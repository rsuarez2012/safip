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
    td{
      width: 20%;
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
                <a href="{{route('paquete.editActividades.paso3', $paquete->id)}}" class="btn btn-danger btn-xs pull-right" data-id="{{$paquete->id}}">Siguiente</a>
                <ul class="nav nav-tabs" id="tabs">
                  <li id="t1" class><a href="#tab_1" data-toggle="tab" aria-expanded="false" id="a_tab1">Perfil del paquete</a></li>
                        <li id="t2" class><a href="#tab_2" data-toggle="tab" aria-expanded="false" id="a_tab2">Destinos y Hoteles</a></li>
                        <li id="t3"  class="active"><a href="#tab_3" data-toggle="tab" aria-expanded="false" id="a_tab3">Dias</a></li>
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
                        @include('adminweb.paquetes.nuevos.partials.create')
                        <button class="btn btn-danger pull-right" type="submit" style="margin-top:-30px;">Guardar</button>
                    </form>
                  </div>
                  <div class="tab-pane" id="tab_2">
                    <form action="{{ route('agregar.desr', $paquete->id) }}" method="POST" id="destino-form">
                      {{ csrf_field() }}
                      <input type="hidden" name="id" value="{{$paquete->id}}" id="paquete_id">
                      @include('adminweb.paquetes.nuevos.partials.destinos')
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
                        <!--configuracion del paquete-->
                  <div class="tab-pane active" id="tab_3">
                 	<div  class="row">
                    <div id="dia">
                      {{--$paquete->id--}}
                      @php 
                        $a = count($noches);
                      @endphp
                      @php
                        $dia=1;
                      @endphp
                      {{--$a--}}
                      @if($a == 0)
                        {{--$onlydes--}}
                        <form action="{{url('/save/day',$paquete_id)}}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                          <input type="hidden" name="paquete_id" value="{{$paquete->id}}" id="paquete_id">
                          <table class="table table-hover table-bordered">
                            @foreach($onlydes as $only)
                            <tr id="tre" data-id="{{$only->noche_id}}">
                              <input type="hidden" name="noche_id[]" id="noche_id" value="{{$only->noche_id}}">
                              <td>
                                  <label class="text-dark">Día {{$dia++}}
                                  </label>
                              </td>
                              <td>
                                  <label class="text-dark">Día Libre</label><br>
                                  <input type="checkbox" name="freeDay[]" id="dia-libre" value="1">
                              </td>
                              <td>
                                  <label class="text-dark">Nombre del Día</label>
                                  
                                  <input type="text" class="form-control" placeholder="Ejemplo" name="nameFree[]" id="nameFree">
                              </td>
                              <td>
                                  <label class="text-dark">Descripción del Día</label>
                                  <textarea  rows="2" class="form-control"  placeholder="Texto..." name="description[]" id="description"></textarea>
                              </td>
                              <td>
                                  <label class="text-dark">Imagen</label>
                                  <input class="form-control" @change="processFile($event)" type="file" accept="image/*" id="file" name="imagen[]">
                              </td>
                            </tr>
                            @endforeach
                            <tr>
                              <td colspan="5">
                                <button  type="submit" class="btn btn-danger pull-right" ><i class="fa fa-save"></i> Guardar</button>
                              </td>
                            </tr>
                          </table>
                            
                        </form>
                        
                      @else
                          {{--$noches--}}
                      
                            <!--<form @submit.prevent="saveDay()">-->
                        <form action="{{url('/save/day',$paquete_id)}}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                          <input type="hidden" name="paquete_id" value="{{$paquete->id}}" id="paquete_id">
                          <table class="table table-hover table-bordered">
                            @foreach($noches as $noche)
                            <tr id="tre" data-id="{{$only->noche_id}}">
                              <input type="hidden" name="noche_id[]" id="noche_id" value="{{$only->noche_id}}">
                              <td>
                                  <label class="text-dark">Día {{$dia++}}
                                  </label>
                              </td>
                              <td>
                                  <label class="text-dark">Día Libre</label><br>
                                  <input type="checkbox" name="freeDay[]" id="dia-libre" value="1">
                              </td>
                              <td>
                                  <label class="text-dark">Nombre del Día</label>
                                  
                                  <input type="text" class="form-control" placeholder="Ejemplo" name="nameFree[]" id="nameFree">
                              </td>
                              <td>
                                  <label class="text-dark">Descripción del Día</label>
                                  <textarea  rows="2" class="form-control"  placeholder="Texto..." name="description[]" id="description"></textarea>
                              </td>
                              <td>
                                  <label class="text-dark">Imagen</label>
                                  <input class="form-control" @change="processFile($event)" type="file" accept="image/*" id="file" name="imagen[]">
                              </td>
                            </tr>
                            @endforeach
                            <tr>
                              <td colspan="5">
                                <button  type="submit" class="btn btn-danger pull-right" ><i class="fa fa-save"></i> Guardar</button>
                              </td>
                            </tr>
                          </table>
                            
                        </form>
                        
          @endif

      </div>
                        @include('adminweb.paquetes.nuevos.partials.actividades')
  </div>
  </div>      
                            <!--<div class="col-xs-12">
                              <button :disabled="view_button_new" @click="newDay(package.id)" class="btn btn-danger pull-right"><i class="fa fa-plus-circle"></i> Agregar Dia</button>    
                            </div>-->
{{--<div class="table-responsive">
  <table class="table table-bordered">
    <thead style="background-color: #dd4b39;">
      <tr style="color: #fff">
        <th class="col-xs-2">Imagen</th>
        <th class="col-xs-1">N° del Dia</th>
        <th class="col-xs-1">Nombre</th>
        <th class="col-xs-4">Descripción</th>
        <th class="col-xs-1 text-center">Acciones</th>
      </tr>
    </thead>
  <tbody>
    <tr v-for="(day, index) in package.dias">
      <td class="text-center" style=" vertical-align: middle;"><img  :src="route+'/storage/miniature/dia'+day.imagen" alt="Este dia no tiene una imagen"></td>
      <td class="text-center">@{{(index+1)}}</td>
      <td class="text-center">@{{day.nombre}}</td>
      <td style="text-align: justify;">@{{day.descripcion}}</td>
      <td class="text-center">
          <button @click="showActivities(index)" class="btn btn-primary btn-xs" title="Ver Actividades" data-toggle="tooltip"><i class="fa fa-calendar"></i></button>
          <button @click="editDay(day)" class="btn btn-warning btn-xs" title="Editar Dia" data-toggle="tooltip"><i class="fa fa-pencil"></i></button>
          <button @click="deleteDay(day,index)" class="btn btn-danger btn-xs" title="Eliminar Dia" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
      </td>
    </tr>
  </tbody>
</table>--}}
</div>
                          
                        <!--itinerario-->
                        <div class="tab-pane" id="tab_4">

                          
                        </div>
                        <!--adicionales--> 
                        <div class="tab-pane" id="tab_5">

                            
                        </div>

                    </div>
                </div>
            </div>  
        </div>
    </div>
</div> 
@endsection
@section('script')
<script src="{{-- asset('js/nuevo/dias.js') --}}"></script>
<script src="{{ asset('js/nuevo/create.js') }}"></script>
<script src="{{ asset('js/nuevo/destinos.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var row = $('#row').html();
    $('#tre').click(function(){
      var noc = $('#noche_id').val();
      trid = $(this).attr('data-id');
      console.log(trid);

    });
    $('#addOnly').click(function(){
      var paquete_id = $('#paquete_id').val();
      $.ajax({
        type: 'POST',
        url: '/safip/public/save/day/'+paquete_id, 
        //data:{paquete_id:paquete_id, nombre:nameFree, description:description},
        success:function(data){

        },
      });

    });
  })
</script>

@endsection






