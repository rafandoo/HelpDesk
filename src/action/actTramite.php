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

    if ($acao == 'salvar') {
        insertTramite(buildTramite(0, $_POST['idTramite'], $_POST['idUsuario'], $_POST['idSetor'], $_POST['idPrioridade'], $_POST['idCategoria'], $_POST['descricao'], $_POST['situacao']));
    } else if ($acao = 'excluir') {
        deleteTramite($_GET['idTramite']);
    } else if ($acao = 'editar') {
        updateTramite(buildTramite($_POST['idTramite'], $_POST['idUsuario'], $_POST['idSetor'], $_POST['idPrioridade'], $_POST['idCategoria'], $_POST['descricao'], $_POST['situacao']));
    }

    function buildTramite($idTramite, $horaInicial, $horaFinal, $descricao, $idTicket, $usuario) {
        return new tramite($idTramite, $horaInicial, $horaFinal, $descricao, $idTicket, $usuario);
    }

    function insertTramite($tramite) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO tramite (horaInicial, horaFinal, descricao, idTicket, usuario) VALUES (:horaInicial, :horaFinal, :descricao, :idTicket, :usuario)");
        $stmt->bindValue(":horaInicial", $tramite->getHoraInicial());
        $stmt->bindValue(":horaFinal", $tramite->getHoraFinal());
        $stmt->bindValue(":descricao", $tramite->getDescricao());
        $stmt->bindValue(":idTicket", $tramite->getIdTicket());
        $stmt->bindValue(":usuario", $tramite->getUsuario());
        $stmt->execute();
        header("Location: index.php");
    }

    function updateTramite($tramite) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE tramite SET horaInicial = :horaInicial, horaFinal = :horaFinal, descricao = :descricao, idTicket = :idTicket, usuario = :usuario WHERE idTramite = :id");
        $stmt->bindValue(":horaInicial", $tramite->getHoraInicial());
        $stmt->bindValue(":horaFinal", $tramite->getHoraFinal());
        $stmt->bindValue(":descricao", $tramite->getDescricao());
        $stmt->bindValue(":idTicket", $tramite->getIdTicket());
        $stmt->bindValue(":usuario", $tramite->getUsuario());
        $stmt->bindValue(":id", $tramite->getIdTramite());
        $stmt->execute();
        header("Location: index.php");
    }

    function deleteTramite($idTramite) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM tramite WHERE idTramite = :id");
        $stmt->bindValue(":id", $idTramite);
        $stmt->execute();
        header("Location: index.php");
    }
?>