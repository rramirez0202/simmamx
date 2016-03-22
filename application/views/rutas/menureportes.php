<table class="menuCreacion">
	<tr>
		<th>
			Seleccione el reporte a generar:
		</th>
	</tr>
	<?php if($this->modsesion->hasPermisoHijo(106)): ?>
		<tr>
			<td>
				<button type="button" class="btn btn-default" onclick="window.open('<?= base_url("reporte/ver/4"); ?>','winreporte')">
					Maestro de Plan de Servicios
				</button>
			</td>
		</tr>
	<?php endif;?>
	<?php if($this->modsesion->hasPermisoHijo(107)): ?>
		<tr>
			<td>
				<button type="button" class="btn btn-default" onclick="window.open('<?= base_url("reporte/ver/5"); ?>','winreporte')">
					Reporte de Operaciones
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