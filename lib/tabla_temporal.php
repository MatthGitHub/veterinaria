<?php include("funciones.php");


//limpia tabla in_organigrama local--------------------------
$link_horas_extras=conectarse_mysql_horas_extras();



//Fin limpiar-----------------------------------------------


$link_bche=conectarse_bche();

$sql_source="select legajo,apellido,nombre
			from personas inner join sld_personal 
			on personas.identificador=sld_personal.identificador";
$record_source=mssql_query($sql_source,$link_bche); 

// Creo tabla temporal----------------------------------------- 
$query_create = "create temporary table temp_empleados(legajo char(8), apellido varchar(30), nombre varchar(30))";
$res_create = mysql_query($query_create,$link_horas_extras);


while($registros=mssql_fetch_array($record_source)){//Inicio loop para resoluciones

	$legajo=$registros["legajo"];
	$apellido=$registros["apellido"];
	$nombre=$registros["nombre"]; 
	//Se inserta en contenidos del boletin oficial---------------------------------
	

	
	$sql_insert_destination="insert into temp_empleados (legajo,apellido,nombre) 
	values('$legajo','$apellido','$nombre')" ;
	mysql_query($sql_insert_destination,$link_horas_extras);
	
	
	//---------------------------------------------------------------------------
	
	

}//Fin loop para resoluciones


$consulta_temp = "select * from temp_empleados";
$rec_temp = mysql_query($consulta_temp,$link_horas_extras);

$datos=mysql_fetch_array($rec_temp);
echo $datos["legajo"];
echo $datos["apellido"];
?>
