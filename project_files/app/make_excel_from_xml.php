<?php
include("phpExcel/PHPExcel.php");

$dir_in         = "../files/download/";
$dir_out        = "../files/download/";
$dir_template   = "../files/templates/";
$archivo        = (isset($_GET["arch"]) && $_GET["arch"]!="" && file_exists($dir_in.$_GET["arch"])?$_GET["arch"]:"");
$path        	= (isset($_GET["path"]) && $_GET["path"]!=""?$_GET["path"]:"");

if($archivo!="")
{
	$xml			= new DOMDocument();
    $xml->load($dir_in.$archivo);
    $template		= "";
    $nombre			= "";
    foreach($xml->getElementsByTagName("propiedades") as $p)
    {
		$template	= $p->getAttribute("template");
		$nombre		= $p->getAttribute("titulo");
		$nombre		= str_replace(" ","_",$nombre)."_".time().".xlsx";
    }
    if(file_exists($dir_template.$template)==false)
    	throw new Exception("No esxiste el archivo template: $dir_template$template");
    $libro      	= PHPExcel_IOFactory::load($dir_template.$template);
    foreach($xml->getElementsByTagName("hoja") as $h)
    {
		$hoja		= $libro->getSheetByName($h->getAttribute("titulo"));
		$noFila		= intval($h->getAttribute("iniciarEnFila"));
		foreach($h->getElementsByTagName("fila") as $f)
		{
			foreach($f->getElementsByTagName("celda") as $k=>$c)
			{
				$hoja->setCellValueByColumnAndRow($k,$noFila,$c->nodeValue,true);
			}
			$noFila++;
		}
		foreach($hoja->getColumnDimensions() as $k=>$col)
		{
			$hoja->getColumnDimension($k)->setAutoSize(true);
		}
    }
    if(file_exists($dir_out.$nombre))
    	unlink($dir_out.$nombre);
    $objWriter = PHPExcel_IOFactory::createWriter($libro,"Excel2007");
    $objWriter->save($dir_out.$nombre);
    echo "$path/$nombre";
}
else
	throw new Exception("No se encuentra el archivo xml: ".$_GET["arch"]);
?>