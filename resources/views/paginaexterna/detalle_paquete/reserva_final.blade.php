@extends('paginaexterna.index')

@section('titulo', 'Detalle del Pquete')

@section('css')

@endsection

@section('script')


@endsection


@section ('content')
	<table class="table" style="width: 50%; margin: 30px auto;">
		<thead>
			<tr>
				<th style="background-color: #c90e14;color: #fff;">Solicitud de Reserva Realizada</th>
			</tr>
			<tr>
				<th style="background-color: #c90e14;color: #fff;">Numero de Operacion {{$nuevo->id}}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="background-color: #c90e14;color: #fff;"><strong>Resumen de Solicitud</strong></td>
			</tr>
			<tr>
				<td>Paquete : {{$paquete->nombre}}</td>
			</tr>
			<tr>
				<td>Destino : {{$paquete->destino}}</td>
			</tr>
			<tr>
				<td>Categoria : {{$paquete->categoria}}</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td style="background-color: #c90e14;color: #fff;">Incluye</td>
			</tr>
			<tr>
				<td>
					<ul>
						@foreach($informacion as $fila)
							<li>{{$fila->descripcion}}</li>
						@endforeach
					</ul>
				</td>
			</tr>
			<tr>
				<td><a href="{{Route('myacount')}}" class="btn btn-block" style="background-color: #c90e14;color: #fff;">Ver Mis Reservas</a></td>
			</tr>
		</tfoot>
	</table>
@endsection
