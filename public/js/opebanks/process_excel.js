Vue.component('t_process_excel',{
	template:"#t_process_excel",
	props: ['data_excel'],
	data: function() {
	    return {
			route: APP_URL,
			block: false,

		    pageSize: 10,	// Cantidad de registros por vista
		    currentPage: 1, // Pagina Actual
		    totalPage: 0,	// Cantidad de Paginas totales
		    showUpto: 10,	// Cantidad de Reg que se van a mostrar a la der
			showFromto: 0,	// Cantidad de Reg que se van a mostrar a la izq
			item: [],

			// multiples
			sm_data: [],
			total_sm_active: false,

			search: '',

			abstractData: [],
	    }
    },
    computed:{
    	data_list(){
    		this.totalPage = Math.ceil(this.data_excel.length / this.pageSize)
    		let self = this
      		let search = self.search.toLowerCase()
      		var list = this.data_excel.slice(this.showFromto, this.showUpto)
      		return list
    	}
    },
    methods:{
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
		set_sm(){
			process_data_excel.multis_save = this.sm_data
        },
        set_sm_all(){
        	this.sm_data = []
        	if(!this.total_sm_active){
	        	this.data_excel.forEach(de => {
	        		this.sm_data.push(de)
	        	})
	        	this.total_sm_active = !0
        	} else this.total_sm_active = !1
        	this.set_sm()
        },
    }
})

const process_data_excel = new Vue({
	el: "#process_data_excel",
	created(){
		this.data_excel = data
		//console.log(data)
	},
	data: {
		route: APP_URL,
		data_excel: [],
		multis_save: [],
	},
	methods:{
		alert(options){
            // title, text, icon, click, esc, time = false
			swal({
				title: options.title,
				text: options.text,
				icon: options.icon,
				button: {
					text: "Ok"
				},
				dangerMode: true,
				closeOnClickOutside: options.click,
				closeOnEsc: options.esc,
				timer: options.time,
			});
		},
		save_process(){
			let banco = $('#banco').val(),
				moneda = $('#moneda').val()
			if(banco == 0){
				toastr.warning('Debe seleccionar un banco', 'Disculpe!')
				return;
			}
			if(moneda == 0){
				toastr.warning('Debe seleccionar una moneda', 'Disculpe!')
				return;	
			}
			if(this.multis_save.length == 0){
				toastr.warning('Seleccione los registros que desea procesar hacia el sistema', 'Disculpe!')
				return;		
			}
			toastr.info('Los registros estan siendo procesados.', 'Bien!');
			let url_save_process = this.route + '/tablero/opebanks/save/process/excel'
			axios.post(url_save_process, {
				registros: this.multis_save,
				banco: banco,
				moneda: moneda
			}).then(response => {
				//console.log(response.data)
				toastr.success(response.data.message, 'Excelente!')
				this.reset_data(response.data)
				//toastr.success('Será redireccionado al listado de operaciones en 3 seg', 'Excelente!')
			}).catch(error => {
				console.log(error)
				console.log(error.response)
				if(error.response != undefined) document.write(error.response.data)
                if(error.status == 500){
                    toastr.info('Ha ocurrido un error durante el guardado, por favor intente nuevamente.', 'Disculpe!');
                }
			})
		},
		reset_data(data){
			let op = {
                title: '',
                text: '',
                icon: '',
                buttons: {
                	"ver": {
                    	text: 'Ver',
                    	value: 0,
                    	className: 'btn-info',
                    },
                    "seguir": {
                        text: 'Seguir procesando',
                        value: 1,
                        className: 'bg-green'
                    },
                    "quit": {
                    	text: 'Salir',
                    	value: 2,
                    	className: 'btn-danger'
                    }
                },
				closeOnClickOutside: false,
				closeOnEsc: false,
            }
			if(data.type == 0){
				op.title = 'Disculpe!.'
				op.text	 = data.message
				op.icon  = 'warning'
			} else if(data.type == 1){
				op.title = 'Excelente!.'
				op.text	 = data.message
				op.icon  = 'success'
			} else if(data.type == 2){
				op.title = 'Bien!.'
				op.text	 = data.message
				op.icon  = 'info'
			}
			swal(op).then(action => {
				//console.log(action)
				if(action == 2){
					window.location.href = this.route +'/tablero/opebanks/admin'
				}
				if(action == 1 || action == 0){
					let m = this.multis_save.reverse()
					m.forEach(o => {
						this.$children[0].data_excel.splice(o.index, 1)
					})
					this.multis_save = []
					this.$children[0].sm_data = []

					this.$children[0].data_excel.forEach((o, i) => {
						o.index = i
					})
					if(action == 0){
						//
					}
				}
			})
		},
		salir(){
			window.location.href = this.route +'/tablero/opebanks/admin'
		}
	}
})