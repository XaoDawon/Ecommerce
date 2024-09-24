<?php
    include("cabecalho.php");
    include("util.php");
    $nula=NULL;
    $conn = conecta();
    $varSQL = "SELECT nome, email, telefone, senha, admin
                FROM usuario
                WHERE id_usuario = :id_usuario";

    $select = $conn->prepare($varSQL);
    $select->bindParam(':id_usuario', $usuario);
    $select->execute();
    while($linha = $select->fetch())
    {
        echo"
        <main class='modificamentos'>
            <div id='centerDivModificamentos'>
                <img src='./images/profImages/download.jfif'  id='profileImage'>
                <p class='pModificamentos' id='pUsuario'><span style='color:#4989b9;' >".$linha['nome']."</span></p>
                <p class='pModificamentos'>Email&nbsp;<span >".$linha['email']."</span></p>
                <p class='pModificamentos' style='padding-bottom: 3vh; '>Telefone&nbsp;<span>".$linha['telefone']."</span></p>
                 <div id='opcModificamentos'>
                    <input type='button' class='buttonGen' value='Alterar usuário'>
                    <input type='button' class='buttonGen' value='Excluir usuário'>
                    
        
        ";

        $adm = $linha['admin'];
    }
    if($adm){
        echo"<input type='button' class='buttonGen' value='Usuarios'>
        <input type='button' class='buttonGen' value='Produtos'>";
    }
    echo"</div>
                
            </div>
        </main>";
   

    /*Aqui o email é como uma "pk". Existência de um select com o email inserido no cadastro: 'select nome from usuario where email = emailinserido'. 
    Se o select voltar nulo, qr dizer que é um email novo e pode-se cadastrá-lo, se voltar com algum resultado o email já existe e n pode repetir. Isso garante que não haverão 
    emails repetidos, assim permitindo pegar o id do usuario cadastrado (criado automaticamente no banco) com base nesse email. Depois do teste se insere os dados e usa um "select idusuario from usuario where email =
    emailinserido. Assim tem o teste de consistência para não repetir o email onde só permite o cadastro se o select voltar nulo, e estipulando que o email não se repita
    vc pode usá-lo para pegar o id referente a esse email gerado automaticamente pelo banco*/

    include("rodape.php");

?>