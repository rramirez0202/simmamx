<?php
$fecha=$fec_inicial;
do
{
	$fechas=array();
	foreach($fecs as $f)
	{
		if(MonthYear($f["fecha"])==MonthYear($fecha))
			$fechas[intval(Day($f["fecha"]))]="Servicio";
	}
	?>
	<div class="mesCalendario">
		<?= $this->calendar->generate(Year($fecha),Month($fecha),$fechas) ?>
		<p>&nbsp;</p>
	</div>
	<?php
	$fecha=NextMonthYear($fecha)."-01";
}
while(MonthYear($fecha)!=NextMonthYear($fec_final));
?>