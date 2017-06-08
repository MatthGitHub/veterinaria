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
    $usuario = $_POST['usuario'];
		$clave = $_POST['clave'];

    $error = sql_reiniciar_clave_usuario($usuario,$clave);


    if($error){
      header("Location: modificar_usuario.php?successpass");
      exit();
    }else{
      header("Location: modificar_usuario.php?errordbpass");
      exit();
    }



/*}else{
    header("Location:nuevo_usuario.php?errordat");
    exit();
}*/

?>
