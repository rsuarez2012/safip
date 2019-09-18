const main_de_hoteles = new Vue({
    el: '#main-hoteles',
    created() {
        this.loadPage();
    },
    data: {
        route: APP_URL,
        editar: false,
        // variables de hoteles
        hoteles: [],
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
        offset: 2,
        sort: 10,
        search: "",
        hotel: {
            id: 0,
            nombre: "",
            estrella: "",
            categoria_id: "",
            destino_id: "",
            p_simple: "",
            p_doble: "",
            p_triple: "",
            p_ninio: "",
            p_sj: "",
            p_s: "",
            e_simple: "",
            e_doble: "",
            e_triple: "",
            e_ninio: "",
            e_sj: "",
            e_s: "",
            check_in: "",
            check_out: "",
            enlace: "",
        },
        // variables de destino
        destinos: [],
        destino: 0,
        // variables de categoria
        categorias: [],
        categoria: 0,
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
            this.getHoteles();
            this.getCategorias();
            this.getDestinos();

        },
        /*getHoteles(page) {
            let ruta_hoteles = this.route + "/hoteles/get?page=" + page + "&sort=" + this.sort + "&name=" + this.search;
            axios.get(ruta_hoteles).then(response => {
                this.hoteles = response.data.hoteles.data;
                this.pagination = response.data.pagination;
                swal.close();
            });
        },*/
        changePage: function (page) {
            this.pagination.current_page = page;
            this.getHoteles(page);
        },
        getDestinos() {
            let ruta_destinos = "/get/destinos/hoteles";
            axios.get(this.route + ruta_destinos).then(response => {
                this.destinos = response.data;
                let options = [];
                this.destinos.forEach(destino => {
                    options.push({ text: destino.nombre, id: destino.id });
                });
                $("select[name='destinos']").select2({
                    placeholder: 'Seleccione una opción',
                    data: options,
                }).on('select2:select', () => {
                    var val = $("select[name='destinos']").select2('data');
                    this.hotel.destino_id = val[0].id;
                });
            });
        },
        getCategorias() {
            let ruta_categorias = "/get/categorias/hoteles";
            axios.get(this.route + ruta_categorias).then(response => {
                this.categorias = response.data;
                let options = [];
                this.categorias.forEach(categoria => {
                    options.push({ text: categoria.nombre, id: categoria.id });
                });
                $("select[name='categorias']").select2({
                    placeholder: 'Seleccione una opción',
                    data: options,
                }).on('select2:select', () => {
                    var val = $("select[name='categorias']").select2('data');
                    this.hotel.categoria_id = val[0].id;
                });
            });
        },
        // metodos de hotel
        abrirModalCrear() {
            this.vaciar_modal();
            this.hotel.id = 0;
            this.editar = false;
            $("#modal_hotel").fadeIn(300);
            this.getDestinos();
            this.getCategorias();
        },
        guardarHotel() {
            let faltante = false;
            for (elemento in this.hotel) {
                if (elemento == "categoria_id" && this.hotel[elemento] == "") {
                    toastr.warning("Por favor seleccione una categoria");
                    faltante = true;
                } else if (elemento == "destino_id" && this.hotel[elemento] == "") {
                    toastr.warning("Por favor seleccione un destino");
                    faltante = true;
                } else if (elemento == "nombre" && this.hotel[elemento] == "") {
                    toastr.warning("Por favor Coloque un nombre");
                    faltante = true;
                } else if (elemento == "estrella" && this.hotel[elemento] == "") {
                    toastr.warning("Por favor Coloque un dato en *");
                    faltante = true;
                } else if (elemento == "check_in" && this.hotel[elemento] == "") {
                    toastr.warning("Por favor Coloque un dato en Check In");
                    faltante = true;
                } else if (elemento == "check_out" && this.hotel[elemento] == "") {
                    toastr.warning("Por favor Coloque un dato en Check Out");
                    faltante = true;
                } else if (elemento != "enlace" && this.hotel[elemento] == "") {
                    this.hotel[elemento] = 0;
                }
            }
            if (!faltante) {
                this.cerrarModal();
                this.loading();
                if (!this.editar) {
                    url_guardar_hotel = this.route + "/tablero/Hoteles/Admin/Store"
                    axios.post(url_guardar_hotel, { hotel: this.hotel }).then(response => {
                        this.alert("Excelente!", "Hotel Creado Correctamente", "success");
                        this.getHoteles();
                        this.vaciar_modal();
                    }).catch(error => {
                        swal.close();
                    });
                } else {
                    url_editar_hotel = this.route + "/tablero/Hoteles/Admin/Update"
                    axios.post(url_editar_hotel, { hotel: this.hotel }).then(response => {
                        this.alert("Excelente!", "Datos del hotel " + this.hotel.nombre + " se modificaron Correctamente", "success");
                        this.getHoteles();
                        this.vaciar_modal();
                    }).catch(error => {
                        swal.close();
                    });
                }
            }
        },
        eliminarHotel(hotel_id) {
            swal({
                title: "Seguro Que Quiere Elimar Este Hotel?",
                text: "Si elimina el hotel se eliminaran los calculos donde se requieran de los datos de este hotel.",
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
                    this.loading();
                    axios.delete(this.route + "/tablero/Hoteles/Admin/delete/" + hotel_id).then(response => {
                        this.getHoteles();
                        this.alert("Exito!", "Hotel Eliminado", "success");
                    }).catch(errors => {
                        toastr.error("fallo");
                        console.log(errors.response);
                    });
                } else {
                    swal.close();
                }
            });
        },
        verHotel(hotel) {
            this.editar = true;
            $("#modal_hotel").fadeIn(300);
            this.hotel.id = hotel.id,
                this.hotel.nombre = hotel.nombre;
            this.hotel.estrella = hotel.estrella;
            this.hotel.categoria_id = hotel.categoria_id;
            this.hotel.destino_id = hotel.destino_id;
            this.hotel.p_simple = hotel.p_swb;
            this.hotel.p_doble = hotel.p_dwb;
            this.hotel.p_triple = hotel.p_tpl;
            this.hotel.p_ninio = hotel.p_chd;
            this.hotel.p_sj = hotel.p_sj;
            this.hotel.p_s = hotel.p_s;
            this.hotel.e_simple = hotel.e_swb;
            this.hotel.e_doble = hotel.e_dwb;
            this.hotel.e_triple = hotel.e_tpl;
            this.hotel.e_ninio = hotel.e_chd;
            this.hotel.e_sj = hotel.e_sj;
            this.hotel.e_s = hotel.e_s;
            this.hotel.check_in = hotel.check_in;
            this.hotel.check_out = hotel.check_out;
            this.hotel.enlace = hotel.enlace;
            this.getDestinos();
            this.getCategorias();
        },
        // reutilizadas
        vaciar_modal() {
            this.hotel.nombre = "";
            this.hotel.estrella = "";
            this.hotel.categoria_id = "";
            this.hotel.destino_id = "";
            this.hotel.p_simple = "";
            this.hotel.p_doble = "";
            this.hotel.p_triple = "";
            this.hotel.p_ninio = "";
            this.hotel.p_sj = "";
            this.hotel.p_s = "";
            this.hotel.e_simple = "";
            this.hotel.e_doble = "";
            this.hotel.e_triple = "";
            this.hotel.e_ninio = "";
            this.hotel.e_sj = "";
            this.hotel.e_s = "";
            this.hotel.check_in = "";
            this.hotel.check_out = "";
            this.hotel.enlace = "";
        },
        cerrarModal() {
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
    },

    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }

            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
});

