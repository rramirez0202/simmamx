<?php
class Grupos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function index()
	{
		$this->load->model('modgrupo');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('grupos/index',array(
			"menumain"=>$menumain,
			"grupos"=>$this->modgrupo->getAll()
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function nuevo()
	{
		$this->load->model('modgrupo');
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$sucs=array();
		$ctes=array();
		$gens=array();
		if(count($this->modgrupo->getSucursales())>0) foreach($this->modgrupo->getSucursales() as $s)
		{
			$this->modsucursal->setIdsucursal($s);
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			if(!isset($sucs[$this->modempresa->getIdempresa()]))
				$sucs[$this->modempresa->getIdempresa()]=array("empresa"=>$this->modempresa->getRazonsocial(),"sucs"=>array());
			if(!isset($sucs[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]))
				$sucs[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]=array("sucursal"=>$this->modsucursal->getNombre());
		}
		if(count($this->modgrupo->getClientes())>0) foreach($this->modgrupo->getClientes() as $c)
		{
			$this->modcliente->setIdcliente($c);
			$this->modcliente->getFromDatabase();
			$this->modsucursal->setIdsucursal($this->modcliente->getIdsucursal());
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			if(!isset($ctes[$this->modempresa->getIdempresa()]))
				$ctes[$this->modempresa->getIdempresa()]=array("empresa"=>$this->modempresa->getRazonsocial(),"sucs"=>array());
			if(!isset($ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]))
				$ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]=array("sucursal"=>$this->modsucursal->getNombre(),"ctes"=>array());
			if(!isset($ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]))
				$ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]=$this->modcliente->getIdentificador()." - ".$this->modcliente->getRazonSocial();
		}
		if(count($this->modgrupo->getGeneradores())>0) foreach($this->modgrupo->getGeneradores() as $g)
		{
			$this->modgenerador->setIdgenerador($g);
			$this->modgenerador->getFromdatabase();
			$this->modcliente->setIdcliente($this->modgenerador->getIdCliente());
			$this->modcliente->getFromDatabase();
			$this->modsucursal->setIdsucursal($this->modcliente->getIdsucursal());
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			if(!isset($gens[$this->modempresa->getIdempresa()]))
				$gens[$this->modempresa->getIdempresa()]=array("empresa"=>$this->modempresa->getRazonsocial(),"sucs"=>array());
			if(!isset($gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]))
				$gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]=array("sucursal"=>$this->modsucursal->getNombre(),"ctes"=>array());
			if(!isset($gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]))
				$gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]=array("cliente"=>$this->modcliente->getIdentificador()." - ".$this->modcliente->getRazonSocial(),"gens"=>array());
			if(!isset($gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]["gens"][$this->modgenerador->getIdgenerador()]))
				$gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]["gens"][$this->modgenerador->getIdgenerador()]=$this->modcliente->getIdentificador()." - ".$this->modgenerador->getIdentificador()." - ".$this->modgenerador->getRazonSocial();
		}
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('grupos/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modgrupo,
			"sucs"=>$sucs,
			"ctes"=>$ctes,
			"gens"=>$gens
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function add()
	{
		$this->load->model('modgrupo');
		$this->modgrupo->getFromInput();
		$this->modgrupo->addToDatabase();
		echo $this->modgrupo->getIdgrupo();
		$this->modsesion->addLog(
			"agregar",
			$this->modgrupo->getIdgrupo(),
			$this->modgrupo->getNombre(),
			"perfil",
			"relpersuc,relpermperf"
		);
	}
	public function update()
	{
		$this->load->model('modgrupo');
		$this->modgrupo->getFromInput();
		$this->modgrupo->updateToDatabase();
		echo $this->modgrupo->getIdgrupo();
		$this->modsesion->addLog(
			"actualizar",
			$this->modgrupo->getIdgrupo(),
			$this->modgrupo->getNombre(),
			"perfil",
			"relpersuc,relpermperf"
		);
	}
	public function ver($id)
	{
		$this->load->model('modgrupo');
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->modgrupo->getFromDatabase($id);
		$sucs=array();
		$ctes=array();
		$gens=array();
		if(count($this->modgrupo->getSucursales())>0) foreach($this->modgrupo->getSucursales() as $s)
		{
			$this->modsucursal->setIdsucursal($s);
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			if(!isset($sucs[$this->modempresa->getIdempresa()]))
				$sucs[$this->modempresa->getIdempresa()]=array("empresa"=>$this->modempresa->getRazonsocial(),"sucs"=>array());
			if(!isset($sucs[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]))
				$sucs[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]=array("sucursal"=>$this->modsucursal->getNombre());
		}
		if(count($this->modgrupo->getClientes())>0) foreach($this->modgrupo->getClientes() as $c)
		{
			$this->modcliente->setIdcliente($c);
			$this->modcliente->getFromDatabase();
			$this->modsucursal->setIdsucursal($this->modcliente->getIdsucursal());
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			if(!isset($ctes[$this->modempresa->getIdempresa()]))
				$ctes[$this->modempresa->getIdempresa()]=array("empresa"=>$this->modempresa->getRazonsocial(),"sucs"=>array());
			if(!isset($ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]))
				$ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]=array("sucursal"=>$this->modsucursal->getNombre(),"ctes"=>array());
			if(!isset($ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]))
				$ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]=$this->modcliente->getIdentificador()." - ".$this->modcliente->getRazonSocial();
		}
		if(count($this->modgrupo->getGeneradores())>0) foreach($this->modgrupo->getGeneradores() as $g)
		{
			$this->modgenerador->setIdgenerador($g);
			$this->modgenerador->getFromdatabase();
			$this->modcliente->setIdcliente($this->modgenerador->getIdCliente());
			$this->modcliente->getFromDatabase();
			$this->modsucursal->setIdsucursal($this->modcliente->getIdsucursal());
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			if(!isset($gens[$this->modempresa->getIdempresa()]))
				$gens[$this->modempresa->getIdempresa()]=array("empresa"=>$this->modempresa->getRazonsocial(),"sucs"=>array());
			if(!isset($gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]))
				$gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]=array("sucursal"=>$this->modsucursal->getNombre(),"ctes"=>array());
			if(!isset($gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]))
				$gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]=array("cliente"=>$this->modcliente->getIdentificador()." - ".$this->modcliente->getRazonSocial(),"gens"=>array());
			if(!isset($gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]["gens"][$this->modgenerador->getIdgenerador()]))
				$gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]["gens"][$this->modgenerador->getIdgenerador()]=$this->modcliente->getIdentificador()." - ".$this->modgenerador->getIdentificador()." - ".$this->modgenerador->getRazonSocial();
		}
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('grupos/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modgrupo,
			"sucs"=>$sucs,
			"ctes"=>$ctes,
			"gens"=>$gens
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function eliminar($id)
	{
		$this->load->model('modgrupo');
		$this->modgrupo->getFromDatabase($id);
		$this->modgrupo->delete($id);
		$this->modsesion->addLog(
			"eliminar",
			$this->modgrupo->getIdgrupo(),
			$this->modgrupo->getNombre(),
			"perfil",
			"relpermperf,relpersuc,relperusu"
		);
	}
	public function actualizar($id)
	{
		$this->load->model('modgrupo');
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->modgrupo->getFromDatabase($id);
		$sucs=array();
		$ctes=array();
		$gens=array();
		if(count($this->modgrupo->getSucursales())>0) foreach($this->modgrupo->getSucursales() as $s)
		{
			$this->modsucursal->setIdsucursal($s);
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			if(!isset($sucs[$this->modempresa->getIdempresa()]))
				$sucs[$this->modempresa->getIdempresa()]=array("empresa"=>$this->modempresa->getRazonsocial(),"sucs"=>array());
			if(!isset($sucs[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]))
				$sucs[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]=array("sucursal"=>$this->modsucursal->getNombre());
		}
		if(count($this->modgrupo->getClientes())>0) foreach($this->modgrupo->getClientes() as $c)
		{
			$this->modcliente->setIdcliente($c);
			$this->modcliente->getFromDatabase();
			$this->modsucursal->setIdsucursal($this->modcliente->getIdsucursal());
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			if(!isset($ctes[$this->modempresa->getIdempresa()]))
				$ctes[$this->modempresa->getIdempresa()]=array("empresa"=>$this->modempresa->getRazonsocial(),"sucs"=>array());
			if(!isset($ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]))
				$ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]=array("sucursal"=>$this->modsucursal->getNombre(),"ctes"=>array());
			if(!isset($ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]))
				$ctes[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]=$this->modcliente->getIdentificador()." - ".$this->modcliente->getRazonSocial();
		}
		if(count($this->modgrupo->getGeneradores())>0) foreach($this->modgrupo->getGeneradores() as $g)
		{
			$this->modgenerador->setIdgenerador($g);
			$this->modgenerador->getFromdatabase();
			$this->modcliente->setIdcliente($this->modgenerador->getIdCliente());
			$this->modcliente->getFromDatabase();
			$this->modsucursal->setIdsucursal($this->modcliente->getIdsucursal());
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			if(!isset($gens[$this->modempresa->getIdempresa()]))
				$gens[$this->modempresa->getIdempresa()]=array("empresa"=>$this->modempresa->getRazonsocial(),"sucs"=>array());
			if(!isset($gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]))
				$gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]=array("sucursal"=>$this->modsucursal->getNombre(),"ctes"=>array());
			if(!isset($gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]))
				$gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]=array("cliente"=>$this->modcliente->getIdentificador()." - ".$this->modcliente->getRazonSocial(),"gens"=>array());
			if(!isset($gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]["gens"][$this->modgenerador->getIdgenerador()]))
				$gens[$this->modempresa->getIdempresa()]["sucs"][$this->modsucursal->getIdSucursal()]["ctes"][$this->modcliente->getIdcliente()]["gens"][$this->modgenerador->getIdgenerador()]=$this->modcliente->getIdentificador()." - ".$this->modgenerador->getIdentificador()." - ".$this->modgenerador->getRazonSocial();
		}
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('grupos/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modgrupo,
			"sucs"=>$sucs,
			"ctes"=>$ctes,
			"gens"=>$gens
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function frmasignasucursales($idgpo)
	{
		$this->load->model('modgrupo');
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->modgrupo->getFromDatabase($idgpo);
		$empresas=array();
		$emps=$this->modempresa->getAll();
		if($emps!==false) foreach($emps as $emp)
		{
			$sucs=$this->modsucursal->getAll($emp["idempresa"]);
			if($sucs!==false and count($sucs)>0)
			{
				array_push($empresas,array("data"=>$emp,"sucs"=>$sucs));
			}
		}
		$this->load->view("grupos/frmassginasucursales",array(
			"empresas"=>$empresas,
			"sucursalesasignadas"=>$this->modgrupo->getSucursales()
			));
	}
	public function frmasignaclientes($idgpo)
	{
		$this->load->model('modgrupo');
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modcliente');
		$this->modgrupo->getFromDatabase($idgpo);
		$empresas=array();
		$emps=$this->modempresa->getAll();
		if($emps!==false) foreach($emps as $emp)
		{
			$sucs=$this->modsucursal->getAll($emp["idempresa"]);
			if($sucs!==false and count($sucs)>0)
			{
				$sucursales=array();
				foreach($sucs as $suc)
				{
					$ctes=$this->modcliente->getAll($suc["idsucursal"],array());
					if($ctes!==false && count($ctes)>0)
						array_push($sucursales,array("data"=>$suc,"ctes"=>$ctes));
				}
				if(count($sucursales)>0)
					array_push($empresas,array("data"=>$emp,"sucs"=>$sucursales));
			}
		}
		$this->load->view("grupos/frmassginaclientes",array(
			"empresas"=>$empresas,
			"clientesasignados"=>$this->modgrupo->getClientes()
			));
	}
	public function frmasignageneradores($idgpo)
	{
		$this->load->model('modgrupo');
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->modgrupo->getFromDatabase($idgpo);
		$empresas=array();
		$emps=$this->modempresa->getAll();
		if($emps!==false) foreach($emps as $emp)
		{
			$sucs=$this->modsucursal->getAll($emp["idempresa"]);
			if($sucs!==false and count($sucs)>0)
			{
				$sucursales=array();
				foreach($sucs as $suc)
				{
					$ctes=$this->modcliente->getAll($suc["idsucursal"],array());
					if($ctes!==false && count($ctes)>0)
					{
						$clientes=array();
						foreach($ctes as $cte)
						{
							$gens=$this->modgenerador->getAll($cte["idcliente"]);
							if($gens!==false && count($gens)>0)
								array_push($clientes,array("data"=>$cte,"gens"=>$gens));
						}
						if(count($clientes)>0)
							array_push($sucursales,array("data"=>$suc,"ctes"=>$clientes));
					}
				}
				if(count($sucursales)>0)
					array_push($empresas,array("data"=>$emp,"sucs"=>$sucursales));
			}
		}
		$this->load->view("grupos/frmassginageneradores",array(
			"empresas"=>$empresas,
			"generadoresasignados"=>$this->modgrupo->getGeneradores()
			));
	}
}
?>
