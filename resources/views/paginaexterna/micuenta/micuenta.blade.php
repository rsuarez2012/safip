@extends('paginaexterna.index')

@section('titulo', 'Pagina de Bienvenida')
@section('script')
<script type="text/javascript">
    $(function () {
        $('#misreservas').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
    });

    $(function () {
        $('#misreservastotales').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
    });
</script>
@endsection
@section('css')

@endsection

@section('content')
<div class="clearfix"></div>
<div class="contenido2 contenidos-custom">
    <div class="col-sm-12"></div>
    <h3 class="seccion-titulos">Mi cuenta</h3>
    <ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#mp">Mi perfil</a></li>
        <li class="active"><a data-toggle="tab" href="#mr">Mis reservas</a></li>
        <li><a data-toggle="tab" href="#cp">Confirmación de pago</a></li>
    </ul>

    <div class="tab-content">
        <div id="mp" class="tab-pane fade">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('actualizar-store') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <h3 class="form-section2">Edición de perfil</h3>
                <br>
                <div class="pull-left col-sm-3 image image-user">
                    <img src="{{asset ('uploads/usuarios')}}/{{$usuarios->imagen}}" class="img-circle" alt="User Image">
                    <div class="custom-file-input2">
                        <input type="file" name="image" class="custom-file-input"/>
                        <div class="edit-i"><i class="fa fa-edit "></i>Editar Imagen</div>
                    </div>
                    <h3 style="text-align: center;margin-top: 8%;" class="form-section2">{{$usuarios->nombres}} {{$usuarios->apellidos}}</h3>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        @if(Auth::User()->type_user == 3 )
                        <h3 class="form-section2">Datos de la Agencia de Viajes</h3>
                        @else
                        <h3 class="form-section2">Datos de usuario</h3>
                        @endif
                        <br>
                    </div>
                    <div class="col-sm-6">
                        <input type="hidden" class="form-control" name="t_u" value="2" placeholder="tipo de usuario" >
                        @if(Auth::User()->type_user == 3 )

                        <div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }} has-feedback">
                            <input type="text" class="form-control" name="nombres" value="{{$usuarios->nombres}}" placeholder="Nombre de Agencia de Viaje">

                            @if ($errors->has('nombres'))
                            <span class="help-block">
                              <strong>{{ $errors->first('nombres') }}</strong>
                          </span>
                          @endif
                      </div>

                      @else
                      <div class="form-group {{ $errors->has('apellidos') ? ' has-error' : '' }} has-feedback">
                        <input type="text" class="form-control" name="apellidos" value="{{$usuarios->apellidos}}"
                        placeholder="Apellidos" required="">

                        @if ($errors->has('apellidos'))
                        <span class="help-block">
                          <strong>{{ $errors->first('apellidos') }}</strong>
                      </span>
                      @endif
                  </div>
                  @endif

                  @if(Auth::User()->type_user == 3 )
                  <div class="form-group {{ $errors->has('cedula') ? ' has-error' : '' }} has-feedback">
                    <input type="text" class="form-control" name="cedula" value="{{$usuarios->cedula}}" placeholder="RIF"
                    required="">

                    @if ($errors->has('cedula'))
                    <span class="help-block">
                      <strong>{{ $errors->first('cedula') }}</strong>
                  </span>
                  @endif

              </div>
              @else
              <div class="form-group {{ $errors->has('cedula') ? ' has-error' : '' }} has-feedback">
                <input type="text" class="form-control" name="cedula" value="{{$usuarios->cedula}}" placeholder="Cedula"
                required="">

                @if ($errors->has('cedula'))
                <span class="help-block">
                  <strong>{{ $errors->first('cedula') }}</strong>
              </span>
              @endif
          </div>

          @endif


          <div class="form-group {{ $errors->has('pais') ? ' has-error' : '' }}">
            <select name="pais" required class="form-control">
                <option value="{{$usuarios->pais_id}}">{{$usuarios->pais->paisnombre}}</option>
                <option value="">Selecciona un País</option>
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
        <input type="text" class="form-control" name="direccion" value="{{$usuarios->direccion}}"
        placeholder="Dirección completa" maxlength="255" required="">

        @if ($errors->has('direccion'))
        <span class="help-block">
          <strong>{{ $errors->first('direccion') }}</strong>
      </span>
      @endif
  </div>


