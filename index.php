
<?php 
    include('cabecalho.php'); 
    include('util.php');
?>
<main id="main">
    <aside>
<?php
    $conn = conecta();
    echo"
        <img id='imgAside' src='./images/3 ponto.png' width='40px'>
        <div id='divFiltro'>
            <form method='GET' action=''>
            <select name='filtro' id='selectFiltro' >
                        <option value=''>Todos</option>
                        <option value='Azul'>Azul</option>
                        <option value='Verde'>Verde</option>
                        <option value='Rosa'>Rosa</option>
                        <option value='Laranja'>laranja</option>
                        <option value='vazio' selected>  </option>
            </select>
        </div>
        ";
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
                            <h3 style='color: rgb(14,153,2);'>R$".$linha['valor_unitario']."</h3>
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
                            <h3 style='color: rgb(14,153,2);'>R$".$linha['valor_unitario']."</h3>
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