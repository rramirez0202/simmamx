<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(29)): ?>
			<button type="button" class="btn btn-default" title="Ver todos las Catalogos" onclick="location.href='<?= base_url('catalogos'); ?>';">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(47)):?>
			<button type="button" class="btn btn-default" title="Actualizar Catalogo" onclick="Catalogos.MuestraFrmUpd()">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(48)):?>
			<button type="button" class="btn btn-default" title="Agregar Opciones al Catalogo" onclick="Catalogos.MuestraFrmOpcs()">
				<span class="glyphicon glyphicon-plus"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(49)):?>
			<button type="button" class="btn btn-default" title="Borrar Opciones del Catalogo" onclick="Catalogos.BorrarOpciones()">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Catalogos <small><?= $catalogo["descripcion"]; ?></small></h3>
	<input type="hidden" name="idcatalogo" id="idcatalogo" value="<?= $catalogo["idcatalogo"]; ?>" />
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<td></td>
					<th>Opción</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td></td>
					<th>Opción</th>
				</tr>
			</tfoot>
			<tbody id="tablaOpciones">
				<?php if($catalogo["opciones"]!==false) foreach($catalogo["opciones"] as $opc): ?>
					<tr>
						<td>
							<input type="checkbox" value="<?= $opc["idcatalogodet"] ?>" />
						</td>
						<td>
							<?= $opc["descripcion"]; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){$("div.table-responsive table").DataTable();});
</script>