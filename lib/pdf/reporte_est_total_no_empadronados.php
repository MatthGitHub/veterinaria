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

$query_tabla_firmantes="select r.fecha_registro,r.elector,r.libro,r.folio,r.orden from 
je_regfirmas_registro r
where 
firma='1'
and anulado='1'
order by r.elector";

/*"select r.fecha_registro,r.elector,r.libro,r.folio,r.orden,p.nome,p.matricula from 
je_regfirmas_registro r left join je_regfirmas_padron p on r.elector=p.matricula
where 
firma='1'
and p.matricula is null
order by p.nome asc";*/
$recordset_tabla_firmantes=mssql_query($query_tabla_firmantes,$link);

//------------------------------------------------------

$query_total_firmas="select count(elector) as tot_firmas from je_regfirmas_registro where
firma='1'
and anulado='1'";

$recordset_total_firmas=mssql_query($query_total_firmas,$link);
$total_firmas=mssql_result($recordset_total_firmas,0,"tot_firmas");

$query_total_firmas_validas="select count(distinct elector) as tot_firmas from je_regfirmas_registro where
firma='1'
and anulado='1'";

$recordset_total_firmas_validas=mssql_query($query_total_firmas_validas,$link);
$total_firmas_validas=mssql_result($recordset_total_firmas_validas,0,"tot_firmas");







//Armado de las matrices-------------------------------------
$ixx = 0;
while($datatmp = mssql_fetch_assoc($recordset_tabla_firmantes)) {
	$ixx = $ixx+1;
	
	$datatmp["fecha_registro"]=timestampToFecha($datatmp["fecha_registro"]); 

    $data[] = array_merge($datatmp, array('num'=>$ixx));

}


$titles = array(

                //'num'=>'<b>Num</b>',

               	'fecha_registro'=>'<b>Fecha</b>',
              	'elector'=>' <b>Documento</b>',
				'nome'=>' <b>Elector</b>',
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

$txttit= "Firmas de personas no empadronadas. ";


 


$pdf->ezText($txttit, 13);
$pdf->ezText("\n", 10);


$pdf->ezTable($data,$titles ,'' , $options);

$pdf->ezText("\n\n\n", 10);

$pdf->ezText("Total de firmas: ".$total_firmas_validas, 12);
$pdf->ezText("\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);

$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();

?>