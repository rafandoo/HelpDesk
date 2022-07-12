<!DOCTYPE html>
<?php
    include "validaSessao.php";
    require_once "util/autoload.php";
    require_once "config/Conexao.php";
    include_once "config/default.inc.php";

    $title = "Lista de Tramites";

    if ($_SESSION['nivelAcesso'] == 1) {
        header("Location: cliente/homeCli.php");
    }

    $idTicket = isset($_GET['idTicket']) ? $_GET['idTicket'] : 0;

    $cliente = getCliente(getTicket($idTicket)->getCliente())->getNome();

    function getTicket($idTicket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM ticket WHERE idTicket = :idTicket");
        $stmt->bindValue(":idTicket", $idTicket);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Ticket($linha['idTicket'], $linha['titulo'], $linha['descricao'], $linha['dataAbertura'], $linha['dataAtualizacao'], $linha['dataFinalizacao'], $linha['categoria'], $linha['prioridade'], $linha['status'], $linha['setor'], $linha['cliente'], $linha['contato'], $linha['usuario']);
    }

    function getCliente($idCliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM cliente WHERE idCliente = :idCliente");
        $stmt->bindValue(":idCliente", $idCliente);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new cliente($linha['idCliente'], $linha['nome'], $linha['nomeFantasia'], $linha['cpfCnpj'], $linha['endereco'], $linha['numero'], $linha['bairro'], $linha['cidade'], $linha['email'], $linha['telefone'], $linha['observacoes'], $linha['idUsuario'], $linha['situacao']);
    }

    function getUsuarios($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE idUsuario = :id");
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
    }

    function countHoras($idTicket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT horaInicial, horaFinal FROM tramite WHERE idTicket = :idTicket");
        $stmt->bindValue(":idTicket", $idTicket);
        $stmt->execute();
        $horas = 0;

        while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
            $horaInicial = $linha['horaInicial'];
            $horaFinal = $linha['horaFinal'];
            $horaInicial = strtotime($horaInicial);
            $horaFinal = strtotime($horaFinal);
            $diferenca = $horaFinal - $horaInicial;
            $horas += $diferenca;
        }

        if ($horas == 0) {
            $horas = ("00:00");
        } else {
            $horas = gmdate("H:i", $horas);
        }
        return $horas;
    }
?>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $title;?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
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
                    <h3 class="text-dark mb-4">Lista de trâmites</h3>
                    <div class="card shadow">
                        <div class="card-body" style="font-size: 14px;">
                            <div class="row">
                                <div class="col-xl-2 col-xxl-2" style="padding-right: 0px;padding-left: 0px;">
                                    <div>
                                        <div style="margin-bottom: 15px;">
                                            <div class="input-group"><span class="input-group-text">Ticket</span><input class="bg-white form-control" type="text" id="ticket" name="ticket" readonly="" style="margin-right: 10px;" value="<?php echo $idTicket;?>"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-xxl-3" style="padding-right: 0px;padding-left: 0px;">
                                    <div>
                                        <div style="margin-bottom: 15px;">
                                            <div class="input-group"><span class="input-group-text">Total horas</span><input class="bg-white form-control" id="horaTotal" name="horaTotal" readonly="" style="margin-right: 10px;" type="time" value="<?php echo countHoras($idTicket);?>"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-xxl-4" style="padding-right: 0px;padding-left: 0px;">
                                    <div>
                                        <div style="margin-bottom: 15px;">
                                            <div class="input-group"><span class="input-group-text">Cliente</span><input class="bg-white form-control" type="text" id="cliente" name="cliente" readonly="" value="<?php echo $cliente;?>"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-xxl-3 offset-xl-0 offset-xxl-0 d-flex justify-content-xl-end align-items-xl-start">
                                    <div><a class="btn btn-success" role="button" href="cadTramites.php?idTicket=<?=$idTicket?>" style="margin-right: 10px;"><i class="fas fa-plus"></i><span>&nbsp;Novo</span></a></div>
                                    <div><a class="btn btn-secondary" role="button" href="cadTickets.php?acao=alterar&idTicket=<?=$idTicket?>"><i class="fas fa-arrow-circle-left"></i><span>&nbsp;Voltar</span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body" style="font-size: 14px;">
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table table-striped my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Data</th>
                                            <th>Hora inicial</th>
                                            <th>Hora final</th>
                                            <th>Descrição</th>
                                            <th>Técnico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $pdo = Conexao::getInstance();
                                            $consulta = $pdo->query("SELECT * FROM tramite WHERE idTicket = '$idTicket'");
                                            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                $tramite = new Tramite($linha['idTramite'], $linha['data'], $linha['horaInicial'], $linha['horaFinal'], $linha['descricao'], $linha['idTicket'], $linha['usuario']);
                                        ?>
                                        <tr class="align-middle">
                                            <td class="text-nowrap"><?php echo $tramite->getIdTramite();?></td>
                                            <td class="text-nowrap"><?php echo $tramite->getData();?></td>
                                            <td class="text-nowrap"><?php echo $tramite->getHoraInicial();?></td>
                                            <td class="text-nowrap"><?php echo $tramite->getHoraFinal();?></td>
                                            <td class="text-break"><?php echo $tramite->getDescricao();?></td>
                                            <td class="text-nowrap"><?php echo getUsuarios($tramite->getUsuario())->getNome();?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td style="padding: 0px;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
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
</body>

</html>