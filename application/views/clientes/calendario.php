<?= $menumain; ?>
<div class="container">
	<h3>Calendarios</h3>
	<form class="form-horizontal noImprimir" role="form" id="frm_rc" method="post">
		<div class="form-group">
			<label for="frm_fec_inicial" class="col-sm-2 control-label">Periodo</label>
			<div class="col-sm-5">
				<input type="date" class="form-control" id="frm_fec_inicial" name="frm_fec_inicial" value="<?= $fec_inicial; ?>" />
			</div>
			<div class="col-sm-5">
				<input type="date" class="form-control" id="frm_fec_final" name="frm_fec_final" value="<?= $fec_final; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Tipo:</label>
			<div class="col-sm-3">
				<label>
					<input type="radio" name="tipo_gen" value="rc" <?= ($tipo=="rc"?'checked="checked"':''); ?> />
					Por Rango de Clientes
				</label>
			</div>
			<div class="col-sm-3">
				<label>
					<input type="radio" name="tipo_gen" value="rg" <?= ($tipo=="rg"?'checked="checked"':''); ?> />
					Por Rango de Generadores
				</label>
			</div>
			<div class="col-sm-4"></div>
		</div>
		<div class="form-group">
			<label for="frm_cte_inicial" class="col-sm-2 control-label">No Cliente.</label>
			<div class="col-sm-5">
				<input type="number" class="form-control" id="frm_cte_inicial" name="frm_cte_inicial" value="<?= $cte_inicial; ?>" placeholder="" maxlength="10" />
			</div>
			<div class="col-sm-5">
				<input type="number" class="form-control" id="frm_cte_final" name="frm_cte_final" value="<?= $cte_final; ?>" placeholder="" maxlength="10" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_gen_inicial" class="col-sm-2 control-label">No Generador.</label>
			<div class="col-sm-5">
				<input type="number" class="form-control" id="frm_gen_inicial" name="frm_gen_inicial" value="<?= $gen_inicial; ?>" placeholder="" maxlength="10" />
			</div>
			<div class="col-sm-5">
				<input type="number" class="form-control" id="frm_gen_final" name="frm_gen_final" value="<?= $gen_final; ?>" placeholder="" maxlength="10" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-10"></div>
			<div class="col-sm-2">
				<button type="submit" class="btn btn-success">Generar</button>
			</div>
		</div>
	</form>
	<?php foreach($data as $cte): ?>
		<h4><?= $cte["identificador"]." - ".$cte["razonsocial"]; ?></h4>
		<?php foreach($cte["generadores"] as $k=>$gen): 
			if($k!=0)
				echo '<div class="saltoPagina"></div>';
			?>			
			<h5><?= $gen["identificador"]." - ".$gen["razonsocial"]; ?></h5>
			<?= $gen["vista"]; ?>
			<div class="calendarioEnd"></div>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>