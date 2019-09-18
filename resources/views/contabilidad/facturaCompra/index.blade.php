@extends('layouts.master')
 
@section('titulo', 'Empleados')

@section('css')
<!--  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->

@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment.min.js"></script>

<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

<script type="text/javascript">
    $(document).ready( function () {
    $("select").change(function(){
            if($(this).val()=="Soles"){
                $("input[name=taza]").val(1);
                $("#taza_cambio").addClass("hidden");
            }else{
                $("#taza_cambio").removeClass("hidden");
            }
        });

    $('#factura').DataTable();
} );

    $(".abrir").click(function(){

            $(".modal1").fadeIn();

        });


        $(".cerrar").click(function(){

            $(".modal1").fadeOut(300);

        });
</script>

@endsection

@section('content')
    <!-- contenido principal -->
    <?php  $nombremes=array("","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"); ?>
    <div style="min-height: 700px" class="box padding_box1" >
        <h1>&nbsp;<i class="fa fa-money"></i>&nbsp;Factura de Compras</h1>
        <hr>
        <div class="row">
        <form action="{{Route('manageFacturaCompra-filtrar-A')}}" method="POST">
        {!! csrf_field() !!}
        <div class="col-md-3">
            <label>Año</label>
            <select class="form-control" id="anio_sel" name="anio">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
            </select>
        </div>


        <div class="col-md-3">
            <label>Mes</label>
            <select class="form-control" id="mes_sel" name="mes">
                <option value="1">ENERO</option>
                <option value="2">FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-danger form-control">Buscar</button>
        </div> 
    </form>  
        <div class="col-md-2">
            <label>&nbsp;</label>
            <button class="btn btn-danger form-control abrir">Nueva Entrada</button>
        </div> 
        </div>
        <div class="row">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="col-sm-12">
        
<div class="ml-5 table-responsive">
    <table id="factura" class="table text-center">
        <thead class="text-center" style="background-color: #dd4b39; color: #fff;">
            <tr>
                <th> </th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Serie</th>
                <th>Numero</th>
                <th>RUC</th>
                <th></th>
                <th>Base Impo.</th>
                <th>Base Impo.</th>
                <th>Valor</th>
                <th>Monto</th>
                <th>&nbsp;</th>
                <th>Base Impo.</th>
                <th>Base Impo.</th>
                <th>Valor</th>
                <th>Monto</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th>ID</th>
                <th>Emision</th>
                <th>Documento</th>
                <th>Comp. Pago</th>
                <th>Comp. Pago</th>
                <th>Proveedor</th>
                <th>Nombre</th>
                <th>Adquis. Grabada</th>
                <th>Adquis. No Grabada</th>
                <th>del Impuesto</th>
                <th>Importe Total</th>
                <th>Taza de Cambio</th>
                <th>Adquis. Grabada</th>
                <th>Adquis. No Grabada</th>
                <th>del Impuesto</th>
                <th>Importe Total</th>
                 <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $grabada=0;
            $no_grabada=0;
            $impuesto=0;
            $total=0;
        ?>
            @foreach($lista as $fila)
            <tr class="factura">
                <td>{{$fila->id}}</td>
                <td>{{$fila->emision}}</td>
                <td>{{$fila->documento}}</td>
                <td>{{$fila->comp_pago_serie}}</td>
                <td>{{$fila->comp_pago_numero}}</td>      
                <td>{{$fila->ruc}}</td>
                <td>{{$fila->nombre}}</td>
                <td>{{$fila->adquis_grabada}}</td>
                <td>{{$fila->adquis_no_grabada}}</td>
                <td>{{$fila->impuesto}}</td>
                <td>{{$fila->importe_total}}</td>
                @if($fila->taza_cambio==1)
                    <td class="bg-danger">0</td>
                @else
                    <td class="bg-danger">{{$fila->taza_cambio}}</td>
                @endif
                <td>{{($fila->adquis_grabada*$fila->taza_cambio)}}</td>
                <td>{{($fila->adquis_no_grabada*$fila->taza_cambio)}}</td>
                <td>{{($fila->impuesto*$fila->taza_cambio)}}</td>
                <td>{{($fila->importe_total*$fila->taza_cambio)}}</td>
                <td><a href="{{route ('managefacturaCompra-update-A',[$fila->id])}}" class="btn btn-danger fa fa-file d-inline" data-toggle="tooltip" data-placement="bottom" title="Modificar"></a>
                    <a href="{{route ('managefacturaCompra-delete-A',[$fila->id])}}" class="btn btn-danger fa fa-trash d-inline" data-toggle="tooltip" data-placement="bottom" title="Eliminar"></a></td>
            </tr>
                <?php
                    $grabada+=$fila->adquis_grabada*$fila->taza_cambio;
                    $no_grabada+=$fila->adquis_no_grabada*$fila->taza_cambio;
                    $impuesto+=$fila->impuesto*$fila->taza_cambio;
                    $total+=$fila->importe_total*$fila->taza_cambio;
                ?>
            @endforeach
        </tbody>
        <tfooter >
            <tr class="text-center">
                <td colspan="12" class="text-bold"  style="background-color: #dd4b39; color: #fff;">TOTAL</td>
                <td class="bg-danger text-bold">{{$grabada}}</td>
                <td class="bg-danger text-bold">{{$no_grabada}}</td>
                <td class="bg-danger text-bold">{{$impuesto}}</td>
                <td class="bg-danger text-bold">{{$total}}</td>
                <td style="background-color: #dd4b39; color: #fff;">&nbsp;</td>
            </tr>
        </tfooter>
    </table>
