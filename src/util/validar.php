<?php

    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    $acao = isset($_POST["acao"]) ? $_POST["acao"] : "";
    $id = isset($_POST["id"]) ? $_POST["id"] : 0;

    if ($acao == 'email') {
        if ($id == 0) {
            echo existeEmailUsuario($_POST['valor'], 0);
        } else {
            echo existeEmailUsuario($_POST['valor'], $id);
        }
    } elseif ($acao == 'login') {
        if ($id == 0) {
            echo existeLoginUsuario($_POST['valor'], 0);
        } else {
            echo existeLoginUsuario($_POST['valor'], $id);
        }
    } elseif ($acao == 'cpfCnpj') {
        echo existeCpfCnpj($_POST['valor']);
    }

    function existeEmailUsuario($email, $id)
    {
        $count = 0;
        $pdo = Conexao::getInstance();

        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email AND idUsuario != :id");
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $count += $stmt->rowCount();

        if ($count == 0) {
            return false;
        } else {
            return true;
        }
    }

    function existeLoginUsuario($login, $id)
    {
        $count = 0;
        $pdo = Conexao::getInstance();

        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE login = :login AND idUsuario != :id");
        $stmt->bindValue(":login", $login);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $count += $stmt->rowCount();

        if ($count == 0) {
            return false;
        } else {
            return true;
        }
    }

    function existeCpfCnpj($cpfCnpj)
    {
        $count = 0;
        $pdo = Conexao::getInstance();

        $stmt = $pdo->prepare("SELECT * FROM cliente WHERE cpfCnpj = :cpfCnpj");
        $stmt->bindValue(":cpfCnpj", $cpfCnpj);
        $stmt->execute();
        $count += $stmt->rowCount();

        if ($count == 0) {
            return false;
        } else {
            return true;
        }
    }
