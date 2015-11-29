<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(58)): ?>
			<button type="button" class="btn btn-default" title="Nuevo Operador" onclick="location.href='<?= base_url('operadores/nuevo/'.$idempresa.'/'.$idsucursal);?>';">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Operadores</h3>
	<form class="form-horizontal" role="form" method="post" id="frm_prefer">
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Empresa</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_empresa" name="frm_prefer_empresa" onchange="location.href=baseURL+'operadores/index/'+$('#frm_prefer_empresa').val();">
					<?php foreach($empresas as $empresa): ?>
						<option value="<?= $empresa["idempresa"]; ?>" <?= ($empresa["idempresa"]==$idempresa?'selected="selected"':''); ?>><?= $empresa["razonsocial"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Sucursal</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_sucursal" name="frm_prefer_sucursal" onchange="location.href=baseURL+'operadores/index/'+$('#frm_prefer_empresa').val()+'/'+$('#frm_prefer_sucursal').val();">
					<?php foreach($sucursales as $sucursal): ?>
						<option value="<?= $sucursal["idsucursal"]; ?>" <?= ($sucursal["idsucursal"]==$idsucursal?'selected="selected"':''); ?>><?= $sucursal["nombre"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</form>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Cargo</th>
					<th>Teléfono</th>
					<th>Correo Electrónico</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Nombre</th>
					<th>Cargo</th>
					<th>Teléfono</th>
					<th>Correo Electrónico</th>
				</tr>
			</tfoot>
			<tbody>
				<?php if($operadores!==false) foreach($operadores as $operador): ?>
					<tr>
						<td>
							<?php if($this->modsesion->hasPermisoHijo(59)): ?>
							<a href="<?= base_url('operadores/ver/'.$operador["idoperador"]); ?>">
							<?php endif; ?>
								<?= $operador["nombre"]; ?>
								<?= $operador["apaterno"]; ?>
								<?= $operador["amaterno"]; ?>
							<?php if($this->modsesion->hasPermisoHijo(59)): ?>
							</a>
							<?php endif; ?>
						</td>
						<td><?= $operador["cargo"]?></td>
						<td><?= $operador["telefono"]?></td>
						<td><?= $operador["email"]?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){$("div.table-responsive table").DataTable();});
</script>