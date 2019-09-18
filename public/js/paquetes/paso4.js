const paso4 = new Vue({
	el: '#main-paso4',
	created() {
		this.pre_cargar_data_base();
		this.paquete_id = $('#paquete_id').val();
	},
	data: {
		paquete_id: 0,
		new_dato: '',
		//data base
		data_base_incluidos: [],
		data_base_noincluidos: [],
		data_base_llevars: [],
		data_base_importantes: [],
		data_base_politcareservas: [],
		data_base_politicatarifas: [],
		data_base_fechas: [],
		data_base_responsabilidades: [],
		// resto de la data
		paquete_act: [],
		paquetes: [],
		name_paquete: '',
		paquete: [],
		incluidos: [],
		noincluidos: [],
		llevars: [],
		importantes: [],
		politcareservas: [],
		politicatarifas: [],
		fechas: [],
		responsabilidades: [],
	},
	methods: {
		pre_cargar_data_base(){
			/* var lanzador = setInterval(function(){
				paso4.cargar_data_base();
			}, 2000); */
			lanzador_pre_carga = setTimeout(function() {
				paso4.cargar_data_base();
			}, 500);
		},
		cargar_data_base(){
			var url = APP_URL+'/tablero/Admin/Paso/4/cargar/data/base/'+this.paquete_id;

			axios.get(url).then(response => {
				//console.log(response.data);
				this.paquete_act = response.data;
				this.set_data_base();
			}).catch(error => {
				console.log(error.response);
			});
		},
		set_data_base(){
			this.clean_data_base();
			if(this.paquete_act.datos.length > 0){
				this.paquete_act.datos.forEach(dato => {
					if(dato.tipo == 'incluido') this.data_base_incluidos.push(dato);
					else if(dato.tipo == 'noincluido') this.data_base_noincluidos.push(dato);
					else if(dato.tipo == 'llevar') this.data_base_llevars.push(dato);
					else if(dato.tipo == 'importante') this.data_base_importantes.push(dato);
					else if(dato.tipo == 'politcareserva') this.data_base_politcareservas.push(dato);
					else if(dato.tipo == 'politicatarifa') this.data_base_politicatarifas.push(dato);
					else if(dato.tipo == 'fechas') this.data_base_fechas.push(dato);
					else this.data_base_responsabilidades.push(dato);
				});
			}
		},
		clean_data_base(){
			this.data_base_fechas 				= [];
			this.data_base_llevars 				= [];
			this.data_base_incluidos 			= [];
			this.data_base_noincluidos 			= [];
			this.data_base_importantes			= [];
			this.data_base_politcareservas 		= [];
			this.data_base_politicatarifas 		= [];
			this.data_base_responsabilidades 	= [];
		},
		clean_data_charged(){
			this.fechas 			= [];
			this.paquete 			= [];
			this.llevars 			= [];
			this.incluidos 			= [];
			this.noincluidos 		= [];
			this.importantes		= [];
			this.politcareservas 	= [];
			this.politicatarifas 	= [];
			this.responsabilidades 	= [];
		},
		crear_dato(){
			var url = APP_URL+'/tablero/Admin/Paso/4/Agregar/Dato/'+this.paquete_id;
			var new_tipo_dato = $('select[name=tipo_dato]').val();
			if(new_tipo_dato != ''){
				if(this.new_dato != ''){
					axios.post(url, {
						texto_dato: this.new_dato,
						tipo_dato: new_tipo_dato
					}).then(response => {
						this.cargar_data_base();
						toastr.success('Dato creado con exito!.');
						this.new_dato = '';
					}).catch(error => {
						console.log(error.response);
					});
				} else {
					toastr.warning('El campo de texto no puede estar vacio!.');
				}
			} else {
				toastr.warning('Debe seleccionar un tipo de dato!.');
			}
		},
		editar_dato(dato_id){
			var data_text = $('#'+dato_id).val();
			if(data_text !== ""){
				var url = APP_URL+'/tablero/Admin/Paso/4/Editar/Dato/'+dato_id;
				axios.post(url, {texto:data_text}).then(response => {
					this.cargar_data_base();
					toastr.success('Dato actualizado con exito!.');
				}).catch(error => {
					console.log(error.response);
				});
			} else {
				toastr.warning('El campo del dato a editar no puede estar vacio!.');
			}
		},
		eliminar_dato(dato_id){
			var url = APP_URL+'/tablero/Admin/Paso/4/Eliminar/Dato/'+dato_id;
			axios.delete(url, {dato_id:dato_id}).then(response => {
				this.cargar_data_base();
				toastr.success('Dato Eliminado con exito!.');
			}).catch(error => {
				console.log(error.response);
			});
		},
		openModal(paquete_act){
			this.paquete_act = paquete_act;
			$("#datos_paquete").fadeIn(300);
		},
		closeModal(){
			this.clean_data_charged();
			this.name_paquete = '';
			this.paquetes = [];
			$("#datos_paquete").fadeOut(300);
		},
		getPaquete(){
			var url = APP_URL+'/tablero/Admin/Paso/4/cargar/datos';
			axios.post(url, {
				name_paquete: this.name_paquete,
				id_paquete_act: this.paquete_act.id
			}).then(response => {
				this.paquetes = response.data;
				if(this.paquetes.length > 0){
					if(this.paquetes.length > 1) toastr.info('Paquetes encontrados!.');
					else toastr.info('Paquete encontrado!.');
				}
				else toastr.warning('Ningun paquete encontrado!.');
				//console.log(response.data);
			}).catch(error => {
				console.log(error.response);
			});
		},
		buscar_paquete(){
			if(this.name_paquete !== ''){
				this.clean_data_charged();
				this.getPaquete();
			} else {
				toastr.warning('El nombre del paquete no puede estar vacio!.');
			}
		},
		select_paquete(paquete){
			this.paquete = paquete;
			if(this.paquete.datos.length > 0){
				this.paquete.datos.forEach(dato => {
					if(dato.tipo == 'incluido') this.incluidos.push(dato);
					else if(dato.tipo == 'noincluido') this.noincluidos.push(dato);
					else if(dato.tipo == 'llevar') this.llevars.push(dato);
					else if(dato.tipo == 'importante') this.importantes.push(dato);
					else if(dato.tipo == 'politcareserva') this.politcareservas.push(dato);
					else if(dato.tipo == 'politicatarifa') this.politicatarifas.push(dato);
					else if(dato.tipo == 'fechas') this.fechas.push(dato);
					else this.responsabilidades.push(dato);
				});
			}
		},
		add_datos_to_paquete(tipo){
			var url = APP_URL+'/tablero/Admin/Paso/4/agregar/datos/'+tipo+'/paquete/'+this.paquete.id+'/paquete_act/'+this.paquete_act.id;
			axios.get(url).then(response => {
				toastr.success('Datos agregados con exito!.');
				if(tipo == 'incluido') this.incluidos = [];
				else if(tipo == 'noincluido') this.noincluidos = [];
				else if(tipo == 'llevar') this.llevars = [];
				else if(tipo == 'importante') this.importantes = [];
				else if(tipo == 'politcareserva') this.politcareservas = [];
				else if(tipo == 'politicatarifa') this.politicatarifas = [];
				else if(tipo == 'fechas') this.fechas = [];
				else this.responsabilidades = [];
				this.cargar_data_base();
			}).catch(error => {
				console.log(error.response);
			});
		}
	}
});
