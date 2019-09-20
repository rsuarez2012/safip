
    <div class="col-sm-6">
        <div class="form-group">
                {{$paquete->zona}}

            <label>Codigo Paquete</label>
            {{--<input :disabled="package.validated" class="form-control" v-model="package.code" type="text" placeholder="Codigo" id="codigo">--}}
            <input class="form-control" type="text" placeholder="Codigo" id="codigo" name="code" value="{{ old('code', $paquete->codigo)}}">
        </div>
        <div class="form-group">
            <label>Nombre Paquete</label>
            <input class="form-control" type="text" placeholder="Nombre" id="nombre" name="name" value="{{ old('name', $paquete->nombre) }}">
        </div>

        <div class="form-group">        
            <label>Categoria Paquete</label>
            <select name="category" id="category" class="form-control">
                @foreach($categorias as $categoria)
                <option value="{{$categoria->id}}"
                  {{ old('category') == $categoria->id ? 'selected' : '' }}
                  >{{$categoria->nombre}}</option>    
                @endforeach
            </select>
            {{--<select cname="miselect[]" data-placeholder="Choose a Country..." class="chosen-select form-control" tabindex="2" multiple>
                @foreach($categorias as $categoria)
                <option>{{$categoria->nombre}}</option>
                @endforeach
                
            </select>--}}
            {{--<select @change="changeCategory()" class="form-control" v-model="package.category" id="categoria">
                <template v-for="option in categories">
                    <option :value="option.id">@{{option.nombre}}</option>    
                </template>    
            </select>--}}
        </div>
        <div class="form-group">
            <label>Zona</label>
            <select class="form-control" name="zone" id="zona">
                <option value="costa" {{ old('zone') == $paquete->zona ? 'selected' : '' }}>Costa</option>
                <option value="sierra" {{ old('zone') == $paquete->zona ? 'selected' : '' }}>Sierra</option>
                <option value="selva" {{ old('zone') == $paquete->zona ? 'selected' : '' }}>Selva</option>    
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
   $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
     $(".chosen-select").chosen(
     {
        allow_single_deselect: true, 
        disable_search: true
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
               /*data: {
                  id: id,
                  _token: $('#signup-token').val(),
                  texto: texto,
               },*/
               url: '/validate/code/'+cod,
               success:function(data){
                    console.log(data);
                    if (data > 0) {
                        toastr.info("El codigo esta repetido.");
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
   })

</script>
@endsection