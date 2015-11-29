<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(85)): ?>
			<button type="button" class="btn btn-default" title="Nuevo Permiso" onclick="Permiso.CapturarNuevosElementos()">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(86)):?>
			<button type="button" class="btn btn-default" title="Actualizar Permiso" onclick="Permiso.ActualizarElementos()">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(87)):?>
			<button type="button" class="btn btn-default" title="Borrar Permiso" onclick="Permiso.EliminarConfirm()">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Permisos</h3>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Permiso</th>
					<th>Descripción</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Permiso</th>
					<th>Descripción</th>
				</tr>
			</tfoot>
			<tbody id="elementosMenu">
				<?php if($permisos!==false) foreach($permisos as $permiso) PrintPermiso($permiso); ?>
			</tbody>
		</table>
	</div>
</div>
<?php
function PrintPermiso($permiso,$level=0)
{
	$levelStr="";
	for($x=1;$x<=$level;$x++)
		$levelStr.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	?>
	<tr>
		<td>
			<div class="checkbox">
				<?= $levelStr; ?>
				<label>
					<input type="checkbox" value="<?= $permiso["idpermiso"]; ?>" />
					(<?= $permiso["idpermiso"]; ?>) <?= $permiso["nombre"]; ?>
				</label>
			</div>
		</td>
		<td>
			<?= $permiso["descripcion"]; ?>
		</td>
	</tr>
	<?php
	if($permiso["hijos"]!==false)
		foreach($permiso["hijos"] as $p)
			PrintPermiso($p,$level+1);
}
?>