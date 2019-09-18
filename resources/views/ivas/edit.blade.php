@extends('layouts.master')

@section('titulo', 'Editar  Iva')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-pencil"></i>Editar Iva</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageIva-update-A',$ivas->id)}}">
                        {!! csrf_field() !!}


                        <div class="form-group {{ $errors->has('iva') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Modificar Iva</label>
                            <div class="col-sm-10">
                            <input type="number" class="form-control" name="iva" value="{{$ivas->iva}}" placeholder="Iva" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('iva'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('iva') }}</strong>
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