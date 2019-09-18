const destinos = new Vue({
	el:"#main-destinos",
	created() {
		this.loadPage();
	},
	data:{
		destinos:[],
		route:APP_URL,
	},
	methods:{
		loadPage(){
			swal({
				title: "Cargando",
				text: "espere un momento mientras se carga la pagina",
				icon: this.route + "/imagenes/loader.gif",
				button: {
					text: "Ok",
					value: false,
					closeModal: false,
				},
				closeOnClickOutside: false,
				closeOnEsc: false,
				dangerMode: true,
			});
			this.getDestinos();
		},
		getDestinos(){
			url_destinos="/get/destinos/hoteles";
			axios.get(this.route+url_destinos).then(response =>{
				this.destinos = response.data;
				swal.close();
			}).catch(errors=>{
				console.log(errors);
			});
		},
		nuevoDestino(){
			swal({
				title:"Nuevo Destino",
				content: {
					element: "input",
					attributes: {
						placeholder: "Destino",
						type: "text",
					},
				},
			}).then((value) => {
				if(value==null){
					return false;
				}
				else if (value.length == 0) {
					toastr.warning("El campo no puede estar vacio.");
				}
				else{
					toastr.info("Creando Destino");
					axios.post(this.route +  "/tablero/paquetes/destino/admin/store", { nuevo_destino: value }).then(response => {
						toastr.success("Destino Actualizado!");
						this.getDestinos();
					}).catch(error => {
						console.log(error);
					});
				}
			});
		},
		editarDestino(destino){
			swal({
				title:"Editar Destino "+destino.nombre,
				content: {
					element: "input",
					attributes: {
						placeholder: "Destino",
						type: "text",
						value:destino.nombre,
					},
				},
			}).then((value) => {
				if(value==null){
					return false;
				}
				else if (value.length == 0) {
					toastr.warning("Debe Modificar el campo para editar y no puede estar vacio");
				}
				else{
					let datos ={
						nombre:value,
						id:destino.id,
					};
					toastr.info("Actualizando Destino");
					axios.post(this.route +  "/tablero/paquetes/destino/admin/update", { nuevo_destino: datos }).then(response => {
						toastr.success("Destino Actualizado");
						this.getDestinos();
					}).catch(error => {
						console.log(error);
					});
				}
			});
		},
		eliminarDestino(destino){
			swal({
				title: "Seguro Que Quiere Elimar el destino : "+destino.nombre+" ?",
				text: "Si elimina este destino se eliminaran todos los HOTELES, RESTAURANTES y OPERADORES que pertenescan a este destino.",
				icon: "warning",
				buttons: {
					cancel: "No",
					aceptar: {
						text: "Si",
						value: true,
						className: "btn-danger"
					},
				},
				dangerMode: true,
			}).then((acepted) => {
				if (acepted) {
					swal({
						title: "Espere un momento",
						text: "eliminando el destino y todas sus dependencias",
						icon: this.route + "/imagenes/loader.gif",
						button: {
							text: "Ok",
							value: false,
							closeModal: false,
						},
						closeOnClickOutside: false,
						closeOnEsc: false,
						dangerMode: true,
					});
					let ruta_eliminar_destino = this.route + "/tablero/paquetes/destino/admin/destroy/" + destino.id;
					axios.delete(ruta_eliminar_destino).then(response => {
						this.getDestinos();
						toastr.success("Destino Eliminado correctamente");
					}).catch(errors => {
						console.log(errors);
					});
				} else {
					swal.close();
				}
			});
		}
	}
})