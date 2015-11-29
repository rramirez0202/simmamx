<?php                
class Modcliente extends CI_Model
{
	private $idcliente;
	private $identificador;
	private $razonsocial;
	private $rfc;
	private $calle;
	private $numexterior;
	private $numinterior;
	private $colonia;
	private $municipio;
	private $estado;
	private $cp;
	private $referencias;
	private $vendedor;
	private $representante;
	private $representantecargo;
	private $representantetelefono;
	private $representanteextencion;
	private $representanteemail;
	private $giro;
	private $observaciones;
	private $fechaalta;
	private $fechacontratoinicio;
	private $fechacontratofin;
	private $fechaserviciosinicio;
	private $fechaserviciosfin;
	private $facturaxgenerador;
	private $diascredito;
	private $cobranzacontacto;
	private $cobranzatelefono;
	private $cobranzaextension;
	private $cobranzaemail;
	private $cobranzaobservaciones;
	private $cobranzacalle;
	private $cobranzanuminterior;
	private $cobranzacolonia;
	private $cobranzamunicipio;
	private $cobranzaestado;
	private $cobranzacp;
	private $leyendas;
	private $ordencompra;
	private $desglosemanifiestos;
	private $idsucursal;
	private $cobranzanumexterior;
	private $afiliacion;
	private $representantetelefono2;
	private $representanteextension2;
	private $cobranzatelefono2;
	private $cobranzaextension2;
	private $facturaciones;
	private $status;
	private $fechastatus;
	public function __construct()
	{
		parent::__construct();
		$this->idcliente=0;
		$this->identificador="";
		$this->razonsocial="";
		$this->rfc="";
		$this->calle="";
		$this->numexterior="";
		$this->numinterior="";
		$this->colonia="";
		$this->municipio="";
		$this->estado="";
		$this->cp="";
		$this->referencias="";
		$this->vendedor="";
		$this->representante="";
		$this->representantecargo="";
		$this->representantetelefono="";
		$this->representanteextencion="";
		$this->representanteemail="";
		$this->giro="";
		$this->observaciones="";
		$this->fechaalta="";
		$this->fechacontratoinicio="";
		$this->fechacontratofin="";
		$this->fechaserviciosinicio="";
		$this->fechaserviciosfin="";
		$this->facturaxgenerador=0;
		$this->diascredito=0;
		$this->cobranzacontacto="";
		$this->cobranzatelefono="";
		$this->cobranzaextension="";
		$this->cobranzaemail="";
		$this->cobranzaobservaciones="";
		$this->cobranzacalle="";
		$this->cobranzanuminterior="";
		$this->cobranzacolonia="";
		$this->cobranzamunicipio="";
		$this->cobranzaestado="";
		$this->cobranzacp="";
		$this->leyendas="";
		$this->ordencompra=0;
		$this->desglosemanifiestos=0;
		$this->idsucursal=0;
		$this->cobranzanumexterior="";
		$this->afiliacion="";
		$this->representantetelefono2="";
		$this->representanteextension2="";
		$this->cobranzatelefono2="";
		$this->cobranzaextension2="";
		$this->facturaciones=array();
		$this->status="";
		$this->fechastatus="";
	}
	public function getIdcliente() { return $this->idcliente; }
	public function getIdentificador() { return $this->identificador; }
	public function getRazonsocial() { return $this->razonsocial; }
	public function getRfc() { return $this->rfc; }
	public function getCalle() { return $this->calle; }
	public function getNumexterior() { return $this->numexterior; }
	public function getNuminterior() { return $this->numinterior; }
	public function getColonia() { return $this->colonia; }
	public function getMunicipio() { return $this->municipio; }
	public function getEstado() { return $this->estado; }
	public function getCp() { return $this->cp; }
	public function getReferencias() { return $this->referencias; }
	public function getVendedor() { return $this->vendedor; }
	public function getRepresentante() { return $this->representante; }
	public function getRepresentantecargo() { return $this->representantecargo; }
	public function getRepresentantetelefono() { return $this->representantetelefono; }
	public function getRepresentanteextencion() { return $this->representanteextencion; }
	public function getRepresentanteemail() { return $this->representanteemail; }
	public function getGiro() { return $this->giro; }
	public function getObservaciones() { return $this->observaciones; }
	public function getFechaalta() { return $this->fechaalta; }
	public function getFechacontratoinicio() { return $this->fechacontratoinicio; }
	public function getFechacontratofin() { return $this->fechacontratofin; }
	public function getFechaserviciosinicio() { return $this->fechaserviciosinicio; }
	public function getFechaserviciosfin() { return $this->fechaserviciosfin; }
	public function getFacturaxgenerador() { return $this->facturaxgenerador; }
	public function getDiascredito() { return $this->diascredito; }
	public function getCobranzacontacto() { return $this->cobranzacontacto; }
	public function getCobranzatelefono() { return $this->cobranzatelefono; }
	public function getCobranzaextension() { return $this->cobranzaextension; }
	public function getCobranzaemail() { return $this->cobranzaemail; }
	public function getCobranzaobservaciones() { return $this->cobranzaobservaciones; }
	public function getCobranzacalle() { return $this->cobranzacalle; }
	public function getCobranzanuminterior() { return $this->cobranzanuminterior; }
	public function getCobranzacolonia() { return $this->cobranzacolonia; }
	public function getCobranzamunicipio() { return $this->cobranzamunicipio; }
	public function getCobranzaestado() { return $this->cobranzaestado; }
	public function getCobranzacp() { return $this->cobranzacp; }
	public function getLeyendas() { return $this->leyendas; }
	public function getOrdencompra() { return $this->ordencompra; }
	public function getDesglosemanifiestos() { return $this->desglosemanifiestos; }
	public function getCobranzanumexterior() { return $this->cobranzanumexterior; }
	public function getIdsucursal() { return $this->idsucursal; }
	public function getAfiliacion() { return $this->afiliacion; }
	public function getRepresentantetelefono2() { return $this->representantetelefono2; }
	public function getRepresentanteextension2() { return $this->representanteextension2; }
	public function getCobranzatelefono2() { return $this->cobranzatelefono2; }
	public function getCobranzaextension2() { return $this->cobranzaextension2; }
	public function getFacturaciones() { return $this->facturaciones; }
	public function getStatus() { return $this->status; }
	public function getFechastatus() { return $this->fechastatus; }
	public function setIdcliente($valor) { $this->idcliente= intval($valor); }
	public function setIdentificador($valor) { $this->identificador= "".$valor; }
	public function setRazonsocial($valor) { $this->razonsocial= "".$valor; }
	public function setRfc($valor) { $this->rfc= "".$valor; }
	public function setCalle($valor) { $this->calle= "".$valor; }
	public function setNumexterior($valor) { $this->numexterior= "".$valor; }
	public function setNuminterior($valor) { $this->numinterior= "".$valor; }
	public function setColonia($valor) { $this->colonia= "".$valor; }
	public function setMunicipio($valor) { $this->municipio= "".$valor; }
	public function setEstado($valor) { $this->estado= "".$valor; }
	public function setCp($valor) { $this->cp= "".$valor; }
	public function setReferencias($valor) { $this->referencias= "".$valor; }
	public function setVendedor($valor) { $this->vendedor= "".$valor; }
	public function setRepresentante($valor) { $this->representante= "".$valor; }
	public function setRepresentantecargo($valor) { $this->representantecargo= "".$valor; }
	public function setRepresentantetelefono($valor) { $this->representantetelefono= "".$valor; }
	public function setRepresentanteextencion($valor) { $this->representanteextencion= "".$valor; }
	public function setRepresentanteemail($valor) { $this->representanteemail= "".$valor; }
	public function setGiro($valor) { $this->giro= "".$valor; }
	public function setObservaciones($valor) { $this->observaciones= "".$valor; }
	public function setFechaalta($valor) { $this->fechaalta= "".$valor; }
	public function setFechacontratoinicio($valor) { $this->fechacontratoinicio= "".$valor; }
	public function setFechacontratofin($valor) { $this->fechacontratofin= "".$valor; }
	public function setFechaserviciosinicio($valor) { $this->fechaserviciosinicio= "".$valor; }
	public function setFechaserviciosfin($valor) { $this->fechaserviciosfin= "".$valor; }
	public function setFacturaxgenerador($valor) { $this->facturaxgenerador= intval($valor); }
	public function setDiascredito($valor) { $this->diascredito= intval($valor); }
	public function setCobranzacontacto($valor) { $this->cobranzacontacto= "".$valor; }
	public function setCobranzatelefono($valor) { $this->cobranzatelefono= "".$valor; }
	public function setCobranzaextension($valor) { $this->cobranzaextension= "".$valor; }
	public function setCobranzaemail($valor) { $this->cobranzaemail= "".$valor; }
	public function setCobranzaobservaciones($valor) { $this->cobranzaobservaciones= "".$valor; }
	public function setCobranzacalle($valor) { $this->cobranzacalle= "".$valor; }
	public function setCobranzanuminterior($valor) { $this->cobranzanuminterior= "".$valor; }
	public function setCobranzacolonia($valor) { $this->cobranzacolonia= "".$valor; }
	public function setCobranzamunicipio($valor) { $this->cobranzamunicipio= "".$valor; }
	public function setCobranzaestado($valor) { $this->cobranzaestado= "".$valor; }
	public function setCobranzacp($valor) { $this->cobranzacp= "".$valor; }
	public function setLeyendas($valor) { $this->leyendas= "".$valor; }
	public function setOrdencompra($valor) { $this->ordencompra= intval($valor); }
	public function setDesglosemanifiestos($valor) { $this->desglosemanifiestos= intval($valor); }
	public function setIdsucursal($valor) { $this->idsucursal= intval($valor); }
	public function setCobranzanumexterior($valor) { $this->cobranzanumexterior= "".$valor; }
	public function setAfiliacion($valor) { $this->afiliacion= "".$valor; }
	public function setRepresentantetelefono2($valor) { $this->representantetelefono2= "".$valor; }
	public function setRepresentanteextension2($valor) { $this->representanteextension2= "".$valor; }
	public function setCobranzatelefono2($valor) { $this->cobranzatelefono2= "".$valor; }
	public function setCobranzaextension2($valor) { $this->cobranzaextension2= "".$valor; }
	public function setFacturaciones($valor) { if(is_array($valor)) $this->facturaciones=$valor; else array_push($this->facturaciones,$valor); }
	public function setStatus($valor) { $this->status= "".$valor; }
	public function setFechastatus($valor) { $this->fechastatus= "".$valor; }
	public function getFromDatabase($id=0)
	{
		if($this->idcliente==""||$this->idcliente==0)
		{
			if($id>0)
				$this->idcliente=$id;
			else
				return false;
		}
		$this->db->where('idcliente',$this->idcliente);
		$regs=$this->db->get('cliente');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
        $this->setIdcliente($reg["idcliente"]);
		$this->setIdentificador($reg["identificador"]);
		$this->setRazonsocial($reg["razonsocial"]);
		$this->setRfc($reg["rfc"]);
		$this->setCalle($reg["calle"]);
		$this->setNumexterior($reg["numexterior"]);
		$this->setNuminterior($reg["numinterior"]);
		$this->setColonia($reg["colonia"]);
		$this->setMunicipio($reg["municipio"]);
		$this->setEstado($reg["estado"]);
		$this->setCp($reg["cp"]);
		$this->setReferencias($reg["referencias"]);
		$this->setVendedor($reg["vendedor"]);
		$this->setRepresentante($reg["representante"]);
		$this->setRepresentantecargo($reg["representantecargo"]);
		$this->setRepresentantetelefono($reg["representantetelefono"]);
		$this->setRepresentanteextencion($reg["representanteextencion"]);
		$this->setRepresentanteemail($reg["representanteemail"]);
		$this->setGiro($reg["giro"]);
		$this->setObservaciones($reg["observaciones"]);
		$this->setFechaalta($reg["fechaalta"]);
		$this->setFechacontratoinicio($reg["fechacontratoinicio"]);
		$this->setFechacontratofin($reg["fechacontratofin"]);
		$this->setFechaserviciosinicio($reg["fechaserviciosinicio"]);
		$this->setFechaserviciosfin($reg["fechaserviciosfin"]);
		$this->setFacturaxgenerador($reg["facturaxgenerador"]);
		$this->setDiascredito($reg["diascredito"]);
		$this->setCobranzacontacto($reg["cobranzacontacto"]);
		$this->setCobranzatelefono($reg["cobranzatelefono"]);
		$this->setCobranzaextension($reg["cobranzaextension"]);
		$this->setCobranzaemail($reg["cobranzaemail"]);
		$this->setCobranzaobservaciones($reg["cobranzaobservaciones"]);
		$this->setCobranzacalle($reg["cobranzacalle"]);
		$this->setCobranzanuminterior($reg["cobranzanuminterior"]);
		$this->setCobranzacolonia($reg["cobranzacolonia"]);
		$this->setCobranzamunicipio($reg["cobranzamunicipio"]);
		$this->setCobranzaestado($reg["cobranzaestado"]);
		$this->setCobranzacp($reg["cobranzacp"]);
		$this->setLeyendas($reg["leyendas"]);
		$this->setOrdencompra($reg["ordencompra"]);
		$this->setDesglosemanifiestos($reg["desglosemanifiestos"]);
		$this->setCobranzanumexterior($reg["cobranzanumexterior"]);
		$this->setAfiliacion($reg["afiliacion"]);
		$this->setRepresentantetelefono2($reg["representantetelefono2"]);
		$this->setRepresentanteextension2($reg["representanteextension2"]);
		$this->setCobranzatelefono2($reg["cobranzatelefono2"]);
		$this->setCobranzaextension2($reg["cobranzaextension2"]);
		$this->setStatus($reg["status"]);
		$this->setFechastatus($reg["fechastatus"]);
		$this->db->where('idcliente',$this->idcliente);
		$regs=$this->db->get('relsuccli');
		if($regs->num_rows()>0)
		{
			$reg=$regs->row_array();
			$this->setIdsucursal($reg["idsucursal"]);
		}
		$this->setFacturaciones(array());
		$this->db->where('idcliente',$this->idcliente);
		$regs=$this->db->get('relclifac');
		if($regs->num_rows()>0) foreach($regs->result_array() as $reg)
		{
			$this->setFacturaciones($reg["idfacturacion"]);
		}
        return true;
	}
	public function getFromInput()
	{
		$this->setIdcliente($this->input->post("frm_cliente_idcliente"));
		$this->setIdentificador($this->input->post("frm_cliente_identificador"));
		$this->setRazonsocial($this->input->post("frm_cliente_razonsocial"));
		$this->setRfc($this->input->post("frm_cliente_rfc"));
		$this->setCalle($this->input->post("frm_cliente_calle"));
		$this->setNumexterior($this->input->post("frm_cliente_numexterior"));
		$this->setNuminterior($this->input->post("frm_cliente_numinterior"));
		$this->setColonia($this->input->post("frm_cliente_colonia"));
		$this->setMunicipio($this->input->post("frm_cliente_municipio"));
		$this->setEstado($this->input->post("frm_cliente_estado"));
		$this->setCp($this->input->post("frm_cliente_cp"));
		$this->setReferencias($this->input->post("frm_cliente_referencias"));
		$this->setVendedor($this->input->post("frm_cliente_vendedor"));
		$this->setRepresentante($this->input->post("frm_cliente_representante"));
		$this->setRepresentantecargo($this->input->post("frm_cliente_representantecargo"));
		$this->setRepresentantetelefono($this->input->post("frm_cliente_representantetelefono"));
		$this->setRepresentanteextencion($this->input->post("frm_cliente_representanteextencion"));
		$this->setRepresentanteemail($this->input->post("frm_cliente_representanteemail"));
		$this->setGiro($this->input->post("frm_cliente_giro"));
		$this->setObservaciones($this->input->post("frm_cliente_observaciones"));
		$this->setFechaalta($this->input->post("frm_cliente_fechaalta"));
		$this->setFechacontratoinicio($this->input->post("frm_cliente_fechacontratoinicio"));
		$this->setFechacontratofin($this->input->post("frm_cliente_fechacontratofin"));
		$this->setFechaserviciosinicio($this->input->post("frm_cliente_fechaserviciosinicio"));
		$this->setFechaserviciosfin($this->input->post("frm_cliente_fechaserviciosfin"));
		$this->setFacturaxgenerador($this->input->post("frm_cliente_facturaxgenerador"));
		$this->setDiascredito($this->input->post("frm_cliente_diascredito"));
		$this->setCobranzacontacto($this->input->post("frm_cliente_cobranzacontacto"));
		$this->setCobranzatelefono($this->input->post("frm_cliente_cobranzatelefono"));
		$this->setCobranzaextension($this->input->post("frm_cliente_cobranzaextension"));
		$this->setCobranzaemail($this->input->post("frm_cliente_cobranzaemail"));
		$this->setCobranzaobservaciones($this->input->post("frm_cliente_cobranzaobservaciones"));
		$this->setCobranzacalle($this->input->post("frm_cliente_cobranzacalle"));
		$this->setCobranzanuminterior($this->input->post("frm_cliente_cobranzanuminterior"));
		$this->setCobranzacolonia($this->input->post("frm_cliente_cobranzacolonia"));
		$this->setCobranzamunicipio($this->input->post("frm_cliente_cobranzamunicipio"));
		$this->setCobranzaestado($this->input->post("frm_cliente_cobranzaestado"));
		$this->setCobranzacp($this->input->post("frm_cliente_cobranzacp"));
		$this->setLeyendas($this->input->post("frm_cliente_leyendas"));
		$this->setOrdencompra($this->input->post("frm_cliente_ordencompra"));
		$this->setDesglosemanifiestos($this->input->post("frm_cliente_desglosemanifiestos"));
		$this->setIdsucursal($this->input->post("frm_cliente_idsucursal"));
		$this->setCobranzanumexterior($this->input->post("frm_cliente_cobranzanumexterior"));
		$this->setAfiliacion($this->input->post("frm_cliente_afiliacion"));
		$this->setRepresentantetelefono2($this->input->post("frm_cliente_representantetelefono2"));
		$this->setRepresentanteextension2($this->input->post("frm_cliente_representanteextension2"));
		$this->setCobranzatelefono2($this->input->post("frm_cliente_cobranzatelefono2"));
		$this->setCobranzaextension2($this->input->post("frm_cliente_cobranzaextension2"));
		$this->setFacturaciones($this->input->post("frm_cliente_facturaciones"));
		$this->setStatus($this->input->post("frm_cliente_status"));
		$this->setFechastatus($this->input->post("frm_cliente_fechastatus"));
		return true;
	}
	public function addToDatabase()
	{
		$data=array(
			"identificador"=>$this->identificador,
			"razonsocial"=>$this->razonsocial,
			"rfc"=>$this->rfc,
			"calle"=>$this->calle,
			"numexterior"=>$this->numexterior,
			"numinterior"=>$this->numinterior,
			"colonia"=>$this->colonia,
			"municipio"=>$this->municipio,
			"estado"=>$this->estado,
			"cp"=>$this->cp,
			"referencias"=>$this->referencias,
			"vendedor"=>$this->vendedor,
			"representante"=>$this->representante,
			"representantecargo"=>$this->representantecargo,
			"representantetelefono"=>$this->representantetelefono,
			"representanteextencion"=>$this->representanteextencion,
			"representanteemail"=>$this->representanteemail,
			"giro"=>$this->giro,
			"observaciones"=>$this->observaciones,
			"fechaalta"=>$this->fechaalta,
			"fechacontratoinicio"=>$this->fechacontratoinicio,
			"fechacontratofin"=>$this->fechacontratofin,
			"fechaserviciosinicio"=>$this->fechaserviciosinicio,
			"fechaserviciosfin"=>$this->fechaserviciosfin,
			"facturaxgenerador"=>$this->facturaxgenerador,
			"diascredito"=>$this->diascredito,
			"cobranzacontacto"=>$this->cobranzacontacto,
			"cobranzatelefono"=>$this->cobranzatelefono,
			"cobranzaextension"=>$this->cobranzaextension,
			"cobranzaemail"=>$this->cobranzaemail,
			"cobranzaobservaciones"=>$this->cobranzaobservaciones,
			"cobranzacalle"=>$this->cobranzacalle,
			"cobranzanuminterior"=>$this->cobranzanuminterior,
			"cobranzacolonia"=>$this->cobranzacolonia,
			"cobranzamunicipio"=>$this->cobranzamunicipio,
			"cobranzaestado"=>$this->cobranzaestado,
			"cobranzacp"=>$this->cobranzacp,
			"leyendas"=>$this->leyendas,
			"ordencompra"=>$this->ordencompra,
			"cobranzanumexterior"=>$this->cobranzanumexterior,
			"desglosemanifiestos"=>$this->desglosemanifiestos,
			"afiliacion"=>$this->afiliacion,
			"representantetelefono2"=>$this->representantetelefono2,
			"representanteextension2"=>$this->representanteextension2,
			"cobranzatelefono2"=>$this->cobranzatelefono2,
			"cobranzaextension2"=>$this->cobranzaextension2,
			"status"=>$this->status,
			"fechastatus"=>$this->fechastatus
		);
		if($this->identificador==""||$this->razonsocial==""||$this->idsucursal==0)
			return false;
		$this->db->insert('cliente',$data);
		$this->setIdcliente($this->db->insert_id());
		$this->db->insert('relsuccli',array(
			"idsucursal"=>$this->idsucursal,
			"idcliente"=>$this->getIdcliente()
		));
		if(is_array($this->facturaciones) && count($this->facturaciones)>0) foreach($this->facturaciones as $idfacturacion) if($idfacturacion>0)
		{
			$this->db->insert("relclifac",array(
				"idcliente"=>$this->getIdcliente(),
				"idfacturacion"=>$idfacturacion
			));
		}
	}
	public function updateToDatabase()
	{
		if($this->idcliente==""||$this->idcliente==0)
			return false;
		$data=array(
			"identificador"=>$this->identificador,
			"razonsocial"=>$this->razonsocial,
			"rfc"=>$this->rfc,
			"calle"=>$this->calle,
			"numexterior"=>$this->numexterior,
			"numinterior"=>$this->numinterior,
			"colonia"=>$this->colonia,
			"municipio"=>$this->municipio,
			"estado"=>$this->estado,
			"cp"=>$this->cp,
			"referencias"=>$this->referencias,
			"vendedor"=>$this->vendedor,
			"representante"=>$this->representante,
			"representantecargo"=>$this->representantecargo,
			"representantetelefono"=>$this->representantetelefono,
			"representanteextencion"=>$this->representanteextencion,
			"representanteemail"=>$this->representanteemail,
			"giro"=>$this->giro,
			"observaciones"=>$this->observaciones,
			"fechaalta"=>$this->fechaalta,
			"fechacontratoinicio"=>$this->fechacontratoinicio,
			"fechacontratofin"=>$this->fechacontratofin,
			"fechaserviciosinicio"=>$this->fechaserviciosinicio,
			"fechaserviciosfin"=>$this->fechaserviciosfin,
			"facturaxgenerador"=>$this->facturaxgenerador,
			"diascredito"=>$this->diascredito,
			"cobranzacontacto"=>$this->cobranzacontacto,
			"cobranzatelefono"=>$this->cobranzatelefono,
			"cobranzaextension"=>$this->cobranzaextension,
			"cobranzaemail"=>$this->cobranzaemail,
			"cobranzaobservaciones"=>$this->cobranzaobservaciones,
			"cobranzacalle"=>$this->cobranzacalle,
			"cobranzanuminterior"=>$this->cobranzanuminterior,
			"cobranzacolonia"=>$this->cobranzacolonia,
			"cobranzamunicipio"=>$this->cobranzamunicipio,
			"cobranzaestado"=>$this->cobranzaestado,
			"cobranzacp"=>$this->cobranzacp,
			"leyendas"=>$this->leyendas,
			"ordencompra"=>$this->ordencompra,
			"cobranzanumexterior"=>$this->cobranzanumexterior,
			"desglosemanifiestos"=>$this->desglosemanifiestos,
			"afiliacion"=>$this->afiliacion,
			"representantetelefono2"=>$this->representantetelefono2,
			"representanteextension2"=>$this->representanteextension2,
			"cobranzatelefono2"=>$this->cobranzatelefono2,
			"cobranzaextension2"=>$this->cobranzaextension2,
			"status"=>$this->status,
			"fechastatus"=>$this->fechastatus
		);
		$this->db->where('idcliente',$this->idcliente);
		$this->db->update('cliente',$data);
		$this->db->where('idcliente',$this->idcliente);
		$this->db->delete("relclifac");
		if(is_array($this->facturaciones) && count($this->facturaciones)>0) foreach($this->facturaciones as $idfacturacion) if($idfacturacion>0)
		{
			$this->db->insert("relclifac",array(
				"idcliente"=>$this->getIdcliente(),
				"idfacturacion"=>$idfacturacion
			));
		}
		return true;
	}
	public function getAll($idsucursal,$filtros)
	{
		$whr="";
		if($idsucursal>0)
			$whr.="idcliente in (select idcliente from relsuccli where idsucursal=$idsucursal)";
		if(is_array($filtros))
		{
			$takePrefs=false;
			if(isset($filtros["identificador"]) && trim($filtros["identificador"])!="")
			{
				$whr.=($whr!=""?" and ":"")."identificador like '%{$filtros["identificador"]}%'";
				$takePrefs=true;
			}
			if(isset($filtros["rfc"]) && trim($filtros["rfc"])!="")
			{
				$whr.=($whr!=""?" and ":"")."rfc like '%{$filtros["rfc"]}%'";
				$takePrefs=true;
			}
			if(isset($filtros["razonsocial"]) && trim($filtros["razonsocial"])!="")
			{
				$whr.=($whr!=""?" and ":"")."razonsocial like '%{$filtros["razonsocial"]}%'";
				$takePrefs=true;
			}
			if(isset($filtros["vendedor"]) && trim($filtros["vendedor"])!="")
			{
				$whr.=($whr!=""?" and ":"")."vendedor like '%{$filtros["vendedor"]}%'";
				$takePrefs=true;
			}
			if(isset($filtros["giro"]) && trim($filtros["giro"])!="")
			{
				$whr.=($whr!=""?" and ":"")."giro like '%{$filtros["giro"]}%'";
				$takePrefs=true;
			}
			if(isset($filtros["observaciones"]) && trim($filtros["observaciones"])!="")
			{
				$whr.=($whr!=""?" and ":"")."observaciones like '%{$filtros["observaciones"]}%'";
				$takePrefs=true;
			}
			if($whr!="" && ($takePrefs||true))
			{
				$this->db->where($whr);
				$this->db->order_by('razonsocial');
				$regs=$this->db->get('cliente');
				if($regs->num_rows()==0)
					return false;
				return $regs->result_array();
			}
		}
		return false;
	}
	public function delete($id=0)
	{
		if($this->idcliente==""||$this->idcliente==0)
		{
			if($id>0)
				$this->idcliente=$id;
			else
				return false;
		}
		$regs=$this->getGeneradores();
		if($regs!==false) foreach($regs as $reg)
		{
			$this->modgenerador->setIdgenerador($reg["idgenerador"]);
			$this->modgenerador->delete();
		}
		if(is_array($this->facturaciones) && count($this->facturaciones)>0)
		{
			$this->db->where("idfacturacion in (".implode(",",$this->facturaciones).")");
			$this->db->delete(array("relclifac","facturacion"));
		}
		$this->db->where('idcliente',$this->idcliente);
		$this->db->delete(array('relsuccli','relcligen','relclifac','cliente'));
	}
	public function nextIdentificador($idsucursal=0)
	{
		if($this->idsucursal==0)
		{
			if($idsucursal!=0) $this->setIdsucursal($idsucursal);
			else return "";
		}
		$this->db->select_max('identificador');
		$regs=$this->db->get('cliente');
		$max=($regs->num_rows()>0?intval($regs->row_array()["identificador"]):0);
		$total=$this->db->count_all('cliente');
		if($total>$max) $max=$total;
		return $max+1;
	}
	public function getGeneradores()
	{
		if($this->idcliente==""||$this->idcliente==0)
			return false;
		$this->db->select('idgenerador');
		$this->db->where('idcliente',$this->idcliente);
		$regs=$this->db->get('relcligen');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getIdclienteWithIdentificador($idsucursal,$identificador)
	{
		if($idsucursal==0)
			$this->db->where("identificador = '$identificador'");
		else
			$this->db->where("identificador = $identificador and idcliente in (select idcliente from relsuccli where idsucursal = $idsucursal)");
		$regs=$this->db->get('cliente');
		if($regs->num_rows()==0)
			return false;
		return $regs->row_array()["idcliente"];
	}
}
?>