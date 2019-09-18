@extends('layouts.master')
@section('content')
	<div class="container text-center">
		<div class="page-header">
			<h1>
				<i class="fa fa-shopping-cart"></i>
				<h2>CATEGORÍAS</h2> <small>[Editar categoría {{ $category->name }}]</small>
			</h1>
		</div>
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<div class="page">
					<form class="form-horizontal" role="form" method="POST" action="{{ route('manageCategory-update-A', $category->id) }}" enctype="multipart/form-data">
						{!! csrf_field() !!}

						<div class="form-group">
							<label for="name">Nombre:</label>
							<input type="text" name="name" value="{{$category->name}}" class="form-control" placeholder="Ingresa el nombre...">
						</div>
						<div class="form-group">
							<label for="description">Descripcion:</label>
							<textarea type="text" name="description" value="" class="form-control" placeholder="Descripcion"> {{$category->description}}</textarea>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Guardar</button>
							<a href="{{ route('manageCategory-A') }}" class="btn btn-warning">Regresar</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop