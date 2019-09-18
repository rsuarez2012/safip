<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <style type="text/css">
    .letra{
        font-size: 9px;
    }
</style>
<title>CONTRATO</title>
</head>
<?php
foreach ($aportes as $apt_familiar) {
    if ($apt_familiar->nombre=="aporte_familiar") {
        $a_familiar=$apt_familiar->monto;
    }elseif ($apt_familiar->nombre=="snp") {
        $a_snp=$apt_familiar->monto;
    }
}
$total_final=0;
?>

<body>
    <div class="container-fluid letra">
        <div class="box padding_box1">
            <div class="row">
              <div class="col-md-12">           
                <table class="table table-bordered text-bold bg-danger text-light">
                    <tr>
                        <td>RUC</td>
                        <td colspan="3">20551016049</td>
                    </tr>
                    <tr>
                        <td>EMPLEADOR</td>
                        <td colspan="3">QANTU TRAVEL SAC</td>
                    </tr>
                    <tr>
                       <td>PERIODO</td>
                       <td colspan="3">{{$mes}}-{{$anio}}</td> 
                   </tr>
               </table>

               <table class="table table-bordered text-bold">    
                <tr  class="text-center bg-danger text-light">
                    <td colspan="2">DOCUMENTO DE IDENTIDAD</td>
                    <td rowspan="2">NOMBRES Y APELLIDOS</td>
                    <td rowspan="2">SITUACION</td>
                </tr>
                <tr class="text-center  bg-danger text-light">
                    <td>TIPO</td>
                    <td>NUMERO</td>
                </tr>
                <tr>
                    <td>DNI</td>
                    <td>{{$empleado->empleado->documento}}</td>
                    <td>{{$empleado->empleado->nombres ." ". $empleado->empleado->apellidos }}</td>
                    <td>Activo o Subsidiado</td>
                </tr>
                <tr class="bg-danger text-light ">
                    <td>FECHA</td>
                    <td>CARGO DEL TRABAJADOR</td>
                    <td>REGIMEN</td>
                    <td>CUSPP</td>
                </tr>
                <tr>
                    <td>{{$empleado->fecha_ingreso}}</td>
                    <td>{{$empleado->cargo}}</td>
                    <td>{{$empleado->seguro}}</td>
                    <td>0</td>
                </tr>
            </table>

            <table class="table table-bordered text-bold">
                <tr class=" bg-danger text-light">
                    <td>CODIGO</td>
                    <td>CONCEPTOS</td>
                    <td>INGRESOS S/.</td>
                    <td>DESCUENTOS S/.</td>
                    <td>NETO S/.</td>
                </tr>
                <tr>
                    <td colspan="5" class=" bg-danger text-light">INGRESOS</td>
                </tr>
                <tr id="sueldo">
                    <td></td>
                    <td>REMUNERACION O JORNAL BASICO</td>
                    <td>{{$empleado->contrato->sueldo}}</td>
                    <?php $total_final+=$empleado->contrato->sueldo; ?>
                    <td></td>
                    <td></td>
                </tr>
                <tr id="familiar">
                    <td></td>
                    <td>ASIGNACION FAMILIAR</td>
                    <td>
                        @if($empleado->empleado->hijos=="si")
                        <?php
                        foreach ($aportes as $apt_familiar) {
                            if ($apt_familiar->nombre=="aporte_familiar") {
                                $a_familiar=$apt_familiar->monto;
                            }
                        }
                        ?>
                        <?php $sueldo=($empleado->contrato->sueldo*$a_familiar)/100; ?>
                        {{$sueldo}}
                        <?php $total_final+=$sueldo; ?>
                        @else
                        0    
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>OTROS INGRESOS</td>
                    <td>
                        0
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-bold bg-danger text-light">APORTES DEL TRABAJADOR</td>
                </tr>
                <tr>
                    <td></td>
                    <td>RENTA QUINTA CATEGORÍA RETENCIONES</td>
                    <td></td>
                    <td>0</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>SISTEMA NAC. DE PENSIONES DL 19990</td>
                    <td></td>
                    <td id="pensiones">
                        @if($empleado->empleado->hijos=="si" && $empleado->seguro=="SNP")
                        <?php
                        $sueldo=($empleado->contrato->sueldo*$a_familiar)/100;
                        $sueldo=$sueldo+$empleado->contrato->sueldo;
                        $sueldo=($sueldo*$a_snp)/100;
                        ?>
                        {{$sueldo}}
                        <?php $total_final+=$sueldo; ?>
                        @endif
                        @if($empleado->empleado->hijos=="no" && $empleado->seguro=="SNP")
                        <?php
                        $sueldo=$empleado->contrato->sueldo;
                        $sueldo=($sueldo*$a_snp)/100;
                        ?>    
                        {{$sueldo}}
                        <?php $total_final+=$sueldo; ?>
                        @endif
                        @if($empleado->empleado->hijos=="no" && $empleado->seguro!="SNP")
                        0
                        @endif
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>COMISION AFP PORCENTUAL</td>
                    <td></td>
                    <td id="porcentual">
                        @if($empleado->empleado->hijos=="si" && $empleado->apf!="no")
                        @foreach($apf_opciones as $opcion)
                        @if($opcion->nombre == $empleado->apf)
                        <?php $aux=$opcion->comision_ra; ?>
                        @endif
                        @endforeach
                        <?php
                        $sueldo=($empleado->contrato->sueldo*$a_familiar)/100;
                        $sueldo=$sueldo+$empleado->contrato->sueldo;
                        $sueldo=($sueldo*$aux)/100;
                        ?>
                        {{$sueldo}}
                        <?php $total_final+=$sueldo; ?>
                        @endif
                        @if($empleado->empleado->hijos=="no" && $empleado->apf!="no")
                        @foreach($apf_opciones as $opcion)
                        @if($opcion->nombre == $empleado->apf)
                        <?php $aux=$opcion->comision_ra; ?>
                        @endif
                        @endforeach
                        <?php
                        $sueldo=$empleado->contrato->sueldo;
                        $sueldo=($sueldo*$aux)/100;
                        ?>
                        {{$sueldo}}
                        <?php $total_final+=$sueldo; ?>
                        @endif
                        @if($empleado->empleado->hijos=="no" && $empleado->apf=="no")
                        0
                        @endif
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>PRIMA DE SEGURO AFP</td>
                    <td></td>
                    <td id="prima">
                       @if($empleado->empleado->hijos=="si" && $empleado->apf!="no")
                       @foreach($apf_opciones as $opcion)
                       @if($opcion->nombre == $empleado->apf)
                       <?php $aux=$opcion->prima_seguro; ?>
                       @endif
                       @endforeach
                       <?php
                       $sueldo=($empleado->contrato->sueldo*$a_familiar)/100;
                       $sueldo=$sueldo+$empleado->contrato->sueldo;
                       $sueldo=($sueldo*$aux)/100;
                       ?>
                       {{$sueldo}}
                       <?php $total_final+=$sueldo; ?>
                       @endif
                       @if($empleado->empleado->hijos=="no" && $empleado->apf!="no")
                       @foreach($apf_opciones as $opcion)
                       @if($opcion->nombre == $empleado->apf)
                       <?php $aux=$opcion->prima_seguro; ?>
                       @endif
                       @endforeach
                       <?php
                       $sueldo=$empleado->contrato->sueldo;
                       $sueldo=($sueldo*$aux)/100;
                       ?>
                       {{$sueldo}}
                       <?php $total_final+=$sueldo; ?>
                       @endif
                       @if($empleado->empleado->hijos=="no" && $empleado->apf=="no")
                       0
                       @endif 
                   </td>
                   <td></td>
               </tr>
               <tr>
                <td></td>
                <td>SSP-APORTACION OBLIGATORIA</td>
                <td></td>
                <td id="obligatoria">
                   @if($empleado->empleado->hijos=="si" && $empleado->apf!="no")
                   @foreach($apf_opciones as $opcion)
                   @if($opcion->nombre == $empleado->apf)
                   <?php $aux=$opcion->aporte_obligatorio; ?>
                   @endif
                   @endforeach
                   <?php
                   $sueldo=($empleado->contrato->sueldo*$a_familiar)/100;
                   $sueldo=$sueldo+$empleado->contrato->sueldo;
                   $sueldo=($sueldo*$aux)/100;
                   ?>
                   {{$sueldo}}
                   <?php $total_final+=$sueldo; ?>
                   @endif
                   @if($empleado->empleado->hijos=="no" && $empleado->apf!="no")
                   @foreach($apf_opciones as $opcion)
                   @if($opcion->nombre == $empleado->apf)
                   <?php $aux=$opcion->aporte_obligatorio; ?>
                   @endif
                   @endforeach
                   <?php
                   $sueldo=$empleado->contrato->sueldo;
                   $sueldo=($sueldo*$aux)/100;
                   ?>
                   {{$sueldo}}
                   <?php $total_final+=$sueldo; ?>
                   @endif
                   @if($empleado->empleado->hijos=="no" && $empleado->apf=="no")
                   0
                   @endif 
               </td>
               <td></td>
           </tr>
           <tr class=" bg-danger text-light">
            <td colspan="4">NETO A PAGAR</td>
            <td>{{$total_final}}</td>
        </tr>
    </table>    
    <table  class="table table-bordered text-bold">
        <tr class=" bg-danger text-light">
            <td colspan="5">APORTES DE EMPLEADOR</td>
        </tr>
        <tr>
            <td colspan="4">ESSALUD(REGULAR CBSSP AGRAR/AC)TRAB</td>
            <td>
               @if($empleado->empleado->hijos=="si" && $empleado->salud!="no")
               @foreach($aportes as $salud)
               @if($salud->nombre == "essalud")
               <?php $aux=$salud->monto; ?>
               @endif
               @endforeach
               <?php
               $sueldo=($empleado->contrato->sueldo*$a_familiar)/100;
               $sueldo=$sueldo+$empleado->contrato->sueldo;
               $sueldo=($sueldo*$aux)/100;
               ?>
               {{$sueldo}}
               <?php $total_final+=$sueldo; ?>
               @endif
               @if($empleado->empleado->hijos=="no" && $empleado->salud!="no")
               @foreach($aportes as $salud)
               @if($salud->nombre == "essalud")
               <?php $aux=$salud->monto; ?>
               @endif
               @endforeach
               <?php
               $sueldo=$empleado->contrato->sueldo;
               $sueldo=($sueldo*$aux)/100;
               ?>
               {{$sueldo}}
               <?php $total_final+=$sueldo; ?>
               @endif
               @if($empleado->empleado->hijos=="no" && $empleado->apf=="no")
               0
               @endif 
           </td>
       </tr>
   </table>
   <table>
       <tr>
           <td></td>
           <td></td>
       </tr>
   </table>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</body>
</html>