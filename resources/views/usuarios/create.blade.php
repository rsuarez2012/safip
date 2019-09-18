@extends('layouts.master')

@section('titulo', 'Crear Usuarios')
@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection


@section('script')
<script src={!! asset("js/jquery.min.js")!!}></script>
<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>

<script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>

<script type="text/javascript">
    $(document).ready(function () {

        $(".abrirpermiso").click(function (e) {
            e.preventDefault();
            $(".modalpermiso").fadeIn();

        });
        $(".cerrarpermiso").click(function (e) {
            e.preventDefault();
            $(".modalpermiso").fadeOut(300);

        });

    });
</script>
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
                            <h2><i class="fa fa-user"></i> Registrar Usuario</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST"
                    action="{{ route('manageUsuario-store-A') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}


                    <div class="form-group {{ $errors->has('empresa') ? ' has-error' : '' }}">
                      <label for="inputEmail3" class="col-sm-2 control-label">Empresa</label>

                      <div class="col-sm-10">
                       <select name="empresa_id" required class="form-control select2">
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


          <div class="form-group {{ $errors->has('sucursal') ? ' has-error' : '' }}">
              <label for="inputEmail3" class="col-sm-2 control-label">Sucursal</label>

              <div class="col-sm-10">
                  <select name="sucursal" required class="form-control select2">
                    <option value="">Selecciona la Sucursal</option>
                    @foreach($sucursales as $sucursal)
                    <option value="{{$sucursal->id}}">{{$sucursal->sucursal_nombre}}</option>
                    @endforeach

                </select>

                @if ($errors->has('sucursal'))
                <span class="help-block">
                  <strong>{{ $errors->first('sucursal') }}</strong>
              </span>
              @endif
          </div>
      </div>


      <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
          <label for="inputEmail3" class="col-sm-2 control-label">Rol</label>

          <div class="col-sm-10">
           <select name="role" required class="form-control select2">
            <option value="">Selecciona el Rol</option>
            @foreach($roles as $rol)
            <option value="{{$rol->name}}">{{$rol->name}}</option>
            @endforeach
        </select>

        @if ($errors->has('role'))
        <span class="help-block">
          <strong>{{ $errors->first('role') }}</strong>
      </span>
      @endif
  </div>
</div>


<div class="form-group {{ $errors->has('apellidos') ? ' has-error' : '' }} has-feedback">
  <label for="inputEmail3" class="col-sm-2 control-label">Apellidos</label>

  <div class="col-sm-10">
     <input type="text" class="form-control" name="apellidos" value=""
     placeholder="Apellidos" required="">

     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

     @if ($errors->has('apellidos'))
     <span class="help-block">
      <strong>{{ $errors->first('apellidos') }}</strong>
  </span>
  @endif
</div>
</div>

<div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }} has-feedback">
  <label for="inputEmail3" class="col-sm-2 control-label">Nombres</label>

  <div class="col-sm-10">
    <input type="text" class="form-control" name="nombres" value="" placeholder="Nombres">

    <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

    @if ($errors->has('nombres'))
    <span class="help-block">
      <strong>{{ $errors->first('nombres') }}</strong>
  </span>
  @endif
</div>
</div>

<div class="form-group {{ $errors->has('cedula') ? ' has-error' : '' }} has-feedback">
  <label for="inputEmail3" class="col-sm-2 control-label">DNI/RUC</label>

  <div class="col-sm-10">
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
</div>


<div class="form-group  {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

  <div class="col-sm-10">
     <input type="email" class="form-control" name="email" value="" placeholder="Email">

     <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

     @if ($errors->has('email'))
     <span class="help-block">
      <strong>{{ $errors->first('email') }}</strong>
  </span>
  @endif
</div>
</div>
<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
  <label for="inputEmail3" class="col-sm-2 control-label">Contraseña</label>

  <div class="col-sm-10">
     <input type="password" class="form-control" name="password" value=""
     placeholder="Password" required="">

     <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

     @if ($errors->has('password'))
     <span class="help-block">
      <strong>{{ $errors->first('password') }}</strong>
  </span>
  @endif
</div>
</div>

