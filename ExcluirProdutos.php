<?php
  include("util.php");
  include('cabecalho.php');
  $conn = conecta();
  $id_produto = $_GET['id'];
  $id_principal = $_GET['idprinc'];
  $excluido = 1;
  $data = date('Y/m/d');

  $varSQL = "UPDATE produto
                SET 
                excluido = :excluido, data_exclusao = :data_exclusao  
            WHERE id_produto = :id_produto";
  $delete = $conn->prepare($varSQL);
  $delete->bindParam(':id_produto', $id_produto);
  $delete->bindParam(':excluido', $excluido);
  $delete->bindParam(':data_exclusao', $data);

  if($delete->execute()>0){
      echo"Excluído";
  }
  echo "<br><a href='produtos.php?id=".$id_principal."'>Voltar para o inicio</a>";
?>