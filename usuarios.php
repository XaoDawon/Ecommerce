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
                FROM usuario";
        
        $select = $conn->query($varSQL);

        echo"<main>";
        echo"<p class=C color=>Usuarios</p><table border=1 color=white>
                <th>Id</th><th>Nome</th><th>Email</th><th>Senha</th>
                <th>Admin</th><th>Telefone</th><th>Alterar</th><th>Excluir</th><th>Definir admin</th>";
            while($linha = $select->fetch())
            {
                echo"<tr>";
                echo"<td>";
                echo $linha["id_usuario"] ;
                echo"</td>";
                echo"<td>";
                echo $linha["nome"] ;
                echo"</td>";
                echo"<td>";
                echo $linha["email"] ;
                echo"</td>";
                echo"<td>";
                echo $linha["senha"] ;
                echo"</td>";
                echo"<td>";
                echo $linha["admin"] ;
                echo"</td>";
                echo"<td>";
                echo $linha["telefone"] ;
                echo"</td>";
                /*Aqui são passados 2 ids por Get, o primeiro como o id do campo que será alterado, e o segundo como o id do administrador que 
                está fazendo a mudança, oq vai permitir a volta para o perfil com os dados do admin*/ 
                echo"<td>";
                echo "<a href='AlterarUsuarios.php?id=".$linha['id_usuario']."&idprincipal=".$id_principal."'>Alterar dados</a>";
                echo"</td>";

                echo"<td>";
                echo "<a href='ExcluirUsuarios.php?id=".$linha['id_usuario']."&idprincipal=".$id_principal."'>Excluir dados</a>";
                echo"</td>";

                echo"<td>";
                echo "<a href='Admin.php?id=".$linha['id_usuario']."&idprincipal=".$id_principal."'>Definir admin</a>";
                echo"</td>";

                echo"</tr>";
                
            }
        echo" </table>";
        echo"<p class=C><a href='perfil.php?id=".$id_principal."'>Voltar</a></p>";
        echo"</main>";
        include('rodape.php');
    
?>