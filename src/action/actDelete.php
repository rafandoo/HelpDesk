<?php
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    function deleteLinhaTabela($tabela, $coluna, $id) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM $tabela WHERE $coluna = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
?>