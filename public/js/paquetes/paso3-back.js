var paquete_id = $("#paquete_id").val();
$(document).ready(function(){
    $(".select2").select2();
});

function charge_mismos_destinos(dia_id){
	$("#filtro_"+dia_id)[0].style.display = 'none';
	$("#div_multiple_"+dia_id)[0].style.display = 'none';
	
	var select_services = $("#serv_actividad_"+dia_id);
	var url = APP_URL+'/tablero/Admin/Paso/3/Mis_Services/Paquete/'+paquete_id;
	axios.get(url).then(response => {
		$(".item_"+dia_id).remove();
		$.each(response.data, function(i, v){
			$(select_services).append("<option class='item_"+dia_id+"' value='"+v.id+"'>"+v.nombre+" / "+v.operador.nombre+"</option>");
		});
	}).catch(error => {
		console.log(error.response.data);
	});
}

function charge_others_destinos(dia_id){
	$("#filtro_"+dia_id)[0].style.display = '';
	var otros_destinos = $("#multi_destinos_"+dia_id);
	var url = APP_URL+'/tablero/Admin/Paso/3/Others_Destinos/Paquete/'+paquete_id;
	axios.get(url).then(response => {
		$("#div_multiple_"+dia_id)[0].style.display = 'block';
		$(".item_"+dia_id).remove();
		$(".destino_"+dia_id).remove();
		$.each(response.data, function(i, v){
			$(otros_destinos).append("<option class='destino_"+dia_id+"' value='"+v.id+"'>"+v.nombre+"</option>");
		});
	}).catch(error => {
		console.log(error.response);
	})
}

function charge_restaurants(){
	var url = APP_URL+'/tablero/Admin/Paso/3/Restaurants/Paquete/'+paquete_id;
	var select_restaurants = $("select[name='restaurante_id']");
	axios.get(url).then(response => {
		$.each(response.data, function(i, v){
			$(select_restaurants).append("<option value='"+v.id+"'>"+v.nombre+" / "+v.destino.nombre+"</option>");
		});
	}).catch(error => {
		console.log(error.response.data);
	});
}

function filtrar_multi(dia_id){
	var array_multi_destinos = [];
	var select_services = $("#serv_actividad_"+dia_id);

	$.each($("#multi_destinos_"+dia_id)[0].selectedOptions, function(i, v){
		array_multi_destinos.push(v.value);
	});
	var url = APP_URL+'/tablero/Admin/Paso/3/Other_Services';
	axios.post(url,{
		destinos: array_multi_destinos
	}).then(response => {
		$(".item_"+dia_id).remove();
		$.each(response.data, function(i, v){
			$(select_services).append("<option class='item_"+dia_id+"' value='"+v.id+"'>"+v.nombre+" / "+v.operador.nombre+"</option>");
		});
		toastr.success("Filtro Realizado!.")
	}).catch(error => {
		console.log(error.response.data);
	});
}

function verTipo(e){
	var valor=$(e).val();
	var id=$(e).attr("id");
	$("span").remove();
	if (valor == 'servicio') {
		$("#msg-default_"+id+"").addClass("hidden");
		$("select[id='rest_actividad_"+id+"']").addClass("hidden");
		$("select[id='rest_actividad_"+id+"']").removeClass("select2");
		$("select[id='serv_actividad_"+id+"']").removeClass("hidden");
		$("select[id='serv_actividad_"+id+"']").addClass("select2");
		$(".select2").select2();

		charge_mismos_destinos(id);
		$("#ocultar_"+id).css("opacity", 1);
	}else if(valor == 'restaurante'){
		$("#msg-default_"+id+"").addClass("hidden");
		$("select[id='rest_actividad_"+id+"']").removeClass("hidden");
		$("select[id='rest_actividad_"+id+"']").addClass("select2");
		$("select[id='serv_actividad_"+id+"']").addClass("hidden");
		$("select[id='serv_actividad_"+id+"']").removeClass("select2");
        
        $("#filtro_"+id)[0].style.display = 'none';
		$("#div_multiple_"+id)[0].style.display = 'none';
		$("#otros").attr('checked', false);
		$("#mismos").attr('checked', true);

		$(".select2").select2();

        $("#ocultar_"+id).css("opacity", 0);
	}else if(valor == 'none'){
		$("#msg-default_"+id+"").removeClass("hidden");
		$("select[id='rest_actividad_"+id+"']").addClass("hidden");
		$("select[id='serv_actividad_"+id+"']").addClass("hidden");
		$("select[id='rest_actividad_"+id+"']").removeClass("select2");
		$("select[id='serv_actividad_"+id+"']").removeClass("select2");
		$(".select2").select2();

		$("#filtro_"+id)[0].style.display = 'none';
		$("#div_multiple_"+id)[0].style.display = 'none';
		$("#ocultar_"+id).css("opacity", 0);
	}

}
