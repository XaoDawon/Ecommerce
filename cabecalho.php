<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./css/main.css">   
        <link rel="stylesheet" href="./css/celular.css">   
        <link rel="stylesheet" href="./css/tablet.css">   
        <link rel="stylesheet" href="./css/monitor.css">   
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Satisfy&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Festum</title>
        
    </head>
    <body>
        <header>

            <img  src="./images/Logo_oficial.svg" onclick="mudarTela(0)" alt="icon festum"  width="5%" >

        </header>
        <nav>
            <button onclick="mudarTela(1)" id="aboutLink">Sobre</button>
        <?php   

            session_start();
            error_reporting(0);
            if(isset($_SESSION['sessaoConectado'])){
                $sessaoConectado = $_SESSION['sessaoConectado'];
                $login = $_SESSION['sessaoLogin'];
                $usuario = $_SESSION['sessaoUsuario']; //variável que contém o id de um usuário que acaba de logar
            }
            else{
                $sessaoConectado = false;
            }
            if($sessaoConectado){
                $idSessao = session_id();
                echo"<button onclick='mudarTela(4)'>Perfil</button>
                    <button onclick='mudarTela(6)'' id='aboutLink'>Carrinho</button>
                    <button onclick='mudarTela(5)'>Logout</button>
                ";
            }
            else{
                echo'
                    <button onclick="mudarTela(2,0)">Login</button>
                    <button onclick="mudarTela(3,0)">Cadastro</button>
                    ';

            }
            function ValidaLogin ($paramLogin, $paramSenha, &$paramAdmin)  
            {
            $conn = conecta();  
            $varSQL = " SELECT senha,admin FROM usuario 
                        WHERE email = :paramLogin "; 
            $select = $conn->prepare($varSQL);
            $select->bindParam(':paramLogin',$paramLogin);
            $select->execute();
            $linha = $select->fetch();

            if ( $linha ) {
                    $paramAdmin = $linha['admin'] ;
                    return $linha['senha'] == $paramSenha;  
            } else {
                    $paramAdmin = false;
                    return false;  
            } 
            }
        ?>
        </nav>
        <section>
        <img src="./images/sec.jpg" style="width: 80%;" alt="Imagem do Produto">
        </section>

