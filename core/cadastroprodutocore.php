<?php
require 'seguranca.php';
$dbfile = 'classes/db.class.php';
$produtofile = 'classes/produto.class.php';

if (file_exists($dbfile)) {
    require_once $dbfile;
    require_once $produtofile;
} else {
    require_once '../' . $dbfile;
    require_once '../' . $produtofile;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ativo = $_POST['ativo'];
    $nomeproduto = $_POST['nomeproduto'];
    $quantidade = $_POST['quantidade'];
    $custo = str_replace(",", ".", $_POST['custo']);
    $valor = str_replace(",", ".", $_POST['valor']);
    $tipo = $_POST['tipo'];
    $idusuario = $_SESSION['usuarioID'];

    if ($ativo == 'on') {
        $ativo = '1';
    } else {
        $ativo = '0';
    }

    $produto = new Produto("$ativo", "$nomeproduto", "$quantidade", "$idusuario", "$custo", "$valor", "$tipo");

    try {
        $cadastroproduto = $produto->novoProduto();
    } finally {
        header('Location: ../produtoServico.php?confirm=1&msg=' . $cadastroproduto);
    }
}