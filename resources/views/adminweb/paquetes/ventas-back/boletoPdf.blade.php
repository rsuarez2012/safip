<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link href="{{asset('imagenes/logo.png')}}" rel="shortcut icon" type="image/x-icon" />
  <title>Boleto</title>
  <style>
    .main{
      width: 80%;
      margin: auto;
      border: solid 2px  #dd4b39;
      border-radius: 10px;
      padding: 10px;
    }
    table{
      margin: auto;
    }
    h3{
      border-bottom: solid 2px #dd4b39;
    }
    .uno{
      border-right: solid 2px #dd4b39;
    }  
    td{
      border-bottom: solid 2px #dd4b39;
      width: 250px;
    }
  </style>
</head>

<body>
  <div class="main">
    <h3>Boleto Paquete  File Nº {{$boleto->id}}</h3>
    <table>
      <tr>
        <td class="uno">Fecha de Creacion </td>
        <td>{{$boleto->created_at}}</td>
      </tr>
      <tr>
        <td class="uno">Numero de Cotizacion </td>
        <td>{{$boleto->cotizacion_id}}</td>
      </tr>
      <tr>
        <td class="uno">Nº Cliente </td>
        <td>{{$boleto->cliente->id}}</td>
      </tr>
      <tr>
        <td class="uno">Nombre Cliente </td>
        <td>{{$boleto->cliente->nombre}} {{$boleto->cliente->apellido}}</td>
      </tr>
      <tr>
        <td class="uno">Agencia de Viajes </td>
        <td>{{$boleto->cotizacion->agencia->nombre}}</td>
      </tr>
      <tr>
        <td class="uno">Vendedor </td>
        <td>{{$boleto->vendedor->nombres}}</td>
      </tr>
      <tr>
        <td class="uno">Hoteles</td>
        <td>
           @foreach($listado as $fila)
              {{$fila->hotel->nombre}} / 
           @endforeach
        </td>
      </tr>
      <tr>
        <td class="uno">Neto </td>
        <td>{{$boleto->costo_neto}}</td>
      </tr>
      <tr>
        <td class="uno">Comision </td>
        <td>{{$boleto->qantu->comision}}</td>
      </tr>
      <tr>
        <td class="uno">10%</td>
        <td>{{$boleto->qantu->porcentaje}}</td>
      </tr>
      <tr>
        <td class="uno">Incentivo</td>
        <td>{{$boleto->incentivo}}</td>
      </tr>
      <tr>
        <td class="uno">Total</td>
        <td>{{$boleto->total_venta}}</td>
      </tr>
      <tr>
        <td class="uno">A Pagar</td>
        <td>{{$boleto->a_pagar}}</td>
      </tr>
    </table>
  </div>
</body>
</html>



