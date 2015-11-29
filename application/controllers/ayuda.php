<?php
class Ayuda extends CI_Controller
{
	public function index()
	{        
		$vista=$this->showView('index');
		$this->displayHelp($vista);
	}
	private function showView($view="",$params=array())
	{
		return $this->load->view("ayuda/$view",$params,true);
	}
	private function displayHelp($view)
	{
		$head=$this->load->view('html/head',array(),true);
		$vista=$this->load->view("ayuda/vista",array("vista"=>$view),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$vista));
	}
	private function getConfig($elemento)
	{
		$elemento=trim($elemento);
		$this->config->load('app_help');
		$conf=$this->config->item('helpItems');
		$topics=explode("/",$elemento);
		if($elemento=="")
			return $conf["config"];
		while(count($topics)>0)
		{
			$actual=array_shift($topics);
			if($actual!="")
				$conf=$conf[$actual];
		}
		return $conf["config"];
	}
	public function generalidades($nivel2="",$nivel3="",$nivel4="",$nivel5="",$return=false,$showTopBar=true)
	{
		$vista="";
		$cfg=null;
		switch($nivel2)
		{
			case 'metodologia':
				$cfg=$this->getConfig("acceso/$nivel2");
				break;
			case 'espaciotrabajo':
				if(in_array($nivel3,array("menuprincipal","barraherramientas")))
					$cfg=$this->getConfig("acceso/$nivel2/$nivel3");
				else
				{
					$vista.=$this->configuracion($nivel2,"menuprincipal","","",true,false);
					$vista.=$this->configuracion($nivel2,"barraherramientas","","",true,false);
					$cfg=$this->getConfig("acceso/$nivel2");
				}
			default:
				$vista.=$this->configuracion("metodologia","","","",true,false);
				$vista.=$this->configuracion("espaciotrabajo","","","",true,false);
				$cfg=$this->getConfig("acceso");
		}
		$cfg["show_top_bar_view"]=$showTopBar;
		$cfg["extra"]=$vista;
		$vista=$this->showView('generica_video',$cfg);
		if($return)
			return $vista;
		$this->displayHelp($vista);
	}
	public function acceso($nivel2="",$nivel3="",$nivel4="",$nivel5="",$return=false,$showTopBar=true)
	{
		$vista="";
		$cfg=null;
		if(in_array($nivel2,array("primeravez","sistema","olvidopassword","cambiopassword")))
			$cfg=$this->getConfig("acceso/$nivel2");
		else
		{
			$vista.=$this->configuracion("primeravez","","","",true,false);
			$vista.=$this->configuracion("sistema","","","",true,false);
			$vista.=$this->configuracion("olvidopassword","","","",true,false);
			$vista.=$this->configuracion("cambiopassword","","","",true,false);
			$cfg=$this->getConfig("acceso");
		}
		$cfg["show_top_bar_view"]=$showTopBar;
		$cfg["extra"]=$vista;
		$vista=$this->showView('generica_video',$cfg);
		if($return)
			return $vista;
		$this->displayHelp($vista);
	}
	public function operacion($nivel2="",$nivel3="",$nivel4="",$nivel5="",$return=false,$showTopBar=true)
	{
		$vista="";
		$cfg=null;
		switch($nivel2)
		{
			case 'manifiestos':
				switch($nivel3)
				{
					case 'nuevos':
						if(in_array($nivel4,array("clientegenerador","rutacompleta","rutacalendario","calendario")))
							$cfg=$this->getConfig("operacion/$nivel2/$nivel3/$nivel4");
						else
						{
							$vista.=$this->configuracion($nivel2,$nivel3,"clientegenerador","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"rutacompleta","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"rutacalendario","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"calendario","",true,false);
							$cfg=$this->getConfig("operacion/$nivel2/$nivel3");
						}
						break;
					case 'ver':
						if(in_array($nivel4,array("capturar","imprimir","borrar")))
							$cfg=$this->getConfig("operacion/$nivel2/$nivel3/$nivel4");
						else
						{
							$vista.=$this->configuracion($nivel2,$nivel3,"capturar","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"imprimir","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"borrar","",true,false);
							$cfg=$this->getConfig("operacion/$nivel2/$nivel3");
						}
						break;
					case 'capturarapida':
						if(in_array($nivel4,array("numero","bitacora")))
							$cfg=$this->getConfig("operacion/$nivel2/$nivel3/$nivel4");
						else
						{
							$vista.=$this->configuracion($nivel2,$nivel3,"numero","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"bitacora","",true,false);
							$cfg=$this->getConfig("operacion/$nivel2/$nivel3");
						}
						break;
					default:
						$vista.=$this->configuracion($nivel2,"nuevos","","",true,false);
						$vista.=$this->configuracion($nivel2,"ver","","",true,false);
						$vista.=$this->configuracion($nivel2,"capturarapida","","",true,false);
						$cfg=$this->getConfig("operacion/$nivel2");
				}
				break;
			case 'bitacoras':
				$cfg=$this->getConfig("operacion/$nivel2");
				break;
			default:
				$vista.=$this->configuracion("manifiestos","","","",true,false);
				$vista.=$this->configuracion("bitacoras","","","",true,false);
				$cfg=$this->getConfig("operacion");
		}
		$cfg["show_top_bar_view"]=$showTopBar;
		$cfg["extra"]=$vista;
		$vista=$this->showView('generica_video',$cfg);
		if($return)
			return $vista;
		$this->displayHelp($vista);
	}
	public function administracion($nivel2="",$nivel3="",$nivel4="",$nivel5="",$return=false,$showTopBar=true)
	{
		$vista="";
		$cfg=null;
		switch($nivel2)
		{
			case 'clientes':
				switch($nivel3)
				{
					case 'nuevo':
						$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						break;
					case 'ver':
						switch($nivel4)
						{
							case 'generadores':
								if(in_array($nivel5,array("nuevo","actualizar","eliminar","asociarrutas","calendarizar")))
									$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4/$nivel5");
								else
								{
									$vista.=$this->configuracion($nivel2,$nivel3,$nivel4,"nuevo",true,false);
									$vista.=$this->configuracion($nivel2,$nivel3,$nivel4,"actualizar",true,false);
									$vista.=$this->configuracion($nivel2,$nivel3,$nivel4,"eliminar",true,false);
									$vista.=$this->configuracion($nivel2,$nivel3,$nivel4,"asociarrutas",true,false);
									$vista.=$this->configuracion($nivel2,$nivel3,$nivel4,"calendarizar",true,false);
									$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4");
								}
								break;
							case 'actualizar':
								$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4");
								break;
							case 'eliminar':
								$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4");
								break;
							default:
								$vista.=$this->configuracion($nivel2,$nivel3,"generadores","",true,false);
								$vista.=$this->configuracion($nivel2,$nivel3,"actualizar","",true,false);
								$vista.=$this->configuracion($nivel2,$nivel3,"eliminar","",true,false);
								$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						}
						break;
					default:
						$vista.=$this->configuracion($nivel2,"nuevo","","",true,false);
						$vista.=$this->configuracion($nivel2,"ver","","",true,false);
						$cfg=$this->getConfig("configuracion/$nivel2");
				}
				break;
			case 'empresas':
				switch($nivel3)
				{
					case 'nuevo':
						$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						break;
					case 'ver':
						if(in_array($nivel4,array("actualizar","eliminar")))
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4");
						else
						{
							$vista.=$this->configuracion($nivel2,$nivel3,"actualizar","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"eliminar","",true,false);
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						}
						break;
					default:
						$vista.=$this->configuracion($nivel2,"nuevo","","",true,false);
						$vista.=$this->configuracion($nivel2,"ver","","",true,false);
						$cfg=$this->getConfig("configuracion/$nivel2");
				}
				break;
			case 'sucursales':
				switch($nivel3)
				{
					case 'nuevo':
						$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						break;
					case 'ver':
						if(in_array($nivel4,array("actualizar","eliminar")))
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4");
						else
						{
							$vista.=$this->configuracion($nivel2,$nivel3,"actualizar","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"eliminar","",true,false);
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						}
						break;
					default:
						$vista.=$this->configuracion($nivel2,"nuevo","","",true,false);
						$vista.=$this->configuracion($nivel2,"ver","","",true,false);
						$cfg=$this->getConfig("configuracion/$nivel2");
				}
				break;
			case 'operadores':
				switch($nivel3)
				{
					case 'nuevo':
						$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						break;
					case 'ver':
						if(in_array($nivel4,array("actualizar","eliminar")))
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4");
						else
						{
							$vista.=$this->configuracion($nivel2,$nivel3,"actualizar","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"eliminar","",true,false);
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						}
						break;
					default:
						$vista.=$this->configuracion($nivel2,"nuevo","","",true,false);
						$vista.=$this->configuracion($nivel2,"ver","","",true,false);
						$cfg=$this->getConfig("configuracion/$nivel2");
				}
				break;
			case 'vehiculos':
				switch($nivel3)
				{
					case 'nuevo':
						$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						break;
					case 'ver':
						if(in_array($nivel4,array("actualizar","eliminar")))
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4");
						else
						{
							$vista.=$this->configuracion($nivel2,$nivel3,"actualizar","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"eliminar","",true,false);
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						}
						break;
					default:
						$vista.=$this->configuracion($nivel2,"nuevo","","",true,false);
						$vista.=$this->configuracion($nivel2,"ver","","",true,false);
						$cfg=$this->getConfig("configuracion/$nivel2");
				}
				break;
			case 'rutas':
				switch($nivel3)
				{
					case 'nuevo':
						$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						break;
					case 'ver':
						if(in_array($nivel4,array("actualizar","eliminar","asociargeneradores")))
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4");
						else
						{
							$vista.=$this->configuracion($nivel2,$nivel3,"actualizar","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"eliminar","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"asociargeneradores","",true,false);
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						}
						break;
					default:
						$vista.=$this->configuracion($nivel2,"nuevo","","",true,false);
						$vista.=$this->configuracion($nivel2,"ver","","",true,false);
						$cfg=$this->getConfig("configuracion/$nivel2");
				}
				break;
			case 'residuos':
				switch($nivel3)
				{
					case 'nuevo':
						$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						break;
					case 'ver':
						if(in_array($nivel4,array("actualizar","eliminar")))
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4");
						else
						{
							$vista.=$this->configuracion($nivel2,$nivel3,"actualizar","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"eliminar","",true,false);
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						}
						break;
					default:
						$vista.=$this->configuracion($nivel2,"nuevo","","",true,false);
						$vista.=$this->configuracion($nivel2,"ver","","",true,false);
						$cfg=$this->getConfig("configuracion/$nivel2");
				}
				break;
			default:
				$vista.=$this->configuracion("clientes","","","",true,false);
				$vista.=$this->configuracion("empresas","","","",true,false);
				$vista.=$this->configuracion("sucursales","","","",true,false);
				$vista.=$this->configuracion("operadores","","","",true,false);
				$vista.=$this->configuracion("operadores","","","",true,false);
				$vista.=$this->configuracion("vehiculos","","","",true,false);
				$vista.=$this->configuracion("rutas","","","",true,false);
				$vista.=$this->configuracion("residuos","","","",true,false);
				$cfg=$this->getConfig("configuracion");
		}
		$cfg["show_top_bar_view"]=$showTopBar;
		$cfg["extra"]=$vista;
		$vista=$this->showView('generica_video',$cfg);
		if($return)
			return $vista;
		$this->displayHelp($vista);
	}
	public function configuracion($nivel2="",$nivel3="",$nivel4="",$nivel5="",$return=false,$showTopBar=true)
	{
		$vista="";
		$cfg=null;
		switch($nivel2)
		{
			case 'usuarios':
				$cfg=$this->getConfig('configuracion/usuarios');
				break;
			case 'permisos':
				$cfg=$this->getConfig('configuracion/permisos');
				break;
			case 'perfiles':
				$cfg=$this->getConfig('configuracion/perfiles');
				break;
			case 'catalogos':
				switch($nivel3)
				{
					case 'nuevo':
						$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						break;
					case 'ver':
						if(in_array($nivel4,array("actualizar","agregaropciones","eliminaropciones")))
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3/$nivel4");
						else
						{
							$vista.=$this->configuracion($nivel2,$nivel3,"actualizar","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"agregaropciones","",true,false);
							$vista.=$this->configuracion($nivel2,$nivel3,"eliminaropciones","",true,false);
							$cfg=$this->getConfig("configuracion/$nivel2/$nivel3");
						}
						break;
					default:
						$vista.=$this->configuracion($nivel2,"nuevo","","",true,false);
						$vista.=$this->configuracion($nivel2,"ver","","",true,false);
						$cfg=$this->getConfig("configuracion/$nivel2");
				}
				break;
			default:
				$vista.=$this->configuracion("usuarios","","","",true,false);
				$vista.=$this->configuracion("permisos","","","",true,false);
				$vista.=$this->configuracion("perfiles","","","",true,false);
				$vista.=$this->configuracion("catalogos","","","",true,false);
				$cfg=$this->getConfig('configuracion');
		}
		$cfg["show_top_bar_view"]=$showTopBar;
		$cfg["extra"]=$vista;
		$vista=$this->showView('generica_video',$cfg);
		if($return)
			return $vista;
		$this->displayHelp($vista);
	}
}
?>