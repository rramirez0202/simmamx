<?= $menumain; ?>
<div class="container">
	<h3>Desasociar Generadores <small><?= $ruta->getIdentificador()." - ".$ruta->getNombre(); ?></small></h3>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th></th>
					<th>No. Cliente</th>
					<th>Cliente</th>
					<th>No. Generador</th>
					<th>Generador</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th></th>
					<th>No. Cliente</th>
					<th>Cliente</th>
					<th>No. Generador</th>
					<th>Generador</th>
				</tr>
			</tfoot>
			<tbody id="generadores">
				<?php
				$gs=$ruta->getGeneradoresAsociados($ruta->getIdruta());
				if($gs!==false && count($gs)>0) foreach($gs as $g)
				{
					$generador->setIdgenerador($g["idgenerador"]);
					$generador->getFromDatabase();
					$cliente->setIdcliente($generador->getIdcliente());
					$cliente->getFromDatabase();
					?>
					<tr>
						<td><input type="checkbox" value="<?= $generador->getIdgenerador(); ?>" /></td>
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
	<input type="hidden" id="idruta" name="idruta" value="<?= $ruta->getIdruta(); ?>" />
	<div class="row">
		<div class="col-sm-8"></div>
		<div class="col-sm-2">
            <button type="button" class="btn btn-success" onclick="Ruta.DelGeneradores()" >Desasociar</button>
        </div>
        <div class="col-sm-2">
            <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url("rutas/ver/".$ruta->getIdruta()); ?>'">Cancelar</button>
        </div>
	</div>
</div>