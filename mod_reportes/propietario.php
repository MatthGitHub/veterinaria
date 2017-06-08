<?php
include("../lib/sesion.php");
include("../mod_sql/sql.php");
include("../lib/funciones.php");


$documento = $_POST['documento'];

$conexion = conectarse_mysql_veterinaria();

$consulta = "SELECT nombre,apellido,documento FROM personas WHERE documento = '$documento'";
$result = $conexion->query($consulta);

$respuesta = new stdClass();
if($result->num_rows > 0){
    $fila = $result->fetch_array();
    $respuesta->nombre = $fila['nombre'];
    $respuesta->apellido = $fila['apellido'];
    $respuesta->documento = $fila['documento'];
}
echo json_encode($respuesta);
 ?>
