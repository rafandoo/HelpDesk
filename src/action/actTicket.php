<?php
    require_once "../util/autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";
    include_once "actDelete.php";

    $acao = "";

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $acao = $_GET["acao"];
            break;
        case "POST":
            $acao = $_POST['acao'];
            $idTicket = isset($_POST['idTicket']) ? $_POST['idTicket'] : null; 
            $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null; 
            $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
            $dataAbertura = isset($_POST['dataAbertura']) ? $_POST['dataAbertura'] : null; 
            $dataAtualizacao = isset($_POST['dataAtualizacao']) ? $_POST['dataAtualizacao'] : null; 
            $dataFinalizacao = isset($_POST['dataFinalizacao']) ? $_POST['dataFinalizacao'] : null; 
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null; 
            $prioridade = isset($_POST['prioridade']) ? $_POST['prioridade'] : null; 
            $status = isset($_POST['status']) ? $_POST['status'] : null; 
            $setor = isset($_POST['setor']) ? $_POST['setor'] : null; 
            $cliente = isset($_POST['idCliente']) ? $_POST['idCliente'] : null;
            $contato = isset($_POST['contato']) ? $_POST['contato'] : null; 
            $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null; 
            break;
    }

    if ($acao === 'salvar') {
        insertTicket(buildTicket($idTicket, $titulo, $descricao, $dataAbertura, $dataAtualizacao, $dataFinalizacao, $categoria, $prioridade, $status, $setor, $cliente, $contato, $usuario));
    } else if ($acao === 'excluir') {
        deleteLinhaTabela('ticket', "idTicket", $_GET['idTicket']);
        deleteLinhaTabela('tramite', "idTicket", $_GET['idTicket']);
        header("Location: ../filaAtendimentos.php");
    } else if ($acao === 'editar') {
        $dataAtualizacao = date('Y-m-d H:i');
        if ($status === 4) {
            $dataFinalizacao = $dataAtualizacao;
        }
        updateTicket(buildTicket($idTicket, $titulo, $descricao, $dataAbertura, $dataAtualizacao, $dataFinalizacao, $categoria, $prioridade, $status, $setor, $cliente, $contato, $usuario));
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
     * @param prioridade
     * @param status 
     * @param setor 1
     * @param cliente is a class
     * @param contato 
     * @param usuario 
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
?>