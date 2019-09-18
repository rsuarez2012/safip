const cpnt1 = Vue.component('v_boletos_datatable',{
	template:"#v_boletos_datatable",
	props: ['v_boletos'],
	data: function() {
	    return {
			route: APP_URL,
			block: false,

		    pageSize: 10,	// Cantidad de registros por vista
		    currentPage: 1, // Pagina Actual
		    totalPage: 0,	// Cantidad de Paginas totales
		    showUpto: 10,	// Cantidad de Reg que se van a mostrar a la der
			showFromto: 0,	// Cantidad de Reg que se van a mostrar a la izq
			v_boleto: [],

			// multiples
			sm_v_boletos: [],

			search: '',

			abstractData: [],
	    }
    },
	computed: {
	    v_boletos_list() {
	    	//console.log(this.v_boletos)
	    	//var list = this.v_boletos.slice(this.showFromto, this.showUpto);
			this.totalPage = Math.ceil(this.v_boletos.length / this.pageSize);
	    	let self = this
      		let search = self.search.toLowerCase()
	    	this.abstractData = self.v_boletos.filter(function (v_boleto){
	    		if(v_boleto.venta_boleto_id != null){
	    			v_b_id = v_boleto.venta_boleto_id;
	    		} else {
	    			v_b_id = '';
	    		}
	    		if(v_boleto.codigo != null){
	    			cd = v_boleto.codigo;
	    		} else {
	    			cd = '';
	    		}
	    		if(v_boleto.cliente_id != null){
	    			cl = v_boleto.cliente_id;
	    		} else {
	    			cl = '';
	    		}
	    		if(v_boleto.nombre_cliente != null){
	    			cli = v_boleto.nombre_cliente;
	    		} else {
	    			cli = '';
	    		}
	    		if(v_boleto.laereas != null){
	    			lae = v_boleto.laereas.nombre;
	    		} else {
	    			lae = '';
	    		}
	    		if(v_boleto.ruta != null){
	    			ruta = v_boleto.ruta;
	    		} else {
	    			ruta = '';
	    		}
	    		if(v_boleto.nro_ticket != null){
	    			ticket = v_boleto.nro_ticket;
	    		} else {
	    			ticket = '';
	    		}
	    		if(v_boleto.nro_ticket != null){
	    			ticket = v_boleto.nro_ticket;
	    		} else {
	    			ticket = '';
	    		}
	    		if(v_boleto.aviajes != null){
	    			av = v_boleto.aviajes;
	    		} else {
	    			av = '';
	    		}
	    		if(v_boleto.users != null){
	    			nom = v_boleto.users.nombre;
	    		} else {
	    			nom = '';
	    		}
	    		if(v_boleto.users != null){
	    			nom = v_boleto.users.nombres;
	    			ape = v_boleto.users.apellidos;
	    		} else {
	    			nom = '';
	    			ape = '';
	    		}
	    		if(v_boleto.neto != null){
	    			neto = v_boleto.neto;
	    		} else {
	    			neto = '';
	    		}
	    		if(v_boleto.comision_agencia != null){
	    			comi = v_boleto.comision_agencia;
	    		} else {
	    			comi = '';
	    		}
	    		if(v_boleto.total != null){
	    			total = v_boleto.total;
	    		} else {
	    			total = '';
	    		}
	    		if(v_boleto.tipop != null){
	    			pago = v_boleto.tipop.pago;
	    		} else {
	    			pago = '';
	    		}
	    		if(v_boleto.tarifa_fee != null){
	    			tarifa = v_boleto.tarifa_fee;
	    		} else {
	    			tarifa = '';
	    		}

	    		return v_boleto.id.toString().indexOf(search) !== -1 ||
	    				v_b_id.toString().indexOf(search) !== -1 ||
	    				cd.toLowerCase().indexOf(search) !== -1 ||
	    				cl.toString().toLowerCase().indexOf(search) !== -1 ||
	    				cli.toLowerCase().indexOf(search) !== -1 ||
	    				lae.toLowerCase().indexOf(search) !== -1 ||
	    				ruta.toLowerCase().indexOf(search) !== -1 ||
	    				ticket.toString().indexOf(search) !== -1 ||
	    				av.toLowerCase().indexOf(search) !== -1 ||
	    				nom.toLowerCase().indexOf(search) !== -1 ||
	    				ape.toLowerCase().indexOf(search) !== -1 ||
	    				neto.toString().indexOf(search) !== -1 ||
	    				comi.toString().indexOf(search) !== -1 ||
	    				total.toString().indexOf(search) !== -1 ||
	    				pago.toLowerCase().indexOf(search) !== -1 ||
	    				tarifa.toString().indexOf(search) !== -1
	    	}).slice(this.showFromto, this.showUpto)
	    	
	    	//console.log(this.abstractData)
	    	var fc = '';
	    	var hr = '';
	    	var f_d = '';
	    	this.abstractData.forEach(obj => {
	    		setTimeout(() => {
	    			fc = obj.created_at.split(' ')[0]
	    			hr = obj.created_at.split(' ')[1]

	    			$("#tr_padre_"+obj.id).css('display', '')

	    			//f_d = fc.split('-')[2]+'/'+fc.split('-')[1]+'/'+fc.split('-')[0]
        			$("#td_fecha_registro_" + obj.id).text(this.setformatDate(obj.created_at))
	    		}, 1000)
	    	})
	    	return this.abstractData;
	    },
	},
	methods: {
		setformatDate(datetime){
			//console.log(datetime)
			let date = datetime.split(' ')[0]
			let time = datetime.split(' ')[1]
			let ar_time = time.split(':')
			let hour = 0
			let tz = 'AM'

			if(date.split('-')[1] != undefined){
				dateFormated = date.split('-')[2]+'/'+date.split('-')[1]+'/'+date.split('-')[0];
			} else {
				dateFormated = date;
			}

			//console.log(dateFormated)

			if(ar_time[0] > 12){
				if(ar_time[0] == 13){
					hour = 1
				} else if (ar_time[0] == 14) {
					hour = 2
				} else if (ar_time[0] == 15) {
					hour = 3
				} else if (ar_time[0] == 16) {
					hour = 4
				} else if (ar_time[0] == 17) {
					hour = 5
				} else if (ar_time[0] == 18) {
					hour = 6
				} else if (ar_time[0] == 19) {
					hour = 7
				} else if (ar_time[0] == 20) {
					hour = 8
				} else if (ar_time[0] == 21) {
					hour = 9
				} else if (ar_time[0] == 22) {
					hour = 10
				} else if (ar_time[0] == 23) {
					hour = 11
				} 
				tz = 'PM'
			} else {
				if(ar_time[0] > 0){
					hour = ar_time[0]
					tz = 'AM'
				}
				
			}

			let datetimeFormated = dateFormated + ' ' + hour+':'+ar_time[1] + ' '+tz; 
    		return datetimeFormated;
    	},
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
		validate_sm(){
			if(this.sm_v_boletos.length >= 2){
        	    venta_boletos.exe_edit_multi = 2
        	} else if( this.sm_v_boletos.length == 1){
        	    venta_boletos.exe_edit_multi = 1
        	}else {
        	    venta_boletos.exe_edit_multi = 0
        	}
        	venta_boletos.sm_v_boletos = this.sm_v_boletos
        },
	    changeSelect:function(){
	    	this.showUpto = this.pageSize;
	    	this.currentPage = 1;
			this.showFromto = 0;
			/*if(Math.ceil(this.v_boletos.length / this.pageSize) == 1){
				this.ve_boletos(this.pageSize);
			}*/

			venta_boletos.showFromto = this.showFromto
	    	venta_boletos.showUpto   = this.showUpto
	    },
	    nextPage:function() {
	    	if (this.currentPage != this.totalPage){
				if(this.currentPage == this.totalPage-2){
					this.block = true;
					/*this.ve_boletos(this.pageSize);*/
				} else if(this.currentPage == this.totalPage-1){
					this.block = true;
					/*this.ve_boletos(this.pageSize * 2);*/
				}
	    	    this.showFromto = (this.currentPage * this.pageSize) ;
	    	    this.currentPage =  this.currentPage + 1;
	    	    this.showUpto = (this.currentPage * this.pageSize);

	    	    venta_boletos.showFromto = this.showFromto
	    	    venta_boletos.showUpto   = this.showUpto
	    	}
	    },
	    previousPage:function() {
	    	if (this.currentPage != 1){
	    	    this.showFromto = ((this.currentPage - 2) * this.pageSize) ;
	    	    this.currentPage =  this.currentPage - 1;
	    	    this.showUpto = (this.currentPage * this.pageSize);

	    	    venta_boletos.showFromto = this.showFromto
	    	    venta_boletos.showUpto   = this.showUpto
	    	}
		},
		showModal(id, v_boleto, tipo_modal, index){
			this.v_boleto = v_boleto
			venta_boletos.showModal(id, v_boleto, tipo_modal, index)
		},
		hideModal(id){
			$("#"+id).modal('hide')
		},
    	printPDF(v_boleto){
    		swal({
                title: "Disculpe!.",
               	text: "¿Desea Generar PDF del Boleto Nº "+v_boleto.nro_ticket+"?",
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
	    		timer: 10000,
            }).then(acepted => {
                if(acepted){
                	window.location.href = this.route + "/tablero/ventaboletos/admin/pdf/" + v_boleto.nro_ticket;
                }
            });
    	},
    	anularTicket(v_boleto){
    		swal({
    			title: "Disculpe!.",
    			text: "¿Está seguro de que desea anular esta venta de boleto?.",
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
    			timer: 10000,
    		}).then(acepted => {
    			if(acepted){
    				let url_anular_ticket = this.route + '/tablero/ventaboletos/anularTicket/' + v_boleto.id
    				this.alert_loader({
            		    text:   'Se está anulando la venta de boleto',
            		    icon:   'loader',
            		    click:  false,
            		    esc:    false,
            		    time:   false,
            		});
    				axios.post(url_anular_ticket, {boleto: v_boleto}).then(response => {
    					swal.close()
    					toastr.success("Venta anulada con exito!", "Excelente!.")
    					$('#tr_padre_'+v_boleto.id).remove()
    				}).catch(error => {
    					console.log(error)
    					console.log(error.response)
    				})
    			}
    		})
    	},
    	previewDocumento(codigo){
    		toastr.info("creando vista previa del documento de cobranza","Espere")
			let url_get_document =this.route+ "/documento/cobranza/"+codigo+"/"+"preview" 
    		axios.get(url_get_document).then(response=>{
    			$("#modalPreviewDocumento").fadeIn(300)
    			this.$root.boletos_documento    = response.data.boletos
    			this.$root.cotizacion_documento = response.data.cotizacion
    			this.$root.pagado_documento     = response.data.pagado
    			this.$root.cliente_documento    = response.data.cliente
    		}).catch(errors=>{
    			console.log(errors)
    		})
    	},
	},
});

