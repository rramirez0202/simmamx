<?= $menumain; ?>
<div class="container">
	<h3>Operadores</h3>
	<form class="form-horizontal" role="form" id="frm_operadores">
		<input type="hidden" id="frm_operador_idoperador" name="frm_operador_idoperador" value="<?= $objeto->getIdoperador(); ?>" />
		<input type="hidden" id="frm_operador_idsucursal" name="frm_operador_idsucursal" value="<?= $idsucursal; ?>" />
		<div class="form-group">
			<label for="frm_operador_nombre" class="col-sm-2 control-label">Nombre <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_operador_nombre" name="frm_operador_nombre" value="<?= $objeto->getNombre(); ?>" placeholder="Nombre del Operador" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_operador_apaterno" class="col-sm-2 control-label">Apellido Paterno</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_operador_apaterno" name="frm_operador_apaterno" value="<?= $objeto->getApaterno(); ?>" placeholder="Apellido Paterno" />
			</div>
			<label for="frm_operador_amaterno" class="col-sm-2 control-label">Apellido Materno</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_operador_amaterno" name="frm_operador_amaterno" value="<?= $objeto->getAmaterno(); ?>" placeholder="Apellido Materno" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_operador_detalle" class="col-sm-2 control-label">Comentarios</label>
			<div class="col-sm-10">
				<textarea rows="3" class="form-control" id="frm_operador_detalle" name="frm_operador_detalle"><?= $objeto->getDetalle(); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_operador_cargo" class="col-sm-2 control-label">Cargo</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_operador_cargo" name="frm_operador_cargo" value="<?= $objeto->getCargo(); ?>" placeholder="Cargo del Operador" maxlength="37" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_operador_telefono" class="col-sm-2 control-label">Teléfono</label>
			<div class="col-sm-4">
				<input type="tel" class="form-control" id="frm_operador_telefono" name="frm_operador_telefono" value="<?= $objeto->getTelefono(); ?>" placeholder="Teléfono del Operador" maxlength="13" />
			</div>
			<label for="frm_operador_email" class="col-sm-2 control-label">Correo Electrónico</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_operador_email" name="frm_operador_email" value="<?= $objeto->getEmail(); ?>" placeholder="Correo Eletrónico del Operador" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Operador.Enviar(<?= ($objeto->getIdoperador()!="" && $objeto->getIdoperador()!=0?'false':'true'); ?>)" >Guardar</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('operadores'); ?>'">Cancelar</button>
            </div>
		</div>
	</form>
</div>
