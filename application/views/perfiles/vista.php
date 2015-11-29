<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(28)): ?>
			<button type="button" class="btn btn-default" title="Ver todos los Perfiles" onclick="location.href='<?= base_url('perfiles'); ?>';">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(90)):?>
			<button type="button" class="btn btn-default" title="Actualizar Perfil" onclick="location.href='<?= base_url('perfiles/actualizar/'.$objeto->getIdperfil()); ?>';">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(91)):?>
			<button type="button" class="btn btn-default" title="Borrar Perfil" onclick="Perfil.Eliminar(<?= $objeto->getIdperfil(); ?>)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Perfiles</h3>
	<form class="form-horizontal" role="form" id="frm_perfiles">
        <input type="hidden" id="frm_perfil_idperfil" name="frm_perfil_idperfil" value="<?= $objeto->getIdperfil(); ?>" />
        <div class="form-group">
        	<label for="frm_perfil_nombre" class="col-sm-2 control-label">Nombre</label>
        	<div class="col-sm-10">
        		<p class="form-control-static"><?= $objeto->getNombre(); ?></p>
        	</div>
        </div>
        <div class="form-group">
        	<label for="frm_perfil_observaciones" class="col-sm-2 control-label">Observaciones</label>
        	<div class="col-sm-10">
        		<p class="form-control-static"><?= $objeto->getObservaciones(); ?></p>
        	</div>
        </div>
        <div class="form-group">
        	<div class="col-sm-6">
        		<fieldset>
        			<legend>Permisos</legend>
        			<?php if($permisos!==false) foreach($permisos as $permiso) PrintPermiso($objeto, $permiso); ?>
        		</fieldset>
        	</div>
        	<div class="col-sm-6">
        		<fieldset>
        			<legend>Sucursales</legend>
        			<?php if($sucursales!==false) foreach($sucursales as $emp): ?>
        				<div><strong><?= $emp["razonsocial"] ?></strong></div>
        				<?php if($emp["sucursales"]!==false) foreach($emp["sucursales"] as $suc): ?>
        					<div class="checkbox">
        						<label>
        							<input type="checkbox" id="frm_perfil_sucursales[]" name="frm_perfil_sucursales[]" value="<?= $suc["idsucursal"]; ?>" <?= (in_array($suc["idsucursal"],$objeto->getSucursales())?'checked="checked"':''); ?> disabled="disabled" />
        							<?= $suc["nombre"]; ?>
        						</label>
        					</div>
        				<?php endforeach; ?>
        			<?php endforeach; ?>
        		</fieldset>
        	</div>
        </div>
	</form>
</div>
<?php
function PrintPermiso($objeto, $permiso,$level=0)
{
	$levelStr="";
	for($x=1;$x<=$level;$x++)
		$levelStr.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	?>
	<div class="checkbox">
		<?= $levelStr; ?>
		<label>
			<input type="checkbox" id="frm_perfil_permisos[]" name="frm_perfil_permisos" value="<?= $permiso["idpermiso"]; ?>" <?= (in_array($permiso["idpermiso"],$objeto->getPermisos())?'checked="checked"':''); ?> disabled="disabled" />
			(<?= $permiso["idpermiso"]; ?>) <?= $permiso["nombre"]; ?>
		</label>
	</div>
	<?php
	if($permiso["hijos"]!==false)
		foreach($permiso["hijos"] as $p)
			PrintPermiso($objeto,$p,$level+1);
}
?>