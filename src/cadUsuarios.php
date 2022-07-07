<!DOCTYPE html>
<?php
    require_once "util/autoload.php";
    require_once "config/Conexao.php";
    include_once "config/default.inc.php";

    $title = "Cadastro de usuários - HelpDesk";

    $acao = isset($_GET["acao"]) ? $_GET["acao"] : "";

    function getSetores() {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM setor");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getNiveisAcesso() {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM nivelAcesso");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getUsuario($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE idUsuario = :id");
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new usuario($linha["idUsuario"], $linha["nome"], $linha["sobrenome"], $linha["email"], $linha["login"], $linha["senha"], $linha["nivelAcesso"], $linha["setor"], $linha["situacao"]);
    }

    if ($acao == "alterar") {
        $value = "editar";
        $usuario = getUsuario($_GET["idUsuario"]);
        $idUsuario = $usuario->getIdUsuario();
        $nome = $usuario->getNome();
        $sobrenome = $usuario->getSobrenome();
        $email = $usuario->getEmail();
        $login = $usuario->getLogin();
        $senha = $usuario->getSenha();
        $idNivelAcesso = $usuario->getNivelAcesso();
        $idSetor = $usuario->getSetor();
        $situacao = $usuario->getSituacao();
    } else {
        $value = "salvar";
        $idUsuario = 0;
        $nome = "";
        $sobrenome = "";
        $email = "";
        $login = "";
        $senha = "";
        $idNivelAcesso = "";
        $idSetor = "";
        $situacao = "";
    }

?>

<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
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
                                <div class="bg-white border rounded collapse-inner"><a class="collapse-item" href="#">Dashboard</a><a class="collapse-item" href="#">Relatórios</a></div>
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
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Buscar chamado"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
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
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">Username</span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar5.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="perfil.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Perfil</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Cadastro de usuário</h3>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="assets/img/dogs/image2.jpeg" width="160" height="160">
                                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button">Mudar foto</button></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="fs-4 text-primary m-0 fw-bold">Dados do perfil</p>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="action/actUsuario.php">
                                                <div class="row">
                                                    <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $idUsuario;?>">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="usuario"><strong>Usuário</strong></label>
                                                            <div class="input-group"><span class="input-group-text">@</span><input class="form-control" type="text" id="usuario" placeholder="user.name" name="usuario" required minlength="3" value="<?php echo $login;?>" <?php if ($acao != 'alterar') echo 'onchange="callValidarPHP(\'login\', this.value, this)"'; else echo 'onchange="callValidarPHPAlterar(\'login\', this.value,'.$idUsuario.', this)"';?>></div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="email"><strong>E-mail</strong></label>
                                                            <input class="form-control" type="email" id="email" placeholder="user@example.com" name="email" required value="<?php echo $email;?>" <?php if ($acao != 'alterar') echo 'onchange="callValidarPHP(\'email\', this.value, this)"'; else echo 'onchange="callValidarPHPAlterar(\'email\', this.value,'.$idUsuario.', this)"';?>>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="nome"><strong>Nome</strong></label><input class="form-control" type="text" id="nome" placeholder="John" name="nome" required minlength="2" value="<?php echo $nome;?>"></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="sobrenome"><strong>Sobrenome</strong><br></label><input class="form-control" type="text" id="sobrenome" placeholder="Doe" name="sobrenome" value="<?php echo $sobrenome;?>"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="senha"><strong>Senha</strong><br></label>
                                                            <input class="form-control" type="password" id="senha" name="senha" placeholder="*******" <?php if ($acao != 'alterar') echo 'required';?> minlength="8">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="confirmarSenha"><strong>Confirmar senha</strong><br></label>
                                                            <input class="form-control" type="password" id="confirmarSenha" placeholder="*******" name="confirmarSenha" <?php if ($acao != 'alterar') echo 'required';?> oninput="validaSenha(this)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="setor"><strong>Setor</strong><br></label>
                                                            <select class="form-select" id="setor" required name="setor">
                                                                <?php
                                                                    $pdo = Conexao::getInstance();
                                                                    $consulta = $pdo->query("SELECT * FROM setor WHERE situacao = 1");
                                                                    while ($linhaSetor = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                                                        $setor = new setor($linhaSetor['idSetor'], $linhaSetor['descricao'], $linhaSetor['situacao']);
                                                                        if ($setor->getId() == $idSetor) {
                                                                            echo '<option value="'.$setor->getId().'" selected="">'.$setor->getDescricao().'</option>';
                                                                        } else {
                                                                            echo '<option value="'.$setor->getId().'">'.$setor->getDescricao().'</option>';
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="nivelAcesso"><strong>Nível&nbsp;de acesso</strong><br></label>
                                                            <select class="form-select" id="nivelAcesso" required name="nivelAcesso">
                                                                <?php
                                                                    $pdo = Conexao::getInstance();
                                                                    $consulta = $pdo->query("SELECT * FROM nivelAcesso WHERE idNivelAcesso != 1");
                                                                    while ($linhaNivelAcesso = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                                                        $nivelAcesso = new nivelAcesso($linhaNivelAcesso['idNivelAcesso'], $linhaNivelAcesso['nome']);
                                                                        if ($nivelAcesso->getIdNivelAcesso() == $idNivelAcesso) {
                                                                            echo '<option value="'.$nivelAcesso->getIdNivelAcesso().'" selected="">'.$nivelAcesso->getNome().'</option>';
                                                                        } else {
                                                                            echo '<option value="'.$nivelAcesso->getIdNivelAcesso().'">'.$nivelAcesso->getNome().'</option>';
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="situacao"><strong>Situação</strong><br></label><select class="form-select" id="situacao" required name="situacao">
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
                                                <div class="mb-3"><button class="btn btn-primary" type="submit" name="acao" value="<?php echo $value; ?>">Salvar</button></div>
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
    <script src="assets/js/validar.js"></script>

</body>

</html>