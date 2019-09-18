const main_otro = new Vue({
    el: '#main_otro',
    created() {
       this.loadPasajeros();
       this.datos_venta.cotizacion_id=$("#cotizacion_id").val();
   },
   data: {
    route: APP_URL,
    ver_pasajeros:false,
    ver_boletos:false,
    indice_venta_directa:0,
    // datos vetna
    datos_venta:{
        comision:0,
        tipo_venta:"ninguna",
        agencia_viaje:null,
        cotizacion_id:null,
    },
    pasajeros:[],
    boletos:[],
    /* datos pago */
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
    setProveedor(){
        let proveedor = $("#select-proveedores").val();
        if (proveedor == null || proveedor == "") {
            toastr.warning("Selecione un Proveedor");
            return;
        }   
        let url_comision = this.route + "/tablero/paquete/otro-proveedor/comision/"+proveedor;
        axios.get(url_comision).then(response=>{
            if(response.data == 0 || response.data == null || response.data == ''){
                toastr.info('No se encontro comisión', 'Disculpe!')
            } else {
                toastr.success('Comisión encontrada', 'Bien!')
            }
            this.datos_venta.comision = response.data;
            this.datos_venta.agencia_viaje = proveedor;
        }).catch(errors =>{
            console.log(errors);
        });
    },
    loadPasajeros(){
        this.pasajeros = [];
        this.boletos = [];
        let cantidad = $("#cantidad_pasajeros").val();
        for (var i = 0; i < cantidad; i++) {
            this.pasajeros.push({
                id:0,
                tipo_documento:'dni',
                dni:null,
                nombres:null,
                apellidos:null,
                pasajero:'adulto',
                tipo:'Directo',
                procesado:false,
                // disabled
                block_input:true,
                block_button:true,
                block_dni:false,
                block_procesar:true
            });
            this.boletos.push({
                procesado:false,
                neto:null,
                pago_mayorista: null,
                incentivo:null,
                comision:null,
                utilidad:null,
                tarifa_fee:null
            });
        }
    },
    verPasajeros(tipo){
        if (this.datos_venta.tipo_venta == null || this.datos_venta.tipo_venta == "") {
            this.ver_pasajeros = false;
        }else{
            this.loadPasajeros();
            this.ver_pasajeros = true;
        }
    },
    buscarPasajero(indice) {
        if (this.pasajeros[indice].dni == "" || this.pasajeros[indice].dni == null) {
            toastr.warning("Debe llenar el campo de documento para poder buscarlo.");
            return;
        }
        let into = false;
        this.pasajeros.forEach((ps, i) => {
            if (i != indice) {
                if (ps.dni == this.pasajeros[indice].dni) {
                    into = true;
                }
            }
        });
        if (!into) {
            toastr.info("Buscando Pasajero");
            axios.get(APP_URL + "/buscar/cedula/procesar/cotizacion/" + this.pasajeros[indice].dni).then(response => {
                if (response.data) {
                    toastr.success("Pasajero Registrado.");
                    this.pasajeros[indice].tipo_documento = response.data.tipo_documento;
                    this.pasajeros[indice].dni = response.data.cedula_rif;
                    this.pasajeros[indice].nombres = response.data.nombre;
                    this.pasajeros[indice].apellidos = response.data.apellido;
                    this.pasajeros[indice].id = response.data.id;
                    this.pasajeros[indice].tipo = response.data.tipo_pasajero;
                    this.pasajeros[indice].telefono = response.data.telefono;
                    this.pasajeros[indice].email = response.data.email;
                    this.pasajeros[indice].direccion = response.data.direccion;
                    this.pasajeros[indice].block_input = true;
                } else {
                    toastr.warning("Pasajero no Registrado.");
                    $("#datos_nombre_" + indice).attr("disabled", false);
                    $("#datos_apellido_" + indice).attr("disabled", false);
                    $("#datos_tipo_" + indice).attr("disabled", false);
                    this.pasajeros[indice].nombres = "";
                    this.pasajeros[indice].apellidos = "";
                    this.pasajeros[indice].id = 0;
                    this.pasajeros[indice].tipo = "";
                    this.pasajeros[indice].telefono = "";
                    this.pasajeros[indice].email = "";
                    this.pasajeros[indice].direccion = "";
                    this.pasajeros[indice].block_input=false
                }
                this.pasajeros[indice].block_button = false;
                this.pasajeros[indice].block_procesar = false;
                this.pasajeros[indice].block_dni = true;
            }).catch(erros => {
                console.log(erros.data);
            });
        } else {
            toastr.error("El DNI, RUC ó pasaporte ya se encuentra registrado!.");
            //this.pasajeros[indice].cedula = "";
            return;
        }
    },
    /* levantar modal */
    modalProcesar(indice){
        $("#modal-ventadirecta").fadeIn(300);
        $("#nombre-pasajero").text(this.pasajeros[indice].nombres + " " + this.pasajeros[indice].apellidos);
        /* if (this.datos_venta.tipo_venta == 'directa') { */
            this.indice_venta_directa = indice;
            this.limpiarBoleto(indice);
        /* } else {

        } */
    },
    cerrarModal(){
        $(".modal").fadeOut(300);
    },
    // limpiar datos modal
    limpiarDatos(indice) {
        this.pasajeros[indice].tipo_documento = 'dni';
        this.pasajeros[indice].dni = '';
        this.pasajeros[indice].nombres = '';
        this.pasajeros[indice].apellidos = '';
        this.pasajeros[indice].pasajero = 'adulto';
        this.pasajeros[indice].tipo = 'Directo';
        this.pasajeros[indice].id = 0;
        this.pasajeros[indice].telefono = null;
        this.pasajeros[indice].email = null;
        this.pasajeros[indice].direccion = null;
        this.pasajeros[indice].block_button = true;
        this.pasajeros[indice].block_dni = false;
        this.pasajeros[indice].block_input = true;
        this.pasajeros[indice].block_procesar = true;
        
        this.boletos[indice].procesado = false;
        this.ver_boletos = false;
        this.boletos.forEach(boleto => {
            if (boleto.procesado) {
                this.ver_boletos = true;
            }
        });
    },
    limpiarBoleto(indice){
        this.boletos[indice].neto = 0;
        this.boletos[indice].pago_mayorista = 0;
        this.boletos[indice].incentivo = 0;
        this.boletos[indice].comision = 0;
        this.boletos[indice].tarifa_fee = 0;
        this.boletos[indice].utilidad = 0;
    },
    // calculos
    calcularVentaDirecta(){
        if (this.boletos[this.indice_venta_directa].neto != 0 && this.boletos[this.indice_venta_directa].neto != "" && this.boletos[this.indice_venta_directa].neto != null && this.datos_venta.comision != "" && this.datos_venta.comision != null) {

            this.boletos[this.indice_venta_directa].comision =  Math.round(this.boletos[this.indice_venta_directa].neto * this.datos_venta.comision) / 100;
            
            this.boletos[this.indice_venta_directa].pago_mayorista = Math.round(this.boletos[this.indice_venta_directa].neto - this.boletos[this.indice_venta_directa].comision - this.boletos[this.indice_venta_directa].incentivo);

            this.boletos[this.indice_venta_directa].utilidad = Math.round(parseFloat(this.boletos[this.indice_venta_directa].tarifa_fee) - parseFloat(this.boletos[this.indice_venta_directa].pago_mayorista) ); 
            /*if (this.boletos[this.indice_venta_directa].incentivo != 0 && this.boletos[this.indice_venta_directa].incentivo != "" && this.boletos[this.indice_venta_directa].incentivo != null) {
                this.boletos[this.indice_venta_directa].utilidad +=  Math.round(parseFloat(this.boletos[this.indice_venta_directa].incentivo) );
            }*/
            //console.log(this.boletos[this.indice_venta_directa].pago_mayorista)
        }
        
    },
    /* procesar boleto */
    procesarBoletoDirecto(){
        /* valido campos */
        if (this.boletos[this.indice_venta_directa].neto == "" || this.boletos[this.indice_venta_directa].neto < 0 || this.boletos[this.indice_venta_directa].neto == null ) {
            return toastr.warning("El neto no puede estar vacio.");
        }
        if (this.boletos[this.indice_venta_directa].incentivo == "" || this.boletos[this.indice_venta_directa].incentivo < 0 || this.boletos[this.indice_venta_directa].incentivo == null ) {
            return toastr.warning("El incentivo no puede estar vacio");
        }
        if (this.boletos[this.indice_venta_directa].tarifa_fee == "" || this.boletos[this.indice_venta_directa].tarifa_fee < 0 || this.boletos[this.indice_venta_directa].tarifa_fee == null ) {
            return toastr.warning("La tarifa fee no puede estar vacia.");
        }
        this.ver_boletos = true;
        this.pasajeros[this.indice_venta_directa].neto = "";
        this.pasajeros[this.indice_venta_directa].block_procesar = true;
        this.boletos[this.indice_venta_directa].procesado = true;
        this.montoPagar();
        this.cerrarModal();
    },
    /* cambiar tipo pago */
    montoPagar(){
        let total = 0;
        this.boletos.forEach(boleto => {
            if (boleto.tarifa_fee > 0 && boleto.tarifa_fee != "" && boleto.tarifa_fee != "") {
                total += parseFloat(boleto.tarifa_fee);
            }
        });
        this.datos_pago.total_pagar =  total;
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
        if (this.datos_venta.agencia_viaje == null || this.datos_venta.agencia_viaje == "") {
            faltantes = true;
            toastr.warning("Seleccione un proveedor");
        }
        if (this.datos_venta.comision == null || this.datos_venta.comision == "") {
            faltantes = true;
            toastr.warning("Coloque una comision");
        }
        this.pasajeros.forEach((pasajero, index) => {
            if (pasajero.tipo_documento == null || pasajero.tipo_documento == "") {
                faltantes = true;
                toastr.warning("Seleccione un tipo de documento en el pasajero " + (index + 1));
            }
            if (pasajero.dni == null || pasajero.dni == "") {
                faltantes = true;
                toastr.warning("El campo dni / ruc / pasaporte esta vacio en el pasajero " + (index + 1));
            }
            if (pasajero.nombres == null || pasajero.nombres == "") {
                faltantes = true;
                toastr.warning("El campo nombre esta vacio en el pasajero " + (index + 1));
            }
            if (pasajero.apellidos == null || pasajero.apellidos == "") {
                faltantes = true;
                toastr.warning("El campo apellido esta vacio en el pasajero " + (index + 1));
            }
            if (pasajero.pasajero == null || pasajero.pasajero == "") {
                faltantes = true;
                toastr.warning("Seleccione un tipo de pasajero en el pasajero " + (index + 1));
            }
            if (pasajero.tipo == null || pasajero.tipo == "") {
                faltantes = true;
                toastr.warning("Seleccione un tipo de cliente en el pasajero " + (index + 1));
            }
        });
        this.boletos.forEach(boleto => {
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
            let url_procesar = this.route + "/tablero/paquete/otro-proveedor/procesar";
            axios.post(url_procesar,{
                datos_pago:this.datos_pago,
                boletos:this.boletos,
                pasajeros:this.pasajeros,
                datos_venta:this.datos_venta
            }).then(response =>{
                window.location.href = APP_URL + "/tablero/boletos/paquetes/index";
            }).catch(errors => {
                console.log(errors)
                console.log(errors.response);
                document.write(errors.response.data)
                if(errors.status == 500){
                    toastr.info('Ha ocurrido un error durante el guardado, por favor intente nuevamente.', 'Disculpe!');
                }
            });
        }
    },
}
})