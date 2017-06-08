<?php
include("../lib/funciones.php");

$patron = $_GET['term'];

$conexion = conectarse_mysql_veterinaria();

$consulta = "SELECT documento,apellido FROM personas WHERE documento LIKE '%$patron%' OR apellido LIKE '%$patron%'";

$result = $conexion->query($consulta);

if($result->num_rows > 0){
    while($fila = $result->fetch_array()){
        $personas[] = $fila['documento']." - ".$fila['apellido'];
    }
echo json_encode($personas);
}

?>
