<?php  
// Inicializamos sesion  
session_start();  
// Comprovamos si existe la variable 
if ($_SESSION['permiso']!="autorizado" ) { 
 	header("location:mensaje_error.php");
}

?>