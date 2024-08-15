<!DOCTYPE html>
<html>

<head>
    <?php include 'layout/top_layout.php';
    include 'core/alerts.php';
    require 'classes/pedido.class.php'; ?>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/incpedido.js"></script>
    <script src="js/alertas.js"></script>
    <title>FinApp - Início</title>
</head>

<body>
    <?php $pedidos = Pedido::ultimosPedidos($_SESSION['usuarioID']); ?>
    <div class="modal fade" id="inclui_pedido" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class='container-fluid'>
                    <div class="modal-header">
                        <div class="container">
                            <div class="row" style="width: 100%;">
                                <h4><label for="search">Incluir Pedido</label></h4>
                                <input class='form-control' aria-describedby='basic-addon1' type='text' id="search"
                                    placeholder="Selecione o produto ou serviço">
                            </div>
                            <br>
                            <div class="row">
                                <div class="list-group" style="display: none;" id="results"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" id="form" action="addpedido.php">
                            <div class="input-group mb-3">
                                <div class="mb-3" style="width: 20%;" id="idprodserv">
                                </div>&nbsp;
                                <div class="mb-3" style="flex-grow: 1; max-width: 44%;" id="ca_nome">
                                </div>&nbsp;
                                <div class="mb-3" style="width: 19%;" id="ca_valor">
                                </div>&nbsp;
                                <div class="mb-3" style="width: 13%;" id="ca_quantidade">
                            </div>
                            </div>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div style="text-align: right;" class="col-md-4 offset-md-4">
                                <h4 id="valor_total"></h4>
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type='submit' class="btn btn-success" id='submitBtn'>Incluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='row' style='margin-bottom: 8px;'>
        <div class='col-lg-2'>
            <div class='container-fluid'>
                <form method="post">
                    <div class="floating-button">
                        <button type='button' data-bs-toggle='modal' data-bs-target='#inclui_pedido'>+</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class='card mb-4 py-3 border-bottom-success shadow'>
                    <div class='card-body' data-toggle="tooltip" data-placement="top"
                        title="Quantidade total de Pedidos do dia">
                        <div class='row no-gutters align-items-center'>
                            <div class='col mr-2'>
                                <div class='text-xs font-weight-bold text-primary text-uppercase mb-1'>Pedidos hoje
                                </div>
                                <div class='h5 mb-0 font-weight-bold text-gray-800'>
                                    <?php
                                    $totalPedidos = count($pedidos);
                                    echo "$totalPedidos";
                                    ?>
                                </div>
                            </div>
                            <div class='col-auto'><i class='fas fa-book fa-2x text-gray-300'></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class='card mb-4 py-3 border-bottom-success shadow'>
                    <div class='card-body' data-toggle="tooltip" data-placement="top"
                        title="Valor total de todos os Pedidos do dia">
                        <div class='row no-gutters align-items-center'>
                            <div class='col mr-2'>
                                <div class='text-xs font-weight-bold text-primary text-uppercase mb-1'>Total hoje($)
                                </div>
                                <div class='h5 mb-0 font-weight-bold text-gray-800'>
                                    <?php
                                    $somaTotalPedidos = 0;
                                    foreach ($pedidos as $valorTotalPedido) {
                                        $valorPedido = Pedido::valorTotalPedido($valorTotalPedido['idpedido']);
                                        $valorPedido = str_replace(",", ".", $valorPedido);
                                        $somaTotalPedidos += $valorPedido;
                                    }
                                    $somaTotalPedidos = number_format($somaTotalPedidos, 2, ',', '.');
                                    echo "R$ " . $somaTotalPedidos;
                                    ?>
                                </div>
                            </div>
                            <div class='col-auto'><i class='fas fa-dollar-sign fa-2x text-gray-300'></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class='card mb-4 shadow' style="min-height: 520px;">
                    <div class='card-body'>
                        <div class='table-responsive'>
                            <table class='table table-sm table-hover' id='dataTable' width='100%' cellspacing='0'>
                                    <?php
                                        if (empty($pedidos)) { ?>
                                        <div class="container" style="margin-top: 50%; text-align: center;">
                                            <h5'>Ainda não foram incluídos pedidos hoje.</h5>
                                        </div>
                                      <?php  } else {   ?>
                                <div class='text-xs font-weight-bold text-primary text-uppercase mb-1'>Detalhamento dos pedidos do dia</div>
                                <tr>
                                    <th>Pedido</th>
                                    <th>Hora</th>
                                    <th>Total</th>
                                    <th style='text-align: right;'>Ações</th>
                                </tr>
                                <?php
                                foreach ($pedidos as $pedido) {
                                    $valorTotalPedido = Pedido::valorTotalPedido($pedido['idpedido']);
                                    $data_pedido = date("H:i", strtotime($pedido['ca_datapedido'])); ?>
                                    <tr>
                                        <td><?php echo $pedido['idpedido']; ?></td>
                                        <td><?php echo $data_pedido; ?></td>
                                        <td><?php echo $valorTotalPedido; ?></td>
                                        <td style='text-align: right;'>
                                            <a data-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw mr-2 text-gray-700"></i>
                                            </a>
                                            <div class="dropdown-menu shadow">
                                                <a class="dropdown-item" href="manipulaPedido.php?idpedido=<?php echo $pedido['idpedido']; ?>">Visualizar</a>
                                                <a class="dropdown-item" onclick="confirmaDeletaPedido('<?php echo $pedido['idpedido']; ?>', '<?php echo $pagina; ?>');" style="color: red;">Excluir</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='row' style='margin-bottom: 8px;'>
            <div class='col-lg-2'>
                <div class='container-fluid shadow'>
                    <form method="post">
                        <div class="floating-button">
                            <button type='button' data-bs-toggle='modal' data-bs-target='#inclui_pedido'>+</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>
</html>