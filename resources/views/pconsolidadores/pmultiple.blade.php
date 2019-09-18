@extends('layouts.mastersm')

@section('titulo', 'Pago Multiple')

@section('css')
    <!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('script')

    <script src={!! asset("js/jquery.min.js")!!}></script>
    <script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
    <script src={!! asset("js/xlsx.core.min.js")!!}></script>

    <script type="text/javascript">
        $(function () {

            $('#opbanc').DataTable({
                "iDisplayLength": 500,
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": true,
            });
        });
        $(document).ready(function(){
            $( ".target" ).change(function() {
                var att = $(this).attr('class').split(' ');
                var valor = $(this).val();
                if (valor == 1){
                    var clase = att[1];

                    var APP_URL = {!!json_encode(url('/'))!!};
                    var iframe = document.getElementById("myiframe1");
                    iframe.setAttribute("src", APP_URL+'/tablero/dagenciaviajes/admin/sm');
                    $('.referencia').val(clase);
                    $('.alert').prop("hidden",true);
                    $('.modal1').fadeIn();
                }
                if (valor == 2){
                    var clase = att[1];

                    var APP_URL = {!!json_encode(url('/'))!!};
                    var iframe = document.getElementById("myiframe1");
                    iframe.setAttribute("src", APP_URL+'/tablero/pconsolidadores/admin/sm');
                    $('.referencia').val(clase);
                    $('.modal1').fadeIn();
                }
                if (valor == 3){
                    var clase = att[1];

                    $('.referencia').val(clase);
                    $('.capturado').val("");
                    $('.tipog').val("");
                    $('.descripciong').val("");
                    $('.modal3').fadeIn();
                    $('.guardar2').val(clase);
                }
            });
            $(".cerrar").click(function(e){
                e.preventDefault();
                $(".modal").fadeOut(600);
            });
            $('#capturar').click(function(e){
                e.preventDefault();

                var capturar = $(this).val();
                $('#capturado').val(capturar);
            });
            $('#myiframe1').load(function(){
                var iframe = $('#myiframe1').contents();
                iframe.find(".capturar").click(function(){
                    var valor= $(this).val();
                    $('#capturado').val(valor);
                    $('.alert').removeAttr("hidden");
                });
            });

            $(".referencia").click(function(e){
                var clase = $(this).val();

                e.preventDefault();
                var referencia = $('#capturado').val();
                if (referencia == 0){
                    alert ("Recuerda identificar tu pago," +
                        "haciendo click sobre el nombre de la Agencia" +
                        " o consolidador que estas identificando");
                }else{
                    var mensaje = confirm("¿Se identifico el pago!?");
//Detectamos si el usuario acepto el mensaje
                    if (mensaje) {
                        var tipoop = $('.target'+clase).val();
                        var valor = $('.target'+clase).val();
                        if (valor == 1){
                            $('.'+clase).addClass("color1");
                        }
                        if (valor == 2){
                            $('.'+clase).addClass("color2");
                        }

                        if (tipoop == 1){
                            $('.tipoop'+clase).val("Deudas de Agencia de Viajes");
                        }else{
                            if (tipoop == 2){
                                $('.tipoop'+clase).val("Pago a Consolidadores");
                            }
                        }
                        $('.status'+clase).val("Identificado");
                        $('.procedencia'+clase).val(referencia);
                        $(".modal").fadeOut(600);
                    }
//Detectamos si el usuario denegó el mensaje
                    else {
                        $('.status'+clase).val("NO Identificado");
                        $(".modal").fadeOut(600);
                    }
                }
//Ingresamos un mensaje a mostrar
            });
            $("#guardar2").click(function(e){
                e.preventDefault();
                var clase = $(this).val();
                var tipog = $('#tipog').val();
                var descripcion = $('#descripciong').val();
                if (referencia == 0){
                    alert ("debe llenar las dos cajas de texto");
                }else {
                    if (descripcion == 0) {
                        alert ("debe llenar las dos cajas de texto");
                    } else {
                        var mensaje = confirm("¿Se identifico el pago!?");
//Detectamos si el usuario acepto el mensaje
                        if (mensaje) {
                            var tipoop = $('.target'+clase).val();
                            $('.status'+clase).val("Identificado");
                            $('.procedencia' + clase).val(tipog+"*"+descripcion);
                            var valor = $('.target'+clase).val();
                            if (valor == 3){
                                $('.'+clase).addClass("color3");
                            }
                            $('.tipoop'+clase).val("Gastos");
                            $(".modal").fadeOut(600);
                        }
//Detectamos si el usuario denegó el mensaje
                        else {
                            $('.status'+clase).val("NO Identificado");
                            $(".modal").fadeOut(600);
                        }
                    }
                }
//Ingresamos un mensaje a mostrar
            });
            $('.check').click(function() {
                var valor= $(this).val().split(' ');
                alert(valor[0]);
                if ($(this).is(':checked')) {
                    $('.'+valor[0]).val("1");
                }
                if (!$(this).is(':checked')) {
                    $('.'+valor[0]).val("0");
                }
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".abrirFiltroC").click(function(e){
                e.preventDefault();
                $(".modalFiltroC").fadeIn();
            });
            $(".cerrarFiltroC").click(function(e){
                e.preventDefault();
                $(".modalFiltroC").fadeOut(300);
            });
            $(".abrirFiltroB").click(function(e){
                e.preventDefault();
                var APP_URL = {!!json_encode(url('/'))!!};
                var iframe = document.getElementById("myiframe2");
                iframe.setAttribute("src", APP_URL+'/tablero/coperacionesbancarias/admin/ttbsmi');
                $(".modalFiltroB").fadeIn();
            });
            $(".cerrarFiltroB").click(function(e){
                e.preventDefault();
                $(".modalFiltroB").fadeOut(300);
            });
        });
    </script>

@endsection
@section('content')

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box padding_box1">
                <div class="row">
                    <div class="col-md-7">
                        <h2><i class="fa fa-ticket"></i> Consultar operaciones bancarias</h2>
                        <div class="clearfix"></div>
                    </div>

                    <form  class="form-horizontal" role="form" method="POST" action="{{ route('manageCoperacionesbancarias-import-A') }}" enctype="multipart/form-data">
                        <div class="col-md-3">
                            <div align="center">
                                <label>Seleccionar</label>
                                {!! csrf_field() !!}
                                <input class="btn" type="file" name="file" id="file">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input style="width: 70px;float: left;margin-right: 5px;" class="btn btn-block btn-success" type="submit" value="Subir">
                            <button class="btn btn-success">Editar</button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageCoperacionesbancarias-A-fecha')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="col-md-4"><label>Desde:</label>
                            <div class="form-group {{ $errors->has('fechai') ? ' has-error' : '' }} has-feedback">

                                <input type="date" class="form-control" name="fechai" value="{{$fechai}}" placeholder="Fecha" >

                                <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>

                                @if ($errors->has('fechai'))
                                    <span class="help-block">
                                              <strong>{{ $errors->first('fechai') }}</strong>
                                          </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4"><label>Hasta:</label>
                            <div class="form-group {{ $errors->has('fechaf') ? ' has-error' : '' }} has-feedback">
                                <input type="date" class="form-control" name="fechaf" value="{{$fechaf}}" placeholder="Fecha" >

                                <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>

                                @if ($errors->has('fechaf'))
                                    <span class="help-block">
                                              <strong>{{ $errors->first('fechaf') }}</strong>
                                          </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" style="margin-top: 24px;padding: 7px;" class="btn btn-warning btn-xs btn"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Filtrar por fecha">
                                <i class="fa fas fa-calendar" aria-hidden="true"></i>
                            </button>
                        </div>
                        <!--<button type="" style="margin-top: 24px;padding: 7px;" class="btn btn-warning btn-xs btn abrirFiltro"  data-toggle="tooltip" data-placement="left" title="" data-original-title="">
                                <i class="fa fas fa-filter" aria-hidden="true"></i> Filtros Generales
                        </button>-->
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <button type="" style="margin-top: 24px;padding: 7px;" class="btn btn-warning btn-xs btn abrirFiltroC" name="abrirFiltroC" id="abrirFiltroC"  data-toggle="tooltip" data-placement="left" title="" data-original-title="">
                            <i class="fa fas fa-filter" aria-hidden="true"></i> Filtros Generales
                        </button>
                        <button type="" style="margin-top: 24px;padding: 7px;" class="btn  btn-xs btn abrirFiltroB"  name="abrirFiltroB" id="abrirFiltroB"  data-toggle="tooltip" data-placement="left" title="" data-original-title="">
                            <i class="fa fas fa-filter" aria-hidden="true"></i> Balance Bancario
                        </button>
                    </div>
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
                <form class="form-horizontal" role="form" method="POST" action="{{ route('manageCoperacionesbancarias-storeindex-A') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table" id="opbanc">
                                <tr>
                                    <th style="width: 80px !important"></th>
                                    <th class="col-md-2">ID</th>
                                    <th class="col-md-2">Registro</th>
                                    <th class="col-md-2">Codigo</th>
                                    <th class="col-md-2">Ticket</th>
                                    <th class="col-md-2">DNI/RUC</th>
                                    <th class="col-md-2">Pasajero</th>
                                    <th class="col-md-2">Linea Aerea</th>
                                    <th class="col-md-2">Ruta</th>
                                    <th class="col-md-1">Consolidador</th>
                                    <th class="col-md-1">Agencia de Viajes</th>
                                    <th class="col-md-1">Pago consolidadores</th>
                                    <th class="col-md-1">Por Pagar</th>
                                    <th class="col-md-1">Comision agencia</th>
                                    <th class="col-md-1">IGV</th>
                                    <th class="col-md-1">Total</th>
                                    <th class="col-md-1">dias</th>
                                    <th class="col-md-2">Estatus</th>
                                    <th class="col-md-2">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($deupagosC as $deupagos)
                                    <tr>
                                        <td><input class="check check{{$operacion->nro_operacion}}{{$operacion->monto}} "  type="checkbox" name="check[]" id="check[]" value="checkeado{{$operacion->nro_operacion}}"><input class="checkeado checkeado{{$operacion->nro_operacion}}" type="text" name="checkeado[]" id="checkeado[]" value="0" hidden></td>
                                        <td>{{$deupagos->id}}</td>
                                        <td>{{$deupagos->fecha}}</td>
                                        <td>{{$deupagos->codigo}}</td>
                                        <td>{{$deupagos->nro_ticket}}</td>
                                        <td>{{$deupagos->dni_ruc}}</td>
                                        <td>{{$deupagos->nombre_cliente}}</td>
                                        <td>@if(!empty($deupagos->laereas->nombre))
                                                {{$deupagos->laereas->nombre}}
                                            @else
                                                Esta Linea Aerea Ya no Existe
                                            @endif

                                        </td>
                                        <td>{{$deupagos->ruta}}</td>
                                        <td>
                                            @if(!empty($deupagos->consolidadores->nombre))
                                                {{$deupagos->consolidadores->nombre}}
                                            @else
                                                Este consolidador Ya no Existe
                                            @endif
                                           </td>
                                        <td>{{$deupagos->aviajes_id}}</td>
                                        <td>{{$deupagos->pago_consolidador}}<input type="hidden" class="pagoc" value="{{$deupagos->pago_consolidador}}"></td>
                                        <td>{{$deupagos->porpagar}}<input type="hidden" class="" value="{{$deupagos->porpagar}}"></td>
                                        <td>{{$deupagos->comision_agencia}}<input type="hidden" class="subt" value="{{$deupagos->comision_agencia}}"></td>
                                        <td>{{$deupagos->igv}}<input type="hidden" class="igvt" value="{{$deupagos->igv}}"></td>
                                        <td>{{$deupagos->total}}<input type="hidden" class="tt" value="{{$deupagos->total}}"></td>
                                        <td>{{$deupagos->diasc}}</td>
                                        <td>
                                            @if ($deupagos->status== "1")
                                                <span class="label label-success">Pagada</span>
                                            @else
                                                <span class="label label-danger">Por Pagar</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-xs btn abrir" value="{{$deupagos->codigo}}Ç{{$deupagos->status}}Ç{{$deupagos->nro_ticket}}" href="" data-toggle="tooltip" data-placement="left" title="Editar cuenta por cobrar">
                                                <i class="fa fa-pencil fa-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <hr>
                            <div class="col-md-6">
                                <span class="h4 text-red">{{$contador}}</span><span class="h4"> Operaciones Bancarias</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success pull-right">
                                Guardar <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="modal-lg modal modalFiltroC">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close cerrarFiltroC" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-filter"></i> Filtros Generales </h4></h5>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('manageCoperacionesbancarias-A-busquedag')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="box">
                            <div id="wrapper">
                                <div id="login" class=" form" style="background-color: #FFF;; border-radius: 10px;">
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div style="text-align: right;" class="col-sm-4"><H4>Estatus</H4></div>
                                        <div class="col-sm-8">
                                            <select name="statusm" class="form-control" style="margin-top: 7px">
                                                <option value="">Selecciona un Estatus</option>
                                                <option value="1">Identificado</option>
                                                <option value="0">NO Identificado</option>
                                            </select>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div style="text-align: right;" class="col-sm-4"><H4>Banco emisor</H4></div>
                                        <div class="col-sm-8">
                                            <select name="bancoem" class="form-control" style="margin-top: 7px">
                                                <option value="">Selecciona un Banco Emisor</option>
                                                @foreach($bancosg as $bancos)
                                                    <option value="{{$bancos->banco}}">{{$bancos->banco}}</option>
                                                @endforeach
                                            </select>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div style="text-align: right;" class="col-sm-4"><H4>Moneda</H4></div>
                                        <div class="col-sm-8">
                                            <select name="monedam" class="form-control" style="margin-top: 7px">
                                                <option value="">Selecciona una Moneda</option>
                                                <option value="Dolar">Dolar</option>
                                                <option Value="Soles">Soles</option>
                                            </select>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div style="text-align: right;" class="col-sm-4"><H4>Tipo operacion</H4></div>
                                        <div class="col-sm-8">
                                            <select name="tipom" class="form-control" style="margin-top: 7px">
                                                <option value="">Selecciona un Tipo</option>
                                                <option value="1">Deudas de Agencia de Viajes</option>
                                                <option value="2">Pago a Consolidadores</option>
                                                <option value="3">Gastos</option>
                                            </select>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"><label>Desde:</label>
                                            <div class="form-group {{ $errors->has('fechai') ? ' has-error' : '' }} has-feedback">
                                                <input type="date" class="form-control" name="fechai" value="{{$fechai}}" placeholder="Fecha" >
                                                <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                                                @if ($errors->has('fechai'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('fechai') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4"><label>Hasta:</label>
                                            <div class="form-group {{ $errors->has('fechaf') ? ' has-error' : '' }} has-feedback">
                                                <input type="date" class="form-control" name="fechaf" value="{{$fechaf}}" placeholder="Fecha" >

                                                <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>

                                                @if ($errors->has('fechaf'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('fechaf') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning" data-dismiss="modal">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

