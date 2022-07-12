<!DOCTYPE html>
<?php
    include "../validaSessao.php";
    require_once "../util/autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    function getUsuarios($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE idUsuario = :idUsuario");
        $stmt->bindValue(":idUsuario", $idUsuario);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
    }

    function getClientes($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM cliente WHERE idUsuario = :id");
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new cliente($linha['idCliente'], $linha['nome'], $linha['nomeFantasia'], $linha['cpfCnpj'], $linha['endereco'], $linha['numero'], $linha['bairro'], $linha['cidade'], $linha['email'], $linha['telefone'], $linha['observacoes'], $linha['idUsuario'], $linha['situacao']);
    }

    $title = "Cadastro de chamados";

    $dataAbertura = date('Y-m-d').'T'.date('H:i');
?>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $title;?></title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="../assets/css/summernote.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/css/bg-gradient.css">
    <link rel="stylesheet" href="../assets/css/Clients-UI.css">
    <link rel="stylesheet" href="../assets/css/summernote-bs5.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon"><img src="../assets/img/logo/foxIcoB.png" style="width: 50px;"></div>
                    <div class="sidebar-brand-text mx-3"><span>help desk</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="homeCli.php"><i class="fas fa-home"></i><span>Home</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="ticketCli.php"><i class="fas fa-plus-square"></i><span>Novo Chamado</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="..\logout.php"><i class="fas fa-arrow-circle-left"></i><span>&nbsp;Sair</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
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
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php echo $_SESSION['nome']?></span><img class="border rounded-circle img-profile" src="../assets/img/avatars/avatar5.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="perfilCli.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Perfil</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="..\logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Abrir novo ticket</h3>
                    <div class="row mb-3">
                        <div class="col-11 col-xl-12 col-xxl-11 offset-xl-0">
                            <div class="row">
                                <div class="col-xl-12 col-xxl-10">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <div class="row d-flex">
                                                <div class="w-100"></div>
                                                <div class="col d-xxl-flex align-items-xxl-center">
                                                    <p class="fs-5 text-primary m-0 fw-bold">Informações do chamado</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-top: 0px;">
                                            <form method="post" action="..\action\actTicket.php">
                                                <div class="row">
                                                    <input type="hidden" name="cliente" value="<?php echo getClientes($_SESSION['idUsuario'])->getIdCliente();?>">
                                                    <div class="col-xl-4 col-xxl-3">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">N° Ticket #</span><input class="bg-white form-control" type="text" id="idTicket" readonly="" name="idTicket"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-xxl-5">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Data de abertura</span><input class="bg-white form-control" id="dataAbertura" readonly="" type="datetime-local" name="dataAbertura" value="<?php echo $dataAbertura;?>"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Contato</span><input class="form-control" type="text" id="contato" required="" name="contato"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-5 col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Setor</span><select class="form-select" id="setor" required="" name="setor">
                                                                    <option value="">Selecione uma opção</option>
                                                                    <?php
                                                                        $pdo = Conexao::getInstance(); 
                                                                        $consulta = $pdo->query("SELECT * FROM setor WHERE situacao = 1");
                                                                        while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                            $setor = new setor($linha['idSetor'], $linha['descricao'], $linha['situacao']);
                                                                            echo '<option value="'.$setor->getId().'">'.$setor->getDescricao().'</option>';
                                                                        }
                                                                    ?>
                                                                </select></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-5 col-xxl-5">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Categoria</span><select class="form-select" id="categoria" required="" name="categoria">
                                                                    <option value="">Selecione uma opção</option>
                                                                    <?php
                                                                        $pdo = Conexao::getInstance(); 
                                                                        $consulta = $pdo->query("SELECT * FROM categoria WHERE situacao = 1");
                                                                        while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                            $categoria = new categoria($linha['idCategoria'], $linha['descricao'], $linha['situacao']);
                                                                            echo '<option value="'.$categoria->getId().'">'.$categoria->getDescricao().'</option>';
                                                                        }
                                                                    ?>
                                                                </select></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr style="margin-top: 0px;">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Título</span><input class="form-control" type="text" id="titulo" name="titulo"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="descricao"><strong>Descrição</strong><br></label><textarea class="form-control" id="summernote" name="descricao"></textarea></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3"><button class="btn btn-primary" type="submit" style="margin-right: 10px;" value="abrirTicketCliente" name="acao">Salvar</button><a class="btn btn-primary" role="button" href="homeCli.php">Voltar</a></div>
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
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/bs-init.js"></script>
    <script src="../assets/js/summernote-bs5.min.js"></script>
    <script src="../assets/js/summernote.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/todo.js"></script>
</body>

</html>