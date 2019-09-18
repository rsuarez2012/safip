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
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

<!-- Modal -->

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registrarme</h4>
        <button type="button" class="close cerrar" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">Usuarios Pasajeros</a></li>
          <li><a data-toggle="tab" href="#menu1">Agencias de Viajes</a></li>
      </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
                <div class="col-md-12">
                        <h3 class="form-section">Datos del usuario</h3>

                            <div name="cliente" id="cliente" class="cliente">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('registrar-store') }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
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

                                            <div class="form-group {{ $errors->has('cedula') ? ' has-error' : '' }} has-feedback">
                                                <input type="text" class="form-control" name="cedula" value="" placeholder="Cedula"
                                                       required="">

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

                                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                                                <input type="password" class="form-control" name="password" value=""
                                                       placeholder="Password" required="">

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
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

                                            <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
                                                <input type="text" class="form-control" name="direccion" value=""
                                                       placeholder="Dirección completa" maxlength="255" required="">

                                                @if ($errors->has('direccion'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('direccion') }}</strong>
                                      </span>
                                                @endif
                                            </div>


                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }} has-feedback">
                                                <input type="text" class="form-control" name="nombres" value="" placeholder="Nombres">

                                                @if ($errors->has('nombres'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('nombres') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                                                <input type="email" class="form-control" name="email" value="" placeholder="Email">

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('confpassword') ? ' has-error' : '' }} has-feedback">
                                                <input type="password" class="form-control" name="confpassword" value=""
                                                       placeholder="Confirmar Password" required="">

                                                @if ($errors->has('confpassword'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('confpassword') }}</strong>
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

                                            <div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }} has-feedback">
                                                {!! NoCaptcha::renderJs() !!}
                                                {!! NoCaptcha::display() !!}

                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                      </span>
                                                @endif
                                            </div>
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
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <div class="col-md-12">
                            <h3 class="form-section">Datos de la agencia de viajes</h3>

                            <div name="cliente" id="cliente" class="cliente">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('registrar-store') }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="hidden" class="form-control" name="t_u" value="3" placeholder="tipo de usuario" >

                                            <div class="form-group {{ $errors->has('razon_social') ? ' has-error' : '' }} has-feedback">
                                                <input type="text" class="form-control" name="razon_social" value=""
                                                       placeholder="Razón Social" required="">

                                                @if ($errors->has('nombres'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('nombres') }}</strong>
                                      </span>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }} has-feedback">
                                                <input type="text" class="form-control" name="nombres" value=""
                                                       placeholder="Nombre Comercial" required="">

                                                @if ($errors->has('nombres'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('nombres') }}</strong>
                                      </span>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('cedula') ? ' has-error' : '' }} has-feedback">
                                                <input type="text" class="form-control" name="cedula" value="" placeholder="RUC/Rif"
                                                       required="">

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

                                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                                                <input type="password" class="form-control" name="password" value=""
                                                       placeholder="Password" required="">

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
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

                                            <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
                                                <input type="text" class="form-control" name="direccion" value=""
                                                       placeholder="Dirección completa" maxlength="255" required="">

                                                @if ($errors->has('direccion'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('direccion') }}</strong>
                                      </span>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('representante_legal') ? ' has-error' : '' }} has-feedback">
                                                <input type="text" class="form-control" name="representante_legal" value=""
                                                       placeholder="Representante Legal" maxlength="255" required="">

                                                @if ($errors->has('representante_legal'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('representante_legal') }}</strong>
                                      </span>
                                                @endif
                                            </div>


                                        </div>
                                        <div class="col-sm-6">

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

                                            <div class="form-group {{ $errors->has('distrito') ? ' has-error' : '' }} has-feedback">
                                                <input type="text" class="form-control" name="distrito" value=""
                                                       placeholder="Distrito" required="">

                                                @if ($errors->has('distrito'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('distrito') }}</strong>
                                      </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                                                <input type="email" class="form-control" name="email" value="" placeholder="Email">

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('confpassword') ? ' has-error' : '' }} has-feedback">
                                                <input type="password" class="form-control" name="confpassword" value=""
                                                       placeholder="Confirmar Password" required="">

                                                @if ($errors->has('confpassword'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('confpassword') }}</strong>
                                      </span>
                                                @endif
                                            </div>
                                            <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group {{ $errors->has('aniversario') ? ' has-error' : '' }} has-feedback">
                                                    <input title="Aniversario" type="date" class="form-control" name="aniversario" value=""
                                                           placeholder="aniversario" required="">
                                                    @if ($errors->has('aniversario'))
                                                        <span class="help-block">
                                          <strong>{{ $errors->first('aniversario') }}</strong>
                                      </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group {{ $errors->has('sitio_web') ? ' has-error' : '' }} has-feedback">
                                                    <input type="text" class="form-control" name="sitio_web" value=""
                                                           placeholder="Sitio Web" required="">

                                                    @if ($errors->has('sitio_web'))
                                                        <span class="help-block">
                                          <strong>{{ $errors->first('sitio_web') }}</strong>
                                      </span>
                                                    @endif
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }} has-feedback">
                                                        <input type="number" class="form-control" name="telefono" value=""
                                                               placeholder="Telefono de Usuario" required="">
                                                        @if ($errors->has('telefono'))
                                                            <span class="help-block">
                                          <strong>{{ $errors->first('telefono') }}</strong>
                                      </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group {{ $errors->has('telefono_corporativo') ? ' has-error' : '' }} has-feedback">
                                                        <input type="number" class="form-control" name="telefono_corporativo" value=""
                                                               placeholder="Telefono Corporativo" required="">

                                                        @if ($errors->has('telefono_corporativo'))
                                                            <span class="help-block">
                                          <strong>{{ $errors->first('telefono_corporativo') }}</strong>
                                      </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }} has-feedback">
                                                {!! NoCaptcha::renderJs() !!}
                                                {!! NoCaptcha::display() !!}

                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="help-block">
                                          <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                      </span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit"  class="btn btn-success pull-right">
                                            Registrar <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>






            </div>
        </div>

    </div>

  </div>
