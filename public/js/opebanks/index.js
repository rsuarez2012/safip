Vue.component('templ_opebanks_no_ident',{
	template:"#template_opebanks_no_ident",
	props: ['opebanks_no_ident'],
	data: function() {
	    return {
			route: APP_URL,
			block: false,
			block_deudas: false,

		    pageSize: 10,	// Cantidad de registros por vista
		    pageSize_deudas: 10,
		    pageSize_pagos: 10,
		    currentPage: 1, // Pagina Actual
		    currentPage_deudas: 1,
		    currentPage_pagos: 1,
		    totalPage: 0,	// Cantidad de Paginas totales
		    totalPage_deudas: 0,
		    totalPage_pagos: 0,
		    showUpto: 10,	// Cantidad de Reg que se van a mostrar a la der
			showUpto_deudas: 10,
			showUpto_pagos: 10,
			showFromto: 0,	// Cantidad de Reg que se van a mostrar a la izq
			showFromto_deudas: 0,
			showFromto_pagos: 0,
			
			ope_no_ident: {},

			set_arrow_filter_date: false,
			fecha_d: '2018-02-01',
			fecha_h: '2018-02-28',

			options: [
				{
					type: 'Deuda de Agencia de Viaje',
					acron: 'deuda',
					value: 1
				},
				{
					type: 'Pago a Consolidadores',
					acron: 'pago_conso',
					value: 2
				},
				{
					type: 'Gastos',
					acron: 'gastos',
					value: 3
				},
			],
			ope_no_ident_type: '',
			procedencia: '',

			// DATA MODAL DEUDAS
			general_index: 0,
			deudas_agencia: [],
			deu_ag: [
				{
					id: 0,
					fecha: 		'',
					nro_cot: 	0,
					nro_ope: 	0,
					ticket: 	0,
					monto: 		0,
					diasc: 		0,
					pagos: [
						{
							type: 0,
							banco_emi: null,
							banco_recep: null,
							nro_ope: null,
							abono: 0,
							validate: {
								b_emi: false,
								b_recep: false,
								n_ope: false,
								abn: false,
							}
						}
					],
					total_abono: 0,
					resta: 0,
					pagado: false,
					btn_reset_pagos: true,
					full_price: 0,
				}
			],
			pay_types: [],
			emisor_banks: [],
			receptor_banks: [],
			save_payments: false,

			monto_pagos_general: 0,
			monto_resta_general: 0,

			// DATA MODAL PAGOS CONSOLIDADORES
			general_index_conso: 0,
			pagos_conso: [],
			pag_con: [
				{
					id: 0,
					fecha: 		'',
					nro_cot: 	0,
					nro_ope: 	0,
					ticket: 	0,
					monto: 		0,
					diasc: 		0,
					pagos: [
						{
							type: 0,
							banco_emi: null,
							banco_recep: null,
							nro_ope: null,
							abono: 0,
							validate: {
								b_emi: false,
								b_recep: false,
								n_ope: false,
								abn: false,
							}
						}
					],
					total_abono: 0,
					resta: 0,
					pagado: false,
					btn_reset_pagos: true,
					full_price: 0,
				}
			],
			save_payments_conso: false,
			monto_pagos_general_conso: 0,
			monto_resta_general_conso: 0,

			// DATA GASTOS
			tipo_gasto: '',
			descripcion_gasto: '',
			add_contability: false,
			sucursales: [
				{
					name: '0001',
				},
				{
					name: '0002',
				},
				{
					name: '0003',
				},
				{
					name: '0004',
				},
			],
			sucursal: 0,
			yes_suc: false,

			// Data Edit Multiple
			ha_editado_multi: false,
			ha_excedido_multi: false,
			excedente_multi: 0,
			excedente_multi_modif: 0,
			sm_pagos: [],
			exe_edit_multi_pagos: 0,
			sm: {
				monto: 0,
				pagos: [
				{
					type: 0,
					banco_emi: null,
					banco_recep: null,
					nro_ope: null,
					abono: 0,
					validate: {
						b_emi: false,
						b_recep: false,
						n_ope: false,
						abn: false,
					}
				}
				],
				total_abono: 0,
				resta: 0,
				pagado: false,
				btn_reset_pagos: true,
				full_price: 0,
			},
			
			search: '',
			search_deudas_no_ident: '',
			search_pagos: '',

			abstractData: [],
	    }
    },
    computed: {
    	opebanks_no_ident_list(){
    		//this.create_obj_deuda()
    		this.totalPage = Math.ceil(this.opebanks_no_ident.length / this.pageSize);
	    	let self = this
      		let search = self.search.toLowerCase()
      		var list = this.opebanks_no_ident.filter(function (no_ident){
      			/* if(no_ident.nro_operacion > 0){ */

	      			if(no_ident.empresa != null){
		    			empresa = no_ident.empresa;
		    		} else {
		    			empresa = '';
		    		}
		    		if(no_ident.moneda != null){
		    			moneda = no_ident.moneda;
		    		} else {
		    			moneda = '';
		    		}
		    		if(no_ident.fecha != null){
	    				fecha = no_ident.fecha
	    			} else {
	    				fecha = ''
	    			}
	    			if(no_ident.descripcion != null){
		    			descripcion = no_ident.descripcion;
		    		} else {
		    			descripcion = '';
		    		}
		    		if(no_ident.monto != null){
	    				monto = no_ident.monto
	    			} else {
	    				monto = ''
	    			}
	    			if(no_ident.saldo != null){
	    				saldo = no_ident.saldo
	    			} else {
	    				saldo = ''
	    			}
	    			if(no_ident.sucursal != null){
	    				sucursal = no_ident.sucursal
	    			} else {
	    				sucursal = ''
	    			}
	    			if(no_ident.nro_operacion != null){
	    				nro_ope = no_ident.nro_operacion
	    			} else {
	    				nro_ope = ''
	    			}
	    			if(no_ident.usuario != null){
		    			usuario = no_ident.usuario;
		    		} else {
		    			usuario = '';
		    		}
	      			return empresa.toLowerCase().indexOf(search) !== -1 ||
	      					moneda.toLowerCase().indexOf(search) !== -1 ||
	      					fecha.indexOf(search) !== -1 ||
	      					descripcion.toLowerCase().indexOf(search) !== -1 ||
	      					monto.toString().indexOf(search) !== -1 ||
	      					saldo.toString().indexOf(search) !== -1 ||
	      					sucursal.toString().indexOf(search) !== -1 ||
	      					nro_ope.toString().indexOf(search) !== -1 ||
	      					usuario.toLowerCase().indexOf(search) !== -1
	      		/* } else return */
      		}).slice(this.showFromto, this.showUpto)
      		return list
    	},
    	deudas_opebank_no_ident_list(){
    		this.totalPage_deudas = Math.ceil(this.deudas_agencia.length / this.pageSize_deudas);
    		let self = this
    		let search = self.search_deudas_no_ident.toLowerCase()
    		var lista_deudas = this.deudas_agencia.filter(function (deuda){
    			if(deuda.nro_operacion != null){
    				nro_ope = deuda.nro_operacion
    			} else {
    				nro_ope = ''
    			}
    			if(deuda.fecha != null){
    				fecha = deuda.fecha
    			} else {
    				fecha = ''
    			}
    			if(deuda.nombre_cliente != null){
	    			cli = deuda.nombre_cliente;
	    		} else {
	    			cli = '';
	    		}
	    		if(deuda.laereas != null){
	    			lae = deuda.laereas.nombre;
	    		} else {
	    			lae = '';
	    		}
	    		if(deuda.ruta != null){
	    			ruta = deuda.ruta;
	    		} else {
	    			ruta = '';
	    		}
	    		if(deuda.aviajes_id != null){
	    			av = deuda.aviajes_id;
	    		} else {
	    			av = '';
	    		}
	    		if(deuda.porpagar != null){
	    			porcobrar = deuda.porpagar;
	    		} else {
	    			porcobrar = '';
	    		}
	    		if(deuda.diasc != null){
	    			diasc = deuda.diasc;
	    		} else {
	    			diasc = '';
	    		}
    			return nro_ope.toString().indexOf(search) !== -1 ||
    					fecha.indexOf(search) !== -1 ||
    					deuda.venta_boleto_id.toString().indexOf(search) !== -1 ||
    					cli.toLowerCase().indexOf(search) !== -1 ||
    					lae.toLowerCase().indexOf(search) !== -1 ||
    					ruta.toLowerCase().indexOf(search) !== -1 ||
    					av.toLowerCase().indexOf(search) !== -1 ||
    					porcobrar.toString().indexOf(search) !== -1 ||
    					diasc.toString().indexOf(search) !== -1
    		}).slice(this.showFromto_deudas, this.showUpto_deudas)
    		return lista_deudas
    	},
    	pagos_conso_list(){
    		this.totalPage_pagos = Math.ceil(this.pagos_conso.length / this.pageSize_pagos)
    		let self = this
    		let search = self.search_pagos.toLowerCase()
    		var lista_pagos = this.pagos_conso.filter(function (deuda){
    			if(deuda.nro_operacion != null){
    				nro_ope = deuda.nro_operacion
    			} else {
    				nro_ope = ''
    			}
    			if(deuda.fecha != null){
    				fecha = deuda.fecha
    			} else {
    				fecha = ''
    			}
    			if(deuda.nombre_cliente != null){
	    			cli = deuda.nombre_cliente;
	    		} else {
	    			cli = '';
	    		}
	    		if(deuda.laereas != null){
	    			lae = deuda.laereas.nombre;
	    		} else {
	    			lae = '';
	    		}
	    		if(deuda.ruta != null){
	    			ruta = deuda.ruta;
	    		} else {
	    			ruta = '';
	    		}
	    		if(deuda.aviajes_id != null){
	    			av = deuda.aviajes_id;
	    		} else {
	    			av = '';
	    		}
	    		if(deuda.porpagar != null){
	    			porcobrar = deuda.porpagar;
	    		} else {
	    			porcobrar = '';
	    		}
	    		if(deuda.diasc != null){
	    			diasc = deuda.diasc;
	    		} else {
	    			diasc = '';
	    		}
    			return nro_ope.toString().indexOf(search) !== -1 ||
    					fecha.indexOf(search) !== -1 ||
    					deuda.venta_boleto_id.toString().indexOf(search) !== -1 ||
    					cli.toLowerCase().indexOf(search) !== -1 ||
    					lae.toLowerCase().indexOf(search) !== -1 ||
    					ruta.toLowerCase().indexOf(search) !== -1 ||
    					av.toLowerCase().indexOf(search) !== -1 ||
    					porcobrar.toString().indexOf(search) !== -1 ||
    					diasc.toString().indexOf(search) !== -1
    		}).slice(this.showFromto_pagos, this.showUpto_pagos)
    		return lista_pagos
    	}
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
	    changeSelect(t){
	    	if(t == 'general'){
	    		this.showUpto = this.pageSize;
	    		this.currentPage = 1;
				this.showFromto = 0;
	    	} else if(t == 'deudas') {
	    		this.showUpto_deudas = this.pageSize_deudas;
	    		this.currentPage_deudas = 1;
				this.showFromto_deudas = 0;
	    	}
	    },
	    nextPage(t) {
	    	if(t == 'general'){
		    	if (this.currentPage != this.totalPage){
		    	    this.showFromto = (this.currentPage * this.pageSize) ;
		    	    this.currentPage =  this.currentPage + 1;
		    	    this.showUpto = (this.currentPage * this.pageSize);
		    	}
	    	} else if(t == 'deudas') {
	    		if (this.currentPage_deudas != this.totalPage_deudas){
		    	    this.showFromto_deudas = (this.currentPage_deudas * this.pageSize_deudas) ;
		    	    this.currentPage_deudas =  this.currentPage_deudas + 1;
		    	    this.showUpto_deudas = (this.currentPage_deudas * this.pageSize_deudas);
		    	}
	    	} else if(t == 'conso'){
	    		if(this.currentPage_pagos != this.totalPage_pagos){
	    			this.showFromto_pagos = this.currentPage_pagos * this.pageSize_pagos
	    			this.currentPage_pagos = this.currentPage_pagos + 1
	    			this.showUpto_pagos = this.currentPage_pagos * this.pageSize_pagos
	    		}
	    	}
	    },
	    previousPage(t) {
	    	if(t == 'general'){
		    	if (this.currentPage != 1){
		    	    this.showFromto = ((this.currentPage - 2) * this.pageSize)
		    	    this.currentPage =  this.currentPage - 1
		    	    this.showUpto = (this.currentPage * this.pageSize)
		    	}
	    		
	    	} else if(t == 'deudas') {
	    		if (this.currentPage_deudas != 1){
		    	    this.showFromto_deudas = ((this.currentPage_deudas - 2) * this.pageSize_deudas)
		    	    this.currentPage_deudas =  this.currentPage_deudas - 1
		    	    this.showUpto_deudas = (this.currentPage_deudas * this.pageSize_deudas)
		    	}
	    	} else if(t == 'conso'){
	    		if(this.currentPage_pagos != 1){
	    			this.showFromto_pagos = ((this.currentPage_pagos - 2) * this.pageSize_pagos)
	    			this.currentPage_pagos = this.currentPage_pagos -1
	    			this.showUpto_pagos = this.currentPage_pagos * this.pageSize_pagos
	    		}
	    	}
		},
		action_generate(ope_no_ident){
			//console.clear()
			this.monto_pagos_general = 0
			this.monto_resta_general = 0
			this.monto_pagos_general_conso = 0
			this.monto_resta_general_conso = 0
			this.ope_no_ident = ope_no_ident
			let type = $("#ope_no_ident_type_"+ope_no_ident.id).val()
			this.ope_no_ident_type = type

			if(type != 0){
				this.procedencia = this.options.filter(opt => {
					if(opt.value == this.ope_no_ident_type) return opt
				})[0].type
			}
			if(type == 1){
				if(this.monto_resta_general == 0){
					this.monto_resta_general = parseFloat(this.ope_no_ident.monto)
				}
				this.validate_fecha_ope()
				this.load_deudas_agencia()
			} else if(type == 2) {
				if(this.monto_resta_general_conso == 0){
					this.monto_resta_general_conso = parseFloat(this.ope_no_ident.monto)
				}
				this.validate_fecha_ope()
				this.load_pagos_conso()
			} else if(type == 3) {
				$("#modal_gastos").modal('show')
			} else {
				toastr.warning('Debe seleccionar una opción', 'Disculpe!')
			}
		},
		create_obj_deuda(){
			this.deu_ag.push({
				id: 0,
				fecha: 		'',
				nro_cot: 	0,
				nro_ope: 	0,
				ticket: 	0,
				monto: 		0,
				diasc: 		0,
				pagos: [
					{
						type: 0,
						banco_emi: null,
						banco_recep: null,
						nro_ope: null,
						abono: 0,
						validate: {
							b_emi: false,
							b_recep: false,
							n_ope: false,
							abn: false,
						}
					}
				],
				total_abono: 0,
				resta: 0,
				pagado: false,
				btn_reset_pagos: true,
				full_price: 0,
			})
		},
		create_obj_pago_conso(){
			this.pag_con.push({
				id: 0,
				fecha: 		'',
				nro_cot: 	0,
				nro_ope: 	0,
				ticket: 	0,
				monto: 		0,
				diasc: 		0,
				pagos: [
					{
						type: 0,
						banco_emi: null,
						banco_recep: null,
						nro_ope: null,
						abono: 0,
						validate: {
							b_emi: false,
							b_recep: false,
							n_ope: false,
							abn: false,
						}
					}
				],
				total_abono: 0,
				resta: 0,
				pagado: false,
				btn_reset_pagos: true,
				full_price: 0,
			})	
		},
		validate_fecha_ope(){
			let ar_fecha_ope = this.ope_no_ident.fecha.split('-')
			let ar_fecha_act = '2019-03-29'.split('-')
			//console.log(ar_fecha_ope)
			//console.log(ar_fecha_act)
			this.set_arrow_filter_date = !0
			/*if(ar_fecha_ope[0] == ar_fecha_act[0]){
				if(ar_fecha_ope[1] == ar_fecha_act[1]){
					if(ar_fecha_ope[2] <= ar_fecha_act[2]) this.set_arrow_filter_date = !0
					else this.set_arrow_filter_date = !1
				} else if(ar_fecha_ope[1] < ar_fecha_act[1]){
					this.set_arrow_filter_date = !0
				} else this.set_arrow_filter_date = !1
			} else if(ar_fecha_ope[0] < ar_fecha_act[0]){
				this.set_arrow_filter_date = !0
			} else this.set_arrow_filter_date = !1*/
		},
		generate_deudas(){
			if(this.deudas_agencia.length > 0){
				this.deudas_agencia.forEach(d => {
					this.deu_ag.push({
						id: d.id,
						aviaje: 	d.aviajes_id,
						fecha: 		d.fecha,
						nro_cot: 	d.venta_boleto_id,
						nro_ope: 	d.nro_operacion,
						ticket: 	d.nro_ticket,
						monto: 		d.porpagar,
						diasc: 		d.diasc,
						pagos: [
							{
								type: 0,
								banco_emi: null,
								banco_recep: null,
								nro_ope: null,
								abono: 0,
								validate: {
									b_emi: false,
									b_recep: false,
									n_ope: false,
									abn: false,
								}
							}
						],
						total_abono: 0,
						resta: d.porpagar,
						pagado: false,
						btn_reset_pagos: true,
						full_price: 0,
					})
				})
			} else {
				this.create_obj_deuda()
			}
		},
		generate_pagos_conso(){
			if(this.pagos_conso.length > 0){
				this.pagos_conso.forEach(p => {
					this.pag_con.push({
						id: p.id,
						fecha: 		p.fecha,
						nro_cot: 	p.venta_boleto_id,
						nro_ope: 	p.nro_operacion,
						ticket: 	p.nro_ticket,
						monto: 		p.porpagar,
						diasc: 		p.diasc,
						pagos: [
							{
								type: 0,
								banco_emi: null,
								banco_recep: null,
								nro_ope: null,
								abono: 0,
								validate: {
									b_emi: false,
									b_recep: false,
									n_ope: false,
									abn: false,
								}
							}
						],
						total_abono: 0,
						resta: p.porpagar,
						pagado: false,
						btn_reset_pagos: true,
						full_price: 0,
					})
				})
			} else {
				this.create_obj_pago_conso()
			}
		},
		load_deudas_agencia(){
			this.alert_loader({
                text:   'Se está buscando deudas de agencias',
                icon:   'loader',
                click:  false,
                esc:    false,
                time:   false,
            });
			let url_load_deudas_agencia = this.route + '/tablero/opebanks/load/data/deudas/agencia/' + this.ope_no_ident.nro_operacion + '/monto/' + this.ope_no_ident.monto
			axios.get(url_load_deudas_agencia).then(response => {
				//console.log(response.data)
				this.deudas_agencia = []
				this.deu_ag = []
				this.deudas_agencia = response.data.deudas_agencia
				this.generate_deudas()
				swal.close()
				$("#modal_deudas").modal('show')
			}).catch(error => {
				console.log(error)
				console.log(error.response)
				document.write(error.response.data)
			})
		},
		load_deudas_agencia_fechas(){
			if(this.fecha_d != null && this.fecha_d != '' && this.fecha_h != null && this.fecha_h != ''){
				this.alert_loader({
	                text:   'Se está buscando deudas de agencias',
	                icon:   'loader',
	                click:  false,
	                esc:    false,
	                time:   false,
	            });
				let url_load_deudas_agencia_fechas = this.route + '/tablero/opebanks/load/data/deudas/fechas/' + this.fecha_d +'/'+ this.fecha_h  + '/monto/' + this.ope_no_ident.monto
				axios.get(url_load_deudas_agencia_fechas).then(response => {
					/*console.log(response.data)
					response.data.deudas_agencia.forEach(d => {
						console.log(d)
						console.log(d.id)
						console.log(d.fecha)
					})*/
					this.deudas_agencia = []
					this.deu_ag = []
					this.deudas_agencia = response.data.deudas_agencia
					this.generate_deudas()
					
				swal.close()
				}).catch(error => {
					console.log(error)
					console.log(error.response)
					document.write(error.response.data)
				})
			} else toastr.warning('Los campos Desde y Hasta no pueden estar vacios y deben tener un formato aceptado!', 'Disculpe!')
		},
		open_modal_set_pago(deuda, type){
			if(type == 'conso') {
				this.pagos_conso.forEach((con, ind) => {
					if(con.id == deuda.id){
						this.general_index_conso = ind
					}
				})
			}
			else if(type == 'deuda') {
				this.deudas_agencia.forEach((deu, ind) => {
					if(deu.id == deuda.id){
						this.general_index = ind
					}
				})
			}
			$("#modal_pagos_"+type).modal('show')
		},
		create_pago_deuda(){
			this.deu_ag[this.general_index].pagos.push(
				{
					type: 0,
					banco_emi: null,
					banco_recep: null,
					nro_ope: null,
					abono: 0,
					validate: {
						b_emi: false,
						b_recep: false,
						n_ope: false,
						abn: false,
					}
				}
			)
		},
		delete_pago_deuda(index){
			this.deu_ag[this.general_index].pagos.splice(index, 1)
			this.val_monto(0)
		},
		val_pay_type(index){
			let pay_type = $('#ope_no_ident_pay_type_'+this.ope_no_ident.id+'_gi_'+this.general_index+'_pg_'+index).val()
			let emi_bank = $('#ope_no_ident_emi_bank_'+this.ope_no_ident.id+'_gi_'+this.general_index+'_pg_'+index).val()
			let recep_bank = $('#ope_no_ident_recep_bank_'+this.ope_no_ident.id+'_gi_'+this.general_index+'_pg_'+index).val()

			$('#ope_no_ident_emi_bank_'+this.ope_no_ident.id+'_gi_'+this.general_index+'_pg_'+index).select2()
			$('#ope_no_ident_recep_bank_'+this.ope_no_ident.id+'_gi_'+this.general_index+'_pg_'+index).select2()

			if(pay_type == 0 || pay_type == 1){
				this.deu_ag[this.general_index].pagos[index].banco_emi = null
				this.deu_ag[this.general_index].pagos[index].banco_recep = null
				this.deu_ag[this.general_index].pagos[index].nro_ope = null
				this.deu_ag[this.general_index].pagos[index].validate = {
					b_emi: false,
					b_recep: false,
					n_ope: false,
					abn: true,
				}
				this.deu_ag[this.general_index].btn_reset_pagos = !1
				if(pay_type == 0){
					this.deu_ag[this.general_index].pagos[index].abono = 0
					this.deu_ag[this.general_index].pagos[index].validate.abn = false
					this.val_monto(index)
					this.deu_ag[this.general_index].btn_reset_pagos = !0
				}
			} else {
				this.deu_ag[this.general_index].pagos[index].banco_emi = emi_bank
				this.deu_ag[this.general_index].pagos[index].banco_recep = recep_bank		
				this.deu_ag[this.general_index].pagos[index].validate = {
					b_emi: true,
					b_recep: true,
					n_ope: true,
					abn: true,
				}
				this.deu_ag[this.general_index].btn_reset_pagos = !1
			}
		},
		close_modal_set_pago(type){
			//console.log(type)
			if(type == 'conso') {
				if(!this.pag_con[this.general_index_conso].full_price) this.val_monto_pago_conso(0)
			}
			else if(type == 'sm_deuda'){
				$("#modal_sm_pagos").modal('hide')
				if(!this.sm.full_price) this.val_monto_sm(0)
			} else {
				if(!this.deu_ag[this.general_index].full_price){
					this.val_monto(0)
				}
			}
			$("#modal_pagos_"+type).modal('hide')
		},
		closeModal(type){
			$("#ope_no_ident_type_"+this.ope_no_ident.id).val('0')
			//console.log(type)
			if(this.sm_pagos.length > 0){
				this.reset_pagos('sm_deuda')
			} else this.reset_pagos(type)
			$("#modal_deudas").modal('hide')
			$('#modal_deudas_pagos_conso').modal('hide')
			this.clear_selected()
		},
		set_type_emi_bank(t, type = 'deuda'){
			let emi = $(t)
			let ind_emi = emi.attr('name').split('_pg_')[1]
			let emi_bank = emi.val()
			if(type == 'conso'){
				this.pag_con[this.general_index_conso].pagos[ind_emi].banco_emi = emi_bank
			} else this.deu_ag[this.general_index].pagos[ind_emi].banco_emi = emi_bank
		},
		set_type_recep_bank(t, type = 'deuda'){
			let recep = $(t)
			let ind_recep = recep.attr('name').split('_pg_')[1]
			let recep_bank = recep.val()
			if(type == 'conso'){
				this.pag_con[this.general_index_conso].pagos[ind_recep].banco_recep = recep_bank
			} else this.deu_ag[this.general_index].pagos[ind_recep].banco_recep = recep_bank
		},
		val_monto(index){
			let ab = this.deu_ag[this.general_index].pagos[index].abono
			let rst = this.deu_ag[this.general_index].resta
			//ab = parseFloat(ab)
			let total_abono = 0
			//console.log(ab)
			
			if(ab.length == 0){
				this.deu_ag[this.general_index].pagos[index].abono = ''
				ab = 0
			}
			if(ab.length == undefined){
				ab = 0
			}
			if (ab != '' && ab != null && ab.length > 0 || ab.length == undefined) {
				//console.log('entro en eval')
				if(ab == 0){
					this.deu_ag[this.general_index].pagos[index].abono = 0
				}
				this.deu_ag[this.general_index].total_abono = 0
				this.deu_ag[this.general_index].pagos.forEach((pago, index) => {
					this.deu_ag[this.general_index].total_abono += parseFloat(pago.abono)
				})
				this.deu_ag[this.general_index].resta = (parseFloat(this.deu_ag[this.general_index].monto) - parseFloat(this.deu_ag[this.general_index].total_abono)).toFixed(2)
			}
			if(this.deu_ag[this.general_index].total_abono > this.ope_no_ident.monto){
				toastr.warning('La cant abonada no puede ser mayor al monto disponible en la operación bancaria', 'Disculpe!')
				return
			}
			if(this.deu_ag[this.general_index].resta < 0){
				toastr.warning('La cant restante no puede ser menor a 0', 'Disculpe!')
				return
			}
			if(this.deu_ag[this.general_index].total_abono > this.monto_resta_general){
				toastr.warning('La cant abonada no puede ser mayor al monto restante de la operación bancaria', 'Disculpe!')
				return
			}
			if(this.deu_ag[this.general_index].resta < 0 || this.deu_ag[this.general_index].resta == this.deu_ag[this.general_index].monto){
				this.deu_ag[this.general_index].pagado = false
				this.val_register_pago_deudas('deuda')
			}
		},
		realizar_pagos(type){
			//this.val_monto(0)
			if(type == 'conso'){
				//console.log(this.pag_con[this.general_index_conso].resta)
				if(this.pag_con[this.general_index_conso].resta >= 0 && this.pag_con[this.general_index_conso].resta < this.pag_con[this.general_index_conso].monto){
					this.pag_con[this.general_index_conso].pagado = true
					if(this.val_nro_ope_pago_deuda(type)){
						this.close_modal_set_pago(type)
						//console.log('si llego')
						this.val_register_pago_deudas('conso')
					} else {
						this.pag_con[this.general_index_conso].pagado = false
					}
				}
			} else if(type == 'deuda') {
				if(this.deu_ag[this.general_index].resta >= 0 && parseFloat(this.deu_ag[this.general_index].resta) < parseFloat(this.deu_ag[this.general_index].monto)){
					this.deu_ag[this.general_index].pagado = true
					if(this.val_nro_ope_pago_deuda(type)){
						this.close_modal_set_pago(type)
						this.val_register_pago_deudas('deuda')
					} else {
						this.deu_ag[this.general_index].pagado = false
					}
				}
			} else if(type == 'sm_deuda'){
				if(parseFloat(this.sm.resta) >= 0 && parseFloat(this.sm.resta) < this.sm.monto){
					this.sm.pagado = true
					if(this.val_nro_ope_pago_deuda(type)){
						this.close_modal_set_pago(type)
						this.val_register_pago_deudas(type)
						this.ha_editado_multi = true
					}  else this.sm.pagado = !1
				}
			}
		},
		val_nro_ope_pago_deuda(type){
			let pay_type = 0
			let nro_op = 0
			let sale = true

			if(type == 'conso'){
				this.pag_con[this.general_index_conso].pagos.forEach((pago_act, ind_pago) => {
					pay_type = $('#conso_ope_no_ident_pay_type_'+this.ope_no_ident.id+'_gi_'+this.general_index_conso+'_pg_'+ind_pago).val()
					if(pay_type != 1){
						nro_op = pago_act.nro_ope
						this.pag_con.forEach((deuda, ind_deu) => {
							if(deuda.pagado){
								deuda.pagos.forEach((pago_gen, ind_pago_gen) => {
									if(ind_deu == this.general_index_conso && ind_pago == ind_pago_gen){
									} else {
										if(pago_gen.nro_ope == nro_op && sale){
											toastr.warning('El nro de operación: '+nro_op+' le pertenece a otro pago que ha realizado', 'Disculpe!')
											sale = false
										}
									}
								})
							}
						})
					}
				})

			} else if(type == 'deuda') {
				this.deu_ag[this.general_index].pagos.forEach((pago_act, ind_pago) => {
					pay_type = $('#ope_no_ident_pay_type_'+this.ope_no_ident.id+'_gi_'+this.general_index+'_pg_'+ind_pago).val()
					if(pay_type != 1){
						nro_op = pago_act.nro_ope
						this.deu_ag.forEach((deuda, ind_deu) => {
							if(deuda.pagado){
								deuda.pagos.forEach((pago_gen, ind_pago_gen) => {
									if(ind_deu == this.general_index && ind_pago == ind_pago_gen){
									} else {
										if(pago_gen.nro_ope == nro_op && sale){
											toastr.warning('El nro de operación: '+nro_op+' le pertenece a otro pago que ha realizado', 'Disculpe!')
											sale = false
										}
									}
								})
							}
						})
					}
				})
			} else if(type == 'sm_deuda'){
				this.sm.pagos.forEach((pago_act, ind_pago) => {
					pay_type = $('#sm_ope_no_ident_pay_type_'+this.ope_no_ident.id+'_pg_'+ind_pago).val()
					if(pay_type > 1){
						nro_op = pago_act.nro_ope
						this.sm.pagos.forEach((pago_gen, ind_pago_gen) => {
							if(ind_pago != ind_pago_gen){
								if(pago_gen.nro_ope == nro_op && sale){
									toastr.warning('El nro de operacion: '+nro_op+' le pertenece a otro pago que ha realizado', 'Disculpe!')
									sale = false
								}
							}
						})
					} else if(pay_type == 0){
						toastr.warning('Seleccione un tipo de pago', 'Disculpe!')
						sale = false
					}
				})
			}
			//console.log(sale)
			return sale
		},
		val_register_pago_deudas(type){
			let pay = !1
			if(type == 'conso'){
				this.monto_pagos_general_conso = 0
				this.pag_con.forEach(deuda => {
					if(deuda.pagado) pay = !0
					this.monto_pagos_general_conso += deuda.total_abono
				})
				this.save_payments_conso = pay
				this.monto_resta_general_conso = this.ope_no_ident.monto - this.monto_pagos_general_conso
				if(this.monto_resta_general_conso.toString().split('.').length > 1){
					this.monto_resta_general_conso.toFixed(2)
				}
			} else if(type == 'deuda'){
				this.monto_pagos_general = 0
				this.deu_ag.forEach(deuda => {
					if(deuda.pagado) pay = !0
					this.monto_pagos_general += deuda.total_abono
				})
				this.save_payments = pay
				this.monto_resta_general = this.ope_no_ident.monto - this.monto_pagos_general
				if(this.monto_resta_general.toString().split('.').length > 1){
					this.monto_resta_general.toFixed(2)
				}
			} else if(type == 'sm_deuda'){
				if(this.sm.pagado) pay = !0
				if(this.ope_no_ident_type == 1){
					this.monto_pagos_general = this.sm.total_abono
					this.save_payments = pay
					this.monto_resta_general = this.ope_no_ident.monto - this.monto_pagos_general
					if(this.monto_resta_general.toString().split('.').length > 1){
						this.monto_resta_general.toFixed(2)
					}
				} else if(this.ope_no_ident_type == 2){
					this.monto_pagos_general_conso = this.sm.total_abono
					this.save_payments_conso = pay
					this.monto_resta_general_conso = this.ope_no_ident.monto - this.monto_pagos_general_conso
					if(this.monto_resta_general_conso.toString().split('.').length > 1){
						this.monto_resta_general_conso.toFixed(2)
					}
				}
			}
		},
		register_payments(type){
			swal({
    			title: "Disculpe!.",
    			text: "¿Está seguro de que desea guardar estos pagos a las deudas seleccionadas?.",
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
    				this.alert_loader({
		                text:   'Se está procesando su solicitud',
		                icon:   'loader',
		                click:  false,
		                esc:    false,
		                time:   false,
		            });
    				let o = this.options.filter(opt => {
						if(opt.value == this.ope_no_ident_type) return opt
					})
    				let deus_to_send = []
    				let regist_sm = false
    				let url_register_payments = this.route + '/tablero/opebanks/register/payments/deudas'
    				if(this.sm_pagos.length > 0){
    					deus_to_send = this.sm_pagos
    					regist_sm = true
    				} else {
	    				if(type == 'deuda'){
		    				this.deu_ag.forEach(deuda => {
								if(deuda.pagado){
									deus_to_send.push(deuda)
								}
							})
	    				} else if(type == 'conso'){
	    					this.pag_con.forEach(deuda => {
								if(deuda.pagado){
									deus_to_send.push(deuda)
								}
							})
	    				}	
    				}
					axios.post(url_register_payments, {
						deudas: deus_to_send,
						rg_sm: regist_sm,
						sm: this.sm,
						operation: this.ope_no_ident,
						option: o,
						proced: this.procedencia,
						type: type,
					}).then(response => {
						console.log(response.data)
						toastr.success(response.data.message, 'Excelente!.')
						this.monto_pagos_general = 0
						this.monto_resta_general = 0
						this.monto_pagos_general_conso = 0
						this.monto_resta_general_conso = 0
						opebanks.load_opebanks()
						this.closeModal(type)
					}).catch(error => {
						console.log(error)
						console.log(error.response)
						if(error.response.status == '409'){
							toastr.warning(error.response.data.message)
							swal.close()
						} else {
							document.write(error.response.data)
						}
					})
    			}
    		})
		},
		reset_pagos(type){
			if(type == 'deuda'){
				this.deu_ag[this.general_index].pagos = []
				this.create_pago_deuda()
				this.val_monto(0)
				this.val_register_pago_deudas('deuda')
				this.deu_ag[this.general_index].btn_reset_pagos = !0
			} else if(type == 'conso'){
				this.pag_con[this.general_index_conso].pagos = []
				this.create_pago_conso()
				this.val_monto_pago_conso(0)
				this.val_register_pago_deudas('conso')
				this.pag_con[this.general_index_conso].btn_reset_pagos = !0
			} else if(type == 'sm_deuda'){
				this.sm.pagos = []
				this.create_pago_sm()
				this.val_monto_sm(0)
				this.val_register_pago_deudas(type)
				this.sm.btn_reset_pagos = !0
			}
		},
		validate_full_price(type){
			if(type == 'deuda'){
				console.log(this.pag_con[this.general_index_conso].full_price)
				if (this.deu_ag[this.general_index].full_price){
					if(this.deu_ag[this.general_index].pagos.length > 1){
						this.deu_ag[this.general_index].pagos.splice(1)
					}
					let act = !1
					this.deu_ag.forEach((deuda, index) => {
						if(index != this.general_index && deuda.full_price) act = !0;
					})
					if(!act){
						this.monto_resta_general = parseFloat(this.ope_no_ident.monto)
					}
					this.deu_ag[this.general_index].pagos[0].abono = parseFloat(this.monto_resta_general)
					this.deu_ag[this.general_index].total_abono = parseFloat(this.monto_resta_general)
					this.deu_ag[this.general_index].resta = (parseFloat(this.deu_ag[this.general_index].monto) - parseFloat(this.deu_ag[this.general_index].total_abono)).toFixed(2)
					$("#plus_deuda_"+this.general_index).attr('disabled', true)
				} else {
					$("#plus_deuda_"+this.general_index).attr('disabled', false)
					this.monto_resta_general = parseFloat(this.deu_ag[this.general_index].total_abono)
					this.reset_pagos(type)
				}
			} else if(type == 'conso'){
				console.log(this.general_index_conso)
				if(this.pag_con[this.general_index_conso].full_price){
					console.log('paso')
					if(this.pag_con[this.general_index_conso].pagos.length > 1){
						this.pag_con[this.general_index_conso].pagos.splice(1)
					}
					let act = false
					this.pag_con.forEach((deuda, index) => {
						if(index != this.general_index_conso && deuda.full_price){
							console.log(act)
							act = true;
						}
					})
					if(!act){
						this.monto_resta_general = parseFloat(this.ope_no_ident.monto)
					}


					this.pag_con[this.general_index_conso].pagos[0].abono = parseFloat(this.monto_resta_general)
					this.pag_con[this.general_index_conso].total_abono = parseFloat(this.monto_resta_general)
					this.pag_con[this.general_index_conso].resta = 0/*(parseFloat(this.pag_con[this.general_index_conso].monto) - parseFloat(this.pag_con[this.general_index_conso].total_abono)).toFixed(2)*/
					$("#plus_deuda_conso_"+this.general_index_conso).attr('disabled', true)

				} else {
					console.log('no paso')
					$("#plus_deuda_conso_"+this.general_index_conso).attr('disabled', false)
					this.monto_resta_general = parseFloat(this.pag_con[this.general_index_conso].total_abono)
					this.reset_pagos(type)
				}
			} else if(type == 'sm_deuda'){
				if(this.sm.full_price){
					if(parseFloat(this.ope_no_ident.monto) > parseFloat(this.sm.monto)){
						let resto = parseFloat(this.ope_no_ident.monto) - parseFloat(this.sm.monto)
						/* validacion para levantar un sweetalert y preguntarle si desea proceder aun cuando se van a perder el resto del monto */
						swal({
			    			title: "Disculpe!.",
			    			text: "Existe un restante de $"+resto+" en la operacion bancaria. ¿Está seguro de que desea usar un redondeo para eliminar ese restante?.",
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
			    			timer: false,
			    		}).then(acepted => {
			    			if(acepted){
			    				if(this.sm.pagos.length > 1){
									this.sm.pagos.splice(1)
								}
								this.sm.pagos[0].abono = parseFloat(this.monto_resta_general)
								this.sm.total_abono = parseFloat(this.monto_resta_general)
								this.sm.resta = 0
								$("#plus_sm_deuda").attr('disabled', true)
			    			} else this.sm.full_price = !1
			    		})
					} else {
						if(this.sm.pagos.length > 1){
							this.sm.pagos.splice(1)
						}
						this.sm.pagos[0].abono = parseFloat(this.monto_resta_general)
						this.sm.total_abono = parseFloat(this.monto_resta_general)
						this.sm.resta = 0
						$("#plus_sm_deuda").attr('disabled', true)
					}
				} else {
					this.monto_resta_general = parseFloat(this.sm.total_abono)
					this.sm.pagos[0].abono = 0
					this.sm.total_abono = 0
					this.sm.resta = this.sm.monto
					$("#plus_sm_deuda").attr('disabled', false)
					this.reset_pagos(type)
				}
			}
		},

		// Pago a Consolidadores
		load_pagos_conso(){
			this.alert_loader({
                text:   'Se está buscando pagos a consolidadores',
                icon:   'loader',
                click:  false,
                esc:    false,
                time:   false,
            });
			let url_load_pagos_conso = this.route + '/tablero/opebanks/load/data/deudas/pagos/conso/' + this.ope_no_ident.nro_operacion + '/monto/' + this.ope_no_ident.monto
			axios.get(url_load_pagos_conso).then(response => {
				//console.log(response.data)
				this.pagos_conso = []
				this.pag_con = []
				this.pagos_conso = response.data.deudas_pagos_conso
				this.generate_pagos_conso()
				swal.close()
				$('#modal_deudas_pagos_conso').modal('show')
			}).catch(error => {
				console.log(error)
				console.log(error.response)
				document.write(error.response.data)
			})
		},
		load_pagos_conso_fechas(){
			if(this.fecha_d != null && this.fecha_d != '' && this.fecha_h != null && this.fecha_h != ''){
				this.alert_loader({
	                text:   'Se está buscando pagos a consolidadores en las fechas seleccionadas',
	                icon:   'loader',
	                click:  false,
	                esc:    false,
	                time:   false,
	            });
				let url_load_pagos_conso_fechas = this.route + '/tablero/opebanks/load/data/deudas/pagos/conso/fechas/' + this.fecha_d +'/'+ this.fecha_h + '/monto/' + this.ope_no_ident.monto
				axios.get(url_load_pagos_conso_fechas).then(response => {
					//console.log(response.data.deudas_pagos_conso)
					/* response.data.deudas_agencia.forEach(d => {
						console.log(d)
						console.log(d.id)
						console.log(d.fecha)
					}) */
					this.pagos_conso = []
					this.pag_con = []
					this.pagos_conso = response.data.deudas_pagos_conso
					this.generate_pagos_conso() 
					swal.close()
				}).catch(error => {
					console.log(error)
					console.log(error.response)
					document.write(error.response.data)
				})
			} else toastr.warning('Los campos Desde y Hasta no pueden estar vacios y deben tener un formato aceptado!', 'Disculpe!')
		},
		create_pago_conso(){
			this.pag_con[this.general_index_conso].pagos.push(
				{
					type: 0,
					banco_emi: null,
					banco_recep: null,
					nro_ope: null,
					abono: 0,
					validate: {
						b_emi: false,
						b_recep: false,
						n_ope: false,
						abn: false,
					}
				}
			)
		},
		delete_pago_conso(index){
			this.pag_con[this.general_index].pagos.splice(index, 1)
			//this.val_monto(0)
		},
		val_monto_pago_conso(index){
			let ab = this.pag_con[this.general_index_conso].pagos[index].abono
			let rst = this.pag_con[this.general_index_conso].resta
			//ab = parseFloat(ab)
			let total_abono = 0
			//console.log(ab)
			//return
			if(ab.length == 0){
				this.pag_con[this.general_index_conso].pagos[index].abono = ''
				ab = 0
			}
			if(ab.length == undefined){
				ab = 0
			}
			if (ab != '' && ab != null && ab.length > 0 || ab.length == undefined) {
				//console.log('entro en eval')
				if(ab == 0){
					this.pag_con[this.general_index_conso].pagos[index].abono = 0
				}
				this.pag_con[this.general_index_conso].total_abono = 0
				this.pag_con[this.general_index_conso].pagos.forEach((pago, index) => {
					this.pag_con[this.general_index_conso].total_abono += parseFloat(pago.abono)
				})
				this.pag_con[this.general_index_conso].resta = (parseFloat(this.pag_con[this.general_index_conso].monto) - parseFloat(this.pag_con[this.general_index_conso].total_abono)).toFixed(2)
			}
			//console.log(this.pag_con[this.general_index_conso].resta)
			if(parseFloat(this.pag_con[this.general_index_conso].resta) < 0){
				toastr.warning('La cant restante no puede ser menor a 0', 'Disculpe!')
				return
			}
			if(this.pag_con[this.general_index_conso].resta < 0 || this.pag_con[this.general_index_conso].resta == this.pag_con[this.general_index_conso].monto){
				this.pag_con[this.general_index_conso].pagado = false
				this.val_register_pago_deudas('conso')
			}
		},
		val_pay_type_conso(index){
			let pay_type = $('#conso_ope_no_ident_pay_type_'+this.ope_no_ident.id+'_gi_'+this.general_index_conso+'_pg_'+index).val()
			let emi_bank = $('#conso_ope_no_ident_emi_bank_'+this.ope_no_ident.id+'_gi_'+this.general_index_conso+'_pg_'+index).val()
			let recep_bank = $('#conso_ope_no_ident_recep_bank_'+this.ope_no_ident.id+'_gi_'+this.general_index_conso+'_pg_'+index).val()

			$('#conso_ope_no_ident_emi_bank_'+this.ope_no_ident.id+'_gi_'+this.general_index_conso+'_pg_'+index).select2()
			$('#conso_ope_no_ident_recep_bank_'+this.ope_no_ident.id+'_gi_'+this.general_index_conso+'_pg_'+index).select2()

			if(pay_type == 0 || pay_type == 1){
				this.pag_con[this.general_index_conso].pagos[index].banco_emi = null
				this.pag_con[this.general_index_conso].pagos[index].banco_recep = null
				this.pag_con[this.general_index_conso].pagos[index].nro_ope = null
				this.pag_con[this.general_index_conso].pagos[index].validate = {
					b_emi: false,
					b_recep: false,
					n_ope: false,
					abn: true,
				}
				this.pag_con[this.general_index_conso].btn_reset_pagos = !1
				if(pay_type == 0){
					this.pag_con[this.general_index_conso].pagos[index].abono = 0
					this.pag_con[this.general_index_conso].pagos[index].validate.abn = false
					this.val_monto_pago_conso(index)
					this.pag_con[this.general_index_conso].btn_reset_pagos = !0
				}
			} else {
				this.pag_con[this.general_index_conso].pagos[index].banco_emi = emi_bank
				this.pag_con[this.general_index_conso].pagos[index].banco_recep = recep_bank		
				this.pag_con[this.general_index_conso].pagos[index].validate = {
					b_emi: true,
					b_recep: true,
					n_ope: true,
					abn: true,
				}
				this.pag_con[this.general_index_conso].btn_reset_pagos = !1
			}
		},

		// GASTOS
		closeModalGasto(){
			this.tipo_gasto = ''
			this.descripcion_gasto = ''
			this.add_contability = !1
			this.yes_suc = !1
			$("#ope_no_ident_type_"+this.ope_no_ident.id).val('0')
			$("#modal_gastos").modal('hide')
		},
		add_gasto_contab(y){
			this.sucursal = 0
			this.add_contability = y
			this.yes_suc = y
		},
		sel_yes_suc(){
			if(this.sucursal != 0){
				this.yes_suc = !1
			} else {
				this.yes_suc = !0
			}
		},
		register_gasto(){
			swal({
    			title: "Disculpe!.",
    			text: "¿Está seguro de que desea guardar este gasto?.",
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
    				let url_register_gastos = this.route + '/tablero/opebanks/register/gasto'
    				let o = this.options.filter(opt => {
						if(opt.value == this.ope_no_ident_type) return opt
					})
    				axios.post(url_register_gastos, {
    					operation: this.ope_no_ident,
    					sucursal: this.sucursal,
    					tipo_gasto: this.tipo_gasto,
    					descripcion_gasto: this.descripcion_gasto,
    					add_contability: this.add_contability,
    					proced: this.procedencia,
    					option: o,
    				}).then(response => {
    					//console.log(response.data)
    					toastr.success(response.data.message, 'Excelente!.')
    					opebanks.load_opebanks()
    					this.closeModalGasto()
    				})
    			}
    		}).catch(error => {
				console.log(error)
				console.log(error.response)
				if(error.response.status == '409'){
					toastr.warning(error.response.data.message)
					swal.close()
				} else {
					document.write(error.response.data)
				}
			})
		},

		// DELETE OPEBANK
		delete_ope_bank(ope_id){
			swal({
    			title: "Disculpe!.",
    			text: "¿Está seguro de que desea eliminar esta operación bancaria?.",
    			icon: "warning",
    			buttons: {
    				cancel: "Cancelar",
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
    				let url_register_gastos = this.route + '/tablero/opebanks/destroy'
    				axios.post(url_register_gastos, {operation: ope_id}).then(response => {
    					//console.log(response.data)
    					swal.close()
    					toastr.success(response.data.message, 'Excelente!.')
    					opebanks.load_opebanks()
    				})
    			}
    		}).catch(error => {
				console.log(error)
				console.log(error.response)
				document.write(error.response.data)
			})
		},

		// SELECCION MULTIPLE
		create_sm(){
			this.sm = {
				monto: 0,
				pagos: [
				{
					type: 0,
					banco_emi: null,
					banco_recep: null,
					nro_ope: null,
					abono: 0,
					validate: {
						b_emi: false,
						b_recep: false,
						n_ope: false,
						abn: false,
					}
				}
				],
				total_abono: 0,
				resta: 0,
				pagado: false,
				btn_reset_pagos: true,
				full_price: 0,
			}
		},
		validate_sm(){
			if(this.sm_pagos.length >= 2){
        	    this.exe_edit_multi_pagos = 2
        	} else if( this.sm_pagos.length == 1){
        	    this.exe_edit_multi_pagos = 1
        	}else {
        	    this.exe_edit_multi_pagos = 0
        	}
        	let total = 0
        	this.sm_pagos.forEach(sm_pago => {
        		total += parseFloat(sm_pago.porpagar) 
        	})
        	if(total > this.ope_no_ident.monto){
        		//$("#btn_edit_sm").attr('disabled', true)
        		toastr.warning('Tenga en cuenta que ha excedido el monto disponible para identificar', 'Estimado Usuario!')
        		this.ha_excedido_multi = true
        		this.excedente_multi = this.excedente_multi_modif = (total - parseFloat(this.ope_no_ident.monto)).toFixed(2)
        	} else {
        		$("#btn_edit_sm").attr('disabled', false)
        		this.ha_excedido_multi = false
        	}
        	if(this.ha_editado_multi){
        		this.save_payments = !1
        	}
        },
        showModal(modal){
        	this.sm.monto = 0
        	if(this.sm.total_abono == 0) this.sm.resta = 0;
        	this.sm_pagos.forEach(d => {
        		this.sm.monto += parseFloat(d.porpagar)
        		if(this.sm.total_abono == 0){
        			this.sm.resta += parseFloat(d.porpagar)
        		}

				d.excedente = 0

        		if(d.tarifa_fee != d.porpagar) d.tarifa_fee = d.porpagar
        	})
        	if(this.sm.monto.toString().split('.').length > 1){
        		if(this.sm.monto.toString().split('.')[1].length > 2) this.sm.monto = parseFloat(this.sm.monto).toFixed(2)
        	}
        	if(this.sm.resta.toString().split('.').length > 1){
        		if(this.sm.resta.toString().split('.')[1].length > 2) this.sm.resta = parseFloat(this.sm.resta).toFixed(2)
        	}
        	if(this.ope_no_ident_type == 2){
        		$("#"+modal).css('z-index', 9999)
        	}
        	$("#"+modal).modal('show')
        },
        clear_selected(){
        	this.sm_pagos = []
        	this.exe_edit_multi_pagos = 0
        	$("input[class='cl_check_sm']:checked").removeAttr("checked");
        	this.val_register_pago_deudas('sm_deuda')
    	},
        val_pay_type_sm(index){
        	let pay_type = $('#sm_ope_no_ident_pay_type_'+this.ope_no_ident.id+'_pg_'+index).val()
			let emi_bank = $('#sm_ope_no_ident_emi_bank_'+this.ope_no_ident.id+'_pg_'+index).val()
			let recep_bank = $('#ope_no_ident_recep_bank_'+this.ope_no_ident.id+'_pg_'+index).val()

			$('#sm_ope_no_ident_emi_bank_'+this.ope_no_ident.id+'_pg_'+index).select2()
			$('#ope_no_ident_recep_bank_'+this.ope_no_ident.id+'_pg_'+index).select2()

			if(pay_type == 0 || pay_type == 1){
				this.sm.pagos[index].banco_emi = null
				this.sm.pagos[index].banco_recep = null
				this.sm.pagos[index].nro_ope = null
				this.sm.pagos[index].validate = {
					b_emi: false,
					b_recep: false,
					n_ope: false,
					abn: true,
				}
				this.sm.btn_reset_pagos = !1
				if(pay_type == 0){
					this.sm.pagos[index].abono = 0
					this.sm.pagos[index].validate.abn = false
					//this.val_monto(index)
					this.sm.btn_reset_pagos = !0
				}
			} else {
				this.sm.pagos[index].banco_emi = emi_bank
				this.sm.pagos[index].banco_recep = recep_bank		
				this.sm.pagos[index].validate = {
					b_emi: true,
					b_recep: true,
					n_ope: true,
					abn: true,
				}
				this.sm.btn_reset_pagos = !1
			}
        },
        create_pago_sm(){
        	this.sm.pagos.push(
				{
					type: 0,
					banco_emi: null,
					banco_recep: null,
					nro_ope: null,
					abono: 0,
					validate: {
						b_emi: false,
						b_recep: false,
						n_ope: false,
						abn: false,
					}
				}
			)
        },
        delete_pago_sm(index){
        	this.sm.pagos.splice(index, 1)
			this.val_monto_sm(0)
        },
        set_type_emi_bank_sm(t){
        	let emi = $(t)
			let ind_emi = emi.attr('name').split('_pg_')[1]
			let emi_bank = emi.val()
			this.sm.pagos[ind_emi].banco_emi = emi_bank
        },
        set_type_recep_bank_sm(t){
			let recep = $(t)
			let ind_recep = recep.attr('name').split('_pg_')[1]
			let recep_bank = recep.val()
			this.sm.pagos[ind_recep].recep_bank = recep_bank
		},
		val_monto_sm(index){
			let ab = this.sm.pagos[index].abono
			let rst = this.sm.resta
			//ab = parseFloat(ab)
			let total_abono = 0
			//console.log(ab)
			
			if(ab.length == 0){
				this.sm.pagos[index].abono = ''
				ab = 0
			}
			if(ab.length == undefined){
				ab = 0
			}
			if (ab != '' && ab != null && ab.length > 0 || ab.length == undefined) {
				//console.log('entro en eval')
				if(ab == 0){
					this.sm.pagos[index].abono = 0
				}
				this.sm.total_abono = 0
				this.sm.pagos.forEach((pago, index) => {
					this.sm.total_abono += parseFloat(pago.abono)
				})
				if(this.sm.total_abono == this.ope_no_ident.monto){
					this.sm.resta = 0
				} else {
					this.sm.resta = (parseFloat(this.sm.monto) - parseFloat(this.sm.total_abono)).toFixed(2)
				}
			}
			if(this.sm.resta < 0){
				toastr.warning('La cant restante no puede ser menor a 0', 'Disculpe!')
				return
			}
			if(this.sm.resta < 0 || this.sm.resta == this.sm.monto){
				this.sm.pagado = false
				this.val_register_pago_deudas('sm_deuda')
			}
		},
		val_monto_resta_sm(index){
			let total_new_cant = 0
			let s = this.sm_pagos[index]
			if(parseFloat(s.excedente) >= 0 && parseFloat(s.excedente) <= this.excedente_multi){
				this.excedente_multi_modif = parseFloat(this.excedente_multi)
				this.sm_pagos.forEach(deu => {
					deu.tarifa_fee = parseFloat(deu.porpagar)
					deu.excedente = parseFloat(deu.excedente)
					
					if(deu.excedente > 0 && deu.excedente <= this.excedente_multi_modif && deu.excedente <= deu.tarifa_fee){
						this.excedente_multi_modif -= deu.excedente
						deu.tarifa_fee = parseFloat(deu.porpagar) - deu.excedente
					} else if(deu.excedente > this.excedente_multi_modif){
						toastr.warning('El excedente ingresado no es correcto, por favor verifique')
					} else if(deu.excedente == 0){
						deu.tarifa_fee = parseFloat(deu.porpagar)
					}

					if(deu.excedente.toString().split('.').length > 1){
						if(deu.excedente.toString().split('.')[1].length > 2){
							deu.excedente = deu.excedente.toFixed(2)
						}
					}

					if(deu.tarifa_fee.toString().split('.').length > 1){
						if(deu.tarifa_fee.toString().split('.')[1].length > 2){
							deu.tarifa_fee = deu.tarifa_fee.toFixed(2)
						}
					}

					if(this.excedente_multi_modif < 0){
						deu.tarifa_fee = deu.porpagar
						deu.excedente = 0
						this.val_monto_resta_sm(index)
						toastr.warning('Excedente no aceptado, inserte de nuevo el monto excedente');
					}

					if(this.excedente_multi_modif.toString().split('.').length > 1){
						if(this.excedente_multi_modif.toString().split('.')[1].length > 2){
							this.excedente_multi_modif = this.excedente_multi_modif.toFixed(2)
						}
					}
				})
			} else toastr.warning('Coloca un monto válido')
			//console.log(total_new_cant)
		},
    }
})

