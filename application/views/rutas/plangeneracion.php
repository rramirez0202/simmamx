<?= $menumain; ?>
<div class="container">
	<h3>Plan de Recolección <small><?= $ruta->getIdentificador()." - ".$ruta->getNombre(); ?></small></h3>
	<form class="form-horizontal" role="form" id="frm_rutas">
		<input type="hidden" name="ruta" id="ruta" value="<?= $ruta->getIdruta(); ?>" />
		<input type="hidden" name="ruta_name" id="ruta_name" value="<?= $ruta->getIdentificador()." - ".$ruta->getNombre(); ?>" />
		<div class="form-group">
			<label for="fecha" class="col-sm-2 control-label">Fecha:</label>
			<div class="col-sm-4">
				<input type="date" class="form-control" id="fecha" name="fecha" value="<?= $fecha; ?>" />
			</div>
			<div class="col-sm-2"></div>
			<div class="col-sm-2">
	        	<button type="button" class="btn btn-success" onclick="Ruta.VerPlanRecoleccion()">Mostar</button>
		    </div>
		    <div class="col-sm-2">
		        <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url("rutas/ver/".$ruta->getIdruta()); ?>'">Cancelar</button>
		    </div>
		</div>
	</form>
	<div id="prevalidacion"></div>
</div>