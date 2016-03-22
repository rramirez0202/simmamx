<div class="dataListSupercontainerParent">
	<h3>Asignación de Generadores</h3>
	<div class="dataListSupercontainerSearcher">
		<form onsubmit="return false" class="form-horizontal" role="form" id="frm_assign">
			<div class="input-group">
		        <span class="input-group-addon">Buscar por</span>
		        <input type="text" class="form-control" id="frm_txt2Find" name="frm_txt2Find" maxlength="250" />
		    </div>
			<div class="input-group">
		        <span class="input-group-addon">Cliente Inicial</span>
		        <input type="number" class="form-control" id="frm_cteInicio" name="frm_cteInicio" maxlength="10" min=0 />
		        <span class="input-group-addon">Cliente Final</span>
		        <input type="number" class="form-control" id="frm_cteFin" name="frm_cteFin" maxlength="10" min=0 />
		        <span class="input-group-btn">
        			<button type="button" class="btn btn-default" onclick="Grupo.findGens()">Buscar</button>
		        </span>
		    </div>
		</form>
	</div>
	<div class="dataListSupercontainer">
		<?php foreach($empresas as $emp): ?>
			<h4><?= $emp["data"]["razonsocial"]; ?></h4>
			<?php foreach($emp["sucs"] as $suc): ?>
				<h5><?= $suc["data"]["nombre"]; ?></h5>
				<ul class="list-group">
					<?php foreach($suc["ctes"] as $cte) foreach($cte["gens"] as $gen): ?>
						<li class="list-group-item" id="element_<?= $gen["idgenerador"]; ?>" onclick="Grupo.setGen('<?= $gen["idgenerador"]; ?>')"><?= "{$cte["data"]["identificador"]} - {$gen["identificador"]} - {$gen["razonsocial"]}"; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</div>
</div>