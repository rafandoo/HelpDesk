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
        insertCliente(buildCliente(0, $_POST['nome'], $_POST['nomeFantasia'], $_POST['cpfCnpj'], $_POST['endereco'], $_POST['cidade'], $_POST['email'], $_POST['telefone'], $_POST['observacoes'], $_POST['idUsuario'], $_POST['situacao']));
    } else if ($acao = 'excluir') {
        deleteCliente($_GET['idCliente']);
    } else if ($acao = 'editar') {
        updateCliente(buildCliente($_POST['idCliente'], $_POST['nome'], $_POST['nomeFantasia'], $_POST['cpfCnpj'], $_POST['endereco'], $_POST['cidade'], $_POST['email'], $_POST['telefone'], $_POST['observacoes'], $_POST['idUsuario'], $_POST['situacao']));
    }

    function buildCliente($idCliente, $nome, $nomeFantasia, $cpfCnpj, $endereco, $cidade, $email, $telefone, $observacoes, $idUsuario, $situacao) {
        return new Cliente($idCliente, $nome, $nomeFantasia, $cpfCnpj, $endereco, $cidade, $email, $telefone, $observacoes, $idUsuario, $situacao);
    }

    function insertCliente($cliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO cliente (nome, nomeFantasia, cpfCnpj, endereco, cidade, email, telefone, observacoes, idUsuario, situacao) VALUES (:nome, :nomeFantasia, :cpfCnpj, :endereco, :cidade, :email, :telefone, :observacoes, :idUsuario, :situacao)");
        $stmt->bindValue(':nome', $cliente->getNome());
        $stmt->bindValue(':nomeFantasia', $cliente->getNomeFantasia());
        $stmt->bindValue(':cpfCnpj', $cliente->getCpfCnpj());
        $stmt->bindValue(':endereco', $cliente->getEndereco());
        $stmt->bindValue(':cidade', $cliente->getCidade());
        $stmt->bindValue(':email', $cliente->getEmail());
        $stmt->bindValue(':telefone', $cliente->getTelefone());
        $stmt->bindValue(':observacoes', $cliente->getObservacoes());
        $stmt->bindValue(':idUsuario', $cliente->getIdUsuario());
        $stmt->bindValue(':situacao', $cliente->getSituacao());
        $stmt->execute();
        header('Location: index.php');
    }

    function updateCliente($cliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE cliente SET nome = :nome, nomeFantasia = :nomeFantasia, cpfCnpj = :cpfCnpj, endereco = :endereco, cidade = :cidade, email = :email, telefone = :telefone, observacoes = :observacoes, idUsuario = :idUsuario, situacao = :situacao WHERE idCliente = :id");
        $stmt->bindValue(':nome', $cliente->getNome());
        $stmt->bindValue(':nomeFantasia', $cliente->getNomeFantasia());
        $stmt->bindValue(':cpfCnpj', $cliente->getCpfCnpj());
        $stmt->bindValue(':endereco', $cliente->getEndereco());
        $stmt->bindValue(':cidade', $cliente->getCidade());
        $stmt->bindValue(':email', $cliente->getEmail());
        $stmt->bindValue(':telefone', $cliente->getTelefone());
        $stmt->bindValue(':observacoes', $cliente->getObservacoes());
        $stmt->bindValue(':idUsuario', $cliente->getIdUsuario());
        $stmt->bindValue(':situacao', $cliente->getSituacao());
        $stmt->bindValue(':id', $cliente->getIdCliente());
        $stmt->execute();
        header('Location: index.php');
    }

    function deleteCliente($idCliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("DELETE FROM cliente WHERE idCliente = :id");
        $stmt->bindValue(':id', $idCliente);
        $stmt->execute();
        header('Location: index.php');
    }
?>