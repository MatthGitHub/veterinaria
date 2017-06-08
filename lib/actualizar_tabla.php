<?php include("funciones.php");


//limpia tabla in_organigrama local--------------------------
$link_horas_extras=conectarse_mysql_horas_extras();

$sql_limpiar="delete from in_organigrama ";
mysql_query($sql_limpiar,$link_horas_extras); 


//Fin limpiar-----------------------------------------------


$link_bche=conectarse_bche();

$sql_source="SELECT CODIGO_ORGANIGRAMA,CONCEPTO,Secretaria,DEPENDEDE from IN_ORGANIGRAMA ";
$record_source=mssql_query($sql_source,$link_bche); 


while($registros=mssql_fetch_array($record_source)){//Inicio loop para resoluciones

	$codigo_organigrama=$registros["CODIGO_ORGANIGRAMA"];
	$concepto=$registros["CONCEPTO"];
	$secretaria=$registros["Secretaria"];
	$depende=$registros["DEPENDEde"];
 
	//Se inserta en contenidos del boletin oficial---------------------------------
	

	
	$sql_insert_destination="insert into in_organigrama (codigo_organigrama,concepto,secretaria,dependede) 
	values('$codigo_organigrama','$concepto','$secretaria','$depende')" ;
	mysql_query($sql_insert_destination,$link_horas_extras);
	
	
	//---------------------------------------------------------------------------
	
	

}//Fin loop para resoluciones


?>
