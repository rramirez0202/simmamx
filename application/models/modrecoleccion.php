<?php
class Modrecoleccion extends CI_Model
{
	private $idrecoleccion;
	private $contenedorcapacidad;
	private $contenedortipo;
	private $cantidad;
	private $unidad;
	private $idresiduo;
	private $idmanifiesto;
	public function __constructor()
	{
		parent::__construct();
		$this->idrecoleccion=0;
		$this->contenedorcapacidad="";
		$this->contenedortipo="";
		$this->cantidad="";
		$this->unidad="";
		$this->idresiduo=0;
		$this->idmanifiesto=0;
	}
	public function getIdrecoleccion() { return $this->idrecoleccion; }
	public function getContenedorcapacidad() { return $this->contenedorcapacidad; }
	public function getContenedortipo() { return $this->contenedortipo; }
	public function getCantidad() { return $this->cantidad; }
	public function getUnidad() { return $this->unidad; }
	public function getIdresiduo() { return $this->idresiduo; }
	public function getIdmanifiesto() { return $this->idmanifiesto; }
	public function setIdrecoleccion($valor) { $this->idrecoleccion= intval($valor); }
	public function setContenedorcapacidad($valor) { $this->contenedorcapacidad= "".$valor; }
	public function setContenedortipo($valor) { $this->contenedortipo= "".$valor; }
	public function setCantidad($valor) { $this->cantidad= "".$valor; }
	public function setUnidad($valor) { $this->unidad= "".$valor; }
	public function setIdresiduo($valor) { $this->idresiduo= intval($valor); }
	public function setIdmanifiesto($valor) { $this->idmanifiesto= intval($valor); }
    public function getFromDatabase($id=0)
	{
		if($this->idrecoleccion==""||$this->idrecoleccion==0)
		{
			if($id>0)
				$this->idrecoleccion=$id;
			else
				return false;
		}
		$this->db->where('idrecoleccion',$this->idrecoleccion);
		$regs=$this->db->get('recoleccion');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdrecoleccion($reg["idrecoleccion"]);
		$this->setContenedorcapacidad($reg["contenedorcapacidad"]);
		$this->setContenedortipo($reg["contenedortipo"]);
		$this->setCantidad($reg["cantidad"]);
		$this->setUnidad($reg["unidad"]);
		$this->db->where('idrecoleccion',$this->idrecoleccion);
		$regs=$this->db->get('relresrec');
		if($regs->num_rows()>0)
		{
			$reg=$regs->row_array();
			$this->setIdresiduo($reg["idresiduo"]);
		}
		$this->db->where('idrecoleccion',$this->idrecoleccion);
		$regs=$this->db->get('relmanrec');
		if($regs->num_rows()>0)
		{
			$reg=$regs->row_array();
			$this->setIdmanifiesto($reg["idmanifiesto"]);
		}
		return true;
	}
	public function getFromInput()
	{
		$this->setIdrecoleccion($this->input->post("frm_recoleccion_idrecoleccion"));
		$this->setContenedorcapacidad($this->input->post("frm_recoleccion_contenedorcapacidad"));
		$this->setContenedortipo($this->input->post("frm_recoleccion_contenedortipo"));
		$this->setCantidad($this->input->post("frm_recoleccion_cantidad"));
		$this->setUnidad($this->input->post("frm_recoleccion_unidad"));
		$this->setIdresiduo($this->input->post("frm_recoleccion_idresiduo"));
		$this->setIdmanifiesto($this->input->post("frm_recoleccion_idmanifiesto"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"contenedorcapacidad"=>$this->contenedorcapacidad,
			"contenedortipo"=>$this->contenedortipo,
			"cantidad"=>$this->cantidad,
			"unidad"=>$this->unidad
		);
		$this->db->insert('recoleccion',$data);
		$this->setIdrecoleccion($this->db->insert_id());
		$this->db->insert('relmanrec',array(
			'idmanifiesto'=>$this->idmanifiesto,
			'idrecoleccion'=>$this->idrecoleccion
		));
		$this->db->insert('relresrec',array(
			'idresiduo'=>$this->idresiduo,
			'idrecoleccion'=>$this->idrecoleccion
		));
	}
	public function updateToDatabase()
	{
		if($this->idrecoleccion==""||$this->idrecoleccion==0)
		{
			return false;
		}
		$data=array(
			"contenedorcapacidad"=>$this->contenedorcapacidad,
			"contenedortipo"=>$this->contenedortipo,
			"cantidad"=>$this->cantidad,
			"unidad"=>$this->unidad
		);
	}
	public function delete($id=0)
	{
		//Elimina la relacion con el residuo pero lo deja vivo
		//Elimina la relacion con el manifiesto pero lo deja vivo
		if($this->idrecoleccion==""||$this->idrecoleccion==0)
		{
			if($id>0)
				$this->idrecoleccion=$id;
			else
				return false;
		}
		$this->db->where('idrecoleccion',$this->idrecoleccion);
		$this->db->delete(array('relresrec','relmanrec','recoleccion'));
		return true;
	}
	public function getAll($idmanifiesto)
	{
		$this->db->where("idrecoleccion in (select idrecoleccion from relmanrec where idmanifiesto=$idmanifiesto)");
		$regs=$this->db->get('recoleccion');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getRecoleccionWithIdResiduo($idmanifiesto,$idresiduo)
	{
		$this->db->where("idrecoleccion in (select idrecoleccion from relresrec where idresiduo = $idresiduo) and idrecoleccion in (select idrecoleccion from relmanrec where idmanifiesto =  $idmanifiesto)");
		$regs=$this->db->get("recoleccion");
		if($regs->num_rows()==0)
			return false;
		return $regs->row_array();
	}
}
?>
