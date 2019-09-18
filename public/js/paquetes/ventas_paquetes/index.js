// DATATABLE
$(document).ready(function () {
	let qantu = $("input[name='qantu_total']").val();
	let otros = $("input[name='otros_total']").val();
	let suma = parseFloat(qantu) + parseFloat(otros);
	$("input[name='total_ot_qt']").val(suma);
	$("input[name='total_qt_ot']").val(suma);
	$(function () {
		$('#paquetes').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true
		});
	});
	$(function () {
		$('#paquetes2').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true
		});
	});
});
// MODAL VER BOLETO
$(document).on('click', '.abrirBoleto', function (e) {
	let boleto = this.value;
	$.get({
		url: APP_URL + "/tablero/Venta/Boletos/Paquete/Modal/" + boleto,
		type: 'get',
		beforeSend: function () {
			$("#cargando").attr("hidden", false);
		},
		success: function (response) {
			nombre_hotel = "";
			$.each(response.hoteles, function (index, value) {
				nombre_hotel += " / " + value.hotel.nombre;
			});
			$("#cargando").attr("hidden", true);
			$("#titulo-boleto").text(boleto);
			$("input[name='cliente_dni']").val(response.boleto.cliente.cedula_rif);
			$("input[name='cliente_nombre']").val(response.boleto.cliente.nombre + " " + response.boleto.cliente.apellido);
			$("input[name='tiket']").val(response.boleto.id);
			$("input[name='cliente_hoteles']").val(nombre_hotel);
			$("input[name='cliente_tipo']").val(response.boleto.qantu.tipo_pasajero);
			$("input[name='cliente_neto']").val(response.boleto.costo_neto);
			$("input[name='cliente_comision']").val(response.boleto.qantu.comision);
			$("input[name='cliente_diez']").val(response.boleto.qantu.porcentaje);
			$("input[name='cliente_incentivo']").val(response.boleto.incentivo);
			$("input[name='cliente_total']").val(response.boleto.total_venta);
			$("input[name='cliente_pagar']").val(response.boleto.a_pagar);
			$("#enlace-boleto").attr("href", APP_URL + "/tablero/Paquetes/Ventas/Imprimir/boleto/" + response.boleto.id);
			$("#modalBoleto").fadeIn(300);
		},
		error: function (jqXHR) {
			$("#cargando").attr("hidden", true);
			alert("no");
		}
	});
});
$(document).on('click', '.cerrarModal', function (e) {
	$(".modal").fadeOut(300);
});
// Modal Fecha
function modalFecha(data) {
	$("input[name='f_cotizacion']").val(data.cotizacion_id);
	$("#f_title").text(data.id)
	$("#modalFecha").fadeIn(300);
};
//CAMBIO DE RADIO
function tipoRadio() {
	let tipo = $("input[name='tventa']:checked").val();
	if (tipo == "agencia") {
		//OCULTO LAS DIRECTAS Y MUESTRO AGENCIAS
		$(".fila-agencia").show();
		$(".fila-directa").hide();
		//OCULTO Y MUESTRO INPUT DE TOTALES
		$("input[name='qantu_agencia']").show();
		$("input[name='qantu_directa']").hide();
		$("input[name='qantu_total']").hide();
		//OCULTO Y MUESTRO INPUTS
		$("input[name='otros_agencia']").show();
		$("input[name='otros_directa']").hide();
		$("input[name='otros_total']").hide();
		//MUESTRO TOTALES EN INPUT DOS
		let qantu = $("input[name='qantu_agencia']").val();
		let otros = $("input[name='otros_agencia']").val();
		let suma = parseFloat(qantu) + parseFloat(otros);
		$("input[name='total_ot_qt']").val(suma);
		$("input[name='total_qt_ot']").val(suma);
	} else if (tipo == "directa") {
		//OCULTO LAS AGENCIAS Y MUESTRO DIRECTAS
		$(".fila-agencia").hide();
		$(".fila-directa").show();
		//OCULTO Y MUESTRO INPUT DE TOTALES
		$("input[name='qantu_agencia']").hide();
		$("input[name='qantu_directa']").show();
		$("input[name='qantu_total']").hide();
		//OCULTO Y MUESTRO INPUTS
		$("input[name='otros_agencia']").hide();
		$("input[name='otros_directa']").show();
		$("input[name='otros_total']").hide();
		//MUESTRO TOTALES EN INPUT DOS
		let qantu = $("input[name='qantu_directa']").val();
		let otros = $("input[name='otros_directa']").val();
		let suma = parseFloat(qantu) + parseFloat(otros);
		$("input[name='total_ot_qt']").val(suma);
		$("input[name='total_qt_ot']").val(suma);
	} else if (tipo == "todos") {
		//MUESTRO TODO
		$(".fila-agencia").show();
		$(".fila-directa").show();
		//OCULTO Y MUESTRO INPUT DE TOTALES
		$("input[name='qantu_agencia']").hide();
		$("input[name='qantu_directa']").hide();
		$("input[name='qantu_total']").show();
		//OCULTO Y MUESTRO INPUTS
		$("input[name='otros_agencia']").hide();
		$("input[name='otros_directa']").hide();
		$("input[name='otros_total']").show();
		//MUESTRO TOTALES EN INPUT DOS
		let qantu = $("input[name='qantu_total']").val();
		let otros = $("input[name='otros_total']").val();
		let suma = parseFloat(qantu) + parseFloat(otros);
		$("input[name='total_ot_qt']").val(suma);
		$("input[name='total_qt_ot']").val(suma);
	}
}
//MODAL FILTRO
function modalFiltro() {
	$("#modalFiltro").fadeIn(300);
}