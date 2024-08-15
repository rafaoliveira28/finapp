<?php
require 'layout/top_layout.php';
require_once 'core/seguranca.php';
require_once 'classes/produto.class.php';
require_once 'classes/pedido.class.php';
include 'core/alerts.php';

$idpedido = $_GET['idpedido'];

$pedido = Pedido::dadosPedido($idpedido);

if ($pedido) {
    $pedidoobj = new Pedido($pedido[0]['idpedido'], $pedido[0]['CA_USUARIO_idusuario'], $pedido[0]['ca_datapedido']);
    $idclientepedido = $pedidoobj->getIdClientePedido();
    $datapedido = $pedidoobj->getDataPedido();
    $datapedidoformatado = date("d/m/y-H:i", strtotime($datapedido));
    if ($idclientepedido != $_SESSION['usuarioID']) {
        echo "<h1>NÃO AUTORIZADO</h1>";
        exit();
    }
} else {
    echo "<script>window.location.href = 'index.php?confirm=1&msg=Pedido não encontrado.';</script>";
    exit(); // Encerra o script para evitar execução adicional
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinApp - Visualizar Pedido</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
    <div class='container-fluid' style='margin-top: 40px;'>
        <div class='card mb-4 shadow'>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <div class="mb-3">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="idpedido" class="form-label">Cód. Pedido</label>
                                        <input class='form-control' disabled aria-describedby='basic-addon1'
                                            name="idpedido" value="<?php echo "$idpedido"; ?>" />
                                    </div>
                                    <div class="col">
                                        <label for="datapedido" class="form-label">Data</label>
                                        <input disabled class='form-control' aria-describedby='basic-addon1'
                                            name="datapedido" value="<?php echo "$datapedidoformatado"; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5 class="card-title">Produtos</h5>
                        <?php
                        $produtos = Pedido::produtosPedido($idpedido); ?>
                        <table class="table table-sm">
                            <?php foreach ($produtos as $produto) {
                                //Corta o nome do produto pra 29 caracteres, pra não quebrar linhas.
                                $nome = (strlen($produto['ca_nome']) > 29) ? substr($produto['ca_nome'], 0, 29) . '...' : $produto['ca_nome'];
                                $total_produto = $produto['ca_qtd'] * $produto['ca_valor'];
                                ?>
                                <tr>
                                    <td>
                                        <li>
                                            <b><?php echo "$nome - $produto[ca_qtd] un."; ?></b>
                                        </li>
                                        <p>
                                            <i><?php echo "&nbsp&nbsp&nbsp&nbsp&nbspR$$produto[ca_valor] por unidade - Total: R$$total_produto"; ?></i><br>
                                            <i
                                                style='font-size: 12px;'><?php echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspCód. $produto[CA_PROD_SERV_idprodserv]"; ?></i>
                                        </p>

                                    </td>
                                </tr>
                            <?php }
                            $total_pedido = Pedido::valorTotalPedido($idpedido); ?>
                        </table>
                        <p>
                            Total do pedido: <b><?php echo "R$$total_pedido"; ?></b>
                        </p>

                    </div>
                    <div style='text-align: right'>
                    <input class='btn btn-sm btn-danger' type='button' value='Excluir'
                    onclick="confirmaDeletaPedido('<?php echo $idpedido; ?>', 'pedidos.php');">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>