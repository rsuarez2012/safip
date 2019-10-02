var protocol = $(location).attr('protocol');
var url = $(location).attr('host');
var full_url = protocol + '//' + url;

var destinos = [];  
var destino_id;
var url; 
var i = 0;
 $(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#nombre').on('click', function(){
    var cod = $("#codigo").val();
    if($("#codigo").val() == ""){
      toastr.warning("Debe colocar un codigo");
      $("#codigo").focus();
    }else{
      $.ajax({
        type:'GET',
        //url: '/validate/code/'+cod,
        url: '/safip/public/validate/code/'+cod,
        success:function(data){
          if (data > 0) {
            toastr.info("El codigo esta repetido.");
            $("#codigo").val('').focus();
            //$("#codigo").focus();
          } else {
            toastr.success("Codigo " + cod + " Valido");
              //this.package.validated = true;
          }
          //toastr.success('Dato actualizado con exito!.');
        },
        error:function(data){
          console.log('Error:',data);
        }
      });
    }
  });

  $("#file").change(function () {
    filePreview(this);
  });
  
  function filePreview(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        //$('#uploadForm + img').remove();
        $('#preview').after('<img src="'+e.target.result+'" width="450" height="200"/>');
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  function validaForm(){
        // Campos de texto
    if($("#codigo").val() == ""){
      toastr.warning("Debe colocar un codigo");
      //alert("El campo Nombre no puede estar vacío.");
      $("#codigo").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
      return false;
    }
    return true;    

  }














  
 });