@extends('layouts.mastersm')

@section('titulo', 'Deuda de agencia de viajes')

@section('css')
    <!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <style type="text/css">
        .modal-body {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }
        .content-wrapper{
            margin-left: 0 !important
        }
        .content-header{
            padding: 0 !important
        }
    </style>
@endsection
@section('script')
    <script>   
        var APP_URL = {!!json_encode(url('/'))!!};
      </script>
    <script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
    <script src={!! asset("js/toastr.js") !!}></script>
    <script src={!! asset("js/axios.js") !!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/dataTables.bootstrap.js")!!}></script>
    <script type="text/javascript">
        $(function () {
            $('#pconsolidadore').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,

            });
            var tf = 0;
            $(".tf").each(
                function (index, value) {
                    tf = tf + eval($(this).val());
                }
            );
            $("#tf").val(tf.toFixed(2));
            var pc = 0;
            $(".pc").each(
                function (index, value) {
                    pc = pc + eval($(this).val());
                }
            );
            $("#pc").val(pc.toFixed(2));
        });

        //funciones nuevas de jose
        function editarMultiplesReistros(){
            let reistros_seleccionados = $(".micheckbox:checked");
            if (reistros_seleccionados == undefined) {
                $("#editar-multiples-registros").css("display","none");
            } else {
                let valor_puro = reistros_seleccionados[0].parentElement.parentElement.lastElementChild.children[0].value;
                $("#registro-actual-editandose").val(reistros_seleccionados[0].id);
                abrirModalCopia(valor_puro);
            }
           
        }
        function abrirModalCopia(registro){
            var valor = registro.split('Ç');
                var h = valor[0]+valor[2];
                var e = valor[1];
                var i = valor[0]
                var j = valor[2];
                $(".otrasFilas").parents('tr').remove();
                BuscarPagos(h,i,j);
                if(e > 0){
                    $(".registrar").attr('disabled',true);
                }
        }
        function enviarFormStore(){
            let form_data = $("#form_edit_cuenta_por_cobrar").serialize();
            axios.post(APP_URL + "/tablero/dagenciaviajes/admin/storebsm",form_data).then(response=>{
                let id_registro = $("#registro-actual-editandose").val();
                let registro_editado = $("#" +id_registro).val() ;
                $("#deuda-id-"+response.data.id).attr("checked",false);
                console.log(response.data);
                $("#deuda-id-"+response.data.id+"-total").text(response.data.porpagar);
                /* cambio tag */
                if (response.data.porpagar == 0) {
                    $("#deuda-id-"+response.data.id+"-tag").text("Pagada");
                    $("#deuda-id-"+response.data.id+"-tag").removeClass("label-danger");
                    $("#deuda-id-"+response.data.id+"-tag").addClass("label-success");
                } else {
                    $("#deuda-id-"+response.data.id+"-tag").text("Por Cobrar");
                }
                $(".modale").fadeOut(200);
                editarMultiplesReistros();
                $("#registro-actual-editandose").val("");
                $("#montom").val("");
                $("table.cdata > tbody > tr").remove();
            })
        }
        //fin funciones jose

        function BuscarPagos(h,i,j){
            /*consulta a base de datos para traer el detalle de los pagos*/
            var codigo = i;
            var ticket = j;
            var suma=0;
            var APP_URL = {!!json_encode(url('/'))!!};
            $.get(APP_URL+'/tablero/dagenciaviajes/getdcobros/' + codigo+ '/'+ ticket, function (pagos) {
                console.log(pagos);
                $("#cdata > tbody > tr").remove()
                $.each(pagos, function(i, item) {
                    var tr = $('<tr>').append(
                        $("<td><input class='form-control otrasFilas ouput_linea' type='text' name='abono[]' value='"+item.abono+"' readonly>"),
                        $("<td><input class='form-control otrasFilas' type='text' name='tipop[]' value='"+item.tipo_pago+"' readonly>"),
                        $("<td><input class='form-control otrasFilas' type='text' name='bancoe[]' value='"+item.banco_emisor+"' readonly>"),
                        $("<td><input class='form-control otrasFilas' type='text' name='bancor[]' value='"+item.banco_receptor+"' readonly>"),
                        $("<td><input class='form-control otrasFilas' type='text' name='dosnroperacion[]' value='"+item.nro_operacion+"' readonly>"),
                        $("<td><button type='button' value='' name='button_eliminar_producto' id='button_eliminar_producto' class='btn btn-danger otrasFilas button_eliminar_producto'> Eliminar </button>")
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
                    $("#cdata").append(tr);
                });
                $.each(pagos, function(i, item) {

                    suma = suma + parseInt(item.abono);
                });
                pCalculo(h,suma);

            });
            $.get(APP_URL+'/tablero/dagenciaviajes/getdeuda/' + codigo+ '/'+ ticket, function (pagos) {
                //console.log(pagos);
                $.get(APP_URL+'/tablero/dagenciaviajes/getconso/' + pagos.consolidadores_id, function (conso) {
                    //console.log(conso);
                    $('#proveedor').val(conso.nombre);
                });
                $('#fecha').val(pagos.fecha);
                $('#codigo').val(pagos.venta_boleto_id);
                $('#ticket').val(pagos.nro_ticket);
                $('#mfacturar').val(pagos.tarifa_fee);
                $('#dias').val(pagos.diasc);
                $('#mresta').val(pagos.porpagar);
            });

            $(".modale").fadeIn(100);
        };
        function pCalculo(h,suma){
            var validate1 = $("#mfacturar");

            /*consulta a base de datos para traer el detalle de los pagos*/
            if (suma == 0) {
                $("#mresta").val(validate1.val());
                $(".restaenv").val(validate1.val());
            } else {
                var restay = validate1.val() - suma;
                $("#mresta").val(restay);
                $(".restaenv").val(restay);
            }

            /*$("#mresta"+h).val(restay);
             $(".restaenv"+h).val(restay);*/
            $("#mtotal").val(suma);
        };
        $(document).ready(function(){


            $(".micheckbox").on( 'change', function() {
                if( $(this).is(':checked') ) {
                    var a = $(this).val();
                    var b = $('#sl').val();
                    var c = parseFloat(a) + parseFloat(b);
                    $('#sl').val(c.toFixed(3));
                } else {
                    var a = $(this).val();
                    var b = $('#sl').val();
                    var c = parseFloat(b) - parseFloat(a);
                    $('#sl').val(c.toFixed(3));
                }

                if ($(".micheckbox:checked").length > 1) {
                    $("#editar-multiples-registros").css("display","block");
                }else{
                    $("#editar-multiples-registros").css("display","none");
                }
            });


            $(".abrir").click(function(){
                var valor = $(this).val().split('Ç');
                var h = valor[0]+valor[2];
                var e = valor[1];
                var i = valor[0]
                var j = valor[2];
                $(".otrasFilas").parents('tr').remove();
                BuscarPagos(h,i,j);
                if(e > 0){
                    $(".registrar").attr('disabled',true);
                }
            });
            $(".cerrar").click(function(){
                var h = $(this).val();
                $(".modale").fadeOut(300);

            });
            $(".debitar").click(function(e){
                e.preventDefault();
                var h = $(this).val();
                var validate1= $("#mfacturar");
                var validate2= $("#mresta");
                var validate3= $("#mtotal");
                var validate4= $("#montom");
                var ouput1 = $('.tipop');
                if(validate2.val() == 0){
                    toastr.info("¡Ya se ha pagado la totalidad de la deuda!");
                }else{
                    if(ouput1.val() <= 0){
                        toastr.warning("Debe seleccionar un tipo de pago");
                    }else{
                        if(validate4.val() <=0 ){
                            toastr.warning("Debe reflejar un monto a ser pagado");
                        }else{
                            var restax= validate1.val() - validate3.val();
                            if(restax  < 0){
                                toastr.warning("El monto supera el total a pagar");
                            }else{
                                var importe_total = 0
                                $(".ouput_linea").each(
                                    function(index, value) {
                                        importe_total = importe_total + eval($(this).val());
                                    }
                                );
                                if(importe_total >= 1){
                                    var restay=  validate2.val() - validate4.val();
                                    if(restay < 0){
                                        toastr.warning("El monto supera el total que resta");
                                    }else {
                                        /*alternativa*/
                                        var ouput1 = $('#montom');
                                        var ouput2 = $('.tipop');
                                        var ouput3 = $('#bancoe');
                                        var ouput4 = $('#bancor');
                                        var ouput5 = $('#noperacion');
                                        toastr.info("Se adicionó un registro con Abono de "+ouput1.val());
                                        var array = [ouput1.val(), ouput2.val(),ouput3.val(),ouput4.val(),ouput5.val()];
                                        var i=0;

                                        $.each(document.querySelectorAll("#cdata tbody"), function(index, val) {
                                            if(i< array.length)
                                                $(val).append("<tr>" +
                                                    "<td><input class='form-control otrasFilas ouput_linea'  type='text' name='abono[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                    "<td><input class='form-control otrasFilas' type='text' name='tipop[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                    "<td><input class='form-control otrasFilas' type='text' name='bancoe[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                    "<td><input class='form-control otrasFilas' type='text' name='bancor[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                    "<td><input class='form-control otrasFilas' type='text' name='dosnroperacion[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                    "<td><button type='button' value='' name='button_eliminar_producto' id='button_eliminar_producto' class='btn btn-danger otrasFilas button_eliminar_producto'> Eliminar </button></td></tr>");
                                        });
                                        var v = "0";
                                        var x = "";
                                        $('#tipop').val(v);
                                        $('#montom').val(v);
                                        $('#bancoe').attr('disabled',true).val(x);
                                        $('#bancor').attr('disabled',true).val(x);
                                        $('#noperacion').attr('disabled','true').val(x);

                                        var importe_total = 0;
                                        $(".ouput_linea").each(
                                            function(index, value) {
                                                importe_total = importe_total + eval($(this).val());
                                            }
                                        );
                                        var restay= validate1.val() - importe_total;
                                        $("#mresta").val(restay);
                                        $(".restaenv").val(restay);
                                        $("#mtotal").val(importe_total);
                                        /*alternativa*/

                                    }
                                }else{
                                    var importe_total = 0
                                    $(".ouput_linea").each(
                                        function(index, value) {
                                            importe_total = importe_total + eval($(this).val());
                                        }
                                    );
                                    var restay= (validate2.val() - validate1.val());
                                    if(restay < 0){
                                        toastr.warning("El monto supera el total que resta");
                                    }else{
                                        var importe_total = 0
                                        $(".ouput_linea").each(
                                            function(index, value) {
                                                importe_total = importe_total + eval($(this).val());
                                            }
                                        );
                                        var restay= validate2.val() - importe_total;
                                        if(restay < 0){
                                            toastr.warning("El monto supera el total que resta");
                                        }else{
                                            var ouput1 = $('#montom');
                                            var ouput2 = $('.tipop');
                                            var ouput3 = $('#bancoe');
                                            var ouput4 = $('#bancor');
                                            var ouput5 = $('#noperacion');
                                            toastr.info("Se adicionó un registro con Abono de "+ouput1.val());
                                            var array = [ouput1.val(), ouput2.val(),ouput3.val(),ouput4.val(),ouput5.val()];
                                            var i=0;
                                            $.each(document.querySelectorAll("#cdata tbody"), function(index, val) {
                                                if(i< array.length)
                                                    $(val).append("<tr>" +
                                                        "<td><input class='form-control otrasFilas ouput_linea' type='text' name='abono[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                        "<td><input class='form-control otrasFilas' type='text' name='tipop[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                        "<td><input class='form-control otrasFilas' type='text' name='bancoe[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                        "<td><input class='form-control otrasFilas' type='text' name='bancor[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                        "<td><input class='form-control otrasFilas' type='text' name='dosnroperacion[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                                                        "<td><button type='button' value='' name='button_eliminar_producto' id='button_eliminar_producto' class='btn btn-danger otrasFilas button_eliminar_producto'> Eliminar </button></td></tr>");
                                            });
                                            var importe_total = 0
                                            $(".ouput_linea").each(
                                                function(index, value) {
                                                    importe_total = importe_total + eval($(this).val());
                                                }
                                            );
                                            var restay= validate1.val() - validate4.val();

                                            $("#mresta").val(restay);
                                            $(".restaenv").val(restay);
                                            $("#mtotal").val(importe_total);

                                            var v = "0";
                                            var x = "";
                                            $('#tipop').val(v);
                                            $('#montom').val(v);
                                            $('#bancoe').attr('disabled',true);
                                            $('#bancor').attr('disabled',true);
                                            $('#noperacion').attr('disabled','true').val(x);
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
                var validate1 = $("#mfacturar");
                $(".ouput_linea").each(
                    function (index, value) {
                        importe_total = importe_total + eval($(this).val());
                    }
                );
                //toastr.info(importe_total);
                $("#mresta").val(validate1.val() - importe_total);
                $(".restaenv").val(validate1.val() - importe_total);

                $("#mtotal").val(importe_total);
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
        });
    </script>

@endsection

@section('content')

    <div>
        <div style="background-color: #fff; min-height: 700px" class="padding_box1">
            <div class="row">

                <form class="form-horizontal" role="form" method="POST" action="{{route('manageDagenciaviajessm-A-fecha')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div style="margin-left: 20px" class="col-md-4"><label>Desde:</label>
                        <div class="form-group {{ $errors->has('fechai') ? ' has-error' : '' }} has-feedback">

                            <input type="date" class="form-control" name="fechai" id="fecha_desde_iframe" value="{{$fechai}}" placeholder="Fecha" >

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
                            <input type="date" class="form-control" name="fechaf" id="fecha_hasta_iframe" value="{{$fechaf}}" placeholder="Fecha" >

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

                <div class="col-md-10">
                    <div class="x_title">
                        <h3><i class="fa fa-ticket"></i> Consultar deuda de agencia de viajes</h3> <button onclick="editarMultiplesReistros()" style="display: none" id="editar-multiples-registros" class="btn btn-xs btn-danger">Editar Multile</button>
                        <div class="clearfix"></div>
                        <input type="text" id="registro-actual-editandose">
                    </div>
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

            @if (count($deuagenciasv) > 0)

                <div class="table-responsive">
                    <table class="table" id="pconsolidadores" >
                        <thead>
                        <tr>
                            <th class="col-md-1">Selec.</th>
                            <th class="col-md-2">Registro</th>
                            <th class="col-md-2">Venta Boleto ID</th>
                            <th style="display: none;" class="col-md-2">Nro de Ticket</th>
                            <th style="display: none;" class="col-md-1">DNI</th>
                            <th class="col-md-2">Pasajero</th>
                            <th class="col-md-2">Linea Aerea</th>
                            <th class="col-md-2">Ruta</th>
                            <th style="display: none;" class="col-md-1">Consolidador</th>
                            <th class="col-md-1">Agencia de Viajes</th>
                            <th class="col-md-1">Tarifa FEE</th>
                            <th class="col-md-1">Por Cobrar</th>
                            <th class="col-md-1">Agente</th>
                            <th class="col-md-1">Dias por cobrar</th>
                            <th class="col-md-2">Estatus</th>
                            <th class="col-md-2">Acciones</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($deuagenciasv as $deuagencias)
                            <tr>
                                <td><input type="checkbox" class="micheckbox" name="" id="deuda-id-{{$deuagencias->id}}" value="{{$deuagencias->tarifa_fee}}"></td>
                                <td>{{$deuagencias->fecha}}</td>
                                <td>{{$deuagencias->venta_boleto_id}}</td>
                                <td style="display: none;">{{$deuagencias->nro_ticket}}</td>
                                <td style="display: none;">{{$deuagencias->dni_ruc}}</td>
                                <td>{{$deuagencias->nombre_cliente}}</td>
                                <td>@if(!empty($deuagencias->laereas->nombre))
                                        {{$deuagencias->laereas->nombre}}
                                    @else
                                        Esta Linea Aerea Ya no Existe
                                    @endif
                                    </td>
                                <td>{{$deuagencias->ruta}}</td>
                                <td  style="display: none;">@if(!empty($deuagencias->consolidadores->nombre))
                                        {{$deuagencias->consolidadores->nombre}}
                                    @else
                                        Este consolidador Ya no Existe
                                    @endif
                                    </td>
                                <td><button name="capturar" id="capturar" class="capturar btn btn-warning" value="{{$deuagencias->aviajes_id}}">{{$deuagencias->aviajes_id}}</button></td>
                                <td id="deuda-id-{{$deuagencias->id}}-tarifaf">{{$deuagencias->tarifa_fee}}<input type="hidden" class="tf" value="{{$deuagencias->tarifa_fee}}"></td>
                                <td id="deuda-id-{{$deuagencias->id}}-total">{{$deuagencias->porpagar}}<input type="hidden" class="pc" value="{{$deuagencias->porpagar}}"></td>
                                <td>{{$deuagencias->agentes_id}}</td>
                                <td>{{$deuagencias->diasc}}</td>
                                <td >
                                    @if ($deuagencias->status== "1")
                                        <span id="deuda-id-{{$deuagencias->id}}-tag" class="label label-success">Pagada</span>
                                    @else
                                        <span id="deuda-id-{{$deuagencias->id}}-tag" class="label label-danger">Por Cobrar</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-xs btn abrir" value="{{$deuagencias->venta_boleto_id}}Ç{{$deuagencias->status}}Ç{{$deuagencias->nro_ticket}}" href="" data-toggle="tooltip" data-placement="left" title="Editar cuenta por cobrar">
                                        <i class="fa fa-pencil fa-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>
            @else
                <div class="alert alert-block alert-info" style="margin-top: 44px;">
                    <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                    <p class="margin-bottom-10">
                        No existen items registrados en el sistema.
                    </p>
                </div>

            @endif
            <div class="row">
                <hr>
                <div class="col-md-6">
                    <span class="h3 text-red">{{count($contadorr)}}</span><span class="h4"> Cuentas por Cobrar</span>
                </div>
                <div style="text-align: right;" class="col-md-3">
                    <br>
                    <span class="h4">TOTAL </span><div></div>
                    <br>
                    <span class="h4">Por Cobrar </span><div></div>
                    <br>
                    <span class="h4">Seleccionados </span><div></div>
                </div>
                <div style="background-color: #fafafa;" class="col-md-3">
                    <span class="h4 text-red"><input class="h3 text-red transparenteinput" value="0" name="tf" id="tf" readonly></span><div></div>
                    <span class="h4 text-red"><input class="h3 text-red transparenteinput" value="0" name="pc" id="pc" readonly></span><div></div>
                    <span class="h4 text-red"><input class="h3 text-red transparenteinput" value="0" name="sl" id="sl" readonly></span><div></div>
                </div>
            </div>

        </div>
    </div>

    <!----------------------------MODAL-------------------------------->

    <div class="modal-lg modal modale">
        <div style="width: 70%;margin-left: 15%" class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cerrar" value="" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-file-text"></i> Modificar cuenta por Cobrar</h4></h4>
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
                                        <form class="form-horizontal row" id="form_edit_cuenta_por_cobrar" role="form" method="POST" {{-- action="{{ route('web.hp') }}" --}} enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <input type="hidden" class="form-control" name="fechai" value="{{$fechai}}">
                                            <input type="hidden" class="form-control" name="fechaf" value="{{$fechaf}}">

                                            <div class="col-sm-2">
                                                <label class="pull-right">Proveedor</label>
                                            </div>
                                            <div class="col-sm-10 mods_input">
                                                <div class="form-group {{ $errors->has('proveedor') ? ' has-error' : '' }}">
                                                    <input type="text" name="proveedor" id="proveedor" value="" required class="form-control" readonly>
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
                                                    <input type="text" class="form-control" name="fecha" id="fecha" value="" placeholder="Fecha" readonly>

                                                    <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                    @if ($errors->has('fecha'))
                                                        <span class="help-block">
                                      <strong>{{ $errors->first('fecha') }}</strong>
                                  </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <label style="font-size: 12px;" class="pull-right">Nro de Cotizacion</label>
                                            </div>
                                            <div class="col-sm-10 mods_input">
                                                <div class="form-group {{ $errors->has('codigo') ? ' has-error' : '' }} has-feedback">
                                                    <input type="text" class="form-control" name="codigo" id="codigo" value="" placeholder="Codigo" readonly>

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
                                                    <input type="text" class="form-control" name="ticket" id="ticket" value="" placeholder="ticket" readonly>

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
                                                    <input type="number" step="any" class="form-control" name="mfacturar" id="mfacturar" value="" placeholder="Monto" readonly>

                                                    <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                    @if ($errors->has('monto'))
                                                        <span class="help-block">
                                      <strong>{{ $errors->first('monto') }}</strong>
                                  </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="pull-right">Diás Cobrar</label>
                                            </div>
                                            <div class="col-sm-10 mods_input">
                                                <div class="form-group {{ $errors->has('dias') ? ' has-error' : '' }} has-feedback">
                                                    <input type="number" class="form-control" name="dias" id="dias" value="" placeholder="Dias para Cobrar" readonly>

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
                                                    <select name="tipop" id="tipop" class="form-control tipop" required >
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
                                                <label class="pull-right">Bnaco Emisor</label>
                                            </div>
                                            <div class="col-sm-10 mods_input">
                                                <div class="form-group {{ $errors->has('bancoe') ? ' has-error' : '' }}" id="disable1">
                                                    <select name="bancoe" id="bancoe"  required class="form-control" disabled>
                                                        <option value="">Selecciona el Banco Emisor</option>
                                                        @foreach($bancosg as $bancog)
                                                            <option value="{{$bancog->banco}}">{{$bancog->banco}}</option>
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
                                                <div class="form-group {{ $errors->has('bancor') ? ' has-error' : '' }}" id="disable2">
                                                    <select name="bancor" id="bancor"  required class="form-control" disabled>
                                                        <option value="">Selecciona el Banco Receptor</option>
                                                        @foreach($bancos as $banco)
                                                            <option value="{{$banco->banco}}">{{$banco->banco}}</option>
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
                                            <div class="col-sm-2">
                                                <label class="pull-right">Abono</label>
                                            </div>
                                            <div class="col-sm-10 mods_input">
                                                <div class="form-group {{ $errors->has('abono') ? ' has-error' : '' }} has-feedback">
                                                    <input type="number" class="form-control" name="montom" id="montom" value="" placeholder="abono" >
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
                                                    <input type="number" class="form-control" name="mtotal" id="mtotal" value="0" placeholder="tabono" readonly>
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
                                                    <input type="number" step="any" class="form-control" name="mresta" id="mresta" value="0" placeholder="resta" readonly>
                                                    <input type="hidden" class="restaenv" name="restaenv" id="restaenv" value="" >
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
                                                <button id="debitar" value=""  name="debitar"  class="btn label-success pull-center debitar">
                                                    Debitar </button>
                                                <br>
                                            </div>
                                            <div>
                                                <br>
                                                <table class="table table-responsive table-bordered table-condensed cdata" id="cdata" name="cdata">
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
                                                <a onclick="enviarFormStore()" type="submit" id="registrar" name="registrar" class="btn btn-success pull-right registrar">
                                                        Registrar <i class="fa fa-arrow-circle-right"></i>
                                                </a>
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
                <button type="button" class="btn cerrar btn-warning" value="" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>






    <!----------------------------MODAL-------------------------------->
    <div class="modal-lg modal modalFiltro">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cerrarFiltro" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h5 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-filter"></i> Filtros Generales </h4></h5>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form" method="POST" action="{{ route('manageDagenciaviajes-A-busquedagsm')}}" enctype="multipart/form-data">
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
                                    <div class="col-sm-4"><H4>Vendedor</H4></div>
                                    <div class="col-sm-8">
                                        <div class="blokselect">
                                            <ul>
                                                @foreach($vendedor as $vende)
                                                    <?php $corto = str_replace(' ','',$vende->nombres.' '.$vende->apellidos)?>
                                                    <li><input type="checkbox" class="vendedor{{$corto}} Ç {{$vende->nombres.' '.$vende->apellidos}} Ç check" name="vendedor[]" value="">{{$vende->nombres.' '.$vende->apellidos}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <!--<div class="row">
                                    <div style="text-align: right;" class="col-sm-4"><H4>DNI/RUC</H4></div>
                                    <div class="col-sm-8">
                                        <input type="text" name="dni" id="dni" class="form-control" style="margin-top: 7px"/>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>-->
                                <div class="row">
                                    <div style="text-align: right;" class="col-sm-4"><H4>Pasajero</H4></div>
                                    <div class="col-sm-8">
                                        <input type="text" name="pasajero" id="pasajero" class="form-control" style="margin-top: 7px"/>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row">
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
    <!----------------------------MODAL-------------------------------->
    </div>
@endsection

