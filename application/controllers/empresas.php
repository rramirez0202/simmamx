<?php
class Empresas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function index()
	{
		$this->load->model('modempresa');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$empresas=$this->modempresa->getAll();
		$empresas=($empresas!==false?$empresas:array());
		$body=$this->load->view('empresas/index',array(
			"menumain"=>$menumain,
			"empresas"=>$empresas
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function nuevo()
	{
		$this->load->model('modempresa');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('empresas/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modempresa
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function add()
	{
		$this->load->model('modempresa');
		$this->modempresa->getFromInput();
		$this->modempresa->addToDatabase();
		echo $this->modempresa->getIdempresa();
		$this->modsesion->addLog(
			"agregar",
			$this->modempresa->getIdempresa(),
			$this->modempresa->getRazonsocial(),
			"empresa",
			""
		);
	}
	public function ver($id)
	{
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->modempresa->getFromDatabase($id);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('empresas/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modempresa,
			"sucursales"=>$this->modsucursal->getAll($id)
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		$this->modsesion->addLog(
			"verdetalle",
			$this->modempresa->getIdempresa(),
			$this->modempresa->getRazonsocial(),
			"",
			""
		);
	}
	public function eliminar($id)
	{
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->modempresa->getFromDatabase($id);
		$this->modempresa->delete($id);
		$this->modsesion->addLog(
			"eliminar",
			$this->modempresa->getIdempresa(),
			$this->modempresa->getRazonsocial(),
			"empresa",
			"relempsuc"
		);
	}
	public function actualizar($id)
	{
		$this->load->model('modempresa');
		$this->modempresa->getFromDatabase($id);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('empresas/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modempresa
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function update()
	{
		$this->load->model('modempresa');
		$this->modempresa->getFromInput();
		$this->modempresa->updateToDatabase();
		echo $this->modempresa->getIdempresa();
		$this->modsesion->addLog(
			"actualizar",
			$this->modempresa->getIdempresa(),
			$this->modempresa->getRazonsocial(),
			"empresa",
			""
		);
	}
}
?>