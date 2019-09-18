// component
Vue.component('table-paginated', {
    props: ['tipo', 'ruta'],

    template: '#datatable-vue',
    created() {
        this.loadPage()
    },
    data() {
        return {
            /* variabes paginacion */
            rol_usuario: 0,
            primera_carga: true,
            datos: [],
            agencias: [],
            tipo_pagos: [],
            vendedores: [],
            consolidadores: [],
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
            },
            offset: 1,
            sort: 10,
            search: "",
            /*  */
            route: APP_URL,
            boleto: {
                id: 0,
                otro: {
                    id: 0
                },
                qantu: {
                    id: 0
                },
                cotizacion: {
                    agencia_id: 0
                }
            },
            comision_auxiliar: 0,
            fecha_inicial: "",
            fecha_final: "",
            lista_consolidadores: "",
            lista_agencias: "",
            lista_vendedores: "",
            cliente_nombre: "",
            tipo_venta: ""
        }
    },
    methods: {
        loadPage() {
            swal({
                title: "Cargando",
                text: "Espere un momento mientras se carga la pagina",
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
            this.set_dft_date()
            this.getData()
            this.getAgencias()
            this.getVendedores()
            this.getConsolidadores()
            /* this.getTipoPago() */
        },
        getData(page) {
            let get_ruta = this.ruta + "?tipo=" + this.tipo +
                "&page=" + page +
                "&sort=" + this.sort +
                "&search=" + this.search +
                "&fecha_inicial=" + this.fecha_inicial +
                "&fecha_final=" + this.fecha_final +
                "&consolidadores=" + this.lista_consolidadores +
                "&agencias=" + this.lista_agencias +
                "&vendedores=" + this.lista_vendedores +
                "&cliente=" + this.cliente_nombre +
                "&tipo_venta=" + this.tipo_venta
            axios.get(get_ruta).then(response => {
                this.rol_usuario = response.data.rol
                this.datos = response.data.registros.data
                this.pagination = response.data.pagination
                $(".select2").select2()
                swal.close()
            });

        },
        filtroGeneral() {
            if ($(".padre_" + this.tipo + " #select_filter_conso").val() != null && $(".padre_" + this.tipo + " #select_filter_conso").val() != "") {
                this.lista_consolidadores = $(".padre_" + this.tipo + " #select_filter_conso").val().toString()
            } else {
                this.lista_consolidadores = ""
            }
            if ($(".padre_" + this.tipo + " #select_filter_agency").val() != null && $(".padre_" + this.tipo + " #select_filter_agency").val() != "") {
                this.lista_agencias = $(".padre_" + this.tipo + " #select_filter_agency").val().toString()
            } else {
                this.lista_agencias = ""
            }
            if ($(".padre_" + this.tipo + " #select_filter_vendedor").val() != null && $(".padre_" + this.tipo + " #select_filter_vendedor").val() != "") {
                this.lista_vendedores = $(".padre_" + this.tipo + " #select_filter_vendedor").val().toString()
            } else {
                this.lista_vendedores = ""
            }
            this.loading()
            this.getData()
            this.cerrarModal()
        },
        getAgencias() {
            let get_route = this.route + "/tablero/get/agencias/paquetes"
            axios.get(get_route).then(response => {
                this.agencias = response.data
                swal.close()
            });
        },
        getConsolidadores() {
            let get_route = this.route + "/tablero/get/consolidadores/paquetes"
            axios.get(get_route).then(response => {
                this.consolidadores = response.data;
            });
        },
        getVendedores() {
            let get_route = this.route + "/tablero/get/vendedores/paquetes"
            axios.get(get_route).then(response => {
                this.vendedores = response.data;
            });
        },
        /* getTipoPago() {
            let get_route = this.route + "/tablero/get/tipo/pago/paquetes"
            axios.get(get_route).then(response => {
                this.tipo_pagos = response.data;
            });
        }, */
        changePage: function (page) {
            this.pagination.current_page = page
            this.getData(page)
        },
        showModalEdit(boleto) {
            this.boleto = boleto
            this.comision_auxiliar = boleto.comision
            $('.padre_' + this.tipo).children("#editar_boleto").fadeIn()
        },
        showModalFilter() {
            $('.padre_' + this.tipo).children(".modal-filter").fadeIn()
        },
        calculoBoletoEditar() {
            if (this.boleto.costo_neto != 0 && this.boleto.costo_neto != "" && this.boleto.costo_neto != null && this.boleto.comision != "" && this.boleto.comision != null) {
                this.boleto.comision = Math.round(this.boleto.costo_neto * this.comision_auxiliar) / 100

                this.boleto.pago_mayorista = Math.round(this.boleto.costo_neto - this.boleto.comision - this.boleto.incentivo)

                this.boleto.a_pagar = Math.round(parseFloat(this.boleto.total_venta) - parseFloat(this.boleto.pago_mayorista))
            }
        },
        actualizarDatos() {
            let consolidador = $(".padre_" + this.tipo + " .select_consolidador").val()
            if (consolidador != null && consolidador != "" && consolidador != 0) {
                if (this.boleto.qantu) {
                    this.boleto.qantu.proveedor_id = consolidador
                } else {
                    this.boleto.otro.proveedor_id = consolidador
                }
            }
            this.loading()
            let edit_url = this.route + "/tablero/edit/boletos/paquetes"
            axios.put(edit_url, {
                boleto: this.boleto
            }).then(response => {
                console.log(response.data)
                this.getData()
                $(".modal").fadeOut(300)
                toastr.success("Boleto Actualizado!")
            }).catch(errors => {
                console.log(errors)
                console.log(errors.response);
                document.write(errors.response.data)
            })
        },
        cerrarModal() {
            $(".modal").fadeOut(300)
        },
        anularBoleto(boleto) {
            swal({
                title: "Seguro Que Quiere Anular este boleto?",
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
                    let url_anular = this.route + "/tablero/anular/boletos/paquetes/" + boleto
                    axios.put(url_anular).then(response => {
                        this.getData()
                        this.alert("exito", "Boleto anulado correctamente.", "success")
                    }).catch(errors => {
                        console.log(errors.response)
                        document.write(errors.response.data)
                    });
                } else {
                    swal.close()
                }
            })
        },
        datesFilterData() {
            if (this.valid_dates() == 1) {
                this.loading()
                this.getData()
            }
        },
        set_dft_date() {
            let y = new Date().getFullYear()
            let m = new Date().getMonth() + 1
            let d = new Date().getDate()

            if (m < 10) m = '0' + m
            if (d < 10) d = '0' + d
            let date = y + "-" + m + "-" + d
            console.log(date)
            this.fecha_final = date
            this.fecha_inicial = date
        },
        valid_dates() {
            if (this.fecha_inicial == null || this.fecha_inicial == "" || this.fecha_final == null || this.fecha_final == "") {
                return toastr.warning("Seleccione una fecha inicial y una fecha final")
            } else if (this.fecha_inicial > this.fecha_final) {
                return toastr.warning("La fecha inicial no puede ser mayor que la final")
            } else {
                return 1
            }
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
            })
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
            })
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
})
// instancia del vue
const main = new Vue({
    el: '#main-vue',
    data: {
        route: APP_URL,
    },
    methods: {

    },
})