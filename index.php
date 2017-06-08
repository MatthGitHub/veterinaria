<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" type="image/png" href="images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema VyZ MSCB</title>

    <!-- Bootstrap core CSS -->
    <script src="js/jquery-1.12.3.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet">


    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
body
{
    padding-top: 200px;
}

    </style>

<script language='javascript' src="jscripts/funciones.js"></script>


<link href="css/estilos.css" rel="stylesheet" type="text/css">

</head>

<body onLoad="document.form1.txtUser.focus();">
	<form name="form1" method="post" action="mod_usuario/login.php">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="panel panel-default">
						<div class="panel-body">
						<img src="images/icons/logo_vet.png" alt="Municipalidad Bariloche" align="middle" style="margin:0px 0px 0px 140px" height="52" width="52">
							<h4 class="text-center bg-info">Sistema Veterinaria y Zoonosis</h4>
							<form class="form form-signup" role="form" method="post" action="inc/entrar.php">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
									<input name="txtUser" type="text" class="form-control" id="txtUser" onKeyPress="return tabular(event,this)" placeholder="Usuario">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
									<input name="txtPass" type="password" class="form-control" id="txtPass" onKeyPress="return tabular(event,this)" placeholder="Contrase&ntilde;a">
								</div>
							</div>
						</div>
						<input type="submit" name="btnLogin" value="INICIAR SESION" id="btnLogin3" class="btn btn-sm btn-primary btn-block" >
					   <br>
					   </form>
					  </div>
		<?php
		if(isset($_GET['errorpass'])){
		echo "
		<div class='alert alert-danger-alt alert-dismissable'>
						<span class='glyphicon glyphicon-exclamation-sign'></span>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>Datos de Usuario o Contraseña incorrectos, vuelva a intentarlo. </div>
		";
		}else{
		echo "";
		}
		?>
				</div>
			</div>
			<div class="panel-footer">
					<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
			</div>
		</div>
	</div>
	</form>
  </body>

</html>