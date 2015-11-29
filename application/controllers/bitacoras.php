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
		$this->load->model('modbitacora');
		$this->modbitacora->getFromDatabase($idbitacora);
		$body="";
		if($this->modbitacora->getManifiestos()!==false)
			foreach($this->modbitacora->getManifiestos() as $k=>$man)
				$body.=$this->preimprimir($man,($k+1)==count($this->modbitacora->getManifiestos())?"true":"false",$k);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
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
}
?>