@extends('layouts.master')

@section('titulo', 'Editor Ciudad')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-pencil"></i>Editar Ciudad</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageCiudad-update-A',$ciudades->id)}}">
                        {!! csrf_field() !!}

                        <div class="form-group {{ $errors->has('ciudadnombre') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Nombre de la Ciudad</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="ciudadnombre" value="{{$ciudades->ciudadnombre}}" placeholder="Nombre de la Ciudad" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('ciudadnombre'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('ciudadnombre') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('paiscodigo') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label">Asignar Pais</label>
                            <div class="col-sm-10">
                            <select name="paiscodigo" required class="form-control select2">
                                <option value="">Asignar Pais</option>
                                @foreach($paiscodigo as $paisco)
                                    <option value="{{$paisco->PaisCodigo}}">{{$paisco->PaisCodigo}}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('paiscodigo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('paiscodigo') }}</strong>
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