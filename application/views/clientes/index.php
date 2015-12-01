<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(54)): ?>
			<button type="button" class="btn btn-default" title="Importar Clientes" onclick="location.href='<?= base_url("clientes/importar/$idempresa/$idsucursal"); ?>'">
				<span class="glyphicon glyphicon-circle-arrow-up"></span>
			</button>
			<button type="button" class="btn btn-default" title="Nuevo Cliente" onclick="location.href='<?= base_url('clientes/nuevo/'.$idempresa.'/'.$idsucursal);?>';">
				<span class="glyphicon glyphicon-list-alt"></span>
			</button>
			<?php endif; 
			if($this->modsesion->hasPermisoHijo(100)): ?>
			<button type="button" class="btn btn-default" title="Generar Reportes" onclick="Cliente.FrmReporte()">
				<span class="glyphicon glyphicon-book"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Clientes</h3>
	<form class="form-horizontal" role="form" method="post" id="frm_prefer" action="<?= base_url("clientes/index/$idempresa/$idsucursal"); ?>">
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Empresa</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_empresa" name="frm_prefer_empresa" onchange="location.href=baseURL+'clientes/index/'+$('#frm_prefer_empresa').val();">
					<?php foreach($empresas as $empresa): ?>
						<option value="<?= $empresa["idempresa"]; ?>" <?= ($empresa["idempresa"]==$idempresa?'selected="selected"':''); ?>><?= $empresa["razonsocial"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_empresa" class="col-sm-2 control-label">Sucursal</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_prefer_sucursal" name="frm_prefer_sucursal" onchange="location.href=baseURL+'clientes/index/'+$('#frm_prefer_empresa').val()+'/'+$('#frm_prefer_sucursal').val();">
					<?php foreach($sucursales as $sucursal): ?>
						<option value="<?= $sucursal["idsucursal"]; ?>" <?= ($sucursal["idsucursal"]==$idsucursal?'selected="selected"':''); ?>><?= $sucursal["nombre"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<h5>Búscar Cliente:</h5>
		<div class="form-group">
			<label for="frm_prefer_identificador" class="col-sm-2 control-label">Número de Cliente</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_prefer_identificador" name="frm_prefer_identificador" value="<?= $filtros["identificador"]; ?>" />
			</div>
			<label for="frm_prefer_rfc" class="col-sm-2 control-label">RFC</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_prefer_rfc" name="frm_prefer_rfc" value="<?= $filtros["rfc"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_razonsocial" class="col-sm-2 control-label">Razon Social</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_prefer_razonsocial" name="frm_prefer_razonsocial" value="<?= $filtros["razonsocial"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_vendedor" class="col-sm-2 control-label">Vendedor</label>
			<div class="col-sm-4">
				<select id="frm_prefer_vendedor" name="frm_prefer_vendedor" class="form-control">
					<option value=""></option>
					<?php if($vendedor!==false) foreach($vendedor["opciones"] as $opc): ?>
						<option value="<?= $opc["idcatalogodet"]; ?>" <?= ($opc["idcatalogodet"]==$filtros["vendedor"]?'selected="selected"':''); ?> >
							<?= $opc["descripcion"]; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<label for="frm_prefer_giro" class="col-sm-2 control-label">Giro</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_prefer_giro" name="frm_prefer_giro" value="<?= $filtros["giro"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_prefer_observaciones" class="col-sm-2 control-label">Observaciones</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_prefer_observaciones" name="frm_prefer_observaciones" value="<?= $filtros["observaciones"]; ?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-10"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Cliente.Buscar()" >Buscar</button>
            </div>
		</div>
	</form>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Número de Cliente</th>
					<th>Razon Social</th>
					<th>RFC</th>
					<th>Ubicación</th>
					<th>Venderdor</th>
					<th>Giro</th>
					<th>Contrato</th>
					<!--<th>Servicios</th>-->
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Número de Cliente</th>
					<th>Razon Social</th>
					<th>RFC</th>
					<th>Ubicación</th>
					<th>Venderdor</th>
					<th>Giro</th>
					<th>Contrato</th>
					<!--<th>Servicios</th>-->
				</tr>
			</tfoot>
			<tbody>
				<?php if($clientes!==false) foreach($clientes as $cliente): ?>
					<tr>
						<td data-order="<?= Refill($cliente["identificador"],10,"0"); ?>">
							<?php if($this->modsesion->hasPermisoHijo(55)): ?>
							<a href="<?= base_url('clientes/ver/'.$cliente["idcliente"]); ?>">
							<?php endif; ?>
								<?= $cliente["identificador"]; ?>
							<?php if($this->modsesion->hasPermisoHijo(55)): ?>
							</a>
							<?php endif; ?>
						</td>
						<td><?= $cliente["razonsocial"]; ?></td>
						<td><?= $cliente["rfc"]; ?></td>
						<td><?= "{$cliente["municipio"]}, {$cliente["estado"]}"; ?></td>
						<td><?php 
							if($vendedor!==false) 
								foreach($vendedor["opciones"] as $opc) 
									if($opc["idcatalogodet"]==$cliente["vendedor"])
										echo $opc["descripcion"];
						?></td>
						<td><?= $cliente["giro"]; ?></td>
						<td><?= DateToMx($cliente["fechacontratoinicio"])." al ".DateToMx($cliente["fechacontratofin"]); ?></td>
						<!--<td><?= DateToMx($cliente["fechaserviciosinicio"])." al ".DateToMx($cliente["fechaserviciosfin"]); ?></td>-->
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){$("div.table-responsive table").DataTable();});
</script>