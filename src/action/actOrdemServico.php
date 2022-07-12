<?php

    require_once "util/autoload.php";

    $acao = "";

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            $acao = $_GET['acao'];
            break;
        case "POST":
            $acao = $_POST['acao'];
            break;
    }

    if ($acao == 'salvar') {
        insertOrdemServico(buildOrdemServico(0, $_POST['idUsuario'], $_POST['idSetor'], $_POST['descricao'], $_POST['situacao']));
    } elseif ($acao == 'excluir') {
        deleteOrdemServico($_GET['idOrdemServico']);
    } elseif ($acao == 'editar') {
        updateOrdemServico(buildOrdemServico($_POST['idOrdemServico'], $_POST['idUsuario'], $_POST['idSetor'], $_POST['descricao'], $_POST['situacao']));
    }

    function buildOrdemServico($idOrdemServico, $valor, $idTicket)
    {
        return new ordemServico($idOrdemServico, $valor, $idTicket);
    }

    function insertOrdemServico($ordemServico)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO ordemServico (valor, idTicket) VALUES (:valor, :idTicket)");
        $stmt->bindValue(':valor', $ordemServico->getValor());
        $stmt->bindValue(':idTicket', $ordemServico->getIdTicket());
        $stmt->execute();
        header('Location: index.php');
    }

    function updateOrdemServico($ordemServico)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE ordemServico SET valor = :valor, idTicket = :idTicket WHERE idOrdemServico = :id");
        $stmt->bindValue(':valor', $ordemServico->getValor());
        $stmt->bindValue(':idTicket', $ordemServico->getIdTicket());
        $stmt->bindValue(':id', $ordemServico->getIdOrdemServico());
        $stmt->execute();
        header('Location: index.php');
    }

    function deleteOrdemServico($idOrdemServico)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM ordemServico WHERE idOrdemServico = :id");
        $stmt->bindValue(':id', $idOrdemServico);
        $stmt->execute();
        header('Location: index.php');
    }
