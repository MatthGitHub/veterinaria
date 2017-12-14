<?php


/*------------------------------------ MODULO EJEMPLARES ----------------------------------------*/

// Devuelve una lista de todos los ejemplares existentes.
function sql_traer_ejemplares()
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT `ejemplares`.`nombre` as nombre_ejemplar,`ejemplares`.`fk_id_especie`, `ejemplares`.`numero_chip`,`personas`.`documento`,`personas`.`barrio`,`personas`.`calle_nocod`,`personas`.`numeracion_calle`,`personas`.`apellido`,`personas`.`nombre`
	FROM `ejemplares` INNER JOIN (`ejemplares_personas` INNER JOIN `personas` ON `fk_id_persona` = `id_persona`) ON `id_ejemplar` = `fk_id_ejemplar`
		  ";

	$ejemplares = mysql_query($sql,$link_veterinaria);

	return $ejemplares;
}

// Chequea si el numero de chip a cargar para un nuevo ejemplar, ya fue utilizado para uno existente.
function sql_buscar_animal_duplicado($pChip)
{
	$flag = false;
	$link_veterinaria = conectarse_mysql_veterinaria();

	$pChip = htmlentities(addslashes($pChip));

	$sql ="SELECT numero_chip
		   FROM `ejemplares`
		   WHERE numero_chip = '".$pChip."'
		   ";

	$pChip = mysql_query($sql,$link_veterinaria);
	$pChip = mysql_result($pChip,0,"numero_chip");


	if ($pChip)
	{
		$flag = true;
	}else{
		$flag = false;
	}

	return $flag;
}

