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
    $pdf			= new MyPDFFile("L","mm","Letter");
    $pdf->SetFont("Arial","",10);
    $pdf->SetMargins(7,10,7);
    $pdf->SetAutoPageBreak(true,10);
    $pdf->AddPage("L","Letter");
    $pdf->Cell(0,10,utf8_decode("BITÁCORA DE SERVICIOS"),0,1,'C');
    $pdf->Ln(10);
    $ancho=$pdf->CurPageSize[1]-20;
    $pdf->Cell($ancho-130,5);
    $pdf->Cell(20,5,utf8_decode("Ruta"),0,0,'R');
    foreach($xml->getElementsByTagName('bitacora_ruta_identificador') as $nodo)
    {
    	$pdf->Cell(40,5,utf8_decode($nodo->nodeValue),1,0,'C');
    	break;
	}
	$pdf->Cell(10,5);
    $pdf->Cell(20,5,utf8_decode("Folio"),0,0,'R');
    foreach($xml->getElementsByTagName('bitacora_folio') as $nodo)
    {
    	$pdf->Cell(40,5,utf8_decode($nodo->nodeValue),1,1,'C');
    	break;
	}
    $pdf->Cell($ancho-130,5);
    $pdf->Cell(20,5,utf8_decode("Nombre"),0,0,'R');
    foreach($xml->getElementsByTagName('bitacora_ruta_nombre') as $nodo)
    {
    	$pdf->Cell(40,5,utf8_decode($nodo->nodeValue),1,0,'C');
    	break;
	}
	$pdf->Cell(10,5);
    $pdf->Cell(20,5,utf8_decode("Fecha"),0,0,'R');
    foreach($xml->getElementsByTagName('bitacora_fecha') as $nodo)
    {
    	$pdf->Cell(40,5,utf8_decode($nodo->nodeValue),1,1,'C');
    	break;
	}
	$pdf->Ln(10);
	$pdf->Cell(10,5);
	foreach($xml->getElementsByTagName('bitacora_operador') as $nodo)
    {
    	$pdf->Cell(0,5,utf8_decode("Nombre del Operador: ".$nodo->nodeValue),0,1,'L');
    	break;
	}
	$pdf->Ln(5);
	$pdf->Image("../img/sistema/simma_printer.png",10,10,87.5);
	$pdf->SetFillColor(150,150,150);
	$pdf->SetFont("","B",6);
	$pdf->SetWidths(array(7,10,9,13,50,10,10,40,15,18,15,15,15,15,25));
	$pdf->SetAligns(array("C","C","C","C"));
	$pdf->Row(array(
		"\nNo.",
		"No. de Cliente",
		"No. de Gen.",
		"No. de Manif.",
		"\nNombre del Cliente",
		"Hora de Llegada",
		"Hora de Salida", 
		"\nResposanble Generador",
		"Cultivos y Cepas",
		"Objetos Punzocortantes",
		"\nPatológico",
		"No Anatómico",
		"\nSangre",
		"Total de Kilos",
		"\nFirma del Cliente"
	),true);
    foreach($xml->getElementsByTagName("manifiesto") as $k=>$manifiesto)
    {
    	$data=array($k);
		foreach($manifiesto->getElementsByTagName('data') as $nodo)
	    {
	    	if($nodo->getAttribute('name')=="manifiesto_space_nocte")
	    	{
	    		array_push($data,$nodo->nodeValue);
				break;
	    	}
		}
		foreach($manifiesto->getElementsByTagName('data') as $nodo)
	    {
	    	if($nodo->getAttribute('name')=="manifiesto_space_nogen")
	    	{
				array_push($data,$nodo->nodeValue);
				break;
	    	}
		}
		foreach($manifiesto->getElementsByTagName('data') as $nodo)
	    {
	    	if($nodo->getAttribute('name')=="manifiesto_space_nomanifiesto")
	    	{
				array_push($data,$nodo->nodeValue);
				break;
	    	}
		}
		foreach($manifiesto->getElementsByTagName('data') as $nodo)
	    {
	    	if($nodo->getAttribute('name')=="manifiesto_space_generedorrazonsocial")
	    	{
				array_push($data,$nodo->nodeValue);
				break;
	    	}
		}
		array_push($data,"\n\n");
		array_push($data,"");
		array_push($data,"");
		array_push($data,"");
		array_push($data,"");
		array_push($data,"");
		array_push($data,"");
		array_push($data,"");
		array_push($data,"");
		array_push($data,"");
		$pdf->Row($data);
    }
    $pdf->SetFont("","",8);
    $pdf->Ln(5);
    $pdf->Cell(7,10);
    $pdf->Cell(30,10,utf8_decode("KM. Inicial"),1,0,"C");
    $pdf->Cell(15,10,"",1);
    $pdf->Cell(5,10);
    $pdf->Cell(30,10,utf8_decode("Hora de Salida"),1,0,"C");
    $pdf->Cell(15,10,"",1);
    $pdf->Cell(5,10);
    $pdf->Cell(30,10,utf8_decode("Manifiestos Enviados"),1,0,"C");
    $pdf->Cell(15,10,"",1);
    $pdf->Cell(5,10);
    $pdf->Cell(30,10,utf8_decode("Total Kilogramos"),1,0,"C");
    $pdf->Cell(5,10);
    $pdf->Cell(70,10,utf8_decode("Recibe Planta"),1,1,"C");
    $pdf->Cell(7,10);
    $pdf->Cell(30,10,utf8_decode("KM. Final"),1,0,"C");
    $pdf->Cell(15,10,"",1);
    $pdf->Cell(5,10);
    $pdf->Cell(30,10,utf8_decode("Hora de Llegada"),1,0,"C");
    $pdf->Cell(15,10,"",1);
    $pdf->Cell(5,10);
    $pdf->Cell(30,10,utf8_decode("Manifiestos Recibidos"),1,0,"C");
    $pdf->Cell(15,10,"",1);
    $pdf->Cell(5,10);
    $pdf->Cell(30,10,utf8_decode(""),1,0,"C");
    $pdf->Cell(5,10);
    $pdf->Cell(30,10,utf8_decode(""),1,0,"C");
    $pdf->Cell(40,10,utf8_decode(""),1,1,"C");
    $pdf->Cell(7,10);
    $pdf->Cell(30,10,utf8_decode("KM. Recorridos"),1,0,"C");
    $pdf->Cell(15,10,"",1);
    $pdf->Cell(55,10);
    $pdf->Cell(30,10,utf8_decode("Diferencia"),1,0,"C");
    $pdf->Cell(15,10,"",1);
    $pdf->Cell(40,10);
    $pdf->SetFont("","",6);
    $pdf->Cell(30,10,utf8_decode("Núm. de Manifiestos Recibidos"),1,0,"C");
    $pdf->SetFont("","",8);
    $pdf->Cell(40,10,utf8_decode("Nombre, Fecha y Firma"),1,1,"C");
    $pdf->Cell(192,10);
    $pdf->Cell(70,5,utf8_decode("Favor de marcar los manifiestos recibidos en bitácora"),0,1,"C");
    $pdf->Output();
}
?>