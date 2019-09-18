$(document).ready(() => {
	let a = $('.paginate_button').children();
	a.on('click', function(){
		mod();
		am();
	});
})
function mod(){
	mod = setInterval(() => {
		am();
		let a = $('.paginate_button').children();
		$.each(a, function(i,v){
			$(v).attr('onclick', 'am()');
		});
	}, 500);
}
function am(){
	let dst_pqt = paso2.dp;
	if(dst_pqt != '' && paso2.s_ind || paso2.s_todos){
		if(paso2.s_multi && paso2.parent_multi_selected == dst_pqt.id){
			$('.check_hijo_'+dst_pqt.id).css('display','');
			$('.radio_hijo_'+dst_pqt.id).css('display','none');
			if(paso2.s_ind){
				$('#s_multi_padre_'+dst_pqt.id).prop("checked", true);
				//$('.check_hijo_'+dst_pqt.id).removeAttr('checked');
			}
			if(paso2.s_todos){
				$('#s_multi_padre_'+dst_pqt.id).removeAttr('checked');
				$('.check_hijo_'+dst_pqt.id).prop("checked", true);
			};
		}
	} else {
		$('.check_hijo_'+dst_pqt.id).css('display','none');
		$('.radio_hijo_'+dst_pqt.id).css('display','');
	}
}

// Start Vue Component
const d_table = Vue.component('datatable',{
	template:"#datatable",
	props: ['enlazados'],
	data: function() {
	  return {
		pageSize: 10,
		currentPage: 1,
		totalPage: 0,
		showUpto: 10,
		showFromto: 0,
		destacados: [],
	  }
	},
	computed: {
	  	orderedList() {
			var list = this.enlazados.slice(this.showFromto, this.showUpto);
			this.totalPage = Math.ceil(this.enlazados.length / this.pageSize);
			this.destacados = [];
			this.enlazados.forEach(en => {
				if(en.destacado == 1){
					this.destacados.push(en.codigo);
				}
			})
			return list;
	  	}
	},
	methods: {
	  	changeSelect:function(){
			this.showUpto = this.pageSize;
			this.currentPage = 1;
			this.showFromto = 0;
			this.set_input_to_check();
	  	},
	  	nextPage:function() {
			if (this.currentPage != this.totalPage){
		  		this.showFromto = (this.currentPage * this.pageSize) ;
		  		this.currentPage =  this.currentPage + 1;
		  		this.showUpto = (this.currentPage * this.pageSize);
			}
			this.set_input_to_check();
	  	},
	  	previousPage:function() {
			if (this.currentPage != 1){
			  	this.showFromto = ((this.currentPage - 2) * this.pageSize);
			  	this.currentPage =  this.currentPage - 1;
			  	this.showUpto = (this.currentPage * this.pageSize);
			}
			this.set_input_to_check();
	  	},
	  	quitar_enlace(codigo_enlace){
			paso2.quitar_enlace(codigo_enlace);
		},
		set_destacados(codigo_enlace){
			paso2.enlazados.forEach(enl => {
				if(enl.codigo == codigo_enlace){
					if(enl.destacado == 1){
						setTimeout(() => {
							$("#check_hijo_dest_"+enl.codigo).removeAttr("checked");
						}, 1000);
					}
				}
			})
			console.log(this.destacados.length);
			if(this.destacados.length <= 5){
				this.set_input_to_check();
				paso2.setDestacados(codigo_enlace);
			} else if(this.destacados.length > 5 && this.destacados.indexOf(codigo_enlace) != -1) {
				toastr.warning("Ya tiene seleccionado los 5 hoteles a destacar!", "Disculpe!.");
				this.destacados.splice(codigo_enlace,1);
			}
		},
		set_input_to_check(){
			setTimeout(() => {
				paso2.enlazados.forEach(en => {
					if(en.destacado == 1){
						$("#check_hijo_dest_"+en.codigo).prop("checked", true)
					}
				})
			}, 1000);
		},
		set_cinco_primeros(){
			swal({
				title: "Atención!.",
				text: "¿Está seguro de que desea seleccionar los 5 primeros enlazados como destacados?.",
				icon: "warning",
				buttons: {
					cancel: 'No',
					confirm: 'Si'
				},
				dangerMode: true
			}).then(response => {
				if(response){
					this.destacados = [];
					for (let i = 0; i < 5; i++) {
						this.destacados.push(this.enlazados[i].codigo);
					}
					//console.log(this.destacados);
					paso2.setDestacados('cinco');
					$("#cinco_destacados").attr("disabled", true)
				}
			})
		},
		clear_all(){
			swal({
				title: "Atención!.",
				text: "¿Está seguro de que desea quitar todos lo destacados?.",
				icon: "warning",
				buttons: {
					cancel: 'No',
					confirm: 'Si'
				},
				dangerMode: true
			}).then(response => {
				if(response){
					this.destacados = [];
					paso2.setDestacados('cinco');
				}
			})
		}
	},
  })
