<?php
class Residuos extends CI_Controller
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
		$this->load->model('modresiduo');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$empresas=$this->modempresa->getAllCoorporativo();
		if($idempresa==0 && count($empresas)>0) $idempresa=$empresas[0]["idempresa"];
		$sucursales=($idempresa>0?$this->modsucursal->getAll($idempresa):array());
		if($idsucursal==0 && count($sucursales)>0) $idsucursal=$sucursales[0]["idsucursal"];
		$residuos=($idsucursal>0?$this->modresiduo->getAll($idsucursal):array());
		$body=$this->load->view('residuos/index',array(
			"menumain"=>$menumain,
			"sucursales"=>$sucursales,
			"empresas"=>$empresas,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"residuos"=>$residuos
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function nuevo($idempresa=0,$idsucursal=0)
	{
		$this->load->model('modresiduo');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('residuos/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modresiduo,
			"idsucursal"=>$idsucursal
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function add()
	{
		$this->load->model('modresiduo');
		$this->modresiduo->getFromInput();
		$this->modresiduo->addToDatabase();
		echo $this->modresiduo->getIdresiduo();
		$this->modsesion->addLog(
			"agregar",
			$this->modresiduo->getIdresiduo(),
			$this->modresiduo->getNombre(),
			"residuo",
			"relsucres"
		);
	}
	public function update()
	{
		$this->load->model('modresiduo');
		$this->modresiduo->getFromInput();
		$this->modresiduo->updateToDatabase();
		echo $this->modresiduo->getIdresiduo();
		$this->modsesion->addLog(
			"actualizar",
			$this->modresiduo->getIdresiduo(),
			$this->modresiduo->getNombre(),
			"residuo",
			""
		);
	}
	public function ver($id)
	{
		$this->load->model('modresiduo');
		$this->load->model('modsucursal');
		$this->modresiduo->getFromDatabase($id);
		$this->modsucursal->getFromDatabase($this->modresiduo->getIdsucursal());
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('residuos/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modresiduo,
			"sucursal"=>$this->modsucursal
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		$this->modsesion->addLog(
			"verdetalle",
			$this->modresiduo->getIdresiduo(),
			$this->modresiduo->getNombre(),
			"",
			""
		);
	}
	public function actualizar($id)
	{
		$this->load->model('modresiduo');
		$this->modresiduo->getFromDatabase($id);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('residuos/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modresiduo,
			"idsucursal"=>$this->modresiduo->getIdsucursal()
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function eliminar($id)
	{
		$this->load->model('modresiduo');
		$this->modresiduo->getFromDatabase($id);
		$this->modresiduo->delete($id);
		$this->modsesion->addLog(
			"eliminar",
			$this->modresiduo->getIdresiduo(),
			$this->modresiduo->getNombre(),
			"residuo",
			"relsucres"
		);
	}
}
?>
