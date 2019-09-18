@extends('layouts.master')

@section('titulo', 'Editor Cotizaciones')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
    <style>
        .stilo-select2{
               border-radius: 0 !important;
    height: 34px !important;
    border-color: #d2d6de !important;
        }
    </style>
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-pencil"></i>Editar Cotizacion de Boleto</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-10 ">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageCotizacion-update-A',$cotizaciones->id)}}">
                        {!! csrf_field() !!}

                         <fieldset>

                        <div class="form-group {{ $errors->has('aviaje') ? ' has-error' : '' }}">
                            
                            <label class="control-label col-sm-4">Agencia de Viajes</label>
                            <div class="col-sm-8">
                            <select name="aviaje" required class="form-control select2 " required>
                                <option value="{{$cotizaciones->aviajes_id}}">{{$cotizaciones->aviajes_id}}</option>
                                <option value="" " class=" stilo-select2">Selecciona la Agencia de Viaje</option>
                                @foreach($aviajes as $aviaje)
                                    <option value="{{$aviaje->id}}">{{$aviaje->nombre}}</option>
                                @endforeach
                                 
                            </select>

                            @if ($errors->has('aviaje'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('aviaje') }}</strong>
                                      </span>
                            @endif
                        </div>
                        </div>

                        <div class="form-group {{ $errors->has('pais') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4"> Pais</label>
                            <div class="col-sm-8">
                            <select name="pais" required class="form-control select2" required>
                                <option value="{{$cotizaciones->paises_id}}">{{$cotizaciones->paises_id}}</option>
                                <option value="" >Selecciona el Pais</option>
                                @foreach($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->paisnombre}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('pais'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('pais') }}</strong>
                                      </span>
                            @endif
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('salida') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4"> Desde</label>
                            <div class="col-sm-8">
                            <select name="salida" required class="form-control select2" required>
                                <option value="{{$cotizaciones->d_ciudad_id}}">{{$cotizaciones->d_ciudad_id}}</option>
                                <option value="" >Desde</option>
                                @foreach($salidas as $salida)
                                    <option value="{{$salida->id}}">{{$salida->ciudadnombre}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('salida'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('salida') }}</strong>
                                      </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('llegada') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4">Hasta</label>
                            <div class="col-sm-8">
                            <select name="llegada" required class="form-control select2" required>
                                <option value="{{$cotizaciones->h_ciudad_id}}">{{$cotizaciones->h_ciudad_id}}</option>
                                <option value="" >Hasta</option>
                                @foreach($llegadas as $llegada)
                                    <option value="{{$llegada->id}}">{{$llegada->ciudadnombre}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('llegada'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('llegada') }}</strong>
                                      </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('salida') ? ' has-error' : '' }} has-feedback">
                            <label class="control-label col-sm-4">Fecha de Salida</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="csalida" value="{{$cotizaciones->salida_at}}" placeholder="salida" required>

                            <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('salida'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('salida') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('llegada') ? ' has-error' : '' }} has-feedback">
                            <label class="control-label col-sm-4">Fecha de llegada</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="cllegada" value="{{$cotizaciones->llegada_at}}" placeholder="llegada" required>

                            <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('llegada'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('llegada') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>

                        @if($cotizaciones->ida_vuelta == 1)
                        <div class="text-center">
                            <label>
                                <span class="fa fa-exchange"></span>
                                <input type="checkbox" name="idavuelta" checked>
                                Ida y Vuelta |

                            </label>
                            <label>
                                <span class="fa fa-angle-double-right"></span>
                                <input type="checkbox" name="solovuelta">
                                Solo Ida |
                            </label>
                        </div><br>
                            @else
                            <div class="text-center">
                                <label>
                                    <span class="fa fa-exchange"></span>
                                    <input type="checkbox"  name="idavuelta">
                                    Ida y Vuelta |

                                </label>
                                <label>
                                    <span class="fa fa-angle-double-right"></span>
                                    <input type="checkbox" value="si" name="solovuelta" checked>
                                    Solo Ida |
                                </label>
                            </div><br>
                        @endif

                        <div class="form-group {{ $errors->has('cpasajero') ? ' has-error' : '' }} has-feedback">
                            <label class="control-label col-sm-4">Cantidad de Pasajeros</label>
                            <div class="col-sm-8">
                            <input type="number" class="form-control" name="cpasajero" value="{{$cotizaciones->cantidad_pasajeros}}" placeholder="Cantidad de Pasajeros" required>

                            <span class="fa fa-users form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('cpasajero'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('cpasajero') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('observacion') ? ' has-error' : '' }} has-feedback">
                            <label class="control-label col-sm-4">Observacion</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="observacion" value="{{$cotizaciones->observacion}}" placeholder="Observacion" required>

                            <span class="fa fa-users form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('observacion'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('observacion') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success pull-right">
                                Actualizar <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                            
                    </form>

                </div>

            </div>
            <div class="clearfix"></div>
</div>

@endsection

@section('script')
    <script src="{!! asset('admin-lte/plugins/select2/select2.min.js') !!}"></script>
@endsection