<?php
class Vehiculos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function index($idempresa=0,$idsucursal=0)
	{
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$this->load->model('modvehiculo');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$empresas=$this->modempresa->getAllTransportista();
		if($idempresa==0 && count($empresas)>0) $idempresa=$empresas[0]["idempresa"];
		$sucursales=($idempresa>0?$this->modsucursal->getAll($idempresa):array());
		if($idsucursal==0 && count($sucursales)>0) $idsucursal=$sucursales[0]["idsucursal"];
		$vehiculos=($idsucursal>0?$this->modvehiculo->getAll($idsucursal):array());
		$body=$this->load->view('vehiculos/index',array(
			"menumain"=>$menumain,
			"sucursales"=>$sucursales,
			"empresas"=>$empresas,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"vehiculos"=>$vehiculos
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function nuevo($idempresa=0,$idsucursal=0)
	{
		$this->load->model('modvehiculo');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('vehiculos/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modvehiculo,
			"idsucursal"=>$idsucursal
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function add()
	{
		$this->load->model('modvehiculo');
		$this->modvehiculo->getFromInput();
		$this->modvehiculo->addToDatabase();
		echo $this->modvehiculo->getIdvehiculo();
		$this->modsesion->addLog(
			"agregar",
			$this->modvehiculo->getIdvehiculo(),
			$this->modvehiculo->getPlaca(),
			"vehiculo",
			"relsucveh"
		);
	}
	public function update()
	{
		$this->load->model('modvehiculo');
		$this->modvehiculo->getFromInput();
		$this->modvehiculo->updateToDatabase();
		echo $this->modvehiculo->getIdvehiculo();
		$this->modsesion->addLog(
			"actualizar",
			$this->modvehiculo->getIdvehiculo(),
			$this->modvehiculo->getPlaca(),
			"vehiculo",
			""
		);
	}
	public function ver($id)
	{
		$this->load->model('modvehiculo');
		$this->load->model('modsucursal');
		$this->modvehiculo->getFromDatabase($id);
		$this->modsucursal->getFromDatabase($this->modvehiculo->getIdsucursal());
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('vehiculos/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modvehiculo,
			"sucursal"=>$this->modsucursal
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		$this->modsesion->addLog(
			"verdetalle",
			$this->modvehiculo->getIdvehiculo(),
			$this->modvehiculo->getPlaca(),
			"",
			""
		);
	}
	public function actualizar($id)
	{
		$this->load->model('modvehiculo');
		$this->modvehiculo->getFromDatabase($id);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('vehiculos/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modvehiculo,
			"idsucursal"=>$this->modvehiculo->getIdsucursal()
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function eliminar($id)
	{
		$this->load->model('modvehiculo');
		$this->modvehiculo->getFromDatabase($id);
		$this->modvehiculo->delete($id);
		$this->modsesion->addLog(
			"eliminar",
			$this->modvehiculo->getIdvehiculo(),
			$this->modvehiculo->getPlaca(),
			"vehiculo",
			"relsucveh,relrutveh"
		);
	}
}
?>