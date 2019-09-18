@extends('layouts.master')
@section('titulo', 'Hoteles Paquete - Paso 2')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pasos_paquetes.css') }}">
@endsection
@section('content')
<div hidden="true" id="div-alerta" class="callout callout-danger" style="position: fixed;z-index: 999999;">
    <h4 style="display: inline;" id="texto-alerta"></h4> <img id="img-alerta" hidden="true" width="20" height="20" src="{{asset('imagenes/cargando.gif')}}">
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <div class="x_title">
            {{-- AGREGAR DESTINOS     --}}
            <div class="col-xs-12 table-responsive">
                <table class="table box" style="box-shadow: 5px 5px 5px #ddd">
                    <tr>
                        <form action="{{route('managePaquete-paso-2-Agregar-Destino')}}" method="POST">
                            {{csrf_field()}}
                            <td class="col-xs-3"><h3><i class="fa fa-map-signs"></i> Destinos <img src="{{asset('imagenes/cargando.gif')}}" hidden="" id="cargando" alt=""></h3></td>
                            <td class="col-xs-3"><input name="noches" type="number" min="0" class="form-control" required="" placeholder="Cantidad de Noches"></td>
                            <td class="col-xs-3">
                                <input type="hidden" value="{{$paquete->id}}" name="id" id="paquete_id">
                                <select name="destino" required="" class="form-control select2">
                                    <option value="" selected="">Seleccione Destino</option>
                                    @foreach($destinos as $destino)
                                    @if(count($destino->hoteles)>0)
                                    <option value="{{$destino->id}}">{{$destino->nombre}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </td>
                            <td class="col-xs-3">
                                <button class="btn btn-danger"><i class="fa fa-plus-circle"></i> Agregar</button>
                            </td>
                        </form>
                    </tr>
                </table>
            </div>
            {{-- FIN AGREGAR DESTINOS   --}}
        </div>
    </div>
    {{-- LISTA DE HOTELES POR DESTINO --}}
    <div class="box-body">
        @if(count($paquete->listados)>0)
        <div class="box">
                <div class="box-header">
                        <button id="enlazar" class="btn btn-danger"><i class="fa fa-exchange"></i> Enlazar</button>
                        @if(!$edit)
                        <a href="{{route('managePaquete-paso-3-A',$paquete->id)}}" class="btn btn-danger pull-right">Siguiente <i class="fa fa-arrow-circle-right"></i></a>
                        @else
                        <a href="{{route('manageProduct-A')}}" class="btn btn-danger pull-right"><i class="fa fa-arrow-circle-left"></i> Volver</a>
                        @endif
                    </div>
        </div>
        <div class="box" style="overflow-x: auto;white-space: nowrap;box-shadow: 5px 5px 5px #ddd;">
            <div class="box-body box-lista-hoteles">
                    <div class="nav-tabs-custom  tab-danger">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab_1" data-toggle="tab">Hoteles Para Enlazar</a></li>
                              <li><a id="hoteles_tab" href="#tab_2" data-toggle="tab">Hoteles Enlazados</a></li>
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_1">
                                    @foreach($paquete->listados as $destino)
                                    <table style="display: inline;" class="table table-bordered">
                                        <thead class="bg-orange">
                                            <tr>
                                                <th class="text-center" colspan="2">
                                                    Hoteles en {{strtoupper($destino->destino->nombre)}}
                                                </th>
                                                <th>
                                                    Noches: {{ $destino->noches->cantidad }}
                                                </th>
                                                <th>
                                                    <a href="{{ route('destroy.paquete.listado', $destino->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</a>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th> <i class="fa fa-check"></i> </th>
                                                <th>Nombre</th>
                                                <th>*</th>
                                                <th>Categoria</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($destino->destino->hoteles as $hotel)
                                            <tr>
                                                <td name="{{$destino->noche_id}}"><input name="hotel{{$destino->destino->nombre}}" value="{{$hotel->id}}"  type="radio">{ñsflgisñfk</td>
                                                <td>{{$hotel->nombre}}</td>
                                                <td>{{$hotel->estrella}}</td>
                                                <td>{{$hotel->categoria->nombre}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endforeach
                              </div>
                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_2">
                                    <table id="lista-enlazados" class="box table table-responsive table-bordered">
                                            <thead style="background-color: #dd4b39;color: white">
                                                <tr>
                                                    @foreach($paquete->listados as $destino)
                                                    <th>Hoteles En {{$destino->destino->nombre}}</th>
                                                    @endforeach
                                                    <th>E_SWB</th>
                                                    <th>E_DWB</th>
                                                    <th>E_TPL</th>
                                                    <th>E_CHD</th>
                                                    <th>P_SWB</th>
                                                    <th>P_DWB</th>
                                                    <th>P_TPL</th>
                                                    <th>P_CHD</th>
                                                    <th class="text-center">Quitar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($enlazados as $key => $fila)
                                                <tr>
                                                    @foreach($fila['hoteles'] as $nombre_hotel)
                                                    <td>{{$nombre_hotel}}</td>    
                                                    @endforeach
                                                    <td>{{round($fila['e_swb'] * 100) / 100}}</td>
                                                    <td>{{round($fila['e_dwb']*100)/100}}</td>
                                                    <td>{{round($fila['e_tpl']*100)/100}}</td>
                                                    <td>{{round($fila['e_chd']*100)/100}}</td>
                                                    <td>{{round($fila['p_swb']*100)/100}}</td>
                                                    <td>{{round($fila['p_dwb']*100)/100}}</td>
                                                    <td>{{round($fila['p_tpl']*100)/100}}</td>
                                                    <td>{{round($fila['p_chd']*100)/100}}</td>
                                                    <td>
                                                        <a type="button" class="btn btn-xs btn-danger" title="" data-toggle="tooltip" data-original-title="Eliminar Enlace" onclick="event.preventDefault(); document.getElementById('delete-enlace_{{ $key }}').submit();"><i class="fa fa-trash "></i>
                                                            <form id="delete-enlace_{{ $key }}" action="{{ route('eliminar.enlace') }}" method="POST" style="display: none;">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="codigo" value="{{ $key }}">
                                                            </form>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach  
                                            </tbody>           
                                    </table>
                              </div>
                            </div>
                    </div>
            </div>
        </div>    
        @endif
    </div>
    {{--FIN LISTA DE HOTELES POR DESTINO --}}

    {{-- TABLA DE HOTELES ENLAZADOS --}}
    <div class="box-body">
        
    </div>
    {{-- FIN DE HOTELES ENLAZADOS --}}
    
</div>
</div>
</div>
@endsection


@section('script')
<script>
    $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
});

    var APP_URL = {!!json_encode(url('/'))!!};
</script>
<script src="{{asset('js/paquetes/paso2.js')}}"></script>

@endsection

