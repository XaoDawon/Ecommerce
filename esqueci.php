<?php
    include('cabecalho.php');
    include('util.php');

    $conn=conecta();
    if(!$conn)
    {
        echo "Não conectado";
        exit;
    }

    echo "<form action='' method='post'>
          Enviar recuperacao da senha para<br>
          <input type='email' name='email'>
          <input type='submit' value='Enviar'>
        </form>";

  if ( $_POST ) {   
      /*
        O usuario devera saber qual é o seu email 
        para poder receber um link de recuperacao.
        O link de recuperacao é uma chamada GET para um codigo php
        que vai receber um token, o token recebido na vdd eh a senha antiga 
        criptografada que foi obtida do email valido informado. 
        Essa senha sera trocada em redefinir.php.
        Ao receber o token e verificar se bate com a senha atual, 
        estamos assegurando que nao houve uma tentativa de quebra de seguranca. 
        Ai o programa pede nova senha e altera      
      */
      $email = $_POST['email'];
      $select = $conn->prepare("select nome,senha from usuario where email=:email ");
      $select->bindParam(':email',$email);
      $select->execute();
      $linha = $select->fetch();
      
      if ( $linha ) {

        // md5 é um tipo de criptografia
        $token=md5($linha['senha']); 
        $nome = $linha['nome'];
        $html="<h4>Redefinir sua senha</h4><br>
               <b>$nome</b>, <br>
               Clique no link para redefinir sua senha:<br>http://127.0.0.1/rafa/redefinir.php?token=$token";

               //https://projetoscti.com.br/projetoscti02/ecomm/redefinir.php?token=$token aqui tem q colocar o endereço do ecommerce dps, passando o token por get

        
        $_SESSION[$token]= $email;

        if ( EnviaEmail ( $email, '* Recupere a sua senha do ecommerce *', $html ) ) {
              echo "<b>Email enviado com sucesso</b> (verifique sua caixa de spam se nao encontrar)";
        }   
      } 
  }
?>