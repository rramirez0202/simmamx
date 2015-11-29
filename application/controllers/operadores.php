<?php
class Operadores extends CI_Controller
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
		$this->load->model('modoperador');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		//$empresas=$this->modempresa->getAllCoorporativo();
		$empresas=$this->modempresa->getAllTransportista();
		if($idempresa==0 && count($empresas)>0) $idempresa=$empresas[0]["idempresa"];
		$sucursales=($idempresa>0?$this->modsucursal->getAll($idempresa):array());
		if($idsucursal==0 && count($sucursales)>0) $idsucursal=$sucursales[0]["idsucursal"];
		$operadores=($idsucursal>0?$this->modoperador->getAll($idsucursal):array());
		$body=$this->load->view('operadores/index',array(
			"menumain"=>$menumain,
			"sucursales"=>$sucursales,
			"empresas"=>$empresas,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"operadores"=>$operadores
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function nuevo($idempresa=0,$idsucursal=0)
	{
		$this->load->model('modoperador');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('operadores/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modoperador,
			"idsucursal"=>$idsucursal
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function add()
	{
		$this->load->model('modoperador');
		$this->modoperador->getFromInput();
		$this->modoperador->addToDatabase();
		echo $this->modoperador->getIdoperador();
		$this->modsesion->addLog(
			"agregar",
			$this->modoperador->getIdoperador(),
			$this->modoperador->getNombre()." ".$this->modoperador->getApaterno()." ".$this->modoperador->getAmaterno()." ",
			"operador",
			"relsucope"
		);
	}
	public function update()
	{
		$this->load->model('modoperador');
		$this->modoperador->getFromInput();
		$this->modoperador->updateToDatabase();
		echo $this->modoperador->getIdoperador();
		$this->modsesion->addLog(
			"actualizar",
			$this->modoperador->getIdoperador(),
			$this->modoperador->getNombre()." ".$this->modoperador->getApaterno()." ".$this->modoperador->getAmaterno()." ",
			"operador",
			""
		);
	}
	public function ver($id)
	{
		$this->load->model('modoperador');
		$this->load->model('modsucursal');
		$this->modoperador->getFromDatabase($id);
		$this->modsucursal->getFromDatabase($this->modoperador->getIdSucursal());
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('operadores/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modoperador,
			"sucursal"=>$this->modsucursal
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		$this->modsesion->addLog(
			"verdetalle",
			$this->modoperador->getIdoperador(),
			$this->modoperador->getNombre()." ".$this->modoperador->getApaterno()." ".$this->modoperador->getAmaterno()." ",
			"",
			""
		);
	}
	public function actualizar($id)
	{
		$this->load->model('modoperador');
		$this->modoperador->getFromDatabase($id);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('operadores/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modoperador,
			"idsucursal"=>$this->modoperador->getIdsucursal()
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function eliminar($id)
	{
		//Elimina la realcion con la sucursal pero la deja viva
		//Elimina la realcion con la ruta pero la deja viva
		$this->load->model('modoperador');
		$this->modoperador->getFromDatabase($id);
		$this->modoperador->delete($id);
		$this->modsesion->addLog(
			"eliminar",
			$this->modoperador->getIdoperador(),
			$this->modoperador->getNombre()." ".$this->modoperador->getApaterno()." ".$this->modoperador->getAmaterno()." ",
			"operador",
			"relrutope,relsucope"
		);
	}
}
?>