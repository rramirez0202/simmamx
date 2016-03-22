<?php
class Clientes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function index($idempresa=0,$idsucursal=0)
	{
		$this->load->model('modcliente');
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$this->load->model('modcatalogo');
		$this->load->model('modgenerador');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$empresas=$this->modempresa->getAllCoorporativo();
		//if($idempresa==0 && count($empresas)>0) $idempresa=$empresas[0]["idempresa"];
		$sucursales=($idempresa>0?$this->modsucursal->getAll($idempresa):array());
		//if($idsucursal==0 && count($sucursales)>0) $idsucursal=$sucursales[0]["idsucursal"];
		$filtros=array(
			"identificador"=>$this->input->post('frm_prefer_identificador'),
			"rfc"=>$this->input->post('frm_prefer_rfc'),
			"razonsocial"=>$this->input->post('frm_prefer_razonsocial'),
			"vendedor"=>$this->input->post('frm_prefer_vendedor'),
			"giro"=>$this->input->post('frm_prefer_giro'),
			"observaciones"=>$this->input->post('frm_prefer_observaciones'),
			"colonia"=>$this->input->post('frm_prefer_colonia'),
			"municipio"=>$this->input->post('frm_prefer_municipio')
		);
		$clientes=$this->modcliente->getAll($idsucursal,$filtros);
		$clientes=$clientes!==false?$clientes:array();
		$generadores=$this->modgenerador->getAllFiltered($filtros);
		$generadores=$generadores!==false?$generadores:array();
		$body=$this->load->view('clientes/index',array(
			"menumain"=>$menumain,
			"sucursales"=>$sucursales,
			"empresas"=>$empresas,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"clientes"=>$clientes,
			"generadores"=>$generadores,
			"filtros"=>$filtros,
			"vendedor"=>$this->modcatalogo->getCatalogo(4)
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function nuevo($idempresa=0,$idsucursal=0)
	{
		$this->load->model('modcliente');
		$this->load->model('modcatalogo');
		$this->modcliente->setIdentificador($this->modcliente->nextIdentificador($idsucursal));
		$this->modcliente->setFechaalta(Today());
		$this->modcliente->setFechacontratoinicio(Today());
		$this->modcliente->setFechacontratofin(AddDays(Today(),366));
		$this->modcliente->setFechaserviciosinicio(Today());
		$this->modcliente->setFechaserviciosfin(AddDays(Today(),365*10+3));
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('clientes/formulario',array(
			"menumain"=>$menumain,
			"idsucursal"=>$idsucursal,
			"objeto"=>$this->modcliente,
			"vendedor"=>$this->modcatalogo->getCatalogo(4),
			"tiposervicio"=>$this->modcatalogo->getCatalogo(5),
			"tipocobro"=>$this->modcatalogo->getCatalogo(6),
			"diascredito"=>$this->modcatalogo->getCatalogo(7),
			"estatuscliente"=>$this->modcatalogo->getCatalogo(13),
			"facturaciones"=>""
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function add()
	{
		$this->load->model('modcliente');
		$this->modcliente->getFromInput();
		$this->modcliente->addToDatabase();
		echo $this->modcliente->getIdcliente();
		$this->modsesion->addLog(
			'agregar',
			$this->modcliente->getIdcliente(),
			$this->modcliente->getRazonsocial(),
			"cliente",
			"relsuccli"
		);
	}
	public function update()
	{
		$this->load->model('modcliente');
		$this->modcliente->getFromInput();
		$statusActual=$this->input->post("frm_cliente_status_current");
		if($this->modcliente->getStatus()!=$statusActual)
			$this->modcliente->setFechastatus(Today());
		$this->modcliente->updateToDatabase();
		echo $this->modcliente->getIdcliente();
		$this->modsesion->addLog(
			'actualizar',
			$this->modcliente->getIdcliente(),
			$this->modcliente->getRazonsocial(),
			"cliente",
			""
		);
	}
	public function ver($id)
	{
		$this->load->model('modcliente');
		$this->load->model('modsucursal');
		$this->load->model('modgenerador');
		$this->load->model('modcatalogo');
		$this->load->model('modfacturacion');
		$this->modcliente->getFromDatabase($id);
		$this->modsucursal->getFromDatabase($this->modcliente->getIdsucursal());
		$facturaciones="";
		if($this->modcliente->getFacturaciones()!==false) foreach($this->modcliente->getFacturaciones() as $idfacturacion)
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
		$body=$this->load->view('clientes/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modcliente,
			"sucursal"=>$this->modsucursal,
			"generadores"=>$this->modgenerador->getAll($id),
			"vendedor"=>$this->modcatalogo->getCatalogo(4),
			"tiposervicio"=>$this->modcatalogo->getCatalogo(5),
			"tipocobro"=>$this->modcatalogo->getCatalogo(6),
			"diascredito"=>$this->modcatalogo->getCatalogo(7),
			"estatuscliente"=>$this->modcatalogo->getCatalogo(13),
			"facturaciones"=>$facturaciones
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		$this->modsesion->addLog(
			'verdetalle',
			$this->modcliente->getIdcliente(),
			$this->modcliente->getRazonsocial(),
			"",
			""
		);
	}
	public function actualizar($id)
	{
		$this->load->model('modcliente');
		$this->load->model('modcatalogo');
		$this->load->model('modfacturacion');
		$this->modcliente->getFromDatabase($id);
		$facturaciones="";
		if($this->modcliente->getFacturaciones()!==false) foreach($this->modcliente->getFacturaciones() as $idfacturacion)
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
		$body=$this->load->view('clientes/formulario',array(
			"menumain"=>$menumain,
			"idsucursal"=>$this->modcliente->getIdsucursal(),
			"objeto"=>$this->modcliente,
			"vendedor"=>$this->modcatalogo->getCatalogo(4),
			"tiposervicio"=>$this->modcatalogo->getCatalogo(5),
			"tipocobro"=>$this->modcatalogo->getCatalogo(6),
			"diascredito"=>$this->modcatalogo->getCatalogo(7),
			"estatuscliente"=>$this->modcatalogo->getCatalogo(13),
			"facturaciones"=>$facturaciones
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function eliminar($id)
	{
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->load->model('modfacturacion');
		$this->modcliente->getFromDatabase($id);
		$this->modcliente->delete($id);
		$this->modsesion->addLog(
			'eliminar',
			$this->modcliente->getIdcliente(),
			$this->modcliente->getRazonsocial(),
			"cliente",
			"relsuccli,relcligen"
		);
	}
	public function agregarfacturacion($idcliente)
	{
		$this->load->model("modcatalogo");
		$this->load->model("modfacturacion");
		$this->modfacturacion->getFromInput();
		$this->modfacturacion->setIdcliente($idcliente);
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
	public function importar($idempresa,$idsucursal)
	{
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('clientes/importar',array(
			"menumain"=>$menumain,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function importar_exec($idempresa,$idsucursal)
	{
		$config["upload_path"]="./project_files/files/upload";
		$config["allowed_types"]="xls|xlsx";
		$config["max_size"]="0";
		$config["max_height"]="0";
		$config["max_width"]="0";
		$this->load->library("upload",$config);
		if($this->upload->do_upload("frm_cliente_archivo"))
		{
			$archivo=$this->upload->data()["file_name"];
			header("location: ".base_url("project_files/app/make_xml_from_excel.php?arch=$archivo&path=".base_url("clientes/importar_exec2/$idempresa/$idsucursal")));
		}
		else
		{
			echo $this->upload->display_errors();
		}
	}
	public function importar_exec2($idempresa,$idsucursal,$archivo)
	{
		$this->load->model("modcliente");
		$this->load->model("modgenerador");
		$this->load->model("modempresa");
		$this->load->model("modsucursal");
		$this->load->model("modcatalogo");
		$this->load->model("modfacturacion");
		$archivo="./project_files/files/upload/$archivo";
		if(file_exists($archivo))
		{
			$resultados=array("otros"=>array());
			$doc=new DOMDocument("1.0","utf-8");
			$doc->load($archivo);
			$clientes=array();
			foreach($doc->getElementsByTagName("hoja") as $hoja)
			{
				//$hoja=new DOMElement("");
				switch(strtoupper($hoja->getAttribute("nombre")))
				{
					case "CLIENTES":
						foreach($hoja->getElementsByTagName("fila") as $fila)
						{
							//$fila=new DOMElement("");
							$objeto=new Modcliente();
							$emp=new Modempresa();
							$suc=new Modsucursal();
							$fac=new Modfacturacion();
							$errores=array();
							$auxidemp=0;
							$auxnoctetmp="";
							foreach($fila->getElementsByTagName("celda") as $celda)
							{
								//$celda=new DOMElement("");
								switch(strtoupper($celda->getAttribute("columna")))
								{
									case "A":
										$aux=$emp->getFromCampo("razonsocial",$celda->nodeValue);
										if($aux!==false && $aux[0]["idempresa"]>0)
											$auxidemp=$aux[0]["idempresa"];
										else
											array_push($errores,"No encontró la empresa");
										break;
									case "B":
										$aux=$suc->getFromCampo($auxidemp,"nombre",$celda->nodeValue);
										if($aux!==false && $aux[0]["idsucursal"]>0)
											$objeto->setIdsucursal($aux[0]["idsucursal"]);
										else
											array_push($errores,"No encontró la sucursal");
										break;
									case "C":
										$auxnoctetmp=$celda->nodeValue;
										break;
									case 'D':
									    $objeto->setRazonsocial($celda->nodeValue);
									    break;
									case 'E':
									    $objeto->setRfc($celda->nodeValue);
									    break;
									case 'F':
										$objeto->setGiro($celda->nodeValue);
										break;
									case 'G':
										$objeto->setVendedor($this->modcatalogo->getIdOption(4,$celda->nodeValue));
										break;
									case 'H':
									    $objeto->setAfiliacion($celda->nodeValue);
									    break;
									case 'I':
										$objeto->setStatus($this->modcatalogo->getIdOption(13,$celda->nodeValue));
										break;
									case 'J':
										$fecha=$celda->nodeValue;
										$fecha=substr($fecha,1);
										$fecha=substr($fecha,0,strlen($fecha)-1);
									    $objeto->setFechacontratoinicio(DateToMySQL($fecha));
									    break;
									case 'K':
										$fecha=$celda->nodeValue;
										$fecha=substr($fecha,1);
										$fecha=substr($fecha,0,strlen($fecha)-1);
									    $objeto->setFechacontratofin(DateToMySQL($fecha));
									    break;
									case 'L':
										$fecha=$celda->nodeValue;
										$fecha=substr($fecha,1);
										$fecha=substr($fecha,0,strlen($fecha)-1);
									    $objeto->setFechaserviciosinicio(DateToMySQL($fecha));
									    break;
									case 'M':
										$fecha=$celda->nodeValue;
										$fecha=substr($fecha,1);
										$fecha=substr($fecha,0,strlen($fecha)-1);
									    $objeto->setFechaserviciosfin(DateToMySQL($fecha));
									    break;
									case 'N':
									    $objeto->setCalle($celda->nodeValue);
									    break;
									case 'O':
									    $objeto->setNumexterior($celda->nodeValue);
									    break;
									case 'P':
									    $objeto->setNuminterior($celda->nodeValue);
									    break;
									case 'Q':
									    $objeto->setColonia($celda->nodeValue);
									    break;
									case 'R':
									    $objeto->setMunicipio($celda->nodeValue);
									    break;
									case 'S':
									    $objeto->setEstado($celda->nodeValue);
									    break;
									case 'T':
									    $objeto->setCp($celda->nodeValue);
									    break;
									case 'U':
									    $objeto->setReferencias($celda->nodeValue);
									    break;
									case 'V':
									    $objeto->setRepresentante($celda->nodeValue);
									    break;
									case 'W':
									    $objeto->setRepresentantecargo($celda->nodeValue);
									    break;
									case 'X':
									    $objeto->setRepresentanteemail($celda->nodeValue);
									    break;
									case 'Y':
									    $objeto->setRepresentantetelefono($celda->nodeValue);
									    break;
									case 'Z':
									    $objeto->setRepresentanteextencion($celda->nodeValue);
									    break;
									case 'AA':
									    $objeto->setRepresentantetelefono2($celda->nodeValue);
									    break;
									case 'AB':
									    $objeto->setRepresentanteextension2($celda->nodeValue);
									    break;
									case 'AC':
									    $objeto->setObservaciones($celda->nodeValue);
									    break;
									case 'AD':
										$fac->setTiposervicio($this->modcatalogo->getIdOption(5,$celda->nodeValue));
										break;
									case 'AE':
										$fac->setTipocobro($this->modcatalogo->getIdOption(6,$celda->nodeValue));
										break;
									case 'AF':
									    $fac->setPrecio($celda->nodeValue);
									    break;
									case 'AG':
									    $fac->setKilosintegrados($celda->nodeValue);
									    break;
									case 'AH':
									    $fac->setKiloexcedido($celda->nodeValue);
									    break;
									case 'AI':
										$objeto->setFacturaxgenerador(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'AJ':
										$objeto->setOrdencompra(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'AK':
										$objeto->setDesglosemanifiestos(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'AL':
									    $objeto->setLeyendas($celda->nodeValue);
									    break;
									case 'AM':
										$objeto->setDiascredito($this->modcatalogo->getIdOption(7,$celda->nodeValue));
										break;
									case 'AN':
									    $objeto->setCobranzacontacto($celda->nodeValue);
									    break;
									case 'AO':
									    $objeto->setCobranzaemail($celda->nodeValue);
									    break;
									case 'AP':
									    $objeto->setCobranzatelefono($celda->nodeValue);
									    break;
									case 'AQ':
									    $objeto->setCobranzaextension($celda->nodeValue);
									    break;
									case 'AR':
									    $objeto->setCobranzatelefono2($celda->nodeValue);
									    break;
									case 'AS':
									    $objeto->setCobranzaextension2($celda->nodeValue);
									    break;
									case 'AT':
									    $objeto->setCobranzaobservaciones($celda->nodeValue);
									    break;
									case 'AU':
									    $objeto->setCobranzacalle($celda->nodeValue);
									    break;
									case 'AV':
									    $objeto->setCobranzanumexterior($celda->nodeValue);
									    break;
									case 'AW':
									    $objeto->setCobranzanuminterior($celda->nodeValue);
									    break;
									case 'AX':
									    $objeto->setCobranzacolonia($celda->nodeValue);
									    break;
									case 'AY':
									    $objeto->setCobranzamunicipio($celda->nodeValue);
									    break;
									case 'AZ':
									    $objeto->setCobranzaestado($celda->nodeValue);
									    break;
									case 'BA':
									    $objeto->setCobranzacp($celda->nodeValue);
									    break;
									case 'BB':
										$objeto->setReferenciabancaria($celda->nodeValue);
										break;
								}
							}
							$fac->addToDatabase();
							if($fac->getIdfacturacion()==0 || $fac->getIdfacturacion()=="")
								array_push($errores,"No se almacenaron los elementos de facturacion");
							else
								$objeto->setFacturaciones($fac->getIdfacturacion());
							$objeto->setIdentificador($objeto->nextIdentificador($objeto->getIdsucursal()));
							$objeto->setFechaalta(Today());
							$objeto->addToDatabase();
							if($objeto->getIdcliente()==0 || $objeto->getIdcliente()=="")
								array_push($errores,"No se almacenaron los datos del cliente");
							$clientes[$auxnoctetmp]=array(
								"tmpcte"=>$auxnoctetmp,
								"razonsocial"=>$objeto->getRazonsocial(),
								"idcliente"=>$objeto->getIdcliente(),
								"identificador"=>$objeto->getIdentificador(),
								"errores"=>$errores,
								"generadores"=>array()
								);
						}
						break;
					case "GENERADORES":
						foreach($hoja->getElementsByTagName("fila") as $fila)
						{
							//$fila=new DOMElement("");
							$objeto=new Modgenerador();
							$fac=new Modfacturacion();
							$errores=array();
							$auxnoctetmp="";
							foreach($fila->getElementsByTagName("celda") as $celda)
							{
								//$celda=new DOMElement("");
								switch(strtoupper($celda->getAttribute("columna")))
								{
									case 'A':
										$auxnoctetmp=$celda->nodeValue;
										if(!isset($clientes[$auxnoctetmp]))
											array_push($errores,"No se encontró la instancia del cliente");
										else
											$objeto->setIdcliente($clientes[$auxnoctetmp]["idcliente"]);
										break;
									case 'B':
									    $objeto->setRazonsocial($celda->nodeValue);
									    break;
									case 'C':
									    $objeto->setRfc($celda->nodeValue);
									    break;
									case 'D':
									    $objeto->setNumregamb($celda->nodeValue);
									    break;
									case 'E':
										$objeto->setFrecuencia($this->modcatalogo->getIdOption(3,$celda->nodeValue));
									    break;
									case 'F':
										$objeto->setActivo(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'G':
										$fecha=$celda->nodeValue;
										$fecha=substr($fecha,1);
										$fecha=substr($fecha,0,strlen($fecha)-1);
									    $objeto->setHorarioinicio($fecha);
									    break;
									case 'H':
										$fecha=$celda->nodeValue;
										$fecha=substr($fecha,1);
										$fecha=substr($fecha,0,strlen($fecha)-1);
									    $objeto->setHorariofin($fecha);
									    break;
									case 'I':
										$fecha=$celda->nodeValue;
										$fecha=substr($fecha,1);
										$fecha=substr($fecha,0,strlen($fecha)-1);
									    $objeto->setHorarioinicio2($fecha);
									    break;
									case 'J':
										$fecha=$celda->nodeValue;
										$fecha=substr($fecha,1);
										$fecha=substr($fecha,0,strlen($fecha)-1);
									    $objeto->setHorariofin2($fecha);
									    break;
									case 'K':
										$objeto->setServiciolunes(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'L':
										$objeto->setServiciomartes(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'M':
										$objeto->setServiciomiercoles(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'N':
										$objeto->setServiciojueves(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'O':
										$objeto->setServicioviernes(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'P':
										$objeto->setServiciosabado(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'Q':
										$objeto->setServiciodomingo(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'R':
									    $objeto->setCalle($celda->nodeValue);
									    break;
									case 'S':
									    $objeto->setNumexterior($celda->nodeValue);
									    break;
									case 'T':
									    $objeto->setNuminterior($celda->nodeValue);
									    break;
									case 'U':
									    $objeto->setColonia($celda->nodeValue);
									    break;
									case 'V':
									    $objeto->setMunicipio($celda->nodeValue);
									    break;
									case 'W':
									    $objeto->setEstado($celda->nodeValue);
									    break;
									case 'X':
									    $objeto->setCp($celda->nodeValue);
									    break;
									case 'Y':
									    $objeto->setReferencias($celda->nodeValue);
									    break;
									case 'Z':
									    $objeto->setRepresentante($celda->nodeValue);
									    break;
									case 'AA':
									    $objeto->setRepresentantecargo($celda->nodeValue);
									    break;
									case 'AB':
									    $objeto->setRepresentanteemail($celda->nodeValue);
									    break;
									case 'AC':
									    $objeto->setRepresentantetelefono($celda->nodeValue);
									    break;
									case 'AD':
									    $objeto->setRepresentanteextension($celda->nodeValue);
									    break;
									case 'AE':
									    $objeto->setRepresentantetelefono2($celda->nodeValue);
									    break;
									case 'AF':
									    $objeto->setCobranzaextension2($celda->nodeValue);
									    break;
									case 'AG':
									    $objeto->setObservaciones($celda->nodeValue);
									    break;
									case 'AH':
										$fac->setTiposervicio($this->modcatalogo->getIdOption(5,$celda->nodeValue));
										break;
									case 'AI':
										$fac->setTipocobro($this->modcatalogo->getIdOption(6,$celda->nodeValue));
										break;
									case 'AJ':
									    $fac->setPrecio($celda->nodeValue);
									    break;
									case 'AK':
									    $fac->setKilosintegrados($celda->nodeValue);
									    break;
									case 'AL':
									    $fac->setKiloexcedido($celda->nodeValue);
									    break;
									case 'AM':
										$objeto->setOrdencompra(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
										break;
									case 'AN':
										$objeto->setDesglosemanifiestos(strtoupper(trim($celda->nodeValue))=="SI"?1:0);
									    break;
									case 'AO':
									    $objeto->setLeyendas($celda->nodeValue);
									    break;
									case 'AP':
									    $objeto->setCobranzacontacto($celda->nodeValue);
									    break;
									case 'AQ':
									    $objeto->setCobranzaemail($celda->nodeValue);
									    break;
									case 'AR':
									    $objeto->setCobranzatelefono($celda->nodeValue);
									    break;
									case 'AS':
									    $objeto->setCobranzaextension($celda->nodeValue);
									    break;
									case 'AT':
									    $objeto->setCobranzatelefono2($celda->nodeValue);
									    break;
									case 'AU':
									    $objeto->setRepresentanteextension2($celda->nodeValue);
									    break;
									case 'AV':
									    $objeto->setCobranzaobservaciones($celda->nodeValue);
									    break;
									case 'AW':
									    $objeto->setCobranzacalle($celda->nodeValue);
									    break;
									case 'AX':
									    $objeto->setCobranzanumexterior($celda->nodeValue);
									    break;
									case 'AY':
									    $objeto->setCobranzanuminterior($celda->nodeValue);
									    break;
									case 'AZ':
									    $objeto->setCobranzacolonia($celda->nodeValue);
									    break;
									case 'BA':
									    $objeto->setCobranzamunicipio($celda->nodeValue);
									    break;
									case 'BB':
									    $objeto->setCobranzaestado($celda->nodeValue);
									    break;
									case 'BC':
									    $objeto->setCobranzacp($celda->nodeValue);
									    break;
									case 'BD':
										$objeto->setGiro($celda->nodeValue);
										break;
								}
							}
							$fac->addToDatabase();
							if($fac->getIdfacturacion()==0||$fac->getIdfacturacion()=="")
								array_push($errores,"No se almacenaron los datos de facturacion");
							else
								$objeto->setFacturaciones($fac->getIdfacturacion());
							$objeto->setIdentificador(count($clientes[$auxnoctetmp]["generadores"])+1);
							$objeto->addToDatabase();
							if($objeto->getIdgenerador()==0||$objeto->getIdgenerador()=="")
								array_push($errores,"No se almacenaron los datos del generador");
							array_push($clientes[$auxnoctetmp]["generadores"],array(
								"idgenerador"=>$objeto->getIdgenerador(),
								"razonsocial"=>$objeto->getRazonsocial(),
								"identificador"=>$objeto->getIdentificador(),
								"errores"=>$errores
								));
						}
						break;
				}
			}
			$head=$this->load->view('html/head',array(),true);
			$menumain=$this->load->view('menu/menumain',array(),true);
			$body=$this->load->view('clientes/importaresultado',array(
				"menumain"=>$menumain,
				"idempresa"=>$idempresa,
				"idsucursal"=>$idsucursal,
				"clientes"=>$clientes
				),true);
			$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		}
		else
			echo "No existe el archivo $archivo";
	}
	public function menucrearreporte()
	{
		$this->load->view('clientes/menureportes');
	}
	public function calendarios()
	{
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->load->library('calendar',array(
			'start_dat'=>'monday',
			'moth_type'=>'long',
			'day_type'=>'short',
			'template'=>file_get_contents("./project_files/files/templates/calendario.php")
		));
		$tipo=$this->input->post('tipo_gen');
		$cte_inicial=$this->input->post('frm_cte_inicial');
		$cte_final=$this->input->post('frm_cte_final');
		$gen_inicial=$this->input->post('frm_gen_inicial');
		$gen_final=$this->input->post('frm_gen_final');
		$fec_inicial=$this->input->post('frm_fec_inicial');
		$fec_final=$this->input->post('frm_fec_final');
		$data=array();
		if($tipo=="rg")
		{
			if(($cte_inicial!==false && $cte_inicial!=="")) $cte_final=$cte_inicial;
			else if(($cte_final!==false||$cte_final!=="")) $cte_inicial=$cte_final;
			if($gen_inicial===false||$gen_inicial=="") $gen_inicial="1";
			if($gen_final===false||$gen_final=="") $gen_final=$gen_inicial;
			$ctes=$this->modcliente->getRango($cte_inicial,$cte_final);
			foreach($ctes as $c)
			{
				$datagens=array();
				$gens=$this->modgenerador->getRango($c["idcliente"],$gen_inicial,$gen_final);
				foreach($gens as $g)
				{
					$dbGen=new Modgenerador();
					$dbGen->getFromDatabase($g["idgenerador"]);
					$g["fechas"]=$dbGen->getFechasRango($fec_inicial,$fec_final);
					if($g["fechas"]!==false && count($g["fechas"])>0)
						array_push($datagens,$g);
				}
				$c["generadores"]=$datagens;
				if($c["generadores"]!==false && count($c["generadores"])>0)
					array_push($data,$c);
			}
		}
		else if($tipo=="rc")
		{
			if(($cte_inicial!==false && $cte_inicial!=="") && ($cte_final===false||$cte_final=="")) $cte_final=$cte_inicial;
			else if(($cte_final!==false||$cte_final!=="") && ($cte_inicial===false||$cte_inicial=="")) $cte_inicial=$cte_final;
			$ctes=$this->modcliente->getRango($cte_inicial,$cte_final);
			foreach($ctes as $c)
			{
				$dbcte=new Modcliente();
				$dbcte->getFromDatabase($c["idcliente"]);
				$datagens=array();
				$gens=$this->modgenerador->getAll($c["idcliente"]);
				if($gens!==false) foreach($gens as $g)
				{
					$dbGen=new Modgenerador();
					$dbGen->getFromDatabase($g["idgenerador"]);
					$g["fechas"]=$dbGen->getFechasRango($fec_inicial,$fec_final);
					if($g["fechas"]!==false && count($g["fechas"])>0)
						array_push($datagens,$g);
				}
				$c["generadores"]=$datagens;
				if($c["generadores"]!==false && count($c["generadores"])>0)
					array_push($data,$c);
			}
		}
		foreach($data as $i=>$c)
		{
			$contgen=0;
			foreach($c["generadores"] as $j=>$g)
			{
				if(count($this->modsesion->getAllGens())>0 && !in_array($g["idgenerador"],$this->modsesion->getAllGens()))
				{
					unset($data[$i]["generadores"][$j]);
				}
				else
				{
					$data[$i]["generadores"][$j]["vista"]=$this->load->view("clientes/calendario_display",array(
						"fec_inicial"=>$fec_inicial,
						"fec_final"=>$fec_final,
						"fecs"=>$g["fechas"]
						),true);
					$contgen++;
				}
			}
			if($contgen==0)
				unset($data[$i]);
		}
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array("justCloseWindow"=>true),true);
		$body=$this->load->view('clientes/calendario',array(
			"menumain"=>$menumain,
			"cte_inicial"=>$cte_inicial,
			"cte_final"=>$cte_final,
			"gen_inicial"=>$gen_inicial,
			"gen_final"=>$gen_final,
			"tipo"=>$tipo,
			"fec_inicial"=>$fec_inicial,
			"fec_final"=>$fec_final,
			"data"=>$data
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function getjson($data="")
	{
		$this->load->model('modcliente');
		if($data=="")
		{
			echo json_encode($this->modcliente->getAll(0,array("identificador"=>"%")));
		}
		else
		{
			list($campo,$valor)=explode("=",$data);
			$campo=strtolower(trim($campo));
			if($campo=="sucursal")
				echo json_encode($this->modcliente->getAll($valor,""));
			else if(strpos($campo,"_equal"))
			{
				if($campo=="identificador_equal")
				{
					$id=$this->modcliente->getIdclienteWithIdentificador(0,$valor);
					if($id!==false)
					{
						$this->modcliente->setIdcliente($id);
						$this->modcliente->getFromDatabase();
						echo $this->modcliente->asJSON();
					}
				}
			}
			else
			{
				echo json_encode($this->modcliente->getAll(0,array($campo=>$valor)));
			}
		}
	}
}
?>