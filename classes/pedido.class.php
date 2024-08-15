<?php
class Pedido
{
    private $idpedido;
    private $idclientepedido;

    private $datapedido;

    public function __construct($idpedido, $idclientepedido, $datapedido)
    {
        $this->idpedido = $idpedido;
        $this->idclientepedido = $idclientepedido;
        $this->datapedido = $datapedido;
    }

    public function getIdPedido()
    {
        return $this->idpedido;
    }

    public function getIdClientePedido()
    {
        return $this->idclientepedido;
    }

    public function getDataPedido()
    {
        return $this->datapedido;
    }

    public static function incluirPedido($idusuario)
    {
        try {
            $conn = DB::connect();

            $query = "INSERT INTO ca_pedido (CA_USUARIO_idusuario, ca_datapedido) VALUES (:idclientepedido, NOW())";
            $stmt = $conn->prepare($query);

            $idusuario = intval($idusuario);

            $stmt->bindParam(':idclientepedido', $idusuario);

            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            return $errorInfo;

        } finally {
            $conn = null;
        }
    }

    public static function valorTotalPedido($idpedido)
    {
        $conn = DB::connect();

        $query = "SELECT ca_valor, ca_qtd FROM ca_prod_serv_has_ca_pedido WHERE CA_PEDIDO_idpedido = :idpedido";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idpedido', $idpedido);

        $stmt->execute();
        $errorInfo = $stmt->errorInfo();

        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $valorTotal = 0;

        foreach ($pedidos as $valor) {
            $valor_produto = $valor['ca_valor'] * $valor['ca_qtd'];
            $valorTotal += $valor_produto;
        }

        $valor_formatado = number_format($valorTotal, 2, ',', '.');

        return $valor_formatado;
    }

    public static function custoTotalPedido($idpedido)
    {
        $conn = DB::connect();

        $query = "SELECT ca_custo, ca_qtd FROM ca_prod_serv_has_ca_pedido WHERE CA_PEDIDO_idpedido = :idpedido";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idpedido', $idpedido);

        $stmt->execute();
        $errorInfo = $stmt->errorInfo();

        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $valorTotal = 0;

        foreach ($pedidos as $valor) {
            $valor_produto = $valor['ca_custo'] * $valor['ca_qtd'];
            $valorTotal += $valor_produto;
        }

        $valor_formatado = number_format($valorTotal, 2, ',', '.');

        return $valor_formatado;
    }

    public static function ultimosPedidos($idusuario)
    {
        $conn = DB::connect();

        $query = "SELECT * FROM ca_pedido WHERE CA_USUARIO_idusuario = :idusuario AND DATE(ca_datapedido) = CURDATE() order by ca_datapedido desc";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idusuario', $idusuario);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function pedidosUsuario($idusuario)
    {
        $conn = DB::connect();

        $query = "SELECT * FROM ca_pedido WHERE CA_USUARIO_idusuario = :idusuario order by ca_datapedido desc";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idusuario', $idusuario);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function pedidosUsuarioDia($idusuario, $dias)
    {
        $conn = DB::connect();

        $query = "SELECT * FROM ca_pedido WHERE CA_USUARIO_idusuario = :idusuario AND ca_datapedido >= CURDATE() - INTERVAL :dias DAY order by ca_datapedido desc";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idusuario', $idusuario);
        $stmt->bindParam(':dias', $dias);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function pedidosUsuarioGap($idusuario, $datainicial, $datafinal)
    {
        $conn = DB::connect();

        $datainicial .= " 00:00:00";
        $datafinal .= " 23:59:59";

        $query = "SELECT * FROM ca_pedido WHERE CA_USUARIO_idusuario = :idusuario
                    AND ca_datapedido BETWEEN :datainicial AND :datafinal";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idusuario', $idusuario);
        $stmt->bindParam(':datainicial', $datainicial);
        $stmt->bindParam(':datafinal', $datafinal);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function dadosPedido($idpedido)
    {
        try {
            $conn = DB::connect();

            // Consulta para buscar produtos por ID do usuário
            $query = "SELECT * FROM ca_pedido WHERE idpedido = :idpedido";
            $stmt = $conn->prepare($query);

            // Bind do parâmetro
            $stmt->bindParam(':idpedido', $idpedido);

            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            // Retorna os resultados da consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return $errorInfo;

        } catch (PDOException $e) {
            return "Erro ao buscar cadastro do pedido: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }
    
    public static function produtosPedido($idpedido)
    {
        try {
            $conn = DB::connect();

            $query = "SELECT ps.ca_qtd, ps.ca_valor, ps.ca_custo, ps.CA_PROD_SERV_idprodserv, c.ca_nome
	                    FROM ca_prod_serv_has_ca_pedido AS ps
                        INNER JOIN ca_prod_serv AS c 
                        ON ps.CA_PROD_SERV_idprodserv = c.idprodserv
                        WHERE ps.CA_PEDIDO_idpedido = :idpedido";
            $stmt = $conn->prepare($query);

            // Bind do parâmetro
            $stmt->bindParam(':idpedido', $idpedido);

            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            // Retorna os resultados da consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return $errorInfo;

        } catch (PDOException $e) {
            return "Erro ao buscar cadastro do pedido: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }

    private static function excluiProdutosPedido($idpedido)
    {
        try {
            $conn = DB::connect();

            $query = "DELETE FROM ca_prod_serv_has_ca_pedido WHERE CA_PEDIDO_idpedido = :idpedido";
            $stmt = $conn->prepare($query);

            // Bind do parâmetro
            $stmt->bindParam(':idpedido', $idpedido);

            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

        } catch (PDOException $e) {
            return "Erro ao buscar cadastro do pedido: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }

    private static function excluiPedido($idpedido)
    {
        try {
            $conn = DB::connect();

            $query = "DELETE FROM ca_pedido WHERE idpedido = :idpedido";
            $stmt = $conn->prepare($query);

            // Bind do parâmetro
            $stmt->bindParam(':idpedido', $idpedido);

            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

        } catch (PDOException $e) {
            return "Erro ao buscar cadastro do pedido: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }

    public static function validaExclusaoPedido($idpedido, $idusuariosession)
    {        
        try {
            $conn = DB::connect();

            $query = "SELECT CA_USUARIO_idusuario FROM ca_pedido WHERE idpedido = :idpedido";
            $stmt = $conn->prepare($query);

            // Bind do parâmetro
            $stmt->bindParam(':idpedido', $idpedido);

            $stmt->execute();
            $errorInfo = $stmt->errorInfo();

            $idusuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $idusuario = $idusuario[0]['CA_USUARIO_idusuario'];

            if ($idusuario != $idusuariosession) {
                return false;
            } else {
                DB::beginTransaction();
                Pedido::excluiProdutosPedido($idpedido);
                Pedido::excluiPedido($idpedido);
                DB::commit();
                return true;
            }
            

        } catch (PDOException $e) {
            DB::rollBack();
            return "Erro ao buscar cadastro do pedido: " . $e->getMessage();
        } finally {
            $conn = null;
        }


    }

}