<?php
/*$cliente=new Modcliente();
$generador=new Modgenerador();
$ruta=new Modruta();*/
?>
<form class="form-horizontal" role="form" method="post" id="frm_validacion">
	<input type="hidden" id="frm_validacion_idcliente" name="frm_validacion_idcliente" value="<?= $cliente->getIdcliente(); ?>" />
	<input type="hidden" id="frm_validacion_idgenerador" name="frm_validacion_idgenerador" value="<?= $generador->getIdgenerador()?>" />
	<input type="hidden" id="frm_validacion_idruta" name="frm_validacion_idruta" value="<?= $ruta->getIdruta() ?>" />
	<div class="form-group">
		<label for="frm_validacion_cliente" class="col-sm-2 control-label">Cliente</label>
		<div class="col-sm-10">
			<p class="form-control-static"><?= $cliente->getIdentificador()." - ".$cliente->getRazonsocial(); ?></p>
		</div>
	</div>
	<div class="form-group">
		<label for="frm_validacion_generador" class="col-sm-2 control-label">Generador</label>
		<div class="col-sm-10">
			<p class="form-control-static"><?= $generador->getIdentificador()." - ".$generador->getRazonsocial(); ?></p>
		</div>
	</div>
	<div class="form-group">
		<label for="frm_validacion_ruta" class="col-sm-2 control-label">Ruta</label>
		<div class="col-sm-10">
			<p class="form-control-static"><?= $ruta->getIdentificador()." - ".$ruta->getNombre(); ?></p>
		</div>
	</div>
	<div class="form-group">
		<label for="frm_validacion_identificador" class="col-sm-2 control-label">No. de Manifiesto</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="frm_validacion_identificador" name="frm_validacion_identificador" value="<?= $identificador; ?>" maxlength="19" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-8"></div>
		<div class="col-sm-2">
            <button type="button" class="btn btn-success" onclick="Manifiesto.CrearManifiestoCteGen_Exec()" >Crear</button>
        </div>
        <div class="col-sm-2">
            <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url("manifiestos/index/$idempresa/$idsucursal"); ?>'">Cancelar</button>
        </div>
	</div>
</form>