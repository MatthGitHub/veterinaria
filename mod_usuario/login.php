<?php

	include("../lib/funciones.php");
	$nombre=$_POST["txtUser"];
	$pass=md5($_POST["txtPass"]);



	$link=conectarse_mysql_veterinaria();
	//$query="select id_usuario,nombre from usuarios where usuario='$nombre' and pass COLLATE Latin1_General_CS ='$pass'";
	$query="select id_usuario,nombre,fk_rol from usuarios where usuario='$nombre' and pass='$pass'";


	$result=mysql_query($query, $link);
	$filas=mysql_num_rows($result);



	if ($filas==0){

				header ("Location: ../index.php?errorpass");
				//$mensaje="Usuario o contrase�a no valido <br> ";
				//$destino="../index.php";

				//header("location:../lib/mensaje_login.php?mensaje=$mensaje&destino=$destino");

		}
	else
		{

			$nombre=mysql_result($result,0,"nombre");
			$id=mysql_result($result,0,"id_usuario");
			$rol=mysql_result($result,0,"fk_rol");





			// Inicializamos sesion
			session_start();
			// Guardamos una variable
			$_SESSION['sistema'] = 'veterinaria';
			$_SESSION['permiso'] = 'autorizado';
			$_SESSION['rol'] = $rol;
			$_SESSION['nombre'] =$nombre;
			$_SESSION['id'] =$id;

			header("Location:../inc/menu_principal.php");
		}


?>
