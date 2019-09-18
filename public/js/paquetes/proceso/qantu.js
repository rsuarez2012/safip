var divPInfoProv, divPHoteles, divPPasajeros, divCInfoProv, divCHoteles, divCPasajeros,divInfoPaquete, agencia = 0, ventad = 0;
var e_swb, e_dwb, e_tpl, e_chd, p_swb, p_dwb, p_tpl, p_chd,c_swb, c_dwb, c_tpl;
function verInfoProv() {
	divPInfoProv = $('#divInfoProv')[0];
	divPHoteles = $('#divHoteles')[0];
	divPPasajeros = $('#divPasajeros')[0];
	divCInfoProv = divPInfoProv.children[0];
	divCHoteles = divPHoteles.children[0];
	divCPasajeros = divPPasajeros.children[0];
	divInfoPaquete = $("#divInfoPaquete")[0];
	divPInfoProv.style.display = 'block';
	divCInfoProv.attributes[0].value = "box box-danger";
}

$(document).on('click', "#agencia", function (e){
	verInfoProv();
	agencia = 1;
	ventad = 0;
});

$(document).on('click', "#ventad", function (e){
	verInfoProv();
	agencia = 0;
	ventad = 1;
});

// FUNCION PARA BUSCAR PAQUETE Y CREAR LISTA DE HOTELES
$(document).on('click', '#buscar-paquete', function (e){
	let codigo = $("input[name='codigo_paquete']").val();
	if (codigo != "") {
		// ENVIO CODIGO A BUSCRA 
		$.ajax({
			type     : "GET",
			url      : APP_URL+'/tablero/Paquetes/Qantu/Procesar/Cotizaciones/Buscar/Paquete/'+codigo,
			datatype : 'json',
			beforeSend: function (){
				$("#cargando").attr("hidden",false);
			},
			success:  function (response) {
				$("#cargando").attr("hidden",true);
				// LIMPIO LA TABLA 
				$("#tabla-enlazados thead").remove();
				$("#tabla-enlazados tr").remove();
				// SI ENCUENTRA ALGO LO MUESTRE Y BUSQUE SUS HOTELES	
				if (response.mensaje) {
					//console.log(response);
					divHoteles.style.display = 'block';
					divCHoteles.attributes[0].value = "box box-danger";
					divPPasajeros.style.display = 'none';
					divCPasajeros.attributes[0].value = "box collapsed-box box-danger";
					$("input[name='nombre_paquete']").val(response.mensaje.nombre);
					$("#buscar-paquete").val(response.mensaje.id);
					$("input[name='codigo_paquete']").val("");
					// CABEREA DE LA TABLA
					// name="+response.listados.codigo+"
					let cabecera = "<thead  style='background-color:#f56954;color:#fff;'>"+
					"<tr><th>Check</th>";
					$.each(response.mensaje.listados, function( llave, valor ) {
						cabecera += "<th>" + valor.destino.nombre + "</th>";
					});
					cabecera +="<th>E_SWB</th>"+
					"<th>E_DWB</th>"+
					"<th>E_TPL</th>"+
					"<th>E_CHD</th>"+
					"<th>P_SWB</th>"+
					"<th>P_DWB</th>"+
					"<th>P_TPL</th>"+
					"<th>P_CHD</th>"+
					"<th>C_SWB</th>"+
					"<th>C_DWB</th>"+
					"<th>C_TPL</th>"+
					"<th>C_CHD</th>"+
					"</tr></thead>";
					// CREO BODY DE TABLA
					let datos_tabla;
					$.each(response.datos, function( llave, valor ) {
						datos_tabla += "<tr name="+llave+">"+
						"<td><input type='radio' name='tarifa_hotel' onclick=mostrarPasajeros('"+llave+"')></td>";
						$.each(valor.hoteles, function( llave, valor ) {
							datos_tabla += "<td class='lista_nombre_hoteles'>"+valor+"</td>";
						});
						datos_tabla += "<td id='"+llave+"'>"+Math.round(valor.e_swb *100)/100+"</td>"+
						"<td>"+Math.round(valor.e_dwb *100)/100+"</td>"+
						"<td>"+Math.round(valor.e_tpl *100)/100+"</td>"+
						"<td>"+Math.round(valor.e_chd *100)/100+"</td>"+
						"<td>"+Math.round(valor.p_swb *100)/100+"</td>"+
						"<td>"+Math.round(valor.p_dwb *100)/100+"</td>"+
						"<td>"+Math.round(valor.p_tpl *100)/100+"</td>"+ 
						"<td>"+Math.round(valor.p_chd *100)/100+"</td>"+
						"<td>"+Math.round(valor.c_swb *100)/100+"</td>"+
						"<td>"+Math.round(valor.c_dwb *100)/100+"</td>"+
						"<td>"+Math.round(valor.c_tpl *100)/100+"</td>"+
						"<td>"+Math.round(valor.p_chd *100)/100+"</td>"+
						"</tr>";
					});
					// AGREGO LA CABECERA Y LOS DATOS A LA TABLA   
					$("#tabla-enlazados").append(cabecera);
					$("#tabla-enlazados").append(datos_tabla);
				}	
				else{
					divPHoteles.style.display = 'none';
					divPPasajeros.style.display = 'none';
					// SINO ENCUENTRA NADA ELIMINA HOTELES 
					$("input[name='nombre_paquete']").val("");
					$("#div-alerta").html("<i class='fa fa-question-circle'></i> No se encuentra un paquete con ese codigo").fadeIn(300).delay(600).fadeOut(300);
				}
			},
			error: function(jqXHR){
				console.log(jqXHR);
				$("#cargando").attr("hidden",true);
				$("#div-alerta").html(jqXHR.status).fadeIn(300).delay(600).fadeOut(300);
			}
		});		
	}else{
		$("#div-alerta").html("<i class='fa fa-warning'></i> El Campo Codigo No Puede Estar Vacio").fadeIn(300).delay(600).fadeOut(300);
	}
});
//paquete a probar -> R6B172QM
function mostrarPasajeros(llave){
	var td_e_swb = $('#'+llave)[0]; //[0].innerText
	e_swb = td_e_swb.innerText;
	e_dwb = td_e_swb.nextSibling.innerText;
	e_tpl = td_e_swb.nextSibling.nextSibling.innerText;
	e_chd = td_e_swb.nextSibling.nextSibling.nextSibling.innerText;
	p_swb = td_e_swb.nextSibling.nextSibling.nextSibling.nextSibling.innerText;
	p_dwb = td_e_swb.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerText;
	p_tpl = td_e_swb.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerText;
	p_chd = td_e_swb.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerText;
	c_swb = td_e_swb.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerText;
	c_dwb = td_e_swb.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerText;
	c_tpl = td_e_swb.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerText;
	divPPasajeros.style.display = 'block';
	divInfoPaquete.style.display = 'block';
	divCPasajeros.attributes[0].value = "box box-danger";
}
// FUNCION PARA CREAR HABITACIONES
$(document).on('click', '#agregar-habitaciones', function (e){
	let cantidad = $("input[name='cantidad_habitaciones']").val();
	let tipo     = $("select[name='tipo_habitacion']").val();
	let faltan   = $("input[name='pasajeros_faltantes']").val();
	let input;
	
	if (cantidad > 0) {
		if (tipo == 1) {
			input="<input type='text' readonly class='form-control' value='Simple'>";
		}else if(tipo == 2){
			input="<input type='text' readonly class='form-control' value='Doble'>";
		}else{
			input="<input type='text' readonly class='form-control' value='Triple'>";
		}
		// CREA ROW DE HABITACIONES
		let id = Math.round(Math.random() * (9999999 - 1));
		$("#zona_habitaciones").append(""+
			"<div class='row fila-cliente' id='"+id+"' style='margin-bottom:10px;'>"+
			"<div class='col-sm-3'>"+
			"<label><i class='fa fa-user'></i> Pasajero</label>"+
			"<button class='btn btn-danger btn-block abrirPasajeros'>Seleccionar Pasajero</button>"+
			"</div>"+
			"<div class='col-sm-2'>"+
			"<label><i class='fa fa-list-alt'></i> Tipo</label>"+
			"<select class='form-control'>"+
			"<option value='adulto'>Adulto</option>"+
			"<option value='ninio'>Niño</option>"+
			"</select>"+
			"</div>"+
			"<div class='col-sm-3'>"+
			"<label><i class='fa fa-list-alt'></i> Nacionalidad</label>"+
			"<select class='form-control'>"+
			"<option value='peruano'>Peruano</option>"+
			"<option value='comunidad'>Comunidad</option>"+
			"<option value='extranjero'>Extranjero</option>"+
			"</select>"+
			"</div>"+
			"<div class='col-sm-2'>"+
			"<label><i class='fa fa-list-alt'></i> Habitacion</label>"+
			input+
			"</div>"+
			"<div class='col-sm-2 text-center'>"+
			"<label style='display: block;'>Acciones</label>"+
			"<button name='procesar' disabled='true' title='Procesar' class='procesar-cotizacion btn btn-danger btn-xs'><i class='fa fa-cog'></i></button> "+
			" <button name='eliminar' title='Eliminar' class='btn btn-danger btn-xs'><i class='fa fa-close'></i></button>"+
			"</div>"+
			"</div>");
		// RESTO UNA HABITACION 
		$("input[name='cantidad_habitaciones']").val(cantidad-1);
	}else{
		$("#div-alerta").html("<i class='fa fa-close'></i> No Puede Añadir Mas Habitaciones").fadeIn(300).delay(600).fadeOut(300);
	}
});
// ABRIR MODAL PASAJEROS
$(document).on('click', '.abrirPasajeros', function (e){
	// LE PASO EL ID DE LA FILA AL BOTON 
	let div = $(this).parents("div .row");
	$("#asginar-pasajero").val($(div).attr("id"));
	$("#modalPasajeros").fadeIn(300);
});
// CERRAR MODAL DE PASAJEROS
$(document).on('click', '.cerrarPasajeros', function (e){
	$("#modalPasajeros").fadeOut(300);
});
// ABRIR MODAL PASAJEROS
$(document).on('click', '.abrirNuevoPasajero', function (e){
	$("#modalNuevoPasajero").fadeIn(300);
});
// CERRAR MODAL DE PASAJEROS
$(document).on('click', '.cerrarNuevoPasajero', function (e){
	$("#modalNuevoPasajero").fadeOut(300);
});
// GUARDAR NUEVO PASAJERO
$(document).on('click', '#guardar-pasajero', function (e){
	// BUSCO LOS INPUT REQUERIDOS Y VALIDO QUE ESTEN LLENOS
	inputs = $(".input_nuevo").toArray();
	let vacio=0;
	$.each(inputs , function( llave, valor ) {
		if (valor.value == "") {
			vacio++;
		}
	});
	// SI TODOS ESTAN LLENOS LOS GUARDO
	if (vacio == 0) {
		let form = $("#form-nuevo-cliente").serialize();
		$.ajax({
			type     : "POST",
			url      : APP_URL+'/tablero/Paquetes/Qantu/Procesar/Cotizaciones/Agregar/Pasajero',
			data     : form,
			datatype : 'json',
			beforeSend: function (){
				$("#cargandoPasajero").attr("hidden",false);
				$("#modalNuevoPasajero").fadeOut(300);
			},
			// AGREGO REGISTRO A FILA
			success:  function (response) {
				let limpiar = $("#form-nuevo-cliente").children('div').toArray();
				$.each(limpiar, function( llave, valor ) {
					console.log($(valor).children("div").children("input").val(""));
				});
				$("#cargandoPasajero").attr("hidden",true);
				$("#pasajeros tbody tr:first").before(
					"<tr>"+
					"<td><input type='radio' name='pasajero' value='"+response.mensaje.id+"'></td>"+
					"<td>Qantu Travel</td>"+
					"<td>"+response.mensaje.cedula_rif+"</td>"+
					"<td>"+response.mensaje.nombre+"</td>"+
					"<td>"+response.mensaje.apellido+"</td>"+
					"<td>"+response.mensaje.tipo_pasajero+"</td>"+
					"</tr>"
					);
				$("#div-alerta").html("<i class='fa fa-check'></i> Pasajero " + response.mensaje.nombre + " Se Creo Correctamente").fadeIn(300).delay(600).fadeOut(300);
				
			},
			error: function(jqXHR){
				$("#cargandoPasajero").attr("hidden",true);
				$("#div-alerta").html(jqXHR.status).fadeIn(300).delay(600).fadeOut(300);
			}
		});		
	}else{
		// SI ALGUNO ETSA VACIO LO INDICO
		$("#div-alerta").html("<i class='fa fa-close'></i> Debe LLenar Todos Los Campos Requeridos").fadeIn(300).delay(600).fadeOut(300);
	}
});
// ASIGNAR PASAJERO A HABITACION
$(document).on('click', '#asginar-pasajero', function (e){
	// BUSCO SI HAY ALGUN RADIO SELECCIONADO
	let seleccionado = $("input[name='pasajero']:checked");
	// SI NO HAY NINGUNO LO AVISO
	if ($(seleccionado).val() == null) {
		$("#div-alerta").html("<i class='fa fa-close'></i> Debe Seleccionar Un Pasajero").fadeIn(300).delay(600).fadeOut(300);
	}else{
		// SINO ASIGNO MI PASAJERO
		let fila        = $(seleccionado).parents("tr").children("td").toArray();
		let nombre      = $(fila[3]).text() +" "+ $(fila[4]).text();
		let registro    = $("#"+this.value).children("div").toArray();
		let pasajero_id = $(seleccionado).val();
		$("#modalPasajeros").fadeOut(300);
		// ELIMINO BOTON Y AGREGO INPUT CON NOMBRE DE PASAJERO E ID
		$(registro[0]).children("button").remove();
		$(registro[0]).append("<input class='form-control' type='text' name='nombre' readonly value='"+nombre+"'>");
		$(registro[0]).append("<input type='hidden' name='pasajero_id' value='"+pasajero_id+"'>");
		// ACTIBO BOTON DE PROCESAR
		$(registro[2]).children(" button[name='procesarp']").attr("disabled",false);
		$(registro[4]).children("button[name='procesar']").attr("disabled",false);


		$(seleccionado).attr("checked",false);
	}
});
// MODAL DE COTIZACION P
$(document).on('click', ".procesar-cotizacion", function (e){
	let datos = $(this).parents("div .row").children("div").toArray();
	let hoteles = $("input[name='tarifa_hotel']:checked").parents("tr").children(".lista_nombre_hoteles").toArray();
	let nombre_hoteles = "";
	$.each(hoteles, function( llave, valor ) {
		nombre_hoteles += " / " + $(valor).text();
	});
	$("input[name='cliente_nombre']").val($(datos[0]).children("input[name='nombre']").val());
	$("input[name='cliente_id']").val($(datos[0]).children("input[name='pasajero_id']").val());
	$("input[name='cliente_hoteles']").val(nombre_hoteles);
	$("input[name='cliente_tipo']").val($(datos[1]).children("select").val());
	let tipo         = $(datos[1]).children("select").val();
	let nacionalidad = $(datos[2]).children("select").val();
	let habitacion   = $(datos[3]).children("input").val(); 
	$("input[name='cliente_nacionalidad']").val(nacionalidad);
	// BUSCO LAS TARIFAS EN BASE A LOS TIPOS
	if (habitacion == "Simple") {
		// SI ES SIMPLE ADULTO
		if (tipo == "adulto") {
			if (nacionalidad == "peruano") {
				$("input[name='cliente_neto']").val(Math.round(p_swb));
			}else if(nacionalidad == "comunidad"){
				$("input[name='cliente_neto']").val(Math.round(c_swb));
			}else if(nacionalidad == "extranjero"){
				$("input[name='cliente_neto']").val(Math.round(e_swb));
			}
		}
	}else if(habitacion == "Doble"){
		// SI ES ADULTO
		if (tipo == "adulto") {
			if (nacionalidad == "peruano") {
				$("input[name='cliente_neto']").val(Math.round(p_dwb));
			}else if(nacionalidad == "comunidad"){
				$("input[name='cliente_neto']").val(Math.round(c_dwb));
			}else if(nacionalidad == "extranjero"){
				$("input[name='cliente_neto']").val(Math.round(e_dwb));
			}
		}else if(tipo == "ninio"){
			if (nacionalidad == "peruano") {
				$("input[name='cliente_neto']").val(Math.round(p_chd));
			}else if(nacionalidad == "comunidad"){
				$("input[name='cliente_neto']").val(Math.round(p_chd));
			}else if(nacionalidad == "extranjero"){
				$("input[name='cliente_neto']").val(Math.round(e_chd));
			}
		}
	}else if(habitacion == "Triple"){
		// SI ES ADULTO
		if (tipo == "adulto") {
			if (nacionalidad == "peruano") {
				$("input[name='cliente_neto']").val(Math.round(p_tpl));
			}else if(nacionalidad == "comunidad"){
				$("input[name='cliente_neto']").val(Math.round(c_tpl));
			}else if(nacionalidad == "extranjero"){
				$("input[name='cliente_neto']").val(Math.round(e_tpl));
			}
		}else if(tipo == "ninio"){
			if (nacionalidad == "peruano") {
				$("input[name='cliente_neto']").val(Math.round(p_chd));
			}else if(nacionalidad == "comunidad"){
				$("input[name='cliente_neto']").val(Math.round(p_chd));
			}else if(nacionalidad == "extranjero"){
				$("input[name='cliente_neto']").val(Math.round(e_chd));
			}
		}
	}
	// CALCULO
	// LLENO LOS CAMPOS CON LOS CALCULOS
	let total = 0;
	let neto     = $("input[name='cliente_neto']").val();
	total += parseInt(neto);
	let comision = ((neto*12)/100);
	total += comision;
	$("input[name='cliente_comision']").val(Math.round(comision));
	let diez = ((total*10)/100);
	total += diez;
	$("input[name='cliente_diez']").val(Math.round(diez));
	let incentivo = 12;
	total += incentivo;
	$("input[name='cliente_incentivo']").val(Math.round(incentivo));
	$("input[name='cliente_total']").val(Math.round(total));
	$("input[name='cliente_pagar']").val(Math.round(total));
	// LE PASO EL I DE LA FILA AL BOTON
	$("#crear-boleto-vdirecta").val($(this).parents("div .row").attr("id"));
	$("#crear-boleto-agencia").val($(this).parents("div .row").attr("id"));
	// VERIFICO CUAL MODAL LEVANTAR
	let modal = $("input[name='tventa']:checked").val();
	if (modal == "agencia") {
		$("#agenciaModal").fadeIn(300);	
	}else{
		$("#vDirectaModal").fadeIn(300);
	}
	
});
// CERRAR MODAL DE COTIZACION P
$(document).on('click', '.cerrar-procesar-modal', function (e){
	$(".modalProcesar").fadeOut(300);
});
// CUANDO CAMBIE EL VALOR DEL TIPO DE VENTA CAMBIAS LOS CAMPOS
$(document).on('change', "input[name='tventa']", function (e){
	if(this.value == "agencia"){
		$(".varian").addClass("hidden",true);
	}else{
		$(".varian").removeClass("hidden",false);
	}
	$("#tabla-venta-paquete tbody").children("tr").remove();
	$("#zona_habitaciones").children(".row").remove();
	$("#zona_habitaciones").children("hr").remove();
	$("input[name='cantidad_habitaciones']").val($("input[name='input_cantidad_pasajeros']").val());
	$("input[name='total_a_pagar']").val(0);
});
// EVENTO TARIFA FEE
$(document).on('keyup', "input[name='cliente_tarifa']", function (e){
	let total = 0,fee = 0,utilidad =0;
	total = $("input[name='cliente_total']").val();
	fee   = $("input[name='cliente_tarifa']").val();
	utilidad = $("input[name='cliente_utilidad']").val();
	if (fee == null || fee == 0) {
		fee=0;
	}
	if (utilidad == null || utilidad == 0) {
		utilidad=0;
	}
	$("input[name='cliente_total_utilidad']").val((parseFloat(fee)+parseFloat(utilidad)));
	$("input[name='cliente_pagar']").val((parseFloat(fee)+parseFloat(total)+parseFloat(utilidad)));
});
// EVENTO UTILIDAD
$(document).on('keyup', "input[name='cliente_utilidad']", function (e){
	let total = 0,fee = 0,utilidad =0;
	total = $("input[name='cliente_total']").val();
	fee   = $("input[name='cliente_tarifa']").val();
	utilidad = $("input[name='cliente_utilidad']").val();
	if (fee == null || fee == 0) {
		fee=0;
	}
	if (utilidad == null || utilidad == 0) {
		utilidad=0;
	}
	$("input[name='cliente_total_utilidad']").val((parseFloat(fee)+parseFloat(utilidad)));
	$("input[name='cliente_pagar']").val((parseFloat(fee)+parseFloat(total)+parseFloat(utilidad)));
});

