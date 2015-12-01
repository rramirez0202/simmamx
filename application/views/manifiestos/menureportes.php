<table class="menuCreacion">
	<tr>
		<th>
			Seleccione el reporte a generar:
		</th>
	</tr>
	<?php if($this->modsesion->hasPermisoHijo(103)): ?>
		<tr>
			<td>
				<button type="button" class="btn btn-default" onclick="window.open('<?= base_url("reporte/ver/3"); ?>','winreporte')">
					Maestro de Manifiestos
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