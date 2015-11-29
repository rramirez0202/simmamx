<?php
class Rutas extends CI_Controller
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
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$empresas=$this->modempresa->getAllTransportista();
		if($idempresa==0 && count($empresas)>0) $idempresa=$empresas[0]["idempresa"];
		$sucursales=($idempresa>0?$this->modsucursal->getAll($idempresa):array());
		if($idsucursal==0 && count($sucursales)>0) $idsucursal=$sucursales[0]["idsucursal"];
		$rutas=($idsucursal>0?$this->modruta->getAll($idsucursal):array());
		$body=$this->load->view('rutas/index',array(
			"menumain"=>$menumain,
			"sucursales"=>$sucursales,
			"empresas"=>$empresas,
			"idempresa"=>$idempresa,
			"idsucursal"=>$idsucursal,
			"rutas"=>$rutas,
			"objruta"=>$this->modruta,
			"objempresa"=>$this->modempresa,
			"objsucursal"=>$this->modsucursal,
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function nuevo($idempresa=0,$idsucursal=0)
	{
		$this->load->model('modruta');
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$this->load->model('modoperador');
		$this->load->model('modvehiculo');
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
						"nombre"=>$this->modsucursal->getNombre(),
						"operadores"=>$this->modoperador->getAll($this->modsucursal->getIdsucursal()),
						"vehiculos"=>$this->modvehiculo->getAll($this->modsucursal->getIdsucursal())
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
		$idTransportista=0;
		$idDestinoFinal=0;
		if($idTransportista==0 && count($sucsTrans)>0 && count($sucsTrans[0]["sucursales"])>0) 
			$idTransportista=$sucsTrans[0]["sucursales"][0]["idsucursal"];
		if($idDestinoFinal==0 && count($sucsDestFinal)>0 && count($sucsDestFinal[0]["sucursales"])>0) 
			$idDestinoFinal=$sucsDestFinal[0]["sucursales"][0]["idsucursal"];
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('rutas/formulario',array(
			"menumain"=>$menumain,
			"transportistas"=>$sucsTrans,
			"destinosfinales"=>$sucsDestFinal,
			"idtransportista"=>$idTransportista,
			"iddestinofinal"=>$idDestinoFinal,
			"objeto"=>$this->modruta,
			"idsucursal"=>$idsucursal
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function add()
	{
		$this->load->model('modruta');
		$this->modruta->getFromInput();
		$this->modruta->addToDatabase();
		echo $this->modruta->getIdruta();
		$this->modsesion->addLog(
			"agregar",
			$this->modruta->getIdruta(),
			$this->modruta->getNombre(),
			"ruta",
			"relsucrut,relrutope,relrutveh"
		);
	}
	public function update()
	{
		$this->load->model('modruta');
		$this->modruta->getFromInput();
		$this->modruta->updateToDatabase();
		echo $this->modruta->getIdruta();
		$this->modsesion->addLog(
			"actualizar",
			$this->modruta->getIdruta(),
			$this->modruta->getNombre(),
			"ruta",
			"relrutope,relrutveh"
		);
	}
	public function ver($id)
	{
		$this->load->model('modruta');
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$this->load->model('modoperador');
		$this->load->model('modvehiculo');
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->modruta->getFromDatabase($id);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('rutas/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modruta,
			"sucursal"=>$this->modsucursal,
			"empresa"=>$this->modempresa,
			"operador"=>$this->modoperador,
			"vehiculo"=>$this->modvehiculo,
			"cliente"=>$this->modcliente,
			"generador"=>$this->modgenerador
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		$this->modsesion->addLog(
			"verdetalle",
			$this->modruta->getIdruta(),
			$this->modruta->getNombre(),
			"",
			""
		);
	}
	public function actualizar($id)
	{
		$this->load->model('modruta');
		$this->load->model('modsucursal');
		$this->load->model('modempresa');
		$this->load->model('modoperador');
		$this->load->model('modvehiculo');
		$this->modruta->getFromDatabase($id);
		$this->modsucursal->setIdsucursal($this->modruta->getIdsucursal());
		$this->modsucursal->getFromDatabase();
		$idsucursal=$this->modsucursal->getIdsucursal();
		$idempresa=$this->modsucursal->getIdempresa();
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
						"nombre"=>$this->modsucursal->getNombre(),
						"operadores"=>$this->modoperador->getAll($this->modsucursal->getIdsucursal()),
						"vehiculos"=>$this->modvehiculo->getAll($this->modsucursal->getIdsucursal())
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
		$idTransportista=($this->modruta->getEmpresatransportista()>0?$this->modruta->getEmpresatransportista():0);
		$idDestinoFinal=($this->modruta->getEmpresadestinofinal()?$this->modruta->getEmpresadestinofinal():0);
		if($idTransportista==0 && count($sucsTrans)>0 && count($sucsTrans[0]["sucursales"])>0) 
			$idTransportista=$sucsTrans[0]["sucursales"][0]["idsucursal"];
		if($idDestinoFinal==0 && count($sucsDestFinal)>0 && count($sucsDestFinal[0]["sucursales"])>0) 
			$idDestinoFinal=$sucsDestFinal[0]["sucursales"][0]["idsucursal"];
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('rutas/formulario',array(
			"menumain"=>$menumain,
			"transportistas"=>$sucsTrans,
			"destinosfinales"=>$sucsDestFinal,
			"idtransportista"=>$idTransportista,
			"iddestinofinal"=>$idDestinoFinal,
			"objeto"=>$this->modruta,
			"idsucursal"=>$idsucursal
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function eliminar($id)
	{
		$this->load->model('modruta');
		$this->modruta->getFromDatabase($id);
		$this->modruta->delete($id);
		$this->modsesion->addLog(
			"eliminar",
			$this->modruta->getIdruta(),
			$this->modruta->getNombre(),
			"ruta",
			"relbitrut,relmanrut,relsucrut,relrutope,relrutveh,relrutgen"
		);
	}
	public function agregargeneradores($id)
	{
		$this->load->model('modruta');
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->modruta->getFromDatabase($id);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('rutas/agregargeneradores',array(
			"menumain"=>$menumain,
			"ruta"=>$this->modruta,
			"cliente"=>$this->modcliente,
			"generador"=>$this->modgenerador
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function eliminargeneradores($id)
	{
		$this->load->model('modruta');
		$this->load->model('modcliente');
		$this->load->model('modgenerador');
		$this->modruta->getFromDatabase($id);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('rutas/eliminargeneradores',array(
			"menumain"=>$menumain,
			"ruta"=>$this->modruta,
			"cliente"=>$this->modcliente,
			"generador"=>$this->modgenerador
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function addgeneradores($id,$data)
	{
		foreach(explode(",",$data) as $gen)
		{
			$this->db->select("COUNT(*) AS n");
			$this->db->where(array("idgenerador"=>$gen,"idruta"=>$id));
			$total=$this->db->get("relrutgen");
			$total=intval($total->result_array()[0]["n"]);
			if($total==0)
				$this->db->insert("relrutgen",array(
					"idgenerador"=>$gen,
					"idruta"=>$id
				));
		}
	}
	public function delgeneradores($id,$data)
	{
		$this->db->where("idruta = $id and idgenerador in ($data)");
		$this->db->delete("relrutgen");
	}
	public function getdatagenerador($identificadorCte,$identificadorGen)
	{
		$this->load->model("modcliente");
		$this->load->model("modgenerador");
		$data=array();
		$idcte=$this->modcliente->getIdclienteWithIdentificador(0,$identificadorCte);
		//array_push($data,$this->db->last_query());
		if($idcte!==false)
		{
			$idgen=$this->modgenerador->getIdgeneradoWithIdentificador($idcte,$identificadorGen);
			if($idgen!==false)
			{
				$this->modcliente->setIdcliente($idcte);
				$this->modcliente->getFromDatabase();
				$this->modgenerador->setIdgenerador($idgen);
				$this->modgenerador->getFromDatabase();
				array_push($data,$idcte);
				array_push($data,$this->modcliente->getRazonsocial());
				array_push($data,$this->modcliente->getIdentificador());
				array_push($data,$idgen);
				array_push($data,$this->modgenerador->getRazonsocial());
				array_push($data,$this->modgenerador->getIdentificador());
			}
			else
				array_push($data,"No encontro el generador $identificadorGen asociado al cliente $identificadorCte");
		}
		else
			array_push($data,"No se encontró el cliente $identificadorCte");
		echo json_encode($data);
	}
	public function planrecoleccion($idruta,$fecha="")
	{
		$this->load->model('modruta');
		$this->modruta->getFromDatabase($idruta);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('rutas/plangeneracion',array(
			"menumain"=>$menumain,
			"ruta"=>$this->modruta,
			"fecha"=>$fecha
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
}
?>