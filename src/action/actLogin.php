<?php
    require_once "../util/autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    $acao = "";

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            $acao = $_GET["acao"];
            break;
        case "POST":
            $acao = $_POST["acao"];
            break;
    }

    if ($acao === 'logar') {
        validaUsuario($_POST['usuario'], $_POST['senha']);
    }

/**
 * It takes a plain text password and a hash and returns true if the password matches the hash, false
 * otherwise.
 * 
 * @param senha The password to verify.
 * @param hash The hash created by password_hash()
 * 
 * @return a boolean value.
 */
    function validaSenha($senha, $hash) {
        if (password_verify($senha, $hash)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * It validates the user and password, and if it's correct, it starts the session.
     * 
     * @param login admin
     * @param senha y$/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X/X
     */
    function validaUsuario($login, $senha) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE login = :login AND situacao = 1");
        $stmt->bindValue(":login", $login);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($linha != false) {
            $usuario = new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
            if (validaSenha($senha, $usuario->getSenha())) {
                    inicializaSessao($usuario);
            }
        }
        echo "<script>alert('Usuário ou senha inválidos.');</script>";
        echo "<script>window.location.href = '../index.php';</script>";
    }

    /**
     * It starts a session, sets some session variables, and then redirects the user to a different page.
     * 
     * @param usuario is the user's object.
     */
    function inicializaSessao($usuario) {
        session_start();
        $_SESSION['idUsuario'] = $usuario->getIdUsuario();
        $_SESSION['usuario'] = $usuario->getLogin();
        $_SESSION['nome'] = $usuario->getNome() . " " . $usuario->getSobrenome();
        $_SESSION['nivelAcesso'] = $usuario->getNivelAcesso();
        $_SESSION['setor'] = $usuario->getSetor();
        
        if ($usuario->getNivelAcesso() === 1) {
            header("Location: ../cliente/homeCli.php");
        } else {
            header("Location: ../index.php");
        }
    }

?>
