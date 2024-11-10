<?php
        include('cabecalho.php');
        $id_principal = $_GET['id'];
        $string_conexao = 
        "pgsql:host=pgsql.projetoscti.com.br;
            dbname=projetoscti10; user=projetoscti10; password=eq42B156";

        $conn = new PDO($string_conexao);

        if(!$conn)
        {
            echo "Não conectado";
            exit;
        }
        $varSQL = "SELECT *
                FROM produto";
        
        $select = $conn->query($varSQL);

        echo "<main>";
        echo"<br><br><p class=C>Produtos</p><br><br><table border=1>";
        echo"<th>Id</th><th>Nome</th><th>Descrição</th><th>Preço</th><th>Excluído</th><th>Data de exclusão</th><th>Estoque</th><th>Cor</th><th>Alterar</th><th>Excluir</th>";
        while($linha = $select->fetch())
        {
            echo"<tr>";
            echo"<td>";
            echo $linha["id_produto"] ;
            echo"</td>";
            echo"<td>";
            echo $linha["nome"] ;
            echo"</td>";
            echo"<td>";
            echo $linha["descricao"] ;
            echo"</td>";
            echo"<td>";
            echo $linha["valor_unitario"] ;
            echo"</td>";
            echo"<td>";
            echo $linha["excluido"] ;
            echo"</td>";
            echo"<td>";
            echo $linha["data_exclusao"] ;
            echo"</td>";
            echo"<td>";
            echo $linha["qtde_estoque"] ;
            echo"</td>";
            echo"<td>";
            echo $linha["cor"] ;
            echo"</td>";

            /*Aqui são passados 2 ids por Get, o primeiro como o id do campo que será alterado, e o segundo como o id do administrador que 
            está fazendo a mudança, oq vai permitir a volta para o perfil com os dados do admin*/ 
            echo"<td>";
            echo "<a href='AlterarProdutos.php?id=".$linha['id_produto']."&idprinc=".$id_principal."'>Alterar dados</a>";
            echo"</td>";

            echo"<td>";
            echo "<a href='ExcluirProdutos.php?id=".$linha['id_produto']."&idprinc=".$id_principal."'>Excluir dados</a>";
            echo"</td>";

            echo"</tr>";
            
        }
        echo" </table>";
        echo"<br><br> <a href='AdicionarProdutos.php?id=".$id_principal."'>Adicionar</a>";
        echo"<br> <p class=C><a href='perfil.php?id=".$id_principal."'>Voltar</a></p>";
        echo"</main>";

        include('rodape.php');
?>