Vue.component('templ_opebanks_ident', {
	template: "#template_opebanks_ident",
	props: ['opebanks_ident'],
	data(){
		return {
			route: APP_URL,
			block: false,

			pageSize: 10,
			currentPage: 1,
			totalPage: 0,
			showUpto: 10,
			showFromto: 0,
			ope_ident: {},

			search: '',
		}
	},
	computed: {
		opebanks_ident_list(){
    		this.totalPage = Math.ceil(this.opebanks_ident.length / this.pageSize);
	    	let self = this
      		let search = self.search.toLowerCase()
      		var list = this.opebanks_ident.slice(this.showFromto, this.showUpto)
      		return list
    	},
	},
	methods: {
		//
	}
})

const opebanks = new Vue({
	el: '#app_opebanks',
	created(){
		this.set_dft_date()
		this.pre_load_opebanks()
	},
	data: {
		route: APP_URL,
		gdate: new Date(),
		actual_date: '',
		fecha_d: '',
		fecha_h: '',
		opebanks_ident: [],
		opebanks_no_ident: [],
		pay_types: [],
		emisor_banks: [],
		receptor_banks: [],

		// Data Edit Multiple
		/*sm_pagos: [],
		exe_edit_multi_pagos: 0,*/
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
			this.fecha_d = /*date*/  '2019-01-01' 
			this.fecha_h = /*date*/  '2019-06-26' 

			//console.log(date)
		},
		pre_load_opebanks(){
            this.alert_loader({
                text:   'Se está buscando operaciones bancarias',
                icon:   'loader',
                click:  false,
                esc:    false,
                time:   false,
            });
            this.load_opebanks()
            setTimeout(() => {
            	if(this.opebanks_no_ident.length > 0){
            		swal.close()
            	}
            }, 20000)
        },
        load_opebanks(){
        	let url_load_opebanks = this.route + '/tablero/opebanks/load/data/'+this.fecha_d+'/'+this.fecha_h
        	axios.get(url_load_opebanks).then(response => {
        		//console.log(response.data)
        		this.pay_types = response.data.pay_types
        		this.emisor_banks = response.data.emisor_banks
        		this.receptor_banks = response.data.receptor_banks
        		this.opebanks_ident = response.data.opebanks_ident
        		this.opebanks_no_ident = response.data.opebanks_no_ident
        		swal.close()

    			this.$children[0].pay_types = this.pay_types
    			this.$children[0].emisor_banks = this.emisor_banks
    			this.$children[0].receptor_banks = this.receptor_banks
        	}).catch(error => {
        		console.log(error)
        		console.log(error.response)
        		//document.write(error.response.data)
        		if(error.response.status == '500'){
        			this.load_opebanks()
        			console.clear()
        		}
        	})
        },
        load_document(event){
        	let name = event.target.files[0].name
        	let ar_name = name.split('.')
        	let n = ar_name.length
        	if(ar_name.length > 1){
        		//xlsx xls
        		if(ar_name[n-1] == 'xls' || ar_name[n-1] == 'xlsx'){
        			toastr.info('Archivo cargado', 'Excelente!')
        		} else {
        			toastr.warning('El archivo que seleccionó no es un archivo excel', 'Disculpe!')
        			event.target.value = ""
        		}
        	} else {
        		toastr.error('El archivo que seleccionó no tiene una extensión', 'Error!')
        		event.target.value = ""
        	}
        },
	}
})