
function abrirModal() {
    $("#modal-agencia").fadeIn(300);
}
function cerrarModal() {
    $("#modal-agencia").fadeOut(300);
}
function crearAgencia(event) {
    event.preventDefault();
    swal({
        title: "¿ Esta seguro de desea configurar esta agencia ?",
        text: "si configura esta agencia se registraran los datos y se le enviara un email al administrador para que lo valide",
        icon: "warning",
        buttons: ['cancelar', 'si, estoy seguro'],
        dangerMode: true,
    })
        .then((acepted) => {
            if (acepted) {
                swal({
                    title: "Espere un momento",
                    text: "Creando agencia y enviando email al administrador.",
                    icon: APP_URL + "/imagenes/loader.gif",
                    button: {
                        text: "Ok",
                        value: false,
                        closeModal: false,
                    },
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    dangerMode: true,
                });
                let valores = $("#form_crear_agencia_counter").serialize();
                axios.post(APP_URL + "/agencias/viajes/cretado/por/counter", valores).then(response => {
                    if (response.data == "existe") {
                        swal.close();
                        toastr.error("Esta Agencia ya se ecuentra registrada.");
                    } else {
                        $("#modal-agencia input").val("");
                        swal.close();
                        toastr.info("Agencia Configurada.");
                        $(".select-agencia-id").select2("destroy");
                        $(".select-agencia-id").append($('<option>', {
                            value: response.data.id,
                            text: response.data.nombre
                        }));
                        $(".select-agencia-id").select2();
                        cerrarModal();
                    }

                }).catch(errors => {
                    console.log(errors.response);
                });
            }
        });
}
function change_input() {
    let valor_radio = $(".input_change_check:checked").val();
    if (valor_radio == 0) {
        $("input[name='cllegada']").attr("required", false);
        $("input[name='cllegada']").attr("disabled", true);
        $("input[name='cllegada']").val(null);
    } else {
        $("input[name='cllegada']").attr("required", true);
        $("input[name='cllegada']").attr("disabled", false);
    }
}