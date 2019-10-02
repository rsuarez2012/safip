@extends('layouts.master')
@section('titulo', 'Datos Paquetes')

@section('css')
<link rel="stylesheet" href="{{ asset('css/multiSelectCss/multi-select.css') }}">
<style>
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
    .ms-container{
    	width: 100%;
    }
</style>
@endsection
@section('content') 
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header">
            	 <h4><i class="fa fa-cube"></i>  Datos del Paquete  </h4>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="tabs">
                        <li id="t1" class><a href="#tab_1" data-toggle="tab" aria-expanded="false" id="a_tab1">Perfil del paquete</a></li>
                        <li id="t2" class="active"><a href="#tab_2" data-toggle="tab" aria-expanded="false" id="a_tab2">Destinos y Hoteles</a></li>
                        <li id="t3" class="disabled"><a class="disabled">Dias</a></li>
                        <li id="t4" class="disabled"><a class="disabled">Actividades</a></li>
                        <li id="t5" class="disabled"><a class="disabled">Precios</a></li>
                        <li id="t6" class="disabled"><a class="disabled">Datos del paquete</a></li>
                    </ul>
                    <div class="tab-content">
                        <!--datos del paquete-->
                        <div class="tab-pane" id="tab_1">
                            <form action="{{ route('paquete.actualizar', $paquete->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{--$paquete_id--}}
                                <input type="hidden" value="{{ $paquete->id }}" name="id">
                                @include('adminweb.paquetes.nuevo.partials.datos')
                                <button class="btn btn-danger pull-right" type="submit" style="margin-top:-30px;">Guardar</button>
                            </form>
                        </div>
                        <!--configuracion del paquete-->
                        <div class="tab-pane active" id="tab_2">
                        	<form action="{{ route('agregar.desr', $paquete->id) }}" method="POST" id="destino-form">
                        		 {{ csrf_field() }}
                        		<input type="hidden" name="id" value="{{$paquete->id}}" id="paquete_id">
                        		@include('adminweb.paquetes.nuevo.partials.destinos')
                        		<!--<div class="row">                        			
	                        		<div class="col-sm-6">
	                        			<div class="form-group">
	                        				<label for="">Desea agregar hotel.?</label>
	                        				<select class="form-control" id="opcion">
	                        					<option value="no">NO</option>
	                        					<option value="si">SI</option>
	                        				</select>
	                        			</div>
	                        		</div>
	                        		<div class="col-sm-6">
	                        			<div class="form-group">
	                        				<label>Dias de Hospedaje</label>
	                        				<input type="number" name="noches" id="noches" class="form-control" value="0">
	                        			</div>
	                        		</div>
                        		</div>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="form-group selector">
	                        				<label>Destinos</label>
	                        				<select class="form-control" multiple="multiple" id="destino" name="destino">
	                        					@foreach($destinos as $destino)
          											  <option value='{{ $destino->id }}'>{{ $destino->nombre }}</option>
          											  @endforeach
          											</select>
  	                        			</div>
  	                        			<div class="form-group selector-hoteles" style="display: none;">
  	                        				<label>Destinos</label>
  	                        				
  	                        				<select class="form-control" multiple="multiple" id="destinos-hoteles">
  	                        					@foreach($destinos as $destino)
  	                        					<optgroup label='{{$destino->nombre}}'>
  	                        						@foreach($destino->hoteles as $hotel)
  												  	         <option value='{{ $destino->id }}_{{ $hotel->id }}'>{{ $hotel->nombre.' '.$destino->id }}</option>
          												  @endforeach	
          												</optgroup>
          											  @endforeach
          											</select>
	                        			</div>
                        			</div>
                        		</div>
                              <div class="form-group">
                          		<a id="btn-step2" class="btn btn-danger pull-right">Guardar</a>
                                  <a id="btn-step2-hoteles" class="btn btn-danger pull-right" style="display: none">Enlazar</a>
                              </div>-->
                          </form>
                          @if(count($paquete->enlazados) > 0)
                          <div id="hoteles-list">
                                <br/>
                                <label>Hoteles enlazados</label>
                                <hr/>
                        	
                                @php $hoteles_enlazados = ''; @endphp
                                @php $p_swb = 0; $p_dwb = 0; $p_tpl = 0; $p_chd = 0; @endphp
                                @php $e_swb = 0; $e_dwb = 0; $e_tpl = 0; $e_chd = 0; @endphp

                                @foreach($paquete->enlazados as $enlazado) 
                                  @php $hoteles_enlazados .= $enlazado->hotel->nombre.' / '; @endphp
                                  @php $p_swb += $enlazado->hotel->p_swb; @endphp
                                  @php $p_dwb += $enlazado->hotel->p_dwb; @endphp
                                  @php $p_tpl += $enlazado->hotel->p_tpl; @endphp
                                  @php $p_chd += $enlazado->hotel->p_chd; @endphp
                                  @php $e_swb += $enlazado->hotel->e_swb; @endphp
                                  @php $e_dwb += $enlazado->hotel->e_dwb; @endphp
                                  @php $e_tpl += $enlazado->hotel->e_tpl; @endphp
                                  @php $e_chd += $enlazado->hotel->e_chd; @endphp
                                @endforeach
                                 <div class="row">
                                     <div class="col-sm-12">
                                         <div class="table-responsive">
                                           <table id="hoteles-table" class="table table-bordered table-hover enlazados">
                                             <thead>
                                              <tr>
                                                 <th colspan="2">&nbsp;</th>
                                                 <th colspan="4">Peruano</th>
                                                 <th colspan="4">Extranjero</th>
                                                 <th>&nbsp;</th>
                                              </tr>
                                               <tr>
                                                 <th class="text-center">Hoteles</th>
                                                 <th class="text-center">*</th>
                                                 <th class="text-center">Simple</th>
                                                 <th class="text-center">Doble</th>
                                                 <th class="text-center">Triple</th>
                                                 <th class="text-center">Cuadruple</th>
                                                 <th class="text-center">Simple</th>
                                                 <th class="text-center">Doble</th>
                                                 <th class="text-center">Triple</th>
                                                 <th class="text-center">Cuadruple</th>
                                                 <th class="text-center">ACCIONES</th>
                                               </tr>
                                             </thead>
                                             <tbody>
                                              @if(count($paquete->enlazados)>0)
                                              <tr>                                      
                                                <td>{{ $hoteles_enlazados }}</td>
                                                <td class="text-center">HOSTEL</td>
                                                <td class="text-center">{{ $p_swb }}</td>
                                                <td class="text-center">{{ $p_dwb }}</td>
                                                <td class="text-center">{{ $p_tpl }}</td>
                                                <td class="text-center">{{ $p_chd }}</td>
                                                <td class="text-center">{{ $e_swb }}</td>
                                                <td class="text-center">{{ $e_dwb }}</td>
                                                <td class="text-center">{{ $e_tpl }}</td>
                                                <td class="text-center">{{ $e_chd }}</td>
                                                <td>&nbsp;</td>
                                              </tr>
                                              @else
                                                <tr>                                      
                                                  <td class="text-center" colspan="11">No hay hoteles enlazados</td>
                                                </tr>
                                              @endif
                                            </tbody>
                                          </table>

                                        </div>
                                     </div>
                                  </div>
                                </div>
                                  @endif

                                  @if(count($paquete->listados)> 0)
                                    {{--<br/>
                                    <label>Destinos</label>
                                    <hr/>
                                    <div class="row">
                                     <div class="col-sm-12">
                                         <div class="table-responsive">
                                           <table id="destinos-table" class="table table-bordered table-hover enlazados">
                                             <thead>
                                               <tr>
                                                 <th class="text-center">Destino</th>
                                                 <th class="text-center">ACCIONES</th>
                                               </tr>
                                             </thead>
                                             <tbody>                                              
                                              @foreach($paquete->listados as $row)
                                              <tr>                                      
                                                <th class="text-center">{{ $row->destino->nombre }}</th>
                                                <th><a class="btn btn-xs btn-danger eliminarDestino" title="" data-toggle="tooltip" data-destino="{{ $row->id }}" data-original-title="Eliminar Destino"><i class="fa fa-trash "></i></a></th>
                                              </tr>
                                              @endforeach
                                              @if(count($paquete->listados) < 1)
                                                <tr>                                      
                                                  <td class="text-center">No hay destinados asociados</td>
                                                  <td></td>
                                                </tr>
                                              @endif
                                            </tbody>
                                          </table>

                                        </div>
                                     </div>
                                  </div>--}}

                                  @endif
                        </div>
                        <!--itinerario-->
                        <div class="tab-pane" id="tab_3">

                            <a id="btn-step3" class="btn btn-danger pull-right">Guardar</a>
                        </div>
                        <!--adicionales--> 
                        <div class="tab-pane" id="tab_4">

                            <a id="btn-step4" class="btn btn-danger pull-right">Guardar</a>
                        </div>

                    </div>
                </div>
            </div>  
        </div>
    </div>
</div> 
@endsection
<script type="text/javascript">
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
  	alert("aqu");
    //var paquete = '{{  $paquete->id }}';
    $('#dest').select2({
      with: '100%',
      tags: true
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
    //$('#delete-dest').on('click',function(){
    $('#destinos-select #delete-dest').click(function(){
    	console.log($(this).attr('data-id'));
    		
    	//e.preventDefault();
    	var id = $(this).attr('data-id');
    	//var id = $(this).val();
    	destino = '';
    	console.log(id);
    	confirm("Esta seguro de eliminar?");
    	$.ajax({
	    		type:'POST',
	    		//url:'/clientes/status/'+id,
	    		url:'/Paso/2/Paquete/DestroyDestino',
	    		data: { destino:id },
	    		success: function(data, msg){
	    			//$('#exito').delay(500).fadeIn('slow');
	    			$('.destino_id'+id).remove();
	    			toastr.success('Destino eliminado con exito!.');

	    		},
	    		error:function(data){
	    			console.log('Error:', data);
	    		}
	    	})
    });
    $('#opcion').change(function(){
        var val = $(this).val();
        if(val == 'si'){
        	
          $('#dest-hot').show();
          $('#btn-step2-hoteles').show();
          $('#next').hide();

          //$('.selector').hide();
          //$('.selector-hoteles').show();
          //$('#destinos-hoteles').addClass("disabled");

          //$('#btn-step2').css('display', 'none');
          //$('#btn-step2-hoteles').css('display', 'block');
        }else{
          $('#dest-hot').hide();
          $('#btn-step2-hoteles').hide();
          $('#next').show();

          //$('.selector-hoteles').hide(); 
          //$('.selector').show();
          //$('#btn-step2').css('display', 'block');
          //$('#btn-step2-hoteles').css('display', 'none');
        }
    });
    $('#hot-des').change(function(){
    	var destin_id = $(this).val();
    	var paquete_id = $('#paquete_id').val();
    	console.log(destin_id);
    	$.ajax({
    		url:'/safip/public/Paso/2/load/paquete/'+paquete_id,
    		type: 'GET',

    	}).done(function(response){
    		console.log(response);
    	})
    });
    $('#hot-dest').change(function() {
    	var id = $(this).val();
    	var paquete_id = $('#paquete_id').val();
    	destino = '';
    	console.log(paquete_id);
      $('#destinos-hoteles').empty().multiSelect('refresh');

    	$.ajax({
    		url:full_url + '/safip/public/destinosP/'+id,
		//url:'/destinosP/'+id,
    		type: 'GET',
    		data: {destino:id},
    		success: function(data){
            
	    			if(data.length > 0) {  				    
              
      				$("#destinos-hoteles").append('<option value="" disabled>Hoteles del destino '+data[0].destino_id+'</option>');
      				var destinos = [];
  	    			$.each(data, function(index, el) {
  	    				$("#destinos-hoteles").append('<option value='+el.id+"_"+el.destino_id+' data-id='+el.destino_id+'>'+el.nombre+'</option>'); 	
  			    		destinos.push({paquete_id:paquete_id, destino_id:el.destino_id, hotel_id:el.id, noches: $('#count-days').val()});  			    		

  	    			});

              $('#destinos-hoteles').multiSelect('refresh');

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
                  
                  },
                  afterDeselect: function(value){
                    destinos.splice(destinos.findIndex(item => item.value === value[0]), 1)
                  }

              });

	    		   }
             else {
              $("#destinos-hoteles").append('<option value="" disabled>No hay hoteles registrados</option>');
             }
             $('.selector-hoteles').show();
        }
    	})
    });
    //var destinos = [];
    $('#destinos-hoteles > option:selected ').each(
    		function(i){
    			destinos[i] = $(this).val();
    			console.log("Destinos seleccionados "+destinos);
    		});
    
    $('#btn-step2').on('click', function(e){
      e.preventDefault();
      var frm = $('#destino-form');
      console.log(frm);
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
      var paquete_id = $('#paquete_id').val();
      var a = $('#destinos-hoteles > option').val();
    
      $('#destinos-hoteles > option:selected').each(
    		function(i){
    			//var values = value[0].split("_");
    			var destin = $('#destinos-hoteles > option:selected').attr('data-id');
    			destinos.push({paquete_id:paquete_id, hotel_id:$(this).val(), noches: $('#count-days').val(), destino_id: destin});
    			
    		});

      $.ajax({
         // url: full_url + '/safip/public/Paso/2/Enlazar/Hoteles/Paquete/'+destinos[0]['paquete_id'],
          //url: full_url + '/safip/public/Paso/2/Enlazar/Hoteles/Paquete/'+paquete_id,         
	  url: full_url + '/Paso/2/Enlazar/Hoteles/Paquete/'+paquete_id,         
          type: frm[0].method,
          dataType: 'json',
          data: { destinos: destinos },
          success: function(response){ //
            $('#hoteles-table tbody').remove();
            var hoteles_enlazados = '';
            var p_swb = 0; p_dwb = 0; p_tpl = 0; p_chd = 0;
            var e_swb = 0; e_dwb = 0; e_tpl = 0; e_chd = 0;

            response.enlazados.forEach(function (enlazado) {
                hoteles_enlazados += enlazado.hotel.nombre + ' / ';
                p_swb += parseFloat(enlazado.hotel.p_swb); 
                p_dwb += parseFloat(enlazado.hotel.p_dwb); 
                p_tpl += parseFloat(enlazado.hotel.p_tpl); 
                p_chd += parseFloat(enlazado.hotel.p_chd); 
                e_swb += parseFloat(enlazado.hotel.e_swb); 
                e_dwb += parseFloat(enlazado.hotel.e_dwb); 
                e_tpl += parseFloat(enlazado.hotel.e_tpl); 
                e_chd += parseFloat(enlazado.hotel.e_chd);                 
            });
            $('#hoteles-table').append("<tr><td>" + hoteles_enlazados + "</td><td>HOSTEL</td><td>" + p_swb.toFixed(2) + "</td><td>" + p_dwb.toFixed(2) + "</td><td>" + p_tpl.toFixed(2) + "</td><td>" + p_chd.toFixed(2) + "</td><td>" + e_swb.toFixed(2) + "</td><td>" + e_dwb.toFixed(2) + "</td><td>" + e_tpl.toFixed(2) + "</td><td>" + e_chd.toFixed(2) + "</td><td>&nbsp;</td></tr>");
        }
      }); 
    });


  //cont = 0;
  function agregar(){
    var destino = $('#nombre-destino').val();
    var dias = $('#noches').val();
    var fila = '<tr class="selected" id="fila'+destino+'"><td value="'+destino+'">'+destino+'</td><td>'+dias+'</td><td><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td></tr>';
      //cont++;
      $('#destinos-select').append(fila);
  }

  $('#destinos-select #edit-dest').click(function(){
	var id = $(this).attr('data-id');
	//var dias = $('#'+id).val();
        var dias = $('#count-days').val();
	console.log(dias);
         //alert(texto);
         if(dias ===""){
            toastr.success('Por favor ingrese la cantidad de dias!.');
         }else{
            $.ajax({
               type:'POST',
               data: {
                  id: id,
                  _token: $('#signup-token').val(),
                  dias: dias,
               },
               url: '/dias/destino/'+id,
               success:function(data){
                  
                  toastr.success('Dato actualizado con exito!.');
               },
               error:function(data){
                  console.log('Error:',data);
               }
   	     });
	}
    });  
  
  });
</script>
