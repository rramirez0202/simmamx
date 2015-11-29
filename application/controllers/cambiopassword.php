<?php
class Cambiopassword extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function index()
	{
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array(),true);
		$body=$this->load->view('cambiopassword/index',array("menumain"=>$menumain),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function cambiar()
	{
		$this->load->model('modusuario');
		$this->load->library('encrypt');
		$actual=trim($this->input->post('actual'));
		$nueva=trim($this->input->post('nueva'));
		$this->modusuario->getFromDatabase($this->session->userdata('idusuario'));
		if($this->modusuario->getPassword()!=$this->encrypt->sha1($actual))
			echo "La contraseña actual no coincide con la almacenada en el sistema.";
		else
		{
			$this->modusuario->updatePassword($nueva);
			echo "La contraseña ha sido establecida satisfactoriamente.";
			$this->modsesion->addLog(
				'cambiopassword',
				$this->modusuario->getIdusuario(),
				$this->modusuario->getNombre()." ".$this->modusuario->getApaterno(),
				"usuario",
				""
			);
			$cuerpomail=$this->load->view('inicio/dataaccesmail',array(
				"usr"=>$this->modusuario->getUsuario(),
				"pwd"=>$nueva
				),true);
			$this->load->library('email');
			$this->email->from('no-reply@simmamx.com',"Servicios Industriales para el Manejo del Medio Ambiente");
			$this->email->to($this->modusuario->getEmail());
			$this->email->message($cuerpomail);
			$this->email->subject('Alta en Sistema: Control de Manifiestos');
			if($this->email->send())
			{
				$this->modsesion->addLog(
					'enviomail',
					$this->modusuario->getIdusuario(),
					$this->modusuario->getNombre()." ".$this->modusuario->getApaterno(),
					"",
					""
				);
				echo "Se ha envíado un correo con los nuevos datos de acceso a {$this->modusuario->getEmail()}";
			}
			else
			{
				$this->modsesion->addLog(
					'errorenviomail',
					$this->modusuario->getIdusuario(),
					$this->modusuario->getNombre()." ".$this->modusuario->getApaterno(),
					"",
					""
				);
				echo "Ocurrió un error al enviar los nuevos datos de acceso a {$this->modusuario->getEmail()}";
			}
		}
	}
}
?>
