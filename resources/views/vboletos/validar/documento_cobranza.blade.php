<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Documento de cobranza</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
  crossorigin="anonymous">
</head>
<style type="text/css">
body{
  font-size: .7em
  padding:10px !important;
}
.border-document{
  border:2px solid #676767 !important;
  border-top:2px solid #676767 !important; 
  padding: 3px;
}
</style>
<body class="border-document">
  <table class="table">
    <tr>
      <td>
        <strong>QANTU TRAVEL SOCIEDAD ANONIMA CERRADA – QANTU TRAVEL</strong>
        <br>
        AV. ALFREDO MENDIOLA 3621- URB. PANAMERICANA NORTE  
        <br>
        LOS OLIVOS – LIMA – LIMA
        <br>
        TELEFONO: 6776615 - 7463164
        <br>
        CELULAR:  
      </td>
      <td class="border-document">
        <strong>DOCUMENTO DE COBRANZA</strong>
        <br>
        RUC: 20551016049
        <br>
        QT - {{$correlativo+1}}
        <br>
        DIA MES AÑO
        <br>
        {{date("d-m-Y")}}
      </td>
    </tr>
  </table> 
  <table class="table table-bordered">
    <tr class="border-document">
      <td>SEÑORES:
        <ul>
          @foreach($boletos as $boleto)
            <li>{{$boleto->nombre_cliente}}</li>  
          @endforeach
        </ul>
      </td>
      <td>DOCUMENTO:
        <ul>
          @foreach($boletos as $boleto)
            <li>{{$boleto->cliente_id}}</li>  
          @endforeach
        </ul>
      </td>
    </tr>
    <tr class="border-document">
      <td>DIRECCION: 
        <ul>
          @foreach($boletos as $boleto)
            <li>{{$boleto->cliente->direccion}}</li>  
          @endforeach
        </ul>
      </td>
      <td>TELEFONO:
        <ul>
          @foreach($boletos as $boleto)
            <li>{{$boleto->cliente->telefono}}</li>  
          @endforeach
        </ul>
      </td>
    </tr>
    <tr class="border-document">
      <td colspan="2">OBSERVACION: {{$cotizacion->first()->observacion}}</td>
    </tr>
  </table>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>CANTIDAD</th>
        <th>CODIGO</th>
        <th>DESCRIPCION</th>
        <th>VALOR UNITARIO</th>
      </tr>
    </thead>
    <tr class="border-document">
      <td>{{$boletos->count()}}</td>
      <td>{{$boletos->first()->codigo}}</td>
      <td>Por la venta de boleto aereo</td>
      <td>{{$total}}</td>
    </tr>
  </table>
  <table class="table table-bordered">
    <tr>
      <td>
        <p class="mt-2">IMPORTANTES:</p>
        <p style='white-space: pre-wrap;'>{{$texto}}</p>
        <p class="mt-2">COUNTER: {{$boletos->first()->agentes_id}}</p>
      </td>
      <td>
        <table class="table table-bordered">
          <tr>
            <td>A CUENTA</td>
            <td>{{$pagado}}</td>
          </tr>
          <tr>
            <td>PENDIENTE</td>
            <td>{{$total - $pagado}}</td>
          </tr>
          <tr>
            <td>TOTAL</td>
            <td>{{$total}}</td>
          </tr>
          <tr>
            <td>PRECIO SOLES</td>
            <td>
              {{$soles}}
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>
  <table class="table mt-5">
    <tr>
      <td class="text-center">
        __________________________________
        <br>
        FIRMA DE LA AGENCIA
      </td>
      <td class="text-center">
        __________________________________
        <br>
        FIRMA DEL PASAJERO
      </td>
    </tr>
  </table>
</body>
</html>