const main_de_categorias = new Vue({
    el: "#modal-categorias",
    created() {
        this.getCategorias();
        let intervalo = setTimeout(() => {
            $('#tabla-categorias').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": true
            });
        }, 6000);
    },
    data: {
        categorias: [],
    },
    methods: {
        getCategorias() {
            let ruta_categorias = "/get/categorias/hoteles";
            axios.get(main_de_hoteles.route + ruta_categorias).then(response => {
                this.categorias = response.data;
            });
        },
        abrirModalCategorias() {
            this.getCategorias();
            $("#modal-categorias").fadeIn(300);
        },
        crearCategoria() {
            swal("Escribir nombre de la nueva categoria :", {
                content: "input",
            }).then((value) => {
                if (value == "" || value == null) {
                    toastr.warning("El Texto No Puede Estar Vacio");
                } else {
                    let ruta_crear_categorias = "/tablero/Hoteles/Admin/Categorias/Store";
                    axios.post(main_de_hoteles.route + ruta_crear_categorias, { nombre: value }).then(response => {
                        toastr.success("Categoria Creada Correctamente.");
                        this.getCategorias();
                    });
                }
            });
        },
        editarCategoria(categoria) {
            swal("Editar nombre de categoria " + categoria.nombre + " :", {
                content: "input",
            }).then((value) => {
                if (value == "" || value == null) {
                    toastr.warning("El Texto No Puede Estar Vacio");
                } else {
                    let datos = {
                        nombre: value,
                        id: categoria.id,
                    }
                    let ruta_editar_categorias = "/tablero/Hoteles/Admin/Categorias/Update";
                    axios.post(main_de_hoteles.route + ruta_editar_categorias, { datos_categorias: datos }).then(response => {
                        toastr.success("Categoria Modificada.");
                        this.getCategorias();
                        main_de_hoteles.getHoteles();
                    });
                }
            });
        },
        eliminarCategoria(categoria_id) {
            swal({
                title: "Seguro Que Quiere Elimar Esta categoria?",
                text: "Si elimina la categoria , se eliminaran todos los hoteles que tengan esta categoria.",
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
                    main_de_hoteles.loading();
                    axios.delete(main_de_hoteles.route + "/tablero/Hoteles/Admin/Categoria/Delete/" + categoria_id).then(response => {
                        this.getCategorias();
                        main_de_hoteles.getHoteles();
                        main_de_hoteles.alert("Exito!", "Categoria Eliminada", "success");
                    }).catch(errors => {
                        this.getCategorias();
                        main_de_hoteles.getHoteles();
                    });
                } else {
                    swal.close();
                }
            });
        },
    }
});