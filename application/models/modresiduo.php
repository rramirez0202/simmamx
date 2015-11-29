<?php
class ModResiduo extends CI_Model
{
	private $idresiduo;
	private $nombre;
	private $nom052;
	private $C;
	private $R;
	private $E;
	private $T;
	private $I;
	private $B;
	private $reportecoa;
	private $idsucursal;
	public function __construct()
	{
		parent::__construct();
		$this->idresiduo=0;
		$this->nombre="";
		$this->nom052="";
		$this->C=0;
		$this->R=0;
		$this->E=0;
		$this->T=0;
		$this->I=0;
		$this->B=0;
		$this->reportecoa=0;
		$this->idsucursal=0;
	}
	public function getIdresiduo() { return $this->idresiduo; }
	public function getNombre() { return $this->nombre; }
	public function getNom052() { return $this->nom052; }
	public function getC() { return $this->C; }
	public function getR() { return $this->R; }
	public function getE() { return $this->E; }
	public function getT() { return $this->T; }
	public function getI() { return $this->I; }
	public function getB() { return $this->B; }
	public function getReportecoa() { return $this->reportecoa; }
	public function getIdsucursal() { return $this->idsucursal; }
	public function setIdresiduo($valor) { $this->idresiduo= intval($valor); }
	public function setNombre($valor) { $this->nombre= "".$valor; }
	public function setNom052($valor) { $this->nom052= "".$valor; }
	public function setC($valor) { $this->C= intval($valor); }
	public function setR($valor) { $this->R= intval($valor); }
	public function setE($valor) { $this->E= intval($valor); }
	public function setT($valor) { $this->T= intval($valor); }
	public function setI($valor) { $this->I= intval($valor); }
	public function setB($valor) { $this->B= intval($valor); }
	public function setReportecoa($valor) { $this->reportecoa= intval($valor); }
	public function setIdsucursal($valor) { $this->idsucursal= intval($valor); }
	public function getFromDatabase($id=0)
	{
		if($this->idresiduo==""||$this->idresiduo==0)
		{
			if($id>0)
				$this->idresiduo=$id;
			else
				return false;
		}
		$this->db->where('idresiduo',$this->idresiduo);
		$regs=$this->db->get('residuo');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdresiduo($reg["idresiduo"]);
		$this->setNombre($reg["nombre"]);
		$this->setNom052($reg["nom052"]);
		$this->setC($reg["C"]);
		$this->setR($reg["R"]);
		$this->setE($reg["E"]);
		$this->setT($reg["T"]);
		$this->setI($reg["I"]);
		$this->setB($reg["B"]);
		$this->setReportecoa($reg["reportecoa"]);
		$this->db->where('idresiduo',$this->idresiduo);
		$regs=$this->db->get('relsucres');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdsucursal($reg["idsucursal"]);
		return true;
	}
	public function getFromInput()
	{
		$this->setIdresiduo($this->input->post("frm_residuo_idresiduo"));
		$this->setNombre($this->input->post("frm_residuo_nombre"));
		$this->setNom052($this->input->post("frm_residuo_nom052"));
		$this->setC($this->input->post("frm_residuo_c"));
		$this->setR($this->input->post("frm_residuo_r"));
		$this->setE($this->input->post("frm_residuo_e"));
		$this->setT($this->input->post("frm_residuo_t"));
		$this->setI($this->input->post("frm_residuo_i"));
		$this->setB($this->input->post("frm_residuo_b"));
		$this->setReportecoa($this->input->post("frm_residuo_reportecoa"));
		$this->setIdsucursal($this->input->post("frm_residuo_idsucursal"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"nombre"=>$this->nombre,
			"nom052"=>$this->nom052,
			"C"=>$this->C,
			"R"=>$this->R,
			"E"=>$this->E,
			"T"=>$this->T,
			"I"=>$this->I,
			"B"=>$this->B,
			"reportecoa"=>$this->reportecoa
		);
		$this->db->insert('residuo',$data);
		$this->setIdresiduo($this->db->insert_id());
		$this->db->insert('relsucres',array(
			"idsucursal"=>$this->idsucursal,
			"idresiduo"=>$this->idresiduo
		));
	}
	public function updateToDatabase($id=0)
	{
		if($this->idresiduo==""||$this->idresiduo==0)
		{
			if($id>0)
				$this->idresiduo=$id;
			else
				return false;
		}
		$data=array(
			"nombre"=>$this->nombre,
			"nom052"=>$this->nom052,
			"C"=>$this->C,
			"R"=>$this->R,
			"E"=>$this->E,
			"T"=>$this->T,
			"I"=>$this->I,
			"B"=>$this->B,
			"reportecoa"=>$this->reportecoa
		);
		$this->db->where('idresiduo',$this->idresiduo);
		$this->db->update('residuo',$data);
		return true;
	}
	public function getAll($idsucursal=0)
	{
		if($idsucursal>0)
			$this->db->where("idresiduo in (select idresiduo from relsucres where idsucursal = $idsucursal)");
		$this->db->order_by('nombre');
		$regs=$this->db->get('residuo');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function delete($id=0)
	{
		//Elimina la relacion con la sucursal pero la deja viva
		//Elimina la relacion con la recoleccion pero la deja viva
		if($this->idresiduo==""||$this->idresiduo==0)
		{
			if($id>0)
				$this->idresiduo=$id;
			else
				return false;
		}
		$this->db->where('idresiduo',$this->idresiduo);
		$this->db->delete(array('relsucres','residuo'));
	}
	public function set($idResiduo,$nombre,$nom052,$c,$r,$e,$t,$i,$b,$reportecoa,$idSucursal)
	{
		$this->setIdresiduo($idResiduo);
		$this->setNombre($nombre);
		$this->setNom052($nom052);
		$this->setC($c);
		$this->setR($r);
		$this->setE($e);
		$this->setT($t);
		$this->setI($i);
		$this->setB($b);
		$this->setReportecoa($reportecoa);
		$this->setIdsucursal($idSucursal);
	}
}
?>