<!DOCTYPE html>
<html lang="pt-br">
<?php
ini_set('default_charset', "utf-8");
$secfile = 'core/seguranca.php';

if (file_exists($secfile)) {
    require $secfile;
} else {
    require '../' . $secfile;
}
date_default_timezone_set('America/Sao_Paulo');
?>

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
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</head>

<body id="page-top">

    <div id="wrapper">
        <ul class="navbar-nav sidebar toggled sidebar-dark bg-gradient-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <img src="img/logo.png" alt="" width="55" height="55" class="d-inline-block">
                </div>
                <div style="color: grey;" class="sidebar-brand-text mx-3">FinApp</div>
            </a>

        </ul>
        
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>