<?php
error_reporting(0);


function sql_buscar_especies()
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_especie,especie 
		   FROM `especies` 
		   ORDER BY `especie`
		  ";
		  
	$especies = mysql_query($sql,$link_veterinaria);		
	
	return $especies;
}

function sql_buscar_razas($pId_especie)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_raza,raza,fk_id_especie
		   FROM `razas` 
		   WHERE fk_id_especie = '".$pId_especie."'
		  ";
		  
	$razas = mysql_query($sql,$link_veterinaria);		
	
	return $razas;
}

function sql_buscar_razas_todas()
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_raza,raza,fk_id_especie
		   FROM `razas` order by fk_id_especie
		  ";
		  
	$razas = mysql_query($sql,$link_veterinaria);		
	
	return $razas;
}

function sql_buscar_id_especie($pEspecie)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_especie,especie 
		   FROM `especies`  
		   WHERE especie = '".$pEspecie."' 
		   ";
		  
	$pIdEspecie = mysql_query($sql,$link_veterinaria);		
	
	$pIdEspecie = mysql_result($pIdEspecie,0,"id_especie");

	return $pIdEspecie;
}

function sql_buscar_id_raza($pRaza)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_raza,raza
		   FROM `razas` 
		   WHERE raza = '".$pRaza."'
		   ";

	$pIdRaza = mysql_query($sql,$link_veterinaria);		
	
	$pIdRaza = mysql_result($pIdRaza,0,"id_raza");

	return $pIdRaza;
}

function sql_buscar_persona_duplicada($pDni)
{
	$flag = false;
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT documento
		   FROM `personas` 
		   WHERE documento = '".$pDni."'
		   ";

	$pDni = mysql_query($sql,$link_veterinaria);		
	
	$pDni = mysql_result($pIdRaza,0,"documento");
	
	if ($pDni)
	{
		$flag = true;
	}else
		$flag = false;

	return $flag;
}

function sql_insert_persona($txt_nombre_propietario,$txt_apellido,$txt_dni,$txt_telefono,$txt_calle,$txt_nro,$txt_barrio)
{
	$persona = "";

	$txt_calle = htmlentities(addslashes($txt_calle));//Resuelvo problemas de comillas dentro del texto
	$txt_barrio = htmlentities(addslashes($txt_barrio));
	
	

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql = "INSERT INTO  `veterinaria`.`personas` 
			(`documento` ,`nombre` ,`apellido` ,`telefono` ,`calle` ,`numero` ,`barrio`,`propietario`)
			VALUES 
			('$txt_dni',  '".$txt_nombre_propietario."', '".$txt_apellido."',  '".$txt_telefono."',  '".$txt_calle."', '".$txt_nro."', '".$txt_barrio."',1)";
		  
	$persona = mysql_query($sql,$link_veterinaria);		
	
	return $persona;

}


function sql_insert_patentamiento()
{

}


function sql_buscar_propietario($pDni)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT * 
		   FROM `personas` 
		   WHERE documento =  ".$pDni."
		  ";
		  
	$propietario = mysql_query($sql,$link_veterinaria);		
	
	return $propietario;
}

function slq_buscar_recibo_duplicado($nroRecibo)
{
	$flag = false;
	
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT nro_recibo
		   FROM `carnets` 
		   WHERE nro_recibo =  ".$nroRecibo."
		  ";		  
		  
	$nroReciboDb = mysql_query($sql,$link_veterinaria);	
	
	$nroReciboDb = mysql_result($nroReciboDb,0,"nro_recibo");
	
	if ($nroReciboDb == $nroRecibo)
	{
		$flag = true;
	}
	else
	{
		$flag = false;
	}
	
	return $flag;

}

