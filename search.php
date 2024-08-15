<?php
require_once('classes/db.class.php'); // Inclua o arquivo da sua classe DB
require 'core/seguranca.php';

// Conecta ao banco de dados
$conn = DB::connect();

// Verifica se o parâmetro 'search' foi enviado

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];

    // Consulta o banco de dados
    $stmt = $conn->prepare("SELECT * FROM ca_prod_serv WHERE ca_nome LIKE :searchTerm AND CA_USUARIO_idusuario = :idusuario AND ca_produtoativo = '1'");
    $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
    $stmt->bindParam(':idusuario', $_SESSION['usuarioID']);
    $stmt->execute();

    // Cria um array com os resultados
    $resultsArray = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $resultsArray[] = $row;
    }

    // Retorna os resultados em formato JSON
    echo json_encode($resultsArray);
}

if (isset($_POST['idprodserv'])) {
    $idprodserv = $_POST['idprodserv'];

    $stmt = $conn->prepare("SELECT ca_valor FROM ca_prod_serv WHERE idprodserv = :searchTerm AND CA_USUARIO_idusuario = :idusuario limit 1" );
    $stmt->bindParam(':searchTerm', $idprodserv);
    $stmt->bindParam(':idusuario', $_SESSION['usuarioID']);
    $stmt->execute();

    $resultsArray = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $resultsArray[] = $row;
    }

    // Retorna os resultados em formato JSON
    echo json_encode($resultsArray);


}

// Fecha a conexão
$conn = null;
