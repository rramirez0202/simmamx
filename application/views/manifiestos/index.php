<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(30)): ?>
			<button type="button" class="btn btn-default" title="Generacion de Manifiestos" onclick="Manifiesto.MostrarMenuCreacion()">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; 
			if($this->modsesion->hasPermisoHijo(42)): ?>
			<button type="button" class="btn btn-default" title="Capturar Manifiestos" onclick="location.href='<?= base_url("manifiestos/capturar")?>'">
				<span class="glyphicon glyphicon-pencil"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Manifiestos</h3>
	<form class="form-horizontal" role="form" method="post" id="frm_prefer" action="<?= base_url("manifiestos/index/$idempresa/$idsucursal")?>">
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Empresa</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_empresa" name="frm_prefer_empresa" onchange="location.href=baseURL+'manifiestos/index/'+$('#frm_prefer_empresa').val();">
					<?php foreach($empresas as $empresa): ?>
						<option value="<?= $empresa["idempresa"]; ?>" <?= ($empresa["idempresa"]==$idempresa?'selected="selected"':''); ?>><?= $empresa["razonsocial"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_sucursal" class="col-sm-2 control-label">Sucursal</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_sucursal" name="frm_prefer_sucursal" onchange="location.href=baseURL+'manifiestos/index/'+$('#frm_prefer_empresa').val()+'/'+$('#frm_prefer_sucursal').val();">
					<?php foreach($sucursales as $sucursal): ?>
						<option value="<?= $sucursal["idsucursal"]; ?>" <?= ($sucursal["idsucursal"]==$idsucursal?'selected="selected"':''); ?>><?= $sucursal["nombre"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<h5>Búscar Manifiesto:</h5>
		<div class="form-group">
			<label for="frm_prefer_identificador" class="col-sm-2 control-label">No. de Manifiesto</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_prefer_identificador" name="frm_prefer_identificador" value="<?= $filtros["identificador"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_numruta" class="col-sm-2 control-label">No. de Ruta</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_prefer_numruta" name="frm_prefer_numruta" value="<?= $filtros["numruta"]; ?>" />
			</div>
			<label for="frm_prefer_nombreruta" class="col-sm-2 control-label">Ruta</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_prefer_nombreruta" name="frm_prefer_nombreruta" value="<?= $filtros["nombreruta"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_fecha_inicio" class="col-sm-2 control-label">Fecha</label>
			<div class="col-sm-5">
				<input type="date" class="form-control" id="frm_prefer_fecha_inicio" name="frm_prefer_fecha_inicio" value="<?= $filtros["fecha_inicio"]; ?>" />
			</div>
			<div class="col-sm-5">
				<input type="date" class="form-control" id="frm_prefer_fecha_fin" name="frm_prefer_fecha_fin" value="<?= $filtros["fecha_fin"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_identificadorcliente" class="col-sm-2 control-label">No. Cliente</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_prefer_identificadorcliente" name="frm_prefer_identificadorcliente" value="<?= $filtros["identificadorcliente"]; ?>" />
			</div>
			<label for="frm_prefer_identificadorgenerador" class="col-sm-2 control-label">No. Generador</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_prefer_identificadorgenerador" name="frm_prefer_identificadorgenerador" value="<?= $filtros["identificadorgenerador"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_razonsocial" class="col-sm-2 control-label">Razón Social</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_prefer_razonsocial" name="frm_prefer_razonsocial" value="<?= $filtros["razonsocial"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_rfc" class="col-sm-2 control-label">RFC</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_prefer_rfc" name="frm_prefer_rfc" value="<?= $filtros["rfc"]; ?>" />
			</div>
			<label for="frm_prefer_nra" class="col-sm-2 control-label">No. Registro Ambiental</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_prefer_nra" name="frm_prefer_nra" value="<?= $filtros["nra"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_destinofinal" class="col-sm-2 control-label">Destino Final</label>
			<div class="col-sm-4">
				<select class="form-control" id="frm_prefer_destinofinal" name="frm_prefer_destinofinal">
					<option value=""></option>
					<?php if($destinosfinales!==false) foreach($destinosfinales as $emp): ?>
						<optgroup label="<?= $emp["nombre"]; ?>">
							<?php foreach($emp["sucursales"] as $suc): ?>
								<option value="<?= $suc["idsucursal"]; ?>" <?= ($suc["idsucursal"]==$filtros["destinofinal"]?'selected="selected"':''); ?>>
									<?= $suc["nombre"]; ?>
								</option>
							<?php endforeach; ?>
						</optgroup>
					<?php endforeach; ?>
				</select>
			</div>
			<label for="frm_prefer_transportista" class="col-sm-2 control-label">Transportista</label>
			<div class="col-sm-4">
				<select class="form-control" id="frm_prefer_transportista" name="frm_prefer_transportista">
					<option value=""></option>
					<?php if($transportistas!==false) foreach($transportistas as $emp): ?>
						<optgroup label="<?= $emp["nombre"]; ?>">
							<?php foreach($emp["sucursales"] as $suc): ?>
								<option value="<?= $suc["idsucursal"]; ?>" <?= ($suc["idsucursal"]==$filtros["transportista"]?'selected="selected"':''); ?>>
									<?= $suc["nombre"]; ?>
								</option>
							<?php endforeach; ?>
						</optgroup>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_fechaembarque_inicio" class="col-sm-2 control-label">Fecha de Embarque</label>
			<div class="col-sm-5">
				<input type="date" class="form-control" id="frm_prefer_fechaembarque_inicio" name="frm_prefer_fechaembarque_inicio" value="<?= $filtros["fechaembarque_inicio"]; ?>" />
			</div>
			<div class="col-sm-5">
				<input type="date" class="form-control" id="frm_prefer_fechaembarque_fin" name="frm_prefer_fechaembarque_fin" value="<?= $filtros["fechaembarque_fin"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_fecharecepcion_inicio" class="col-sm-2 control-label">Fecha de Recepción</label>
			<div class="col-sm-5">
				<input type="date" class="form-control" id="frm_prefer_fecharecepcion_inicio" name="frm_prefer_fecharecepcion_inicio" value="<?= $filtros["fecharecepcion_inicio"]; ?>" />
			</div>
			<div class="col-sm-5">
				<input type="date" class="form-control" id="frm_prefer_fecharecepcion_fin" name="frm_prefer_fecharecepcion_fin" value="<?= $filtros["fecharecepcion_fin"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-10"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Manifiesto.Buscar()" >Buscar</button>
            </div>
		</div>
	</form>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>No. Manifiesto</th>
					<th>Fecha</th>
					<th>No. Cliente</th>
					<th>No. Generador</th>
					<th>Generador</th>
					<th>No. Ruta</th>
					<th>Ruta</th>
					<th>Transportista</th>
					<th>Destino Final</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>No. Manifiesto</th>
					<th>Fecha</th>
					<th>No. Cliente</th>
					<th>No. Generador</th>
					<th>Generador</th>
					<th>No. Ruta</th>
					<th>Ruta</th>
					<th>Transportista</th>
					<th>Destino Final</th>
				</tr>
			</tfoot>
			<tbody>
				<?php if($manifiestos!==false) foreach($manifiestos as $manifiesto): ?>
					<tr>
						<td data-order="<?= Refill($manifiesto["identificador"],10,"0"); ?>">
							<?php if($this->modsesion->hasPermisoHijo(32)): ?>
							<a href="<?= base_url("manifiestos/ver/".$manifiesto["idmanifiesto"]); ?>">
							<?php endif; ?>
								<?= $manifiesto["identificador"]; ?>
							<?php if($this->modsesion->hasPermisoHijo(32)): ?>
							</a>
							<?php endif; ?>
						</td>
						<td><?= DateToMx($manifiesto["fecha"]); ?></td>
						<td><?= $manifiesto["nocliente"]; ?></td>
						<td><?= $manifiesto["nogenerador"]; ?></td>
						<td><?= $manifiesto["generador"]; ?></td>
						<td><?= $manifiesto["noruta"]; ?></td>
						<td><?= $manifiesto["ruta"]; ?></td>
						<td><?= $manifiesto["destinofinal"]; ?></td>
						<td><?= $manifiesto["transportista"]; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){$("div.table-responsive table").DataTable();});
</script>