<?php
    require_once "util/autoload.php";

    $acao = "";

    switch($_SERVER['REQUEST_METHOD']) {
        case "GET":
            $acao = $_GET['acao'];
            break;
        case "POST":
            $acao = $_POST['acao'];
            break;
    }

    if ($acao = 'salvar') {
        insertCategoria(buildCategoria(0, $_POST['descricao'], $_POST['situacao']));
    } else if ($acao = 'excluir') {
        deleteCategoria($_GET['idCategoria']);
    } else if ($acao = 'editar') {
        updateCategoria(buildCategoria($_POST['idCategoria'], $_POST['descricao'], $_POST['situacao']));
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
        header('Location: index.php');
    }

    function updateCategoria($categoria) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE categoria SET descricao = :descricao, situacao = :situacao WHERE idCategoria = :id");
        $stmt->bindValue(':descricao', $categoria->getDescricao());
        $stmt->bindValue(':situacao', $categoria->getSituacao());
        $stmt->bindValue(':id', $categoria->getIdCategoria());
        $stmt->execute();
        header('Location: index.php');
    }

    function deleteCategoria($idCategoria) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM categoria WHERE idCategoria = :id");
        $stmt->bindValue(':id', $idCategoria);
        $stmt->execute();
        header('Location: index.php');
    }
?>