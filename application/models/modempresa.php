<?php
class Modempresa extends CI_Model
{
	private $idempresa;
	private $razonsocial;
	private $rfc;
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
	private $coorporativo;
	private $transportista;
	private $destinofinal;
	public function __construct()
	{
		parent::__construct();
		$this->idempresa=0;
		$this->razonsocial="";
		$this->rfc="";
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
		$this->coorporativo=0;
		$this->transportista=0;
		$this->destinofinal=0;
	}
	public function getIdempresa() { return $this->idempresa; }
	public function getRazonsocial() { return $this->razonsocial; }
	public function getRfc() { return $this->rfc; }
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
	public function getCoorporativo() { return $this->coorporativo; }
	public function getTransportista() { return $this->transportista; }
	public function getDestinofinal() { return $this->destinofinal; }
	public function setIdempresa($valor) { $this->idempresa= intval($valor); }
	public function setRazonsocial($valor) { $this->razonsocial= "".$valor; }
	public function setRfc($valor) { $this->rfc= "".$valor; }
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
	public function setCoorporativo($valor) { $this->coorporativo= intval($valor); }
	public function setTransportista($valor) { $this->transportista= intval($valor); }
	public function setDestinofinal($valor) { $this->destinofinal= intval($valor); }
	public function getFromDatabase($id=0)
	{
		if($this->idempresa==""||$this->idempresa==0)
		{
			if($id>0)
				$this->idempresa=$id;
			else
				return false;
		}
		$this->db->where('idempresa',$this->idempresa);
		$regs=$this->db->get('empresa');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdempresa($reg["idempresa"]);
		$this->setRazonsocial($reg["razonsocial"]);
		$this->setRfc($reg["rfc"]);
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
		$this->setCoorporativo($reg["coorporativo"]);
		$this->setTransportista($reg["transportista"]);
		$this->setDestinofinal($reg["destinofinal"]);
		return true;
	}
	public function getFromInput()
	{
		$this->setIdempresa($this->input->post("frm_empresa_idempresa"));
		$this->setRazonsocial($this->input->post("frm_empresa_razonsocial"));
		$this->setRfc($this->input->post("frm_empresa_rfc"));
		$this->setCalle($this->input->post("frm_empresa_calle"));
		$this->setNumexterior($this->input->post("frm_empresa_numexterior"));
		$this->setNuminterior($this->input->post("frm_empresa_numinterior"));
		$this->setColonia($this->input->post("frm_empresa_colonia"));
		$this->setMunicipio($this->input->post("frm_empresa_municipio"));
		$this->setEstado($this->input->post("frm_empresa_estado"));
		$this->setCp($this->input->post("frm_empresa_cp"));
		$this->setTelefono($this->input->post("frm_empresa_telefono"));
		$this->setAutsemarnat($this->input->post("frm_empresa_autsemarnat"));
		$this->setRegistrosct($this->input->post("frm_empresa_registrosct"));
		$this->setRepresentante($this->input->post("frm_empresa_representante"));
		$this->setCargorepresentante($this->input->post("frm_empresa_cargorepresentante"));
		$this->setCoorporativo($this->input->post("frm_empresa_coorporativo"));
		$this->setTransportista($this->input->post("frm_empresa_transportista"));
		$this->setDestinofinal($this->input->post("frm_empresa_destinofinal"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"razonsocial"=>$this->razonsocial,
			"rfc"=>$this->rfc,
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
			"coorporativo"=>$this->coorporativo,
			"transportista"=>$this->transportista,
			"destinofinal"=>$this->destinofinal
		);
		$this->db->insert('empresa',$data);
		$this->setIdempresa($this->db->insert_id());
	}
	public function updateToDatabase($id=0)
	{
		if($this->idempresa==""||$this->idempresa==0)
		{
			if($id>0)
				$this->idempresa=$id;
			else
				return false;
		}
		$data=array(
			"razonsocial"=>$this->razonsocial,
			"rfc"=>$this->rfc,
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
			"coorporativo"=>$this->coorporativo,
			"transportista"=>$this->transportista,
			"destinofinal"=>$this->destinofinal
		);
		$this->db->where('idempresa',$this->idempresa);
		$this->db->update('empresa',$data);
		return true;
	}
	public function getAll()
	{
		$this->db->order_by('razonsocial');
		$regs=$this->db->get('empresa');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getAllCoorporativo()
	{
		$this->db->where('coorporativo',1);
		$this->db->order_by('razonsocial');
		$regs=$this->db->get('empresa');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getAllTransportista()
	{
		$this->db->where('transportista',1);
		$this->db->order_by('razonsocial');
		$regs=$this->db->get('empresa');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getAllDestinoFinal()
	{
		$this->db->where('destinofinal',1);
		$this->db->order_by('razonsocial');
		$regs=$this->db->get('empresa');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function delete($id=0)
	{
		if($this->idempresa==""||$this->idempresa==0)
		{
			if($id>0)
				$this->idempresa=$id;
			else
				return false;
		}
		$sucs=$this->getSucursales();
		if($sucs!==false)
		{
			foreach($sucs as $suc)
			{
				$this->modsucursal->setIdsucursal($suc["idsucursal"]);
				$this->modsucursal->delete();
			}
		}
		$this->db->where('idempresa',$this->idempresa);
		$this->db->delete(array('empresa','relempsuc'));
	}
	public function getSucursales()
	{
		if($this->idempresa==""||$this->idempresa==0)
			return false;
		$this->db->select('idsucursal');
		$this->db->where('idempresa',$this->idempresa);
		$regs=$this->db->get('relempsuc');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getFromCampo($campo,$valor)
	{
		$this->db->where($campo,$valor);
		$regs=$this->db->get('empresa');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
}
?>