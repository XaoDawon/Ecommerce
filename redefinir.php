<?php
  
    include('cabecalho.php');
    include('util.php');

    $conn=conecta();
    if(!$conn)
    {
        echo "Não conectado";
        exit;
    }

    echo "<h3>Redefinir a senha</h3>
        <form action='' method='post'>  
             Senha<br>
             <input type='password' name='senha1'><br>

             Redigite a senha<br>
             <input type='password' name='senha2'><br>  
               
             <input type='submit' value='Alterar'>
        </form>";

    if ( $_POST ) {  


       $senha1 = $_POST['senha1'];
       $senha2 = $_POST['senha2'];
       
       // recupera o email salvo como var sessao em esqueci.php
       
       $token = $_GET['token'];
       
       $email = $_SESSION[$token];

       // obtem a senha

       $senha = ValorSQL($conn, "select senha from usuario where email='$email'");     
       
       // confere se o token é VERDADEIRO
       if ( md5 ($senha) <> $token ) {
            echo "<br>Token invalido !!";
            exit;
       }
    
       // se o preenchimento da nova senha esta correto
       // atualiza a senha do usuario !!!

       if ( $senha1 == $senha2 ) {
            ExecutaSQL($conn, "update usuario set senha='$senha1' where email='$email'");
            echo "<br>Senha alterada com sucesso !!";
       } else {
            echo "<br>Senhas estão diferentes";
       }
       echo "<br><br><a href='index.php'>Voltar</a>";
    }
?>  