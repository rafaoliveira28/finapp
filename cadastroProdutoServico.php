<?php
require 'layout/top_layout.php';
require_once 'core/seguranca.php';
require_once 'classes/produto.class.php';

$idproduto = $_GET['idproduto'];


$produto = Produto::dadosProduto($idproduto);

if ($produto) {
    $produtoobj = new Produto($produto[0]['ca_produtoativo'], $produto[0]['ca_nome'], $produto[0]['ca_quantidade'], $produto[0]['CA_USUARIO_idusuario'], $produto[0]['ca_custo'], $produto[0]['ca_valor'], $tipo = $produto[0]['ca_tipo']);
    $nome = $produtoobj->getNomeproduto();
    $valornf = $produtoobj->getValor();
    $tipo = $produtoobj->getTipo();
    $custonf = $produtoobj->getCusto();
    $quantidade = $produtoobj->getQuantidade();
    $ativo = $produtoobj->getAtivo();
    $usuario = $produtoobj->getUsuario();
} else {
    echo "<script>window.location.href = 'produtoServico.php?confirm=1&msg=Produto não encontrado.';</script>";
    exit(); // Encerra o script para evitar execução adicional
}
$custo = str_replace(".", ",", $custonf);
$valor = str_replace(".", ",", $valornf);

if ($_SESSION['usuarioID'] != $usuario) {
    echo "<script>window.location.href = 'produtoServico.php?confirm=1&msg=Você não pode alterar esse produto.';</script>";
    exit(); // Encerra o script para evitar execução adicional
}

if ($tipo == "1") {
    $tipo = "Produto";
} else {
    $tipo = "Serviço";
}
?>

<html>

<head>
    <title>
        <?php echo "$nome"; ?>
    </title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
    <div class='container-fluid' style='margin-top: 40px;'>
        <div class='card mb-4 shadow'>
            <div class="card-body">
                <h3 class="card-title">
                    <?php echo "$nome"; ?>
                </h3>
                <form method="post">
                    <div class="mb-3">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <div class="mb-3">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php
                                    if ($ativo == "1") { ?>
                                        <input name="ativo" class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckDefault" checked>Ativo</input>
                                    <?php } else { ?>
                                        <input name="ativo" class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckDefault">Ativo</input>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="quantidade" class="form-label">Estoque</label>
                                        <input class='form-control' aria-describedby='basic-addon1' type="quantidade"
                                            name="quantidade" value="<?php echo "$quantidade"; ?>" />
                                    </div>
                                    <div class="col">
                                        <label class="form-label" id="tipo" for="tipo">Tipo</label>
                                        <input disabled class='form-control' aria-describedby='basic-addon1' name="tipo"
                                            value="<?php echo "$tipo"; ?>" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label" id="valor" for="valor">Valor</label>
                                        <input class='form-control' aria-describedby='basic-addon1' name="valor"
                                            value="<?php echo "$valor"; ?>" />
                                    </div>
                                    <div class="col">
                                        <label class="form-label" id="custo" for="custo">Custo</label>
                                        <input class='form-control' aria-describedby='basic-addon1' name="custo"
                                            value="<?php echo "$custo"; ?>" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                    
                    $custo_total = number_format((float)$custonf * (float)$quantidade, 2, ',', '.');
                    $valor_total = number_format((float)$valornf * (float)$quantidade, 2, ',', '.');
                    ?>
                    <div class="mb-3">
                        <h4 class="card-title">Estatísticas</h4>
                        <div class="row">
                            <div class="col">
                                <label class="form-label" id="custo_total" for="custo_total">Estoque total
                                    (custo)</label>

                                <input disabled class='form-control' aria-describedby='basic-addon1' name="custo_total"
                                    value="<?php echo "R$ $custo_total"; ?>" />
                            </div>
                            <div class="col">
                                <label class="form-label" id="valor" for="valor_total">Estoque total
                                    (valor)</label>
                                <input disabled class='form-control' aria-describedby='basic-addon1' name="valor_total"
                                    value="<?php echo "R$ $valor_total"; ?>" />
                            </div>
                        </div>
                    </div>
                    <div style='text-align: right'>
                        <button type='submit' class='btn btn-sm btn-success btn-lg'>Salvar</button>
                        <input class='btn btn-sm btn-danger' type='button' value='Cancelar' onclick='history.go(-1)'>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ( $_POST['ativo'] == 'on' ) {
        $ativo = '1';
    } else {
        $ativo = '0';
    }
    
    $valorobj = str_replace(",", ".", $_POST['valor']);
    $custoobj = str_replace(",", ".", $_POST['custo']);

    $produtoobj->setAtivo($ativo);
    $produtoobj->setQuantidade($_POST['quantidade']);
    $produtoobj->setValor($valorobj);
    $produtoobj->setCusto($custoobj);
    $produtoobj->updateProduto($idproduto);

    ?> <script>window.location.href='produtoServico.php?confirm=1&msg=Produto atualizado com sucesso' </script> <?php

}
?>
</html>