<?php
require 'core/seguranca.php';
require_once 'classes/pedido.class.php';
require_once 'classes/produto.class.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        $ids_prodserv = $_POST["idprodserv"];
        $qtd_prodserv = $_POST["ca_quantidade"];

        if (empty($ids_prodserv) || empty($qtd_prodserv)) {
            header("Location: index.php?confirm=2&msg=Um pedido precisa conter produtos ou serviços!");
            exit();
        }
         DB::beginTransaction(); 

        $idusuario = $_SESSION['usuarioID'];
        Pedido::incluirPedido($idusuario);

        $ultimoPedido = DB::lastInsertId();

        if (!$ultimoPedido) {
            throw new Exception("Erro ao obter o último pedido.");
        }

        foreach ($ids_prodserv as $key => $idprodserv) {
            $dadosproduto = Produto::dadosProduto($idprodserv);

            if (empty($dadosproduto)) {
                throw new Exception("Produto não encontrado: $idprodserv.");
            }

            $quantidade = $dadosproduto[0]['ca_quantidade'] - $qtd_prodserv[$key];

            if ($quantidade < 0) {
                throw new Exception("Quantidade insuficiente para o produto: " . $dadosproduto[0]['ca_nome']);
            }

            error_log("Atualizando produto ID: $idprodserv");
            error_log("Quantidade antes: " . $dadosproduto[0]['ca_quantidade'] . ", Quantidade depois: $quantidade");

            $produto = new Produto(
                $dadosproduto[0]['ca_produtoativo'],
                $dadosproduto[0]['ca_nome'],
                "$quantidade",
                $_SESSION['usuarioID'],
                $dadosproduto[0]['ca_custo'],
                $dadosproduto[0]['ca_valor'],
                $dadosproduto[0]['ca_tipo']
            );

            error_log("Tentando atualizar produto ID: $idprodserv");

            try {
                $produto->updateProduto($idprodserv);
            } catch (PDOException $e) {
                error_log("Erro ao atualizar produto ID: $idprodserv - " . $e->getMessage());
                throw $e;
            }

            error_log("Produto atualizado com sucesso ID: $idprodserv");

            error_log("Tentando adicionar produto ao pedido ID do pedido: $ultimoPedido, ID do produto: $idprodserv");

            try {
                $produto->setQuantidade($qtd_prodserv[$key]);
                $produto->adicionaProdutoPedido($ultimoPedido, $idprodserv);
            } catch (PDOException $e) {
                error_log("Erro ao adicionar produto ao pedido ID do pedido: $ultimoPedido, ID do produto: $idprodserv - " . $e->getMessage());
                throw $e;
            }

            error_log("Produto adicionado ao pedido ID do pedido: $ultimoPedido, ID do produto: $idprodserv");
        }

         DB::commit(); 

        header("Location: index.php?confirm=1&msg=Pedido incluído!");
        exit();
    } catch (PDOException $e) {
         DB::rollBack(); 
        error_log("PDOException: " . $e->getMessage());
        echo "Erro de banco de dados: " . $e->getMessage();
    }
}
