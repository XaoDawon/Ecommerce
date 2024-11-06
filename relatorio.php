<?php
    include("cabecalho.php");
    include("util.php");
    include ("vendor/autoload.php");
    use Dompdf\Dompdf; 
    $conn = conecta();
    ob_clean();
    ob_start();
    echo"<!DOCTYPE HTML>
            <html lang='pt-br'>
            <table border='2px'>
            <th>ID da Compra</th><th>Data</th><th>Usuário</th><th>Quantidade</th><th>Total</th>";

    $nome = "";  
    $qtd = 0;       
    $varSQL = "SELECT * from compra";
    $select = $conn->prepare($varSQL);
    $select->execute();

    while($linha = $select->fetch()){
        $varSQL1 = "SELECT nome from usuario where id_usuario=:usuario";
        $select1 = $conn->prepare($varSQL1);
        $select1->bindParam(':usuario', $linha['fk_id_usuario']);
        $select1->execute();
        if($linha1 = $select1->fetch()){
            $nome = $linha1['nome'];
        }
        $varSQL2 = "SELECT quantidade from compra_produto where fk_id_compra=:compra";
        $select2 = $conn->prepare($varSQL2);
        $select2->bindParam(':compra', $linha['id_compra']);
        $select2->execute();
        while($linha2 = $select2->fetch()){
            $med = $linha2['quantidade'];
            $qtd+= $med;
        }
        echo"<tr>";
        echo"<td>";
        echo $linha['id_compra'];
        echo"</td>";
        echo"<td>";
        echo $linha['data'];
        echo"</td>";
        echo"<td>";
        echo $nome;
        echo"</td>";
        echo"<td>";
        echo $qtd;
        echo"</td>";
        echo"<td>";
        echo $linha['total'];
        echo"</td>";
        echo"</tr>";
        $qtd = 0;
    }
    echo"</table></html>";

        $html = ob_get_clean();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();

        echo"Gerado com sucesso!!";

?>