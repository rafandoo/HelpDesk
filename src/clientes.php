<!DOCTYPE html>
<?php
    include "validaSessao.php";
    require_once "util/autoload.php";
    require_once "config/Conexao.php";
    include_once "config/default.inc.php";

    $title = "Clientes";

    if ($_SESSION['nivelAcesso'] == 1) {
        header("Location: cliente/homeCli.php");
    }

    $procurar = isset($_GET["procurar"]) ? $_GET["procurar"] : "";
    $filtro = isset($_GET["filtro"]) ? $_GET["filtro"] : "nome";
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
                                <div class="bg-white border rounded collapse-inner"><a class="collapse-item" href="clientes.php">Clientes</a><a class="collapse-item" href="usuarios.php">Usu??rios</a><a class="collapse-item" href="categorias.php">Categorias</a><a class="collapse-item" href="setores.php">Setores</a></div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div><a data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-2" href="#collapse-2" role="button" class="nav-link"><i class="fas fa-chart-bar"></i>&nbsp;<span>Gerencial</span></a>
                            <div class="collapse" id="collapse-2">
                                <div class="bg-white border rounded collapse-inner"><a class="collapse-item" href="404.php">Dashboard</a><a class="collapse-item" href="relatorios.php">Relat??rios</a></div>
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
                    <h3 class="text-dark mb-4">Clientes</h3>
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div id="dataTable_filter-1" class="dataTables_filter">
                                        <form method="get">
                                            <div class="d-flex">
                                                <div style="margin-right: 20px;"><select class="form-select" id="filtro" style="width: 145px;" name="filtro">
                                                        <option value="nome" selected="">Nome</option>
                                                        <option value="idCliente">C??digo</option>
                                                        <option value="cpfCnpj">CPF/CNPJ</option>
                                                    </select></div>
                                                <div>
                                                    <div class="input-group" style="width: 270px;"><input class="form-control form-control-sm" type="search" id="procurar" aria-controls="dataTable" placeholder="Buscar" name="procurar"><button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="text-end"><a class="btn btn-success" role="button" href="cadClientes.php"><i class="fas fa-plus"></i><span>&nbsp;Novo</span></a></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>C??digo</th>
                                            <th>Nome</th>
                                            <th>Telefone</th>
                                            <th>E-mail</th>
                                            <th>CPF/CNPJ</th>
                                            <th>Situa????o</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                                $pdo = Conexao::getInstance();
                                                $consulta = $pdo->query("SELECT * FROM cliente WHERE $filtro LIKE '%$procurar%' ORDER BY idCliente");
                                                while($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                                    $cliente = new cliente($linha['idCliente'], $linha['nome'], $linha['nomeFantasia'], $linha['cpfCnpj'], $linha['endereco'], $linha['numero'], $linha['bairro'], $linha['cidade'], $linha['email'], $linha['telefone'], $linha['observacoes'], $linha['idUsuario'], $linha['situacao']);
                                            ?>
                                        <tr class="align-middle">
                                            <td><?php echo $cliente->getIdCliente()?></td>
                                            <td><?php echo $cliente->getNome()?></td>
                                            <td><?php echo $cliente->getTelefone()?></td>
                                            <td><?php echo $cliente->getEmail()?></td>
                                            <td class="text-nowrap"><?php echo $cliente->getCpfCnpj()?></td>
                                            <td><?php echo $cliente->getStrSituacao()?></td>
                                            <td class="text-nowrap text-end align-middle">
                                                <a class="btn btn-outline-danger border rounded-circle" role="button" style="border-radius: 30px;margin-right: 10px;" href="javascript:confirmBloquear('action/actCliente.php?acao=situacaoC&idCliente=<?=$cliente->getIdCliente()?>')">
                                                    <i class="fas fa-lock"></i>
                                                </a>
                                                <a class="btn btn-outline-success border rounded-circle" role="button" style="border-radius: 30px;width: 40px;margin-right: 10px;" href="cadClientes.php?acao=alterarC&idCliente=<?=$cliente->getIdCliente()?>">
                                                    <i class="fas fa-pen" style="width: 14px;height: 16px;"></i>
                                                </a>
                                            </td>
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
                            <div class="row" hidden>
                                <div class="col-md-6 align-self-center">
                                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando de 1 a 10 de 27</p>
                                </div>
                                <div class="col-md-6">
                                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                        <ul class="pagination">
                                            <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">??</span></a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">??</span></a></li>
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
                    <div class="text-center my-auto copyright"><a href="https://github.com/rafandoo" style="color: #000000;"><span style="color: rgb(133,135,150);font-weight: bold;"><br>Copyright ?? Rafael Camargo 2022<br><br></span></a></div>
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
    <script src="assets/js/confirmMsg.js"></script>
</body>

</html>