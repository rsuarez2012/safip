
    <div class="col-sm-6">
        <div class="form-group">
            <label>Codigo Paquete</label>
            {{--<input :disabled="package.validated" class="form-control" v-model="package.code" type="text" placeholder="Codigo" id="codigo">--}}
            <input class="form-control" type="text" autocomplete="off" placeholder="Codigo" id="codigo" name="code" value="{{ old('code', $paquete->codigo)}}">
        </div>
        <div class="form-group">
            <label>Nombre Paquete</label>
            <input class="form-control" type="text" autocomplete="off" placeholder="Nombre" id="nombre" name="name" value="{{ old('name', $paquete->nombre) }}">
        </div>

        <div class="form-group">        
            <label>Categoria Paquete</label>
            <select name="category" id="category" class="form-control">
                @foreach($categorias as $categoria)
                <option value="{{$categoria->id}}" {{ $categoria->id == $paquete->categoria_id ? "selected" : "" }}>{{$categoria->nombre}}</option>    
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Zona</label>
            <select class="form-control" name="zone" id="zona">
                <option value="costa" {{ $paquete->zona == 'costa' ? 'selected' : '' }}>Costa</option>
                <option value="sierra" {{ $paquete->zona == 'sierra' ? 'selected' : '' }}>Sierra</option>
                <option value="selva" {{ $paquete->zona == 'selva' ? 'selected' : '' }}>Selva</option>    
            </select>
        </div>
    
        <div class="form-group">
            <label>Imagen Paquete</label>
            <input class="form-control" @change="processFile($event)" type="file" accept="image/*" id="file" name="img">
            <span class="help-block">Las medidas del banner deben ser 700px por 263px</span>
        </div>

        <div class="clearfix"></div>

        <br>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
        
                <center>
                <label>Imagen del paquete</label>
                
                <div id="preview">
                
                </div>
                    {{--<img  :src="route+'/storage/original/'+package.image" alt="Este dia no tiene una imagen">--}}
                    <img src="{{asset('storage/original/'.$paquete->imagen)}}" alt="" width="450" height="200">
                    {{--<img :src="route+'/storage/original/'+package.image" class="img-responsive" width="200px" height="200px" v-if="package.edit">
                    <img :src="'/web/images/paquetes/'+package.image" class="img-responsive" width="720px" height="80px" v-if="package.edit">--}}
                </center>
        </div>
                
                <!--<div class="col-sm-6 form-group hidden">
                    <label>Descripcion Corta</label>
                    <input class="form-control " v-model="package.extrac" type="text" placeholder="extracto">
                </div>
                <div class="col-sm-6 form-group  hidden">
                    <label>Descripcion Larga</label>
                    <textarea class="form-control" v-model="package.description" placeholder="description"></textarea>
                </div>-->
            
                        
    </div>
    <div class="clearfix"></div>

    

