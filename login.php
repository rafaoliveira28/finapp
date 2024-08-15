<html>

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/jpg" href="img/logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="js/sweetalert.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/fonts.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <title>FinApp - Login</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card my-5 shadow">

                    <form id="formlogin" method="post" action="core/valida.php" class="card-body cardbody-color p-lg-5">
                        <!-- <h2 class="text-center text-dark mt-5">awsadmin</h2> -->

                        <div class="text-center">
                            <img src="img/logo.png" class="img-fluid profile-image-pic img-thumbnail my-3" width="200px"
                                alt="profile">
                        </div>
                        <div class="mb-3">
                            <input required type="text" class="form-control" id="login" name="login" aria-describedby="emailHelp"
                                placeholder="E-mail">
                        </div>
                        <div class="mb-3">
                            <input required type="password" class="form-control" id="senha" name="senha" placeholder="Senha">
                        </div>
                        <?php
                        if (isset($_GET['inc'])) {
                            $inc = $_GET['inc'];
                            if ($inc == '1') {
                                echo "<p class='incorreto'>Usuário ou senha incorretos!</p>";
                            }
                        }
                        ?>
                        <div class="text-center"><button type="submit"
                                class="btn btn-primary px-5 w-100">Entrar</button>
                        </div>
                        <div id="emailHelp" class="form-text text-center mb-5 text-dark">Ainda não possui cadastro?
                            Clique
                            <a href="cadastroCliente.php" class="text-dark fw-bold">Aqui!</a>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    
</body>

<script src="js/alertas.js"></script>

<?php
if (isset($_GET['confirm'])) {
    $confirm = $_GET['confirm'];
    $msg = $_GET['msg'];
    if ($confirm == '1') { 
        echo "<script>resultadoCadastro('$msg');</script>";
    }
} ?>

</html>