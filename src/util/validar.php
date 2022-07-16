<?php
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    $acao = isset($_POST["acao"]) ? $_POST["acao"] : "";
    $idUsuario = isset($_POST["id"]) ? $_POST["id"] : 0;

    if ($acao == 'email') {
        if ($idUsuario == 0) {
            echo existeEmailUsuario($_POST['valor'], 0);
        } else {
            echo existeEmailUsuario($_POST['valor'], $idUsuario);
        }
    } else if ($acao == 'login') {
        if ($idUsuario == 0) {
            echo existeLoginUsuario($_POST['valor'], 0);
        } else {
            echo existeLoginUsuario($_POST['valor'], $idUsuario);
        }
    } else if ($acao == 'cpfCnpj') {
        echo existeCpfCnpj($_POST['valor']);
    }

    /**
     * It checks if the email exists in the database, but it doesn't count the current user.
     * 
     * @param email teste@teste.com
     * @param id 1
     * 
     * @return a boolean value.
     */
    function existeEmailUsuario($email, $idUsuario) {
        $count = 0;
        $pdo = Conexao::getInstance();

        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email AND idUsuario != :id");
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        $count += $stmt->rowCount();
        
        if ($count == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * If the login exists in the database, return true, otherwise return false, but it doesn't count the current user.
     * 
     * @param login the login of the user
     * @param id 1
     * 
     * @return a boolean value.
     */
    function existeLoginUsuario($login, $id) {
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

    /**
     * It checks if a given CPF/CNPJ exists in the database
     * 
     * @param cpfCnpj 12345678910
     * 
     * @return The number of rows that match the query.
     */
    function existeCpfCnpj($cpfCnpj) {
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
?>