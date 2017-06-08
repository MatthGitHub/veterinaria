<?php

$ajusteHoraLocal=86400;
$dia=86400;


function conecta_sqls(){
		if (!($link=mssql_connect("10.20.130.8","sa","kristina")))  {
		   echo "Error conectando a la base de datos.";
		   exit();
		   }
		if (!mssql_select_db("db_electoral_juanma",$link))  {
		   echo "Error seleccionando la base de datos.";
		   exit();
		   }
		return $link;
}




function conecta() {

if (!($link=mysql_connect("localhost","root","admin"))){
	   echo "Error conectando a la base de datos.";
	   exit();
	   }
	if (!mysql_select_db("base_aserradero",$link)){
	   echo "Error seleccionando la base de datos.";
	   exit();
	   }
	   


	   

//para conectarse de forma local
/*if (!($link=mysql_connect("localhost","root","")))  {
		   echo "Error conectando a la base de datos.";
		   exit();
		   }
		if (!mysql_select_db("aserradero",$link))  {
		   echo "Error seleccionando la base de datos.";
		   exit();
		   }*/
		   
		return $link;
}


function timestampToFecha($timeStamp)
{
    $fechaDelTime=getdate($timeStamp);
		  $dia=$fechaDelTime["mday"];
		  $mes=$fechaDelTime["mon"];
		  $anio=$fechaDelTime["year"];
		  $hora=$fechaDelTime["hours"];
		  $minuto=$fechaDelTime["minutes"];
$fechaDelTime=$dia."-".$mes."-".$anio;		

    return $fechaDelTime;
}

function timestampToFechaPagoAlquiler ($timeStamp)
{
    $fechaDelTime=getdate($timeStamp);
		  $dia=$fechaDelTime[mday];
		  $mes=$fechaDelTime[mon];
		  $anio=$fechaDelTime[year];
		  $hora=$fechaDelTime[hours];
		  $minuto=$fechaDelTime[minutes];
$fechaDelTime=$mes."-".$anio;		

    return $fechaDelTime;
}


function fechaToTimestamp ($cadena)
{
    $retorno = "";

    
    //list ($dia, $mes, $anyo)          = explode ("-", $fecha);
	list ($dia, $mes, $anyo) = explode ("-", $cadena);
   
 /*   if (!$fecha)
    {
        list ($dia, $mes, $anyo) = explode ("-", $cadena);
    }*/
       
  
    $retorno = mktime(0,0,0,$mes,$dia,$anyo);

    return $retorno;
}



function calculaCuotas ($time_inicial,$time_final)
{
$mes=2592000;
$total=$time_final-$time_inicial;
$cuotas=floor($total/$mes);
return $cuotas;
}

function listaVencimientos ($time_inicial,$time_final)
{
$mes=2592000;
while ($conta < calculaCuotas ($time_inicial,$time_final)){
$time_inicial=$time_inicial+$mes;
echo timestampToFeecha($time_inicial);
$conta=$conta+1;
}

return ;
}

function auditar ($usuario,$fecha,$tabla,$registro,$operacion,$conexion)
{
    $query_insert_auditoria="insert into auditorias(usuario,fecha,tabla,registro,operacion) 
values ('$usuario','$fecha','$tabla','$registro','$operacion')";
mysql_query($query_insert_auditoria,$conexion);
    return ;
}

function traeIdInsertado ($tabla,$id,$conexion)
{
    $query_trae_id="select max(".$id.") as ultimo from ".$tabla;
$maxId=mysql_query($query_trae_id,$conexion);
$id=mysql_result($maxId,0,"ultimo"); 
    return $id;
}

function cuenta_dias ($time_inicial,$time_final)
{
$dia=86400;
$segundos=$time_final-$time_inicial;
$dias=$segundos/$dia;
return (int)$dias;
}

