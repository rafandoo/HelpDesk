<!DOCTYPE html>
<?php
    $title = "Login - HelpDesk";
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

<body class="bg-gradient-primary">
    <div class="container">
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="row">
                <div class="col-md-12 col-lg-20">
                    <div class="card shadow-lg o-hidden border-0 my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-12 col-xxl-12">
                                    <div class="p-5">
                                        <div class="d-print-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex d-xxl-flex align-items-sm-end mb-3"><img class="img-fluid" src="assets/img/logo/fox.png" width="100px" height="100px">
                                            <h2 class="text-dark mb-4 float-end" style="padding-right: 0px;min-width: 200px;padding-top: 0;margin-left: 15px;">Help Desk - Fox</h2>
                                        </div>
                                        <form class="user" method="post" action="action/actLogin.php">
                                            <div class="mb-3"><input class="form-control form-control-user" type="text" id="usuario" placeholder="Usuário" name="usuario" aria-describedby="email"></div>
                                            <div class="mb-3"><input class="form-control form-control-user" type="password" id="senha" placeholder="Senha" name="senha"></div>
                                            <hr><button class="btn btn-primary d-block btn-user w-100 mb-3" type="submit" name="acao" value="logar">Login</button>
                                        </form>
                                        <div class="text-center" hidden><a class="small" href="esqueceuSenha.php">Esqueceu a senha?</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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