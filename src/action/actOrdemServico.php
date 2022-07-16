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
    } else if ($acao == 'excluir') {
        deleteOrdemServico($_GET['idOrdemServico']);
    } else if ($acao == 'editar') {
        updateOrdemServico(buildOrdemServico($_POST['idOrdemServico'], $_POST['idUsuario'], $_POST['idSetor'], $_POST['descricao'], $_POST['situacao']));
    }

    /**
     * It creates a new object of the class "ordemServico" and returns it.
     * 
     * @param idOrdemServico int
     * @param valor is a decimal value
     * @param idTicket int
     * 
     * @return An object of type ordemServico.
     */
    function buildOrdemServico($idOrdemServico, $valor, $idTicket) {
        return new ordemServico($idOrdemServico, $valor, $idTicket);
    }

    /**
     * It inserts a new record into the ordemServico table.
     * 
     * @param ordemServico 
     */
    function insertOrdemServico($ordemServico) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO ordemServico (valor, idTicket) VALUES (:valor, :idTicket)");
        $stmt->bindValue(':valor', $ordemServico->getValor());
        $stmt->bindValue(':idTicket', $ordemServico->getIdTicket());
        $stmt->execute();
        header('Location: index.php');
    }

    /**
     * It updates the value of the column "valor" in the table "ordemServico" where the idOrdemServico
     * is equal to the idOrdemServico of the object .
     * 
     * @param ordemServico 
     */
    function updateOrdemServico($ordemServico) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE ordemServico SET valor = :valor, idTicket = :idTicket WHERE idOrdemServico = :id");
        $stmt->bindValue(':valor', $ordemServico->getValor());
        $stmt->bindValue(':idTicket', $ordemServico->getIdTicket());
        $stmt->bindValue(':id', $ordemServico->getIdOrdemServico());
        $stmt->execute();
        header('Location: index.php');
    }

    /**
     * It deletes a row from the database table 'ordemServico' where the idOrdemServico column matches
     * the value of the  variable.
     * 
     * @param idOrdemServico int(11)
     */
    function deleteOrdemServico($idOrdemServico) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM ordemServico WHERE idOrdemServico = :id");
        $stmt->bindValue(':id', $idOrdemServico);
        $stmt->execute();
        header('Location: index.php');
    }
?>