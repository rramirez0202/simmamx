<?php
class Modperfil extends CI_Model
{
	private $idperfil;
	private $nombre;
	private $observaciones;
	private $sucursales;
	private $permisos;
	public function __construct()
	{
		parent::__construct();
		$this->idperfil=0;
		$this->nombre="";
		$this->observaciones="";
		$this->sucursales=array();
		$this->permisos=array();
	}
	public function getIdperfil() { return $this->idperfil; }
	public function getNombre() { return $this->nombre; }
	public function getObservaciones() { return $this->observaciones; }
	public function getSucursales() { return $this->sucursales; }
	public function getPermisos() { return $this->permisos; }
	public function setIdperfil($valor) { $this->idperfil= intval($valor); }
	public function setNombre($valor) { $this->nombre= "".$valor; }
	public function setObservaciones($valor) { $this->observaciones= "".$valor; }
	public function setSucursales($valor) { if(is_array($valor)) $this->sucursales=$valor; else array_push($this->sucursales,$valor); }
	public function setPermisos($valor) { if(is_array($valor)) $this->permisos=$valor; else array_push($this->permisos,$valor); }
	public function getFromDatabase($id=0)
	{
		if($this->idperfil==""||$this->idperfil==0)
		{
			if($id>0)
				$this->idperfil=$id;
			else
				return false;
		}
		$this->db->where('idperfil',$this->idperfil);
		$regs=$this->db->get('perfil');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setNombre($reg["nombre"]);
		$this->setObservaciones($reg["observaciones"]);
		$this->db->where('idperfil',$this->idperfil);
		$regs=$this->db->get('relpersuc');
		if($regs->num_rows()>0)
		{
			$regs=$regs->result_array();
			foreach($regs as $reg)
				$this->setSucursales($reg["idsucursal"]);
		}
		else $this->setSucursales(array());
		$this->db->where('idperfil',$this->idperfil);
		$regs=$this->db->get('relpermperf');
		if($regs->num_rows()>0)
		{
			$regs=$regs->result_array();
			foreach($regs as $reg)
				$this->setPermisos($reg["idpermiso"]);
		}
		else $this->setPermisos(array());
		return true;
	}
	public function getFromInput()
	{
		$this->setIdperfil($this->input->post("frm_perfil_idperfil"));
		$this->setNombre($this->input->post("frm_perfil_nombre"));
		$this->setObservaciones($this->input->post("frm_perfil_observaciones"));
		$this->setSucursales($this->input->post("frm_perfil_sucursales"));
		$this->setPermisos($this->input->post("frm_perfil_permisos"));
	}
	public function addToDatabase()
	{
		$data=array(
			"nombre"=>$this->nombre,
			"observaciones"=>$this->observaciones
		);
		$this->db->insert('perfil',$data);
		$this->setIdperfil($this->db->insert_id());
		foreach($this->sucursales as $reg) if($reg>0)
			$this->db->insert('relpersuc',array(
				"idperfil"=>$this->idperfil,
				"idsucursal"=>$reg
			));
		foreach($this->permisos as $reg) if($reg>0)
			$this->db->insert('relpermperf',array(
				"idperfil"=>$this->idperfil,
				"idpermiso"=>$reg
			));
	}
	public function updateToDatabase($id=0)
	{
		if($this->idperfil==""||$this->idperfil==0)
		{
			if($id>0)
				$this->idperfil=$id;
			else
				return false;
		}
		$data=array(
			"nombre"=>$this->nombre,
			"observaciones"=>$this->observaciones
		);
		$this->db->where('idperfil',$this->idperfil);
		$this->db->update('perfil',$data);
		$this->db->where('idperfil',$this->idperfil);
		$this->db->delete('relpersuc');
		foreach($this->sucursales as $reg) if($reg>0)
			$this->db->insert('relpersuc',array(
				"idperfil"=>$this->idperfil,
				"idsucursal"=>$reg
			));
		$this->db->where('idperfil',$this->idperfil);
		$this->db->delete('relpermperf');
		foreach($this->permisos as $reg) if($reg>0)
			$this->db->insert('relpermperf',array(
				"idperfil"=>$this->idperfil,
				"idpermiso"=>$reg
			));
		return true;
	}
	public function getAll()
	{
		$this->db->order_by('nombre');
		$regs=$this->db->get('perfil');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function delete($id=0)
	{
		//Elimina la relacion con el permiso pero lo deja vivo
		//Elimina la relacion con el usuario pero lo deja vivo
		//Elimina la relacion con la sucursal pero la deja viva
		if($this->idperfil==""||$this->idperfil==0)
		{
			if($id>0)
				$this->idperfil=$id;
			else
				return false;
		}
		$this->db->where('idperfil',$this->idperfil);
		$this->db->delete(array('relpermperf','relpersuc','relperusu','perfil'));
	}
}
?>