@extends('layouts.master')
@section('titulo', 'Crear Itinerario')
@section('css')
<link rel="stylesheet" href="{{ asset('css/pasos_paquetes.css') }}">
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
                        <li id="t1" class=""><a href="#tab_1" data-toggle="tab" aria-expanded="true">Perfil del paquete</a></li>
                        <li id="t2" class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Destinos y Hoteles</a></li>
                        <li id="t3" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Dias</a></li>
                        <li id="t4" class="active"><a href="#tab_4" data-toggle="tab" aria-expanded="true">Actividades</a></li>
                        <li id="t5" class="disabled"><a class="disabled">Precios</a></li>
                        <li id="t6" class="disabled"><a class="disabled">Datos del paquete</a></li>
                    </ul>
                    <div class="tab-content">
                        <!--datos del paquete-->
                        <div class="tab-pane active" id="tab_1">
                            <form action="{{ route('paquete.guardar') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{--@include('adminweb.paquetes.nuevo.partials.datos')
                                <button class="btn btn-danger pull-right" type="submit">Guardar</button>--}}
                            </form>
                        </div>
                        <!--configuracion del paquete-->
                        <div class="tab-pane" id="tab_2">
                            {{--@include('adminweb.paquetes.nuevo.partials.destinos')--}}
                        </div>
                        <!--itinerario-->
                        <div class="tab-pane" id="tab_3">
                            {{--@include('adminweb.paquetes.nuevo.partials.dia')--}}
                        </div>
                        <!--adicionales--> 
                        <div class="tab-pane active" id="tab_4">
                          <form action="{{ url('/save/activity/day', $paquete_id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="paquete_id" id="paquete_id" value="{{$paquete_id}}">
                            <div class="row">
                              <div class="form-group col-md-4">
                                <label>Seleccione el Dia</label>
                                <select class="select2" style="width: 100%" name="dias">
                                  @foreach($dias as $dia)
                                    <option value="{{$dia->id}}">{{$dia->nombre}}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group col-md-4"></div>
                              <div class="form-group col-md-4" style="display: none" id="serve-des">
                                <label>Servicios de otro Destino</label>
                                <select class="select2" style="width: 90%" id="destinos-ser">
                                  <option>Buscar destino</option>
                                </select>
                                <a class="btn btn-primary btn-xs" id="searchFilterRestaurants"><i class="fa fa-filter"></i></a>
                                
                                
                                
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-4">
                                <label>Nombre de la actividad</label><br>
                                <input type="text" name="activity" class="form-control">
                              </div>
                              <div class="form-group col-md-4">
                                <label>Tipo de Actividad</label><br>
                                <!--<input type="text" name="descripcion" class="form-control">-->
                                <select name="tipoA" id="tipo" class="select2" style="width: 100%">
                                  <option>Seleccione el tipo de Actividad</option>
                                  <option value="servicio">Servicio</option>
                                  <option value="restaurante">Restaurante</option>
                                </select>
                              </div>
                              <div class="form-group col-md-4">
                                <label>Servicios</label>
                                <div class="row" id="opcion" style="display: none;">
                                  <input type="radio" @change="changeFilterServices()" checked value="false" name="f-services">Mismos
                                  <input type="radio" @change="changeFilterServices()" value="true" name="f-services" id="f-services">Otros
                                </div>
                                <select class="select2" style="width: 100%" id="search-restaurants" name="actividad">
                                  <option value="">Servicios</option>
                                </select>
                              </div>
                            </div>
                            <div class="row">
                              <img src="">

                              <button class="btn btn-danger btn-xm pull-right" type="submit" style="margin: 20px;">Guardar</button>
                            </div>
                          </form>
                          <div class="table-responsive">
                            @include('adminweb.paquetes.nuevos.partials.itinerario')
                          </div>

                        </div>

                    </div>
                </div>
            </div>  
        </div>
    </div>
</div> 
@endsection
@section('script')
<script src="{{ asset('js/nuevo/itinerario.js') }}"></script>
@endsection