<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(45)): ?>
			<button type="button" class="btn btn-default" title="Nuevo Catalogo" onclick="Catalogos.MuestraFrmNuevo()">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Catalogos</h3>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Catalogo</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Catalogo</th>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach($catalogos as $catalogo): ?>
					<tr>
						<td>
							<?php if($this->modsesion->hasPermisoHijo(46)): ?>
							<a href="<?= base_url('catalogos/ver/'.$catalogo["idcatalogo"]); ?>">
							<?php endif; ?>
								<?= $catalogo["descripcion"]; ?>
							<?php if($this->modsesion->hasPermisoHijo(46)): ?>
							</a>
							<?php endif; ?>
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