// End Vue Component
const paso2 = new Vue({
	el: '#paso2',
	created() {
		this.paquete = paquete_act;
		this.listados = paquete_act.listados;
		this.edit = edit;
		this.pre_loader();
		this.calculos_enlazados;
	},
	data: {
		route: APP_URL,
		paquete: [],
		listados: [],
		edit: 0,
		destinos: [],
		dp: [],
		sl: '',
		s_ind: false,
		s_todos: false,
		s_multi: false,
		parent_multi_selected: 0,
		multi_selected: [],
		destinos_selected: [], // cada hotel selected con el radio-btn
		noches: '',
		destino: '',
		noche_for_multi: '',
		btn_enlazar: false,

		destacados: []/* this.$root.children[0].destacados */,
		anterior: '',

		// data computed
		enlazados: [],
	},
	methods: {
		alert_loader(text, icon, click, esc, time = false){
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
				timer: time,
            });
		},
		alert_success(text, click, esc, time = false){
			swal({
				title: "Excelente!",
				text: text,
				icon: "success",
				button: {
					text: "Ok"
				},
				dangerMode: true,
				closeOnClickOutside: click,
				closeOnEsc: esc,
				timer: time,
			});
		},
		pre_loader(){
			this.alert_loader('Cargando datos.', 'loader', false, false, 4000);
			this.cargar_destinos();
		},
		cargar_paquete(){
			let url = this.route+'/Paso/2/load/paquete/'+this.paquete.id;
			axios.get(url).then(response=>{
				this.paquete = [];
				this.listados = [];
				this.paquete = response.data;
				this.listados = response.data.listados;
				this.enlazados = [];
				paso2.calculos_enlazados;
			}).catch(error=>{
				console.log(error);
			});
		},
		cargar_destinos(){
			let mis_destinos = [];
			if(this.paquete.listados.length > 0){
				this.paquete.listados.forEach(destinoPaquete => {
					mis_destinos.push(destinoPaquete.destino_id);
				});
			}
			let url = this.route+'/Paso/2/load/destinos';
			axios.post(url,{destinos:mis_destinos, paquete:this.paquete.id}).then(response=>{
				//console.log('se cargaron destinos');
				let options = [];
				this.destinos = response.data;
				/* this.destinos.forEach(destino=>{
					options.push({text: destino.nombre, id: destino.id});
				}); */
				$("select[name='destino']").select2(/* {
					placeholder: 'Seleccione una opción',
					data: options,
				} */).on('select2:select', () => {
					var val = $("select[name='destino']").select2('data');
					this.destino = val[0].id;
				});
				swal.close();
			}).catch(error=>{
				console.clear();
				console.log(error.response);
				swal.close();
			});
		},
		agregar_destino(){
			if(this.paquete.enlazados.length == 0){
				if(this.noches != ''){
					if(this.destino != ''){
						let url = this.route+'/Paso/2/Paquete/'+this.paquete.id+'/Agregar/Destino';
						this.alert_loader('Los datos están siendo procesados!.', 'loader', false, false);
						axios.post(url,{
							noches: this.noches,
							destino: this.destino,
						}).then(response=>{
							//console.log(response.data);
							if(response.data == '1'){
								swal.close();
								this.noches = '';
								this.destino = '';
								this.cargar_paquete();
								this.cargar_destinos();
								this.alert_success('Destino agregado con exito!.', true, true, 4000);
							}
						}).catch(error=>{swal.close(); console.log(error.response);});
					} else toastr.warning('Debe seleccionar un destino.', 'Atencion!.');
				} else toastr.warning('Debe ingresar la cantidad de noches.', 'Atencion!.');
			} else toastr.error('No puede agregar mas destinos porque el paquete contiene hoteles enlazados!.', 'Atencion!.');
		},
		eliminar_destino(destino){
			if(this.paquete.enlazados.length == 0){
				swal({
					title: "Atención!.",
					text: "¿Está seguro de que desea eliminar este destino?.",
					icon: "warning",
					buttons: {
						cancel: 'No',
						confirm: 'Si'
					},
					dangerMode: true
				}).then(response => {
					if(response){
						let url = this.route+'/Paso/2/Paquete/DestroyDestino';
						this.alert_loader('El destino está siendo elimido!.', 'loader', false, false)
						axios.post(url, {destino: destino}).then(response => {
							swal.close();
							this.cargar_paquete();
							this.cargar_destinos();
							toastr.success('Destino eliminado con exito!.');
						}).catch(error => {
							swal.close();
							console.log(error.response);
						});
					}
				});
			} else toastr.error('No puede eliminar el destinos porque el paquete contiene hoteles enlazados!.');
		},
		active_multi(destinoPaquete, sl){
			this.sl = sl;
			if(!this.s_multi){
				if(sl === 'todos'){
					$('.check_hijo_'+destinoPaquete.id).css('display','');
					$('.radio_hijo_'+destinoPaquete.id).css('display','none');
					$('#s_multi_padre_'+destinoPaquete.id).removeAttr('checked');
					$('.check_hijo_'+destinoPaquete.id).prop("checked", true);
					this.multi_selected = [];
					destinoPaquete.destino.hoteles.forEach(hotel => {
						this.multi_selected.push(hotel.id);
					});
					this.s_todos = true;
				} else {
					$('.check_hijo_'+destinoPaquete.id).css('display','');
					$('.radio_hijo_'+destinoPaquete.id).css('display','none');
					this.s_ind = true;
				}
				this.s_multi = true;
				this.dp = [];
				this.dp = destinoPaquete;
				this.parent_multi_selected = destinoPaquete.id;
				this.noche_for_multi = destinoPaquete.noche_id;

				this.destinos_selected.forEach(dest=>{
					if(dest.padre == destinoPaquete.id){
						dest.dft = dest.hijo;
						dest.hijo = 0;
					}
				});
				this.validate();
			} else if(this.s_multi && this.parent_multi_selected == destinoPaquete.id){
				if(this.s_todos && this.sl === 'ind'){
					$('.check_hijo_'+destinoPaquete.id).removeAttr('checked');
					this.multi_selected = [];
					this.s_ind = true;
					this.s_todos = false;
					return;
				}
				if(this.s_ind && this.sl === 'todos'){
					this.s_ind = false;
					this.s_multi = false;
					this.active_multi(destinoPaquete, 'todos');
					return;
				};
				$('.check_hijo_'+destinoPaquete.id).css('display','none');
				$('.radio_hijo_'+destinoPaquete.id).css('display','');
				this.s_ind = false;
				this.s_todos = false;
				this.s_multi = false;
				this.parent_multi_selected = 0;
				//this.dp = [];
				this.multi_selected = [];
				this.noche_for_multi = '';

				this.destinos_selected.forEach(dest=>{
					if(dest.padre == destinoPaquete.id){
						dest.hijo = dest.dft;
						dest.dft = 0;
					}
				});
				this.validate();
			} else {
				$('#s_multi_padre_'+destinoPaquete.id).removeAttr('checked');
				toastr.warning('Ya tiene un destino con selección multiple.', 'Disculpe!.');
			}
		},
		// Creamos un slot de hotel cuando cambiamos un radio-btn de hotel
		set_destinos_selected(padre_id,hijo_id, noche_id){
			let v = false;
			if(this.destinos_selected.length > 0){
				this.destinos_selected.forEach(dest=>{
					if(dest.padre == padre_id){
						dest.hijo = hijo_id;
						v = true;
					}
				});
				if(!v) this.destinos_selected.push({padre:padre_id, hijo:hijo_id, dft:0, noche:noche_id});
			} else {
				this.destinos_selected.push({padre:padre_id, hijo:hijo_id, dft:0, noche:noche_id});
			}
			this.validate();
		},
		clear_data(){
			$("tr[class=odd]").remove();
			this.btn_enlazar = false;
			this.s_multi = false;
			this.parent_multi_selected = 0;
			this.multi_selected = [];
			this.noche_for_multi = '';
			this.destinos_selected = [];
			this.listados.forEach(list=>{
				$('#s_multi_padre_'+list.id).removeAttr('checked');
				$('.check_hijo_'+list.id).removeAttr('checked');
				$('.radio_hijo_'+list.id).removeAttr('checked');
				$('.check_hijo_'+list.id).css('display','none');
				$('.radio_hijo_'+list.id).css('display','');
			})
		},
		// Validamos cuando colocar el btn-enlazar en true o false
		validate(){
			if(this.listados.length > 1){
				if(this.multi_selected.length == 0 && this.destinos_selected.length == this.listados.length){
					this.btn_enlazar = true;
					/* this.destinos_selected.forEach(dest=>{
						if(dest.hijo == 0) this.btn_enlazar = false;
					}) */
				} else if(this.multi_selected.length > 0 && this.destinos_selected.length == this.listados.length-1){
					this.btn_enlazar = true;
				} else {
					this.btn_enlazar = false;
				}
			} else if(this.listados.length == 1){
				if(this.destinos_selected.length == 1 || this.multi_selected.length > 0){
					this.btn_enlazar = true;
				} else this.btn_enlazar = false;
			} else {
				this.btn_enlazar = false;
			}
		},
		enlazar(){
			swal({
				title: 'Atención!.',
				text: '¿Está seguro de querer enlazar estos hoteles?.',
				icon: "warning",
				buttons: {
					cancel: 'No',
					confirm: 'Si'
				},
				closeOnClickOutside: false,
                closeOnEsc: false,
				dangerMode: true,
				timer: 8000,
			}).then(response => {
				if(response){
					this.alert_loader('Enviando hoteles a enlazar', 'loader', false, false);
					let url = this.route+'/Paso/2/Enlazar/Hoteles/Paquete/'+this.paquete.id;
					axios.post(url,{
						multis:this.multi_selected,
						destinos:this.destinos_selected,
						noche: this.noche_for_multi,
					}).then(response=>{
						//console.log(response.data);
						this.paquete = response.data;
						this.listados = response.data.listados;
						swal.close();
						this.alert_success('Hoteles enlazados con exito!.', true, true, 4000);
						this.clear_data();
					}).catch(error=>{
						swal.close();
						console.log(error);
					});
				}
			});
		},
		quitar_enlace(codigo_enlace){
			let text = 'este enlace de hoteles';
			if(codigo_enlace === 'todos') text = 'todos los hoteles enlazados en este paquete';
			swal({
				title: "Atención!.",
				text: "¿Está seguro de que desea eliminar "+text+'?.',
				icon: "warning",
				buttons: {
					cancel: 'No',
					confirm: 'Si'
				},
				dangerMode: true
			}).then(response => {
				if(response){
					let to = 'Este enlace de hoteles está siendo eliminado!.';
					if(codigo_enlace === 'todos') to = 'Todos los hoteles enlazados de este paquete estan siendo eliminados!.';
					let url = this.route+'/Paso/2/Paquete/DestroyEnlace';
					this.alert_loader(to, 'loader', false, false);
					axios.post(url, {codigo: codigo_enlace, paquete:this.paquete.id}).then(response => {
						swal.close();
						//this.enlazados = [];
						this.cargar_paquete();
						this.cargar_destinos();
						this.alert_success('Operación realizada con exito!.', true, true, 4000);
						console.log(this.$children[0].destacados);
						if(codigo_enlace === 'todos'){
							this.$children[0].destacados = [];
						} else {
							if(this.$children[0].destacados.length > 0){
								this.$children[0].destacados.forEach((dest, index) => {
									if(dest == codigo_enlace) this.$children[0].destacados.splice(index,1);
								});
							}
						}
					}).catch(error => {
						swal.close();
						console.log(error);
						console.log(error.response);
					});
				}
			});
		},
		setDestacados(codigo_enlace){
			this.destacados = this.$children[0].destacados;
			if(codigo_enlace === 'cinco'){
				this.alert_loader('La acción esta siendo realizada!.', 'loader', false, false, 4000);
				let url = this.route+'/Paso/2/Destacar/5/Hoteles/Paquete/'+this.paquete.id;
				axios.post(url, {cinco: this.destacados}).then(response => {
					//console.log(response.data);
					this.paquete = response.data.paquete;
					this.act_inp_dft_check()
					this.calculos_enlazados
				}).catch(error => {
					console.log(error);
					console.log(error.response);
				});
			} else {
				let url = this.route+'/Paso/2/Destacar/Hoteles/Ind';
				this.alert_loader('La acción esta siendo realizada!.', 'loader', false, false, 4000);
				axios.post(url, {
					codigo:		codigo_enlace,
					paquete_id:	this.paquete.id
				}).then(response => {
					this.paquete = response.data.paquete;
					if(response.data.set_to == 0){
						setTimeout(() => {
							$("#check_hijo_dest_"+codigo_enlace).removeAttr("checked")
						}, 1000);
					}
					this.act_inp_dft_check()
					this.calculos_enlazados
				}).catch(error => {
					console.log(error);
					console.log(error.response);
				});
			}
		},
		act_inp_dft_check(){
			this.enlazados.forEach(en => {
				if(en.destacado == 1){
					$("#check_hijo_dest_"+en.codigo).prop("checked", true)
				}
			})
		},
	},
	computed: {
		calculos_enlazados(loader = false){
			this.enlazados = [];
			if(this.paquete.enlazados.length > 0){
				let ultimo = '';
				this.paquete.enlazados.forEach(enlace => {
					if(ultimo == enlace.codigo){
						let noches = enlace.noches.cantidad;
						this.enlazados.forEach(enlazado => {
							if(enlazado.codigo == enlace.codigo){
								enlazado.hoteles.push(enlace.hotel.nombre);
								enlazado.p_swb += (enlace.hotel.p_swb * noches);
								enlazado.p_swb += (enlace.hotel.p_dwb * noches)/2;
								enlazado.p_tpl += (enlace.hotel.p_tpl * noches)/3;
								enlazado.p_chd += (enlace.hotel.p_dwb * noches);
								enlazado.e_swb += (enlace.hotel.e_swb * noches);
								enlazado.e_dwb += (enlace.hotel.e_dwb * noches)/2;
								enlazado.e_tpl += (enlace.hotel.e_tpl * noches)/3;
								enlazado.e_chd += (enlace.hotel.e_dwb * noches);
							}
						});
					} else {
						let noches = enlace.noches.cantidad;
						this.enlazados.push({
							hoteles : [enlace.hotel.nombre],
							codigo : enlace.codigo,
							destacado: enlace.destacado,
							estado : enlace.estado,
							p_swb : (enlace.hotel.p_swb * noches),
							p_dwb : (enlace.hotel.p_dwb * noches)/2,
							p_tpl : (enlace.hotel.p_tpl * noches)/3,
							p_chd : (enlace.hotel.p_swb * noches),
							e_swb : (enlace.hotel.e_swb * noches),
							e_dwb : (enlace.hotel.e_dwb * noches)/2,
							e_tpl : (enlace.hotel.e_tpl * noches)/3,
							e_chd : (enlace.hotel.e_dwb * noches),
						});
					}
					ultimo = enlace.codigo;
				});
			}
			setTimeout(() => {
				this.act_inp_dft_check();
				if(loader){
					
					toastr.success("Acción realizada con exito!.", 'Excelente!', {
						timeOut: 2000,
						preventDuplicates: true,
						preventOpenDuplicates: true
					});
				}
			}, 1000);
		},
		// New Computeds
	}
});