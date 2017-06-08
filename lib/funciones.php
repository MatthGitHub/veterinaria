<?php

	function conectarse_mysql_veterinaria(){
		if (!($link=mysql_connect("localhost","root","cavaliere")))  {
		   echo "Error conectando al servidor.";
		   exit();
		   }
		if (!mysql_select_db("veterinaria",$link))  {
		   echo "Error seleccionando la base de datos.";
		   exit();
		   }
		   mysql_set_charset('utf8',$link);
		return $link;
	}

	
//---Manejo de fechas------------------------------------
function fecha_mysql_normal($fechavieja){
    list($a,$m,$d)=explode("-",$fechavieja);
    return $d."-".$m."-".$a;
};

function fecha_normal_mysql($fechavieja){
    list($d,$m,$a)=explode("-",$fechavieja);
    return $a."-".$m."-".$d;
};

function timestampToFecha ($timeStamp)
{
    $fechaDelTime=getdate($timeStamp);
		  $dia=$fechaDelTime[mday];
		  $mes=$fechaDelTime[mon];
		  $anio=$fechaDelTime[year];
		  $hora=$fechaDelTime[hours];
		  $minuto=$fechaDelTime[minutes];
$fechaDelTime=$dia."-".$mes."-".$anio;		

    return $fechaDelTime;
}


function fechaToTimestamp ($cadena)
{
    $retorno = "";

    
    list ($dia, $mes, $anyo)          = explode ("-", $fecha);
	
   
    if (!$fecha)
    {
        list ($dia, $mes, $anyo) = explode ("-", $cadena);
    }
       
  
    $retorno = mktime(0,0,0,$mes,$dia,$anyo);

    return $retorno;
}

//---------------------------------------		

	////////////////////////////////////////////////////
	//Convierte fecha de mysql a normal
	////////////////////////////////////////////////////
	function cambiaf_a_mssql($fecha){
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
		$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
		return $lafecha;
	}
	function cambiaf_desde_mssql($fecha){
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
		$lafecha=$mifecha[2]."/".$mifecha[1]."/".$mifecha[3];
		return $lafecha;
	}
	function cambiaf_a_normal($fecha){
		ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
		$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
		return $lafecha;
	}
	////////////////////////////////////////////////////
	//Convierte fecha de normal a mysql
	////////////////////////////////////////////////////
	
	function cambiaf_a_mysql($fecha){
		ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
		$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
		return $lafecha;
	} 
	function lngBuscaId($txtTabla,$lngId) 
	{
		
		$link=Conectarse();
		$qry="Select max($lngId) from $txtTabla;";
		$result=mssql_query($qry,$link);
		$tuplas=0;
		$tuplas = mssql_num_rows($result);
		
		
		if ($tuplas!=0)
		{
			while($array = mssql_fetch_array($result)) {
					$id=$array[0]+1;
					return $id;
						}
		}
		else
		{
			 $id=1;
			 return $id;
		}
				
	}
	function GetIP()
	{
	   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
			   $ip = getenv("HTTP_CLIENT_IP");
	   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			   $ip = getenv("HTTP_X_FORWARDED_FOR");
	   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			   $ip = getenv("REMOTE_ADDR");
	   else if (isset($_SERVER[´REMOTE_ADDR´]) && $_SERVER[´REMOTE_ADDR´] && strcasecmp($_SERVER[´REMOTE_ADDR´], "unknown"))
			   $ip = $_SERVER[´REMOTE_ADDR´];
	   else
			   $ip = "unknown";
	  
	   return($ip);
	}

	function fecha()
	{
		/* Definición de los meses del año en castellano */
		$mes[0]="-";
		$mes[1]="enero";
		$mes[2]="febrero";
		$mes[3]="marzo";
		$mes[4]="abril";
		$mes[5]="mayo";
		$mes[6]="junio";
		$mes[7]="julio";
		$mes[8]="agosto";
		$mes[9]="septiembre";
		$mes[10]="octubre";
		$mes[11]="noviembre";
		$mes[12]="diciembre";

		/* Definición de los días de la semana */
		$dia[0]="Domingo";
		$dia[1]="Lunes";
		$dia[2]="Martes";
		$dia[3]="Miércoles";
		$dia[4]="Jueves";
		$dia[5]="Viernes";
		$dia[6]="Sábado";
		
		/* Implementación de las variables que calculan la fecha */
		$gisett=(int)date("w");
		$mesnum=(int)date("m");
		/* Variable que calcula la hora*/
		$hora = date(" H:i",time());
		
		/* Presentación de los resultados en una forma similar a la siguiente:
		Miércoles, 23 de junio de 2004 | 17:20
		*/
		
		return $dia[$gisett].", ".date("d")." de ".$mes[$mesnum]." de ".date("Y")." | ".$hora;
	}
	//mostrar un fecha con formato normal
//	<input type="text" name="fecha" value="<?echo cambiaf_a_normal($fila->fecha);

//Juan Carlos Ramos
//Normaliza la codificacion de fuente a utf8_encode
function normaliza ($cadena){

    return utf8_encode($cadena);
}

//Juan Carlos Ramos
function mes_letra($mes_numero)
{
	switch ($mes_numero) {
		case 1:
			$mes_letra = "Enero";
		break;
		case 2:
			$mes_letra = "Febrero";
		break;
		case 3:
			$mes_letra = "Marzo";
		break;
		case 4:
			$mes_letra = "Abril";
		break;
		case 5:
			$mes_letra = "Mayo";
		break;
		case 6:
			$mes_letra = "Junio";
		break;
		case 7:
			$mes_letra = "Julio";
		break;
		case 8:
			$mes_letra = "Agosto";
		break;
		case 9:
			$mes_letra = "Septiembre";
		break;
		case 10:
			$mes_letra = "Octubre";
		break;
		case 11:
			$mes_letra = "Noviembre";
		break;
		case 12:
			$mes_letra = "Diciembre";
		break;
	}
	return $mes_letra;
}
//Juan Carlos Ramos
function limpia_espacios_x_guin_bajo($cadena){
    $cadena = str_replace(' ','_', $cadena);
    return $cadena;
}
?>