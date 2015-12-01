function Alert(mensaje,afterOk) //msgID: 1 Deprecated
{
	$.msg({
		autoUnblock : 	false,
		bgPath : 		baseURL+'project_files/msg/',
        clickUnblock : 	false,
		content:		'<div>'+mensaje+'</div><div style="text-align: center;"><button id="btnOk" class="btn btn-success">Aceptar</button></div>',
		afterBlock:		function(){
							var self=this;
							$('#btnOk').bind('click',function(){
								self.unblock(300);
								afterOk();
							});
		                }
		//, msgID:1
	});
}
function Confirm(mensaje,afterOk) //msgID: 2 Deprecated
{
	$.msg({
		autoUnblock : 	false,
		bgPath : 		baseURL+'project_files/msg/',
        clickUnblock : 	false,
		content:		'<div>'+mensaje+'</div><div style="text-align: center;"><button id="btnOk" class="btn btn-success">Aceptar</button> <button id="btnCancel" class="btn btn-danger">Cancelar</button></div>',
		afterBlock : 	function(){
							var self=this;
							$('#btnOk').bind('click',function(){
								self.unblock(300);
								afterOk();
							});
							$('#btnCancel').bind('click',function(){
								self.unblock(300);
							});
		                }
		//, msgID:2
	});
}
function Mensaje(mensaje) //msgID: 3
{
	$.msg({
		autoUnblock : 	false,
		bgPath : 		baseURL+'project_files/msg/',
        clickUnblock : 	false,
		content:		mensaje,
		msgID:			3
	});
}
function MensajeAfter(mensaje,afterOk) //msgID: 4
{
	$.msg({
		autoUnblock : 	false,
		bgPath : 		baseURL+'project_files/msg/',
        clickUnblock : 	false,
		content:		mensaje,
		afterBlock:		function(){
							var self=this;
							afterOk();
						},
		msgID:			4
	});
}
function MuestraCPFrm(cp,colonia,municipio,estado,fnSelecciona)
{
	var datos="cp="+cp+"&colonia="+colonia+"&municipio="+municipio+"&estado="+estado+"&fnSelecciona="+fnSelecciona;
	Mensaje("Cargando Códigos Postales");
	var ajx=$.ajax({
		method:	"POST",
		url:	baseURL+'generico/creaFrmCP',
		cache:	false,
		data:	datos
	});
	ajx.fail(function(jqXHRObj,mensaje){
		$.msg('unblock',10,3);
		setTimeout(function(){
			Mensaje("Error al cargar formulario: "+mensaje+"<br />"+jqXHRObj.responseText);
		},500);
	});
	ajx.done(function(resp){
		$.msg('unblock',10,3);
		setTimeout(function(){
			MensajeAfter(resp,function(){
				$("#btnCancelarCP").bind('click',function(){
					$.msg('unblock',10,3);
				});
				$("#btnBuscarCP").bind('click',function(){
					var tmpCp			= $("#frm_cp_cp").val().trim();
					var tmpColonia		= $("#frm_cp_colonia").val().trim();
					var tmpMunicipio	= $("#frm_cp_municipio").val().trim();
					var tmpEstado		= $("#frm_cp_estado").val().trim();
					$.msg('unblock',10,4);
					setTimeout(function(){
						MuestraCPFrm(tmpCp,tmpColonia,tmpMunicipio,tmpEstado,fnSelecciona);
					},500);
				});
			});
		},500);
	});
}
function fnValidaciones()
{
	this.Vacio=function(idCampo,mensaje)
	{
		var valor	= "";
		valor		= $("#"+idCampo).val();
		valor		= (valor==null?'':valor.trim());
		if(valor.length==0) 
		{
			Alert(mensaje,function(){$("#"+idCampo).focus();});
			return true;
		}
		return false;
	}
	this.Numerico=function(idCampo,mensaje)
	{
		var valor	= "";
		valor		= $("#"+idCampo).val();
		valor		= (valor==null?'':valor.trim());
		if(this.Vacio(idCampo,mensaje))
			return false;
		if(isNaN(valor))
		{
			Alert(mensaje,function(){$("#"+idCampo).focus();});
			return false;
		}
		return true;
	}
	this.NPositivo=function(idCampo,mensaje,IncluyeCero)
	{
		if(this.Numerico(idCampo,mensaje))
		{
			var valor	= "";
			valor		= parseInt($("#"+idCampo).val().trim());
			if(IncluyeCero)
			{
				if(valor>=0) return true;
				else Alert(mensaje,function(){$("#"+idCampo).focus();});
			}
			else
				if(valor>0) return true;
				else Alert(mensaje,function(){$("#"+idCampo).focus();});
		}
		return false;
	}
	this.LargoEntre=function(idCampo,mensaje,minimo,maximo,puedeSerVacio)
	{
		var valor	= "";
		valor		= $("#"+idCampo).val();
		valor		= (valor==null?'':valor.trim());
		if(!puedeSerVacio && this.Vacio(idCampo,mensaje))
			return false;
		if(puedeSerVacio && valor.length==0)
			return true;
		if(valor.length<minimo||valor.length>maximo)
		{
			Alert(mensaje,function(){$("#"+idCampo).focus();});
			return false;
		}
		return true;
	}
	this.LargoCampo=function(idCampo)
	{
		var valor	= "";
		valor		= $("#"+idCampo).val();
		valor		= (valor==null?'':valor.trim());
		return valor.length;
	}
	this.Valor=function(idCampo)
	{
		var valor	= "";
		valor		= $("#"+idCampo).val();
		valor		= (valor==null?'':valor.trim());
		return valor;
	}
	this.CreaDireccion=function(idCampoCalle, idCampoNumExterior, idCampoNumInterior, idCampoColonia,idCampoDelegacion,idCampoEstado)
	{
		var calle		= this.Valor(idCampoCalle);
		var numExterior	= this.Valor(idCampoNumExterior);
		var numInterior	= this.Valor(idCampoNumInterior);
		var colonia		= this.Valor(idCampoColonia);
		var delegacion	= idCampoDelegacion!=""?this.Valor(idCampoDelegacion):"";
		var estado		= idCampoEstado!=""?this.Valor(idCampoEstado):"";
		var direccion	= "";
		direccion += calle + " ";
		direccion += numExterior;
		if(numInterior!="")
			direccion += " (Int. " + numInterior + "), ";
		else
			direccion += ", ";
		direccion += colonia;
		if(delegacion!="")
			direccion += ", "+delegacion;
		if(estado!="")
			direccion += ", "+estado
		return direccion;
	}
}

Date.prototype.getDiaSemana=function()
{
	var dias=new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	return dias[this.getDay()];
}
Date.prototype.getMes=function()
{
	var meses=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	return meses[this.getMonth()];
}
Date.prototype.agregaDias=function(numDias)
{
	this.setTime(this.getTime()+numDias*24*60*60*1000)
	return this;
}
Date.prototype.getSemana=function(anioAnterior)
{
	var diaPrimero=new Date(this.getFullYear()-(anioAnterior?1:0),0,1);
	var diasTranscurridos=Math.floor((this.getTime()-diaPrimero.getTime())/(1*24*60*60*1000));
	var nen=[6,7,8,9,10,4,5][diaPrimero.getDay()];
	var sem=Math.floor((diasTranscurridos+nen)/7);
	if(sem==0)
		return this.getSemana(true);
	return sem;
}
Date.prototype.getSemanaEnMes=function()
{
	var diaPrimero=new Date(this.getFullYear(),this.getMonth(),1);
	/*while(diaPrimero.getDay()!=1) // Es uno xq la semana inicia en lunes
	{
		diaPrimero.agregaDias(1);
	}*/
	var numSemana=this.getSemana(false)-diaPrimero.getSemana(false)+(diaPrimero.getDay()==0?0:1);
	if(numSemana>0)
		return numSemana;
	return this.getSemana(false)+(diaPrimero.getDay()==0?0:1);
}
Array.prototype.igual=function(data)
{
	var cont=0;
	for(var x in this) 
		if(!isNaN(x) && typeof data[x]!="undefined" && this[x]==data[x])
			cont++;
	return (this.length==data.length && cont==this.length);
}