function sql_insert_ejemplar_propietario($castrado,$especie,$raza,$pelaje,$tamanio,$txt_calle,$esterelizado,$sexo,$nombreEjemplar,$capturas,$altaCarnet,$bajaCarnet,$nroRecibo,$Observaciones,$caracter,$nroRecibo,$dni_fk,$adoptado,$senial,$anios,$observaciones)
{

	//Controlo que el recibo no exista
	$flag = false;
	$nroEjemplar = 0;
	
	//$flag = slq_buscar_recibo_duplicado($nroRecibo);
	
	if (!$flag)
	{
		$ejemplar = "";
	
		$link_veterinaria = conectarse_mysql_veterinaria();
		
		//Busco id_especie
		$fk_id_especie = sql_buscar_id_especie($especie);
	
		//Busco id_raza
		$fk_id_raza = sql_buscar_id_raza($raza);
	
		$sql = "INSERT INTO  `veterinaria`.`ejemplares` 
				(`caracter` ,`sexo` ,`pelaje` ,`nombre` ,`capturas` ,`tamanio` ,`esterilizado`,`fk_id_especie`,`fk_id_raza`,`fk_documento`,`senial`,`adoptado`,`anios`,`castrado`,`observaciones`)			
				VALUES 
				('$caracter',  '$sexo', '$pelaje',  '$nombreEjemplar',  '$capturas', '$tamanio', '$esterelizado', '$fk_id_especie','$fk_id_raza','$dni_fk','$senial','$adoptado','$anios','$castrado','$observaciones')";
		
		$ejemplar = mysql_query($sql,$link_veterinaria);
	
		//Busco el id_ejemplar que acabo de persistir
		$sql = "SELECT max(id_ejemplar) as id_ejemplar from ejemplares where fk_documento = '$dni_fk'";
		
		$nroEjemplar = mysql_query($sql,$link_veterinaria);
	
		$nroEjemplar = mysql_result($nroEjemplar,0,"id_ejemplar");
	}
	
	return $nroEjemplar;

}

function sql_insert_carnet_ejemplar($altaCarnet,$bajaCarnet,$observaciones,$nroRecibo,$fk_id_ejemplar,$nro_carnet)
{
	//Conversion de fecha
	$altaCarnet = fecha_mysql_normal($altaCarnet);
	$bajaCarnet = fecha_mysql_normal($bajaCarnet);
	
	$observaciones = htmlentities(addslashes($observaciones));

	$nrocCarnet = "";

	$link_veterinaria = conectarse_mysql_veterinaria();
	
	$sql = "INSERT INTO `veterinaria`.`carnets` (`id_carnet`, `fecha_alta`, `fecha_vencimiento`, `nro_recibo`, `renovaciones`, `observaciones`, `fk_id_ejemplar`,`nro_carnet`) VALUES (NULL, '$altaCarnet', '$bajaCarnet', '$nroRecibo', '0', '$observaciones', '$fk_id_ejemplar',$nro_carnet)";
					
	$nroCarnet = mysql_query($sql,$link_veterinaria);
	
	//Busco el nro de carnet del ejemplar
	//$sql = "SELECT max(id_carnet) as nro_carnet from carnets where fk_id_ejemplar = '$fk_id_ejemplar'";
	$sql = "SELECT nro_carnet from carnets where fk_id_ejemplar = '$fk_id_ejemplar'";

	$nroCarnet = mysql_query($sql,$link_veterinaria);

	$nroCarnet = mysql_result($nroCarnet,0,"nro_carnet");

	return $nroCarnet;
	
}

