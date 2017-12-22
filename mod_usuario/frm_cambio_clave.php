<?php
//--------------------------------Inicio de sesion------------------------
include("../inc/sesion.php"); 
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
    <title>Sistema VyZ MSCB-Cambio Clave</title>

    <!-- Bootstrap -->
    <script src="../js/jquery-1.12.3.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script language='javascript' src="../jscripts/funciones.js"></script>
	<script type="text/JavaScript">

		/*function vacio(q) {
				for ( i = 0; i < q.length; i++ ) {
						if ( q.charAt(i) != " " ) {
								return true
						}
				}
				return false
		}
		//-------------Validaciones del formulario---------------------------//
		function validar(frm) {

		   if ( document.form1.txt_clave.value != document.form1.txt_clave2.value ){
				alert("La clave ingresada y su repetición no coinciden");
				document.form1.txt_clave.focus();
				return (false);
			}

			if (vacio(document.form1.txt_clave.value)== false | document.form1.txt_clave.value.length<=3 ){
				alert("Debe ingresar la nueva clave");
				document.form1.txt_clave.focus();
				return (false);
			}

			if (vacio(document.form1.txt_clave2.value)== false | document.form1.txt_clave2.value.length<=3 ){
				alert("Debe repetir la clave");
				document.form1.txt_clave2.focus();
				return (false);
			}

				  if (!confirm('¿Confirma el cambio de clave?')){
			   return (false);
		   }
		}*/
	</script>
  </head>

  <body>

	<br>
	<div class="container">
		<!-- Static navbar -->
		<?php include "../inc/menu.php"; ?>

		 <!-- Main component for a primary marketing message or call to action -->
	    <div class="jumbotron">
		  <h4 class="text-center bg-info">Cambiar clave</h4>

			<div class="container">
				<!--form id="form1" name="form1" method="get"  action="procesa_cambio_clave.php" -->
				<form name="form1" method="post" action="cambiar_clave.php">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-body">
									<h5 class="text-center text-bold"><i class="fa fa-user-circle fa-fw"></i> <?php echo $_SESSION["nombre"]; ?></h5>
									<form class="form form-signup" role="form">
										<div>
											<h5 class="text-left bg-info"><i class="fa fa-exclamation-triangle fa-fw"></i> Maximo 10 caracteres, hace diferencia entre mayusculas y minusculas.</h5>
										</div>
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
												<!--input name="clave1" type="password" id="clave1" class="form-control" onKeyPress="return tabular(event,this)" placeholder="Clave nueva" /-->
												<input name="claveA" type="password" id="claveA" class="form-control" placeholder="Clave nueva" />
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
												<!--input name="clave2" type="password" id="clave2" class="form-control" onKeyPress="return tabular(event,this)" placeholder="Repetir clave nueva" /-->

												<input name="claveN" type="password" id="claveN" class="form-control" placeholder="Repetir clave nueva" />
											</div>
										</div>
										<input type="submit" name="Submit" value="GUARDAR"  class="btn btn-sm btn-primary btn-block">
									</form>
								</div>
								  <?php
									if(isset($_GET['success'])){
									echo "
									<div class='alert alert-success-alt alert-dismissable'>
									                <span class='glyphicon glyphicon-ok'></span>
									                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									                    ×</button>La clave ha sido modificada satisfactoriamente.</div>
									";
									}else{
									echo "";
									}
									?>
									<?php
									if(isset($_GET['errordat'])){
									echo "
									<div class='alert alert-warning-alt alert-dismissable'>
									                <span class='glyphicon glyphicon-exclamation-sign'></span>
									                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									                    ×</button>Ha habido un error al insertar los valores.</div>
									";
									}else{
									echo "";
									}
									?>
									<?php
									if(isset($_GET['errordb'])){
									echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									                <span class='glyphicon glyphicon-exclamation-sign'></span>
									                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									                    ×</button>Error, las claves ingresadas no coinciden.</div>
									";
									}else{
									echo "";
									}
									?>
							</div>
						</div>
					</div>
				</form>
			</div>
	    </div>
		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>
    </div> <!-- /container -->

  </body>
</html>
