<?php
    include('cabecalho.php');
    include('util.php');
    $id_produto = $_GET['id'];

    $conn=conecta();
    if(!$conn)
    {
        echo "Não conectado";
        exit;
    }
    echo"
    <style>
        p{
            font-size: large;
            text-align:center;
        }
        div{
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: 1fr;
        }    
    </style>
    ";
    $varSQL = "SELECT *
            FROM produto
            WHERE id_produto = :id";
    
    $select = $conn->prepare($varSQL);
    $select ->bindParam(':id',$id_produto);
    $select ->execute();

    echo"<p>Produto:</p><br><br>";
    while($linha = $select->fetch())
    {
        $_SESSION['idProduto'] = $linha['id_produto'];
        echo"<div>
            <p> Nome: ".  $nome =$linha['nome']." <br><br>
                Valor: R$ ". $valor = $linha['valor_unitario'] ." <br><br>
               <a href= 'carrinho.php'>Adicionar ao Carrinho</a> <br><br>
            </p>
            <img src='imagens/p".$id_produto.".jpg' width='250px'>
        </div><br><br>";
        echo"<p>Informações gerais sobre o produto</p>";
        echo "<center><table border=1px style='color:white;'></center>";
        echo "<tr>";
        echo"<td>";
        echo "Nome: ".  $nome =$linha['nome'];
        echo"</td>";
        echo "</tr>";
        echo "<tr>";
        echo"<td>"; 
        echo  "Descrição: ".  $descricao = $linha['descricao'] ;
        echo"</td>";
        echo "</tr>";
        echo "<tr>";
        echo"<td>";
        echo   "Preço: ". $valor = $linha['valor_unitario'] ." reais";
        echo"</td>";
        echo "</tr>";
        echo "<tr>";
        echo"<td>";
        echo   "Quantidade no Estoque: ".$estoque =$linha['qtde_estoque'] ;
        echo"</td>";
        echo "</tr>";
        echo "<tr>";
        echo"<td>";
        echo   "Cor: ". $cor =$linha['cor'] ;
        echo"</td>";
        echo"</tr>";
        echo "</table>";
    }
    include"./rodape.php";
?>
