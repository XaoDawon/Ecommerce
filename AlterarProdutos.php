<?php
    include("util.php");
    include('cabecalho.php');
    $conn=conecta();
    $id_produto=$_GET['id'];
    $id_principal=$_GET['idprinc'];
    $varSQL="SELECT * 
             FROM produto
             WHERE id_produto= :id_produto";
    
    $select = $conn->prepare($varSQL);
    $select->bindParam(':id_produto',$id_produto);
    $select->execute();
    $linha= $select->fetch();

    $nome = $linha['nome'];
    $descricao = $linha['descricao'];
    $valor = $linha['valor_unitario'];
    $excluido = $linha['excluido'];
    $data = $linha['data_exclusao'];
    $estoque = $linha['qtde_estoque'];
    $cor = $linha['cor'];

    echo
    "
        <form action='' method='post'>
        <label for=''>Alterar produto</label><br>

        <label for='nome'>Nome:</label>
        <input type='text' name='nome' value='$nome'><br><br>

        <label for='descricao'>Descrição:</label>
        <input type='text' name='descricao' value='$descricao'><br><br> 

        <label for='cor'>Cor:</label>
        <input type='text' name='cor' value='$cor'><br><br> 

        <label for='valor_unitario'>Preço:</label>
        <input type='number' name='valor_unitario' value='$valor'  step='0.5' min='0.5'><br><br>

        <label for='qtde_estoque'>Estoque:</label>
        <input type='number' name='qtde_estoque' value='$estoque' min='1'><br><br>

        <input type='submit' value='Salvar'>
        </form>";

        if ( $_POST ) {
            $varSQL =
            "UPDATE produto
                SET 
                nome = :nome, descricao = :descricao, 
                valor_unitario = :valor_unitario, qtde_estoque = :qtde_estoque, cor = :cor
            WHERE id_produto = :id_produto";

            $update = $conn->prepare($varSQL);
            $update->bindParam(':nome', $_POST['nome']);
            $update->bindParam(':descricao', $_POST['descricao']);
            $update->bindParam(':valor_unitario', $_POST['valor_unitario']);
            $update->bindParam(':qtde_estoque', $_POST['qtde_estoque']);
            $update->bindParam(':cor',$_POST['cor']);
            $update->bindParam(':id_produto', $id_produto);
            
            if($update->execute()>0){
                echo"Alteração concluída";
            }
            echo "<br><a href='produtos.php?id=".$id_principal."'>Voltar para o inicio</a>";
        }
?>