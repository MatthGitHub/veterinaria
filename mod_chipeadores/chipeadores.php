
<?php
include("../inc/sesion.php");
include '../lib/funciones.php';

$db= Conexion();

$buscar = $_POST['txt_buscar'];


//LONGITUD DE BUSQUEDA

$long_buscar = strlen($buscar);

if (!empty($_POST['txt_buscar'])) {

    $sql = "select * from chipeadores where nombre like '%$buscar%'";
    //echo $sql;
}elseif(empty($_POST['txt_buscar'])){

	$sql = "select * from chipeadores limit 10";
  //echo $sql;
}else{

	$sql = "select * from chipeadores limit 10";
//  echo $sql;
}
 $ejecuto = mysqli_query($db,$sql);
 /*echo "EJEC:".$ejecuto;
 while($persona = mysqli_fetch_array($ejecuto)){
   echo $persona['nombre'];
 }
 exit();*/

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema Veterinaria y Zoonosis MSCB</title>

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


   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>

<script>
function validar(){

	//Almacenamos los valores
	nombre=$('#txt_buscar').val();

   //Comprobamos la longitud de caracteres
	if (nombre.length>4){
		return true;
	}
	else {
		alert('Minimo 5 caracteres');
		return false;

	}

}
</script>



</head>




	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->


            <div class="row">
                <div class="col-lg-3">
                <br>
                <h4 class="text-center"><img src="../images/icons/chipeadores.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

                <h4 class="text-center bg-info">Chipeadores</h4>
                </div>
                <div class="col-lg-6">

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onSubmit="return validar();" id="formjquery" name="buscar"><br>
                <input class="form-control" name="txt_buscar" id="txt_buscar" value="<?php if (isset($_POST['txt_buscar'])){echo $buscar;} ?>" required="required" placeholder="Buscar por número de documento o apellido. Mínimo 5 caracteres."><br>
                <input class="btn btn-success" type="submit" value="Buscar" onSubmit="return validar();">
                </form>
                </div>
                <div></div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-6">

                <form method="POST" action="frm_alta_chipeador.php" id="formNuevo" name="nuevo"><br>
                <input class="btn btn-success" type="submit" value="Nuevo" onSubmit="return validar();">
                </form>
                </div>
                <div></div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Chipeadores
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>

                                        <th>NOMBRE</th>
                                       <!-- <th>PRUEBA GET</th>-->
                                        

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php



                                        while ($row = mysqli_fetch_assoc($ejecuto)) {



                                    ?>

                                    <tr class="odd gradeX">
                                        <td><form action="../mod_animales/frm_alta_animal.php" method="POST">
                                        <input type="hidden" name="txt_id_chipeador" value="<?php echo $row['id_chipeador']; ?>">
                                        <input type="hidden" name="txt_nombre" value="<?php echo $row['nombre_chipeador']; ?>">
                                        <?php echo $row['nombre_chipeador']; ?>
                                          </form></td>
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

            <!-- /.row -->






		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>
		</div>


	<!-- /#wrapper -->

    <!-- jQuery -->


    <!-- Metis Menu Plugin JavaScript -->
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
