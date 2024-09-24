<?php
    //Código que permite tornar um usuário administrador
    echo
     "
         <form action='' method='post'>
         <label for=''>Definir administrador</label><br><br>

        <label for='admin'>Admin:</label>
        <input type='number' name='admin'><br><br>

        <input type='submit' value='Salvar'>
        </form>";

    if ( $_POST ) {
        include("util.php");
        $conn = conecta();
        $id_usuario = $_GET['id'];
        $id_principal=$_GET['idprincipal'];

        $admin = $_POST['admin'];

        $varSQL = "UPDATE usuario 
                        SET admin = :admin
                    WHERE id_usuario = :id_usuario";
        $update = $conn->prepare($varSQL);
        $update->bindParam(':id_usuario', $id_usuario);
        $update->bindParam(':admin', $admin);

        if($update->execute()>0){
            echo"Atualizado";
        }
        
        echo "<br><a href='usuarios.php?id=".$id_principal."'>Voltar para o inicio</a>";
    }
?>