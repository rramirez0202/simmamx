<?= $menumain; ?>
<?php
$sucursal->getFromDatabase($objeto->getIdSucursal());
$operador->setIdoperador($objeto->getIdoperador());
$operador->getFromDatabase();
$vehiculo->setIdvehiculo($objeto->getIdvehiculo());
$vehiculo->getFromDatabase();
?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(52)): ?>
			<button type="button" class="btn btn-default" title="Ver todas las rutas" onclick="location.href='<?= base_url('rutas/index/'.$sucursal->getIdempresa().'/'.$sucursal->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(25)):?>
			<button type="button" class="btn btn-default" title="Ver la Sucursal Asociada" onclick="location.href='<?= base_url('sucursales/ver/'.$sucursal->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-eye-open"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(94)):?>
			<button type="button" class="btn btn-default" title="Ver Plan de Recoleccion" onclick="location.href='<?= base_url("rutas/planrecoleccion/".$objeto->getIdruta()); ?>'">
				<span class="glyphicon glyphicon-briefcase"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(73)):?>
			<button type="button" class="btn btn-default" title="Actualizar Ruta" onclick="location.href='<?= base_url('rutas/actualizar/'.$objeto->getIdruta()); ?>';">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(74)):?>
			<button type="button" class="btn btn-default" title="Borrar Ruta" onclick="Ruta.Eliminar(<?= $sucursal->getIdempresa(); ?>,<?= $sucursal->getIdsucursal(); ?>,<?= $objeto->getIdruta(); ?>)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Rutas</h3>
	<form class="form-horizontal" role="form" id="frm_rutas">
		<div class="form-group">
			<label for="frm_ruta_nombre" class="col-sm-2 control-label">Nombre de la Ruta</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNombre(); ?></p>
			</div>
			<label for="frm_ruta_identificador" class="col-sm-2 control-label">Número de Ruta</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getIdentificador(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="empresadestinofinal" class="col-sm-2 control-label">Planta de Tratamiento</label>
			<div class="col-sm-4">
				<?php
				$sucursal->setIdsucursal($objeto->getEmpresadestinofinal());
				$sucursal->getFromDatabase();
				$empresa->setIdempresa($sucursal->getIdempresa());
				$empresa->getFromDatabase();
				?>
				<p class="form-control-static"><?= "{$empresa->getRazonsocial()} - {$sucursal->getNombre()}"; ?></p>
			</div>
			<label for="empresatransportista" class="col-sm-2 control-label">Transportista</label>
			<div class="col-sm-4">
				<?php
				$sucursal->setIdsucursal($objeto->getEmpresatransportista());
				$sucursal->getFromDatabase();
				$empresa->setIdempresa($sucursal->getIdempresa());
				$empresa->getFromDatabase();
				?>
				<p class="form-control-static"><?= "{$empresa->getRazonsocial()} - {$sucursal->getNombre()}"; ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_ruta_descripcion" class="col-sm-2 control-label">Descripción de la Ruta</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getDescripcion(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_ruta_idoperador" class="col-sm-2 control-label">Operador</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= "{$operador->getNombre()} {$operador->getApaterno()} {$operador->getAmaterno()}"; ?></p>
			</div>
			<label for="frm_ruta_idvehiculo" class="col-sm-2 control-label">Vehiculo</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= "{$vehiculo->getPlaca()} ({$vehiculo->getTipo()})"; ?></p>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_ruta_serviciolunes" name="frm_ruta_serviciolunes" <?= ($objeto->getServiciolunes()==1?'checked="checked"':''); ?> disabled="disabled" />
						Lunes
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_ruta_serviciomartes" name="frm_ruta_serviciomartes" <?= ($objeto->getServiciomartes()==1?'checked="checked"':''); ?> disabled="disabled" />
						Martes
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_ruta_serviciomiercoles" name="frm_ruta_serviciomiercoles" <?= ($objeto->getServiciomiercoles()==1?'checked="checked"':''); ?> disabled="disabled" />
						Miércoles
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_ruta_serviciojueves" name="frm_ruta_serviciojueves" <?= ($objeto->getServiciojueves()==1?'checked="checked"':''); ?> disabled="disabled" />
						Jueves
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_ruta_servicioviernes" name="frm_ruta_servicioviernes" <?= ($objeto->getServicioviernes()==1?'checked="checked"':''); ?> disabled="disabled" />
						Viernes
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_ruta_serviciosabado" name="frm_ruta_serviciosabado" <?= ($objeto->getServiciosabado()==1?'checked="checked"':''); ?> disabled="disabled" />
						Sabado
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_ruta_serviciodomingo" name="frm_ruta_serviciodomingo" <?= ($objeto->getServiciodomingo()==1?'checked="checked"':''); ?> disabled="disabled" />
						Domingo
					</label>
				</div>
			</div>
		</div>
	</form>
	<h5>
		Generadores Asociados
		<?php if($this->modsesion->hasPermisoHijo(80)): ?>
	    <button type="button" class="btn btn-default btn-xs" title="Asociar Generadores" onclick="location.href='<?= base_url("rutas/agregargeneradores/".$objeto->getIdruta()); ?>'">
			<span class="glyphicon glyphicon-plus-sign"></span>
		</button>
	    <button type="button" class="btn btn-default btn-xs" title="Desasociador Generadores" onclick="location.href='<?= base_url("rutas/eliminargeneradores/".$objeto->getIdruta()); ?>'">
			<span class="glyphicon glyphicon-minus-sign"></span>
		</button>
		<?php endif; ?>
	</h5>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>No. Cliente</th>
					<th>Cliente</th>
					<th>No. Generador</th>
					<th>Generador</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>No. Cliente</th>
					<th>Cliente</th>
					<th>No. Generador</th>
					<th>Generador</th>
				</tr>
			</tfoot>
			<tbody>
				<?php
				$gs=$objeto->getGeneradoresAsociados($objeto->getIdruta());
				if($gs!==false && count($gs)>0) foreach($gs as $g)
				{
					$generador->setIdgenerador($g["idgenerador"]);
					$generador->getFromDatabase();
					$cliente->setIdcliente($generador->getIdcliente());
					$cliente->getFromDatabase();
					?>
					<tr>
						<td><?= $cliente->getIdentificador(); ?></td>
						<td><?= $cliente->getRazonsocial(); ?></td>
						<td><?= $generador->getIdentificador(); ?></td>
						<td><?= $generador->getRazonsocial(); ?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>