<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(83)): ?>
			<button type="button" class="btn btn-default" title="Nuevo Perfil" onclick="location.href='<?= base_url('perfiles/nuevo');?>';">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Perfiles</h3>
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
				<?php if($perfiles!==false) foreach($perfiles as $perfil): ?>
					<tr>
						<td>
							<?php if($this->modsesion->hasPermisoHijo(84)): ?>
							<a href="<?= base_url('perfiles/ver/'.$perfil["idperfil"])?>">
							<?php endif; ?>
								<?= $perfil["nombre"]; ?>
							<?php if($this->modsesion->hasPermisoHijo(84)): ?>
							</a>
							<?php endif; ?>
						</td>
						<td><?= $perfil["observaciones"]; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>