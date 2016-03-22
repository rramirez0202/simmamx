<?php
class Modgrupo extends CI_Model
{
	private $idgrupo;
	private $nombre;
	private $descripcion;
	private $usuarios;
	private $clientes;
	private $sucursales;
	private $clientescompleto;
	private $generadores;
	private $generadorescompleto;
	public function __construct()
	{
		parent::__construct();
		$this->idgrupo=0;
		$this->nombre="";
		$this->descripcion="";
		$this->usuarios=array();
		$this->clientes=array();
		$this->sucursales=array();
		$this->clientescompleto=array();
		$this->generadores=array();
		$this->generadorescompleto=array();
	}
	public function getIdgrupo() { return $this->idgrupo; }
	public function getNombre() { return $this->nombre; }
	public function getDescripcion() { return $this->descripcion; }
	public function getUsuarios() { return $this->usuarios; }
	public function getClientes() { return $this->clientes; }
	public function getSucursales() { return $this->sucursales; }
	public function getClientescompleto() { return $this->clientescompleto; }
	public function getGeneradores() { return $this->generadores; }
	public function getGeneradorescompleto() { return $this->generadorescompleto; }
	public function setIdgrupo($valor) { $this->idgrupo= intval($valor); }
	public function setNombre($valor) { $this->nombre= "".$valor; }
	public function setDescripcion($valor) { $this->descripcion= "".$valor; }
	public function setUsuarios($valor) { if(is_array($valor)) $this->usuarios=$valor; else array_push($this->usuarios,$valor); }
	public function setClientes($valor) { if(is_array($valor)) $this->clientes=$valor; else array_push($this->clientes,$valor); }
	public function setSucursales($valor) { if(is_array($valor)) $this->sucursales=$valor; else array_push($this->sucursales,$valor); }
	public function setClientescompleto($valor) { if(is_array($valor)) $this->clientescompleto=$valor; else array_push($this->clientescompleto,$valor); }
	public function setGeneradores($valor) { if(is_array($valor)) $this->generadores=$valor; else array_push($this->generadores,$valor); }
	public function setGeneradorescompleto($valor) { if(is_array($valor)) $this->generadorescompleto=$valor; else array_push($this->generadorescompleto,$valor); }
	public function getFromDatabase($id=0)
	{
		if($this->idgrupo==""||$this->idgrupo==0)
		{
			if($id>0)
				$this->idgrupo=$id;
			else
				return false;
		}
		$this->db->where('idgrupo',$this->idgrupo);
		$regs=$this->db->get('grupo');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdgrupo($reg["idgrupo"]);
		$this->setNombre($reg["nombre"]);
		$this->setDescripcion($reg["descripcion"]);
		$this->setUsuarios(array());
		$this->db->where('idgrupo',$this->idgrupo);
		$regs=$this->db->get('relgruusu');
		if($regs->num_rows()>0) 
			foreach($regs->result_array() as $reg) 
				if($reg["idusuario"]>0)
					$this->setUsuarios($reg["idusuario"]);
		$this->setClientes(array());
		$this->db->where('idgrupo',$this->idgrupo);
		$regs=$this->db->get('relgrucli');
		if($regs->num_rows()>0) 
			foreach($regs->result_array() as $reg) 
				if($reg["idcliente"]>0)
					$this->setClientes($reg["idcliente"]);
		$this->setSucursales(array());
		$this->db->where('idgrupo',$this->idgrupo);
		$regs=$this->db->get('relgrusuc');
		if($regs->num_rows()>0) 
			foreach($regs->result_array() as $reg) 
				if($reg["idsucursal"]>0)
					$this->setSucursales($reg["idsucursal"]);
		$this->setClientescompleto($this->clientes);
		if(count($this->sucursales)>0)
		{
			$this->db->where("idsucursal in (".implode(",",$this->sucursales).")");
			$regs=$this->db->get("relsuccli");
			if($regs->num_rows()>0) 
				foreach($regs->result_array() as $reg)
					if($reg["idcliente"]>0 && !in_array($reg["idcliente"],$this->clientescompleto))
						$this->setClientescompleto($reg["idcliente"]);
		}
		$this->setGeneradores(array());
		$this->db->where('idgrupo',$this->idgrupo);
		$regs=$this->db->get('relgrugen');
		if($regs->num_rows()>0) 
			foreach($regs->result_array() as $reg) 
				if($reg["idgenerador"]>0)
					$this->setGeneradores($reg["idgenerador"]);
		$this->setGeneradorescompleto($this->generadores);
		if(count($this->clientescompleto)>0)
		{
			$this->db->where("idcliente in (".implode(",",$this->clientescompleto).")");
			$regs=$this->db->get("relcligen");
			if($regs->num_rows()>0)
				foreach($regs->result_array() as $reg)
					if($reg["idgenerador"]>0 && !in_array($reg["idgenerador"],$this->generadorescompleto))
						$this->setGeneradorescompleto($reg["idgenerador"]);
		}
		return true;
	}
	public function getFromInput()
	{
		$this->setIdgrupo($this->input->post("frm_grupo_idgrupo"));
		$this->setNombre($this->input->post("frm_grupo_nombre"));
		$this->setDescripcion($this->input->post("frm_grupo_descripcion"));
		$this->setUsuarios(explode(",",$this->input->post("frm_grupo_usuarios")));
		$this->setClientes(explode(",",$this->input->post("frm_grupo_clientes")));
		$this->setSucursales(explode(",",$this->input->post("frm_grupo_sucursales")));
		$this->setGeneradores(explode(",",$this->input->post("frm_grupo_generadores")));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"nombre"=>$this->nombre,
			"descripcion"=>$this->descripcion
		);
		$this->db->insert('grupo',$data);
		$this->setIdgrupo($this->db->insert_id());
		if(is_array($this->clientes) && count($this->clientes)>0) foreach($this->clientes as $reg) if($reg>0)
			$this->db->insert('relgrucli',array(
				"idcliente"=>$reg,
				"idgrupo"=>$this->idgrupo
			));
		if(is_array($this->sucursales) && count($this->sucursales)>0) foreach($this->sucursales as $reg) if($reg>0)
			$this->db->insert('relgrusuc',array(
				"idsucursal"=>$reg,
				"idgrupo"=>$this->idgrupo
			));
		if(is_array($this->generadores) && count($this->generadores)>0) foreach($this->generadores as $reg) if($reg>0)
			$this->db->insert('relgrugen',array(
				"idgenerador"=>$reg,
				"idgrupo"=>$this->idgrupo
			));
	}
	public function updateToDatabase($id=0)
	{
		if($this->idgrupo==""||$this->idgrupo==0)
		{
			if($id>0)
				$this->idgrupo=$id;
			else
				return false;
		}
		$data=array(
			"nombre"=>$this->nombre,
			"descripcion"=>$this->descripcion
		);
		$this->db->where('idgrupo',$this->idgrupo);
		$this->db->update('grupo',$data);
		$this->db->where('idgrupo',$this->idgrupo);
		$this->db->delete('relgrugen');
		$this->db->where('idgrupo',$this->idgrupo);
		$this->db->delete('relgrucli');
		$this->db->where('idgrupo',$this->idgrupo);
		$this->db->delete('relgrusuc');
		if(is_array($this->clientes) && count($this->clientes)>0) foreach($this->clientes as $reg) if($reg>0)
			$this->db->insert('relgrucli',array(
				"idcliente"=>$reg,
				"idgrupo"=>$this->idgrupo
			));
		if(is_array($this->sucursales) && count($this->sucursales)>0) foreach($this->sucursales as $reg) if($reg>0)
			$this->db->insert('relgrusuc',array(
				"idsucursal"=>$reg,
				"idgrupo"=>$this->idgrupo
			));
		if(is_array($this->generadores) && count($this->generadores)>0) foreach($this->generadores as $reg) if($reg>0)
			$this->db->insert('relgrugen',array(
				"idgenerador"=>$reg,
				"idgrupo"=>$this->idgrupo
			));
		return true;
	}
	public function getAll()
	{
		$this->db->order_by('nombre');
		$regs=$this->db->get('grupo');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function delete($id=0)
	{
		//Elimina la relacion con cliente pero le deja vivo
		//Elimina la relacion con usuario pero le deja vivo
		//Elimina la relacion con sucursal pero le deja vivo
		if($this->idgrupo==""||$this->idgrupo==0)
		{
			if($id>0)
				$this->idgrupo=$id;
			else
				return false;
		}
		$this->db->where('idgrupo',$this->idgrupo);
		$this->db->delete(array('relgruusu','relgrusuc','relgrucli','grupo'));
	}
}
?>