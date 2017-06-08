<?php
include('config');
include('validar');

$usuario = $_POST['usuario'];


//Busco el legajo
$sql = "SELECT * FROM usuarios_web WHERE nombre_usuario = '$usuario'";
$stmt = sqlsrv_query($conn,$sql);
$elu = sqlsrv_fetch_array($stmt);
$legajo = $elu['legajo'];
$id = $elu['idUsuario'];


//Borro todos los registros con legajos asociados en control acceso fichadas
$sql = "DELETE FROM Personal_fichadas_permisos WHERE usuario = $legajo";
sqlsrv_query($conn,$sql);

//Borro el usuario del sistema
$sql = "DELETE FROM usuarios_web WHERE idUsuario = $id";
sqlsrv_query($conn,$sql);




?>
