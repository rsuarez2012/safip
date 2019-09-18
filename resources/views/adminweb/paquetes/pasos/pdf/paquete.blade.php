<!DOCTYPE html>
<html style="padding: 0px;margin: 0px">

<head>
  <meta charset="utf-8">
  <link href="{{asset('imagenes/logo.png')}}" rel="shortcut icon" type="image/x-icon" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
  <style>
    body {
      /* background-position: center; */
      background-repeat: no-repeat;
      /* background-size: auto; */
      padding-top: 170px;
      padding-bottom: 150px;
    }

    .table {
      margin-left: 15px;
      margin-right: 15px;
    }
  </style>
  <title>Boleto</title>
</head>

<body class="text-justify" style="background-image: url({{asset('/imagenes/back_pdf_paquetes.jpg')}})">

  <div class="container content-middle">
    <div class="row">
      <div class="col-sm-12 text-center text-danger font-italic">
        <h1>{{$paquete->nombre}}</h1>
        <h2>{{$paquete->dias->count()."D / ".($paquete->dias->count()-1)."N" }}</h2>
      </div>
    </div>

    @if(count($datos['incluidos']) > 0)
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-danger">Incluye :</h4>
        <ul class="mt-1">
          @foreach($datos['incluidos'] as $incluido)
          <li>{{ $incluido }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif @if(count($datos['noincluidos']) > 0)
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-danger">No Incluye :</h4>
        <ul class="mt-1">
          @foreach($datos['noincluidos'] as $noincluido)
          <li>{{ $noincluido }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif

    <div class="row">
      <div class="col-md-12">
        <h4 class="text-danger">Itinerario :</h4>
        <ul class="mt-1">
          @foreach ($paquete->dias as $dia)
          <li class="text-danger">{{$dia->nombre}} :</li>
          <ul>
            <li>{{$dia->descripcion}}</li>
          </ul>
          @endforeach
        </ul>
      </div>
    </div>

    @if(count($datos['llevar']) > 0)
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-danger">Recomendaciones a llevar :</h4>
        <ul class="mt-1">
          @foreach($datos['llevar'] as $llevar)
          <li>{{ $llevar }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif @if(count($datos['importantes']) > 0)
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-danger">Nota Inportante :</h4>
        <ul class="mt-1">
          @foreach($datos['importantes'] as $importante)
          <li>{{ $importante }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif @if(count($datos['politicaReserva']) > 0)
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-danger">Politicas de reserva :</h4>
        <ul class="mt-1">
          @foreach($datos['politicaReserva'] as $pol_res)
          <li>{{ $pol_res }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif @if(count($datos['politicaTarifa']) > 0)
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-danger">Politicas de nuestras tarifas :</h4>
        <ul class="mt-1">
          @foreach($datos['politicaTarifa'] as $pol_tarif)
          <li>{{ $pol_tarif }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif @if(count($datos['fechas']) > 0)
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-danger">Fechas especiales :</h4>
        <ul class="mt-1">
          @foreach($datos['fechas'] as $fecha)
          <li>{{ $fecha }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif @if(count($datos['responsabilidades']) > 0)
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-danger">Responsabilidades :</h4>
        <ul class="mt-1">
          @foreach($datos['responsabilidades'] as $responsabilidad)
          <li>{{ $responsabilidad }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif

  </div>

  @if(count($enlazados) > 0)
  <table class="table table-bordered" style="font-size: 10px;">
    <thead class="bg-danger text-light">
      <tr>
        <th rowspan="2" style="min-width: 200px;">Hoteles</th>
        <th rowspan="2" class="text-center">*</th>
        <th rowspan="2">Categoria</th>
        <th colspan="4">Extranjero</th>
        <th colspan="4">Peruano</th>
        <th colspan="2"></th>
      </tr>
      <tr>
        <th>SWB</th>
        <th>DWB</th>
        <th>TPL</th>
        <th>CHD</th>
        <th>SWB</th>
        <th>DWB</th>
        <th>TPL</th>
        <th>CHD</th>
        <th>Check In</th>
        <th>Check Out</th>
      </tr>
    </thead>
    <tbody style="font-size: 7px;">
      @foreach ($enlazados as $enlazado)
      <tr>
        <td>
          @foreach ($enlazado["hoteles"] as $hotel) {{ $hotel }} @if (!$loop->last) / @endif @endforeach
        </td>
        <td>{{ $enlazado["estrella"] }}</td>
        <td>{{ $enlazado["categoria"] }}</td>
        <td>{{ round($enlazado["e_swb"] * 100) / 100 }}</td>
        <td>{{ round($enlazado["e_dwb"] * 100) / 100 }}</td>
        <td>{{ round($enlazado["e_tpl"] * 100) / 100 }}</td>
        <td>{{ round($enlazado["e_chd"] * 100) / 100 }}</td>
        <td>{{ round($enlazado["p_swb"] * 100) / 100 }}</td>
        <td>{{ round($enlazado["p_dwb"] * 100) / 100 }}</td>
        <td>{{ round($enlazado["p_tpl"] * 100) / 100 }}</td>
        <td>{{ round($enlazado["p_chd"] * 100) / 100 }}</td>
        <td>{{ $enlazado["check_in"] }}</td>
        <td>{{ $enlazado["check_out"] }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif @if(count($itinerario) > 0)
  <table class="table table-bordered" style="margin-top: auto">
    <thead class="bg-head-tabla">
      <tr>
        <th></th>
        <th>Peruano Adulto</th>
        <th>Extranjero Adulto</th>
        <th>Comunidad Adulto</th>
        <th>Niño Peruano</th>
        <th>Niño Extranjero</th>
      </tr>
    </thead>
    <tfoot class="bg-head-tabla">
      <tr>
        <td colspan="1">TOTAL </td>
        <td>{{$itinerario['p_adulto']}}</td>
        <td>{{$itinerario['e_adulto']}}</td>
        <td>{{$itinerario['c_adulto']}}</td>
        <td>{{$itinerario['p_ninio']}}</td>
        <td>{{$itinerario['e_ninio']}}</td>
      </tr>
    </tfoot>
  </table>
  @endif
</body>

</html>