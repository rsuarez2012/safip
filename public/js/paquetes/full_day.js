const fullday = new Vue({
    el: '#fullday',
    created(){
        this.pre_load_paquete();
        setTimeout(() => {
            //console.clear();
        }, 800);
    },
    data: {
        // General Data
        route: APP_URL,
        paquete: [],
        paso: 1,
        action_type: '',
        tipo: '',

        // Data Paso1
        basic_data: {
            id: 0,
            codigo: '',
            nombre: '',
            descripcion: 'nada',
            extracto: 'nada',
            imagen: File,
            img: '',
            categoria: 0,
            validated: false,
        },

        // Data Paso2
        destinos_p: [],
        otros_destinos: [],
        
        // Data Paso3
        mis_destinos: [],
        restaurantes_disponibles: [],
        servicios_disponibles: [],

        mi_dia: [],
        total_itinerary: {
            p_adulto: 0,
            p_ninio: 0,
            e_adulto: 0,
            e_ninio: 0,
            c_adulto: 0,
        },

        new_dia: {
            id: 0,
            nombre: '',
            descripcion: '',
            imagen: File,
            img: '',
        },

        new_percent: 0,
        aux_percent: 0,
        calculated_percent: false,

        // new data de restaurantes y servicios, seleccion multiple, mismo y otros
        restaurants: [],
        services: [],
        destinies: [],
        filterServices: false,
        filterRestaurants: false,
        dataActivity: {
            name: "",
            type: "",
            item_id: null,
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
				timer: 10000,
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
        pre_load_paquete(){
            this.basic_data.id = $('#paquete_id').val();
            this.basic_data.categoria = $('#categoria_id').val();
            if(this.basic_data.id > 0){
                this.alert_loader({
                    text:   'Los datos del paquete están siendo cargados',
                    icon:   'loader',
                    click:  false,
                    esc:    false,
                    time:   false,
                });
                this.load_paquete();
            }
        },
        load_paquete(){
            let url = this.route + '/tablero/Paquete/Full_Day/load_paquete/' + this.basic_data.id;
            axios.get(url).then(response => {
                //console.log(response.data);
                this.paquete = response.data.paquete;
                this.destinos_p = response.data.paquete.listados;
                this.otros_destinos = response.data.otros_destinos;
                this.set_basic_data();
                swal.close();
            }).catch(error => {
                console.log(error)
                console.log(error.response)
                if(error.response.status == 500) this.load_paquete();
                console.clear();
            });
        },
        load_image(event){
            //console.log(event)
            if(event.target.files[0].type == 'image/jpeg' || event.target.files[0].type == 'image/png'){
                if(event.target.files[0].size <= 10400000){
                    this.basic_data.imagen  = event.target.files[0];
                    this.basic_data.img     = event.target.files[0].name;
                } else {
                    toastr.warning('La imagen seleccionada no puede ser de peso mayor a 10 Mb.', 'Atención!.');
                    event.target.value = "";
                    this.basic_data.img = '';
                }
            } else {
                toastr.warning('El archivo seleccionado no es una imagen.', 'Atención!.');
                event.target.value = "";
                this.basic_data.img = '';
            }
        },
        code_validate(){
            if (this.basic_data.codigo == "") {
                toastr.warning("Debe colocar un codigo");
            } else {
                axios.get(this.route + "/validate/code/" + this.basic_data.codigo).then(response => {
                    if (response.data > 0) {
                        toastr.info("El codigo esta repetido.", "Disculpe!");
                    } else {
                        toastr.success("El código " + this.basic_data.codigo + " es válido");
                        this.basic_data.validated = true;
                    }
                });
            }
        },
        set_basic_data(){
            this.basic_data.id          = this.paquete.id;
            this.basic_data.codigo      = this.paquete.codigo;
            this.basic_data.nombre      = this.paquete.nombre;
            this.basic_data.descripcion = this.paquete.descripcion;
            this.basic_data.extracto    = this.paquete.extracto;
            this.basic_data.img         = this.paquete.imagen;
            this.basic_data.validated   = true;
            this.paso                   = this.paquete.statusCreado;

            $('#new_paquete').css('display','none');
            $('#old_paquete').text('Paquete: '+this.paquete.nombre);
            $('#old_paquete').css('display','');

            this.validate_status();
        },
        save_paquete_validate(){
            if(this.basic_data.codigo == '' || this.basic_data.codigo.length == 0){
                toastr.warning("Debe ingresar un código!", "Disculpe!")
                return false;
            }
            if(this.basic_data.nombre == '' || this.basic_data.nombre.length == 0){
                toastr.warning("Debe ingresar un nombre para el paquete!", "Disculpe!")
                return false;
            }
            if((typeof fullday.basic_data.imagen != "object" || this.basic_data.img == '') && this.paso == 1){
                toastr.warning("Debe seleccionar una imagen para el paquete!", "Disculpe!")
                return false;
            }
            return true;
        },
        save_paquete(){
            if(this.save_paquete_validate()){
                if(this.paso == 1) act = 'crear un nuevo';
                else act = 'actualizar este';

                swal({
                    title: "Disculpe!.",
                    text: "¿Está seguro de que desea "+act+" paquete?",
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
				    timer: 5000,
                }).then(acepted => {
                    if(acepted){
                        this.alert_loader({
                            text:   'Los datos del paquete están siendo guardados',
                            icon:   'loader',
                            click:  false,
                            esc:    false,
                            time:   false,
                        });
                        let url_store = this.route + "/tablero/Paquete/Full_Day/store_basic_data";
                        var data_basic = new FormData();
                        data_basic.append('codigo', this.basic_data.codigo);
                        data_basic.append('nombre', this.basic_data.nombre);
                        data_basic.append('imagen', this.basic_data.imagen);
                        data_basic.append('descripcion', this.basic_data.descripcion);
                        data_basic.append('extracto', this.basic_data.extracto);
                        data_basic.append('categoria_id', this.basic_data.categoria);

                        if (this.paso != 1) {
                            let url_update = this.route + '/tablero/Paquete/Full_Day/update_basic_data/' + this.paquete.id;
                            axios.post(url_update, data_basic).then(response => {
                                //console.log(response.data)
                                this.alert_success({
                                    text: 'El paquete se editó correctamente',
                                    click: true,
                                    esc: true,
                                    time: 4000
                                })
                                this.paquete = response.data;
                                this.set_basic_data();
                                swal.close();
                            }).catch(error => {
                                console.log(error);
                                console.log(error.response);
                                if(error.response.status == 500){
                                    document.write(error.response.data)
                                }
                            });
                        } else {
                            axios.post(url_store, data_basic).then(response => {
                                //console.log(response.data);
                                this.alert_success({
                                    text: 'El paquete fue creado correctamente!',
                                    click: true,
                                    esc: true,
                                    time: 4000
                                })
                                this.paquete = response.data.paquete;
                                this.otros_destinos = response.data.otros_destinos;
                                this.set_basic_data();
                                swal.close();
                            }).catch(error => {
                                console.log(error);
                                console.log(error.response);
                            });
                        }
                    }
                })
            }
        },

        // Necesarios
        validate_status(){
            if(this.paquete.statusCreado != 'terminado'){
                if(this.paquete.listados.length > 0) this.paso = 3;
                else this.paso = 2;
            }
            if(this.paso != 1 || this.paso != 2){
                this.load_mis_destinos();
            }
        },

        // Selección de destinos
        agregar_destino(){
            let destino = $("#destino").val();
            if(destino > 0){
                swal({
                    title: "Disculpe!.",
                    text: "¿Está seguro de que desea agregar este destino al paquete?",
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
				    timer: 5000,
                }).then(acepted => {
                    if(acepted){
                        let url_store_destino = this.route + "/tablero/Paquete/Full_Day/store_destino/" + this.paquete.id;
                        this.alert_loader({
                            text:   'El destino esta siendo agregado',
                            icon:   'loader',
                            click:  false,
                            esc:    false,
                            time:   false,
                        });
                        axios.post(url_store_destino, {destino_id: destino}).then(response => {
                            //console.log(response.data)
                            this.paquete = response.data.paquete;
                            this.destinos_p = response.data.paquete.listados;
                            this.otros_destinos = response.data.otros_destinos;
                            toastr.success("El destino fue agregado exitosamente!", "Excelente!");
                            setTimeout(() => {
                                $("#destino").select2();
                            }, 1000);
                            swal.close();
                            this.validate_status();
                        }).catch(error => {
                            console.log(error)
                            console.log(error.response)
                        });
                    }
                });
            } else {
                toastr.warning("Debe seleccionar un destino!", "Disculpe!");
            }
        },
        eliminar_destino(destino_id){
            swal({
                title: "Disculpe!.",
                text: "¿Está seguro de que desea eliminar este destino del paquete?",
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
                timer: 5000,
            }).then(acepted => {
                if(acepted){
                    let url_destroy_destino = this.route + "/tablero/Paquete/Full_Day/destroy_destino/" + this.paquete.id;
                    this.alert_loader({
                        text:   'El destino esta siendo eliminado',
                        icon:   'loader',
                        click:  false,
                        esc:    false,
                        time:   false,
                    });
                    axios.post(url_destroy_destino, {destino_id:destino_id}).then(response => {
                        //console.log(response.data);
                        this.paquete = response.data.paquete;
                        this.destinos_p = response.data.paquete.listados;
                        this.otros_destinos = response.data.otros_destinos;
                        toastr.success("El destino fue eliminado exitosamente!", "Excelente!");
                        setTimeout(() => {
                            $("#destino").select2();
                        }, 1000);
                        swal.close();
                        this.validate_status();
                    }).catch(error => {
                        console.log(error);
                        console.log(error.response);
                    });
                }
            });
        },

        // Selección de servicios y conf de tarifas
        load_mis_destinos(){
            let url_load = this.route + "/tablero/Paquete/Full_Day/mis_destinos/" + this.paquete.id;
            axios.get(url_load).then(response => {
                //console.log(response.data);
                this.paquete = response.data.paquete;
                if(response.data.cant_dest > 0){
                    this.mis_destinos = response.data.mis_destinos;
                    this.ordering_data_dias();
                }
            }).catch(error => {
                console.log(error);
                console.log(error.response);
            });
        },
        ordering_data_dias(){
            this.servicios_disponibles = [];
            this.restaurantes_disponibles = [];
            if(this.mis_destinos.length > 0){
                this.mis_destinos.forEach(dest => {
                    if(dest.operadores.length > 0){
                        dest.operadores.forEach(ope => {
                            if(ope.servicios.length > 0){
                                ope.servicios.forEach(serv => {
                                    this.servicios_disponibles.push(serv);
                                });
                            }
                        });
                    }
                    if(dest.restaurantes.length > 0){
                        dest.restaurantes.forEach(rest => {
                            this.restaurantes_disponibles.push(rest);
                        });
                    } 
                });
            }
            if(this.paquete.dias.length > 0){
                this.mi_dia = this.paquete.dias[0];
                this.calculate_itinerary;
                this.load_data_dia();
            }
        },
        openModal(action, tipo){
			this.action_type = action;
            this.tipo   = tipo;
			$("#data_dia").fadeIn(300);
		},
		closeModal(){
			$("#data_dia").fadeOut(300);
        },
        load_image_dia(event){
            //console.log(event)
            if(event.target.files[0].type == 'image/jpeg' || event.target.files[0].type == 'image/png'){
                if(event.target.files[0].size <= 10400000){
                    this.new_dia.imagen  = event.target.files[0];
                    this.new_dia.img     = event.target.files[0].name;
                } else {
                    toastr.warning('La imagen seleccionada no puede ser de peso mayor a 10 Mb.', 'Atención!.');
                    event.target.value = "";
                    this.new_dia.img = '';
                }
            } else {
                toastr.warning('El archivo seleccionado no es una imagen.', 'Atención!.');
                event.target.value = "";
                this.new_dia.img = '';
            }
        },
        save_dia_validate(){
            if(this.new_dia.nombre == '' || this.new_dia.nombre.length == 0){
                toastr.warning("Debe ingresar el nombre del día!", "Disculpe!")
                return false;
            }
            if(this.new_dia.descripcion == '' || this.new_dia.descripcion.length == 0){
                toastr.warning("Debe agregarle una descripción al dia!", "Disculpe!")
                return false;
            }
            if((typeof fullday.new_dia.imagen != "object" || this.new_dia.img == '') && this.new_dia.id == 0){
                toastr.warning("Debe seleccionar una imagen para el día!", "Disculpe!")
                return false;
            }
            return true;
        },
        save_dia(){
            if(this.save_dia_validate()){
                if(this.new_dia.id == 0) act = 'crear';
                else act = 'actualizar'

                swal({
                    title: "Disculpe!.",
                    text: "¿Está seguro de que desea "+act+" este día?",
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
                    timer: 5000,
                }).then(acepted => {
                    if(acepted){
                        this.alert_loader({
                            text:   'Los datos del día están siendo guardados',
                            icon:   'loader',
                            click:  false,
                            esc:    false,
                            time:   false,
                        });
                        let url_store = this.route + "/tablero/Paquete/Full_Day/save_dia";
                        var data_dia = new FormData();
                        data_dia.append('paquete_id', this.paquete.id);
                        data_dia.append('nombre', this.new_dia.nombre);
                        data_dia.append('descripcion', this.new_dia.descripcion);
                        data_dia.append('imagen', this.new_dia.imagen);

                        if(this.new_dia.id > 0){
                            let url_update = this.route + "/tablero/Paquete/Full_Day/update_dia/" + this.new_dia.id;
                            axios.post(url_update, data_dia).then(response => {
                                this.alert_success({
                                    text: 'El día se actualizó correctamente!',
                                    click: true,
                                    esc: true,
                                    time: 4000
                                })
                                this.validate_status();
                                swal.close();
                            }).catch(error => {
                                console.log(error)
                                console.log(error.response)
                            });
                        } else {
                            axios.post(url_store, data_dia).then(response => {
                                this.alert_success({
                                    text: 'El día fue creado correctamente!',
                                    click: true,
                                    esc: true,
                                    time: 4000
                                });
                                this.validate_status();
                                swal.close();
                            }).catch(error => {
                                console.log(error)
                                console.log(error.response)
                            });
                        }
                    }
                    this.closeModal();
                });
            }
        },
        load_data_dia(){
            this.new_dia.id     = this.mi_dia.id;
            this.new_dia.img    = this.mi_dia.imagen;
            this.new_dia.nombre = this.mi_dia.nombre;
            this.new_dia.descripcion = this.mi_dia.descripcion;
            this.new_percent = this.paquete.percent_full_day;
            this.aux_percent = this.new_percent;
        },
        destroy_dia(){
            swal({
                title: "Disculpe!.",
                text: "¿Está seguro de que desea eliminar este día?",
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
                timer: 5000,
            }).then(acepted => {
                if(acepted){
                    let url_destroy_destino = this.route + "/tablero/Paquete/Full_Day/destroy_destino/" + this.paquete.id;
                    this.alert_loader({
                        text:   'El día esta siendo eliminado!',
                        icon:   'loader',
                        click:  false,
                        esc:    false,
                        time:   false,
                    });
                    let url_destroy_dia = this.route + "/tablero/Paquete/Full_Day/destroy/" + this.mi_dia.id;
                    axios.delete(url_destroy_dia).then(response => {
                        this.alert_success({
                            text: 'El día se eliminó correctamente!',
                            click: true,
                            esc: true,
                            time: 4000
                        })
                        this.validate_status();
                        swal.close();
                        this.clean_dia();
                    }).catch(error => {
                        console.log(error)
                        console.log(error.response)
                    });
                }
            });
        },
        clean_dia(){
            this.mi_dia = [];
            this.new_dia = {
                id: 0,
                nombre: '',
                descripcion: '',
                imagen: File,
                img: '',
            }
        },
        clean_activity(){
            this.dataActivity.name = "";
            this.dataActivity.type = "";
            this.dataActivity.item_id = null;
        },

        show_modal_services(){
            $("#actividades").fadeIn(300);
        },
        hide_modal_services(){
            $("#actividades").fadeOut(300);
        },

        // filtrado de restaurantes y servicios
        changeFilterRestaurants() { // EVENTO QUE SE LANZA CUANDO CAMBIA EL TIPO DE FILTRO EN SERVICIOS [mismos/otros -> df mismos]
            this.filterRestaurants = !this.filterRestaurants;
            if (this.filterRestaurants) {
                urlDetinies = this.route + "/get/other/destinies/" + this.paquete.id;
                axios.get(urlDetinies).then(response => {
                    $("#search-restaurants").remove("span");
                    this.restaurants = [];
                    this.destinies = response.data;
                    $("#search-restaurants").select2();
                }).catch(error => {
                    console.log(error);
                });
            } else {
                this.restaurants = [];
                this.restaurants = this.restaurantes_disponibles;
                $("#search-restaurants").select2();
                /*urlRest = this.route + "/tablero/Admin/Paso/3/Restaurants/Paquete/" + this.paquete.id;
                axios.get(urlRest).then(response => {
                    $("#search-restaurants").remove("span");
                    this.restaurants = [];
                    this.restaurants = response.data;
                    $("#search-restaurants").select2();
                }).catch(error => {
                    console.log(error);
                });*/
            }
        },
        changeFilterServices() { // EVENTO QUE SE LANZA CUANDO CAMBIA EL TIPO DE FILTRO EN SERVICIOS [mismos/otros -> df mismos]
            this.filterServices = !this.filterServices;
            $("#select_filter_services").children().remove();
            if (this.filterServices) {
               /* $("#search-activity").remove("span");
                this.services = [];
                this.destinies = [];
                if(this.otros_destinos.length > 0){
                    this.destinies = this.otros_destinos;
                }
                $("#search-activity").select2();*/
                urlDetinies = this.route + "/get/other/destinies/" + this.paquete.id;
                axios.get(urlDetinies).then(response => {
                    console.log(response.data)
                    $("#search-activity").remove("span");
                    this.services = [];
                    this.destinies = response.data;
                    $("#search-activity").select2();
                }).catch(error => {
                    console.log(error);
                });
            } else {
                this.services = this.servicios_disponibles;
                $("#search-activity").select2();
                /*urlRest = this.route + "/tablero/Admin/Paso/3/Mis_Services/Paquete/" + this.paquete.id;
                axios.get(urlRest).then(response => {
                    $("#search-activity").remove("span");
                    this.services = [];
                    this.services = response.data;
                    $("#search-activity").select2();
                }).catch(error => {
                    console.log(error);
                });*/
            }
        },
        searchFilterServices() {
            var lista = $("#select_filter_services").val();
            //console.log(lista)
            if (lista) {
                this.toastr_search_data_type('servicio');
                axios.post(this.route + "/get/other/services", { destinos: lista }).then(response => {
                    if (response.data.length > 0) {
                        this.toastr_data_found('servicio');
                        //console.log(response.data);
                        $("#search-activity").remove("span");
                        this.services = [];
                        this.services = response.data;
                        $("#search-activity").select2();
                    } else {
                        $("#search-activity").remove("span");
                        this.services = [];
                        $("#search-activity").select2();
                        this.toastr_data_not_found('servicio');
                    }
                }).catch(error => {
                    console.log(error.response);
                    console.log(error.response.data);
                });
            } else {
                toastr.warning("Seleccione al menos un destino para poder filtrar","Disculpe");
            }
        },
        searchFilterRestaurants() {
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
        },
        toastr_search_data_type(type) {
            toastr.info('Se estan buscando ' + type + 's, por favor tenga paciencia!.');
        },
        toastr_data_found(type) {
            toastr.success('Se han encontrado ' + type + 's!.');
        },
        toastr_data_not_found(type) {
            toastr.warning('Disculpe!, No se han encontrado ' + type + 's!.');
        },
        searchType() { // BUSCAR UN TIPO DE ACTIVIDAD DE ACUERDO A LA SELECCIONADA
            if (this.dataActivity.type == "restaurante") {
                this.toastr_search_data_type(this.dataActivity.type);
                urlRest = this.route + "/tablero/Admin/Paso/3/Restaurants/Paquete/" + this.paquete.id;
                axios.get(urlRest).then(response => {
                    if (response.data.length > 0) {
                        this.toastr_data_found(this.dataActivity.type);
                        this.restaurants = response.data;
                        $("#search-restaurants").remove("span");
                        $("#search-restaurants").select2();
                    } else this.toastr_data_not_found(this.dataActivity.type);
                }).catch(error => {
                    console.log(error);
                });
            } else if (this.dataActivity.type == "servicio") {
                //this.toastr_search_data_type(this.dataActivity.type);
                $("#search-activity").remove("span");
                this.services = [];
                if(this.servicios_disponibles.length > 0){
                    this.services = this.servicios_disponibles;
                    this.toastr_data_found(this.dataActivity.type);
                } else {
                    this.toastr_data_not_found('servicio');
                }
                $("#search-activity").select2();
                /*this.toastr_search_data_type(this.dataActivity.type);
                urlRest = this.route + "/tablero/Admin/Paso/3/Mis_Services/Paquete/" + this.paquete.id;
                axios.get(urlRest).then(response => {
                    if (response.data.length > 0) {
                        this.toastr_data_found(this.dataActivity.type);
                        $("#search-activity").remove("span");
                        this.services = [];
                        this.services = response.data;
                        $("#search-activity").select2();
                    } else {
                        $("#search-activity").remove("span");
                        this.services = [];
                        $("#search-activity").select2();
                        this.toastr_data_not_found('servicio');
                    }
                }).catch(error => {
                    console.log(error);
                });*/
            } else {
                this.dataActivity.item_id = null;
            }
        },

        saveActivity() {
            if (this.dataActivity.type == "servicio") {
                this.dataActivity.item_id = $("#search-activity > option:selected").val();
            } else if (this.dataActivity.type == "restaurante") {
                this.dataActivity.item_id = $("#search-restaurants > option:selected").val();
            }
            if (this.dataActivity.name == "" || this.dataActivity.type == "" || !this.dataActivity.item_id) {
                toastr.warning("Debe LLenar Todos los Campo", "Disculpe");
            } else {
                this.alert_loader({
                    text:   'La actividad esta siendo creada!',
                    icon:   'loader',
                    click:  false,
                    esc:    false,
                    time:   false,
                });
                urlActivity = this.route + "/save/activity/day/" + this.mi_dia.id;
                axios.post(urlActivity, { activity: this.dataActivity }).then(response => {
                    this.alert_success({
                        text: 'La actividad se creó exitosamente!',
                        click: true,
                        esc: true,
                        time: 4000
                    })
                    this.validate_status();
                    this.clean_activity();
                    swal.close();
                }).catch(error => {
                    console.log(error);
                    console.log(error.response);
                });
            }
        },
        deleteActivity(activity, index) {
            swal({
                title: "Disculpe!.",
                text: "Seguro que desea elimar esta actividad?",
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
                timer: 5000,
            }).then((acepted) => {
                if (acepted) {
                    this.alert_loader({
                        text:   'La actividad esta siendo eliminada!',
                        icon:   'loader',
                        click:  false,
                        esc:    false,
                        time:   false,
                    });
                    urlEliminarActividad = this.route + "/tablero/Admin/Paso/3/borrar/" + activity.id;
                    axios.get(urlEliminarActividad).then(response => {
                        this.alert_success({
                            text: 'Actividad Eliminada Correctamente',
                            click: true,
                            esc: true,
                            time: 4000
                        })
                        this.validate_status();
                        this.clean_activity();
                        swal.close();
                    }).catch(error => {
                        console.log(error);
                        console.log(error.response);
                    });
                }
            });
        },

        sum_new_percent(num) {
            if(this.aux_percent > 0){
                this.calculated_percent = true;
                /*return ((this.aux_percent / 100) * num) + num;*/
                return (parseInt(this.aux_percent) + parseFloat(num));
            } else {
                this.calculated_percent = false;
                return num;
            }
        },
        calculate_new_promotion() {
            this.aux_percent = this.new_percent;
            toastr.success("Tarifas calculadas con el nuevo monto");
        },
        save_new_percent(){
            let url_store_new_percent = this.route + "/tablero/Paquete/Full_Day/save_new_percent/" + this.paquete.id;
            axios.post(url_store_new_percent, {new_percent: this.aux_percent}).then(response => {
                toastr.success("Se guardó el monto: "+this.aux_percent+" para las tarifas del paquete!", "Excelente!");
            });
        },

        seguir_finalizar(){
            window.location.href = this.route + "/tablero/Admin/Paso/4/Datos/Adicionales/Paquete/" + this.paquete.id;
        },
    },
    computed: {
        calculate_itinerary() {
            total_itinerary = { p_adulto: 0, e_adulto: 0, c_adulto: 0, p_ninio: 0, e_ninio: 0 };
            if(this.mi_dia.length == undefined){
                if (this.mi_dia.actividades.length > 0) {
                    this.mi_dia.actividades.forEach(function (actividad) {
                        if (actividad.tipo == "servicio") {
                            total_itinerary.p_adulto += actividad.servicio[0].servicio.peruano.adulto
                            total_itinerary.e_adulto += actividad.servicio[0].servicio.extranjero.adulto
                            total_itinerary.c_adulto += actividad.servicio[0].servicio.comunidad.adulto
                            total_itinerary.p_ninio += actividad.servicio[0].servicio.peruano.ninio
                            total_itinerary.e_ninio += actividad.servicio[0].servicio.extranjero.ninio
                        } else if (actividad.tipo == "restaurante") {
                            total_itinerary.p_adulto += actividad.restaurante[0].restaurante.peruano.adulto
                            total_itinerary.e_adulto += actividad.restaurante[0].restaurante.extranjero.adulto
                            total_itinerary.c_adulto += actividad.restaurante[0].restaurante.comunidad.adulto
                            total_itinerary.p_ninio += actividad.restaurante[0].restaurante.peruano.ninio
                            total_itinerary.e_ninio += actividad.restaurante[0].restaurante.extranjero.ninio
                        }
                    }); 
                    this.total_itinerary = total_itinerary;
                }
            }
            return this.total_itinerary;
        }
    }
});