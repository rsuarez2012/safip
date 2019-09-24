@extends('layouts.master')
@section('titulo', 'Crear Paquete')

@section('css')
<!--<style>
    #map-canvas {
        width: 100%;
        height: 370px;
    }
    body > div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr > td.disabled{
        color: #aaa;
    }
    body > div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr > td.active{
        color:#fff;
        background-color: #d9534f;
    }
    th{
      text-align: center;
    }
</style>-->
@endsection
@section('content') 
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header">
                <h4><i class="fa fa-cube"></i>  Crear Paquete  </h4>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="tabs">
                        <li id="t1" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Perfil del paquete</a></li>
                        <li id="t2" class><a href="#tab_2" data-toggle="tab" aria-expanded="false" id="a_tab2">Destinos y Hoteles</a></li>
                        <li id="t3" class><a href="#tab_3" data-toggle="tab" aria-expanded="false" id="a_tab3">Dias y Actividades</a></li>
                        <li id="t4" class><a href="#tab_4" data-toggle="tab" aria-expanded="false" id="a_tab4">Precios</a></li>
                    </ul>
                    <div class="tab-content">
                        <!--datos del paquete-->
                        <div class="tab-pane active" id="tab_1">
                            <form action="{{ route('paquete.guardar') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('adminweb.paquetes.nuevo.partials.datos')
                                <button class="btn btn-danger pull-right" type="submit">Guardar</button>
                            </form>
                        </div>
                        <!--configuracion del paquete-->
                        <div class="tab-pane" id="tab_2">
                            @include('adminweb.paquetes.nuevo.partials.destinos')
                        </div>
                        <!--itinerario-->
                        <div class="tab-pane" id="tab_3">
                            @include('adminweb.paquetes.nuevo.partials.dia')
                        </div>
                        <!--adicionales--> 
                        <div class="tab-pane" id="tab_4">
                        </div>

                    </div>
                </div>
            </div>  
        </div>
    </div>
</div> 
@endsection
@section('script')
<!--<script type="text/javascript">
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
    /*Start nuevo*/
    $('#dest').select2();
    $('#add').on('click', function(){
        alert("agregar");
    });
    //$("#codigo").prop("disabled", true);
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
            var values = value[0].split("_");
            destinos.push({ paquete_id: $('#paquete_id').val(), destino_id: values[0], hotel_id: values[1], noches: $('#noches').val(), value: value });
            $('#noches').val('0');
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
          $('#destinos-hoteles').addClass("disabled");

          $('#btn-step2').css('display', 'none');
          $('#btn-step2-hoteles').css('display', 'block');
        }else{
          $('.selector-hoteles').hide(); 
          $('.selector').show();
          $('#btn-step2').css('display', 'block');
          $('#btn-step2-hoteles').css('display', 'none');
        }
    });

     /*End Nuevo*/
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
            $('#a_tab3').trigger('click'); //se activa siguiente tab #3
          }
        }); 
    });


    $('#btn-step2-hoteles').on('click', function(e){
      e.preventDefault();
      var frm = $('#destino-form');
      $.ajax({
         // url: full_url + '/safip/public/Paso/2/Enlazar/Hoteles/Paquete/'+destinos[0]['paquete_id'],
         url: full_url + '/Paso/2/Enlazar/Hoteles/Paquete/'+destinos[0]['paquete_id'],
          type: frm[0].method,
          dataType: 'json',
          data: { destinos: destinos },
        })
        .done(function(response){ //
          
          if(response != '') {                        
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

</script>-->
<script type="text/javascript">
  $(document).ready(function(){
    $('#dest').select2({
      with: '100%'
    });
    $('#dest').on('change', function(){
      var val_dest = $(this).val();
      console.log(val_dest);
      var separador = "_";
      desti = val_dest.split(separador);
      //alert(product[
      //Aqui debe ir el valor del id del producto que falta
      $('#nombre-destino').val(desti[1]);
      $('#destino_id').val(desti[0]);
    });
    $('#destino-seleccionado').on('click', function(){
      agregar();
    });
  //cont = 0;
  function agregar(){
    var destino = $('#nombre-destino').val();
    var dias = $('#noches').val();
    var fila = '<tr class="selected" id="fila'+destino+'"><td value="'+destino+'">'+destino+'</td><td>'+dias+'</td><td><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td></tr>';
      //cont++;
      $('#destinos-select').append(fila);
  }
  /*function add(){

    var fila= '<tr class="selected" id="fila'++'" style="text-align:center;"><td id="exent" value="'++'"><input type="hidden" id="exent_iva" name="exent_iva" value="'++'">'++'</td><td><input type="hidden" name="product_id[]" value="'++'">'++'</td><td>'++'</td><td><input type="hidden" name="quantity_product[]" value="'++'" class="">'+  +'</td><td><input type="number" name="buy[]" value="'+parseFloat().toFixed(2)+'"> </td><td><button type="button" class="btn btn-danger btn-sm" onclick="return eliminarFila('++');"><i class="fa fa-trash fa-2x"></i></button></td></tr>';
  }*/
                            //subtot[cont] = quantity * buy;
                            //<td>Bs.'+parseFloat(subtot[cont]).toFixed(2)+'</td>
                            //console.log("probando el sub iva: " + subtotalIva);
                            //subto[cont] = (quantity*buy)-(quantity*buy*iva/100);
                            /*cont++;
                            limpiar();
                            totales();
                            evaluar();*/
                            //$('#details').append(fila);
                            //
  });
</script>
@endsection