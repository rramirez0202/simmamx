<?= $menumain; ?>
<div class="container">
	<h3>Sucursales <small><?= $objeto->getIdsucursal()!="" && $objeto->getIdsucursal()!=0?"Actualizar":"Nueva" ; ?> sucursal</small></h3>
	<form class="form-horizontal" role="form" id="frm_sucursales" method="post">
		<input type="hidden" id="frm_sucursal_idempresa" name="frm_sucursal_idempresa" value="<?= $empresa->getIdempresa(); ?>" />
		<input type="hidden" id="frm_sucursal_idsucursal" name="frm_sucursal_idsucursal" value="<?= $objeto->getIdsucursal(); ?>" />
		<div class="form-group">
			<label for="frm_sucursal_nombre" class="col-sm-2 control-label">Razón Social <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_sucursal_nombre" name="frm_sucursal_nombre" value="<?= $objeto->getNombre(); ?>" placeholder="Nombre o Razón Social de la Sucursal" maxlength="62" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_sucursal_iniciales" class="col-sm-2 control-label">Iniciales</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_sucursal_iniciales" name="frm_sucursal_iniciales" value="<?= $objeto->getIniciales(); ?>" placeholder="Iniciales para manifiestos" maxlength="20" />
			</div>
		</div>
		<h5>
			Dirección
			<button type="button" class="btn btn-default btn-xs" title="Copiar datos desde la empresa" onclick="Sucursal.CopiaDireccion()">
				<span class="glyphicon glyphicon-import"></span>
			</button>
		</h5>
		<div class="form-group">
			<label for="frm_sucursal_calle" class="col-sm-2 control-label">Calle</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_sucursal_calle" name="frm_sucursal_calle" value="<?= $objeto->getCalle(); ?>" placeholder="Calle" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_sucursal_numexterior" class="col-sm-2 control-label">Número Exterior</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_sucursal_numexterior" name="frm_sucursal_numexterior" value="<?= $objeto->getNumexterior(); ?>" placeholder="Número Exterior de la Sucursal" />
			</div>
			<label for="frm_sucursal_numinterior" class="col-sm-2 control-label">Número Interior</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_sucursal_numinterior" name="frm_sucursal_numinterior" value="<?= $objeto->getNuminterior(); ?>" placeholder="Número Interior de la Sucursal" />
			</div>
		</div>
		<div class="form-group">
		    <label for="frm_sucursal_cp" class="col-sm-2 control-label">Código Postal</label>
			<div class="col-sm-3">
				<input type="number" class="form-control" id="frm_sucursal_cp" name="frm_sucursal_cp" value="<?= $objeto->getCp(); ?>" placeholder="C. P." min="0" max="99999" />
			</div>
			<div class="col-sm-1">
				<button type="button" class="btn btn-default" onclick="Sucursal.DisplayFrmCP()">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>
			<label for="frm_sucursal_colonia" class="col-sm-2 control-label">Colonia</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_sucursal_colonia" name="frm_sucursal_colonia" value="<?= $objeto->getColonia(); ?>" placeholder="colonia" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_sucursal_municipio" class="col-sm-2 control-label">Delegación o Municipio</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_sucursal_municipio" name="frm_sucursal_municipio" value="<?= $objeto->getMunicipio(); ?>" placeholder="Delegación o Municipio" />
			</div>
			<label for="frm_sucursal_estado" class="col-sm-2 control-label">Estado</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_sucursal_estado" name="frm_sucursal_estado" value="<?= $objeto->getEstado(); ?>" placeholder="Estado" />
			</div>
		</div>
		<h5>
			Contacto
			<button type="button" class="btn btn-default btn-xs" title="Copiar datos desde la empresa" onclick="Sucursal.CopiaContacto()">
				<span class="glyphicon glyphicon-import"></span>
			</button>
		</h5>
		<div class="form-group">
			<label for="frm_sucursal_representante" class="col-sm-2 control-label">Representante <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_sucursal_representante" name="frm_sucursal_representante" value="<?= $objeto->getRepresentante(); ?>" placeholder="Representante" maxlength="50" />
			</div>
		</div>
		<div class="form-group">
			<label for="frm_sucursal_cargorepresentante" class="col-sm-2 control-label">Cargo</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_sucursal_cargorepresentante" name="frm_sucursal_cargorepresentante" value="<?= $objeto->getCargorepresentante(); ?>" placeholder="Representante" maxlength="30" />
			</div>
			<label for="frm_sucursal_telefono" class="col-sm-2 control-label">Teléfono</label>
			<div class="col-sm-4">
				<input type="tel" class="form-control" id="frm_sucursal_telefono" name="frm_sucursal_telefono" value="<?= $objeto->getTelefono(); ?>" placeholder="Teléfono" maxlength="13" />
			</div>
		</div>
		<h5>
			Legal
			<button type="button" class="btn btn-default btn-xs" title="Copiar datos desde la empresa" onclick="Sucursal.CopiaLegal()">
				<span class="glyphicon glyphicon-import"></span>
			</button>
		</h5>
		<div class="form-group">
			<label for="frm_sucursal_autsemarnat" class="col-sm-2 control-label">Número de Autorización SEMARNAT</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_sucursal_autsemarnat" name="frm_sucursal_autsemarnat" value="<?= $objeto->getAutsemarnat(); ?>" placeholder="Número de Autorización SEMARNAT" maxlength="10" />
			</div>
			<label for="frm_sucursal_registrosct" class="col-sm-2 control-label">Número de Registro SCT</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" id="frm_sucursal_registrosct" name="frm_sucursal_registrosct" value="<?= $objeto->getRegistrosct(); ?>" placeholder="Número de Registro SCT" maxlength="23" />
			</div>
		</div>
		<!--<div class="form-group">
			<label for="frm_sucursal_numregamb" class="col-sm-2 control-label">Número de Registro Ambiental <abbr class="text-danger" title="Campo Obligatorio">(*)</abbr></label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="frm_sucursal_numregamb" name="frm_sucursal_numregamb" value="<?= $objeto->getNumregamb(); ?>" placeholder="Número de Registro Ambiental" />
			</div>
		</div>-->
		<div class="form-group">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
                <button type="button" class="btn btn-success" onclick="Sucursal.Enviar(<?= ($objeto->getIdSucursal()!="" && $objeto->getIdSucursal()!=0?'false':'true'); ?>)" >Guardar</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('sucursales'); ?>'">Cancelar</button>
            </div>
		</div>
	</form>
</div>
<script type="text/javascript">
	var dataEmpresa={
		direccion:{
			calle:'<?= $empresa->getCalle(); ?>',
			numexterior:'<?= $empresa->getNumexterior(); ?>',
			numinterior:'<?= $empresa->getNuminterior(); ?>',
			cp:'<?= $empresa->getCp(); ?>',
			colonia:'<?= $empresa->getColonia(); ?>',
			municipio:'<?= $empresa->getMunicipio(); ?>',
			estado:'<?= $empresa->getEstado(); ?>'
		},
		contacto:{
			representante:'<?= $empresa->getRepresentante(); ?>',
			cargorepresentante:'<?= $empresa->getCargorepresentante(); ?>',
			telefono:'<?= $empresa->getTelefono(); ?>'
		},
		legal:{
			autsemarnat:'<?= $empresa->getAutsemarnat(); ?>',
			registrosct:'<?= $empresa->getRegistrosct(); ?>'
		},
	};
</script>