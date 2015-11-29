<?= $menumain; ?>
<div class="container">
	<div class="btn-toolbar pull-right" role="toolbar">
		<div class="btn-group">
			<?php if($this->modsesion->hasPermisoHijo(66)): ?>
			<button type="button" class="btn btn-default" title="Ver el Generador Asociado" onclick="location.href='<?= base_url('generadores/ver/'.$objeto->getIdgenerador()); ?>';">
				<span class="glyphicon glyphicon-eye-open"></span>
			</button>
			<?php endif; ?>
		</div>
	</div>
	<h3>Generadores - Calendarización</h3>
	<div class="row">
		<div class="col-sm-2">Cliente:</div>
		<div class="col-sm-10">(<?= $cliente->getIdentificador(); ?>) <?= $cliente->getRazonsocial(); ?></div>
	</div>
	<div class="row">
		<div class="col-xs-2">Generador:</div>
		<div class="col-xs-10">(<?= $objeto->getIdentificador(); ?>) <?= $objeto->getRazonsocial(); ?></div>
	</div>
	<div class="row">
		<div class="col-xs-2">Frecuencia:</div>
		<div class="col-xs-10">
			<?php foreach($frecuencia["opciones"] as $opc) if($opc["idcatalogodet"]==$objeto->getFrecuencia()): ?>
				<?= $opc["descripcion"]; ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2">Inicio de Servicios:</div>
		<div class="col-xs-10"><?= DateToMx($cliente->getFechaserviciosinicio()) ?></div>
	</div>
	<div class="row">
		<div class="col-xs-2">Fin de Servicios:</div>
		<div class="col-xs-10"><?= DateToMx($cliente->getFechaserviciosfin()) ?></div>
	</div>
	<hr />
	<input type="hidden" id="idgenerador" name="idgenerador" value="<?= $objeto->getIdgenerador(); ?>" />
	<input type="hidden" id="frecuencia" name="frecuencia" value="<?= $objeto->getFrecuencia(); ?>" />
	<input type="hidden" id="inicio" name="inicio" value="<?= $cliente->getFechaserviciosinicio(); ?>" />
	<input type="hidden" id="fin" name="fin" value="<?= $cliente->getFechaserviciosfin(); ?>" />
	<?php
	if($objeto->getFrecuencia()=="74"||$objeto->getFrecuencia()=="75"||$objeto->getFrecuencia()=="76"||$objeto->getFrecuencia()=="77")
	{
		// 74	Frecuencia diaria
		// 75	Frecuencia dos veces por semana
		// 76	Frecuencia tres veces por semana
		// 77	Frecuencia semanal
		?>
		<div class="row">
			<div class="col-xs-12">Generar servicios para los días:</div>
		</div>
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-2">
				<label>
					<input type="checkbox" id="lunes" name="lunes" value="1" checked="checked" />
					Lunes
				</label>
			</div>
			<div class="col-sm-2">
				<label>
					<input type="checkbox" id="martes" name="martes" value="1" checked="checked" />
					Martes
				</label>
			</div>
			<div class="col-sm-2">
				<label>
					<input type="checkbox" id="miercoles" name="miercoles" value="1" checked="checked" />
					Miércoles
				</label>
			</div>
			<div class="col-xs-2">
				<label>
					<input type="checkbox" id="jueves" name="jueves" value="1" checked="checked" />
					Jueves
				</label>
			</div>
			<div class="col-xs-2">
				<label>
					<input type="checkbox" id="viernes" name="viernes" value="1" checked="checked" />
					Viernes
				</label>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-1"></div>
			<div class="col-xs-2">
				<label>
					<input type="checkbox" id="sabado" name="sabado" value="1" checked="checked" />
					Sábado
				</label>
			</div>
			<div class="col-xs-2">
				<label>
					<input type="checkbox" id="domingo" name="domingo" value="1" checked="checked" />
					Domingo
				</label>
			</div>
		</div>
		<?php
	}
	else if($objeto->getFrecuencia()=="78"||$objeto->getFrecuencia()=="79"||$objeto->getFrecuencia()=="80"||$objeto->getFrecuencia()=="81"||$objeto->getFrecuencia()=="82")
	{
		// 78	Frecuencia Quincenal
		// 79	Frecuencia Mensual
		// 80	Frecuencia Bimestral
		// 81	Frecuencia Trimestral
		// 82	Frecuencia Semestral
		?>
		<div class="row">
			<div class="col-xs-12">Generar servicios para los días:</div>
		</div>
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-2">
				<label>
					<input type="checkbox" id="lunes" name="lunes" value="1" />
					Lunes
				</label>
			</div>
			<div class="col-sm-2">
				<label>
					<input type="checkbox" id="martes" name="martes" value="1" />
					Martes
				</label>
			</div>
			<div class="col-sm-2">
				<label>
					<input type="checkbox" id="miercoles" name="miercoles" value="1" />
					Miércoles
				</label>
			</div>
			<div class="col-xs-2">
				<label>
					<input type="checkbox" id="jueves" name="jueves" value="1" />
					Jueves
				</label>
			</div>
			<div class="col-xs-2">
				<label>
					<input type="checkbox" id="viernes" name="viernes" value="1" />
					Viernes
				</label>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-1"></div>
			<div class="col-xs-2">
				<label>
					<input type="checkbox" id="sabado" name="sabado" value="1" />
					Sábado
				</label>
			</div>
			<div class="col-xs-2">
				<label>
					<input type="checkbox" id="domingo" name="domingo" value="1" />
					Domingo
				</label>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">En la semana:</div>
		</div>
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-2">
				<label>
					<input type="checkbox" id="semana1" name="semana1" value="1" />
					Semana 01
				</label>
			</div>
			<div class="col-sm-2">
				<label>
					<input type="checkbox" id="semana2" name="semana2" value="1" />
					Semana 02
				</label>
			</div>
			<div class="col-sm-2">
				<label>
					<input type="checkbox" id="semana3" name="semana3" value="1" />
					Semana 03
				</label>
			</div>
			<div class="col-sm-2">
				<label>
					<input type="checkbox" id="semana4" name="semana4" value="1" />
					Semana 04
				</label>
			</div>
		</div>
		<?php
	}
	?>
	<div class="row">
		<div class="col-sm-10"></div>
		<div class="col-sm-2">
	        <button type="button" class="btn btn-success" onclick="Calendario.GeneraFechas()" >Siguiente</button>
	    </div>
	</div>
	<hr />
	<div class="row">
		<div class="col-sm-2">Agregar Fecha Eventual:</div>
		<div class="col-sm-3">
			<input type="date" class="form-control" id="fechaeventual" name="fechaeventual" />
		</div>
		<div class="col-sm-5"></div>
		<div class="col-sm-2">
	        <button type="button" class="btn btn-info" onclick="Calendario.GeneraCalendarioEventual()" >Agregar</button>
	    </div>
	</div>
	<div id="fechascalendario_space" style="display: none;">
		<form class="form-horizontal" role="form" id="frm_fechas">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Guardar</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Fecha</th>
							<th>Guardar</th>
						</tr>
					</tfoot>
					<tbody id="fechascalendario_tbl"></tbody>
				</table>
			</div>
		</form>
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-info"><span class="glyphicon glyphicon-info-sign"></span> Al guardar las fechas de servicio seleccionadas se eliminarán las fechas generadas anteriormente.</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
		        <button type="button" class="btn btn-success" onclick="Calendario.GuardarFechas()" >Guardar</button>
		    </div>
		    <div class="col-sm-2">
		        <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('generadores/ver/'.$objeto->getIdgenerador()); ?>';">Cancelar</button>
		    </div>
		</div>
	</div>
</div>