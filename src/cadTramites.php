<!DOCTYPE .php>
<?php 
    include "validaSessao.php";
    require_once "util/autoload.php";
    require_once "config/Conexao.php";
    include_once "config/default.inc.php";

    $title = "Cadastro de Tramites";

    $idTicket = isset($_GET["idTicket"]) ? $_GET["idTicket"] : 0;
    $idStatus = getTicket($idTicket)->getStatus();
    $contato = getTicket($idTicket)->getContato();
    $cliente = getTicket($idTicket)->getCliente();
    $data = date("Y-m-d");
    $horaInicial = date("H:i");

    function getTicket($idTicket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM ticket WHERE idTicket = :id");
        $stmt->bindValue(":id", $idTicket);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Ticket($linha['idTicket'], $linha['titulo'], $linha['descricao'], $linha['dataAbertura'], $linha['dataAtualizacao'], $linha['dataFinalizacao'], $linha['categoria'], $linha['prioridade'], $linha['status'], $linha['setor'], $linha['cliente'], $linha['contato'], $linha['usuario']);
    }

?>

<.php lang="pt-br">

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
                    <h3 class="text-dark mb-4">Trâmites</h3>
                    <div class="row mb-3">
                        <div class="col-11 col-xl-12 col-xxl-11 offset-xl-0">
                            <div class="row">
                                <div class="col-xl-11 col-xxl-9">
                                    <div class="card shadow mb-3">
                                        <div class="card-body">
                                            <form method="post" action="action/actTramite.php">
                                                <div class="row">
                                                    <input type="hidden" name="idTicket" value="<?php echo $idTicket;?>">
                                                    <input type="hidden" name="usuario" value="1">
                                                    <div class="col-xl-4 col-xxl-3">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Contato</span><input class="bg-white form-control" type="text" id="contato" readonly="" name="Contato" value="<?php echo $contato;?>"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-8 col-xxl-5">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Cliente</span><input class="bg-white form-control" type="text" id="cliente" name="cliente" readonly="" value="<?php echo $cliente;?>"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Estado</span><select class="form-select" id="status" required="" name="status">
                                                                    <option value="">Selecione uma opção</option>
                                                                    <?php
                                                                        $pdo = Conexao::getInstance();
                                                                        $consulta = $pdo->query("SELECT * FROM status WHERE situacao = 1");
                                                                        while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                            $status = new Status($linha['idStatus'], $linha['descricao'], $linha['situacao']);
                                                                            if ($status->getId() == $idStatus) {
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
                                                <hr style="margin-top: 0px;">
                                                <div class="row">
                                                    <div class="col-xl-3 col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Data</span><input class="bg-white form-control" id="data" name="data" type="date" readonly="" value="<?php echo $data;?>"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Hora inicial</span><input class="bg-white form-control" id="horaInicial" name="horaInicial" readonly="" type="time" value="<?php echo $horaInicial;?>"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Hora final</span><input class="bg-white form-control" id="horaFinal" name="horaFinal" readonly="" type="time" required=""><button class="btn btn-secondary" type="button" onclick="horaFinalAgora()"><i class="far fa-clock"></i></button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="descricao"><strong>Descrição</strong><br></label><textarea class="form-control" id="summernote" name="descricao"></textarea></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <button id="btnSalvar" disabled class="btn btn-primary" type="submit" style="margin-right: 10px;" name="acao" value="incluir">Salvar</button>
                                                    <a class="btn btn-primary" role="button" style="margin-right: 10px;" href="listaTramites.php?idTicket=<?=$idTicket?>">Voltar</a>
                                                </div>
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
    <script language=javascript type="text/javascript">
        function horaFinalAgora() {
            now = new Date();
            var hora = now.getHours();
            var minutos = now.getMinutes();

            if (hora < 10) {
                hora = "0" + hora;
            }
            if (minutos < 10) {
                minutos = "0" + minutos;
            }
            var horaFinal = hora + ":" + minutos;
            document.getElementById("horaFinal").value = horaFinal;
            document.getElementById("btnSalvar").disabled = false;
        }

    </script>
</body>

</.php>