// Carga un nuevo ejemplar VER COMO MEJORARLO!
function sql_insert_ejemplar($nombreEjemplar,$anioNacimiento,$especie,$raza,$pelaje,$tamanio,$alzada,$libreta,$sexo,$condicion,$caracter,$capturas,$castrado,$fechaCastrado,$observaciones,$nroChip, $fechaChip, $plan, $nro_recibo, $sextuple, $fechaSextuple, $quintuple, $fechaQuintuple, $rabia, $fechaRabia, $hidatidosis, $fechaHidatidosis, $gusanos_redondos, $fechaGusanos, $anemia, $fechaAnemia, $influenza, $fechaInfluenza, $adenitis, $fechaAdenitis, $encefalomielitis, $fechaEncefalomielitis, $leucemia, $fechaLeucemia, $rabiaFelino, $fechaRabiaFelino, $triple, $fechaTriple, $id_propietario, $nombre_chipeador)
{

	$fechaChip = fecha_mysql_normal($fechaChip);

	$fechaSextuple = fecha_mysql_normal($fechaSextuple);
	$fechaQuintuple = fecha_mysql_normal($fechaQuintuple);
	$fechaRabia = fecha_mysql_normal($fechaRabia);
	$fechaHidatidosis = fecha_mysql_normal($fechaHidatidosis);
	$fechaGusanos = fecha_mysql_normal($fechaGusanos);
	$fechaAnemia = fecha_mysql_normal($fechaAnemia);
	$fechaInfluenza = fecha_mysql_normal($fechaInfluenza);
	$fechaAdenitis = fecha_mysql_normal($fechaAdenitis);
	$fechaEncefalomielitis = fecha_mysql_normal($fechaEncefalomielitis);
	$fechaLeucemia = fecha_mysql_normal($fechaLeucemia);
	$fechaRabiaFelino = fecha_mysql_normal($fechaRabiaFelino);
	$fechaTriple = fecha_mysql_normal($fechaTriple);

	$nombreEjemplar = htmlentities(addslashes($nombreEjemplar));
	$observaciones = htmlentities(addslashes($observaciones));
	$sexo = htmlentities(addslashes($sexo));
	$condicion = htmlentities(addslashes($condicion));
	$caracter = htmlentities(addslashes($caracter));
	$plan = htmlentities(addslashes($plan));


	if($castrado == 'Si')
	{
		$castrado = 1;
		$fechaCastrado = fecha_mysql_normal($fechaCastrado);
	}else{
		$castrado = 0;
		$fechaCastrado = NULL;
	}

	$ejemplar = "";

	$link_veterinaria = conectarse_mysql_veterinaria();

	//Busco id_especie
	$fk_id_especie = sql_buscar_id_especie($especie);

	//Busco id_raza
	$fk_id_raza = sql_buscar_id_raza($raza);

	//Busco id_pelaje
	$fk_id_pelaje = sql_buscar_id_pelaje($pelaje);

	$sql = "INSERT INTO  `veterinaria`.`ejemplares`
			(`numero_chip`,`nombre` ,`anio_nacimiento`,`sexo`,`caracter`,`capturas` ,`tamanio` ,`alzada`,`libreta`,`condicion`,`castrado`,`fecha_castrado`,`observaciones`,`fk_id_especie`,`fk_id_raza`,`fk_id_pelaje`)
			VALUES
			( '".$nroChip."','".$nombreEjemplar."', '".$anioNacimiento."', '".$sexo."', '".$caracter."', '".$capturas."', '".$tamanio."', '".$alzada."','".$libreta."',
			 '".$condicion."', '".$castrado."', '".$fechaCastrado."', '".$observaciones."', '".$fk_id_especie."','".$fk_id_raza."',
			 '".$fk_id_pelaje."')";

	 $ejemplar = mysql_query($sql,$link_veterinaria);


	//Busco el id_ejemplar que acabo de persistir
	//$sql = "SELECT max(id_ejemplar) as id_ejemplar from ejemplares";

	//$nroEjemplar = mysql_query($sql,$link_veterinaria);

	//$nroEjemplar = mysql_result($nroEjemplar,0,"id_ejemplar");

	$nroEjemplar = mysql_insert_id($link_veterinaria);


	$chipear = sql_insert_chipeado_ejemplar($nroEjemplar, $fechaChip, $plan, $nro_recibo, $nombre_chipeador);

	/*echo "Chipear:".$chipear;
	exit();*/

	if(!$chipear)
	{
		//Hago rollback!
		$sql = "DELETE FROM ejemplares where id_ejemplar = '$nroEjemplar'";

		$nroEjemplar = mysql_query($sql,$link_veterinaria);

		$nroEjemplar = mysql_result($nroEjemplar,0,"id_ejemplar");
	}else{
		//VACUNAS

		if($sextuple = 'Sextuple' && $fechaSextuple != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,1,$fechaSextuple);
		}
		if($quintuple = 'Quintuple' && $fechaQuintuple != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,2,$fechaQuintuple);
		}
		if($rabia = 'Rabia' && $fechaRabia != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,3,$fechaRabia);
		}
		if($hidatidosis = 'Hidatidosis' && $fechaHidatidosis != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,4,$fechaHidatidosis);
		}
		if($gusanos_redondos = 'Gusanos_redondos' && $fechaGusanos != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,5,$fechaGusanos);
		}
		if($leucemia = 'Leucemia' && $fechaLeucemia != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,11,$fechaLeucemia);
		}
		if($rabiaFelino = 'Rabia' && $fechaRabiaFelino != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,5,$fechaRabiaFelino);
		}
		if($triple = 'Triple' && $fechaTriple != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,10,$fechaTriple);
		}
		if($anemia = 'Anemia' && $fechaAnemia != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,6,$fechaAnemia);
		}
		if($influenza = 'Influenza' && $fechaInfluenza != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,7,$fechaInfluenza);
		}
		if($adenitis = 'Adenitis' && $fechaAdenitis != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,8,$fechaAdenitis);
		}
		if($encefalomielitis = 'Encefalomielitis' && $fechaEncefalomielitis != "--")
		{
			$vac = sql_insert_vacunas($nroEjemplar,9,$fechaEncefalomielitis);
		}

		//Propietarios
		//$propietario = sql_buscar_propietario($id_propietario);

		//$row=mysql_fetch_array($propietario);

		//$id_persona = ($row['id_persona']);

	    $prop = sql_insert_propietario_ejemplar($nroEjemplar, $id_propietario);
	}

	return $nroEjemplar;

}

