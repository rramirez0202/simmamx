<?php
class Punto{public $x, $y, $visible;public function __construct($mx=0,$my=0,$mvisible=true){$this->x=$mx;$this->y=$my;$this->visible=$mvisible;}}
class Coordenadas
{
	public $general;
	public $seccion;
	public function __construct()
	{
		$this->general										= array(
			"posicion"										=> new Punto()
		);
		$this->seccion										= array(
			"generador"										=> array(
				"posicion"									=> new Punto(),
				"campos"									=> array(
					"manifiesto_space_nocte"				=> new Punto(10,	28),
					"manifiesto_space_nogen"				=> new Punto(10,	35),
					"manifiesto_space_nrg"					=> new Punto(3,		49),
					"manifiesto_space_nomanifiesto"			=> new Punto(123,	49),
					"manifiesto_space_pagina"				=> new Punto(165,	49),
					"manifiesto_space_generedorrazonsocial"	=> new Punto(74,	54),
					"manifiesto_space_generadordocimicilio"	=> new Punto(19,	60),
					"manifiesto_space_generadordelegacion"	=> new Punto(42,	66),
					"manifiesto_space_generadorcp"			=> new Punto(102,	66),
					"manifiesto_space_generadoredo"			=> new Punto(155,	66),
					"manifiesto_space_generadortel"			=> new Punto(10,	72),
					"manifiesto_space_generadorreferencias"	=> new Punto(73,	72),
					"manifiesto_space_instrucciones"		=> new Punto(3,		140,	false),	
					"manifiesto_space_cccontenedorcap"		=> new Punto(95,	99,		false),
					"manifiesto_space_cccontenedortipo"		=> new Punto(118,	99,		false),
					"manifiesto_space_cccantidad"			=> new Punto(143,	99,		false),
					"manifiesto_space_ccunidad"				=> new Punto(170,	99,		false),
					"manifiesto_space_punzcontenedorcap"	=> new Punto(95,	117,	false),
					"manifiesto_space_punzcontenedortipo"	=> new Punto(118,	117,	false),
					"manifiesto_space_punzcantidad"			=> new Punto(143,	117,	false),
					"manifiesto_space_punzunidad"			=> new Punto(170,	117,	false),
					"manifiesto_space_patcontenedorcap"		=> new Punto(95,	105,	false),
					"manifiesto_space_patcontenedortipo"	=> new Punto(118,	105,	false),
					"manifiesto_space_patcantidad"			=> new Punto(143,	105,	false),
					"manifiesto_space_patunidad"			=> new Punto(170,	105,	false),
					"manifiesto_space_noanatcontenedorcap"	=> new Punto(95,	111,	false),
					"manifiesto_space_noanatcontenedortipo"	=> new Punto(118,	111,	false),
					"manifiesto_space_noanatcantidad"		=> new Punto(143,	111,	false),
					"manifiesto_space_noanatunidad"			=> new Punto(170,	111,	false),
					"manifiesto_space_sangrecontenedorcap"	=> new Punto(95,	94,		false),
					"manifiesto_space_sangrecontenedortipo"	=> new Punto(118,	94,		false),
					"manifiesto_space_sangecantidad"		=> new Punto(143,	94,		false),
					"manifiesto_space_sangreunidad"			=> new Punto(170,	94,		false),
					"manifiesto_space_otrocontenedorcap"	=> new Punto(95,	123,	false),
					"manifiesto_space_otrocontenedortipo"	=> new Punto(118,	123,	false),
					"manifiesto_space_otrocantidad"			=> new Punto(143,	123,	false),
					"manifiesto_space_otrounidad"			=> new Punto(170,	123,	false),
					"manifiesto_space_totalcontenedorcap"	=> new Punto(95,	128,	false),
					"manifiesto_space_totalcontenedortipo"	=> new Punto(118,	128,	false),
					"manifiesto_space_totalcantidad"		=> new Punto(143,	128,	false),
					"manifiesto_space_totalunidad"			=> new Punto(170,	128,	false),
					"manifiesto_space_cetificacion"			=> new Punto(43,	160,	false)
					)
				),
			"transporte"							=> array(
				"posicion"							=> new Punto(),
				"campos"							=> array(
					"manifiesto_space_transprazonsoc"		=> new Punto(69,	166),
					"manifiesto_space_transpdocimicilio"	=> new Punto(20,	171),
					"manifiesto_space_transptel"			=> new Punto(125,	171),
					"manifiesto_space_transpautsemarnat"	=> new Punto(50,	177),
					"manifiesto_space_transpregsct"			=> new Punto(107,	177),
					"manifiesto_space_transpoperadornombre"	=> new Punto(19,	187),
					"manifiesto_space_transpoperadorfirma"	=> new Punto(103,	187,	false),
					"manifiesto_space_transpoperadorcargo"	=> new Punto(19,	192),
					"manifiesto_space_transpfecha"			=> new Punto(125,	192,	false),
					"manifiesto_space_transpruta"			=> new Punto(3,		201,	false),
					"manifiesto_space_transpvahiculotipo"	=> new Punto(38,	207),
					"manifiesto_space_transpvahiculoplaca"	=> new Punto(113,	207)
					)
				),
			"destinatario"							=> array(
				"posicion"							=> new Punto(),
				"campos"							=> array(
					"manifiesto_space_dest_razonsoc"		=> new Punto(67,	214),
					"manifiesto_space_dest_nautsemarnat"	=> new Punto(70,	220),
					"manifiesto_space_dest_domicilio"		=> new Punto(20,	226),
					"manifiesto_space_dest_recibido"		=> new Punto(85,	232,	false),
					"manifiesto_space_dest_observaciones"	=> new Punto(29,	239,	false),
					"manifiesto_space_dest_nombre"			=> new Punto(20,	250,	false),
					"manifiesto_space_dest_firma"			=> new Punto(20,	256,	false),
					"manifiesto_space_dest_cargo"			=> new Punto(130,	250,	false),
					"manifiesto_space_dest_fecha"			=> new Punto(160,	256,	false)
					)
				)
		);
	}
}
$obj=new Coordenadas();
$str=json_encode($obj);
echo $str;
file_put_contents("coordenadas_manifiesto.json",$str);
?>