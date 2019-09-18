// Start Vue Component
const cpnt1 = Vue.component('c_boletos_datatable',{
	template:"#c_boletos_datatable",
	props: ['c_boletos'],
	data: function() {
	    return {
			route: APP_URL,
			desde: cotizaciones.desde,
			block: false,

		    pageSize: 10,	// Cantidad de registros por vista
		    currentPage: 1, // Pagina Actual
		    totalPage: 0,	// Cantidad de Paginas totales
		    showUpto: 10,	// Cantidad de Reg que se van a mostrar a la der
			showFromto: 0,	// Cantidad de Reg que se van a mostrar a la izq
			c_boleto: [],

			// multiples
			multi_selected: [],
			index_multi_selected: [],

			search: '',
			abstractData: [],
	    }
    },
	computed: {
	    c_boletos_list() {
			this.totalPage = Math.ceil(this.c_boletos.length / this.pageSize);
	    	/*var list = this.c_boletos.slice(this.showFromto, this.showUpto);
	    	return list;*/

	    	let av 	= '';
	    	let d_c = '';
	    	let h_c = '';
	    	let ll  = '';

	    	let self = this
      		let search = self.search.toLowerCase()
	    	this.abstractData = self.c_boletos.filter(function (c_boleto){
	    		if(c_boleto.aviajes != null){
	    			av = c_boleto.aviajes.nombre;
	    		}
	    		if(c_boleto.d_ciudad_id != null){
	    			d_c = c_boleto.d_ciudad_id
	    		}
	    		if(c_boleto.h_ciudad_id != null){
	    			h_c = c_boleto.h_ciudad_id
	    		}
	    		if(c_boleto.llegada_at != null){
	    			ll = c_boleto.llegada_at
				}
				if(c_boleto.ida_vuelta == 0){
					tb = 'solo ida'
				} else {
					tb = 'ida y vuelta'
				}
				if(c_boleto.status == 1){
					eb = 'procesado'
				} else {
					eb = 'sin procesar'
				}
				if(c_boleto.observacion != null){
					ob = c_boleto.observacion
				} else {
					ob = ''
				}
				if(c_boleto.users != null){
					user_name = c_boleto.users.nombres
					user_lname = c_boleto.users.apellidos
				} else {
					user_name = ''
					user_lname = ''
				}
				
	    		return c_boleto.count.toString().indexOf(search) !== -1 || 
	    			av.toLowerCase().indexOf(search) !== -1 || 
	    			d_c.toLowerCase().indexOf(search) !== -1 || 
	    			h_c.toLowerCase().indexOf(search) !== -1 || 
	    			c_boleto.salida_at.toLowerCase().indexOf(search) !== -1 ||
					ll.toLowerCase().indexOf(search) !== -1 ||
					tb.toLowerCase().indexOf(search) !== -1 ||
					c_boleto.cantidad_pasajeros.toString().indexOf(search) !== -1 ||
					eb.toLowerCase().indexOf(search) !== -1 ||
					ob.toLowerCase().indexOf(search) !== -1 ||
					c_boleto.created_at.toLowerCase().indexOf(search) !== -1 ||
					user_name.toLowerCase().indexOf(search) !== -1 ||
					user_lname.toLowerCase().indexOf(search) !== -1 ||
					c_boleto.updated_at.toLowerCase().indexOf(search) !== -1
	    	}).slice(this.showFromto, this.showUpto);

	    	return this.abstractData;
	    }
	},
	methods: {
		alert_loader(text, icon, click, esc){
			swal({
                title: "Espere un momento!",
                text: text,
                icon: this.route + "/imagenes/"+icon+".gif",
                button: {
                    text: "Entiendo",
                    value: false,
                    closeModal: false,
                },
                closeOnClickOutside: click,
                closeOnEsc: esc,
				dangerMode: true,
            });
		},
		changeSelect:function(){
	    	this.showUpto = this.pageSize;
	    	this.currentPage = 1;
			this.showFromto = 0;
	    },
	    nextPage:function() {
	    	if (this.currentPage != this.totalPage){
				if(this.currentPage == this.totalPage-2){
					this.block = true;
				} else if(this.currentPage == this.totalPage-1){
					this.block = true;
				}
	    	    this.showFromto = (this.currentPage * this.pageSize) ;
	    	    this.currentPage =  this.currentPage + 1;
	    	    this.showUpto = (this.currentPage * this.pageSize);
	    	}
	    },
	    previousPage:function() {
	    	if (this.currentPage != 1){
	    	    this.showFromto = ((this.currentPage - 2) * this.pageSize) ;
	    	    this.currentPage =  this.currentPage - 1;
	    	    this.showUpto = (this.currentPage * this.pageSize);
	    	}
		},
		modalShow(id_modal, c_boleto){
			this.c_boleto = [];
			this.c_boleto = c_boleto;
			cotizaciones.c_boleto = c_boleto;
			$('#'+id_modal).modal('show');

			cotizaciones.aviaje_id 		= this.c_boleto.aviajes_id;
			cotizaciones.c_salida_id 	= this.c_boleto.d_ciudad_id;
			cotizaciones.c_llegada_id 	= this.c_boleto.h_ciudad_id;
			cotizaciones.pais_boleto_id = this.c_boleto.paises_id;
			cotizaciones.fecha_salida 	= this.c_boleto.salida_at;
			cotizaciones.fecha_retorno 	= this.c_boleto.llegada_at;
			cotizaciones.ida_v 			= this.c_boleto.ida_vuelta;
			cotizaciones.pasajeros 		= this.c_boleto.cantidad_pasajeros;
			cotizaciones.observacion 	= this.c_boleto.observacion;
		},
		validate(){
			this.index_multi_selected = [];
			if(this.multi_selected.length > 0){
				this.multi_selected.forEach(ms => {
					this.index_multi_selected.push({id:ms, index: $('#'+ms).val()});
				})
			}
			cotizaciones.multi_selected = this.multi_selected;
			cotizaciones.index_multi_selected = this.index_multi_selected;
			if(this.multi_selected.length >= 2){
				cotizaciones.btn_editar_multi = true;
			} else {
				cotizaciones.btn_editar_multi = false;
			}
		}
	},
});

Vue.component('c_paquetes_datatable',{
	template:"#c_paquetes_datatable",
	props: ['c_paquetes'],
	data: function() {
	    return {
            route: APP_URL,
		    pageSize: 10,
		    currentPage: 1,
		    totalPage: 0,
		    showUpto: 10,
			showFromto: 0,
			c_paquete: [],
	    }
    },
	computed: {
	    c_paquetes_list() {
	    	var list = this.c_paquetes.slice(this.showFromto, this.showUpto);
	    	this.totalPage = Math.ceil(this.c_paquetes.length / this.pageSize);
	    	return list;
	    }
	},
	methods: {
	    changeSelect:function(){
	    	this.showUpto = this.pageSize;
	    	this.currentPage = 1;
	    	this.showFromto = 0;
	    },
	    nextPage:function() {
	    	if (this.currentPage != this.totalPage){
	    	    this.showFromto = (this.currentPage * this.pageSize) ;
	    	    this.currentPage =  this.currentPage + 1;
	    	    this.showUpto = (this.currentPage * this.pageSize);
	    	}
	    },
	    previousPage:function() {
	    	if (this.currentPage != 1){
	    	    this.showFromto = ((this.currentPage - 2) * this.pageSize) ;
	    	    this.currentPage =  this.currentPage - 1;
	    	    this.showUpto = (this.currentPage * this.pageSize);
	    	}
	    },
	    modalShow(id_modal, c_paquete){
			this.c_paquete = [];
			this.c_paquete = c_paquete;
			cotizaciones.c_paquete = c_paquete;
			$("#cot_paquete_id").val(this.c_paquete.id);
			$("#vendedor").val(this.c_paquete.id);
			$('#'+id_modal).modal('show');


			cotizaciones.agencia_id 	= this.c_paquete.agencia_id;
			cotizaciones.destino_id 	= this.c_paquete.destino_id;
			cotizaciones.pais_id 		= this.c_paquete.pais_id;
			cotizaciones.nacionalidad 	= this.c_paquete.nacionalidad;
			cotizaciones.fecha_salida 	= this.c_paquete.fecha_salida;
			cotizaciones.fecha_retorno 	= this.c_paquete.fecha_retorno;
			cotizaciones.pasajeros 		= this.c_paquete.pasajero;
			cotizaciones.observacion 	= this.c_paquete.observacion;
		},
		anular_c_paquete(c_paquete_id){
			swal({
				title: 'Atención!.',
				text: '¿Está seguro de querer anular esta cotización?.\n Tenga en cuenta que toda la INFORMACIÓN asociada a esta cotización SE PERDERÁ!.',
				icon: "warning",
				buttons: {
					cancel: 'No',
					confirm: 'Si'
				},
				closeOnClickOutside: false,
                closeOnEsc: false,
				dangerMode: true,
			}).then(response => {
				if(response){
					let url = this.route+'/tablero/Paquetes/Cotizaciones/destroy/'+c_paquete_id;
					axios.get(url).then(response => {
						cotizaciones.alert_success('Cotización anulada exitosamente!.', true, true, 4000);
						cotizaciones.co_paquetes();
					}).catch(error => {
						console.log(error);
						console.log(error.response);
					});
				}
			});
		}
	},
});
// End Vue Component
const cotizaciones = new Vue({
    el: '#cotizaciones',
    created() {
    	this.set_dft_date()
    	this.pre_load_cboletos()
		this.co_paquetes()
		this.get_data_edit_c_paquete()
		setTimeout(() => {
			//console.clear()
		}, 800);
    },
    data: {
		route: APP_URL,
		limiter: 30,
		desde: 999999999,

		// Basic Data
		gdate: new Date(),
		actual_date: '',
		fecha_d: '',
		fecha_h: '',

        c_boletos: [],
		c_paquetes: [],
		c_boleto: [],
		c_paquete: [],
		agencias: [],
		destinos: [],
		paises: [],
		ciudades: [],

		// data selected
		agencia_id: 0,
		aviaje_id: 0,
		destino_id: 0,
		pais_id: 0,
		pais_boleto_id: 0,
		nacionalidad: '',
		fecha_salida: '',
		fecha_retorno: '',
		pasajeros: 0,
		observacion: '',

		c_salida_id: '',
		c_llegada_id: '',
		ida_v: 0,

		// multiples
		multi_selected: [],
		btn_editar_multi: false,
		index_multi_selected: [],
    },
    methods: {
        alert_loader(options){
			swal({
                title: "Espere un momento!",
                text: options.text,
                icon: this.route + "/imagenes/"+options.icon+".gif",
                button: {
                    text: "Entiendo",
                    value: false,
                    closeModal: false,
                },
                closeOnClickOutside: options.click,
                closeOnEsc: options.esc,
				dangerMode: true,
				timer: options.time,
            });
        },
        alert_success(options){
            // text, click, esc, time = false
			swal({
				title: "Excelente!",
				text: options.text,
				icon: "success",
				button: {
					text: "Ok"
				},
				dangerMode: true,
				closeOnClickOutside: options.click,
				closeOnEsc: options.esc,
				timer: options.time,
			});
		},
		set_dft_date(){
			let y = this.gdate.getFullYear()
			let m = this.gdate.getMonth() + 1
			let d = this.gdate.getDate()

			if(m < 10) m = '0'+m;
			if(d < 10) d = '0'+d;
			let date = y + "-" + m + "-" + d;

			this.actual_date = date /*'2018-12-20'*/
			this.fecha_d = date /*'2019-01-11'*/
			this.fecha_h = date /*'2019-01-11'*/

			//console.log(date)
		},
		pre_load_cboletos(){
			//this.co_boletos()
			this.alert_loader({
                text:   'Se está buscando cotización de boletos',
                icon:   'loader',
                click:  false,
                esc:    false,
                time:   false,
            });
			this.load_cboletos()
		},
		load_cboletos(){
			let url_get_inRange = this.route + "/tablero/cotizaciones/boletos/getInRange/" + this.fecha_d + "/" + this.fecha_h
			axios.get(url_get_inRange).then(response => {
				//console.log(response.data)
				this.c_boletos = response.data
				swal.close()
			}).catch(error => {
				console.log(error)
				console.log(error.response)
				if(error.response.status == '500') this.load_cboletos();
			})
		},
		search_filter_cboletos(){
			let url_get_count_data_to_filter = this.route + "/tablero/cotizaciones/getCountDataFilter/" + this.fecha_d + "/" + this.fecha_h;
			axios.get(url_get_count_data_to_filter).then(response => {
				//console.log('cantidad de registros: ' + response.data)
				if (parseInt(response.data) > 2000) {
					swal({
                	    title: "Disculpe!.",
                	    text: "¿Está seguro de que desea cargar estos "+ response.data +" registros contenidos en el rango de fechas seleccionadas?.\n Mientas más grande sea la cantidad de registros mayor será el tiempo que tomará mostrarlos!.",
                	    icon: "warning",
                	    buttons: {
                	        cancel: "cancelar",
                	        confirm: {
                	            text: "Continuar",
                	            value: true,
                	        },
                	    },
                	    dangerMode: true,
					    closeOnClickOutside: false,
					    closeOnEsc: false,
					    timer: 20000,
                	}).then(acepted => {
                	    if(acepted){
                	    	this.pre_load_cboletos()
                	    }
                	})
				} else if(parseInt(response.data) <= 2000) {
					this.pre_load_cboletos()
				}
			})
		},
        co_paquetes(){
            let url = this.route+'/tablero/cotizaciones/get_paquetes';
            axios.get(url).then(response => {
                this.c_paquetes = response.data;
            }).catch(error => {
                swal.close();
                console.log(error);
                console.log(error.response);
                if(error.response.status == '500') this.co_paquetes();
            });
        },
		modalHide(id_modal){
			$('#'+id_modal).modal('hide');
		},
		get_data_edit_c_paquete(){
			let url = this.route+'/tablero/cotizaciones/get_data_edit_Cpaquete';
			axios.get(url).then(response => {
				//console.log(response.data);
				this.agencias = response.data.agencias;
				this.destinos = response.data.destinos;
				this.paises = response.data.paises;
				this.ciudades = response.data.ciudades;

				// selects de edit c_paquete
				$("select[name='sl_agencia']").select2().on('select2:select', () => {
					var val = $("select[name='sl_agencia']").select2('data');
					this.agencia_id = val[0].id;
				});
				$("select[name='sl_pais']").select2().on('select2:select', () => {
					var val = $("select[name='sl_pais']").select2('data');
					this.pais_id = val[0].id;
				});
				$("select[name='sl_destino']").select2().on('select2:select', () => {
					var val = $("select[name='sl_destino']").select2('data');
					this.destino_id = val[0].id;
				});
				$("select[name='nacionalidad']").select2().on('select2:select', () => {
					var val = $("select[name='nacionalidad']").select2('data');
					this.nacionalidad = val[0].id;
				});

				// selects de edit c_boleto
				$("select[name='sl_aviaje']").select2().on('select2:select', () => {
					var val = $("select[name='sl_aviaje']").select2('data');
					this.aviaje_id = val[0].id;
				});
				$("select[name='sl_pais_boleto']").select2().on('select2:select', () => {
					var val = $("select[name='sl_pais_boleto']").select2('data');
					this.pais_boleto_id = val[0].id;
				});

				$("select[name='sl_c_salida']").select2().on('select2:select', () => {
					var val = $("select[name='sl_c_salida']").select2('data');
					this.c_salida_id = val[0].id;
				});
				$("select[name='sl_c_llegada']").select2().on('select2:select', () => {
					var val = $("select[name='sl_c_llegada']").select2('data');
					this.c_llegada_id = val[0].id;
				});
			}).catch(error => {
				console.log(error);
				console.log(error.response);
				if(error.response.status == '500') this.get_data_edit_c_paquete();
			});
		},
		update_c_paquete(){
			swal({
				title: 'Atención!.',
				text: '¿Está seguro de querer editar esta cotización?.',
				icon: "warning",
				buttons: {
					cancel: 'No',
					confirm: 'Si'
				},
				closeOnClickOutside: false,
                closeOnEsc: false,
				dangerMode: true,
			}).then(response => {
				if(response){
					this.alert_loader({
            		    text:   'Enviando datos.',
            		    icon:   'loader',
            		    click:  false,
            		    esc:    false,
            		    time:   false,
            		});
					let url = this.route+'/tablero/cotizaciones/paquetes/update';
					axios.post(url, {
						id_cotizacion: 	this.c_paquete.id,
						agencia_id: 	this.agencia_id,
						pais_id: 		this.pais_id,
						destino_id: 	this.destino_id,
						nacionalidad: 	this.nacionalidad,
						fecha_salida: 	this.fecha_salida,
						fecha_retorno: 	this.fecha_retorno,
						cantidad: 		this.pasajeros,
						nacionalidad: 	this.nacionalidad,
						observacion: 	this.observacion,
					}).then(response => {
						this.alert_success({
                 			text:   'Datos de Cotización actualizados exitosamente!.',
            		    	click:  true,
            		    	esc:    true,
            		    	time:   4000,
                 		});
						this.co_paquetes();
						this.modalHide('modalEditarCPaquete');
					}).catch(error => {
						console.log(error);
						console.log(error.response);
					});
				}
			})
		},
		update_c_boleto(){
			swal({
				title: 'Atención!.',
				text: '¿Está seguro de querer editar esta cotización?.',
				icon: "warning",
				buttons: {
					cancel: 'No',
					confirm: 'Si'
				},
				closeOnClickOutside: false,
                closeOnEsc: false,
				dangerMode: true,
			}).then(response => {
				if(response){
					this.alert_loader({
            		    text:   'Enviando datos.',
            		    icon:   'loader',
            		    click:  false,
            		    esc:    false,
            		    time:   false,
            		});
					let url = this.route+'/tablero/cotizaciones/boletos/update';
					axios.post(url,{
						id_cotizacion: this.c_boleto.id,
						aviaje: 	this.aviaje_id,
						csalida: 	this.fecha_salida,
						cllegada: 	this.fecha_retorno,
						salida: 	this.c_salida_id,
						llegada: 	this.c_llegada_id,
						pais: 		this.pais_boleto_id,
						idavuelta: 	this.ida_v,
						cpasajero: 	this.pasajeros,
						observacion: this.observacion,
					}).then(response => {
						let blt = response.data;
						$('#aviaje_'+blt.id).text(blt.aviajes.nombre)
						$('#c_salida_'+blt.id).text(blt.d_ciudad_id)
						$('#c_llegada_'+blt.id).text(blt.h_ciudad_id)
						$('#fecha_salida_'+blt.id).text(blt.salida_at)
						$('#fecha_retorno_'+blt.id).text(blt.llegada_at)
						if(blt.ida_vuelta == 0) {
							$('#s_ida_'+blt.id).text("Solo Ida");
							$('#ida_v_'+blt.id).text("Solo Ida");
						} else {
							$('#s_ida_'+blt.id).text("Ida y Vuelta");
							$('#ida_v_'+blt.id).text("Ida y Vuelta");
						}
						$('#pasajeros_'+blt.id).text(blt.cantidad_pasajeros)
						$('#observacion_'+blt.id).text(blt.observacion)
						this.alert_success({
                 			text:   'Datos de Cotización actualizados exitosamente!.',
            		    	click:  true,
            		    	esc:    true,
            		    	time:   4000,
                 		});
						this.modalHide('modalEditarCBoleto');
					}).catch(error => {
						console.log(error);
						console.log(error.response);
					});
				}
			});
		},
		edit_multi(){
			$('#modalEditarCBoletos').modal('show');
		},
		clean_multi(){
			this.multi_selected = [];
			this.index_multi_selected = [];
			this.aviaje_id = 0;
			this.c_salida_id = '';
			this.llegada_id = '';
			this.ida_v = 0;
			this.fecha_salida = '';
			this.fecha_retorno = '';
			this.pasajeros = 0;
			this.observacion = '';
			this.btn_editar_multi = false;
			$(".check_cot").removeAttr('checked');
			this.$root.$children[0].multi_selected = [];
			this.$root.$children[1].multi_selected = [];
			this.$root.$children[0].index_multi_selected = [];
			this.$root.$children[1].index_multi_selected = [];
		},
		update_c_boletos(){
			swal({
				title: 'Atención!.',
				text: '¿Está seguro de querer editar estas cotizaciones?.',
				icon: "warning",
				buttons: {
					cancel: 'No',
					confirm: 'Si'
				},
				closeOnClickOutside: false,
                closeOnEsc: false,
				dangerMode: true,
			}).then(response => {
				if(response){
					this.alert_loader({
            		    text:   'Enviando datos.',
            		    icon:   'loader',
            		    click:  false,
            		    esc:    false,
            		    time:   false,
            		});
					let url = this.route+'/tablero/cotizaciones/boletos/update/multi';
					axios.post(url,{
						cotizaciones: this.multi_selected,
						aviaje: 	this.aviaje_id,
						salida: 	this.c_salida_id,
						llegada: 	this.c_llegada_id,
						idavuelta: 	this.ida_v,
						csalida: 	this.fecha_salida,
						cllegada: 	this.fecha_retorno,
						/* pais: 		this.pais_boleto_id, */
						cpasajero: 	this.pasajeros,
						observacion: this.observacion,
					}).then(response => {
						//console.log(response.data);
						response.data.forEach(ctbts => {
							this.index_multi_selected.forEach(ind => {
								if(ctbts.id == ind.id){
									$('#aviaje_'+ctbts.id).text(ctbts.aviajes.nombre)
									$('#c_salida_'+ctbts.id).text(ctbts.d_ciudad_id)
									$('#c_llegada_'+ctbts.id).text(ctbts.h_ciudad_id)
									$('#fecha_salida_'+ctbts.id).text(ctbts.salida_at)
									$('#fecha_retorno_'+ctbts.id).text(ctbts.llegada_at)
									if(ctbts.ida_vuelta == 0) {
										$('#s_ida_'+ctbts.id).text("Solo Ida");
										$('#ida_v_'+ctbts.id).text("Solo Ida");
									} else {
										$('#s_ida_'+ctbts.id).text("Ida y Vuelta");
										$('#ida_v_'+ctbts.id).text("Ida y Vuelta");
									}
									$('#pasajeros_'+ctbts.id).text(ctbts.cantidad_pasajeros)
									$('#observacion_'+ctbts.id).text(ctbts.observacion)
									this.c_boletos[ind.index] = ctbts;
								}
							});
						});
						this.alert_success({
                 			text:   'Datos de Cotización actualizados exitosamente!.',
            		    	click:  true,
            		    	esc:    true,
            		    	time:   4000,
                 		});
						this.modalHide('modalEditarCBoletos');
						this.clean_multi();
					}).catch(error => {
						console.log(error);
						console.log(error.response);
					});
				}
			});
		},
    }
});