// Actualiza un ejemplar especifico.
function sql_update_ejemplar($id_ejemplar,$nombreEjemplar,$anioNacimiento,$alzada,$libreta,$especie,$raza,$pelaje,$tamanio,$sexo,$condicion,$caracter,$capturas,$castrado,$fechaCastrado,$observaciones, $fechaChip, $plan, $nro_recibo, $sextuple, $fechaSextuple, $quintuple, $fechaQuintuple, $rabia, $fechaRabia, $hidatidosis, $fechaHidatidosis, $gusanos_redondos, $fechaGusanos, $anemia, $fechaAnemia, $influenza, $fechaInfluenza, $adenitis, $fechaAdenitis, $encefalomielitis, $fechaEncefalomielitis, $leucemia, $fechaLeucemia, $rabiaFelino, $fechaRabiaFelino, $triple, $fechaTriple, $id_propietario, $nombre_chipeador)
{

	$fechaChip = fecha_normal_mysql($fechaChip);

	$fechaSextuple = fecha_mysql_normal($fechaSextuple);
	$fechaQuintuple = fecha_mysql_normal($fechaQuintuple);
	$fechaRabia = fecha_mysql_normal($fechaRabia);
	$fechaHidatidosis = fecha_mysql_normal($fechaHidatidosis);
	$fechaGusanos = fecha_mysql_normal($fechaGusanos);
	$fechaAnemia = fecha_mysql_normal($fechaAnemia);
	$fechaInfluenza = fecha_mysql_normal($fechaInfluenza);
	$fechaAdenitis = fecha_mysql_normal($fechaAdenitis);
	$fechaEncefalomielitis = fecha_mysql_normal($fechaEncefalomielitis);
	$fechaLeucemia = fecha_mysql_normal($fechaLeucemia);
	$fechaRabiaFelino = fecha_mysql_normal($fechaRabiaFelino);
	$fechaTriple = fecha_mysql_normal($fechaTriple);

	$nombreEjemplar = htmlentities(addslashes($nombreEjemplar));
	$observaciones = htmlentities(addslashes($observaciones));
	$sexo = htmlentities(addslashes($sexo));
	$condicion = htmlentities(addslashes($condicion));
	$caracter = htmlentities(addslashes($caracter));
	$plan = htmlentities(addslashes($plan));

	if($castrado == 'Si')
	{
		$castrado = 1;
		$fechaCastrado = fecha_mysql_normal($fechaCastrado);
	}else{
		$castrado = 0;
		$fechaCastrado = NULL;
	}

	$ejemplar = "";

	$link_veterinaria = conectarse_mysql_veterinaria();

	//Busco id_especie
	$fk_id_especie = sql_buscar_id_especie($especie);

	//Busco id_raza
	$fk_id_raza = sql_buscar_id_raza($raza);

	//Busco id_pelaje
	$fk_id_pelaje = sql_buscar_id_pelaje($pelaje);

	$sql = "UPDATE `ejemplares`
			SET `nombre`='".$nombreEjemplar."',
			`anio_nacimiento`='".$anioNacimiento."',
			`alzada`='".$alzada."',
			`libreta`='".$libreta."',
			`sexo`='".$sexo."',
			`caracter`='".$caracter."',
			`capturas`='".$capturas."',
			`tamanio`='".$tamanio."',
			`condicion`='".$condicion."',
			`castrado`='".$castrado."',
			`fecha_castrado`='".$fechaCastrado."',
			`observaciones`='".$observaciones."',
			`fk_id_especie`='".$fk_id_especie."',
			`fk_id_raza`='".$fk_id_raza."',
			`fk_id_pelaje`='".$fk_id_pelaje."'
			WHERE `id_ejemplar`='".$id_ejemplar."'";

	echo 'sql -->>> '.$sql;

	$ejemplar = mysql_query($sql,$link_veterinaria);

	$chipear = sql_update_chipeado_ejemplar($nroEjemplar, $fechaChip, $plan, $nro_recibo, $nombre_chipeador);

	//VACUNAS

	$deleteVacunas = sql_delete_vacunas_ejemplar($id_ejemplar);

	if($deleteVacunas)
	{
		if($sextuple = 'Sextuple' && $fechaSextuple != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,1,$fechaSextuple);
		}
		if($quintuple = 'Quintuple' && $fechaQuintuple != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,2,$fechaQuintuple);
		}
		if($rabia = 'Rabia' && $fechaRabia != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,3,$fechaRabia);
		}
		if($hidatidosis = 'Hidatidosis' && $fechaHidatidosis != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,4,$fechaHidatidosis);
		}
		if($gusanos_redondos = 'Gusanos Redondos' && $fechaGusanos != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,5,$fechaGusanos);
		}
		if($leucemia = 'Leucemia' && $fechaLeucemia != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,11,$fechaLeucemia);
		}
		if($rabiaFelino = 'Rabia' && $fechaRabiaFelino != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,5,$fechaRabiaFelino);
		}
		if($triple = 'Triple' && $fechaTriple != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,10,$fechaTriple);
		}
		if($anemia = 'Anemia Infecciosa' && $fechaAnemia != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,6,$fechaAnemia);
		}
		if($influenza = 'Influenza Equina' && $fechaInfluenza != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,7,$fechaInfluenza);
		}
		if($adenitis = 'Adenitis Equina' && $fechaAdenitis != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,8,$fechaAdenitis);
		}
		if($encefalomielitis = 'Encefalomielitis' && $fechaEncefalomielitis != "--")
		{
			$vac = sql_insert_vacunas($id_ejemplar,9,$fechaEncefalomielitis);
		}
	}

	//Propietarios

	$deletePropietario = sql_delete_propietarios_ejemplar($id_ejemplar);

	if($deletePropietario)
	{
		$propietario = sql_buscar_propietario($id_propietario);

		$row=mysql_fetch_array($propietario);

		$id_persona = ($row['id_persona']);

    $prop = sql_insert_propietario_ejemplar($id_ejemplar, $id_persona);
    }

	return $id_ejemplar;

}

