<?php
include 'seguranca.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senha = $_POST['senha'];
    $senhaatual = $_POST['senhaatual'];
    $usuario = $_SESSION['usuario']->getEmail();

    if (validaUsuario($usuario, $senhaatual)) {
        // Hash the new password using bcrypt
        
        // Attempt to update the user's password in the database
        $altera = Usuario::updateSenhaUsuario($_SESSION['usuarioID'], $senha);
        
        if ($altera) {
            // Redirect to profile page with success message
            header('Location: ../perfil.php?confirm=1&msg=Senha alterada com sucesso!');
        } else {
            // Redirect to profile page with error message
            header('Location: ../perfil.php?confirm=3&msg=Erro ao alterar a senha');
        }
        exit(); // Ensure script execution stops after the redirect
    } else {
        // Handle invalid user credentials
        header('Location: ../perfil.php?confirm=2&msg=Senha atual incorreta');
        exit();
    }
    

}