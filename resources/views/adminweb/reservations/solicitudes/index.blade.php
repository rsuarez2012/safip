@extends('layouts.master')
@section('titulo', 'Solicitudes De Reservacion')

@section('content')

	<div class="container-fluid" id="reservaciones">
		<div class="row">
			<div class="col-md-12  box">
				<div class="box-header">
					<h2><i class="fa fa-cubes"></i> Solicitudes de Reservación <img style="display: none" src="{{asset('imagenes/cargando.gif')}}"  id="cargando"></h2>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="solicitudes">
							<thead  style="background-color: #dd4b39;color: #fff">
								<tr>
									<th>Código de reserva</th>
									<th>Codigo de Paquete</th>
									<th>Paquete Reservado</th>
									<th>Usuario</th>
									<th>Cant de Pax</th>
									<th>Total a Pagar</th>
									<th>Estado</th>
									<th>Posible Fecha de Salida</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="solicitud in solicitudes">
									<td>@{{ solicitud.code }}</td>
									<td>@{{ solicitud.paquete.codigo }}</td>
									<td>@{{ solicitud.paquete.nombre }}</td>
									<td>@{{ solicitud.user.name }} @{{ solicitud.user.lastname }}</td>
									<td>@{{ solicitud.tikets.length }}</td>
									<td>@{{ solicitud.total }}</td>
									<td>
										<label class="label bg-primary" v-show="solicitud.status == 'pending'">En Espera</label>
										<label class="label bg-green" v-show="solicitud.status == 'approved'">Aprobado</label>
										<label style="background-color: #dd4b39;color: #fff" class="label" v-show="solicitud.status == 'rejected'">Rechazado</label> 
									</td>
									<td>@{{ solicitud.posible_fecha_sal }}</td>
									<td class="text-center">
										<button @click="open_view_solicitud(solicitud)" class="btn btn-info btn-xs"  title="Ver Reservación" data-toggle="tooltip"><i class="fa fa-eye"></i></button>
										<button @click.prevent="action('eliminar', 'warning', 'btn-danger', solicitud.id)" class="btn btn-danger btn-xs"  title="Eliminar Reservación" data-toggle="tooltip"><i class="fa fa-close"></i></button>
									</td>
                  				</tr>
              				</tbody>
          				</table>
      				</div>
  				</div>
			</div>
		</div>
		@include('adminweb.reservations.solicitudes.modal_solicitud')
		@include('adminweb.reservations.solicitudes.modal_codigo_referencia')
	</div>
@push('scripts')
	<script src="{{ asset('js/reservations/solicitudes.js') }}"></script>
@endpush
@endsection