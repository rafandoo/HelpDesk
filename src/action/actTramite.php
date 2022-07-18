<?php
    require_once "../util/autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";
    include_once "actTicket.php";

    $acao = "";

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $acao = $_GET["acao"];
            break;
        case "POST":
            $acao = $_POST["acao"];
            break;
    }

    if ($acao === 'incluir') {
        updateTicketTramite($_POST['status'], $_POST['idTicket']);
        insertTramite(buildTramite(0, $_POST['data'], $_POST['horaInicial'], $_POST['horaFinal'], $_POST['descricao'], $_POST['idTicket'], $_POST['usuario']));
    }

    function buildTramite($idTramite, $data, $horaInicial, $horaFinal, $descricao, $idTicket, $usuario) {
        return new tramite($idTramite, $data, $horaInicial, $horaFinal, $descricao, $idTicket, $usuario);
    }

    function insertTramite($tramite) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO tramite (data, horaInicial, horaFinal, descricao, idTicket, usuario) VALUES (:data, :horaInicial, :horaFinal, :descricao, :idTicket, :usuario)");
        $stmt->bindValue(":data", $tramite->getData());
        $stmt->bindValue(":horaInicial", $tramite->getHoraInicial());
        $stmt->bindValue(":horaFinal", $tramite->getHoraFinal());
        $stmt->bindValue(":descricao", $tramite->getDescricao());
        $stmt->bindValue(":idTicket", $tramite->getIdTicket());
        $stmt->bindValue(":usuario", $tramite->getUsuario());
        $stmt->execute();
        header("Location: ../listaTramites.php?idTicket=" . $tramite->getIdTicket());
    }
?>