// CREAR BOLETO DE PAQUETE
$(document).on('click', "#crear-boleto-vdirecta", function (e){
	let id_fila = $("#crear-boleto-vdirecta").val();
	let datos = $(".input_vdirecta").toArray();
	if(datos[10].value == 0 || datos[10].value == null){
		$(datos[10]).val(0);
	}
	if(datos[11].value == 0 || datos[11].value == null){
		$(datos[11]).val(0);	
	}
	if(datos[12].value == 0 || datos[12].value == null){
		$(datos[12]).val(0);
	}
	$("#tabla-venta-paquete").append(
		"<tr value='"+id_fila+"'>"+
		"<td value='"+datos[14].value+"'>"+datos[0].value+"</td>"+
		"<td>"+datos[1].value+"</td>"+
		"<td>"+datos[2].value+"</td>"+
		"<td>"+datos[3].value+"</td>"+
		"<td>"+datos[4].value+"</td>"+
		"<td>"+datos[5].value+"</td>"+
		"<td>"+datos[6].value+"</td>"+
		"<td>"+datos[7].value+"</td>"+
		"<td>"+datos[8].value+"</td>"+
		"<td>"+datos[9].value+"</td>"+
		"<td>"+datos[10].value+"</td>"+
		"<td>"+datos[11].value+"</td>"+
		"<td>"+datos[12].value+"</td>"+
		"<td class='valores-a-pagar'>"+datos[13].value+"</td>"+
		"<td>"+
		"<button data-toggle='tooltip' title='Eliminar Boleto' class='btn-xs btn btn-danger eliminar-boleto'><i class='fa fa-close'></i></button>"+
		"</td>"+
		"</tr>"
		);
	let fila = $("#"+id_fila).children("div");
	$(fila[4]).children("label").html("Procesada <i class='fa fa-check'></i>");
	$(fila[4]).children("label").addClass("bg-green");
	$(fila[4]).children("button").remove();
	$("#vDirectaModal").fadeOut(300);

	let total_pagar=0;
	let totales=$(".valores-a-pagar").toArray()
	$.each(totales, function( llave, valor ) {
		total_pagar += parseFloat($(valor).text());
	});
	$("input[name='total_a_pagar']").val(total_pagar);
	if (totales.length == $("input[name='input_cantidad_pasajeros']").val() ) {
		$("#boton-modal-pago").attr("disabled",false);
	}else{
		$("#boton-modal-pago").attr("disabled",true);
	}
});
// ABRIR MODAL DE FORAMDE PAGO
$(document).on('click', '#boton-modal-pago', function (e){
	let a_pagar = $("input[name='total_a_pagar']").val();
	$("input[name='fp_abono']").attr("max",a_pagar);
	$("input[name='fp_por_pagar']").val(a_pagar);
	$("#modal-tipo-pago").fadeIn(300);
});
// VER CUANDO CAMBIE DE VALOR EL SELECT
$(document).on('change', "select[name='fp_tipo']", function (e){
	let valor = this.value;
	if (valor == "Efectivo") {
		$("#fp_datos_banco").attr("hidden",true);
	}else{
		$("#fp_datos_banco").attr("hidden",false);
	}
});
// FUNCION DEL CHEK DE MONTO COMPLETO
$(document).on('click', "input[name='fp_monto_completo']", function (e){
	let estado = this;
	if (estado.checked) {
		$("input[name='fp_abono']").val($("input[name='total_a_pagar']").val());
		$("input[name='fp_abono']").attr("disabled",true);
	} else {
		$("input[name='fp_abono']").val(0);
		$("input[name='fp_abono']").attr("disabled",false);
	}
});
// GUARDAR FORMA DE PAGO
$(document).on('click', '#guardar-forma-pago', function (e){
	let datos_fp = $(".input-forma-pago").toArray();
	if (datos_fp[0].value == "Efectivo") {
		if (datos_fp[1].value == 0 || datos_fp[1] == null) {
			$("#div-alerta").html("<i class='fa fa-warning'></i> Por Favor Llene El campo MONTO").fadeIn(300).delay(1000).fadeOut(300);
		}else{
			$("#modal-tipo-pago").fadeOut(300);
			$("#boton-finalizar-procesar-cotizacion").attr("disabled",false);
		}
	} else {
		if (datos_fp[1].value == 0 || datos_fp[1] == null) {
			$("#div-alerta").html("<i class='fa fa-warning'></i> Por Favor Llene El campo MONTO").fadeIn(300).delay(1000).fadeOut(300);
		}else{
			if (datos_fp[5].value == 0 || datos_fp[1] == null) {
				$("#div-alerta").html("<i class='fa fa-warning'></i> Por Favor Llene El campo N° De Operacion").fadeIn(1000).delay(600).fadeOut(300);
			}else{
				$("#modal-tipo-pago").fadeOut(300);
				$("#boton-finalizar-procesar-cotizacion").attr("disabled",false);
			}
		}
	}
});
// CERRAR MODAL DE FORAMDE PAGO
$(document).on('click', '.cerrar-boton-modal-pago', function (e){
	$("#modal-tipo-pago").fadeOut(300);
});
// CREAR BOLETO AGENCIA DE VIAJES
$(document).on('click', "#crear-boleto-agencia", function (e){
	let id_fila = $("#crear-boleto-agencia").val();
	let datos = $(".input_venta_agencia").toArray();
	$("#tabla-venta-paquete").append(
		"<tr value='"+id_fila+"'>"+
		"<td value='"+datos[11].value+"'>"+datos[0].value+"</td>"+
		"<td>"+datos[1].value+"</td>"+
		"<td>"+datos[2].value+"</td>"+
		"<td>"+datos[3].value+"</td>"+
		"<td>"+datos[4].value+"</td>"+
		"<td>"+datos[5].value+"</td>"+
		"<td>"+datos[6].value+"</td>"+
		"<td>"+datos[7].value+"</td>"+
		"<td>"+datos[8].value+"</td>"+
		"<td>"+datos[9].value+"</td>"+
		"<td class='valores-a-pagar'>"+datos[10].value+"</td>"+
		"<td>"+
		"<button data-toggle='tooltip' title='Eliminar Boleto' class='btn-xs btn btn-danger eliminar-boleto'><i class='fa fa-close'></i></button>"+
		"</td>"+
		"</tr>"
		);
	let fila = $("#"+id_fila).children("div");
	$(fila[4]).children("label").html("Procesada <i class='fa fa-check'></i>");
	$(fila[4]).children("label").addClass("bg-green");
	$(fila[4]).children("button").remove();
	$("#agenciaModal").fadeOut(300);

	let total_pagar=0;
	let totales=$(".valores-a-pagar").toArray()
	$.each(totales, function( llave, valor ) {
		total_pagar += parseFloat($(valor).text());
	});
	$("input[name='total_a_pagar']").val(total_pagar);
	if (totales.length == $("input[name='input_cantidad_pasajeros']").val() ) {
		$("#boton-modal-pago").attr("disabled",false);
	}else{
		$("#boton-modal-pago").attr("disabled",true);
	}
});
$(document).on('click', '#boton-finalizar-procesar-cotizacion', function (e){
	let boletos = [];
	let hotel = $("input[name='tarifa_hotel']:checked").parents("tr").attr("name");
	$.each($("#tabla-venta-paquete tbody tr").toArray(), function( llave, valor ) {
		let boletoActual = $(valor).children("td").toArray(); 
		var boleto = [];
		// VALIDO SI ES VENTA DIRECTA 
		if ($("input[name='tventa']:checked").val() === "venta") {
			boleto.push('tarifa_fee','utilidad','total_utilidades');
			boleto = {
				'cliente_id'       : $(boletoActual[0]).text(),
				'nacionalidad'     : $(boletoActual[0]).attr("value"),
				'tipo_venta'       : $("input[name='tventa']:checked").val(),
				'cotizacion_id'    : $(boletoActual[2]).text(),
				'codigo_hoteles'   : hotel,
				'tipo_cliente'     : $(boletoActual[4]).text(),
				'neto'             : $(boletoActual[5]).text(),
				'comision'         : $(boletoActual[6]).text(),
				'diez'             : $(boletoActual[7]).text(),
				'incentivo'        : $(boletoActual[8]).text(),
				'total'            : $(boletoActual[9]).text(),
				'a_pagar'          : $(boletoActual[13]).text(),
				'tarifa_fee'       : $(boletoActual[10]).text(),
				'utilidad'         : $(boletoActual[11]).text(),
				'paquete_id'       : $("#buscar-paquete").val(),
				'total_utilidades' : $(boletoActual[12]).text()
			};
		}else{
			boleto = {
				'cliente_id'       : $(boletoActual[0]).text(),
				'nacionalidad'     : $(boletoActual[0]).attr("value"),
				'tipo_venta'       : $("input[name='tventa']:checked").val(),
				'cotizacion_id'    : $(boletoActual[2]).text(),
				'codigo_hoteles'   : hotel,
				'tipo_cliente'     : $(boletoActual[4]).text(),
				'neto'             : $(boletoActual[5]).text(),
				'comision'         : $(boletoActual[6]).text(),
				'diez'             : $(boletoActual[7]).text(),
				'incentivo'        : $(boletoActual[8]).text(),
				'total'            : $(boletoActual[9]).text(),
				'paquete_id'       : $("#buscar-paquete").val(),
				'a_pagar'          : $(boletoActual[10]).text()
			};
		}
		console.log(boleto);
		boletos.push(boleto);
	});
	// GAURDO DATOS DE PAGO
	// YGE150MS
	if ($("select[name='fp_tipo']").val() === "Efectivo") {
		var abono = [{
			'tipo'   :$("select[name='fp_tipo']").val(),
			'abono'  :$("input[name='fp_abono']").val(),
		}];
	}else{
		var abono = [{
			'tipo'   :$("select[name='fp_tipo']").val(),
			'abono'  :$("input[name='fp_abono']").val(),
			'banco_e'  :$("select[name='fp_banco_emisor']").val(),
			'banco_r'  :$("select[name='fp_banco_receptor']").val(),
			'operacion'  :$("input[name='fp_operacion']").val(),
		}];
	}
	$.ajax({
		type     : "get",
		data     :{listaBoletos : boletos , pago:abono},
		url      : APP_URL+'/tablero/Procesar/Cotizacion/Qantu/Finalizar/Proceso/Store',
		datatype : 'json',
		beforeSend: function (){
			$("#div-alerta").html("Procesando La Cotizacion Espere Un Momento <img src='"+APP_URL+"/imagenes/cargando.gif"+"'>").fadeIn(500);
			$("#boton-finalizar-procesar-cotizacion").attr("disabled",true);
		},
		success:  function (response) {
			if (response == "si") {
				window.location.href = APP_URL+"/tablero/Paquetes/Ventas/index";
			}
		},
		error: function(jqXHR){
			console.log(jqXHR);
		}
	});		
});
// ELIMINAR BOLETO
$(document).on('click', '.eliminar-boleto', function (e){
	boton = $(this);
	fila = $(boton).parents("tr");
	$("#"+$(fila).attr("value")).remove();
	$(fila).remove();
	$("input[name='cantidad_habitaciones']").val(parseInt($("input[name='cantidad_habitaciones']").val())+1);
});
// ELIMINAR BOLETO SIN PROCESAR 
$(document).on('click',  "button[name='eliminar']", function (e){
	 boton = $(this);
	 fila = $(boton).parents(".fila-cliente");
	 $(fila).remove();
	 $("input[name='cantidad_habitaciones']").val(parseInt($("input[name='cantidad_habitaciones']").val())+1);
});

