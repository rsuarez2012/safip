@extends('layouts.master')

@section('titulo', 'Editar  Usuario')
@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('css')
<link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
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
		$("select[name='role'] > option").removeAttr("selected");
		$("select[name='role'] > option[value='{!! $usuarios->role !!}'").attr("selected",true);	
});
</script>
@endsection
@section('content')
<div class="box padding_box1">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2><i class="fa fa-user"></i> Editar Usuario</h2>
			<hr>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="col-sm-8 col-sm-offset-2">
				<form class="form-horizontal" role="form" method="POST"
				action="{{route('manageUsuario-update-A',$usuarios->id)}}"
				enctype="multipart/form-data">
				{!! csrf_field() !!}

				<div class="form-group {{ $errors->has('empresa') ? ' has-error' : '' }}">
					 <label  class="col-sm-2 control-label">Empresa</label>
					 <div class="col-sm-10">
					<select name="empresa_id" required class="form-control select2">
						<option value="">Selecciona La Empresa</option>
						@foreach($empresas as $empresa)
						<option value="{{$empresa->id}}" @if($empresa->id == $empresa->id) selected @endif>{{$empresa->nombre}}</option>
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
					 <label  class="col-sm-2 control-label">Sucursal</label>
					 <div class="col-sm-10">
					<select name="sucursal" required class="form-control select2">
						<option value="">Selecciona la Sucursal</option>
						@foreach($sucursales as $sucursal)
						<option value="{{$sucursal->id}}" @if($sucursal->id == $sucursal->id) selected @endif>{{$sucursal->sucursal_nombre}}</option>
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
					<label class="col-sm-2 control-label" >Apellidos</label>
					<div class="col-sm-10">
					<input type="text" class="form-control" name="apellidos"
					value="{{$usuarios->apellidos}}" placeholder="Apellidos del Cliente">

					<span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

					@if ($errors->has('apellidos'))
					<span class="help-block">
						<strong>{{ $errors->first('apellidos') }}</strong>
					</span>
					@endif
					</div>
				</div>
				<div class="form-group {{ $errors->has('nombres') ? ' has-error' : '' }} has-feedback">
					<label class="col-sm-2 control-label">Nombres</label>
					<div class="col-sm-10">
					<input type="text" class="form-control" name="nombres"
					value="{{$usuarios->nombres}}" placeholder="Nombres del Cliente">

					<span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

					@if ($errors->has('nombres'))
					<span class="help-block">
						<strong>{{ $errors->first('nombres') }}</strong>
					</span>
					@endif
					</div>
				</div>

				<div class="form-group {{ $errors->has('cedula') ? ' has-error' : '' }} has-feedback">
					<label class="col-sm-2 control-label">DNI/RUC</label>
					<div class="col-sm-10">
					<input type="text" class="form-control" name="cedula" value="{{$usuarios->cedula}}"
					placeholder="Cedula">

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
				<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
					<input type="email" class="form-control" name="email" value="{{$usuarios->email}}"
					placeholder="Email">

					<span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

					@if ($errors->has('email'))
					<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
					@endif
					</div>
				</div>

				<div class="form-group {{ $errors->has('pais') ? ' has-error' : '' }}">
					<label class="col-sm-2 control-label">Pais</label>
					<div class="col-sm-10">
					<select name="pais" required class="form-control">
						<option value="">Selecciona el Pais</option>
						@foreach($paises as $pais)
						<option value="{{$pais->id}}" @if($pais->id == $pais->id) selected @endif>{{$pais->paisnombre}}</option>
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
					<label class="col-sm-2 control-label">Ciudad</label>
					<div class="col-sm-10">
					<select name="ciudad" required class="form-control">
						<option value="">Selecciona la Ciudad</option>
						@foreach($ciudades as $ciudad)
						<option value="{{$ciudad->id}}" @if($ciudad->id == $ciudad->id) selected @endif>{{$ciudad->ciudadnombre}}</option>
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
					<label class="col-sm-2 control-label">Direccion</label>
					<div class="col-sm-10">
					<input type="text" class="form-control" name="direccion"
					value="{{$usuarios->direccion}}" placeholder="Dirección completa"
					maxlength="255">

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
					<input type="text" class="form-control" name="telefono"
					value="{{$usuarios->telefono}}" placeholder="Telefono de contacto"
					maxlength="25">

					<span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

					@if ($errors->has('telefono'))
					<span class="help-block">
						<strong>{{ $errors->first('telefono') }}</strong>
					</span>
					@endif
					</div>
				</div>

			

				<div class="form-group {{ $errors->has('image') ? ' has-error' : '' }} has-feedback">
					<label class="col-sm-2 control-label"><i class="fa fa-file-image-o"></i> Imagen</label>
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

				<div class="form-actions">
					<button type="" style="padding: 7px;"
					class="btn btn-warning btn-xs btn abrirpermiso" data-toggle="tooltip"
					data-placement="left" title="" data-original-title="">
					<i class="fa fas fa-key" aria-hidden="true"></i> Ver y editar permisos
				</button>
				<button type="submit" class="btn btn-success pull-right">
					Actualizar <i class="fa fa-arrow-circle-right"></i>
				</button>
			</div>


			<div class="modal-lg modal modalpermiso">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close cerrarpermiso" data-dismiss="modal"
						aria-label="Close"><span aria-hidden="true">×</span></button>
						<h5 class="modal-title" id="myModalLabel"><h4><i class="fa fa-key"></i>
						Permisos </h4></h5>
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

											<ul>@if($usuarios->vboletos == 1)
												<li><input type="checkbox" value="1"
													name="vboletos" checked> VENTA DE
													BOLETOS
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="vboletos"> VENTA DE BOLETOS
												</li>
												@endif
												@if($usuarios->nomina == 1)
												<li><input type="checkbox" value="1"
													name="mnomina" checked> MANEJO DE NOMINA
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="mnomina"> MANEJO DE NOMINA
												</li>
												@endif
												@if($usuarios->cclave == 1)
												<li><input type="checkbox" value="1"
													name="cclave" checked> CAMBIO DE
													CLAVES
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="cclave"> CAMBIO DE CLAVES
												</li>
												@endif
												@if($usuarios->pconso == 1)
												<li><input type="checkbox" value="1"
													name="pconso" checked> PAGO A
													CONSOLIDADORES
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="pconso"> PAGO A
													CONSOLIDADORES
												</li>
												@endif
												@if($usuarios->deuaviajes == 1)
												<li><input type="checkbox" value="1"
													name="deuaviajes" checked> DEUDA
													AGENCIA DE VIAJES
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="deuaviajes"> DEUDA AGENCIA
													DE VIAJES
												</li>
												@endif
												@if($usuarios->opb == 1)
												<li><input type="checkbox" value="1"
													name="opb" checked> OPERACIONES
													BANCARIAS
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="opb"> OPERACIONES BANCARIAS
												</li>
												@endif
												@if($usuarios->ncppagar == 1)
												<li><input type="checkbox" value="1"
													name="ncppagar" checked> NUEVAS
													CUENTAS POR PAGAR
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="ncppagar"> NUEVAS CUENTAS
													POR PAGAR
												</li>
												@endif
												@if($usuarios->ancppagar == 1)
												<li><input type="checkbox" value="1"
													name="ancppagar" checked>
													ADMINISTRAR CUENTAS POR PAGAR
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="ancppagar"> ADMINISTRAR
													CUENTAS POR PAGAR
												</li>
												@endif
												@if($usuarios->ncpcobrar == 1)
												<li><input type="checkbox" value="1"
													name="ncpcobrar" checked> NUEVAS
													CUENTAS POR COBRAR
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="ncpcobrar"> NUEVAS CUENTAS
													POR COBRAR
												</li>
												@endif
												@if($usuarios->ancpcobrar == 1)
												<li><input type="checkbox" value="1"
													name="ancpcobrar" checked>
													ADMINISTRAR CUENTAS POR COBRARR
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="ancpcobrar"> ADMINISTRAR
													CUENTAS POR COBRARR
												</li>
												@endif
												@if($usuarios->boletos == 1)
												<li><input type="checkbox" value="1"
													name="boletos" checked> BOLETOS
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="boletos"> BOLETOS
												</li>
												@endif
												<li>CONFIGURACIÓN</li>
												@if($usuarios->empresa == 1)
												<li><input type="checkbox" value="1"
													name="empresa" checked>EMPRESA
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="empresa">EMPRESA
												</li>
												@endif
												@if($usuarios->consolidadores == 1)
												<li><input type="checkbox" value="1"
													name="consolidadores" checked>CONSOLIDADORES
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="consolidadores">CONSOLIDADORES
												</li>
												@endif
												@if($usuarios->usuarios == 1)
												<li><input type="checkbox" value="1"
													name="usuarios" checked>USUARIOS
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="usuarios">USUARIOS
												</li>
												@endif
												@if($usuarios->gastos == 1)
												<li><input type="checkbox" value="1"
													name="gastos" checked>GASTOS
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="gastos">GASTOS
												</li>
												@endif
												@if($usuarios->deudas == 1)
												<li><input type="checkbox" value="1"
													name="deudas" checked>DEUDAS
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="deudas">DEUDAS
												</li>
												@endif
												@if($usuarios->banco == 1)
												<li><input type="checkbox" value="1"
													name="banco" checked>BANCO
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="banco">BANCO
												</li>
												@endif
												@if($usuarios->caja_chica == 1)
												<li><input type="checkbox" value="1"
													name="caja_chica" checked>CAJA
													CHICA
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="caja_chica">CAJA CHICA
												</li>
												@endif
												@if($usuarios->igv == 1)
												<li><input type="checkbox" value="1"
													name="igv" checked>IGV
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="igv">IGV
												</li>
												@endif
												@if($usuarios->agentes == 1)
												<li><input type="checkbox" value="1"
													name="agentes" checked>AGENTES
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="agentes">AGENTES
												</li>
												@endif
												@if($usuarios->agencias_viajes == 1)
												<li><input type="checkbox" value="1"
													name="agencias_viajes" checked>AGENCIAS
													DE VIAJE
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="agencias_viajes">AGENCIAS
													DE VIAJE
												</li>
												@endif
												@if($usuarios->lineas_aereas == 1)
												<li><input type="checkbox" value="1"
													name="lineas_aereas" checked>LINEAS
													AEREAS
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="lineas_aereas">LINEAS
													AEREAS
												</li>
												@endif

												@if($usuarios->incentivos == 1)
												<li><input type="checkbox" value="1"
													name="incentivos" checked>INCENTIVOS
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="incentivos">INCENTIVOS
												</li>
												@endif
												@if($usuarios->paises == 1)
												<li><input type="checkbox" value="1"
													name="paises" checked>PAISES
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="paises">PAISES
												</li>
												@endif
												@if($usuarios->ciudades == 1)
												<li><input type="checkbox" value="1"
													name="ciudades" checked>CIUDADES
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="ciudades">CIUDADES
												</li>
												@endif
												@if($usuarios->pasajeros == 1)
												<li><input type="checkbox" value="1"
													name="pasajeros" checked>PASAJEROS
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="pasajeros">PASAJEROS
												</li>
												@endif

												@if($usuarios->comision == 1)
												<li><input type="checkbox" value="1"
													name="comision" checked>COMISIÓN
												</li>
												@else
												<li><input type="checkbox" value="1"
													name="comision">COMISIÓN
												</li>
												@endif
												<li>
													<ul>
														<li> PAQUETES</li>
														@if($usuarios->poperadores == 1)
														<li><input type="checkbox" value="1"
															name="poperadores" checked>Operadores
														</li>
														@else
														<li><input type="checkbox" value="1"
															name="poperadores">Operadores
														</li>
														@endif
														@if($usuarios->pdestinos == 1)
														<li><input type="checkbox" value="1"
															name="pdestinos" checked>Destinos
														</li>
														@else
														<li><input type="checkbox" value="1"
															name="pdestinos">Destinos
														</li>
														@endif
														@if($usuarios->ppaquetes == 1)
														<li><input type="checkbox" value="1"
															name="ppaquetes" checked>Paquetes
														</li>
														@else
														<li><input type="checkbox" value="1"
															name="ppaquetes">Paquetes
														</li>
														@endif
														@if($usuarios->photeles == 1)
														<li><input type="checkbox" value="1"
															name="photeles" checked>Hoteles
														</li>
														@else
														<li><input type="checkbox" value="1"
															name="photeles">Hoteles
														</li>
														@endif
														@if($usuarios->prestaurantes == 1)
														<li><input type="checkbox" value="1"
															name="prestaurantes" checked>Restaurantes
														</li>
														@else
														<li><input type="checkbox" value="1"
															name="prestaurantes">Restaurantes
														</li>
														@endif
														@if($usuarios->pcotizacion == 1)
														<li><input type="checkbox" value="1"
															name="pcotizacion" checked>Cotizacion Paquetes
														</li>
														@else
														<li><input type="checkbox" value="1"
															name="pcotizacion">Cotizacion Paquete
														</li>
														@endif
														@if($usuarios->solicitudes == 1)
														<li><input type="checkbox" value="1"
															name="solicitudes" checked>Solicitudes de Agencias
														</li>
														@else
														<li><input type="checkbox" value="1"
															name="solicitudes">Solicitudes de Agencias
														</li>
														@endif
														@if($usuarios->reservaciones == 1)
														<li><input type="checkbox" value="1"
															name="reservaciones" checked>Solicitudes de Reservaciones
														</li>
														@else
														<li><input type="checkbox" value="1"
															name="reservaciones">Solicitudes de Reservaciones
														</li>
														@endif
														@if($usuarios->validar_boletos == 1)
														<li><input type="checkbox" value="1"
															name="validar_boletos" checked>Validar Boletos
														</li>
														@else
														<li><input type="checkbox" value="1"
															name="validar_boletos">Validar Boletos
														</li>
														@endif
														@if($usuarios->usuarios_web == 1)
														<li><input type="checkbox" value="1"
															name="usuarios_web" checked>Administrar Usuarios Pagina web
														</li>
														@else
														<li><input type="checkbox" value="1"
															name="usuarios_web">Administrar Usuarios Pagina web
														</li>
														@endif
														
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
					data-dismiss="modal">Guardar cambios
				</button>
			</div>
		</div>
	</div>
</form>

</div>
</div>
</div>
</div>
</div>
</div>


@endsection

@section('script')
<script src="{!! asset('admin-lte/plugins/select2/select2.min.js') !!}"></script>

@endsection