<?php
class Modgenerador extends CI_Model
{
	private $idgenerador;
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
	private $numregamb;
	private $numreggen;
	private $representante;
	private $representantecargo;
	private $representantetelefono;
	private $representanteextension;
	private $representanteemail;
	private $frecuencia;
	private $serviciolunes;
	private $serviciomartes;
	private $serviciomiercoles;
	private $serviciojueves;
	private $servicioviernes;
	private $serviciosabado;
	private $serviciodomingo;
	private $horarioinicio;
	private $horariofin;
	private $servicio;
	private $observaciones;
	private $cobranzacontacto;
	private $cobranzatelefono;
	private $cobranzaextension;
	private $cobranzaemail;
	private $cobranzaobservaciones;
	private $cobranzacalle;
	private $cobranzanuminterior;
	private $cobranzanumexterior;
	private $cobranzacolonia;
	private $cobranzaestado;
	private $cobranzamunicipio;
	private $cobranzacp;
	private $leyendas;
	private $ordencompra;
	private $desglosemanifiestos;
	private $idcliente;
	private $representantetelefono2;
	private $representanteextension2;
	private $cobranzatelefono2;
	private $cobranzaextension2;
	private $rutas;
	private $horarioinicio2;
	private $horariofin2;
	private $facturaciones;
	private $fechascalendario;
	private $activo;
	private $fechaactivo;
	private $giro;
	public function __construct()
	{
		parent::__construct();
		$this->idgenerador=0;
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
		$this->numregamb="";
		$this->numreggen="";
		$this->representante="";
		$this->representantecargo="";
		$this->representantetelefono="";
		$this->representanteextension="";
		$this->representanteemail="";
		$this->frecuencia=0;
		$this->serviciolunes=0;
		$this->serviciomartes=0;
		$this->serviciomiercoles=0;
		$this->serviciojueves=0;
		$this->servicioviernes=0;
		$this->serviciosabado=0;
		$this->serviciodomingo=0;
		$this->horarioinicio="";
		$this->horariofin="";
		$this->servicio="";
		$this->observaciones="";
		$this->cobranzacontacto="";
		$this->cobranzatelefono="";
		$this->cobranzaextension="";
		$this->cobranzaemail="";
		$this->cobranzaobservaciones="";
		$this->cobranzacalle="";
		$this->cobranzanuminterior="";
		$this->cobranzanumexterior="";
		$this->cobranzacolonia="";
		$this->cobranzaestado="";
		$this->cobranzamunicipio="";
		$this->cobranzacp="";
		$this->leyendas="";
		$this->ordencompra=0;
		$this->desglosemanifiestos=0;
		$this->idcliente=0;
		$this->representantetelefono2="";
		$this->representanteextension2="";
		$this->cobranzatelefono2="";
		$this->cobranzaextension2="";
		$this->rutas=array();
		$this->horarioinicio2="";
		$this->horariofin2="";
		$this->facturaciones=array();
		$this->fechascalendario=array();
		$this->activo=0;
		$this->fechaactivo="";
		$this->giro="";
	}
	public function getIdgenerador() { return $this->idgenerador; }
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
	public function getNumregamb() { return $this->numregamb; }
	public function getNumreggen() { return $this->numreggen; }
	public function getRepresentante() { return $this->representante; }
	public function getRepresentantecargo() { return $this->representantecargo; }
	public function getRepresentantetelefono() { return $this->representantetelefono; }
	public function getRepresentanteextension() { return $this->representanteextension; }
	public function getRepresentanteemail() { return $this->representanteemail; }
	public function getFrecuencia() { return $this->frecuencia; }
	public function getServiciolunes() { return $this->serviciolunes; }
	public function getServiciomartes() { return $this->serviciomartes; }
	public function getServiciomiercoles() { return $this->serviciomiercoles; }
	public function getServiciojueves() { return $this->serviciojueves; }
	public function getServicioviernes() { return $this->servicioviernes; }
	public function getServiciosabado() { return $this->serviciosabado; }
	public function getServiciodomingo() { return $this->serviciodomingo; }
	public function getHorarioinicio() 
	{ 
		if(strlen($this->horarioinicio)==8 && substr($this->horarioinicio,2,1)==":" && substr($this->horarioinicio,5,1)==":")
			return substr($this->horarioinicio,0,5);
		return $this->horarioinicio; 
	}
	public function getHorariofin() 
	{ 
		if(strlen($this->horariofin)==8 && substr($this->horariofin,2,1)==":" && substr($this->horariofin,5,1)==":")
			return substr($this->horariofin,0,5);
		return $this->horariofin; 
	}
	public function getServicio() { return $this->servicio; }
	public function getObservaciones() { return $this->observaciones; }
	public function getCobranzacontacto() { return $this->cobranzacontacto; }
	public function getCobranzatelefono() { return $this->cobranzatelefono; }
	public function getCobranzaextension() { return $this->cobranzaextension; }
	public function getCobranzaemail() { return $this->cobranzaemail; }
	public function getCobranzaobservaciones() { return $this->cobranzaobservaciones; }
	public function getCobranzacalle() { return $this->cobranzacalle; }
	public function getCobranzanuminterior() { return $this->cobranzanuminterior; }
	public function getCobranzanumexterior() { return $this->cobranzanumexterior; }
	public function getCobranzacolonia() { return $this->cobranzacolonia; }
	public function getCobranzaestado() { return $this->cobranzaestado; }
	public function getCobranzamunicipio() { return $this->cobranzamunicipio; }
	public function getCobranzacp() { return $this->cobranzacp; }
	public function getLeyendas() { return $this->leyendas; }
	public function getOrdencompra() { return $this->ordencompra; }
	public function getDesglosemanifiestos() { return $this->desglosemanifiestos; }
	public function getIdcliente() { return $this->idcliente; }
	public function getRepresentantetelefono2() { return $this->representantetelefono2; }
	public function getRepresentanteextension2() { return $this->representanteextension2; }
	public function getCobranzatelefono2() { return $this->cobranzatelefono2; }
	public function getCobranzaextension2() { return $this->cobranzaextension2; }
	public function getRutas() { return $this->rutas; }
	public function getHorarioinicio2() 
	{ 
		if(strlen($this->horarioinicio2)==8 && substr($this->horarioinicio2,2,1)==":" && substr($this->horarioinicio2,5,1)==":")
			return substr($this->horarioinicio2,0,5);
		return $this->horarioinicio2; 
	}
	public function getHorariofin2() 
	{ 
		if(strlen($this->horariofin2)==8 && substr($this->horariofin2,2,1)==":" && substr($this->horariofin2,5,1)==":")
			return substr($this->horariofin2,0,5);
		return $this->horariofin2; 
	}
	public function getFacturaciones() { return $this->facturaciones; }
	public function getFechascalendario() { return $this->fechascalendario; }
	public function getActivo() { return $this->activo; }
	public function getFechaactivo() { return $this->fechaactivo; }
	public function getGiro() { return $this->giro; }
	public function setIdgenerador($valor) { $this->idgenerador= intval($valor); }
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
	public function setNumregamb($valor) { $this->numregamb= "".$valor; }
	public function setNumreggen($valor) { $this->numreggen= "".$valor; }
	public function setRepresentante($valor) { $this->representante= "".$valor; }
	public function setRepresentantecargo($valor) { $this->representantecargo= "".$valor; }
	public function setRepresentantetelefono($valor) { $this->representantetelefono= "".$valor; }
	public function setRepresentanteextension($valor) { $this->representanteextension= "".$valor; }
	public function setRepresentanteemail($valor) { $this->representanteemail= "".$valor; }
	public function setFrecuencia($valor) { $this->frecuencia= intval($valor); }
	public function setServiciolunes($valor) { $this->serviciolunes= intval($valor); }
	public function setServiciomartes($valor) { $this->serviciomartes= intval($valor); }
	public function setServiciomiercoles($valor) { $this->serviciomiercoles= intval($valor); }
	public function setServiciojueves($valor) { $this->serviciojueves= intval($valor); }
	public function setServicioviernes($valor) { $this->servicioviernes= intval($valor); }
	public function setServiciosabado($valor) { $this->serviciosabado= intval($valor); }
	public function setServiciodomingo($valor) { $this->serviciodomingo= intval($valor); }
	public function setHorarioinicio($valor) { $this->horarioinicio= "".$valor; }
	public function setHorariofin($valor) { $this->horariofin= "".$valor; }
	public function setServicio($valor) { $this->servicio= "".$valor; }
	public function setObservaciones($valor) { $this->observaciones= "".$valor; }
	public function setCobranzacontacto($valor) { $this->cobranzacontacto= "".$valor; }
	public function setCobranzatelefono($valor) { $this->cobranzatelefono= "".$valor; }
	public function setCobranzaextension($valor) { $this->cobranzaextension= "".$valor; }
	public function setCobranzaemail($valor) { $this->cobranzaemail= "".$valor; }
	public function setCobranzaobservaciones($valor) { $this->cobranzaobservaciones= "".$valor; }
	public function setCobranzacalle($valor) { $this->cobranzacalle= "".$valor; }
	public function setCobranzanuminterior($valor) { $this->cobranzanuminterior= "".$valor; }
	public function setCobranzanumexterior($valor) { $this->cobranzanumexterior= "".$valor; }
	public function setCobranzacolonia($valor) { $this->cobranzacolonia= "".$valor; }
	public function setCobranzaestado($valor) { $this->cobranzaestado= "".$valor; }
	public function setCobranzamunicipio($valor) { $this->cobranzamunicipio= "".$valor; }
	public function setCobranzacp($valor) { $this->cobranzacp= "".$valor; }
	public function setLeyendas($valor) { $this->leyendas= "".$valor; }
	public function setOrdencompra($valor) { $this->ordencompra= intval($valor); }
	public function setDesglosemanifiestos($valor) { $this->desglosemanifiestos= intval($valor); }
	public function setIdcliente($valor) { $this->idcliente= intval($valor); }
	public function setRepresentantetelefono2($valor) { $this->representantetelefono2= "".$valor; }
	public function setRepresentanteextension2($valor) { $this->representanteextension2= "".$valor; }
	public function setCobranzatelefono2($valor) { $this->cobranzatelefono2= "".$valor; }
	public function setCobranzaextension2($valor) { $this->cobranzaextension2= "".$valor; }
	public function setRutas($valor) { if(is_array($valor)) $this->rutas=$valor; else array_push($this->rutas,$valor); }
	public function setHorarioinicio2($valor) { $this->horarioinicio2= "".$valor; }
	public function setHorariofin2($valor) { $this->horariofin2= "".$valor; }
	public function setFacturaciones($valor) { if(is_array($valor)) $this->facturaciones=$valor; else array_push($this->facturaciones,$valor); }
	public function setFechascalendario($valor) { if(is_array($valor)) $this->fechascalendario=$valor; else array_push($this->fechascalendario,$valor); }
	public function setActivo($valor) { $this->activo= intval($valor); }
	public function setFechaactivo($valor) { $this->fechaactivo= "".$valor; }
	public function setGiro($valor) { $this->giro= "".$valor; }
	public function getFromDatabase($id=0)
	{
		if($this->idgenerador==""||$this->idgenerador==0)
		{
			if($id>0)
				$this->idgenerador=$id;
			else
				return false;
		}
		$this->db->where('idgenerador',$this->idgenerador);
		$regs=$this->db->get('generador');
		if($regs->num_rows()==0)
			return false;
		$reg=$regs->row_array();
		$this->setIdgenerador($reg["idgenerador"]);
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
		$this->setNumregamb($reg["numregamb"]);
		$this->setNumreggen($reg["numreggen"]);
		$this->setRepresentante($reg["representante"]);
		$this->setRepresentantecargo($reg["representantecargo"]);
		$this->setRepresentantetelefono($reg["representantetelefono"]);
		$this->setRepresentanteextension($reg["representanteextension"]);
		$this->setRepresentanteemail($reg["representanteemail"]);
		$this->setFrecuencia($reg["frecuencia"]);
		$this->setServiciolunes($reg["serviciolunes"]);
		$this->setServiciomartes($reg["serviciomartes"]);
		$this->setServiciomiercoles($reg["serviciomiercoles"]);
		$this->setServiciojueves($reg["serviciojueves"]);
		$this->setServicioviernes($reg["servicioviernes"]);
		$this->setServiciosabado($reg["serviciosabado"]);
		$this->setServiciodomingo($reg["serviciodomingo"]);
		$this->setHorarioinicio($reg["horarioinicio"]);
		$this->setHorariofin($reg["horariofin"]);
		$this->setServicio($reg["servicio"]);
		$this->setObservaciones($reg["observaciones"]);
		$this->setCobranzacontacto($reg["cobranzacontacto"]);
		$this->setCobranzatelefono($reg["cobranzatelefono"]);
		$this->setCobranzaextension($reg["cobranzaextension"]);
		$this->setCobranzaemail($reg["cobranzaemail"]);
		$this->setCobranzaobservaciones($reg["cobranzaobservaciones"]);
		$this->setCobranzacalle($reg["cobranzacalle"]);
		$this->setCobranzanuminterior($reg["cobranzanuminterior"]);
		$this->setCobranzanumexterior($reg["cobranzanumexterior"]);
		$this->setCobranzacolonia($reg["cobranzacolonia"]);
		$this->setCobranzaestado($reg["cobranzaestado"]);
		$this->setCobranzamunicipio($reg["cobranzamunicipio"]);
		$this->setCobranzacp($reg["cobranzacp"]);
		$this->setLeyendas($reg["leyendas"]);
		$this->setOrdencompra($reg["ordencompra"]);
		$this->setDesglosemanifiestos($reg["desglosemanifiestos"]);
		$this->setRepresentantetelefono2($reg["representantetelefono2"]);
		$this->setRepresentanteextension2($reg["representanteextension2"]);
		$this->setCobranzatelefono2($reg["cobranzatelefono2"]);
		$this->setCobranzaextension2($reg["cobranzaextension2"]);
		$this->setHorarioinicio2($reg["horarioinicio2"]);
		$this->setHorariofin2($reg["horariofin2"]);
		$this->setActivo($reg["activo"]);
		$this->setFechaactivo($reg["fechaactivo"]);
		$this->setGiro($reg["giro"]);
		$this->db->where('idgenerador',$this->idgenerador);
		$regs=$this->db->get('relcligen');
		if($regs->num_rows()>0)
		{
			$reg=$regs->row_array();
			$this->setIdcliente($reg["idcliente"]);
		}
		$this->db->where('idgenerador',$this->idgenerador);
		$regs=$this->db->get('relrutgen');
		$this->setRutas(array());
		if($regs->num_rows()>0) foreach($regs->result_array() as $reg)
		{
			$this->setRutas($reg["idruta"]);
		}
		$this->setFacturaciones(array());
		$this->db->where('idgenerador',$this->idgenerador);
		$regs=$this->db->get('relgenfac');
		if($regs->num_rows()>0) foreach($regs->result_array() as $reg)
		{
			$this->setFacturaciones($reg["idfacturacion"]);
		}
		$this->setFechascalendario(array());
		$this->db->where("idcalendario in (select idcalendario from relgencal where idgenerador={$this->idgenerador})");
		$this->db->order_by("fecha");
		$regs=$this->db->get('calendario');
		if($regs->num_rows()>0) foreach($regs->result_array() as $reg)
		{
			$this->setFechascalendario($reg["fecha"]);
		}
		return true;
	}
	public function getFromInput()
	{
		$this->setIdgenerador($this->input->post("frm_generador_idgenerador"));
		$this->setIdentificador($this->input->post("frm_generador_identificador"));
		$this->setRazonsocial($this->input->post("frm_generador_razonsocial"));
		$this->setRfc($this->input->post("frm_generador_rfc"));
		$this->setCalle($this->input->post("frm_generador_calle"));
		$this->setNumexterior($this->input->post("frm_generador_numexterior"));
		$this->setNuminterior($this->input->post("frm_generador_numinterior"));
		$this->setColonia($this->input->post("frm_generador_colonia"));
		$this->setMunicipio($this->input->post("frm_generador_municipio"));
		$this->setEstado($this->input->post("frm_generador_estado"));
		$this->setCp($this->input->post("frm_generador_cp"));
		$this->setReferencias($this->input->post("frm_generador_referencias"));
		$this->setNumregamb($this->input->post("frm_generador_numregamb"));
		$this->setNumreggen($this->input->post("frm_generador_numreggen"));
		$this->setRepresentante($this->input->post("frm_generador_representante"));
		$this->setRepresentantecargo($this->input->post("frm_generador_representantecargo"));
		$this->setRepresentantetelefono($this->input->post("frm_generador_representantetelefono"));
		$this->setRepresentanteextension($this->input->post("frm_generador_representanteextension"));
		$this->setRepresentanteemail($this->input->post("frm_generador_representanteemail"));
		$this->setFrecuencia($this->input->post("frm_generador_frecuencia"));
		$this->setServiciolunes($this->input->post("frm_generador_serviciolunes"));
		$this->setServiciomartes($this->input->post("frm_generador_serviciomartes"));
		$this->setServiciomiercoles($this->input->post("frm_generador_serviciomiercoles"));
		$this->setServiciojueves($this->input->post("frm_generador_serviciojueves"));
		$this->setServicioviernes($this->input->post("frm_generador_servicioviernes"));
		$this->setServiciosabado($this->input->post("frm_generador_serviciosabado"));
		$this->setServiciodomingo($this->input->post("frm_generador_serviciodomingo"));
		$this->setHorarioinicio($this->input->post("frm_generador_horarioinicio"));
		$this->setHorariofin($this->input->post("frm_generador_horariofin"));
		$this->setServicio($this->input->post("frm_generador_servicio"));
		$this->setObservaciones($this->input->post("frm_generador_observaciones"));
		$this->setCobranzacontacto($this->input->post("frm_generador_cobranzacontacto"));
		$this->setCobranzatelefono($this->input->post("frm_generador_cobranzatelefono"));
		$this->setCobranzaextension($this->input->post("frm_generador_cobranzaextension"));
		$this->setCobranzaemail($this->input->post("frm_generador_cobranzaemail"));
		$this->setCobranzaobservaciones($this->input->post("frm_generador_cobranzaobservaciones"));
		$this->setCobranzacalle($this->input->post("frm_generador_cobranzacalle"));
		$this->setCobranzanuminterior($this->input->post("frm_generador_cobranzanuminterior"));
		$this->setCobranzanumexterior($this->input->post("frm_generador_cobranzanumexterior"));
		$this->setCobranzacolonia($this->input->post("frm_generador_cobranzacolonia"));
		$this->setCobranzaestado($this->input->post("frm_generador_cobranzaestado"));
		$this->setCobranzamunicipio($this->input->post("frm_generador_cobranzamunicipio"));
		$this->setCobranzacp($this->input->post("frm_generador_cobranzacp"));
		$this->setLeyendas($this->input->post("frm_generador_leyendas"));
		$this->setOrdencompra($this->input->post("frm_generador_ordencompra"));
		$this->setDesglosemanifiestos($this->input->post("frm_generador_desglosemanifiestos"));
		$this->setIdcliente($this->input->post("frm_generador_idcliente"));
		$this->setRepresentantetelefono2($this->input->post("frm_generador_representantetelefono2"));
		$this->setRepresentanteextension2($this->input->post("frm_generador_representanteextension2"));
		$this->setCobranzatelefono2($this->input->post("frm_generador_cobranzatelefono2"));
		$this->setCobranzaextension2($this->input->post("frm_generador_cobranzaextension2"));
		$this->setHorarioinicio2($this->input->post("frm_generador_horarioinicio2"));
		$this->setHorariofin2($this->input->post("frm_generador_horariofin2"));
		$this->setRutas($this->input->post("frm_generador_rutas"));
		$this->setFacturaciones($this->input->post("frm_cliente_facturaciones"));
		$this->setFechascalendario($this->input->post("frm_generador_fechascalendario"));
		$this->setActivo($this->input->post("frm_generador_activo"));
		$this->setFechaactivo($this->input->post("frm_generador_fechaactivo"));
		$this->setGiro($this->input->post("frm_generador_giro"));
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
			"numregamb"=>$this->numregamb,
			"numreggen"=>$this->numreggen,
			"representante"=>$this->representante,
			"representantecargo"=>$this->representantecargo,
			"representantetelefono"=>$this->representantetelefono,
			"representanteextension"=>$this->representanteextension,
			"representanteemail"=>$this->representanteemail,
			"frecuencia"=>$this->frecuencia,
			"serviciolunes"=>$this->serviciolunes,
			"serviciomartes"=>$this->serviciomartes,
			"serviciomiercoles"=>$this->serviciomiercoles,
			"serviciojueves"=>$this->serviciojueves,
			"servicioviernes"=>$this->servicioviernes,
			"serviciosabado"=>$this->serviciosabado,
			"serviciodomingo"=>$this->serviciodomingo,
			"horarioinicio"=>$this->horarioinicio,
			"horariofin"=>$this->horariofin,
			"servicio"=>$this->servicio,
			"observaciones"=>$this->observaciones,
			"cobranzacontacto"=>$this->cobranzacontacto,
			"cobranzatelefono"=>$this->cobranzatelefono,
			"cobranzaextension"=>$this->cobranzaextension,
			"cobranzaemail"=>$this->cobranzaemail,
			"cobranzaobservaciones"=>$this->cobranzaobservaciones,
			"cobranzacalle"=>$this->cobranzacalle,
			"cobranzanuminterior"=>$this->cobranzanuminterior,
			"cobranzanumexterior"=>$this->cobranzanumexterior,
			"cobranzacolonia"=>$this->cobranzacolonia,
			"cobranzaestado"=>$this->cobranzaestado,
			"cobranzamunicipio"=>$this->cobranzamunicipio,
			"cobranzacp"=>$this->cobranzacp,
			"leyendas"=>$this->leyendas,
			"ordencompra"=>$this->ordencompra,
			"desglosemanifiestos"=>$this->desglosemanifiestos,
			"representantetelefono2"=>$this->representantetelefono2,
			"representanteextension2"=>$this->representanteextension2,
			"cobranzatelefono2"=>$this->cobranzatelefono2,
			"cobranzaextension2"=>$this->cobranzaextension2,
			"horarioinicio2"=>$this->horarioinicio2,
			"horariofin2"=>$this->horariofin2,
			"activo"=>$this->activo,
			"fechaactivo"=>$this->fechaactivo,
			"giro"=>$this->giro
		);
		if($this->identificador==""||$this->razonsocial==""||$this->idcliente==0)
			return false;
		$this->db->insert('generador',$data);
		$this->setIdgenerador($this->db->insert_id());
		$this->db->insert('relcligen',array(
			"idcliente"=>$this->idcliente,
			"idgenerador"=>$this->idgenerador
		));
		foreach($this->rutas as $r)
		{
			if($r!==false)
				$this->db->insert("relrutgen",array(
					"idruta"=>$r,
					"idgenerador"=>$this->idgenerador
				));
		}
		if(is_array($this->facturaciones) && count($this->facturaciones)>0) foreach($this->facturaciones as $idfacturacion) if($idfacturacion>0)
		{
			$this->db->insert("relgenfac",array(
				"idgenerador"=>$this->getIdgenerador(),
				"idfacturacion"=>$idfacturacion
			));
		}
	}
	public function updateToDatabase($id=0)
	{
		if($this->idgenerador==""||$this->idgenerador==0)
		{
			if($id>0)
				$this->idgenerador=$id;
			else
				return false;
		}
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
			"numregamb"=>$this->numregamb,
			"numreggen"=>$this->numreggen,
			"representante"=>$this->representante,
			"representantecargo"=>$this->representantecargo,
			"representantetelefono"=>$this->representantetelefono,
			"representanteextension"=>$this->representanteextension,
			"representanteemail"=>$this->representanteemail,
			"frecuencia"=>$this->frecuencia,
			"serviciolunes"=>$this->serviciolunes,
			"serviciomartes"=>$this->serviciomartes,
			"serviciomiercoles"=>$this->serviciomiercoles,
			"serviciojueves"=>$this->serviciojueves,
			"servicioviernes"=>$this->servicioviernes,
			"serviciosabado"=>$this->serviciosabado,
			"serviciodomingo"=>$this->serviciodomingo,
			"horarioinicio"=>$this->horarioinicio,
			"horariofin"=>$this->horariofin,
			"servicio"=>$this->servicio,
			"observaciones"=>$this->observaciones,
			"cobranzacontacto"=>$this->cobranzacontacto,
			"cobranzatelefono"=>$this->cobranzatelefono,
			"cobranzaextension"=>$this->cobranzaextension,
			"cobranzaemail"=>$this->cobranzaemail,
			"cobranzaobservaciones"=>$this->cobranzaobservaciones,
			"cobranzacalle"=>$this->cobranzacalle,
			"cobranzanuminterior"=>$this->cobranzanuminterior,
			"cobranzanumexterior"=>$this->cobranzanumexterior,
			"cobranzacolonia"=>$this->cobranzacolonia,
			"cobranzaestado"=>$this->cobranzaestado,
			"cobranzamunicipio"=>$this->cobranzamunicipio,
			"cobranzacp"=>$this->cobranzacp,
			"leyendas"=>$this->leyendas,
			"ordencompra"=>$this->ordencompra,
			"desglosemanifiestos"=>$this->desglosemanifiestos,
			"representantetelefono2"=>$this->representantetelefono2,
			"representanteextension2"=>$this->representanteextension2,
			"cobranzatelefono2"=>$this->cobranzatelefono2,
			"cobranzaextension2"=>$this->cobranzaextension2,
			"horarioinicio2"=>$this->horarioinicio2,
			"horariofin2"=>$this->horariofin2,
			"activo"=>$this->activo,
			"fechaactivo"=>$this->fechaactivo,
			"giro"=>$this->giro
		);
		$this->db->where('idgenerador',$this->idgenerador);
		$this->db->update('generador',$data);
		$this->db->where('idgenerador',$this->idgenerador);
		$this->db->delete('relrutgen');
		foreach($this->rutas as $r)
		{
			if($r!==false)
				$this->db->insert("relrutgen",array(
					"idruta"=>$r,
					"idgenerador"=>$this->idgenerador
				));
		}
		$this->db->where('idgenerador',$this->idgenerador);
		$this->db->delete("relgenfac");
		if(is_array($this->facturaciones) && count($this->facturaciones)>0) foreach($this->facturaciones as $idfacturacion) if($idfacturacion>0)
		{
			$this->db->insert("relgenfac",array(
				"idgenerador"=>$this->getIdgenerador(),
				"idfacturacion"=>$idfacturacion
			));
		}
		return true;
	}
	public function getAll($idcliente=0)
	{
		if($idcliente>0)
			$this->db->where("idgenerador in (select idgenerador from relcligen where idcliente=$idcliente)");
		$this->db->order_by('razonsocial');
		$regs=$this->db->get('generador');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getAllFiltered($filtros)
	{
		$whr="";
		$takePrefs=false;
		if(is_array($filtros))
		{
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
			if(isset($filtros["colonia"]) && trim($filtros["colonia"])!="")
			{
				$whr.=($whr!=""?" and ":"")."(colonia like '%{$filtros["colonia"]}%' OR cobranzacolonia like '%{$filtros["colonia"]}%')";
				$takePrefs=true;
			}
			if(isset($filtros["municipio"]) && trim($filtros["municipio"])!="")
			{
				$whr.=($whr!=""?" and ":"")."(municipio like '%{$filtros["municipio"]}%' OR cobranzamunicipio like '%{$filtros["municipio"]}%')";
				$takePrefs=true;
			}
		}
		if($whr!="" && ($takePrefs||true))
		{
			if(count($this->modsesion->getAllGens())>0)
				$whr.=" AND idgenerador IN (".implode(",",$this->modsesion->getAllGens()).")";
			$this->db->where($whr);
			$this->db->order_by('razonsocial');
			$regs=$this->db->get('generador');
			if($regs->num_rows()==0)
				return false;
			return $regs->result_array();
		}
		return false;
	}
	public function delete($id=0)
	{
		// Elimina la realcion con el manifiesto, pero lo deja vivo
		// Elimina la realcion con la ruta, pero la deja viva
		// Elimina la realcion con el cliente, pero lo deja vivo
		if($this->idgenerador==""||$this->idgenerador==0)
		{
			if($id>0)
				$this->idgenerador=$id;
			else
				return false;
		}
		if(is_array($this->facturaciones) && count($this->facturaciones)>0)
		{
			$this->db->where("idfacturacion in (".implode(",",$this->facturaciones).")");
			$this->db->delete(array("relgenfac","facturacion"));
		}
		$this->db->where('idgenerador',$this->idgenerador);
		$this->db->delete(array('relgenman','relrutgen','relcligen','relgenfac','generador'));
	}
	public function nextIdentificador($idcliente=0)
	{
		if($this->idcliente==0)
		{
			if($idcliente!=0) $this->setIdcliente($idcliente);
			else return "";
		}
		$regs=$this->db->query("SELECT MAX(CONVERT(identificador,UNSIGNED)) AS identificador FROM (`generador`) WHERE `idgenerador` in (select idgenerador from relcligen where idcliente = {$this->idcliente})");
		$max=($regs->num_rows()>0?intval($regs->row_array()["identificador"]):0);
		return $max+1;
	}
	public function getIdgeneradoWithIdentificador($idcliente,$identificador)
	{
		$this->db->where("identificador = $identificador and idgenerador in (select idgenerador from relcligen where idcliente = $idcliente)");
		$regs=$this->db->get('generador');
		if($regs->num_rows()==0)
			return false;
		return $regs->row_array()["idgenerador"];
	}
	public function agregaFechaCalendario($id=0,$fecha)
	{
		if($this->idgenerador==""||$this->idgenerador==0)
		{
			if($id>0)
				$this->idgenerador=$id;
			else
				return false;
		}
		$this->db->insert("calendario",array("fecha"=>$fecha));
		$idcal=$this->db->insert_id();
		$this->db->insert("relgencal",array(
			"idgenerador"=>$this->idgenerador,
			"idcalendario"=>$idcal
		));
	}
	public function eliminaFechasCalendario($id=0)
	{
		if($this->idgenerador==""||$this->idgenerador==0)
		{
			if($id>0)
				$this->idgenerador=$id;
			else
				return false;
		}
		$this->db->where("idgenerador",$this->idgenerador);
		$regs=$this->db->get("relgencal");
		if($regs->num_rows()>0) foreach($regs->result_array() as $reg)
		{
			$this->db->where("idcalendario",$reg["idcalendario"]);
			$this->db->delete(array("relgencal","calendario"));
		}
	}
	public function getAllFromDate($fecha)
	{
		$this->db->where("idgenerador in (select idgenerador from relgencal where idcalendario in (select idcalendario from calendario where fecha='$fecha'))");
		$this->db->order_by('razonsocial');
		$regs=$this->db->get('generador');
		if($regs->num_rows()==0)
			return false;
		return $regs->result_array();
	}
	public function getRango($idCte,$genIni,$genFin)
	{
		$this->db->where("CONVERT(identificador,UNSIGNED) between $genIni and $genFin and idgenerador in (select idgenerador from relcligen where idcliente = '$idCte')");
		//$this->db->order_by("CONVERT(identificador,UNSIGNED), razonsocial");
		$regs=$this->db->get("generador");
		if($regs->num_rows()>0)
			return $regs->result_array();
		return array();
	}
	public function getFechasRango($fecIni,$fecFin)
	{
		if($this->idgenerador==""||$this->idgenerador==0)
		{
			return array();
		}
		$this->db->where("idcalendario in (select idcalendario from relgencal where idgenerador={$this->idgenerador})");
		$this->db->order_by("fecha");
		$regs=$this->db->get('calendario');
		if($regs->num_rows()>0) 
			return $regs->result_array();
		return array();
	}
	public function asJSON()
	{
		$data=array();
		foreach($this as $k=>$v)
			$data[$k]=$v;
		return json_encode($data);
	}
}
?>