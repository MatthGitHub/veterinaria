<?php
//--------------------------------Inicio de sesion------------------------
include("../inc/sesion.php");
include("../mod_sql/sql.php");
include("../lib/funciones.php");

if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="index.php";
	header("location:mensaje_ok.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------
$flag = 'no';

if((isset($_GET['process']))&&(isset($_POST['txt_buscar_usr']))){
	$flag = 'buscar';

	$nombre = $_POST['txt_buscar_usr'];
	$usuario = sql_buscar_usuario($nombre);
	$filas=mysql_num_rows($usuario);
	if ($filas==0){
		header ("Location: modificar_usuario.php?errordat");
	}else{
			$buscar_usr=mysql_result($usuario,0,"nombre");
			$rol=mysql_result($usuario,0,"fk_rol");
			$nuevaClave=md5(mysql_result($usuario,0,"usuario"));
			$usuario=mysql_result($usuario,0,"id_usuario");
	}
}





$link = conectarse_mysql_veterinaria();
$sql = "SELECT * FROM roles";

$stmt = mysql_query($sql,$link);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="../image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Modificar Usuario</title>

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

		<h4 class="text-center bg-info">Modificar Usuario</h4>
		<div class="container">
				<form id="formBuscar" name="formBuscar" method="post" value= "buscar_usuario" action="modificar_usuario.php?process">
				  <div class="row">
					<div class="col-md-4 col-md-offset-4">
					  <div class="panel panel-default">
						<div class="panel-body"
						  <form class="form form-signup" role="form">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">
											<?php if($flag == 'buscar'){ ?>
											<input type="text" class="form-control" value="<?php echo $buscar_usr; ?>" />
											<?php }else{ ?>
											<input name="txt_buscar_usr" type="text" id="txt_buscar_usr" class="form-control" placeholder="Escribir aquí"/>
											<?php } ?>
										</span>
								</div>
							</div>
							<input type="submit" name="Buscar_usuario" value="BUSCAR" method="post" onclick="submit()" class="btn btn-sm btn-primary btn-block">
							<?php
							if($resultadoBusqueda <> ""){
							echo "
								<div class='alert alert-danger-alt alert-dismissable'>
								<span class='glyphicon glyphicon-exclamation-sign'></span>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
								×</button>$resultadoBusqueda</div>
							";
							}else{
							echo "";
							}
							?>
					</form>
						</div>
					  </div>
					</div>
				  </div>
				</form>
			</div><!-- Container 1 -->

			<div class="container">
				<form name="form1" method="post" action="editar_usuario.php">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="panel panel-default">
							<div class="panel-body">
								<form class="form form-signup" role="form">

								<h4 class="text-center"><img src="../images/icons/veterinario.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

								<input style="visibility:hidden" name="usuario" type="text" class="form-control" id="usuario" value="<?php echo $usuario;?>"/>

								<div class="form-group">
									<span class="input-group-addon"><i class="fa fa-user-o fw" aria-hidden="true"></i> Rol</span>
									<div class="col-xs-15 selectContainer">
										<select class="form-control" name="rol">
										  <?php while($roles = mysql_fetch_array($stmt)){
															if($flag == 'buscar'){
																if($roles['id_rol'] == $rol){?>
																		<option selected value="<?php echo $roles['id_rol']; ?>"> <?php echo $roles['descripcion']; ?></option>
																<?php }else{ ?>
																		<option value="<?php echo $roles['id_rol']; ?>"> <?php echo $roles['descripcion']; ?></option>
																<?php }}?>
										  <?php } ?>
										</select>
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
											×</button>Listo! Usuario modificado satisfactoriamente.</div>";
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

			</div><!-- /container 2 -->
		</form>

		<form name="form1" method="post" action="reinicializar_clave.php">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<form class="form form-signup" role="form">
						<?php
						if(isset($_GET['successpass'])){
						echo "
						<div class='alert alert-success-alt alert-dismissable'>
										<span class='glyphicon glyphicon-ok'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
											×</button>Listo! Clave reinicializada.</div>";
						}else{
						echo "";
						}
						?>
						<?php
						if(isset($_GET['errordatpass'])){
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
						if(isset($_GET['errordbpass'])){
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
						
						<input style="visibility:hidden" name="usuario" type="text" class="form-control" id="usuario" value="<?php echo $usuario;?>"/>
						<input style="visibility:hidden" name="clave" type="text" class="form-control" id="clave" value="<?php echo $nuevaClave;?>"/>
						<h4 class="text-center"><img src="../images/icons/reset.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
						<input type="submit" name="Submit" value="REINICIALIZAR CLAVE"  class="btn btn-sm btn-primary btn-block">

					</form>
				</div>

			</div>
		</div>

	</div><!-- /container 2 -->
</form>

	</div>

</div>
<div class="panel-footer">
	<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
</div>
    </div> <!-- /container -->
  </body>
</html>