function fnEmpresa()
{
	this.ValidaFrmIn=function()
	{
		if(Validacion.Vacio('frm_empresa_razonsocial','Debe ingresar la razon social de la empresa'))
			return false;
		if(Validacion.Vacio('frm_empresa_rfc','Debe ingresar el rfc de la empresa'))
			return false;
		var valor	= "";
		valor		= $("#frm_empresa_cp").val().trim();
		if(valor.length>0 && isNaN(parseInt(valor)) && parseInt(valor)>0 && parseInt(valor)<99999)
		{
			Alert('El codigo postal debe formarse por 5 digitos numéricos',function(){$('#frm_empresa_cp').focus();})
			return false;
		}		
		if(Validacion.Vacio('frm_empresa_representante','Debe ingresar el nombre del representante de la empresa'))
			return false;		
		if(Validacion.Vacio('frm_empresa_autsemarnat','Debe ingresar el número de autorización SEMARNAT de la empresa'))
			return false;		
		if(Validacion.Vacio('frm_empresa_registrosct','Debe ingresar el número de registro SCT de la empresa'))
			return false;
		if(!Validacion.LargoEntre('frm_empresa_telefono',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		return true
	}
	this.Enviar=function(nuevo)
	{
		if(this.ValidaFrmIn())
		{
			var urlFrm=baseURL+"empresas/"+(nuevo===true?'add':'update');
			Mensaje("Guardando");
			var ajx=$.ajax({
				method:	"POST",
				url:	urlFrm,
				cache:	false,
				data:	$("#frm_empresas").serialize()
			});
			ajx.done(function(resp){
				if(resp!="" && !isNaN(parseInt(resp)))
					location.href=baseURL+"empresas/ver/"+resp;
				else
					Mensaje(resp);
			});
			ajx.fail(function(jqXHRObj,mensaje){
				$.msg('unblock',10,3);
				setTimeout(function(){
					Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500)
			});
		}
	}
	this.Eliminar=function(id)
	{
		Confirm("¿Realmente desa eliminar esta empresa?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'empresas/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'empresas';
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
			
		});
	}
	this.DisplayFrmCP=function()
	{
		MuestraCPFrm($("#frm_empresa_cp").val().trim(),'','','','Empresa.EstableceCP')
	}
	this.EstableceCP=function(cp,colonia,municipio,estado)
	{
		$.msg('unblock',10,4);
		$("#frm_empresa_cp"			).attr('value',	cp);
		$("#frm_empresa_colonia"	).attr('value',	colonia);
		$("#frm_empresa_municipio"	).attr('value',	municipio);
		$("#frm_empresa_estado"		).attr('value',	estado);
	}
}

function fnSucursal()
{
	this.CopiaDireccion=function()
	{
		if(dataEmpresa && dataEmpresa.direccion)
		{
			$("#frm_sucursal_calle"			).attr('value',	dataEmpresa.direccion.calle);
			$("#frm_sucursal_numexterior"	).attr('value',	dataEmpresa.direccion.numexterior);
			$("#frm_sucursal_numinterior"	).attr('value',	dataEmpresa.direccion.numinterior);
			$("#frm_sucursal_cp"			).attr('value',	dataEmpresa.direccion.cp);
			$("#frm_sucursal_colonia"		).attr('value',	dataEmpresa.direccion.colonia);
			$("#frm_sucursal_municipio"		).attr('value',	dataEmpresa.direccion.municipio);
			$("#frm_sucursal_estado"		).attr('value',	dataEmpresa.direccion.estado);
			return true;
		}
		return false;
	}
	this.CopiaContacto=function()
	{
		if(dataEmpresa && dataEmpresa.contacto)
		{
			$("#frm_sucursal_representante"			).attr('value',	dataEmpresa.contacto.representante);
			$("#frm_sucursal_cargorepresentante"	).attr('value',	dataEmpresa.contacto.cargorepresentante);
			$("#frm_sucursal_telefono"				).attr('value',	dataEmpresa.contacto.telefono);
			return true;
		}
		return false;
	}
	this.CopiaLegal=function()
	{
		if(dataEmpresa && dataEmpresa.legal)
		{
			$("#frm_sucursal_autsemarnat"	).attr('value',	dataEmpresa.legal.autsemarnat);
			$("#frm_sucursal_registrosct"	).attr('value',	dataEmpresa.legal.registrosct);
			return true;
		}
		return false;
	}
	this.DisplayFrmCP=function()
	{
		MuestraCPFrm($("#frm_sucursal_cp").val().trim(),'','','','Sucursal.EstableceCP')
	}
	this.EstableceCP=function(cp,colonia,municipio,estado)
	{
		$.msg('unblock',10,4);
		$("#frm_sucursal_cp"		).attr('value',cp);
		$("#frm_sucursal_colonia"	).attr('value',colonia);
		$("#frm_sucursal_municipio"	).attr('value',municipio);
		$("#frm_sucursal_estado"	).attr('value',estado);
	}
	this.ValidaFrmIn=function()
	{
		if(Validacion.Vacio('frm_sucursal_nombre','Debe ingresar el nombre o razón social de la sucursal'))
			return false;
		var valor="";
		valor=$("#frm_sucursal_cp").val().trim();
		if(valor.length>0 && isNaN(parseInt(valor)))
		{
			Alert('El codigo postal debe formarse por 5 digitos numéricos',function(){$('#frm_sucursal_cp').focus();})
			return false;
		}
		if(Validacion.Vacio('frm_sucursal_representante','Debe ingresar el nombre del representante de la sucursal'))
			return false;
		//if(Validacion.Vacio('frm_sucursal_autsemarnat','Debe ingresar el número de autorización SEMARNAT de la sucursal'))
		//	return false;		
		//if(Validacion.Vacio('frm_sucursal_registrosct','Debe ingresar el número de registro SCT de la sucursal'))
		//	return false;		
		//if(Validacion.Vacio('frm_sucursal_numregamb','Debe ingresar el número de registro ambiental de la sucursal'))
		//	return false;
		if(!Validacion.LargoEntre('frm_sucursal_telefono',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		var domicilio=Validacion.CreaDireccion(
			'frm_sucursal_calle',
			'frm_sucursal_numexterior',
			'frm_sucursal_numinterior',
			'frm_sucursal_colonia',
			'frm_sucursal_municipio',
			'frm_sucursal_estado'
		);
		if(domicilio.length>90)
		{
			Alert('El Domicilio Formado "' + domicilio + '" no debe superar los 49 caracteres',function(){$("#frm_sucursal_calle").focus();});
			return false;
		}
		return true
	}
	this.Enviar=function(nuevo)
	{
		if(this.ValidaFrmIn())
		{
			var urlFrm=baseURL+"sucursales/"+(nuevo===true?'add':'update');
			Mensaje("Guardando");
			var ajx=$.ajax({
				method:	'POST',
				url:	urlFrm,
				cache:	false,
				data:	$('#frm_sucursales').serialize()
			});
			ajx.done(function(resp){
				if(resp!="" && !isNaN(parseInt(resp))) location.href=baseURL+"sucursales/ver/"+resp;
				else Mensaje(resp);
			});
			ajx.fail(function(jqXHRObj,mensaje){
				$.msg('unblock',10,3);
				setTimeout(function(){
					Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500);
			});
		}
	}
	this.Eliminar=function(idEmpresa,id)
	{
		Confirm("¿Realmente desa eliminar esta sucursal?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'sucursales/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'sucursales/index/'+idEmpresa;
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
		});
	}
}

function fnOperador()
{
	this.ValidaFrmIn=function()
	{
		if(Validacion.Vacio('frm_operador_nombre','Debe ingresar el nombre del operador.'))
			return false;
		if(!Validacion.LargoEntre('frm_operador_telefono',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		var nombre = "";
		nombre	+= Validacion.Valor('frm_operador_nombre'	) + " ";
		nombre	+= Validacion.Valor('frm_operador_apaterno'	) + " ";
		nombre	+= Validacion.Valor('frm_operador_amaterno'	);
		if(nombre.length>37)
		{
			Alert('El Nombre Formado "' + nombre + '" no debe superar los 37 caracteres',function(){$("#frm_operador_nombre").focus();});
			return false;
		}
		return true
	}
	this.Enviar=function(nuevo)
	{
		if(this.ValidaFrmIn())
		{
			var urlFrm=baseURL+"operadores/"+(nuevo===true?'add':'update');
			Mensaje("Guardando");
			var ajx=$.ajax({
				method:	"POST",
				url:	urlFrm,
				cache:	false,
				data:	$("#frm_operadores").serialize()
			});
			ajx.done(function(resp){
				if(resp!="" && !isNaN(parseInt(resp)))
					location.href=baseURL+"operadores/ver/"+resp;
				else
					Mensaje(resp);
			});
			ajx.fail(function(jqXHRObj,mensaje){
				$.msg('unblock',10,3);
				setTimeout(function(){
					Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500)
			});
		}
	}
	this.Eliminar=function(idEmpresa,idSucursal,id)
	{
		Confirm("¿Realmente desa eliminar a este Operador?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'operadores/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'operadores/index/'+idEmpresa+'/'+idSucursal;
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
			
		});
	}
}

function fnVehiculo()
{
	this.ValidaFrmIn=function()
	{
		if(Validacion.Vacio('frm_vehiculo_placa','Debe ingresar la placa del vehículo.'))
			return false;
		return true
	}
	this.Enviar=function(nuevo)
	{
		if(this.ValidaFrmIn())
		{
			var urlFrm=baseURL+"vehiculos/"+(nuevo===true?'add':'update');
			Mensaje("Guardando");
			var ajx=$.ajax({
				method:	"POST",
				url:	urlFrm,
				cache:	false,
				data:	$("#frm_vehiculos").serialize()
			});
			ajx.done(function(resp){
				if(resp!="" && !isNaN(parseInt(resp)))
					location.href=baseURL+"vehiculos/ver/"+resp;
				else
					Mensaje(resp);
			});
			ajx.fail(function(jqXHRObj,mensaje){
				$.msg('unblock',10,3);
				setTimeout(function(){
					Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500)
			});
		}
	}
	this.Eliminar=function(idEmpresa,idSucursal,id)
	{
		Confirm("¿Realmente desa eliminar este Vehículo?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'vehiculos/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'vehiculos/index/'+idEmpresa+'/'+idSucursal;
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
		});
	}
}

function fnRuta()
{
	this.dias=["lunes","martes","miercoles","jueves","viernes","sabado","domingo"];
	this.ObtieneOperadores=function(idSucursal)
	{
		$("#frm_ruta_idoperador").empty();
		for(var idx in tmpSucursalesOperadoresVehiculos[idSucursal].operadores)
			$("#frm_ruta_idoperador").append('<option value="'+tmpSucursalesOperadoresVehiculos[idSucursal].operadores[idx].idoperador+'">'+tmpSucursalesOperadoresVehiculos[idSucursal].operadores[idx].nombre+'</option>');
	}
	this.ObtieneVehiculos=function(idSucursal)
	{
		$("#frm_ruta_idvehiculo").empty();
		for(var idx in tmpSucursalesOperadoresVehiculos[idSucursal].vehiculos)
			$("#frm_ruta_idvehiculo").append('<option value="'+tmpSucursalesOperadoresVehiculos[idSucursal].vehiculos[idx].idvehiculo+'">'+tmpSucursalesOperadoresVehiculos[idSucursal].vehiculos[idx].placa+'</option>');
	}
	this.ObtieneOperadoresVehiculos=function()
	{
		this.ObtieneOperadores($("#frm_ruta_empresatransportista").val());
		this.ObtieneVehiculos($("#frm_ruta_empresatransportista").val());
	}
	this.ValidaFrmIn=function()
	{
		if(Validacion.Vacio('frm_ruta_nombre','Debe ingresar el nombre de la ruta.'))
			return false;
		if(!Validacion.NPositivo('frm_ruta_empresadestinofinal','Debe seleccionar una sucursal de destino final.',false))
			return false;
		if(!Validacion.NPositivo('frm_ruta_empresatransportista','Debe seleccionar una sucursal de transportista.',false))
			return false;
		if(!Validacion.NPositivo('frm_ruta_idoperador','Debe seleccionar un operador para el para la ruta.',false))
			return false;
		if(!Validacion.NPositivo('frm_ruta_idvehiculo','Debe seleccionar un vehículo para la ruta.',false))
			return false;
		var ruta = "";
		ruta	+= Validacion.Valor('frm_ruta_identificador') + " - ";
		ruta	+= Validacion.Valor('frm_ruta_nombre'		);
		if(ruta.length>75)
		{
			Alert('La Ruta Formada "' + ruta + '" no debe superar los 75 caracteres',function(){$("#frm_ruta_nombre").focus();});
			return false;
		}
		return true;
	}
	this.Enviar=function(nuevo)
	{
		if(this.ValidaFrmIn())
		{
			var urlFrm=baseURL+"rutas/"+(nuevo===true?'add':'update');
			Mensaje("Guardando");
			var ajx=$.ajax({
				method:	"POST",
				url:	urlFrm,
				cache:	false,
				data:	$("#frm_rutas").serialize()
			});
			ajx.done(function(resp){
				if(resp!="" && !isNaN(parseInt(resp)))
					location.href=baseURL+"rutas/ver/"+resp;
				else
					Mensaje(resp);
			});
			ajx.fail(function(jqXHRObj,mensaje){
				$.msg('unblock',10,3);
				setTimeout(function(){
					Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500)
			});
		}
	}
	this.Eliminar=function(idEmpresa,idSucursal,id)
	{
		Confirm("¿Realmente desa eliminar esta Ruta?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'rutas/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'rutas/index/'+idEmpresa+'/'+idSucursal;
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
			
		});
	}
	this.BuscarCteGen=function()
	{
		var identificadorCte=$("#cliente").val();
		var identificadorGen=$("#generador").val();
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+'rutas/getdatagenerador/'+identificadorCte+"/"+identificadorGen,
			cache:	false
		});
		ajx.done(function(resp){
			var resp=JSON.parse(resp);
			if(resp.length==1)
				Alert(resp[0],function(){return true;});
			else if(resp.length!=6)
				Alert(JSON.stringify(resp),function(){return true;});
			else
			{
				var tbl=$("#generadores")[0];
				var fila=tbl.rows.length;
				tbl.insertRow(fila);
				tbl.rows[fila].insertCell(0);
				tbl.rows[fila].insertCell(1);
				tbl.rows[fila].insertCell(2);
				tbl.rows[fila].insertCell(3);
				tbl.rows[fila].insertCell(4);
				tbl.rows[fila].cells[0].innerHTML='<input type="checkbox" checked="checked" value="'+resp[3]+'" />';
				tbl.rows[fila].cells[1].innerHTML=resp[2];
				tbl.rows[fila].cells[2].innerHTML=resp[1];
				tbl.rows[fila].cells[3].innerHTML=resp[5];
				tbl.rows[fila].cells[4].innerHTML=resp[4];
				$("#cliente")[0].value="";
				$("#generador")[0].value="";
				$("#cliente").focus();
			}
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al obtener los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.AddGeneradores=function()
	{
		var gens=new Array();
		$("#generadores input").each(function(idx){
			if(this.checked)
				gens.push(this.value);
		});
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+'rutas/addgeneradores/'+$("#idruta").val()+"/"+gens.join(","),
			cache:	false
		});
		ajx.done(function(resp){
			if(resp=="")
			{
				location.href=baseURL+"rutas/ver/"+$("#idruta").val();
			}
			else
				Alert(resp,function(){return true;});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al obtener los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.DelGeneradores=function()
	{
		var gens=new Array();
		$("#generadores input").each(function(idx){
			if(this.checked)
				gens.push(this.value);
		});
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+'rutas/delgeneradores/'+$("#idruta").val()+"/"+gens.join(","),
			cache:	false
		});
		ajx.done(function(resp){
			if(resp=="")
			{
				location.href=baseURL+"rutas/ver/"+$("#idruta").val();
			}
			else
				Alert(resp,function(){return true;});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al obtener los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.VerPlanRecoleccion=function()
	{
		Mensaje("Generando");
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/validacreacionrutacalendario/0/0",
			cache:	false,
			data:{
				ruta:		$("#ruta").val(),
				bitacora:	"Plan de Recoleccion "+$("#ruta_name").val()+" ( "+$("#fecha").val()+")",
				fecha:		$("#fecha").val()
			}
		});
		ajx.done(function(resp){
			$.msg('unblock',10,3);
			$("#prevalidacion").html(resp);
			$("#prevalidacion div.form-group").hide();
			$("#prevalidacion table tr th:last-child").hide();
			$("#prevalidacion table tr td:last-child").hide();
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al generar datos de plan de recolección: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.FrmReporte=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"rutas/menucrearreporte",
			cache:	false
		});
		ajx.done(function(resp){
			Mensaje(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al cargar el menu: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
}

function fnCliente()
{
	this.CopiaGenerales=function()
	{
		$('#frm_cliente_cobranzacalle'			).attr('value',	$('#frm_cliente_calle'						).val().trim()	);
		$('#frm_cliente_cobranzanumexterior'	).attr('value',	$('#frm_cliente_numexterior'				).val().trim()	);
		$('#frm_cliente_cobranzanuminterior'	).attr('value',	$('#frm_cliente_numinterior'				).val().trim()	);
		$('#frm_cliente_cobranzacp'				).attr('value',	$('#frm_cliente_cp'							).val().trim()	);
		$('#frm_cliente_cobranzacolonia'		).attr('value',	$('#frm_cliente_colonia'					).val().trim()	);
		$('#frm_cliente_cobranzamunicipio'		).attr('value',	$('#frm_cliente_municipio'					).val().trim()	);
		$('#frm_cliente_cobranzaestado'			).attr('value',	$('#frm_cliente_estado'						).val().trim()	);
		$('#frm_cliente_cobranzacontacto'		).attr('value',	$('#frm_cliente_representante'				).val().trim()	);
		$('#frm_cliente_cobranzaemail'			).attr('value',	$('#frm_cliente_representanteemail'			).val().trim()	);
		$('#frm_cliente_cobranzatelefono'		).attr('value',	$('#frm_cliente_representantetelefono'		).val().trim()	);
		$('#frm_cliente_cobranzaextension'		).attr('value',	$('#frm_cliente_representanteextencion'		).val().trim()	);
		$('#frm_cliente_cobranzatelefono2'		).attr('value',	$('#frm_cliente_representantetelefono2'		).val().trim()	);
		$('#frm_cliente_cobranzaextension2'		).attr('value',	$('#frm_cliente_representanteextension2'	).val().trim()	);
	}
	this.DisplayFrmCP=function()
	{
		MuestraCPFrm($('#frm_cliente_cp').val().trim(),'','','','Cliente.EstableceCP');
	}
	this.DisplayFrmCPCobranza=function()
	{
		MuestraCPFrm($('#frm_cliente_cobranzacp').val().trim(),'','','','Cliente.EstableceCPCobranza');
	}
	this.EstableceCP=function(cp,colonia,municipio,estado)
	{
		$.msg('unblock',10,4);
		$("#frm_cliente_cp"			).attr('value',	cp);
		$("#frm_cliente_colonia"	).attr('value',	colonia);
		$("#frm_cliente_municipio"	).attr('value',	municipio);
		$("#frm_cliente_estado"		).attr('value',	estado);
	}
	this.EstableceCPCobranza=function(cp,colonia,municipio,estado)
	{
		$.msg('unblock',10,4);
		$("#frm_cliente_cobranzacp"			).attr('value',	cp);
		$("#frm_cliente_cobranzacolonia"	).attr('value',	colonia);
		$("#frm_cliente_cobranzamunicipio"	).attr('value',	municipio);
		$("#frm_cliente_cobranzaestado"		).attr('value',	estado);
	}
	this.ValidaFrmIn=function()
	{
		if(Validacion.Vacio('frm_cliente_razonsocial','Debe ingresar la razón social del cliente'))
			return false;
		if(Validacion.Vacio('frm_cliente_identificador','Debe ingresar el identificador único del cliente'))
			return false;
		if(Validacion.Vacio('frm_cliente_rfc','Debe ingresar el RFC del cliente'))
			return false;
		if(Validacion.Vacio('frm_cliente_representante','Debe ingresar el nombre del representante del cliente'))
			return false;
		if(!Validacion.LargoEntre('frm_cliente_representantetelefono',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		if(!Validacion.LargoEntre('frm_cliente_representantetelefono2',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		if(!Validacion.LargoEntre('frm_cliente_cobranzatelefono',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		if(!Validacion.LargoEntre('frm_cliente_cobranzatelefono2',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		return true;
	}
	this.Enviar=function(nuevo)
	{
		if(this.ValidaFrmIn())
		{
			var urlFrm=baseURL+"clientes/"+(nuevo===true?'add':'update');
			Mensaje("Guardando");
			var ajx=$.ajax({
				method:	"POST",
				url:	urlFrm,
				cache:	false,
				data:	$("#frm_clientes").serialize()
			});
			ajx.done(function(resp){
				if(resp!="" && !isNaN(parseInt(resp)))
					location.href=baseURL+"clientes/ver/"+resp;
				else
					Mensaje(resp);
			});
			ajx.fail(function(jqXHRObj,mensaje){
				$.msg('unblock',10,3);
				setTimeout(function(){
					Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500)
			});
		}
	}
	this.Eliminar=function(idEmpresa,idSucursal,id)
	{
		Confirm("¿Realmente desa eliminar este Cliente?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'clientes/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'clientes/index/'+idEmpresa+'/'+idSucursal;
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
			
		});
	}
	this.Buscar=function()
	{
		$("#frm_prefer").submit();
	}
	this.FrmAgregarFacturacion=function()
	{
		var urlFrm=baseURL+"generico/creaFrmFacturacion";
		var ajx=$.ajax({
			method:	"POST",
			url:	urlFrm,
			cache:	false
		});
		ajx.done(function(resp){
			Confirm(resp,function(){
				Cliente.AgregarFacturacion();
			});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.AgregarFacturacion=function()
	{
		var urlFrm=baseURL+"clientes/agregarfacturacion/"+$("#frm_cliente_idcliente").val();
		var ajx=$.ajax({
			method:	"POST",
			url:	urlFrm,
			cache:	false,
			data:	$("#frm_facturacion").serialize()
		});
		ajx.done(function(resp){
			$("#facturacion").html($("#facturacion").html()+resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.EliminaFacturacion=function(idFacturacion)
	{
		var nodo=$("#facturacion"+idFacturacion)[0];
		nodo.parentNode.removeChild(nodo);
	}
	this.FrmReporte=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"clientes/menucrearreporte",
			cache:	false
		});
		ajx.done(function(resp){
			Mensaje(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al cargar el menu: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
}

function fnGenerador()
{
	this.CopiaDatos=function()
	{
		if(dataCliente)
		{
			$("#frm_generador_razonsocial"		).attr('value',	dataCliente.razonsocial);
			$("#frm_generador_rfc"				).attr('value',	dataCliente.rfc);
			$("#frm_generador_observaciones"	).html(			dataCliente.observaciones);
			if(dataCliente.direccion)
			{
				$("#frm_generador_calle"		).attr('value',	dataCliente.direccion.calle);
				$("#frm_generador_numexterior"	).attr('value',	dataCliente.direccion.numexterior);
				$("#frm_generador_numinterior"	).attr('value',	dataCliente.direccion.numinterior);
				$("#frm_generador_cp"			).attr('value',	dataCliente.direccion.cp);
				$("#frm_generador_colonia"		).attr('value',	dataCliente.direccion.colonia);
				$("#frm_generador_municipio"	).attr('value',	dataCliente.direccion.municipio);
				$("#frm_generador_estado"		).attr('value',	dataCliente.direccion.estado);
			}
			if(dataCliente.representante)
			{
				$("#frm_generador_representante"			).attr('value',	dataCliente.representante.nombre);
				$("#frm_generador_representantecargo"		).attr('value',	dataCliente.representante.cargo);
				$("#frm_generador_representanteemail"		).attr('value',	dataCliente.representante.email);
				$("#frm_generador_representantetelefono"	).attr('value',	dataCliente.representante.telefono);
				$("#frm_generador_representanteextension"	).attr('value',	dataCliente.representante.extension);
				$("#frm_generador_representantetelefono2"	).attr('value',	dataCliente.representante.telefono2);
				$("#frm_generador_representanteextension2"	).attr('value',	dataCliente.representante.extension2);
			}
			if(dataCliente.facturacion)
			{
				$("#frm_generador_leyendas"				).html(				dataCliente.facturacion.leyendas);
				$("#frm_generador_ordencompra"			).attr('checked',	dataCliente.facturacion.ordencompra=="1");
				$("#frm_generador_desglosemanifiestos"	).attr('checked',	dataCliente.facturacion.desglosemanifiestos=="1");
			}
			if(dataCliente.cobranza)
			{
				$("#frm_generador_cobranzacontacto"			).attr('value',	dataCliente.cobranza.nombre);
				$("#frm_generador_cobranzaemail"			).attr('value',	dataCliente.cobranza.email);
				$("#frm_generador_cobranzatelefono"			).attr('value',	dataCliente.cobranza.telefono);
				$("#frm_generador_cobranzaextension"		).attr('value',	dataCliente.cobranza.extension);
				$("#frm_generador_cobranzatelefono2"		).attr('value',	dataCliente.cobranza.telefono2);
				$("#frm_generador_cobranzaextension2"		).attr('value',	dataCliente.cobranza.extension2);
				$("#frm_generador_cobranzaobservaciones"	).html(			dataCliente.cobranza.observaciones);
				$("#frm_generador_cobranzacalle"			).attr('value',	dataCliente.cobranza.calle);
				$("#frm_generador_cobranzanumexterior"		).attr('value',	dataCliente.cobranza.numexterior);
				$("#frm_generador_cobranzanuminterior"		).attr('value',	dataCliente.cobranza.numinterior);
				$("#frm_generador_cobranzacp"				).attr('value',	dataCliente.cobranza.cp);
				$("#frm_generador_cobranzacolonia"			).attr('value',	dataCliente.cobranza.colonia);
				$("#frm_generador_cobranzamunicipio"		).attr('value',	dataCliente.cobranza.municipio);
				$("#frm_generador_cobranzaestado"			).attr('value',	dataCliente.cobranza.estado);
			}
		}
	}
	this.CopiaGenerales=function()
	{
		$('#frm_generador_cobranzacalle'		).attr('value',	$('#frm_generador_calle').val().trim()						);
		$('#frm_generador_cobranzanumexterior'	).attr('value',	$('#frm_generador_numexterior').val().trim()				);
		$('#frm_generador_cobranzanuminterior'	).attr('value',	$('#frm_generador_numinterior').val().trim()				);
		$('#frm_generador_cobranzacp'			).attr('value',	$('#frm_generador_cp').val().trim()							);
		$('#frm_generador_cobranzacolonia'		).attr('value',	$('#frm_generador_colonia').val().trim()					);
		$('#frm_generador_cobranzamunicipio'	).attr('value',	$('#frm_generador_municipio').val().trim()					);
		$('#frm_generador_cobranzaestado'		).attr('value',	$('#frm_generador_estado').val().trim()						);
		$('#frm_generador_cobranzacontacto'		).attr('value',	$('#frm_generador_representante').val().trim()				);
		$('#frm_generador_cobranzaemail'		).attr('value',	$('#frm_generador_representanteemail').val().trim()			);
		$('#frm_generador_cobranzatelefono'		).attr('value',	$('#frm_generador_representantetelefono').val().trim()		);
		$('#frm_generador_cobranzaextension'	).attr('value',	$('#frm_generador_representanteextension').val().trim()		);
		$('#frm_generador_cobranzatelefono2'	).attr('value',	$('#frm_generador_representantetelefono2').val().trim()		);
		$('#frm_generador_cobranzaextension2'	).attr('value',	$('#frm_generador_representanteextension2').val().trim()	);
	}
	this.DisplayFrmCP=function()
	{
		MuestraCPFrm($('#frm_generador_cp').val().trim(),'','','','Generador.EstableceCP');
	}
	this.DisplayFrmCPCobranza=function()
	{
		MuestraCPFrm($('#frm_generador_cobranzacp').val().trim(),'','','','Generador.EstableceCPCobranza');
	}
	this.EstableceCP=function(cp,colonia,municipio,estado)
	{
		$.msg('unblock',10,4);
		$("#frm_generador_cp"			).attr('value',	cp);
		$("#frm_generador_colonia"		).attr('value',	colonia);
		$("#frm_generador_municipio"	).attr('value',	municipio);
		$("#frm_generador_estado"		).attr('value',	estado);
	}
	this.EstableceCPCobranza=function(cp,colonia,municipio,estado)
	{
		$.msg('unblock',10,4);
		$("#frm_generador_cobranzacp"			).attr('value',	cp);
		$("#frm_generador_cobranzacolonia"		).attr('value',	colonia);
		$("#frm_generador_cobranzamunicipio"	).attr('value',	municipio);
		$("#frm_generador_cobranzaestado"		).attr('value',	estado);
	}
	this.ValidaFrmIn=function()
	{
		if(Validacion.Vacio('frm_generador_razonsocial','Debe ingresar la razón social del generador'))
			return false;
		if(Validacion.Vacio('frm_generador_identificador','Debe ingresar el identificador del generador'))
			return false;
		if(Validacion.Vacio('frm_generador_rfc','Debe ingresar el RFC del generador'))
			return false;
		if(Validacion.Vacio('frm_generador_representante','Debe ingresar el nombre del representante del generador'))
			return false;
		if(!Validacion.LargoEntre('frm_generador_representantetelefono',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		if(!Validacion.LargoEntre('frm_generador_representantetelefono2',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		if(!Validacion.LargoEntre('frm_generador_cobranzatelefono',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		if(!Validacion.LargoEntre('frm_generador_cobranzatelefono2',"El telefono debe tener entre 10 y 13 digitos.",10,13,true))
			return false;
		var domicilio = Validacion.CreaDireccion(
			'frm_generador_calle',
			'frm_generador_numexterior',
			'frm_generador_numinterior',
			'frm_generador_colonia',
			'',
			''
		);
		if(domicilio.length>90)
		{
			Alert('El Domicilio Formado "' + domicilio + '" no debe superar los 90 caracteres',function(){$("#frm_generador_calle").focus();});
			return false;
		}
		if(!Validacion.LargoEntre('frm_generador_municipio',"El municipio o delegación no debe superar los 27 caracteres",0,27,true))
			return false;
		if(!Validacion.LargoEntre('frm_generador_estado',"El estado no debe superar los 16 caracteres",0,16,true))
			return false;
		if(!Validacion.LargoEntre('frm_generador_referencias',"Las referencias no deben superar los 39 caracteres",0,39,true))
			return false;
		return true;
	}
	this.Enviar=function(nuevo)
	{
		if(this.ValidaFrmIn())
		{
			var urlFrm=baseURL+"generadores/"+(nuevo===true?'add':'update');
			Mensaje("Guardando");
			var ajx=$.ajax({
				method:	"POST",
				url:	urlFrm,
				cache:	false,
				data:	$("#frm_generadores").serialize()
			});
			ajx.done(function(resp){
				if(resp!="" && !isNaN(parseInt(resp)))
					location.href=baseURL+"generadores/ver/"+resp;
				else
					Mensaje(resp);
			});
			ajx.fail(function(jqXHRObj,mensaje){
				$.msg('unblock',10,3);
				setTimeout(function(){
					Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500)
			});
		}
	}
	this.Eliminar=function(idCliente,id)
	{
		Confirm("¿Realmente desa eliminar este Generador?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'generadores/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'clientes/ver/'+idCliente;
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
			
		});
	}
	this.FrmAgregarFacturacion=function()
	{
		var urlFrm=baseURL+"generico/creaFrmFacturacion";
		var ajx=$.ajax({
			method:	"POST",
			url:	urlFrm,
			cache:	false
		});
		ajx.done(function(resp){
			Confirm(resp,function(){
				Generador.AgregarFacturacion();
			});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.AgregarFacturacion=function()
	{
		var urlFrm=baseURL+"generadores/agregarfacturacion/"+$("#frm_generador_idgenerador").val();
		var ajx=$.ajax({
			method:	"POST",
			url:	urlFrm,
			cache:	false,
			data:	$("#frm_facturacion").serialize()
		});
		ajx.done(function(resp){
			$("#facturacion").html($("#facturacion").html()+resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.EliminaFacturacion=function(idFacturacion)
	{
		var nodo=$("#facturacion"+idFacturacion)[0];
		nodo.parentNode.removeChild(nodo);
	}
}

function fnResiduo()
{
	this.ValidaFrmIn=function()
	{
		if(Validacion.Vacio('frm_residuo_nombre','Debe ingresar el nombre del residuo.'))
			return false;
		if(Validacion.Vacio('frm_residuo_nom052','Debe ingresar el identificador bajo la Nom-052 del residuo.'))
			return false;
		return true
	}
	this.Enviar=function(nuevo)
	{
		if(this.ValidaFrmIn())
		{
			var urlFrm=baseURL+"residuos/"+(nuevo===true?'add':'update');
			Mensaje("Guardando");
			var ajx=$.ajax({
				method:	"POST",
				url:	urlFrm,
				cache:	false,
				data:	$("#frm_residuos").serialize()
			});
			ajx.done(function(resp){
				if(resp!="" && !isNaN(parseInt(resp)))
					location.href=baseURL+"residuos/ver/"+resp;
				else
					Mensaje(resp);
			});
			ajx.fail(function(jqXHRObj,mensaje){
				$.msg('unblock',10,3);
				setTimeout(function(){
					Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500)
			});
		}
	}
	this.Eliminar=function(idEmpresa,idSucursal,id)
	{
		Confirm("¿Realmente desa eliminar este Residuo?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'residuos/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'residuos/index/'+idEmpresa+'/'+idSucursal;
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
			
		});
	}
}

function fnManifiesto()
{
	this.Buscar=function()
	{
		$("#frm_prefer").submit();
	}
	this.MostrarMenuCreacion=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/menucrear",
			cache:	false
		});
		ajx.done(function(resp){
			Mensaje(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al cargar el menu: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.CerrarMenuCreacion=function()
	{
		$.msg('unblock',10,3);
	}
	this.CrearManifiestoCteGen=function()
	{
		location.href=baseURL+"manifiestos/crearclientegenerador/"+$("#frm_prefer_empresa").val()+"/"+$("#frm_prefer_sucursal").val();
	}
	this.CrearManifiestoRutaBruto=function()
	{
		location.href=baseURL+"manifiestos/crearrutabruto/"+$("#frm_prefer_empresa").val()+"/"+$("#frm_prefer_sucursal").val();
	}
	this.CrearManifiestoRutaCalendario=function()
	{
		location.href=baseURL+"manifiestos/crearrutacalendario/"+$("#frm_prefer_empresa").val()+"/"+$("#frm_prefer_sucursal").val();
	}
	this.CrearManifiestoCalendario=function()
	{
		location.href=baseURL+"manifiestos/crearcalendario/"+$("#frm_prefer_empresa").val()+"/"+$("#frm_prefer_sucursal").val();
	}
	this.ValidaCreacionCteGen=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/validacreacionctegen/"+$("#frm_nuevo_empresa").val()+"/"+$("#frm_nuevo_sucursal").val(),
			cache:	false,
			data:	{
						cliente:	$("#frm_nuevo_cliente").val(),
						generador:	$("#frm_nuevo_generador").val(),
						ruta:		$("#frm_nuevo_ruta").val()
		            }
		});
		ajx.done(function(resp){
			$("#prevalidacion").html(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al generar datos de validación: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.ValidaCreacionRutaBruto=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/validacreacionrutabruto/"+$("#frm_nuevo_empresa").val()+"/"+$("#frm_nuevo_sucursal").val(),
			cache:	false,
			data:{
				ruta:		$("#frm_nuevo_ruta").val(),
				bitacora:	$("#frm_nuevo_bitacora").val()
			}
		});
		ajx.done(function(resp){
			$("#prevalidacion").html(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al generar datos de validación: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.ValidaCreacionRutaCalendario=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/validacreacionrutacalendario/"+$("#frm_nuevo_empresa").val()+"/"+$("#frm_nuevo_sucursal").val(),
			cache:	false,
			data:{
				ruta:		$("#frm_nuevo_ruta").val(),
				bitacora:	$("#frm_nuevo_bitacora").val(),
				fecha:		$("#frm_nuevo_fecha").val()
			}
		});
		ajx.done(function(resp){
			$("#prevalidacion").html(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al generar datos de validación: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.ValidaCreacionCalendario=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/validacreacioncalendario/"+$("#frm_nuevo_empresa").val()+"/"+$("#frm_nuevo_sucursal").val(),
			cache:	false,
			data:{
				bitacora:	$("#frm_nuevo_bitacora").val(),
				fecha:		$("#frm_nuevo_fecha").val()
			}
		});
		ajx.done(function(resp){
			$("#prevalidacion").html(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al generar datos de validación: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.CrearManifiestoCteGen_Exec=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/nuevomanifiesto",
			cache:	false,
			data:	{
				generador:$("#frm_validacion_idgenerador").val(),
				ruta:$("#frm_validacion_idruta").val(),
				identificador:$("#frm_validacion_identificador").val()
			}
		});
		ajx.done(function(resp){
			if(!isNaN(resp) && parseInt(resp)>0)
			{
				open(baseURL+"manifiestos/vistapreimpresion/"+resp+"/true");
				location.href=baseURL+"manifiestos/ver/"+resp;
			}
			else
				Mensaje(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al generar manifiesto: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.CrearManifiestoRutaBruto_Exec=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/nuevosmanifiestos",
			cache:	false,
			data:	$("#frm_validacion").serialize()
		});
		ajx.done(function(resp){
			if(!isNaN(resp) && parseInt(resp)>0)
			{
				location.href=baseURL+"bitacoras/ver/"+resp;
			}
			else
				Mensaje(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al generar manifiestos: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.Imprimir=function(idmanifiesto)
	{
		open(baseURL+'manifiestos/vistapreimpresion/'+idmanifiesto+'/true');
	}
	this.Eliminar=function(idEmpresa,idSucursal,id)
	{
		Confirm("¿Realmente desa eliminar este Manifiesto?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'manifiesto/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'manifiestos/index/'+idEmpresa+'/'+idSucursal;
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
			
		});
	}
	this.FrmCapturaKilos=function(idmanifiesto)
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/formulariocapturakilos/"+idmanifiesto,
			cache:	false
		});
		ajx.done(function(resp){
			Confirm(resp,function(){
				Manifiesto.CapturaKilos();
			});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al cargar residuos: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.CapturaKilos=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/capturakilos/"+idManifiesto,
			cache:	false,
			data:	$("#frm_captura_kilos").serialize()
		});
		ajx.done(function(resp){
			if(resp.trim()=="")
				location.href=baseURL+"manifiestos/ver/"+idManifiesto;
			else
				Mensaje(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al almacenar captura de residuos: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.GetManifiestoPrecaptura=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/getForPrecaptura/"+$("#frm_manifiesto_identificador").val(),
			cache:	false
		});
		ajx.done(function(resp){
			var datos=JSON.parse(resp);
			if(datos.length==1)
				Alert(datos[0],function(){
					$("#frm_manifiesto_identificador").focus();
				});
			else
			{
				$("#frm_manifiesto_generador_static").html(datos[0]);
				$("#frm_manifiesto_generador_nombre_static").html(datos[1]);
				$("#frm_manifiesto_cliente_static").html(datos[2]);
				$("#frm_manifiesto_cliente_nombre_static").html(datos[3]);
				$("#frm_manifiesto_generador")[0].value=datos[0];
				$("#frm_manifiesto_cliente")[0].value=datos[2];
				$("#frm_manifiesto_generador_static").html(datos[5]);
				$("#frm_manifiesto_cliente_static").html(datos[6]);
				$("#frm_manifiesto_idmanifiesto")[0].value=datos[7];
				$("#frmCapturaContainer").html(datos[4]);
				$("#frm_manifiesto_identificador")[0].readonly=true;
				$("#frmConfirmButtons").show();
			}
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al cargar residuos: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.LimpiaFormPrecaptura=function()
	{
		$("#frm_manifiesto_identificador")[0].value="";
		$("#frm_manifiesto_generador_static").html("");
		$("#frm_manifiesto_generador_nombre_static").html("");
		$("#frm_manifiesto_cliente_static").html("");
		$("#frm_manifiesto_cliente_nombre_static").html("");
		$("#frm_manifiesto_generador")[0].value=0;
		$("#frm_manifiesto_cliente")[0].value=0;
		$("#frmCapturaContainer").html("");
		$("#frmConfirmButtons").hide();
		$("#frm_manifiesto_identificador")[0].readonly=false;
		$("#frm_manifiesto_identificador").focus();
	}
	this.EjecutaPrecaptura=function()
	{
		Mensaje("Guardando");
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/capturakilos/"+$("#frm_manifiesto_idmanifiesto").val(),
			cache:	false,
			data:	$("#frm_captura_kilos").serialize()
		});
		ajx.done(function(resp){
			$.msg('unblock',10,3);
			setTimeout(function(){
				if(resp.trim()=="")
					Manifiesto.LimpiaFormPrecaptura();
				else
					Alert(resp,function(){return true;});
			},500);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al almacenar captura de residuos: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
	this.FrmReporte=function()
	{
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+"manifiestos/menucrearreporte",
			cache:	false
		});
		ajx.done(function(resp){
			Mensaje(resp);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			Mensaje("Error al cargar el menu: "+mensaje+"<br />"+jqXHRObj.responseText);
		});
	}
}

function fnCatalogos()
{
	this.MuestraFrmNuevo=function()
	{
		var ajx=$.ajax({
			method:	'POST',
			url:	baseURL+"catalogos/catalogofrm",
			cache:	false
		});
		ajx.done(function(resp){
			Confirm(resp,function(){
				location.href=baseURL+"catalogos/nuevo/"+$('#catalogo_name').val();
			});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al cargar formulario de entrada de datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.MuestraFrmOpcs=function()
	{
		var ajx=$.ajax({
			method:	'POST',
			url:	baseURL+"catalogos/opcionesfrm/"+$("#idcatalogo").val(),
			cache:	false
		});
		ajx.done(function(resp){
			Confirm(resp,function(){
				$("#opcionescatalogo").submit();
			});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al cargar formulario de entrada de datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.MuestraFrmUpd=function()
	{
		var ajx=$.ajax({
			method:	'POST',
			url:	baseURL+"catalogos/catalogofrm/"+$("#idcatalogo").val(),
			cache:	false
		});
		ajx.done(function(resp){
			Confirm(resp,function(){
				location.href=baseURL+"catalogos/actualiza/"+$("#idcatalogo").val()+"/"+$('#catalogo_name').val();
			});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al cargar formulario de entrada de datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.BorrarOpciones=function()
	{
		Confirm(
			"¿Realmente desea eliminar las opciones del catalogo seleccionadas?",
			function(){
				var arrOpcs=new Array();
				$('#tablaOpciones input').each(function(idx){
					if(this.checked) 
						arrOpcs.push(this.value);
				});
				var ajx=$.ajax({
					method:	'POST',
					url:	baseURL+"catalogos/borraropciones/"+$("#idcatalogo").val(),
					cache:	false,
					data:	{opciones:arrOpcs.join(',')}
				});
				ajx.done(function(resp){
					location.href=baseURL+"catalogos/ver/"+$("#idcatalogo").val()+"/"+$('#catalogo_name').val();
				});
				ajx.fail(function(jqXHRObj,mensaje){
					setTimeout(function(){
						Mensaje("Error al ejecutar borrado de opciones: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500)
				});
			}
		);
	}
}

var auxiliarFnPermiso=null;
function fnPermiso()
{
	this.CapturarNuevosElementos=function()
	{
		auxiliarFnPermiso=new Array();
		$('#elementosMenu input').each(function(idx){
			if(this.checked)
			{ 
				auxiliarFnPermiso.push(this.value);
				this.checked=false;
			}
		});
		if(auxiliarFnPermiso.length>0)
			this.MuestraFrmElementos(auxiliarFnPermiso.shift());
		else
			Alert("Debe seleccionar un elemento para anidar los permisos",function(){return true;});
	}
	this.MuestraFrmElementos=function(idPermiso)
	{
		var ajx=$.ajax({
			method:	'POST',
			url:	baseURL+"permisos/elementosfrm/"+idPermiso,
			cache:	false
		});
		ajx.done(function(resp){
			Confirm(resp,function(){
				Permiso.SalvarElementos();
			});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al cargar formulario de entrada de datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.SalvarElementos=function()
	{
		var ajx=$.ajax({
			method:	'POST',
			url:	baseURL+"permisos/salvarelementos/"+$("#idpermiso").val(),
			cache:	false,
			data:	{
				elemento1:$("#elemento1").val(),
				elemento2:$("#elemento2").val(),
				elemento3:$("#elemento3").val(),
				elemento4:$("#elemento4").val(),
				elemento5:$("#elemento5").val(),
				descripcion1:$("#descripcion1").val(),
				descripcion2:$("#descripcion2").val(),
				descripcion3:$("#descripcion3").val(),
				descripcion4:$("#descripcion4").val(),
				descripcion5:$("#descripcion5").val()
			}
		});
		ajx.done(function(resp){
			if(auxiliarFnPermiso.length>0)
				setTimeout(function(){
					Permiso.MuestraFrmElementos(auxiliarFnPermiso.shift());
				},500);
			else
				location.reload();
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al almacenar datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.ActualizarElementos=function()
	{
		auxiliarFnPermiso=new Array();
		$('#elementosMenu input').each(function(idx){
			if(this.checked)
			{ 
				auxiliarFnPermiso.push(this.value);
				this.checked=false;
			}
		});
		if(auxiliarFnPermiso.length>0)
			this.MuestraFrmUpdElemento(auxiliarFnPermiso.shift());
		else
			Alert("Debe seleccionar un elemento para actualizar",function(){return true;});
	}
	this.MuestraFrmUpdElemento=function(idPermiso)
	{
		var ajx=$.ajax({
			method:	'POST',
			url:	baseURL+"permisos/elementosfrmupd/"+idPermiso,
			cache:	false
		});
		ajx.done(function(resp){
			Confirm(resp,function(){
				Permiso.SalvarElementoUpd();
			});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al cargar formulario de entrada de datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.SalvarElementoUpd=function()
	{
		var ajx=$.ajax({
			method:	'POST',
			url:	baseURL+"permisos/salvarelementosupd/"+$("#idpermiso").val(),
			cache:	false,
			data:	{
				elemento:$("#elemento").val(),
				descripcion:$("#descripcion").val()
			}
		});
		ajx.done(function(resp){
			if(auxiliarFnPermiso.length>0)
				setTimeout(function(){
					Permiso.MuestraFrmUpdElemento(auxiliarFnPermiso.shift());
				},500);
			else
				location.reload();
		});
		ajx.fail(function(jqXHRObj,mensaje){
			setTimeout(function(){
				Mensaje("Error al almacenar datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500)
		});
	}
	this.EliminarConfirm=function()
	{
		auxiliarFnPermiso=new Array();
		$('#elementosMenu input').each(function(idx){
			if(this.checked)
			{ 
				auxiliarFnPermiso.push(this.value);
				this.checked=false;
			}
		});
		if(auxiliarFnPermiso.length>0)
			Confirm("¿Realmente desea eliminar los permisos seleccionados? Al hacerlo, los permisos hijo tambien serán eliminados.",function(){
				Permiso.Eliminar();
			});
		else
			Alert("Debe seleccionar un permiso para eliminar",function(){return true;});
	}
	this.Eliminar=function()
	{
		if(auxiliarFnPermiso.length>0)
		{
			var ajx=$.ajax({
				method:	'POST',
				url:	baseURL+"permisos/eliminar",
				cache:	false,
				data:	{permisos:auxiliarFnPermiso.join(",")}
			});
			ajx.done(function(resp){
				location.reload();
			});
			ajx.fail(function(jqXHRObj,mensaje){
				setTimeout(function(){
					Mensaje("Error al eliminar datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500)
			});
		}
	}
}

function fnPerfil()
{
	this.ValidaFrmIn=function()
	{
		if(Validacion.Vacio('frm_perfil_nombre','Debe ingresar un nombre para el perfil.'))
			return false;
		return true
	}
	this.Enviar=function(nuevo)
	{
		if(this.ValidaFrmIn())
		{
			var urlFrm=baseURL+"perfiles/"+(nuevo===true?'add':'update');
			Mensaje("Guardando");
			var ajx=$.ajax({
				method:	"POST",
				url:	urlFrm,
				cache:	false,
				data:	$("#frm_perfiles").serialize()
			});
			ajx.done(function(resp){
				if(resp!="" && !isNaN(parseInt(resp)))
					location.href=baseURL+"perfiles/ver/"+resp;
				else
					Mensaje(resp);
			});
			ajx.fail(function(jqXHRObj,mensaje){
				$.msg('unblock',10,3);
				setTimeout(function(){
					Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500)
			});
		}
	}
	this.Eliminar=function(id)
	{
		Confirm("¿Realmente desa eliminar este Perfil?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'perfiles/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'perfiles';
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
		});
	}
}

function fnUsuario()
{
	this.ValidaFrmIn=function()
	{
		if(Validacion.Vacio('frm_usuario_nombre','Debe ingresar el nombre del usuario.'))
			return false;
		if(Validacion.Vacio('frm_usuario_usuario','Debe ingresar el usuario.'))
			return false;
		if(Validacion.Vacio('frm_usuario_email','Debre ingresar el correo electrónico del usuario'))
			return false;
		return true;
	}
	this.Enviar=function(nuevo)
	{
		if(this.ValidaFrmIn())
		{
			var urlFrm=baseURL+"usuarios/"+(nuevo===true?'add':'update');
			Mensaje("Guardando");
			var ajx=$.ajax({
				method:	"POST",
				url:	urlFrm,
				cache:	false,
				data:	$("#frm_usuarios").serialize()
			});
			ajx.done(function(resp){
				if(resp!="" && !isNaN(parseInt(resp)))
					location.href=baseURL+"usuarios/ver/"+resp;
				else
					Mensaje(resp);
			});
			ajx.fail(function(jqXHRObj,mensaje){
				$.msg('unblock',10,3);
				setTimeout(function(){
					Mensaje("Error al guardar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
				},500)
			});
		}
	}
	this.Eliminar=function(id)
	{
		Confirm("¿Realmente desa eliminar este Vehículo?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'usuarios/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'usuarios/index';
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
		});
	}
	this.GetAcceso=function()
	{
		var dataVars={
			usr:$("#usr").val(),
			pwd:$("#pwd").val()
		};
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+'sesiones/login',
			data:	dataVars,
			cache:	false
		});
		ajx.done(function(resp){
			if(resp.trim()=="")
				location.href=baseURL+'inicio/principal';
			else
				Alert(resp,function(){return true});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			$.msg('unblock',10,3);
			setTimeout(function(){
				Alert("Error al accesar: "+mensaje+"<br />"+jqXHRObj.responseText,function(){return true;});
			},500);
		});
	}
	this.GetData=function()
	{
		var dataVars={
			usr:$("#usr").val()
		};
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+'sesiones/obtenercontrasena',
			data:	dataVars,
			cache:	false
		});
		ajx.done(function(resp){
			Alert(resp,function(){return true});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			$.msg('unblock',10,3);
			setTimeout(function(){
				Alert("Error al accesar: "+mensaje+"<br />"+jqXHRObj.responseText,function(){return true;});
			},500);
		});
	}
	this.ResetearPwr=function()
	{
		if(Validacion.Vacio('frm_data_usr','Debe ingresar el usuario')) 
			return false;
		var dataVars={
			usr:$("#frm_data_usr").val()
		};
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+'reseteopassword/resetear',
			data:	dataVars,
			cache:	false
		});
		ajx.done(function(resp){
			Alert(resp,function(){return true});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			$.msg('unblock',10,3);
			setTimeout(function(){
				Alert("Error al establecer contraseña: "+mensaje+"<br />"+jqXHRObj.responseText,function(){return true;});
			},500);
		});
	}
	this.CambiarPwd=function()
	{
		if(Validacion.Vacio('frm_data_actual','Debe ingresar su contraseña de acceso al sistema actual.'))
			return false;
		if(Validacion.Vacio('frm_data_nueva','Debe ingresar su nueva contraseña para accesar al sistema.'))
			return false;
		if(Validacion.Vacio('frm_data_confirmacion','Debe ingresar la confirmación de la nueva contraseña para accesar al sistema'))
			return false;
		var dataVars={
			actual	: $("#frm_data_actual").val(),
			nueva	: $("#frm_data_nueva").val(),
			confirm	: $("#frm_data_confirmacion").val()
		};
		if(dataVars.nueva!=dataVars.confirm)
		{
			Alert("La contraseña nueva y la confirmación deben ser iguales",function(){
				$("#frm_data_confirmacion").focus();
			});
		}
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+'cambiopassword/cambiar',
			data:	dataVars,
			cache:	false
		});
		ajx.done(function(resp){
			Alert(resp,function(){return true});
		});
		ajx.fail(function(jqXHRObj,mensaje){
			$.msg('unblock',10,3);
			setTimeout(function(){
				Alert("Error al establecer contraseña: "+mensaje+"<br />"+jqXHRObj.responseText,function(){return true;});
			},500);
		});
	}
}

function fnCalendario()
{
	this.fechaInicial=new Date();
	this.fechaFinal=new Date();
	this.fechas=new Array();
	this.GeneraFechas=function()
	{
		this.fechaInicial	= new Date(	$("#inicio").val().substring(0,4),	($("#inicio").val().substring(5,7))-1,	$("#inicio").val().substring(8,10));
		this.fechaFinal		= new Date(	$("#fin").val().substring(0,4),		($("#fin").val().substring(5,7))-1,		$("#fin").val().substring(8,10));
		this.fechas			= new Array();
		this.LimpiaFechas();
		switch(parseInt($("#frecuencia").val()))
		{
			case 74:	// Frecuencia diaria
				this.GeneraCalendarioSimple(this.GetDias(0));
				break;
			case 75:	// Frecuencia dos veces por semana
				this.GeneraCalendarioSimple(this.GetDias(2));
				break;
			case 76:	// Frecuencia tres veces por semana
				this.GeneraCalendarioSimple(this.GetDias(3));
				break;
			case 77:	// Frecuencia semanal
				this.GeneraCalendarioSimple(this.GetDias(1));
				break;
			case 78:	// Frecuencia quincenal
				this.GeneraCalendarioQuincenal();
				break;
			case 79:	// Frecuencia mensual
				this.GeneraCalendario1VezPorMesGlobal(1);
				break;
			case 80:	// Frecuencia bimestral
				this.GeneraCalendario1VezPorMesGlobal(2);
				break;
			case 81:	// Frecuencia trimestral
				this.GeneraCalendario1VezPorMesGlobal(3);
				break;
			case 82:	// Frecuencia semestral
				this.GeneraCalendario1VezPorMesGlobal(6);
				break;
		}
		for(var x in this.fechas) if(!isNaN(x))
			this.AgregaCalendario(this.fechas[x]);
		if(this.fechas.length>0)
			$("#fechascalendario_space").show();
	}
	this.GetDias=function(maximo)
	{
		var dias=new Array(
			$("#domingo")[0].checked,
			$("#lunes")[0].checked,
			$("#martes")[0].checked,
			$("#miercoles")[0].checked,
			$("#jueves")[0].checked,
			$("#viernes")[0].checked,
			$("#sabado")[0].checked
		);
		var cont=0;
		for(var x in dias) if(!isNaN(x))
		{
			if(dias[x]==true)
				cont++;
		}
		if(maximo==0||maximo==cont)
			return dias;
		else
			Alert("Debe seleccionar "+maximo+" día(s) para recoleccion",function(){return true;});
		return new Array(false,false,false,false,false,false,false);
	}
	this.GetSemanas=function(maximo)
	{
		var semanas=new Array(
			$("#semana1")[0].checked,
			$("#semana2")[0].checked,
			$("#semana3")[0].checked,
			$("#semana4")[0].checked
		);
		var cont=0;
		for(var x in semanas) if(!isNaN(x))
		{
			if(semanas[x]==true)
				cont++;
		}
		if(maximo==0||maximo==cont)
			return semanas;
		else
			Alert("Debe seleccionar "+maximo+" semana(s) para recoleccion",function(){return true;});
		return new Array(false,false,false,false);
	}
	this.GeneraCalendarioSimple=function(dias)
	{
		var fechaActual=this.fechaInicial;
		while(fechaActual.getTime()<(this.fechaFinal.getTime()+(1*24*60*60*1000)))
		{
			if(dias[fechaActual.getDay()])
				this.fechas.push(new Date(fechaActual.getTime()));
			fechaActual.agregaDias(1);
		}
	}
	this.GeneraCalendario1VezPorMes=function(dias,semanas,cadaXMeses)
	{
		// Cambia la lógica de la semana, en lugar de ser la primer semana es el primer día X (L,M,W,J,V,S,D) del mes, y repite cada cadaXMeses
		var fechaActual=this.fechaInicial;
		var contDiaSemana=fechaActual.getSemanaEnMes();
		var mesActual=fechaActual.getMonth();
		while(fechaActual.getTime()<(this.fechaFinal.getTime()+(1*24*60*60*1000)))
		{
			var agregado=false;
			if(dias[fechaActual.getDay()])
			{
				if(mesActual!=fechaActual.getMonth())
				{
					mesActual=fechaActual.getMonth();
					contDiaSemana=0;
				}
				if(contDiaSemana!=this.fechaInicial.getSemanaEnMes())
					contDiaSemana++;
				if(semanas[contDiaSemana-1])
				{
					this.fechas.push(new Date(fechaActual.getTime()));
					agregado=true;
				}
			}
			if(agregado)
				fechaActual=new Date((fechaActual.getMonth()<(12-cadaXMeses)?fechaActual.getFullYear():fechaActual.getFullYear()+1),(fechaActual.getMonth()<(12-cadaXMeses)?fechaActual.getMonth()+cadaXMeses:(fechaActual.getMonth()+cadaXMeses)%12),1)
			else
				fechaActual.agregaDias(1);
		}
	}
	this.GeneraCalendario1VezPorMesGlobal=function(cadaXMeses)
	{
		var dias=this.GetDias(1);
		if(!dias.igual([false,false,false,false,false,false,false]))
		{
			var semanas=this.GetSemanas(1);
			if(!semanas.igual([false,false,false,false]))
			{
				this.GeneraCalendario1VezPorMes(dias,semanas,cadaXMeses);
			}
		}
	}
	this.GeneraCalendarioQuincenal=function()
	{
		var dias=this.GetDias(1);
		if(!dias.igual([false,false,false,false,false,false,false]))
		{
			var semanas=this.GetSemanas(2);
			if(!semanas.igual([false,false,false,false]))
			{
				var fechaActual=this.fechaInicial;
				while(fechaActual.getTime()<(this.fechaFinal.getTime()+(1*24*60*60*1000)))
				{
					if(dias[fechaActual.getDay()])
					{
						var semanaActual=fechaActual.getSemanaEnMes();
						if(semanaActual>0 && semanas[semanaActual-1])
							this.fechas.push(new Date(fechaActual.getTime()));
					}
					fechaActual.agregaDias(1);
				}
			}
		}
	}
	this.GeneraCalendarioEventual=function()
	{
		var fecha= new Date($("#fechaeventual").val().substring(0,4),($("#fechaeventual").val().substring(5,7))-1,	$("#fechaeventual").val().substring(8,10));
		this.AgregaCalendario(fecha);
		$("#fechascalendario_space").show();
	}
	this.AgregaCalendario=function(fecha)
	{
		var tbl=$("#fechascalendario_tbl")[0];
		var fila=tbl.rows.length;
		tbl.insertRow(fila);
		tbl.rows[fila].insertCell(0);
		tbl.rows[fila].insertCell(1);
		tbl.rows[fila].cells[0].innerHTML=fecha.getDiaSemana()+" "+fecha.getDate()+" de "+fecha.getMes()+" de "+fecha.getFullYear();
		tbl.rows[fila].cells[1].innerHTML='<input type="checkbox" checked="checked" id="fechas[]" name="fechas[]" value="'+fecha.getFullYear()+'-'+(fecha.getMonth()<9?"0":"")+(fecha.getMonth()+1)+'-'+(fecha.getDate()<10?"0":"")+fecha.getDate()+'" />';
	}
	this.LimpiaFechas=function()
	{
		$("#fechascalendario_tbl").html("");
		$("#fechascalendario_space").hide();
	}
	this.GuardarFechas=function()
	{
		var fechas=$("#frm_fechas").serialize();
		Mensaje("Guardando Fechas");
		var ajx=$.ajax({
			method:	"POST",
			url:	baseURL+'generadores/cargacalendario/'+$("#idgenerador").val(),
			cache:	false,
			data:	fechas
		});
		ajx.done(function(resp){
			if(resp.trim()=="")
				location.href=baseURL+'generadores/ver/'+$("#idgenerador").val();
			else
				$.msg('unblock',10,3);
				setTimeout(function(){
					Alert()(resp,function(){return true;});
				},500);
		});
		ajx.fail(function(jqXHRObj,mensaje){
			$.msg('unblock',10,3);
			setTimeout(function(){
				Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500);
		});
	}
}

function fnBitacora()
{
	this.Eliminar=function(idEmpresa,idSucursal,id)
	{
		Confirm("¿Realmente desa eliminar esta Bitácora?",function(){
			$.msg('unblock',10,2);
			setTimeout(function(){
				Mensaje("Eliminando");
				var ajx=$.ajax({
					method:	"POST",
					url:	baseURL+'bitacoras/eliminar/'+id,
					cache:	false
				});
				ajx.done(function(resp){
					if(resp=="")
						location.href=baseURL+'bitacoras/index/'+idEmpresa+'/'+idSucursal;
					else
						Mensaje(resp);
				});
				ajx.fail(function(jqXHRObj,mensaje){
					$.msg('unblock',10,3);
					setTimeout(function(){
						Mensaje("Error al eliminar los datos: "+mensaje+"<br />"+jqXHRObj.responseText);
					},500);
				});
			},500);
		});
	}
}

function fnReporte()
{
	this.Ejecutar=function()
	{
		Mensaje("Generando Reporte");
		$("#bodyreport").html("");
		var ajx=$.ajax({
			method	: "POST",
			url		: baseURL+"reporte/ejecutar",
			cache	: false,
			data	: $("#frm_reporte").serialize()
		});
		ajx.done(function(resp){
			$.msg('unblock',10,3);
			$("#bodyreport").html(resp);
			$('#btnDescarga').removeClass('disabled');
			$('#btnDescarga').attr('disabled', '');
			$('#btnDescarga').prop('disabled', false);
			if($("#reporttable").length>0 && $("#reporttablebody")[0].rows.length>0)
			{
				$("#reporttable").DataTable();
			}
		});
		ajx.fail(function(jqXHRObj,mensaje){
			$.msg('unblock',10,3);
			setTimeout(function(){
				Mensaje("Error al generar reporte: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500);
		});
	}
	this.Descargar=function()
	{
		Mensaje("Generando Reporte");
		var ajx=$.ajax({
			method	: "POST",
			url		: baseURL+"reporte/exportar",
			cache	: false,
			data	: $("#frm_reporte").serialize()
		});
		ajx.done(function(resp){
			$.msg('unblock',10,3);
			if(resp.length>250)
				setTimeout(function(){Alert(resp,function(){return true;});},500);
			else
				location.href=resp;
		});
		ajx.fail(function(jqXHRObj,mensaje){
			$.msg('unblock',10,3);
			setTimeout(function(){
				Mensaje("Error al generar reporte: "+mensaje+"<br />"+jqXHRObj.responseText);
			},500);
		});
	}
}

var Empresa		= new fnEmpresa();
var Sucursal	= new fnSucursal();
var Operador	= new fnOperador();
var Vehiculo	= new fnVehiculo();
var Validacion	= new fnValidaciones();
var Ruta		= new fnRuta();
var Cliente		= new fnCliente();
var Generador	= new fnGenerador();
var Residuo		= new fnResiduo();
var Manifiesto	= new fnManifiesto();
var Catalogos	= new fnCatalogos();
var Permiso		= new fnPermiso();
var Perfil		= new fnPerfil();
var Usuario		= new fnUsuario();
var Calendario	= new fnCalendario();
var Bitacora	= new fnBitacora();
var Reporte		= new fnReporte();

$.extend(true, $.fn.dataTable.defaults, {
	"scrollY": 400,
	"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
	"language": {
	    "lengthMenu":	"Mostrar _MENU_ registros por página",
	    "zeroRecords":	"No se encontraron resultados",
	    "info":			"Página _PAGE_ de _PAGES_",
	    "infoEmpty":	"No hay resultados que mostrar",
	    "infoFiltered":	"(filtro de _MAX_ registros en total)",
	    "emptyTable":	"No hay resultados que mostrar",
	    "search":		"Buscar:",
	    "paginate": {
			"first":    "<span class=\"glyphicon glyphicon-fast-backward\"></span>",
			"previous": "<span class=\"glyphicon glyphicon-backward\"></span>",
			"next":     "<span class=\"glyphicon glyphicon-forward\"></span>",
			"last":     "<span class=\"glyphicon glyphicon-fast-forward\"></span>"
		},
		"decimal": ".",
        "thousands": ","
	},
	"searching": false,
	"pagingType": "full_numbers",
	"order": [[ 0, "asc" ]]
});