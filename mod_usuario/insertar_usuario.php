<?php
include("../lib/funciones.php");
include("../mod_sql/sql.php");


/*echo "Nombre: ".$_POST['nombre'];
echo " - Usuario: ".$_POST['usuario'];
echo " - clave: ".$_POST['clave'];
echo " - Rol: ".$_POST['rol'];*/
//header("Location:nuevo_usuario.php?errordat");


if(isset($_POST['nombre'])&&isset($_POST['usuario'])&&isset($_POST['clave'])){
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $rol = $_POST['rol'];
    $clave = md5($_POST['clave']);

    echo "Nombre: ".$nombre;
    echo " - Usuario: ".$usuario;
    echo " - clave: ".$clave;
    echo " - Rol: ".$rol;

    $error = sql_insert_usuario($nombre,$usuario,$clave,$rol);

    if($error){
      header("Location: nuevo_usuario.php?success");
      exit();
    }else{
      header("Location: nuevo_usuario.php?errordb");
      exit();
    }

    }else{
      echo "Nombre: ".$nombre;
      echo " - Usuario: ".$usuario;
      echo " - clave: ".$clave;
      echo " - Rol: ".$rol;
      exit();
}

?>
