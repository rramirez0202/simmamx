<?php
class Manifiestos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function index($idempresa=0,$idsucursal=0)
	{
		$this->load->model('modmanifiesto');
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$this->load->model('modgenerador');
		$this->load->model('modcliente');
		$this->load->model('modruta');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$empresas=$this->modempresa->getAllCoorporativo();
		if($idempresa==0 && count($empresas)>0) $idempresa=$empresas[0]["idempresa"];
		$sucursales=($idempresa>0?$this->modsucursal->getAll($idempresa):array());
		if($idsucursal==0 && count($sucursales)>0) $idsucursal=$sucursales[0]["idsucursal"];
		$filtros=array(
			"identificador"=>$this->input->post('frm_prefer_identificador'),
			"numruta"=>$this->input->post('frm_prefer_numruta'),
			"nombreruta"=>$this->input->post('frm_prefer_nombreruta'),
			"fecha_inicio"=>$this->input->post('frm_prefer_fecha_inicio'),
			"fecha_fin"=>$this->input->post('frm_prefer_fecha_fin'),
			"identificadorcliente"=>$this->input->post('frm_prefer_identificadorcliente'),
			"identificadorgenerador"=>$this->input->post('frm_prefer_identificadorgenerador'),
			"nra"=>$this->input->post('frm_prefer_nra'),
			"razonsocial"=>$this->input->post('frm_prefer_razonsocial'),
			"rfc"=>$this->input->post('frm_prefer_rfc'),
			"transportista"=>$this->input->post('frm_prefer_transportista'),
			"destinofinal"=>$this->input->post('frm_prefer_destinofinal'),
			"fechaembarque_inicio"=>$this->input->post('frm_prefer_fechaembarque_inicio'),
			"fechaembarque_fin"=>$this->input->post('frm_prefer_fechaembarque_fin'),
			"fecharecepcion_inicio"=>$this->input->post('frm_prefer_fecharecepcion_inicio'),
			"fecharecepcion_fin"=>$this->input->post('frm_prefer_fecharecepcion_fin')
		);
		$manifiestos=($idsucursal>0?$this->modmanifiesto->getAll($idsucursal,$filtros):array());
		$empTrans=$this->modempresa->getAllTransportista();
		$sucsTrans=array();
		if($empTrans!==false) foreach($empTrans as $emp)
		{
			$this->modempresa->setIdempresa($emp["idempresa"]);
			$sucs=$this->modempresa->getSucursales();
			$arrsucs=array();
			if($sucs!==false) 
			{
				foreach($sucs as $suc) 
				{
					$this->modsucursal->setIdsucursal($suc["idsucursal"]);
					$this->modsucursal->getFromDatabase();
					array_push($arrsucs,array(
						"idsucursal"=>$this->modsucursal->getIdsucursal(),
						"nombre"=>$this->modsucursal->getNombre()
						));
				}
				array_push($sucsTrans,array("idempresa"=>$emp["idempresa"],"nombre"=>$emp["razonsocial"],"sucursales"=>$arrsucs));
			}
		}
		$empDestFinal=$this->modempresa->getAllDestinoFinal();
		$sucsDestFinal=array();
		if($empDestFinal!==false) foreach($empDestFinal as $emp)
		{
			$this->modempresa->setIdempresa($emp["idempresa"]);
			$sucs=$this->modempresa->getSucursales();
			$arrsucs=array();
			if($sucs!==false) 
			{
				foreach($sucs as $suc) 
				{
					$this->modsucursal->setIdsucursal($suc["idsucursal"]);
					$this->modsucursal->getFromDatabase();
					array_push($arrsucs,array(
						"idsucursal"=>$this->modsucursal->getIdsucursal(),
						"nombre"=>$this->modsucursal->getNombre()
						));
				}
				array_push($sucsDestFinal,array("idempresa"=>$emp["idempresa"],"nombre"=>$emp["razonsocial"],"sucursales"=>$arrsucs));
			}
		}
		if($manifiestos!==false) foreach($manifiestos as $k=>$reg)
		{
			$this->modmanifiesto->setIdmanifiesto($reg["idmanifiesto"]);
			$this->modmanifiesto->getFromDatabase();
			$this->modgenerador->setIdgenerador($this->modmanifiesto->getIdgenerador());
			$this->modgenerador->getFromDatabase();
			$this->modcliente->setIdcliente($this->modgenerador->getIdcliente());
			$this->modcliente->getFromDatabase();
			$manifiestos[$k]["nocliente"]=$this->modcliente->getIdentificador();
			$manifiestos[$k]["nogenerador"]=$this->modgenerador->getIdentificador();
			$manifiestos[$k]["generador"]=$this->modgenerador->getRazonsocial();
			$this->modruta->setIdruta($this->modmanifiesto->getIdruta());
			$this->modruta->getFromDatabase();
			$manifiestos[$k]["noruta"]=$this->modruta->getIdentificador();
			$manifiestos[$k]["ruta"]=$this->modruta->getNombre();
			$this->modsucursal->setIdsucursal($this->modruta->getEmpresadestinofinal());
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			$manifiestos[$k]["destinofinal"]="{$this->modempresa->getRazonsocial()} - {$this->modsucursal->getNombre()}";
			$this->modsucursal->setIdsucursal($this->modruta->getEmpresatransportista());
			$this->modsucursal->getFromDatabase();
			$this->modempresa->setIdempresa($this->modsucursal->getIdempresa());
			$this->modempresa->getFromDatabase();
			$manifiestos[$k]["transportista"]="{$this->modempresa->getRazonsocial()} - {$this->modsucursal->getNombre()}";
		}
		$body=$this->load->view('manifiestos/index',array(
			"menumain"=>$menumain,
			"sucursales"=>$sucursales,
			"empresas"=>$empresas,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"manifiestos"=>$manifiestos,
			"filtros"=>$filtros,
			"transportistas"=>$sucsTrans,
			"destinosfinales"=>$sucsDestFinal
		),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function vistacampos()
	{
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('manifiestos/impresion',array(),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));	
	}
	public function vistapreimpresion($idmanifiesto,$imprimir)
	{
		$this->creaXMLManifiesto($idmanifiesto);
		/*$this->load->model("modmanifiesto");
		$this->load->model("modgenerador");
		$this->load->model("modcliente");
		$this->load->model("modruta");
		$this->load->model("modempresa");
		$this->load->model("modsucursal");
		$this->load->model("modoperador");
		$this->load->model("modvehiculo");
		$this->load->model("modresiduo");
		$this->load->model("modrecoleccion");
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
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
			"recoleccion"=>$recoleccion
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));*/	
	}
	public function vistacamposconnombre()
	{
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('manifiestos/impresion_total',array(),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));	
	}
	public function vistacamposconlongitud()
	{
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('manifiestos/impresion_longitud',array(),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));	
	}
	public function menucrear()
	{
		$this->load->view('manifiestos/menucrearmanifiestos');
	}
	public function crearclientegenerador($idempresa,$idsucursal)
	{
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modruta');
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
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('manifiestos/formulariocrearctegen',array(
			"menumain"=>$menumain,
			"rutas"=>$rutaScheme,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal
		),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function crearrutabruto($idempresa,$idsucursal)
	{
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modruta');
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
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('manifiestos/formulariocrearrutabruto',array(
			"menumain"=>$menumain,
			"rutas"=>$rutaScheme,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal
		),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function crearrutacalendario($idempresa,$idsucursal)
	{
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modruta');
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
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('manifiestos/formulariocrearrutacalendario',array(
			"menumain"=>$menumain,
			"rutas"=>$rutaScheme,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal
		),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function crearcalendario($idempresa,$idsucursal)
	{
		$this->load->model('modempresa');
		$this->load->model('modsucursal');
		$this->load->model('modruta');
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
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('manifiestos/formulariocrearcalendario',array(
			"menumain"=>$menumain,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"rutas"=>$rutaScheme,
		),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function validacreacionctegen($idempresa,$idsucursal)
	{
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->load->model('modmanifiesto');
		$this->load->model('modruta');
		$this->load->model('modsucursal');
		$cte=$this->input->post('cliente');
		$gen=$this->input->post('generador');
		$ruta=$this->input->post('ruta');
		$idcte=$this->modcliente->getIdclienteWithIdentificador(0,$cte);
		$this->modruta->setIdruta($ruta);
		$this->modruta->getFromDatabase();
		if($idcte!==false)
		{
			$this->modcliente->setIdcliente($idcte);
			$this->modcliente->getFromDatabase();
			$idgen=$this->modgenerador->getIdgeneradoWithIdentificador($idcte,$gen);
			if($idgen!==false)
			{
				$this->modgenerador->setIdgenerador($idgen);
				$this->modgenerador->getFromDatabase();
				$this->load->view('manifiestos/validacreacionctegen',array(
					"cliente"=>$this->modcliente,
					"generador"=>$this->modgenerador,
					"ruta"=>$this->modruta,
					"identificador"=>$this->modmanifiesto->nextIdentificador($this->modruta->getIdSucursal()),
					"idempresa"=>$idempresa,
					"idsucursal"=>$idsucursal
				));
			}
			else
				echo "No se encontro el generador $cte - $gen";
		}
		else
		 echo "No se encontro el cliente $cte.";
	}
	public function validacreacionrutabruto($idempresa,$idsucursal)
	{
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->load->model('modmanifiesto');
		$this->load->model('modruta');
		$this->load->model('modsucursal');
		$this->load->model('modbitacora');
		$ruta=$this->input->post('ruta');
		$bitacora=$this->input->post('bitacora');
		$this->modruta->getFromDatabase($ruta);
		$this->load->view('manifiestos/validacreacionrutabruto',array(
			"cliente"=>$this->modcliente,
			"generador"=>$this->modgenerador,
			"ruta"=>$this->modruta,
			"identificador"=>$this->modmanifiesto->nextIdentificador($this->modruta->getIdSucursal()),
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"bitacora"=>$bitacora
		));
	}
	public function validacreacionrutacalendario($idempresa,$idsucursal)
	{
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->load->model('modmanifiesto');
		$this->load->model('modruta');
		$this->load->model('modsucursal');
		$this->load->model('modbitacora');
		$ruta=$this->input->post('ruta');
		$bitacora=$this->input->post('bitacora');
		$fecha=$this->input->post('fecha');
		$this->modruta->getFromDatabase($ruta);
		$this->load->view('manifiestos/validacreacionrutacalendario',array(
			"cliente"=>$this->modcliente,
			"generador"=>$this->modgenerador,
			"ruta"=>$this->modruta,
			"identificador"=>$this->modmanifiesto->nextIdentificador($this->modruta->getIdSucursal()),
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"bitacora"=>$bitacora,
			"fecha"=>$fecha
		));
	}
	public function validacreacioncalendario($idempresa,$idsucursal)
	{
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->load->model('modmanifiesto');
		$this->load->model('modsucursal');
		$this->load->model('modruta');
		$ruta=$this->input->post('ruta');
		$bitacora=$this->input->post('bitacora');
		$fecha=$this->input->post('fecha');
		$this->modruta->getFromDatabase($ruta);
		$this->load->view('manifiestos/validacreacioncalendario',array(
			"cliente"=>$this->modcliente,
			"generador"=>$this->modgenerador,
			"ruta"=>$this->modruta,
			"identificador"=>$this->modmanifiesto->nextIdentificador($this->modruta->getIdSucursal()),
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"bitacora"=>$bitacora,
			"fecha"=>$fecha
		));
	}
	public function nuevomanifiesto()
	{
		$this->load->model('modmanifiesto');
		$gen=$this->input->post("generador");
		$ruta=$this->input->post("ruta");
		$identificador=$this->input->post("identificador");
		$this->modmanifiesto->setIdentificador($identificador);
		$this->modmanifiesto->setFecha(DateToMySQL(Hoy()));
		$this->modmanifiesto->setFechaembarque(AddDays(DateToMySQL(Hoy()),1));
		$this->modmanifiesto->setFecharecepcion(AddDays(DateToMySQL(Hoy()),1));
		$this->modmanifiesto->setIdgenerador($gen);
		$this->modmanifiesto->setIdruta($ruta);
		$this->modmanifiesto->addToDatabase();
		echo $this->modmanifiesto->getIdmanifiesto();
		$this->modsesion->addLog(
			"agregar",
			$this->modmanifiesto->getIdmanifiesto(),
			$this->modmanifiesto->getIdentificador(),
			"manifiesto",
			"relgenman,relmanrut"
		);
	}
	public function nuevosmanifiestos()
	{
		$this->load->model('modmanifiesto');
		$this->load->model('modbitacora');
		$this->load->model('modruta');
		$this->load->model('modsucursal');
		$idruta=$this->input->post('frm_validacion_idruta');
		$nombreBitacora=$this->input->post('frm_validacion_bitacora');
		$manifiestos=$this->input->post('frm_validacion_manifiesto');
		$fecha=$this->input->post('frm_validacion_fecha');
		$this->modmanifiesto->setFecha($fecha!==false?$fecha:DateToMySQL(Hoy()));
		$this->modmanifiesto->setFechaembarque($fecha!==false?$fecha:AddDays(DateToMySQL(Hoy()),1));
		$this->modmanifiesto->setFecharecepcion($fecha!==false?$fecha:AddDays(DateToMySQL(Hoy()),1));
		$this->modbitacora->setFecha($fecha!==false?$fecha:DateToMySQL(Hoy()));
		$this->modbitacora->setNombre($nombreBitacora);
		if($idruta!==false)
		{
			$this->modbitacora->setIdruta($idruta);
			$this->modruta->getFromDatabase($idruta);
			$this->modmanifiesto->setIdruta($idruta);
			$this->modbitacora->setIdsucursal($this->modruta->getIdSucursal());
			$this->modbitacora->setIdentificador($this->modbitacora->nextIdentificador($this->modruta->getIdSucursal()));
		}
		else
		{
			$this->modbitacora->setIdsucursal($this->input->post("frm_validacion_idsucursal"));
			$this->modbitacora->setIdentificador($this->modbitacora->nextIdentificador($this->input->post("frm_validacion_idsucursal")));
		}
		if($manifiestos!==false) foreach($manifiestos as $man)
		{
			$data=explode("|",$man);
			$this->modmanifiesto->setIdentificador($data[1]);
			$this->modmanifiesto->setIdgenerador($data[0]);
			$this->modmanifiesto->addToDatabase();
			$idman=$this->modmanifiesto->getIdmanifiesto();
			$this->modbitacora->setManifiestos($idman);
		}
		$this->modbitacora->addToDatabase();
		echo $this->modbitacora->getIdbitacora();
	}
	public function ver($idmanifiesto)
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
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
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
		$residuos=$this->modresiduo->getAll($this->modruta->getIdsucursal());
		if($residuos!==false) foreach($residuos as $res)
		{
			$recol=$this->modrecoleccion->getRecoleccionWithIdResiduo($idmanifiesto,$res["idresiduo"]);
			if($recol!==false)
			{
				$recoleccion[$res["nom052"]]=array("residuo"=>$res,"recoleccion"=>$recol);
			}
			else
				$recoleccion[$res["nom052"]]=array("residuo"=>$res,"recoleccion"=>false);
		}
		$body=$this->load->view('manifiestos/vista',array(
			"menumain"=>$menumain,
			"manifiesto"=>$this->modmanifiesto,
			"generador"=>$this->modgenerador,
			"cliente"=>$this->modcliente,
			"empresa"=>$this->modempresa,
			"sucursal"=>$this->modsucursal,
			"ruta"=>$this->modruta,
			"operador"=>$this->modoperador,
			"vehiculo"=>$this->modvehiculo,
			"recoleccion"=>$recoleccion,
			"motivos"=>array(
				"cobranza"=>$this->modcatalogo->getCatalogo(9),
				"ajenos"=>$this->modcatalogo->getCatalogo(12),
				"transporte"=>$this->modcatalogo->getCatalogo(10),
				"ventas"=>$this->modcatalogo->getCatalogo(8),
				"cliente"=>$this->modcatalogo->getCatalogo(11)
				),
			"motivo"=>$this->modmanifiesto->getMotivo()
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		$this->modsesion->addLog(
			"verdetalle",
			$this->modmanifiesto->getIdmanifiesto(),
			$this->modmanifiesto->getIdentificador(),
			"",
			""
		);
	}
	public function formulariocapturakilos($idmanifiesto)
	{
		$this->load->model("modmanifiesto");
		$this->load->model("modgenerador");
		$this->load->model("modcliente");
		$this->load->model("modresiduo");
		$this->load->model("modrecoleccion");
		$this->load->model("modcatalogo");
		$this->load->model("modruta");
		$this->modmanifiesto->setIdmanifiesto($idmanifiesto);
		$this->modmanifiesto->getFromDatabase();
		$this->modgenerador->setIdgenerador($this->modmanifiesto->getIdgenerador());
		$this->modgenerador->getFromDatabase();
		$this->modcliente->setIdcliente($this->modgenerador->getIdcliente());
		$this->modcliente->getFromDatabase();
		$this->modruta->setIdruta($this->modmanifiesto->getIdruta());
		$this->modruta->getFromDatabase();
		$recoleccion=array();
		$residuos=$this->modresiduo->getAll($this->modruta->getIdsucursal());
		if($residuos!==false) foreach($residuos as $res)
		{
			$recol=$this->modrecoleccion->getRecoleccionWithIdResiduo($idmanifiesto,$res["idresiduo"]);
			if($recol!==false)
			{
				$recoleccion[$res["idresiduo"]]=array("residuo"=>$res,"recoleccion"=>$recol);
			}
			else
				$recoleccion[$res["idresiduo"]]=array("residuo"=>$res,"recoleccion"=>false);
		}
		$this->load->view('manifiestos/formulariocapturakilos',array(
			"recoleccion"=>$recoleccion,
			"motivos"=>array(
				"cobranza"=>$this->modcatalogo->getCatalogo(9),
				"ajenos"=>$this->modcatalogo->getCatalogo(12),
				"transporte"=>$this->modcatalogo->getCatalogo(10),
				"ventas"=>$this->modcatalogo->getCatalogo(8),
				"cliente"=>$this->modcatalogo->getCatalogo(11)
				),
			"motivo"=>$this->modmanifiesto->getMotivo(),
			"noexterno"=>$this->modmanifiesto->getNoexterno()
			));
	}
	public function eliminar($id)
	{
		$this->load->model('modmanifiesto');
		$this->modmanifiesto->getFromDatabase($id);
		$this->modmanifiesto->delete($id);
		$this->modsesion->addLog(
			"eliminar",
			$this->modmanifiesto->getIdmanifiesto(),
			$this->modmanifiesto->getIdentificador(),
			"manifiesto",
			"'relresrec,relmanrec,recoleccion,relbitman,relmanrut,relmanrec,relgenman,manifiesto"
		);
	}
	public function capturakilos($idmanifiesto)
	{
		$this->load->model("modmanifiesto");
		$this->load->model("modgenerador");
		$this->load->model("modcliente");
		$this->load->model("modresiduo");
		$this->load->model("modrecoleccion");
		$this->load->model("modruta");
		$this->modmanifiesto->setIdmanifiesto($idmanifiesto);
		$this->modmanifiesto->getFromDatabase();
		$this->modgenerador->setIdgenerador($this->modmanifiesto->getIdgenerador());
		$this->modgenerador->getFromDatabase();
		$this->modcliente->setIdcliente($this->modgenerador->getIdcliente());
		$this->modcliente->getFromDatabase();
		$this->modruta->setIdruta($this->modmanifiesto->getIdRuta());
		$this->modruta->getFromDatabase();
		$this->modmanifiesto->setMotivo($this->input->post('frm_motivo'));
		$this->modmanifiesto->setNoexterno($this->input->post('frm_noexterno'));
		$residuos=$this->modresiduo->getAll($this->modruta->getIdsucursal());
		$recoleccionesActual=$this->modmanifiesto->getRecoleccionesDatabase();
		if($recoleccionesActual!==false) foreach($recoleccionesActual as $rec)
		{
			$this->modrecoleccion->setIdrecoleccion($rec["idrecoleccion"]);
			$this->modrecoleccion->delete();
			$this->modsesion->addLog(
				"eliminar",
				$rec["idrecoleccion"],
				$rec["idrecoleccion"],
				"recoleccion",
				"relresrec,relmanrec"
			);
		}
		$this->modmanifiesto->updateToDatabase();
		if($residuos!==false) foreach($residuos as $res)
		{
			$capacidad=$this->input->post('capacidad_'.$res["idresiduo"]);
			$tipo=$this->input->post('tipo_'.$res["idresiduo"]);
			$cantidad=$this->input->post('cantidad_'.$res["idresiduo"]);
			//$unidad=$this->input->post('unidad_'.$res["nom052"]);
			$unidad="kg";
			if($cantidad!="")
			{
				$this->modrecoleccion->setContenedorcapacidad($capacidad);
				$this->modrecoleccion->setContenedortipo($tipo);
				$this->modrecoleccion->setCantidad($cantidad);
				$this->modrecoleccion->setUnidad($unidad);
				$this->modrecoleccion->setIdresiduo($res["idresiduo"]);
				$this->modrecoleccion->setIdmanifiesto($idmanifiesto);
				$this->modrecoleccion->addToDatabase();
				$this->modsesion->addLog(
					"agregar",
					$this->modrecoleccion->getIdRecoleccion(),
					"Recoleccion: ".$this->modrecoleccion->getIdRecoleccion(),
					"recoleccion",
					"relresrec,relmanrec"
				);
			}
		}
	}
	public function capturar()
	{
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('manifiestos/precaptura',array(
			"menumain"=>$menumain
		),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function getForPrecaptura($identificador=0)
	{
		$this->load->model("modmanifiesto");
		$this->load->model("modgenerador");
		$this->load->model("modcliente");
		$this->load->model("modresiduo");
		$this->load->model("modrecoleccion");
		$this->load->model("modcatalogo");
		$this->load->model("modruta");
		$data=array();
		$manif=$this->modmanifiesto->getFromIdentificador($identificador);
		$idmanifiesto=0;
		if($manif!==false && $manif[0]["idmanifiesto"]!="")
			$idmanifiesto=$manif[0]["idmanifiesto"];
		$this->modmanifiesto->setIdmanifiesto($idmanifiesto);
		$this->modmanifiesto->getFromDatabase();
		$this->modgenerador->setIdgenerador($this->modmanifiesto->getIdgenerador());
		$this->modgenerador->getFromDatabase();
		$this->modcliente->setIdcliente($this->modgenerador->getIdcliente());
		$this->modcliente->getFromDatabase();
		$this->modruta->setIdruta($this->modmanifiesto->getIdruta());
		$this->modruta->getFromDatabase();
		if($idmanifiesto==0||trim($idmanifiesto)=="")
			array_push($data,"No se ha ingresado un manifiesto válido");
		else if($this->modmanifiesto->getIdgenerador()==""||$this->modmanifiesto->getIdgenerador()==0||$this->modgenerador->getIdcliente()==""||$this->modgenerador->getIdcliente()==0)
			array_push($data,"No se ha encontrado el manifiesto solicitado");
		else if($manif!==false && count($manif)>1)
			array_push($data,"Existen dos o mas manifiestos con el mismo identificador, por favor contacte al administrador del sistema");
		else
		{
			$recoleccion=array();
			$residuos=$this->modresiduo->getAll($this->modruta->getIdsucursal());
			if($residuos!==false) foreach($residuos as $res)
			{
				$recol=$this->modrecoleccion->getRecoleccionWithIdResiduo($idmanifiesto,$res["idresiduo"]);
				if($recol!==false)
				{
					$recoleccion[$res["idresiduo"]]=array("residuo"=>$res,"recoleccion"=>$recol);
				}
				else
					$recoleccion[$res["idresiduo"]]=array("residuo"=>$res,"recoleccion"=>false);
			}
			$frm=$this->load->view('manifiestos/formulariocapturakilos',array(
				"recoleccion"=>$recoleccion,
				"motivos"=>array(
					"cobranza"=>$this->modcatalogo->getCatalogo(9),
					"ajenos"=>$this->modcatalogo->getCatalogo(12),
					"transporte"=>$this->modcatalogo->getCatalogo(10),
					"ventas"=>$this->modcatalogo->getCatalogo(8),
					"cliente"=>$this->modcatalogo->getCatalogo(11)
					),
				"motivo"=>$this->modmanifiesto->getMotivo(),
				"noexterno"=>$this->modmanifiesto->getNoexterno()
				),true);
			array_push($data,$this->modgenerador->getIdGenerador());
			array_push($data,$this->modgenerador->getRazonSocial());
			array_push($data,$this->modcliente->getIdCliente());
			array_push($data,$this->modcliente->getRazonSocial());
			array_push($data,$frm);
			array_push($data,$this->modgenerador->getIdentificador());
			array_push($data,$this->modcliente->getIdentificador());
			array_push($data,$idmanifiesto);
		}
		echo json_encode($data);
	}
	public function menucrearreporte()
	{
		$this->load->view('manifiestos/menureportes');
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
		$residuos=$this->modresiduo->getAll($ruta->getIdsucursal());
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
	private function creaXMLManifiesto($idmanifiesto)
	{
		$doc=new DOMDocument("1.0","utf-8");
		$raiz=$doc->createElement("manifiestos");
		$raiz->appendChild($this->creaNodoXML($doc,$idmanifiesto));
		$doc->appendChild($raiz);
		$doc->formatOutput=true;
		$archivo="manifiesto_".time().".xml";
		$doc->save($this->config->item("ruta_downloads").$archivo);
		header("location: ".base_url("project_files/app/make_manifiesto_pdf_from_xml.php?arch=$archivo&path=".base_url("manifiestos/descargar")));
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
	public function importar($tipo,$idempresa,$idsucursal)
	{
		$tipo=strtolower(trim($tipo));
		if($tipo!="excel"&&$tipo!="formiik")
		{
			header("location: ".base_url('manifiestos'));
			exit();
		}
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('manifiestos/importar'.$tipo,array(
			"menumain"=>$menumain,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"tipo"=>$tipo
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function importar_exec($tipo,$idempresa,$idsucursal)
	{
		$tipo=strtolower(trim($tipo));
		if($tipo!="excel"&&$tipo!="formiik")
		{
			header("location: ".base_url('manifiestos'));
			exit();
		}
		$config["upload_path"]="./project_files/files/upload";
		$config["allowed_types"]="xls|xlsx";
		$config["max_size"]="0";
		$config["max_height"]="0";
		$config["max_width"]="0";
		$this->load->library("upload",$config);
		if($this->upload->do_upload("frm_importar_archivo"))
		{
			$archivo=$this->upload->data()["file_name"];
			header("location: ".base_url("project_files/app/make_xml_from_excel.php?arch=$archivo&path=".base_url("manifiestos/importar_exec2/$tipo/$idempresa/$idsucursal")));
		}
		else
		{
			echo $this->upload->display_errors();
		}
	}
	public function importar_exec2($tipo,$idempresa,$idsucursal,$archivo)
	{
		$this->load->model("modmanifiesto");
		$this->load->model("modcliente");
		$this->load->model("modgenerador");
		$this->load->model("modempresa");
		$this->load->model("modsucursal");
		$this->load->model("modruta");
		$this->load->model("modresiduo");
		$this->load->model("modrecoleccion");
		$this->load->model("modcatalogo");
		$tipo=strtolower(trim($tipo));
		if($tipo!="excel"&&$tipo!="formiik")
		{
			header("location: ".base_url('manifiestos'));
			exit();
		}
		$archivo="./project_files/files/upload/$archivo";
		if(file_exists($archivo))
		{
			$doc=new DOMDocument("1.0","utf-8");
			$doc->load($archivo);
			$manifs=array();
			foreach($doc->getElementsByTagName('hoja') as $hoja)
			{
				//$hoja=new DOMElement("");
				if(strtolower(trim($hoja->getAttribute("nombre")))!="recoleccion")
					continue;
				foreach($hoja->getElementsByTagName('fila') as $fila)
				{
					//$fila=new DOMElement("");
					if(intval(trim($fila->getAttribute('numero')))==1||intval(trim($fila->getAttribute('numero')))==2)
						continue;
					array_push($manifs,$this->crearArrayDesdeFilaXML($fila,$tipo));
				}
			}
			foreach($manifs as $k=>$man)
			{
				$status="";
				$errors=array();
				$warnings=array();
				$idruta="";
				$idcte="";
				$idgen="";
				$dataman=$this->modmanifiesto->getFromIdentificador($man["manif"]);
				$tmpruta=$this->modruta->getFromNombreIdentificador($man["ruta"]);
				$tmpcte=$this->modcliente->getIdclienteWithIdentificador(0,$man["cte"]);
				$tmpgen=false;
				$manifs[$k]["idcte_actual"]="";
				$manifs[$k]["nomcte_actual"]="";
				$manifs[$k]["identifcte_actual"]="";
				$manifs[$k]["idgen_actual"]="";
				$manifs[$k]["nomgen_actual"]="";
				$manifs[$k]["identifgen_actual"]="";
				$manifs[$k]["idruta_actual"]="";
				$manifs[$k]["nomruta_actual"]="";
				$manifs[$k]["identifruta_actual"]="";
				if($tmpruta==false)
				{
					array_push($errors,array(1,"No existe la ruta {$man["ruta"]}. "));
				}
				else
				{
					$idruta=$tmpruta[0]["idruta"];
					$this->modruta->setIdruta($idruta);
					$this->modruta->getFromdatabase();
					$manifs[$k]["idruta_actual"]=$this->modruta->getIdruta();
					$manifs[$k]["nomruta_actual"]=$this->modruta->getNombre();
					$manifs[$k]["identifruta_actual"]=$this->modruta->getIdentificador();
				}
				if($tmpcte===false)
				{
					array_push($errors,array(2,"No existe el cliente {$man["cte"]}. "));
				}
				else
				{
					$idcte=$tmpcte;
					$tmpgen=$this->modgenerador->getIdgeneradoWithIdentificador($idcte,$man["gen"]);
					$this->modcliente->setIdcliente($idcte);
					$this->modcliente->getFromDatabase();
					$manifs[$k]["idcte_actual"]=$this->modcliente->getIdcliente();
					$manifs[$k]["nomcte_actual"]=$this->modcliente->getRazonsocial();
					$manifs[$k]["identifcte_actual"]=$this->modcliente->getIdentificador();
					if($tmpgen===false)
					{
						array_push($errors,array(3,"No existe el generador {$man["gen"]}. "));
					}
					else
					{
						if(count($this->modsesion->getAllGens())==0 || in_array($tmpgen,$this->modsesion->getAllGens()))
						{
							$idgen=$tmpgen;
							$this->modgenerador->setIdgenerador($idgen);
							$this->modgenerador->getFromdatabase();
							$manifs[$k]["idgen_actual"]=$this->modgenerador->getIdgenerador();
							$manifs[$k]["nomgen_actual"]=$this->modgenerador->getRazonsocial();
							$manifs[$k]["identifgen_actual"]=$this->modgenerador->getIdentificador();
						}
						else
						{
							array_push($errors,array(4,"El generador {$man["cte"]} - {$man["gen"]} no pertenece al grupo de usuarios asignado. "));
						}
					}
				}
				if($dataman===false)
				{
					$status="noextiste";
					array_push($warnings,array(1,"El manifiesto no existe"));
				}
				else
				{
					$this->modmanifiesto->setIdmanifiesto($dataman[0]["idmanifiesto"]);
					$this->modmanifiesto->getFromDatabase();
					$this->modgenerador->setIdgenerador($this->modmanifiesto->getIdgenerador());
					$this->modgenerador->getFromDatabase();
					$this->modcliente->setIdCliente($this->modgenerador->getIdcliente());
					$this->modcliente->getFromDatabase();
					$this->modruta->setIdruta($this->modmanifiesto->getIdruta());
					$this->modruta->getFromDatabase();
					$recs=$this->modrecoleccion->getAll($dataman[0]["idmanifiesto"]);
					$suma=0.0;
					if($recs!==false) foreach($recs as $rec) $suma+=floatval($rec["cantidad"]);
					if($suma==0.0 && $this->modmanifiesto->getmotivo()=="")
					{
						$status="porcapturar";
					}
					else
					{
						$status="capturado";
						array_push($warnings,array(2,"El manifiesto {$man["manif"]} ya esta capturado."));
					}
					if($idgen!=$this->modgenerador->getIdgenerador())
					{
						array_push($warnings,array(3,"El manifesto fue creado para un generador diferente al cual se esta capturando. Generado para {$this->modcliente->getIentificador()} - {$this->modgenerador->getIdentificador()}, capturando para {$man["cte"]} - {$man["gen"]}. "));
					}
					if($idruta!=$this->modruta->getIdruta())
					{
						array_push($warnings,array(4,"El manifiesto fue creado para una ruta diferente a la cual se esta capturando. Generado para la ruta {$this->modruta->getNombre()} ({$this->modruta->getIdentificador()}), capturando para {$man["ruta"]}. "));
					}
					$manifs[$k]["idruta_actual"]=$this->modruta->getIdruta();
					$manifs[$k]["nomruta_actual"]=$this->modruta->getNombre();
					$manifs[$k]["identifruta_actual"]=$this->modruta->getIdentificador();
					$manifs[$k]["idcte_actual"]=$this->modcliente->getIdcliente();
					$manifs[$k]["nomcte_actual"]=$this->modcliente->getRazonsocial();
					$manifs[$k]["identifcte_actual"]=$this->modcliente->getIdentificador();
					$manifs[$k]["idgen_actual"]=$this->modgenerador->getIdgenerador();
					$manifs[$k]["nomgen_actual"]=$this->modgenerador->getRazonsocial();
					$manifs[$k]["identifgen_actual"]=$this->modgenerador->getIdentificador();
				}
				$manifs[$k]["status"]=$status;
				$manifs[$k]["errors"]=$errors;
				$manifs[$k]["warnings"]=$warnings;
			}
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
			$head=$this->load->view('html/head',array(),true);
			$menumain=$this->load->view('menu/menumain',array(),true);
			$body=$this->load->view('manifiestos/importar',array(
				"menumain"=>$menumain,
				"idempresa"=>$idempresa,
				"idsucursal"=>$idsucursal,
				"rutas"=>$rutaScheme,
				"manifiestos"=>$manifs,
				"motivos"=>array(
					"cobranza"=>$this->modcatalogo->getCatalogo(9),
					"ajenos"=>$this->modcatalogo->getCatalogo(12),
					"transporte"=>$this->modcatalogo->getCatalogo(10),
					"ventas"=>$this->modcatalogo->getCatalogo(8),
					"cliente"=>$this->modcatalogo->getCatalogo(11)
					)
			),true);
			$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		}
		else
			echo "No existe el archivo $archivo";
	}
	private function crearArrayDesdeFilaXML(DOMElement $fila,$tipo)
	{
		$data=array(
			"cte"			=>"",
			"gen"			=>"",
			"ruta"			=>"",
			"manif"			=>"",
			"fecha"			=>"",
			"causa"			=>"",
			"motivo"		=>"",
			"res_sangre"	=>"",
			"res_cultivos"	=>"",
			"res_pato"		=>"",
			"res_noanat"	=>"",
			"res_punzo"		=>"",
			"res_medcad"	=>""
		);
		foreach($fila->getElementsByTagName("celda") as $celda)
		{
			//$celda=new DOMElement("");
			if($tipo=="excel")
			{
				switch($celda->getAttribute('columna'))
				{
					case 'A':
						$data["cte"]=$celda->nodeValue;
						break;
					case 'B':
						$data["gen"]=$celda->nodeValue;
						break;
					case 'C':
						$data["ruta"]=$celda->nodeValue;
						break;
					case 'D':
						$data["manif"]=$celda->nodeValue;
						break;
					case 'E':
						$data["fecha"]=substr($celda->nodeValue,1,10);
						break;
					case 'F':
						$data["causa"]=$celda->nodeValue;
						break;
					case 'G':
						$data["motivo"]=$celda->nodeValue;
						break;
					case 'H':
						$data["res_sangre"]=$celda->nodeValue;
						break;
					case 'I':
						$data["res_cultivos"]=$celda->nodeValue;
						break;
					case 'J':
						$data["res_pato"]=$celda->nodeValue;
						break;
					case 'K':
						$data["res_noanat"]=$celda->nodeValue;
						break;
					case 'L':
						$data["res_punzo"]=$celda->nodeValue;
						break;
					case 'M':
						$data["res_medcad"]=$celda->nodeValue;
						break;
				}
			}
			else if($tipo=="formiik")
			{
				switch($celda->getAttribute('columna'))
				{
					case 'I':
						$data["cte"]=$celda->nodeValue;
						break;
					case 'J':
						$data["gen"]=$celda->nodeValue;
						break;
					case 'K':
						$data["ruta"]=$celda->nodeValue;
						break;
					case 'L':
						$data["manif"]=$celda->nodeValue;
						break;
					case 'M':
						$data["fecha"]=substr($celda->nodeValue,0,10);
						break;
					case 'X':
						$data["causa"]=$celda->nodeValue;
						break;
					case 'Y':
						$data["motivo"]=$celda->nodeValue;
						break;
					case 'AA':
						$data["res_sangre"]=$celda->nodeValue;
						break;
					case 'AB':
						$data["res_cultivos"]=$celda->nodeValue;
						break;
					case 'AC':
						$data["res_pato"]=$celda->nodeValue;
						break;
					case 'AD':
						$data["res_noanat"]=$celda->nodeValue;
						break;
					case 'AE':
						$data["res_punzo"]=$celda->nodeValue;
						break;
					case 'AF':
						$data["res_medcad"]=$celda->nodeValue;
						break;
				}
			}
		}
		return $data;
	}
	public function capturarImportacion()
	{
		$this->load->model('modmanifiesto');
		$this->load->model('modruta');
		$this->load->model('modrecoleccion');
		$fecha=$this->input->post('fecha');
		$generador=$this->input->post('generador');
		$manifiesto=$this->input->post('manifiesto');
		$motivo=$this->input->post('motivo');
		$r_cc=$this->input->post('r_cc');
		$r_medcad=$this->input->post('r_medcad');
		$r_noanat=$this->input->post('r_noanat');
		$r_pat=$this->input->post('r_pat');
		$r_punzo=$this->input->post('r_punzo');
		$r_san=$this->input->post('r_san');
		$ruta=$this->input->post('ruta');
		$status=$this->input->post('status');
		$this->modruta->setIdruta($ruta);
		$this->modruta->getFromDatabase();
		switch($status)
		{
			case 'noextiste':
				$this->modmanifiesto->setIdentificador($manifiesto);
				$this->modmanifiesto->setFecha($fecha);
				$this->modmanifiesto->setFechaembarque($fecha);
				$this->modmanifiesto->setFecharecepcion($fecha);
				$this->modmanifiesto->setIdgenerador($generador);
				$this->modmanifiesto->setIdruta($ruta);
				$this->modmanifiesto->setMotivo($motivo);
				$this->modmanifiesto->addToDatabase();
				break;
			case 'porcapturar':
			case 'capturado':
				$manif=$this->modmanifiesto->getFromIdentificador($manifiesto);
				$this->modmanifiesto->setIdmanifiesto($manif[0]["idmanifiesto"]);
				$this->modmanifiesto->getFromDatabase();
				$this->modmanifiesto->setFecha($fecha);
				$this->modmanifiesto->setFechaembarque($fecha);
				$this->modmanifiesto->setFecharecepcion($fecha);
				$this->modmanifiesto->setIdgenerador($generador);
				$this->modmanifiesto->setIdruta($ruta);
				$this->modmanifiesto->setMotivo($motivo);
				$this->modmanifiesto->updateToDatabase();
				break;
		}
		$recoleccionesActual=$this->modmanifiesto->getRecoleccionesDatabase();
		if($recoleccionesActual!==false) foreach($recoleccionesActual as $rec)
		{
			$this->modrecoleccion->setIdrecoleccion($rec["idrecoleccion"]);
			$this->modrecoleccion->delete();
		}
		$settings=json_decode(file_get_contents($this->config->item('ruta_templates').'importa_manifiesto.json'),true);
		foreach($settings["sucursales"] as $suc)
		{
			if($suc["id"]==$this->modruta->getIdSucursal())
			{
				$cfgResiduos=$suc["residuos"];
				$this->modrecoleccion->setUnidad("kg");
				$this->modrecoleccion->setIdmanifiesto($this->modmanifiesto->getIdmanifiesto());
				foreach($cfgResiduos as $cfgres)
				{
					$this->modrecoleccion->setIdresiduo($cfgres["id"]);
					switch($cfgres["nombre"])
					{
						case 'Cultivos y Cepas':
							$this->modrecoleccion->setCantidad($r_cc);
							break;
						case 'No Anatómicos':
							$this->modrecoleccion->setCantidad($r_noanat);
							break;
						case 'Objetos Punzocortantes':
							$this->modrecoleccion->setCantidad($r_punzo);
							break;
						case 'Patológicos':
							$this->modrecoleccion->setCantidad($r_pat);
							break;
						case 'Sangre':
							$this->modrecoleccion->setCantidad($r_san);
							break;
						case 'Medicamento Caduco':
							$this->modrecoleccion->setCantidad($r_medcad);
							break;
					}
					$this->modrecoleccion->addToDatabase();
				}
			}
		}
	}
}
?>