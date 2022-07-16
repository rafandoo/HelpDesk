<?php
    /* It's a PHP code that is getting the data from the database and returning it to the ajax call. */
    require_once "autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    $id = isset($_POST["id"]) ? $_POST["id"] : 0;

    $pdo = Conexao::getInstance();
    $consulta = $pdo->query("SELECT * FROM cidade WHERE idEstado = $id ORDER BY nome");
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $cidade = new cidade($linha['idCidade'], $linha['nome'], $linha['idEstado']);
        echo "<option value='".$cidade->getIdCidade()."'>".$cidade->getNome()."</option>";
    }
?>