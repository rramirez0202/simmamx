<?php
class Reporte extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if(!($this->modsesion->logedin()))
			header("location: ".base_url("sesiones/logout"));
	}
	public function ver($idreporte)
	{
		$this->load->model("modreporte");
		$this->modreporte->setIdreporte($idreporte);
		$this->modreporte->getFromDatabase();
		$head=$this->load->view('html/head',array(),true);
		$menumain=$this->load->view('menu/menumain',array("justCloseWindow"=>true),true);
		$body=$this->load->view('reporte/reporte',array("menumain"=>$menumain,"reporte"=>$this->modreporte),true);
		$this->load->view('html/html',array("head"=>$head,"body"=>$body));
	}
	public function ejecutar()
	{
		$id=$this->input->post('idreporte');
		if($id!==false && $id>0)
		{
			$this->load->model("modreporte");
			$this->modreporte->setIdreporte($id);
			$this->modreporte->getFromDatabase();
			$this->modreporte->getParamsFromInput();
			$this->load->view('reporte/grid',array("registros"=>$this->modreporte->execute()));
		}
	}
	public function exportar()
	{
		$id=$this->input->post('idreporte');
		if($id!==false && $id>0)
		{
			$this->load->model("modreporte");
			$this->modreporte->setIdreporte($id);
			$this->modreporte->getFromDatabase();
			$this->modreporte->getParamsFromInput();
			$regs=$this->modreporte->execute();
			if($regs!==false && count($regs)>0)
			{
				$doc=new DOMDocument("1.0","utf-8");
				$raiz=$doc->createElement("libro");
				$props=$doc->createElement("propiedades");
				$props->setAttribute("template",$this->modreporte->getPlantilla());
				$props->setAttribute("titulo",$this->modreporte->getTitulo());
				$hoja=$doc->createElement("hoja");
				$hoja->setAttribute("titulo","Reporte");
				$hoja->setAttribute("iniciarEnFila","2");
				foreach($regs as $reg)
				{
					$fila=$doc->createElement("fila");
					foreach($reg as $celda)
					{
						$cld=$doc->createElement("celda");
						$cldCont=$doc->createCDATASection($celda);
						$cld->appendChild($cldCont);
						$fila->appendChild($cld);
					}
					$hoja->appendChild($fila);
				}
				$raiz->appendChild($props);
				$raiz->appendChild($hoja);
				$doc->appendChild($raiz);
				$doc->formatOutput=true;
				$archivo="reporte_".time().".xml";
				$doc->save($this->config->item("ruta_downloads").$archivo);
				$url=base_url("project_files/app/make_excel_from_xml.php?arch=$archivo&path=".base_url("reporte/descargarExcel"));
				header("location: ".$url);
			}
		}
		echo " No hay registros para exportar";
	}
	public function descargarExcel($archivo)
	{
		if($archivo!="")
		{
			$this->load->library('zip');
			$this->zip->read_file($this->config->item("ruta_downloads").$archivo);
			$this->zip->download(str_replace(".xlsx",".zip",$archivo));
		}
	}
}
?>