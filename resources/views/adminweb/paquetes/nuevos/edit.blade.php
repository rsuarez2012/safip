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
            <li id="t1" class>
              <a href="#tab_1" data-toggle="tab" aria-expanded="false" id="a_tab1">Perfil del paquete</a>
            </li>
            <li id="t2" class="active">
              <a href="#tab_2" data-toggle="tab" aria-expanded="false" id="a_tab2">Destinos y Hoteles</a>
            </li>
            <li id="t3" class="disabled">
              <a class="disabled">Dias</a>
            </li>
            <li id="t4" class="disabled">
              <a class="disabled">Actividades</a>
            </li>
            <li id="t5" class="disabled">
              <a class="disabled">Precios</a>
            </li>
            <li id="t6" class="disabled">
              <a class="disabled">Datos del paquete</a>
            </li>
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
                @include('adminweb.paquetes.nuevos.partials.destinos')
              </form>
              
                <div id="hoteles-list">
                  <br/>
                  <label>Hoteles enlazados</label>
                  <hr/>
                  
                  @if(count($paquete->enlazados) > 0)         
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
                  @endif
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
                              <tr id="{{ $enlazado->id }}" data-id="{{ $enlazado->id }}">                                      
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
                                <td>
                                  <button type="button" data-toggle="tooltip" data-placement="left" title="Eliminar Enlace" class="btn btn-danger btn-xs" id="quitar_enlace" data-id="{{$paquete->id}}"><i class="fa fa-close"></i>
                                  </button>
                                  {{--<button type="button" data-toggle="tooltip" data-placement="top" title="Quitar Todos Destacados" class="btn btn-warning btn-xs pull-right" @click.prevent="clear_all" :disabled="destacados.length == 0"><i class="fa fa-ban"></i>
                                  </button>
                                  <button type="button" id="cinco_destacados" style="margin-right: 12px;" class="btn btn-warning btn-xs pull-right" data-toggle="tooltip" data-placement="top" title="Destacados 5 primeros hoteles" @click.prevent="set_cinco_primeros" :disabled="destacados.length >= 5"><i class="fa fa-star"></i>
                                  </button>--}}
                                </td>
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
            <div class="tab-pane" id="tab_3"></div>
            <!--adicionales--> 
            <div class="tab-pane" id="tab_4"></div>
          </div>
        </div>
      </div>  
    </div>
  </div>
</div> 
@endsection
@section('script')
<script src="{{ asset('js/nuevo/destinos.js') }}"></script>
@endsection