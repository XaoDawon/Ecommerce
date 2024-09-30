<?php
     include('cabecalho.php');
     include('util.php');
     $id_produto = $_GET['id'];
     $id_compra = $_GET['compra'];
 
     $conn = conecta();
 
     if(!$conn)
     {
         echo "Não conectado";
         exit;
     }
     $qtd;

     $varSQL="SELECT quantidade FROM compra_produto WHERE fk_id_produto=:idprod AND fk_id_compra=:idcompra";
     $select = $conn->prepare($varSQL);
     $select->bindParam(':idprod', $id_produto);
     $select->bindParam(':idcompra', $id_compra);
     $select->execute();

     while($linha=$select->fetch()){
        $qtd = $linha['quantidade'];
     }
    
     $qtd+=1;

     $varSQL="UPDATE compra_produto SET quantidade=:qtde WHERE fk_id_produto=:idprod and fk_id_compra=:idcompra";
     $update = $conn->prepare($varSQL);
     $update->bindParam(':idprod', $id_produto);
     $update->bindParam(':idcompra',  $id_compra);
     $update->bindParam(':qtde',  $qtd);
     $update->execute();

     $_SESSION['idProduto'] = "";
     header('Location: carrinho.php');
?>