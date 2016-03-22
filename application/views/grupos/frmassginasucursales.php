<div class="dataListSupercontainerParent">
	<h3>Asignación de Sucursales</h3>
	<div class="dataListSupercontainerSearcher">
		<form onsubmit="return false" class="form-horizontal" role="form" id="frm_assign">
			<div class="input-group">
		        <span class="input-group-addon">Buscar por</span>
		        <input type="text" class="form-control" id="frm_txt2Find" name="frm_txt2Find" maxlength="250" />
		        <span class="input-group-btn">
        			<button type="button" class="btn btn-default" onclick="Grupo.findSucursales()">Buscar</button>
		        </span>
		    </div>
		</form>
	</div>
	<div class="dataListSupercontainer">
		<?php foreach($empresas as $emp): ?>
			<h4><?= $emp["data"]["razonsocial"]; ?></h4>
			<ul class="list-group">
				<?php foreach($emp["sucs"] as $suc): ?>
					<li class="list-group-item" id="element_<?= $suc["idsucursal"]; ?>" onclick="Grupo.setSucursal('<?= $suc["idsucursal"]; ?>')"><?= $suc["nombre"]; ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endforeach; ?>
	</div>
</div>