// Asocia a un ejemplar especifico, los datos del chipeado.
function sql_insert_chipeado_ejemplar($fk_id_ejemplar, $fechaChip, $plan, $nro_recibo, $nombre_chipeador)
{

	$id_persona = "";

	$link_veterinaria = conectarse_mysql_veterinaria();

	$chipeador = sql_buscar_chipeador($nombre_chipeador);

	$row=mysql_fetch_array($chipeador);

	$id_persona = ($row['id_chipeador']);

	if($id_persona != "")
	{

		$sql = "INSERT INTO `chipeados`(`fecha_alta`, `plan`, `nro_recibo`, `fk_id_ejemplar`, `fk_id_chipeador`) VALUES ('".$fechaChip."', '".$plan."', '".$nro_recibo."', '".$fk_id_ejemplar."', '".$id_persona."')";

		$chipeado = mysql_query($sql,$link_veterinaria);

	}

	return $chipeado;

}

// Actualiza a un ejemplar especifico, los datos de chipeado.
function sql_update_chipeado_ejemplar($fk_id_ejemplar, $fechaChip, $plan, $nro_recibo/*, $dni_chipeador*/)
{

//lo dejo por si tenemos que modificar el aplicador de chip:
	//$chipeador = sql_buscar_propietario($dni_chipeador);

	//$row=mysql_fetch_array($chipeador);

	//$id_persona = ($row['id_persona']);

/*,			`fk_id_persona` = '".$id_persona."' */

	$id_persona = "";

	$link_veterinaria = conectarse_mysql_veterinaria();

	$chipeador = sql_buscar_chipeador($nombre_chipeador);

	$row=mysql_fetch_array($chipeador);

	$id_persona = ($row['id_chipeador']);

	if($id_persona != "")
	{

		$sql = "UPDATE `veterinaria`.`chipeados`
				SET `fecha_alta` = '".$fechaChip."',
				`plan` = '".$plan."',
				`nro_recibo` = '".$nro_recibo."',
				`fk_id_chipeador` = '".$id_persona."'
				WHERE `fk_id_ejemplar` = '".$fk_id_ejemplar."' ";
	}

	$chipeado = mysql_query($sql,$link_veterinaria);

	return $chipeado;

}

