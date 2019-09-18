@extends('layouts.master')
@section('titulo', 'Usuarios Pagina Web')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12  box">
				<div class="box-header">
					<h2><i class="fa fa-users"></i> Usuarios Pagina Web <img style="display: none" src="{{asset('imagenes/cargando.gif')}}"  id="cargando"></h2>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="usuarios">
							<thead  style="background-color: #dd4b39;color: #fff">
								<tr>
									<th>NOMBRE</th>
                                    <th>APELLIDO</th>
                                    <th>DNI</th>
                                    <th>EMAIL</th>
                                    <th>DIRECCION</th>
                                    <th>CANT DE RESERVAS</th>
                                    <th>FECHA DE REGISTRO</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->lastname }}</td>
                                        <td>{{ $user->dni }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address}}</td>
                                        <td>{{ count($user->reservations) }}</td>
                                        <td>{{ date("Y-m-d",strtotime($user->created_at)) }}</td>
                                    </tr>
                                @endforeach
              				</tbody>
          				</table>
      				</div>
  				</div>
			</div>
		</div>
	</div>
@push('scripts')
<script>
    $(function () {
        $('#usuarios').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
        });
    });
</script>
@endpush
@endsection