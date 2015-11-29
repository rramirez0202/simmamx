<?php
include("phpExcel/PHPExcel.php");

$dir_in         = "../files/upload/";
$dir_out        = "../files/upload/";
$dir_template   = "../files/templates/";
$archivo        = (isset($_GET["arch"]) && $_GET["arch"]!="" && file_exists($dir_in.$_GET["arch"])?$_GET["arch"]:"");
$path        	= (isset($_GET["path"]) && $_GET["path"]!=""?$_GET["path"]:"");

if($archivo!="")
{
	$libro  = PHPExcel_IOFactory::load($dir_in.$archivo);
	$doc	= new DOMDocument("1.0","utf-8");
	$raiz	= $doc->createElement("libro");
	$hojas	= $libro->getAllSheets();
	foreach($hojas as $hoja)
	{
		//$hoja=new PHPExcel_Worksheet();
		$xmlHoja=$doc->createElement("hoja");
		$xmlHoja->setAttribute("nombre",$hoja->getTitle());
		foreach($hoja->getRowIterator() as $fila)
		{
			if($fila->getRowIndex()==1)
				continue;
			$xmlFila=$doc->createElement("fila");
			$xmlFila->setAttribute("numero",$fila->getRowIndex());
			foreach($fila->getCellIterator() as $celda)
			{
				//$celda=new PHPExcel_Cell();
				//$xmlCelda=$doc->createElement("celda",$celda->getCalculatedValue());
				$xmlCelda=$doc->createElement("celda",str_replace("&","&amp;",$celda->getCalculatedValue()));
				$xmlCelda->setAttribute("direccion",$celda->getCoordinate());
				$xmlCelda->setAttribute("fila",$celda->getRow());
				$xmlCelda->setAttribute("columna",$celda->getColumn());
				$xmlFila->appendChild($xmlCelda);
			}
			$xmlHoja->appendChild($xmlFila);
		}
		$raiz->appendChild($xmlHoja);
	}
	$doc->appendChild($raiz);
	$doc->formatOutput=true;
    $doc->save($dir_out.str_replace(".","_",$archivo).".xml");
	header("location: $path/".str_replace(".","_",$archivo).".xml");
}
else
	echo "Error al procesar archivo";
?>