// Asocia un propietario a un ejemplar especifico.
function sql_insert_propietario_ejemplar($fk_id_ejemplar, $fk_id_propietario)
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql = "INSERT INTO `veterinaria`.`ejemplares_personas` (`fk_id_ejemplar`, `fk_id_persona`) VALUES ('$fk_id_ejemplar', '$fk_id_propietario')";

	$prop_ej = mysql_query($sql,$link_veterinaria);

	return $prop_ej;
}

// Elimina las vacunas asociadas a un ejemplar especifico.
function sql_delete_vacunas_ejemplar($id_ejemplar)
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="DELETE FROM `vacunas_ejemplares`
			WHERE fk_ejemplar = '".$id_ejemplar."';
		   ";

	$vacunas = mysql_query($sql,$link_veterinaria);

	return $vacunas;
}

//Elimina los propietarios asociados a un ejemplar especifico.
function sql_delete_propietarios_ejemplar($id_ejemplar)
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="DELETE FROM `ejemplares_personas`
			WHERE fk_id_ejemplar = '".$id_ejemplar."';
		   ";

	$propietarios = mysql_query($sql,$link_veterinaria);

	return $propietarios;
}

// Busca los datos de chipeado de un ejemplar especifico.
function sql_buscar_chipeado_animal($pid_ejemplar)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT *
			FROM `chipeados`
			WHERE `fk_id_ejemplar` =  ".$pid_ejemplar."
		  ";

	$chipeado = mysql_query($sql,$link_veterinaria);

	return $chipeado;
}

// Busca un ejemplar por id.
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

// Busca un ejemplar por numero de chip.
function sql_buscar_ejemplar_chip($pNro)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT *
				FROM ejemplares e
				JOIN ejemplares_personas ep ON e.id_ejemplar = fk_id_ejemplar
				JOIN personas p ON ep.fk_id_persona = p.id_persona
		   WHERE numero_chip =  '$pNro'";

	$ejemplar = mysql_query($sql,$link_veterinaria);

	return $ejemplar;
}

/********************************* END MODULO EJEMPLAR *************************************/

/*---------------------------------------- MODULO VACUNAS -------------------------------------------*/

//Busca las vacuans asociadas a un ejemplar especifico (por id ejemplar)
function sql_traer_vacunas_ejemplar($id_ejemplar)
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT c.id_vacuna, c.nombre_vacuna, a.fecha_aplicacion
			FROM `vacunas` c
			INNER JOIN (`vacunas_ejemplares` a
			            INNER JOIN `ejemplares` b ON a.`fk_ejemplar` = b.`id_ejemplar`)
			ON c.`id_vacuna` = a.`fk_vacuna`
			WHERE a.`fk_ejemplar` = '".$id_ejemplar."'
		  ";

	$vacunas = mysql_query($sql,$link_veterinaria);

	return $vacunas;
}

// Busca todas las vacunas.
function sql_traer_vacunas()
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT *
		   FROM `vacunas`
		  ";

	$vacunas = mysql_query($sql,$link_veterinaria);

	return $vacunas;
}

// Asocia vacunas a un ejemplar especifico, con la fecha de aplicacion correspondiente.
function sql_insert_vacunas($fk_id_ejemplar, $fk_id_vacuna, $fecha_vacuna)
{
	$vacuna = "";

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql = "INSERT INTO  `veterinaria`.`vacunas_ejemplares`
			(`fk_vacuna` ,`fk_ejemplar` ,`fecha_aplicacion`)
			VALUES
			('$fk_id_vacuna',  '$fk_id_ejemplar', '".$fecha_vacuna."')";

	$vacuna = mysql_query($sql,$link_veterinaria);

	return $vacuna;

}
/*********************************** END MODULO VACUNAS *********************************/

