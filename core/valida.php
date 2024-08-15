<?php
require 'seguranca.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $usuario = (isset($_POST['login'])) ? $_POST['login'] : '';
  $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';


  if (validaUsuario($usuario, $senha) == true) {
    header("Location: ../index.php");
  } else {
    LoginIncorreto();
  }
}
?>