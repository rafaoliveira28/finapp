<?php
include 'layout/top_layout.php';
require_once 'core/seguranca.php';
require_once 'classes/produto.class.php';
require_once 'classes/pedido.class.php';
include 'core/alerts.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>FinApp - Pedidos</title>
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/classic.css">
    <link rel="stylesheet" href="css/classic.date.css">
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
</head>

<?php
$pedidos = Pedido::pedidosUsuarioDia($_SESSION['usuarioID'], 30);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['from_date'])) {
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];

        $pedidos = Pedido::pedidosUsuarioGap($_SESSION['usuarioID'], $from_date, $to_date);

    }
}


//Listar produtos cadastrados para o Usuário logado
?>

<body>
    <div class='container-fluid'>
        <h3 class="font-weight-bold text-primary">Pedidos</h3><br>
        <label>Filtrar por data:</label>
        <form method="post">
            <div class="d-flex justify-content-start" style="margin-bottom: 8px;">
                <input type="date" class="form-control" id="input_from" name="from_date" placeholder="Data Inicial"
                    style="max-width: 139px;">
                &nbsp<input type="date" class="form-control" id="input_to" name="to_date" placeholder="Data Final"
                    style="max-width: 139px;">
                &nbsp<button type="submit" class="btn btn-success">Filtrar</button>
                &nbsp<a href="pedidos.php" class="btn btn-primary">Limpar</a>
            </div>
        </form>
        <div class="alert alert-primary" role="alert">
            Por padrão são exibidos os pedidos dos últimos 30 dias.
        </div>
        <div class='card mb-4 shadow'>
            <div class='card-body'>
                <table class='table table-sm table-hover' id='dataTable'>
                    <thead>
                        <th class="text-primary">Cód.</th>
                        <th class="text-primary">Data</th>
                        <th class="text-primary">Valor</th>
                        <th style='text-align: right;' class="text-primary">Ações</th>
                    </thead>
                    <?php
                    if (!is_string($pedidos)) {
                        foreach ($pedidos as $pedido) { ?>
                            <tr> <?php
                            $valorTotalPedido = Pedido::valorTotalPedido($pedido['idpedido']);
                            $data_pedido = date("d/m-H:i", strtotime($pedido['ca_datapedido']));
                            echo "<td style='font-size: 15px;'>$pedido[idpedido]</td>
                            <td style='font-size: 15px;'>$data_pedido</td>
                            <td style='font-size: 15px;'>$valorTotalPedido</td>"; ?>
                                <td style='text-align: right; font-size: 15px;'>
                                    <a data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw mr-2 text-gray-700"></i>
                                    </a>
                                    <div class="dropdown-menu shadow">
                                        <a class="dropdown-item"
                                            href="manipulaPedido.php?idpedido=<?php echo $pedido['idpedido']; ?>">Visualizar</a>
                                        <a class="dropdown-item"
                                            onclick="confirmaDeletaPedido('<?php echo $pedido['idpedido']; ?>', '<?php echo $pagina; ?>');"
                                            style="color: red;">Excluir</a>
                                        <!-- href="deletepedido.php?idpedido=<?php echo $pedido['idpedido']; ?>&pagina=<?php echo $pagina; ?>" -->
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } ?>
                </table>
            </div>
        </div>
        <div class='card mb-4 shadow'>
            <div class='card-header py-3'>
                <h4 class="m-0 font-weight-bold text-primary">Estatísticas do filtro</h4>
            </div>
            <?php

            $qtdTotalPedidos = count($pedidos);
            $valorTotalPedidos = 0;
            $custoTotalPedidos = 0;
            $pedidoMaiorValor = 0;

            // Array para contar os pedidos em cada dia
            $contagemPorDia = array();

            foreach ($pedidos as $pedido) {

                $dataPedido = date("d/m", strtotime($pedido['ca_datapedido']));
                $totalPedido = floatval(str_replace(',', '.', Pedido::valorTotalPedido($pedido['idpedido'])));
                $custoPedido = floatval(str_replace(',', '.', Pedido::custoTotalPedido($pedido['idpedido'])));
                $valorTotalPedidos += $totalPedido;
                $custoTotalPedidos += $custoPedido;

                if ($totalPedido > $pedidoMaiorValor) {
                    $pedidoMaiorValor = $totalPedido;
                }

                // Conta os pedidos em cada dia
                if (!isset($contagemPorDia[$dataPedido])) {
                    $contagemPorDia[$dataPedido] = 1;
                } else {
                    $contagemPorDia[$dataPedido]++;
                }
            }

            // Encontra o dia com mais pedidos
            $diaMaisPedidos = null;
            $quantidadeMaxima = 0;
            foreach ($contagemPorDia as $data => $quantidade) {
                if ($quantidade > $quantidadeMaxima) {
                    $diaMaisPedidos = $data;
                    $quantidadeMaxima = $quantidade;
                }
            }
            ?>

            <div class="card-body">
                <i>Total de pedidos: <b><?php echo "$qtdTotalPedidos"; ?></b></i><br>
                <i>Valor total: <b><?php echo "R$" . number_format($valorTotalPedidos, 2, ',', '.'); ?></b></i><br>
                <i>Custo total: <b><?php echo "R$" . number_format($custoTotalPedidos, 2, ',', '.'); ?></b></i><br>
                <i>Maior valor de um pedido:
                    <b><?php echo "R$" . number_format($pedidoMaiorValor, 2, ',', '.'); ?></b></i><br>
                <i>Dia com mais pedidos:
                    <b><?php echo $diaMaisPedidos . " com " . $quantidadeMaxima . " pedidos"; ?></b></i><br>
            </div>
        </div>
        <div class="card mb-4 shadow">
            <?php

            $pedidos2 = Pedido::pedidosUsuario($_SESSION['usuarioID']);

            $qtdTotalPedidos2 = count($pedidos2);
            $valorTotalPedidos2 = 0;
            $custoTotalPedidos2 = 0;
            $pedidoMaiorValor2 = 0;

            // Array para contar os pedidos em cada dia
            $contagemPorDia2 = array();

            foreach ($pedidos2 as $pedido) {

                $dataPedido = date("m/Y", strtotime($pedido['ca_datapedido']));
                $totalPedido = floatval(str_replace(',', '.', Pedido::valorTotalPedido($pedido['idpedido'])));
                $custoPedido = floatval(str_replace(',', '.', Pedido::custoTotalPedido($pedido['idpedido'])));
                $valorTotalPedidos2 += $totalPedido;
                $custoTotalPedidos2 += $custoPedido;

                if ($totalPedido > $pedidoMaiorValor2) {
                    $pedidoMaiorValor2 = $totalPedido;
                }

                // Conta os pedidos em cada dia
                if (!isset($contagemPorDia2[$dataPedido])) {
                    $contagemPorDia2[$dataPedido] = 1;
                } else {
                    $contagemPorDia2[$dataPedido]++;
                }
            }

            // Encontra o dia com mais pedidos
            $diaMaisPedidos = null;
            $quantidadeMaxima = 0;
            foreach ($contagemPorDia2 as $data => $quantidade) {
                if ($quantidade > $quantidadeMaxima) {
                    $diaMaisPedidos = $data;
                    $quantidadeMaxima = $quantidade;
                }
            }
            ?>
            <div class='card-header py-3'>
                <h4 class="m-0 text-primary font-weight-bold">Estatísticas Gerais</h4>
            </div>
            <div class="card-body">
                <i>Total de pedidos: <b><?php echo "$qtdTotalPedidos2"; ?></b></i><br>
                <i>Valor total: <b><?php echo "R$" . number_format($valorTotalPedidos2, 2, ',', '.'); ?></b></i><br>
                <i>Custo total: <b><?php echo "R$" . number_format($custoTotalPedidos2, 2, ',', '.'); ?></b></i><br>
                <i>Maior valor de um pedido:
                    <b><?php echo "R$" . number_format($pedidoMaiorValor2, 2, ',', '.'); ?></b></i><br>
                <i>Mês com mais pedidos:
                    <b><?php echo $diaMaisPedidos . " com " . $quantidadeMaxima . " pedidos"; ?></b></i><br>
            </div>
        </div>
    </div>
</body>
<script src="js/alertas.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/picker.js"></script>
<script src="js/picker.date.js"></script>
<script src="js/main.js"></script>

</html>