<?php
//--------------------------------Inicio de sesion------------------------
include("../inc/sesion.php");
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="index.php";
	header("location:mensaje_ok.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

include("../lib/funciones.php");

$link = conectarse_mysql_veterinaria();
$sql = "SELECT * FROM roles";
$stmt = mysql_query($sql,$link);

//echo $_SESSION['rol'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="../image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Nuevo Usuario</title>

    <!-- Bootstrap -->
    <script language='javascript' src="../js/jquery-1.12.3.js"></script>
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

		<h4 class="text-center bg-info">Nuevo Usuario</h4>

		<div class="container">
			<form name="form1" method="post" action="insertar_usuario.php">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<form class="form form-signup" role="form">

							<h4 class="text-center"><img src="../images/icons/veterinario.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-keyboard-o fw" aria-hidden="true"></i></span>
									<input name="nombre" type="text" class="form-control"  id="nombre" placeholder="Nombre Completo" />
								</div>
							</div>

							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fw" aria-hidden="true"></i></span>
									<input name="usuario" type="text" class="form-control"  id="usuario" placeholder="Nombre de usuario" />
								</div>
							</div>

							<div class="form-group">
								<span class="input-group-addon"><i class="fa fa-user-o fw" aria-hidden="true"></i> Rol </span>
								<div class="col-xs-15 selectContainer">
									<select class="form-control" name="rol">
									  <?php while($roles = mysql_fetch_array($stmt)){
											if($_SESSION['rol'] == 1 ) {?>
												<option value="<?php echo $roles['id_rol']; ?>"> <?php echo $roles['descripcion']; ?></option>
									  <?php }else{
												if(($roles['id_rol'] != 1)&&($roles['id_rol'] != 2)){?>
												<option value="<?php echo $roles['id_rol']; ?>"> <?php echo $roles['descripcion']; ?></option>
										<?php }}} ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-key fw" aria-hidden="true"></i></span>
									<input name="clave" type="password" class="form-control"  id="clave" placeholder="Contraseña" />
								</div>
							</div>

							<input type="submit" name="Submit" value="CREAR"  class="btn btn-sm btn-primary btn-block">
						</div>
					  </form>
					</div>

					<?php
					if(isset($_GET['success'])){
					echo "
					<div class='alert alert-success-alt alert-dismissable'>
									<span class='glyphicon glyphicon-ok'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Listo! Usuario creado satisfactoriamente.</div>";
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
										×</button>El nombre de usuario ya esta en uso o no ha introducido todos los datos</div>
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
										×</button>Error, no ha introducido todos los datos.</div>
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
	<div class="panel-footer">
		<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
	</div>
</div> <!-- /container -->
  </body>
</html>
