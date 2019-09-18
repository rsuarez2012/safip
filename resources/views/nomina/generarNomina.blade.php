@extends('layouts.master')

@section('titulo', 'Empleados')

@section('css')
<!--  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<style type="text/css">
td{
  text-align: center;
 }
</style>
@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment.min.js"></script>

<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

<script type="text/javascript">
  $(function () {
    $('#planilla').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });

    $('#exportar').click(function(e){
      var htmltable= document.getElementById('planilla');
      var html = htmltable.outerHTML; window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
      e.preventDefault();

    });
  });

  $(document).ready(function(){

  });
</script>


@endsection

@section('content')
<?php 
    switch ($mes) {
        case '01':
            $mes_texto="ENERO";
            break;
        case '02':
            $mes_texto="FEBRERO";
            break;
        case '03':
            $mes_texto="MARZO";
            break;
        case '04':
            $mes_texto="ABRIL";
            break;
        case '05':
            $mes_texto="MAYO";
            break;
        case '06':
            $mes_texto="JUNIO";
            break;
        case '07':
            $mes_texto="JULIO";
            break;
        case '08':
            $mes_texto="AGOSTO";
            break;
        case '09':
            $mes_texto="SEPTIEMBRE";
            break;
        case '10':
            $mes_texto="OCTUBRE";
            break;
        case '11':
            $mes_texto="NOVIEMBRE";
            break;
        case '12':
            $mes_texto="DICIEMBRE";
            break;                                                 
    }
