/* function cambiarEstado(agencia, status) {
    $("#cargando").show();
    $("#modalCrear").fadeOut(300);
    if (status == "delete") {
        axios.delete(APP_URL + '/solicitudes/agencias/' + agencia)
            .then((respuesta) => {
                $("#" + agencia).remove();
                $("#cargando").hide();
            });
    } else {
        let msg = $("input[name='message']").val();
        axios.put(APP_URL + '/solicitudes/agencias/' + agencia, { nuevoEstado: status, message: msg })
            .then((respuesta) => {
                console.log(respuesta);
                $("#cargando").hide();
                if (status == "approved") {
                    $("#" + agencia).children(".status-actual").html("<label class='label bg-green'>Aprovado</label>");
                    $("#" + agencia).children(".status-botones").text("");
                    $("#" + agencia).children(".status-botones").html(
                        "<button title='Eliminar' onclick='abrirModal(" + agencia + ",\"delete\")' class='btn-xs btn btn-danger'><i class='fa fa-close'></i></button> " +
                        "<button onclick='abrirModal(" + agencia + ",\"rejected\")' class='btn btn-danger btn-xs' title='Rechazar'><i class='glyphicon glyphicon-ban-circle'></i></button>");
                } else if (status == "rejected") {
                    $("#" + agencia).children(".status-actual").html("<label style='background-color: #dd4b39;color: #fff' class='label'>Rechazado</label>    ");
                    $("#" + agencia).children(".status-botones").text("");
                    $("#" + agencia).children(".status-botones").html(
                        "<button title='Eliminar' onclick='abrirModal(" + agencia + ",\"delete\")' class='btn-xs btn btn-danger'><i class='fa fa-close'></i></button> " +
                        "<button title='Editar' class='btn-xs btn btn-warning'><i class='fa fa-pencil'></i></button>");
                }
            });
    }
} */
function abrirModal(agencia, status) {
    $("#modalCrear").fadeIn(300);
    $("#input_agencia").val(agencia);
    $("#input_status").val(status);
    if (status == "approved") {
        $("#accion-modal").text("Aprobar");
        $("#text-message").hide();
    } else if (status == "rejected") {
        $("#accion-modal").text("Rechazar");
        $("#text-message").show();
    } else if (status == "delete") {
        $("#accion-modal").text("Eliminar");
        $("#text-message").hide();
    }
}
function cerrarModal() {
    $("#modalCrear").fadeOut(300);
}
function eliminar(agencia) {
    alert(agencia);
}