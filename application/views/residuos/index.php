<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(62)): ?>
			<button type="button" class="btn btn-default" title="Nuevo Residuo" onclick="location.href='<?= base_url('residuos/nuevo/'.$idempresa.'/'.$idsucursal);?>';">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Residuos</h3>
	<form class="form-horizontal" role="form" method="post" id="frm_prefer">
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Empresa</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_empresa" name="frm_prefer_empresa" onchange="location.href=baseURL+'residuos/index/'+$('#frm_prefer_empresa').val();">
					<?php foreach($empresas as $empresa): ?>
						<option value="<?= $empresa["idempresa"]; ?>" <?= ($empresa["idempresa"]==$idempresa?'selected="selected"':''); ?>><?= $empresa["razonsocial"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Sucursal</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_sucursal" name="frm_prefer_sucursal" onchange="location.href=baseURL+'residuos/index/'+$('#frm_prefer_empresa').val()+'/'+$('#frm_prefer_sucursal').val();">
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
					<th>Nom-052</th>
					<th>C</th>
					<th>R</th>
					<th>E</th>
					<th>T</th>
					<th>I</th>
					<th>B</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Nombre</th>
					<th>Nom-052</th>
					<th>C</th>
					<th>R</th>
					<th>E</th>
					<th>T</th>
					<th>I</th>
					<th>B</th>
				</tr>
			</tfoot>
			<tbody>
				<?php if($residuos!==false) foreach($residuos as $residuo): ?>
					<tr>
						<td>
							<?php if($this->modsesion->hasPermisoHijo(63)): ?>
							<a href="<?= base_url('residuos/ver/'.$residuo["idresiduo"]); ?>">
							<?php endif; ?>
								<?= $residuo["nombre"]; ?>
							<?php if($this->modsesion->hasPermisoHijo(63)): ?>
							</a>
							<?php endif; ?>
						</td>
						<td><?= $residuo["nom052"]?></td>
						<td><input type="checkbox" <?= ($residuo["C"]==1?'checked="checked"':''); ?> disabled="disabled" /></td>
						<td><input type="checkbox" <?= ($residuo["R"]==1?'checked="checked"':''); ?> disabled="disabled" /></td>
						<td><input type="checkbox" <?= ($residuo["E"]==1?'checked="checked"':''); ?> disabled="disabled" /></td>
						<td><input type="checkbox" <?= ($residuo["T"]==1?'checked="checked"':''); ?> disabled="disabled" /></td>
						<td><input type="checkbox" <?= ($residuo["I"]==1?'checked="checked"':''); ?> disabled="disabled" /></td>
						<td><input type="checkbox" <?= ($residuo["B"]==1?'checked="checked"':''); ?> disabled="disabled" /></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){$("div.table-responsive table").DataTable();});
</script>