<?= $menumain; ?>
<div class="container">
	<h3>Asociar Generadores <small><?= $ruta->getIdentificador()." - ".$ruta->getNombre(); ?></small></h3>
	<form class="form-horizontal" role="form" id="frm_rutas">
		<div class="form-group">
			<label for="cliente" class="col-sm-2 control-label">No. Cliente:</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" id="cliente" name="cliente" />
			</div>
			<label for="generador" class="col-sm-2 control-label">No. Generador</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" id="generador" name="generador" />
			</div>
			<div class="col-sm-2">
            	<button type="button" class="btn btn-default" onclick="Ruta.BuscarCteGen()">
            		<span class="glyphicon glyphicon-search"></span>
            	</button>
        	</div>
		</div>
	</form>
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
			<tbody id="generadores"></tbody>
		</table>
	</div>
	<input type="hidden" id="idruta" name="idruta" value="<?= $ruta->getIdruta(); ?>" />
	<div class="row">
		<div class="col-sm-8"></div>
		<div class="col-sm-2">
            <button type="button" class="btn btn-success" onclick="Ruta.AddGeneradores()">Asociar</button>
        </div>
        <div class="col-sm-2">
            <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url("rutas/ver/".$ruta->getIdruta()); ?>'">Cancelar</button>
        </div>
	</div>
</div>