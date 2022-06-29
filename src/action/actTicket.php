<?php
    require_once "util/autoload.php";

    $acao = "";

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $acao = $_GET["acao"];
            break;
        case "POST":
            $acao = $_POST["acao"];
            break;
    }

    if ($acao = 'salvar') {
        insertTicket(buildTicket($_POST['idTicket'], $_POST['titulo'], $_POST['descricao'], $_POST['dataAbertura'], $_POST['dataAtualizacao'], $_POST['dataFinalizacao'], $_POST['categoria'], $_POST['prioridade'], $_POST['status'], $_POST['setor'], $_POST['cliente'], $_POST['usuario']));
    } else if ($acao = 'excluir') {
        deleteTicket($_POST['idTicket']);
    } else if ($acao = 'editar') {
        updateTicket(buildTicket($_POST['idTicket'], $_POST['titulo'], $_POST['descricao'], $_POST['dataAbertura'], $_POST['dataAtualizacao'], $_POST['dataFinalizacao'], $_POST['categoria'], $_POST['prioridade'], $_POST['status'], $_POST['setor'], $_POST['cliente'], $_POST['usuario']));
    }

    function buildTicket($idTicket, $titulo, $descricao, $dataAbertura, $dataAtualizacao, $dataFinalizacao, $categoria, $prioridade, $status, $setor, $cliente, $usuario) {
        return new ticket($idTicket, $titulo, $descricao, $dataAbertura, $dataAtualizacao, $dataFinalizacao, $categoria, $prioridade, $status, $setor, $cliente, $usuario);
    }

    function insertTicket($ticket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO ticket (titulo, descricao, data_abertura, data_atualizacao, data_finalizacao, categoria, prioridade, status, setor, cliente, usuario) VALUES (:titulo, :descricao, :dataAbertura, :dataAtualizacao, :dataFinalizacao, :categoria, :prioridade, :status, :setor, :cliente, :usuario)");
        $stmt->bindValue(":titulo", $ticket->getTitulo());
        $stmt->bindValue(":descricao", $ticket->getDescricao());
        $stmt->bindValue(":dataAbertura", $ticket->getDataAbertura());
        $stmt->bindValue(":dataAtualizacao", $ticket->getDataAtualizacao());
        $stmt->bindValue(":dataFinalizacao", $ticket->getDataFinalizacao());
        $stmt->bindValue(":categoria", $ticket->getCategoria());
        $stmt->bindValue(":prioridade", $ticket->getPrioridade());
        $stmt->bindValue(":status", $ticket->getStatus());
        $stmt->bindValue(":setor", $ticket->getSetor());
        $stmt->bindValue(":cliente", $ticket->getCliente());
        $stmt->bindValue(":usuario", $ticket->getUsuario());
        $stmt->execute();
        header("Location: index.php");
    }

    function updateTicket($ticket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE ticket SET titulo = :titulo, descricao = :descricao, data_abertura = :dataAbertura, data_atualizacao = :dataAtualizacao, data_finalizacao = :dataFinalizacao, categoria = :categoria, prioridade = :prioridade, status = :status, setor = :setor, cliente = :cliente, usuario = :usuario WHERE id_ticket = :idTicket");
        $stmt->bindValue(":titulo", $ticket->getTitulo());
        $stmt->bindValue(":descricao", $ticket->getDescricao());
        $stmt->bindValue(":dataAbertura", $ticket->getDataAbertura());
        $stmt->bindValue(":dataAtualizacao", $ticket->getDataAtualizacao());
        $stmt->bindValue(":dataFinalizacao", $ticket->getDataFinalizacao());
        $stmt->bindValue(":categoria", $ticket->getCategoria());
        $stmt->bindValue(":prioridade", $ticket->getPrioridade());
        $stmt->bindValue(":status", $ticket->getStatus());
        $stmt->bindValue(":setor", $ticket->getSetor());
        $stmt->bindValue(":cliente", $ticket->getCliente());
        $stmt->bindValue(":usuario", $ticket->getUsuario());
        $stmt->bindValue(":idTicket", $ticket->getIdTicket());
        $stmt->execute();
        header("Location: index.php");
    }

    function deleteTicket($idTicket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM ticket WHERE id_ticket = :idTicket");
        $stmt->bindValue(":idTicket", $idTicket);
        $stmt->execute();
        header("Location: index.php");
    }
?>