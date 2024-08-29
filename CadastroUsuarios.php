<?php
    include('cabecalho.php');
    echo"<center><br><br>";
    echo"
        <form method ='post' action=''>
        <label for=''>Cadastro de Usuários</label><br><br>

        <label for='nome'>Nome:</label>
        <input type='text' name='nome'><br><br>

        <label for='email'>Email:</label>
        <input type='text' name='email'><br><br> 

        <label for='senha'>Senha:</label>
        <input type='text' name='senha'><br><br>

        <label for='telefone'>Telefone:</label>
        <input type='text' name='telefone'><br><br>


        <input type='submit' value='Salvar'>
        </form>";

        if($_POST){
            include("util.php");
            
            $conn = conecta();
            $varSQL = "SELECT nome
                        FROM usuario
                        WHERE email = :email";

            $select = $conn->prepare($varSQL);
            $select->bindParam(':email', $_POST['email']);
            $select->execute();
            $linha;
            $flag = false;
            //Verificação para garantir que 1 email vai existir em apenas 1 cadastro
            while($linha = $select->fetch()) // se ele achar o email na tabela, ele entra aqui, caso contrário ele nem roda essa parte, é como se nem tivesse no que dar fetch
            {
                $flag=true;
            }

            if(!$flag){ //aqui ele confere p ver se não tem mesmo o email e segue o código
                $varSQL = "INSERT INTO usuario (nome, senha, email, telefone)
                VALUES (:nome, :senha, :email, :telefone)";

                $insert = $conn->prepare($varSQL);
                $insert->bindParam(':nome', $_POST['nome']);
                $insert->bindParam(':senha', $_POST['senha']);
                $insert->bindParam(':email', $_POST['email']);
                $insert->bindParam(':telefone', $_POST['telefone']);
                
                if($insert->execute()>0){
                    echo"<br>Dados salvos";

                    $email = $_POST['email'];
                    $senha = $_POST['senha'];
                    $admin;

                    $_SESSION['sessaoConectado'] = ValidaLogin($email, $senha, $admin);
                    $_SESSION['sessaoAdmin'] = $admin;

                    if($_SESSION['sessaoConectado']){
                        $_SESSION['sessaoLogin'] = $email;

                        $varSQL = "SELECT id_usuario
                                FROM usuario
                                WHERE email = :email";

                        $select = $conn->prepare($varSQL);
                        $select->bindParam(':email', $_POST['email']);
                        $select->execute();
                        while($linha = $select->fetch()){
                            $id= $linha['id_usuario'];
                        }
                        $_SESSION['sessaoUsuario'] = $id; //insere o id do usuário cadastrado em uma variável global
                        echo"<br><a href='perfil.php?id=".$id."'>Meus Dados</a>"; 
                    
                    }
                }  
            }
            else{
                echo"<script>alert('Email já cadastrado');</script>";
            }
        }
        function defineId(){
            return $id;
        }
?>