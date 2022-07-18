<!DOCTYPE html>
<?php
    include "validaSessao.php";
    require_once "util/autoload.php";
    require_once "config/Conexao.php";
    include_once "config/default.inc.php";

    $title = "Cadastro de CLientes";

    if ($_SESSION['nivelAcesso'] == 1) {
        header("Location: cliente/homeCli.php");
    }

    $acao = isset($_GET["acao"]) ? $_GET["acao"] : "";

    function getCliente($idCliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM cliente WHERE idCliente = :idCliente");
        $stmt->bindValue(":idCliente", $idCliente);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new cliente($linha['idCliente'], $linha['nome'], $linha['nomeFantasia'], $linha['cpfCnpj'], $linha['endereco'], $linha['numero'], $linha['bairro'], getCidadeCliente($linha['cidade']), $linha['email'], $linha['telefone'], $linha['observacoes'], getUsuarioCliente($linha['idUsuario']), $linha['situacao']);
    }

    function getUsuarioCliente($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE idUsuario = :idUsuario");
        $stmt->bindValue(":idUsuario", $idUsuario);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
    }

    function getCidadeCliente($idCidade) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM cidade WHERE idCidade = :idCidade");
        $stmt->bindValue(":idCidade", $idCidade);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new cidade($linha['idCidade'], $linha['nome'], $linha['idEstado']);
    }

    if ($acao == "alterarC") {
        $value = "editarC";
        $cliente = getCliente($_GET['idCliente']);
        $idCliente = $cliente->getIdCliente();
        $nome = $cliente->getNome();
        $nomeFantasia = $cliente->getNomeFantasia();
        $cpfCnpj = $cliente->getCpfCnpj();
        $endereco = $cliente->getEndereco();
        $numero = $cliente->getNumero();
        $bairro = $cliente->getBairro();
        $cidade = $cliente->getCidade();
        $idEstado = $cidade->getIdEstado();
        $email = $cliente->getEmail();
        $telefone = $cliente->getTelefone();
        $observacoes = $cliente->getObservacoes();
        $usuario = $cliente->getUsuario();
        $idUsuario = $usuario->getIdUsuario();
        $login = $usuario->getLogin();
        $situacao = $cliente->getSituacao();
    } else {
        $value = "salvarC";
        $idCliente = 0;
        $idUsuario = 0;
        $nome = "";
        $nomeFantasia = "";
        $cpfCnpj = "";
        $endereco = "";
        $numero = "";
        $bairro = "";
        $cidade = "";
        $email = "";
        $telefone = "";
        $observacoes = "";
        $situacao = "";
        $login = "";
    }