?>
<div class="box padding_box1">
  <div class="row">
    <div class="col-sm-10">
      <h1>Planilla de Remuneraciones  {{$mes_texto ."
      - ".$anio}} <i class="fa fa-users"></i></h1>
    </div>
    <div class="col-sm-2" style="margin-top: 15px;">
      <button id="exportar" class="btn btn-danger">Imprimir <i class="fa fa-print"></i></button>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table id="planilla" class="table table-bordered" bordercolor="#000" border="1">
          <thead>
            <tr class="bg-info text-bold">
             <th class="col">ORDEN</th>
             <th class="col">DNI</th>
             <th class="col">CUSPP</th>
             <th class="col">APELLIDOS Y NOMBRES</th>
             <th class="col">FECHA INGRESO</th>
             <th class="col">CARGO U OCUPACION</th>
             <th class="col">ASIGNACION FAMILIAR</th>
             <th class="col">SUELDO BASICO</th>
             <th class="col">ASIGNACION FAMILIAR</th>
             <th class="col">OTROS</th>
             <th class="col">TOTAL REMUNERACION BRUTA</th>
             <th class="col">SNP/AFP</th>
             <th class="col">ONP/SNP</th>
             <th class="col">APF</th>
             <th class="col">APORTE OBLIGATORIO</th>
             <th class="col">COMISION % SOBRE R.A</th>
             <th class="col">PRIMA SEGURO</th>
             <th class="col">RENTA DE QUINTA CATEGORIA</th>
             <th class="col">TOTAL DESCUENTOS</th>
             <th class="col">REMUNERACION NETA</th>
             <th class="col">SALUD</th>
             <th class="col bg-danger">QANTU</th>
             <th class="col bg-danger">QUINCENA 1</th>
             <th class="col bg-danger">ADELANTO</th>
             <th class="col bg-danger">DESCUENTO</th>
             <th class="col bg-danger">INASISTENCIAS</th>
             <th class="col bg-danger">TOTAL</th>
             <th class="col bg-danger">QUINCENA 2</th>
             <th class="col bg-danger">INASISTENCIAS</th>
             <th class="col bg-danger">AFP</th>
             <th class="co bg-danger">TOTAL</th>
             <th class="col bg-danger">&nbsp;</th>
           </tr>
         </thead>
         <?php 
         //VARIABLES PARA SUMA DE TOTALES
         $sueldos_basicos=0;
         $suma_bruto=0;
         $suma_snp=0;
         $suma_obligatorio=0;
         $suma_ra=0;
         $suma_seguro=0;
         $suma_descuentos=0;
         $suma_neta=0;
         $suma_salud=0;
         $suma_quincena=0;
         $suma_adelanto=0;
         $suma_total=0;
         $suma_quincena2=0;
         $suma_total2=0;
         $faltas_totales=0;
         $faltas_totales2=0;
         ?>
         <tbody>        
           @foreach($nomina as $fila)
           @if($fila->datoslaborales[0]->contrato[0]->fecha_fin >= date('Y-m-d'))
           <tr>
            <td>{{$fila->id}}</td>
            <td>{{$fila->documento}}</td>
            <td>0</td>
            <td>{{$fila->apellidos." ".$fila->nombres}}</td>
            <td>{{$fila->datoslaborales[0]->contrato[0]->fecha_inicio}}</td>
            <td>{{$fila->datoslaborales[0]->cargo}}</td>
            <td>{{$fila->hijos}}</td>
            <td>{{$fila->datoslaborales[0]->contrato[0]->sueldo}}</td><?php $sueldos_basicos=$sueldos_basicos + $fila->datoslaborales[0]->contrato[0]->sueldo;?></td>

            <!--VALIDAR SI TIENE HIJOS-->
            <td>
              @if($fila->hijos=="si")
              @foreach($aportes as $hijos)
              @if($hijos->nombre == "aporte_familiar")
              {{($fila->datoslaborales[0]->contrato[0]->sueldo * $hijos->monto)/100}}
              @endif
              @endforeach 
              @endif
            </td>
            <td>0</td>
            <!--SUMA BRUTA DE TOTALES-->
            @foreach($aportes as $hijos)
            @if($hijos->nombre=="aporte_familiar")
            <?php $aporte_familiar=$hijos->monto; ?>
            @endif
            @endforeach

            <td>
              @if($fila->hijos=="si")
              <?php 
              $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
              $suma_bruto+=$x+$fila->datoslaborales[0]->contrato[0]->sueldo
              ?>
              {{$x+$fila->datoslaborales[0]->contrato[0]->sueldo}}
              @else
              <?php $suma_bruto+=$fila->datoslaborales[0]->contrato[0]->sueldo ?>
              {{$fila->datoslaborales[0]->contrato[0]->sueldo}}
              @endif
            </td>
            <!--SNP AFP-->
            <td>
              {{$fila->seguro}}
            </td>
            <!--SNP AFP CALCULOS-->
            @foreach($aportes as $snp)
            @if($snp->nombre=="snp")
            <?php $snp_porc=$snp->monto; ?>
            @endif
            @endforeach
            <td>
              @if($fila->seguro=="SNP")
              @if($fila->hijos=="si")
              <?php 
              $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
              $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
              $y=($x*$snp_porc)/100;
              $suma_snp=$suma_snp+$y;
              ?>
              {{$y}}
              @else
              <?php 
              $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
              $y=($x*$snp_porc)/100;
              $suma_snp=$suma_snp+$y;
              ?>
              {{$y}}
              @endif
              @endif
            </td>
            <!--APF-->
            <td>
              {{$fila->apf}}
            </td>
            <!--APF CALCULOS-->
            <td>
              @foreach($apf_opciones as $opcion)
              @if($fila->apf==$opcion->nombre)
              @if($fila->hijos=="si")
              <?php 
              $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
              $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
              $y=($x*$opcion->aporte_obligatorio)/100;
              $suma_obligatorio=$suma_obligatorio+$y;
              ?>
              {{$y}}
              @else
              <?php 
              $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
              $y=($x*$opcion->aporte_obligatorio)/100;
              $suma_obligatorio=$suma_obligatorio+$y;
              ?>
              {{$y}}
              @endif
              @endif
              @endforeach
            </td>
            <td>
              @foreach($apf_opciones as $opcion)
              @if($fila->apf==$opcion->nombre)
              @if($fila->empleado->hijos=="si")
              <?php 
              $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
              $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
              $y=($x*$opcion->comision_ra)/100;
              $suma_ra=$suma_ra+$y;
              ?>
              {{$y}}
              @else
              <?php 
              $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
              $y=($x*$opcion->comision_ra)/100;
              $suma_ra=$suma_ra+$y;
              ?>
              {{$y}}
              @endif
              @endif
              @endforeach
            </td>
            <td>
              @foreach($apf_opciones as $opcion)
              @if($fila->apf==$opcion->nombre)
              @if($fila->hijos=="si")
              <?php 
              $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
              $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
              $y=($x*$opcion->prima_seguro)/100;
              $suma_seguro=$suma_seguro+$y;
              ?>
              {{$y}}
              @else
              <?php 
              $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
              $y=($x*$opcion->prima_seguro)/100;
              $suma_seguro=$suma_seguro+$y;
              ?>
              {{$y}}
              @endif
              @endif
              @endforeach
            </td>
            <td>
              0
            </td>
            <!--CALCULAR TOTAL DE DESCUENTOS-->
            <td>
              @foreach($apf_opciones as $opcion)
              @if($fila->apf==$opcion->nombre)
              @if($fila->empleado->hijos=="si")
              <?php 
              $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
              $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
              $ao=($x*$opcion->aporte_obligatorio)/100;
              $ra=($x*$opcion->comision_ra)/100;
              $ps=($x*$opcion->prima_seguro)/100;
              $suma_descuentos=$suma_descuentos+$ao+$ra+$ps;
              ?>
              {{$ao+$ra+$ps}}
              @else
              <?php 
              $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
              $ao=($x*$opcion->aporte_obligatorio)/100;
              $ra=($x*$opcion->comision_ra)/100;
              $ps=($x*$opcion->prima_seguro)/100;
              $suma_descuentos=$suma_descuentos+$ao+$ra+$ps;
              ?>
              {{$ao+$ra+$ps}}
              @endif
              @endif
              @endforeach
            </td>
            <!--CALCULAR REMUNERACION NETA-->    
            <td>
             @foreach($apf_opciones as $opcion)
             @if($fila->apf==$opcion->nombre)
             @if($fila->hijos=="si")
             <?php 
             $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
             $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
             $ao=($x*$opcion->aporte_obligatorio)/100;
             $ra=($x*$opcion->comision_ra)/100;
             $ps=($x*$opcion->prima_seguro)/100;
             $x=$x-($ao+$ra+$ps);
             $suma_neta+=$x;
             ?>
             {{$x}}
             @else
             <?php 
             $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
             $ao=($x*$opcion->aporte_obligatorio)/100;
             $ra=($x*$opcion->comision_ra)/100;
             $ps=($x*$opcion->prima_seguro)/100;
             $x=$x-($ao+$ra+$ps);
             $suma_neta+=$x;
             ?>
             {{$x}}
             @endif
             @endif
             @endforeach
           </td>
           <td>
            <?php $si_salud=0; ?>
            @foreach($aportes as $salud)
            @if($salud->nombre == "essalud")
            <?php 
            $si_salud=$salud->monto; 
            ?>
            @endif
            @endforeach 
            @if($fila->salud=="si")
            @if($fila->hijos=="si")
            @foreach($aportes as $hijos)
            @if($hijos->nombre == "aporte_familiar")
            <?php 
            $hijos=($fila->datoslaborales[0]->contrato[0]->sueldo * $hijos->monto)/100;
            $sueldo=($fila->datoslaborales[0]->contrato[0]->sueldo)+$hijos;
            $salud=($sueldo * $si_salud)/100;
            $suma_salud+=$salud;
            ?>
            {{$salud}}
            @endif
            @endforeach 
            @else
            <?php 
            $sueldo=($fila->datoslaborales[0]->contrato[0]->sueldo);
            $salud=($sueldo * $si_salud)/100;
            $suma_salud+=$salud;
            ?>
            {{$salud}}
            @endif
            @endif
          </td>
          <!--QANTU-->
          <td>
            @if($fila->hijos=="si")
            <?php 
            $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
            ?>
            {{$x+$fila->datoslaborales[0]->contrato[0]->sueldo}}
            @else
            {{$fila->datoslaborales[0]->contrato[0]->sueldo}}
            @endif
          </td>
          <!--QUINCENA 1-->
          @if($fila->datoslaborales[0]->contrato[0]->periodo_pago=="mensual")
          <td class="text-center">
            -
          </td>
          @else
          <td>
            @if($fila->hijos=="si")
            <?php 
            $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
            ?>
            <?php $suma_quincena+=($x+$fila->datoslaborales[0]->contrato[0]->sueldo)/2 ?>
            {{($x+$fila->datoslaborales[0]->contrato[0]->sueldo)/2}}
            @else
            {{$fila->datoslaborales[0]->contrato[0]->sueldo/2}}
            <?php $suma_quincena+=($fila->datoslaborales[0]->contrato[0]->sueldo)/2 ?>
            @endif
          </td>    
          @endif
          <!--ADELANTOS-->
          @if($fila->datoslaborales[0]->contrato[0]->periodo_pago=="mensual")
          <td class="text-center">
            -
          </td>
          @else
          <td>
            <?php $adelanto_actual=0; ?>
            @foreach($adelantos as $ad)
            @if($fila->id==$ad->empleado_id)
            <?php 
            $adelanto_actual+= $ad->monto;
            ?>
            @endif
            @endforeach
            {{$adelanto_actual}}
            <?php $suma_adelanto=$suma_adelanto+$adelanto_actual; ?>
          </td>    
          @endif
          <!--DESCUENTO-->
          @if($fila->datoslaborales[0]->contrato[0]->periodo_pago=="mensual")
          <td class="text-center">
            -
          </td>
          @else
          <td>
            0
          </td>    
          @endif
          <!--CALCULA INASISTENCIAS <=15-->
          @if($fila->datoslaborales[0]->contrato[0]->periodo_pago=="mensual")
          <td>-</td>
          @else
          <td>
            <?php $faltas_actual=0;?>
            @foreach($faltas as $falta)
              @if($falta->empleado_id == $fila->id)
              <?php $dia=explode("-",$falta->fecha); ?>
                @if($dia[2]<=15)
                <?php $faltas_actual++; ?>
                @endif
              @endif
            @endforeach
            {{$faltas_actual}}
            <?php $faltas_totales+=$faltas_actual; ?>
          </td>
          @endif  
          <!--TOTAL QUINCENA 1-->
          @if($fila->datoslaborales[0]->contrato[0]->periodo_pago=="mensual")
          <td class="text-center">
            -
          </td>
          @else
          <td>
            @if($fila->hijos=="si")
            <?php 
            $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
            $x=$fila->datoslaborales[0]->contrato[0]->sueldos+$x;
            $x=$x/2;
            $x=$x-($adelanto_actual);
            $x=$x-(($fila->datoslaborales[0]->contrato[0]->sueldo/26)*$faltas_actual);
            ?>
            <?php $suma_total+=$x ?>
            {{$x}}
            @else
            <?php 
              $x=$fila->datoslaborales[0]->contrato[0]->sueldo/2;
              $x=$x-($adelanto_actual);
              $x=$x-(($fila->datoslaborales[0]->contrato[0]->sueldo/26)*$faltas_actual);  
            ?>
            {{$x}}
            <?php $suma_total+=$x ?>
            @endif
          </td>    
          @endif
        <!--TOTAL QUINCENA 2-->
        @if($fila->datoslaborales[0]->contrato[0]->periodo_pago=="mensual")
        <td>
          @if($fila->hijos=="si")
          <?php 
          $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
          ?>
          <?php $suma_quincena2+=($x+$fila->datoslaborales[0]->contrato[0]->sueldo) ?>
          {{($x+$fila->datoslaborales[0]->contrato[0]->sueldo)}}
          @else
          {{$fila->datoslaborales[0]->contrato[0]->sueldo}}
          <?php $suma_quincena2+=($fila->datoslaborales[0]->contrato[0]->sueldo) ?>
          @endif
        </td>
        @else
        <td>
          @if($fila->hijos=="si")
          <?php 
          $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
          ?>
          <?php $suma_quincena2+=($x+$fila->datoslaborales[0]->contrato[0]->sueldo)/2 ?>
          {{($x+$fila->datoslaborales[0]->contrato[0]->sueldo)/2}}
          @else
          {{$fila->datoslaborales[0]->contrato[0]->sueldo/2}}
          <?php $suma_quincena2+=($fila->datoslaborales[0]->contrato[0]->sueldo)/2 ?>
          @endif
        </td>    
        @endif
        <!--CALCULA INASISTENCIAS > 15-->
          @if($fila->datoslaborales[0]->contrato[0]->periodo_pago=="mensual")
          <td>
            <?php $faltas_actual=0;?>
            @foreach($faltas as $falta)
              @if($falta->empleado_id == $fila->id)
              <?php $dia=explode("-",$falta->fecha); ?>
                <?php $faltas_actual++; ?>
              @endif
            @endforeach
            {{$faltas_actual}}
            <?php $faltas_totales2+=$faltas_actual; ?>
          </td>
          @else
          <td>
            <?php $faltas_actual=0;?>
            @foreach($faltas as $falta)
              @if($falta->empleado_id == $fila->id)
              <?php $dia=explode("-",$falta->fecha); ?>
                @if($dia[2] > 15)
                <?php $faltas_actual++; ?>
                @endif
              @endif
            @endforeach
            {{$faltas_actual}}
            <?php $faltas_totales2+=$faltas_actual; ?>
          </td>
          @endif  
        <!--AFP-->
        @foreach($aportes as $snp)
        @if($snp->nombre=="snp")
        <?php $snp_porc=$snp->monto; ?>
        @endif
        @endforeach
        <td>
          @if($fila->seguro=="SNP")
          @if($fila->hijos=="si")
          <?php 
          $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
          $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
          $y=($x*$snp_porc)/100;
          ?>
          {{$y}}
          @else
          <?php 
          $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
          $y=($x*$snp_porc)/100;
          ?>
          {{$y}}
          @endif
          @endif
        </td>
        <!--TOTAL QUINCENA 2-->
        @if($fila->datoslaborales[0]->contrato[0]->periodo_pago=="mensual")
        <td>
          @if($fila->hijos=="si")
          @if($fila->seguro=="SNP")
          <?php 
          $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
          $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
          $y=($x*$snp_porc)/100;
          $z=$x-$y;
          $z=$z-(($x/26)*$faltas_actual);
          $suma_total2+=$z;
          ?>
          {{$z}}
          @else
          <?php
          $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
          $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
          $x=$x-(($x/26)*$faltas_actual);
          $suma_total2+=$x;
          ?>
          {{$x}}
          @endif
          @else
          @if($fila->seguro=="SNP")
          <?php 
          $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
          $y=($x*$snp_porc)/100;
          $z=$x-$y;
          $z=$z-(($x/26)*$faltas_actual);
          $suma_total2+=$z;
          ?>
          {{$z}}
          @else
          <?php
          $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
          $x=$x-(($x/26)*$faltas_actual);
          $suma_total2+=$x;
          ?>
          {{$x}}
          @endif
          @endif
        </td>
        @else
        <td>
          @if($fila->hijos=="si")
          @if($fila->seguro=="SNP")
          <?php 
          $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
          $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
          $y=($x*$snp_porc)/100;
          $z=($x/2)-$y;
          $z=$z-(($x/26)*$faltas_actual);
          $suma_total2+=$z;
          ?>
          {{$z}}
          @else
          <?php
          $x=($fila->datoslaborales[0]->contrato[0]->sueldo * $aporte_familiar)/100;
          $x=$x+$fila->datoslaborales[0]->contrato[0]->sueldo;
          $suma_total2+=($x/2)-(($x/26)*$faltas_actual);
          ?>
          {{($x/2)-(($x/26)*$faltas_actual)}}
          @endif
          @else
          @if($fila->seguro=="SNP")
          <?php 
          $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
          $y=($x*$snp_porc)/100;
          $z=($x/2)-$y;
          $z=$z-(($x/26)*$faltas_actual);
          $suma_total2+=$z;
          ?>
          {{$z}}
          @else
          <?php
          $x=$fila->datoslaborales[0]->contrato[0]->sueldo;
          $x=($x/2)-(($x/26)*$faltas_actual);
          $suma_total2+=$x;
          ?>
          {{($x)}} 
          @endif
          @endif
        </td>  
        @endif
        <td><a target="_blank" href="{{Route('manageNomina-reciboIndividual-A',array('id'=>$fila->id,'mes'=>$mes,'anio'=>$anio))}}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="left" title="" data-original-title="Imprimir Planilla del Empleado"><i class="fa fa-print"></i></a></td>
      </tr>
      @endif
      @endforeach
    </tbody>
    <tfoot>  
      <tr class="bg-info text-bold text-center">
        <td colspan="7">TOTALES</td>
        <td>{{$sueldos_basicos}}</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>{{$suma_bruto}}</td>
        <td>&nbsp;</td>
        <td>{{$suma_snp}}</td>
        <td>&nbsp;</td>
        <td>{{$suma_obligatorio}}</td>
        <td>{{$suma_ra}}</td>
        <td>{{$suma_seguro}}</td>
        <td>&nbsp;</td>
        <td>{{$suma_descuentos}}</td>
        <td>{{$suma_neta}}</td>
        <td>{{$suma_salud}}</td>
        <td class="bg-danger">{{$suma_bruto}}</td>
        <td class="bg-danger">{{$suma_quincena}}</td>
        <td class="bg-danger">{{$suma_adelanto}}</td>
        <td class="bg-danger">0</td>
        <td class="bg-danger">{{$faltas_totales}}</td>
        <td class="bg-danger">{{$suma_total}}</td>
        <td class="bg-danger">{{$suma_quincena2}}</td>
        <td class="bg-danger">{{$faltas_totales2}}</td>
        <td class="bg-danger">{{$suma_snp}}</td>
        <td class="bg-danger">{{$suma_total2}}</td>
        <td class="bg-danger">&nbsp;</td>
      </tr>
    </tfoot>  
  </table>
</div>  
</div>
</div>
</div>
@endsection