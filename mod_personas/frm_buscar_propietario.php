
<?php 
//--------------------------------Inicio de sesion------------------------

include("../lib/sesion.php"); 
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

//Parametros - var - librerias
include("../lib/funciones.php");
include("../mod_sql/sql.php");	

//Cargo propietarios
$propietarios = sql_traer_propietarios();

?>

<!DOCTYPE html">
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema VyZ MSCB-Buscar Persona</title>
	
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
		
				
		$('#propietarios').DataTable( {
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

			  $('#propietarios tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
					}
					else {
						  $('#propietarios').DataTable.$('tr.selected').removeClass('selected');
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
	/*
	//---------------------Verificar abandono de la pagina-------------------//
	var bPreguntar = true;
		 
		window.onbeforeunload = preguntarAntesDeSalir;
		 
		function preguntarAntesDeSalir()
		{
		  if (bPreguntar)
			return "";
		}
	//------------------Fin verificar abandono--------------------------//
	*/

	</script>
</head>


<body>
	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center"><img src="../images/icons/propietario_blanco.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
			<h4 class="text-center bg-info">Listado Personas</h4>	
			<div class="container">
				<div class="row">	
					<table id="propietarios" class="display" cellspacing="0" width="100%">
						<thead>
							<th> Apellido </th>
							<th> Nombre </th>
							<th> Documento </th>
							<th> Barrio </th>
							<th> Calle </th>
							<th> Numero </th>
							<th> Ver Detalle </th>
							<th> Modificar </th>
						</thead>
						<tbody>
							<?php while($prop = mysql_fetch_array($propietarios)){ ?>
							<tr class="success">
								<td> <?php echo $prop['apellido']; ?> </td>
								<td> <?php echo $prop['nombre']; ?> </td>
								<td> <?php echo $prop['documento']; ?> </td>
								<td> <?php echo $prop['barrio']; ?> </td>
								<td> <?php echo $prop['calle']; ?> </td>
								<td> <?php echo $prop['numero']; ?> </td>
								<td> <button type="submit" id="txt_detalle" name="txt_detalle" class="btn btn-sm btn-primary"  onclick="location.href='frm_detalle_propietario.php?txt_buscar_dni=<?php echo $prop['documento']; ?>';"><i class="fa fa-address-book-o fa-fw"></i></button> </td>
								<td> <button type="submit" id="txt_modificar" name="txt_modificar" class="btn btn-sm btn-danger"  onclick="location.href='frm_mod_propietario.php?txt_buscar_dni=<?php echo $prop['documento']; ?>';"><i class="fa fa-pencil fa-fw"></i></button> </td>
							</tr>
							<?php } ?>
						</tbody>
					</table>				
				</div>	
			</div><!-- Container 1 -->
					
		</div> <!-- Jumbotron -->
	</div> <!-- Container -->
</body>
</html>
