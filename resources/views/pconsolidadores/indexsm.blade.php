@extends('layouts.mastersm')

@section('titulo', 'Pago consolidadores')

@section('css')
    <!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
    <style type="text/css">
        .modal-body {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }

    </style>
@endsection
@section('script')
    <script src={!! asset("js/jquery.min.js")!!}></script>
    <script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/dataTables.bootstrap.js")!!}></script>
    <script type="text/javascript">
        $(function () {
            $('#dc').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

            });
            var pagoc = 0;
            $(".pagoc").each(
                function (index, value) {
                    pagoc = pagoc + eval($(this).val());
                }
            );
            $("#pagoc").val(pagoc.toFixed(2));

            var subt = 0;
            $(".subt").each(
                function (index, value) {
                    subt = subt + eval($(this).val());
                }
            );
            subt = subt.toFixed(2);
            $("#subt").val(subt);

            var igvt = 0;
            $(".igvt").each(
                function (index, value) {
                    igvt = igvt + eval($(this).val());
                }
            );
            $("#igvt").val(igvt.toFixed(2));

            var tt = 0;
            $(".tt").each(
                function (index, value) {
                    tt = tt + eval($(this).val());
                }
            );
            $("#tt").val(tt.toFixed(2));
        });
        function BuscarPagos(h,i,j){
            /*consulta a base de datos para traer el detalle de los pagos*/
            var codigo = i;
            var ticket = j;
            var suma=0;
            var APP_URL = {!!json_encode(url('/'))!!};
            $.get(APP_URL+'/tablero/pconsolidadores/getdpagos/' + codigo+ '/'+ ticket, function (pagos) {
                console.log(pagos);

                $.each(pagos, function(i, item) {
                    var tr = $('<tr>').append(
                        $("<td><input class='form-control otrasFilas ouput_linea"+h+"' type='text' name='abono[]' value='"+item.abono+"' readonly>"),
                        $("<td><input class='form-control otrasFilas' type='text' name='tipop[]' value='"+item.tipo_pago+"' readonly>"),
                        $("<td><input class='form-control otrasFilas' type='text' name='bancoe[]' value='"+item.banco_emisor+"' readonly>"),
                        $("<td><input class='form-control otrasFilas' type='text' name='bancor[]' value='"+item.banco_receptor+"' readonly>"),
                        $("<td><input class='form-control otrasFilas' type='text' name='dosnroperacion[]' value='"+item.nro_operacion+"' readonly>"),
                        $("<td><button type='button' value='"+h+"' name='button_eliminar_producto' id='button_eliminar_producto' class='btn btn-danger otrasFilas button_eliminar_producto'> Eliminar </button>")
                    );
                    /*
                     "<tr>"
                     "<td><input class='form-control ouput_linea'  type='text' name='abono[]' value='item.abono' readonly></td>"
                     "<td><input class='form-control' type='text' name='tipop[]' value='item.tipo_pago' readonly></td>"
                     "<td><input class='form-control' type='text' name='bancoe[]' value='item.banco_emisor' readonly></td>"
                     "<td><input class='form-control' type='text' name='bancor[]' value='item.banco_receptor' readonly></td>"
                     "<td><input class='form-control' type='text' name='dosnroperacion[]' value='item.nro_operacion' readonly></td>"
                     "<td><button type='button' value='"+h+"' name='button_eliminar_producto' id='button_eliminar_producto' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td>"
                     "</tr>"*/
                    $("#cdata"+h).append(tr);
                });
                $.each(pagos, function(i, item) {
                    suma = suma + parseInt(item.abono);
                });
                pCalculo(h,suma);
                $(".modale"+h).fadeIn(100);
            });
        };
        function pCalculo(h,suma){
            var validate1 = $("#mfacturar"+h);

            /*consulta a base de datos para traer el detalle de los pagos*/
            if (suma == 0) {
                $("#mresta"+h).val(validate1.val());
                $(".restaenv"+h).val(validate1.val());
            } else {
                var restay = validate1.val() - suma;
                $("#mresta"+h).val(restay);
                $(".restaenv"+h).val(restay);
            }

            /*$("#mresta"+h).val(restay);
            $(".restaenv"+h).val(restay);*/
            $("#mtotal" + h).val(suma);
        };
        $(document).ready(function(){
            $(".abrir").click(function(){
                var valor = $(this).val().split('Ç');
                var h = valor[0]+valor[2];
                var e = valor[1];
                var i = valor[0]
                var j = valor[2];
                $(".otrasFilas").parents('tr').remove();
                BuscarPagos(h,i,j);
                if(e > 0){
                    $(".registrar"+h).attr('disabled',true);
                }
            });
            $(".cerrar").click(function(){
                var h = $(this).val();
                $(".modale"+h).fadeOut(300);

            });
            $(".debitar").click(function(e){
                e.preventDefault();
                var h = $(this).val();
                var validate1= $("#mfacturar"+h);
                var validate2= $("#mresta"+h);
                var validate3= $("#mtotal"+h);
                var validate4= $("#montom"+h);
                var ouput1 = $('.tipop'+h);
                if(validate2.val() == 0){
                    alert ("¡Ya se ha pagado la totalidad de la deuda!");
                }else{
                    if(ouput1.val() <= 0){
                        alert("Debe seleccionar un tipo de pago");
                    }else{
                        if(validate4.val() <=0 ){
                            alert("Debe reflejar un monto a ser pagado");
                        }else{
                            var restax= validate1.val() - validate3.val();
                            if(restax  < 0){
                                alert("El monto supera el total a pagar");
                            }else{
                                var importe_total = 0
                                $(".ouput_linea"+h).each(
                                    function(index, value) {
                                        importe_total = importe_total + eval($(this).val());
                                    }
                                );
                                if(importe_total >= 1){
                                    var restay=  validate2.val() - validate4.val();
                                    if(restay < 0){
                                        alert("El monto supera el total que resta");
                                    }else {
                                        /*alternativa*/
                                        var ouput1 = $('#montom'+h);
                                        var ouput2 = $('.tipop'+h);
                                        var ouput3 = $('#bancoe'+h);
                                        var ouput4 = $('#bancor'+h);
                                        var ouput5 = $('#noperacion'+h);
                                        alert ("Se va a adicionar un registro con Abono de"+ouput1.val());
                                        var array = [ouput1.val(), ouput2.val(),ouput3.val(),ouput4.val(),ouput5.val()];
                                        var i=0;

                                        $.each(document.querySelectorAll("#cdata"+h+" tbody"), function(index, val) {
                                            if(i< array.length)
                                                $(val).append("<tr>" +
                                                    "<td><input class='form-control otrasFilas ouput_linea"+h+"'  type='text' name='abono[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                    "<td><input class='form-control otrasFilas' type='text' name='tipop[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                    "<td><input class='form-control otrasFilas' type='text' name='bancoe[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                    "<td><input class='form-control otrasFilas' type='text' name='bancor[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                    "<td><input class='form-control otrasFilas' type='text' name='dosnroperacion[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                    "<td><button type='button' value='"+h+"' name='button_eliminar_producto' id='button_eliminar_producto' class='btn btn-danger otrasFilas button_eliminar_producto'> Eliminar </button></td></tr>");
                                        });
                                        var v = "0";
                                        var x = "";
                                        $('#tipop').val(v);
                                        $('#montom'+h).val(v);
                                        $('#bancoe'+h).attr('disabled',true);
                                        $('#bancor'+h).attr('disabled',true);
                                        $('#noperacion'+h+'').attr('disabled','true').val(x);

                                        var importe_total = 0;
                                        $(".ouput_linea"+h).each(
                                            function(index, value) {
                                                importe_total = importe_total + eval($(this).val());
                                            }
                                        );
                                        var restay= validate1.val() - importe_total;
                                        $("#mresta"+h).val(restay);
                                        $(".restaenv"+h).val(restay);
                                        $("#mtotal"+h).val(importe_total);
                                        /*alternativa*/

                                    }
                                }else{
                                    var importe_total = 0
                                    $(".ouput_linea"+h).each(
                                        function(index, value) {
                                            importe_total = importe_total + eval($(this).val());
                                        }
                                    );
                                    var restay= (validate2.val() - validate1.val());
                                    if(restay < 0){
                                        alert("El monto supera el total que resta");
                                    }else{
                                        var importe_total = 0
                                        $(".ouput_linea"+h).each(
                                            function(index, value) {
                                                importe_total = importe_total + eval($(this).val());
                                            }
                                        );
                                        var restay= validate2.val() - importe_total;
                                        if(restay < 0){
                                            alert("El monto supera el total que resta");
                                        }else{
                                            var ouput1 = $('#montom'+h);
                                            var ouput2 = $('.tipop'+h);
                                            var ouput3 = $('#bancoe'+h);
                                            var ouput4 = $('#bancor'+h);
                                            var ouput5 = $('#noperacion'+h);
                                            alert ("Se va a adicionar un registro con Abono de"+ouput1.val());
                                            var array = [ouput1.val(), ouput2.val(),ouput3.val(),ouput4.val(),ouput5.val()];
                                            var i=0;
                                            $.each(document.querySelectorAll("#cdata"+h+" tbody"), function(index, val) {
                                                if(i< array.length)
                                                    $(val).append("<tr>" +
                                                        "<td><input class='form-control otrasFilas ouput_linea"+h+"' type='text' name='abono[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                        "<td><input class='form-control otrasFilas' type='text' name='tipop[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                        "<td><input class='form-control otrasFilas' type='text' name='bancoe[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                        "<td><input class='form-control otrasFilas' type='text' name='bancor[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                        "<td><input class='form-control otrasFilas' type='text' name='dosnroperacion[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                        "<td><button type='button'value='"+h+"' name='button_eliminar_producto' id='button_eliminar_producto' class='btn btn-danger otrasFilas button_eliminar_producto'> Eliminar </button></td></tr>");
                                            });
                                            var importe_total = 0
                                            $(".ouput_linea"+h).each(
                                                function(index, value) {
                                                    importe_total = importe_total + eval($(this).val());
                                                }
                                            );
                                            var restay= validate1.val() - validate4.val();

                                            $("#mresta"+h).val(restay);
                                            $(".restaenv"+h).val(restay);
                                            $("#mtotal"+h).val(importe_total);

                                            var v = "0";
                                            var x = "";
                                            $('#tipop').val(v);
                                            $('#montom'+h).val(v);
                                            $('#bancoe'+h).attr('disabled',true);
                                            $('#bancor'+h).attr('disabled',true);
                                            $('#noperacion'+h+'').attr('disabled','true').val(x);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });
            $('.cdata').on('click', '.button_eliminar_producto', function() {
                var h = $(this).val();
                $(this).parents('tr').eq(0).remove();
                var importe_total = 0
                var validate1 = $("#mfacturar" + h);
                $(".ouput_linea"+h).each(
                    function (index, value) {
                        importe_total = importe_total + eval($(this).val());
                    }
                );
                alert(importe_total);
                $("#mresta" + h).val(validate1.val() - importe_total);
                $(".restaenv"+h).val(validate1.val() - importe_total);

                $("#mtotal" + h).val(importe_total);
            });
            /*$("#totalpagar").val(importe_total);*/
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("select#tipop").change(function(e){
                e.preventDefault();
                var valor = $(this).attr('class').split(' ');
                var f = valor[1];

                // alert($('select[name=tipop]').val());
                var a = $(this).val();
                if (a > 1){
                    $('#disable1'+f).find('input, textarea, button, select').removeAttr("disabled");
                    $('#disable2'+f).find('input, textarea, button, select').removeAttr("disabled");
                    $('#disable3'+f).find('input, textarea, button, select').removeAttr("disabled");
                }
                if (a <= 1) {
                    $('#disable1'+f).find('input, textarea, button, select').prop("disabled",true);
                    $('#disable2'+f).find('input, textarea, button, select').prop("disabled",true);
                    $('#disable3'+f).find('input, textarea, button, select').prop("disabled",true);
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".abrirFiltro").click(function(){

                $(".modalFiltro").fadeIn();
            });
            $(".cerrarFiltro").click(function(){
                $(".modalFiltro").fadeOut(300);
            });
            $('.check').click(function() {
                var clase= $(this).attr('class').split('Ç');

                if ($(this).is(':checked')) {
                    $('.'+clase[0]).val(clase[1]);

                }

            });
            $(".abrirPago").click(function(){
                var APP_URL = {!!json_encode(url('/'))!!};
                var iframe = document.getElementById("myiframe1");
                iframe.setAttribute("src", APP_URL+'/tablero/pconsolidadores/admin/if');
                $(".mod").fadeIn();
            });


            $(".cerrar").click(function(){
                $(".mod").fadeOut(300);
            });

            $('#myiframe1').load(function(){
                var iframe = $('#myiframe1').contents();
                iframe.find(".capturar").click(function(){
                    var valor= $(this).val().split('Ç');
                    var ouput1 = valor[0];
                    var ouput2 = valor[1];
                    var ouput3 = valor[2];
                    var ouput4 = valor[3];
                    var ouput5 = valor[4];
                    var array = [ouput1,ouput5,ouput2,ouput3,ouput4];
                    var i=0;
                    $.each(document.querySelectorAll("#data tbody"), function(index, val) {
                        if(i< array.length)
                            $(val).append("<tr>" +
                                "<td><input class='form-control otrasFilas ouput_linea' type='text' name='id[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                "<td><input class='form-control otrasFilas ouput_linea' type='text' name='codigo[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                "<td><input class='form-control otrasFilas' type='text' name='ticket[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                "<td><input class='form-control otrasFilas' type='text' name='nombre_consolidador[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                "<td><input class='form-control otrasFilas importe_linea' type='text' name='pago_consolidador[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                "<td><button type='button' value='' name='button_eliminar_producto' id='button_eliminar_producto' class='btn btn-danger otrasFilas button_eliminar_producto'> Eliminar </button></td></tr>");
                    });

                });
            });
            $(document).ready(function(){
                $( ".mod" ).mousemove(function() {
                    var importe_total = 0
                    $(".importe_linea").each(
                        function(index, value) {
                            importe_total = importe_total + eval($(this).val());
                        }
                    );
                    $("#abono").val(importe_total);
                });



                $("select#tipopif").change(function(e){
                    e.preventDefault();
                    var valor = $(this).attr('class').split(' ');
                    var f = valor[1];

                    // alert($('select[name=tipop]').val());
                    var a = $(this).val();
                    if (a > 1){
                        $('#disable1').find('input, textarea, button, select').removeAttr("disabled");
                        $('#disable2').find('input, textarea, button, select').removeAttr("disabled");
                        $('#disable3').find('input, textarea, button, select').removeAttr("disabled");
                    }
                    if (a <= 1) {
                        $('#disable1').find('input, textarea, button, select').prop("disabled",true);
                        $('#disable2').find('input, textarea, button, select').prop("disabled",true);
                        $('#disable3').find('input, textarea, button, select').prop("disabled",true);
                    }
                });
                $('#data').on('click', '.button_eliminar_producto', function() {
                    $(this).parents('tr').eq(0).remove();
                });
            });
        });
    </script>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box padding_box1">
                <div class="row">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('managePconsolidadorsm-A-fecha')}}" enctype="multipart/form-data">
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
                <button type="" style="margin-top: 24px;padding: 7px;" class="btn btn-warning btn-xs btn abrirFiltro"  data-toggle="tooltip" data-placement="left" title="" data-original-title="">
                    <i class="fa fas fa-filter" aria-hidden="true"></i> Filtros Generales
                </button>
                <button type="" value="Pago Multiple Consolidador" style="margin-top: 24px;padding: 7px;" class="btn btn-warning btn-xs btn abrirPago capturar"  data-toggle="tooltip" data-placement="left" title="" data-original-title="">
                    <i class="fa fas fa-filter" aria-hidden="true"></i> Pago Multiple
                </button>

                <div class="col-md-10">
                    <div class="x_title">
                        <h2><i class="fa fa-handshake-o"></i> Consultar Pago consolidadores</h2>
                        <div class="clearfix"></div>
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
                <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table" id="dc" name="dc">
                        <thead>
                        <tr>
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
                                <td><button name="capturar" id="capturar" class="capturar btn btn-warning" value="@if(!empty($deupagos->consolidadores->nombre))
                                    {{$deupagos->consolidadores->nombre}}
                                    @else
                                        Este consolidador Ya no Existe
                                    @endif">@if(!empty($deupagos->consolidadores->nombre))
                                            {{$deupagos->consolidadores->nombre}}
                                        @else
                                            Este consolidador Ya no Existe
                                        @endif</button></td>
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
                </div>
                <div class="row">
                    <hr>
                    <div class="col-md-6">
                        <span class="h4 text-red">{{$contadorr}}</span><span class="h4"> Cuentas por pagar</span>
                    </div>
                    <div style="text-align: right;" class="col-md-3">
                        <span class="h4">Total pago consolidadores </span><div></div>
                        <span class="h4">Sub total </span><div></div>
                        <span class="h4">IGV </span><div></div>
                        <span class="h4">TOTAL </span><div></div>
                    </div>
                    <div style="background-color: #fafafa;" class="col-md-3">
                        <span class="h4 text-red"><input name="pagoc" id="pagoc" class="transparenteinput text-red" type="text" readonly></span><div></div>
                        <span class="h4 text-red"><input name="subt" id="subt" class="transparenteinput text-red" type="text" readonly></span><div></div>
                        <span class="h4 text-red"><input name="igvt" id="igvt" class="transparenteinput text-red" type="text" readonly></span><div></div>
                        <span class="h4 text-red"><input name="tt" id="tt" class="transparenteinput text-red" type="text" readonly></span><div></div>
                    </div>
                </div>
            </div>
            </div>
        </div>


    @foreach ($deupagosC as $deupagos)
        <div class="modal-lg modal modale{{$deupagos->codigo}}{{$deupagos->nro_ticket}}">
            <div style="width: 70%;margin-left: 15%" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close cerrar" value="{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-file-text"></i> Modificar cuenta por pagar</h4></h4>
                </div>
                <div class="modal-body">

                    <div>
                        <div id="wrapper">
                            <div id="login" class=" form" style="background-color: #FFF; padding: 0 20px; border-radius: 10px;">
                                <section class="login_content">
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="clearfix"></div>
                                            <form class="form-horizontal row" role="form" method="POST" action="{{ route('managePagoC-storebsm-A') }}" enctype="multipart/form-data">
                                                {!! csrf_field() !!}

                                                <div class="col-sm-2">
                                                    <label class="pull-right">Proveedor</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('proveedor') ? ' has-error' : '' }}">
                                                        <input type="text" name="proveedor" value="{{$deupagos->consolidadores_id}}" required class="form-control" readonly>
                                                        </input>
                                                        @if ($errors->has('proveedor'))
                                                            <span class="help-block">
                                              <strong>{{ $errors->first('proveedor') }}</strong>
                                          </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Fecha</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('fecha') ? ' has-error' : '' }} has-feedback">
                                                        <input type="text" class="form-control" name="fecha" id="fecha" value="{{$deupagos->created_at }}" placeholder="Fecha" readonly>

                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('fecha'))
                                                            <span class="help-block">
                                      <strong>{{ $errors->first('fecha') }}</strong>
                                  </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Codigo</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('codigo') ? ' has-error' : '' }} has-feedback">
                                                        <input type="text" class="form-control" name="codigo" id="codigo" value="{{$deupagos->codigo}}" placeholder="Codigo" readonly>

                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('codigo'))
                                                            <span class="help-block">
                                      <strong>{{ $errors->first('codigo') }}</strong>
                                  </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Ticket</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('ticket') ? ' has-error' : '' }} has-feedback">
                                                        <input type="text" class="form-control" name="ticket" id="ticket" value="{{$deupagos->nro_ticket}}" placeholder="ticket" readonly>

                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('ticket'))
                                                            <span class="help-block">
                                      <strong>{{ $errors->first('ticket') }}</strong>
                                  </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Monto</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('monto') ? ' has-error' : '' }} has-feedback">
                                                        <input type="number" step="any" class="form-control" name="mfacturar{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" id="mfacturar{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" value="{{$deupagos->pago_consolidador}}" placeholder="Monto" readonly>

                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('monto'))
                                                            <span class="help-block">
                                      <strong>{{ $errors->first('monto') }}</strong>
                                  </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Diás pagar</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('dias') ? ' has-error' : '' }} has-feedback">
                                                        <input type="number" class="form-control" name="dias{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" id="dias{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" value="{{$deupagos->diasc}}" placeholder="Dias para Pagar" readonly>

                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('dias'))
                                                            <span class="help-block">
                                      <strong>{{ $errors->first('dias') }}</strong>
                                  </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Tipo de pago</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('tipop') ? ' has-error' : '' }}">
                                                        <select name="tipop" id="tipop" class="form-control {{$deupagos->codigo}}{{$deupagos->nro_ticket}} tipop{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" required >
                                                            <option value="0">Selecciona el Tipo de Pago</option>
                                                            @foreach($tpagos as $tpago)
                                                                <option value="{{$tpago->id}}">{{$tpago->pago}}</option>
                                                            @endforeach

                                                        </select>

                                                        @if ($errors->has('tipop'))
                                                            <span class="help-block">
                                          <strong>{{ $errors->first('tipop') }}</strong>
                                      </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Tipo</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('bancoe') ? ' has-error' : '' }}" id="disable1{{$deupagos->codigo}}{{$deupagos->nro_ticket}}">
                                                        <select name="bancoe{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" id="bancoe{{$deupagos->codigo}}{{$deupagos->nro_ticket}}"  required class="form-control" disabled>
                                                            <option value="">Selecciona el Banco Emisor</option>
                                                            @foreach($bancos as $banco)
                                                                <option value="{{$banco->banco}}">{{$banco->banco}}</option>
                                                            @endforeach
                                                        </select>

                                                        @if ($errors->has('bancoe'))
                                                            <span class="help-block">
                             <strong>{{ $errors->first('bancoe') }}</strong>
                                      </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Banco receptor</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('bancor') ? ' has-error' : '' }}" id="disable2{{$deupagos->codigo}}{{$deupagos->nro_ticket}}">
                                                        <select name="bancor{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" id="bancor{{$deupagos->codigo}}{{$deupagos->nro_ticket}}"  required class="form-control" disabled>
                                                            <option value="">Selecciona el Banco Receptor</option>
                                                            @foreach($bancosg as $bancog)
                                                                <option value="{{$bancog->banco}}">{{$bancog->banco}}</option>
                                                            @endforeach
                                                        </select>

                                                        @if ($errors->has('bancor'))
                                                            <span class="help-block">
                                          <strong>{{ $errors->first('bancor') }}</strong>
                                      </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Nro operación</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('noperacion') ? ' has-error' : '' }} has-feedback" id="disable3{{$deupagos->codigo}}{{$deupagos->nro_ticket}}">
                                                        <input type="text" class="form-control" name="noperacion{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" id="noperacion{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" id="Nro peración" value="" placeholder="noperacion" disabled>
                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('noperacion'))
                                                            <span class="help-block">
                                      <strong>{{ $errors->first('noperacion') }}</strong>
                                  </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Abono</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('abono') ? ' has-error' : '' }} has-feedback">
                                                        <input type="number" class="form-control" name="montom{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" id="montom{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" value="" placeholder="abono" >
                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
                                                        @if ($errors->has('abono'))
                                                            <span class="help-block">
                                      <strong>{{ $errors->first('abono') }}</strong>
                                  </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Total abono</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('tabono') ? ' has-error' : '' }} has-feedback">
                                                        <input type="number" class="form-control" name="mtotal{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" id="mtotal{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" value="0" placeholder="tabono" readonly>
                                                        <input type="hidden" class="form-control" name="tabonosum" id="tabonosum" value="0" placeholder="abono" >

                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('tabono'))
                                                            <span class="help-block">
                                      <strong>{{ $errors->first('tabono') }}</strong>
                                  </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="pull-right">Resta</label>
                                                </div>
                                                <div class="col-sm-10 mods_input">
                                                    <div class="form-group {{ $errors->has('resta') ? ' has-error' : '' }} has-feedback">
                                                        <input type="number" step="any" class="form-control" name="mresta{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" id="mresta{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" value="0" placeholder="resta" readonly>
                                                        <input type="hidden" class="restaenv{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" name="restaenv" id="restaenv" value="" >
                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('resta'))
                                                            <span class="help-block">
                                      <strong>{{ $errors->first('resta') }}</strong>
                                  </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div align="center" >
                                                    <br>
                                                    <button id="debitar" value="{{$deupagos->codigo}}{{$deupagos->nro_ticket}}"  name="debitar"  class="btn label-success pull-center debitar">
                                                        Debitar </button>
                                                    <br>
                                                </div>
                                                <div>
                                                    <br>
                                                    <table class="table table-responsive table-bordered table-condensed cdata" id="cdata{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" name="cdata{{$deupagos->codigo}}{{$deupagos->nro_ticket}}">
                                                        <thead>
                                                        <tr>
                                                            <th class="col-md-2">Abono</th>
                                                            <th class="col-md-1">Tipo de pago</th>
                                                            <th class="col-md-1">Banco Emisor</th>
                                                            <th class="col-md-1">Banco Receptor</th>
                                                            <th class="col-md-1">Nro de Operacion</th>
                                                            <th class="col-md-1">*Acciones*</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" id="registrar" name="registrar" class="btn btn-success pull-right registrar{{$deupagos->codigo}}{{$deupagos->nro_ticket}}">
                                                        Registrar <i class="fa fa-arrow-circle-right"></i>
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cerrar btn-warning" value="{{$deupagos->codigo}}{{$deupagos->nro_ticket}}" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal-lg modal modalFiltro">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cerrarFiltro" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h5 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-filter"></i> Filtros Generales </h4></h5>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form" method="POST" action="{{ route('managePconsolidador-A-busquedagsm')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="box">
                        <div id="wrapper">
                            <div id="login" class=" form" style="background-color: #FFF;; border-radius: 10px;">
                                <div class="clearfix"></div>
                                <div class="row mods-h4">
                                    <div class="col-sm-4"><H4>Consolidador</H4></div>
                                    <div class="col-sm-8">
                                        <div class="blokselect">
                                            <ul>
                                                @foreach($consolidadores as $conso)
                                                    <?php $corto = str_replace(' ','',$conso->nombre)?>
                                                    <li><input type="checkbox" class="consolidador{{$corto}} Ç {{$conso->id}} Ç check"  name="consolidador[]" value="">{{$conso->nombre}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row mods-h4">
                                    <div class="col-sm-4"><H4>Agencia de viajes</H4></div>
                                    <div class="col-sm-8">
                                        <div class="blokselect">
                                            <ul>
                                                @foreach($aviajes as $avi)
                                                    <?php $corto = str_replace(' ','',$avi->nombre)?>
                                                    <li><input type="checkbox" class="aviajes{{$corto}} Ç {{$avi->nombre}} Ç check" name="aviajes[]" value="">{{$avi->nombre}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row mods-h4">
                                    <div class="col-sm-4"><H4>Lineas aereas</H4></div>
                                    <div class="col-sm-8">
                                        <div class="blokselect">
                                            <ul>
                                                @foreach($laereas as $lae)
                                                    <?php $corto = str_replace(' ','',$lae->nombre)?>
                                                    <li><input type="checkbox" class="laereas{{$corto}} Ç {{$lae->id}} Ç check" name="laereas[]" value="">{{$lae->nombre}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row mods-h4">
                                    <div class="col-sm-4"><H4>Estatus</H4></div>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="status" id="status">
                                            <option value="0">Por Pagar</option>
                                            <option value="1">Pagado</option>
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
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning" data-dismiss="modal">Buscar</button>
            </div>
            </form>
        </div>
    </div>

    </div>
    <!--------------------------------------------------Modal Pago Multiple--------------------------------------------------->
    <div class="modal-lg modal mod">
        <div class="modal-content modal-content2">
            <div class="modal-header">
                <button type="button" class="close cerrar" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-file-text"></i> Pagos Multiples</h4></h4>
            </div>
            <div style="padding-top: 0;" class="modal-body">
                <div class="row">

                    <form class="form-horizontal" role="form" method="POST" action="{{route('managePconsolidador-storepm-A')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div>

                            <section>
                                <div class=" row">
                                    <div class="col-sm-11 col-sm-offset-1 ">

                                        <iframe name="myiframe1" id="myiframe1" src="" height="900" width="1000">Your browser does not support frames.</iframe>

                                        <div class="clearfix"></div>

                                    </div>
                                </div>

                            </section>
                        </div>
                        <div class="col-sm-8 col-sm-offset-2">

                            <!-------------------------------------------------------------tabla dinamica---------------------------------------->
                            <div>
                                <br>
                                <table class="table table-responsive table-bordered table-condensed" id="data" name="data">
                                    <thead>
                                    <tr>
                                        <th class="col-md-3">ID</th>
                                        <th class="col-md-3">Codigo</th>
                                        <th class="col-md-3">Nro de ticket</th>
                                        <th class="col-md-3">Nombre del Consolidador</th>
                                        <th class="col-md-3">Pago del Consolidador</th>
                                        <th class="col-md-1">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                            <!-------------------------------------------------------------tabla dinamica---------------------------------------->

                        </div>

                        <div class="col-sm-8 col-sm-offset-2">
                            <div class=" mods_input">
                                <div class="form-group {{ $errors->has('tipopif') ? ' has-error' : '' }}">
                                    <select name="tipopif" id="tipopif" class="form-control tipopif" required >
                                        <option value="0">Selecciona el Tipo de Pago</option>
                                        @foreach($tpagos as $tpago)
                                            <option value="{{$tpago->id}}">{{$tpago->pago}}</option>
                                        @endforeach

                                    </select>

                                    @if ($errors->has('tipopif'))
                                        <span class="help-block">
                                          <strong>{{ $errors->first('tipopif') }}</strong>
                                      </span>
                                    @endif
                                </div>
                            </div>

                            <div class=" mods_input">
                                <div class="form-group {{ $errors->has('bancoe') ? ' has-error' : '' }}" id="disable1">
                                    <select name="bancoe" id="bancoe"  required class="form-control" disabled>
                                        <option value="">Selecciona el Banco Emisor</option>
                                        @foreach($bancos as $banco)
                                            <option value="{{$banco->banco}}">{{$banco->banco}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('bancoe'))
                                        <span class="help-block">
                             <strong>{{ $errors->first('bancoe') }}</strong>
                                      </span>
                                    @endif
                                </div>
                            </div>

                            <div class=" mods_input">
                                <div class="form-group {{ $errors->has('bancor') ? ' has-error' : '' }}" id="disable2">
                                    <select name="bancor" id="bancor"  required class="form-control" disabled>
                                        <option value="">Selecciona el Banco Receptor</option>
                                        @foreach($bancosg as $bancog)
                                            <option value="{{$bancog->banco}}">{{$bancog->banco}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('bancor'))
                                        <span class="help-block">
                                          <strong>{{ $errors->first('bancor') }}</strong>
                                      </span>
                                    @endif
                                </div>
                            </div>

                            <div class=" mods_input">
                                <div class="form-group {{ $errors->has('noperacion') ? ' has-error' : '' }} has-feedback" id="disable3">
                                    <input type="text" class="form-control" name="noperacion" id="noperacion" id="Nro peración" value="" placeholder="noperacion" disabled>
                                    <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                    @if ($errors->has('noperacion'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('noperacion') }}</strong>
                                  </span>
                                    @endif
                                </div>
                            </div>

                            <div class=" mods_input">
                                <div class="form-group {{ $errors->has('abono') ? ' has-error' : '' }} has-feedback">
                                    <input type="number" step="any" class="form-control" name="abono" id="abono" value="" placeholder="Total del Pago" >
                                    <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
                                    @if ($errors->has('abono'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('abono') }}</strong>
                                  </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <button type="submit" class="btn btn-success pull-right">
                                Guardar Pagos Multiples <i class="fa fa fa-plus-circle"></i>
                            </button>

                    </form>
                </div>


                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!--------------------------------------------------Modal Pago Multiple--------------------------------------------------->
@endsection

