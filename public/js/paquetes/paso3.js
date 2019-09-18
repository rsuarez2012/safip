const tres = new Vue({
    el: '#main-paso3',
    created() {
        this.loadPage();
        this.act();
    },
    data: {
        //biding
        route: APP_URL,
        src: "",
        rowspan: 0,
        value: "",
        completed_days: false,
        //paquete
        package: [],
        //variables para dias
        day: [],
        view_button_new: true,
        list_days: [],
        edit: false,
        dataDay: {
            name: null,
            description: null,
            image: null,
            libre: false,
        },
        //variables para actividaes
        restaurants: [],
        services: [],
        filterServices: false,
        destinies: [],
        listDestinies: null,
        dataActivity: {
            name: "",
            type: "",
            code: "",
            item_id: null,
        },
        //varibales tarifas
        neto: [],
        table_mounts: [],
        total_itinerary: {
            p_adulto: 0,
            p_ninio: 0,
            e_adulto: 0,
            e_ninio: 0,
            c_adulto: 0,
        },
        type_calc: "",
        type_tarifa: 'diez',
        price_utility: 0,
        calculated_utility: false,
        mount_utility: 0,
        // DATA CREADA POR CESSARE JULIUS
        filterRestaurants: false,
        dia_libre: false,
    },
    methods: {
        //funciones de paquetes
        loadPage() {
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
            this.getPackage();
            this.getNeto();
        },
        getPackage() {
            var package_id = $("input[name='id_oculto']").val();
            var url = this.route + '/get/package/' + package_id;

            axios.get(url).then(response => {
                this.package = response.data;
                this.type_calc = this.package.tipo_tarifa;
                this.type_tarifa = this.package.tipo_tarifa;
                this.mount_utility = this.package.utilidad_promocion;
                swal.close();
                /* if (this.type_calc == "promocion") { */
                tres.calculate_itinerary_final;
                /* } */
                this.showNewDay();
            }).catch(error => {
                console.log(error.response);
                swal.close();
            });
        },
        /* abrir modal dia */
        newDay() {
            this.edit = false;
            total_night = 0;
            this.package.listados.forEach(day => {
                total_night += parseInt(day.noches.cantidad);
                console.log(total_night+1);
            });
            this.list_days = [];
            console.log(this.list_days);
            total_night = total_night - this.package.dias.length;
            for (let i = 0; i < (total_night + 1); i++) {
                this.list_days.push({
                    id: 0,
                    name: "",
                    description: "",
                    image: null,
                    libre: false,
                })
            }
            $("#dia").fadeIn(300);
        },
        /* guardar o actualizar dia */
        saveDay() {
            if (this.edit) {
                let fail = false;
                this.list_days.forEach((day, index) => {
                    if (day.name == "" || day.name == null) {
                        toastr.warning("Debe colocar un nombre en el dia " + (index + 1));
                        fail = true;
                    }
                    if (day.description == "" || day.description == null) {
                        toastr.warning("Debe colocar una descripcion en el dia " + (index + 1));
                        fail = true;
                    }
                    var urlUpdateDay = this.route + "/updated/day/" + this.package.id;
                    this.loading();
                    //Creamos el formData
                    var data = new FormData();
                    //Añadimos la imagen seleccionada
                    console.log(data);
                    data.append('img', this.list_days[0].image);
                    data.append('name', this.list_days[0].name);
                    data.append('text', this.list_days[0].description);
                    data.append('day_id', this.list_days[0].id);
                    //Enviamos la petición

                    axios.post(urlUpdateDay, data).then(response => {
                        this.alert("Excelente!", "Dia Modificado Correctamente", "success");
                        this.closeModal();
                        console.log(response.data);
                        this.getPackage();
                    }).catch(error => {
                        console.log(error.response);
                        swal.close();
                    });

                });
                /* cancelo si falta algo */
                if (fail) {
                    return;
                }
            } else {
                /* valido dias llenos */
                let fail = false;
                this.list_days.forEach((day, index) => {
                    if (day.name == "" || day.name == null) {
                        toastr.warning("Debe colocar un nombre en el dia " + (index + 1));
                        fail = true;
                    }
                    if (day.description == "" || day.description == null) {
                        toastr.warning("Debe colocar una descripcion en el dia " + (index + 1));
                        fail = true;
                    }
                    if (day.image == null && day.libre == false) {
                        toastr.warning("Debe colocar una Imagen en el dia " + (index + 1));
                        fail = true;
                    }
                });
                /* cancelo si falta algo */
                if (fail) {
                    return;
                }
                /* creo varuable de url */
                var urlSaveDay = this.route + "/save/day/" + this.package.id;
                this.loading();
                //Creamos el formData
                var data = new FormData();

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                /* recorro dias para guardar*/
                this.list_days.forEach((day, index) => {
                    /* var data_day = [, day.description, day.libre, day.image] */
                    data.append("days[" + index + "][name]", day.name);
                    data.append("days[" + index + "][description]", day.description);
                    data.append("days[" + index + "][libre]", day.libre);
                    data.append("img-" + index, this.list_days[index].image);


                    /* data.append('text[]', day.description);
                    data.append('libre[]', day.libre);
                    data.append('img[]', day.image); */
                });
                //Enviamos la petición
                axios.post(urlSaveDay, data, config).then(response => {
                    this.alert("Exito !", "Solicitud procesada correctamente", "success");
                    this.getPackage();
                    this.list_days = [];
                    $("#dia").fadeOut(300);
                }).catch(error => {
                    swal.close();
                    console.log(error.response);
                });

            }
        },
        changeFreeDay(index) {
            if (this.list_days[index].libre) {
                this.list_days[index].name = "Dia Libre";
                this.list_days[index].description = "Dia Libre";
                this.list_days[index].image = null;
            } else {
                this.list_days[index].name = "";
                this.list_days[index].description = "";
                this.list_days[index].image = null;
            }
        },
        validateTotalDays() {
            let total_night = 0;
            this.package.listados.forEach(item => {
                total_night += parseInt(item.noches.cantidad);
            });
            //modificacion en la validacion de los dias
            if ((this.package.dias.length) > total_night || (this.package.categoria_id) === 6) {
                return true;
                /* window.location.href = this.route + "/tablero/Admin/Paso/4/Datos/Adicionales/Paquete/" + this.package.id; */
            } else {
                return false;
                /* toastr.warning("Debe colocar al menos " + (total_night + 1) + " dias"); */
            }
        },
        completeDays() {
            if (this.validateTotalDays()) {
                window.location.href = this.route + "/tablero/Admin/Paso/4/Datos/Adicionales/Paquete/" + this.package.id;
            } else {
                //aaqui categoria_id = 6
                console.log(this.package.categoria_id);
                toastr.warning("debe registrar todos los dias ");
                
            }
        },
        showNewDay() {
            this.view_button_new = this.validateTotalDays();
        },
        deleteDay(day, index) {
            swal({
                title: "Seguro Que Quiere Elimar Este Dia?",
                text: "si elimina el dia , tambien elimina todas las actividades que esten dentro de ese dia",
                icon: "warning",
                buttons: {
                    cancel: "cancelar",
                    aceptar: {
                        text: "Continuar",
                        value: true,
                        className: "btn-danger"
                    },
                },
                dangerMode: true,
            }).then((acepted) => {
                if (acepted) {
                    this.loading();
                    var url = this.route + '/delete/day/' + day.id;
                    axios.get(url).then(response => {
                        this.getPackage();
                        this.alert("Dia Eliminado", "El dia " + day.nombre + " se elimino correctamente", "success");
                    }).catch(error => {
                        console.log(error);
                        swal.close();
                    });
                } else {
                    swal.close();
                }
            });
        },
        processFile(event, index) {
            this.list_days[index].image = event.target.files[0];
        },
        act(index){
            console.log(index);
            this.day = this.package.dias[index];
            console.log(this.day);           
            this.dataActivity.item_id = null;
            $("#actividades").fadeIn(300);
        },
        editDay(day) {
            this.list_days = [];
            this.edit = true;
            let free = false;
            if (day.nombre == "Dia Libre") {
                free = true;
            }
            this.list_days.push({
                id: day.id,
                name: day.nombre,
                description: day.descripcion,
                image: day.imagen,
                libre: free,
            });
            /* this.day = day;
            this.edit = true;
            this.dataDay.name = day.nombre;
            this.dataDay.description = day.descripcion;
            this.dataDay.image = day.imagen; */
            $("#dia").fadeIn(300);
        },
        //funciones para actividades
        showActivities(index) {
            this.day = this.package.dias[index];
            /* this.dataActivity.code = ""; */
            /* this.dataActivity.name = "Dia Libre";
            this.dataActivity.type = "Dia Libre"; */
            this.dataActivity.item_id = null;
            $("#actividades").fadeIn(300);
        },
        changeFilterRestaurants() { // EVENTO QUE SE LANZA CUANDO CAMBIA EL TIPO DE FILTRO EN SERVICIOS [mismos/otros -> df mismos]
            this.filterRestaurants = !this.filterRestaurants;
            if (this.filterRestaurants) {
                urlDetinies = this.route + "/get/other/destinies/" + this.package.id;
                axios.get(urlDetinies).then(response => {
                    $("#search-restaurants").remove("span");
                    this.restaurants = [];
                    this.destinies = response.data;
                    $("#search-restaurants").select2();
                }).catch(error => {
                    console.log(error);
                });
            } else {
                urlRest = this.route + "/tablero/Admin/Paso/3/Restaurants/Paquete/" + this.package.id;
                axios.get(urlRest).then(response => {
                    $("#search-restaurants").remove("span");
                    this.restaurants = [];
                    this.restaurants = response.data;
                    $("#search-restaurants").select2();
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        changeFilterServices() { // EVENTO QUE SE LANZA CUANDO CAMBIA EL TIPO DE FILTRO EN SERVICIOS [mismos/otros -> df mismos]
            this.filterServices = !this.filterServices;
            $("#select_filter_services").children().remove();
            if (this.filterServices) {
                urlDetinies = this.route + "/get/other/destinies/" + this.package.id;
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
                urlRest = this.route + "/tablero/Admin/Paso/3/Mis_Services/Paquete/" + this.package.id;
                axios.get(urlRest).then(response => {
                    $("#search-activity").remove("span");
                    this.services = [];
                    this.services = response.data;
                    $("#search-activity").select2();
                }).catch(error => {
                    console.log(error);
                });
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
                this.alert("Disculpe", "Seleccione al menos un destino para poder filtrar", "warning");
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
                urlRest = this.route + "/tablero/Admin/Paso/3/Restaurants/Paquete/" + this.package.id;
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
                this.toastr_search_data_type(this.dataActivity.type);
                urlRest = this.route + "/tablero/Admin/Paso/3/Mis_Services/Paquete/" + this.package.id;
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
                });
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
                    this.dataActivity.name = "";
                    this.dataActivity.type = "";
                    this.dataActivity.item_id = null;
                    swal.close();
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        deleteActivity(activity, index) {
            swal({
                title: "Seguro Que Quiere Elimar Esta Actividad ?",
                icon: "warning",
                buttons: {
                    cancel: "cancelar",
                    aceptar: {
                        text: "Continuar",
                        value: true,
                        className: "btn-danger"
                    },
                },
                dangerMode: true,
            }).then((acepted) => {
                if (acepted) {
                    this.loading();
                    urlEliminarActividad = this.route + "/tablero/Admin/Paso/3/borrar/" + activity.id;
                    axios.get(urlEliminarActividad).then(response => {
                        this.day.actividades.splice(index, 1);
                        this.alert("Exito!", 'Actividad Eliminada Correctamente', 'success');
                    }).catch(error => {
                        console.log(error);
                    });
                } else {
                    swal.close();
                }
            });
        },
        //funciones calculos
        getNeto() {
            var package_id = $("input[name='id_oculto']").val();
            urlNeto = this.route + "/get/neto/package/" + package_id;
            axios.get(urlNeto).then(response => {
                //console.log(response.data)
                this.neto = response.data;
            }).catch(error => {
                console.log(error);
                console.log(error.response);
            });
        },
        getItineraryTotal() {
            this.calculate_itinerary;
        },
        getItinerarioFinal(type_calc) {
            this.calculate_itinerary;
            this.type_calc = type_calc
            this.calculate_itinerary_final;
        },
        //hoteles y estados
        changetypeTarifa(type) {
            this.type_tarifa = type;
            let precio_pm = 0;
            if (type == 'promocion') {
                if (this.package.utilidad_promocion == this.mount_utility) {
                    precio_pm = this.package.utilidad_promocion;
                }
            }
            urlChangeTypeTarifa = this.route + "/change/type/tarifa/" + this.package.id + "/to/" + type + "/ppm/" + precio_pm;
            axios.get(urlChangeTypeTarifa).then(response => {
                toastr.success('Tarifas Publicadas');
            }).catch(error => {
                console.log(error);
            });
        },
        changeStateHotels(code, status) {
            toastr.info('Procesano Solicitud')
            urlChangeStateHotels = this.route + "/change/state/hotels/" + code + "/to/" + status;
            axios.get(urlChangeStateHotels).then(response => {
                toastr.success('Estado Modificado');
                this.getNeto();
            }).catch(error => {
                console.log(error);
            });
        },
        //funciones reciclabes
        closeModal() {
            $(".modal").fadeOut(300);
        },
        loading() {
            swal({
                title: "Procesando",
                text: "espere un momento mientras se procesa la solicitud",
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
        },
        alert(titles, texts, icons) {
            swal({
                title: titles,
                text: texts,
                icon: icons,
                button: {
                    text: "Continuar",
                    className: "btn-danger"
                },
            });
        },
        sum_doce(num) {
            number = num / 0.88;
            return number;
        },
        sum_doce_chd(num) {
            number = num / 0.78;
            return number;
        },
        sum_final(num) {
            number = this.sum_doce(num);
            number = number + 12;
            number = number / 0.90;
            return number;
        },
        sum_final_chd(num) {
            number = this.sum_doce_chd(num);
            number = number + 12;
            number = number / 0.90;
            return number;
        },
        sum_promotion(num) {
            if (this.package.utilidad_promocion > 0) {
                this.calculated_utility = true;
                return (parseInt(this.package.utilidad_promocion) + num);
            } else {
                this.calculated_utility = false;
                return num;
            }
        },
        calculate_new_promotion() {
            if (this.table_mounts.length == 0) {
                this.package.utilidad_promocion = this.mount_utility;
                toastr.success("Tarifas Calculadas");
            } else {
                toastr.info("Calculando Tarifas");
                axios.get(this.route + "/change/utility/" + this.mount_utility + "/package/" + this.package.id).then(response => {
                    this.getPackage();
                    toastr.success("Tarifas Calculadas");
                }).catch(errors => {
                    console.log(errors);
                })
            }
        }
    },
    computed: {
        calculate_neto() {
            percent = Object.values(this.neto);
            percent.map((item) => ([
                item.p_swb += this.total_itinerary.p_adulto,
                item.p_dwb += this.total_itinerary.p_adulto,
                item.p_tpl += this.total_itinerary.p_adulto,
                item.p_chd += this.total_itinerary.p_ninio,
                item.e_swb += this.total_itinerary.e_adulto,
                item.e_dwb += this.total_itinerary.e_adulto,
                item.e_tpl += this.total_itinerary.e_adulto,
                item.e_chd += this.total_itinerary.e_ninio,
                item.c_swb += this.total_itinerary.c_adulto,
                item.c_dwb += this.total_itinerary.c_adulto,
                item.c_tpl += this.total_itinerary.c_adulto,
                item.p_chd += this.total_itinerary.p_ninio,

            ]));
            return this.total_neto;
        },
        calculate_itinerary() {
            total_itinerary = { p_adulto: 0, e_adulto: 0, c_adulto: 0, p_ninio: 0, e_ninio: 0 },
                this.package.dias.forEach(function (day) {
                    day.actividades.forEach(function (actividad) {
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
                });
            this.total_itinerary = total_itinerary;
            return this.total_itinerary;
        },
        calculate_itinerary_final() {
            tres.table_mounts.splice(0);
            list = Object.values(tres.neto);
            list.forEach(function (row) {
                i = {
                    hotels: "", estado: "", codigo: "",
                    p_swb: 0, p_dwb: 0, p_tpl: 0, p_chd: 0,
                    e_swb: 0, e_dwb: 0, e_tpl: 0, e_chd: 0,
                    c_swb: 0, c_dwb: 0, c_tpl: 0, c_chd: 0,
                };
                i.estado = row.estado;
                i.codigo = row.codigo;
                row.hoteles.forEach(function (hotel) {
                    i.hotels += " / " + hotel;
                });
                i.star = row.estrella
                /* peruanos */
                if (row.p_swb > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.p_swb = row.p_swb + tres.total_itinerary.p_adulto; break;
                        case 'doce': i.p_swb = tres.sum_doce((row.p_swb + tres.total_itinerary.p_adulto)); break;
                        case 'diez': i.p_swb = tres.sum_final((row.p_swb + tres.total_itinerary.p_adulto)); break;
                        case 'promocion': i.p_swb = tres.sum_promotion((row.p_swb + tres.total_itinerary.p_adulto)); break;
                    }
                }
                if (row.p_dwb > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.p_dwb = row.p_dwb + tres.total_itinerary.p_adulto; break;
                        case 'doce': i.p_dwb = tres.sum_doce((row.p_dwb + tres.total_itinerary.p_adulto)); break;
                        case 'diez': i.p_dwb = tres.sum_final((row.p_dwb + tres.total_itinerary.p_adulto)); break;
                        case 'promocion': i.p_dwb = tres.sum_promotion((row.p_dwb + tres.total_itinerary.p_adulto)); break;
                    }
                }
                if (row.p_tpl > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.p_tpl = row.p_tpl + tres.total_itinerary.p_adulto; break;
                        case 'doce': i.p_tpl = tres.sum_doce((row.p_tpl + tres.total_itinerary.p_adulto)); break;
                        case 'diez': i.p_tpl = tres.sum_final((row.p_tpl + tres.total_itinerary.p_adulto)); break;
                        case 'promocion': i.p_tpl = tres.sum_promotion((row.p_tpl + tres.total_itinerary.p_adulto)); break;
                    }
                }
                if (row.p_chd > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.p_chd = row.p_chd + tres.total_itinerary.p_ninio; break;
                        case 'doce': i.p_chd = tres.sum_doce_chd((row.p_chd + tres.total_itinerary.p_ninio)); break;
                        case 'diez': i.p_chd = tres.sum_final_chd((row.p_chd + tres.total_itinerary.p_ninio)); break;
                        case 'promocion': i.p_chd = tres.sum_promotion((row.p_chd + tres.total_itinerary.p_ninio)); break;
                    }
                }
                /* extranjero */
                if (row.e_swb > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.e_swb = row.e_swb + tres.total_itinerary.e_adulto; break;
                        case 'doce': i.e_swb = tres.sum_doce((row.e_swb + tres.total_itinerary.e_adulto)); break;
                        case 'diez': i.e_swb = tres.sum_final((row.e_swb + tres.total_itinerary.e_adulto)); break;
                        case 'promocion': i.e_swb = tres.sum_promotion((row.e_swb + tres.total_itinerary.e_adulto)); break;
                    }
                }
                if (row.e_dwb > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.e_dwb = row.e_dwb + tres.total_itinerary.e_adulto; break;
                        case 'doce': i.e_dwb = tres.sum_doce((row.e_dwb + tres.total_itinerary.e_adulto)); break;
                        case 'diez': i.e_dwb = tres.sum_final((row.e_dwb + tres.total_itinerary.e_adulto)); break;
                        case 'promocion': i.e_dwb = tres.sum_promotion((row.e_dwb + tres.total_itinerary.e_adulto)); break;
                    }
                }
                if (row.e_tpl > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.e_tpl = row.e_tpl + tres.total_itinerary.e_adulto; break;
                        case 'doce': i.e_tpl = tres.sum_doce((row.e_tpl + tres.total_itinerary.e_adulto)); break;
                        case 'diez': i.e_tpl = tres.sum_final((row.e_tpl + tres.total_itinerary.e_adulto)); break;
                        case 'promocion': i.e_tpl = tres.sum_promotion((row.e_tpl + tres.total_itinerary.e_adulto)); break;
                    }
                }
                if (row.e_chd > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.e_chd = row.e_chd + tres.total_itinerary.e_ninio; break;
                        case 'doce': i.e_chd = tres.sum_doce_chd((row.e_chd + tres.total_itinerary.e_ninio)); break;
                        case 'diez': i.e_chd = tres.sum_final_chd((row.e_chd + tres.total_itinerary.e_ninio)); break;
                        case 'promocion': i.e_chd = tres.sum_promotion((row.e_chd + tres.total_itinerary.e_ninio)); break;
                    }

                }
                /* comunidad */
                if (row.p_swb > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.c_swb = row.p_swb + tres.total_itinerary.c_adulto; break;
                        case 'doce': i.c_swb = tres.sum_doce((row.p_swb + tres.total_itinerary.c_adulto)); break;
                        case 'diez': i.c_swb = tres.sum_final((row.p_swb + tres.total_itinerary.c_adulto)); break;
                        case 'promocion': i.c_swb = tres.sum_promotion((row.p_swb + tres.total_itinerary.c_adulto)); break;
                    }
                }
                if (row.p_dwb > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.c_dwb = row.p_dwb + tres.total_itinerary.c_adulto; break;
                        case 'doce': i.c_dwb = tres.sum_doce((row.p_dwb + tres.total_itinerary.c_adulto)); break;
                        case 'diez': i.c_dwb = tres.sum_final((row.p_dwb + tres.total_itinerary.c_adulto)); break;
                        case 'promocion': i.c_dwb = tres.sum_promotion((row.p_dwb + tres.total_itinerary.c_adulto)); break;
                    }
                }
                if (row.p_tpl > 0) {
                    switch (tres.type_calc) {
                        case 'neto': i.c_tpl = row.p_tpl + tres.total_itinerary.c_adulto; break;
                        case 'doce': i.c_tpl = tres.sum_doce((row.p_tpl + tres.total_itinerary.c_adulto)); break;
                        case 'diez': i.c_tpl = tres.sum_final((row.p_tpl + tres.total_itinerary.c_adulto)); break;
                        case 'promocion': i.c_tpl = tres.sum_promotion((row.p_tpl + tres.total_itinerary.c_adulto)); break;
                    }
                }
                tres.table_mounts.push(i);
            });

            return tres.table_mounts;
        },
    }
})