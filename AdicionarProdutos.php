<?php
    include('cabecalho.php');
    $id_principal = $_GET['id'];
    echo"
        <form method ='post' action=''>
        <label for=''>Adicionar produtos</label><br><br>

        <label for='nome'>Nome:</label>
        <input type='text' name='nome'><br><br>

        <label for='cor'>Cor:</label>
        <input type='text' name='cor'><br><br> 

        <label for='descricao'>Descrição:</label>
        <input type='text' name='descricao'><br><br> 

        <label for='valor_unitario'>Preço Unitário:</label>
        <input type='number' step='0.5' min='0.5' name='valor_unitario'><br><br>

        <label for='qtde_estoque'>Estoque:</label>
        <input type='number' name='qtde_estoque' min='1'><br><br>


        <input type='submit' value='Salvar'>
        </form>";

        if($_POST){
            include("util.php");
            $conn = conecta();

            $val=$_POST['valor_unitario'];
            $qtd=$_POST['qtde_estoque'];

            $varSQL = "INSERT INTO produto (nome, descricao, valor_unitario, qtde_estoque, cor)
                     VALUES (:nome, :descricao, :valor_unitario, :qtde_estoque, :cor)";

            $insert = $conn->prepare($varSQL);
            $insert->bindParam(':nome', $_POST['nome']);
            $insert->bindParam(':descricao', $_POST['descricao']);
            $insert->bindParam(':valor_unitario', $val);
            $insert->bindParam(':qtde_estoque', $qtd);
            $insert->bindParam(':cor', $_POST['cor']);

            if($insert->execute()>0){
                echo"<br>Dados salvos";
            }
            echo"<br><a href='produtos.php?id=".$id_principal."'>Voltar para o inicio</a>";


        }
?>