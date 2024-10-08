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
    }
    include ('rodape.php');
?>
