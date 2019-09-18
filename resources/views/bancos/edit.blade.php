@extends('layouts.master')

@section('titulo', 'Editar Banco')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-pencil"></i>Editar Banco</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageBanco-update-A',$bancos->id)}}">
                        {!! csrf_field() !!}


                        <div class="form-group {{ $errors->has('banco') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Banco</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="banco" value="{{$bancos->banco}}" placeholder="Banco" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('banco'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('banco') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('nrocuenta') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Numero de Cuenta</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="nrocuenta" value="{{$bancos->nrocuenta}}" placeholder="Numero de cuenta" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('nrocuenta'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('nrocuenta') }}</strong>
                                  </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('monto') ? ' has-error' : '' }} has-feedback">
                            <label class="col-sm-2 control-label">Monto</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="monto" value="{{$bancos->monto}}" placeholder="Monto" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('monto'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('monto') }}</strong>
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