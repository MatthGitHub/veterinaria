<!-- Bootstrap -->
<script src="../js/bootstrap.min.js"></script>
<link href="../css/font-awesome.css" rel="stylesheet">
<link href="../css/font-awesome.min.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">

<div class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
	  <div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand"><p><img src="../images/escudobrc.gif" alt="Municipalidad Bariloche" align="middle" style="margin:0px 0px 0px 20px"></p></a>
	  </div>
	  <div class="navbar-collapse collapse">
		  <ul class="nav navbar-nav">
			<li><a href="../inc/menu_principal.php"><i class="fa fa-home fa-fw"></i>Inicio</a></li>
				  <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-id-badge fa-fw"></i> Personas<span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="../mod_personas/frm_buscar_propietario.php">Alta Persona</a></li>
						<li><a href="../mod_personas/personas_grilla.php">Buscar Persona</a></li>
						<li><a href="../mod_chipeadores/chipeadores.php">Chipeadores</a></li>
					  </ul>
				  </li>
				  <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-paw fa-fw"></i> Animales<span class="caret"></span></a>
					  <ul class="dropdown-menu">
							<?php if(($_SESSION['rol'] > 0)&&($_SESSION['rol'] < 4)){?>
						  <li><a href="../mod_personas/personas.php">Cargar Animal</a></li>
						  <li><a href="../mod_animales/frm_buscar_ejemplar.php">Buscar Animal</a></li>
							<?php }else{ ?>
								<li><a href="../mod_animales/frm_buscar_ejemplar.php">Buscar Animal</a></li>
							<?php } ?>
						</ul>
				  </li>
				<li class="dropdown">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-file-text-o fa-fw"></i> Reportes<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="../mod_reportes/frm_reporte_por_propietario.php">Reporte ejemplares propietario</a></li>
						<li><a href="../mod_reportes/frm_reporte_animales_por_barrio.php">Reporte ejemplares por barrio</a></li>
					  </ul>
				</li>

				<?php if(($_SESSION['rol'] == 1)||($_SESSION['rol'] == 2)){ ?>
				<li class="dropdown">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-users fa-fw"></i> Adm. Usuarios<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="../mod_usuario/nuevo_usuario.php">Nuevo Usuario</a></li>
						<?php if($_SESSION['rol'] == 1){ ?>
						<li><a href="../mod_usuario/modificar_usuario.php">Modificar Usuario</a></li>
						<?php } ?>
						<li><a href="../mod_usuario/usuarios.php">Listado y baja</a></li>
					  </ul>
				</li>
				<?php } ?>

		  </ul>
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="../mod_usuario/frm_cambio_clave.php"><i class="fa fa-key fa-fw"></i> Cambiar clave </a></li>
			<li><a><i class="fa fa-user-circle-o fa-fw"></i> <?php echo $_SESSION['nombre']; ?> </a></li>
			<li><a><i class="fa fa-calendar-o fa-fw"></i>
			<?php
			// Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1
			date_default_timezone_set('UTC');
			//Imprimimos la fecha actual dandole un formato
			echo date("d / m / Y");
			?></a></li>
			<li><a href="../mod_usuario/logout.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a></li>
		  </ul>
	  </div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</div>
