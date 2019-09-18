@extends('layouts.master')
@section('titulo', 'Ventas de  Paquetes')
@section('css')
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('content')
@php
	$qt_total = 0;$qt_directa = 0;$qt_agencia = 0;
	$ot_total = 0;$ot_directa = 0;$ot_agencia = 0;
@endphp
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="x_title">
					<h3> <i class="fa fa-money"> </i> Venta de boletos de paquetes <img src="{{asset('imagenes/cargando.gif')}}" hidden id="cargando" alt=""></h3><hr>
				</div>
			</div>
			<div class="box-body">
				<div class="col-xs-6">
					<div class="text-center">
					<label>
						<input type="radio" id="hide"
						name="tventa" onclick="tipoRadio()" value="todos" checked>
						<label for="directa">Ver Todos</label>

						<input type="radio" id="show"
						name="tventa" onclick="tipoRadio()" value="agencia">
						<label for="agencia">Agencia</label>

						<input type="radio" id="hide"
						name="tventa" onclick="tipoRadio()" value="directa">
						<label for="directa">Venta directa</label>
					</label>
					</div>
				</div>
				<div class="col-xs-6">
					<button class="btn btn-warning pull-right" onclick="modalFiltro()">Filtrar <i class="fa fa-filter"></i></button>
				</div>
				<div class="nav-tabs-custom" style="margin-top:60px;">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab"><b>QantuTravel</b></a></li>
						<li><a href="#tab_2" data-toggle="tab"><b>Otro Proveedor</b></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							@if(count($qantu) > 0)
							<table id="paquetes" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Nº File</th>
										<th>Registro</th>
										<th>Nº Cotizacion</th>
										<th>DNI / RUC</th>
										<th>Pasajero</th>
										<th>Agencia</th>
										<th>Agente</th>
										<th>Estado</th>
										<th>A Pagar</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									
									@foreach($qantu as $qt)
										@php
											$qt_total += $qt->a_pagar;
										@endphp
										@if ($qt->qantu->tipo == "Directa")
											@php
												$qt_directa += $qt->a_pagar;
											@endphp
											<tr class="fila-directa">
										@elseif($qt->qantu->tipo == "Agencia")
											<tr class="fila-agencia">
											@php
												$qt_agencia += $qt->a_pagar;
											@endphp		
										@endif
										
										<td>{{$qt->id}}</td>
										<td>{{$qt->created_at}}</td>
										<td>{{$qt->cotizacion_id}}</td>
										<td>{{$qt->cliente->cedula_rif}}</td>
										<td>{{$qt->cliente->nombre}} {{$qt->cliente->apellido}}</td>
										<td>{{$qt->cotizacion->agencia->nombre}}</td>
										<td>{{$qt->vendedor->nombres}}</td>
										<td class="text-center">
											@if($qt->estado == "Cancelado")
											<small value="{{$qt->id}}" style="background-color:#dd4b39;" class="label bg-green">
												@else
												<small value="{{$qt->id}}" style="background-color:#00a65a;"l class="label bg-success">
													@endif	
													{{$qt->estado}}
												</small>	
											</td>
											<td>{{ $qt->a_pagar }}</td>
											<td>
												<button value="{{$qt->id}}" class="btn btn-xs btn-primary abrirBoleto" data-toggle="tooltip" title="Ver"><i class="fa fa-eye" ></i></button>
												<button class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil"></i></button>
												@if (Auth::user()->role == "Administrador")
												<button class="btn btn-xs btn-danger" data-toggle="tooltip" title="Anular"><i class="fa fa-close"></i></button>
												<button onclick="modalFecha({{$qt}})" class="btn btn-xs btn-info" data-toggle="tooltip" title="Cambiar Fecha Registro"><i class="fa fa-calendar"></i></button>
												@endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								@else
								<p>No hay datos que mostrar</p>
								@endif
								<div class="row">
									<div class="col-xs-12 col-sm-4">
										<label>Total Ventas Qantu</label>
										<input value="{{ $qt_total }}" readonly type="number" name="qantu_total" id="qantu_total" class="form-control">
										<input style="display: none" value="{{ $qt_agencia }}" readonly type="number" name="qantu_agencia" id="qantu_agencia" class="form-control">
										<input style="display: none" value="{{ $qt_directa }}" readonly type="number" name="qantu_directa" id="qantu_directa" class="form-control">
									</div>
									<div class="col-xs-12 col-sm-4">
											<label for="">Total Qantu + Otros</label>
											<input type="text" class="form-control" readonly name="total_qt_ot">
										</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_2">
								@if(count($otro) > 0)
								<table id="paquetes" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Nº File</th>
											<th>Registro</th>
											<th>N° Cotizacion</th>
											<th>DNI / RUC</th>
											<th>Pasajero</th>
											<th>Agencia</th>
											<th>Agente</th>
											<th>Estado</th>
											<th>A Pagar</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach($otro as $ot)
										@php
											$ot_total += $ot->a_pagar;
										@endphp
										@if ($ot->otro->tipo == "directa")
											@php
												$ot_directa += $ot->a_pagar;
											@endphp
											<tr class="fila-directa">
										@elseif($ot->otro->tipo == "agencia")
											<tr class="fila-agencia">
											@php
												$ot_agencia += $ot->a_pagar;
											@endphp		
										@endif
										
											<td>{{$ot->id}}</td>
											<td>{{$ot->created_at}}</td>
											<td>{{$ot->cotizacion_id}}</td>
											<td>{{$ot->cliente->cedula_rif}}</td>
											<td>{{$ot->cliente->nombre}} {{$ot->cliente->apellido}}</td>
											<td>{{$ot->cotizacion->agencia->nombre}}</td>
											<td>{{$ot->vendedor->nombres}}</td>
											<td class="text-center">
												@if($ot->estado == "Cancelado")
												<small value="{{$ot->id}}" style="background-color:#dd4b39;" class="label bg-green">
													@else
													<small value="{{$ot->id}}" style="background-color:#00a65a;"l class="label bg-success">
														@endif	
														{{$ot->estado}}
													</small>	
												</td>
												<td>{{ $ot->a_pagar }}</td>
												<td>
													<button value="{{$ot->id}}" class="btn btn-xs btn-primary abrirBoleto" data-toggle="tooltip" title="Ver"><i class="fa fa-eye" ></i></button>
													<button class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil"></i></button>
													@if (Auth::user()->role == "Administrador")
													<button class="btn btn-xs btn-danger" data-toggle="tooltip" title="Anular"><i class="fa fa-close"></i></button>
													<button class="btn btn-xs btn-info" data-toggle="tooltip" title="Cambiar Fecha Registro"><i class="fa fa-calendar"></i></button>
													@endif
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
									@else
									<p>No hay datos que mostrar</p>
									@endif
									<div class="row">
											<div class="col-xs-12 col-sm-4">
												<label>Total Ventas Otros</label>
												<input value="{{ $ot_total }}" readonly type="number" name="otros_total" id="otros_total" class="form-control">
												<input style="display: none" value="{{ $ot_agencia }}" readonly type="number" name="otros_agencia" id="otros_agencia" class="form-control">
												<input style="display: none" value="{{ $ot_directa }}" readonly type="number" name="otros_directa" id="otros_directa" class="form-control">
											</div>
											<div class="col-xs-12 col-sm-4">
												<label for="">Total Qantu + Otros</label>
												<input type="text" class="form-control" readonly name="total_ot_qt">
											</div>	
										</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@include('adminweb.paquetes.ventas.boleto')
		@include('adminweb.paquetes.ventas.fecha')
		@include('adminweb.paquetes.ventas.filtro')
		@endsection
		@section('script')
		<script>
			$(function () {
   			 //Initialize Select2 Elements
    		$(".select2").select2();
    		});
			var APP_URL = {!!json_encode(url('/'))!!};
		</script>
		<script src="{{asset('js/paquetes/ventas_paquetes/index.js')}}"></script>
		@endsection
