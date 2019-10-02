var protocol = $(location).attr('protocol');
  var url = $(location).attr('host');
  var full_url = protocol + '//' + url;

  var destinos = [];  
  var destino_id;
  var hotel; //agregado
  var url; 
  var i = 0;
  $(document).ready(function(){
  	$.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    //var paquete = '{{  $paquete->id }}';
    
  alert("hola");
    //var rau = window.location.pathname;
    //console.log(rau);
    $('a #agregarDias]').on('click',function(){
      if($('#name').val() === ''){
        toastr.warning("Debe colocar un nombre en el dia ");

      }
    });
    function saveDay() {

    }
            /*if (this.edit) {
                let fail = false;
                this.list_days.forEach((day, index) => {
                    if (day.name == "" || day.name == null) {
                        toastr.warning("Debe colocar un nombre en el dia " + (index + 1));
                        fail = true;
                    }
                    if (day.description == "" || day.description == null) {
                        toastr.warning("Debe colocar una descripcion en el dia " + (index + 1));
                        fail = true;
                    }
                    var urlUpdateDay = this.route + "/updated/day/" + this.package.id;
                    this.loading();
                    //Creamos el formData
                    var data = new FormData();
                    //Añadimos la imagen seleccionada
                    console.log(data);
                    data.append('img', this.list_days[0].image);
                    data.append('name', this.list_days[0].name);
                    data.append('text', this.list_days[0].description);
                    data.append('day_id', this.list_days[0].id);
                    //Enviamos la petición

                    axios.post(urlUpdateDay, data).then(response => {
                        this.alert("Excelente!", "Dia Modificado Correctamente", "success");
                        this.closeModal();
                        console.log(response.data);
                        this.getPackage();
                    }).catch(error => {
                        console.log(error.response);
                        swal.close();
                    });

                });
                /* cancelo si falta algo */
                /*if (fail) {
                    return;
                }
            } else {
                /* valido dias llenos */
                /*let fail = false;
                this.list_days.forEach((day, index) => {
                    if (day.name == "" || day.name == null) {
                        toastr.warning("Debe colocar un nombre en el dia " + (index + 1));
                        fail = true;
                    }
                    if (day.description == "" || day.description == null) {
                        toastr.warning("Debe colocar una descripcion en el dia " + (index + 1));
                        fail = true;
                    }
                    if (day.image == null && day.libre == false) {
                        toastr.warning("Debe colocar una Imagen en el dia " + (index + 1));
                        fail = true;
                    }
                });
                /* cancelo si falta algo */
                /*if (fail) {
                    return;
                }*/
                /* creo varuable de url */
                /*var urlSaveDay = this.route + "/save/day/" + this.package.id;
                this.loading();
                //Creamos el formData
                var data = new FormData();

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                /* recorro dias para guardar*/
                /*this.list_days.forEach((day, index) => {
                    /* var data_day = [, day.description, day.libre, day.image] */
                  /*  data.append("days[" + index + "][name]", day.name);
                    data.append("days[" + index + "][description]", day.description);
                    data.append("days[" + index + "][libre]", day.libre);
                    data.append("img-" + index, this.list_days[index].image);


                    /* data.append('text[]', day.description);
                    data.append('libre[]', day.libre);
                    data.append('img[]', day.image); */
                //});
                //Enviamos la petición
                /*axios.post(urlSaveDay, data, config).then(response => {
                    this.alert("Exito !", "Solicitud procesada correctamente", "success");
                    this.getPackage();
                    this.list_days = [];
                    $("#dia").fadeOut(300);
                }).catch(error => {
                    swal.close();
                    console.log(error.response);
                });*/

            /*}
        },*/
        /*changeFreeDay(index) {
            if (this.list_days[index].libre) {
                this.list_days[index].name = "Dia Libre";
                this.list_days[index].description = "Dia Libre";
                this.list_days[index].image = null;
            } else {
                this.list_days[index].name = "";
                this.list_days[index].description = "";
                this.list_days[index].image = null;
            }
        },*/
  });