<div class="form-group {{ $errors->has('confpassword') ? ' has-error' : '' }} has-feedback">
  <label for="inputEmail3" class="col-sm-2 control-label">Confirmar Contraseña</label>

  <div class="col-sm-10">
     <input type="password" class="form-control" name="confpassword" value=""
     placeholder="Confirmar Password" required="">

     <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

     @if ($errors->has('confpassword'))
     <span class="help-block">
      <strong>{{ $errors->first('confpassword') }}</strong>
  </span>
  @endif
</div>
</div>
<div class="form-group {{ $errors->has('pais') ? ' has-error' : '' }}">
  <label for="inputEmail3" class="col-sm-2 control-label">Pais</label>

  <div class="col-sm-10">
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
</div>
<div class="form-group {{ $errors->has('ciudad') ? ' has-error' : '' }}">
  <label for="inputEmail3" class="col-sm-2 control-label">Ciudad</label>

  <div class="col-sm-10">
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
</div>

<div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
  <label for="inputEmail3" class="col-sm-2 control-label">Direccion</label>

  <div class="col-sm-10">
   <input type="text" class="form-control" name="direccion" value=""
   placeholder="Dirección completa" maxlength="255" required="">

   <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

   @if ($errors->has('direccion'))
   <span class="help-block">
      <strong>{{ $errors->first('direccion') }}</strong>
  </span>
  @endif
</div>
</div>      


<div class="form-group {{ $errors->has('telefono') ? ' has-error' : '' }} has-feedback">
  <label for="inputEmail3" class="col-sm-2 control-label">Telefono</label>

  <div class="col-sm-10">
     <input type="text" class="form-control" name="telefono" value=""
     placeholder="Telefono de contacto" maxlength="25">

     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

     @if ($errors->has('telefono'))
     <span class="help-block">
      <strong>{{ $errors->first('telefono') }}</strong>
  </span>
  @endif
</div>
</div>      

<div class="form-group  {{ $errors->has('active') ? ' has-error' : '' }}">
    <label for="inputEmail3" class="col-sm-2 control-label">Estatus</label>

  <div class="col-sm-10">
     <select name="active" required class="form-control" required>
        <option value="0">Estatus</option>
        <option value="1">Habilitado</option>
        <option value="0">Deshabilitado</option>
    </select>

    @if ($errors->has('active'))
    <span class="help-block">
      <strong>{{ $errors->first('active') }}</strong>
  </span>
  @endif
  </div>
</div>       

<div class="form-group {{ $errors->has('image') ? ' has-error' : '' }} has-feedback">
  <label for="inputEmail3" class="col-sm-2 control-label"><i class="fa fa-file-image-o"></i> Imagen</label>

  <div class="col-sm-10">
<input type="file" class="form-control" name="image" placeholder="Foto">
    <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>

    @if ($errors->has('image'))
    <span class="help-block">
        <strong>{{ $errors->first('image') }}</strong>
    </span>
    @endif
  </div>
</div>       