?>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $title;?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Nunito.css">
    <link rel="stylesheet" href="assets/css/summernote.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/bg-gradient.css">
    <link rel="stylesheet" href="assets/css/Clients-UI.css">
    <link rel="stylesheet" href="assets/css/summernote-bs5.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon"><img src="assets/img/logo/foxIcoB.png" style="width: 50px;"></div>
                    <div class="sidebar-brand-text mx-3"><span>help desk</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home"></i><span>Home</span></a></li>
                    <li class="nav-item">
                        <div><a data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-3" href="#collapse-3" role="button" class="nav-link"><i class="fas fa-tasks"></i>&nbsp;<span>Atendimentos</span></a>
                            <div class="collapse" id="collapse-3">
                                <div class="bg-white border rounded collapse-inner"><a class="collapse-item" href="cadTickets.php">Novo chamado</a><a class="collapse-item" href="filaAtendimentos.php">Minha fila</a><a class="collapse-item" href="filaPendentes.php">Pendentes</a></div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div><a data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-1" href="#collapse-1" role="button" class="nav-link"><i class="fas fa-user"></i>&nbsp;<span>Cadastros</span></a>
                            <div class="collapse" id="collapse-1">
                                <div class="bg-white border rounded collapse-inner"><a class="collapse-item" href="clientes.php">Clientes</a><a class="collapse-item" href="usuarios.php">Usuários</a><a class="collapse-item" href="categorias.php">Categorias</a><a class="collapse-item" href="setores.php">Setores</a></div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div><a data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-2" href="#collapse-2" role="button" class="nav-link"><i class="fas fa-chart-bar"></i>&nbsp;<span>Gerencial</span></a>
                            <div class="collapse" id="collapse-2">
                                <div class="bg-white border rounded collapse-inner"><a class="collapse-item" href="404.php">Dashboard</a><a class="collapse-item" href="relatorios.php">Relatórios</a></div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-arrow-circle-left"></i><span>&nbsp;Sair</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group" hidden><input class="bg-light form-control border-0 small" type="text" placeholder="Buscar chamado"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1"></li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php echo $_SESSION['nome']?></span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar5.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="perfil.php?idUsuario=<?=$_SESSION['idUsuario']?>"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Perfil</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Cadastro de cliente</h3>
                    <div class="row mb-3">
                        <div class="col-11">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="fs-4 text-primary m-0 fw-bold">Dados do cliente</p>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="action/actCliente.php">
                                                <div class="row">
                                                <input type="hidden" id="idCliente" name="idCliente" value="<?php echo $idCliente;?>">
                                                <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $idUsuario;?>">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="nome"><strong>Nome</strong></label>
                                                            <input class="form-control" type="text" id="nome" name="nome" required="" minlength="2" value="<?php echo $nome;?>">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="nomeFantasia"><strong>Nome Fantasia</strong><br></label>
                                                            <input class="form-control" type="text" id="nomeFantasia" name="nomeFantasia" value="<?php echo $nomeFantasia;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="cpfCnpj"><strong>CPF/CNPJ</strong><br></label>
                                                            <input class="form-control" type="text" id="cpfCnpj" placeholder="00.000.000/0001-00" name="cpfCnpj" required="" minlength="11" value="<?php echo $cpfCnpj;?>" onchange="callValidarPHP('cpfCnpj', formatarCpfCnpj(this.value), this)" <?php if ($acao == 'alterarC') echo 'readonly'?>>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="telefone"><strong>Telefone</strong><br></label>
                                                            <input class="form-control" type="text" id="telefone" placeholder="(47) 90000-0000" name="telefone" value="<?php echo $telefone;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-5">
                                                        <div class="mb-3"><label class="form-label" for="endereco"><strong>Endereço</strong><br></label>
                                                            <input class="form-control" type="text" id="endereco" name="endereco" required="" value="<?php echo $endereco;?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="mb-3"><label class="form-label" for="numero"><strong>Número</strong><br></label>
                                                            <input class="form-control" type="text" id="numero" name="numero" required="" value="<?php echo $numero;?>">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="bairro"><strong>Bairro</strong><br></label>
                                                            <input class="form-control" type="text" id="bairro" name="bairro" required="" value="<?php echo $bairro;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="estado"><strong>Estado</strong><br></label>
                                                            <select class="form-select" id="estado" required="" name="estado">
                                                                <option value="" selected>Selecione uma opção</option>
                                                                <?php
                                                                    $pdo = Conexao::getInstance();
                                                                    $consulta = $pdo->query("SELECT * FROM estado");
                                                                    while($linhaEstado = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                        $estado = new estado($linhaEstado['idEstado'], $linhaEstado['nome'], $linhaEstado['sigla']);
                                                                        if($estado->getIdEstado() == $idEstado) {
                                                                            echo "<option value='".$estado->getIdEstado()."' selected>".$estado->getNome()."</option>";
                                                                        } else {
                                                                            echo '<option value="'.$estado->getIdEstado().'">'.$estado->getNome().'</option>';
                                                                        }
                                                                    }
                                                                ?>
                                                            </select></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="cidade"><strong>Cidade</strong><br></label>
                                                            <select class="form-select" id="cidade" required="" name="cidade">
                                                                <option value="">Selecione um estado</option>
                                                                <?php 
                                                                    if ($acao == 'alterarC') {
                                                                        echo '<option value="'.$cidade->getIdCidade().'" selected>'.$cidade->getNome().'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="usuario"><strong>Usuário</strong></label>
                                                            <div class="input-group"><span class="input-group-text">@</span>
                                                                <input class="form-control" type="text" id="usuario" placeholder="user.name" name="usuario" required="" minlength="3" value="<?php echo $login;?>" onchange="callValidarPHP('login', this.value, this, <?=$idUsuario?>)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="email"><strong>E-mail</strong></label>
                                                            <input class="form-control" type="email" id="email" placeholder="user@example.com" name="email" required="" value="<?php echo $email;?>" onchange="callValidarPHP('email', this.value, this, <?=$idUsuario?>)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="senha"><strong>Senha</strong><br></label><input class="form-control" type="password" id="senha" name="senha" placeholder="*******" <?php if ($acao != 'alterarC') echo 'required';?> minlength="8"></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="confirmarSenha"><strong>Confirmar senha</strong><br></label><input class="form-control" type="password" id="confirmarSenha" placeholder="*******" name="confirmarSenha" <?php if ($acao != 'alterarC') echo 'required';?> oninput="validaSenha(this)" minlength="8"></div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="observacoes"><strong>Observações</strong><br></label>
                                                            <textarea class="form-control" id="observacoes" name="observacoes" rows="3"><?php echo $observacoes;?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="situacao"><strong>Situação</strong><br></label>
                                                            <select class="form-select" id="situacao" required="" name="situacao">
                                                                <?php 
                                                                    if ($situacao == 0) {
                                                                        echo '<option value="1" >Ativo</option>';
                                                                        echo '<option value="0" selected>Inativo</option>';
                                                                    } else {
                                                                        echo '<option value="1" selected>Ativo</option>';
                                                                        echo '<option value="0">Inativo</option>';
                                                                    }
                                                                ?>
                                                            </select></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3"><button class="btn btn-primary" type="submit" name="acao" value="<?php echo $value;?>">Salvar</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><a href="https://github.com/rafandoo" style="color: #000000;"><span style="color: rgb(133,135,150);font-weight: bold;"><br>Copyright © Rafael Camargo 2022<br><br></span></a></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/summernote-bs5.min.js"></script>
    <script src="assets/js/summernote.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/todo.js"></script>
    <script src="assets/js/buscaCidades.js"></script> 
    <script src="assets/js/validar.js"></script>
    <script src="assets/js/formatar.js"></script>
</body>

</html>