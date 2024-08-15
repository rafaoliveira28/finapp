<?php
include 'layout/top_layout.php';
require_once 'core/seguranca.php';
require_once 'classes/produto.class.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>FinApp - Produtos/Serviços</title>
</head>

<body>
    <div class='container-fluid'>
    <h3 class="font-weight-bold text-primary">Produtos/Serviços</h3><br>
        <div class="d-flex justify-content-start" style="margin-bottom: 8px;">
            <button type='button' class='btn btn-success' data-bs-toggle='modal'
                data-bs-target='#inclui_cliente'>Incluir Produto/Serviço</button>&nbsp
            <form method="post">
                <select required onchange="this.form.submit()" class='form-select' id='filtro' name="filtro">
                    <option></option>
                    <option value="1">Produtos</option>
                    <option value="0">Serviços</option>
                    <option value="2">Ativos</option>
                    <option value="3">Inativos</option>
                    <option value="4">Todos</option>
                </select>
            </form>
        </div>
    </div>

    <?php
    $produtos = Produto::listaProdutos($_SESSION['usuarioID'], "6");
    if (isset($_POST['filtro'])) {
        $produtos = Produto::listaProdutos($_SESSION['usuarioID'], $_POST['filtro']);
        ;
    }
    ?>

    <div class="modal fade" id="inclui_cliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class='container-fluid'>
                    <div class="card-body">
                        <form action="core/cadastroprodutocore.php" method="post">
                            <div class="input-group mb-3">
                                <div class="form-check form-switch">
                                    <input name="ativo" class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault" checked>Ativo</input>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nomeproduto" class="form-label">Nome</label>
                                <input class='form-control' aria-describedby='basic-addon1' type="nomeproduto"
                                    name="nomeproduto" />

                                <label for="quantidade" class="form-label">Estoque inicial</label>
                                <input class='form-control' aria-describedby='basic-addon1' type="quantidade"
                                    name="quantidade" />

                                <label for="custo" class="form-label">Custo Unitário</label>
                                <input class='form-control' aria-describedby='basic-addon1' type="custo" name="custo" />

                                <label for="valor" class="form-label">Valor final Unitário</label>
                                <input class='form-control' aria-describedby='basic-addon1' type="valor" name="valor" />

                                <label for="tipo" class="form-label">Tipo do Produto/Serviço</label>
                                <select required class='form-select' id='tipo' name="tipo">
                                    <option value="">Selecione</option>
                                    <option value="1">Produto</option>
                                    <option value="0">Serviço</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type='submit' class="btn btn-success">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/alertas.js"></script>
    <?php
    if (isset($_GET['confirm'])) {
        $confirm = $_GET['confirm'];
        $msg = $_GET['msg'];
        if ($confirm == '1') {
            echo "<script>alertaSucesso('$msg');</script>";
        }
    }
    //Listar produtos cadastrados para o Usuário logado
    
    ?>
    <div class='container-fluid'>
        <div class='card mb-4 shadow'>
            <div class='card-body'>
                <table class='table table-sm table-hover' id='dataTable'>
                    <?php
                    if (!is_string($produtos)) {
                        foreach ($produtos as $produto) {
                            $nome = (strlen($produto['ca_nome']) > 29) ? substr($produto['ca_nome'], 0, 29) . '...' : $produto['ca_nome'];
                            if ($produto['ca_tipo'] == 1) {
                                $tipo = "Produto";
                            } else {
                                $tipo = "Serviço";
                            } ?>
                            <tr>
                                <td>
                                    <li>
                                        <b><?php echo "$nome" ?></b>
                                        <p>
                                            <i><?php echo "&nbsp&nbsp&nbsp&nbsp&nbspValor Unitário: R$$produto[ca_valor]"; ?></i><br>
                                            <i
                                                style='font-size: 12px;'><?php echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspCód. $produto[idprodserv] - $tipo"; ?></i><br>
                                            <?php
                                            if ($produto['ca_produtoativo'] == 0) { ?>
                                                <i
                                                    style='font-size: 12px; color: red;'><?php echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$tipo INATIVO"; ?></i> <?php
                                            }
                                            ?>
                                        </p>
                                    </li>
                                </td>
                                <!-- <?php echo "<td>$produto[idprodserv]</td>
                                        <td>$produto[ca_nome]</td><td>$produto[ca_valor]</td>
                                        <td>$tipo</td>"; ?> -->
                                <td style='text-align: right;'>
                                    <a data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw mr-2 text-gray-700"></i>
                                    </a>
                                    <div class="dropdown-menu shadow">
                                        <a class="dropdown-item"
                                            href="cadastroProdutoServico.php?idproduto=<?php echo $produto['idprodserv']; ?>">Editar</a>
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
</body>

</html>