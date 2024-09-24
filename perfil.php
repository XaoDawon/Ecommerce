<?php
    include("cabecalho.php");
    include("util.php");
    $nula=NULL;
    echo"<br><br><p class=C>Meu perfil</p>";
    $conn = conecta();
    $varSQL = "SELECT nome, email, telefone, senha, admin
                FROM usuario
                WHERE id_usuario = :id_usuario";

    $select = $conn->prepare($varSQL);
    $select->bindParam(':id_usuario', $usuario);
    $select->execute();
    echo"<center><table border=3px></center><th>Nome</th><th>Email</th><th>Telefone</th><th>Senha</th><th>Alterar Dados</th><th>Excluir Dados</th>";
    while($linha = $select->fetch())
    {
        echo"<tr>";
        echo"<td>";
        echo $linha["nome"] ;
        echo"</td>";
        echo"<td>";
        echo $linha["email"] ;
        echo"</td>";
        echo"<td>";
        echo $linha["telefone"] ;
        echo"</td>";
        echo"<td>";
        echo $linha["senha"] ;
        echo"</td>";
        echo"<td>";
        echo "<a href='AlterarUsuarios.php?id=".$usuario."&idprincipal=".$nula."'>Alterar dados</a>";
        echo"</td>";

        echo"<td>";
        echo "<a href='ExcluirUsuarios.php?id=".$usuario."&idprincipal=".$nula."'>Excluir dados</a>";
        echo"</td>";

        echo"</tr>";

        $adm = $linha['admin'];
    }
    echo"</table>";
    if($adm){
        echo"<br><br><p class=C>Login administrativo</p>";
        echo"<p class=C><a href='usuarios.php?id=".$usuario."'>Usuários</a> <a href='produtos.php?id=".$usuario."'>Produtos</a></p>";
    }
    echo"<br><br><p class=C><a href='logout.php'>Logout</a></p>";
   

    /*Aqui o email é como uma "pk". Existência de um select com o email inserido no cadastro: 'select nome from usuario where email = emailinserido'. 
    Se o select voltar nulo, qr dizer que é um email novo e pode-se cadastrá-lo, se voltar com algum resultado o email já existe e n pode repetir. Isso garante que não haverão 
    emails repetidos, assim permitindo pegar o id do usuario cadastrado (criado automaticamente no banco) com base nesse email. Depois do teste se insere os dados e usa um "select idusuario from usuario where email =
    emailinserido. Assim tem o teste de consistência para não repetir o email onde só permite o cadastro se o select voltar nulo, e estipulando que o email não se repita
    vc pode usá-lo para pegar o id referente a esse email gerado automaticamente pelo banco*/
?>