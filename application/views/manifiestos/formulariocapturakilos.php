<?php
$total=0.0;
?><form id="frm_captura_kilos">
	<div class="row">
		<label for="frm_noexterno" class="col-sm-4 control-label">No. Externo</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="frm_noexterno" name="frm_noexterno" value="<?= $noexterno; ?>" />
		</div>
	</div>
	<div class="form-group">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Residuo</th>
						<!--<th>Capacidad del Contenedor</th>
						<th>Tipo de Contenedor</th>-->
						<th>Cantidad Total</th>
						<!--<th>Unidad de Volumen</th>-->
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Residuo</th>
						<!--<th>Capacidad del Contenedor</th>
						<th>Tipo de Contenedor</th>-->
						<th>Cantidad Total</th>
						<!--<th>Unidad de Volumen</th>-->
					</tr>
				</tfoot>
				<tbody id="tblCantidades">
					<?php foreach($recoleccion as $rec): ?>
						<tr>
							<td><?= $rec["residuo"]["nombre"]; ?></td>
							<!--<td>
								<input type="text" id="capacidad_<?= $rec["residuo"]["idresiduo"]; ?>" name="capacidad_<?= $rec["residuo"]["idresiduo"]; ?>" value="<?= ($rec["recoleccion"]!==false?$rec["recoleccion"]["contenedorcapacidad"]:""); ?>" />
							</td>
							<td>
								<input type="text" id="tipo_<?= $rec["residuo"]["idresiduo"]; ?>" name="tipo_<?= $rec["residuo"]["idresiduo"]; ?>" value="<?= ($rec["recoleccion"]!==false?$rec["recoleccion"]["contenedortipo"]:""); ?>" />
							</td>-->
							<td>
								<input type="text" class="form-control numero" id="cantidad_<?= $rec["residuo"]["idresiduo"]; ?>" name="cantidad_<?= $rec["residuo"]["idresiduo"]; ?>" value="<?= ($rec["recoleccion"]!==false?$rec["recoleccion"]["cantidad"]:""); ?>" maxlength="8" onchange="Manifiesto.SumaCantidad()" />
							</td>
							<!--<td>
								<input type="text" id="unidad_<?= $rec["residuo"]["idresiduo"]; ?>" name="unidad_<?= $rec["idresiduo"]["idresiduo"]; ?>" value="<?= ($rec["recoleccion"]!==false?$rec["recoleccion"]["unidad"]:""); ?>" />
							</td>-->
						</tr>
					<?php 
					$total+=floatval(($rec["recoleccion"]!==false?$rec["recoleccion"]["cantidad"]:"0"));
					endforeach; ?>
					<tr>
						<td><strong>Total</strong></td>
						<td>
							<input type="text" class="form-control numero" id="total" name="total" readonly="readonly" value="<?= number_format($total,3); ?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div>
		<p>
			<i>Si el servicio no se realizó:</i><br />
			<select id="frm_motivo" name="frm_motivo" class="form-control">
				<option value=""></option>
				<?php foreach($motivos as $cat): ?>
					<optgroup label="<?= $cat["descripcion"]; ?>"></optgroup>
					<?php foreach($cat["opciones"] as $opc): ?>
						<option value="<?= $opc["idcatalogodet"]; ?>" <?= ($motivo==$opc["idcatalogodet"]?'selected="selected"':""); ?>><?= $opc["descripcion"]; ?></option>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</select>
		</p>
	</div>
</form>