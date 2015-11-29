<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(53)): ?>
			<button type="button" class="btn btn-default" title="Ver todos los Residuos" onclick="location.href='<?= base_url('residuos/index/'.$sucursal->getIdempresa().'/'.$sucursal->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(25)):?>
			<button type="button" class="btn btn-default" title="Ver la Sucursal Asociada" onclick="location.href='<?= base_url('sucursales/ver/'.$sucursal->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-eye-open"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(71)):?>
			<button type="button" class="btn btn-default" title="Actualizar Residuo" onclick="location.href='<?= base_url('residuos/actualizar/'.$objeto->getIdresiduo()); ?>';">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(72)):?>
			<button type="button" class="btn btn-default" title="Borrar Residuo" onclick="Residuo.Eliminar(<?= $sucursal->getIdempresa(); ?>,<?= $sucursal->getIdsucursal(); ?>,<?= $objeto->getIdresiduo(); ?>)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Residuos</h3>
	<form class="form-horizontal" role="form" id="frm_residuos">
		<div class="form-group">
            <label for="frm_residuo_nombre" class="col-sm-2 control-label">Residuo <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNombre(); ?></p>
			</div>
			<label for="frm_residuo_nom052" class="col-sm-2 control-label">Residuo Norma-052 <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNom052(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-3"></div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_residuo_c" name="frm_residuo_c" <?= ($objeto->getC()==1?'checked="checked"':''); ?> />
						C
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_residuo_r" name="frm_residuo_r" <?= ($objeto->getR()==1?'checked="checked"':''); ?> />
						R
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_residuo_e" name="frm_residuo_e" <?= ($objeto->getE()==1?'checked="checked"':''); ?> />
						E
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_residuo_t" name="frm_residuo_t" <?= ($objeto->getT()==1?'checked="checked"':''); ?> />
						T
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_residuo_i" name="frm_residuo_i" <?= ($objeto->getI()==1?'checked="checked"':''); ?> />
						I
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_residuo_b" name="frm_residuo_b" <?= ($objeto->getB()==1?'checked="checked"':''); ?> />
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
						<input disabled="disabled" type="checkbox" value="1" id="frm_residuo_reportecoa" name="frm_residuo_reportecoa" <?= ($objeto->getReportecoa()==1?'checked="checked"':''); ?> />
						Este residuo se reporta en COA
					</label>
				</div>
			</div>
		</div>
	</form>
</div>