<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(110)): ?>
			<button type="button" class="btn btn-default" title="Nuevo Grupo" onclick="location.href='<?= base_url('grupos/nuevo');?>';">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Grupos</h3>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Descripción</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Nombre</th>
					<th>Descripción</th>
				</tr>
			</tfoot>
			<tbody>
				<?php if($grupos!==false) foreach($grupos as $grupo): ?>
					<tr>
						<td>
							<?php if($this->modsesion->hasPermisoHijo(111)): ?>
							<a href="<?= base_url('grupos/ver/'.$grupo["idgrupo"])?>">
							<?php endif; ?>
								<?= $grupo["nombre"]; ?>
							<?php if($this->modsesion->hasPermisoHijo(111)): ?>
							</a>
							<?php endif; ?>
						</td>
						<td><?= $grupo["descripcion"]; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>