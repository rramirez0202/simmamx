<?= $menumain; ?>
<div class="container">
	<h3>Vehículos</h3>
	<form class="form-horizontal" role="form" id="frm_vehiculos">
        <input type="hidden" id="frm_vehiculo_idvehiculo" name="frm_vehiculo_idvehiculo" value="<?= $objeto->getIdvehiculo(); ?>" />
        <input type="hidden" id="frm_vehiculo_idsucursal" name="frm_vehiculo_idsucursal" value="<?= $idsucursal; ?>" />
		<div class="form-group">
            <label for="frm_vehiculo_tipo" class="col-sm-2 control-label">Tipo de Vehículo</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_vehiculo_tipo" name="frm_vehiculo_tipo" value="<?= $objeto->getTipo(); ?>" placeholder="Tipo de Vehículo" maxlength="28" />
			</div>
			<label for="frm_vehiculo_placa" class="col-sm-2 control-label">Placa del Vehículo <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_vehiculo_placa" name="frm_vehiculo_placa" value="<?= $objeto->getPlaca(); ?>" placeholder="Placa del Vehículo" maxlength="20" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_vehiculo_numautsct" class="col-sm-2 control-label">Número de Autorizacion SCT</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_vehiculo_numautsct" name="frm_vehiculo_numautsct" value="<?= $objeto->getNumautsct(); ?>" placeholder="Número de Autorizacion SCT" />
			</div>
			<label for="frm_vehiculo_numautsct" class="col-sm-2 control-label">Número de Autorizacion SEMARNAT</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_vehiculo_autsemarnat" name="frm_vehiculo_autsemarnat" value="<?= $objeto->getAutsemarnat(); ?>" placeholder="Número de Autorizacion SEMARNAT" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_vehiculo_detalle" class="col-sm-2 control-label">Comentarios</label>
			<div class="col-sm-10">
				<textarea rows="3" class="form-control" id="frm_vehiculo_detalle" name="frm_vehiculo_detalle"><?= $objeto->getDetalle(); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Vehiculo.Enviar(<?= ($objeto->getIdvehiculo()!="" && $objeto->getIdvehiculo()!=0?'false':'true'); ?>)" >Guardar</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('vehiculos'); ?>'">Cancelar</button>
            </div>
		</div>
	</form>
</div>
