<?php
class Modvehiculo extends CI_Model
{
	private $idvehiculo;
	private $detalle;
	private $tipo;
	private $placa;
	private $numautsct;
	private $idsucursal;
	private $autsemarnat;
	public function __construct()
	{
		parent::__construct();
		$this->idvehiculo=0;
		$this->detalle="";
		$this->tipo="";
		$this->placa="";
		$this->numautsct="";
		$this->idsucursal=0;
		$this->autsemarnat="";
	}
	public function getIdvehiculo() { return $this->idvehiculo; }
	public function getDetalle() { return $this->detalle; }
	public function getTipo() { return $this->tipo; }
	public function getPlaca() { return $this->placa; }
	public function getNumautsct() { return $this->numautsct; }
	public function getIdsucursal() { return $this->idsucursal; }
	public function getAutsemarnat() { return $this->autsemarnat; }
	public function setIdvehiculo($valor) { $this->idvehiculo= intval($valor); }
	public function setDetalle($valor) { $this->detalle= "".$valor; }
	public function setTipo($valor) { $this->tipo= "".$valor; }
	public function setPlaca($valor) { $this->placa= "".$valor; }
	public function setNumautsct($valor) { $this->numautsct= "".$valor; }
	public function setIdsucursal($valor) { $this->idsucursal= intval($valor); }
	public function setAutsemarnat($valor) { $this->autsemarnat= "".$valor; }
	public function getFromDatabase($id=0)
	{
		if($this->idvehiculo==""||$this->idvehiculo==0)
		{
			if($id>0)
				$this->idvehiculo=$id;
			else
				return false;
		}
		$this->db->where('idvehiculo',$this->idvehiculo);
		$regs=$this->db->get('vehiculo');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdvehiculo($reg["idvehiculo"]);
		$this->setDetalle($reg["detalle"]);
		$this->setTipo($reg["tipo"]);
		$this->setPlaca($reg["placa"]);
		$this->setNumautsct($reg["numautsct"]);
		$this->setAutsemarnat($reg["autsemarnat"]);
		$this->db->where('idvehiculo',$this->idvehiculo);
		$regs=$this->db->get('relsucveh');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdsucursal($reg["idsucursal"]);
		return true;
	}
	public function getFromInput()
	{
		$this->setIdvehiculo($this->input->post("frm_vehiculo_idvehiculo"));
		$this->setDetalle($this->input->post("frm_vehiculo_detalle"));
		$this->setTipo($this->input->post("frm_vehiculo_tipo"));
		$this->setPlaca($this->input->post("frm_vehiculo_placa"));
		$this->setNumautsct($this->input->post("frm_vehiculo_numautsct"));
		$this->setIdsucursal($this->input->post("frm_vehiculo_idsucursal"));
		$this->setAutsemarnat($this->input->post("frm_vehiculo_autsemarnat"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"detalle"=>$this->detalle,
			"tipo"=>$this->tipo,
			"placa"=>$this->placa,
			"numautsct"=>$this->numautsct,
			"autsemarnat"=>$this->autsemarnat
		);
		$this->db->insert('vehiculo',$data);
		$this->setIdvehiculo($this->db->insert_id());
		$this->db->insert('relsucveh',array(
			"idsucursal"=>$this->idsucursal,
			"idvehiculo"=>$this->idvehiculo
			));
	}
	public function updateToDatabase($id=0)
	{
		if($this->idvehiculo==""||$this->idvehiculo==0)
		{
			if($id>0)
				$this->idvehiculo=$id;
			else
				return false;
		}
		$data=array(
			"detalle"=>$this->detalle,
			"tipo"=>$this->tipo,
			"placa"=>$this->placa,
			"numautsct"=>$this->numautsct,
			"autsemarnat"=>$this->autsemarnat
		);
		$this->db->where('idvehiculo',$this->idvehiculo);
		$this->db->update('vehiculo',$data);
		return true;
	}
	public function getAll($idsucursal=0)
	{
		if($idsucursal>0)
			$this->db->where("idvehiculo in (select idvehiculo from relsucveh where idsucursal=$idsucursal)");
		$this->db->order_by('placa');
		$regs=$this->db->get('vehiculo');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function delete($id=0)
	{
		//Elimina la relacion con la sucursal pero la deja viva
		//Elimina la relacion con la ruta pero la deja viva
		if($this->idvehiculo==""||$this->idvehiculo==0)
		{
			if($id>0)
				$this->idvehiculo=$id;
			else
				return false;
		}
		$this->db->where('idvehiculo',$this->idvehiculo);
		$this->db->delete(array('relrutveh','relsucveh','vehiculo'));
	}
}
?>