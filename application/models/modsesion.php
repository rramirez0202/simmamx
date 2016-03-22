<?php
class Modsesion extends CI_Model
{
	private $perfiles;
	private $grupos;
	private $allctes;
	private $allgens;
	public function __construct()
	{
		parent::__construct();
		$this->perfiles=array();
		$this->grupos=array();
		$this->allctes=array();
		$this->allgens=array();
	}
	public function getAcceso($usr,$pwd)
	{
		$pwd=$this->encrypt->sha1($pwd);
		$this->db->where(array("usuario"=>$usr,"password"=>$pwd,"activo"=>1));
		$regs=$this->db->get('usuario');
		if($regs->num_rows()==0)
			return false;
		return $regs->row_array();
	}
	public function getdata($usr)
	{
		$this->db->where(array("usuario"=>$usr,"activo"=>1));
		$regs=$this->db->get('usuario');
		if($regs->num_rows()==0)
			return false;
		return $regs->row_array();
	}
	public function logedin()
	{
		$insession=(!($this->session->userdata('idusuario')===false));
		if($insession)
		{
			$this->getPerfiles();
			$this->getGrupos();
		}
		return $insession;
	}
	private function getGrupos()
	{
		$this->load->model('modusuario');
		$this->load->model('modgrupo');
		$musuario=new Modusuario();
		$musuario->getFromDatabase($this->session->userdata('idusuario'));
		$this->grupos=array();
		$this->allctes=array();
		$this->allgens=array();
		foreach($musuario->getGrupos() as $gpo)
		{
			$grupo=new Modgrupo();
			$grupo->getFromDatabase($gpo);
			array_push($this->grupos,array(
				"idgrupo"=>$grupo->getIdgrupo(),
				"nombre"=>$grupo->getNombre(),
				"ctes"=>$grupo->getClientes(),
				"sucs"=>$grupo->getSucursales(),
				"allctes"=>$grupo->getClientescompleto(),
				"allgens"=>$grupo->getGeneradorescompleto()
			));
			foreach($grupo->getClientescompleto() as $cte)
				if(!in_array($cte,$this->allctes))
					array_push($this->allctes,$cte);
			foreach($grupo->getGeneradorescompleto() as $gen)
				if(!in_array($gen,$this->allgens))
					array_push($this->allgens,$gen);
		}
		sort($this->allctes);
	}
	public function hasGroup($idgrupo=0)
	{
		if($idgrupo==0)
			return (count($this->grupos)>0);
		if(!is_array($idgrupo))
			$idgrupo=array($idgrupo);
		foreach($idgrupo as $gpo)
			foreach($this->grupos as $g)
				if($g["idgrupo"]==$idgrupo)
					return true;
		return false;
	}
	private function getPerfiles()
	{
		$this->load->model('modusuario');
		$this->load->model('modperfil');
		$this->load->model('modpermiso');
		$musuario=new Modusuario();
		$musuario->getFromDatabase($this->session->userdata('idusuario'));
		$this->perfiles=array();
		foreach($musuario->getPerfiles() as $perf)
		{
			$perfil=new Modperfil();
			$perfil->getFromDatabase($perf);
			array_push($this->perfiles,array(
				"idperfil"		=> $perf,
				"sucursales"	=> $perfil->getSucursales(),
				"permisos"		=> $perfil->getPermisos()
			));
		}
	}
	public function hasPermiso($idpermiso)
	{
		if(!is_array($idpermiso))
			$idpermiso=array($idpermiso);
		foreach($idpermiso as $perm)
			foreach($this->perfiles as $perf)
			{
				if(in_array($perm,$perf["permisos"]))
					return true;
			}
		return false;
	}
	public function hasPermisoHijo($idpermiso)
	{
		return $this->hasPermiso(explode(",",$this->permisosHijo($idpermiso)));
	}
	private function permisosHijo($idpermiso)
	{
		$permisos=$idpermiso."";
		$this->load->model('modpermiso');
		$permiso=new Modpermiso();
		$permiso->getFromDatabase($idpermiso);
		if($permiso->getPermisoshijo()!==false)
			foreach($permiso->getPermisoshijo() as $p)
				$permisos.=",".$this->permisosHijo($p);
		return $permisos;
	}
	public function addLog($accion,$objetoid,$objetonombre,$tablabase,$tablasreferencia)
	{
		$this->load->model('modlog');
		$this->modlog->addLog(
			$accion,
			$objetoid,
			$objetonombre,
			$tablabase,
			$tablasreferencia,
			$this->session->userdata('idusuario')!==false?$this->session->userdata('idusuario'):"",
			$this->session->userdata('datausr')!==false?$this->session->userdata('datausr')["usuario"]:"",
			$this->session->userdata('datausr')!==false?$this->session->userdata('datausr')["nombre"]." ".$this->session->userdata('datausr')["apaterno"]:""
			);
	}
	public function getGrupo($idgrupo)
	{
		foreach($this->grupos as $g)
			if($g["idgrupo"]==$idgrupo)
				return $g;
		return false;
	}
	public function getAllCtes()
	{
		return $this->allctes;
	}
	public function getAllGens()
	{
		return $this->allgens;
	}
}
?>