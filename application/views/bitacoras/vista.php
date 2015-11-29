<?= $menumain; ?>
<?php
$sucursal->getFromDatabase($objeto->getIdSucursal());
$operador->setIdoperador($ruta->getIdoperador());
$operador->getFromDatabase();
$vehiculo->setIdvehiculo($ruta->getIdvehiculo());
$vehiculo->getFromDatabase();
$cliente=new Modcliente();
$generador=new Modgenerador();
$manifiesto=new ModManifiesto();
?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(19)): ?>
			<button type="button" class="btn btn-default" title="Ver todas las bitacoras" onclick="location.href='<?= base_url('bitacoras/index/'.$sucursal->getIdempresa().'/'.$sucursal->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(25)):?>
			<button type="button" class="btn btn-default" title="Ver la Sucursal Asociada" onclick="location.href='<?= base_url('sucursales/ver/'.$sucursal->getIdsucursal()); ?>';">
				<span class="glyphicon glyphicon-eye-open"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(97)):?>
			<button type="button" class="btn btn-default" title="Imprimir Bitácora" onclick="window.print()">
				<span class="glyphicon glyphicon-print"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(98)):?>
			<button type="button" class="btn btn-default" title="Imprimir Manifiestos" onclick="window.open('<?= base_url("bitacoras/imprimir/".$objeto->getIdbitacora()); ?>','bitacora')">
				<span class="glyphicon glyphicon-picture"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(96)):?>
			<button type="button" class="btn btn-default" title="Borrar Bitacora" onclick="Bitacora.Eliminar(<?= $sucursal->getIdempresa(); ?>,<?= $sucursal->getIdsucursal(); ?>,<?= $objeto->getIdbitacora(); ?>)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Bitacoras</h3>
	<form class="form-horizontal" role="form" id="frm_rutas">
		<div class="form-group">
			<label for="frm_ruta_nombre" class="col-xs-2 control-label">Nombre de la Bitacora</label>
			<div class="col-xs-4">
				<p class="form-control-static"><?= $objeto->getNombre(); ?></p>
			</div>
			<label for="frm_ruta_identificador" class="col-xs-2 control-label">Fecha de la Bitacora</label>
			<div class="col-xs-4">
				<p class="form-control-static"><?= DateToMx($objeto->getFecha()); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_ruta_nombre" class="col-xs-2 control-label">Nombre de la Ruta</label>
			<div class="col-xs-4">
				<p class="form-control-static"><?= $ruta->getNombre(); ?></p>
			</div>
			<label for="frm_ruta_identificador" class="col-xs-2 control-label">Número de Ruta</label>
			<div class="col-xs-4">
				<p class="form-control-static"><?= $ruta->getIdentificador(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="empresadestinofinal" class="col-xs-2 control-label">Planta de Tratamiento</label>
			<div class="col-xs-4">
				<?php
				$sucursal->setIdsucursal($ruta->getEmpresadestinofinal());
				$sucursal->getFromDatabase();
				$empresa->setIdempresa($sucursal->getIdempresa());
				$empresa->getFromDatabase();
				?>
				<p class="form-control-static"><?= "{$empresa->getRazonsocial()} - {$sucursal->getNombre()}"; ?></p>
			</div>
			<label for="empresatransportista" class="col-xs-2 control-label">Transportista</label>
			<div class="col-xs-4">
				<?php
				$sucursal->setIdsucursal($ruta->getEmpresatransportista());
				$sucursal->getFromDatabase();
				$empresa->setIdempresa($sucursal->getIdempresa());
				$empresa->getFromDatabase();
				?>
				<p class="form-control-static"><?= "{$empresa->getRazonsocial()} - {$sucursal->getNombre()}"; ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_ruta_idoperador" class="col-xs-2 control-label">Operador</label>
			<div class="col-xs-4">
				<p class="form-control-static"><?= "{$operador->getNombre()} {$operador->getApaterno()} {$operador->getAmaterno()}"; ?></p>
			</div>
			<label for="frm_ruta_idvehiculo" class="col-xs-2 control-label">Vehiculo</label>
			<div class="col-xs-4">
				<p class="form-control-static"><?= "{$vehiculo->getPlaca()} ({$vehiculo->getTipo()})"; ?></p>
			</div>
		</div>
	</form>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Cliente</th>
					<th>Generador</th>
					<th>Manifiesto</th>
					<th>Ubicacion</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Cliente</th>
					<th>Generador</th>
					<th>Manifiesto</th>
					<th>Ubicacion</th>
				</tr>
			</tfoot>
			<tbody>
				<?php if($objeto->getManifiestos()!==false) foreach($objeto->getManifiestos() as $man):
					$manifiesto->setIdmanifiesto($man);
					$manifiesto->getFromDatabase();
					$generador->setIdgenerador($manifiesto->getIdgenerador());
					$generador->getFromDatabase();
					$cliente->setIdcliente($generador->getIdcliente());
					$cliente->getFromDatabase();
				?>
				<tr>
					<td><?= "{$cliente->getIdentificador()} - {$cliente->getRazonsocial()}"?></td>
					<td><?= "{$generador->getIdentificador()} - {$generador->getRazonsocial()}"?></td>
					<td><?= $manifiesto->getIdentificador(); ?></td>
					<td>
						<?= $generador->getCalle(); ?>
						<?= ($generador->getNumexterior()!=""?" , Num. ".$generador->getNumexterior():""); ?>
						<?= ($generador->getNuminterior()!=""?" (Int.".$generador->getNuminterior().")":""); ?><br />
						<?= $generador->getColonia(); ?><br />
						<?= $generador->getMunicipio(); ?><br />
						<?= $generador->getEstado(); ?><br />
						C.P. <?= $generador->getCp(); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
</div>