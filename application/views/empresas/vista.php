<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(6)): ?>
			<button type="button" class="btn btn-default" title="Ver todas las Empresas" onclick="location.href='<?= base_url('empresas'); ?>';">
				<span class="glyphicon glyphicon-th-list"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(69)):?>
			<button type="button" class="btn btn-default" title="Actualizar Empresa" onclick="location.href='<?= base_url('empresas/actualizar/'.$objeto->getIdempresa()); ?>';">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(70)):?>
			<button type="button" class="btn btn-default" title="Borrar Empresa" onclick="Empresa.Eliminar(<?= $objeto->getIdempresa(); ?>)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Empresas <small><?= $objeto->getRazonsocial(); ?></small></h3>
	<form class="form-horizontal" role="form" method="post" id="frm_empresas">
		<div class="form-group">
			<label class="col-sm-2 control-label">Razón Social</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getRazonsocial(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Registro Federal de Contribuyentes</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getRfc(); ?></p>
			</div>
		</div>
		<h5>Dirección</h5>
		<div class="form-group">
			<label class="col-sm-2 control-label">Calle</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getCalle(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Número Exterior</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNumexterior(); ?></p>
			</div>
			<label class="col-sm-2 control-label">Número Interior</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNuminterior(); ?></p>
			</div>
		</div>
		<div class="form-group">
		    <label class="col-sm-2 control-label">Código Postal</label></span>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCp(); ?></p>
			</div>
			<label class="col-sm-2 control-label">Colonia</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getColonia(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Delegación o Municipio</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getMunicipio(); ?></p>
			</div>
			<label class="col-sm-2 control-label">Estado</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getEstado(); ?></p>
			</div>
		</div>
		<h5>Contacto</h5>
		<div class="form-group">
			<label class="col-sm-2 control-label">Representante</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getRepresentante(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Cargo</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCargorepresentante(); ?></p>
			</div>
			<label class="col-sm-2 control-label">Teléfono</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getTelefono(); ?></p>
			</div>
		</div>
		<h5>Legal</h5>
		<div class="form-group">
			<label class="col-sm-2 control-label">Número de Autorización SEMARNAT</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getAutsemarnat(); ?></p>
			</div>
			<label class="col-sm-2 control-label">Número de Registro SCT</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getRegistrosct(); ?></p>
			</div>
		</div>
		<h5>Otros</h5>
		<div class="form-group">
			<div class="col-sm-2"></div>
			<div class="col-sm-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="frm_empresa_coorporativo" name="frm_empresa_coorporativo" value="1" disabled="disabled" <?= ($objeto->getCoorporativo()==1?'checked="checked"':''); ?> />
						Empresa Coorporativo
					</label>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="frm_empresa_transportista" name="frm_empresa_transportista" value="1" disabled="disabled" <?= ($objeto->getTransportista()==1?'checked="checked"':''); ?> />
						Empresa Transportista
					</label>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="frm_empresa_destinofinal" name="frm_empresa_destinofinal" value="1" disabled="disabled" <?= ($objeto->getDestinofinal()==1?'checked="checked"':''); ?> />
						Empresa de Destino Final
					</label>
				</div>
			</div>
		</div>
		<?php if($this->modsesion->hasPermisoHijo(7)): ?>
			<h5>Sucursales</h5>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Sucursal</th>
							<th>Representante</th>
							<th>Ubicación</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Sucursal</th>
							<th>Representante</th>
							<th>Ubicación</th>
						</tr>
					</tfoot>
					<tbody>
						<?php if($sucursales!==false) foreach($sucursales as $sucursal): ?>
						<tr>
							<td><a href="<?= base_url('sucursales/ver/'.$sucursal["idsucursal"]); ?>"><?= $sucursal["nombre"]; ?></a></td>
							<td><?= $sucursal["representante"]; ?></td>
							<td>
								<?= $sucursal["municipio"]; ?>,
								<?= $sucursal["estado"]; ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){$("div.table-responsive table").DataTable();});
</script>