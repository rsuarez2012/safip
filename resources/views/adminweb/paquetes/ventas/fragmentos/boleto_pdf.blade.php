<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style type="text/css">
		.table td, .table th {
			border-top:0px;
			border-bottom: 1px solid red;
		}
		.table thead th{
			border-top:0px;
			border-bottom: 1px solid red;
		}
		.table{
			border: 2px solid red !important;
			border-radius: 5px !important;
		}
		.text-bold{
			text-transform: uppercase;
			font-weight: bold;
		}
	</style>
	<title>Boleto</title>
</head>
<body>
	<div class="row">
		<div class="col-8 offset-2 mt-5 rounded">
			<table class="table">
				<thead>
					<tr class="text-center">
						<th colspan="2"><h3>Boleto N° {{$boleto->id}}</h3></td>
					</tr>
				</thead>
				<tr>
					<td class="text-bold">Fecha de Registro</td>
					<td>{{$boleto->fecha}}</td>
				</tr>
				<tr>
					<td class="text-bold">Nro Cotizacion</td>
					<td>{{$boleto->cotizacion_id}}</td>
				</tr>
				<tr>
					<td class="text-bold">DNI/RUC</td>
					<td>{{$boleto->cliente->cedula_rif}}</td>
				</tr>
				<tr>
					<td class="text-bold">Pasajero</td>
					<td>{{$boleto->cliente->nombre . " " . $boleto->cliente->apellido}}</td>
				</tr>
				<tr>
					<td class="text-bold">A Pagar</td>
					<td>{{$boleto->a_pagar}}</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>