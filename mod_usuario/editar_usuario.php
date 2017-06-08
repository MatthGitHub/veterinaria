<?php
include("../lib/sesion.php");
include("../mod_sql/sql.php");
include("../lib/funciones.php");
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="index.php";
	header("location:mensaje_ok.php?mensaje=$mensaje&destino=$destino");
}



//if(isset($_POST['usuario']){
    $rol = $_POST['rol'];
    $usuario = $_POST['usuario'];


    $error = sql_modificar_usuario($rol,$usuario);


    if($error){
      header("Location: modificar_usuario.php?success");
      exit();
    }else{
      header("Location: nuevo_usuario.php?errordb");
      exit();
    }



/*}else{
    header("Location:nuevo_usuario.php?errordat");
    exit();
}*/

?>
