<?php
    // util.php //// funcao de conexao 14-8-2023


    include __DIR__.'/PHPMailer/PHPMailer/src/PHPMailer.php';
    include __DIR__.'/PHPMailer/PHPMailer/src/SMTP.php';


    function conecta ($params = "")
    {
        if ($params == "") {
            $params="pgsql:host=pgsql.projetoscti.com.br;
            dbname=projetoscti10; user=projetoscti10; password=eq42B156";
        }
        $varConn = new PDO($params);
        if (!$varConn) {
            echo "Nao foi possivel conectar";
            exit;
        } else { return $varConn; }
    }

    function EnviaEmail ( $pEmailDestino, $pAssunto, $pHtml, 
        $pUsuario = "marcelocabello@projetoscti.com.br", 
        $pSenha = "MarceloC@belo", 
        $pSMTP = "smtp.projetoscti.com.br" )  {    
            try {

                //cria instancia de phpmailer
                echo "<br>Tentando enviar para $pEmailDestino...";
                $mail = new PHPMailer(); 
                $mail->IsSMTP();  // diz ao php que � o servidor eh SMTP

                // servidor smtp
                $mail->Host = $pSMTP;  // configura o servidor
                $mail->SMTPAuth = true;      // requer autenticacao com o servidor                         

                $mail->SMTPSecure = 'tls';  // nivel de seguranca                           
                $mail-> SMTPOptions = array ( 'ssl' => array ( 'verificar_peer' => false, 'verify_peer_name' => false,
                'allow_self_signed' => true ) );

                $mail->Port = 587;  // porta do servi�o no servidor     

                $mail->Username = $pUsuario; 
                $mail->Password = $pSenha; 
                $mail->From = $pUsuario; 
                $mail->FromName = "Suporte de senhas"; 

                $mail->AddAddress($pEmailDestino, "Usuario"); 
                $mail->IsHTML(true); // o conteudo enviado eh html (poderia ser txt comum sem formato)
                $mail->Subject = $pAssunto; 
                $mail->Body = $pHtml;
                $enviado = $mail->Send(); // disparo

                if (!$enviado) {
                    echo "<br>Erro: " . $mail->ErrorInfo;
                } 
                else {
                    echo "<br><b>Enviado!</b>";
                }
                return $enviado;         

            } 
            catch (phpmailerException $e) {
                 echo $e->errorMessage(); // erros do phpmailer
            } 
            catch (Exception $e) {
                echo $e->getMessage(); // erros da aplica��o - gerais
            }      
        }

        function ValorSQL( $pConn, $pSQL ) 
        {
            $linha = $pConn->query($pSQL)->fetch();
            if ( $linha ) { 
                return $linha[0]; // equivale a retornar o valor do campo
            } else { 
                return "0"; 
            }
        }

        function ExecutaSQL( $paramConn, $paramSQL ) 
        {
            // exec eh usado para update, delete, insert
            // eh um metodo da conexao
            // retorna TRUE se houve linhas afetadas
            $linhas = $paramConn->exec($paramSQL);
            return ($linhas > 0);
        }
?>

