<?php
			
include("../lib/funciones.php");
$link=conectarse_mysql_veterinaria();
$txt_buscar_chip=$_GET['txt_buscar_chip'];	
	
	
	
//elimino del File System el file
$sql_file="SELECT * FROM ejemplares_fotos where id=".$_GET['id_file'];
				
$result_file=mysql_query($sql_file,$link);

unlink("imagenes_ejemplares/".$row_file["archivo"]); 
			
//elimino el registro de la base de datos tabla -> contenidos_files
$sql="delete from ejemplares_fotos where id=".$_GET['id_file'];
mysql_query($sql,$link);
mysql_close($link);
	
//header('Location:frm_mod_ejemplar_beta_2.php?txt_buscar_chip='.$txt_buscar_chip); 
header('Location:frm_mod_ejemplar.php?txt_buscar_chip='.$txt_buscar_chip); 

?>
