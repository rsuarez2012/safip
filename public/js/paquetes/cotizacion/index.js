// LEVANTAR EL MODAL DE CREAR
$(document).on('click', '#abrirCrear', function (e) {
	$("#crearCotizacion").removeClass("hidden");
	$("#actualizarCotizacion").addClass("hidden");
	$("#titulo-modal-cotizacion").html("<i class='fa fa-list'></i> Crear Cotizacion");
	$("#form-cotizacion").attr("action",APP_URL+"/tablero/Paquetes/Cotizaciones/store");
	$("#modalCrear").fadeIn(300);
});
// CERRAR MODAL
$(document).on('click', '.cerrarCrear', function (e) {
	$("#modalCrear").fadeOut(300);
	// VACIO LOS INPUT Y TEXTAREA
	let inputs = $(".input-cotizacion").toArray();
	$.each( inputs , function( indice , valor ){
		this.value = "";
	});
	$("#textarea-cotizacion").val("");
});
// CREAR COTIZACION
// $(document).on('click', '#crearCotizacion', function (e) {
// 	let form   = $("#form-cotizacion .input-cotizacion").toArray();
// 	let llenos = 0;
// 	let alerta = $("#div-alerta");

// 	// VALIDAR CAMPOS REQUERIDOS
// 	$.each( form , function( indice , valor ){
// 		if (this.value != "") {
// 			llenos++;
// 		}
// 	});


// 	if ($("input[name='cantidad']").val() > 0) {
// 		if (llenos < form.length) {
// 			alerta.html("<i class='fa fa-warning'></i> Debe LLenar Todos Los Campos Requeridos").fadeIn(300).delay(600).fadeOut(300);
// 		}else{
// 			// ENVIAR AJAX
// 			$.ajax({
// 				type     : "POST",
// 				data     : $("#form-cotizacion").serialize(),
// 				url      : APP_URL+'/tablero/Paquetes/Cotizaciones/store',
// 				datatype : 'json',
// 				beforeSend: function (){
// 					$("#modalCrear").fadeOut(300);
// 					// VACIO LOS INPUT Y TEXTAREA
// 					let inputs = $(".input-cotizacion").toArray();
// 					$.each( inputs , function( indice , valor ){
// 						this.value = "";
// 					});
// 					$("#form-cotizacion textarea").val("");
// 				},
// 				success:  function (response) {
// 					$("#cargando").attr("hidden",true);
// 					// CREAR FILA 
// 					if (response.mensaje.estado == "procesado") {
// 						var estado = "<label class='label label-success'>Procesado</label>";
// 					}else{
// 						var estado = "<label class='label label-danger'>Por Procesar</label>";
// 					}	
// 					$("#cpaquetes tbody tr:first").before(
// 						"<tr>"+
// 						"<td class='text-center text-bold'>"+response.mensaje.id+"</td>"+
// 						"<td>"+response.mensaje.agencia.nombre+"</td>"+
// 						"<td>"+response.mensaje.pais.Paisnombre+"</td>"+
// 						"<td>"+response.mensaje.destino.nombre+"</td>"+
// 						"<td>"+response.mensaje.nacionalidad+"</td>"+
// 						"<td>"+response.mensaje.fecha_salida+"</td>"+
// 						"<td>"+response.mensaje.fecha_retorno+"</td>"+
// 						"<td class='text-center'>"+response.mensaje.pasajero+"</td>"+
// 						"<td class='text-center'>"+estado+"</td>"+
// 						"<td>"+response.mensaje.observacion+"</td>"+
// 						"<td>"+response.mensaje.created_at+"</td>"+
// 						"<td>"+response.mensaje.vendedor.nombres+"</td>"+
// 						"<td>"+response.mensaje.updated_at+"</td>"+
// 						"<td>"+
// 						"</td>"
// 						);
// 					alerta.html("Cotizacion Creada Correctamente <i class='fa fa-check'></i>").fadeIn(300).delay(600).fadeOut(300);
// 				},
// 				error: function(jqXHR){
// 					$("#cargando").attr("hidden",true);
// 					alerta.html(jqXHR).fadeIn(300).delay(600).fadeOut(300);
// 				}
// 			});				
// 		}
// 	}else{
// 		alerta.html("<i class='fa fa-user'></i> Minimo 1 Pasajero").fadeIn(300).delay(600).fadeOut(300);
// 	}
// });

// ABRI MODAL EDITAR 
$(document).on('click', '.editarCotizacion', function (e) {
	$("#form-cotizacion").attr("action",APP_URL+"/tablero/Paquetes/Cotizaciones/update");
	$("#input-editar-cotizacion").children("input").val(this.value);
	$("#crearCotizacion").addClass("hidden");
	$("#actualizarCotizacion").removeClass("hidden");
	$("#modalCrear").fadeIn(300);
	$("span").remove();
	$("#titulo-modal-cotizacion").html("<i class='fa fa-pencil'></i> Editar Cotizacion N° " + this.value);
	let fila    = $(this).parents("tr");
	let valores = $(fila).children("td").toArray();
	// RECORRER SELECT AGENCIAS
	$.each( $("select[name='agencia_id'] option"), function( indice , valor ){
		if ($(this).text() == $(valores[1]).text()) {
			$(this).attr("selected",true);
		}else{
			$(this).attr("selected",false);
		}
	});
	// RECORRER SELECT DE PAISES
	$.each( $("select[name='pais_id'] option"), function( indice , valor ){
		if ($(this).text() == $(valores[2]).text()) {
			$(this).attr("selected",true);
		}else{
			$(this).attr("selected",false);
		}
	});
	// RECORRER SELECT DE DESTINOS
	$.each( $("select[name='destino_id'] option"), function( indice , valor ){
		if ($(this).text() == $(valores[3]).text()) {
			$(this).attr("selected",true);
		}else{
			$(this).attr("selected",false);
		}
	});
	// RECORRER SELECT DE NACIONALIDAD
	$.each( $("select[name='nacionalidad'] option"), function( indice , valor ){
		if ($(this).text() == $(valores[4]).text()) {
			$(this).attr("selected",true);
		}else{
			$(this).attr("selected",false);
		}
	});
	// EJECUTAR FUNCION DE SELECT DINAMICO
	$(".select2").select2();
	// AGREGAR VALORES A INPUT Y TEXTAREA 
	$("input[name='fecha_salida']").val($(valores[5]).text());
	$("input[name='fecha_retorno']").val($(valores[6]).text());
	$("input[name='cantidad']").val($(valores[7]).text());
	$("#textarea-cotizacion").val($(valores[9]).text());

	// LE PASO EL ID DE LA COTIZACION AL BOTON
	$("#actualizarCotizacion").val($(valores[0]).text());
});

// // FUNCION EDITAR DE COTIZACION
// $(document).on('click', '#actualizarCotizacion', function (e) {
// 	let form   = $("#form-cotizacion .input-cotizacion").toArray();
// 	let llenos = 0;
// 	let alerta = $("#div-alerta");

// 	// VALIDAR CAMPOS REQUERIDOS
// 	$.each( form , function( indice , valor ){
// 		if (this.value != "") {
// 			llenos++;
// 		}
// 	});


// 	if ($("input[name='cantidad']").val() > 0) {
// 		if (llenos < form.length) {
// 			alerta.html("<i class='fa fa-warning'></i> Debe LLenar Todos Los Campos Requeridos").fadeIn(300).delay(600).fadeOut(300);
// 		}else{
// 			// ENVIAR AJAX
// 			let id_cotizacion = this.value;
// 			$.ajax({
// 				type     : "POST",
// 				data     : $("#form-cotizacion").serialize(),
// 				url      : APP_URL+'/tablero/Paquetes/Cotizaciones/update/'+id_cotizacion,
// 				datatype : 'json',
// 				beforeSend: function (){
// 					$("#cargando").attr("hidden",false);
// 					$("#modalCrear").fadeOut(300);
// 					// VACIO LOS INPUT Y TEXTAREA
// 					let inputs = $(".input-cotizacion").toArray();
// 					$.each( inputs , function( indice , valor ){
// 						this.value = "";
// 					});
// 					$("#form-cotizacion textarea").val("");
// 				},
// 				success:  function (response) {
// 					if (response.mensaje.estado == "procesado") {
// 						var estado = "<label class='label label-success'>Procesado</label>";
// 					}else{
// 						var estado = "<label class='label label-danger'>Por Procesar</label>";
// 					}	
// 					$("#cargando").attr("hidden",true);
// 					alerta.html("La Cotizacion N° "+response.mensaje.id+" Se Actualiza Correctamente").fadeIn(300).delay(600).fadeOut(300);
// 					let filas = $("#fila-"+id_cotizacion+" td").toArray();
// 					$(filas[1]).text(response.mensaje.agencia.nombre);
// 					$(filas[2]).text(response.mensaje.pais.Paisnombre);
// 					$(filas[3]).text(response.mensaje.destino.nombre);
// 					$(filas[4]).text(response.mensaje.nacionalidad);
// 					$(filas[5]).text(response.mensaje.fecha_salida);
// 					$(filas[6]).text(response.mensaje.fecha_retorno);
// 					$(filas[7]).text(response.mensaje.pasajero);
// 					$(filas[8]).html(estado);
// 					$(filas[9]).text(response.mensaje.observacion);
// 					$(filas[10]).text(response.mensaje.created_at);
// 					$(filas[11]).text(response.mensaje.user.nombres);
// 					$(filas[11]).text(response.mensaje.updated_at);
// 				},
// 				error: function(jqXHR){
// 					$("#cargando").attr("hidden",true);
// 					alerta.html(jqXHR).fadeIn(300).delay(600).fadeOut(300);
// 				}
// 			});				
// 		}
// 	}else{
// 		alerta.html("<i class='fa fa-user'></i> Minimo 1 Pasajero").fadeIn(300).delay(600).fadeOut(300);
// 	}
// });

// LEVANTAR EL MODAL DE CREAR
$(document).on('click', '.abrirProcesar', function (e) {
	$("input[name='cotizacion']").val(this.value);
	$("input[name='proveedor']").val(this.value);
	$("#modalProcesar").fadeIn(300);
});
// CERRAR MODAL
$(document).on('click', '.cerrarProcesar', function (e) {
	$("#modalProcesar").fadeOut(300);
});