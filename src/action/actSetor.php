<?php
    require_once "util/autoload.php";

    $acao = "";

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            $acao = $_GET["acao"];
            break;
        case "POST":
            $acao = $_POST["acao"];
            break;
    }

    if ($acao = 'salvar') {
        insertSetor(buildSetor(0, $_POST['descricao'], $_POST['situacao']));
    } else if ($acao = 'excluir') {
        deleteSetor($_GET['idSetor']);
    } else if ($acao = 'editar') {
        updateSetor(buildSetor($_POST['idSetor'], $_POST['descricao'], $_POST['situacao']));
    } 

    function buildSetor($idSetor, $descricao, $situacao) {
        return new setor($idSetor, $descricao, $situacao);
    }

    function insertSetor($setor) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO setor (descricao, situacao) VALUES (:descricao, :situacao)");
        $stmt->bindValue(":descricao", $setor->getDescricao());
        $stmt->bindValue(":situacao", $setor->getSituacao());
        $stmt->execute();
        header("Location: index.php");
    }

    function updateSetor($setor) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE setor SET descricao = :descricao, situacao = :situacao WHERE idSetor = :id");
        $stmt->bindValue(":descricao", $setor->getDescricao());
        $stmt->bindValue(":situacao", $setor->getSituacao());
        $stmt->bindValue(":id", $setor->getId());
        $stmt->execute();
        header("Location: index.php");
    }

    function deleteSetor($idSetor) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM setor WHERE idSetor = :id");
        $stmt->bindValue(":id", $idSetor);
        $stmt->execute();
        header("Location: index.php");
    }
?>