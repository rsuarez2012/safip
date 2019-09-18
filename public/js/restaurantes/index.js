/* $(function () {
    $('#restaurante').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
});

$(function () {
    $(".select2").select2();
}); */

const restaurantes = new Vue({
    el: "#main-restaurantes",
    created() {
        this.loadPage();
    },
    data: {
        restaurantes: [],
        destinos: [],
        route: APP_URL,
        restaurante: {
            id: 0,
            nombre: "",
            destino_id: 0,
            peruano_id: 0,
            peruano_adulto: 0,
            peruano_estudiante: 0,
            peruano_ninio: 0,
            extranjero_id: 0,
            extranjero_adulto: 0,
            extranjero_estudiante: 0,
            extranjero_ninio: 0,
            comunidad_id: 0,
            comunidad_adulto: 0,
            comunidad_estudiante: 0,
            accion: "crear",
        }
    },
    methods: {
        loadPage() {
            this.loading("Espere Un Momento", "Cargando los restaurnates registrados", this.route + "/imagenes/loader.gif");
            this.getRestaurants();
        },
        getRestaurants() {
            axios.get(this.route + "/get/restaurantes/lista").then(response => {
                this.restaurantes = response.data;
                swal.close();
                let table = $('#tabla-restaurantes').DataTable();
                table.destroy();
                let intervalo = setTimeout(() => {
                    $('#tabla-restaurantes').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": false,
                        "info": true,
                        "autoWidth": true
                    });
                }, 1000);
            }).catch(errors => {
                console.log(errors.response);
            });
        },
        modalNuevoRestaurante() {
            $("#modal_restaurante").fadeIn(300);
            vaciarDatos = {
                id: 0,
                nombre: "",
                destino_id: 0,
                peruano_id: 0,
                peruano_adulto: 0,
                peruano_estudiante: 0,
                peruano_ninio: 0,
                extranjero_id: 0,
                extranjero_adulto: 0,
                extranjero_estudiante: 0,
                extranjero_ninio: 0,
                comunidad_id: 0,
                comunidad_adulto: 0,
                comunidad_estudiante: 0,
                accion: "crear",
            }
            this.restaurante = vaciarDatos;
        },
        guardarRestaurante() {
            for (atributo in this.restaurante) {
                if (atributo == "nombre" || atributo == "destino_id") {
                    if (this.restaurante[atributo] == "" || this.restaurante[atributo] == null) {
                        toastr.warning("Coloque un nombre y seleccione un destino");
                        return;
                    }
                } else if (atributo != "accion") {
                    if (this.restaurante[atributo] == "" || this.restaurante[atributo] == null) {
                        this.restaurante[atributo] = 0;
                    }
                }
            }
            this.loading("Guardando", "guardando nuevo restaurante", this.route + "/imagenes/loader.gif");
            axios.post(this.route + "/tablero/paquetes/restaurante/admin/store", { restaurante: this.restaurante }).then(response => {
                toastr.success("Restaurante Registrado Correctamente");
                this.getRestaurants();
                this.cerrarModal();
            }).catch(errors => {
                console.log(errors.response);
            });
        },
        setRestaurantes(restaurante) {
            $("#modal_restaurante").fadeIn(300);
            this.restaurante.id = restaurante.id;
            this.restaurante.nombre = restaurante.nombre;
            this.restaurante.destino_id = restaurante.destino_id;
            this.restaurante.peruano_id = restaurante.peruano.id;
            this.restaurante.peruano_adulto = restaurante.peruano.adulto;
            this.restaurante.peruano_estudiante = restaurante.peruano.estudiante;
            this.restaurante.peruano_ninio = restaurante.peruano.ninio;
            this.restaurante.extranjero_id = restaurante.extranjero.id;
            this.restaurante.extranjero_adulto = restaurante.extranjero.adulto;
            this.restaurante.extranjero_estudiante = restaurante.extranjero.estudiante;
            this.restaurante.extranjero_ninio = restaurante.extranjero.ninio;
            this.restaurante.comunidad_id = restaurante.comunidad.id;
            this.restaurante.comunidad_adulto = restaurante.extranjero.adulto;
            this.restaurante.comunidad_estudiante = restaurante.comunidad.estudiante;
            this.restaurante.accion = "editar";
        },
        updateRestaurantes() {
            for (atributo in this.restaurante) {
                if (atributo == "nombre" || atributo == "destino_id") {
                    if (this.restaurante[atributo] == "" || this.restaurante[atributo] == null) {
                        toastr.warning("Coloque un nombre y seleccione un destino");
                        return;
                    }
                } else if (atributo != "accion") {
                    if (this.restaurante[atributo] == "" || this.restaurante[atributo] == null) {
                        this.restaurante[atributo] = 0;
                    }
                }
            }
            this.loading("Actualizando", "Actualizando Datos del restaurante", this.route + "/imagenes/loader.gif");
            axios.post(this.route + "/tablero/paquetes/restaurante/admin/Update/" + this.restaurante.id, { restaurante: this.restaurante }).then(response => {
                this.getRestaurants();
                toastr.success("Restaurante Actualizado");
                this.cerrarModal();
            }).catch(errors => {
                console.log(errors.response);
            });
        },
        eliminarRestaurantes(restaurante) {
            swal({
                title: "¿Esta Seguro?",
                text: "seguro que quiere eliminar el restaurante",
                icon: "warning",
                buttons: ["No", "Si, Estoy Seguro"],
                dangerMode: true,
            }).then((aceptar) => {
                if (aceptar) {
                    this.loading("Eliminando", "Se esta eliminando el restaurante", this.route + "/imagenes/loader.gif");
                    axios.delete(this.route + "/tablero/paquetes/restaurante/admin/destroy/" + restaurante.id).then(response => {
                        this.getRestaurants();
                        toastr.success("Restaurante Eliminado");
                        this.cerrarModal();
                    }).catch(errors => {
                        console.log(errors.response);
                    });
                }
            });
        },
        cerrarModal() {
            $(".modal").fadeOut(300);
        },
        loading(title, text, icon) {
            swal({
                title: title,
                text: text,
                icon: icon,
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
    }
}); 