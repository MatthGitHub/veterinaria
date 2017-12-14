<?php
// Inicializamos sesion
session_start();
// Comprovamos si existe la variable
if (($_SESSION['permiso']!="autorizado" )||($_SESSION['sistema']!="veterinaria")) {
 	header("location:../index.php?desconectado");
}

?>
