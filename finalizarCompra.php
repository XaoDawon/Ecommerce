<?php
include('cabecalho.php');
include('util.php');
$teste = true;
$q;
$q2;
$nome;
$compra = $_GET['id'];
    if($_POST){

    $acres = $_POST['acres'];
    $transacao = null;
    
    

    $conn = conecta();

    if(!$conn)
    {
        echo "Não conectado";
        exit;
    }
    
    $varSQL = "SELECT *
                FROM compra_produto
                WHERE fk_id_compra = :id";
    $select = $conn->prepare($varSQL);
    $select ->bindParam(':id', $compra);
    $select ->execute();

    while ($linha = $select->fetch()) {
        $p = $linha['fk_id_produto'];
        $q = $linha['quantidade'];

        $varSQL1 = "SELECT qtde_estoque, nome
                    FROM produto WHERE id_produto = :prod";
        $select1 = $conn->prepare($varSQL1);
        $select1 ->bindParam(':prod', $p);
        $select1 ->execute();

        while ($l = $select1->fetch()) { 
            $q2 = $l['qtde_estoque']; 
            if($q > $q2){
                $teste = false;
                $nome = $l['nome'];
            }
        }    
    }
    if($teste){

        $tot;
        $total = 0;
        $varSQL = "SELECT quantidade, valor_unitario
        FROM compra_produto
        WHERE fk_id_compra = :id";
        $select = $conn->prepare($varSQL);
        $select ->bindParam(':id', $compra);
        $select ->execute();

        while ($linha = $select->fetch()) {
            //Calcula o total gasto na compra
            $tot = $linha['quantidade'] * $linha['valor_unitario'];
            $total+= $tot;
        }

        $total+= $acres;

        $status = "Concluida";
        // Atualiza a compra como concluída
        $varSQL = "UPDATE compra SET status = :status, acrescimo_total = :acres, id_transacao = :voucher, total = :total WHERE id_compra = :id";
        $update = $conn->prepare($varSQL);
        $update->bindParam(':status', $status);
        $update->bindParam(':acres', $acres);
        $update->bindParam(':voucher', $transacao);
        $update->bindParam(':total', $total);
        $update->bindParam(':id', $compra);
        $update->execute();
        
        //Atualiza o estoque dos produtos

        $varSQL = "SELECT fk_id_produto, quantidade
        FROM compra_produto
        WHERE fk_id_compra = :id";
        $select = $conn->prepare($varSQL);
        $select ->bindParam(':id', $compra);
        $select ->execute();

        while ($linha = $select->fetch()) {
            $q = $linha['quantidade'];
            $varSQL1 = "SELECT qtde_estoque FROM produto WHERE id_produto=:id";
            $select1 = $conn->prepare($varSQL1);
            $select1 ->bindParam(':id', $linha['fk_id_produto']);
            $select1 ->execute();
            while ($l = $select1->fetch()) {
                
                    $q2 = $l['qtde_estoque'];
                    $q2-= $q;
                    $varSQL2 = "UPDATE produto SET qtde_estoque = :valor WHERE id_produto = :id";
                    $update = $conn->prepare($varSQL2);
                    $update ->bindParam(':valor', $q2);
                    $update ->bindParam(':id', $linha['fk_id_produto']);
                    $update ->execute();

                
            }        
        }
        echo"<script>
            window.alert('Compra realizada com sucesso!');
            window.open('index.php', '_self')
        </script>";
        
        $_SESSION['idCompra'] = "";     
    }
    else if (!$teste){
        echo"<script>
            window.alert('Não temos o produto ".$nome." disponível nessas quantidades no nosso estoque')
            window.open('carrinho.php', '_self')
        </script>";
        
        $_SESSION['idCompra'] = "";  
        
    }
}
include('rodape.php');

        
?>
