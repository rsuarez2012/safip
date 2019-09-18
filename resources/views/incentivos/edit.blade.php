@extends('layouts.master')

@section('titulo', 'Editor Incentivo')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-building"></i>Editar Incentivo</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageIncentivo-update-A',$incentivos->id)}}">
                        {!! csrf_field() !!}
                        

                        <div class="form-group {{ $errors->has('primera_meta') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Primera Meta</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="primera_meta" value="{{$incentivos->primera_meta}}" placeholder="Primera Meta" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('primera_meta'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('primera_meta') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('primer_incentivo') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Primer Incentivo</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="primer_incentivo" value="{{$incentivos->primer_incentivo}}" placeholder="Primer Incentivo" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('primer_incentivo'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('primer_incentivo') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('segunda_meta') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Segunda Meta</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="segunda_meta" value="{{$incentivos->segunda_meta}}" placeholder="Segunda Meta" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('segunda_meta'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('segunda_meta') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('segundo_incentivo') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Segundo Incentivo</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="segundo_incentivo" value="{{$incentivos->segundo_incentivo}}" placeholder="Segundo Incentivo"  >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('segundo_incentivo'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('segundo_incentivo') }}</strong>
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