/*----------------------------------------- MODULO PELAJES -----------------------------------------*/

// Busca todos los pelajes.
function sql_traer_pelajes()
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT *
		   FROM `pelajes` ORDER BY `pelaje`
		  ";

	$pelajes = mysql_query($sql,$link_veterinaria);

	return $pelajes;
}

// Busca el id de un pelaje por su nombre.
function sql_buscar_id_pelaje($pPelaje)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_pelaje
		   FROM `pelajes`
		   WHERE pelaje = '".$pPelaje."'
		   ";

	$pIdPelaje = mysql_query($sql,$link_veterinaria);

	$pIdPelaje = mysql_result($pIdPelaje,0,"id_pelaje");

	return $pIdPelaje;
}

// Busca el nombre de un pelaje por su id.
function sql_buscar_pelaje_por_id($pid_pelaje)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_pelaje,pelaje
		   FROM `pelajes`
		   WHERE id_pelaje = ".$pid_pelaje."
		  ";

	$pelaje = mysql_query($sql,$link_veterinaria);

	$pelaje = mysql_result($pelaje,0,"pelaje");

	return $pelaje;
}
/*********************************** END MODULO PELAJES *********************************/

/*------------------------------------- MODULO ESPECIES ---------------------------------------*/

// Busca todas las especies.
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

//Busca el id de la especie por su nombre.
function sql_buscar_id_especie($pEspecie)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_especie
		   FROM `especies`
		   WHERE especie = '".$pEspecie."'
		   ";

	$pIdEspecie = mysql_query($sql,$link_veterinaria);

	$pIdEspecie = mysql_result($pIdEspecie,0,"id_especie");

	return $pIdEspecie;
}

//Busca el nombre de la especie por su id.
function sql_buscar_especie($pEspecie)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT especie
		   FROM `especies`
		   WHERE id_especie = '".$pEspecie."'
		   ";

	$pEspecie = mysql_query($sql,$link_veterinaria);

	$pEspecie = mysql_result($pEspecie,0,"especie");

	return $pEspecie;
}
// ver si se USA!!!!!!!!!!!!!!!!!!!! esta repetido
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
/******************************** END MODULO ESPECIES ******************************/

/*----------------------------------- MODULO RAZAS --------------------------------------*/

//Busca las razas asociadas a una especie especifica.
function sql_buscar_razas($pId_especie)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_raza,raza,fk_id_especie
		   FROM `razas`
		   WHERE fk_id_especie = '".$pId_especie."'  order by raza
		  ";

	$razas = mysql_query($sql,$link_veterinaria);

	return $razas;
}

// Busca todas las razas.
function sql_buscar_razas_todas()
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_raza,raza,fk_id_especie
		   FROM `razas` order by fk_id_especie
		  ";

	$razas = mysql_query($sql,$link_veterinaria);

	return $razas;
}

// Busca el id de una raza por su nombre.
function sql_buscar_id_raza($pRaza)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT id_raza
		   FROM `razas`
		   WHERE raza = '".$pRaza."'
		   ";

	$pIdRaza = mysql_query($sql,$link_veterinaria);

	$pIdRaza = mysql_result($pIdRaza,0,"id_raza");

	return $pIdRaza;
}

// Busca el nombre de una raza por su id.
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
/************************************* END MODULO RAZAS *****************************************/

/*----------------------               MODULO USUARIOS               -----------------------------*/

function sql_insert_usuario($nombre,$usuario,$clave,$rol)
{
	$nombre = htmlentities(addslashes($nombre));//Resuelvo problemas de comillas dentro del texto
	$usuario = htmlentities(addslashes($usuario));
	$clave = htmlentities(addslashes($clave));
	$rol = htmlentities(addslashes($rol));

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql = "INSERT INTO usuarios
			(`nombre` ,`usuario` ,`pass` ,`fk_rol`)
			VALUES
			('$nombre','$usuario','$clave',$rol)";

	$usuario = mysql_query($sql,$link_veterinaria);

	return $usuario;

}

function sql_buscar_usuario($nombre)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT *
		   FROM usuarios
		   WHERE usuario LIKE '$nombre'";

	$usuario = mysql_query($sql,$link_veterinaria);

	return $usuario;
}

function sql_modificar_usuario($rol,$usuario){
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql = "UPDATE usuarios SET fk_rol = $rol WHERE id_usuario = $usuario";

	$result = mysql_query($sql,$link_veterinaria);

	return $result;

}

function sql_reiniciar_clave_usuario($usuario,$clave){
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql = "UPDATE usuarios SET pass = '$clave' WHERE id_usuario = $usuario";

	$result = mysql_query($sql,$link_veterinaria);

	return $result;
}


/****************************       END MODULO USUARIOS             *************************/

/*------------------------            MODULO PERSONAS           -----------------------------------*/

// Crea un nuevo propietario.
function sql_insert_persona($txt_nombre_propietario,$txt_apellido,$txt_dni,$txt_telefono,$txt_calle,$txt_sexo,$txt_nro,$txt_barrio,$txt_piso, $txt_dpto, $txt_email,$txt_ec,$txt_fecha_nac,$txt_pais,$txt_cp)
{
  $txt_fecha_nac = fecha_mysql_normal($txt_fecha_nac);
	$persona = "";

	$txt_calle = htmlentities(addslashes($txt_calle));//Resuelvo problemas de comillas dentro del texto
	$txt_barrio = htmlentities(addslashes($txt_barrio));
	$txt_piso = htmlentities(addslashes($txt_piso));
	$txt_dpto = htmlentities(addslashes($txt_dpto));
	$txt_email = htmlentities(addslashes($txt_email));


	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql = "INSERT INTO `personas`
	(`IDENTIFICADOR`, `TIPO_DOCUMENTO`, `DOCUMENTO`, `APELLIDO`,
		 `NOMBRE`, `SEXO`, `CALLE_NOCOD`, `NUMERACION_CALLE`, `DEPARTAMENTO`,
		  `PISO`, `BARRIO`, `CODIGO_POSTAL_AUXILIAR`, `CODIGO_CALLE`,`CODIGO_ESTADO_CIVIL`,
			 `TELEFONO`, `CODIGO_PROVINCIA`, `CODIGO_NACIONALIDAD`, `CODIGO_DGI`,`INGRESOS_BRUTOS`,
			  `CAJA_JUBILACION`, `CUIT_CUIL`, `FECHA_NACIMIENTO`, `FECHA_FALLECIMIENTO`,`OBSERVACIONES`,
				 `TELEFONO_MOVIL`, `E_MAIL`, `TORRE`, `CODIGO_POSTAL_AMPLIADO`,`PAIS`,
				  `FECHA_AC`, `APELLIDO_NOMBRE`, `CODIGO_POSTAL_SUFIJO`, `id_subrogado`, `unificado`)
					VALUES ('00000',1,'$txt_dni','$txt_apellido',
									'$txt_nombre_propietario','$txt_sexo','$txt_calle',$txt_nro,'$txt_dpto',
									$txt_piso,'$txt_barrio','$txt_cp',null,'$txt_ec',
									'$txt_telefono',null,null,null,null,
									null,null,'$txt_fecha_nac',null,null,
									null,'$txt_email',null,null,'Argentina',
									null,'$txt_apellido $txt_nombre_propietario',null,null,0)";



	$persona = mysql_query($sql,$link_veterinaria);
	/*echo "SQL: ".$sql."\n";
	echo "Res: ".$persona;
	exit();*/
	return $persona;

}

