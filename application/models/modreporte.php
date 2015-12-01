<?php
class Modreporte extends CI_Model
{
	private $idreporte;
	private $titulo;
	private $descripcion;
	private $categoria;
	private $plantilla;
	private $sql;
	private $parametros;
	private $params;
	public function __construct()
	{
		$this->idreporte=0;
		$this->titulo="";
		$this->descripcion="";
		$this->categoria="";
		$this->plantilla="";
		$this->sql="";
		$this->parametros="";
		$this->params=array();
	}
	public function getIdreporte() { return $this->idreporte; }
	public function getTitulo() { return $this->titulo; }
	public function getDescripcion() { return $this->descripcion; }
	public function getCategoria() { return $this->categoria; }
	public function getPlantilla() { return $this->plantilla; }
	public function getSql() { return $this->sql; }
	public function getParametros() { return $this->parametros; }
	public function getParams() { return $this->params; }
	public function setIdreporte($valor) { $this->idreporte= intval($valor); }
	public function setTitulo($valor) { $this->titulo= "".$valor; }
	public function setDescripcion($valor) { $this->descripcion= "".$valor; }
	public function setCategoria($valor) { $this->categoria= "".$valor; }
	public function setPlantilla($valor) { $this->plantilla= "".$valor; }
	public function setSql($valor) { $this->sql= "".$valor; }
	public function setParametros($valor) { $this->parametros= "".$valor; }
    public function getFromDatabase($id=0)
	{
		if($this->idreporte==""||$this->idreporte==0)
		{
			if($id>0)
				$this->idreporte=$id;
			else
				return false;
		}
		$this->db->where('idreporte',$this->idreporte);
		$regs=$this->db->get('reporte');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdreporte($reg["idreporte"]);
		$this->setTitulo($reg["titulo"]);
		$this->setDescripcion($reg["descripcion"]);
		$this->setCategoria($reg["categoria"]);
		$this->setPlantilla($reg["plantilla"]);
		$this->setSql($reg["sql"]);
		$this->setParametros($reg["parametros"]);
		$this->params=json_decode(trim($this->parametros),true);
		foreach($this->params as $k=>$p)
		{
			$valor="";
			switch(strtoupper($p["default"]))
			{
				case '_HOY_':
					$valor=Today();
					break;
				case '_HOY_+365':
					$valor=AddDays(Today(),365);
					break;
				default:
					$valor=$p["default"];
			}
			$this->params[$k]["valor"]=$valor;
		}
		return true;
	}
	public function getFromInput()
	{
		$this->setIdreporte($this->input->post("frm_reporte_idreporte"));
		$this->setTitulo($this->input->post("frm_reporte_titulo"));
		$this->setDescripcion($this->input->post("frm_reporte_descripcion"));
		$this->setCategoria($this->input->post("frm_reporte_categoria"));
		$this->setPlantilla($this->input->post("frm_reporte_plantilla"));
		$this->setSql($this->input->post("frm_reporte_sql"));
		$this->setParametros($this->input->post("frm_reporte_parametros"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"titulo"=>$this->titulo,
			"descripcion"=>$this->descripcion,
			"categoria"=>$this->categoria,
			"plantilla"=>$this->plantilla,
			"sql"=>$this->sql,
			"parametros"=>$this->parametros
		);
		$this->db->insert('reporte',$data);
		$this->setIdreporte($this->db->insert_id());
	}
	public function updateToDatabase($id=0)
	{
		if($this->idpermiso==""||$this->idpermiso==0)
		{
			if($id>0)
				$this->idpermiso=$id;
			else
				return false;
		}
		$data=array(
			"titulo"=>$this->titulo,
			"descripcion"=>$this->descripcion,
			"categoria"=>$this->categoria,
			"plantilla"=>$this->plantilla,
			"sql"=>$this->sql,
			"parametros"=>$this->parametros
		);
		$this->db->where('idreporte',$this->idreporte);
		$this->db->update('reporte',$data);
		return true;
	}
	public function delete($id=0)
	{
		if($this->idreporte==""||$this->idreporte==0)
		{
			if($id>0)
				$this->idreporte=$id;
			else
				return false;
		}
		$this->db->where('idreporte',$this->idreporte);
		$this->db->delete(array('reporte'));
	}
	public function getParamsFromInput()
	{
		if($this->idreporte==0 || $this->idreporte=="" || $this->parametros=="")
			return false;
		if($this->input->post("read")==="1")
		{
			foreach($this->params as $k=>$p)
			{
				$this->params[$k]["valor"]=$this->input->post($p["parametro"]);
			}
		}
		return true;
	}
	private function makeWhr()
	{
		if($this->idreporte==0 || $this->idreporte=="" || $this->parametros=="")
			return false;
		$whr="";
		foreach($this->params as $k=>$p)
		{
			$op=strtoupper(trim($p["operador"]));
			//var_dump($op);
			switch($op)
			{
				case 'LIKE':
					$whr.=(trim($whr)!=""?" AND ":"")."{$p["campo"]} LIKE '%{$p["valor"]}%' ";
					break;
				case '>':
				case '>=':
				case '=':
				case '<>':
				case '!=':
				case '<=':
				case '<':
					if($p["valor"]!="")
						$whr.=(trim($whr)!=""?" AND ":"")."{$p["campo"]} $op '{$p["valor"]}' ";
					break;
			}
		}
		return "WHERE ".$whr;
	}
	public function makeSQL()
	{
		if($this->idreporte==0 || $this->idreporte=="" || $this->parametros=="")
			return false;
		return str_replace("__WHR__",$this->makeWhr(),$this->sql);
	}
	public function execute()
	{
		if($this->idreporte==0 || $this->idreporte=="" || $this->parametros=="")
			return false;
		return $this->db->query($this->makeSQL())->result_array();
	}
}
?>