const venta_boletos = new Vue({
	el: '#venta_boletos',
	created(){
		this.set_dft_date()
		this.pre_load_vboletos()
		setTimeout(() => {
            //console.clear()
        }, 800);
	},
	data: {
		route: APP_URL,
		gdate: new Date(),
		actual_date: '',
		fecha_d: '',
		fecha_h: '',
		v_boletos: [],
		v_boleto: [],
		vendedores: [],
		iva: 0,
		//data doc cobranza
		boletos_documento:[],
		cotizacion_documento:[],
		soles_documento:0,
		observacion_documento:"- Vuelo Nacionales, presentarse 2 horas antes de la salida.\n"+ 
                  			  "- Vuelos Internacionales presentarse 3 horas antes de la salida.\n"+
                  			  "- Tarifas sujetas a restricciones según tarifa.\n"+
                              "- Consultar cambios.\n"+
                              "- NO REEMBOLSABLE.\n"+
                              "- SOLO ES VALIDO CON FIRMA Y SELLO DE LA AGENCIA.\n",
		cliente_documento:null,
		pagado_documento:0,
		abstractData: [],
		showFromto: 0,
		showUpto: 10,

		// Data Edit Multiple
		sm_v_boletos: [],
		exe_edit_multi: 0,
		m_tipo_pago: 0,
		m_aviajes: 0,

		// Data Filtro General
		filter_conso: [],
		filter_linea_aerea: [],
		filter_agencia_viaje: [],
		filter_vendedores: [],
		filter_tipo_pago: 0,
		filter_pasajero: '',

		// Data Select in Modal Editar Ticket
		tipo_pagos: [],
		aviajes: [],
		laereas: [],
		consolidadores: [],

		// Data Fecha Registro
		new_fecha_registro: '',
		exe_new_fecha_reg: false,
		ar_tickets_with_fecha_editada: [],

		// Data Edit Ticket
		comision_general_agencia: 0,
		ticket: {
			id: 0,
			index: 0,
			fecha: '',
			cliente: {
				dni: 0,
				nombre: '', 
			},
			nro: '',
			nro_operacion: null,
			neto: 0,
			tarifa: 0,
			exist_percent: false,
			percent_comi_agency: 0,
			comision_agencia: 0,
			igv: 0,
			total: 0,
			pago_consolidador: 0,
			tarifa_fee: 0,
			utilidad: 0,
			incentivo: 0,

			tipop: {
				id: 0,
				pago: '',
			},
			aviajes: '',
			laerea: {
				id: 0,
				nombre: '',
			},
			consolidador: {
				id: 0,
				nombre: '',
			},
		},
		ver_nro_operacion: false,
		edit_nro_ope: false,
	},
	computed:{
		total_valor_unitario(){
	    	let sum_tf = 0
			this.$root.boletos_documento.forEach(function (boleto){
				sum_tf += boleto.tarifa_fee
			})
			return sum_tf
		},
		
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

			this.actual_date = date /*'2018-12-20'*/ // > 30
			this.fecha_d = date /*'2019-03-01'*/
			this.fecha_h = date /*'2019-03-01'*/

			//console.log(date)
		},
		set_ar_tickets(){
			if(this.ar_tickets_with_fecha_editada.length > 0){
				this.ar_tickets_with_fecha_editada.forEach(el => {
					$("#tr_padre_"+el.id).css('display', '')
				})
				//this.ar_tickets_with_fecha_editada = []
				this.ar_tickets_with_fecha_editada.forEach(el => {
					//console.log(el)
					this.validateTrRemove(el, false)
					//this.abstractData = this.$children[0].v_boletos_list
					//console.log(this.$children[0].v_boletos_list)
				})
			}
		},
		pre_load_vboletos(){
			this.set_ar_tickets()
            this.alert_loader({
                text:   'Se está buscando venta de boletos',
                icon:   'loader',
                click:  false,
                esc:    false,
                time:   false,
            });
            this.load_vboletos()
        },
		load_vboletos(){
			let url_get_InRange = this.route + "/tablero/ventaboletos/getInRange/" + this.fecha_d + "/" + this.fecha_h;
			axios.get(url_get_InRange).then(response => {
				//console.log(response.data)
				calculos_finales.incentivos	= response.data.incentivos
				this.iva			= response.data.iva.iva
				this.vendedores 	= response.data.vendedores
				this.tipo_pagos   	= response.data.tipo_pagos
            	this.aviajes       	= response.data.aviajes
            	this.laereas       	= response.data.laereas
            	this.consolidadores 	= response.data.consolidadores
				this.v_boletos 		= response.data.vboletos
				swal.close()

				calculos_finales.v_boletos = this.v_boletos
				calculos_finales.inf_calculos
			}).catch(error => {
				console.log(error)
				console.log(error.response)
				if(error.response.status == '500') this.load_vboletos();
			});
		},
		search_filter_vboletos(){
			let url_get_count_data_to_filter = this.route + "/tablero/ventaboletos/getCountDataFilter/" + this.fecha_d + "/" + this.fecha_h;
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
                	    	this.pre_load_vboletos()
                	    }
                	})
				} else if(parseInt(response.data) <= 2000) {
					this.pre_load_vboletos()
				}
			})
		},
		showModal(id, v_boleto = [], tipo_modal, index){
			//console.log(tipo_modal)
			this.v_boleto = v_boleto
			if(tipo_modal == 'detalle'){
				this.setAttributesModal();
			} else if(tipo_modal == 'editar_fecha'){
				this.new_fecha_registro = ''
				$("#fecha_registro").val(v_boleto.created_at.split(' ')[0])

				this.ticket.id 		= this.v_boleto.id
				this.ticket.index 	= index
				this.ticket.nro 	= this.v_boleto.nro_ticket

			} else if (tipo_modal == 'editar_ticket') {
				this.edit_nro_ope = !1
				this.setAttributesTicket(index)
			} else if(tipo_modal == 'edit_multis'){
				$("#multi_tipo_pago").children('option').removeAttr('selected')
				let o = $("#multi_tipo_pago").children('option')[0]
				$(o).attr('selected', true)
				$("#multi_tipo_pago").select2('destroy')
				$("#multi_tipo_pago").select2()

				$("#multi_agencia_viaje").children('option').removeAttr('selected')
				let av = $("#multi_agencia_viaje").children('option')[0]
				$(av).attr('selected', true)
				$("#multi_agencia_viaje").select2('destroy')
				$("#multi_agencia_viaje").select2()

				$("#new_fecha_registro").val("")
			}
			$("#"+id).modal('show')
		},
		hideModal(id){
			//$("#"+id).fadeOut(300)
			/*---------------------------------------------------> NOTA IMPORTANTE <------------------------------------------------------*/
			/* EN LO QUE RESPECTA A LOS MODALES HAY QUE TRABAJARLOS SOLO CON MODAL('SHOW') Y MODAL('HIDE'), SON ESAS LAS FUNCIONES PARA MOSTRAR Y OCULTAR, NO FADE  */
			$("#"+id).modal('hide')
		},
		setAttributesModal(){
			$("#nro_ticket").val(this.v_boleto.nro_ticket)
			$("#neto").val(this.v_boleto.neto)
			$("#tarifa").val(this.v_boleto.tarifa)
			$("#comision_agencia").val(this.v_boleto.comision_agencia)
			$("#igv").val(this.v_boleto.igv)
			$("#consolidador").val(this.v_boleto.consolidadores.nombre)
			$("#total").val(this.v_boleto.total)
			$("#pago_consolidador").val(this.v_boleto.pago_consolidador)
			$("#tarifa_fee").val(this.v_boleto.tarifa_fee)
			$("#utilidad").val(this.v_boleto.utilidad)
			$("#incentivo").val(this.v_boleto.incentivo)
		},
		valFalseFechaRegistro(){
			this.exe_new_fecha_reg = false
		},
		validate_fecha_proceso(tipo_fecha){
			let ar_fe_act = this.actual_date.split('-')
			let ar_new_fe_reg = []
			if(this.new_fecha_registro != ''){
				ar_new_fe_reg = this.new_fecha_registro.split('-')
			}
			if(tipo_fecha == 'new_fecha_registro'){
				if(ar_new_fe_reg[0] == ar_fe_act[0]){
					if(ar_new_fe_reg[1] > ar_fe_act[1]){
						this.exe_new_fecha_reg = false
						toastr.warning("El mes de la nueva fecha de registro no puede ser mayor al mes actual", "Disculpe!.");
					} else if(ar_new_fe_reg[1] == ar_fe_act[1]) {
						if(ar_new_fe_reg[2] > ar_fe_act[2]){
							this.exe_new_fecha_reg = false
							toastr.warning("El dia de la nueva fecha de registro no puede ser mayor al día actual", "Disculpe!.");
						} else {
							this.exe_new_fecha_reg = true
						}
					} else {
						this.exe_new_fecha_reg = true
					}
				} else {
					if(ar_new_fe_reg[0] > ar_fe_act[0]){
						this.exe_new_fecha_reg = false
						toastr.warning("El año de la nueva fecha de registro no puede ser mayor al año actual", "Disculpe!.");
					} else {
						this.exe_new_fecha_reg = true
					}
				}
			}
		},
		setAttributesTicket(index){
			//console.log(this.v_boleto)
			this.comision_general_agencia 	= 0

			this.ticket.id 					= this.v_boleto.id
			this.ticket.index 				= index
			this.ticket.fecha 				= this.v_boleto.created_at.split(' ')[0]
			this.ticket.cliente.dni 		= this.v_boleto.cliente_id
			this.ticket.cliente.nombre		= this.v_boleto.nombre_cliente
			this.ticket.nro 				= this.v_boleto.nro_ticket
			this.ticket.nro_operacion		= this.v_boleto.nro_operacion
			this.ticket.neto 				= this.v_boleto.neto
			this.ticket.tarifa 				= this.v_boleto.tarifa
			this.ticket.comision_agencia	= this.v_boleto.comision_agencia
			this.ticket.igv					= this.v_boleto.igv
			this.ticket.total 				= this.v_boleto.total
			this.ticket.pago_consolidador	= this.v_boleto.pago_consolidador
			this.ticket.tarifa_fee			= this.v_boleto.tarifa_fee
			this.ticket.utilidad			= this.v_boleto.utilidad
			this.ticket.incentivo			= this.v_boleto.incentivo
			this.ticket.tipop.id 			= this.v_boleto.tipop.id
			this.ticket.tipop.pago 			= this.v_boleto.tipop.pago
			this.ticket.aviajes				= this.v_boleto.aviajes
			this.ticket.laerea.id			= this.v_boleto.laereas.id
			this.ticket.laerea.nombre			= this.v_boleto.laereas.nombre
			this.ticket.consolidador.id 		= this.v_boleto.consolidadores.id
			this.ticket.consolidador.nombre 	= this.v_boleto.consolidadores.nombre

			this.val_ver_nro_ope()
			this.buscarComision()
		},
		val_ver_nro_ope(){
			if(this.ticket.tipop.id != 1){
				if(this.ticket.nro_operacion == null){
					this.ver_nro_operacion = !0
				} else this.ver_nro_operacion = !1
			} else this.ver_nro_operacion = !1
		},
		buscarComision() {
			let url_search_comision = this.route + "/buscar/comision/" + this.ticket.laerea.id + "/" + this.ticket.consolidador.id
            toastr.info("Buscando si existe comision registrada.")
            axios.get(url_search_comision).then(response => {
            	//console.log(response.data)
                if (response.data != null && response.data != '') {
                	this.comision_general_agencia = response.data.comision

                    if(this.v_boleto.comision > 0){
                    	toastr.success("Comisión de ticket encontrada!.");
                    	this.ticket.exist_percent = false
                    	this.ticket.percent_comi_agency = this.v_boleto.comision
                    } else {
                    	toastr.success("Comisión General encontrada!.");
                    	this.ticket.exist_percent = true
                    	this.ticket.percent_comi_agency = response.data.comision
                    }
                    //$("#comi_without_percent").css('display', 'none')
                } else {
                    toastr.error("No existe comisión general registrada.");
                    this.ticket.exist_percent = false
                    this.ticket.percent_comi_agency = this.v_boleto.comision
                    //$("#comi_without_percent").css('display', '')
                }
                $("#tipo_pago").select2("destroy")
				$("#tipo_pago").select2()
            }).catch(error => {
            	console.log(error)
                console.log(error.response);
            });
        },
        setChangePayType(self){
        	if(self.value != 1){
        		if(this.ticket.nro_operacion == null || this.ticket.nro_operacion == 0){
        			this.ticket.nro_operacion = 0
        			this.ver_nro_operacion = !0
        		}
        	} else {
        		if(this.edit_nro_ope){
	        		this.ticket.nro_operacion = null
        		}
	        	this.ver_nro_operacion = !1
        	}
        	$("#tipo_pago").select2("destroy")
			$("#tipo_pago").select2()
        },
        editar_nro_ope(){
        	if(this.ticket.nro_operacion.length > 0){
        		this.edit_nro_ope = !0
        	} else this.edit_nro_ope = !1
        },
        calcularMontos() {
        	//console.log(this.ticket.neto)
            if (this.ticket.neto >= 0) {
                this.ticket.comision_agencia = (this.ticket.percent_comi_agency * this.ticket.neto) / 100;
                this.ticket.igv = (parseFloat(this.ticket.comision_agencia) * parseFloat(this.iva)) / 100;
                this.ticket.total = (this.ticket.comision_agencia + this.ticket.igv);
                this.ticket.igv = Math.round(this.ticket.igv * 100) / 100;
                this.ticket.total = Math.round(this.ticket.total * 100) / 100;
            }
            if (this.ticket.tarifa >= 0) {
                this.ticket.pago_consolidador = parseFloat(this.ticket.tarifa) - this.ticket.total;
                this.ticket.pago_consolidador = Math.round(this.ticket.pago_consolidador * 100) / 100
            }
            if (this.ticket.tarifa_fee >= 0) {
                this.ticket.utilidad = parseFloat(this.ticket.tarifa_fee) - this.ticket.pago_consolidador;
                this.ticket.utilidad = Math.round(this.ticket.utilidad * 100) / 100
            }
        },
        setAttributesSelects(){
        	this.ticket.tipop.id 			= $("#tipo_pago").val()
        	this.ticket.tipop.pago 			= $("#tipo_pago").find(":selected").text().trim()
        	this.ticket.aviajes				= $("#agencia_viaje").val()
        	this.ticket.laerea.id 			= $("#linea_aerea").val()
        	this.ticket.laerea.nombre 		= $("#linea_aerea").find(":selected").text().trim()
        	this.ticket.consolidador.id 	= $("#conso").val()
        	this.ticket.consolidador.nombre = $("#conso").find(":selected").text().trim()
        },
        updateTicket(){
        	this.setAttributesSelects()
        	swal({
                title: "Disculpe!.",
               	text: "¿Está seguro de que desea editar este ticket?",
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
	    		timer: 10000,
            }).then(acepted => {
                if(acepted){
                	if(this.ticket.percent_comi_agency != this.comision_general_agencia){
                		this.ticket.exist_percent = false;
                	}
                 	let url_update_ticket = this.route + "/tablero/ventaboletos/updateVb/" + this.ticket.id
                 	this.alert_loader({
            		    text:   'Se está editando el ticket!',
            		    icon:   'loader',
            		    click:  false,
            		    esc:    false,
            		    time:   false,
            		})
                 	axios.post(url_update_ticket, {ticket: this.ticket}).then(response => {
                 		this.updateDataVboleto()
                 		this.alert_success({
                 			text:   'El ticket fue editado correctamente!',
            		    	click:  true,
            		    	esc:    true,
            		    	time:   4000,
                 		});
                 		swal.close()
						$("#modalEditarVBoleto").modal('hide')
                 		this.edit_nro_ope = !1
                 	}).catch(error => {
                 		console.log(error)
                 		console.log(error.response)
                 	})
                }
            })
        },
        updateDataVboleto(){
        	this.v_boletos[this.ticket.index].comision = this.ticket.percent_comi_agency
			$("#td_linea_aerea_" + this.ticket.id).text(this.ticket.laerea.nombre)
			$("#td_agencia_viaje_" + this.ticket.id).text(this.ticket.aviajes)
			$("#td_valor_neto_" + this.ticket.id).text(this.ticket.neto)
			$("#td_comision_agencia_" + this.ticket.id).text(this.ticket.comision_agencia)
			$("#td_total_" + this.ticket.id).text(this.ticket.total)
			$("#td_tipo_pago_" + this.ticket.id).text(this.ticket.tipop.pago)
			$("#td_tarifa_fee_" + this.ticket.id).text(this.ticket.tarifa_fee)

			// Update data vboleto in vboletos
			let index = this.ticket.index

			this.$children[0].v_boletos[index].neto 				= this.ticket.neto
			this.$children[0].v_boletos[index].nro_operacion 		= this.ticket.nro_operacion
			this.$children[0].v_boletos[index].tarifa 				= this.ticket.tarifa
			this.$children[0].v_boletos[index].tarifa_fee 			= this.ticket.tarifa_fee
			this.$children[0].v_boletos[index].comision_agencia 	= this.ticket.comision_agencia 
			this.$children[0].v_boletos[index].igv 					= this.ticket.igv
			this.$children[0].v_boletos[index].total 				= this.ticket.total
			this.$children[0].v_boletos[index].pago_consolidador 	= this.ticket.pago_consolidador
			this.$children[0].v_boletos[index].utilidad 			= this.ticket.utilidad
			this.$children[0].v_boletos[index].incentivo 			= this.ticket.incentivo
			this.$children[0].v_boletos[index].tipop.id 			= this.ticket.tipop.id
			this.$children[0].v_boletos[index].tipop.pago 			= this.ticket.tipop.pago 
			this.$children[0].v_boletos[index].aviajes 				= this.ticket.aviajes
			this.$children[0].v_boletos[index].laereas.id  			= this.ticket.laerea.id
			this.$children[0].v_boletos[index].laereas.nombre 		= this.ticket.laerea.nombre 
			this.$children[0].v_boletos[index].consolidadores.id 	= this.ticket.consolidador.id
			this.$children[0].v_boletos[index].consolidadores.nombre = this.ticket.consolidador.nombre

			this.v_boletos[index].neto 					= this.ticket.neto
			this.v_boletos[index].nro_operacion 		= this.ticket.nro_operacion
			this.v_boletos[index].tarifa 				= this.ticket.tarifa
			this.v_boletos[index].tarifa_fee 			= this.ticket.tarifa_fee
			this.v_boletos[index].comision_agencia 		= this.ticket.comision_agencia 
			this.v_boletos[index].igv 					= this.ticket.igv
			this.v_boletos[index].total 				= this.ticket.total
			this.v_boletos[index].pago_consolidador 	= this.ticket.pago_consolidador
			this.v_boletos[index].utilidad 				= this.ticket.utilidad
			this.v_boletos[index].incentivo 			= this.ticket.incentivo
			this.v_boletos[index].tipop.id 				= this.ticket.tipop.id
			this.v_boletos[index].tipop.pago 			= this.ticket.tipop.pago 
			this.v_boletos[index].aviajes 				= this.ticket.aviajes
			this.v_boletos[index].laereas.id  			= this.ticket.laerea.id
			this.v_boletos[index].laereas.nombre 		= this.ticket.laerea.nombre 
			this.v_boletos[index].consolidadores.id 	= this.ticket.consolidador.id
			this.v_boletos[index].consolidadores.nombre = this.ticket.consolidador.nombre

			console.log('Se actualizó el boleto con id:'+this.ticket.id+', de index:'+this.ticket.index+' internamente en vboletos')
        },
        updateFechaRegistro(){
        	let url_update_fecha_registro = this.route + "/tablero/ventaboletos/updateFecha/" + this.ticket.id
        	toastr.info("Actualizando Fecha!")
        	axios.post(url_update_fecha_registro, {
        		new_fecha: this.new_fecha_registro,
        		nro_ticket: this.ticket.nro,
        	}).then(response => {
        		this.validateTrRemove({id: this.ticket.id, fecha: this.new_fecha_registro}, true)
        		toastr.success("Fecha de Registro editada con exito!.", "Excelente!")
        		let f_d = this.new_fecha_registro.split('-')[2]+'/'+this.new_fecha_registro.split('-')[1]+'/'+this.new_fecha_registro.split('-')[0]
        		$("#td_fecha_registro_" + this.ticket.id).text(f_d + ' ' + response.data)
        		$("#modalFechaVBoletos").modal('hide')
        		this.new_fecha_registro = ''
        	}).catch(error => {
            	console.log(error)
            	console.log(error.response)
            })
        },
        validateTrRemove(obj, exe){
        	let ar_fe_d = this.fecha_d.split('-')
        	let ar_fe_h = this.fecha_h.split('-')
        	let ar_fe_n = obj.fecha.split('-')
        	//console.log('fecha: ' + obj.fecha)
        	$("#tr_padre_"+obj.id).css('display', '')
        	if(ar_fe_n[0] >= ar_fe_d[0] && ar_fe_n[0] <= ar_fe_h[0]){ // año de new_fecha mayor o igual a año de fecha_d y menor o igual a fecha_h
        		if(ar_fe_n[1] >= ar_fe_d[1] && ar_fe_n[1] <= ar_fe_h[1]){
        			if(ar_fe_n[2] < ar_fe_d[2] || ar_fe_n[2] > ar_fe_h[2]){
        				if(exe){
        					if(this.ar_tickets_with_fecha_editada.length > 0){
        						this.ar_tickets_with_fecha_editada.forEach((objeto, index) => {
        							if(objeto.id == obj.id){
        								this.ar_tickets_with_fecha_editada.splice(index, 1)
        							}
        						})
        					}
        					this.ar_tickets_with_fecha_editada.push({id: obj.id, fecha: obj.fecha});
        				}
        				$("#tr_padre_"+obj.id).css('display', 'none')
        			}
        		} else {
        			if(exe){
        				if(this.ar_tickets_with_fecha_editada.length > 0){
        					this.ar_tickets_with_fecha_editada.forEach((objeto, index) => {
        						if(objeto.id == obj.id){
        							this.ar_tickets_with_fecha_editada.splice(index, 1)
        						}
        					})
        				}
        				this.ar_tickets_with_fecha_editada.push({id: obj.id, fecha: obj.fecha});
        			}
        			$("#tr_padre_"+obj.id).css('display', 'none')
        		}
        	} else {
        		if(exe){
        			if(this.ar_tickets_with_fecha_editada.length > 0){
        				this.ar_tickets_with_fecha_editada.forEach((objeto, index) => {
        					if(objeto.id == obj.id){
        						this.ar_tickets_with_fecha_editada.splice(index, 1)
        					}
        				})
        			}
        			this.ar_tickets_with_fecha_editada.push({id: obj.id, fecha: obj.fecha});
        		}
        		$("#tr_padre_"+obj.id).css('display', 'none')
        	}
        },
        setGeneralFilter(){
        	this.filter_conso 			= $("#select_filter_conso").val()
			this.filter_linea_aerea 	= $("#select_filter_linea_aerea").val()
			this.filter_agencia_viaje 	= $("#select_filter_agencia_viaje").val()
			this.filter_vendedores 		= $("#select_filter_vendedor").val()
			this.filter_tipo_pago 		= $("#filter_tipo_pago").val()

			this.searchGeneralFilter()
        },
        searchGeneralFilter(){
        	this.alert_loader({
                text:   'Se está realizando la busqueda!',
                icon:   'loader',
                click:  false,
                esc:    false,
                time:   false,
            })
        	let url_general_filter = this.route + "/tablero/ventaboletos/GeneralFilter";
        	axios.post(url_general_filter, {
        		fecha_d: 		this.fecha_d,
        		fecha_h: 		this.fecha_h,
        		consolidador: 	this.filter_conso,
        		aviajes: 		this.filter_agencia_viaje,
        		laereas: 		this.filter_linea_aerea,
        		vendedor: 		this.filter_vendedores,
        		pasajero: 		this.filter_pasajero,
        		tpago: 			this.filter_tipo_pago
        	}).then(response => {
        		//console.log(response.data)
        		/*response.data.vboletos.forEach(b => {
        			console.log(b)
        		})*/
        		swal.close()
        		
        		this.v_boletos = response.data.vboletos
        		toastr.success("Busqueda terminada!. \n Encontrados: " + response.data.vboletos.length + " registros que coinciden.")
        		this.hideModal('modalFiltroGeneral')

        		calculos_finales.v_boletos = this.v_boletos
				calculos_finales.inf_calculos
				
        	}).catch(error => {
            	console.log(error)
            	console.log(error.response)
            	document.write(error.response.data)
            })
        },
        clear_selected(){
        	this.sm_v_boletos = []
        	this.exe_edit_multi = 0
        	$("input[class='cl_check_sm']:checked").removeAttr("checked");
        	this.$root.$children[0].sm_v_boletos = []
    	},
    	procesar_edith_sm(){
    		this.m_tipo_pago 		= $("#multi_tipo_pago").val();
    		//console.log(this.m_tipo_pago);
    		//return;
        	this.m_aviajes 			= $("#multi_agencia_viaje").val();
        	let m_tipo_pago_nombre	= $("#multi_tipo_pago").find(":selected").text().trim()
        	//console.log(this.m_aviajes)
        	//return
        	swal({
        	    title: "Espere un momento!",
        	    text: "Los boletos estan siendo actualizados!",
        	    icon: APP_URL + "/imagenes/loader.gif",
        	    button: {
        	        text: "Entiendo",
        	        value: false,
        	        closeModal: false,
        	    },
        	    closeOnClickOutside: false,
        	    closeOnEsc: false,
				dangerMode: true,
        	});
        	let url = this.route + "/tablero/ventaboletos/updateVarios";
        	axios.post(url,{
        		tpago: this.m_tipo_pago,
        		aviaje: this.m_aviajes,
        		freg: this.new_fecha_registro,
        		boletos: this.sm_v_boletos
        	}).then(response => {
        		//console.log(response.data)
        		this.updateDataMRegistros(m_tipo_pago_nombre, response.data)
        	    swal.close()
        	    toastr.success("Boletos actualizados con exito!.", "Excelente!.")
        	    this.hideModal('modalEditarVBoletos')
        	}).catch(error => {
        	    console.log(error);
        	    console.log(error.response);
        	});
    	},
    	updateDataMRegistros(mtp_n, hours){
    		this.sm_v_boletos.forEach((v_b, index) => {
    			if(this.new_fecha_registro != '' && this.new_fecha_registro != null){
    				let ar_nfecha = this.new_fecha_registro.split('-')
	    			let f_d = ar_nfecha[2]+'/'+ar_nfecha[1]+'/'+ar_nfecha[0]
	    			let dt = f_d + ' ' + hours[index]
	    			f = this.$children[0].setformatDate(dt)
	    			console.log(dt)
	    			console.log(f)
	        		//$("#td_fecha_registro_" + v_b).text(f)
    				this.validateTrRemove({id: v_b, fecha: this.new_fecha_registro}, true)
    			}
    			if(this.m_aviajes != '' && this.m_aviajes != '0' && this.m_aviajes != 0){
    				$("#td_agencia_viaje_" + v_b).text(this.m_aviajes)
    			}
    			if(mtp_n != ''){
    				$("#td_tipo_pago_" + v_b).text(mtp_n)
    			}
    		})
    		this.clear_selected()
    	},
    	exportarExcel(){

    		let abst = []
    		let busqueda = ''
    		
    		let conso = null
    		let agen_vi = null
    		let lin_ae = null
    		let vende = null

    		abst = this.$children[0].abstractData
    		busqueda = this.$children[0].search

    		if(busqueda == ''){
        		busqueda = null
        	}

        	if(abst.length > 0){
        		if(abst.length < this.$children[0].pageSize){
        			//console.log('paso por aqui')
        			this.showUpto = this.showFromto + abst.length
        		}
        	}

        	if(this.filter_conso != null){
	        	if(this.filter_conso.length > 0){
	        		conso = this.filter_conso.toString();
	        	} 
        	}

        	if(this.filter_agencia_viaje != null){
	        	if(this.filter_agencia_viaje.length > 0){
	        		agen_vi = this.filter_agencia_viaje.toString();
	        	}
        	}

        	if(this.filter_linea_aerea != null){
	        	if(this.filter_linea_aerea.length > 0){
	        		lin_ae = this.filter_linea_aerea.toString();
	        	}
        	}

        	if(this.filter_vendedores != null){
	        	if(this.filter_vendedores.length > 0){
	        		vende = this.filter_vendedores.toString();
	        	}
        	}

        	if(this.filter_pasajero == ''){
        		this.filter_pasajero = null
        	}

        	toastr.info('Generando Reporte en Excel!.');
        	console.log(this.showFromto ,this.showUpto)

    		window.location.href = this.route + '/tablero/ventaboletos/getExcelExport/'+this.fecha_d+'/'+this.fecha_h+'/'+conso+'/'+agen_vi+'/'+lin_ae+'/'+vende+'/'+this.filter_pasajero+'/'+this.filter_tipo_pago+'/'+this.showFromto+'/'+this.showUpto+'/'+busqueda
    	},
    	exportarPdf(){
    		let url_pdf_export = this.route + ""
    	},
	}
});

