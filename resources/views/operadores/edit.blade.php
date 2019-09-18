@extends('layouts.master')

@section('titulo', 'Editar Operador')

@section('css')
<link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/css/bootstrap-tagsinput.css') }}">
<style>
    .bootstrap-tagsinput{
        width: 100%;
        border-radius: 0px;
        border-color: #d2d6de;
      }
    </style>
@endsection

@section('content')
<div class="box padding_box1">

    <div class="x_title">
        <h2><i class="fa fa-building"></i>Editar Operador</h2>
        <hr>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="col-sm-8 col-sm-offset-2">
            <form class="form-horizontal" role="form" method="POST" action="{{route('manageOperador-update-A',$operador->id)}}">
                {!! csrf_field() !!}

                <div class="form-group {{ $errors->has('empresa') ? ' has-error' : '' }}">
                    <label class="col-sm-2 control-label">Empresa</label>
                    <div class="col-sm-10">
                        <select name="empresa" required class="form-control select2">
                            <option value="">Selecciona La Empresa</option>
                            @foreach($empresas as $empresa)
                            <option selected="" value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                            @endforeach

                        </select>

                        @if ($errors->has('empresa'))
                        <span class="help-block">
                            <strong>{{ $errors->first('empresa') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }} has-feedback">
                    <label class="col-sm-2 control-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" value="{{$operador->nombre}}" placeholder="Nombre">

                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                        @if ($errors->has('nombre'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('rif') ? ' has-error' : '' }} has-feedback">
                    <label class="col-sm-2 control-label">RUC</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rif" value="{{$operador->rif}}" placeholder="RUC">

                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                        @if ($errors->has('rif'))
                        <span class="help-block">
                            <strong>{{ $errors->first('rif') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
                    <label class="col-sm-2 control-label">Direccion</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="direccion" value="{{$operador->direccion}}"
                            placeholder="Direccion" maxlength="255">

                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                        @if ($errors->has('direccion'))
                        <span class="help-block">
                            <strong>{{ $errors->first('direccion') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }} has-feedback">
                    <label class="col-sm-2 control-label">Telefono</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telefono" value="{{$operador->telefono}}"
                            placeholder="Telefono">

                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                        @if ($errors->has('telefono'))
                        <span class="help-block">
                            <strong>{{ $errors->first('telefono') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" value="{{$emails}}" data-role="tagsinput"
                            placeholder="Email">
                    </div>
                </div>

                <div class="form-group {{ $errors->has('web') ? ' has-error' : '' }} has-feedback">
                    <label class="col-sm-2 control-label">Web Empresarial</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="web" value="{{$operador->web}}" placeholder="Web Empresarial">

                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                        @if ($errors->has('web'))
                        <span class="help-block">
                            <strong>{{ $errors->first('web') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tipo de Operador</label>
                    <div class="col-sm-10">
                        <select name="tipo" id="" class="form-control select2">
                            <option value="">Seleccione Tipo de Operador</option>
                            @foreach($tipos as $tipo)
                            @if($tipo->id == $operador->pagina_categoria_operador_id)
                            <option value="{{$tipo->id}}" selected="">{{$tipo->nombre}}</option>
                            @else
                            <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Seleccione un Destino</label>
                    <div class="col-sm-10">
                        <select name="destino" id="" class="form-control select2">
                            <option value="">Seleccione el destino del Operador</option>
                            @foreach($destinos as $destino)
                            @if($destino->id == $operador->detino_id)
                            <option value="{{$destino->id}}" selected="">{{$destino->nombre}}</option>
                            @else
                            <option value="{{$destino->id}}">{{$destino->nombre}}</option>
                            @endif
                            @endforeach
                        </select>
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
<script src="{{ asset('/js/bootstrap-tagsinput.js') }}"></script>
<script>
    $("input[name='email']").tagsinput();
</script>
@endsection