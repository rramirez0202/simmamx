<?= $menumain; ?>
<?php
	if(!isset($manifiestos)||$manifiestos===false||!is_array($manifiestos)) $manifiestos=array();
?>
<div class="container">
	<h3>Importar Manifiestos <small>Preimportación</small></h3>
	<form class="form-horizontal" role="form" method="post" id="frm_importado" action="<?= base_url("manifiestos/importado_final/$idempresa/$idsucursal")?>">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Fila</th>
						<th>Manifiesto</th>
						<th>Fecha</th>
						<th>Ruta</th>
						<th>No. Cliente</th>
						<th>No. Generador</th>
						<th>Motivo</th>
						<th>Total</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Fila</th>
						<th>Manifiesto</th>
						<th>Fecha</th>
						<th>Ruta</th>
						<th>No. Cliente</th>
						<th>No. Generador</th>
						<th>Motivo</th>
						<th>Total</th>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach($manifiestos as $k=>$manif): 
						$suma=0.0;
						$suma+=$manif["res_sangre"];
						$suma+=$manif["res_cultivos"];
						$suma+=$manif["res_pato"];
						$suma+=$manif["res_noanat"];
						$suma+=$manif["res_medcad"];
						$suma+=$manif["res_punzo"];
						?>
						<tr>
							<td rowspan="3"><?= ($k+3); ?></td>
							<td rowspan="3">
								<?= $manif["manif"]; ?>
								<input type="hidden" id="identif_manif_<?= $k; ?>" name="identif_manif_<?= $k; ?>" value="<?= $manif["manif"]; ?>" />
							</td>
							<td>
								<input type="date" class="form-control" id="fecha_<?= $k; ?>" name="fecha_<?= $k; ?>" value="<?= DateToMySQL($manif["fecha"]); ?>" />
							</td>
							<td>
								<select class="form-control" id="ruta_<?= $k; ?>" name="ruta_<?= $k; ?>">
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
												<option value="<?= $ruta["id"]?>" <?= ($ruta["id"]==$manif["idruta_actual"]?'selected="selected"':''); ?> ><?= $ruta["identificador"]." - ".$ruta["nombre"]; ?></option>
												<?php
											}
											?>
											</optgroup>
											<?php
										}
									?>
								</select>
							</td>
							<td>
								<input type="number" class="form-control" id="no_cte_<?= $k; ?>" name="no_cte_<?= $k; ?>" value="<?= $manif["identifcte_actual"]; ?>" min="1" max="999999" maxlength="6" onblur="Manifiesto.importarValidaCliente(<?= $k; ?>)" />
								<div id="nom_cte_<?= $k; ?>"><?= $manif["nomcte_actual"]?></div>
								<input type="hidden" id="id_cte_<?= $k; ?>" name="id_cte_<?= $k; ?>" value="<?= $manif["idcte_actual"]; ?>" />
							</td>
							<td>
							    <input type="number" class="form-control" id="no_gen_<?= $k; ?>" name="no_gen_<?= $k; ?>" value="<?= $manif["identifgen_actual"]; ?>" min="1" max="999999" maxlength="6" onblur="Manifiesto.importarValidaGenerador(<?= $k; ?>)" />
								<div id="nom_gen_<?= $k; ?>"><?= $manif["nomgen_actual"]?></div>
								<input type="hidden" id="id_gen_<?= $k; ?>" name="id_gen_<?= $k; ?>" value="<?= $manif["idgen_actual"]; ?>" />
							</td>
							<td>
								<select id="frm_motivo_<?= $k; ?>" name="frm_motivo_<?= $k; ?>" class="form-control">
									<option value=""></option>
									<?php foreach($motivos as $cat): ?>
										<optgroup label="<?= $cat["descripcion"]; ?>"></optgroup>
										<?php foreach($cat["opciones"] as $opc): ?>
											<option value="<?= $opc["idcatalogodet"]; ?>" <?= (strtolower(trim($manif["causa"]))==strtolower(trim($cat["descripcion"])) && strtolower(trim($manif["motivo"]))==strtolower(trim($opc["descripcion"]))?'selected="selected"':""); ?>><?= $opc["descripcion"]; ?></option>
										<?php endforeach; ?>
									<?php endforeach; ?>
								</select>
							</td>
							<td>
								<input type="text" class="form-control" id="total_<?= $k; ?>" name="total_<?= $k; ?>" value="<?= $suma; ?>" readonly="readonly" />
							</td>
						</tr>
						<tr>
							<td class="abajo">
								Sangre<br />
								<div>
									<input type="text" class="form-control" id="sangre_<?= $k; ?>" name="sangre_<?= $k; ?>" value="<?= $manif["res_sangre"]; ?>" onblur="Manifiesto.importarSumaKilos(<?= $k; ?>)" />
								</div>
							</td>
							<td class="abajo">
								Cultivos y Cepas<br />
								<div>
									<input type="text" class="form-control" id="cultivos_<?= $k; ?>" name="cultivos_<?= $k; ?>" value="<?= $manif["res_cultivos"]; ?>" onblur="Manifiesto.importarSumaKilos(<?= $k; ?>)" />
								</div>
							</td>
							<td class="abajo">
								Patológicos<br />
								<div>
									<input type="text" class="form-control" id="pato_<?= $k; ?>" name="pato_<?= $k; ?>" value="<?= $manif["res_pato"]; ?>" onblur="Manifiesto.importarSumaKilos(<?= $k; ?>)" />
								</div>
							</td>
							<td class="abajo">
								No Anatómcos<br />
								<div>
									<input type="text" class="form-control" id="noanat_<?= $k; ?>" name="noanat_<?= $k; ?>" value="<?= $manif["res_noanat"]; ?>" onblur="Manifiesto.importarSumaKilos(<?= $k; ?>)" />
								</div>
							</td>
							<td class="abajo">
								Punzocortantes<br />
								<div>
									<input type="text" class="form-control" id="punzo_<?= $k; ?>" name="punzo_<?= $k; ?>" value="<?= $manif["res_punzo"]; ?>" onblur="Manifiesto.importarSumaKilos(<?= $k; ?>)" />
								</div>
							</td>
							<td class="abajo">
								Medicamento Caduco<br />
								<div>
									<input type="text" class="form-control" id="medcad_<?= $k; ?>" name="medcad_<?= $k; ?>" value="<?= $manif["res_medcad"]; ?>" onblur="Manifiesto.importarSumaKilos(<?= $k; ?>)" />
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<?php if(count($manif["warnings"])>0): ?>
									<div class="alert alert-warning">
										<?php foreach($manif["warnings"] as $item): ?>
											<strong>Warning <?= $item[0]; ?>: </strong>
											<?= $item[1]; ?><br />
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
								<?php if(count($manif["errors"])>0): ?>
									<div class="alert alert-danger">
										<?php foreach($manif["errors"] as $item): ?>
											<strong>Error <?= $item[0]; ?>: </strong>
											<?= $item[1]; ?><br />
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</td>
							<td colspan="2">
								<label class="control-label">
									<input type="checkbox" id="pso_<?= $k; ?>" name="pso_<?= $k; ?>" value="<?= $k; ?>" checked="checked" />
									<input type="hidden" id="status_<?= $k; ?>" name="status_<?= $k; ?>" value="<?= $manif["status"]; ?>" />
									<?php
									switch($manif["status"])
									{
										case 'noextiste':
											echo "Crear y Capturar Manifiesto";
											break;
										case 'porcapturar':
											echo "Capturar Manifiesto";
											break;
										case 'capturado':
											echo "Recapturar Manifiesto";
											break;
									}
									?>
								</label>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Manifiesto.importarCaptura()" >Aceptar</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url("manifiestos/index/$idempresa/$idsucursal"); ?>'">Cancelar</button>
            </div>
		</div>
	</form>
</div>
<script type="text/javascript">
	var gens=<?= json_encode($this->modsesion->getAllGens()); ?>;
	var empresa=<?= $idempresa; ?>;
	var sucursal=<?= $idsucursal; ?>;
</script>