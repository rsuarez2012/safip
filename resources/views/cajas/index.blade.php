@extends('layouts.master') 
@section('titulo', 'Cajas') 
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box padding_box1">
            <div class="row">
                <div class="col-md-4">
                    <div class="x_title">
                        <h2><i class="fa fa-building"></i> Caja Chica</h2>
                    </div>
                </div>
                <form action="{{route('manageCaja-A')}}" method="POST">
                    {!! csrf_field() !!}
                    <div class="col-md-2">
                        <label>Año</label>
                        <select class="form-control" id="anio_sel" name="anio">
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                            </select>
                    </div>
                    <div class="col-md-2">
                        <label>Mes</label>
                        <select class="form-control" id="mes_sel" name="mes">
                                <option value="01">ENERO</option>
                                <option value="02">FEBRERO</option>
                                <option value="03">MARZO</option>
                                <option value="04">ABRIL</option>
                                <option value="05">MAYO</option>
                                <option value="06">JUNIO</option>
                                <option value="07">JULIO</option>
                                <option value="08">AGOSTO</option>
                                <option value="09">SEPTIEMBRE</option>
                                <option value="10">OCTUBRE</option>
                                <option value="11">NOVIEMBRE</option>
                                <option value="12">DICIEMBRE</option>
                            </select>
                    </div>
                    <div class="col-md-1">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-xs btn-danger form-control"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <!--<a href="{{ route('manageCaja-create-A') }}" type="submit" class="btn btn-success" style="margin-bottom: 10px; position: relative; z-index: 1;margin-top: 24px;">
                            <i class="fa fa-btn fa-sign-in"></i> Nuevo Valor
                        </a>-->
            </div>

            <hr>
            <div class="x_content">
                @if(Session::has('message'))
                <div class='alert alert-success'>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{!! Session::get('message') !!}</p>
                </div>
                @endif
            </div>
            <div class="x_content">
                @if(Session::has('message2'))
                <div class='alert alert-danger'>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{!! Session::get('message2') !!}</p>
                </div>
                @endif
            </div>


            <div class="table-responsive ">
                <table class="table" id="Cajas">
                    <thead>
                        <tr>
                            <th colspan="2">
                                <h4 class="text-bold">Monto Disponible</h4>
                            </th>
                            <th>
                                <h4 id="monto">{{$total}}</h4>
                            </th>
                            <th>
                                <button class="btn btn-danger btn-xs abrir2" data-toggle="tooltip" data-placement="left" title="Retirar Efectivo">
                                            <i class="fa fa-money fa-lg"></i>
                                        </button>
                                <button class="btn btn-danger btn-xs abrir" data-toggle="tooltip" data-placement="left" title="Pagar Impuestos">
                                            <i class="fa fa-industry fa-lg"></i>
                                        </button>
                            </th>
                        </tr>
                        <tr class="text-center">
                            <th>Monto</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Sucursal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($gastos as $caja)
                        <tr class="text-center">
                            <td>-{{$caja->monto}}</td>
                            <td>{{$caja->tipo}}</td>
                            <td>{{$caja->fecha}}</td>
                            <td>{{$caja->sucursal}}</td>
                            <td>
                                <a href="{{ route('eliminar.monto.caja',$caja->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" title="eliminar"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box padding_box1">
            <div class="row">
                <div class="table-responsive  col-md-12">
                    <table class="table bordered table-hover" id="table-boletos-caja">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>COTIZACION ID</th>
                                <th>CODIGO</th>
                                <th>NRO TICKET</th>
                                <th>AGENTE</th>
                                <th>AGENCIA VIAJES</th>
                                <th>NETO</th>
                                <th>COMISION</th>
                                <th>TOTAL</th>
                                <th>TARIFA FEE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($boletos as $boleto)
                            <tr>
                                <td>{{$boleto->id}}</td>
                                <td>{{$boleto->venta_boleto_id}}</td>
                                <td>{{$boleto->codigo}}</td>
                                <td>{{$boleto->nro_ticket}}</td>
                                <td>{{$boleto->agentes_id}}</td>
                                <td>{{$boleto->aviajes}}</td>
                                <td>{{$boleto->neto}}</td>
                                <td>{{$boleto->comision}}</td>
                                <td>{{$boleto->total}}</td>
                                <td>{{$boleto->tarifa_fee}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<div class=" modal modal1">
    <div style="width: 65%;margin-left: 20%;" class="modal-content">
        <div class="modal-body">
            <h1>Pagar Impuestos</h1>
            <form class="form-horizontal padding_box1" role="form" method="POST" action="{{route('manageCaja-retiro-save-A')}}">
                {!! csrf_field() !!}

                <input type="hidden" value="1" name="impuesto">
                <div class="form-group">
                    <input type="number" readonly="" class="form-control" name="monto" value="">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="retiro" min="0" step="0.01" placeholder="Cantidad">
                </div>
                <div class="form-group">
                    <select class="form-control" name="texto">
                                <option value="">Seleccione Una Opcion</option>
                                <option value="renta">Renta</option>
                                <option value="igv">IGV</option>
                                <option value="essalud">ESSALUD</option>
                            </select>
                </div>
                <div class="form-group">
                    <select class="form-control" name="sucursal" required>
                                <option value="" selected>Seleccione Sucursal</option>
                                @foreach ($sucursal as $opcion)    
                                    <option value="{{$opcion->nombre}}">{{$opcion->nombre}}</option>
                                @endforeach
                            </select>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha del retiro <i class="fa fa-calendar"></i></label>
                    <input type="date" class="form-control" name="fecha" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cerrar1 btn-warning" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success pull-right">
                                Registrar <i class="fa fa-arrow-circle-right"></i>
                            </button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal modal2">
    <div style="width: 65%;margin-left: 20%;" class="modal-content">
        <div class="modal-body">
            <h1>Retirar Efectivo</h1>
            <form class="form-horizontal padding_box1" role="form" method="POST" action="{{route('manageCaja-retiro-save-A')}}">
                {!! csrf_field() !!}
                <input type="hidden" value="0" name="impuesto">
                <div class="form-group">
                    <input type="number" readonly="" class="form-control" id="monto2" name="monto" value="">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="retiro" id="retiro2" min="0" step="0.01" placeholder="Cantidad">
                </div>
                <div class="form-group">
                    <input class="form-control" name="texto" type="text" required="" placeholder="Razon del Retiro">
                </div>
                <div class="form-group">
                    <select class="form-control" name="sucursal" required>
                                <option value="" selected>Seleccione Sucursal</option>
                                @foreach ($sucursal as $opcion)    
                                    <option value="{{$opcion->nombre}}">{{$opcion->nombre}}</option>
                                @endforeach
                            </select>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha del retiro <i class="fa fa-calendar"></i></label>
                    <input type="date" class="form-control" name="fecha" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cerrar2 btn-warning" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success pull-right">
                                Retirar <i class="fa fa-arrow-circle-right"></i>
                            </button>
                </div>

            </form>
        </div>
    </div>
@endsection
 
@section('script')
    <script type="text/javascript">
        /* $("option[value='{!! $anio !!}']").attr("selected",true);
        $("option[value='{!! $mes !!}']").attr("selected",true); */
        
        $(function () {
            $('#Cajas').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "lengthMenu": [ 50,100, 200, 500],
                "autoWidth": true
            });
        });
        
            $('#table-boletos-caja').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "lengthMenu": [ 50,100, 200, 500],
                "autoWidth": true
            });
        

        $(".abrir").click(function(){

            $(".modal1").fadeIn();
            var x = $("#monto").text();
            $("input[name=monto]").val(x);
        });


        $(".cerrar1").click(function(){
            $(".modal1").fadeOut(300);
        });

        $(".abrir2").click(function(){

            $(".modal2").fadeIn();
            var x = $("#monto").text();
            $("input[id=monto2]").val(x);
        });


        $(".cerrar2").click(function(){
            $(".modal2").fadeOut(300);
        });




        $("input[name=retiro]").keyup(function(){
        var monto=$("#monto").text();
        var retiro= $("input[name=retiro]").val();
        var total = monto - retiro;
        $("input[name=monto]").val(total);
    });

        $("input[id=retiro2]").keyup(function(){
        var monto=$("#monto").text();
        var retiro= $("input[id=retiro2]").val();
        var total = monto - retiro;
        $("input[id=monto2]").val();
    });

    $("option[value='{!! $anio !!}']").attr("selected",true);
    $("option[value='{!! $mes !!}']").attr("selected",true);
    </script>
@endsection