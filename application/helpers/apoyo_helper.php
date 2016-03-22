<?php
function Today()
{
	$fecha=getdate();
	return $fecha["year"]."-".($fecha["mon"]<10?0:"").$fecha["mon"]."-".($fecha["mday"]<10?0:"").$fecha["mday"];
}
function Hoy()
{
	return DateToMx(Today());
}
function DateToMySQL($fecha)
{
	if(strlen($fecha)==10)
		return substr($fecha,6,4)."-".substr($fecha,3,2)."-".substr($fecha,0,2);
	return "";
}
function DateToMx($fecha)
{
	if(strlen($fecha)==10)
		return substr($fecha,8,2)."/".substr($fecha,5,2)."/".substr($fecha,0,4);
	return "";
}
function AddDays($fecha,$dias)
{
	$fecha=date_create($fecha);
	date_add($fecha, date_interval_create_from_date_string($dias.' days'));
	return date_format($fecha, 'Y-m-d');
}
function Refill($dato,$largo,$relleno,$rellenaXIzquierda=true)
{
	while(strlen($dato)<$largo)
	{
		if($rellenaXIzquierda)
			$dato=$relleno.$dato;
		else
			$dato.=$relleno;
	}
	return $dato;
}
function Day($fecha) { return substr($fecha,8,2); }
function Month($fecha) { return substr($fecha,5,2); }
function Year($fecha) { return substr($fecha,0,4); }
function MonthYear($fecha) { return substr($fecha,0,4)."-".substr($fecha,5,2); }
function NextMonthYear($fecha)
{
	if(Month($fecha)=="12")
		return (intval(Year($fecha))+1)."-01";
	return Year($fecha)."-".((intval(Month($fecha))+1)<10?"0":"").(intval(Month($fecha))+1);
}
?>