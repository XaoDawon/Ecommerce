<?php
    include('cabecalho.php');
    echo"";
    echo"
    <main id='registro'>
            <h2 style='color: #d326da;'>Registro</h2>
            <div>
        <form method ='post' action=''>

        <input type='text' name='nome' placeholder='Digite seu nome'><br>


        <input type='text' name='email' placeholder='Digite seu email'><br>

        <input type='password' name='senha' placeholder='Digite sua senha'><br>
        <input type='text'  name='telefone' placeholder='Digite seu telefone'><br><br><br>

        <input type='submit' id='submit' value='Salvar'>
        </form>
        </div>
        </main>";
        include('b');

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
                if($_POST['nome'] == null || $_POST['senha'] == null || $_POST['email'] == null || $_POST['telefone'] == null){
                    echo"
                        <script> window.alert('Existem valores nulos')</script>
                    ";
                }
                else{
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
                        header("location: perfil.php");
                    
                    }
                }  
            }
            }
            else{
                echo"<script>alert('Email já cadastrado');</script>";
            }
                
        }
        include("rodape.php");
?>