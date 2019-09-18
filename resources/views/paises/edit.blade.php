@extends('layouts.master')

@section('titulo', 'Editar Pais')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-pencil"></i>Editar Pais</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('managePais-update-A',$paises->id)}}">
                        {!! csrf_field() !!}

                        <div class="form-group {{ $errors->has('PaisCodigo') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Codigo de Pais</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="PaisCodigo" value="{{$paises->PaisCodigo}}" placeholder="Codigo del Pais" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('PaisCodigo'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('PaisCodigo') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('paisnombre') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Nombre del Pais</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="paisnombre" value="{{$paises->paisnombre}}" placeholder="Nombre del Pais" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('paisnombre'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('paisnombre') }}</strong>
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