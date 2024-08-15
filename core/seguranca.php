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

ini_set('default_charset', "utf-8");
date_default_timezone_set('America/Sao_Paulo');
ini_set('session.gc_maxlifetime', 86400);
session_start();
$_SG['abreSessao'] = true;
$_SG['caseSensitive'] = true;
$_SG['paginaLogin'] = 'login.php';


function validaUsuario($usuario, $senha)
{
    try {
        $conn = DB::connect();

        // Consulta para verificar se as credenciais são válidas
        $query = "SELECT * FROM ca_usuario WHERE ca_email = :usuario";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario);

        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        
        //$total = count($resultado);

        if (password_verify($senha, $resultado['ca_senha'])) {
            $usuario = new Usuario($resultado['ca_nomeusuario'], $resultado['ca_telusuario'], $resultado['ca_rua'], $resultado['ca_email'], "", $resultado['ca_cep'], $resultado['ca_numerorua'], $resultado['ca_cidade'], $resultado['ca_bairro'], $resultado['ca_nomeempresa'], $resultado['ca_cpf'], $resultado['ca_cnpj']);
            
            $_SESSION['usuarioID'] = $resultado['idusuario'];
            $_SESSION['usuario'] = $usuario;
            $_SESSION['usuarioNome'] = $usuario->getNome();
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Em caso de erro de banco de dados, tratar a exceção
        $errorMessage = "Erro: " . $e->getMessage();
        error_log($errorMessage, 0);
        return false; // Falha na validação
    } finally {
        $conn = null;
    }
}

function protegePagina()
{
    global $_SG;
    if (!isset($_SESSION['usuarioID']) or !isset($_SESSION['usuarioNome'])) {
        expulsaVisitante();
    } else if (!isset($_SESSION['usuarioID']) or !isset($_SESSION['usuarioNome'])) {
        if ($_SG['validaSempre'] == true) {
            if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
                expulsaVisitante();
            }
        }
    }
}

function expulsaVisitante()
{
    global $_SG;
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
    header("Location: " . $_SG['paginaLogin']);
}

function LoginIncorreto()
{
    global $_SG;
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
    header('Location: ../login.php?inc=1');
}
