<?php
require("pdf/fpdf.php");
require("pdf/MyPDFFile.class.php");
$dir_in         = "../files/download/";
$dir_out        = "../files/download/";
$dir_template   = "../files/templates/";
$archivo        = (isset($_GET["arch"]) && $_GET["arch"]!="" && file_exists($dir_in.$_GET["arch"])?$_GET["arch"]:"");
$coords			= (file_exists($dir_template."coordenadas_manifiesto.json")?json_decode(file_get_contents($dir_template."coordenadas_manifiesto.json"),true):"");

if($archivo!="" && $coords!="")
{
	$xml			= new DOMDocument();
    $xml->load($dir_in.$archivo);
    $pdf			= new MyPDFFile("P","mm","Letter");
    foreach($xml->getElementsByTagName("manifiesto") as $manifiesto)
    {
		AgregaManifiesto($pdf,$manifiesto,$coords);
    }
    $pdf->Output();
}

function AgregaManifiesto(MyPDFFile &$pdf,DOMElement $nodoManifiesto,$coords)
{
	$pdf->AddPage("P","Letter");
	$pdf->SetFont("Times","",9);
	$pdf->SetMargins(0,0,0);
	$pdf->SetAutoPageBreak(false,0);
	$generalX=$coords["general"]["posicion"]["x"];
	$generalY=$coords["general"]["posicion"]["y"];
	foreach($nodoManifiesto->getElementsByTagName("data") as $data)
	{
		$elem=$data->getAttribute("name");
		$cont=$data->nodeValue;
		$pos=ObtieneCoordenadas($elem,$coords);
		if($pos!==false && is_array($pos))
		{
			$cont=utf8_decode($cont);
			$pdf->Text($pos[0]+$generalX,$pos[1]+$generalY,$cont);
		}
	}
}

function ObtieneCoordenadas($campo,$coords)
{
	$x=0;
	$y=0;
	$sx=0;
	$sy=0;
	$campo=strtolower(trim($campo));
	foreach($coords["seccion"] as $sec)
	{
		$sx=$sec["posicion"]["x"];
		$sy=$sec["posicion"]["y"];
		foreach($sec["campos"] as $k=>$c)
		{
			if(strtolower(trim($k))==$campo)
			{
				if($c["visible"]===true)
					return array($sx+$c["x"],$sy+$c["y"]);
				return false;
			}
		}
	}
	throw(new Exception("No se encontro el campo en el archivo de coordenadas"));
	return false;
}
?>