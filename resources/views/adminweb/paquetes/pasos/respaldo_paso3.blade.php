    @extends('layouts.master')
    @section('titulo', 'Crear Itinerario')

    @section('content')
    {{--                  ZONA DE ITINERARIO                         --}}

    <div class="row box" id="parte2">
        <div class="col-xs-12">
            <table class=" text-center table table-bordered" style="box-shadow: 3px 3px 5px #ddd; margin-top: 15px;">
                <tr>
                    <td class="col-xs-3"><h4 class="text-bold"><i class="fa fa-calendar"></i> ITINERARIO DE {{strtoUpper($paquete->nombre)}}</h4>
                    </td>
                    
                    <form action="{{route('managePaquete-paso-3-agregar-dia',$paquete->id)}}" method="post"  enctype="multipart/form-data">
                        {{csrf_field()}}
                        <td class="col-xs-2">
                            <input required="" placeholder="Nombre Para El Dia" type="text" class="form-control" name="nombre_dia">
                        </td>
                        <td class="col-xs-3">
                           <textarea name="descripcion_dia" class="form-control" maxlength="200" placeholder="Maximo 200 Caracteres..."></textarea>
                       </td>
                       <td class="col-xs-2">
                           <input type="file" name="imagen" accept="image/png image/jpg" required class="form-control">
                       </td>
                       <td class="col-xs-1">
                            <button class="btn btn-danger"><i class="fa fa-calendar-plus-o"></i> AGREGAR DIA</button>
                        </td>
                    </form>
            </tr>
        </table>

        <div class="box-footer">
            @if($edit)
            <a href="{{route('manageProduct-A')}}" class="btn btn-danger pull-right"><i class="fa fa-arrow-circle-left"></i> Volver</a>
            @else
            <a href="{{route('managePaquete-paso-4-A',$paquete->id)}}" class="btn btn-danger pull-right"  id="parte1-fin">Siguiente <i class="fa fa-arrow-circle-right"></i></a>
            @endif
        </div>


        {{-- FIN ZONA ITINERARIO --}}
        @if(count($paquete->dias) > 0)
        <div >
        @foreach($paquete->dias as $dia)
        <div class="row box " style="box-shadow: 3px 3px 5px #ddd; margin-top: 15px;">
            <div class="col-xs-12" id="lista-dias">
                <table class="table table-bordered">
                    <form action="{{route('managePaquete-paso-3-agregar-actividad',$dia->id)}}" method="POST">
                        {{csrf_field()}}
                        <thead>
                            <tr>
                                <td class="col-xs-9" colspan="2"><h3>Dia {{strtoUpper($dia->nombre)}}</h3></td>
                                <input id="paquete_id" type="hidden" name="paquete_id" value="{{ $paquete->id }}">
                                <input id="dia_id" type="hidden" name="dia_id" value="{{ $dia->id }}">
                                <td id="ocultar_{{ $dia->id }}" style="opacity: 0">
                                    <input id="mismos" type="radio" 
                                           name="change_services" onclick="charge_mismos_destinos({{$dia->id}})" 
                                           checked> Mismos Destinos
                                    <input id="otros" type="radio" 
                                           name="change_services" onclick="charge_others_destinos({{$dia->id}})"> 
                                           Otros Destinos
                                </td>
                                <td>
                                    <a id="filtro_{{$dia->id}}" class="btn btn-info" style="display: none;" 
                                    onclick="filtrar_multi({{$dia->id}})">
                                        <i class="fa fa-filter"></i> Filtrar</a>
                                    <a href="{{ route('eliminar.itinerario', $dia->id) }}" class="btn btn-danger"><i class="fa fa-calendar-minus-o"></i> Eliminar Dia</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-3">
                                    <input required="" placeholder="Nombre Actividad" type="text" class="form-control" name="nombre_actividad">
                                </td>
                                <td class="col-xs-3">
                                    <select onchange="verTipo(this)" name="tipo_actividad" id="{{$dia->id}}" class="form-control" required="">
                                        <option value="none" >Seleccione Un Tipo</option>
                                        <option value="servicio">Servicio</option>
                                        <option value="restaurante">Restaurante</option>
                                    </select>
                                </td>
                                <td class="col-xs-3">
                                    <p class="form-control" id="msg-default_{{$dia->id}}">Seleccione un Tipo Primero</p>

                                    <select id="rest_actividad_{{$dia->id}}" name="restaurante_id" class="form-control hidden" >
                                        <option value="">Seleccione un Restaurante</option>
                                        @foreach($restaurantes as $restaurante)
                                        <option value="{{$restaurante->id}}">{{$restaurante->nombre}} / {{$restaurante->destino->nombre}}</option>
                                        @endforeach
                                    </select>

                                    <div class="form-group" id="div_multiple_{{$dia->id}}" style="display: none;">
                                        <label>Multiple</label>
                                        <select class="form-control select2" 
                                                multiple="multiple" 
                                                data-placeholder="Seleccione los Destinos" 
                                                style="width: 100%;" 
                                                name="multi_destinos" 
                                                id="multi_destinos_{{$dia->id}}">
                                        </select>
                                    </div>

                                    <select id="serv_actividad_{{$dia->id}}" name="servicio_id" class="form-control hidden" v-show="mismos_destinos">
                                        <option id="top_item">Seleccione un Servicio</option>
                                    </select>

                                </td>
                                <td class="col-xs-3 text-center">
                                    <button type="submit" class="btn btn-danger" @click.prevent="store_data({{$dia->id}})"><i class="fa fa-child"></i> Agregar Actividad</button>
                                </td>
                            </tr>    
                        </thead>
                    </form>
                    <tbody>
                        <table class="table table-bordered table-responsive">
                            <thead style="background-color: #dd4b39;color: #fff;">
                                <tr>
                                    <th>Nombre De La Actividad</th>
                                    <th>Tipo de Actividad</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dia->actividades as $actividad)
                                <tr>
                                    <td>{{$actividad->nombre}}</td>
                                    <td>{{$actividad->tipo}}</td>
                                    <td>
                                        <a type="button" href="" class="btn btn-danger btn-xs" id="{{$actividad->id}}" title="Editar"><i class="fa fa-edit"></i></a>
                                        <a type="button" href="{{ route('eliminar.actividad', $actividad->id) }}" class="btn btn-danger btn-xs" id="{{$actividad->id}}"><i class="fa fa-trash"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </tbody>
                </table>
            </div>    
        </div>
        @endforeach
        </div>
        @endif
        <table class="table table-bordered table-responsive"  >
            <thead style="background-color: #dd4b39;color: #fff;">
                <tr class="text-center" style="background-color: #dd4b39;color: #fff;">
                    <td colspan="12">ITINERARIO DE ACTIVIDADES </td>
                </tr>
                <tr>
                    <th class="col-xs-2">Dia</th>
                    <th class="col-xs-2">Actividad</th>
                    <th colspan="2" class="col-xs-2">Peruano</th>
                    <th colspan="2" class="col-xs-2">Extranjero</th>
                    <th colspan="2" class="col-xs-2">Comunidad Andina</th>
                    <th class="col-xs-1">Ninio Peruano</th>
                    <th class="col-xs-1">Ninio Extranjero</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paquete->dias as $dia)
                <tr>
                    <td rowspan="{{count($dia->actividades)+1}}">{{$dia->nombre}}</td>
                    @foreach ($dia->actividades as $actividad)
                        @if($actividad->tipo == "servicio")
                            <tr>
                                <td>{{$actividad->nombre}}</td>
                                <td>{{$actividad->servicio[0]->servicio->peruano->adulto}}</td>
                                <td>{{$actividad->servicio[0]->servicio->peruano->estudiante}}</td>
                                <td>{{$actividad->servicio[0]->servicio->extranjero->adulto}}</td>
                                <td>{{$actividad->servicio[0]->servicio->extranjero->estudiante}}</td>
                                <td>{{$actividad->servicio[0]->servicio->comunidad->adulto}}</td>
                                <td>{{$actividad->servicio[0]->servicio->comunidad->estudiante}}</td>
                                <td>{{$actividad->servicio[0]->servicio->peruano->ninio}}</td>
                                <td>{{$actividad->servicio[0]->servicio->extranjero->ninio}}</td>
                            </tr>
                        @elseif($actividad->tipo == "restaurante")
                            @if(count($actividad->restaurante) > 0)
                </tr>
                                    <td>{{$actividad->nombre}}</td>
                                    <td>{{$actividad->restaurante[0]->restaurante->peruano->adulto}}</td>
                                    <td>{{$actividad->restaurante[0]->restaurante->peruano->estudiante}}</td>
                                    <td>{{$actividad->restaurante[0]->restaurante->extranjero->adulto}}</td>
                                    <td>{{$actividad->restaurante[0]->restaurante->extranjero->estudiante}}</td>
                                    <td>{{$actividad->restaurante[0]->restaurante->comunidad->adulto}}</td>
                                    <td>{{$actividad->restaurante[0]->restaurante->comunidad->estudiante}}</td>
                                    <td>{{$actividad->restaurante[0]->restaurante->peruano->ninio}}</td>
                                    <td>{{$actividad->restaurante[0]->restaurante->extranjero->ninio}}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
            <tfoot style="background-color: #dd4b39;color: #fff;">
                <tr>
                    <td colspan="2">Subtotal</td>
                    <td>{{$subtotal['p_adulto']}}</td>
                    <td>{{$subtotal['p_estudiante']}}</td>
                    <td>{{$subtotal['e_adulto']}}</td>
                    <td>{{$subtotal['e_estudiante']}}</td>
                    <td>{{$subtotal['c_adulto']}}</td>
                    <td>{{$subtotal['c_estudiante']}}</td>
                    <td>{{$subtotal['p_ninio']}}</td>
                    <td>{{$subtotal['e_ninio']}}</td>
                </tr>
            </tfoot>
        </table>
        <div style="background-color: #dd4b39;color: #fff;height: 34px;text-align: center;padding-top: 0.1px;">
            <h4 style="font-size: 14px;">TOTAL</h4>
        </div>
        <table class="table table-bordered table-responsive"  >
            <thead style="background-color: #dd4b39;color: #fff;">
                <tr>
                    @foreach($paquete->listados as $listado)
                    <th class="col-xs-1">{{ $listado->destino->nombre }}</th>
                    @endforeach
                    <th class="col-xs-1">e_swb</th>
                    <th class="col-xs-1">e_dwb</th>
                    <th class="col-xs-1">e_tpl</th>
                    <th class="col-xs-1">e_chd</th>
                    <th class="col-xs-1">p_swb</th>
                    <th class="col-xs-1">p_dwb</th>
                    <th class="col-xs-1">p_tpl</th>
                    <th class="col-xs-1">p_chd</th>
                    <th class="col-xs-1">c_swb</th>
                    <th class="col-xs-1">c_dwb</th>
                    <th class="col-xs-1">c_tpl</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enlazados as $enlazado)
                <tr>
                    @foreach($enlazado['hoteles'] as $hotel)
                    <td>{{ $hotel }}</td>
                    @endforeach
                    <td>{{ $enlazado['e_swb'] }}</td>
                    <td>{{ $enlazado['e_dwb'] }}</td>
                    <td>{{ $enlazado['e_tpl'] }}</td>
                    <td>{{ $enlazado['e_chd'] }}</td>
                    <td>{{ $enlazado['p_swb'] }}</td>
                    <td>{{ $enlazado['p_dwb'] }}</td>
                    <td>{{ $enlazado['p_tpl'] }}</td>
                    <td>{{ $enlazado['p_chd'] }}</td>
                    <td>{{ $enlazado['c_swb'] }}</td>
                    <td>{{ $enlazado['c_dwb'] }}</td>
                    <td>{{ $enlazado['c_tpl'] }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot style="background-color: #dd4b39;color: #fff;">
                
            </tfoot>
        </table>
    </div>    
</div>






@endsection

@section('script')
    <script >
        var APP_URL = {!!json_encode(url('/'))!!};
    </script>
    
    <script src="{{asset('js/paquetes/paso3.js')}}"></script>
@endsection