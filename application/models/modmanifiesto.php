<?php
class ModManifiesto extends CI_Model
{
	private $idmanifiesto;
	private $identificador;
	private $instruccionesespeciales;
	private $fecha;
	private $fechaembarque;
	private $fecharecepcion;
	private $observacionesdestinofinal;
	private $idgenerador;
	private $idruta;
	private $recolecciones;
	private $motivo;
	public function __construct()
	{
		parent::__construct();
		$this->idmanifiesto=0;
		$this->identificador="";
		$this->instruccionesespeciales="";
		$this->fecha="";
		$this->fechaembarque="";
		$this->fecharecepcion="";
		$this->observacionesdestinofinal="";
		$this->idgenerador=0;
		$this->idruta=0;
		$this->recolecciones=array();
		$this->motivo="";
	}
	public function getIdmanifiesto() { return $this->idmanifiesto; }
	public function getIdentificador() { return $this->identificador; }
	public function getInstruccionesespeciales() { return $this->instruccionesespeciales; }
	public function getFecha() { return $this->fecha; }
	public function getFechaembarque() { return $this->fechaembarque; }
	public function getFecharecepcion() { return $this->fecharecepcion; }
	public function getObservacionesdestinofinal() { return $this->observacionesdestinofinal; }
	public function getIdgenerador() { return $this->idgenerador; }
	public function getIdruta() { return $this->idruta; }
	public function getRecolecciones() { return $this->recolecciones; }
	public function getMotivo() { return $this->motivo; }
	public function setIdmanifiesto($valor) { $this->idmanifiesto= intval($valor); }
	public function setIdentificador($valor) { $this->identificador= "".$valor; }
	public function setInstruccionesespeciales($valor) { $this->instruccionesespeciales= "".$valor; }
	public function setFecha($valor) { $this->fecha= "".$valor; }
	public function setFechaembarque($valor) { $this->fechaembarque= "".$valor; }
	public function setFecharecepcion($valor) { $this->fecharecepcion= "".$valor; }
	public function setObservacionesdestinofinal($valor) { $this->observacionesdestinofinal= "".$valor; }
	public function setIdgenerador($valor) { $this->idgenerador= intval($valor); }
	public function setIdruta($valor) { $this->idruta= intval($valor); }
	public function setRecolecciones($valor) { if(is_array($valor)) $this->recolecciones=$valor; else array_push($this->recolecciones,$valor); }
	public function setMotivo($valor) { $this->motivo= "".$valor; }
	public function getFromDatabase($id=0)
	{
		if($this->idmanifiesto==""||$this->idmanifiesto==0)
		{
			if($id>0)
				$this->idmanifiesto=$id;
			else
				return false;
		}
		$this->db->where('idmanifiesto',$this->idmanifiesto);
		$regs=$this->db->get('manifiesto');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdmanifiesto($reg["idmanifiesto"]);
		$this->setIdentificador($reg["identificador"]);
		$this->setInstruccionesespeciales($reg["instruccionesespeciales"]);
		$this->setFecha($reg["fecha"]);
		$this->setFechaembarque($reg["fechaembarque"]);
		$this->setFecharecepcion($reg["fecharecepcion"]);
		$this->setObservacionesdestinofinal($reg["observacionesdestinofinal"]);
		$this->setMotivo($reg["motivo"]);
		$this->db->where('idmanifiesto',$this->idmanifiesto);
		$regs=$this->db->get('relgenman');
		if($regs->num_rows()>0)
		{
			$reg=$regs->row_array();
			$this->setIdgenerador($reg["idgenerador"]);
		}
		$this->db->where('idmanifiesto',$this->idmanifiesto);
		$regs=$this->db->get('relmanrut');
		if($regs->num_rows()>0)
		{
			$reg=$regs->row_array();
			$this->setIdruta($reg["idruta"]);
		}
		$this->setRecolecciones(array());
		$this->db->where('idmanifiesto',$this->idmanifiesto);
		$regs=$this->db->get('relmanrec');
		if($regs->num_rows()>0)
		{
			$reg=$regs->row_array();
			$this->setRecolecciones($reg["idrecoleccion"]);
		}
		return true;
	}
	public function getFromInput()
	{
		$this->setIdmanifiesto($this->input->post("frm_manifiesto_idmanifiesto"));
		$this->setIdentificador($this->input->post("frm_manifiesto_identificador"));
		$this->setInstruccionesespeciales($this->input->post("frm_manifiesto_instruccionesespeciales"));
		$this->setFecha($this->input->post("frm_manifiesto_fecha"));
		$this->setFechaembarque($this->input->post("frm_manifiesto_fechaembarque"));
		$this->setFecharecepcion($this->input->post("frm_manifiesto_fecharecepcion"));
		$this->setObservacionesdestinofinal($this->input->post("frm_manifiesto_observacionesdestinofinal"));
		$this->setIdgenerador($this->input->post("frm_manifiesto_idgenerador"));
		$this->setIdruta($this->input->post("frm_manifiesto_idruta"));
		$this->setRecolecciones(explode(",",$this->input->post("frm_manifiesto_recolecciones")));
		$this->setMotivo($this->input->post("frm_manifiesto_motivo"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"identificador"=>$this->identificador,
			"instruccionesespeciales"=>$this->instruccionesespeciales,
			"fecha"=>$this->fecha,
			"fechaembarque"=>$this->fechaembarque,
			"fecharecepcion"=>$this->fecharecepcion,
			"observacionesdestinofinal"=>$this->observacionesdestinofinal,
			"motivo"=>$this->motivo
		);
		$this->db->insert('manifiesto',$data);
		$this->setIdmanifiesto($this->db->insert_id());
		$this->db->insert('relgenman',array(
			'idgenerador'=>$this->idgenerador,
			'idmanifiesto'=>$this->idmanifiesto
		));
		if($this->idruta!="" && $this->idruta>0)
			$this->db->insert('relmanrut',array(
				'idruta'=>$this->idruta,
				'idmanifiesto'=>$this->idmanifiesto
			));
	}
	public function updateToDatabase()
	{
		if($this->idmanifiesto==""||$this->idmanifiesto==0)
		{
			return false;
		}
		$data=array(
			"identificador"=>$this->identificador,
			"instruccionesespeciales"=>$this->instruccionesespeciales,
			"fecha"=>$this->fecha,
			"fechaembarque"=>$this->fechaembarque,
			"fecharecepcion"=>$this->fecharecepcion,
			"observacionesdestinofinal"=>$this->observacionesdestinofinal,
			"motivo"=>$this->motivo
		);
		$this->db->where('idmanifiesto',$this->idmanifiesto);
		$this->db->update('manifiesto',$data);
		$this->db->where('idmanifiesto',$this->idmanifiesto);
		$this->db->update('relgenman',array('idgenerador'=>$this->idgenerador));
		$this->db->where('idmanifiesto',$this->idmanifiesto);
		$this->db->update('relmanrut',array('idruta'=>$this->idruta));
		return true;
	}
	public function delete($id=0)
	{
		//Elimina la relacion con la bitacora pero la deja viva
		if($this->idmanifiesto==""||$this->idmanifiesto==0)
		{
			if($id>0)
				$this->idmanifiesto=$id;
			else
				return false;
		}
		$regs=$this->getRecoleccionesDatabase();
		if($regs!==false) foreach($regs as $reg)
		{
			$this->modrecoleccion->setIdrecoleccion($reg["idrecoleccion"]);
			$this->modrecoleccion->delete();
		}
		$this->db->where('idmanifiesto',$this->idmanifiesto);
		$this->db->delete(array('relbitman','relmanrut','relmanrec','relgenman','manifiesto'));
		return true;
	}
	public function getRecoleccionesDatabase()
	{
		if($this->idmanifiesto==""||$this->idmanifiesto==0)
		{
			return false;
		}
		$this->db->select('idrecoleccion');
		$this->db->where('idmanifiesto',$this->idmanifiesto);
		$regs=$this->db->get("relmanrec");
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function nextIdentificador($idsucursal=0)
	{
		$idsuc=$idsucursal;
		if($this->idgenerador!=0 && $this->idgenerador>0)
		{
			$this->modgenerador->setIdgenerador($this->idgenerador);
			$this->modgenerador->getFromDatabase();
			$idsuc=$this->modgenerador->getIdsucursal();
		}
		$this->db->select('MAX(CAST(identificador AS UNSIGNED)) AS identificador');
		//$this->db->where("idmanifiesto in (select idmanifiesto from relgenman where idgenerador in (select idgenerador from relcligen where idcliente in (select idcliente from relsuccli where idsucursal = $idsuc)))");
		$regs=$this->db->get('manifiesto');
		$max=($regs->num_rows()>0?intval($regs->row_array()["identificador"]):0);
		return $max+1;
	}
	public function getAll($idsucursal,$filtros)
	{
		$whr="";
		if($idsucursal>0)
			$whr.="idmanifiesto in (select idmanifiesto from relgenman where idgenerador in (select idgenerador from relcligen where idcliente in (select idcliente from relsuccli where idsucursal = $idsucursal)))";
		if(is_array($filtros))
		{
			$takePrefs=false;
			if(isset($filtros["identificador"]) && trim($filtros["identificador"])!="")
			{
				$whr.=($whr!=""?" and ":"")."identificador like '%{$filtros["identificador"]}%'";
				$takePrefs=true;
			}
			if(isset($filtros["numruta"]) && trim($filtros["numruta"])!="")
			{
				$whr.=($whr!=""?" and ":"")."idmanifiesto in (select idmanifiesto from relmanrut where idruta in (select idruta from ruta where identificador like '%{$filtros["numruta"]}%'))";
				$takePrefs=true;
			}
			if(isset($filtros["nombreruta"]) && trim($filtros["nombreruta"])!="")
			{
				$whr.=($whr!=""?" and ":"")."idmanifiesto in (select idmanifiesto from relmanrut where idruta in (select idruta from ruta where nombre like '%{$filtros["nombreruta"]}%'))";
				$takePrefs=true;
			}
			if(isset($filtros["fecha_inicio"]) && trim($filtros["fecha_inicio"])!="")
			{
				$whr.=($whr!=""?" and ":"")."fecha >= '{$filtros["fecha_inicio"]}'";
				$takePrefs=true;
			}
			if(isset($filtros["fecha_fin"]) && trim($filtros["fecha_fin"])!="")
			{
				$whr.=($whr!=""?" and ":"")."fecha <= '{$filtros["fecha_fin"]}'";
				$takePrefs=true;
			}
			if(isset($filtros["identificadorcliente"]) && trim($filtros["identificadorcliente"])!="")
			{
				$whr.=($whr!=""?" and ":"")."idmanifiesto in (select idmanifiesto from relgenman where idgenerador in (select idgenerador from relcligen where idcliente in (select idcliente from cliente where identificador like '%{$filtros["identificadorcliente"]}%')))";
				$takePrefs=true;
			}
			if(isset($filtros["identificadorgenerador"]) && trim($filtros["identificadorgenerador"])!="")
			{
				$whr.=($whr!=""?" and ":"")."idmanifiesto in (select idmanifiesto from relgenman where idgenerador in (select idgenerador from generador where identificador like '%{$filtros["identificadorgenerador"]}%'))";
				$takePrefs=true;
			}
			if(isset($filtros["nra"]) && trim($filtros["nra"])!="")
			{
				$whr.=($whr!=""?" and ":"")."idmanifiesto in (select idmanifiesto from relgenman where idgenerador in (select idgenerador from generador where numregamb like '%{$filtros["nra"]}%'))";
				$takePrefs=true;
			}
			if(isset($filtros["razonsocial"]) && trim($filtros["razonsocial"])!="")
			{
				$whr.=($whr!=""?" and ":"")."idmanifiesto in (select idmanifiesto from relgenman where idgenerador in (select idgenerador from generador where razonsocial like '%{$filtros["razonsocial"]}%'))";
				$takePrefs=true;
			}
			if(isset($filtros["rfc"]) && trim($filtros["rfc"])!="")
			{
				$whr.=($whr!=""?" and ":"")."idmanifiesto in (select idmanifiesto from relgenman where idgenerador in (select idgenerador from generador where rfc like '%{$filtros["rfc"]}%'))";
				$takePrefs=true;
			}
			if(isset($filtros["transportista"]) && trim($filtros["transportista"])!="")
			{
				$whr.=($whr!=""?" and ":"")."idmanifiesto in (select idmanifiesto from relmanrut where idruta in (select idruta from ruta where empresatransportista = {$filtros["transportista"]}))";
				$takePrefs=true;
			}
			if(isset($filtros["destinofinal"]) && trim($filtros["destinofinal"])!="")
			{
				$whr.=($whr!=""?" and ":"")."idmanifiesto in (select idmanifiesto from relmanrut where idruta in (select idruta from ruta where empresadestinofinal = {$filtros["destinofinal"]}))";
				$takePrefs=true;
			}
			if(isset($filtros["fechaembarque_inicio"]) && trim($filtros["fechaembarque_inicio"])!="")
			{
				$whr.=($whr!=""?" and ":"")."fechaembarque >= '{$filtros["fechaembarque_inicio"]}'";
				$takePrefs=true;
			}
			if(isset($filtros["fechaembarque_fin"]) && trim($filtros["fechaembarque_fin"])!="")
			{
				$whr.=($whr!=""?" and ":"")."fechaembarque <= '{$filtros["fechaembarque_fin"]}'";
				$takePrefs=true;
			}
			if(isset($filtros["fecharecepcion_inicio"]) && trim($filtros["fecharecepcion_inicio"])!="")
			{
				$whr.=($whr!=""?" and ":"")."fecharecepcion >= '{$filtros["fecharecepcion_inicio"]}'";
				$takePrefs=true;
			}
			if(isset($filtros["fecharecepcion_fin"]) && trim($filtros["fecharecepcion_fin"])!="")
			{
				$whr.=($whr!=""?" and ":"")."fecharecepcion <= '{$filtros["fecharecepcion_fin"]}'";
				$takePrefs=true;
			}
			if($whr!="" && ($takePrefs||true))
			{
				$this->db->where($whr);
				$this->db->order_by('identificador');
				$regs=$this->db->get('manifiesto');
				if($regs->num_rows()==0)
					return false;
				return $regs->result_array();
			}
		}
	}
	public function getFromIdentificador($identificador)
	{
		$this->db->where("identificador",$identificador);
		$this->db->order_by('identificador');
		$regs=$this->db->get('manifiesto');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
}
?>