</div>
<div class="col-sm-6">
    @if(Auth::User()->type_user == 3 )

    @else
    <div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }} has-feedback">
        <input type="text" class="form-control" name="nombres" value="{{$usuarios->nombres}}" placeholder="Nombres">

        @if ($errors->has('nombres'))
        <span class="help-block">
          <strong>{{ $errors->first('nombres') }}</strong>
      </span>
      @endif
  </div>
  @endif
  <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
    <input type="email" class="form-control" name="email" value="{{$usuarios->email}}" placeholder="Email" readonly>

    @if ($errors->has('email'))
    <span class="help-block">
      <strong>{{ $errors->first('email') }}</strong>
  </span>
  @endif
</div>
<div class="form-group {{ $errors->has('ciudad') ? ' has-error' : '' }}">
    <select name="ciudad" required class="form-control">
        <option value="{{$usuarios->ciudad_id}}">{{$usuarios->ciudad->ciudadnombre}}</option>
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
<div class="col-sm-12"><br></div>
<div class="col-sm-12">
    <h3 class="form-section2">Cambio de contraseña</h3>
    <br>
</div>
<div class="col-sm-12">
    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
        <input type="password" class="form-control" name="oldpassword" value=""
        placeholder="Contraseña actual" >

        @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>
</div>
<div class="col-sm-12">
    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
        <input type="password" class="form-control" name="password" value=""
        placeholder="Nueva contraseña" >

        @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>
</div>
<div class="col-sm-12">
    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
        <input type="password" class="form-control" name="confpassword" value=""
        placeholder="Confirmar nueva contraseña">

        @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>
</div>
</div>
<div style="text-align: right;" class="col-sm-12">
    <div class="form-actions">
        <button type="submit" class="btn btn-success">
            Guardar <i class="fa fa-arrow-circle-right"></i>
        </button>
    </div>
</div>
</form>
</div>
<div id="mr" class="tab-pane in active" >
    <div class="table-responsive">
        <table class="table" id="misreservastotales" >
            <thead>
                <tr>
                    <th>Reserva</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($reservas as $reserva)
                <tr>
                    <td>#{{$reserva->id}}</td>
                    <td>{{date("Y-m-d",strtotime($reserva->created_at))}}</td>
                    <td>
                        @if($reserva->estado==0)
                         Pendiente
                        @else
                         Confirmado
                        @endif 
                    </td>
                    <td>
                        <a class="btn btn-warning btn-xs" href="" data-toggle="tooltip" data-placement="left" title="Ver">
                            <i class="fa fa-eye fa-lg"></i>
                        </a>
                        <a class="btn btn-warning btn-xs" href="" data-toggle="tooltip" data-placement="left" title="Confirmación de Pago">
                            <i class="fa fa-pencil fa-lg"></i>
                        </a>

                        <a class="btn btn-danger btn-xs" href="" onclick="" data-toggle="tooltip" data-placement="left" title="Cancelar">
                            <i class="fa fa-trash fa-lg"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>


    </div>
</div>
<div id="mc" class="tab-pane">
    3
</div>
<div id="cp" class="tab-pane">
   <div class="form-group">
     <input class="form-control" type="text" placeholder="Numero de Operacion">
   </div>
   <br>
   <div class="form-group">
     <input class="form-control" type="text" placeholder="Fecha">
   </div>
   <br>
   <div class="form-group">
     <input class="form-control" type="text" placeholder="Nombre">
   </div>
   <br>
   <div class="form-group">
     <input class="form-control" type="text" placeholder="Apellido">
   </div>
   <br>
   <div class="form-group">
     <input class="form-control" type="text" placeholder="Ruc">
   </div>
</div>
</div>
</div>
@stop