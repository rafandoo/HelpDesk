<!DOCTYPE html>
<?php
    include "validaSessao.php";
    require_once "util/autoload.php";
    require_once "config/Conexao.php";
    include_once "config/default.inc.php";

    $title = "Cadastro de Tickets";

    if ($_SESSION['nivelAcesso'] == 1) {
        header("Location: cliente/homeCli.php");
    }

    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";

    function getStatus($idStatus) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM status WHERE idStatus = :id");
        $stmt->bindValue(":id", $idStatus);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new status($linha['idStatus'], $linha['descricao'], $linha['situacao']);
    }

    function getUsuario($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE idUsuario = :id");
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
    }

    function getTicket($idTicket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM ticket WHERE idTicket = :id");
        $stmt->bindValue(":id", $idTicket);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new ticket($linha['idTicket'], $linha['titulo'], $linha['descricao'], $linha['dataAbertura'], $linha['dataAtualizacao'], $linha['dataFinalizacao'], $linha['categoria'], $linha['prioridade'], $linha['status'], $linha['setor'], $linha['cliente'], $linha['contato'], $linha['usuario']);
    }

    function getClientes($idCliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM cliente WHERE idCliente = :id");
        $stmt->bindValue(":id", $idCliente);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new cliente($linha['idCliente'], $linha['nome'], $linha['nomeFantasia'], $linha['cpfCnpj'], $linha['endereco'], $linha['numero'], $linha['bairro'], $linha['cidade'], $linha['email'], $linha['telefone'], $linha['observacoes'], $linha['idUsuario'], $linha['situacao']);
    }

    if ($acao == 'alterar') {
        $value = 'editar';
        $ticket = getTicket($_GET['idTicket']);
        $idTicket = $ticket->getIdTicket();
        $dataAbertura = $ticket->getDataAbertura();
        $dataAtualizacao = $ticket->getDataAtualizacao();
        $cliente = getClientes($ticket->getCliente())->getNome();
        $idCliente = $ticket->getCliente();
        $contato = $ticket->getContato();
        $idSetor = $ticket->getSetor();
        if ($ticket->getUsuario() != 0) {
            $usuario = getUsuario($ticket->getUsuario())->getNome();
        }
        $idUsuario = $ticket->getUsuario();
        $status = getStatus($ticket->getStatus())->getDescricao();
        $idStatus = $ticket->getStatus();
        $idCategoria = $ticket->getCategoria();
        $idPrioridade = $ticket->getPrioridade();
        $titulo = $ticket->getTitulo();
        $descricao = $ticket->getDescricao();
    } else {
        $value = 'salvar';
        $idTicket = 0;
        $idCliente = 0;
        $cliente = "";
        $contato = "";
        $dataAbertura = date('Y-m-d').'T'.date('H:i');
        $status = getStatus(1)->getDescricao();
        $idStatus = 1;
        $titulo = "";
        $descricao = "";

    }
