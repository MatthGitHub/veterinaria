
<?php
include("../inc/sesion.php");
include('../lib/funciones.php');
include('../mod_sql/sql.php');

$db= Conexion();

$id_ejemplar = $_POST['txt_id_ejemplar'];
$id_personaVieja = $_POST['txt_id_persona_vieja'];
$id_persona = $_POST['txt_id_persona'];
$chip = $_POST['txt_buscar_chip'];

/*echo "Id Ejemplar: ".$id_ejemplar." - Id nuevo prop: ".$id_persona." - Id antiguo prop:".$id_personaVieja." - Chip: ".$chip;
exit();*/
$error = sql_transferir_ejemplar($id_ejemplar,$id_persona,$id_personaVieja);


if($error){
	header('Location: frm_transferir_animal.php?success&txt_buscar_chip='.$chip);
	exit();
}else{
	header('Location: frm_transferir_animal.php?error&txt_buscar_chip='.$chip);
	exit();
}


?>
