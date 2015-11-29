<?= $menumain; ?>
<div class="container">
	<h3>Importar Clientes <small>Resultado</small></h3>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>No. Excel</th>
					<th>No. Cliente</th>
					<th colspan="2">Razón Social</th>
					<th>Resultados</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>No. Excel</th>
					<th>No. Cliente</th>
					<th colspan="2">Razón Social</th>
					<th>Resultados</th>
				</tr>
			</tfoot>
			<tbody>
				<?php
				foreach($clientes as $cte)
				{
					?>
					<tr>
						<td><?= $cte["tmpcte"]; ?></td>
						<td><?= $cte["identificador"]; ?></td>
						<td colspan="2"><?= $cte["razonsocial"]; ?></td>
						<td>
							<div class="alert <?= count($cte["errores"])>0?"alert-danger":"alert-success"; ?>">
								<?= count($cte["errores"])>0?implode(", ",$cte["errores"]):"Cargado"; ?>
							</div>
						</td>
					</tr>
					<?php
					foreach($cte["generadores"] as $gen)
					{
						?>
						<tr>
							<td></td>
							<td></td>
							<td><?= $gen["identificador"]; ?></td>
							<td><?= $gen["razonsocial"]; ?></td>
							<td>
								<div class="alert <?= count($gen["errores"])>0?"alert-danger":"alert-success"; ?>">
									<?= count($gen["errores"])>0?implode(", ",$gen["errores"]):"Cargado"; ?>
								</div>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="row">
		<div class="col-sm-10"></div>
		<div class="col-sm-2">
			<button type="button" class="btn btn-success" onclick="location.href='<?= base_url("clientes/index/$idempresa/$idsucursal"); ?>'">Regresar</button>
		</div>
	</div>
</div>