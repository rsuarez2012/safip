@extends('layouts.master')

@section('content')
	<div class="container text-center">
		<div class="page-header">
			<h1>
				<i class="fa fa-shopping-cart">
					<h2>CATEGORÍAS</h2> <a href="{{ route('manageCategory-create-A') }}" class="btn btn-warning"><i class="fa fa-plus-circle"></i> Categoría</a>
				</i>	
			</h1>
		</div>
		<div class="page">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center">Editar</th>
							<th class="text-center">Eliminar</th>
							<th class="text-center">Nombre</th>
							<th class="text-center">Descripción</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($categories as $category)
							<tr>
								<td>
									<a href="{{ route('manageCategory-edit-A', $category->id) }}" class="btn btn-primary">
										<i class="fa fa-pencil-square"></i>
									</a>
								</td>
								<td>
									<a href="{{ route('manageCategory-destroy-A', $category->id) }}" class="btn btn-danger">
										<i class="fa fa-trash"></i>
									</a>
								</td>
								<td>{{ $category->name }}</td>
								<td>{{ $category->description }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop