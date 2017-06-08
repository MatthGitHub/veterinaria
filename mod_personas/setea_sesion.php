<?php
//--------------------------------Inicio de sesion------------------------
include("../lib/sesion.php"); 
if ($_SESSION['permiso'] != 'autorizado'){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

include("../lib/funciones.php");

$_SESSION['busquedaAuEntreFech']=1;
$_SESSION['FrmLisAuFD']=fecha_normal_mysql($_POST["txt_fecha_desde"]);
$_SESSION['FrmLisAuFH']=fecha_normal_mysql($_POST["txt_fecha_hasta"]);
$_SESSION['FrmLisAuLeg']=$_POST["txt_legajo"];

header("location:frm_listado_ausentes_entre_fechas.php");

?>