</div>
</div>
<div class="clearfix"></div>
</div>


<!--MODAL DE CREATE-->
<div class="modal-lg modal modal1">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close cerrar" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel"> <h2><i class="fa fa-money"></i> Datos Adicionales</h2></h4>
        </div>
        <div class="modal-body">

            @section('script')
            <script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>
            <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
            <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
            @endsection

            <div class="box padding_box1">
                <div id="wrapper">
                    <div id="login" class=" form" style="background-color: #FFF; padding: 0 20px; border-radius: 10px;">
                        <section class="login_content">
                            <div class="clearfix"></div>


                            <div class="row">
                                <div class="col-md-10">
                                    <div class="x_title">

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row "  style="overflow: scroll; height: 380px;">
                                <div class="col-sm-8 col-sm-offset-2">

                                    <div class="clearfix"></div>


                                    <form method="POST" action="{{ route('managefacturaCompra-store-A') }}">

                                        <div class="form-group">
                                            <label>Fecha de emision</label>
                                            <input type="date" name="emision" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo Documento</label>
                                            <select name="tipo" required="" class="form-control">
                                                <option value="FACTURA">Factura</option>
                                                <option value="BOLETO">Boleto</option>
                                                <option value="RECIBO POR HONORARIOS">Recibo Por Honorarios</option>
                                                <option value="NOTA CREDITO">Nota Credito</option>
                                                <option value="NOTA DEBITO">Nota Debito</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Numero serie del comprobante</label>
                                            <input type="text" name="serie" required="" class="form-control">
                                        </div>
                                        <div class="form-group has-feedback">
                                        <div class="form-group">
                                            <label>Numero del comprobante</label>
                                            <input type="text" name="numero" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>RUC</label>
                                            <input type="text" name="ruc" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre o razon social</label>
                                            <input type="text" name="nombre" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Adquis grabada</label>
                                            <input value="0" type="number" step="0.00001" name="grabada" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Adquis No grabada</label>
                                            <input value="0" type="number" step="0.00001" name="nograbada" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Monto del Impuesto</label>
                                            <input value="0" type="number" step="0.00001" name="impuesto" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo Moneda</label>
                                            <select class="form-control">
                                                <option selected>Dolares</option>
                                                <option>Soles</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="taza_cambio">
                                            <label>Taza de Cambio</label>
                                            <input value="1" type="number" step="0.00001" name="taza" required="" class="form-control">
                                        </div>    
                                      </div>
                                      <div class="form-actions">
                                        <button type="submit" class="btn btn-success pull-right">
                                            Registrar <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                        {!! csrf_field() !!}
                                       </div> 
                                    </form>                                                        
                                

                            </div>
                        </div>
                    </section>
                   
                </div>
 
            </div>
</div>
</div>
</div>
</div>    

@endsection

