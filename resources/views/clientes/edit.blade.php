@extends('layouts.master')

@section('titulo', 'Editar pasajero')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-users"></i>Editar Pasajero</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageCliente-update-A',$clientes->id)}}">
                        {!! csrf_field() !!}
                        <div class="form-group {{ $errors->has('empresa') ? ' has-error' : '' }}">
                            <label class="col-sm-4 control-label">Empresa</label>
                            <div class="col-sm-6">
                                <select name="empresa" required class="form-control select2">
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
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tipo de Documento</label>
                            <div class="col-sm-6">
                                <select name="tipo_documento" id="tipo_documento" required class="form-control">
                                    @if($clientes->tipo_documento == 'dni')
                                    <option value="dni" selected>DNI</option>
                                    <option value="pasaporte">Pasaporte</option>
                                    @else
                                    <option value="dni">DNI</option>
                                    <option value="pasaporte" selected>Pasaporte</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tipo</label>
                            <div class="col-sm-6">
                                <select name="tipopasajero" id="tipopasajero" required class="form-control select2">
                                    <option value="Corporativo">Corporativo</option>
                                    <option value="Directo">Directo</option>
                                    <option value="Indirecto">Indirecto</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-4 control-label">Nombre</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="nombre" value="{{$clientes->nombre}}" placeholder="Nombre" >
                                <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('apellido') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-4 control-label">Apellido</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="apellido" value="{{$clientes->apellido}}" placeholder="Apellido" >
                                <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
                                @if ($errors->has('apellido'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('apellido') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('cedula_rif') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-4 control-label">DNI</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="cedula_rif" value="{{$clientes->cedula_rif}}" placeholder="DNI" >
                                <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
                                @if ($errors->has('cedula_rif'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cedula_rif') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-4 control-label">Direccion</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="direccion" value="{{$clientes->direccion}}" placeholder="Direccion"  maxlength="255">
                                <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
                                @if ($errors->has('direccion'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-4 control-label">Telefono</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="telefono" value="{{$clientes->telefono}}" placeholder="Telefono">
                                <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
                                @if ($errors->has('telefono'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="email" value="{{$clientes->email}}" placeholder="Email">
                                <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-actions">
                            <a href="{{ route('manageCliente-A') }}" class="btn btn-success pull-left">
                                <i class="fa fa-arrow-circle-left"></i> Volver 
                            </a>
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