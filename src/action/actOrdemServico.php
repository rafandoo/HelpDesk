<?php
    require_once "../util/autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";
    
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
        insertOrdemServico(buildOrdemServico(0, $_POST['valor'], $_POST['descricao'], $_POST['idTicket']));
    } else if ($acao == 'editar') {
        updateOrdemServico(buildOrdemServico($_POST['idOrdemServico'], $_POST['valor'], $_POST['descricao'], $_POST['idTicket']));
    }

    /**
     * It creates a new object of the class "ordemServico" and returns it.
     * 
     * @param idOrdemServico int
     * @param valor is a decimal value
     * @param descricao string
     * @param idTicket int
     * 
     * @return An object of type ordemServico.
     */
    function buildOrdemServico($idOrdemServico, $valor, $descricao, $idTicket) {
        return new ordemServico($idOrdemServico, $valor, $descricao, $idTicket);
    }

    /**
     * It inserts a new order into the database.
     * 
     * @param ordemServico object
     */
    function insertOrdemServico($ordemServico) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO ordemServico (valor, descricao, idTicket) VALUES (:valor, :descricao, :idTicket)");
        $stmt->bindValue(':valor', $ordemServico->getValor());
        $stmt->bindValue(':descricao', $ordemServico->getDescricao());
        $stmt->bindValue(':idTicket', $ordemServico->getIdTicket());
        $stmt->execute();
        header("Location: ../cadOrdemServico.php?idTicket=" . $ordemServico->getIdTicket());
    }


    /**
     * It updates the table ordemServico with the values of the object .
     * 
     * @param ordemServico is the object that contains the data to be updated.
     */
    function updateOrdemServico($ordemServico) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE ordemServico SET valor = :valor, descricao = :descricao WHERE idOrdemServico = :idOrdemServico");
        $stmt->bindValue(':valor', $ordemServico->getValor());
        $stmt->bindValue(':descricao', $ordemServico->getDescricao());
        $stmt->bindValue(':idOrdemServico', $ordemServico->getIdOrdemServico());
        $stmt->execute();
        header("Location: ../cadOrdemServico.php?idTicket=" . $ordemServico->getIdTicket());
    }
?>