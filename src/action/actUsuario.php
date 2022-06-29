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

    function buildUsuario($idUsuario, $nome, $sobrenome, $email, $login, $senha, $nivelAcesso, $setor, $situacao) {
        return new usuario($idUsuario, $nome, $sobrenome, $email, $login, $senha, $nivelAcesso, $setor, $situacao);
    }

    function insertUsuario($usuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO usuario (nome, sobrenome, email, login, senha, nivelAcesso, setor, situacao) VALUES (:nome, :sobrenome, :email, :login, :senha, :nivelAcesso, :setor, :situacao)");
        $stmt->bindValue(":nome", $usuario->getNome());
        $stmt->bindValue(":sobrenome", $usuario->getSobrenome());
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":login", $usuario->getLogin());
        $stmt->bindValue(":senha", $usuario->getSenha());
        $stmt->bindValue(":nivelAcesso", $usuario->getNivelAcesso());
        $stmt->bindValue(":setor", $usuario->getSetor());
        $stmt->bindValue(":situacao", $usuario->getSituacao());
        $stmt->execute();
        header("Location: index.php");
    }

    function updateUsuario($usuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE usuario SET nome = :nome, sobrenome = :sobrenome, email = :email, login = :login, senha = :senha, nivelAcesso = :nivelAcesso, setor = :setor, situacao = :situacao WHERE idUsuario = :id)");
        $stmt->bindValue(":nome", $usuario->getNome());
        $stmt->bindValue(":sobrenome", $usuario->getSobrenome());
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":login", $usuario->getLogin());
        $stmt->bindValue(":senha", $usuario->getSenha());
        $stmt->bindValue(":nivelAcesso", $usuario->getNivelAcesso());
        $stmt->bindValue(":setor", $usuario->getSetor());
        $stmt->bindValue(":situacao", $usuario->getSituacao());
        $stmt->bindValue(":id", $usuario->getIdUsuario());
        $stmt->execute();
        header("Location: index.php");
    }

    function deleteUsuario($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM usuario WHERE idUsuario = :id");
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        header("Location: index.php");
    }
?>