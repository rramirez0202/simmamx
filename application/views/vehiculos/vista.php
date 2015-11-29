<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(9)): ?>
			<button type="button" class="btn btn-default" title="Ver todos los Vehiculos" onclick="location.href='<?= base_url('vehiculos/index/'.$sucursal->getIdempresa().'/'.$sucursal->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(25)):?>
			<button type="button" class="btn btn-default" title="Ver la Sucursal Asociada" onclick="location.href='<?= base_url('sucursales/ver/'.$sucursal->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-eye-open"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(22)):?>
			<button type="button" class="btn btn-default" title="Actualizar Vehículo" onclick="location.href='<?= base_url('vehiculos/actualizar/'.$objeto->getIdvehiculo()); ?>';">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(23)):?>
			<button type="button" class="btn btn-default" title="Borrar Vehículo" onclick="Vehiculo.Eliminar(<?= $sucursal->getIdempresa(); ?>,<?= $sucursal->getIdsucursal(); ?>,<?= $objeto->getIdvehiculo(); ?>)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Vehículos</h3>
	<form class="form-horizontal" role="form" id="frm_vehiculos">
        <div class="form-group">
            <label for="frm_vehiculo_tipo" class="col-sm-2 control-label">Tipo de Vehículo</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getTipo(); ?></p>
			</div>
			<label for="frm_vehiculo_placa" class="col-sm-2 control-label">Placa del Vehículo</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getPlaca(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_vehiculo_numautsct" class="col-sm-2 control-label">Número de Autorizacion SCT</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNumautsct(); ?></p>
			</div>
			<label for="frm_vehiculo_numautsct" class="col-sm-2 control-label">Número de Autorizacion SEMARNAT</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getAutsemarnat(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_vehiculo_detalle" class="col-sm-2 control-label">Comentarios</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getDetalle(); ?></p>
			</div>
		</div>
	</form>
</div>
