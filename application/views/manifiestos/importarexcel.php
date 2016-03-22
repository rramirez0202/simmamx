<?= $menumain; ?>
<div class="container">
	<h3>Importar Manifiestos <small>Desde Excel</small></h3>
	<form class="form-horizontal" role="form" id="frm_importar" method="post" action="<?= base_url("manifiestos/importar_exec/$tipo/$idempresa/$idsucursal"); ?>" enctype="multipart/form-data" onsubmit="Mensaje('Cargando Información')">
		<div class="form-group">
			<label for="frm_importar_archivo" class="col-sm-2 control-label">Archivo a importar</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" id="frm_importar_archivo" name="frm_importar_archivo" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
                <button type="submit" class="btn btn-success">Importar</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url("manifiestos/index/$idempresa/$idsucursal"); ?>'">Cancelar</button>
            </div>
		</div>
	</form>
	<div class="alert alert-info">
		El archivo a cargar requiere un formato especifico el cual puedes descargar haciendo clic
		<a href="<?= base_url("project_files/files/templates/rep_manifiesto_in.xlsx?date=".time())?>"> aquí</a>.
	</div>
</div>