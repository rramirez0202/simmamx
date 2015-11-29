<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(26)): ?>
			<button type="button" class="btn btn-default" title="Ver todos los Usuarios" onclick="location.href='<?= base_url('usuarios'); ?>';">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(92)):?>
			<button type="button" class="btn btn-default" title="Actualizar Usuario" onclick="location.href='<?= base_url('usuarios/actualizar/'.$objeto->getIdusuario()); ?>';">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(93)):?>
			<button type="button" class="btn btn-default" title="Borrar Usuario" onclick="Usuario.Eliminar(<?= $objeto->getIdusuario(); ?>)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Usuarios</h3>
	<form class="form-horizontal" role="form" id="frm_usuarios">
        <input type="hidden" id="frm_usuario_idusuario" name="frm_usuario_idusuario" value="<?= $objeto->getIdusuario(); ?>" />
        <div class="form-group">
        	<label for="frm_usuario_nombre" class="col-sm-2 control-label">Nombre</label>
        	<div class="col-sm-10">
        		<p class="form-control-static"><?= $objeto->getNombre(); ?></p>
        	</div>
        </div>
        <div class="form-group">
        	<label for="frm_usuario_apaterno" class="col-sm-2 control-label">Apellido Paterno</label>
        	<div class="col-sm-4">
        		<p class="form-control-static"><?= $objeto->getApaterno(); ?></p>
        	</div>
        	<label for="frm_usuario_amaterno" class="col-sm-2 control-label">Apellido Materno</label>
        	<div class="col-sm-4">
        		<p class="form-control-static"><?= $objeto->getAmaterno(); ?></p>
        	</div>
        </div>
        <div class="form-group">
        	<label for="frm_usuario_usuario" class="col-sm-2 control-label">Usuario</label>
        	<div class="col-sm-4">
        		<p class="form-control-static"><?= $objeto->getUsuario(); ?></p>
        	</div>
        	<label for="frm_usuario_email" class="col-sm-2 control-label">Correo Electrónico</label>
        	<div class="col-sm-4">
        		<p class="form-control-static"><?= $objeto->getEmail(); ?></p>
        	</div>
        </div>
        <div class="col-sm-12">
        	<div class="checkbox">
        		<label>
        			<input type="checkbox" value="1" id="frm_usuario_activo" name="frm_usuario_activo" <?= ($objeto->getActivo()==1?'checked="checked"':''); ?> disabled="disabled" />
        			Activo
        		</label>
        	</div>
        </div>
        <div class="col-sm-12">
        	<fieldset>
        		<legend>Perfiles</legend>
        		<?php if($perfiles!==false) foreach($perfiles as $perfil): ?>
        			<div class="checkbox">
        				<label>
        					<input type="checkbox" value="<?= $perfil["idperfil"]; ?>" id="frm_usuario_perfiles[]" name="frm_usuario_perfiles[]" <?= (in_array($perfil["idperfil"],$objeto->getPerfiles())?' checked="checked"':''); ?> disabled="disabled" />
        					<?= $perfil["nombre"]; ?>
        				</label>
        			</div>
        		<?php endforeach; ?>
        	</fieldset>
        </div>
	</form>
</div>
