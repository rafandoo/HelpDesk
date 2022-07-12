<!DOCTYPE html>
<?php
    include "../validaSessao.php";
    require_once "../util/autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";

    $title = "Painel do cliente";

    $filtroStatus = isset($_GET["filtroStatus"]) ? $_GET["filtroStatus"] : 0;
    $filtroTicket = isset($_GET["filtroTicket"]) ? $_GET["filtroTicket"] : 0;

    function getClientes($idUsuario)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM cliente WHERE idUsuario = :id");
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new cliente($linha['idCliente'], $linha['nome'], $linha['nomeFantasia'], $linha['cpfCnpj'], $linha['endereco'], $linha['numero'], $linha['bairro'], $linha['cidade'], $linha['email'], $linha['telefone'], $linha['observacoes'], $linha['idUsuario'], $linha['situacao']);
    }

    function getStatus($idStatus)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM status WHERE idStatus = :idStatus");
        $stmt->bindValue(":idStatus", $idStatus);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new status($linha['idStatus'], $linha['descricao'], $linha['situacao']);
    }

    function getUsuarios($idUsuario)
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE idUsuario = :idUsuario");
        $stmt->bindValue(":idUsuario", $idUsuario);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
    }

    function filtraTickets($filtroStatus, $filtroTicket, $idCliente)
    {
        $pdo = Conexao::getInstance();
        $sql = "SELECT * FROM ticket WHERE  cliente = $idCliente";
        if ($filtroStatus != 0) {
            $sql .= " AND status = $filtroStatus";
        }
        if ($filtroTicket != 0) {
            $sql .= " AND idTicket = $filtroTicket";
        }
        $sql .= " ORDER BY idTicket DESC";
        $consulta = $pdo->query($sql);
        return $consulta;
    }
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
                    <h3 class="text-dark mb-4">Lista de chamados</h3>
                    <form method="get">
                        <div class="card shadow">
                            <div class="card-body" style="font-size: 14px;">
                                <div class="row">
                                    <div class="col-xl-4 col-xxl-3 offset-xxl-0" style="padding-left: 0px;">
                                        <div id="dataTableFilter1" class="dataTables_filter">
                                            <div style="margin-bottom: 15px;">
                                                <div class="input-group"><span class="input-group-text">Estado</span><select class="form-select" id="filtroStatus" name="filtroStatus">
                                                        <option value="0">Selecione uma opção</option>
                                                        <?php
                                                            $pdo = Conexao::getInstance();
                                                            $consulta = $pdo->query("SELECT * FROM status WHERE situacao = 1");
                                                            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                                                $status = new status($linha['idStatus'], $linha['descricao'], $linha['situacao']);
                                                                if ($status->getId() == $filtroStatus) {
                                                                    echo '<option value="'.$status->getId().'" selected>'.$status->getDescricao().'</option>';
                                                                } else {
                                                                    echo '<option value="'.$status->getId().'">'.$status->getDescricao().'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-xxl-2" style="padding-right: 0px;padding-left: 0px;">
                                        <div id="dataTableFilter2" class="dataTables_filter">
                                            <div style="margin-bottom: 15px;">
                                                <div class="input-group"><span class="input-group-text">Ticket</span><input class="form-control" type="text" id="filtroTicket" name="filtroTicket" style="margin-right: 10px;" value="0"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-xxl-2 offset-xl-10 offset-xxl-5">
                                        <div class="text-end" style="margin-bottom: 10px;"><button class="btn btn-warning" type="submit"><i class="fas fa-filter"></i><span>Filtrar</span></button></div>
                                        <div class="text-end" style="margin-bottom: 10px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card shadow">
                        <div class="card-body" style="font-size: 14px;">
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Ticket</th>
                                            <th>Título</th>
                                            <th>Data de abertura</th>
                                            <th>Estado</th>
                                            <th>Técnico</th>
                                            <th>Última atualização</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $pdo = Conexao::getInstance();
                                            $consulta = filtraTickets($filtroStatus, $filtroTicket, getClientes($_SESSION['idUsuario'])->getIdCliente());
                                            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                                $ticket = new Ticket($linha['idTicket'], $linha['titulo'], $linha['descricao'], $linha['dataAbertura'], $linha['dataAtualizacao'], $linha['dataFinalizacao'], $linha['categoria'], $linha['prioridade'], $linha['status'], $linha['setor'], $linha['cliente'], $linha['contato'], $linha['usuario']); ?>
                                        <tr class="align-middle">
                                            <td>#<?php echo $ticket->getIdTicket(); ?></td>
                                            <td><?php echo $ticket->getTitulo(); ?></td>
                                            <td><?php echo $ticket->getDataAbertura(); ?></td>
                                            <td><?php echo getStatus($ticket->getStatus())->getDescricao(); ?></td>
                                            <?php
                                                if ($ticket->getUsuario() == 0) {
                                                    echo "<td>Não atribuído</td>";
                                                } else {
                                                    echo "<td>".getUsuarios($ticket->getUsuario())->getNome()."</td>";
                                                } ?>
                                            <td><?php echo $ticket->getDataAtualizacao(); ?></td>
                                            <td class="text-nowrap text-end align-middle"><a class="btn btn-outline-info border rounded-circle" role="button" style="border-radius: 30px;margin-right: 10px;width: 40px;" href="detTicket.php?idTicket=<?=$ticket->getIdTicket()?>"><i class="far fa-eye" style="width: 15px;"></i></a></td>
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
                            <div class="row">
                                <div class="col-md-6 align-self-center">
                                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando de 1 a 10 de 2</p>
                                </div>
                                <div class="col-md-6">
                                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                        <ul class="pagination">
                                            <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>
                                        </ul>
                                    </nav>
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