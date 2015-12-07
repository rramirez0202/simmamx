<?= $menumain; ?>
<?php
$nombreBitacora="Bitácora (".Today().")";
?>
<div class="container">
	<h3>Manifiestos <small>Creación por Ruta (Todos los Generadores Asociados)</small></h3>
	<form class="form-horizontal" role="form" method="post" id="frm_nuevo">
		<input type="hidden" id="frm_nuevo_empresa" name="frm_nuevo_empresa" value="<?= $idempresa; ?>" />
		<input type="hidden" id="frm_nuevo_sucursal" name="frm_nuevo_sucursal" value="<?= $idsucursal; ?>" />
		<div class="form-group">
			<label for="frm_nuevo_fecha" class="col-sm-2 control-label">Fecha Programada</label>
			<div class="col-sm-3">
				<input type="date" class="form-control" id="frm_nuevo_fecha" name="frm_nuevo_fecha" value="<?= Today(); ?>" onchange="$('#frm_nuevo_bitacora')[0].value='Bitácora ('+this.value+')'" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_nuevo_bitacora" class="col-sm-2 control-label">Bitácora</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_nuevo_bitacora" name="frm_nuevo_bitacora" value="<?= $nombreBitacora; ?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Manifiesto.ValidaCreacionCalendario()" >Validar</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url("manifiestos/index/$idempresa/$idsucursal"); ?>'">Cancelar</button>
            </div>
		</div>
	</form>
	<div id="prevalidacion"></div>
</div>
<script type="text/javascript">
	var hoy="<?= Hoy(); ?>";
</script>