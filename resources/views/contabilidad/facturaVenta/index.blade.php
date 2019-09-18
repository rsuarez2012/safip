@extends('layouts.master')
 
@section('titulo', 'Empleados')

@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->

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
                $("input[name=taza_cambio]").val(1);
                $("#taza_cambio").addClass("hidden");
            }else{
                $("#taza_cambio").removeClass("hidden");
            }
        });


    $('#factura2').DataTable();
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


    <br>
    <div style="min-height: 700px" class="box padding_box1" >
         <h1>&nbsp;<i class="fa fa-money"></i>&nbsp;Factura de Ventas</h1>
         <hr>
             <div  class="row" >
    <form action="{{Route('manageFacturaVenta-filtrar-A')}}" method="POST">
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
    <table id="factura2" class="table text-center">
        <thead style="background-color: #dd4b39; color: #fff;">
            <tr>
                <th>SERIE</th>
                <th>Fecha</th>
                <th>Factura</th>
                <th>RUC</th>
                <th>Usuario</th>
                <th>Monto</th>
                <th>IGV</th>
                <th>Total</th>
                <th>Taza Cambio</th>
                <th>Monto</th>
                <th>IGV</th>
                <th>Total</th>
                <th>Acciones</th>                
            </tr>
        </thead>
        <tbody>
            <?php 
                $monto=0;
                $igv=0;
                $total=0; 
            ?>
            @foreach($lista as $fila)
            <tr class="factura">
                <td>{{$fila->serie}}</td>
                <td>{{$fila->fecha}}</td>
                <td>{{$fila->factura}}</td>
                <td>{{$fila->ruc}}</td>
                <td>{{$fila->usuario}}</td>      
                <td>{{$fila->monto}}</td>
                <td>{{$fila->igv}}</td>
                <td>{{$fila->total}}</td>
                @if($fila->taza_cambio==1)
                    <td class="bg-danger">0</td>
                @else
                    <td class="bg-danger">{{$fila->taza_cambio}}</td>
                @endif    
                <td>{{$fila->monto*$fila->taza_cambio}}</td>
                <td>{{$fila->igv*$fila->taza_cambio}}</td>
                <td>{{$fila->total*$fila->taza_cambio}}</td>
                <td><a href="{{Route('managefacturaVenta-update-A',[$fila->id])}}" class="btn btn-danger fa fa-file d-inline" data-toggle="tooltip" data-placement="bottom" title="Modificar"></a>
                    <a href="{{Route('managefacturaVenta-delete-A',[$fila->id])}}" class="btn btn-danger fa fa-trash d-inline" data-toggle="tooltip" data-placement="bottom" title="Eliminar"></a></td>
                <?php 
                    $monto+=$fila->monto*$fila->taza_cambio;
                    $igv+=$fila->igv*$fila->taza_cambio;
                    $total+=$fila->total*$fila->taza_cambio;
                ?>
            @endforeach
        </tbody>
        <tfooter>
            <tr class="text-center">
                <td colspan="9" class="text-bold" style="background-color: #dd4b39; color: #fff;">TOTAL</td>
                <td class="text-bold bg-danger">{{ $monto }}</td>
                <td class="text-bold bg-danger">{{ $igv }}</td>
                <td class="text-bold bg-danger">{{ $total }}</td>
                <td style="background-color: #dd4b39; color: #fff;">&nbsp;</td>
            </tr>
        </tfooter>
        </tbody>
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
                            <div class="row "  style="overflow-y: scroll; height: 380px;">
                                <div class="col-sm-8 col-sm-offset-2">

                                    <div class="clearfix"></div>


                                    <form method="POST" action="{{Route('manageFacturaVenta-store-A')}}">
                                        <div class="form-group">
                                            <label>Serie</label>
                                            <select class="form-control" name="serie">

                                                <option value="0001">0001</option>
                                                <option value="0002">0002</option>
                                                <option value="0003">0003</option>
                                                <option value="0004">0004</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <input type="date" name="fecha" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Factura</label>
                                            <input type="text" name="factura" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>RUC</label>
                                            <input type="text" name="ruc" required="" class="form-control">
                                        </div>
                                        <div class="form-group has-feedback">
                                        <div class="form-group">
                                            <label>Usuario</label>
                                            <input type="text" name="usuario" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Monto</label>
                                            <input value="0" type="number" step="0.01" name="monto" required="" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>IGV</label>
                                            <input value="0" type="number" step="0.01" name="igv" required="" class="form-control">
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
                                            <input value="1" type="number" step="0.01" name="taza_cambio" required="" class="form-control">
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

