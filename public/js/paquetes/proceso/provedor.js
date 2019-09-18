$(document).ready(function () {
	var div_prov_CInfoProv,
		div_prov_PPasajeros,
		div_prov_CPasajeros,
		div_prov_PInfoPaquete,
		div_prov_CInfoPaquete,
		prov_agencia = 0,
		prov_ventad = 0,
		op_neto = 0,
		op_comi = 0,
		op_diez = 0,
		op_total = 0,
		op_a_pagar = 0,
		op_tarifa_fee = 0,
		op_tarifa_utilidad = 0,
		op_total_utilidad = 0,
		tabla;


	div_prov_CInfoProv = $('#div_prov_CInfoProv')[0];
	div_prov_CInfoProv.attributes[0].value = "box box-danger";

	/* $(document).on('click', ".abriragencia", function (e){
        alert('hi');
	}); */

	function verInfoPasajeros() {
		div_prov_PPasajeros = $('#div_prov_PPasajeros')[0];
		div_prov_CPasajeros = div_prov_PPasajeros.children[0];
		div_prov_PPasajeros.style.display = 'block';
		div_prov_CPasajeros.attributes[0].value = "box box-danger";

		tabla = $("#tabla_op-venta-paquete");
		if (tabla[0].children.length > 1) {
			var tr_childs = tabla[0].children[1].children;
			//console.log(tr_childs);
			for (var i = tr_childs.length - 1; i >= 0; i--) {
				tr_childs[i].remove()
			}
			$("input[name='total_post_proces']").val('');
			$("input[name='total_a_pagar']").val('');
		}

		var div_pasajeros = $('div .renoval');
		div_pasajeros.each(function () {
			var chd = $(this).children("div").toArray();
			var btn0 = $(chd[0]).children("button");
			var inp = $(chd[0]).children("input");
			var btn2 = $(chd[2]).children("button");

			if (btn0.length > 0) {
				//console.log(btn.length);
			}
			if (inp.length > 0) {
				inp.remove();
				$(chd[0]).append("<button class='btn btn-danger abrirPasajeros' >Seleccionar Pasajero</button>");
				$(chd[2]).children("button[name='procesarp']").attr("disabled", true);

				if (btn2.length == 0) {
					//console.log(chd[2]);
					$(chd[2]).children("label").html("<i class='fa  fa-wrench'></i> Acciones");
					$(chd[2]).children("label").removeClass("bg-green");
					$(chd[2]).append("<button name='procesarp' disabled='true' title='Procesar' data-toggle='tooltip' class='abriragencia btn btn-danger btn-xs'><i class='fa fa-cog'></i></button>");
					$(chd[2]).append("<button name='eliminar' title='Eliminar' data-toggle='tooltip' class='btn btn-danger btn-xs'><i class='fa fa-close'></i></button>");
				}
			}
		});
	}

	$(document).on('click', "#prov_agencia", function (e) {
		verInfoPasajeros();
		prov_agencia = 1;
		prov_ventad = 0;
		$(".mostrar").hide();
	});

	$(document).on('click', "#prov_ventad", function (e) {
		verInfoPasajeros();
		prov_agencia = 0;
		prov_ventad = 1;
		$(".mostrar").show();
	});

	$(document).on('keyup', "#otros_prov_neto", function (e) {
		op_neto = $("#otros_prov_neto").val();
		op_comi = op_neto * 0.12;
		op_diez = (parseFloat(op_neto) + parseFloat(op_comi)) * 0.10;
		op_total = parseFloat(op_neto) + parseFloat(op_comi) + parseFloat(op_diez) + 12;
		op_a_pagar = op_total;
		$('#otros_prov_comi').val(op_comi.toLocaleString("es-ES"));
		$('#otros_prov_diez').val(op_diez.toLocaleString("es-ES"));
		$('#otros_prov_total').val(op_total);
		$('#otros_prov_a_pagar').val(op_a_pagar);
	});

	$(document).on('keyup', "#otros_prov_tarifa_fee", function (e) {
		op_tarifa_fee = $("#otros_prov_tarifa_fee").val();

		if (op_tarifa_fee == null || op_tarifa_fee == 0 || op_tarifa_fee == '') {
			op_tarifa_fee = 0;
		}
		if (op_tarifa_utilidad == null || op_tarifa_utilidad == 0 || op_tarifa_utilidad == '') {
			op_tarifa_utilidad = 0;
		}

		op_total_utilidad = parseFloat(op_tarifa_fee) + parseFloat(op_tarifa_utilidad);
		op_a_pagar = parseFloat(op_total) + parseFloat(op_total_utilidad);

		$('#otros_prov_total_util').val(op_total_utilidad);
		$('#otros_prov_a_pagar').val(op_a_pagar);
	});

	$(document).on('keyup', "#tarifaUtilidad", function (e) {
		op_tarifa_utilidad = $("#tarifaUtilidad").val();

		if (op_tarifa_fee == null || op_tarifa_fee == 0 || op_tarifa_fee == '') {
			op_tarifa_fee = 0;
		}
		if (op_tarifa_utilidad == null || op_tarifa_utilidad == 0 || op_tarifa_utilidad == '') {
			op_tarifa_utilidad = 0;
		}

		op_total_utilidad = parseFloat(op_tarifa_fee) + parseFloat(op_tarifa_utilidad);
		op_a_pagar = parseFloat(op_total) + parseFloat(op_total_utilidad);

		$('#otros_prov_total_util').val(op_total_utilidad);
		$('#otros_prov_a_pagar').val(op_a_pagar);
	});



	$(".abrirfpago").click(function () {
		$(".modalpagos").fadeIn();
	});
	$(".cerrarfpago").click(function () {
		$(".modalpagos").fadeOut(300);
	});
	//FIN FUNCION PARA MODAL FORMA DE PAGO
	// PARA OCULTAR LOS TH DE INFORMACION DE PAQUETE DE VENTA DIRECTA
	/*    $("#hide").click(function(){
			$(".mostrar").hide();
		});
		$("#show").click(function(){
			$(".mostrar").show();
		});*/
	//FIN OCULTAR LOS TH DE INFORMACION DE PAQUETE DE VENTA DIRECTA


	// MODAL AGENCIA 

	$(document).on('click', ".abriragencia", function (e) {
		clearDataCuentas();
		var oculto = $('.oculto');
		if (prov_ventad == 1) {
			$('#modal-title')[0].innerText = 'Paquetes y Costos Venta Directa';
			oculto.each(function () {
				$(this)[0].style.display = 'block';
			});
		} else {
			$('#modal-title')[0].innerText = 'Paquetes y Costos Agencia de Viaje';
			//var oculto = $('.oculto');
			oculto.each(function () {
				$(this)[0].style.display = 'none';
			});
		}

		$("#crear-pago-pasajero").val($(this).parents("div .row").attr("id"));

		$("#modal-procesar").fadeIn();
		// FUNCION PARA TRAER DATOS AL MODAL
		$(document).on('click', ".abriragencia", function (e) {
			let datos = $(this).parents("div .row").children("div").toArray();
			$("input[name='cliente_name']").val($(datos[0]).children("input[name='nombre']").val());
		});

		// FIN FUNCION PARA TRAER DATOS AL MODAL
	});

	$(".cerraragencia").click(function () {
		$("#modal-procesar").fadeOut(300);
	});
	// FIN MODAL AGENCIA 

	// MODAL VENTA DIRECTA
	$("#abrirventad").click(function () {
		$(".modal-ventadirecta").fadeIn();
	});
	$("#cerrarventad").click(function () {
		$(".modal-ventadirecta").fadeOut(300);
	});

	// Adicionar Costo de Pasajero
	$(document).on('click', "#crear-pago-pasajero", function () {
		let id_fila = $("#crear-pago-pasajero").val();
		let datos = $(".otros_prov_inputs_pago").toArray();

		if (datos[4].value == 0 || datos[4].value == null) {
			$(datos[4]).val(0);
		}
		if (datos[5].value == 0 || datos[5].value == null) {
			$(datos[5]).val(0);
		}
		if (datos[6].value == 0 || datos[6].value == null) {
			$(datos[6]).val(0);
		}

		div_prov_PInfoPaquete = $('#div_prov_PInfoPaquete')[0];
		div_prov_CInfoPaquete = div_prov_PInfoPaquete.children[0];
		div_prov_PInfoPaquete.style.display = 'block';
		div_prov_CInfoPaquete.attributes[0].value = "box box-danger";
		$("#modal-procesar").fadeOut(300);
		//clearDataCuentas();
		let fila = $("#" + id_fila).children("div");
		nacionalidad = fila[1].children[1].value;
		cliente_id = fila[0].children[3].value;

		if (prov_ventad == 1) {
			$("#tabla_op-venta-paquete").append(
				"<tr value='" + id_fila + "'>" +
				"<td name='nacionalidad' value='" + nacionalidad + "' style='display:none'></td>" +
				"<td name='cliente_id'   value='" + cliente_id + "'   style='display:none'></td>" +
				"<td>" + id_fila + "</td>" +
				"<td>" + datos[0].value + "</td>" +
				"<td>" + datos[1].value + "</td>" +
				"<td>" + datos[2].value + "</td>" +
				"<td>" + datos[3].value + "</td>" +
				"<td>" + datos[4].value + "</td>" +
				"<td>" + datos[5].value + "</td>" +
				"<td>" + datos[6].value + "</td>" +
				"<td name='total_venta'   value='" + datos[7].value + "' style='display:none'></td>" +
				"<td class='subtotal'>" + datos[8].value + "</td>" +
				"<td>" +
				"<button data-toggle='tooltip' title='Eliminar Boleto' class='btn-xs btn btn-danger eliminar-boleto'><i class='fa fa-close'></i></button>" +
				"</td>" +
				"</tr>"
			);
		} else {
			$("#tabla_op-venta-paquete").append(
				"<tr value='" + id_fila + "'>" +
				"<td name='nacionalidad' value='" + nacionalidad + "' style='display:none'></td>" +
				"<td name='cliente_id'   value='" + cliente_id + "'   style='display:none'></td>" +
				"<td>" + id_fila + "</td>" +
				"<td>" + datos[0].value + "</td>" +
				"<td>" + datos[1].value + "</td>" +
				"<td>" + datos[2].value + "</td>" +
				"<td>" + datos[3].value + "</td>" +
				"<td name='total_venta'   value='" + datos[7].value + "' style='display:none'></td>" +
				"<td class='subtotal'>" + datos[8].value + "</td>" +
				"<td>" +
				"<button data-toggle='tooltip' title='Eliminar Boleto' class='btn-xs btn btn-danger eliminar-boleto'><i class='fa fa-close'></i></button>" +
				"</td>" +
				"</tr>"
			);
		}


		$(fila[2]).children("label").html("Procesada <i class='fa fa-check'></i>");
		$(fila[2]).children("label").addClass("bg-green");
		$(fila[2]).children("button").remove();

		subtotales = $('.subtotal');
		total_post_proces = 0;
		subtotales.each(function () {
			total_post_proces += parseFloat($(this)[0].innerText);
		});
		$("input[name='total_post_proces']").val(total_post_proces);
		$("input[name='total_a_pagar']").val(total_post_proces);

		if (subtotales.length == $("input[name='input_cantidad_pasajeros']").val()) {
			$("#boton-modal-pago").attr("disabled", false);
			$("#total_a_pagar").attr("disabled", false);
		} else {
			$("#boton-modal-pago").attr("disabled", true);
			$("#total_a_pagar").attr("disabled", true);
		}
	});

	$(document).on('click', '#guardar-forma-pago', function (e) {
		let datos_fp = $(".input-forma-pago").toArray();
		if (datos_fp[0].value == "Efectivo") {
			if (datos_fp[1].value == 0 || datos_fp[1] == null) {
				$("#div-alerta").html("<i class='fa fa-warning'></i> Por Favor Llene El campo MONTO").fadeIn(300).delay(1000).fadeOut(300);
			} else {
				$("#modal-tipo-pago").fadeOut(300);
				$("#boton-finalizar-procesar-cotizacion_otros_prov").attr("disabled", false);
			}
		} else {
			if (datos_fp[1].value == 0 || datos_fp[1] == null) {
				$("#div-alerta").html("<i class='fa fa-warning'></i> Por Favor Llene El campo MONTO").fadeIn(300).delay(1000).fadeOut(300);
			} else {
				if (datos_fp[5].value == 0 || datos_fp[1] == null) {
					$("#div-alerta").html("<i class='fa fa-warning'></i> Por Favor Llene El campo N° De Operacion").fadeIn(1000).delay(600).fadeOut(300);
				} else {
					$("#modal-tipo-pago").fadeOut(300);
					$("#boton-finalizar-procesar-cotizacion_otros_prov").attr("disabled", false);
				}
			}
		}
	});

	function clearDataCuentas() {
		op_neto = 0,
			op_comi = 0,
			op_diez = 0,
			op_total = 0,
			op_a_pagar = 0,
			op_tarifa_fee = 0,
			op_tarifa_utilidad = 0,
			op_total_utilidad = 0;

		$("#otros_prov_neto").val('');
		$('#otros_prov_comi').val('');
		$('#otros_prov_diez').val('');
		//$('#incentivo').val('');
		$('#otros_prov_total').val('');
		$("#otros_prov_tarifa_fee").val('');
		$("#tarifaUtilidad").val('');
		$('#otros_prov_total_util').val('');
		$('#otros_prov_a_pagar').val('');
	}

	$(document).on('click', '#boton-finalizar-procesar-cotizacion_otros_prov', function (e) {
		let boletos = [];
		let cotizacion_id = $("input[name='cotizacion_id']").val();

		$.each($("#tabla_op-venta-paquete tbody tr").toArray(), function (i, v) {
			let boletoActual = $(v).children("td").toArray();
			var boleto = [];

			if (prov_ventad == 1) {
				boleto.push('tarifa_fee', 'utilidad', 'total_utilidad');
				boleto = {
					'tipo_venta': 'directa',
					'proveedor_id': $('#proveedor').val(),
					'por_pagar_t_t': $("input[name='fp_por_pagar']").val(),
					'nacionalidad': $(boletoActual[0]).attr("value"),
					'costo_neto': $(boletoActual[3]).text(),
					'incentivo': $(boletoActual[6]).text(),
					'cliente_id': $(boletoActual[1]).attr("value"),
					'cotizacion_id': cotizacion_id,
					'total_venta': $(boletoActual[10]).attr("value"),
					'a_pagar': parseFloat($(boletoActual[11]).text()),
					'tarifa_fee': $(boletoActual[7]).text(),
					'utilidad': $(boletoActual[8]).text(),
					'total_utilidad': $(boletoActual[9]).text(),
				}
			} else {
				boleto = {
					'tipo_venta': 'agencia',
					'proveedor_id': $('#proveedor').val(),
					'por_pagar_t_t': $("input[name='fp_por_pagar']").val(),
					'nacionalidad': $(boletoActual[0]).attr("value"),
					'costo_neto': $(boletoActual[3]).text(),
					'incentivo': $(boletoActual[6]).text(),
					'cliente_id': $(boletoActual[1]).attr("value"),
					'cotizacion_id': cotizacion_id,
					'total_venta': $(boletoActual[7]).attr("value"),
					'a_pagar': parseFloat($(boletoActual[8]).text()),
				}
			}
			boletos.push(boleto);
		});

		// Guardar datos de Pago
		if ($("select[name='fp_tipo']").val() === "Efectivo") {
			var abono = [{
				'tipo': $("select[name='fp_tipo']").val(),
				'abono': $("input[name='fp_abono']").val(),
			}];
		} else {
			var abono = [{
				'tipo': $("select[name='fp_tipo']").val(),
				'abono': $("input[name='fp_abono']").val(),
				'banco_e': $("select[name='fp_banco_emisor']").val(),
				'banco_r': $("select[name='fp_banco_receptor']").val(),
				'operacion': $("input[name='fp_operacion']").val(),
			}];
		}

		$("#div-alerta").html("Procesando La Cotizacion Espere Un Momento <img src='" + APP_URL + "/imagenes/cargando.gif" + "'>").fadeIn(500);
		$("#boton-finalizar-procesar-cotizacion").attr("disabled", true);

		console.log(boletos);
    	var url = APP_URL+'/tablero/Procesar/Cotizacion/Proveedor/Finalizar/Proceso/Store';
    	axios.post(url, {
            listaBoletos: boletos,
            pago: abono       
    	}).then(response => {
            //console.log(response.data);
            window.location.href = APP_URL+"/tablero/cotizaciones/admin";
    	}).catch(error => {
    		console.log(error.response.data);
    	});
	});




});




