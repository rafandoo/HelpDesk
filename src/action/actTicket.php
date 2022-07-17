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
    } else if ($acao == 'excluir') {
        deleteTicket($_GET['idTicket']);
    } else if ($acao == 'editar') {
        $dataAtualizacao = date('Y-m-d H:i');
        updateTicket(buildTicket($_POST['idTicket'], $_POST['titulo'], $_POST['descricao'], $_POST['dataAbertura'], $dataAtualizacao, $dataFinalizacao, $_POST['categoria'], $_POST['prioridade'], $_POST['status'], $_POST['setor'], $_POST['cliente'], $_POST['contato'], $_POST['usuario']));
    } else if ($acao == 'abrirTicketCliente') {
        insertTicketCliente(buildTicket($_POST['idTicket'], $_POST['titulo'], $_POST['descricao'], $_POST['dataAbertura'], NULL, NULL, $_POST['categoria'], NULL, 1, $_POST['setor'], $_POST['cliente'], $_POST['contato'], 0));
    }

    /**
     * It creates a new ticket object.
     * 
     * @param idTicket int
     * @param titulo Title of the ticket
     * @param descricao text
     * @param dataAbertura date
     * @param dataAtualizacao DateTime
     * @param dataFinalizacao date
     * @param categoria category
     * @param prioridade 1 = low, 2 = medium, 3 = high
     * @param status 1 = open, 2 = closed, 3 = pending
     * @param setor 1
     * @param cliente is a class
     * @param contato 
     * @param usuario is the user who created the ticket
     * 
     * @return A new ticket object.
     */
    function buildTicket($idTicket, $titulo, $descricao, $dataAbertura, $dataAtualizacao, $dataFinalizacao, $categoria, $prioridade, $status, $setor, $cliente, $contato, $usuario) {
        return new ticket($idTicket, $titulo, $descricao, $dataAbertura, $dataAtualizacao, $dataFinalizacao, $categoria, $prioridade, $status, $setor, $cliente, $contato, $usuario);
    }

    /**
     * It inserts a ticket into the database.
     * 
     * @param ticket 
     */
    function insertTicket($ticket) {
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

    /**
     * It updates a ticket in the database.
     * 
     * @param ticket is the object that contains all the data that will be updated in the database.
     */
    function updateTicket($ticket) {
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

    /**
     * It deletes a ticket from the database.
     * 
     * @param idTicket 1
     */
    function deleteTicket($idTicket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM ticket WHERE idTicket = :idTicket");
        $stmt->bindValue(":idTicket", $idTicket);
        $stmt->execute();
        header("Location: ../filaAtendimentos.php");
    }

    /**
     * Update the ticket table with the current date, the date of completion, and the status of the
     * ticket.
     * 
     * @param status 4
     * @param idTicket 1
     */
    function updateTicketTramite($status, $idTicket) {
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

    /**
     * It inserts a ticket into the database.
     * 
     * @param ticket 
     */
    function insertTicketCliente($ticket) {
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
?>