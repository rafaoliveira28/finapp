<?php
class Produto
{
    private $ativo;
    private $nomeproduto;
    private $quantidade;
    private $idusuario;
    private $custo;
    private $valor;
    private $tipo;

    public function __construct($ativo, $nomeproduto, $quantidade, $idusuario, $custo, $valor, $tipo)
    {
        $this->ativo = $ativo;
        $this->nomeproduto = $nomeproduto;
        $this->quantidade = $quantidade;
        $this->idusuario = $idusuario;
        $this->custo = $custo;
        $this->valor = $valor;
        $this->tipo = $tipo;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }

    public function getUsuario()
    {
        return $this->idusuario;
    }

    public function getNomeproduto()
    {
        return $this->nomeproduto;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function getCusto()
    {
        return $this->custo;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    public function setNomeProduto($nomeproduto)
    {
        $this->nomeproduto = $nomeproduto;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function setIdUsuario($idusuario)
    {
        $this->idusuario = $idusuario;
    }

    public function setCusto($custo)
    {
        $this->custo = $custo;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function novoProduto()
    {
        try {
            $conn = DB::connect();

            // Inserir novo produto no banco
            $query = "INSERT INTO ca_prod_serv (ca_nome, ca_quantidade, ca_valor, ca_custo, CA_USUARIO_idusuario, ca_tipo, ca_produtoativo) VALUES (:ca_nome, :ca_quantidade, :ca_valor, :ca_custo, :CA_USUARIO_idusuario, :ca_tipo, :ca_produtoativo)";
            $stmt = $conn->prepare($query);

            // Bind dos parâmetros
            $stmt->bindParam(':ca_nome', $this->nomeproduto);
            $stmt->bindParam(':ca_quantidade', $this->quantidade);
            $stmt->bindParam(':ca_valor', $this->valor);
            $stmt->bindParam(':ca_custo', $this->custo);
            $stmt->bindParam(':CA_USUARIO_idusuario', $this->idusuario);
            $stmt->bindParam(':ca_tipo', $this->tipo);
            $stmt->bindParam(':ca_produtoativo', $this->ativo);

            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            return "Produto cadastrado com sucesso!";
            //return $errorInfo;

        } catch (PDOException $e) {
            return "$errorInfo";
        } finally {
            $conn = null;
        }
    }

    public static function listaProdutos($idusuario, $filtro)
    {
        try {
            $conn = DB::connect();

            switch ($filtro) {
                case 0:
                    $query = "SELECT * FROM ca_prod_serv WHERE CA_USUARIO_idusuario = :idUsuario AND ca_tipo = '0' ORDER BY ca_nome";
                    break;
                case 1:
                    $query = "SELECT * FROM ca_prod_serv WHERE CA_USUARIO_idusuario = :idUsuario AND ca_tipo = '1' ORDER BY ca_nome";
                    break;
                case 2:
                    $query = "SELECT * FROM ca_prod_serv WHERE CA_USUARIO_idusuario = :idUsuario AND ca_produtoativo = '1' ORDER BY ca_nome";
                    break;
                case 3:
                    $query = "SELECT * FROM ca_prod_serv WHERE CA_USUARIO_idusuario = :idUsuario AND ca_produtoativo = '0' ORDER BY ca_nome";
                    break;
                default:
                    $query = "SELECT * FROM ca_prod_serv WHERE CA_USUARIO_idusuario = :idUsuario ORDER BY ca_nome";
                    break;

            }

            $stmt = $conn->prepare($query);

            // Bind do parâmetro
            $stmt->bindParam(':idUsuario', $idusuario);

            $stmt->execute();

            // Retorna os resultados da consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return "Erro ao buscar produtos: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }

    public static function dadosProduto($idproduto)
    {
        try {
            $conn = DB::connect();

            // Consulta para buscar produtos por ID do usuário
            $query = "SELECT * FROM ca_prod_serv WHERE idprodserv = :idproduto";
            $stmt = $conn->prepare($query);

            // Bind do parâmetro
            $stmt->bindParam(':idproduto', $idproduto);

            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            // Retorna os resultados da consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return $errorInfo;

        } catch (PDOException $e) {
            return "Erro ao buscar cadastro do produto: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }

    public function updateProduto($idproduto)
    {
        $conn = DB::connect();

        // Inserir novo produto no banco
        $query = "UPDATE ca_prod_serv set ca_produtoativo = :ativo, ca_quantidade = :quantidade, ca_valor = :valor, ca_custo = :custo WHERE idprodserv = :idproduto";
        $stmt = $conn->prepare($query);

        // Bind dos parâmetros
        $stmt->bindParam(':ativo', $this->ativo);
        $stmt->bindParam(':quantidade', $this->quantidade);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':custo', $this->custo);
        $stmt->bindParam(':idproduto', $idproduto);

        $stmt->execute();
        $errorInfo = $stmt->errorInfo();
    }

    public function adicionaProdutoPedido($idpedido, $idproduto)
    {
        $conn = DB::connect();

        $query = "INSERT INTO ca_prod_serv_has_ca_pedido (CA_PROD_SERV_idprodserv, CA_PEDIDO_idpedido, ca_qtd, ca_valor, ca_custo) VALUES (:idproduto, :idpedido, :quantidade, :valor, :custo)";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idproduto', $idproduto);
        $stmt->bindParam(':idpedido', $idpedido);
        $stmt->bindParam(':quantidade', $this->quantidade);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':custo', $this->custo);

        $stmt->execute();
        $errorInfo = $stmt->errorInfo();

        return true;
    }
}