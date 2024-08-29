<?php 
    include('cabecalho.php'); 
    include('util.php');
?>
<section>
    <img src="./images/sec.jpg" style="width: 80%;" alt="Imagem do Produto">
</section>
<main id="main">
    <aside>
<?php
    $conn = conecta();
    echo"
        <form method='GET' action=''>
        <input type='text' id='filtroCor' name='filtro' placeholder='Filtrar'><br>
        <button type='submit' id='btEnviar'>Enviar</button>";
        echo"</aside>";
    $filtro = 0;
    if($_GET){
        if(!$conn){
            echo"<h3 style='color:gray;'>Servidor não conectado</h3>";
        }else{
            $filtro = $_GET["filtro"];
            if(!$filtro){
                $varSQL = "SELECT * FROM produto WHERE excluido = FALSE";
                $select = $conn->prepare($varSQL);
            }else{
                $varSQL = "SELECT * FROM produto WHERE (cor = :cor)";
                $select = $conn->prepare($varSQL);
                $select->bindParam (":cor",$filtro);
            }
            
            $select->execute();

            echo"
                <article>
            ";
            while($linha = $select-> fetch()){
                echo"
                    <div class='produto' id='".$linha['cor']."'>
                        <img src='./images/copo ".$linha['cor']." normal.jpg' width='34%'>
                        <div>
                            <h3>".$linha['nome']."</h3>
                            <h3 id='preco''>R$".$linha['valor_unitario']."</h3>
                            <p  >".$linha['descricao']."</p>
                        </div>
                    </div>
                
                ";
            }
        }
    }else{
        if(!$conn){
            echo"<h3 style='color:gray;'>Servidor não conectado</h3>";
        }else{
            $varSQL = "SELECT * FROM produto WHERE excluido = FALSE";
            $select = $conn->prepare($varSQL);
            $select->execute();
            echo"
                <article>
            ";
            while($linha = $select-> fetch()){
                echo"
                    <div class='produto' id='".$linha['cor']."'>
                        <img src='./images/copo ".$linha['cor']." normal.jpg' width='34%'>
                        <div>
                            <h3>".$linha['nome']."</h3>
                            <h3 id='preco'>R$".$linha['valor_unitario']."</h3>
                            <p>".$linha['descricao']."</p>
                        </div>
                    </div>
                
                ";
            }
        }
    }
    echo"
            </article>
        </main>
        ";    

    include("rodape.php");
?>