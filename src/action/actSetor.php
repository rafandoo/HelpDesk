<?php

    require_once "../util/autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    $acao = "";

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            $acao = $_GET["acao"];
            break;
        case "POST":
            $acao = $_POST["acao"];
            break;
    }

    if ($acao == 'salvar') {
        insertSetor(buildSetor(0, $_POST['descricao'], $_POST['situacao']));
    } elseif ($acao == 'excluir') {
        deleteSetor($_GET['idSetor']);
    } elseif ($acao == 'editar') {
        updateSetor(buildSetor($_POST['idSetor'], $_POST['descricao'], $_POST['situacao']));
    } elseif ($acao == 'situacao') {
        situationSetor($_GET['idSetor']);
    }

    function buildSetor($idSetor, $descricao, $situacao)
    {
        return new setor($idSetor, $descricao, $situacao);
    }

    function insertSetor($setor)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO setor (descricao, situacao) VALUES (:descricao, :situacao)");
        $stmt->bindValue(":descricao", $setor->getDescricao());
        $stmt->bindValue(":situacao", $setor->getSituacao());
        $stmt->execute();
        header("Location: ../setores.php");
    }

    function updateSetor($setor)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE setor SET descricao = :descricao, situacao = :situacao WHERE idSetor = :id");
        $stmt->bindValue(":descricao", $setor->getDescricao());
        $stmt->bindValue(":situacao", $setor->getSituacao());
        $stmt->bindValue(":id", $setor->getId());
        $stmt->execute();
        header("Location: ../setores.php");
    }

    function deleteSetor($idSetor)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM setor WHERE idSetor = :id");
        $stmt->bindValue(":id", $idSetor);
        $stmt->execute();
    }

    function situationSetor($idSetor)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT situacao FROM setor WHERE idSetor = :id");
        $stmt->bindValue(":id", $idSetor);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['situacao'] == 0) {
            $stmt = $pdo->prepare("UPDATE setor SET situacao = 1 WHERE idSetor = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE setor SET situacao = 0 WHERE idSetor = :id");
        }
        $stmt->bindValue(":id", $idSetor);
        $stmt->execute();
        header("Location: ../setores.php");
    }
