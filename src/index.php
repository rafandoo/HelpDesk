<!DOCTYPE html>
<?php
    include 'validaSessao.php';
?>

<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Brand</title>
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
                    <li class="nav-item"><a class="nav-link active" href="index.html"><i class="fas fa-home"></i><span>Home</span></a></li>
                    <li class="nav-item">
                        <div><a data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-3" href="#collapse-3" role="button" class="nav-link"><i class="fas fa-tasks"></i>&nbsp;<span>Atendimentos</span></a>
                            <div class="collapse" id="collapse-3">
                                <div class="bg-white border rounded collapse-inner"><a class="collapse-item" href="cadTickets.html">Novo chamado</a><a class="collapse-item" href="filaAtendimentos.html">Minha fila</a><a class="collapse-item" href="filaPendentes.html">Pendentes</a></div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div><a data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-1" href="#collapse-1" role="button" class="nav-link"><i class="fas fa-user"></i>&nbsp;<span>Cadastros</span></a>
                            <div class="collapse" id="collapse-1">
                                <div class="bg-white border rounded collapse-inner"><a class="collapse-item" href="clientes.html">Clientes</a><a class="collapse-item" href="usuarios.html">Usuários</a><a class="collapse-item" href="categorias.html">Categorias</a><a class="collapse-item" href="setores.html">Setores</a></div>
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
                    <li class="nav-item"><a class="nav-link" href="logout.html"><i class="fas fa-arrow-circle-left"></i><span>&nbsp;Sair</span></a></li>
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
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="perfil.html"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Perfil</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Home&nbsp;</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4"><a href="filaPendentes.html" style="text-decoration: none;">
                                <div class="card shadow border-start-primary py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-danger fw-bold text-xs mb-1"><span>Aguardando Atendimento</span></div>
                                                <div class="text-dark fw-bold h5 mb-0"><span>6</span></div>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-hourglass-half fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </a></div>
                        <div class="col-md-6 col-xl-3 mb-4"><a href="filaAtendimentos.html" style="text-decoration: none;">
                                <div class="card shadow border-start-primary py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Em atendimento</span></div>
                                                <div class="text-dark fw-bold h5 mb-0"><span>4</span></div>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-play fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </a></div>
                        <div class="col-md-6 col-xl-3 mb-4"><a href="#" style="text-decoration: none;">
                                <div class="card shadow border-start-primary py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Pendentes</span></div>
                                                <div class="row g-0 align-items-center">
                                                    <div class="col-auto">
                                                        <div class="text-dark fw-bold h5 mb-0"><span>5</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-user-clock fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </a></div>
                        <div class="col-md-6 col-xl-3 mb-4"><a href="#" style="text-decoration: none;">
                                <div class="card shadow border-start-primary py-2" style="text-decoration: none;">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span class="text-info">finalizados</span></div>
                                                <div class="text-dark fw-bold h5 mb-0"><span>8</span></div>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </a></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <div class="row d-flex" style="margin-top: 5px;">
                                                <div class="w-100"></div>
                                                <div class="col d-xxl-flex align-items-xxl-center">
                                                    <h5 class="text-dark fw-bold m-0">Lista de Tarefas</h5>
                                                </div>
                                                <div class="col text-end d-xxl-flex justify-content-xxl-end align-items-xxl-center"><a class="btn btn-info btn-sm btn-circle ms-1" role="button"><i class="fas fa-plus text-white"></i></a></div>
                                            </div>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="row align-items-center no-gutters">
                                                    <div class="col col-auto"><button class="btn btn-outline-success btn-sm btn-circle ms-1" type="button"><i class="fas fa-check"></i></button></div>
                                                    <div class="col me-2">
                                                        <h6 class="mb-0"><strong>Lunch meeting</strong></h6><span class="text-xs">10:30 AM</span>
                                                    </div>
                                                    <div class="col-auto"><button class="btn btn-outline-danger btn-sm btn-circle ms-1" type="button"><i class="far fa-trash-alt"></i></button></div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row align-items-center no-gutters">
                                                    <div class="col col-auto"><button class="btn btn-outline-success btn-sm btn-circle ms-1" type="button"><i class="fas fa-check"></i></button></div>
                                                    <div class="col me-2">
                                                        <h6 class="mb-0"><strong>Lunch meeting</strong></h6><span class="text-xs">10:30 AM</span>
                                                    </div>
                                                    <div class="col-auto"><button class="btn btn-outline-danger btn-sm btn-circle ms-1" type="button"><i class="far fa-trash-alt"></i></button></div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row align-items-center no-gutters">
                                                    <div class="col col-auto"><button class="btn btn-outline-success btn-sm btn-circle ms-1" type="button"><i class="fas fa-check"></i></button></div>
                                                    <div class="col me-2">
                                                        <h6 class="mb-0"><strong>Lunch meeting</strong></h6><span class="text-xs">10:30 AM</span>
                                                    </div>
                                                    <div class="col-auto"><button class="btn btn-outline-danger btn-sm btn-circle ms-1" type="button"><i class="far fa-trash-alt"></i></button></div>
                                                </div>
                                            </li>
                                        </ul>
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
</body>

</html>