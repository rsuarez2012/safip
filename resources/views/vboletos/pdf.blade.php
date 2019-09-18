<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Boleto</title>
</head>
<body>
<div><label for="">Fecha de Creacion</label>{{$data->created_at}}</div>
<div><label for="">Numero de Ctoizacion</label>{{$data->venta_boleto_id}}</div>
<div><label for="">Codigo</label>{{$data->codigo}}</div>
<div><label for="">Cliente</label>{{$data->cliente_id}}</div>
<div><label for="">Nombre</label>{{$data->nombre_cliente}}</div>
<div><label for="">Linea Aerea</label>{{$data->laereas->nombre}}</div>
<div><label for="">Ruta</label>{{$data->ruta}}</div>
<div><label for="">Consolidador</label>{{$data->consolidadores->nombre}}</div>
<div><label for="">Agencia de Viajes</label>{{$data->aviajes}}</div>
<div><label for="">Usuario</label>{{$data->users->nombres}} {{$data->users->apellidos}}</div>
<div><label for="">Neto</label>{{$data->neto}}</div>
<div><label for="">Tarifa</label>{{$data->tarifa}}</div>
<div><label for=""Comision de Agencia</label>{{$data->comision_agencia}}</div>
<div><label for="">Igv</label>{{$data->igv}}</div>
<div><label for="">Total</label>{{$data->total}}</div>
<div><label for="">Pago a Cosolidador</label>{{$data->pago_consolidador}}</div>
<div><label for="">Tarifa + Fee</label>{{$data->tarifa_fee}}</div>
<div><label for="">Uilidad</label>{{$data->utilidad}}</div>
<div><label for="">Incentivo</label>{{$data->incentivo}}</div>
<div><label for="">Estatus de Deuda</label> @if ($data->pagado== "1")
        <span class="label label-success">Pagado</span>
    @else
        <span class="label label-danger">Aun sin pagar</span></div>
@endif
</body>
</html>