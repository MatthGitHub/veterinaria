<?php
include("../inc/sesion.php");
include("../lib/funciones.php");
include("../mod_sql/sql.php");

// Primero comprobamos que ning�n campo est� vac�o y que todos los campos existan.
    if(isset($_POST['claveA']) && !empty($_POST['claveA']) &&
    isset($_POST['claveN']) && !empty($_POST['claveN']) &&
	($_POST['claveA'] == $_POST['claveN'])){
        // Si entramos es que todo se ha realizado correctamente
		  $claveA = md5($_POST['claveA']);
      $idU=$_SESSION['id'];

      $link=conectarse_mysql_veterinaria();

      $sql = "UPDATE usuarios SET pass = '{$claveA}' WHERE id_usuario = '$idU'";
        // Con esta sentencia SQL insertaremos los datos en la base de datos

      $claveModificada = mysql_query($sql,$link);

          if(!$claveModificada) {

          header ("Location: frm_cambio_clave.php?errordat");

      } else {

           header ("Location: frm_cambio_clave.php?success");

      }

    } else {

         header ("Location: frm_cambio_clave.php?errordb");

    }
?>
