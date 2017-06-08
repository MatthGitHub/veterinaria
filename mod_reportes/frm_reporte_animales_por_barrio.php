<?php
//--------------------------------Inicio de sesion------------------------
include("../lib/sesion.php");
include("../mod_sql/sql.php");
include("../lib/funciones.php");

if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="index.php";
	header("location:mensaje_ok.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="../image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Reporte animales por barrio</title>

    <!-- Bootstrap -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
		<script language='javascript' src="../js/jquery-1.12.3.js"></script>
		<script language='javascript' src="../js/jquery-ui.js"></script>
		<link href="../css/bootstrap.css" rel="stylesheet">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

        <div class="container">
          <br>
          <?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">

		<h4 class="text-center bg-info">Reporte por propietario</h4>
		<div class="container">
				<form id="formBuscar" name="formBuscar" method="post" action="reporte_animales_por_barrio.php">
				  <div class="row">
					<div class="col-md-4 col-md-offset-4">
					  <div class="panel panel-default">
						<div class="panel-body"
						  <form class="form form-signup" role="form">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">
											<input name="barrio" type="text" id="barrio" class="form-control" placeholder="Escribir aquí barrio"/>
										</span>
								</div>
							</div>
							<input type="submit" name="Buscar_usuario" value="Buscar" method="post" onclick="submit()" class="btn btn-sm btn-primary btn-block">

					</form>
						</div>
					  </div>
					</div>
				  </div>
				</form>
			</div><!-- Container 1 -->
</div>
<div class="panel-footer">
	<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
</div>
    </div> <!-- /container -->
  </body>
</html>
