@extends('layouts.master')

@section('titulo', 'Editor Agencia de Viaje')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-building"></i>Editar Agencia de Viaje</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageAgente-update-A',$agentes->id)}}">
                        {!! csrf_field() !!}

                        <div class="form-group {{ $errors->has('empresa') ? ' has-error' : '' }}">
                            <select name="empresa" required class="form-control">
                                <option value="">Selecciona La Empresa</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('empresa'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('empresa') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('sucursal') ? ' has-error' : '' }}">
                            <select name="sucursal" required class="form-control">
                                <option value="">Selecciona la Sucursal</option>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('sucursal'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('sucursal') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="nombre" value="{{$agentes->nombre}}" placeholder="Nombre" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('nombre') }}</strong>
                                  </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('apellido') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="apellido" value="{{$agentes->apellido}}" placeholder="Apellido" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('apellido'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('apellido') }}</strong>
                                  </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('cedula_rif') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="cedula_rif" value="{{$agentes->cedula_rif}}" placeholder="DNI" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('cedula_rif'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('cedula_rif') }}</strong>
                                  </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="direccion" value="{{$agentes->direccion}}" placeholder="Direccion"  maxlength="255">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('direccion'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('direccion') }}</strong>
                                  </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="telefono" value="{{$agentes->telefono}}" placeholder="Telefono">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('telefono'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('telefono') }}</strong>
                                  </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                            <input type="email" class="form-control" name="email" value="{{$agentes->email}}" placeholder="Email">

                            <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('cargo') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="cargo" value="{{$agentes->cargo}}" placeholder="Cargo">

                            <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('Cargo'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('Cargo') }}</strong>
                                  </span>
                            @endif
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