$(document).on('click', '.cambiar-estado', function (e) {
	let valor = this.value;
	let paquete_id = $(this).parents("td").attr("name");
	let boton      = $(this);
	let icono      = $(boton).children("i");
	let alerta     = $("#div-alerta");
	$.ajax({
		type     : "get",
		url      : APP_URL+'/tablero/Paquetes/Admin/Cambiar/Estado/'+paquete_id+"/"+valor,
		datatype : 'json',
		success:  function (response) {
			icono.remove();
			alerta.html("El Paquete Cambio De Estado Correctamente <i class='fa fa-check'></i>").fadeIn(300).delay(500).fadeOut(300);
			$("#estado-"+paquete_id).text(response.e_n);
			// AGREGAR ESTADO 
            if (response.e_v == 'oculto') {
            	$(boton).append("<i class='fa fa-eye-slash'></i>");
            	$(boton).val('oculto');
            	$(boton).attr("data-original-title","Oculto Para La Web");
            	$(boton).attr("title","Oculto Para La Web");
            }else if(response.e_v == 'visible'){
            	$(boton).append("<i class='fa fa-eye'></i>");
            	$(boton).val('visible');
            	$(boton).attr("data-original-title","Visible En La Web");
            	$(boton).attr("title","Visible En La Web");
            }else{
            	$(boton).append("<i class='fa fa-star'></i>");
            	$(boton).val('destacado');
            	$(boton).attr("data-original-title","Colocar En Destacados");
            	$(boton).attr("title","Colocar En Destacados");
            }
        },
        error: function(jqXHR){
        	$("#cargando").attr("hidden",true);
        	console.log(jqXHR);
        }
    });
});
