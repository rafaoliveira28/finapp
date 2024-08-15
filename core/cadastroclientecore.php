<?php
$dbfile = 'classes/db.class.php';
$userfile = 'classes/usuario.class.php';

if (file_exists($dbfile)) {
    require_once $dbfile;
    require_once $userfile;
} else {
    require_once '../' . $dbfile;
    require_once '../' . $userfile;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $logradouro = $_POST['logradouro'];
    $numlogradouro = $_POST['numlogradouro'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];

    $senhasegura = password_hash($senha, PASSWORD_BCRYPT);

    if (isset($_POST['cnpj'])) {
        $cnpj = $_POST['cnpj'];
    } else {
        $cnpj = "";
    }

    if (isset($_POST['nomeempresa'])) {
        $nomeempresa = $_POST['nomeempresa'];
    } else {
        $nomeempresa = "";
    }
}

$idcadastro = new Usuario("$nome", "$telefone", "$logradouro", "$email", "$senhasegura", "$cep", "$numlogradouro", "$cidade", "$bairro", "$nomeempresa", "$cpf", "$cnpj");

try {
    // Cadastrar novo cliente
    $resultadoCadastro = $idcadastro->cadastrarUsuario();
    // Exibir resultado
    //if ($resultadoCadastro) {
    //    header('Location: ../login.php?confirm=1&msg=$resultadoCadastro');
   // }
} finally {
    header('Location: ../login.php?confirm=1&msg=' . $resultadoCadastro);
    //var_dump($resultadoCadastro);
    $conn = null;
}