// Trae todas las personas cargadas, devuelve solo el documento, apellido y nombre.
function sql_buscar_personas()
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT identificador,documento,nombre,apellido
		   FROM `personas` LIMIT 100
		   ";
	$personas = mysql_query($sql,$link_veterinaria);

	return $personas;

}

// Busca una persona por documento.
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

function sql_buscar_persona_id($id)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT *
		   FROM `personas`
		   WHERE id_persona =  ".$id."
		  ";

	$persona = mysql_query($sql,$link_veterinaria);

	return $persona;
}

// Busca los propietarios de un ejemplar especifico.
function sql_buscar_propietario_ejemplar($pEjemplar)
{

	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT `IDENTIFICADOR`, `documento`, `nombre`, `apellido`
			FROM `personas`
			INNER JOIN `ejemplares_personas`
			ON `personas`.`id_persona` = `ejemplares_personas`.`fk_id_persona`
			WHERE `fk_id_ejemplar`= ".$pEjemplar."
		  ";

	$propietario = mysql_query($sql,$link_veterinaria);

	return $propietario;
}

// Trae todas las personas con todos sus datos.
function sql_traer_propietarios()
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT *
		   FROM `personas` LIMIT 100
		  ";

	$propietarios = mysql_query($sql,$link_veterinaria);

	return $propietarios;
}

// Actualiza una persoan especifica.
function sql_update_propietario($txt_dni_original,$txt_dni,$txt_nombre_propietario,$txt_apellido,$txt_telefono,$txt_calle,$txt_nro,$txt_barrio,$txt_piso,$txt_dpto,$txt_email)
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
	nombre = '$txt_nombre_propietario',
	apellido = '$txt_apellido',
	telefono = '$txt_telefono',
	calle = '$txt_calle',
	numero = '$txt_nro',
	barrio = '$txt_barrio',
	piso = '$txt_piso',
	departamento = '$txt_dpto',
	email = '$txt_email'
	where documento = '$txt_dni_original'";

	$propietario = mysql_query($sql,$link_veterinaria);

	return $propietario;

}

// Verifica si ya existe una persona cargada con un documento especifico.
function sql_buscar_persona_duplicada($pDni)
{
	$flag = false;
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT documento
		   FROM `personas`
		   WHERE documento = '".$pDni."'
		   ";

	$pDni = mysql_query($sql,$link_veterinaria);

	$pDni = mysql_result($pDni,0,"documento");

	if ($pDni)
	{
		$flag = true;
	}else
		$flag = false;

	return $flag;
}

/*************************  END MODULO PERSONAS  ********************************/
/************************* CHIPEADORES ******************************************/
function sql_insert_chipeador($nombre)
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="INSERT INTO chipeadores(nombre_chipeador) VALUES('$nombre')";
	$stmt = mysql_query($sql,$link_veterinaria);

	if($stmt){
		return true;
	}else{
		return false;
	}

}

function sql_buscar_chipeador($nombre)
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT *
		   FROM `chipeadores`
		   WHERE nombre_chipeador =  '$nombre'
		  ";

	$chipeador = mysql_query($sql,$link_veterinaria);

	return $chipeador;
}

// Busca todos los chipeadores.
function sql_traer_chipeadores()
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT *
		   FROM `chipeadores` ORDER BY `nombre_chipeador`
		  ";

	$chipeadores = mysql_query($sql,$link_veterinaria);

	return $chipeadores;
}

function sql_buscar_chipeador_ejemplar($id_ejemplar)
{
	$link_veterinaria = conectarse_mysql_veterinaria();

	$sql ="SELECT `chipeadores`.`id_chipeador`, `chipeadores`.`nombre_chipeador`
			FROM `chipeados`
			INNER JOIN `chipeadores`
			ON `chipeados`.`fk_id_chipeador`=`chipeadores`.`id_chipeador`
			WHERE `fk_id_ejemplar`= $id_ejemplar
		  ";

	$chipeador = mysql_query($sql,$link_veterinaria);

	return $chipeador;
}

/************************* CHIPEADORES ******************************************/
?>
