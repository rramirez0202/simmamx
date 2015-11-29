<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(56)): ?>
			<button type="button" class="btn btn-default" title="Nueva Empresa" onclick="location.href='<?= base_url('empresas/nuevo');?>';">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Empresas</h3>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Razon Social</th>
					<th>RFC</th>
					<th>Representante</th>
					<th>Coorporativo</th>
					<th>Transportista</th>
					<th>Destino Final</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Razon Social</th>
					<th>RFC</th>
					<th>Representante</th>
					<th>Coorporativo</th>
					<th>Transportista</th>
					<th>Destino Final</th>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach($empresas as $empresa): ?>
					<tr>
						<td>
							<?php if($this->modsesion->hasPermisoHijo(57)): ?>
							<a href="<?= base_url('empresas/ver/'.$empresa["idempresa"]); ?>">
							<?php endif; ?>
								<?= $empresa["razonsocial"]; ?>
							<?php if($this->modsesion->hasPermisoHijo(57)): ?>
							</a>
							<?php endif; ?>
						</td>
						<td><?= $empresa["rfc"]; ?></td>
						<td><?= $empresa["representante"]; ?></td>
						<td><input type="checkbox" disabled="disabled" <?= ($empresa["coorporativo"]=="1"?'checked="checked"':''); ?> /></td>
						<td><input type="checkbox" disabled="disabled" <?= ($empresa["transportista"]=="1"?'checked="checked"':''); ?> /></td>
						<td><input type="checkbox" disabled="disabled" <?= ($empresa["destinofinal"]=="1"?'checked="checked"':''); ?> /></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){$("div.table-responsive table").DataTable();});
</script>