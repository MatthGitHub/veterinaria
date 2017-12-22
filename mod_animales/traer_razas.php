<?php
//Parametros - var - librerias
include("../lib/funciones.php");
include("../mod_sql/sql.php");

if(isset($_POST["especie"]))
{
		$especie = $_POST['especie'];

		$id_especie = sql_buscar_id_especie($especie);

		$opciones = '<option value="0"> Elige una raza</option>';

		$result = sql_buscar_razas($id_especie);

		while( $fila = mysql_fetch_array($result) )	{
			$opciones.='<option value="'.$fila['raza'].'">'.$fila['raza'].'</option>';

		}	

		echo $opciones;
}		
?>
