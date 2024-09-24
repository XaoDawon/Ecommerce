<?php
    // util.php //// funcao de conexao 14-8-2023
    function conecta ($params = "")
    {
        if ($params == "") {
            $params="pgsql:host=pgsql.projetoscti.com.br;
            dbname=projetoscti10; user=projetoscti10; password=eq42B156";
        }
        $varConn = new PDO($params);
        if (!$varConn) {
            echo "Nao foi possivel conectar";
            exit;
        } else { return $varConn; }
    }
?>

