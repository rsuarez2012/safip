var protocol = $(location).attr('protocol');
var url = $(location).attr('host');
var full_url = protocol + '//' + url;

$(document).ready(function(){
	$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var paquete = $('#paquete_id').val();
  $('.select-dia').change(function(){
  	var id = $(this).val();
  	console.log(id);
  	$('#dia_id').val(id);
  });
	$('#tipo').change(function(){
		var val = $(this).val();
    if(val == 'servicio'){
    	$.ajax({
    		url: "/safip/public/tablero/Admin/Paso/3/Restaurants/Paquete/" + paquete,
    		type: "GET",
    		success:function(data){
    			console.log(data);
    			if(data.length > 0){
	    			toastr.success('Se han encontrado ' + val + 's!.');
	    			this.restaurants = response.data;
            $("#search-restaurants").remove("span");
            $("#search-restaurants").select2();
    			}else{
    				toastr.warning('Disculpe!, No se han encontrado ' + val + 's!.');
    			}
    		}

    	});
  		$('#opcion').show();
    }else{
    	$.ajax({
    		url: "/safip/public/tablero/Admin/Paso/3/Mis_Services/Paquete/" + paquete,
    		type: "GET",
    		success:function(data){
    			console.log(data);
    			if(data.length > 0){
	    			toastr.success('Se han encontrado ' + val + 's!.');
	    			this.restaurants = response.data;
            $("#search-restaurants").remove("span");
            $("#search-restaurants").select2();
    			}else{
    				toastr.warning('Disculpe!, No se han encontrado ' + val + 's!.');
    			}
    		}

    	});
      $('#opcion').show();
    }
	});
	$('#f-services').change(function(){
		
		var opcion = $(this).val();
		if(opcion == false){
			
			$.ajax({
				url: "/safip/public/tablero/Admin/Paso/3/Mis_Services/Paquete/" + paquete,
				type: "GET",
				//data:,
				success:function(data){
					console.log(data);
					
				},
				error:function(data){

				}
			});
		}else{
			$.ajax({
				url: "/safip/public/get/other/destinies/" + paquete,
				type: "GET",
				//data:,
				success:function(data){
					$('#serve-des').show();
				  $.each(data, function(index, el) {
            //$("#serve-des").append('<optgroup label="">');
            $("#destinos-ser").append('<option value='+el.id+'>'+el.nombre+'</option>');  
            //destinos.push({paquete_id:paquete_id, destino_id:el.destino_id, hotel_id:el.id, noches: $('#count-days').val()});               

          });
				},
				error:function(data){

				}
			});
		}
		if(opcion === 'true'){
			//$('#serve-des').show();
		}else{
			$('#serve-des').hide();

		}

	});
	$('#searchFilterRestaurants').click(function(){
		var tipo = $('#tipo').val();
		console.log(tipo);
		var lista = $("#destinos-ser").val();
		console.log(lista);
		destinos = [];
		if(tipo == 'servicio'){
			if(lista){
				toastr.info('Se estan buscando información, por favor tenga paciencia!.');
				$.ajax({
					url: "/safip/public/get/other/services",
					type:"POST",
					data:{destinos:lista},
					success:function(data){
						console.log(data);
						if(data.length == ''){
							toastr.warning('No se encontro la información solicitada.!');

						}else{
							toastr.success('Excelente, se encontro la información solicitada.!');

							$.each(data, function(index, el) {
			          $("#search-restaurants").append('<option value='+el.id+'>'+el.nombre+'</option>');  

			        });
						}
					}
				});

			}
		}else{
			if(lista){
			toastr.info('Se estan buscando información, por favor tenga paciencia!.');
			$.ajax({
				url: "/safip/public/get/other/restaurants",
				type:"POST",
				data:{destinos:lista},
				success:function(data){
					console.log(data);
					if(data.length == ''){
						toastr.warning('No se encontro la información solicitada.!');

					}else{
						toastr.success('Excelente, se encontro la información solicitada.!');

						$.each(data, function(index, el) {
		          $("#search-restaurants").append('<option value='+el.id+'>'+el.nombre+'</option>');  

		        });
					}
				}
			});

			}
		}
	});
	/*saveActivity() {
            if (this.dataActivity.type == "servicio") {
                this.dataActivity.item_id = $("#search-activity > option:selected").val();
            } else if (this.dataActivity.type == "restaurante") {
                this.dataActivity.item_id = $("#search-restaurants > option:selected").val();
            }
            if (this.dataActivity.name == "" || this.dataActivity.type == "" || !this.dataActivity.item_id) {
                console.log(this.dataActivity.name);
                console.log(this.dataActivity.type);
                console.log(this.dataActivity.item_id);
                this.alert("Disculpe", "Debe LLenar Todos los Campo", "warning");
            } else {
                this.loading();
                urlActivity = this.route + "/save/activity/day/" + this.day.id;
                axios.post(urlActivity, { activity: this.dataActivity }).then(response => {
                    this.day.actividades.push(response.data);
                    /* this.dataActivity.code = ""; */
            /*        this.dataActivity.name = "";
                    this.dataActivity.type = "";
                    this.dataActivity.item_id = null;
                    swal.close();
                }).catch(error => {
                    console.log(error);
                });
            }
        },*/




























































































































































	/*searchFilterRestaurants() {
            var lista = $("#select_filter_restaurants").val();
            //console.log(lista)
            if (lista) {
                this.toastr_search_data_type('restaurante');
                axios.post(this.route + "/get/other/restaurants", { destinos: lista }).then(response => {
                    if (response.data.length > 0) {
                        this.toastr_data_found('restaurante');
                        //console.log(response.data);
                        $("#search-restaurants").remove("span");
                        this.restaurants = [];
                        this.restaurants = response.data;
                        $("#search-restaurants").select2();
                    } else {
                        $("#search-restaurants").remove("span");
                        this.restaurants = [];
                        $("#search-restaurants").select2();
                        this.toastr_data_not_found('restaurante');
                    }
                }).catch(error => {
                    console.log(error.response);
                    console.log(error.response.data);
                });
            } else {
                this.alert("Disculpe", "Seleccione al menos un destino para poder filtrar", "warning");
            }
        },*/
	/*function changeFilterServices() { // EVENTO QUE SE LANZA CUANDO CAMBIA EL TIPO DE FILTRO EN SERVICIOS [mismos/otros -> df mismos]
		var filterServices = false;
		console.log(filterServices);
    this.filterServices = !this.filterServices;
            $("#select_filter_services").children().remove();
            if (filterServices) {
                urlDetinies = this.route + "/get/other/destinies/" + paquete;
                console.log(urlDetinies);
                axios.get(urlDetinies).then(response => {
                    $("#search-activity").remove("span");
                    this.services = [];
                    this.destinies = response.data;
                    $("#search-activity").select2();
                }).catch(error => {
                    console.log(error);
                });
            } else {
                urlRest = this.route + "/tablero/Admin/Paso/3/Mis_Services/Paquete/" + paquete;
                axios.get(urlRest).then(response => {
                    $("#search-activity").remove("span");
                    this.services = [];
                    this.services = response.data;
                    $("#search-activity").select2();
                }).catch(error => {
                    console.log(error);
                });
            }
        }*/


});