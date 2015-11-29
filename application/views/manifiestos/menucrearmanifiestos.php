<table class="menuCreacion">
	<tr>
		<th>
			Seleccione el Método de Creación de Manifiestos:
		</th>
	</tr>
	<?php if($this->modsesion->hasPermisoHijo(38)): ?>
		<tr>
			<td>
				<button type="button" class="btn btn-default" onclick="Manifiesto.CrearManifiestoCteGen()">
					Por Número de Cliente / Generador
				</button>
			</td>
		</tr>
	<?php endif;
	if($this->modsesion->hasPermisoHijo(39)): ?>
		<tr>
			<td>
				<button type="button" class="btn btn-default" onclick="Manifiesto.CrearManifiestoRutaBruto()">
					Por Ruta (todos los generadores de la ruta)
				</button>
			</td>
		</tr>
	<?php endif;
	if($this->modsesion->hasPermisoHijo(40)): ?>
		<tr>
			<td>
				<button type="button" class="btn btn-default" onclick="Manifiesto.CrearManifiestoRutaCalendario()">
					Por Ruta (con base en calendario)
				</button>
			</td>
		</tr>
	<?php endif;
	if($this->modsesion->hasPermisoHijo(41)): ?>
		<tr>
			<td>
				<button type="button" class="btn btn-default" onclick="Manifiesto.CrearManifiestoCalendario()">
					Por Calendario
				</button>
			</td>
		</tr>
	<?php endif;?>
	<tr>
		<td>
			<button type="button" class="btn btn-danger" onclick="Manifiesto.CerrarMenuCreacion()">
				Cancelar
			</button>
		</td>
	</tr>
</table>