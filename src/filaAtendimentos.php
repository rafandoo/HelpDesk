<!DOCTYPE html>
<?php
    include "validaSessao.php";
    require_once "util/autoload.php";
    require_once "config/Conexao.php";
    include_once "config/default.inc.php";

    $title = "Fila de Atendimentos";

    if ($_SESSION['nivelAcesso'] == 1) {
        header("Location: cliente/homeCli.php");
    }

    $filtroPrioridade = isset($_GET["filtroPrioridade"]) ? $_GET["filtroPrioridade"] : 0;
    $filtroStatus = isset($_GET["filtroStatus"]) ? $_GET["filtroStatus"] : 0;
    $filtroCategoria = isset($_GET["filtroCategoria"]) ? $_GET["filtroCategoria"] : 0;
    $filtroUsuario = isset($_GET["filtroUsuario"]) ? $_GET["filtroUsuario"] : 0;
    $filtroCliente = isset($_GET["filtroCliente"]) ? $_GET["filtroCliente"] : 0;
    $filtroSetor = isset($_GET["filtroSetor"]) ? $_GET["filtroSetor"] : 0;

    function getClientes($idCliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM cliente WHERE idCliente = :idCliente");
        $stmt->bindValue(":idCliente", $idCliente);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new cliente($linha['idCliente'], $linha['nome'], $linha['nomeFantasia'], $linha['cpfCnpj'], $linha['endereco'], $linha['numero'], $linha['bairro'], $linha['cidade'], $linha['email'], $linha['telefone'], $linha['observacoes'], $linha['idUsuario'], $linha['situacao']);
    }

    function getPrioridades($idPrioridade) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM prioridade WHERE idPrioridade = :idPrioridade");
        $stmt->bindValue(":idPrioridade", $idPrioridade);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new prioridade($linha['idPrioridade'], $linha['descricao'], $linha['situacao']);
    }

    function getStatus($idStatus) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM status WHERE idStatus = :idStatus");
        $stmt->bindValue(":idStatus", $idStatus);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new status($linha['idStatus'], $linha['descricao'], $linha['situacao']);
    }

    function getUsuarios($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE idUsuario = :idUsuario");
        $stmt->bindValue(":idUsuario", $idUsuario);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
    }

    function filtraTickets($filtroPrioridade, $filtroStatus, $filtroCategoria, $filtroUsuario, $filtroCliente, $filtroSetor) {
        $pdo = Conexao::getInstance();
        $sql = "SELECT * FROM ticket WHERE usuario != 0";

        if ($filtroPrioridade != '0') {
            $sql .= " AND prioridade = $filtroPrioridade";
        }
        if ($filtroStatus != '0') {
            $sql .= " AND status = $filtroStatus";
        } else {
            $sql .= " AND status != 4";
        }
        if ($filtroCategoria != '0') {
            $sql .= " AND categoria = $filtroCategoria";
        }
        if ($filtroUsuario != '0') {
            $sql .= " AND usuario = $filtroUsuario";
        }
        if ($filtroCliente != '0') {
            $sql .= " AND cliente = $filtroCliente";
        }
        if ($filtroSetor != '0') {
            $sql .= " AND setor = $filtroSetor";
        } else {
            $setorUsuario = $_SESSION['setor'];
            $sql .= " AND setor = $setorUsuario";
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
                    <h3 class="text-dark mb-4">Fila de chamados</h3>
                    <div class="card shadow">
                        <div class="card-body" style="font-size: 14px;">
                            <form method="get">
                                <div class="row">
                                    <div class="col-xl-4 col-xxl-3 offset-xxl-0" style="padding-left: 0px;">
                                        <div id="dataTableFilter1" class="dataTables_filter">
                                            <div style="margin-bottom: 15px;">
                                                <div class="input-group"><span class="input-group-text">Prioridade</span><select class="form-select" id="filtroPrioridade" name="filtroPrioridade">
                                                        <option value="0">Selecione uma opção</option>
                                                        <?php
                                                            $pdo = Conexao::getInstance();
                                                            $consulta = $pdo->query("SELECT * FROM prioridade WHERE situacao = 1");
                                                            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                $prioridade = new prioridade($linha['idPrioridade'], $linha['descricao'], $linha['situacao']);
                                                                if ($prioridade->getId() == $filtroPrioridade){
                                                                    echo '<option value="'.$prioridade->getId().'" selected>'.$prioridade->getDescricao().'</option>';
                                                                } else {
                                                                    echo '<option value="'.$prioridade->getId().'">'.$prioridade->getDescricao().'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div style="margin-bottom: 15px;">
                                                <div class="input-group"><span class="input-group-text">Estado</span><select class="form-select" id="filtroStatus" name="filtroStatus">
                                                        <option value="0">Selecione uma opção</option>
                                                        <?php
                                                            $pdo = Conexao::getInstance();
                                                            $consulta = $pdo->query("SELECT * FROM status WHERE situacao = 1");
                                                            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                $status = new status($linha['idStatus'], $linha['descricao'], $linha['situacao']);
                                                                if ($status->getId() == $filtroStatus){
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
                                    <div class="col-xl-4 col-xxl-3" style="padding-right: 0px;padding-left: 0px;">
                                        <div id="dataTableFilter2" class="dataTables_filter">
                                            <div style="margin-bottom: 15px;">
                                                <div class="input-group"><span class="input-group-text">Categoria</span><select class="form-select" id="filtroCategoria" name="filtroCategoria" style="margin-right: 10px;">
                                                        <option value="0">Selecione uma opção</option>
                                                        <?php
                                                            $pdo = Conexao::getInstance();
                                                            $consulta = $pdo->query("SELECT * FROM categoria WHERE situacao = 1");
                                                            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                $categoria = new categoria($linha['idCategoria'], $linha['descricao'], $linha['situacao']);
                                                                if ($categoria->getId() == $filtroCategoria){
                                                                    echo '<option value="'.$categoria->getId().'" selected>'.$categoria->getDescricao().'</option>';
                                                                } else {
                                                                    echo '<option value="'.$categoria->getId().'">'.$categoria->getDescricao().'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div style="margin-bottom: 15px;">
                                                <div class="input-group"><span class="input-group-text">Tecnico</span><select class="form-select" id="filtroUsuario" name="filtroUsuario" style="margin-right: 10px;">
                                                        <option value="0" selected>Selecione uma opção</option>
                                                        <?php
                                                            $pdo = Conexao::getInstance();
                                                            $consulta = $pdo->query("SELECT * FROM usuario WHERE situacao = 1 AND nivelAcesso != 1");
                                                            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                $usuario = new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
                                                                if ($usuario->getIdUsuario() == $filtroUsuario){
                                                                    echo '<option value="'.$usuario->getIdUsuario().'" selected>'.$usuario->getNome().' '.$usuario->getSobrenome().'</option>';
                                                                } else {
                                                                    echo '<option value="'.$usuario->getIdUsuario().'">'.$usuario->getNome().' '.$usuario->getSobrenome().'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-xxl-3 offset-xxl-0" style="padding-left: 0px;padding-right: 0px;">
                                        <div id="dataTableFilter3" class="dataTables_filter">
                                            <div style="margin-bottom: 15px;">
                                                <div class="input-group"><span class="input-group-text">Cliente</span>
                                                    <input class="form-control" type="text" id="cliente" name="cliente">
                                                    <input type="hidden" name="filtroCliente" id="idCliente" value="0">
                                                    <button class="btn btn-primary" type="button" data-bs-target="#procurarCliente" data-bs-toggle="modal"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                            <div class="modal fade input-group-text" role="dialog" tabindex="-1" id="procurarCliente" name="procurarCliente" style="padding-top: 0px;background: rgba(234,236,244,0);">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Procurar cliente</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="input-group">
                                                                                    <select class="form-select" name="filtro" id="filtro">
                                                                                        <option value="nome" selected="">Nome</option>
                                                                                        <option value="idCliente">Código</option>
                                                                                        <option value="cpfCnpj">CPF/CNPJ</option>
                                                                                    </select>
                                                                                    <input class="form-control" type="text" name="procurar" id="procurar" style="width: 461px;">
                                                                                    <button class="btn btn-primary" type="button" onclick="filtrarCliente()">
                                                                                        <i class="fas fa-search"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="table-responsive" role="grid">
                                                                                <table class="table table-hover my-0">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Código</th>
                                                                                            <th>Nome</th>
                                                                                            <th>CFP/CNPJ</th>
                                                                                            <th>Situação</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody id="dados" name="dados">
                                                                                        
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="modal-footer"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                            <div style="margin-bottom: 15px;">
                                                <div class="input-group"><span class="input-group-text">Setor</span><select class="form-select" id="filtroSetor" name="filtroSetor" style="margin-right: 10px;">
                                                        <option value="0" selected>Selecione uma opção</option>
                                                        <?php
                                                            $pdo = Conexao::getInstance();
                                                            $consulta = $pdo->query("SELECT * FROM setor WHERE situacao = 1");
                                                            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                $setor = new setor($linha['idSetor'], $linha['descricao'], $linha['situacao']);
                                                                if ($setor->getId() == $filtroSetor){
                                                                    echo '<option value="'.$setor->getId().'" selected>'.$setor->getDescricao().'</option>';
                                                                } else {
                                                                    echo '<option value="'.$setor->getId().'">'.$setor->getDescricao().'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-xxl-2 offset-xl-10 offset-xxl-1">
                                        <div class="text-end" style="margin-bottom: 10px;"><button class="btn btn-warning" type="submit"><i class="fas fa-filter"></i><span>&nbsp;Filtrar</span></button><a class="btn btn-secondary" role="button" style="margin-left: 10px;" href="filaAtendimentos.php"><i class="far fa-times-circle"></i><span>&nbsp;Limpar</span></a></div>
                                        <div class="text-end" style="margin-bottom: 10px;"><a class="btn btn-success" role="button" href="cadTickets.php"><i class="fas fa-plus"></i><span>&nbsp;Novo</span></a></div>
                                    </div>
                                </div>
                            </form>
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
                                        <?php
                                            $pdo = Conexao::getInstance();
                                            $consulta = filtraTickets($filtroPrioridade, $filtroStatus, $filtroCategoria, $filtroUsuario, $filtroCliente, $filtroSetor);
                                            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                $ticket = new ticket($linha['idTicket'], $linha['titulo'], $linha['descricao'], $linha['dataAbertura'], $linha['dataAtualizacao'], $linha['dataFinalizacao'], $linha['categoria'], $linha['prioridade'], $linha['status'], $linha['setor'], $linha['cliente'], $linha['contato'], $linha['usuario']);
                                                $url = '"action/actTicket.php?acao=excluir&idTicket='.$ticket->getIdTicket().'"';
                                        ?>
                                        <tr class="align-middle">
                                            <td>#<?php echo $ticket->getIdTicket();?></td>
                                            <td><?php echo getClientes($ticket->getCliente())->getNome();?></td>
                                            <td><?php echo $ticket->getTitulo();?></td>
                                            <td><?php echo $ticket->getDataAbertura();?></td>
                                            <td><?php echo getPrioridades($ticket->getPrioridade())->getDescricao();?></td>
                                            <td><?php echo getStatus($ticket->getStatus())->getDescricao();?></td>
                                            <td><?php echo getUsuarios($ticket->getUsuario())->getNome();?></td>
                                            <td><?php echo $ticket->getDataAtualizacao();?></td>
                                            <td class="text-nowrap text-end align-middle">
                                                <a class="btn btn-outline-info border rounded-circle" role="button" style="border-radius: 30px;margin-right: 10px;width: 40px;" href="cadTickets.php?acao=alterar&idTicket=<?=$ticket->getIdTicket()?>"><i class="far fa-eye" style="width: 15px;"></i></a>
                                                <a class="btn btn-outline-danger border rounded-circle" role="button" style="border-radius: 30px;border-width: 1px;margin-right: 10px;" <?php if ($_SESSION['nivelAcesso'] != 3) echo "onclick='alertSemPermissao()'"; else echo "onclick='confirmExclusao($url)'";?>><i class="far fa-trash-alt"></i></a>
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
    <script src="assets/js/modalCliente.js"></script>
    <script src="assets/js/buscaCliente.js"></script>
    <script src="assets/js/confirmMsg.js"></script>
</body>

</html>