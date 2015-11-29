<?php
class Modsucursal extends CI_Model
{
	private $idsucursal;
	private $nombre;
	private $calle;
	private $numexterior;
	private $numinterior;
	private $colonia;
	private $municipio;
	private $estado;
	private $cp;
	private $telefono;
	private $autsemarnat;
	private $registrosct;
	private $representante;
	private $cargorepresentante;
	private $numregamb;
	private $idempresa;
	private $iniciales;
	public function __construct()
	{
		parent::__construct();
		$this->idsucursal=0;
		$this->nombre="";
		$this->calle="";
		$this->numexterior="";
		$this->numinterior="";
		$this->colonia="";
		$this->municipio="";
		$this->estado="";
		$this->cp="";
		$this->telefono="";
		$this->autsemarnat="";
		$this->registrosct="";
		$this->representante="";
		$this->cargorepresentante="";
		$this->numregamb="";
		$this->idempresa=0;
		$this->iniciales="";
	}
	public function getIdsucursal() { return $this->idsucursal; }
	public function getNombre() { return $this->nombre; }
	public function getCalle() { return $this->calle; }
	public function getNumexterior() { return $this->numexterior; }
	public function getNuminterior() { return $this->numinterior; }
	public function getColonia() { return $this->colonia; }
	public function getMunicipio() { return $this->municipio; }
	public function getEstado() { return $this->estado; }
	public function getCp() { return $this->cp; }
	public function getTelefono() { return $this->telefono; }
	public function getAutsemarnat() { return $this->autsemarnat; }
	public function getRegistrosct() { return $this->registrosct; }
	public function getRepresentante() { return $this->representante; }
	public function getCargorepresentante() { return $this->cargorepresentante; }
	public function getNumregamb() { return $this->numregamb; }
	public function getIdempresa() { return $this->idempresa; }
	public function getIniciales() { return $this->iniciales; }
	public function setIdsucursal($valor) { $this->idsucursal= intval($valor); }
	public function setNombre($valor) { $this->nombre= "".$valor; }
	public function setCalle($valor) { $this->calle= "".$valor; }
	public function setNumexterior($valor) { $this->numexterior= "".$valor; }
	public function setNuminterior($valor) { $this->numinterior= "".$valor; }
	public function setColonia($valor) { $this->colonia= "".$valor; }
	public function setMunicipio($valor) { $this->municipio= "".$valor; }
	public function setEstado($valor) { $this->estado= "".$valor; }
	public function setCp($valor) { $this->cp= "".$valor; }
	public function setTelefono($valor) { $this->telefono= "".$valor; }
	public function setAutsemarnat($valor) { $this->autsemarnat= "".$valor; }
	public function setRegistrosct($valor) { $this->registrosct= "".$valor; }
	public function setRepresentante($valor) { $this->representante= "".$valor; }
	public function setCargorepresentante($valor) { $this->cargorepresentante= "".$valor; }
	public function setNumregamb($valor) { $this->numregamb= "".$valor; }
	public function setIdempresa($valor) { $this->idempresa= intval($valor); }
	public function setIniciales($valor) { $this->iniciales= "".$valor; }
	public function getFromDatabase($id=0)
	{
		if($this->idsucursal==""||$this->idsucursal==0)
		{
			if($id>0)
				$this->idsucursal=$id;
			else
				return false;
		}
		$this->db->where('idsucursal',$this->idsucursal);
		$regs=$this->db->get('sucursal');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdsucursal($reg["idsucursal"]);
		$this->setNombre($reg["nombre"]);
		$this->setCalle($reg["calle"]);
		$this->setNumexterior($reg["numexterior"]);
		$this->setNuminterior($reg["numinterior"]);
		$this->setColonia($reg["colonia"]);
		$this->setMunicipio($reg["municipio"]);
		$this->setEstado($reg["estado"]);
		$this->setCp($reg["cp"]);
		$this->setTelefono($reg["telefono"]);
		$this->setAutsemarnat($reg["autsemarnat"]);
		$this->setRegistrosct($reg["registrosct"]);
		$this->setRepresentante($reg["representante"]);
		$this->setCargorepresentante($reg["cargorepresentante"]);
		$this->setNumregamb($reg["numregamb"]);
		$this->setIniciales($reg["iniciales"]);
		$this->db->where('idsucursal',$this->idsucursal);
		$regs=$this->db->get('relempsuc');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdempresa($reg["idempresa"]);
		return true;
	}
	public function getFromInput()
	{
		$this->setIdsucursal($this->input->post("frm_sucursal_idsucursal"));
		$this->setNombre($this->input->post("frm_sucursal_nombre"));
		$this->setCalle($this->input->post("frm_sucursal_calle"));
		$this->setNumexterior($this->input->post("frm_sucursal_numexterior"));
		$this->setNuminterior($this->input->post("frm_sucursal_numinterior"));
		$this->setColonia($this->input->post("frm_sucursal_colonia"));
		$this->setMunicipio($this->input->post("frm_sucursal_municipio"));
		$this->setEstado($this->input->post("frm_sucursal_estado"));
		$this->setCp($this->input->post("frm_sucursal_cp"));
		$this->setTelefono($this->input->post("frm_sucursal_telefono"));
		$this->setAutsemarnat($this->input->post("frm_sucursal_autsemarnat"));
		$this->setRegistrosct($this->input->post("frm_sucursal_registrosct"));
		$this->setRepresentante($this->input->post("frm_sucursal_representante"));
		$this->setCargorepresentante($this->input->post("frm_sucursal_cargorepresentante"));
		$this->setNumregamb($this->input->post("frm_sucursal_numregamb"));
		$this->setIdempresa($this->input->post("frm_sucursal_idempresa"));
		$this->setIniciales($this->input->post("frm_sucursal_iniciales"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"nombre"=>$this->nombre,
			"calle"=>$this->calle,
			"numexterior"=>$this->numexterior,
			"numinterior"=>$this->numinterior,
			"colonia"=>$this->colonia,
			"municipio"=>$this->municipio,
			"estado"=>$this->estado,
			"cp"=>$this->cp,
			"telefono"=>$this->telefono,
			"autsemarnat"=>$this->autsemarnat,
			"registrosct"=>$this->registrosct,
			"representante"=>$this->representante,
			"cargorepresentante"=>$this->cargorepresentante,
			"numregamb"=>$this->numregamb,
			"iniciales"=>$this->iniciales
		);
		$this->db->insert('sucursal',$data);
		$this->setIdsucursal($this->db->insert_id());
		$this->db->insert('relempsuc',array(
			"idsucursal"=>$this->idsucursal,
			"idempresa"=>$this->idempresa
			));
	}
	public function updateToDatabase($id=0)
	{
		if($this->idsucursal==""||$this->idsucursal==0)
		{
			if($id>0)
				$this->idsucursal=$id;
			else
				return false;
		}
		$data=array(
			"nombre"=>$this->nombre,
			"calle"=>$this->calle,
			"numexterior"=>$this->numexterior,
			"numinterior"=>$this->numinterior,
			"colonia"=>$this->colonia,
			"municipio"=>$this->municipio,
			"estado"=>$this->estado,
			"cp"=>$this->cp,
			"telefono"=>$this->telefono,
			"autsemarnat"=>$this->autsemarnat,
			"registrosct"=>$this->registrosct,
			"representante"=>$this->representante,
			"cargorepresentante"=>$this->cargorepresentante,
			"numregamb"=>$this->numregamb,
			"iniciales"=>$this->iniciales
		);
		$this->db->where('idsucursal',$this->idsucursal);
		$this->db->update('sucursal',$data);
		return true;
	}
	public function getAll($idempresa=0)
	{
		if($idempresa>0)
			$this->db->where("idsucursal in (select idsucursal from relempsuc where idempresa=$idempresa)");
		$this->db->order_by('nombre');
		$regs=$this->db->get('sucursal');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function delete($id=0)
	{
		//Elimina la relacion con la empresa pero la deja viva
		if($this->idsucursal==""||$this->idsucursal==0)
		{
			if($id>0)
				$this->idsucursal=$id;
			else
				return false;
		}
		$regs=$this->getRutas();
		if($regs!==false) foreach($regs as $reg)
		{
			$this->modruta->setIdruta($reg["idruta"]);
			$this->modruta->delete();
		}
		$regs=$this->getVehiculos();
		if($regs!==false) foreach($regs as $reg)
		{
			$this->modvehiculo->setIdvehiculo($reg["idvehiculo"]);
			$this->modvehiculo->delete();
		}
		$regs=$this->getOperadores();
		if($regs!==false) foreach($regs as $reg)
		{
			$this->modoperador->setIdoperador($reg["idoperador"]);
			$this->modoperador->delete();
		}
		$regs=$this->getClientes();
		if($regs!==false) foreach($regs as $reg)
		{
			$this->modcliente->setIdcliente($reg["idcliente"]);
			$this->modcliente->delete();
		}
		$regs=$this->getResiduos();
		if($regs!==false) foreach($regs as $reg)
		{
			$this->modresiduo->setIdresiduo($reg["idresiduo"]);
			$this->modresiduo->delete();
		}
		$this->db->where('idsucursal',$this->idsucursal);
		$this->db->delete(array('relempsuc','sucursal'));
	}
	public function getResiduos()
	{
		if($this->idsucursal==""||$this->idsucursal==0)
			return false;
		$this->db->select('idresiduo');
		$this->db->where('idsucursal',$this->idsucursal);
		$regs=$this->db->get('relsucres');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getClientes()
	{
		if($this->idsucursal==""||$this->idsucursal==0)
			return false;
		$this->db->select('idcliente');
		$this->db->where('idsucursal',$this->idsucursal);
		$regs=$this->db->get('relsuccli');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getVehiculos()
	{
		if($this->idsucursal==""||$this->idsucursal==0)
			return false;
		$this->db->select('idvehiculo');
		$this->db->where('idsucursal',$this->idsucursal);
		$regs=$this->db->get('relsucveh');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getRutas()
	{
		if($this->idsucursal==""||$this->idsucursal==0)
			return false;
		$this->db->select('idruta');
		$this->db->where('idsucursal',$this->idsucursal);
		$regs=$this->db->get('relsucrut');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getOperadores()
	{
		if($this->idsucursal==""||$this->idsucursal==0)
			return false;
		$this->db->select('idoperador');
		$this->db->where('idsucursal',$this->idsucursal);
		$regs=$this->db->get('relsucope');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getFromCampo($idempresa,$campo,$valor)
	{
		$this->db->where("$campo ='$valor' and idsucursal in (select idsucursal from relempsuc where idempresa=$idempresa)");
		$regs=$this->db->get('sucursal');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
}
?>