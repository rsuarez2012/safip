<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Correo de qantutravel</title>
</head>
<body>
    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
      <thead>
        <th>
          <h3 align="center">Notificacion de Qantu Travel</h3>
        </th>
      </thead>
      <tbody>
        <tr>
          <td>
            Registro de nueva agencia de viajes por parte de {{ $agencia->counter }}
          </td>
        </tr>
        <tr>
          <td>
            <ul>
              <li>Nombre Agencia : {{ $agencia->nombre }}</li>
              <li>RUC : {{ $agencia->rif }}</li>
              <li>Email : {{ $agencia->email }}</li>
              <li>Web : {{ $agencia->web }}</li>
              <li>Direccion : {{ $agencia->direccion }}</li>
              <li>Telefono : {{ $agencia->telefono }}</li>
              <li style="list-style: none">
                {{$agencia->descripcion}}
              </li>
            </ul>
          </td>
        </tr>
      </tbody>
    </table>
    </body>
</html>