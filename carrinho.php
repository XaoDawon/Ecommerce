<?php
     include('cabecalho.php');
     include('util.php');
     $id_produto = $_SESSION['idProduto'];
 
     $conn = conecta();
     $id;
     $total;
     $compp;
 
     if(!$conn)
     {
         echo "Não conectado";
         exit;
     }

        // se não houver uma compra já "logada" - primeira vez que entra no carrinho depois de logar
        if($_SESSION['idCompra']==""){

            //se houver um produto sendo recebido
            if($id_produto != ""){
                //Registros nas tabelas
                $qtd = 1;
                $status = "Pendente";
                $id="";
                    $varSQL = "SELECT id_compra FROM compra WHERE fk_id_usuario = :id and status ='Pendente' ";
                    $select = $conn->prepare($varSQL);
                    $select->bindParam(':id', $_SESSION['sessaoUsuario']);
                    $select->execute();
                    while($linha = $select->fetch()){
                        $id = $linha['id_compra'];
                    }
                    //se não houver uma compra pendente no nome do usuário
                    if($id == ""){
                            //Quando os vouchers estiverem prontos, voltar aq para inserir o id_transação
                            // cria um registro de compra no nome do usuário
                            $varSQL = "INSERT INTO compra (status, sessao, fk_id_usuario)
                                    VALUES (:status, :sessao, :fk)";
                                    
                            $insert = $conn->prepare($varSQL);
                            $insert->bindParam(':status', $status);
                            $insert->bindParam(':sessao', $_SESSION['sessaoLogin']);
                            $insert->bindParam(':fk', $_SESSION['sessaoUsuario']);
                            $insert->execute();

                            $varSQL = "SELECT id_compra FROM compra WHERE fk_id_usuario = :id
                                        ";
                            $select = $conn->prepare($varSQL);
                            $select->bindParam(':id', $_SESSION['sessaoUsuario']);
                            $select->execute();
                            while($linha = $select->fetch()){
                                $id = $linha['id_compra'];
                                // pega o id da compra que acabou de ser criada
                            }

                            $varSQL = "SELECT  valor_unitario
                                            FROM produto
                                            WHERE id_produto = :id";
                                $select = $conn->prepare($varSQL);
                                $select ->bindParam(':id', $id_produto);
                                $select ->execute();

                                while ($linha = $select->fetch()) {
                                    $val = $linha['valor_unitario'];
                                    //pega o valor unitário do produto inserido
                                }

                            // com os dados da compra que acabou de ser criada, e os dados do produto, insere na compra_produto relacionando os dois
                            $varSQL = "INSERT INTO compra_produto (fk_id_produto, fk_id_compra, valor_unitario, quantidade)
                                        VALUES  (:idProd, :idCompra, :val, :qtd)";

                            $insert = $conn->prepare($varSQL);
                            $insert->bindParam(':idProd', $id_produto);
                            $insert->bindParam(':idCompra', $id);
                            $insert->bindParam(':val', $val);
                            $insert->bindParam(':qtd', $qtd);
                            $insert->execute();
                    
                            //Apresentação do grid

                            $varSQL = "SELECT compra_produto.fk_id_compra, produto.id_produto, produto.nome, produto.valor_unitario, compra_produto.quantidade 
                            FROM compra_produto INNER JOIN produto on produto.id_produto = compra_produto.fk_id_produto  
                            INNER JOIN compra on compra_produto.fk_id_compra = compra.id_compra WHERE compra.fk_id_usuario = :user and compra.status = :p";

                            $total=0;
                            $select = $conn->prepare($varSQL);
                            $select->bindParam(':user',  $_SESSION['sessaoUsuario']);
                            $select->bindParam(':p', $status);
                            $select->execute();
                            echo"<table border='2px'>";
                            echo"<th>Produto</th><th>Nome</th><th>Quantidade</th><th>Preço unitário</th><th>Somatória</th><th></th><th></th>";
                            while($linha = $select->fetch()){
                                //salva o id da compra agora existente na variável session
                                $_SESSION['idCompra'] = $linha['fk_id_compra'];
                                $sub = $linha['valor_unitario']*$linha['quantidade'];
                                $total+=$sub;
                                echo"<tr>";
                                echo"<td>";
                                echo "<img src='imagens/p".$linha['id_produto'].".jpg' width='150px'>";
                                echo"</td>";
                                echo"<td>";
                                echo $linha['nome'];
                                echo"</td>";
                                echo"<td>";
                                echo $linha['quantidade'];
                                echo"</td>";
                                echo"<td>";
                                echo $linha['valor_unitario'];
                                echo"</td>";
                                echo"<td>";
                                echo $sub;
                                echo"</td>";
                                echo"<td>";
                                echo "<a href='incluir.php?id=".$linha['id_produto']."&compra=".$id."'>Incluir</a>";
                                echo"</td>";
                                echo"<td>";
                                echo "<a href='excluir.php?id=".$linha['id_produto']."&compra=".$id."'>Excluir</a>";
                                echo"</td>";
                                echo"</tr>";
                            }
                            echo"</table>";
                            echo"<p>Status da compra: ".$status."</p>";
                            echo"<p>Total:".$total."</p>";
                           
                    }
                    //se houver uma compra pendente no nome do usuário
                    else{
                        //atribui essa compra pré-existente à variável session
                        $_SESSION['idCompra'] = $id;

                        $verifica = false;
                        if($id_produto != ""){
                         $varSQL = "SELECT  valor_unitario
                                    FROM produto
                                    WHERE id_produto = :id";
                        $select = $conn->prepare($varSQL);
                        $select ->bindParam(':id', $id_produto);
                        $select ->execute();

                        while ($linha = $select->fetch()) {
                            $val = $linha['valor_unitario'];
                        }
                        //pega o id do produto existente na compra_produto relacionado a compra já pré-existente
                        $varSQL = "SELECT fk_id_produto FROM compra_produto WHERE fk_id_compra = :id";
                        $select = $conn->prepare($varSQL);
                        $select ->bindParam(':id', $id);
                        $select ->execute();

                        while($linha = $select->fetch()){
                            if($linha['fk_id_produto'] == $id_produto){
                                $verifica = true;
                            }
                        }
                        //se o produto recebido for o mesmo que já existe na compra
                        if($verifica){
                            //aumenta a quantidade dele em 1
                            $qtd;

                            $varSQL="SELECT quantidade FROM compra_produto WHERE fk_id_produto=:idprod AND fk_id_compra=:idcompra";
                            $select = $conn->prepare($varSQL);
                            $select->bindParam(':idprod', $id_produto);
                            $select->bindParam(':idcompra', $id);
                            $select->execute();

                            while($linha=$select->fetch()){
                                $qtd = $linha['quantidade'];
                            }
                            
                            $qtd+=1;

                            $varSQL="UPDATE compra_produto SET quantidade=:qtde WHERE fk_id_produto=:idprod and fk_id_compra=:idcompra";
                            $update = $conn->prepare($varSQL);
                            $update->bindParam(':idprod', $id_produto);
                            $update->bindParam(':idcompra',  $id);
                            $update->bindParam(':qtde',  $qtd);
                            $update->execute();

                        }
                        else{
                            //caso contrário registra ele na tabela
                            
                            $varSQL = "SELECT  valor_unitario
                            FROM produto
                            WHERE id_produto = :id";
                            $select = $conn->prepare($varSQL);
                            $select ->bindParam(':id', $id_produto);
                            $select ->execute();

                            while ($linha = $select->fetch()) {
                                $val = $linha['valor_unitario'];
                            }


                            $varSQL = "INSERT INTO compra_produto (fk_id_produto, fk_id_compra, valor_unitario, quantidade)
                                        VALUES  (:idProd, :idCompra, :val, :qtd)";

                            $insert = $conn->prepare($varSQL);
                            $insert->bindParam(':idProd', $id_produto);
                            $insert->bindParam(':idCompra', $_SESSION['idCompra']);
                            $insert->bindParam(':val', $val);
                            $insert->bindParam(':qtd', $qtd);
                            $insert->execute();

                        }            
                    
                    }

                        //Apresentação do grid

                        $varSQL = "SELECT produto.id_produto, produto.nome, produto.valor_unitario, compra_produto.quantidade 
                        FROM compra_produto INNER JOIN produto on produto.id_produto = compra_produto.fk_id_produto  
                        INNER JOIN compra on compra_produto.fk_id_compra = compra.id_compra WHERE compra.fk_id_usuario = :user and compra.status = :p";
                        $total = 0;
                        
                        $select = $conn->prepare($varSQL);
                        $select->bindParam(':user',  $_SESSION['sessaoUsuario']);
                        $select->bindParam(':p', $status);
                        $select->execute();
                        echo"<table border='2px'>";
                        echo"<th>Produto</th><th>Nome</th><th>Quantidade</th><th>Preço unitário</th><th>Somatória</th><th></th><th></th>";
                        while($linha = $select->fetch()){
                            $sub = $linha['valor_unitario']*$linha['quantidade'];
                            $total+=$sub;
                            echo"<tr>";
                            echo"<td>";
                            echo "<img src='imagens/p".$linha['id_produto'].".jpg' width='150px'>";
                            echo"</td>";
                            echo"<td>";
                            echo $linha['nome'];
                            echo"</td>";
                            echo"<td>";
                            echo $linha['quantidade'];
                            echo"</td>";
                            echo"<td>";
                            echo $linha['valor_unitario'];
                            echo"</td>";
                            echo"<td>";
                            echo $sub;
                            echo"</td>";
                            echo"<td>";
                            echo "<a href='incluir.php?id=".$linha['id_produto']."&compra=".$id."'>Incluir</a>";
                            echo"</td>";
                            echo"<td>";
                            echo "<a href='excluir.php?id=".$linha['id_produto']."&compra=".$id."'>Excluir</a>";
                            echo"</td>";
                            echo"</tr>";
                        }
                        echo"</table>";
                        echo"<p>Status da compra: ".$status."</p>";
                        echo"<p>Total:".$total."</p>";
                    }
                } //se não houver um produto sendo recebido só apresenta o grid (se tiver algo para apresentar)
                else{

                    $status = "Pendente";
                    $varSQL = "SELECT compra_produto.fk_id_compra, produto.id_produto, produto.nome, produto.valor_unitario, compra_produto.quantidade 
                    FROM compra_produto INNER JOIN produto on produto.id_produto = compra_produto.fk_id_produto  
                    INNER JOIN compra on compra_produto.fk_id_compra = compra.id_compra WHERE compra.fk_id_usuario = :user and compra.status = :p";
                    $total=0;
                    $select = $conn->prepare($varSQL);
                    $select->bindParam(':user',  $_SESSION['sessaoUsuario']);
                    $select->bindParam(':p', $status);
                    $select->execute();

                    $status = "";
                    echo"<table border='2px'>";
                    echo"<th>Produto</th><th>Nome</th><th>Quantidade</th><th>Preço unitário</th><th>Somatória</th><th></th><th></th>";
                    while($linha = $select->fetch()){
                        $_SESSION['idCompra'] = $linha['fk_id_compra'];
                        $id = $linha['fk_id_compra'];
                        $sub = $linha['valor_unitario']*$linha['quantidade'];
                        $total+=$sub;
                        echo"<tr>";
                        echo"<td>";
                        echo "<img src='imagens/p".$linha['id_produto'].".jpg' width='150px'>";
                        echo"</td>";
                        echo"<td>";
                        echo $linha['nome'];
                        echo"</td>";
                        echo"<td>";
                        echo $linha['quantidade'];
                        echo"</td>";
                        echo"<td>";
                        echo $linha['valor_unitario'];
                        echo"</td>";
                        echo"<td>";
                        echo $sub;
                        echo"</td>";
                        echo"<td>";
                        echo "<a href='incluir.php?id=".$linha['id_produto']."&compra=".$id."'>Incluir</a>";
                        echo"</td>";
                        echo"<td>";
                        echo "<a href='excluir.php?id=".$linha['id_produto']."&compra=".$id."'>Excluir</a>";
                        echo"</td>";
                        echo"</tr>";
                        $status = "Pendente";
                    }
                    echo"</table>";
                    echo"<p>Status da compra: ".$status."</p>";
                    echo"<p>Total:".$total."</p>";
                    echo"<a href='finalizarCompra.php?id=".$_SESSION['idCompra']."'>Finalizar a compra</a>";
                    
                }
                $compp = $id;
            } //se já houver uma compra "logada" - não é a primeira vez que entra no carrinho depois de logar
        else{
            //pega o id dessa compra em andamento
            $idcomp = $_SESSION['idCompra'];
            $verifica = false;
            //se houver um produto sendo recebido
            if($id_produto != ""){
                $varSQL = "SELECT  valor_unitario
                                    FROM produto
                                    WHERE id_produto = :id";
                        $select = $conn->prepare($varSQL);
                        $select ->bindParam(':id', $id_produto);
                        $select ->execute();

                        while ($linha = $select->fetch()) {
                            $val = $linha['valor_unitario'];
                        }

                    $varSQL = "SELECT fk_id_produto FROM compra_produto WHERE fk_id_compra = :id";
                    $select = $conn->prepare($varSQL);
                    $select ->bindParam(':id', $idcomp);
                    $select ->execute();

                    while($linha = $select->fetch()){
                        if($linha['fk_id_produto'] == $id_produto){
                            $verifica = true;
                            //vê se o produto que tá sendo recebido já existe nessa compra em andamento
                        }
                    }
                    if($verifica){ //se existir adiciona 1

                        $qtd;

                        $varSQL="SELECT quantidade FROM compra_produto WHERE fk_id_produto=:idprod AND fk_id_compra=:idcompra";
                        $select = $conn->prepare($varSQL);
                        $select->bindParam(':idprod', $id_produto);
                        $select->bindParam(':idcompra', $idcomp);
                        $select->execute();

                        while($linha=$select->fetch()){
                            $qtd = $linha['quantidade'];
                        }
                        
                        $qtd+=1;

                        $varSQL="UPDATE compra_produto SET quantidade=:qtde WHERE fk_id_produto=:idprod and fk_id_compra=:idcompra";
                        $update = $conn->prepare($varSQL);
                        $update->bindParam(':idprod', $id_produto);
                        $update->bindParam(':idcompra',  $idcomp);
                        $update->bindParam(':qtde',  $qtd);
                        $update->execute();

                    }
                    else{ //se não existir registra ele

                        $varSQL = "INSERT INTO compra_produto (fk_id_produto, fk_id_compra, valor_unitario, quantidade)
                                VALUES  (:idProd, :idCompra, :val, :qtd)";

                        $insert = $conn->prepare($varSQL);
                        $insert->bindParam(':idProd', $id_produto);
                        $insert->bindParam(':idCompra', $_SESSION['idCompra']);
                        $insert->bindParam(':val', $val);
                        $insert->bindParam(':qtd', $qtd);
                        $insert->execute();

                    }
            
                    //Apresentação do grid

                    $varSQL = "SELECT produto.id_produto, produto.nome, produto.valor_unitario, compra_produto.quantidade 
                    FROM compra_produto INNER JOIN produto on produto.id_produto = compra_produto.fk_id_produto  
                    INNER JOIN compra on compra_produto.fk_id_compra = compra.id_compra WHERE compra.fk_id_usuario = :user and compra.status = :p";
                    $total=0;
                    $select = $conn->prepare($varSQL);
                    $select->bindParam(':user',  $_SESSION['sessaoUsuario']);
                    $select->bindParam(':p', $status);
                    $select->execute();
                    echo"<table border='2px'>";
                    echo"<th>Produto</th><th>Nome</th><th>Quantidade</th><th>Preço unitário</th><th>Somatória</th><th></th><th></th>";
                    while($linha = $select->fetch()){
                        $sub = $linha['valor_unitario']*$linha['quantidade'];
                        $total+=$sub;
                        echo"<tr>";
                        echo"<td>";
                        echo "<img src='imagens/p".$linha['id_produto'].".jpg' width='150px'>";
                        echo"</td>";
                        echo"<td>";
                        echo $linha['nome'];
                        echo"</td>";
                        echo"<td>";
                        echo $linha['quantidade'];
                        echo"</td>";
                        echo"<td>";
                        echo $linha['valor_unitario'];
                        echo"</td>";
                        echo"<td>";
                        echo $sub;
                        echo"</td>";
                        echo"<td>";
                        echo "<a href='incluir.php?id=".$linha['id_produto']."&compra=".$id."'>Incluir</a>";
                        echo"</td>";
                        echo"<td>";
                        echo "<a href='excluir.php?id=".$linha['id_produto']."&compra=".$id."'>Excluir</a>";
                        echo"</td>";
                        echo"</tr>";
                    }
                    echo"</table>";
                    echo"<p>Status da compra: ".$status."</p>";
                    echo"<p>Total:".$total."</p>";
                    echo"<a href='finalizarCompra.php?id=".$_SESSION['idCompra']."'>Finalizar a compra</a>";
            } // se não houver um produto sendo recebido apenas apresenta oq já tem na compra
            else{

                $status = "Pendente";
                $varSQL = "SELECT produto.id_produto, produto.nome, produto.valor_unitario, compra_produto.quantidade 
                FROM compra_produto INNER JOIN produto on produto.id_produto = compra_produto.fk_id_produto  
                INNER JOIN compra on compra_produto.fk_id_compra = compra.id_compra WHERE compra.fk_id_usuario = :user and compra.status = :p";
                $total=0;
                $select = $conn->prepare($varSQL);
                $select->bindParam(':user',  $_SESSION['sessaoUsuario']);
                $select->bindParam(':p', $status);
                $select->execute();

                $status = "";
                echo"<table border='2px'>";
                echo"<th>Produto</th><th>Nome</th><th>Quantidade</th><th>Preço unitário</th><th>Somatória</th><th></th><th></th>";
                while($linha = $select->fetch()){
                    $sub = $linha['valor_unitario']*$linha['quantidade'];
                    $total+=$sub;
                    echo"<tr>";
                    echo"<td>";
                    echo "<img src='imagens/p".$linha['id_produto'].".jpg' width='150px'>";
                    echo"</td>";
                    echo"<td>";
                    echo $linha['nome'];
                    echo"</td>";
                    echo"<td>";
                    echo $linha['quantidade'];
                    echo"</td>";
                    echo"<td>";
                    echo $linha['valor_unitario'];
                    echo"</td>";
                    echo"<td>";
                    echo $sub;
                    echo"</td>";
                    echo"<td>";
                    echo "<a href='incluir.php?id=".$linha['id_produto']."&compra=".$id."'>Incluir</a>";
                    echo"</td>";
                    echo"<td>";
                    echo "<a href='excluir.php?id=".$linha['id_produto']."&compra=".$id."'>Excluir</a>";
                    echo"</td>";
                    echo"</tr>";
                    $status = "Pendente";
                }
                echo"</table>";
                echo"<p>Status da compra: ".$status."</p>";
                echo"<p>Total:".$total."</p>";
                echo"<a href='finalizarCompra.php?id=".$_SESSION['idCompra']."'>Finalizar a compra</a>";
            }
            $compp = $idcomp;
        }
        $_SESSION['idProduto'] = "";
        // depois de fazer oq precisa com o produto recebido (se é que foi recebido), "zera" a session e começa dnv
?>