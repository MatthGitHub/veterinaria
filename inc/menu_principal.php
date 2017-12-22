<?php
error_reporting(0);
//--------------------------------Inicio de sesion------------------------
include("../inc/sesion.php");
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje=" Usuario sin permisos";
	$destino="../index.php";
	header("location:mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema VyZ MSCB</title>

    <!-- Bootstrap -->
		<script src="../js/jquery-1.12.3.js"></script>
		<link href="../css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <br>
	<div class="container">
		<!-- Static navbar -->
		<?php include "../inc/menu.php"; ?>
		<!-- Main component for a primary marketing message or call to action -->
		  <div class="jumbotron">
			<h2><img src="../images/icons/logo_vet_blanco.png" alt="Municipalidad Bariloche" align="middle" style="margin:0px 0px 0px 0px" height="32" width="32"> Accesos Frecuentes Veterinaria y Zoonosis </h2>
			<div class="row">
			<?php //if ($_SESSION['area'] == "Sistemas" ){ ?>
				<div class="col-lg-5">
					<p>
					   <a class="btn btn-lg btn-direct" href="../mod_animales/frm_buscar_ejemplar.php" role="button">Buscar Animal</a>
					   <a class="btn btn-lg btn-direct" href="../mod_personas/personas_grilla.php" role="button">Buscar Persona</a>
					</p>
				</div>
				<div class="col-lg-5">
					<?php if(($_SESSION['rol'] > 0)&&($_SESSION['rol'] < 4)){?>
					<p>
				    <a class="btn btn-lg btn-direct" href="../mod_personas/personas.php" role="button">Cargar Animal</a>

					</p>
					<?php } ?>
				</div>
			 <?php //}?>
			</div>
		  </div> <!-- /jumbotron -->

		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>

	</div> <!-- /container -->
  </body>
</html>
