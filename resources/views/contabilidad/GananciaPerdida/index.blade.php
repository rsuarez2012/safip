@extends('layouts.master')

@section('titulo', 'Contabilidad')

@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment.min.js"></script>

<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>

<script>
    $(".abrir").click(function(){

            $(".modal1").fadeIn();
            var suc=$(this).attr("id");
            $("input[name=sucursal]").val(suc);
        });


        $(".cerrar1").click(function(){

            $(".modal1").fadeOut(300);

        });
    $(".abrir2").click(function(){

            $(".modal2").fadeIn();
            var suc=$(this).attr("id");
            $("input[name=sucursal]").val(suc);
        });


        $(".cerrar2").click(function(){

            $(".modal2").fadeOut(300);

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

    <div style="min-height: 600px" class="box padding_box1">
        <h2><i class="fa fa-money"></i>&nbsp;Estado Perdidas Y Ganancias   {{$mes_texto . "-" . $anio}}</h2>
            
            @foreach($sucursales as $sucursal)
            <?php $sumatotal=0; ?> 
                <table class="table table-bordered bor">
                    <thead>
                        <tr class="bg-danger">
                            <th colspan="3"><h3 class="text-bold  text-center">QANTU TRAVEL<span class="sucursal" id="{{$sucursal->id}}"> {{$sucursal->nombre}}</span></h3></th>
                        </tr>
                    </thead>
                    <tbody class="row">
                        <tr class="text-bold">
                            <td class="col-sm-4">NOMBRE</td>
                            <td class="col-sm-4">METAS</td>
                            <td class="col-sm-4">VENTAS</td>
                        </tr>

                        <!--VENTAS Y METAS-->
                        @foreach($vendedores as $vendedor)
                        @php
                            $metas=0;
                            $total=0;
                            foreach ($boletos as $blt):
                                if($blt->anulado!=1 && $blt->users_id==$vendedor->id){
                                    $metas += ($blt->tarifa_fee - $blt->pago_consolidador);
                                    $total += $blt->total;
                                }
                            endforeach;
                        @endphp
                            <tr>
                                @if($metas > 0)
                                    @if($vendedor->sucursales_id==$sucursal->id)
                                        <td>{{$vendedor->nombres}}</td>
                                        <td>
                                            {{$metas}}
                                        </td>
                                        <td class="totales">
                                        @foreach($boletos as $blt)
                                            @if($blt->anulado!=1 && $blt->users_id==$vendedor->id)
                                                <?php $sumatotal=$sumatotal+$blt->total ?>
                                            @endif
                                        @endforeach
                                        {{$total}}
                                        </td>
                                    @endif
                                @endif
                            </tr>    
                        @endforeach
                        <tr class="bg-danger text-bold">
                            <td colspan="2">
                                TOTAL
                            </td>
                            <td>   
                                {{$sumatotal}}
                            </td>
                        </tr>
                        

                        <!--PAGO MAYORISTAS-->
                        <tr>
                            <td colspan="2" class="text-bold text-center">PAGO MAYORISTAS</td>
                            <td class="text-center"><button id="{{$sucursal->nombre}}" class="abrir btn btn-danger">Agregar Pago Mayorista</button></td>
                        </tr>

                        <?php $total_mayoristas=0; ?>
                        @foreach($pago_mayorista as $pm)
                            @if($pm->sucursal==$sucursal->nombre)
                            <tr>
                                <td colspan="2">{{$pm->mayorista}}</td>
                                <td>-{{$pm->pago}}</td>
                                <?php $total_mayoristas+=$pm->pago; ?>                                
                            </tr>
                            @endif
                        @endforeach
                        <tr class="bg-danger text-bold">
                            <td colspan="2">TOTAL MAYORISTAS</td>
                            <td>-{{$total_mayoristas}}</td>
                        </tr>
 
                        <!--UTILIDADES-->
                        <tr class="bg-danger text-bold">
                            <td colspan="2">UTILIDAD BRUTA</td>
                            <td>{{$suma_utl=$sumatotal-$total_mayoristas}}</td>
                        </tr>
                        <tr class="bg-danger text-bold">
                            <td>UTILIDAD BRUTA SOLES</td>
                            <td>
                                <?php $taza=1; ?>
                                @if(count($utilidades)>0)
                                    @foreach($utilidades as $utl)
                                        @if($utl->sucursal==$sucursal->nombre)
                                            <?php $taza=($utl->taza); ?>       
                                            Taza De cambio ({{$taza}})
                                        @elseif($utl->tipo ==1)
                                            <button class="btn btn-danger abrir2" id="{{$sucursal->nombre}}">Agregar taza de cambio</button>
                                        @endif    
                                    @endforeach
                                @else
                                    <button class="btn btn-danger btn-sm abrir2" id="{{$sucursal->nombre}}">Agregar taza de cambio</button>     
                                @endif
                            </td>
                            <td>
                                {{$utilidad_bruta_soles=$taza*$suma_utl}}
                            </td>
                        </tr>
                        <!--GASTOS OPREATIVOS-->
                        <tr>
                            <td colspan="2" class="text-center text-bold">GASTOS OPREATIVOS</td>
                            <td>
                                @if(count($utilidades)>0)
                                    @foreach($utilidades as $utl)
                                        @if($utl->sucursal==$sucursal->nombre && $utl->tipo ==2)
                                            <?php $taza=($utl->taza); ?>   
                                            Taza De cambio ({{$taza}})
                                        @elseif($utl->tipo ==2)
                                            <button class="btn btn-danger abrir3" id="{{$sucursal->nombre}}">Agregar taza de cambio</button>
                                        @endif    
                                    @endforeach
                                @else
                                    <button class="btn btn-danger btn-sm abrir3" id="{{$sucursal->nombre}}">Agregar taza de cambio</button>     
                                @endif
                            </td>
                        </tr>
                        <?php $total1=0; ?>
                        @foreach($vendedores as $vendedor)
                                        <?php $metas=0;?>
                                        @foreach($boletos as $blt)

                                            @if($blt->anulado!=1 && $blt->users_id==$vendedor->id)
                                                <?php $metas=$metas+($blt->tarifa_fee - $blt->pago_consolidador) ?>       
                                            @endif
                                        @endforeach
                            @if($metas > 0)
                            <tr class="text-danger">
                                @if($vendedor->sucursales_id==$sucursal->id)
                                    <td>{{$vendedor->nombres}}</td>
                                     
                                    <td>
                                        @if($metas<= $incentivo[0]->primera_meta)
                                            <?php $metas=($metas*$incentivo[0]->primer_incentivo)/100?>
                                            {{$metas}}
                                        @elseif($metas<= $incentivo[0]->segunda_meta)
                                            <?php $metas=($metas*$incentivo[0]->segundo_incentivo)/100?>
                                            {{$metas}}
                                        @elseif($metas<= $incentivo[0]->tercera_meta)
                                            <?php $metas=($metas*$incentivo[0]->tercer_incentivo)/100?>
                                            {{$metas}}
                                        @elseif($metas<= $incentivo[0]->cuarta_meta)
                                            <?php $metas=($metas*$incentivo[0]->cuarto_incentivo)/100?>
                                            {{$metas}}
                                        @elseif($metas<= $incentivo[0]->quinta_meta)
                                            <?php $metas=($metas*$incentivo[0]->quinto_incentivo)/100?>
                                            {{$metas}}
                                        @elseif($metas>= $incentivo[0]->quinta_meta)
                                            <?php $metas=($metas*$incentivo[0]->quinto_incentivo)/100?>
                                            {{$metas}}   
                                        @endif
                                    </td>

                                    <td>
                                        @if(count($utilidades)>0)
                                        @foreach($utilidades as $utl)
                                            @if($utl->sucursal==$sucursal->nombre && $utl->tipo ==2)
                                                <?php $taza=($utl->taza); ?>       
                                                {{$taza*$metas}}
                                                 <?php $total1=$total1+($taza*$metas) ?>
                                            @elseif($utl->tipo ==2)
                                                {{$metas}}
                                                <?php $total1=$total1+($taza*$metas) ?>
                                            @endif    
                                        @endforeach
                                        @else
                                            {{$metas}}
                                            <?php $total1=$total1+($taza*$metas) ?> 
                                        @endif
                                    </td>
                                @endif
                            </tr>
                            @endif 
                        @endforeach
                        <?php $total2=0; ?>
                        @foreach($contabilidad_opb as $copb)
                                @if($copb->sucursal == $sucursal->nombre)
                                    <tr>
                                        <td colspan="2">{{$copb->tipo}}</td>
                                        <td>{{$copb->monto}}</td>
                                        <?php $total2=$total2+$copb->monto; ?>
                                    </tr>
                                @endif
                        @endforeach
                               <tr class="bg-danger text-bold">
                                    <td colspan="2">TOTAL GASTOS OPREATIVOS</td>
                                    <td>{{$total_gastos_operativos=$total1+$total2}}</td>
                                </tr>
                                <tr class="bg-danger text-bold">
                                    <td colspan="2">TOTAL UTILIDAD</td>
                                    <td>{{$total_utilidad=$utilidad_bruta_soles-$total_gastos_operativos}}</td>
                                </tr>

                        <!--OTROS GASTOS-->
                        <tr>
                            <td colspan="3" class="text-bold text-center">OTROS GASTOS</td>
                        </tr>
                        <?php $total_gastos=0; ?>
                        @foreach($otros as $otro)
                            @if($otro->sucursal == $sucursal->nombre && $otro->impuesto!=1)
                                <tr>
                                    <td colspan="2">{{$otro->tipo}}</td>
                                    <td>{{$otro->monto}}</td>
                                    <?php $total_gastos=$total_gastos+$otro->monto; ?>
                                </tr>
                            @endif
                        @endforeach 
                        <tr class="bg-danger text-bold">
                            <td colspan="2">TOTAL OTROS GASTOS</td>
                            <td>{{$total_gastos}}</td>
                        </tr>
                        <tr class="bg-danger text-bold">
                            <td colspan="2">TOTAL UTILIDAD ANTES DE IMPUESTOS</td>
                            <td>{{$total_uai=$total_utilidad-$total_gastos}}</td>
                        </tr>
                        <tr>
                            <td class="text-center text-bold" colspan="3">IMPUESTOS</td>
                        </tr>    
                        <?php $total_impuestos=0; ?>
                        @foreach($otros as $otro)
                            @if($otro->sucursal == $sucursal->nombre && $otro->impuesto == 1)
                                <tr>
                                    <td colspan="2">{{$otro->tipo}}</td>
                                    <td>{{$otro->monto}}</td>
                                    <?php $total_impuestos=$total_impuestos+$otro->monto; ?>
                                </tr>
                            @endif
                        @endforeach
                        <tr class="bg-danger text-bold">
                            <td colspan="2" >TOTAL IMPUESTOS</td>
                            <td>{{$total_impuestos}}</td>
                        </tr>
                        <!--TOTAL FINALLLL-->
                        <tr class="bg-danger text-bold">
                            <td colspan="2">UTILIDAD DEL EJERCICIO</td>
                            <td>{{$total_uai-$total_impuestos}}</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <br>
                <hr>
                <br>
                <br>
            @endforeach    
    </div>


<div class="modal-lg modal modal1">
    <div style="width: 65%;margin-left: 20%;" class="modal-content">
        <div class="modal-body">
             <h1>Registrar Pago a Mayorista</h1>
            <form action="{{ route('manageGananciaPerdida-mayorista-A') }}" method="POST">
                 {!! csrf_field() !!}
                <select name="mayorista" required="" class="form-control">
                    <option value="">Seleccione Mayorista</option>
                    @foreach($mayoristas as $my)
                        <option value="{{$my->nombre}}">{{$my->nombre}}</option>
                    @endforeach    
                </select>
                <br>
                <input type="text" class="form-control" required="" name="sucursal" readonly="" value="0000">
                <br>
                <input type="number" class="form-control" required="" step="0.01" name="pago" placeholder="Cantidad a Pagar">
                <input type="hidden" name="fecha" class="form-control" required="" value="{{$anio."-".$mes."-"."01"}}">
                <input type="hidden" name="mes" value="{{$mes}}">
                <input type="hidden" name="anio" value="{{$anio}}">
                <br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn cerrar1 btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
            <button class="btn btn-success btn-sm pull-right" type="submit">Guardar</button>
        </div>
        </form>
    </div>
</div>

<div class="modal-lg modal modal2">
    <div style="width: 65%;margin-left: 20%;" class="modal-content">
        <div class="modal-body">
             <h1>Taza De cambio Mayoristas</h1>
            <form action="{{ route('manageGananciaPerdida-taza-A') }}" method="POST">
                 {!! csrf_field() !!}
                <input type="text" class="form-control" required="" name="sucursal" readonly="" value="0000">
                <br>
                <input type="number" class="form-control" required="" step="0.01" name="taza" placeholder="Taza de cambio">
                <input type="hidden" name="fecha" class="form-control" required="" value="{{$anio."-".$mes."-"."01"}}">
                <input type="hidden" name="mes" value="{{$mes}}">
                <input type="hidden" name="anio" value="{{$anio}}">
                <br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn cerrar2 btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
            <button class="btn btn-success btn-sm pull-right" type="submit">Guardar</button>
        </div>
        </form>
    </div>
</div>
<div class="modal-lg modal modal3">
    <div style="width: 65%;margin-left: 20%;" class="modal-content">
        <div class="modal-body">
             <h1>Taza De cambio Gastos Operativo</h1>
            <form action="{{ route('manageGananciaPerdida-taza-A') }}" method="POST">
                 {!! csrf_field() !!}
                <input type="text" class="form-control" required="" name="sucursal" readonly="" value="0000">
                <br>
                <input type="number" class="form-control" required="" step="0.01" name="taza" placeholder="Taza de cambio">
                <input type="hidden" name="fecha" class="form-control" required="" value="{{$anio."-".$mes."-"."01"}}">
                <input type="hidden" name="mes" value="{{$mes}}">
                <input type="hidden" name="anio" value="{{$anio}}">
                <br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn cerrar3 btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
            <button class="btn btn-success btn-sm pull-right" type="submit">Guardar</button>
        </div>
        </form>
    </div>
</div>
@endsection