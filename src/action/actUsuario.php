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
        insertUsuario(buildUsuario(0, $_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['usuario'], $_POST['senha'], $_POST['nivelAcesso'], $_POST['setor'], $_POST['situacao']));
    } elseif ($acao == 'editar') {
        updateUsuario(buildUsuario($_POST['idUsuario'], $_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['usuario'], $_POST['senha'], $_POST['nivelAcesso'], $_POST['setor'], $_POST['situacao']));
    } elseif ($acao == 'situacao') {
        situationUsuario($_GET['idUsuario']);
    } elseif ($acao == 'editarPerfil') {
        updateUsuarioPerfil(buildUsuario($_POST['idUsuario'], $_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['login'], $_POST['senha'], 0, 0, 0));
    } elseif ($acao == 'editarPerfilCliente') {
        updateUsuarioPerfilCliente(buildUsuario($_POST['idUsuario'], $_POST['nome'], "", $_POST['email'], $_POST['login'], $_POST['senha'], 0, 0, 0));
    }

    function buildUsuario($idUsuario, $nome, $sobrenome, $email, $login, $senha, $nivelAcesso, $setor, $situacao)
    {
        return new usuario($idUsuario, $nome, $sobrenome, $email, $login, $senha, $nivelAcesso, $setor, $situacao);
    }

    function insertUsuario($usuario)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO usuario (nome, sobrenome, email, login, senha, nivelAcesso, setor, situacao) VALUES (:nome, :sobrenome, :email, :login, :senha, :nivelAcesso, :setor, :situacao)");
        $stmt->bindValue(":nome", $usuario->getNome());
        $stmt->bindValue(":sobrenome", $usuario->getSobrenome());
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":login", $usuario->getLogin());
        $stmt->bindValue(":senha", sha1($usuario->getSenha()));
        $stmt->bindValue(":nivelAcesso", $usuario->getNivelAcesso());
        $stmt->bindValue(":setor", $usuario->getSetor());
        $stmt->bindValue(":situacao", $usuario->getSituacao());
        $stmt->execute();
        if ($GLOBALS['acao'] != 'salvarC') {
            header("Location: ../usuarios.php");
        }
    }

    function updateUsuario($usuario)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE usuario SET nome = :nome, sobrenome = :sobrenome, email = :email, login = :login, senha = :senha, nivelAcesso = :nivelAcesso, setor = :setor, situacao = :situacao WHERE idUsuario = (:id)");
        $stmt->bindValue(":nome", $usuario->getNome());
        $stmt->bindValue(":sobrenome", $usuario->getSobrenome());
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":login", $usuario->getLogin());
        if ($usuario->getSenha() == "") {
            $stmt->bindValue(":senha", getSenhaUsuario($usuario->getIdUsuario())['senha']);
        } else {
            $stmt->bindValue(":senha", sha1($usuario->getSenha()));
        }
        $stmt->bindValue(":nivelAcesso", $usuario->getNivelAcesso());
        $stmt->bindValue(":setor", $usuario->getSetor());
        $stmt->bindValue(":situacao", $usuario->getSituacao());
        $stmt->bindValue(":id", $usuario->getIdUsuario());
        $stmt->execute();
        if ($GLOBALS['acao'] != 'editarC') {
            header("Location: ../usuarios.php");
        }
    }

    function situationUsuario($idUsuario)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT situacao FROM usuario WHERE idUsuario = :id");
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario['situacao'] == 1) {
            $stmt = $pdo->prepare("UPDATE usuario SET situacao = 0 WHERE idUsuario = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE usuario SET situacao = 1 WHERE idUsuario = :id");
        }
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        if ($GLOBALS['acao'] != 'situacaoC') {
            header("Location: ../usuarios.php");
        }
    }

    function insertUsuarioCliente($usuario)
    {
        insertUsuario($usuario);
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE login = :login");
        $stmt->bindValue(":login", $usuario->getLogin());
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateUsuarioCliente($usuario)
    {
        updateUsuario($usuario);
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE login = :login");
        $stmt->bindValue(":login", $usuario->getLogin());
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getSenhaUsuario($idUsuario)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT senha FROM usuario WHERE idUsuario = :id");
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateUsuarioPerfil($usuario)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE usuario SET nome = :nome, sobrenome = :sobrenome, email = :email, login = :login, senha = :senha WHERE idUsuario = (:id)");
        $stmt->bindValue(":nome", $usuario->getNome());
        $stmt->bindValue(":sobrenome", $usuario->getSobrenome());
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":login", $usuario->getLogin());
        if ($usuario->getSenha() == "") {
            $stmt->bindValue(":senha", getSenhaUsuario($usuario->getIdUsuario())['senha']);
        } else {
            $stmt->bindValue(":senha", sha1($usuario->getSenha()));
        }
        $stmt->bindValue(":id", $usuario->getIdUsuario());
        $stmt->execute();

        header("Location: ../index.php");
    }

    function updateUsuarioPerfilCliente($usuario)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE usuario SET nome = :nome, email = :email, login = :login, senha = :senha WHERE idUsuario = (:id)");
        $stmt->bindValue(":nome", $usuario->getNome());
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":login", $usuario->getLogin());
        if ($usuario->getSenha() == "") {
            $stmt->bindValue(":senha", getSenhaUsuario($usuario->getIdUsuario())['senha']);
        } else {
            $stmt->bindValue(":senha", sha1($usuario->getSenha()));
        }
        $stmt->bindValue(":id", $usuario->getIdUsuario());
        $stmt->execute();

        header("Location: ../cliente/homeCli.php");
    }
