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
        });
    </script>


@endsection

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box padding_box1">
               <div class="row">
                   <form class="form-horizontal" role="form" method="POST" action="{{route('managePconsolidadorif-A-fecha')}}" enctype="multipart/form-data">
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



                    <div class="table-responsive">
                    <table class="table" id="dc" name="dc">
                                <thead>
                                <tr>
                                    <th class="col-md-2">Acciones</th>
                                    <th class="col-md-2">Estatus</th>
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
                                    <th class="col-md-1">dias</th>


                                </tr>
                            </thead>

                        <tbody>
                        @foreach ($deupagosC as $deupagos)
                            <tr>
                                <td>  @if ($deupagos->status== "1")
                                    <button class="btn btn-warning btn-xs btn disbaled" value="{{$deupagos->id}}Ç{{$deupagos->nro_ticket}}Ç{{$deupagos->consolidadores->nombre}}Ç{{$deupagos->pago_consolidador}}Ç{{$deupagos->codigo}}" href="" data-toggle="tooltip" data-placement="left" title="Agregar a la Lista">
                                        <i class="fa fa-list-alt fa-lg"></i>
                                    </button>
                                    @else
                                        <button class="btn btn-warning btn-xs btn capturar" value="{{$deupagos->id}}Ç{{$deupagos->nro_ticket}}Ç{{$deupagos->consolidadores->nombre}}Ç{{$deupagos->pago_consolidador}}Ç{{$deupagos->codigo}}" href="" data-toggle="tooltip" data-placement="left" title="Agregar a la Lista">
                                            <i class="fa fa-list-alt fa-lg"></i>
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    @if ($deupagos->status== "1")
                                        <span class="label label-success">Pagada</span>
                                    @else
                                        <span class="label label-danger">Por Pagar</span>
                                    @endif
                                </td>
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
                                <td>@if(!empty($deupagos->consolidadores->nombre))
                                        {{$deupagos->consolidadores->nombre}}
                                    @else
                                        Este consolidador Ya no Existe
                                    @endif
                                    </td>
                                <td>{{$deupagos->aviajes_id}}</td>
                                <td>{{$deupagos->pago_consolidador}}<input type="hidden" class="pagoc" value="{{$deupagos->pago_consolidador}}"></td>
                                <td>{{$deupagos->porpagar}}<input type="hidden" class="" value="{{$deupagos->porpagar}}"></td>
                                <td>{{$deupagos->diasc}}</td>


                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                 </div>
                <div class="row">
                <hr>
                        <div class="col-md-6">
                            <span class="h4 text-red">{{$contadorr}}</span><span class="h4"> Cuentas por pagar</span>
                        </div>
                       <!-- <div style="text-align: right;" class="col-md-3">
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
                        </div>-->
                </div>

                </div>
    </div>
</div>


        <div class="modal-lg modal modalFiltro">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close cerrarFiltro" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-filter"></i> Filtros Generales </h4></h5>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('managePconsolidador-A-busquedagif')}}" enctype="multipart/form-data">
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
@endsection