function sql_update_propietario($txt_dni_original,$txt_dni,$txt_nombre_propietario,$txt_apellido,$txt_telefono,$txt_calle,$txt_nro,$txt_barrio)
{

	$txt_nombre_propietario = htmlentities(addslashes($txt_nombre_propietario));
	$txt_apellido = htmlentities(addslashes($txt_apellido));
	$txt_telefono = htmlentities(addslashes($txt_telefono));
	$txt_calle = htmlentities(addslashes($txt_calle));
	$txt_nro = htmlentities(addslashes($txt_nro));	
	$txt_barrio = htmlentities(addslashes($txt_barrio));

	$link_veterinaria = conectarse_mysql_veterinaria();
			  
	$sql = "UPDATE `personas`
	SET 
	documento = '$txt_dni',
	nombre = '".$txt_nombre_propietario."',
	apellido = '".$txt_apellido."',
	telefono = '".$txt_telefono."',
	calle = '".$txt_calle."',
	numero = '".$txt_nro."',
	barrio = '".$txt_barrio."',
	propietario = 1
	where documento = '".$txt_dni_original."'";

	$propietario = mysql_query($sql,$link_veterinaria);		
	
	return $propietario;

}


function sql_buscar_ejemplar($pNro)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT * 
		   FROM `ejemplares` 
		   WHERE id_ejemplar =  ".$pNro."
		  ";
	$ejemplar = mysql_query($sql,$link_veterinaria);
	
			
	
	return $ejemplar;
}


function sql_buscar_especies_por_id($pid_especie)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_especie,especie 
		   FROM `especies` 
		   WHERE id_especie = ".$pid_especie."
		  ";

	$especies = mysql_query($sql,$link_veterinaria);		
	
	$especies = mysql_result($especies,0,"especie");

	
	return $especies;
}


function sql_buscar_raza_por_id($pid_raza)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_raza,raza 
		   FROM `razas` 
		   WHERE id_raza = ".$pid_raza."
		  ";
		  
	$raza = mysql_query($sql,$link_veterinaria);		
	
	$raza = mysql_result($raza,0,"raza");

	return $raza;
}


function sql_update_ejemplar($txt_id_ejemplar,$txt_nombre_ejemplar,$txt_caracter,$txt_anios,$txt_especie,$txt_raza ,$select_pelaje,$select_tamanio,$txt_sexo,$txt_capturas,$txt_observaciones,$txt_checkboxAdopatdo,$txt_checkboxCastrado,$txt_checkboxSenial,$txt_checkboxEsterilizado,$select_persona,$txt_checkboxFalecido)
{

	$txt_nombre = htmlentities(addslashes($txt_nombre_propietario));
	$txt_observaciones = htmlentities(addslashes($txt_observaciones));

	//Busco id_raza
	$fk_id_raza = sql_buscar_id_raza($txt_raza);
	
   //Busco id_especie
	$fk_id_especie = sql_buscar_id_especie($txt_especie);
	
	$link_veterinaria = conectarse_mysql_veterinaria();
	
	$sql = "UPDATE  `veterinaria`.`ejemplares`
    SET  `caracter` =  '".$txt_caracter."',
	`sexo` =  '".$txt_sexo."',
	`pelaje` =  '".$select_pelaje."',
	`nombre` =  '".$txt_nombre_ejemplar."',
	`capturas` =  '".$txt_capturas."',
	`tamanio` =  '".$select_tamanio."',
	`anios` =  '".$txt_anios."',
	`esterilizado` =  '".$txt_checkboxEsterilizado."',
	`senial` =  '".$txt_checkboxSenial."',
	`adoptado` =  '".$txt_checkboxCastrado."',
	`castrado` =  '".$txt_checkboxCastrado."',
	`fallecido` =  '".$txt_checkboxFalecido."',
	`fk_id_especie` =  '".$fk_id_especie."',
	`fk_id_raza` =  '".$fk_id_raza."',
	`fk_documento` = '".$select_persona."',
	`observaciones` =  '".$txt_observaciones."' 
	 WHERE  `ejemplares`.`id_ejemplar` ='".$txt_id_ejemplar."'";
	
	
	$ejemplar = mysql_query($sql,$link_veterinaria);		
	
	return $ejemplar;

}

function sql_buscar_personas()
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT documento
		   FROM `personas` ORDER BY documento ASC
		   ";

	$personas = mysql_query($sql,$link_veterinaria);		

	return $personas;

}



?> 
							
						