function total_caja ($moneda,$cheque,$fdesde,$fhasta,$usuario,$link)
{

$query_caja="select * from caja where tipo_moneda like '$moneda%' and cheque='$cheque' and realizado_por='$usuario' and fecha between '$fdesde' and '$fhasta' order by fecha"; 
$movimientos=mysql_query($query_caja,$link);
$filas_movimientos=mysql_num_rows($movimientos);

$conta=0;
while ($conta < $filas_movimientos){ 
				
	$ingreso_total=$ingreso_total+mysql_result($movimientos,$conta,"ingreso");
	$egreso_total=$egreso_total+mysql_result($movimientos,$conta,"egreso");
	$conta =$conta+1;
}
			
$total=$ingreso_total-$egreso_total;


return $total;

}

function total_caja_persona ($moneda,$cheque,$fdesde,$fhasta,$persona,$link)
{

$query_caja="select * from caja where tipo_moneda like '$moneda%' and cheque='$cheque' and responsable='$persona' and fecha between '$fdesde' and '$fhasta' order by fecha"; 
$movimientos=mysql_query($query_caja,$link);
$filas_movimientos=mysql_num_rows($movimientos);

$conta=0;
while ($conta < $filas_movimientos){ 
				
	$ingreso_total=$ingreso_total+mysql_result($movimientos,$conta,"ingreso");
	$egreso_total=$egreso_total+mysql_result($movimientos,$conta,"egreso");
	$conta =$conta+1;
}
			
$total=$ingreso_total-$egreso_total;


return $total;

}


function da_mes ()
{

$Tstamp=time();
$Fecha=getdate($Tstamp);
$mes=$Fecha[mon];
if ($mes==1) $nomMes="Enero";
if ($mes==2) $nomMes="Febrero";
if ($mes==3) $nomMes="Marzo";
if ($mes==4) $nomMes="Abril";
if ($mes==5) $nomMes="Mayo";
if ($mes==6) $nomMes="Junio";
if ($mes==7) $nomMes="Julio";
if ($mes==8) $nomMes="Agosto";
if ($mes==9) $nomMes="Septiembre";
if ($mes==10) $nomMes="Octubre";
if ($mes==11) $nomMes="Noviembre";
if ($mes==12) $nomMes="Diciembre";
$dia=$Fecha[wday];
if ($dia==0) $nomDia="Domingo";
if ($dia==1) $nomDia="Lunes";
if ($dia==2) $nomDia="Martes";
if ($dia==3) $nomDia="Miercoles";
if ($dia==4) $nomDia="Jueves";
if ($dia==5) $nomDia="Viernes";
if ($dia==6) $nomDia="Sabado";


return $nomMes;

}


function fecha_full($fecha_ts)
{


$Fecha=getdate($fecha_ts);
$dia=$Fecha[day];
$mes=$Fecha[mon];
$nro_dia=$Fecha[mday];
$anio=$Fecha[year];

if ($mes==1) $nomMes="Enero";
if ($mes==2) $nomMes="Febrero";
if ($mes==3) $nomMes="Marzo";
if ($mes==4) $nomMes="Abril";
if ($mes==5) $nomMes="Mayo";
if ($mes==6) $nomMes="Junio";
if ($mes==7) $nomMes="Julio";
if ($mes==8) $nomMes="Agosto";
if ($mes==9) $nomMes="Septiembre";
if ($mes==10) $nomMes="Octubre";
if ($mes==11) $nomMes="Noviembre";
if ($mes==12) $nomMes="Diciembre";
$dia=$Fecha[wday];
if ($dia==0) $nomDia="Domingo";
if ($dia==1) $nomDia="Lunes";
if ($dia==2) $nomDia="Martes";
if ($dia==3) $nomDia="Miercoles";
if ($dia==4) $nomDia="Jueves";
if ($dia==5) $nomDia="Viernes";
if ($dia==6) $nomDia="Sabado";


return $nomDia." ".$nro_dia." de ".$nomMes." de ".$anio;

}

function retorna_vacio ($valor)
{
if ($valor==0){
return "";
}
else
{
return $valor;
}

}

?>