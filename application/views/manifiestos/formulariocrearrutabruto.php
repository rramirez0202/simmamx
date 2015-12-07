<?= $menumain; ?>
<div class="container">
	<h3>Manifiestos <small>Creación por Ruta (Todos los Generadores Asociados)</small></h3>
	<form class="form-horizontal" role="form" method="post" id="frm_nuevo">
		<input type="hidden" id="frm_nuevo_empresa" name="frm_nuevo_empresa" value="<?= $idempresa; ?>" />
		<input type="hidden" id="frm_nuevo_sucursal" name="frm_nuevo_sucursal" value="<?= $idsucursal; ?>" />
		<div class="form-group">
			<label for="frm_nuevo_ruta" class="col-sm-2 control-label">Ruta</label>
			<div class="col-sm-10">
				<select class="form-control" id="frm_nuevo_ruta" name="frm_nuevo_ruta" onchange="$('#frm_nuevo_bitacora')[0].value='Bitácora '+this.options[this.selectedIndex].text+' ('+hoy+')'">
					<?php
					$nombreBitacora="";
					foreach($rutas as $emp)
						foreach($emp["sucursales"] as $suc)
						{
							?>
							<optgroup label="<?= $emp["razonsocial"]." - ".$suc["nombre"] ?>">
							<?php
							foreach($suc["rutas"] as $ruta)
							{
								if($nombreBitacora=="")
									$nombreBitacora="Bitácora ".$ruta["identificador"]." - ".$ruta["nombre"]." (".Hoy().")";
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
			<label for="frm_nuevo_bitacora" class="col-sm-2 control-label">Bitácora</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_nuevo_bitacora" name="frm_nuevo_bitacora" value="<?= $nombreBitacora; ?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Manifiesto.ValidaCreacionRutaBruto()" >Validar</button>
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