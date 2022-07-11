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

    if ($acao == 'logar') {
        validaUsuario($_POST['usuario'], sha1($_POST['senha']));
    }

    function validaUsuario($login, $senha) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE login = :login AND senha = :senha AND situacao = 1");
        $stmt->bindValue(":login", $login);
        $stmt->bindValue(":senha", $senha);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($linha);
        if ($linha != false) {
            $usuario = new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
            inicializaSessao($usuario);
        } else {
            echo "<script>alert('Usuário ou senha inválidos.');</script>";
            echo "<script>window.location.href = '../index.php';</script>";
        }
    }

    function inicializaSessao($usuario) {
        session_start();
        $_SESSION['idUsuario'] = $usuario->getIdUsuario();
        $_SESSION['usuario'] = $usuario->getLogin();
        $_SESSION['nome'] = $usuario->getNome() . " " . $usuario->getSobrenome();
        $_SESSION['nivelAcesso'] = $usuario->getNivelAcesso();
        $_SESSION['setor'] = $usuario->getSetor();
        
        if ($usuario->getNivelAcesso() == 1) {
            header("Location: ../index.php");
        } else {
            header("Location: ../index.php");
        }
    }

?>
