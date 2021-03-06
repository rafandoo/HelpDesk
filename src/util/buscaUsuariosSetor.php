<?php
    /* It's a PHP code that is getting the data from the database and returning it to the ajax call. */
    require_once "autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";
    
    $idSetor = isset($_POST["idSetor"]) ? $_POST["idSetor"] : 0;
    
    $pdo = Conexao::getInstance();
    $consulta = $pdo->query("SELECT * FROM usuario WHERE setor = $idSetor AND situacao = 1 ORDER BY nome");
    echo "<option value=''>Selecione uma opção</option>";
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $usuario = new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
        echo "<option value='".$usuario->getIdUsuario()."'>".$usuario->getNome()."</option>";
    }
?>