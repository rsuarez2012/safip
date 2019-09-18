@extends('layouts.master')

@section('content')
	<div class="container text-center  box">
		<div class="page-header">
			<h1>
				<i class="fa fa-shopping-cart">
					Usuarios Web
				</i>	
			</h1>
		</div>
		<div class="page">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center">Activar</th>
							<th class="text-center">Eliminar</th>
							<th class="text-center">Nombre</th>
							<th class="text-center">Correo</th>
                            <th class="text-center">Ruc</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
							<tr>
								<td>
									
                                    @if($user->active == 1 )
                                        <a title="Desabilitar Usuario" href="{{ route('manageUser-status-A', $user->id) }}" class="btn btn-danger">
                                        <i class="fa fa-pencil-square"></i>
                                    </a>
                                        @endif
                                    @if($user->active == 0 )
                                        <a title="Habilitar Usuario" href="{{ route('manageUser-status-A', $user->id) }}" class="btn btn-warning">
                                            <i class="fa fa-pencil-square"></i>
                                        </a>
                                    @endif
								</td>
								<td>
									<a href="{{ route('manageUser-destroy-A', $user->id) }}" class="btn btn-danger">
										<i class="fa fa-trash"></i>
									</a>
								</td>
								<td>{{ $user->nombres}}</td>
								<td>{{ $user->email}}</td>
                                <td>{{ $user->cedula}}</td>

							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop