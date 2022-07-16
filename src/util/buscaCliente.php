<?php
    /* It's a PHP code that is getting the data from the database and returning it to the ajax call. */
    require_once "autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    $filtro = isset($_POST["filtro"]) ? $_POST["filtro"] : "";
    $procurar = isset($_POST["procurar"]) ? $_POST["procurar"] : "";

    $pdo = Conexao::getInstance();
    $consulta = $pdo->query("SELECT * FROM cliente WHERE $filtro LIKE '%$procurar%' ORDER BY $filtro");
    while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
        $cliente = new cliente($linha['idCliente'], $linha['nome'], $linha['nomeFantasia'], $linha['cpfCnpj'], $linha['endereco'], $linha['numero'], $linha['bairro'], $linha['cidade'], $linha['email'], $linha['telefone'], $linha['observacoes'], $linha['idUsuario'], $linha['situacao']);
        echo "<tr onclick='selecionaCliente(".$cliente->getIdCliente().", \"".$cliente->getNome()."\")' style='cursor: pointer;'>";
            echo "<td>".$cliente->getIdCliente()."</td>";
            echo "<td>".$cliente->getNome()."</td>";
            echo "<td>".$cliente->getCpfCnpj()."</td>";
            echo "<td>".$cliente->getStrSituacao()."</td>";
        echo "</tr>";
    }
?>