@section('script')
<script type="text/javascript">
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

    $("#destinos-table").DataTable();

    var enlazado_id = null;
    $('.eliminarDestino').on('click', function(){

      enlazado_id = $(this).data('enlazado');
    
      swal({
        title: "Atención!.",
        text: "¿Está seguro de que desea eliminar este hotel?'",
        icon: "warning",
        buttons: {
          cancel: 'No',
          confirm: 'Si'
        },
        dangerMode: true
      }).then(isConfirm => {
        if(isConfirm) {
          
          var url = full_url + '/safip/public/Paso/2/Paquete/DestroyEnlace';
          
          $.ajax({
            url: url,
            type: 'POST',
            data: { enlazado_id: enlazado_id },
          })
          .done(function(response){ //                        
              toastr.success('Hotel eliminado con exito!');
              var table = $('#destinos-table').DataTable().draw();
          
          });
        }
      })
    
      });


    /*Start nuevo*/
    $('#destino').multiSelect({
      selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar hotel...'>",
      selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar hotel...'>",
      afterInit: function(ms){
        var that = this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
        .on('keydown', function(e){
          if (e.which === 40){
            that.$selectableUl.focus();
            return false;
          }
        });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
        .on('keydown', function(e){
          if (e.which == 40){
            that.$selectionUl.focus();
            return false;
          }
        });
      }, 
      afterSelect: function(value){
          destinos.push({ paquete_id: $('#paquete_id').val(), destino_id: value[0], noches: $('#noches').val() });
          $('#noches').val('0');
      },
      afterDeselect: function(value){
          destinos.splice(destinos.findIndex(item => item.destino_id === value[0]), 1)
      },
    });

    $('#destinos-hoteles').multiSelect({ 
          selectableOptgroup: true, 
          selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar hotel...'>",
          selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar hotel...'>",
          afterInit: function(ms){
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
            .on('keydown', function(e){
              if (e.which === 40){
                that.$selectableUl.focus();
                return false;
              }
            });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            .on('keydown', function(e){
              if (e.which == 40){
                that.$selectionUl.focus();
                return false;
              }
            });
          },
          afterSelect: function(value){
            /*validacion cantidad de noches*/
            if($('#noches').val()<1) {
              toastr.warning('Días de hospedaje debe ser mayor a cero!');
              $('#destinos-hoteles').multiSelect('deselect', [value[0]]); //deselecciona ultima opcion
            }
            else {
              var values = value[0].split("_");
              destinos.push({ paquete_id: $('#paquete_id').val(), destino_id: values[0], hotel_id: values[1], noches: $('#noches').val(), value: value });
              $('#noches').val('0');
            }
            
          },
          afterDeselect: function(value){
            destinos.splice(destinos.findIndex(item => item.value === value[0]), 1)
          }

      });
    
    $('#opcion').change(function(){
        var val = $(this).val();
        if(val == 'si'){
          $('.selector').hide();
          $('.selector-hoteles').show();
          toastr.info('Hoteles seleccionados!');
          
          
          $('#btn-step2').css('display', 'none');
          $('#btn-step2-hoteles').css('display', 'block');
        }else{
          $('.selector-hoteles').hide(); 
          $('.selector').show();
          toastr.info('Hoteles desactivados!');
          $('#btn-step2').css('display', 'block');
          $('#btn-step2-hoteles').css('display', 'none');
        }
    });

     /*End Nuevo*/
     $(".chosen-select").chosen(
     {
        allow_single_deselect: true, 
        disable_search: true
    });


    $('#btn-step2').on('click', function(e){
      e.preventDefault();
      var frm = $('#destino-form');
      $.ajax({
          url: frm[0].action,
          type: frm[0].method,
          dataType: 'json',
          data: { destinos: destinos },
        })
        .done(function(response){ //

          if(response == 1) {                        
            toastr.success('Datos almacenados con exito!');
            $('#a_tab3').trigger('click'); //se activa siguiente tab #3
          }
        }); 
    });


    $('#btn-step2-hoteles').on('click', function(e){
      e.preventDefault();
      var frm = $('#destino-form');
      $.ajax({
          url: full_url + '/safip/public/Paso/2/Enlazar/Hoteles/Paquete/'+destinos[0]['paquete_id'],
          type: frm[0].method,
          dataType: 'json',
          data: { destinos: destinos },
        })
        .done(function(response){ //
          
          if(response != '') {                        
            toastr.success('Datos almacenados con exito!');
            $('#a_tab3').trigger('click'); //se activa siguiente tab #3
          }
        }); 
    });

    
    //evaluar la categoria
      $('#categoria').change(function(){
        var id = $(this).val();
        //alert(id);
        if(id === '6'){
          $('#zona').prop('disabled', true);
        
        }else{
          $('#zona').prop('disabled', false);
        }

      })
      $('.add').on('click', function(){
         var paquete = $('#paquete_id').val();
         var tipo = $(this).attr('data-id');
         //alert(tipo);
         if(tipo == 'incluido'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);
            $('#enviar').click(function(event){
               var formID = '#addF';
               var table = $('.table').val({ajax: "/tablero/Admin/Paso/4/Agregar/Dato/"+paquete});
               $.ajax({
                  //url: $(formID).attr('action'),
                  method: $(formID).attr('method'),
                  data: $(formID).serialize(),
                  dataType: 'html',
                  success:function(data){
                     /*$('#table tbody').append('<tr class="inclu{{--$dato->id}}"><td style="border-top:0;"><input type="text" class="form-control" value="{{$dato->texto}}" id="{{$dato->id}}"></td><td class="pull-right" style="margin-top:6px;border-top:0;"><button class="btn btn-warning btn-xs ed" data-id="{{$dato->id}}"><i class="fa fa-edit"></i> Editar</button><button class="btn btn-danger btn-xs dele-in" data-id="{{$dato->id--}}"><i class="fa fa-trash"></i> Eliminar</button></td></tr>');*/
                     //$('#table tbody').append(data);
                     $('#table tbody').load(data);
                     toastr.success('Dato registrado con exito!.');
                  },
                  error:function(data){
                     console.log('Error:',data);
                  }
                  /*success: function(result){
                     if ($(formID).find("input:first-child").attr('value') == 'PUT') {
                        var $jsonObject = jQuery.parseJSON(result);
                        $(location).attr('href',$jsonObject.re);
                     }
                     else{
                        $(formID)[0].reset();
                        console.log('Ok');
                     }
                  },
                  error: function(){
                     console.log('Error');
                  }*/
               });

            })

         } else if(tipo == 'noincluido'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'llevar'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'politcareserva'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'importante'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'politicatarifa'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'fechas'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'responsabilidades'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else {
         }
      });
      $('.dele-in').on('click', function () {
         var id = $(this).attr('data-id');
         confirm("Seguro de eliminar?");
         $.ajax({
            type:'DELETE',
            data: {
               //id: id,
               _token: $('#signup-token').val()
            },
            url:'/tablero/Admin/Paso/4/Eliminar/Dato/'+id,
            success: function(data){
               toastr.success('Dato Eliminado con exito!.');
               $('.inclu'+id).remove();
            },
            error:function(data){
               console.log('Error:',data);
            }
         });
      });
      $('.ed').on('click', function () {
         //textO
         var id = $(this).attr('data-id');
         var texto = $('#'+id).val();
         //alert(texto);
         if(texto ===""){
            toastr.success('Por favor ingrese el dato!.');
         }else{
            $.ajax({
               type:'POST',
               data: {
                  id: id,
                  _token: $('#signup-token').val(),
                  texto: texto,
               },
               url: '/tablero/Admin/Paso/4/Editar/Dato/'+id,
               success:function(data){
                  
                  toastr.success('Dato actualizado con exito!.');
               },
               error:function(data){
                  console.log('Error:',data);
               }
            });

         }


        
      })
    $('#nombre').on('click', function(){
        var cod = $("#codigo").val();
        console.log(cod);
        if($("#codigo").val() == ""){
            toastr.warning("Debe colocar un codigo");
            $("#codigo").focus();
        }else{

            //toastr.success("exacto");
            $.ajax({
               type:'GET',
               url: full_url + '/safip/public/validate/code/' + cod,
               success:function(data){
                    console.log(data);
                    if (data > 0) {
                        toastr.info("El codigo esta repetido.");
                    } else {
                        toastr.success("Codigo " + cod + " Valido");
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

</script>
@endsection