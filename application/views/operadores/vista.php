<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(8)): ?>
			<button type="button" class="btn btn-default" title="Ver todos los Operadores" onclick="location.href='<?= base_url('operadores/index/'.$sucursal->getIdempresa().'/'.$sucursal->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(25)):?>
			<button type="button" class="btn btn-default" title="Ver la Sucursal Asociada" onclick="location.href='<?= base_url('sucursales/ver/'.$sucursal->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-eye-open"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(60)):?>
			<button type="button" class="btn btn-default" title="Actualizar Operador" onclick="location.href='<?= base_url('operadores/actualizar/'.$objeto->getIdoperador()); ?>';">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(61)):?>
			<button type="button" class="btn btn-default" title="Borrar Operador" onclick="Operador.Eliminar(<?= $sucursal->getIdempresa(); ?>,<?= $sucursal->getIdsucursal(); ?>,<?= $objeto->getIdoperador(); ?>)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Operadores</h3>
	<form class="form-horizontal" role="form" id="frm_operadores">
		<div class="form-group">
			<label for="frm_operador_nombre" class="col-sm-2 control-label">Nombre</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getNombre(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_operador_apaterno" class="col-sm-2 control-label">Apellido Paterno</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getApaterno(); ?></p>
			</div>
			<label for="frm_operador_amaterno" class="col-sm-2 control-label">Apellido Materno</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getAmaterno(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_operador_detalle" class="col-sm-2 control-label">Comentarios</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getDetalle(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_operador_cargo" class="col-sm-2 control-label">Cargo</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getCargo(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_operador_telefono" class="col-sm-2 control-label">Teléfono</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getTelefono(); ?></p>
			</div>
			<label for="frm_operador_email" class="col-sm-2 control-label">Correo Electrónico</label>
			<div class="col-sm-4">
				<p class="form-control-static"><a href="mailto:<?= $objeto->getEmail(); ?>?subject=Correo enviado desde SIMMA. "><?= $objeto->getEmail(); ?></a></p>
			</div>
		</div>
	</form>
</div>
