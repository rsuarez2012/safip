@extends('layouts.master')

@section('titulo', 'Editor de Sucursal')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-building"></i>Editar Sucursal</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageSucursal-update-A',$sucursales->id)}}">
                        {!! csrf_field() !!}


                            <input type="hidden" class="form-control" name="empresa" value="{{$sucursales->empresas_id}}" placeholder="ID Empresa" >


                        <div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="nombre" value="{{$sucursales->nombre}}" placeholder="Nombre" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('rif') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="rif" value="{{$sucursales->rif}}" placeholder="RUC" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('rif'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rif') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="direccion" value="{{$sucursales->direccion}}" placeholder="Direccion"  maxlength="255">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('direccion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('direccion') }}</strong>
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