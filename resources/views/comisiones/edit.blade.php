@extends('layouts.master')

@section('titulo', 'Editar Comision')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-pencil"></i>Editar Comision</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageComision-update-A',$comisiones->id)}}">
                        {!! csrf_field() !!}

                        <div class="form-group {{ $errors->has('laereas') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label">Linea Aerea</label>
                  <div class="col-sm-10">
                            <select name="laerea_id" required class="form-control select2">
                                <option value="{{$comisiones->laereas_id}}">{{$comisiones->laereas->nombre}}</option>
                            </select>

                            @if ($errors->has('laereas'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('laereas') }}</strong>
                                      </span>
                            @endif
                        </div>
                        </div>

                        <div class="form-group {{ $errors->has('consolidadores') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label">Consolidador</label>
                  <div class="col-sm-10">
                            <select name="consolidador_id" required class="form-control select2">
                                <option value="{{$comisiones->consolidadores_id}}">{{$comisiones->consolidadores->nombre}}</option>

                            </select>

                            @if ($errors->has('consolidadores'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('consolidadores') }}</strong>
                                      </span>
                            @endif
                        </div>
                        </div>

                        <div class="form-group {{ $errors->has('comisiones') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Comision</label>
                  <div class="col-sm-10">
                            <input type="number" step="any" class="form-control" name="comision" value="{{$comisiones->comision}}" placeholder="comisiones" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('comisiones'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('comisiones') }}</strong>
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