const calculos_finales = new Vue({
	el: '#venta_boletos_calculos_finales',
	created() {
		//console.log()
	},
	data: {
		v_boletos: [],
		incentivos: [],

		// Data Computed para Calculos inferiores
		inf_pago_conso: 0,
		inf_tarifa: 0,
		inf_tarifa_fee: 0,
		inf_utilidad: 0,
		inf_incentivo: 0,
		inf_sub_total: 0,
		inf_igv: 0,
		inf_total: 0,
	},
	methods: {
		cleanDataComputed(){
			this.inf_pago_conso	= 0
			this.inf_tarifa_fee	= 0
			this.inf_utilidad	= 0
			this.inf_incentivo	= 0
			this.inf_sub_total	= 0
			this.inf_igv		= 0
			this.inf_total		= 0
		},
		setFix(){
			this.inf_pago_conso	= parseFloat(this.inf_pago_conso.toFixed(2))
			this.inf_tarifa_fee	= parseFloat(this.inf_tarifa_fee.toFixed(2))	
			this.inf_utilidad	= parseFloat(this.inf_utilidad.toFixed(2))	
			this.inf_incentivo	= parseFloat(this.inf_incentivo.toFixed(2))	
			this.inf_sub_total	= parseFloat(this.inf_sub_total.toFixed(2))	
			this.inf_igv		= parseFloat(this.inf_igv.toFixed(2))		
			this.inf_total		= parseFloat(this.inf_total.toFixed(2))			
		}
	},
	computed: {
		inf_calculos(){
			this.cleanDataComputed()

			this.v_boletos.forEach(vboleto => {

				this.inf_pago_conso += vboleto.pago_consolidador
				this.inf_tarifa    	+= vboleto.tarifa
				this.inf_tarifa_fee += vboleto.tarifa_fee
				this.inf_utilidad   += vboleto.utilidad
				this.inf_sub_total  += vboleto.comision_agencia
				this.inf_igv  		+= vboleto.igv
			})

			if(this.inf_tarifa_fee > 0){
				this.inf_incentivo = parseFloat(this.inf_tarifa_fee) - parseFloat(this.inf_tarifa)
			}
			this.inf_total = parseFloat(this.inf_sub_total) + parseFloat(this.inf_igv)
			//console.log(this.inf_incentivo);
			//console.log(this.inf_total);

			if(this.incentivos.length > 0){
				if(this.inf_incentivo > 0){
					if(this.inf_incentivo <= this.incentivos[0].primera_meta){
						console.log('entro en la primera meta')
						this.inf_incentivo = (parseFloat(this.inf_incentivo) * this.incentivos[0].primer_incentivo) / 100
					} else {
						if(this.inf_incentivo <= this.incentivos[0].segunda_meta){
							console.log('entro en la segunda meta')
							this.inf_incentivo = (parseFloat(this.inf_incentivo) * this.incentivos[0].segundo_incentivo) / 100
						} else {
							if(this.inf_incentivo <= this.incentivos[0].tercera_meta){
								console.log('entro en la tercera meta')
								this.inf_incentivo = (parseFloat(this.inf_incentivo) * this.incentivos[0].tercer_incentivo) / 100
							} else {
								if(this.inf_incentivo <= this.incentivos[0].cuarta_meta){
									console.log('entro en la cuarta meta')
									this.inf_incentivo = (parseFloat(this.inf_incentivo) * this.incentivos[0].cuarto_incentivo) / 100
								} else {
									if(this.inf_incentivo <= this.incentivos[0].quinta_meta){
										console.log('entro en la quinta meta')
										this.inf_incentivo = (parseFloat(this.inf_incentivo) * this.incentivos[0].quinto_incentivo) / 100
									}
								}	
							}	
						}
					}
				}
			}

			this.setFix()
		}
	}
});