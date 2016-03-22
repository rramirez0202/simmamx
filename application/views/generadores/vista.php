<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(55)): ?>
			<button type="button" class="btn btn-default" title="Ver el Cliente Asociado" onclick="location.href='<?= base_url('clientes/ver/'.$objeto->getIdcliente()); ?>';">
				<span class="glyphicon glyphicon-eye-open"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(79)):?>
			<button type="button" class="btn btn-default" title="Calendarizar Generador" onclick="location.href='<?= base_url('generadores/calendarizar/'.$objeto->getIdgenerador()) ?>'">
				<span class="glyphicon glyphicon-calendar"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(76)):?>
			<button type="button" class="btn btn-default" title="Actualizar Generador" onclick="location.href='<?= base_url('generadores/actualizar/'.$objeto->getIdgenerador()); ?>';">
				<span class="glyphicon glyphicon-edit"></span>
			</button>
			<?php endif;
			if($this->modsesion->hasPermisoHijo(77)):?>
			<button type="button" class="btn btn-default" title="Borrar Generador	" onclick="Generador.Eliminar(<?= $objeto->getIdcliente(); ?>,<?= $objeto->getIdgenerador(); ?>)">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Generadores</h3>
	<form class="form-horizontal" role="form" id="frm_generadores">
		<div class="form-group">
			<label for="frm_generador_razonsocial" class="col-sm-2 control-label">Razón Social</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getRazonsocial(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_identificador" class="col-sm-2 control-label">Número de Generador</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getIdentificador(); ?></p>
			</div>
			<label for="frm_generador_rfc" class="col-sm-2 control-label">Registro Federal de Contribuyentes</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getRfc(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_numregamb" class="col-sm-2 control-label">Número de Registro Ambiental</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getNumregamb(); ?></p>
			</div>
			<!--<label for="frm_generador_numreggen" class="col-sm-2 control-label">Número de Registro como Generador</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNumreggen(); ?></p>
			</div>-->
			
		</div>
		<div class="form-group">
			<label for="frm_generador_frecuencia" class="col-sm-2 control-label">Frecuencia de Recolección</label>
			<div class="col-sm-4">
				<p class="form-control-static">
					<?php 
						if($frecuencia!==false) 
							foreach($frecuencia["opciones"] as $opc) 
								if($opc["idcatalogodet"]==$objeto->getFrecuencia()) 
								{ 
									echo $opc["descripcion"]; 
									break; 
								} 
					?>
				</p>
			</div>
			<!--<label for="frm_generador_servicio" class="col-sm-2 control-label">Tipo de Servicio</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getServicio(); ?></p>
			</div>-->
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" id="frm_generador_activo" name="frm_generador_activo" <?= ($objeto->getActivo()==1?'checked="checked"':''); ?> disabled="disabled" />
						Activo (<?= DateToMx($objeto->getFechaactivo()); ?>)
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_giro" class="col-sm-2 control-label">Giro</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getGiro(); ?></p>
			</div>
		</div>
		<h5>Servicios</h5>
		<div class="form-group">
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_generador_serviciolunes" name="frm_generador_serviciolunes" <?= ($objeto->getServiciolunes()==1?'checked="checked"':''); ?> />
						Lunes
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_generador_serviciomartes" name="frm_generador_serviciomartes" <?= ($objeto->getServiciomartes()==1?'checked="checked"':''); ?> />
						Martes
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_generador_serviciomiercoles" name="frm_generador_serviciomiercoles" <?= ($objeto->getServiciomiercoles()==1?'checked="checked"':''); ?> />
						Miércoles
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_generador_serviciojueves" name="frm_generador_serviciojueves" <?= ($objeto->getServiciojueves()==1?'checked="checked"':''); ?> />
						Jueves
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_generador_servicioviernes" name="frm_generador_servicioviernes" <?= ($objeto->getServicioviernes()==1?'checked="checked"':''); ?> />
						Viernes
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_generador_serviciosabado" name="frm_generador_serviciosabado" <?= ($objeto->getServiciosabado()==1?'checked="checked"':''); ?> />
						Sabado
					</label>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" value="1" id="frm_generador_serviciodomingo" name="frm_generador_serviciodomingo" <?= ($objeto->getServiciodomingo()==1?'checked="checked"':''); ?> />
						Domingo
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_horarioinicio" class="col-sm-2 control-label">Hora Inicio</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getHorarioinicio(); ?></p>
			</div>
			<label for="frm_generador_horariofin" class="col-sm-2 control-label">Hora Fin</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getHorariofin(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_horarioinicio2" class="col-sm-2 control-label">Hora Inicio</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getHorarioinicio2(); ?></p>
			</div>
			<label for="frm_generador_horariofin2" class="col-sm-2 control-label">Hora Fin</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getHorariofin2(); ?></p>
			</div>
		</div>
		<h5>Dirección</h5>
		<div class="form-group">
			<label for="frm_generador_calle" class="col-sm-2 control-label">Calle</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getCalle(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_numexterior" class="col-sm-2 control-label">Número Exterior</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNumexterior(); ?></p>
			</div>
			<label for="frm_generador_numinterior" class="col-sm-2 control-label">Número Interior</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getNuminterior(); ?></p>
			</div>
		</div>
		<div class="form-group">
		    <label for="frm_generador_cp" class="col-sm-2 control-label">Código Postal</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCp(); ?></p>
			</div>
			<label for="frm_generador_colonia" class="col-sm-2 control-label">Colonia</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getColonia(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_municipio" class="col-sm-2 control-label">Delegación o Municipio</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getMunicipio(); ?></p>
			</div>
			<label for="frm_generador_estado" class="col-sm-2 control-label">Estado</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getEstado(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_referencias" class="col-sm-2 control-label">Referencias</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getReferencias(); ?></p>
			</div>
		</div>
		<h5>Contacto</h5>
		<div class="form-group">
			<label for="frm_generador_representante" class="col-sm-2 control-label">Representante</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getRepresentante(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_representantecargo" class="col-sm-2 control-label">Cargo</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getRepresentantecargo(); ?></p>
			</div>
			<label for="frm_generador_representanteemail" class="col-sm-2 control-label">Corro Electrónico</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getRepresentanteemail(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_representantetelefono" class="col-sm-2 control-label">Teléfono</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getRepresentantetelefono(); ?></p>
			</div>
			<label for="frm_generador_representanextension" class="col-sm-2 control-label">Extensión</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getRepresentanteextension(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_representantetelefono2" class="col-sm-2 control-label">Teléfono 2</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getRepresentantetelefono2(); ?></p>
			</div>
			<label for="frm_generador_representanextension2" class="col-sm-2 control-label">Extensión 2</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getRepresentanteextension2(); ?></p>
			</div>
		</div>
		<h5>Notas y Observaciones</h5>
		<div class="form-group">
			<div class="col-sm-12">
				<p class="form-control-static"><?= $objeto->getObservaciones(); ?></p>
			</div>
		</div>
		<h5>Facturación</h5>
		<div id="facturacion"><?= $facturaciones; ?></div>
		<div class="form-group">
			<div class="col-sm-2"></div>
			<div class="col-sm-3">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" id="frm_generador_ordencompra" name="frm_generador_ordencompra" value="1" <?= ($objeto->getOrdencompra()==1?'checked="checked"':''); ?> />
						Orden de Compra
					</label>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="checkbox">
					<label>
						<input disabled="disabled" type="checkbox" id="frm_generador_desglosemanifiestos" name="frm_generador_desglosemanifiestos" value="1" <?= ($objeto->getDesglosemanifiestos()==1?'checked="checked"':''); ?> />
						Desglosar Manifiestos
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_leyendas" class="col-sm-2 control-label">Leyendas</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getLeyendas(); ?></p>
			</div>
		</div>
		<h5>Cobranza</h5>
		<div class="form-group">
			<label for="frm_generador_cobranzacontacto" class="col-sm-2 control-label">Contacto</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getCobranzacontacto(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_cobranzaemail" class="col-sm-2 control-label">Corro Electrónico</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getCobranzaemail(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_cobranzatelefono" class="col-sm-2 control-label">Teléfono</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCobranzatelefono(); ?></p>
			</div>
			<label for="frm_generador_cobranzaextension" class="col-sm-2 control-label">Extensión</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCobranzaextension(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_cobranzatelefono2" class="col-sm-2 control-label">Teléfono 2</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCobranzatelefono2(); ?></p>
			</div>
			<label for="frm_generador_cobranzaextension2" class="col-sm-2 control-label">Extensión 2</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCobranzaextension2(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_cobranzaobservaciones" class="col-sm-2 control-label">Observaciones</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getCobranzaobservaciones(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_cobranzacalle" class="col-sm-2 control-label">Calle</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?= $objeto->getCobranzacalle(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_cobranzanumexterior" class="col-sm-2 control-label">Número Exterior</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCobranzanumexterior(); ?></p>
			</div>
			<label for="frm_generador_cobranzanuminterior" class="col-sm-2 control-label">Número Interior</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCobranzanuminterior(); ?></p>
			</div>
		</div>
		<div class="form-group">
		    <label for="frm_generador_cobranzacp" class="col-sm-2 control-label">Código Postal</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCobranzacp(); ?></p>
			</div>
			<label for="frm_generador_cobranzacolonia" class="col-sm-2 control-label">Colonia</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCobranzacolonia(); ?></p>
			</div>
		</div>
		<div class="form-group">
			<label for="frm_generador_cobranzamunicipio" class="col-sm-2 control-label">Delegación o Municipio</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCobranzamunicipio(); ?></p>
			</div>
			<label for="frm_generador_cobranzaestado" class="col-sm-2 control-label">Estado</label>
			<div class="col-sm-4">
				<p class="form-control-static"><?= $objeto->getCobranzaestado(); ?></p>
			</div>
		</div>
		<h5>Rutas Asociadas</h5>
		<?php foreach($rutas as $r): ?>
			<div class="form-group">
				<div class="col-sm-1"></div>
				<div class="col-sm-11">
					<?= $r; ?>
				</div>
			</div>
		<?php endforeach; ?>
		<h5>Fechas Calendarizadas</h5>
		<div class="row">
			<?php if($objeto->getFechasCalendario()!==false) foreach($objeto->getFechasCalendario() as $k=>$fecha):?>
				<div class="col-sm-2"><?= DateToMx($fecha); ?></div>
			    <?php if(($k+1)%6==0): ?>
			    	</div>
			    	<div class="row">
			    <?php endif; ?>
			<?php endforeach; ?>
		</div>
	</form>
</div>