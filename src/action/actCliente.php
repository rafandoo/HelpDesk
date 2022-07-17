<?php
    require_once "../util/autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";
    include_once "actUsuario.php";
    
    $acao = "";

    switch($_SERVER['REQUEST_METHOD']) {
        case "GET":
            $acao = $_GET['acao'];
            break;
        case "POST":
            $acao = $_POST['acao'];
            break;
    }

    if ($acao == 'salvarC') {
        $usuario = insertUsuarioCliente(buildUsuario(0, $_POST['nome'], "", $_POST['email'], $_POST['usuario'], $_POST['senha'], 1, 0, $_POST['situacao']));
        insertCliente(buildCliente(0, $_POST['nome'], $_POST['nomeFantasia'], $_POST['cpfCnpj'], $_POST['endereco'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['email'], $_POST['telefone'], $_POST['observacoes'],$usuario, $_POST['situacao']));
    } else if ($acao == 'editarC') {
        $usuario = updateUsuarioCliente(buildUsuario($_POST['idUsuario'], $_POST['nome'], "", $_POST['email'], $_POST['usuario'], $_POST['senha'], 1, 0, $_POST['situacao']));
        updateCliente(buildCliente($_POST['idCliente'], $_POST['nome'], $_POST['nomeFantasia'], $_POST['cpfCnpj'], $_POST['endereco'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['email'], $_POST['telefone'], $_POST['observacoes'], $usuario, $_POST['situacao']));
    } else if ($acao == 'situacaoC') {
        situationCliente($_GET['idCliente']);
    }

    /**
     * It creates a new cliente object.
     * 
     * @param idCliente int
     * @param nome string
     * @param nomeFantasia "teste"
     * @param cpfCnpj 11111111111
     * @param endereco Street
     * @param numero number
     * @param bairro neighborhood
     * @param cidade city
     * @param email email@email.com
     * @param telefone (11) 11111-1111
     * @param observacoes text
     * @param usuario is the user that is logged in
     * @param situacao 1 = active, 0 = inactive
     * 
     * @return A new instance of the class cliente.
     */
    function buildCliente($idCliente, $nome, $nomeFantasia, $cpfCnpj, $endereco, $numero, $bairro, $cidade, $email, $telefone, $observacoes, $usuario, $situacao) {
        return new cliente($idCliente, $nome, $nomeFantasia, $cpfCnpj, $endereco, $numero, $bairro, $cidade, $email, $telefone, $observacoes, $usuario, $situacao);
    }

    /**
     * It inserts a client into the database.
     * 
     * @param cliente 
     */
    function insertCliente($cliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("INSERT INTO cliente (nome, nomeFantasia, cpfCnpj, endereco, numero, bairro, cidade, email, telefone, observacoes, idUsuario, situacao) VALUES (:nome, :nomeFantasia, :cpfCnpj, :endereco, :numero, :bairro, :cidade, :email, :telefone, :observacoes, :idUsuario, :situacao)");
        $stmt->bindValue(':nome', $cliente->getNome());
        $stmt->bindValue(':nomeFantasia', $cliente->getNomeFantasia());
        $stmt->bindValue(':cpfCnpj', $cliente->getCpfCnpj());
        $stmt->bindValue(':endereco', $cliente->getEndereco());
        $stmt->bindValue(':numero', $cliente->getNumero());
        $stmt->bindValue(':bairro', $cliente->getBairro());
        $stmt->bindValue(':cidade', intval($cliente->getCidade()));
        $stmt->bindValue(':email', $cliente->getEmail());
        $stmt->bindValue(':telefone', $cliente->getTelefone());
        $stmt->bindValue(':observacoes', $cliente->getObservacoes());
        $usuario = $cliente->getUsuario();
        $stmt->bindValue(':idUsuario', $usuario['idUsuario']);
        $stmt->bindValue(':situacao', $cliente->getSituacao());
        $stmt->execute();
        header("Location: ../clientes.php");
    }

    /**
     * It updates a cliente (client) in the database.
     * 
     * @param cliente 
     */
    function updateCliente($cliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("UPDATE cliente SET nome = :nome, nomeFantasia = :nomeFantasia, endereco = :endereco, numero = :numero, bairro = :bairro, cidade = :cidade, email = :email, telefone = :telefone, observacoes = :observacoes, idUsuario = :idUsuario, situacao = :situacao WHERE idCliente = :id");
        $stmt->bindValue(':nome', $cliente->getNome());
        $stmt->bindValue(':nomeFantasia', $cliente->getNomeFantasia());
        $stmt->bindValue(':endereco', $cliente->getEndereco());
        $stmt->bindValue(':numero', $cliente->getNumero());
        $stmt->bindValue(':bairro', $cliente->getBairro());
        $stmt->bindValue(':cidade', $cliente->getCidade());
        $stmt->bindValue(':email', $cliente->getEmail());
        $stmt->bindValue(':telefone', $cliente->getTelefone());
        $stmt->bindValue(':observacoes', $cliente->getObservacoes());
        $usuario = $cliente->getUsuario();
        $stmt->bindValue(':idUsuario', $usuario['idUsuario']);
        $stmt->bindValue(':situacao', $cliente->getSituacao());
        $stmt->bindValue(':id', $cliente->getIdCliente());
        $stmt->execute();
        header("Location: ../clientes.php");
    }

    /**
     * It takes an id, checks if the row with that id has a 0 or 1 in the 'situacao' column, and then
     * updates the row with the opposite value.
     * 
     * @param idCliente The id of the client
     */
    function situationCliente($idCliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT situacao, idUsuario FROM cliente WHERE idCliente = :id");
        $stmt->bindValue(':id', $idCliente);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario['situacao'] == 1) {
            $stmt = $pdo->prepare("UPDATE cliente SET situacao = 0 WHERE idCliente = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE cliente SET situacao = 1 WHERE idCliente = :id");
        }
        $stmt->bindValue(':id', $idCliente);
        $stmt->execute();
        situationUsuario($usuario['idUsuario']);
        header("Location: ../clientes.php");
    }
?>