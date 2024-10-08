<?php
  include("util.php");
  $conn = conecta();
  $id_usuario = $_GET['id'];
  $id_principal=$_GET['idprincipal'];

  $nome = "";
  $tel = "";
  $senha = "";
  $excluido = true;

  $varSQL = "UPDATE usuario SET nome=:nome, telefone=:telefone, senha=:senha, excluido=:excluido
              WHERE id_usuario = :id_usuario";
  $update = $conn->prepare($varSQL);
  $update->bindParam(':id_usuario', $id_usuario);
  $update->bindParam(':nome', $nome);
  $update->bindParam(':telefone', $tel);
  $update->bindParam(':senha', $senha);
  $update->bindParam(':excluido', $excluido);

  if($update->execute()>0){
      echo"Excluído";
  }
  
  if($id_principal == NULL){
    echo "<br><a href='logout.php'>Voltar para o inicio</a>";
    session_start();
    session_destroy();
    header('Location: index.php');
  }
  else{
    echo "<br><a href='usuarios.php?id=".$id_principal."'>Voltar </a>"; 
    session_start();
    session_destroy();
    header('Location: index.php');
  }
?>