</div>


<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <h3 class="text-center">
                <i class="fa fa-sign-in" aria-hidden="true"></i>
                Iniciar Sesion
        </h3>
        <button type="button" class="close cerrar2" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
               <div class="login-box-body">
        <div class="form-actions"></div>

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

        <form class="login-fomr" action="{{ route('login') }}" method="POST">
            {!! csrf_field() !!}

            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Correo">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Contraseña">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
           <div class="row">
                <div style="padding-left: 16px;" class="col-xs-5">
                   <!-- <div class="checkbox icheck">
                        <input type="checkbox" class="flat" id="Remember Me" value="1">
                        <label for="Remember Me">
                            Recordarme
                        </label>
                    </div>-->
                </div>
                <div style="text-align: right;" class="col-xs-7">
                    <a href="{{ route('restaurar')}}">He olvidado mi clave</a><br>
                   <!--  <a href="{{ route('registrar')}}" class="text-center">Registrate como nuevo miembro</a> -->
                </div>

             
            </div>
            <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar</button>
                    </div>
            </div>
        </form>
        

        <!--<div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                Google+</a>
        </div>
        <!-- /.social-auth-links -->


    </div>
      </div>
    </div>

  </div>

</div>

<div id="myModal3" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center">
                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                    Iniciar Sesion
                </h3>
                <button type="button" class="close cerrar2" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="login-box-body">
                    <div class="form-actions"></div>

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

                    <form class="login-fomr" action="{{ route('login3') }}" method="POST">
                        {!! csrf_field() !!}

                        <div class="form-group has-feedback">
                            <input type="email" name="email" class="form-control" placeholder="Correo">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" name="password" class="form-control" placeholder="Contraseña">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div style="padding-left: 16px;" class="col-xs-5">
                           
                            </div>
                            <div style="text-align: right;" class="col-xs-7">
                                <a href="{{ route('restaurar')}}">He olvidado mi clave</a><br>
                            <!--  <a href="{{ route('registrar')}}" class="text-center">Registrate como nuevo miembro</a> -->
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>