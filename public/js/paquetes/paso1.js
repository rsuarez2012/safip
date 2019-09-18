$(document).ready(() => {
    $('.date').datepicker({
        multidate: true,
        format: 'yyyy-m-d',
        startDate: new Date(),
    });
})

const uno = new Vue({
    el: '#main-paso1',
    created() {
        this.getCategories();
        this.getPackage();
        this.loadMap();
    },
    data: {
        dateActual: new Date(),
        /* variables */
        route: APP_URL,
        categories: [],
        package_edit_id: 0,
        package: {
            zone:"costa",
            action: "Crear",
            code: "",
            name: "",
            extrac: "nada",
            description: "nada",
            category: "",
            image: "",
            edit: false,
            validated: false,
        },
        repeat: false,
        departures: [],
        departure: "",
        departure_list: [],
        point_lat: null,
        point_long: null,
        quotas: 0,
    },
    methods: {
        getCategories() {
            var url = this.route + '/get/categories/packages';
            axios.get(url).then(response => {
                this.categories = response.data;
            }).catch(error => {
                console.log(error);
            });
        },
        loadMap() {
            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: {
                    lat: -11.9939394,
                    lng:
                        -77.06406809999999
                },
                zoom: 17
            });
            var marker = new google.maps.Marker({
                position: {
                    lat: -11.9939394,
                    lng:
                        -77.06406809999999
                },
                map: map,
                icon: APP_URL + '/imagenes/flor_qantu.png',
                draggable: true
            });
            var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
            google.maps.event.addListener(searchBox, 'places_changed', function () {
                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();
                var i, place;
                for (i = 0; place = places[i]; i++) {
                    bounds.extend(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                }
                map.fitBounds(bounds);
                map.setZoom(17);
            });
            google.maps.event.addListener(marker, 'position_changed', function () {
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();
                $('#lat').val(lat);
                $('#lng').val(lng);
            });
        },
        getPackage() {
            var url = window.location.href;
            var position = url.split("/")[(url.split("/").length) - 1];
            var package_id = parseInt(position);
            if (Number.isInteger(package_id)) {
                axios.get(this.route + "/paso1/get/package/" + package_id).then(response => {
                    this.package_edit_id = response.data.id;
                    this.package.edit = true;
                    this.package.validated = true;
                    this.package.action = "Editar";
                    this.package.name = response.data.nombre;
                    this.package.code = response.data.codigo;
                    this.package.extrac = response.data.extracto;
                    this.package.category = response.data.categoria_id;
                    this.package.zone = response.data.zona;
                    this.package.description = response.data.descripcion;
                    this.package.image = response.data.imagen;
                    response.data.salidas.forEach(element => {
                        var departureActual = {
                            id: element.id,
                            departure: element.fecha_salida,
                            quotas: element.cupos,
                            lat: element.punto.latitud,
                            lng: element.punto.longitud,
                            point_name: element.punto.nombre,
                        }
                        this.departures.push(departureActual);
                    });
                }).catch(errors => {
                    console.log(errors);
                });
            }
        },
        addDate() {
            this.departure_list = $("input[name='dates_datepicker']").val().split(",");
            if (this.departure_list[0] == "") {
                toastr.warning("Debe seleccionar al menos una fecha ");
            } else {
                if (this.quotas == 0) {
                    toastr.warning("Debe Indicar cantidad de cupos");
                } else {
                    if ($("#actual_nombre").val() == "") {
                        toastr.warning("Seleccione un Punto de Encuentro");
                    } else {
                        /* this.departures.forEach(element => {
                            if (element.departure == this.departure) {
                                this.repeat = true;
                            }
                        }); */

                        if (!this.repeat) {
                            let newItems = [];
                            this.departure_list.forEach(departure => {
                                newItems.push({
                                    departure: departure,
                                    quotas: this.quotas,
                                    id: 0,
                                    lat: $("#lat").val(),
                                    lng: $("#lng").val(),
                                    point_name: $("#nombre_punto").val(),
                                });
                            });

                            this.loadMap();
                            if (this.package.edit) {
                                axios.post(this.route + "/save/departure/" + this.package_edit_id, { departures: newItems }).then(response => {
                                    for (let index = 0; index < response.data.length; index++) {
                                        newItems[index].id = response.data[index];
                                        this.departures.push(newItems[index]);
                                        this.departure = "";
                                        this.quotas = 0;
                                    }
                                    /* newItem.id = response.data; */
                                });
                            }
                            this.departure_list.forEach(date => {
                                item = {
                                    departure: date,
                                    quotas: this.quotas,
                                    id: 0,
                                    lat: $("#lat").val(),
                                    lng: $("#lng").val(),
                                    point_name: $("#nombre_punto").val(),
                                }
                                this.departures.push(item);
                            });

                            $("#lat").val("");
                            $("#lng").val("");
                            $("#actual_nombre").val("");
                            $("#button-modal-point").show();
                            $("#actual_nombre").hide("");
                            $("#nombre_punto").val("");
                            $("#searchmap").val("");
                            $('.date').datepicker('update', '');

                        } else {
                            toastr.warning("Ya tiene una salida asignada a esa fecha.");
                        }
                        this.repeat = false;
                    }
                }
            }
        },
        changeCategory() {
            if (this.package.category == 7) {
                this.departures = [];
                this.departure = "";

            }
        },
        validateCode() {
            if (this.package.code == "") {
                toastr.warning("Debe colocar un codigo");
            } else {
                axios.get(this.route + "/validate/code/" + this.package.code).then(response => {
                    if (response.data > 0) {
                        toastr.info("El codigo esta repetido.");
                    } else {
                        toastr.success("Codigo " + this.package.code + " Valido");
                        this.package.validated = true;
                    }
                });
            }
        },
        savePackage() {
            let complete = true;
            let editVar = this.package.edit;
            let data = Object.values(this.package);
            data.forEach(function (element, index) {
                if (element === "") {
                    if (editVar && index != 7) {
                        complete = false;
                    } else if (!editVar) {
                        complete = false;
                    }

                }
            });
            if (!complete) {
                toastr.warning("Debe LLenar todos los campos");
            } else {
                if (this.package.category == 7 && this.departures.length == 0) {
                    toastr.warning("Disculpe Las salidas confirmadas deben tener al menos una fecha de salida");
                } else {
                    swal({
                        title: "Enviando",
                        text: "Espere un momento mientras se guarda el paquete.",
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
                    urlSavePackage = this.route + "/tablero/Paquete/Admin/Paso/1/Store";
                    //Creo el formData
                    var dataPackage = new FormData();
                    //Añadimos la imagen seleccionada
                    dataPackage.append('img', this.package.image);
                    dataPackage.append('name', this.package.name);
                    dataPackage.append('code', this.package.code);
                    dataPackage.append('description', this.package.description);
                    dataPackage.append('extrac', this.package.extrac);
                    dataPackage.append('category', this.package.category);
                    dataPackage.append('zone', this.package.zone);
                    if (this.package.edit) {
                        axios.post(this.route + "/tablero/Paquete/Admin/Paso/1/Update/" + this.package_edit_id, dataPackage).then(response => {
                            swal({
                                title: "Exito",
                                text: "Paquete Editado correctamente",
                            });
                            window.location.href = this.route + "/tablero/Paquetes/Admin/Index";
                        }).catch(errors => {
                            console.log(errors);
                        });
                    } else {
                        this.departures.forEach(function (element, index) {
                            dataPackage.append("departures[" + index + "][departure]", element.departure);
                            dataPackage.append("departures[" + index + "][quotas]", element.quotas);
                            dataPackage.append("departures[" + index + "][lat]", element.lat);
                            dataPackage.append("departures[" + index + "][lng]", element.lng);
                            dataPackage.append("departures[" + index + "][point_name]", element.point_name);
                        });
                        console.log(dataPackage);
                        axios.post(urlSavePackage, dataPackage).then(response => {
                            swal({
                                title: "Exito",
                                text: "Paquete creado correctamente",
                            });
                            console.log(dataPackage);
                            if(this.package.category != 6){
                                window.location.href = this.route + "/tablero/Admin/Paso/2/Paquete/" + response.data;
                            }else{
                                window.location.href = this.route + "/tablero/Paquetes/Admin/Index/";

                            }
                        }).catch(errors => {
                            console.log(errors);
                        });
                    }
                }
            }
        },
        processFile(event) {
            this.package.image = event.target.files[0];
        },
        deleteDate(index, itemDeleted) {
            if (this.package.edit) {
                axios.put(this.route + '/delete/departure/' + itemDeleted.id);
            }
            this.departures.splice(index, 1);
        },

    }
})
