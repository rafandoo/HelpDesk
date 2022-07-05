<?php
    require_once "../util/autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    $acao = "";

    switch($_SERVER['REQUEST_METHOD']) {
        case "GET":
            $acao = $_GET['acao'];
            break;
        case "POST":
            $acao = $_POST['acao'];
            break;
    }

    if ($acao == 'salvar') {
        insertCategoria(buildCategoria(0, $_POST['descricao'], $_POST['situacao']));
    } else if ($acao == 'excluir') {
        deleteCategoria($_GET['idCategoria']);
    } else if ($acao == 'editar') {
        updateCategoria(buildCategoria($_POST['idCategoria'], $_POST['descricao'], $_POST['situacao']));
    } else if ($acao == 'situacao') {
        situationCategoria($_GET['idCategoria']);
    }

    function buildCategoria($idCategoria, $descricao, $situacao) {
        return new Categoria($idCategoria, $descricao, $situacao);
    }

    function insertCategoria($categoria) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO categoria (descricao, situacao) VALUES (:descricao, :situacao)");
        $stmt->bindValue(':descricao', $categoria->getDescricao());
        $stmt->bindValue(':situacao', $categoria->getSituacao());
        $stmt->execute();
        header("Location: ../categorias.php");
    }

    function updateCategoria($categoria) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE categoria SET descricao = :descricao, situacao = :situacao WHERE idCategoria = :id");
        $stmt->bindValue(':descricao', $categoria->getDescricao());
        $stmt->bindValue(':situacao', $categoria->getSituacao());
        $stmt->bindValue(':id', $categoria->getId());
        $stmt->execute();
        header("Location: ../categorias.php");
    }

    function deleteCategoria($idCategoria) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM categoria WHERE idCategoria = :id");
        $stmt->bindValue(':id', $idCategoria);
        $stmt->execute();
    }

    function situationCategoria($idCategoria) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT situacao FROM categoria WHERE idCategoria = :id");
        $stmt->bindValue(':id', $idCategoria);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['situacao'] == 0) {
            $stmt = $pdo->prepare("UPDATE categoria SET situacao = 1 WHERE idCategoria = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE categoria SET situacao = 0 WHERE idCategoria = :id");
        }
        $stmt->bindValue(':id', $idCategoria);
        $stmt->execute();
        header("Location: ../categorias.php");
    }
?>