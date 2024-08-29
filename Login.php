<?php
include('cabecalho.php');
include('util.php');

echo"<center><br><br>";
    echo"
        <form method ='post' action=''>
        <label for=''>Login</label><br><br>

        <label for='email'>Email:</label>
        <input type='text' name='email'><br><br> 

        <label for='senha'>Senha:</label>
        <input type='text' name='senha'><br><br>

        <input type='submit' value='Salvar'>
        </form>";

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
        }
        else{
            $_SESSION['sessaoLogin'] = '';
            echo"<br><p class=C>Não foi possível conectar</p>";
        }
        header("location: index.php");
    }
?>