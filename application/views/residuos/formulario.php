<?= $menumain; ?>
<div class="container">
	<h3>Residuos</h3>
	<form class="form-horizontal" role="form" id="frm_residuos">
		<input type="hidden" id="frm_residuo_idresiduo" name="frm_residuo_idresiduo" value="<?= $objeto->getIdresiduo(); ?>" />
		<input type="hidden" id="frm_residuo_idsucursal" name="frm_residuo_idsucursal" value="<?= $idsucursal; ?>" />
		<div class="form-group">
            <label for="frm_residuo_nombre" class="col-sm-2 control-label">Residuo <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_residuo_nombre" name="frm_residuo_nombre" value="<?= $objeto->getNombre(); ?>" placeholder="Nombre del Residuo" />
			</div>
			<label for="frm_residuo_nom052" class="col-sm-2 control-label">Residuo Norma-052 <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_residuo_nom052" name="frm_residuo_nom052" value="<?= $objeto->getNom052(); ?>" placeholder="Residuo Norma-052" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3"></div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_residuo_c" name="frm_residuo_c" <?= ($objeto->getC()==1?'checked="checked"':''); ?> />
						C
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_residuo_r" name="frm_residuo_r" <?= ($objeto->getR()==1?'checked="checked"':''); ?> />
						R
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_residuo_e" name="frm_residuo_e" <?= ($objeto->getE()==1?'checked="checked"':''); ?> />
						E
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_residuo_t" name="frm_residuo_t" <?= ($objeto->getT()==1?'checked="checked"':''); ?> />
						T
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_residuo_i" name="frm_residuo_i" <?= ($objeto->getI()==1?'checked="checked"':''); ?> />
						I
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_residuo_b" name="frm_residuo_b" <?= ($objeto->getB()==1?'checked="checked"':''); ?> />
						B
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3"></div>
			<div class="col-sm-5">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_residuo_reportecoa" name="frm_residuo_reportecoa" <?= ($objeto->getReportecoa()==1?'checked="checked"':''); ?> />
						Este residuo se reporta en COA
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Residuo.Enviar(<?= ($objeto->getIdresiduo()!="" && $objeto->getIdresiduo()!=0?'false':'true'); ?>)" >Guardar</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('vehiculos'); ?>'">Cancelar</button>
            </div>
		</div>
	</form>
</div>