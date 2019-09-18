<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Correo de qantutravel</title>
</head>
<body>
        @php $status = null; @endphp
        @if ($agency->status == "approved")
            @php $status = "Aprobada"; @endphp
        @else
            @php $status = "Rechazada"; @endphp
        @endif
    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr style="background-image:url('http://safip.qantutravel.com/imagenes/top_banner.jpg');">
      <td height="141px" width="197" align="left" valign="top"></td>
        <td align="left" valign="middle" style="padding:20px; color:#ffffff;">
       
        </td>
        
      </tr>
    </table>
    <table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#971800" style="background-color:#971800;">
      <tr>
        <td align="center" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top" bgcolor="#971800"  style="background-color:#c90e15; padding:8px; font-family:Arial, Helvetica, sans-serif;">
            <div style="color:#fff; font-size:18px;">Qantutravel</div>
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#e7e0b7" style="background-color:#fdfdfd; padding:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="10" style="margin-bottom:10px;">
              <tr>
              <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#53231a;"><div style="font-size:19px;"><b> Agencia: {{$agency->name}}</b></div><br>
                <div style="ext-align: justify;">  Le Informamos que su solicitud realizada el dia {{$agency->created_at}} fue {{$status}} 
                @if ($agency->status == "rejected")
                    <h3>Por Motivo de: {{ $agency->message }}</h3>
                @endif
    <br><br>Conoce mas sobre nuestros paquetes en
    <a href="http://online.qantutravel.com" target="_blank"  style="color:#564319; text-decoration:underline;">www.online.qantutravel.com</a>
                    <br><br>
                    <br></div></td>
              </tr>
            </table>
              <table style="border-top: solid 2px #c90e15;" width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" style="padding:10px;"><table width="75%" border="0" cellspacing="0" cellpadding="4">
                    <tr>
                      <td align="left" valign="top" style="font-family:Verdana, Geneva, sans-serif; font-size:14px; color:#000000;"><b>Siguenos en</b></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#000000;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="33%" align="left" valign="middle"><a target="_blank" href="https://twitter.com/VelasVeracruz1"><img src="http://safip.qantutravel.com/imagenes/face48.png" width="48" height="48"></a></td>
                          <td width="34%" align="left" valign="middle"><a target="_blank" href="https://www.facebook.com/vveracruz/"><img src="http://safip.qantutravel.com/imagenes/tweet48.png')}}" width="48" height="48"></a></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
                  <td width="50%" align="left" valign="middle" style="color:#564319; font-size:11px; font-family:Arial, Helvetica, sans-serif; padding:10px;"><b>Telefono:</b> (556) 555.555.555<br>
                    <b>Correo:</b> <a href="" style="color:#564319; text-decoration:none;">loren@hotmail.com</a><br>
                    <br>
                    <b>Dirección de la empresa:</b>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mattis aliquet lorem eget mattis.<br>
                    <b>Dirección web:</b> <a href="http://online.qantutravel.com" target="_blank"  style="color:#564319; text-decoration:underline;">www.online.qantutravel.com</a></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
    </body>
</html>