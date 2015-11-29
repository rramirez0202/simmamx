<div id="facturacion<?= $objeto->getIdfacturacion(); ?>">
	<div class="form-group">
		<input type="hidden" id="frm_cliente_facturaciones[]" name="frm_cliente_facturaciones[]" value="<?= $objeto->getIdfacturacion(); ?>" />
		<label for="frm_cliente_tiposervicio" class="col-sm-2 control-label">
			<?php if(isset($modoedicion) && $modoedicion===true): ?>
				<button type="button" class="btn btn-default btn-xs" onclick="Cliente.EliminaFacturacion(<?= $objeto->getIdfacturacion(); ?>)">
					<span class="glyphicon glyphicon-minus-sign"></span>
				</button>
			<?php endif; ?>
			Tipo de Servicio
		</label>
		<div class="col-sm-4">
			<p class="form-control-static">
				<?php 
					if($tiposervicio!==false) 
						foreach($tiposervicio["opciones"] as $opc) 
							if($opc["idcatalogodet"]==$objeto->getTiposervicio()) 
							{ 
								echo $opc["descripcion"]; 
								break; 
							} 
				?>
			</p>
		</div>
		<label for="frm_cliente_tipocobro" class="col-sm-2 control-label">Tipo de Cobro</label>
		<div class="col-sm-4">
			<p class="form-control-static">
				<?php 
					if($tipocobro!==false) 
						foreach($tipocobro["opciones"] as $opc) 
							if($opc["idcatalogodet"]==$objeto->getTipocobro()) 
							{ 
								echo $opc["descripcion"]; 
								break; 
							} 
				?>
			</p>
		</div>
	</div>
	<div class="form-group">
		<label for="frm_cliente_precio" class="col-sm-2 control-label">Precio</label>
		<div class="col-sm-4">
			<p class="form-control-static">$ <?= number_format($objeto->getPrecio(),2); ?></p>
		</div>
		<label for="frm_cliente_kilosintegrados" class="col-sm-2 control-label">Kilos Integrados</label>
		<div class="col-sm-4">
			<p class="form-control-static"><?= $objeto->getKilosintegrados(); ?></p>
		</div>
	</div>
	<div class="form-group">
		<label for="frm_cliente_kiloexcedido" class="col-sm-2 control-label">Kilo Excedido</label>
		<div class="col-sm-4">
			<p class="form-control-static"><?= $objeto->getKiloexcedido(); ?></p>
		</div>
	</div>
</div>