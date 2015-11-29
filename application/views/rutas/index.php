<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(64)): ?>
			<button type="button" class="btn btn-default" title="Nueva Ruta" onclick="location.href='<?= base_url('rutas/nuevo/'.$idempresa.'/'.$idsucursal);?>';">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Rutas</h3>
	<form class="form-horizontal" role="form" method="post" id="frm_prefer">
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Empresa</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_empresa" name="frm_prefer_empresa" onchange="location.href=baseURL+'rutas/index/'+$('#frm_prefer_empresa').val();">
					<?php foreach($empresas as $empresa): ?>
						<option value="<?= $empresa["idempresa"]; ?>" <?= ($empresa["idempresa"]==$idempresa?'selected="selected"':''); ?>><?= $empresa["razonsocial"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Sucursal</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_sucursal" name="frm_prefer_sucursal" onchange="location.href=baseURL+'rutas/index/'+$('#frm_prefer_empresa').val()+'/'+$('#frm_prefer_sucursal').val();">
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
					<th>Número de Ruta</th>
					<th>Nombre</th>
					<th>Descripcion</th>
					<th>Planta de Tratamiento</th>
					<th>Transportista</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Número de Ruta</th>
					<th>Nombre</th>
					<th>Descripcion</th>
					<th>Planta de Tratamiento</th>
					<th>Transportista</th>
				</tr>
			</tfoot>
			<tbody>
				<?php if($rutas!==false) foreach($rutas as $ruta): ?>
					<tr>
						<td>
							<?php if($this->modsesion->hasPermisoHijo(65)): ?>
							<a href="<?= base_url('rutas/ver/'.$ruta["idruta"]); ?>">
							<?php endif; ?>
								<?= $ruta["identificador"]; ?>
							<?php if($this->modsesion->hasPermisoHijo(65)): ?>
							</a>
							<?php endif; ?>
						</td>
						<td><?= $ruta["nombre"]; ?></td>
						<td><?= $ruta["descripcion"]; ?></td>
						<td>
							<?php 
								$objruta->setIdruta($ruta["idruta"]);
								$objruta->getFromDatabase();
								$objsucursal->setIdsucursal($objruta->getEmpresadestinofinal());
								$objsucursal->getFromDatabase();
								$objempresa->setIdempresa($objsucursal->getIdempresa());
								$objempresa->getFromDatabase();
								echo "{$objempresa->getRazonsocial()} - {$objsucursal->getNombre()}";
							?>
						</td>
						<td>
							<?php 
								$objruta->getFromDatabase();
								$objsucursal->setIdsucursal($objruta->getEmpresatransportista());
								$objsucursal->getFromDatabase();
								$objempresa->setIdempresa($objsucursal->getIdempresa());
								$objempresa->getFromDatabase();
								echo "{$objempresa->getRazonsocial()} - {$objsucursal->getNombre()}";
							?>
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