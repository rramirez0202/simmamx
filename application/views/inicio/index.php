<?= $menumain; ?>
<div class="container">
	<hr />
	<div class="row">
		<?php
		$dir=dir($this->config->item('ruta_templates').'indicadores');
		$k=1;
		$inds=array();
		while(($archivo=$dir->read())!==false)
		{
			if(strtolower(substr($archivo,strlen($archivo)-4))=="json")
			{
				array_push($inds,$archivo);
			}
		}
		$dir->close();
		sort($inds);
		foreach($inds as $archivo)
		{
			$indicador=json_decode(file_get_contents($this->config->item('ruta_templates')."indicadores/$archivo"),true);
			?>
			<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">
							<?= $indicador["nombre"]; ?>
						</h3>
					</div>
					<div class="panel-body" id="indicador_<?= explode(".",$archivo)[0]; ?>">
						<div class="center-block">Cargando Indicador</div>
						<div class="progress progress-striped active">
							<div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
								<span class="sr-only">Obteniendo Indicador</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			if($k%3==0)
			{
				echo '</div><div class="row">';
			}
			$k++;
		}
		?>
	</div>
</div>
<?php if(count($inds)>0): ?>
	<script type="text/javascript" src="<?= base_url("project_files/js/chart.js?time=".time()); ?>"></script>
	<script type="text/javascript" src="<?= base_url("project_files/js/indicador.js?time=".time()); ?>"></script>
	<script type="text/javascript">
		var indicadores=<?= json_encode($inds)?>;
		indicadores.reverse();
		$(document).ready(function(){
			GenerarIndicador();
		});
	</script>
<?php endif; ?>