<?php
class Modfacturacion extends CI_Model
{
	private $idfacturacion;
	private $tiposervicio;
	private $tipocobro;
	private $precio;
	private $kilosintegrados;
	private $kiloexcedido;
	private $idcliente;
	private $idgenerador;
	public function __construct()
	{
		$this->idfacturacion=0;
		$this->tiposervicio="";
		$this->tipocobro="";
		$this->precio="";
		$this->kilosintegrados="";
		$this->kiloexcedido="";
		$this->idcliente=0;
		$this->idgenerador=0;
	}
	public function getIdfacturacion() { return $this->idfacturacion; }
	public function getTiposervicio() { return $this->tiposervicio; }
	public function getTipocobro() { return $this->tipocobro; }
	public function getPrecio() { return $this->precio; }
	public function getKilosintegrados() { return $this->kilosintegrados; }
	public function getKiloexcedido() { return $this->kiloexcedido; }
	public function getIdcliente() { return $this->idcliente; }
	public function getIdgenerador() { return $this->idgenerador; }
	public function setIdfacturacion($valor) { $this->idfacturacion= intval($valor); }
	public function setTiposervicio($valor) { $this->tiposervicio= "".$valor; }
	public function setTipocobro($valor) { $this->tipocobro= "".$valor; }
	public function setPrecio($valor) { $this->precio= "".$valor; }
	public function setKilosintegrados($valor) { $this->kilosintegrados= "".$valor; }
	public function setKiloexcedido($valor) { $this->kiloexcedido= "".$valor; }
	public function setIdcliente($valor) { $this->idcliente= intval($valor); }
	public function setIdgenerador($valor) { $this->idgenerador= intval($valor); }
    public function getFromDatabase($id=0)
	{
		if($this->idfacturacion==""||$this->idfacturacion==0)
		{
			if($id>0)
				$this->idfacturacion=$id;
			else
				return false;
		}
		$this->db->where('idfacturacion',$this->idfacturacion);
		$regs=$this->db->get('facturacion');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdfacturacion($reg["idfacturacion"]);
		$this->setTiposervicio($reg["tiposervicio"]);
		$this->setTipocobro($reg["tipocobro"]);
		$this->setPrecio($reg["precio"]);
		$this->setKilosintegrados($reg["kilosintegrados"]);
		$this->setKiloexcedido($reg["kiloexcedido"]);
		$this->db->where('idfacturacion',$this->idfacturacion);
		$regs=$this->db->get('relclifac');
		if($regs->num_rows()>0)
		{
			$reg=$regs->row_array();
			$this->setIdcliente($reg["idcliente"]);
		}
		$this->db->where('idfacturacion',$this->idfacturacion);
		$regs=$this->db->get('relgenfac');
		if($regs->num_rows()>0)
		{
			$reg=$regs->row_array();
			$this->setIdgenerador($reg["idgenerador"]);
		}
	}
	public function getFromInput()
	{
		$this->setIdfacturacion($this->input->post("frm_facturacion_idfacturacion"));
		$this->setTiposervicio($this->input->post("frm_facturacion_tiposervicio"));
		$this->setTipocobro($this->input->post("frm_facturacion_tipocobro"));
		$this->setPrecio($this->input->post("frm_facturacion_precio"));
		$this->setKilosintegrados($this->input->post("frm_facturacion_kilosintegrados"));
		$this->setKiloexcedido($this->input->post("frm_facturacion_kiloexcedido"));
		$this->setIdcliente($this->input->post("frm_facturacion_idcliente"));
		$this->setIdgenerador($this->input->post("frm_facturacion_idgenerador"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"tiposervicio"=>$this->tiposervicio,
			"tipocobro"=>$this->tipocobro,
			"precio"=>$this->precio,
			"kilosintegrados"=>$this->kilosintegrados,
			"kiloexcedido"=>$this->kiloexcedido
		);
		$this->db->insert('facturacion',$data);
		$this->setIdfacturacion($this->db->insert_id());
		if($this->getIdcliente()>0 && $this->getIdcliente()!="")
			$this->db->insert('relclifac',array(
				"idfacturacion"=>$this->idfacturacion,
				"idcliente"=>$this->getIdcliente()
			));
		if($this->getIdgenerador()>0 && $this->getIdgenerador()!="")
			$this->db->insert('relgenfac',array(
				"idfacturacion"=>$this->idfacturacion,
				"idgenerador"=>$this->getIdgenerador()
			));
	}
	public function updateToDatabase()
	{
		if($this->idfacturacion==""||$this->idfacturacion==0)
			return false;
		$data=array(
			"tiposervicio"=>$this->tiposervicio,
			"tipocobro"=>$this->tipocobro,
			"precio"=>$this->precio,
			"kilosintegrados"=>$this->kilosintegrados,
			"kiloexcedido"=>$this->kiloexcedido
		);
		$this->db->where('idfacturacion',$this->idfacturacion);
		$this->db->update('facturacion',$data);
		return true;
	}
	public function getAll($idcliente=0,$idgenerador=0)
	{
		$whr="";
		if($idcliente>0)
			$whr="idfacturacion in (select idfacturacion from relclifac where idcliente=$idcliente)";
		if($idgenerador>0)
			$whr="idfacturacion in (select idfacturacion from relgenfac where idgenerador=$idgenerador)";
		if($whr!="")
			$this->db->where($whr);
		$regs=$this->db->get("facturacion");
		if($regs->num_rows()>0)
			return $regs->result_array();
		return false;
	}
	public function delete($id=0)
	{
		if($this->idfacturacion==""||$this->idfacturacion==0)
		{
			if($id>0)
				$this->idfacturacion=$id;
			else
				return false;
		}
		$this->db->where('idfacturacion',$this->idfacturacion);
		$this->db->delete(array('relclifac','relgenfac','facturacion'));
	}
}
?>