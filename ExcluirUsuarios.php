<?php
  include("util.php");
  $conn = conecta();
  $id_usuario = $_GET['id'];
  $id_principal=$_GET['idprincipal'];

  $varSQL = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
  $delete = $conn->prepare($varSQL);
  $delete->bindParam(':id_usuario', $id_usuario);

  if($delete->execute()>0){
      echo"Excluído";
  }
  if($id_principal == NULL){
    echo "<br><a href='logout.php'>Voltar para o inicio</a>";
  }
  else{
    echo "<br><a href='usuarios.php?id=".$id_principal."'>Voltar </a>"; 
  }
?>