<?php
include("../conecta.php");
require_once("class.ezpdf.php");


//Configuración de página-----------------

$pdf =& new Cezpdf('a4');

$pdf->selectFont('../fonts/courier.afm');

$pdf->ezSetCmMargins(1,1,1.5,1.5);

//Fin configuración de página-----------------


include("../funciones.php");
$link=conecta_sqls();


if (isset($_GET["txt_libro"])){
	$libro=$_GET["txt_libro"];
}



$query_total_firmantes="select count(distinct elector) as tot_firmantes from je_regfirmas_registro where 
firma='1' ";

$recordset_total_firmantes=mssql_query($query_total_firmantes,$link);
$total_firmantes=mssql_result($recordset_total_firmantes,0,"tot_firmantes");

//------------------------------------------------------------

$query_tabla_firmantes="select t.elector as elector,p.nome as nome,r.libro as libro,r.folio as folio,r.orden as orden,r.fecha_registro  from
(SELECT elector FROM je_regfirmas_registro where firma='1' GROUP BY elector HAVING Count(*) > 1) t inner join je_regfirmas_registro r
on t.elector=r.elector 
inner join je_regfirmas_padron p
on 
r.elector=p.matricula
order by p.nome";
$recordset_tabla_firmantes=mssql_query($query_tabla_firmantes,$link);

//------------------------------------------------------

$query_total_firmas="select count(elector) as tot_firmas from je_regfirmas_registro where
firma='1'";

$recordset_total_firmas=mssql_query($query_total_firmas,$link);
$total_firmas=mssql_result($recordset_total_firmas,0,"tot_firmas");







//Armado de las matrices-------------------------------------
$ixx = 0;
while($datatmp = mssql_fetch_assoc($recordset_tabla_firmantes)) {
	$ixx = $ixx+1;
	
	$datatmp["fecha_registro"]=timestampToFecha($datatmp["fecha_registro"]); 

    $data[] = array_merge($datatmp, array('num'=>$ixx));

}


$titles = array(

                //'num'=>'<b>Num</b>',

               	
              	'elector'=>' <b>Documento</b>',
				'nome'=>' <b>Elector</b>',
				'fecha_registro'=>'<b>Fecha</b>',
				'libro'=>' <b>Libro</b>',
				'folio'=>' <b>Folio</b>',
				'orden'=>' <b>Orden</b>',

            

            );


$options = array(

              //  'shadeCol'=>array(0.9,0.9,0.9),

                'xOrientation'=>'center',

                'width'=>500

            );


// Fin armado de matrices-----------------------------------

$txttit= "Listado de electores con firmas repetidas \n";


 


$pdf->ezText($txttit, 12);


$pdf->ezTable($data,$titles ,'' , $options);

$pdf->ezText("\n\n\n", 10);

$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);

$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();

?>