<?php
session_start();
unset($_SESSION["usuarioID"]);
unset($_SESSION["usuarioNome"]);
header("Location:../login.php");
