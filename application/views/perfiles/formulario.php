<?= $menumain; ?>
<div class="container">
	<h3>Perfiles</h3>
	<form class="form-horizontal" role="form" id="frm_perfiles">
        <input type="hidden" id="frm_perfil_idperfil" name="frm_perfil_idperfil" value="<?= $objeto->getIdperfil(); ?>" />
        <div class="form-group">
        	<label for="frm_perfil_nombre" class="col-sm-2 control-label">Nombre <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
        	<div class="col-sm-10">
        		<input type="text" class="form-control" id="frm_perfil_nombre" name="frm_perfil_nombre" value="<?= $objeto->getNombre(); ?>" placeholder="Nombre del perfil" maxlength="250" />
        	</div>
        </div>
        <div class="form-group">
        	<label for="frm_perfil_observaciones" class="col-sm-2 control-label">Observaciones</label>
        	<div class="col-sm-10">
        		<textarea rows="3" class="form-control" id="frm_perfil_observaciones" name="frm_perfil_observaciones"><?= $objeto->getObservaciones(); ?></textarea>
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
        							<input type="checkbox" id="frm_perfil_sucursales[]" name="frm_perfil_sucursales[]" value="<?= $suc["idsucursal"]; ?>" <?= (in_array($suc["idsucursal"],$objeto->getSucursales())?'checked="checked"':''); ?> />
        							<?= $suc["nombre"]; ?>
        						</label>
        					</div>
        				<?php endforeach; ?>
        			<?php endforeach; ?>
        		</fieldset>
        	</div>
        </div>
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Perfil.Enviar(<?= ($objeto->getIdperfil()!="" && $objeto->getIdperfil()!=0?'false':'true'); ?>)" >Guardar</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('perfiles'); ?>'">Cancelar</button>
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
			<input type="checkbox" id="frm_perfil_permisos[]" name="frm_perfil_permisos[]" value="<?= $permiso["idpermiso"]; ?>" <?= (in_array($permiso["idpermiso"],$objeto->getPermisos())?'checked="checked"':''); ?> />
			(<?= $permiso["idpermiso"]; ?>) <?= $permiso["nombre"]; ?>
		</label>
	</div>
	<?php
	if($permiso["hijos"]!==false)
		foreach($permiso["hijos"] as $p)
			PrintPermiso($objeto,$p,$level+1);
}
?>