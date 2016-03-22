<?php
class Modusuario extends CI_Model
{
	private $idusuario;
	private $nombre;
	private $apaterno;
	private $amaterno;
	private $usuario;
	private $password;
	private $perfiles;
	private $email;
	private $activo;
	private $grupos;
	public function __construct()
	{
		parent::__construct();
		$this->idusuario=0;
		$this->nombre="";
		$this->apaterno="";
		$this->amaterno="";
		$this->usuario="";
		$this->password="";
		$this->perfiles=array();
		$this->email="";
		$this->activo=0;
		$this->grupos=array();
	}
	public function getIdusuario() { return $this->idusuario; }
	public function getNombre() { return $this->nombre; }
	public function getApaterno() { return $this->apaterno; }
	public function getAmaterno() { return $this->amaterno; }
	public function getUsuario() { return $this->usuario; }
	public function getPassword() { return $this->password; }
	public function getPerfiles() { return $this->perfiles; }
	public function getEmail() { return $this->email; }
	public function getActivo() { return $this->activo; }
	public function getGrupos() { return $this->grupos; }
	public function setIdusuario($valor) { $this->idusuario= intval($valor); }
	public function setNombre($valor) { $this->nombre= "".$valor; }
	public function setApaterno($valor) { $this->apaterno= "".$valor; }
	public function setAmaterno($valor) { $this->amaterno= "".$valor; }
	public function setUsuario($valor) { $this->usuario= "".$valor; }
	public function setPassword($valor) { $this->password= "".$valor; }
	public function setPerfiles($valor) { if(is_array($valor)) $this->perfiles=$valor; else array_push($this->perfiles,$valor); }
	public function setEmail($valor) { $this->email= "".$valor; }
	public function setActivo($valor) { $this->activo= intval($valor); }
	public function setGrupos($valor) { if(is_array($valor)) $this->grupos=$valor; else array_push($this->grupos,$valor); }
	public function getFromDatabase($id=0)
	{
		if($this->idusuario==""||$this->idusuario==0)
		{
			if($id>0)
				$this->idusuario=$id;
			else
				return false;
		}
		$this->db->where('idusuario',$this->idusuario);
		$regs=$this->db->get('usuario');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdusuario($reg["idusuario"]);
		$this->setNombre($reg["nombre"]);
		$this->setApaterno($reg["apaterno"]);
		$this->setAmaterno($reg["amaterno"]);
		$this->setUsuario($reg["usuario"]);
		$this->setPassword($reg["password"]);
		$this->setEmail($reg["email"]);
		$this->setActivo($reg["activo"]);
		$this->db->where('idusuario',$this->idusuario);
		$regs=$this->db->get('relperusu');
		if($regs->num_rows()>0)
		{
			$regs=$regs->result_array();
			foreach($regs as $reg)
				$this->setPerfiles($reg["idperfil"]);
		}
		else $this->setPerfiles(array());
		$this->db->where('idusuario',$this->idusuario);
		$regs=$this->db->get('relgruusu');
		if($regs->num_rows()>0)
		{
			$regs=$regs->result_array();
			foreach($regs as $reg)
				$this->setGrupos($reg["idgrupo"]);
		}
		else $this->setGrupos(array());
		return true;
	}
	public function getFromInput()
	{
		$this->setIdusuario($this->input->post("frm_usuario_idusuario"));
		$this->setNombre($this->input->post("frm_usuario_nombre"));
		$this->setApaterno($this->input->post("frm_usuario_apaterno"));
		$this->setAmaterno($this->input->post("frm_usuario_amaterno"));
		$this->setUsuario($this->input->post("frm_usuario_usuario"));
		$this->setPassword($this->input->post("frm_usuario_password"));
		$this->setPerfiles($this->input->post("frm_usuario_perfiles"));
		$this->setEmail($this->input->post("frm_usuario_email"));
		$this->setActivo($this->input->post("frm_usuario_activo"));
		$this->setGrupos($this->input->post("frm_usuario_grupos"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"nombre"=>$this->nombre,
			"apaterno"=>$this->apaterno,
			"amaterno"=>$this->amaterno,
			"usuario"=>$this->usuario,
			"password"=>$this->password,
			"email"=>$this->email,
			"activo"=>$this->activo
		);
		$this->db->insert('usuario',$data);
		$this->setIdusuario($this->db->insert_id());
		if(is_array($this->perfiles) && count($this->perfiles)>0) foreach($this->perfiles as $reg) if($reg>0)
			$this->db->insert('relperusu',array(
				"idperfil"=>$reg,
				"idusuario"=>$this->idusuario
			));
		if(is_array($this->grupos) && count($this->grupos)>0) foreach($this->grupos as $reg) if($reg>0)
			$this->db->insert('relgruusu',array(
				"idgrupo"=>$reg,
				"idusuario"=>$this->idusuario
			));
	}
	public function updateToDatabase($id=0)
	{
		if($this->idusuario==""||$this->idusuario==0)
		{
			if($id>0)
				$this->idusuario=$id;
			else
				return false;
		}
		$data=array(
			"nombre"=>$this->nombre,
			"apaterno"=>$this->apaterno,
			"amaterno"=>$this->amaterno,
			"usuario"=>$this->usuario,
			"email"=>$this->email,
			"activo"=>$this->activo
		);
		$this->db->where('idusuario',$this->idusuario);
		$this->db->update('usuario',$data);
		$this->db->where('idusuario',$this->idusuario);
		$this->db->delete('relperusu');
		if(is_array($this->perfiles) && count($this->perfiles)>0) foreach($this->perfiles as $reg) if($reg>0)
			$this->db->insert('relperusu',array(
				"idperfil"=>$reg,
				"idusuario"=>$this->idusuario
			));
		$this->db->where('idusuario',$this->idusuario);
		$this->db->delete('relgruusu');
		if(is_array($this->grupos) && count($this->grupos)>0) foreach($this->grupos as $reg) if($reg>0)
			$this->db->insert('relgruusu',array(
				"idgrupo"=>$reg,
				"idusuario"=>$this->idusuario
			));
		return true;
	}
	public function getAll()
	{
		$this->db->order_by('nombre');
		$regs=$this->db->get('usuario');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function delete($id=0)
	{
		//Elimina la relacion con el perfil y grupo pero lo deja vivo
		if($this->idusuario==""||$this->idusuario==0)
		{
			if($id>0)
				$this->idusuario=$id;
			else
				return false;
		}
		$this->db->where('idusuario',$this->idusuario);
		$this->db->delete(array('relgruusu','relperusu','usuario'));
	}
	public function generaPassword()
	{
		if($this->idusuario==""||$this->idusuario==0)
			return false;
		$pwd="";
		while(strlen($pwd)<10)
		{
			switch(rand(1,3))
			{
				case 1:
					$pwd.=chr(rand(48,57));
					break;
				case 2:
					$pwd.=chr(rand(65,90));
					break;
				case 3:
					$pwd.=chr(rand(97,122));
					break;
			}
		}
		$this->updatePassword($pwd);
		return $pwd;
	}
	public function updatePassword($pwd)
	{
		$this->load->library('encrypt');
		if($this->idusuario==""||$this->idusuario==0)
			return false;
		$this->password=$this->encrypt->sha1($pwd);
		$data=array(
			"password"=>$this->password
		);
		$this->db->where('idusuario',$this->idusuario);
		$this->db->update('usuario',$data);
	}
}
?>