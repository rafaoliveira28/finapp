<html>
<script src="js/alertas.js"></script>
</html>
<?php
//captura a pagina
$uri = $_SERVER['REQUEST_URI'];
$uri = ltrim($uri, '/');
$uriparts = explode('/', $uri);
$pagina = end($uriparts);

if (isset($_GET['alert'])) {
    $alert = $_GET['alert'];
    switch ($alert) {
        case 1:
            echo "<script>resultadoCadastro('Pedido incluido!');</script>";
            break;
        case 2:
            echo "<script>resultadoCadastro('Erro ao excluir pedido');</script>";
            break;
        case 3:
            echo "<script>resultadoCadastro('Pedido excluido!');</script>";
            break;
        case 4:
            echo "<script>resultadoCadastro('Pedido não encontrado');</script>";
            break;
    }
}

if (isset($_GET['confirm'])) {
    $confirm = $_GET['confirm'];
    $msg = $_GET['msg'];
    
    switch ($confirm) {
        case 1:
            echo "<script>alertaSucesso('$msg');</script>";
            break;
        case 2:
            echo "<script>alertaErro('$msg');</script>";
            break;
        default:
            echo "<script>alertaDesconhecido('$msg');</script>";
            break;
    }
}

?>