<div class="modal-lg modal modalpermiso">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close cerrarpermiso" data-dismiss="modal"
            aria-label="Close"><span aria-hidden="true">×</span></button>
            <h5 class="modal-title" id="myModalLabel"><h4><i class="fa fa-key"></i> Permisos
            </h4></h5>
        </div>
        <div class="modal-body">

            @section('script')
            <script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>
            <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
            <link rel="stylesheet"
            href="{{ asset("admin-lte/dist/css/style_child.css")}}">
            @endsection

            <div>
                <div id="wrapper">
                    <div id="login" class=" form"
                    style="background-color: #FFF;; border-radius: 10px;">
                    <div class="clearfix"></div>
                    <div class="row mods-h42">
                        <div class="col-sm-4"><H4>Asignar permisos</H4></div>
                        <div class="col-sm-8">
                            <div class="blokselect2">
                                <ul>
                                    <li><input type="checkbox" value="1"
                                     name="vboletos"> VENTA DE BOLETOS
                                 </li>
                                 <li><input type="checkbox" value="1"
                                     name="mnomina"> MANEJO DE NOMINA
                                 </li>
                                 <li><input type="checkbox" value="1" name="cclave">
                                    CAMBIO DE CLAVES
                                </li>
                                <li><input type="checkbox" value="1" name="pconso">
                                    PAGO A CONSOLIDADORES
                                </li>
                                <li><input type="checkbox" value="1"
                                 name="deuaviajes"> DEUDA AGENCIA DE
                                 VIAJES
                             </li>
                             <li><input type="checkbox" value="1" name="opb">
                                OPERACIONES BANCARIAS
                            </li>
                            <li><input type="checkbox" value="1"
                             name="ncppagar"> NUEVAS CUENTAS POR PAGAR
                         </li>
                         <li><input type="checkbox" value="1"
                             name="ancppagar"> ADMINISTRAR CUENTAS POR
                             PAGAR
                         </li>
                         <li><input type="checkbox" value="1"
                             name="ncpcobrar"> NUEVAS CUENTAS POR
                             COBRAR
                         </li>
                         <li><input type="checkbox" value="1"
                             name="ancpcobrar"> ADMINISTRAR CUENTAS
                             POR COBRARR
                         </li>
                         <li><input type="checkbox" value="1" name="boletos">
                            BOLETOS
                        </li>
                        <li>CONFIGURACIÓN</li>
                        <li><input type="checkbox" value="1" name="empresa">EMPRESA
                        </li>
                        <li><input type="checkbox" value="1"
                         name="consolidadores">CONSOLIDADORES
                     </li>
                     <li><input type="checkbox" value="1"
                         name="usuarios">USUARIOS
                     </li>
                     <li><input type="checkbox" value="1" name="gastos">GASTOS
                     </li>
                     <li><input type="checkbox" value="1" name="deudas">DEUDAS
                     </li>
                     <li><input type="checkbox" value="1" name="banco">BANCO
                     </li>
                     <li><input type="checkbox" value="1"
                         name="caja_chica">CAJA CHICA
                     </li>
                     <li><input type="checkbox" value="1" name="igv">IGV
                     </li>
                     <li><input type="checkbox" value="1" name="agentes">AGENTES
                     </li>
                     <li><input type="checkbox" value="1"
                         name="agencias_viajes">AGENCIAS DE VIAJE
                     </li>
                     <li><input type="checkbox" value="1"
                         name="lineas_aereas">LENAS AEREAS
                     </li>
                     <li><input type="checkbox" value="1"
                         name="incentivos">INCENTIVOS
                     </li>
                     <li><input type="checkbox" value="1" name="paises">PAISES
                     </li>
                     <li><input type="checkbox" value="1"
                         name="ciudades">CIUDADES
                     </li>
                     <li><input type="checkbox" value="1"
                         name="pasajeros">PASAJEROS
                     </li>
                     <li><input type="checkbox" value="1"
                         name="comision">COMISIÓN
                     </li>
                     <li>
                        <ul>
                            <li> PAQUETES</li>
                            <li>
                                <input type="checkbox" value="1"
                                name="poperadores"> Operadores
                            </li>
                            <li>
                                <input type="checkbox" value="1"
                                name="pdestinos"> Destinos
                            </li>
                            <li>
                                <input type="checkbox" value="1"
                                name="photeles"> Hoteles
                            </li>
                            <li>
                                <input type="checkbox" value="1"
                                name="prestaurantes"> Restaurantes
                            </li>
                            <li>
                                <input type="checkbox" value="1"
                                name="ppaquetes"> Paquetes
                            </li>
                            <li><input type="checkbox" value="1"
                             name="pcotizacion"> Cotizaciones Paquetes
                         </li>
                         <li><input type="checkbox" value="1"
                             name="solicitudes"> Solicitudes de Agencias
                         </li>
                         <li><input type="checkbox" value="1"
                            name="reservaciones"> Solicitudes de Reservaciones
                        </li>
                        <li><input type="checkbox" value="1"
                            name="usuarios_web">Administrar Usuarios Pagina web
                        </li>
                        <li><input type="checkbox" value="1"
                            name="validar_boletos">Validar Boletos
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
</div>

</div>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-warning cerrarpermiso"
    data-dismiss="modal">Asignar
</button>
</div>
</div>
</div>


<div class="form-actions">
    <button type="" style="padding: 7px;" class="btn btn-warning btn-xs btn abrirpermiso"
    data-toggle="tooltip" data-placement="left" title="" data-original-title="">
    <i class="fa fas fa-key" aria-hidden="true"></i> Asignar permisos
</button>
<button type="submit" class="btn btn-success pull-right">
    Registrar <i class="fa fa-arrow-circle-right"></i>
</button>
</div>


</form>

</div>
<div class="clearfix"></div>

</section>
</div>


</div>
</div>

@endsection





