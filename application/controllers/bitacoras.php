<?php
class Bitacoras extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function index($idempresa=0,$idsucursal=0)
	{
		$this->load->model('modruta');
		$this->load->model('modbitacora');
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$empresas=$this->modempresa->getAllTransportista();
		if($idempresa==0 && count($empresas)>0) $idempresa=$empresas[0]["idempresa"];
		$sucursales=($idempresa>0?$this->modsucursal->getAll($idempresa):array());
		if($idsucursal==0 && count($sucursales)>0) $idsucursal=$sucursales[0]["idsucursal"];
		$bitacoras=($idsucursal>0?$this->modbitacora->getAll($idsucursal):array());
		$body=$this->load->view('bitacoras/index',array(
			"menumain"=>$menumain,
			"sucursales"=>$sucursales,
			"empresas"=>$empresas,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"bitacoras"=>$bitacoras,
			"objbitacora"=>$this->modbitacora,
			"objruta"=>$this->modruta,
			"objempresa"=>$this->modempresa,
			"objsucursal"=>$this->modsucursal,
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function ver($id)
	{
		$this->load->model('modruta');
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$this->load->model('modoperador');
		$this->load->model('modvehiculo');
		$this->load->model('modbitacora');
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->load->model('modmanifiesto');
		$this->modbitacora->getFromDatabase($id);
		$this->modruta->getFromDatabase($this->modbitacora->getIdruta());
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('bitacoras/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modbitacora,
			"sucursal"=>$this->modsucursal,
			"empresa"=>$this->modempresa,
			"ruta"=>$this->modruta,
			"operador"=>$this->modoperador,
			"vehiculo"=>$this->modvehiculo
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function eliminar($id)
	{
		$this->load->model('modbitacora');
		$this->modbitacora->getFromDatabase($id);
		$this->modbitacora->delete($id);
	}
	public function imprimir($idbitacora)
	{
		$this->creaPDFBitacora($idbitacora);
		/*$this->load->model('modbitacora');
		$this->modbitacora->getFromDatabase($idbitacora);
		$body="";
		if($this->modbitacora->getManifiestos()!==false)
			foreach($this->modbitacora->getManifiestos() as $k=>$man)
				$body.=$this->preimprimir($man,($k+1)==count($this->modbitacora->getManifiestos())?"true":"false",$k);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));*/
	}
	public function preimprimir($idmanifiesto,$imprimir="false",$idx)
	{
		$this->load->model("modmanifiesto");
		$this->load->model("modgenerador");
		$this->load->model("modcliente");
		$this->load->model("modruta");
		$this->load->model("modempresa");
		$this->load->model("modsucursal");
		$this->load->model("modoperador");
		$this->load->model("modvehiculo");
		$this->load->model("modresiduo");
		$this->load->model("modrecoleccion");
		$this->modmanifiesto->setIdmanifiesto($idmanifiesto);
		$this->modmanifiesto->getFromDatabase();
		$this->modgenerador->setIdgenerador($this->modmanifiesto->getIdgenerador());
		$this->modgenerador->getFromDatabase();
		$this->modcliente->setIdcliente($this->modgenerador->getIdcliente());
		$this->modcliente->getFromDatabase();
		$this->modruta->setIdruta($this->modmanifiesto->getIdruta());
		$this->modruta->getFromDatabase();
		$this->modoperador->setIdoperador($this->modruta->getIdoperador());
		$this->modoperador->getFromDatabase();
		$this->modvehiculo->setIdvehiculo($this->modruta->getIdVehiculo());
		$this->modvehiculo->getFromDatabase();
		$recoleccion=array();
		$residuos=$this->modresiduo->getAll($this->modcliente->getIdsucursal());
		if($residuos!==false) foreach($residuos as $res)
		{
			$recol=$this->modrecoleccion->getRecoleccionWithIdResiduo($idmanifiesto,$res["idresiduo"]);
			if($recol!==false)
			{
				$recoleccion[$res["nom052"]]=$recol;
			}
			else
				$recoleccion[$res["nom052"]]=false;
		}
		$body=$this->load->view('manifiestos/impresion',array(
			"imprimir"=>($imprimir=="true"),
			"manifiesto"=>$this->modmanifiesto,
			"generador"=>$this->modgenerador,
			"cliente"=>$this->modcliente,
			"empresa"=>$this->modempresa,
			"sucursal"=>$this->modsucursal,
			"ruta"=>$this->modruta,
			"operador"=>$this->modoperador,
			"vehiculo"=>$this->modvehiculo,
			"recoleccion"=>$recoleccion,
			"idx"=>$idx
			),true);
		return $body;
	}
	private function creaNodoXML(DOMDocument $xml,$idmanifiesto)
	{
		$this->load->model("modmanifiesto");
		$this->load->model("modgenerador");
		$this->load->model("modcliente");
		$this->load->model("modruta");
		$this->load->model("modempresa");
		$this->load->model("modsucursal");
		$this->load->model("modoperador");
		$this->load->model("modvehiculo");
		$this->load->model("modresiduo");
		$this->load->model("modrecoleccion");
		$this->load->model("modcatalogo");
		$manifiesto	= new Modmanifiesto();
		$generador	= new Modgenerador();
		$cliente	= new Modcliente();
		$empresa	= new Modempresa();
		$sucursal	= new Modsucursal();
		$ruta		= new Modruta();
		$operador	= new Modoperador();
		$vehiculo	= new Modvehiculo();
		$manifiesto->getFromDatabase($idmanifiesto);
		$generador->getFromDatabase($manifiesto->getIdgenerador());
		$cliente->getFromDatabase($generador->getIdcliente());
		$ruta->getFromDatabase($manifiesto->getIdruta());
		$operador->getFromDatabase($ruta->getIdoperador());
		$vehiculo->getFromDatabase($ruta->getIdvehiculo());
		$recoleccion=array();
		$residuos=$this->modresiduo->getAll($this->modcliente->getIdsucursal());
		if($residuos!==false) foreach($residuos as $res)
		{
			$recol=$this->modrecoleccion->getRecoleccionWithIdResiduo($idmanifiesto,$res["idresiduo"]);
			if($recol!==false)
			{
				$recoleccion[$res["nom052"]]=$recol;
			}
			else
				$recoleccion[$res["nom052"]]=false;
		}
		$nodoManifiesto=$xml->createElement("manifiesto");
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_nocte");
		$elem->appendChild($xml->createCDATASection($cliente->getIdentificador()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_nogen");
		$elem->appendChild($xml->createCDATASection($generador->getIdentificador()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_nrg");
		$elem->appendChild($xml->createCDATASection($generador->getNumregamb()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_nomanifiesto");
		$elem->appendChild($xml->createCDATASection($manifiesto->getIdentificador()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_pagina");
		$elem->appendChild($xml->createCDATASection("1 / 1"));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_generedorrazonsocial");
		$elem->appendChild($xml->createCDATASection($generador->getRazonsocial()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_generadordocimicilio");
		$elem->appendChild($xml->createCDATASection($generador->getCalle().",".$generador->getNumexterior().($generador->getNuminterior()!=""?" (Int. ".$generador->getNuminterior().")":"").",".$generador->getColonia()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_generadordelegacion");
		$elem->appendChild($xml->createCDATASection($generador->getMunicipio()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_generadorcp");
		$elem->appendChild($xml->createCDATASection($generador->getCp()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_generadoredo");
		$elem->appendChild($xml->createCDATASection($generador->getEstado()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_generadortel");
		$elem->appendChild($xml->createCDATASection($generador->getRepresentantetelefono().($generador->getRepresentanteextension()!=""?"-".$generador->getRepresentanteextension():"")));
		$nodoManifiesto->appendChild($elem);
		$refs="";
		$hr1="";
		$hr2="";
		if($generador->getReferencias()) $refs=$generador->getReferencias();
		if($generador->getHorarioinicio()!="" || $generador->getHorariofin()!="") $hr1=$generador->getHorarioinicio()."-".$generador->getHorariofin();
		if($generador->getHorarioinicio2()!="" || $generador->getHorariofin2()!="") $hr2=$generador->getHorarioinicio2()."-".$generador->getHorariofin2();
		if($hr1!="00:00-00:00")
		{
			$hr1=substr($hr1,0,2).substr($hr1,5,3);
			$refs.=($refs!=""?", ":"").$hr1;
		}
		if($hr2!="00:00-00:00")
		{
			$hr2=substr($hr2,0,2).substr($hr2,5,3);
			$refs.=($refs!=""?", ":"").$hr2;
		}
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_generadorreferencias");
		$elem->appendChild($xml->createCDATASection($refs));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_instrucciones");
		$elem->appendChild($xml->createCDATASection($manifiesto->getInstruccionesespeciales()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_cccontenedorcap");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI1"]) && $recoleccion["BI1"]!==false?$recoleccion["BI1"]["contenedorcapacidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_cccontenedortipo");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI1"]) && $recoleccion["BI1"]!==false?$recoleccion["BI1"]["contenedortipo"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_cccantidad");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI1"]) && $recoleccion["BI1"]!==false?$recoleccion["BI1"]["cantidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_ccunidad");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI1"]) && $recoleccion["BI1"]!==false?$recoleccion["BI1"]["unidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_punzcontenedorcap");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI2"]) && $recoleccion["BI2"]!==false?$recoleccion["BI2"]["contenedorcapacidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_punzcontenedortipo");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI2"]) && $recoleccion["BI2"]!==false?$recoleccion["BI2"]["contenedortipo"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_punzcantidad");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI2"]) && $recoleccion["BI2"]!==false?$recoleccion["BI2"]["cantidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_punzunidad");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI2"]) && $recoleccion["BI2"]!==false?$recoleccion["BI2"]["unidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_patcontenedorcap");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI3"]) && $recoleccion["BI3"]!==false?$recoleccion["BI3"]["contenedorcapacidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_patcontenedortipo");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI3"]) && $recoleccion["BI3"]!==false?$recoleccion["BI3"]["contenedortipo"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_patcantidad");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI3"]) && $recoleccion["BI3"]!==false?$recoleccion["BI3"]["cantidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_patunidad");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI3"]) && $recoleccion["BI3"]!==false?$recoleccion["BI3"]["unidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_noanatcontenedorcap");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI4"]) && $recoleccion["BI4"]!==false?$recoleccion["BI4"]["contenedorcapacidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_noanatcontenedortipo");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI4"]) && $recoleccion["BI4"]!==false?$recoleccion["BI4"]["contenedortipo"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_noanatcantidad");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI4"]) && $recoleccion["BI4"]!==false?$recoleccion["BI4"]["cantidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_noanatunidad");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI4"]) && $recoleccion["BI4"]!==false?$recoleccion["BI4"]["unidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_sangrecontenedorcap");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI5"]) && $recoleccion["BI5"]!==false?$recoleccion["BI5"]["contenedorcapacidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_sangrecontenedortipo");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI5"]) && $recoleccion["BI5"]!==false?$recoleccion["BI5"]["contenedortipo"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_sangecantidad");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI5"]) && $recoleccion["BI5"]!==false?$recoleccion["BI5"]["cantidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_sangreunidad");
		$elem->appendChild($xml->createCDATASection(isset($recoleccion["BI5"]) && $recoleccion["BI5"]!==false?$recoleccion["BI5"]["unidad"]:""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_otrocontenedorcap");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_otrocontenedortipo");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_otrocantidad");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_otrounidad");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_totalcontenedorcap");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_totalcontenedortipo");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_totalcantidad");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_totalunidad");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_cetificacion");
		$elem->appendChild($xml->createCDATASection($generador->getRepresentante()));
		$nodoManifiesto->appendChild($elem);
		$sucursal->setIdsucursal($ruta->getEmpresatransportista());
		$sucursal->getFromDatabase();
		$empresa->setIdempresa($sucursal->getIdempresa());
		$empresa->getFromDatabase();
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transprazonsoc");
		$elem->appendChild($xml->createCDATASection($empresa->getRazonsocial()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transpdocimicilio");
		$elem->appendChild($xml->createCDATASection($sucursal->getCalle().",".$sucursal->getNumexterior().($sucursal->getNuminterior()!=""?"-".$sucursal->getNuminterior():"").",".$sucursal->getColonia().",".$sucursal->getMunicipio().",".$sucursal->getEstado()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transptel");
		$elem->appendChild($xml->createCDATASection($sucursal->getTelefono()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transpautsemarnat");
		$elem->appendChild($xml->createCDATASection($sucursal->getAutsemarnat()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transpregsct");
		$elem->appendChild($xml->createCDATASection($sucursal->getRegistrosct()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transpoperadornombre");
		$elem->appendChild($xml->createCDATASection($operador->getNombre()." ".$operador->getApaterno()." ".$operador->getAmaterno()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transpoperadorfirma");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transpoperadorcargo");
		$elem->appendChild($xml->createCDATASection($operador->getCargo()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transpfecha");
		$elem->appendChild($xml->createCDATASection(DateToMx($manifiesto->getFechaembarque())));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transpruta");
		$elem->appendChild($xml->createCDATASection($ruta->getIdentificador()." - ".$ruta->getNombre()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transpvahiculotipo");
		$elem->appendChild($xml->createCDATASection($vehiculo->getTipo()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_transpvahiculoplaca");
		$elem->appendChild($xml->createCDATASection($vehiculo->getPlaca()));
		$nodoManifiesto->appendChild($elem);
		$sucursal->setIdsucursal($ruta->getEmpresadestinofinal());
		$sucursal->getFromDatabase();
		$empresa->setIdempresa($sucursal->getIdempresa());
		$empresa->getFromDatabase();
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_dest_razonsoc");
		$elem->appendChild($xml->createCDATASection($empresa->getRazonsocial()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_dest_nautsemarnat");
		$elem->appendChild($xml->createCDATASection($sucursal->getAutsemarnat()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_dest_domicilio");
		$elem->appendChild($xml->createCDATASection($sucursal->getCalle().",".$sucursal->getNumexterior().($sucursal->getNuminterior()!=""?"-".$sucursal->getNuminterior():"").",".$sucursal->getColonia().",".$sucursal->getMunicipio().",".$sucursal->getEstado()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_dest_recibido");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_dest_observaciones");
		$elem->appendChild($xml->createCDATASection($manifiesto->getObservacionesdestinofinal()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_dest_nombre");
		$elem->appendChild($xml->createCDATASection($sucursal->getRepresentante()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_dest_firma");
		$elem->appendChild($xml->createCDATASection(""));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_dest_cargo");
		$elem->appendChild($xml->createCDATASection($sucursal->getCargorepresentante()));
		$nodoManifiesto->appendChild($elem);
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_dest_fecha");
		$elem->appendChild($xml->createCDATASection(DateToMx($manifiesto->getFecharecepcion())));
		$nodoManifiesto->appendChild($elem);
		$f="";
		$frecuencia=$this->modcatalogo->getCatalogo(3);
		if($frecuencia!==false) 
			foreach($frecuencia["opciones"] as $opc) 
				if($opc["idcatalogodet"]==$generador->getFrecuencia()) 
				{ 
					$f=substr($opc["descripcion"],0,2);
					break; 
				}
		$elem=$xml->createElement("data");
		$elem->setAttribute("name","manifiesto_space_generadorfrecuencia");
		$elem->appendChild($xml->createCDATASection($f));
		$nodoManifiesto->appendChild($elem);
		return $nodoManifiesto;
	}
	public function creaPDFBitacora($idbitacora)
	{
		$this->load->model('modbitacora');
		$this->modbitacora->getFromDatabase($idbitacora);
		$doc=new DOMDocument("1.0","utf-8");
		$raiz=$doc->createElement("manifiestos");
		if($this->modbitacora->getManifiestos()!==false)
			foreach($this->modbitacora->getManifiestos() as $k=>$man)
				$raiz->appendChild($this->creaNodoXML($doc,$man));
		$doc->appendChild($raiz);
		$doc->formatOutput=true;
		$archivo="manifiesto_".time().".xml";
		$doc->save($this->config->item("ruta_downloads").$archivo);
		header("location: ".base_url("project_files/app/make_manifiesto_pdf_from_xml.php?arch=$archivo&path=".base_url("bitacoras/descargar")));
	}
	public function imprimirbit($idbitacora)
	{
		$this->load->model('modruta');
		$this->load->model('modoperador');
		$this->load->model('modvehiculo');
		$this->load->model('modbitacora');
		$bitacora=new Modbitacora();
		$ruta=new Modruta();
		$operador=new Modoperador();
		$vehiculo=new Modvehiculo();
		$bitacora->getFromDatabase($idbitacora);
		$ruta->getFromDatabase($bitacora->getIdruta());
		$operador->getFromDatabase($ruta->getIdoperador());
		$vehiculo->getFromDatabase($ruta->getIdvehiculo());
		$doc=new DOMDocument("1.0","utf-8");
		$raiz=$doc->createElement("manifiestos");
		$nodoBitacora=$doc->createElement("bitacora");
		$elem=$doc->createElement("bitacora_ruta_identificador");
		$elem->appendChild($doc->createCDATASection($ruta->getIdentificador()));
		$nodoBitacora->appendChild($elem);
		$elem=$doc->createElement("bitacora_ruta_nombre");
		$elem->appendChild($doc->createCDATASection($ruta->getNombre()));
		$nodoBitacora->appendChild($elem);
		$elem=$doc->createElement("bitacora_operador");
		$elem->appendChild($doc->createCDATASection("{$operador->getNombre()} {$operador->getApaterno()} {$operador->getAmaterno()}"));
		$nodoBitacora->appendChild($elem);
		$elem=$doc->createElement("bitacora_vehiculo_tipo");
		$elem->appendChild($doc->createCDATASection($vehiculo->getTipo()));
		$nodoBitacora->appendChild($elem);
		$elem=$doc->createElement("bitacora_vehiculo_placa");
		$elem->appendChild($doc->createCDATASection($vehiculo->getPlaca()));
		$nodoBitacora->appendChild($elem);
		$elem=$doc->createElement("bitacora_folio");
		$elem->appendChild($doc->createCDATASection($bitacora->getIdentificador()));
		$nodoBitacora->appendChild($elem);
		$elem=$doc->createElement("bitacora_fecha");
		$elem->appendChild($doc->createCDATASection(DateToMx($bitacora->getFecha())));
		$nodoBitacora->appendChild($elem);
		$raiz->appendChild($nodoBitacora);
		if($bitacora->getManifiestos()!==false)
			foreach($bitacora->getManifiestos() as $k=>$man)
				$raiz->appendChild($this->creaNodoXML($doc,$man));
		$doc->appendChild($raiz);
		$doc->formatOutput=true;
		$archivo="bitacora_".time().".xml";
		$doc->save($this->config->item("ruta_downloads").$archivo);
		header("location: ".base_url("project_files/app/make_bitacora_pdf_from_xml.php?arch=$archivo"));
	}
	public function descargar($archivo)
	{
		if($archivo!="")
		{
			$this->load->library('zip');
			$this->zip->read_file($this->config->item("ruta_downloads").$archivo);
			$this->zip->download(str_replace(".pdf",".zip",$archivo));
		}
	}
}
?>