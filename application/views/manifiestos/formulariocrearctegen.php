<?= $menumain; ?>
<div class="container">
	<h3>Manifiestos <small>Creación por Cliente / Generador</small></h3>
	<form class="form-horizontal" role="form" method="post" id="frm_nuevo">
		<input type="hidden" id="frm_nuevo_empresa" name="frm_nuevo_empresa" value="<?= $idempresa; ?>" />
		<input type="hidden" id="frm_nuevo_sucursal" name="frm_nuevo_sucursal" value="<?= $idsucursal; ?>" />
		<div class="form-group">
			<label for="frm_nuevo_cliente" class="col-sm-2 control-label">No. de Cliente</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_nuevo_cliente" name="frm_nuevo_cliente" value="" />
			</div>
			<label for="frm_nuevo_generador" class="col-sm-2 control-label">No. de Generador</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_nuevo_generador" name="frm_nuevo_generador" value="" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_nuevo_ruta" class="col-sm-2 control-label">Ruta</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_nuevo_ruta" name="frm_nuevo_ruta">
					<?php
					foreach($rutas as $emp)
						foreach($emp["sucursales"] as $suc)
						{
							?>
							<optgroup label="<?= $emp["razonsocial"]." - ".$suc["nombre"] ?>">
							<?php
							foreach($suc["rutas"] as $ruta)
							{
								?>
								<option value="<?= $ruta["id"]?>"><?= $ruta["identificador"]." - ".$ruta["nombre"]; ?></option>
								<?php
							}
							?>
							</optgroup>
							<?php
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Manifiesto.ValidaCreacionCteGen()" >Validar</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url("manifiestos/index/$idempresa/$idsucursal"); ?>'">Cancelar</button>
            </div>
		</div>
	</form>
	<div id="prevalidacion"></div>
</div>