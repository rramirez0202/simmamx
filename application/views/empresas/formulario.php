<?= $menumain; ?>
<div class="container">
	<h3>Empresas <small><?= $objeto->getIdempresa()!="" && $objeto->getIdempresa()!=0?"Actualizar":"Nueva"; ?> empresa</small></h3>
	<form class="form-horizontal" role="form" method="post" id="frm_empresas">
		<input type="hidden" id="frm_empresa_idempresa" name="frm_empresa_idempresa" value="<?= $objeto->getIdempresa(); ?>" />
		<div class="form-group">
			<label for="frm_empresa_razonsocial" class="col-sm-2 control-label">Razón Social <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_empresa_razonsocial" name="frm_empresa_razonsocial" value="<?= $objeto->getRazonsocial(); ?>" placeholder="Nombre o Razón Social de la Empresa" maxlength="62" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_empresa_rfc" class="col-sm-2 control-label">Registro Federal de Contribuyentes <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_empresa_rfc" name="frm_empresa_rfc" value="<?= $objeto->getRfc(); ?>" placeholder="Registro Federal de Contribuyentes de la Empresa" />
			</div>
		</div>
		<h5>Dirección</h5>
		<div class="form-group">
			<label for="frm_empresa_calle" class="col-sm-2 control-label">Calle</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_empresa_calle" name="frm_empresa_calle" value="<?= $objeto->getCalle(); ?>" placeholder="Calle" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_empresa_numexterior" class="col-sm-2 control-label">Número Exterior</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_empresa_numexterior" name="frm_empresa_numexterior" value="<?= $objeto->getNumexterior(); ?>" placeholder="Número Exterior de la Empresa" />
			</div>
			<label for="frm_empresa_numinterior" class="col-sm-2 control-label">Número Interior</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_empresa_numinterior" name="frm_empresa_numinterior" value="<?= $objeto->getNuminterior(); ?>" placeholder="Número Interior de la Empresa" />
			</div>
		</div>
		<div class="form-group">
		    <label for="frm_empresa_cp" class="col-sm-2 control-label">Código Postal</label>
			<div class="col-sm-3">
				<input type="number" class="form-control" id="frm_empresa_cp" name="frm_empresa_cp" value="<?= $objeto->getCp(); ?>" placeholder="C. P." min="0" max="99999" />
			</div>
			<div class="col-sm-1">
				<button type="button" class="btn btn-default" onclick="Empresa.DisplayFrmCP()">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>
			<label for="frm_empresa_colonia" class="col-sm-2 control-label">Colonia</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_empresa_colonia" name="frm_empresa_colonia" value="<?= $objeto->getColonia(); ?>" placeholder="colonia" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_empresa_municipio" class="col-sm-2 control-label">Delegación o Municipio</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_empresa_municipio" name="frm_empresa_municipio" value="<?= $objeto->getMunicipio(); ?>" placeholder="Delegación o Municipio" />
			</div>
			<label for="frm_empresa_estado" class="col-sm-2 control-label">Estado</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_empresa_estado" name="frm_empresa_estado" value="<?= $objeto->getEstado(); ?>" placeholder="Estado" />
			</div>
		</div>
		<h5>Contacto</h5>
		<div class="form-group">
			<label for="frm_empresa_representante" class="col-sm-2 control-label">Representante <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_empresa_representante" name="frm_empresa_representante" value="<?= $objeto->getRepresentante(); ?>" placeholder="Representante" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_empresa_cargorepresentante" class="col-sm-2 control-label">Cargo</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_empresa_cargorepresentante" name="frm_empresa_cargorepresentante" value="<?= $objeto->getCargorepresentante(); ?>" placeholder="Representante" />
			</div>
			<label for="frm_empresa_telefono" class="col-sm-2 control-label">Teléfono</label>
			<div class="col-sm-4">
				<input type="tel" class="form-control" id="frm_empresa_telefono" name="frm_empresa_telefono" value="<?= $objeto->getTelefono(); ?>" placeholder="Teléfono" maxlength="13" />
			</div>
		</div>
		<h5>Legal</h5>
		<div class="form-group">
			<label for="frm_empresa_autsemarnat" class="col-sm-2 control-label">Número de Autorización SEMARNAT <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_empresa_autsemarnat" name="frm_empresa_autsemarnat" value="<?= $objeto->getAutsemarnat(); ?>" placeholder="Número de Autorización SEMARNAT" />
			</div>
			<label for="frm_empresa_registrosct" class="col-sm-2 control-label">Número de Registro SCT <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_empresa_registrosct" name="frm_empresa_registrosct" value="<?= $objeto->getRegistrosct(); ?>" placeholder="Número de Registro SCT" />
			</div>
		</div>
		<h5>Otros</h5>
		<div class="form-group">
			<div class="col-sm-2"></div>
			<div class="col-sm-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="frm_empresa_coorporativo" name="frm_empresa_coorporativo" value="1" <?= ($objeto->getCoorporativo()==1?'checked="checked"':''); ?> />
						Empresa Coorporativo
					</label>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="frm_empresa_transportista" name="frm_empresa_transportista" value="1" <?= ($objeto->getTransportista()==1?'checked="checked"':''); ?> />
						Empresa Transportista
					</label>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="frm_empresa_destinofinal" name="frm_empresa_destinofinal" value="1" <?= ($objeto->getDestinofinal()==1?'checked="checked"':''); ?> />
						Empresa de Destino Final
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
				<button type="button" class="btn btn-success" onclick="Empresa.Enviar(<?= ($objeto->getIdempresa()!="" && $objeto->getIdempresa()!=0?'false':'true'); ?>)" >Guardar</button>
			</div>
			<div class="col-sm-2">
				<button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('empresas'); ?>'">Cancelar</button>
			</div>
		</div>
	</form>
</div>