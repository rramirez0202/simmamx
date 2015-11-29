<?= $menumain; ?>
<?php
$objruta=new Modruta();
$objsucursal=new Modsucursal();
$objempresa=new Modempresa();
?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(7)): ?>
			<button type="button" class="btn btn-default" title="Ver todas las Sucurales" onclick="location.href='<?= base_url('sucursales/index/'.$objeto->getIdEmpresa()); ?>';">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(57)):?>
			<button type="button" class="btn btn-default" title="Ver la Empresa Asociada" onclick="location.href='<?= base_url('empresas/ver/'.$objeto->getIdEmpresa()); ?>';">
				<span class="glyphicon glyphicon-eye-open"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(50)):?>
			<button type="button" class="btn btn-default" title="Actualizar Sucursal" onclick="location.href='<?= base_url('sucursales/actualizar/'.$objeto->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(51)):?>
			<button type="button" class="btn btn-default" title="Borrar Sucursal" onclick="Sucursal.Eliminar(<?= $objeto->getIdempresa(); ?>,<?= $objeto->getIdsucursal(); ?>)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Sucursales <small><?= $objeto->getNombre(); ?></small></h3>
	<form class="form-horizontal" role="form" id="frm_sucursales" method="post">
		<div class="form-group">
			<label for="frm_sucursal_nombre" class="col-sm-2 control-label">Razón Social</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getNombre(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_sucursal_iniales" class="col-sm-2 control-label">Iniciales</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getIniciales(); ?></p>
			</div>
		</div>
		<h5>Dirección</h5>
		<div class="form-group">
			<label for="frm_sucursal_calle" class="col-sm-2 control-label">Calle</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getCalle(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_sucursal_numexterior" class="col-sm-2 control-label">Número Exterior</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNumexterior(); ?></p>
			</div>
			<label for="frm_sucursal_numinterior" class="col-sm-2 control-label">Número Interior</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNuminterior(); ?></p>
			</div>
		</div>
		<div class="form-group">
		    <label for="frm_sucursal_cp" class="col-sm-2 control-label">Código Postal</label></span>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCp(); ?></p>
			</div>
			<label for="frm_sucursal_colonia" class="col-sm-2 control-label">Colonia</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getColonia(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_sucursal_municipio" class="col-sm-2 control-label">Delegación o Municipio</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getMunicipio(); ?></p>
			</div>
			<label for="frm_sucursal_estado" class="col-sm-2 control-label">Estado</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getEstado(); ?></p>
			</div>
		</div>
		<h5>Contacto</h5>
		<div class="form-group">
			<label for="frm_sucursal_representante" class="col-sm-2 control-label">Representante</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getRepresentante(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_sucursal_cargorepresentante" class="col-sm-2 control-label">Cargo</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCargorepresentante(); ?></p>
			</div>
			<label for="frm_sucursal_telefono" class="col-sm-2 control-label">Teléfono</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getTelefono(); ?></p>
			</div>
		</div>
		<h5>Legal</h5>
		<div class="form-group">
			<label for="frm_sucursal_autsemarnat" class="col-sm-2 control-label">Número de Autorización SEMARNAT</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getAutsemarnat(); ?></p>
			</div>
			<label for="frm_sucursal_registrosct" class="col-sm-2 control-label">Número de Registro SCT</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getRegistrosct(); ?></p>
			</div>
		</div>
		<!--<div class="form-group">
			<label for="frm_sucursal_numregamb" class="col-sm-2 control-label">Número de Registro Ambiental <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getNumregamb(); ?></p>
			</div>
		</div>-->
		<?php if($this->modsesion->hasPermisoHijo(8) && count($operadores)>0): ?>
			<h5>Operadores</h5>
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
									<a href="<?= base_url('operadores/ver/'.$operador["idoperador"]); ?>">
										<?= $operador["nombre"]; ?>
										<?= $operador["apaterno"]; ?>
										<?= $operador["amaterno"]; ?>
									</a>
								</td>
								<td><?= $operador["cargo"]; ?></td>
								<td><?= $operador["telefono"]; ?></td>
								<td><A href="mailto:<?= $operador["email"]; ?>?subject=Correo enviado desde SIMMA. "><?= $operador["email"]; ?></a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; 
		if($this->modsesion->hasPermisoHijo(9) && count($vehiculos)>0): ?>
			<h5>Vehiculos</h5>
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
									<a href="<?= base_url('vehiculos/ver/'.$vehiculo["idvehiculo"]); ?>">
										<?= $vehiculo["placa"]; ?>
									</a>
								</td>
								<td><?= $vehiculo["numautsct"]; ?></td>
								<td><?= $vehiculo["autsemarnat"]; ?></td>
								<td><?= $vehiculo["tipo"]; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; 
		if($this->modsesion->hasPermisoHijo(52) && count($rutas)>0):?>
			<h5>Rutas</h5>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Número de Ruta</th>
							<th>Nombre</th>
							<th>Descripcion</th>
							<th>Destino Final</th>
							<th>Transportista</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Número de Ruta</th>
							<th>Nombre</th>
							<th>Descripcion</th>
							<th>Destino Final</th>
							<th>Transportista</th>
						</tr>
					</tfoot>
					<tbody>
						<?php if($rutas!==false) foreach($rutas as $ruta): ?>
							<tr>
								<td>
									<a href="<?= base_url('rutas/ver/'.$ruta["idruta"]); ?>">
										<?= $ruta["identificador"]; ?>
									</a>
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
		<?php endif; ?>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){$("div.table-responsive table").DataTable();});
</script>