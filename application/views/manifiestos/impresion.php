<?php
if(!isset($idx)) $idx=0;

if($idx==0) echo '<link rel="stylesheet" type="text/css" href="'.base_url("project_files/css/manifiestoimpresion.css").'" />'."\r\n";
?>
<div class="manifiestoView" <?= $idx>0?'style="top:'.(1021*$idx).'px;"':"" ?> >
	<div class="manifiestoViewScreen">
		<div class="manifiestoPage">
			<img class="logo01" src="<?= base_url('project_files/img/sistema/logosemarnat.jpg'); ?>" />
			<div class="encabezado01">
				secretaria de medio ambiente y recursos naurales<br />
				subsecretaria de gestiónn para la proteción ambiental<br />
				dirección general de gestión integral de materiales<br />
				y actividades riesgosas
			</div>
			<div class="encabezado02">
				manifiesto de entrega, transporte y recepción<br />
				de residuos peligrosos
			</div>
			<div class="clientegenerador">
				No. Cte.:<br />
				No. Gen.:
			</div>
			<table class="manifiestoCuerpo">
				<tr>
					<th class="manifiestoSeccion">g e n e r a d o r</th>
					<td>
						<table class="dataTable">
							<tr>
								<td colspan="2">
									1. NÚM. RE REGISTRO AMBIENTAL (o Núm de Registro como Empresa Generadora)<br />
									&nbsp;
								</td>
								<td colspan="2">
								    2. No. DE MANIFIESTO
								</td>
								<td>
									3. PAGINA
								</td>
							</tr>
							<tr>
								<td colspan="5">
									4. RAZON SOCIAL DE LA EMPRESA GENERADORA <br />
									DOMICILIO <br />
									MUNICIPIO O DELEGACIÓN <span style="width: 200px;"></span> C.P.: <span style="width: 200px;"></span> EDO: <br />
									TEL. <span style="width: 140px;"></span> REFERENCIAS: 
								</td>
							</tr>
							<tr>
								<th rowspan="2">
									5. DESCRIPCION (Nombre del resiudo y caracterpisticas CRETIB)
								</th>
								<th colspan="2">
									CONTENEDOR
								</th>
								<th rowspan="2">
									CANTIDAD<br/>
									TOTAL DE RESIDUO
								</th>
								<th rowspan="2">
									UNIDAD<br />
									VOLUMEN/PESO
								</th>
							</tr>
							<tr>
								<th>
									CAPACIDAD
								</th>
								<th>
									TIPO
								</th>
							</tr>
							<tr>
								<td>
									Cultivos y Cepas
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>
									Objetos Punzocortantes
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>
									Patólógicos
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>
									No Anatómicos
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>
									Sangre
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>
									&nbsp;
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>
									TOTAL
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="5">
									6. INSTRUCCIONES ESPECIALES INFORMACION ADICIONAL PARA EL MANEJO SEGURO<br />
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="5">
									7. CERTIFICACION DEL GENERADOR: <br />
									<div style="font-size: 5.5pt;">
										DECLARO QUE EL CONTENIDO DE ESTE LOTE ESTA TOTAL Y CORRECTAMENTE DESCRITO MEDIANTE EL NOMBRE DEL RESIDUO, CARACTERISTICAS CRETIB, BIEN EMPACADO, MARCADO Y ROTULADO, Y QUE SE HAN PREVISTO LAS CONDICIONES DE SEGURIDAD PARA SU TRANSPORTE POR VIA TERRESTRE DE ACUERDO A LA LEGISLACION NACIONAL VIGENTE.
									</div>
									<div style="font-size: 5.5pt; margin-top: 12px; margin-bottom: 10px;">
										NOMBRE Y FIRMA DEL RESPONSABLE
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th class="manifiestoSeccion">t r a n s p o r t e</th>
					<td>
						<table class="dataTable">
							<tr>
								<td>
									8. NOMBRE DE LA EMPRESA TRANSPORTISTA: <br />	
									DOMICILIO: <span style="width: 360px;"></span> TEL. <br />
									AUTORIZACIÓN DE LA SEMARNAT: <span style="width: 75px;"></span> NO. DE REGISTRO S.C.T. <br />
									&nbsp;
								</td>
							</tr>
							<tr>
								<td>
									9. RECIBI LOS RESIDUOS DESCRITOS EN EL MANIFIESTO PARA SU TRANSPORTE. <br />
									NOMBRE: <span style="width: 285px;"></span> FIRMA <br />
									CARGO: <span style="width: 293px;"></span> FECHA DE EMBARQUE: <br/>
									10. RUTA DE LA EMPRESA GENERADORA HASTA SU ENTREGA. <span style="width: 150px;"></span> <span style="font-size: 5.5pt;">MES DIA AÑO</span> <br />
									&nbsp;
								</td>
							</tr>
							<tr>
								<td>
									11. TIPO  DE VEHICULO <span style="width: 215px;"></span> No. DE PLACA:<br />
									&nbsp;
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th class="manifiestoSeccion">d e s t i n a t a r i o</th>
					<td>
						<table class="dataTable">
							<tr>
								<td>
									12.- NOMBRE DE LA EMPRESA DESTINATARIA: <br />
									&nbsp; <br />
									NÚMERO DE AUTORIZACIÓN DE LA SEMARNAT: <br />
									&nbsp; <br />
									DOMICILIO: <br />
									&nbsp;
								</td>
							</tr>
							<tr>
								<td>
									13.- RECIBI LOS RESIDUOS DESCRITOS EN EL MANIFIESTO. <br />
									&nbsp; <br />
									OBSERVACIONES: <br />
									&nbsp;
								</td>
							</tr>
							<tr>
								<td>
									NOMBRE: <span style="width: 387px;"></span> CARGO:	<br />
									&nbsp;<br />
									FIRMA: <span style="width: 400px;"></span> FECHA DE RECEPCIÓN : <br />
									&nbsp;
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="manifiestoViewPrint">
		<div class="manifiesto_space_nocte"><?= $cliente->getIdentificador(); ?></div>
		<div class="manifiesto_space_nogen"><?= $generador->getIdentificador(); ?></div>
		<div class="manifiesto_space_nrg"><?= $generador->getNumregamb(); ?></div>
		<div class="manifiesto_space_nomanifiesto"><?= $manifiesto->getIdentificador(); ?></div>
		<div class="manifiesto_space_pagina">1 / 1</div>
		<div class="manifiesto_space_generedorrazonsocial"><?= $generador->getRazonsocial(); ?></div>
		<div class="manifiesto_space_generadordocimicilio"><?= $generador->getCalle().", ".$generador->getNumexterior().($generador->getNuminterior()!=""?" (Int. ".$generador->getNuminterior().")":"").", ".$generador->getColonia(); ?></div>
		<div class="manifiesto_space_generadordelegacion"><?= $generador->getMunicipio(); ?></div>
		<div class="manifiesto_space_generadorcp"><?= $generador->getCp(); ?></div>
		<div class="manifiesto_space_generadoredo"><?= $generador->getEstado(); ?></div>
		<div class="manifiesto_space_generadortel"><?= $generador->getRepresentantetelefono().($generador->getRepresentanteextension()!=""?"-".$generador->getRepresentanteextension():""); ?></div>
		<?php
		$refs="";
		$hr1="";
		$hr2="";
		if($generador->getReferencias()) $refs=$generador->getReferencias();
		if($generador->getHorarioinicio()!="" || $generador->getHorariofin()!="") $hr1=$generador->getHorarioinicio()."-".$generador->getHorariofin();
		if($generador->getHorarioinicio2()!="" || $generador->getHorariofin2()!="") $hr2=$generador->getHorarioinicio2()."-".$generador->getHorariofin2();
		$refs.=($refs!=""?", ":"").$hr1;
		$refs.=($refs!=""?", ":"").$hr2;
		?><div class="manifiesto_space_generadorreferencias"><?= $refs; ?></div>
		<div class="manifiesto_space_instrucciones"><?= $manifiesto->getInstruccionesespeciales(); ?></div>
		<?php if(isset($recoleccion["BI1"]) && $recoleccion["BI1"]!==false): ?>
		<div class="manifiesto_space_cccontenedorcap"><?= $recoleccion["BI1"]["contenedorcapacidad"]; ?></div>
		<div class="manifiesto_space_cccontenedortipo"><?= $recoleccion["BI1"]["contenedortipo"]; ?></div>
		<div class="manifiesto_space_cccantidad"><?= $recoleccion["BI1"]["cantidad"]; ?></div>
		<div class="manifiesto_space_ccunidad"><?= $recoleccion["BI1"]["unidad"]; ?></div>
		<?php endif; 
		if(isset($recoleccion["BI2"]) && $recoleccion["BI2"]!==false): ?>
		<div class="manifiesto_space_punzcontenedorcap"><?= $recoleccion["BI2"]["contenedorcapacidad"]; ?></div>
		<div class="manifiesto_space_punzcontenedortipo"><?= $recoleccion["BI2"]["contenedortipo"]; ?></div>
		<div class="manifiesto_space_punzcantidad"><?= $recoleccion["BI2"]["cantidad"]; ?></div>
		<div class="manifiesto_space_punzunidad"><?= $recoleccion["BI2"]["unidad"]; ?></div>
		<?php endif; 
		if(isset($recoleccion["BI3"]) && $recoleccion["BI3"]!==false): ?>
		<div class="manifiesto_space_patcontenedorcap"><?= $recoleccion["BI3"]["contenedorcapacidad"]; ?></div>
		<div class="manifiesto_space_patcontenedortipo"><?= $recoleccion["BI3"]["contenedortipo"]; ?></div>
		<div class="manifiesto_space_patcantidad"><?= $recoleccion["BI3"]["cantidad"]; ?></div>
		<div class="manifiesto_space_patunidad"><?= $recoleccion["BI3"]["unidad"]; ?></div>
		<?php endif; 
		if(isset($recoleccion["BI4"]) && $recoleccion["BI4"]!==false): ?>
		<div class="manifiesto_space_noanatcontenedorcap"><?= $recoleccion["BI4"]["contenedorcapacidad"]; ?></div>
		<div class="manifiesto_space_noanatcontenedortipo"><?= $recoleccion["BI4"]["contenedortipo"]; ?></div>
		<div class="manifiesto_space_noanatcantidad"><?= $recoleccion["BI4"]["cantidad"]; ?></div>
		<div class="manifiesto_space_noanatunidad"><?= $recoleccion["BI4"]["unidad"]; ?></div>
		<?php endif; 
		if(isset($recoleccion["BI5"]) && $recoleccion["BI5"]!==false): ?>
		<div class="manifiesto_space_sangrecontenedorcap"><?= $recoleccion["BI5"]["contenedorcapacidad"]; ?></div>
		<div class="manifiesto_space_sangrecontenedortipo"><?= $recoleccion["BI5"]["contenedortipo"]; ?></div>
		<div class="manifiesto_space_sangecantidad"><?= $recoleccion["BI5"]["cantidad"]; ?></div>
		<div class="manifiesto_space_sangreunidad"><?= $recoleccion["BI5"]["unidad"]; ?></div>
		<?php endif; ?>
		<div class="manifiesto_space_otrocontenedorcap"></div>
		<div class="manifiesto_space_otrocontenedortipo"></div>
		<div class="manifiesto_space_otrocantidad"></div>
		<div class="manifiesto_space_otrounidad"></div>
		<div class="manifiesto_space_totalcontenedorcap"></div>
		<div class="manifiesto_space_totalcontenedortipo"></div>
		<div class="manifiesto_space_totalcantidad"></div>
		<div class="manifiesto_space_totalunidad"></div>
		<div class="manifiesto_space_cetificacion"><?= $generador->getRepresentante(); ?></div>
		<?php
		$sucursal->setIdsucursal($ruta->getEmpresatransportista());
		$sucursal->getFromDatabase();
		$empresa->setIdempresa($sucursal->getIdempresa());
		$empresa->getFromDatabase();
		?>
		<div class="manifiesto_space_transprazonsoc"><?= $empresa->getRazonsocial(); ?></div>
		<div class="manifiesto_space_transpdocimicilio"><?= $sucursal->getCalle().", ".$sucursal->getNumexterior().($sucursal->getNuminterior()!=""?"-".$sucursal->getNuminterior():"").", ".$sucursal->getColonia().", ".$sucursal->getMunicipio().", ".$sucursal->getEstado(); ?></div>
		<div class="manifiesto_space_transptel"><?= $sucursal->getTelefono(); ?></div>
		<div class="manifiesto_space_transpautsemarnat"><?= $sucursal->getAutsemarnat(); ?></div>
		<div class="manifiesto_space_transpregsct"><?= $sucursal->getRegistrosct(); ?></div>
		<div class="manifiesto_space_transpoperadornombre"><?= $operador->getNombre()." ".$operador->getApaterno()." ".$operador->getAmaterno(); ?></div>
		<div class="manifiesto_space_transpoperadorfirma"></div>
		<div class="manifiesto_space_transpoperadorcargo"><?= $operador->getCargo(); ?></div>
		<div class="manifiesto_space_transpfecha"><?= DateToMx($manifiesto->getFechaembarque()); ?></div>
		<div class="manifiesto_space_transpruta"><?= $ruta->getIdentificador()." - ".$ruta->getNombre(); ?></div>
		<div class="manifiesto_space_transpvahiculotipo"><?= $vehiculo->getTipo(); ?></div>
		<div class="manifiesto_space_transpvahiculoplaca"><?= $vehiculo->getPlaca(); ?></div>
		<?php
		$sucursal->setIdsucursal($ruta->getEmpresadestinofinal());
		$sucursal->getFromDatabase();
		$empresa->setIdempresa($sucursal->getIdempresa());
		$empresa->getFromDatabase();
		?>
		<div class="manifiesto_space_dest_razonsoc"><?= $empresa->getRazonsocial(); ?></div>
		<div class="manifiesto_space_dest_nautsemarnat"><?= $sucursal->getAutsemarnat(); ?></div>
		<div class="manifiesto_space_dest_domicilio"><?= $sucursal->getCalle().", ".$sucursal->getNumexterior().($sucursal->getNuminterior()!=""?"-".$sucursal->getNuminterior():"").", ".$sucursal->getColonia().", ".$sucursal->getMunicipio().", ".$sucursal->getEstado(); ?></div>
		<div class="manifiesto_space_dest_recibido"></div>
		<div class="manifiesto_space_dest_observaciones"><?= $manifiesto->getObservacionesdestinofinal(); ?></div>
		<div class="manifiesto_space_dest_nombre"><?= $sucursal->getRepresentante(); ?></div>
		<div class="manifiesto_space_dest_firma"></div>
		<div class="manifiesto_space_dest_cargo"><?= $sucursal->getCargorepresentante(); ?></div>
		<div class="manifiesto_space_dest_fecha"><?= DateToMx($manifiesto->getFecharecepcion()); ?></div>
	</div>
</div>
<?php if($imprimir):?>
	<script type="text/javascript">
		window.print();
	</script>
<?php endif; ?>