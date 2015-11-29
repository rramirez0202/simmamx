<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(24)): ?>
			<button type="button" class="btn btn-default" title="Nueva Sucursal" onclick="location.href='<?= base_url('sucursales/nuevo/'.$idempresa);?>';">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Sucursales</h3>
	<form class="form-horizontal" role="form" method="post" id="frm_prefer">
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Empresa</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_empresa" name="frm_prefer_empresa" onchange="location.href=baseURL+'sucursales/index/'+$('#frm_prefer_empresa').val();">
					<?php foreach($empresas as $empresa): ?>
						<option value="<?= $empresa["idempresa"]; ?>" <?= ($empresa["idempresa"]==$idempresa?'selected="selected"':''); ?>><?= $empresa["razonsocial"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</form>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Sucursal</th>
					<th>Representante</th>
					<th>Ubicación</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Sucursal</th>
					<th>Representante</th>
					<th>Ubicación</th>
				</tr>
			</tfoot>
			<tbody>
				<?php if($sucursales!==false) foreach($sucursales as $sucursal): ?>
				<tr>
					<td>
						<?php if($this->modsesion->hasPermisoHijo(25)): ?>
						<a href="<?= base_url('sucursales/ver/'.$sucursal["idsucursal"]); ?>">
						<?php endif; ?>
							<?= $sucursal["nombre"]; ?>
						<?php if($this->modsesion->hasPermisoHijo(25)): ?>
						</a>
						<?php endif; ?>
					</td>
					<td><?= $sucursal["representante"]; ?></td>
					<td>
						<?= $sucursal["municipio"]; ?>,
						<?= $sucursal["estado"]; ?>
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