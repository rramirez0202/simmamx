<?php
class Generadores extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function nuevo($idcliente)
	{
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->load->model('modcatalogo');
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modruta');
		$this->modcliente->getFromDatabase($idcliente);
		$this->modgenerador->setIdentificador($this->modgenerador->nextIdentificador($idcliente));
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$rutaScheme=array();
		$emps=$this->modempresa->getAll();
		if($emps!==false) foreach($emps as $emp)
		{
			$empresa=array("id"=>$emp["idempresa"],"razonsocial"=>$emp["razonsocial"],"sucursales"=>array());
			$this->modempresa->setIdempresa($emp["idempresa"]);
			$sucs=$this->modempresa->getSucursales();
			if($sucs!==false) foreach($sucs as $suc)
			{
				$this->modsucursal->setIdsucursal($suc["idsucursal"]);
				$this->modsucursal->getFromDatabase();
				$sucursal=array("id"=>$suc["idsucursal"],"nombre"=>$this->modsucursal->getNombre(),"rutas"=>array());
				$ruts=$this->modsucursal->getRutas();
				if($ruts!==false) foreach($ruts as $rut)
				{
					$this->modruta->setIdruta($rut["idruta"]);
					$this->modruta->getFromDatabase();
					array_push($sucursal["rutas"],array(
						"id"=>$rut["idruta"],
						"nombre"=>$this->modruta->getNombre(),
						"identificador"=>$this->modruta->getIdentificador()
						));
				}
				if(count($sucursal["rutas"])>0) array_push($empresa["sucursales"],$sucursal);
			}
			if(count($empresa["sucursales"])>0) array_push($rutaScheme,$empresa);
		}
		$body=$this->load->view('generadores/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modgenerador,
			"cliente"=>$this->modcliente,
			"frecuencia"=>$this->modcatalogo->getCatalogo(3),
			"tiposervicio"=>$this->modcatalogo->getCatalogo(5),
			"tipocobro"=>$this->modcatalogo->getCatalogo(6),
			"rutasEsquema"=>$rutaScheme,
			"facturaciones"=>""
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function add()
	{
		$this->load->model('modgenerador');
		$this->modgenerador->getFromInput();
		$this->modgenerador->addToDatabase();
		echo $this->modgenerador->getIdgenerador();
		$this->modsesion->addLog(
			"agregar",
			$this->modgenerador->getIdgenerador(),
			$this->modgenerador->getRazonsocial(),
			"generador",
			"relcligen,relrutgen"
		);
	}
	public function update()
	{
		$this->load->model('modgenerador');
		$this->modgenerador->getFromInput();
		$statusActual=$this->input->post("frm_generador_activo_current");
		if($this->modgenerador->getActivo()!=$statusActual)
			$this->modgenerador->setFechaactivo(Today());
		$this->modgenerador->updateToDatabase();
		echo $this->modgenerador->getIdgenerador();
		$this->modsesion->addLog(
			"actualizar",
			$this->modgenerador->getIdgenerador(),
			$this->modgenerador->getRazonsocial(),
			"generador",
			"relrutgen"
		);
	}
	public function ver($id)
	{
		$this->load->model('modgenerador');
		$this->load->model('modcatalogo');
		$this->load->model('modruta');
		$this->load->model('modfacturacion');
		$this->modgenerador->getFromDatabase($id);
		$facturaciones="";
		if($this->modgenerador->getFacturaciones()!==false) foreach($this->modgenerador->getFacturaciones() as $idfacturacion)
		{
			$this->modfacturacion->setIdfacturacion($idfacturacion);
			$this->modfacturacion->getFromDatabase();
			$facturaciones.=$this->load->view("facturacion/vista",array(
				"objeto"=>$this->modfacturacion,
				"tiposervicio"=>$this->modcatalogo->getCatalogo(5),
				"tipocobro"=>$this->modcatalogo->getCatalogo(6),
				"modoedicion"=>false
			),true);
		}
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$rutas=array();
		foreach($this->modgenerador->getRutas() as $r)
		{
			$this->modruta->setIdruta($r);
			$this->modruta->getFromDatabase();
			array_push($rutas,"{$this->modruta->getIdentificador()} - {$this->modruta->getNombre()}");
		}
		$body=$this->load->view('generadores/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modgenerador,
			"frecuencia"=>$this->modcatalogo->getCatalogo(3),
			"tiposervicio"=>$this->modcatalogo->getCatalogo(5),
			"tipocobro"=>$this->modcatalogo->getCatalogo(6),
			"rutas"=>$rutas,
			"facturaciones"=>$facturaciones
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		$this->modsesion->addLog(
			"verdetalle",
			$this->modgenerador->getIdgenerador(),
			$this->modgenerador->getRazonsocial(),
			"",
			""
		);
	}
	public function actualizar($id)
	{
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->load->model('modcatalogo');
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modruta');
		$this->load->model('modfacturacion');
		$this->modgenerador->getFromDatabase($id);
		$this->modcliente->getFromDatabase($this->modgenerador->getIdcliente());
		$facturaciones="";
		if($this->modgenerador->getFacturaciones()!==false) foreach($this->modgenerador->getFacturaciones() as $idfacturacion)
		{
			$this->modfacturacion->setIdfacturacion($idfacturacion);
			$this->modfacturacion->getFromDatabase();
			$facturaciones.=$this->load->view("facturacion/vista",array(
				"objeto"=>$this->modfacturacion,
				"tiposervicio"=>$this->modcatalogo->getCatalogo(5),
				"tipocobro"=>$this->modcatalogo->getCatalogo(6),
				"modoedicion"=>true
			),true);
		}
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$rutaScheme=array();
		$emps=$this->modempresa->getAll();
		if($emps!==false) foreach($emps as $emp)
		{
			$empresa=array("id"=>$emp["idempresa"],"razonsocial"=>$emp["razonsocial"],"sucursales"=>array());
			$this->modempresa->setIdempresa($emp["idempresa"]);
			$sucs=$this->modempresa->getSucursales();
			if($sucs!==false) foreach($sucs as $suc)
			{
				$this->modsucursal->setIdsucursal($suc["idsucursal"]);
				$this->modsucursal->getFromDatabase();
				$sucursal=array("id"=>$suc["idsucursal"],"nombre"=>$this->modsucursal->getNombre(),"rutas"=>array());
				$ruts=$this->modsucursal->getRutas();
				if($ruts!==false) foreach($ruts as $rut)
				{
					$this->modruta->setIdruta($rut["idruta"]);
					$this->modruta->getFromDatabase();
					array_push($sucursal["rutas"],array(
						"id"=>$rut["idruta"],
						"nombre"=>$this->modruta->getNombre(),
						"identificador"=>$this->modruta->getIdentificador()
						));
				}
				if(count($sucursal["rutas"])>0) array_push($empresa["sucursales"],$sucursal);
			}
			if(count($empresa["sucursales"])>0) array_push($rutaScheme,$empresa);
		}
		$body=$this->load->view('generadores/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modgenerador,
			"cliente"=>$this->modcliente,
			"frecuencia"=>$this->modcatalogo->getCatalogo(3),
			"tiposervicio"=>$this->modcatalogo->getCatalogo(5),
			"tipocobro"=>$this->modcatalogo->getCatalogo(6),
			"rutasEsquema"=>$rutaScheme,
			"facturaciones"=>$facturaciones
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function eliminar($id)
	{
		$this->load->model('modgenerador');
		$this->modgenerador->getFromDatabase($id);
		$this->modgenerador->delete($id);
		$this->modsesion->addLog(
			"agregar",
			$this->modgenerador->getIdgenerador(),
			$this->modgenerador->getRazonsocial(),
			"generador",
			"relrutgen,relcligen"
		);
	}
	public function agregarfacturacion($idgenerador)
	{
		$this->load->model("modcatalogo");
		$this->load->model("modfacturacion");
		$this->modfacturacion->getFromInput();
		$this->modfacturacion->setIdgenerador($idgenerador);
		$this->modfacturacion->addToDatabase();
		$this->load->model('modfacturacion');
		$this->load->view("facturacion/vista",array(
			"objeto"=>$this->modfacturacion,
			"tiposervicio"=>$this->modcatalogo->getCatalogo(5),
			"tipocobro"=>$this->modcatalogo->getCatalogo(6),
			"modoedicion"=>true
		));
	}
	public function eliminaFacturacion($idfacturacion)
	{
		$this->load->model('modfacturacion');
		$this->modfacturacion->delete($idfacturacion);
	}
	public function calendarizar($id)
	{
		$this->load->model('modgenerador');
		$this->load->model('modcatalogo');
		$this->load->model('modcliente');
		$this->modgenerador->getFromDatabase($id);
		$this->modcliente->setIdCliente($this->modgenerador->getIdcliente());
		$this->modcliente->getFromDatabase();
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('generadores/calendarizar',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modgenerador,
			"frecuencia"=>$this->modcatalogo->getCatalogo(3),
			"cliente"=>$this->modcliente
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function cargacalendario($id)
	{
		$this->load->model("modgenerador");
		$this->modgenerador->setIdgenerador($id);
		$fechas=$this->input->post("fechas");
		if($fechas!==false && is_array($fechas) && count($fechas)>0)
		{
			$this->modgenerador->eliminaFechasCalendario();
			foreach($fechas as $fecha)
				if($fecha!="")
					$this->modgenerador->agregaFechaCalendario(0,$fecha);
		}
	}
}
?>