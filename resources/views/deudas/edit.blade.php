@extends('layouts.master')

@section('titulo', 'Editor de TDeudas')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-building"></i>Editar Tipo de Deuda</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageDeuda-update-A',$deudas->id)}}">
                        {!! csrf_field() !!}

                        <div class="form-group {{ $errors->has('tipo') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="tipo" value="{{$deudas->tipo_deuda}}" placeholder="Tipo" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('tipo'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('tipo') }}</strong>
                                  </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('descripcion') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="descripcion" value="{{$deudas->descripcion}}" placeholder="Descripcion" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('descripcion'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('descripcion') }}</strong>
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