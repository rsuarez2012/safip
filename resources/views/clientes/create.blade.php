@extends('layouts.master')

@section('titulo', 'Registrar pasajero')



@section('script')
    <script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>

    <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

@endsection

@section('content')


    <div class="box padding_box1">

        <div id="wrapper">
            <div id="login" class=" form" style="background-color: #FFF; padding: 0 20px; border-radius: 10px;">
                <section class="login_content">
                    <div class="clearfix"></div>

                    <div class="x_content">
                        @if(Session::has('message'))
                            <div class='alert alert-success'>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <p>{!! Session::get('message') !!}</p>
                            </div>
                        @endif
                    </div>
                    <div class="x_content">
                        @if(Session::has('message2'))
                            <div class='alert alert-danger'>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <p>{!! Session::get('message2') !!}</p>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="x_title">
                                <h2  ><i class="fa fa-users"></i> Registrar Pasajero</h2>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">

                            <form class="form-horizontal" role="form" method="POST" action="{{ route('manageCliente-store-A') }}" enctype="multipart/form-data">
                                {!! csrf_field() !!}

                                <div class="form-group {{ $errors->has('empresa') ? ' has-error' : '' }}">
                                    <label class="col-sm-2 control-label">Empresa</label>
                                    <div class="col-sm-10">
                                    <select name="empresa" required class="form-control select2 mayus">
                                        <option value="">Selecciona La Empresa</option>
                                        @foreach($empresas as $empresa)
                                            <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                                        @endforeach

                                    </select>

                                    @if ($errors->has('empresa'))
                                        <span class="help-block">
                                          <strong>{{ $errors->first('empresa') }}</strong>
                                      </span>
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tipo</label>
                                    <div class="col-sm-10">
                                    <select name="tipopasajero" id="tipopasajero" required class="form-control select2 mayus">
                                        <option value="0">Seleccione el Tipo</option>
                                        <option value="Corporativo">CORPORATIVO</option>
                                        <option value="Directo">DIRECTO</option>
                                        <option value="Indirecto">INDIRECTO</option>
                                    </select>
                                    </div>
                                </div>


                                <div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }} has-feedback">
                                <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control mayus" name="nombre" value="" placeholder="Nombre" >

                                    <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                    @if ($errors->has('nombre'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('nombre') }}</strong>
                                  </span>
                                    @endif
                                </div>
                                </div>

                                <div class="form-group {{ $errors->has('apellido') ? ' has-error' : '' }} has-feedback">
                                      <label class="col-sm-2 control-label">Apellido</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control mayus" name="apellido" value="" placeholder="Apellido" >

                                    <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                    @if ($errors->has('apellido'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('apellido') }}</strong>
                                  </span>
                                    @endif
                                </div>
                                </div>

                                <div class="form-group {{ $errors->has('cedula_rif') ? ' has-error' : '' }} has-feedback">
                                      <label class="col-sm-2 control-label">DNI</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control mayus" name="cedula_rif" value="" placeholder="DNI" >

                                    <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                    @if ($errors->has('cedula_rif'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('cedula_rif') }}</strong>
                                  </span>
                                    @endif
                                </div>
                                </div>

                                <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
                                      <label class="col-sm-2 control-label">Direccion</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control mayus" name="direccion" value="" placeholder="Direccion"  maxlength="255">

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
                                    <input type="text" class="form-control mayus" name="telefono" value="" placeholder="Telefono">

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
                                    <input type="email" class="form-control mayus" name="email" value="" placeholder="Email">

                                    <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                                    @endif
                                </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success pull-right">
                                        Registrar <i class="fa fa-arrow-circle-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </section>
            </div>


        </div>
    </div>

@endsection




   
