const reservaciones = new Vue({
    el: '#reservaciones',
    created() {
        this.loader_solicitudes();
    },
    data: {
        solicitudes: [],
        sol: [],
        paquete: [],
        destinos: '',
        user: [],
        tickets: [],
        contact: [],
        people: [],
        codigo_referencia: '',
    },
    methods: {
        loader_solicitudes(){
            swal({
                title: "Espere un momento!",
                text: "Buscando solicitudes de Reservacion.",
                icon: APP_URL + "/imagenes/search.gif",
                button: {
                    text: "Entiendo",
                    value: false,
                    closeModal: false,
                },
                closeOnClickOutside: false,
                closeOnEsc: false,
                dangerMode: true,
            });
            this.cargar_solicitudes();
        },
        cargar_solicitudes(){
            var url = APP_URL+'/find/reservations/solicitudes';
            axios.get(url).then(response => {
                //console.log(response.data);
                swal.close();
                this.solicitudes = response.data;
            }).catch(error => {
                swal.close();
                console.log(error.response);
                if(error.response.status == '500') this.cargar_solicitudes();
            });
        },
        action(action, icono, clase, reservation_id){
            swal({
                title: "Atención!.",
                text: "Esta seguro que desea "+action+" esta solicitud",
                icon: icono,
                buttons: {
                    cancel: 'No hacerlo',
                    confirm: {
                        text: action,
                        className: clase,
                        value: true,
                    },
                },
                closeOnClickOutside: false,
                closeOnEsc: false,
            }).then(response => {
                if(response){
                    swal.close();
                    //console.log(reservation_id);
                    if(action == 'rechazar'){
                        swal({
                            text: 'Introduzca la razón por la que cancela esta solicitud',
                            content: "input",
                            buttons: {
                                cancel: 'Cancelar',
                                confirm: {
                                    text: 'Aceptar',
                                    value: true,
                                    closeModal: false,
                                },
                            },
                            dangerMode: true,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        }).then(observacion => {
                            if(observacion != '' && observacion.length > 0){
                                this.env_data(reservation_id, action, observacion);
                            //console.log(observacion);
                            }
                        });
                    } else{
                        this.env_data(reservation_id, action);
                    }
                }
            });
        },
        post_env(){
            swal.close();
            this.cargar_solicitudes();
            this.closeModal('solicitud_reservacion');
            this.closeModal('codigo_referencia');
        },
        env_data(reservation_id, action, obser = null){
            var url = APP_URL+'/reservations/'+action;
            let a = action.split('ar')[0]+'ada';
            if(action == 'eliminar'){
                var url = APP_URL+'/reservations/'+action+'/'+reservation_id;
                axios.delete(url).then(response => {this.post_env();toastr.success('Solicitud '+a+' con exito!.');}).catch(error => {swal.close();console.log(error.response);});
            } else {
                axios.put(url, {
                    id: reservation_id,
                    observacion: obser,
                    refer_code: this.codigo_referencia,
                }).then(response => {this.post_env();toastr.success('Solicitud '+a+' con exito!.');}).catch(error => {console.log(error.response);});
            }
        },
        open_view_solicitud(solicitud){
            this.sol = solicitud;
            this.paquete = solicitud.paquete;
            this.destinos = '';
            this.user = solicitud.user;
            this.tickets = solicitud.tikets;
            if(this.sol.contactos.length > 0){
                this.contact = solicitud.contactos[0].contact;
                this.people = solicitud.contactos[0].contact.people;
            }
            this.get_destinos();
            $('#solicitud_reservacion').modal('show');
        },
        closeModal(id){
            this.codigo_referencia = '';
            $('#'+id).modal('hide');
        },
        get_destinos() {
            for (let i = 0; i < this.paquete.listados.length; i++) {
                this.destinos += this.paquete.listados[i].destino.nombre;
                if ((i + 1) < this.paquete.listados.length) {
                    this.destinos += '/';
                }
            }
        },
        aprobar(){
            if(this.sol.codigo_referencia == null || this.sol.codigo_referencia == ''){
                $('#codigo_referencia').modal('show');
            } else {
                this.codigo_referencia = this.sol.codigo_referencia;
                this.action('aprobar', 'info', 'btn-primary', this.sol.id);
            }
        }
    }
});