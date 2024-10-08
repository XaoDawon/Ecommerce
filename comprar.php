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

    $varSQL = "SELECT *
            FROM produto
            WHERE id_produto = :id";
    
    $select = $conn->prepare($varSQL);
    $select ->bindParam(':id',$id_produto);
    $select ->execute();
    
    while($linha = $select->fetch())
    {
        $_SESSION['idProduto'] = $linha['id_produto'];
<<<<<<< HEAD
        echo"
    <main class='dtlProduto' id='".$cor =$linha['cor']."' style='border: none;'>
            <div class='imgProduto'>
    ";
        echo"
                <img src='./images/copo".$cor =$linha['cor']."normal.jpg' alt=' height='100%'>
            </div>
            <div class='infoProduto' style='border: none;'>
                <h3 style='font-size: 5.2vh;' id='nomeProduto'>
                    ".$nome =$linha['nome']."
                </h3><br>
                <p id='corProduto'>
                    <span>Cor:</span> ".$cor =$linha['cor']."
                </p>
                <h4 style='color: rgb(14,153,2);' class='precoProduto'>
                    R$:".$valor =$linha['valor_unitario']."
                </h4>
                <p id='qntdProduto'>
                    Quantidade em estoque: ".$estoque =$linha['qtde_estoque']."
                </p>
            </div>
            <div class='opcProduto'>
                <input type='button' href='Carrinho.php' style='width: 40%; height: 35%; font-size: 2.7vh;' class='buttonGen' id='btComprar".$cor = $linha['cor']."' value='Adicionar ao Carrinho'>
                <input type='button' style='width: 40%; height: 35%; font-size: 2.7vh;' class='buttonGen' id='btComprar".$cor = $linha['cor']."' onclick='mudarTela(6)' value='Comprar'>
            </div>
            <div class='infoAdcProduto' >
                <p class='descricao'>
                    ".$descricao = $linha['descricao']."
                </p>
            </div>
        </main>";
=======
        echo"<div>
            <p> Nome: ".  $nome =$linha['nome']." <br><br>
                Valor: R$ ". $valor = $linha['valor_unitario'] ." <br><br>
               <a href= 'carrinho.php'>Adicionar ao Carrinho</a> <br><br>
            </p>
            <img src='images/p".$id_produto.".jpg' width='250px'>
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
>>>>>>> f405786b669a410c6fee35b76fa3ddaed884e069
    }
    include ('rodape.php');
?>
