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

    /**
     * It creates a new object of the class "categoria" and returns it.
     * 
     * @param idCategoria int
     * @param descricao string
     * @param situacao 1 = active, 0 = inactive
     * 
     * @return a new instance of the class categoria.
     */
    function buildCategoria($idCategoria, $descricao, $situacao) {
        return new categoria($idCategoria, $descricao, $situacao);
    }

    /**
     * It inserts a new category into the database.
     * 
     * @param categoria object
     */
    function insertCategoria($categoria) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO categoria (descricao, situacao) VALUES (:descricao, :situacao)");
        $stmt->bindValue(':descricao', $categoria->getDescricao());
        $stmt->bindValue(':situacao', $categoria->getSituacao());
        $stmt->execute();
        header("Location: ../categorias.php");
    }

    /**
     * It updates a row in the database with the values of the object passed as parameter.
     * 
     * @param categoria object
     */
    function updateCategoria($categoria) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE categoria SET descricao = :descricao, situacao = :situacao WHERE idCategoria = :id");
        $stmt->bindValue(':descricao', $categoria->getDescricao());
        $stmt->bindValue(':situacao', $categoria->getSituacao());
        $stmt->bindValue(':id', $categoria->getId());
        $stmt->execute();
        header("Location: ../categorias.php");
    }

    /**
     * It deletes a row from the database table 'categoria' where the idCategoria column matches the
     * idCategoria parameter.
     * 
     * @param idCategoria int(11)
     */
    function deleteCategoria($idCategoria) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM categoria WHERE idCategoria = :id");
        $stmt->bindValue(':id', $idCategoria);
        $stmt->execute();
    }

    /**
     * It takes an id, checks if the row with that id has a 0 or 1 in the 'situacao' column, and then
     * updates the row with the opposite value.
     * 
     * @param idCategoria 1
     */
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