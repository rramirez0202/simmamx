<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(20)): ?>
			<button type="button" class="btn btn-default" title="Nuevo Vehiculo" onclick="location.href='<?= base_url('vehiculos/nuevo/'.$idempresa.'/'.$idsucursal);?>';">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Vehiculos</h3>
	<form class="form-horizontal" role="form" method="post" id="frm_prefer">
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Empresa</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_empresa" name="frm_prefer_empresa" onchange="location.href=baseURL+'vehiculos/index/'+$('#frm_prefer_empresa').val();">
					<?php foreach($empresas as $empresa): ?>
						<option value="<?= $empresa["idempresa"]; ?>" <?= ($empresa["idempresa"]==$idempresa?'selected="selected"':''); ?>><?= $empresa["razonsocial"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Sucursal</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_sucursal" name="frm_prefer_sucursal" onchange="location.href=baseURL+'vehiculos/index/'+$('#frm_prefer_empresa').val()+'/'+$('#frm_prefer_sucursal').val();">
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
					<th>Placa</th>
					<th>Número de Autorizacion SCT</th>
					<th>Número de Autorizacion SEMARNAT</th>
					<th>Tipo de Vehículo</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Placa</th>
					<th>Número de Autorizacion SCT</th>
					<th>Número de Autorizacion SEMARNAT</th>
					<th>Tipo de Vehículo</th>
				</tr>
			</tfoot>
			<tbody>
				<?php if($vehiculos!==false) foreach($vehiculos as $vehiculo): ?>
					<tr>
						<td>
							<?php if($this->modsesion->hasPermisoHijo(21)): ?>
							<a href="<?= base_url('vehiculos/ver/'.$vehiculo["idvehiculo"]); ?>">
							<?php endif; ?>
								<?= $vehiculo["placa"]; ?>
							<?php if($this->modsesion->hasPermisoHijo(21)): ?>
							</a>
							<?php endif; ?>
						</td>
						<td><?= $vehiculo["numautsct"]?></td>
						<td><?= $vehiculo["autsemarnat"]?></td>
						<td><?= $vehiculo["tipo"]?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){$("div.table-responsive table").DataTable();});
</script>