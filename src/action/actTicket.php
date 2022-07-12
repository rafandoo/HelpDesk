<?php

    require_once "../util/autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    $acao = "";

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $acao = $_GET["acao"];
            break;
        case "POST":
            $acao = $_POST["acao"];
            break;
    }

    if ($acao == 'salvar') {
        insertTicket(buildTicket($_POST['idTicket'], $_POST['titulo'], $_POST['descricao'], $_POST['dataAbertura'], $_POST['dataAtualizacao'], null, $_POST['categoria'], $_POST['prioridade'], $_POST['status'], $_POST['setor'], $_POST['idCliente'], $_POST['contato'], $_POST['usuario']));
    } elseif ($acao == 'excluir') {
        deleteTicket($_GET['idTicket']);
    } elseif ($acao == 'editar') {
        $dataAtualizacao = date('Y-m-d H:i');
        updateTicket(buildTicket($_POST['idTicket'], $_POST['titulo'], $_POST['descricao'], $_POST['dataAbertura'], $dataAtualizacao, $dataFinalizacao, $_POST['categoria'], $_POST['prioridade'], $_POST['status'], $_POST['setor'], $_POST['cliente'], $_POST['contato'], $_POST['usuario']));
    } elseif ($acao == 'abrirTicketCliente') {
        insertTicketCliente(buildTicket($_POST['idTicket'], $_POST['titulo'], $_POST['descricao'], $_POST['dataAbertura'], null, null, $_POST['categoria'], null, 1, $_POST['setor'], $_POST['cliente'], $_POST['contato'], 0));
    }

    function buildTicket($idTicket, $titulo, $descricao, $dataAbertura, $dataAtualizacao, $dataFinalizacao, $categoria, $prioridade, $status, $setor, $cliente, $contato, $usuario)
    {
        return new ticket($idTicket, $titulo, $descricao, $dataAbertura, $dataAtualizacao, $dataFinalizacao, $categoria, $prioridade, $status, $setor, $cliente, $contato, $usuario);
    }

    function insertTicket($ticket)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO ticket (titulo, descricao, dataAbertura, dataAtualizacao, categoria, prioridade, status, setor, cliente, contato, usuario) VALUES (:titulo, :descricao, :dataAbertura, :dataAtualizacao, :categoria, :prioridade, :status, :setor, :cliente, :contato, :usuario)");
        $stmt->bindValue(":titulo", $ticket->getTitulo());
        $stmt->bindValue(":descricao", $ticket->getDescricao());
        $stmt->bindValue(":dataAbertura", $ticket->getDataAbertura());
        $stmt->bindValue(":dataAtualizacao", $ticket->getDataAtualizacao());
        $stmt->bindValue(":categoria", $ticket->getCategoria());
        $stmt->bindValue(":prioridade", $ticket->getPrioridade());
        $stmt->bindValue(":status", $ticket->getStatus());
        $stmt->bindValue(":setor", $ticket->getSetor());
        $stmt->bindValue(":cliente", $ticket->getCliente());
        $stmt->bindValue(":contato", $ticket->getContato());
        $stmt->bindValue(":usuario", $ticket->getUsuario());
        $stmt->execute();
        header("Location: ../filaAtendimentos.php");
    }

    function updateTicket($ticket)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE ticket SET titulo = :titulo, descricao = :descricao, dataAtualizacao = :dataAtualizacao, dataFinalizacao = :dataFinalizacao, categoria = :categoria, prioridade = :prioridade, status = :status, setor = :setor, cliente = :cliente, contato = :contato, usuario = :usuario WHERE idTicket = :idTicket");
        $stmt->bindValue(":titulo", $ticket->getTitulo());
        $stmt->bindValue(":descricao", $ticket->getDescricao());
        $stmt->bindValue(":dataAtualizacao", $ticket->getDataAtualizacao());
        $stmt->bindValue(":dataFinalizacao", $ticket->getDataFinalizacao());
        $stmt->bindValue(":categoria", $ticket->getCategoria());
        $stmt->bindValue(":prioridade", $ticket->getPrioridade());
        $stmt->bindValue(":status", $ticket->getStatus());
        $stmt->bindValue(":setor", $ticket->getSetor());
        $stmt->bindValue(":cliente", $ticket->getCliente());
        $stmt->bindValue(":contato", $ticket->getContato());
        $stmt->bindValue(":usuario", $ticket->getUsuario());
        $stmt->bindValue(":idTicket", $ticket->getIdTicket());
        $stmt->execute();
        header("Location: ../cadTickets.php?acao=alterar&idTicket=" . $ticket->getIdTicket());
    }

    function deleteTicket($idTicket)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM ticket WHERE idTicket = :idTicket");
        $stmt->bindValue(":idTicket", $idTicket);
        $stmt->execute();
        header("Location: ../filaAtendimentos.php");
    }

    function updateTicketTramite($status, $idTicket)
    {
        $dataAtualizacao = date('Y-m-d H:i');
        if ($status == 4) {
            $dataFinalizacao = $dataAtualizacao;
        } else {
            $dataFinalizacao = null;
        }
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE ticket SET dataAtualizacao = :dataAtualizacao, dataFinalizacao = :dataFinalizacao, status = :status WHERE idTicket = :idTicket");
        $stmt->bindValue(":dataAtualizacao", $dataAtualizacao);
        $stmt->bindValue(":dataFinalizacao", $dataFinalizacao);
        $stmt->bindValue(":status", $status);
        $stmt->bindValue(":idTicket", $idTicket);
        $stmt->execute();
    }

    function insertTicketCliente($ticket)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO ticket (titulo, descricao, dataAbertura, categoria, status, setor, cliente, contato, usuario) VALUES (:titulo, :descricao, :dataAbertura, :categoria, :status, :setor, :cliente, :contato, :usuario)");
        $stmt->bindValue(":titulo", $ticket->getTitulo());
        $stmt->bindValue(":descricao", $ticket->getDescricao());
        $stmt->bindValue(":dataAbertura", $ticket->getDataAbertura());
        $stmt->bindValue(":categoria", $ticket->getCategoria());
        $stmt->bindValue(":status", $ticket->getStatus());
        $stmt->bindValue(":setor", $ticket->getSetor());
        $stmt->bindValue(":cliente", $ticket->getCliente());
        $stmt->bindValue(":contato", $ticket->getContato());
        $stmt->bindValue(":usuario", $ticket->getUsuario());
        $stmt->execute();
        header("Location: ../cliente/homeCli.php");
    }
