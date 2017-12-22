
<?php
//--------------------------------Inicio de sesion------------------------

include("../inc/sesion.php");
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

//Parametros - var - librerias
include("../lib/funciones.php");
include("../mod_sql/sql.php");

//Cargo animales
$animales = sql_traer_ejemplares();

?>

<!DOCTYPE html">
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema VyZ MSCB</title>
		<!-- Bootstrap Core CSS -->
		<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

		<!-- DataTables CSS -->
		<link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

		<!-- DataTables Responsive CSS -->
		<link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="../dist/css/sb-admin-2.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script language='javascript' src="../js/jquery-1.12.3.js"></script>
    <script language='javascript' src="../js/jquery.dataTables.min.js"></script>

	<script type="text/JavaScript">

	$(document).ready(function() {


		$('#animales').DataTable( {
		  "language": {
				"lengthMenu": "Mostrar _MENU_ registros por pagina",
				"zeroRecords": "No se encontraron registros",
				"info": "Pagina _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros",
				"infoFiltered": "(filtrado de _MAX_ registros)",
				"sSearch":       	"Buscar",
				"oPaginate": {
					"sFirst":    	"Primero",
					"sPrevious": 	"Anterior",
					"sNext":     	"Siguiente",
					"sLast":     	"Ultimo"
				}
			},
			"scrollY":        "500px",
			"scrollCollapse": true,
			"order":[[0,"desc"]]
			  } );

			  $('#animales tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
					}
					else {
						  $('#animales').DataTable.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
					}
				} );
      });

	function set_focus()
	{
		document.getElementById("txt_nombre_animal").focus();
		alert("focus animal nombre");
		return (false);
	}

	</script>
</head>


<body>
	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
		<h4 class="text-center"><img src="../images/icons/animales.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
			<h4 class="text-center bg-info">Listado Animales</h4>
			<div class="container">
				<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-heading">
										Personas
								</div>
								<!-- /.panel-heading -->
								<div class="panel-body">
									<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
												<tr>

													<th> Nombre </th>
													<th> Nro Chip </th>
													<th> Especie </th>
													<th> Propietario </th>
													<th> Documento Prop. </th>
													<th> Barrio </th>
													<th> Calle </th>
													<th> Ver Detalle </th>
													<th> Modificar </th>
													<th> Transferir </th>

												</tr>
										</thead>
										<tbody>
												<?php



												while($anim = mysql_fetch_array($animales)){
									       		 $especie= sql_buscar_especie($anim['fk_id_especie']);
									        ?>

												<tr class="odd gradeX">
													<td> <?php echo $anim['nombre_ejemplar']; ?> </td>
													<td> <?php echo $anim['numero_chip']; ?> </td>
													<td> <?php echo $especie ?> </td>
													<td> <?php echo $anim['apellido']." ".$anim['nombre'] ; ?> </td>
													<td> <?php echo $anim['documento']; ?> </td>
													<td> <?php echo $anim['barrio']; ?> </td>
													<td> <?php echo $anim['calle_nocod']; ?> </td>
													<td>
														<form action="frm_detalle_ejemplar.php" method="POST">
                            							<input type="hidden" name="txt_buscar_chip" value="<?php echo $anim['numero_chip']; ?>">
                            							<input type="submit" name="detalle" value="Ver" class="btn btn-table">
                            							</form>
													</td>
													<td>
														<form action="frm_mod_ejemplar.php" method="POST">
                            							<input type="hidden" name="txt_buscar_chip" value="<?php echo $anim['numero_chip']; ?>">
                            							 <input type="submit" name="modificar" value="Modificar" class="btn btn-table">
                            							</form>
													</td>
													<td>
														<form action="frm_transferir_animal.php" method="POST">
                            							<input type="hidden" name="txt_buscar_chip" value="<?php echo $anim['numero_chip']; ?>">
                            							 <input type="submit" name="transferir" value="Transferir" class="btn btn-table">
                            							</form>
													</td>
												</tr>
												<?php } ?>
										</tbody>
									</table>
										<!-- /.table-responsive -->

								</div>
									<!-- /.panel-body -->
							</div>
							<!-- /.panel -->
					</div>
						<!-- /.col-lg-12 -->
				</div>
			</div><!-- Container 1 -->

		</div> <!-- Jumbotron -->
	</div> <!-- Container -->
</body>

<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
$(document).ready(function() {
$('#dataTables-example').DataTable( {
responsive : true,
		"language": {
				"url": "../inc/spanish.json"
			}
	} );
} );
</script>
</html>
