<?php
require 'core/seguranca.php';
require_once 'classes/pedido.class.php';
require_once 'classes/produto.class.php';
include 'core/alerts.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    try {
        
        $idusuario = $_SESSION['usuarioID'];
        $paginas = $_GET['pagina'];

        if (isset($_GET['idpedido'])) {
            $idpedido = $_GET['idpedido'];
            $retorno = Pedido::validaExclusaoPedido($idpedido, $idusuario);
            if (empty($retorno)) {
                header("Location: $paginas?confirm=3&msg=Pedido não encontrado");
            } else {
                header("Location: $paginas?confirm=1&msg=Pedido excluído!");
            }
        } else {
            header("Location: $paginasconfirm=2&msg=Erro ao excluir pedido");
            exit();
        }
        
        
    } catch (Exception $e) {
        // Desfazer a transação em caso de erro
        echo "Erro: " . $e->getMessage();
    }
}