function estado(estado,agencia_id){
	swal({
		title: "Confirmar",
		text: "Esta seguro de que desea colocar esta agencia como " + estado,
		icon: "info",
		buttons: ['cancelar','si'],
	})
	.then((tipo) => {
		if (tipo) {
			window.location.href=APP_URL+"/agencias/viajes/"+agencia_id+"/cambiar/estado/"+estado;
		}
	});
}