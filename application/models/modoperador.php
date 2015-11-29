<?php
class Modoperador extends CI_Model
{
	private $idoperador;
	private $nombre;
	private $apaterno;
	private $amaterno;
	private $detalle;
	private $cargo;
	private $telefono;
	private $email;
	private $idsucursal;
	public function __construct()
	{
		parent::__construct();
		$this->idoperador=0;
		$this->nombre="";
		$this->apaterno="";
		$this->amaterno="";
		$this->detalle="";
		$this->cargo="";
		$this->telefono="";
		$this->email="";
		$this->idsucursal=0;
	}
	public function getIdoperador() { return $this->idoperador; }
	public function getNombre() { return $this->nombre; }
	public function getApaterno() { return $this->apaterno; }
	public function getAmaterno() { return $this->amaterno; }
	public function getDetalle() { return $this->detalle; }
	public function getCargo() { return $this->cargo; }
	public function getTelefono() { return $this->telefono; }
	public function getEmail() { return $this->email; }
	public function getIdsucursal() { return $this->idsucursal; }
	public function setIdoperador($valor) { $this->idoperador= intval($valor); }
	public function setNombre($valor) { $this->nombre= "".$valor; }
	public function setApaterno($valor) { $this->apaterno= "".$valor; }
	public function setAmaterno($valor) { $this->amaterno= "".$valor; }
	public function setDetalle($valor) { $this->detalle= "".$valor; }
	public function setCargo($valor) { $this->cargo= "".$valor; }
	public function setTelefono($valor) { $this->telefono= "".$valor; }
	public function setEmail($valor) { $this->email= "".$valor; }
	public function setIdsucursal($valor) { $this->idsucursal= intval($valor); }
	public function getFromDatabase($id=0)
	{
		if($this->idoperador==""||$this->idoperador==0)
		{
			if($id>0)
				$this->idoperador=$id;
			else
				return false;
		}
		$this->db->where('idoperador',$this->idoperador);
		$regs=$this->db->get('operador');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdoperador($reg["idoperador"]);
		$this->setNombre($reg["nombre"]);
		$this->setApaterno($reg["apaterno"]);
		$this->setAmaterno($reg["amaterno"]);
		$this->setDetalle($reg["detalle"]);
		$this->setCargo($reg["cargo"]);
		$this->setTelefono($reg["telefono"]);
		$this->setEmail($reg["email"]);
		$this->db->where('idoperador',$this->idoperador);
		$regs=$this->db->get('relsucope');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdsucursal($reg["idsucursal"]);
		return true;
	}
	public function getFromInput()
	{
		$this->setIdoperador($this->input->post("frm_operador_idoperador"));
		$this->setNombre($this->input->post("frm_operador_nombre"));
		$this->setApaterno($this->input->post("frm_operador_apaterno"));
		$this->setAmaterno($this->input->post("frm_operador_amaterno"));
		$this->setDetalle($this->input->post("frm_operador_detalle"));
		$this->setCargo($this->input->post("frm_operador_cargo"));
		$this->setTelefono($this->input->post("frm_operador_telefono"));
		$this->setEmail($this->input->post("frm_operador_email"));
		$this->setIdsucursal($this->input->post("frm_operador_idsucursal"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"nombre"=>$this->nombre,
			"apaterno"=>$this->apaterno,
			"amaterno"=>$this->amaterno,
			"detalle"=>$this->detalle,
			"cargo"=>$this->cargo,
			"telefono"=>$this->telefono,
			"email"=>$this->email
		);
		$this->db->insert('operador',$data);
		$this->setIdoperador($this->db->insert_id());
		$this->db->insert('relsucope',array(
			"idsucursal"=>$this->idsucursal,
			"idoperador"=>$this->idoperador
			));
	}
	public function updateToDatabase($id=0)
	{
		if($this->idoperador==""||$this->idoperador==0)
		{
			if($id>0)
				$this->idoperador=$id;
			else
				return false;
		}
		$data=array(
			"nombre"=>$this->nombre,
			"apaterno"=>$this->apaterno,
			"amaterno"=>$this->amaterno,
			"detalle"=>$this->detalle,
			"cargo"=>$this->cargo,
			"telefono"=>$this->telefono,
			"email"=>$this->email
		);
		$this->db->where('idoperador',$this->idoperador);
		$this->db->update('operador',$data);
		return true;
	}
	public function getAll($idsucursal=0)
	{
		if($idsucursal>0)
			$this->db->where("idoperador in (select idoperador from relsucope where idsucursal=$idsucursal)");
		$this->db->order_by('nombre asc,apaterno asc,amaterno asc');
		$regs=$this->db->get('operador');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function delete($id=0)
	{
		if($this->idoperador==""||$this->idoperador==0)
		{
			if($id>0)
				$this->idoperador=$id;
			else
				return false;
		}
		$this->db->where('idoperador',$this->idoperador);
		$this->db->delete(array('relrutope','relsucope','operador'));
	}
}
?>