?>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $title?></title>
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
                    <h3 class="text-dark mb-4">Ticket</h3>
                    <div class="row mb-3">
                        <div class="col-11 col-xl-12 col-xxl-11 offset-xl-0">
                            <div class="row">
                                <div class="col-xl-12 col-xxl-12">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <div class="row d-flex">
                                                <div class="w-100"></div>
                                                <div class="col d-xxl-flex align-items-xxl-center">
                                                    <p class="fs-5 text-primary m-0 fw-bold">Informações do chamado</p>
                                                </div>
                                                <div class="col text-end">
                                                    <a class="btn btn-primary" role="button" onclick="validaTicket('cadOrdemServico.php?idTicket=<?=$idTicket?>')" style="margin-right: 10px;">Ordem de Serviço</a>
                                                    <a class="btn btn-primary" role="button" onclick="validaTicket('listaTramites.php?idTicket=<?=$idTicket?>')">Trâmites</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="padding-top: 0px;">
                                            <form method="post" action="action/actTicket.php">
                                                <div class="row">
                                                    <div class="col-xl-4 col-xxl-3">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">N° Ticket #</span><input class="bg-white form-control" type="text" id="idTicket" placeholder="#" readonly="" name="idTicket" value="<?php echo $idTicket;?>"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Data de abertura</span>
                                                                <input class="bg-white form-control" id="dataAbertura" readonly="" type="datetime-local" name="dataAbertura" value="<?php echo $dataAbertura?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-xxl-5 offset-xl-0">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Data atualização</span><input class="bg-white form-control" id="dataAtualizacao" readonly="" type="datetime-local" name="dataAtualizacao" value="<?php echo $dataAtualizacao;?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-7 col-xl-7 col-xxl-8">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Cliente</span>
                                                                <input class="bg-white form-control" type="text" id="cliente" readonly="" required="" name="cliente" value="<?php echo $cliente;?>">
                                                                <input type="hidden" id="idCliente" name="idCliente" value="<?php echo $idCliente;?>">
                                                                <button class="btn btn-primary py-0" type="button" data-bs-target="#procurarCliente" data-bs-toggle="modal">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Contato</span><input class="form-control" type="text" id="contato" required="" name="contato" value="<?php echo $contato;?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-5 col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Setor</span>
                                                                <select class="form-select" id="setor" required="" name="setor">
                                                                    <option value="">Selecione uma opção</option>
                                                                    <?php
                                                                        $pdo = Conexao::getInstance(); 
                                                                        $consulta = $pdo->query("SELECT * FROM setor WHERE situacao = 1");
                                                                        while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                            $setor = new setor($linha['idSetor'], $linha['descricao'], $linha['situacao']);
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
                                                    </div>
                                                    <div class="col-xl-7 col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Técnico</span><select class="form-select" id="usuario" required="" name="usuario">
                                                                    <option value="" selected="">Selecione uma opção</option>
                                                                    <?php
                                                                        if ($acao == 'alterar') {
                                                                            if ($idUsuario == 0) {
                                                                                echo '<option value="0" selected="">Não atribuído</option>';
                                                                            } else {
                                                                                echo '<option value="'.$idUsuario.'" selected="">'.$usuario.'</option>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-5 col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Estado</span>
                                                                <input class="bg-white form-control" type="text" id="statusNome" name="statusNome" readonly value="<?php echo $status;?>">
                                                                <input type="hidden" name="status" value="<?php echo $idStatus;?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-5 col-xxl-5">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Categoria</span><select class="form-select" id="categoria" required="" name="categoria">
                                                                    <option value="" selected="">Selecione uma opção</option>
                                                                    <?php
                                                                        $pdo = Conexao::getInstance(); 
                                                                        $consulta = $pdo->query("SELECT * FROM categoria WHERE situacao = 1");
                                                                        while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                            $categoria = new categoria($linha['idCategoria'], $linha['descricao'], $linha['situacao']);
                                                                            if ($categoria->getId() == $idCategoria) {
                                                                                echo '<option value="'.$categoria->getId().'" selected="">'.$categoria->getDescricao().'</option>';
                                                                            } else {
                                                                                echo '<option value="'.$categoria->getId().'">'.$categoria->getDescricao().'</option>';
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
                                                    <div class="col-xl-5 col-xxl-4">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Prioridade</span>
                                                                <select class="form-select" id="prioridade" required="" name="prioridade">
                                                                    <option value="" selected="">Selecione uma opção</option>
                                                                    <?php
                                                                        $pdo = Conexao::getInstance(); 
                                                                        $consulta = $pdo->query("SELECT * FROM prioridade WHERE situacao = 1");
                                                                        while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                                                                            $prioridade = new prioridade($linha['idPrioridade'], $linha['descricao'], $linha['situacao']);
                                                                            if ($prioridade->getId() == $idPrioridade) {
                                                                                echo '<option value="'.$prioridade->getId().'" selected="">'.$prioridade->getDescricao().'</option>';
                                                                            } else {
                                                                                echo '<option value="'.$prioridade->getId().'">'.$prioridade->getDescricao().'</option>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <div class="input-group"><span class="input-group-text">Título</span><input class="form-control" type="text" id="titulo" name="titulo" value="<?php echo $titulo;?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="descricao"><strong>Descrição</strong><br></label><textarea class="form-control" id="summernote" name="descricao"><?php echo $descricao;?></textarea></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3"><button class="btn btn-primary" type="submit" style="margin-right: 10px;" name="acao" value="<?php echo $value;?>">Salvar</button><a class="btn btn-primary" role="button" href="filaAtendimentos.php">Voltar</a></div>
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
    <script src="assets/js/buscaUsuariosSetor.js"></script>
    <script src="assets/js/modalCliente.js"></script>
    <script src="assets/js/buscaCliente.js"></script>
    <script src="assets/js/validar.js"></script>
</body>

</html>