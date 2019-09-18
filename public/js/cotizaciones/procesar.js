const procesar = new Vue({
    el: "#div-procesar-cotizacion",
    created() {
        this.listarPasajeros();
    },
    data: {
        cotizacion_id: 0,
        informacion_proveedor: {
            consolidador: null,
            aerolinea: null,
            comision: 0,
            codigo: null,
        },
        lista_pasajeros: [],
        lista_boletos: [],
        indice_adicionales: 0,
        datos_pago: {
            tipo: null,
            total_pagar: 0,
            monto_cancelar: 0,
            restante: 0,
            banco_emisor: null,
            banco_receptor: null,
            nro_operacion: null,
            dias_para_pagar: 0,
            disable_monto: true,
            disable_datos_banco: true,
            disable_dias_para_pagar: true,
        }
    },
    methods: {
        buscarComision() {
            if (this.informacion_proveedor.consolidador != null && this.informacion_proveedor.aerolinea != null) {
                toastr.info("Buscando si existe comision registrada.");
                axios.get(APP_URL + "/buscar/comision/" + this.informacion_proveedor.aerolinea + "/" + this.informacion_proveedor.consolidador).then(response => {
                    if (response.data) {
                        toastr.success("Comision encontrada.");
                        this.informacion_proveedor.comision = response.data.comision;
                    } else {
                        toastr.error("No existe comision registrada.");
                        this.informacion_proveedor.comision = 0;
                    }
                }).catch(errors => {
                    console.log(errors.response);
                });
            }
        },
        validarCodigo() {
            if (this.informacion_proveedor.codigo == null || this.informacion_proveedor.codigo == "") {
                toastr.warning("Codigo no puede estar vacio.");
            } else {
                axios.get(APP_URL + "/validar/codigo/boleto/" + this.informacion_proveedor.codigo).then(response => {
                    if (response.data) {
                        toastr.error("Este codigo ya esta registrado.");
                    }
                }).catch(errors => {
                    console.log(errors.data);
                })
            }
        },
        listarPasajeros() {
            this.cotizacion_id = $("#id_cotizacion_boleto").val();
            this.lista_pasajeros = [];
            let cantidad = $("input[name='dato_cantidad_pasajeros']").val();
            for (let i = 0; i < cantidad; i++) {
                this.lista_pasajeros.push({
                    tipo_doc: 'dni',
                    cedula: '',
                    nombre: '',
                    apellido: '',
                    tipo_pas: 'adulto',
                    tipo: 'Directo',
                    id: 0,
                    telefono: null,
                    email: null,
                    direccion: null,
                    validate: {
                        dni_blocked: false,
                        passenger_type_blocked: false,
                    }
                });
                this.lista_boletos.push({
                    nro_ticket: null,
                    neto: 0,
                    tarifa: 0,
                    igv: 0,
                    total: 0,
                    pago_consolidador: 0,
                    tarifa_fee: 0,
                    utilidad: 0,
                    comision: 0,
                    anulado: 0,
                    pagado: 0,
                    procesado: false,
                });
            }
        },
        buscarEmpleado(indice) {
            if (this.lista_pasajeros[indice].cedula == "" || this.lista_pasajeros[indice].cedula == null) {
                toastr.warning("Debe colocar una cedula para poder buscarla.");
                return;
            }
            let into = false;
            this.lista_pasajeros.forEach((ps, i) => {
                if (i != indice) {
                    if (ps.cedula == this.lista_pasajeros[indice].cedula) {
                        into = true;
                    }
                }
            });
            if (!into) {
                toastr.info("Buscando Pasajero");
                axios.get(APP_URL + "/buscar/cedula/procesar/cotizacion/" + this.lista_pasajeros[indice].cedula).then(response => {
                    if (response.data) {
                        toastr.success("Pasajero Registrado.");
                        this.lista_pasajeros[indice].tipo_doc = response.data.tipo_documento;
                        this.lista_pasajeros[indice].cedula = response.data.cedula_rif;
                        this.lista_pasajeros[indice].nombre = response.data.nombre;
                        this.lista_pasajeros[indice].apellido = response.data.apellido;
                        this.lista_pasajeros[indice].id = response.data.id;
                        this.lista_pasajeros[indice].tipo = response.data.tipo_pasajero;
                        this.lista_pasajeros[indice].telefono = response.data.telefono;
                        this.lista_pasajeros[indice].email = response.data.email;
                        this.lista_pasajeros[indice].direccion = response.data.direccion;
                        this.lista_pasajeros[indice].validate.dni_blocked = true;
                    } else {
                        toastr.warning("Pasajero no Registrado.");
                        $("#datos_nombre_" + indice).attr("disabled", false);
                        $("#datos_apellido_" + indice).attr("disabled", false);
                        $("#datos_tipo_" + indice).attr("disabled", false);
                        this.lista_pasajeros[indice].nombre = "";
                        this.lista_pasajeros[indice].apellido = "";
                        this.lista_pasajeros[indice].id = 0;
                        this.lista_pasajeros[indice].tipo = "";
                        this.lista_pasajeros[indice].telefono = "";
                        this.lista_pasajeros[indice].email = "";
                        this.lista_pasajeros[indice].direccion = "";
                        this.lista_pasajeros[indice].validate.dni_blocked = false;
                    }

                    $("#datos_procesar_" + indice).attr("disabled", false);
                    $("#datos_adicionales_" + indice).attr("disabled", false);
                    $("#clear_data_" + indice).attr("disabled", false);
                }).catch(erros => {
                    console.log(erros.data);
                });
            } else {
                toastr.error("El DNI, RUC ó pasaporte ya se encuentra registrado!.");
                //this.lista_pasajeros[indice].cedula = "";
                return;
            }
        },
        modalDatosAdicionales(indice) {
            this.indice_adicionales = indice;
            $("#modal-dato-adicionales").fadeIn(300);
        },
        set_default_value_depending_type_pas(new_index) {
            let encontrado = false;
            let i_encontrado = -1;
            this.lista_pasajeros.forEach((pas, index) => {
                if (index != new_index) {
                    if (!encontrado) {
                        if (pas.tipo_pas == this.lista_pasajeros[new_index].tipo_pas) {
                            if (this.lista_boletos[index].total > 0) {
                                encontrado = true;
                                i_encontrado = index;
                            }
                        }
                    }
                }
            });
            if (encontrado) {
                toastr.info("Se añadieron las tarifas de otro pasajero de tipo " + this.lista_pasajeros[i_encontrado].tipo_pas, "Excelente!");
                this.lista_boletos[new_index].neto = this.lista_boletos[i_encontrado].neto;
                this.lista_boletos[new_index].tarifa = this.lista_boletos[i_encontrado].tarifa;
                this.lista_boletos[new_index].igv = this.lista_boletos[i_encontrado].igv;
                this.lista_boletos[new_index].total = this.lista_boletos[i_encontrado].total;
                this.lista_boletos[new_index].pago_consolidador = this.lista_boletos[i_encontrado].pago_consolidador;
                this.lista_boletos[new_index].tarifa_fee = this.lista_boletos[i_encontrado].tarifa_fee;
                this.lista_boletos[new_index].utilidad = this.lista_boletos[i_encontrado].utilidad;
                this.lista_boletos[new_index].comision = this.lista_boletos[i_encontrado].comision;
                this.lista_boletos[new_index].anulado = this.lista_boletos[i_encontrado].anulado;
                this.lista_boletos[new_index].pagado = this.lista_boletos[i_encontrado].pagado;
                this.lista_boletos[new_index].procesado = this.lista_boletos[i_encontrado].procesado;
            } else {
                toastr.info("No se encontraron tarifas de otro pasajero de tipo " + this.lista_pasajeros[new_index].tipo_pas);
                this.lista_boletos[new_index].nro_ticket = null;
                this.lista_boletos[new_index].neto = 0;
                this.lista_boletos[new_index].tarifa = 0;
                this.lista_boletos[new_index].pago_consolidador = 0;
                this.lista_boletos[new_index].tarifa_fee = 0;
                this.lista_boletos[new_index].utilidad = 0;
                this.lista_boletos[new_index].procesado = false;
                /* 
                this.lista_boletos[new_index].igv               = 0;
                this.lista_boletos[new_index].total             = 0;
                this.lista_boletos[new_index].comision          = 0;
                this.lista_boletos[new_index].anulado           = 0;
                this.lista_boletos[new_index].pagado            = 0;
                */
            }
        },
        modalProcesarCotizacion(persona, indice) {
            /* agrego valores inutiles solo visuales */
            $("#persona_azul").text(persona.nombre + " " + persona.apellido);
            $("#dni_azul").text(persona.cedula);
            /* seteo el indice sobre el cual trabajo */
            this.indice_adicionales = indice;
            /* seteo comision de agencia de viajes */
            this.lista_boletos[indice].comision = this.informacion_proveedor.comision;
            /* calculo el igv */
            let valor_igv = $("#valor_del_igv").val();
            if (this.informacion_proveedor.comision > 0) {
                this.lista_boletos[indice].igv = valor_igv;
            } else {
                this.lista_boletos[indice].igv = 0;
            }
            /* calculo el total */
            this.lista_boletos[indice].total = parseFloat(this.lista_boletos[indice].comision) + parseFloat(this.lista_boletos[indice].igv);
            this.set_default_value_depending_type_pas(indice);
            $("#modal-procesar-cotizaciones").fadeIn(300);
        },
        clear_data(persona, index) {
            persona.tipo_doc = 'dni';
            persona.cedula = '';
            persona.nombre = '';
            persona.apellido = '';
            persona.tipo_pas = 'adulto';
            persona.tipo = 'Directo';
            persona.id = 0;
            persona.telefono = null;
            persona.email = null;
            persona.direccion = null;
            persona.validate.dni_blocked = false;
            persona.validate.passenger_type_blocked = false;

            this.lista_boletos[index].nro_ticket = null;
            this.lista_boletos[index].neto = 0;
            this.lista_boletos[index].tarifa = 0;
            this.lista_boletos[index].igv = 0;
            this.lista_boletos[index].total = 0;
            this.lista_boletos[index].pago_consolidador = 0;
            this.lista_boletos[index].tarifa_fee = 0;
            this.lista_boletos[index].utilidad = 0;
            this.lista_boletos[index].comision = 0;
            this.lista_boletos[index].anulado = 0;
            this.lista_boletos[index].pagado = 0;
            this.lista_boletos[index].procesado = false;

            $("#datos_procesar_" + index).attr("disabled", true);
            $("#datos_adicionales_" + index).attr("disabled", true);
            $("#clear_data_" + index).attr("disabled", true);
        },
        calcularMontos() {
            if (this.lista_boletos[this.indice_adicionales].neto >= 0) {
                this.lista_boletos[this.indice_adicionales].comision = (this.informacion_proveedor.comision * this.lista_boletos[this.indice_adicionales].neto) / 100;
                this.lista_boletos[this.indice_adicionales].igv = (parseFloat(this.lista_boletos[this.indice_adicionales].comision) * parseFloat($("#valor_del_igv").val())) / 100;
                this.lista_boletos[this.indice_adicionales].total = (this.lista_boletos[this.indice_adicionales].comision + this.lista_boletos[this.indice_adicionales].igv);
                this.lista_boletos[this.indice_adicionales].igv = Math.round(this.lista_boletos[this.indice_adicionales].igv * 100) / 100;
                this.lista_boletos[this.indice_adicionales].total = Math.round(this.lista_boletos[this.indice_adicionales].total * 100) / 100;
            }
            if (this.lista_boletos[this.indice_adicionales].tarifa >= 0) {
                this.lista_boletos[this.indice_adicionales].pago_consolidador = parseFloat(this.lista_boletos[this.indice_adicionales].tarifa) - this.lista_boletos[this.indice_adicionales].total;
                this.lista_boletos[this.indice_adicionales].pago_consolidador = Math.round(this.lista_boletos[this.indice_adicionales].pago_consolidador * 100) / 100
            }
            if (this.lista_boletos[this.indice_adicionales].tarifa_fee >= 0) {
                this.lista_boletos[this.indice_adicionales].utilidad = parseFloat(this.lista_boletos[this.indice_adicionales].tarifa_fee) - this.lista_boletos[this.indice_adicionales].pago_consolidador;
                this.lista_boletos[this.indice_adicionales].utilidad = Math.round(this.lista_boletos[this.indice_adicionales].utilidad * 100) / 100
            }
        },
        /* tarifaFee() {

        }, */
        procesarBoleto() {
            for (atributo in this.lista_boletos[this.indice_adicionales]) {
                if (atributo == "nro_ticket") {
                    if (this.lista_boletos[this.indice_adicionales][atributo] == null ||
                        this.lista_boletos[this.indice_adicionales][atributo] == "" ||
                        this.lista_boletos[this.indice_adicionales][atributo] < 0) {
                        toastr.warning("El campo " + atributo + " debe estar lleno");
                        return;
                    } else {
                        let into = false;
                        this.lista_boletos.forEach((bl, i) => {
                            if (i != this.indice_adicionales) {
                                if (bl.nro_ticket == this.lista_boletos[this.indice_adicionales].nro_ticket) {
                                    into = true;
                                }
                            }
                        });
                        if (!into) {
                            axios.get(APP_URL + "/validar/numero/ticket/" + this.lista_boletos[this.indice_adicionales].nro_ticket).then(response => {
                                if (response.data.length > 0) {
                                    toastr.error("El numero de ticket ya existe");
                                    this.lista_boletos[this.indice_adicionales].procesado = false;
                                    return;
                                } else {
                                    toastr.success("Boleto Procesado");
                                    this.cerrarModal();
                                    this.lista_boletos[this.indice_adicionales].procesado = true;
                                    this.lista_pasajeros[this.indice_adicionales].validate.passenger_type_blocked = true;
                                    $("#datos_procesar_" + this.indice_adicionales).attr("disabled", true);
                                }
                            })
                        } else {
                            toastr.error("El numero de ticket ya existe");
                            this.lista_boletos[this.indice_adicionales].procesado = false;
                            return;
                        }
                    }
                }
            }
            let total = 0;
            this.lista_boletos.forEach(boleto => {
                total += parseFloat(boleto.tarifa_fee);
            });
            this.datos_pago.total_pagar = total;
        },
        calcularTotal() {
            if (this.datos_pago.monto_cancelar > 0) {
                let total = this.datos_pago.total_pagar - this.datos_pago.monto_cancelar;
                if (total < 0) {
                    toastr.info("El monto a pagar no puede ser mayor que el monto total");
                    this.datos_pago.monto_cancelar = this.datos_pago.total_pagar;
                    this.datos_pago.restante = 0;
                    return;
                } else {
                    this.datos_pago.restante = total;
                }
            } else {
                toastr.warning("El monto debe ser mayor a 0");
            }
        },
        pagarTodo() {
            this.datos_pago.restante = 0;
            this.datos_pago.monto_cancelar = this.datos_pago.total_pagar;
        },
        cambiarTipoPago() {
            switch (this.datos_pago.tipo) {
                case "1":
                    /* desactivo botone */
                    this.datos_pago.disable_dias_para_pagar = true;
                    this.datos_pago.disable_datos_banco = true;
                    this.datos_pago.disable_monto = false;
                    /* seteo valores */
                    this.datos_pago.banco_emisor = null;
                    this.datos_pago.banco_receptor = null;
                    this.datos_pago.nro_operacion = "";
                    this.datos_pago.dias_para_pagar = 0;
                    break;
                case "7":
                    /* desactivo botone */
                    this.datos_pago.disable_dias_para_pagar = false;
                    this.datos_pago.disable_datos_banco = true;
                    this.datos_pago.disable_monto = true;
                    /* seteo valores */
                    this.datos_pago.banco_emisor = null;
                    this.datos_pago.banco_receptor = null;
                    this.datos_pago.nro_operacion = "";
                    this.datos_pago.dias_para_pagar = 0;
                    this.datos_pago.monto_cancelar = 0;
                    this.datos_pago.restante = this.total_pagar;
                    break;
                case "8":
                    this.datos_pago.disable_dias_para_pagar = false;
                    this.datos_pago.disable_datos_banco = true;
                    this.datos_pago.disable_monto = false;
                    /* seteo valores */
                    this.datos_pago.banco_emisor = null;
                    this.datos_pago.banco_receptor = null;
                    this.datos_pago.nro_operacion = "";
                    break;
                default:
                    this.datos_pago.disable_dias_para_pagar = true;
                    this.datos_pago.disable_datos_banco = false;
                    this.datos_pago.disable_monto = false;
                    break;
            }
        },
        finalizarProcesar() {
            let faltantes = false;
            /* verificar datos */
            if (this.informacion_proveedor.consolidador == null || this.informacion_proveedor.consolidador == "") {
                faltantes = true;
                toastr.warning("Seleccione un consolidador");
            }
            if (this.informacion_proveedor.aerolinea == null || this.informacion_proveedor.aerolinea == "") {
                faltantes = true;
                toastr.warning("Seleccione un aerolinea");
            }
            if (this.informacion_proveedor.comision == null || this.informacion_proveedor.comision == "") {
                faltantes = true;
                toastr.warning("Coloque una comision");
            }
            if (this.informacion_proveedor.codigo == null || this.informacion_proveedor.codigo == "") {
                faltantes = true;
                toastr.warning("Coloque un codigo");
            }
            this.lista_pasajeros.forEach((pasajero, index) => {
                if (pasajero.tipo_doc == null || pasajero.tipo_doc == "") {
                    faltantes = true;
                    toastr.warning("Seleccione un tipo de documento en el pasajero " + (index + 1));
                }
                if (pasajero.cedula == null || pasajero.cedula == "") {
                    faltantes = true;
                    toastr.warning("El campo dni / ruc / pasaporte esta vacio en el pasajero " + (index + 1));
                }
                if (pasajero.nombre == null || pasajero.nombre == "") {
                    faltantes = true;
                    toastr.warning("El campo nombre esta vacio en el pasajero " + (index + 1));
                }
                if (pasajero.apellido == null || pasajero.apellido == "") {
                    faltantes = true;
                    toastr.warning("El campo apellido esta vacio en el pasajero " + (index + 1));
                }
                if (pasajero.tipo_doc == null || pasajero.tipo_doc == "") {
                    faltantes = true;
                    toastr.warning("Seleccione un tipo de pasajero en el pasajero " + (index + 1));
                }
                if (pasajero.tipo == null || pasajero.tipo == "") {
                    faltantes = true;
                    toastr.warning("Seleccione un tipo de cliente en el pasajero " + (index + 1));
                }
            });
            this.lista_boletos.forEach(boleto => {
                if (!boleto.procesado) {
                    faltantes = true;
                    toastr.warning("Todavia faltan boletos por procesar");
                }
            });
            if (this.datos_pago.tipo == null || this.datos_pago.tipo == "") {
                faltantes = true;
                toastr.warning("Seleccione un tipo de pago");
            } else {
                switch (this.datos_pago.tipo) {
                    case "1":
                        if (this.datos_pago.monto_cancelar == null || this.datos_pago.monto_cancelar == 0 || this.datos_pago.monto_cancelar == "") {
                            faltantes = true;
                            toastr.warning("El monto no es valido")
                        }
                        break;
                    case "7":
                        if (this.datos_pago.dias_para_pagar == null || this.datos_pago.dias_para_pagar == 0 || this.datos_pago.dias_para_pagar == "") {
                            faltantes = true;
                            toastr.warning("la cantidad de dias no es valida")
                        }
                        break;
                    case "8":
                        if (this.datos_pago.monto_cancelar == null || this.datos_pago.monto_cancelar == 0 || this.datos_pago.monto_cancelar == "") {
                            faltantes = true;
                            toastr.warning("El monto no es valido")
                        }
                        if (this.datos_pago.dias_para_pagar == null || this.datos_pago.dias_para_pagar == 0 || this.datos_pago.dias_para_pagar == "") {
                            faltantes = true;
                            toastr.warning("la cantidad de dias no es valida")
                        }
                        break;

                    default:
                        if (this.datos_pago.monto_cancelar == null || this.datos_pago.monto_cancelar == "") {
                            faltantes = true;
                            toastr.warning("El monto no es valido")
                        }
                        if (this.datos_pago.banco_emisor == null || this.datos_pago.banco_emisor == "") {
                            faltantes = true;
                            toastr.warning("Seleccione un banco emisor");
                        }
                        if (this.datos_pago.banco_receptor == null || this.datos_pago.banco_receptor == "") {
                            faltantes = true;
                            toastr.warning("Seleccione un banco receptor");
                        }
                        if (this.datos_pago.nro_operacion == null || this.datos_pago.nro_operacion == "") {
                            faltantes = true;
                            toastr.warning("Coloque un numero de operacion");
                        }
                        break;
                }
            }
            if (!faltantes) {
                swal({
                    title: "Espere un momento!",
                    text: "se esta procesando la cotizacion",
                    icon: APP_URL + "/imagenes/loader.gif",
                    button: {
                        text: "Entiendo",
                        value: false,
                        closeModal: false,
                    },
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    dangerMode: true,
                });
                axios.post(APP_URL + "/tablero/cotizaciones/admin/getcliente", {
                    cotizacion: this.cotizacion_id,
                    pasajeros: this.lista_pasajeros,
                    boletos: this.lista_boletos,
                    forma_pago: this.datos_pago,
                    proveedor: this.informacion_proveedor,
                }).then(response => {
                    swal({
                        title: "exito!",
                        text: "cotizacion procesada correctamente.",
                        icon: "success",
                        button: {
                            text: "Ok",
                            value: false,
                            closeModal: false,
                        },
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        dangerMode: true,
                    });
                    window.location.href = APP_URL + "/tablero/cotizaciones/admin";
                    console.log(response.data);
                }).catch(errors => {
                    console.log(errors.response);
                });
            }
        },
        cerrarModal() {
            $(".modal").fadeOut(300);
        },
    }
})