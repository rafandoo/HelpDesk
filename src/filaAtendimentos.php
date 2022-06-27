<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - Brand</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.html"><i class="fas fa-home"></i><span>Home</span></a></li>
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
                    <h3 class="text-dark mb-4">Fila de chamados</h3>
                    <div class="card shadow">
                        <div class="card-body" style="font-size: 14px;">
                            <div class="row">
                                <div class="col-xl-4 col-xxl-3 offset-xxl-0" style="padding-left: 0px;">
                                    <div id="dataTableFilter1" class="dataTables_filter">
                                        <div style="margin-bottom: 15px;">
                                            <div class="input-group"><span class="input-group-text">Prioridade</span><select class="form-select" id="prioridadeFiltro" name="prioridadeFiltro">
                                                    <option value="name" selected="">Nome</option>
                                                    <option value="id">Código</option>
                                                    <option value="cpfCnpj">CPF/CNPJ</option>
                                                    <option value="situation">Situação</option>
                                                </select></div>
                                        </div>
                                        <div style="margin-bottom: 15px;">
                                            <div class="input-group"><span class="input-group-text">Estado</span><select class="form-select" id="estadoFiltro" name="estadoFiltro">
                                                    <option value="name" selected="">Nome</option>
                                                    <option value="id">Código</option>
                                                    <option value="cpfCnpj">CPF/CNPJ</option>
                                                    <option value="situation">Situação</option>
                                                </select></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-xxl-3" style="padding-right: 0px;padding-left: 0px;">
                                    <div id="dataTableFilter2" class="dataTables_filter">
                                        <div style="margin-bottom: 15px;">
                                            <div class="input-group"><span class="input-group-text">Ticket</span><input class="form-control" type="text" id="ticketFiltro" name="ticketFiltro" style="margin-right: 10px;"></div>
                                        </div>
                                        <div style="margin-bottom: 15px;">
                                            <div class="input-group"><span class="input-group-text">Tecnico</span><select class="form-select" id="tecnicoFiltro" name="tecnicoFiltro" style="margin-right: 10px;">
                                                    <option value="name" selected="">Nome</option>
                                                    <option value="id">Código</option>
                                                    <option value="cpfCnpj">CPF/CNPJ</option>
                                                    <option value="situation">Situação</option>
                                                </select></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-xxl-3 offset-xxl-0" style="padding-left: 0px;padding-right: 0px;">
                                    <div id="dataTableFilter3" class="dataTables_filter">
                                        <div style="margin-bottom: 15px;">
                                            <div class="input-group"><span class="input-group-text">Cliente</span><input class="form-control" type="text" id="clienteFiltro" name="clienteFiltro"><button class="btn btn-primary" type="button" data-bs-target="#procurarCliente" data-bs-toggle="modal"><i class="fas fa-search"></i></button></div>
                                        </div>
                                        <div class="modal fade" role="dialog" tabindex="-1" id="procurarCliente" name="procurarCliente" style="padding-top: 0px;background: rgba(234,236,244,0);">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Procurar cliente</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="input-group"><select class="form-select">
                                                                <option value="nome" selected="">Nome</option>
                                                                <option value="codigo">Código</option>
                                                                <option value="cpfCnpj">cpfCnpj</option>
                                                            </select><input class="form-control" type="text" style="width: 461px;"><button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button></div>
                                                    </div>
                                                    <div class="table-responsive" role="grid">
                                                        <table class="table table-hover my-0">
                                                            <thead>
                                                                <tr class="text-center">
                                                                    <th>Código</th>
                                                                    <th>Nome</th>
                                                                    <th>CFP/CNPJ</th>
                                                                    <th>Situação</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="text-center">
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Rafael Camargo</td>
                                                                    <td>111.111.111-11</td>
                                                                    <td>Ativo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Fulano de tal LTDA</td>
                                                                    <td>11.111.111/0001-01</td>
                                                                    <td>Inativo</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button">Save</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-xxl-2 offset-xl-10 offset-xxl-1">
                                    <div class="text-end" style="margin-bottom: 10px;"><a class="btn btn-warning" role="button"><i class="fas fa-filter"></i><span>Filtrar</span></a></div>
                                    <div class="text-end" style="margin-bottom: 10px;"><a class="btn btn-success" role="button" href="cadTickets.html"><i class="fas fa-plus"></i><span>&nbsp;Novo</span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body" style="font-size: 14px;">
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Ticket</th>
                                            <th>Cliente</th>
                                            <th>Título</th>
                                            <th>Data de abertura</th>
                                            <th>Prioridade</th>
                                            <th>Estado</th>
                                            <th>Técnico</th>
                                            <th>Atualizado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="align-middle">
                                            <td>#1</td>
                                            <td>Rafael Camargo</td>
                                            <td>FISCAL - Bloco X pendente</td>
                                            <td>05/06/2022</td>
                                            <td class="text-nowrap">Alta</td>
                                            <td>Em atendimento</td>
                                            <td>Rafael</td>
                                            <td>06/06/2022</td>
                                            <td class="text-nowrap text-end align-middle"><a class="btn btn-outline-info border rounded-circle" role="button" style="border-radius: 30px;margin-right: 10px;width: 40px;"><i class="far fa-eye" style="width: 15px;"></i></a><a class="btn btn-outline-danger border rounded-circle" role="button" style="border-radius: 30px;border-width: 1px;margin-right: 10px;"><i class="far fa-trash-alt"></i></a></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>#2</td>
                                            <td>Fulano De Tal</td>
                                            <td>PDV - Erro cupom</td>
                                            <td>04/05/2022</td>
                                            <td class="text-nowrap">Média</td>
                                            <td>Pausado</td>
                                            <td>Rafael</td>
                                            <td>10/06/2022</td>
                                            <td class="text-nowrap text-end align-middle"><a class="btn btn-outline-info border rounded-circle" role="button" style="border-radius: 30px;margin-right: 10px;width: 40px;"><i class="far fa-eye border-0" style="width: 15px;"></i></a><a class="btn btn-outline-danger border rounded-circle" role="button" style="border-radius: 30px;border-width: 1px;margin-right: 10px;"><i class="far fa-trash-alt"></i></a></td>
                                        </tr>
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
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/summernote-bs5.min.js"></script>
    <script src="assets/js/summernote.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/todo.js"></script>
</body>

</html>