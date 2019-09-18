@extends('paginaexterna.indexslim')

@section('titulo', 'Pagina de Registro')

@section('css')
    <!-------estilos locales en caso de requerirlos van aqui------>
@endsection

@section('script')

    <script type="text/javascript">
        $( function (){
            $("#cliente").hide("slow"); //oculto mediante id
            $("#agencia-viaje").hide("slow"); //muestro mediante id
        });
        $(document).ready(function(){
            $("select[name=type]").change(function() {
                var a =  $(this).val();
                if(a == 2){
                    $(".cliente").show("slow"); //muestro mediante id
                    $(".agencia-viaje").hide("slow" ); //oculto mediante id
                }
                if(a == 3){
                    $(".agencia-viaje").show("slow" ); //muestro mediante id
                    $(".cliente").hide("slow" ); //oculto mediante id
                }
                if(a == 0){
                    $(".cliente").hide("slow" ); //muestro mediante id
                    $(".agencia-viaje").hide("slow" ); //oculto mediante id
                }
            });
        });
    </script>

    <!-------script locales en caso de requerirlos van aqui------>
@endsection

@section ('content')
<div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <h4 align="center">Formulario de Registro</h4>


            <div class="col-md-8">
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
                <br>
                <div class="col-md-8">
                    <select class="form-control" name="type" id="type">
                        <option value="0" >Tipo de Registro</option>
                        <option value="2" >Cliente</option>
                        <option value="3" >Agencia de Viajes</option>
                    </select>
                </div>
            </div>

            <div name="cliente" id="cliente" class="col-md-12 cliente">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('registrar-store') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <br>
                    <div class="col-sm-8 col-sm-offset-2">
                        <input type="hidden" class="form-control" name="t_u" value="2" placeholder="tipo de usuario" >

                        <div class="form-group {{ $errors->has('apellidos') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="apellidos" value=""
                                   placeholder="Apellidos" required="">

                            @if ($errors->has('apellidos'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('apellidos') }}</strong>
                                      </span>
                            @endif
                        </div>


                        <div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="nombres" value="" placeholder="Nombres">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('nombres'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('nombres') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('cedula') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="cedula" value="" placeholder="Cedula"
                                   required="">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('cedula'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('cedula') }}</strong>
                                      </span>
                            @endif
                            @if ($errors->has('cedula'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('cedula') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                            <input type="email" class="form-control" name="email" value="" placeholder="Email">

                            <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                            <input type="password" class="form-control" name="password" value=""
                                   placeholder="Password" required="">

                            <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('confpassword') ? ' has-error' : '' }} has-feedback">
                            <input type="password" class="form-control" name="confpassword" value=""
                                   placeholder="Confirmar Password" required="">

                            <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('confpassword'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('confpassword') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('pais') ? ' has-error' : '' }}">
                            <select name="pais" required class="form-control">
                                <option value="">Selecciona el Pais</option>
                                @foreach($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->paisnombre}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('pais'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('pais') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('ciudad') ? ' has-error' : '' }}">
                            <select name="ciudad" required class="form-control">
                                <option value="">Selecciona la Ciudad</option>
                                @foreach($ciudades as $ciudad)
                                    <option value="{{$ciudad->id}}">{{$ciudad->ciudadnombre}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('ciudad'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('ciudad') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="direccion" value=""
                                   placeholder="Dirección completa" maxlength="255" required="">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('direccion'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('direccion') }}</strong>
                                      </span>
                            @endif
                        </div>


                        <div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }} has-feedback">
                            <input type="number" class="form-control" name="telefono" value=""
                                   placeholder="Telefono de contacto" maxlength="25">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('telefono'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('telefono') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <h4 align="center"><i class="fa fa-file-image-o"></i>Cargar Imagen</h4>

                        <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }} has-feedback">
                            <input type="file" class="form-control" name="image" placeholder="Foto">
                            <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-actions">
                            <button type="submit" id="clientebtn" class="btn btn-success pull-right">
                                Registrar <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            <div name="agencia-viaje" id="agencia-viaje" class="col-md-12 agencia-viaje">
                <form class="form-horizontal" name="av" role="form" method="POST" action="{{ route('registrar-store') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <br>
                    <div class="col-sm-8 col-sm-offset-2">
                        <input type="hidden" class="form-control" name="t_u" value="3" placeholder="tipo de usuario" >

                        <div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="nombres" value="" placeholder="Nombre de Agencia">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('nombres'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('nombres') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('rif') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="rif" value="" placeholder="Rif"
                                   required="">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('rif'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('rif') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                            <input type="email" class="form-control" name="email" value="" placeholder="Email">

                            <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                            <input type="password" class="form-control" name="password" value=""
                                   placeholder="Password" required="">

                            <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('confpassword') ? ' has-error' : '' }} has-feedback">
                            <input type="password" class="form-control" name="confpassword" value=""
                                   placeholder="Confirmar Password" required="">

                            <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('confpassword'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('confpassword') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('pais') ? ' has-error' : '' }}">
                            <select name="pais" required class="form-control">
                                <option value="">Selecciona el Pais</option>
                                @foreach($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->paisnombre}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('pais'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('pais') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('ciudad') ? ' has-error' : '' }}">
                            <select name="ciudad" required class="form-control">
                                <option value="">Selecciona la Ciudad</option>
                                @foreach($ciudades as $ciudad)
                                    <option value="{{$ciudad->id}}">{{$ciudad->ciudadnombre}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('ciudad'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('ciudad') }}</strong>
                                      </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="direccion" value=""
                                   placeholder="Dirección completa" maxlength="255" required="">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('direccion'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('direccion') }}</strong>
                                      </span>
                            @endif
                        </div>


                        <div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="telefono" value=""
                                   placeholder="Telefono de contacto" maxlength="25">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('telefono'))
                                <span class="help-block">
                                          <strong>{{ $errors->first('telefono') }}</strong>
                                      </span>
                            @endif
                        </div>


                        <h4 align="center"><i class="fa fa-file-image-o"></i>Cargar Imagen</h4>

                        <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }} has-feedback">
                            <input type="file" class="form-control" name="image" placeholder="Foto">
                            <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-actions">
                            <button type="submit" id="agencia_viagebtn" class="btn btn-success pull-right">
                                Registrar <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

