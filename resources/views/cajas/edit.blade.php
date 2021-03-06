@extends('layouts.master')

@section('titulo', 'Editor de Caja')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-building"></i>Editar Cajas</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageCaja-update-A',$cajas->id)}}">
                        {!! csrf_field() !!}

                        <div class="form-group {{ $errors->has('monto') ? ' has-error' : '' }} has-feedback">
                            <input type="number" class="form-control" name="monto" value="{{$cajas->monto}}" placeholder="Monto" >
                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
                            @if ($errors->has('monto'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('monto') }}</strong>
                                  </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('descripcion') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="descripcion" value="{{$cajas->descripcion}}" placeholder="Descripcion" >
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