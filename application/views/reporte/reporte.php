<?= $menumain; ?>
<?php

?>
<div class="container">
	<h3>Reporte <small><?= $reporte->getTitulo(); ?></small></h3>
	
	<form class="form-horizontal" role="form" id="frm_reporte">
		<input type="hidden" name="read" id="read" value="1" />
		<input type="hidden" name="idreporte" id="idreporte" value="<?= $reporte->getIdreporte(); ?>">
		<div id="parametros">
			<div class="row">
				<?php foreach($reporte->getParams() as $k=>$p)
				{
					?>
					<label for="<?= $p["parametro"]; ?>" class="control-label col-sm-2"><?= $p["etiqueta"]?></label>
					<div class="col-sm-2">
						<?php
						switch(strtolower($p["tipo"]))
						{
							case 'text':
								?>
								<input type="text" name="<?= $p["parametro"]; ?>" id="<?= $p["parametro"]; ?>" class="form-control" value="<?= $p["valor"]; ?>" />
								<?php
								break;
							case 'numeric':
								?>
								<input type="number" name="<?= $p["parametro"]; ?>" id="<?= $p["parametro"]; ?>" class="form-control" min="0" value="<?= $p["valor"]; ?>" />
								<?php
								break;
							case 'checkbox':
								?>
								<input type="checkbox" name="<?= $p["parametro"]; ?>" id="<?= $p["parametro"]; ?>" value="1" <?= ($p["valor"]==1?'checked="checked"':''); ?> />
								<?php
								break;
							case 'date':
								?>
								<input type="date" name="<?= $p["parametro"]; ?>" id="<?= $p["parametro"]; ?>" class="form-control" value="<?= $p["valor"]; ?>" />
								<?php
								break;
							default:
								echo $p["tipo"];
						}
						?>
					</div>
					<?php
					if($k%3==2)
					{
						?>
						</div>
						<div class="row">
						<?php
					}
				}
				?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-7"></div>
			<div class="col-sm-1">
				<button type="button" class="btn btn-default" title="Filtros" onclick="$('#parametros').slideToggle(1000)">
					<span class="glyphicon glyphicon-filter"></span>
				</button>
			</div>
			<div class="col-sm-2">
		        <button id="btnGenera" type="button" class="btn btn-success" onclick="Reporte.Ejecutar()" >Generar</button>
		    </div>
			<div class="col-sm-2">
		        <button id="btnDescarga" type="button" class="btn btn-info disabled" onclick="Reporte.Descargar()" >Descargar</button>
		    </div>
		</div>
	</form>
	<div id="bodyreport"></div>
</div>