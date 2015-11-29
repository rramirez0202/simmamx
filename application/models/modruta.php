<?php
class Modruta extends CI_Model
{
	private $idruta;
	private $nombre;
	private $descripcion;
	private $empresadestinofinal;
	private $empresatransportista;
	private $idsucursal;
	private $identificador;
	private $idoperador;
	private $idvehiculo;
	public function __construct()
	{
		parent::__construct();
		$this->idruta=0;
		$this->nombre="";
		$this->descripcion="";
		$this->empresadestinofinal=0;
		$this->empresatransportista=0;
		$this->idsucursal=0;
		$this->identificador="";
		$this->idoperador=0;
		$this->idvehiculo=0;
	}
	public function getIdruta() { return $this->idruta; }
	public function getNombre() { return $this->nombre; }
	public function getDescripcion() { return $this->descripcion; }
	public function getEmpresadestinofinal() { return $this->empresadestinofinal; }
	public function getEmpresatransportista() { return $this->empresatransportista; }
	public function getIdentificador() { return $this->identificador; }
	public function getIdsucursal() { return $this->idsucursal; }
	public function getIdoperador() { return $this->idoperador; }
	public function getIdvehiculo() { return $this->idvehiculo; }
	public function setIdruta($valor) { $this->idruta= intval($valor); }
	public function setNombre($valor) { $this->nombre= "".$valor; }
	public function setDescripcion($valor) { $this->descripcion= "".$valor; }
	public function setEmpresadestinofinal($valor) { $this->empresadestinofinal= intval($valor); }
	public function setEmpresatransportista($valor) { $this->empresatransportista= intval($valor); }
	public function setIdentificador($valor) { $this->identificador= "".$valor; }
	public function setIdsucursal($valor) { $this->idsucursal= intval($valor); }
	public function setIdoperador($valor) { $this->idoperador= intval($valor); }
	public function setIdvehiculo($valor) { $this->idvehiculo= intval($valor); }
	public function getFromDatabase($id=0)
	{
		if($this->idruta==""||$this->idruta==0)
		{
			if($id>0)
				$this->idruta=$id;
			else
				return false;
		}
		$this->db->where('idruta',$this->idruta);
		$regs=$this->db->get('ruta');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdruta($reg["idruta"]);
		$this->setNombre($reg["nombre"]);
		$this->setDescripcion($reg["descripcion"]);
		$this->setEmpresadestinofinal($reg["empresadestinofinal"]);
		$this->setEmpresatransportista($reg["empresatransportista"]);
		$this->setIdentificador($reg["identificador"]);
		$this->db->where('idruta',$this->idruta);
		$regs=$this->db->get('relsucrut');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdsucursal($reg["idsucursal"]);
		$this->db->where('idruta',$this->idruta);
		$regs=$this->db->get('relrutope');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdoperador($reg["idoperador"]);
		$this->db->where('idruta',$this->idruta);
		$regs=$this->db->get('relrutveh');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdvehiculo($reg["idvehiculo"]);
		return true;
	}
	public function getFromInput()
	{
		$this->setIdruta($this->input->post("frm_ruta_idruta"));
		$this->setNombre($this->input->post("frm_ruta_nombre"));
		$this->setDescripcion($this->input->post("frm_ruta_descripcion"));
		$this->setEmpresadestinofinal($this->input->post("frm_ruta_empresadestinofinal"));
		$this->setEmpresatransportista($this->input->post("frm_ruta_empresatransportista"));
		$this->setIdentificador($this->input->post("frm_ruta_identificador"));
		$this->setIdsucursal($this->input->post("frm_ruta_idsucursal"));
		$this->setIdentificador($this->input->post("frm_ruta_identificador"));
		$this->setIdoperador($this->input->post("frm_ruta_idoperador"));
		$this->setIdvehiculo($this->input->post("frm_ruta_idvehiculo"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"nombre"=>$this->nombre,
			"descripcion"=>$this->descripcion,
			"empresadestinofinal"=>$this->empresadestinofinal,
			"empresatransportista"=>$this->empresatransportista,
			"identificador"=>$this->identificador
		);
		$this->db->insert('ruta',$data);
		$this->setIdruta($this->db->insert_id());
		$this->db->insert('relsucrut',array(
			"idsucursal"=>$this->idsucursal,
			"idruta"=>$this->idruta
			));
		$this->db->insert('relrutope',array(
			"idruta"=>$this->idruta,
			"idoperador"=>$this->idoperador
			));
		$this->db->insert('relrutveh',array(
			"idruta"=>$this->idruta,
			"idvehiculo"=>$this->idvehiculo
			));
	}
	public function updateToDatabase($id=0)
	{
		if($this->idruta==""||$this->idruta==0)
		{
			if($id>0)
				$this->idruta=$id;
			else
				return false;
		}
		$data=array(
			"nombre"=>$this->nombre,
			"descripcion"=>$this->descripcion,
			"empresadestinofinal"=>$this->empresadestinofinal,
			"empresatransportista"=>$this->empresatransportista,
			"identificador"=>$this->identificador
		);
		$this->db->where('idruta',$this->idruta);
		$this->db->update('ruta',$data);
		$this->db->where('idruta',$this->idruta);
		$this->db->update('relrutope',array("idoperador"=>$this->idoperador));
		$this->db->where('idruta',$this->idruta);
		$this->db->update('relrutveh',array("idvehiculo"=>$this->idvehiculo));
		return true;
	}
	public function getAll($idsucursal=0)
	{
		if($idsucursal>0)
			$this->db->where("idruta in (select idruta from relsucrut where idsucursal=$idsucursal)");
		$this->db->order_by('nombre');
		$regs=$this->db->get('ruta');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function delete($id=0)
	{
		//Elimina la relacion con la bitacora pero la deja viva
		//Elimina la relacion con la sucursal pero la deja viva
		//Elimina la relacion con el manifiesto pero lo deja vivo
		//Elimina la relacion con el generador pero lo deja vivo
		//Elimina la relacion con el operador pero lo deja vivo
		//Elimina la relacion con el vehiculo pero lo deja vivo
		if($this->idruta==""||$this->idruta==0)
		{
			if($id>0)
				$this->idruta=$id;
			else
				return false;
		}
		$this->db->where('idruta',$this->idruta);
		$this->db->delete(array('relbitrut','relmanrut','relrutgen','relsucrut','relrutope','relrutveh','ruta'));
	}
	public function getGeneradoresAsociados($idruta)
	{
		$this->db->select('idgenerador');
		$this->db->where('idruta',$idruta);
		$regs=$this->db->get('relrutgen');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
}
?>