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
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));	
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
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('manifiestos/formulariocrearcalendario',array(
			"menumain"=>$menumain,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal
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
		$idcte=$this->modcliente->getIdclienteWithIdentificador($idsucursal,$cte);
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
					"identificador"=>$this->modmanifiesto->nextIdentificador($idsucursal),
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
		$ruta=$this->input->post('ruta');
		$bitacora=$this->input->post('bitacora');
		$this->modruta->getFromDatabase($ruta);
		$this->load->view('manifiestos/validacreacionrutabruto',array(
			"cliente"=>$this->modcliente,
			"generador"=>$this->modgenerador,
			"ruta"=>$this->modruta,
			"identificador"=>$this->modmanifiesto->nextIdentificador($idsucursal),
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
		$ruta=$this->input->post('ruta');
		$bitacora=$this->input->post('bitacora');
		$fecha=$this->input->post('fecha');
		$this->modruta->getFromDatabase($ruta);
		$this->load->view('manifiestos/validacreacionrutacalendario',array(
			"cliente"=>$this->modcliente,
			"generador"=>$this->modgenerador,
			"ruta"=>$this->modruta,
			"identificador"=>$this->modmanifiesto->nextIdentificador($idsucursal),
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
		$ruta=$this->input->post('ruta');
		$bitacora=$this->input->post('bitacora');
		$fecha=$this->input->post('fecha');
		$this->load->view('manifiestos/validacreacioncalendario',array(
			"cliente"=>$this->modcliente,
			"generador"=>$this->modgenerador,
			"identificador"=>$this->modmanifiesto->nextIdentificador($idsucursal),
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
		}
		else
			$this->modbitacora->setIdsucursal($this->input->post("frm_validacion_idsucursal"));
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
		$residuos=$this->modresiduo->getAll($this->modcliente->getIdsucursal());
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
		$this->modmanifiesto->setIdmanifiesto($idmanifiesto);
		$this->modmanifiesto->getFromDatabase();
		$this->modgenerador->setIdgenerador($this->modmanifiesto->getIdgenerador());
		$this->modgenerador->getFromDatabase();
		$this->modcliente->setIdcliente($this->modgenerador->getIdcliente());
		$this->modcliente->getFromDatabase();
		$recoleccion=array();
		$residuos=$this->modresiduo->getAll($this->modcliente->getIdsucursal());
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
			"motivo"=>$this->modmanifiesto->getMotivo()
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
		$this->modmanifiesto->setIdmanifiesto($idmanifiesto);
		$this->modmanifiesto->getFromDatabase();
		$this->modgenerador->setIdgenerador($this->modmanifiesto->getIdgenerador());
		$this->modgenerador->getFromDatabase();
		$this->modcliente->setIdcliente($this->modgenerador->getIdcliente());
		$this->modcliente->getFromDatabase();
		$this->modmanifiesto->setMotivo($this->input->post('frm_motivo'));
		$residuos=$this->modresiduo->getAll($this->modcliente->getIdsucursal());
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
		if($idmanifiesto==0||trim($idmanifiesto)=="")
			array_push($data,"No se ha ingresado un manifiesto válido");
		else if($this->modmanifiesto->getIdgenerador()==""||$this->modmanifiesto->getIdgenerador()==0||$this->modgenerador->getIdcliente()==""||$this->modgenerador->getIdcliente()==0)
			array_push($data,"No se ha encontrado el manifiesto solicitado");
		else if($manif!==false && count($manif)>1)
			array_push($data,"Existen dos o mas manifiestos con el mismo identificador, por favor contacte al administrador del sistema");
		else
		{
			$recoleccion=array();
			$residuos=$this->modresiduo->getAll($this->modcliente->getIdsucursal());
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
				"motivo"=>$this->modmanifiesto->getMotivo()
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
}
?>
