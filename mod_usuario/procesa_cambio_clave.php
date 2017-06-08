<?php
//--------------------------------Inicio de sesion------------------------
include("../lib/sesion.php");
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:mensaje_ok.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

include("../lib/funciones.php");


$link=conectarse_mysql_veterinaria();

$clave=md5(utf8_decode($_GET['clave1']));
$usuario=$_SESSION['id'];


$query_actualiza_clave="update usuarios set pass='$clave' where id_usuario=$usuario";


if(mysql_query($query_actualiza_clave,$link)){
	//$mensaje="La clave ha sido actualizada correctamente";
	//$destino="../inc/menu_principal.php";
	header("location: frm_cambio_clave.php?success");
	}
	else
	{
	//$mensaje="No se realizo el cambio de clave";
	//$destino="../inc/menu_principal.php";
	header("location: frm_cambio_clave.php?errordat");
	}

?>
