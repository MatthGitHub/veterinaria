<?php include("funciones.php");


//limpia tabla empleados local--------------------------
$link_horas_extras=conectarse_mysql_horas_extras();

$sql_limpiar="delete from empleados ";
mysql_query($sql_limpiar,$link_horas_extras); 


//Fin limpiar-----------------------------------------------


//Lee de la Bche--------------------------------------------------------
$link_bche=conectarse_bche();

$sql_source="select cast(legajo as int) as legajo,apellido,nombre
			from personas inner join sld_personal 
			on personas.identificador=sld_personal.identificador ";

$record_source=mssql_query($sql_source,$link_bche); 
//----------------------------------------------------------------------


//Carga tabla local con datos de la Bche------------------------------------------
while($registros=mssql_fetch_array($record_source)){
	
	$legajo=$registros["legajo"];
	$apellido=$registros["apellido"];
	$nombre=$registros["nombre"]; 
 
	
	$sql_insert_destination="insert into empleados (legajo,apellido,nombre) 
	values('$legajo','$apellido','$nombre')" ;
	mysql_query($sql_insert_destination,$link_horas_extras);
	
	
}
//---------------------------------------------------------------------------

?>
