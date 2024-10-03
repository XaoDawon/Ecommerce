


<?php
include('cabecalho.php');
include('util.php');

    echo"
        <main id='login'>
        <h2 style='color: #d326da;'>Login</h2>
        <div>
        <form method ='post' action=''>

        <input type='text' id='email' name='email' placeholder='Digite seu email'><br><br> 

        <input type='password' id='senha' name='senha' placeholder='Digite sua senha'><br><br>

        <input type='submit' id='submit' value='Salvar'>
        </form>
        </div>
        </main>";
        include('rodape.php');
    if($_POST){
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $admin;

        $_SESSION['sessaoConectado'] = ValidaLogin($email, $senha, $admin);
        $_SESSION['sessaoAdmin'] = $admin;

        if($_SESSION['sessaoConectado']){
            $_SESSION['sessaoLogin'] = $email;
            
            $conn = conecta();

            $varSQL = "SELECT id_usuario
            FROM usuario
            WHERE email = :email";

            $select = $conn->prepare($varSQL);
            $select->bindParam(':email', $email);
            $select->execute();
            while($linha = $select->fetch()){
                $id= $linha['id_usuario'];
            }
            $_SESSION['sessaoUsuario'] = $id; //insere o id do usuário logado em uma variável global
            echo"<br>Conectado com sucesso!";
            echo"<br><a href='perfil.php?id=".$id."'>Meus Dados</a>"; 
            header("location: index.php");
        }
        else{
            $_SESSION['sessaoLogin'] = '';
            echo"
                <script>
                    window.alert('Usuario e ou senha nâo estão corretas, faça a correção e tente novamente');
                </script>
            ";
            
        }
        
        
    }
?>