<?php
class Usuarios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function index()
	{
		$this->load->model('modusuario');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$usuarios=$this->modusuario->getAll();
		$body=$this->load->view('usuarios/index',array(
			"menumain"=>$menumain,
			"usuarios"=>$usuarios
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function nuevo()
	{
		$this->load->model('modusuario');
		$this->load->model('modperfil');
		$this->load->model('modgrupo');
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('usuarios/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modusuario,
			"perfiles"=>$this->modperfil->getAll(),
			"grupos"=>$this->modgrupo->getAll()
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function add()
	{
		$this->load->model('modusuario');
		$this->modusuario->getFromInput();
		$this->modusuario->addToDatabase();
		echo $this->modusuario->getIdusuario();
		$this->modsesion->addLog(
			'agregar',
			$this->modusuario->getIdusuario(),
			$this->modusuario->getNombre()." ".$this->modusuario->getApaterno(),
			"usuario",
			"relperusu"
		);
		$pwd=$this->modusuario->generaPassword();
		$this->modsesion->addLog(
			'reseteopassword',
			$this->modusuario->getIdusuario(),
			$this->modusuario->getNombre()." ".$this->modusuario->getApaterno(),
			"usuario",
			""
		);
		$cuerpomail=$this->load->view('inicio/dataaccesmail',array(
			"usr"=>$this->modusuario->getUsuario(),
			"pwd"=>$pwd
			),true);
		$this->load->library('email');
		$this->email->from('no-reply@simmamx.com',"Servicios Industriales para el Manejo del Medio Ambiente");
		$this->email->to($this->modusuario->getEmail());
		$this->email->message($cuerpomail);
		$this->email->subject('Alta en Sistema: Control de Manifiestos');
		if($this->email->send())
			$this->modsesion->addLog(
				'enviomail',
				$this->modusuario->getIdusuario(),
				$this->modusuario->getNombre()." ".$this->modusuario->getApaterno(),
				"usuario",
				""
			);
		else
			$this->modsesion->addLog(
				'errorenviomail',
				$this->modusuario->getIdusuario(),
				$this->modusuario->getNombre()." ".$this->modusuario->getApaterno(),
				"",
				""
			);
	}
	public function update()
	{
		$this->load->model('modusuario');
		$this->modusuario->getFromInput();
		$this->modusuario->updateToDatabase();
		echo $this->modusuario->getIdusuario();
		$this->modsesion->addLog(
			'actualizar',
			$this->modusuario->getIdusuario(),
			$this->modusuario->getNombre()." ".$this->modusuario->getApaterno(),
			"usuario",
			"relperusu"
		);
	}
	public function ver($id)
	{
		$this->load->model('modusuario');
		$this->load->model('modperfil');
		$this->load->model('modgrupo');
		$this->modusuario->getFromDatabase($id);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('usuarios/vista',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modusuario,
			"perfiles"=>$this->modperfil->getAll(),
			"grupos"=>$this->modgrupo->getAll()
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
		$this->modsesion->addLog(
			'verdetalle',
			$this->modusuario->getIdusuario(),
			$this->modusuario->getNombre()." ".$this->modusuario->getApaterno(),
			"",
			""
		);
	}
	public function actualizar($id)
	{
		$this->load->model('modusuario');
		$this->load->model('modperfil');
		$this->load->model('modgrupo');
		$this->modusuario->getFromDatabase($id);
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('usuarios/formulario',array(
			"menumain"=>$menumain,
			"objeto"=>$this->modusuario,
			"perfiles"=>$this->modperfil->getAll(),
			"grupos"=>$this->modgrupo->getAll()
			),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function eliminar($id)
	{
		$this->load->model('modusuario');
		$this->modusuario->delete($id);
		$this->modsesion->addLog(
			'eliminar',
			$this->modusuario->getIdusuario(),
			$this->modusuario->getNombre()." ".$this->modusuario->getApaterno(),
			"usuario",
			"relperusu"
		);
	}
}
?>
