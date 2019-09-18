@extends('layouts.master')
@section('titulo', 'Cobros')
@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('script')

<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<script type="text/javascript">
    $(function () {
        $('#cobros').DataTable({
           "paging": true,
           "lengthChange": true,
           "searching": true,
           "ordering": false,
           "info": true,
           "lengthMenu": [ 50,100, 200, 500],

           "autoWidth": true,
           scrollY:        '30vh',
       });

    });
    function BuscarCobros(h){
        /*consulta a base de datos para traer el detalle de los pagos*/
        var dni_ruc = h;
        var cont=0;
        var suma=0;
        var APP_URL = {!!json_encode(url('/'))!!};

        $.get(APP_URL+'/tablero/porCobrar/getdcobros/' + dni_ruc, function (cobros) {
            console.log(cobros);

            $.each(cobros, function(i, item) {
                var tr = $('<tr>').append(
                    $("<td><input class='form-control otrasFilas ouput_linea"+h+"' type='text' name='abono[]' value='"+item.abono+"' readonly>"),
                    $("<td><input class='form-control otrasFilas' type='text' name='tipop[]' value='"+item.tipo_pago+"' readonly>"),
                    $("<td><input class='form-control otrasFilas' type='text' name='bancoe[]' value='"+item.banco_emisor+"' readonly>"),
                    $("<td><input class='form-control otrasFilas' type='text' name='bancor[]' value='"+item.banco_receptor+"' readonly>"),
                    $("<td><input class='form-control otrasFilas' type='text' name='dosnroperacion[]' value='"+item.nro_operacion+"' readonly>"),
                    $("<td><button type='button' value='"+h+"' name='button_eliminar_producto' id='button_eliminar_producto' class='btn btn-danger otrasFilas button_eliminar_producto'> Eliminar </button>")
                    );
                   
                     $("#mdata"+h).append(tr);
                 });
            $.each(cobros, function(i, item) {

                suma = suma + parseInt(item.abono);
            });
            pCalculo(h,suma);
            $(".modale"+h).fadeIn(100);
        });
    };
    function pCalculo(h,suma){
        var validate1 = $("#mfacturar" + h).val();
        /*consulta a base de datos para traer el detalle de los pagos*/
        if (suma == 0) {
            $("#mresta"+h).val(validate1);
            $("#restaenv").val(validate1);
        } else {
            var restay = validate1 - suma;
            $("#mresta"+h).val(restay);
            $("#restaenv").val(restay);
        }
        $("#mresta" + h).val(restay);
        $("#restaenv").val(restay);
        $("#mtotal" + h).val(suma);
    };
    $(document).ready(function(){
        $(".abrir").click(function(){
            var valor = $(this).val().split('Ç');
            var h = valor[0];
            var e = valor[1];

            $(".otrasFilas").parents('tr').remove();
            BuscarCobros(h);

            if(e != 0){
                $('.submit').attr('disabled',true);
            }

        });
        $(".cerrar").click(function(){
            var h = $(this).val();
            $(".modale"+h).fadeOut(300);

        });
        $("#debitar").click(function(e){
            e.preventDefault();
            var h = $(this).val();
            var validate1= $("#mfacturar"+h);
            var validate2= $("#mresta"+h);
            var validate3= $("#mtotal"+h);
            var validate4= $("#montom"+h);
            var ouput1 = $('#tipop');
            if(validate2.val() == 0){
                toastr.warning ("¡Ya se ha pagado la totalidad de la deuda!");
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
                            $(".ouput_linea"+h).each(
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
                                    var ouput1 = $('#montom'+h);
                                    var ouput2 = $('#tipop');
                                    var ouput3 = $('#bancoe'+h);
                                    var ouput4 = $('#bancor'+h);
                                    var ouput5 = $('#noperacion'+h);
                                    toastr.warning ("Se va a adicionar un registro con Abono de"+ouput1.val());
                                    var array = [ouput1.val(), ouput2.val(),ouput3.val(),ouput4.val(),ouput5.val()];
                                    var i=0;

                                    $.each(document.querySelectorAll("#mdata"+h+" tbody"), function(index, val) {
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
                                    $("#restaenv").val(restay);
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
                                    toastr.warning("El monto supera el total que resta");
                                }else{
                                    var importe_total = 0
                                    $(".ouput_linea"+h).each(
                                        function(index, value) {
                                            importe_total = importe_total + eval($(this).val());
                                        }
                                        );
                                    var restay= validate2.val() - importe_total;
                                    if(restay < 0){
                                        toastr.warning("El monto supera el total que resta");
                                    }else{
                                        var ouput1 = $('#montom'+h);
                                        var ouput2 = $('#tipop');
                                        var ouput3 = $('#bancoe'+h);
                                        var ouput4 = $('#bancor'+h);
                                        var ouput5 = $('#noperacion'+h);
                                        toastr.warning ("Se va a adicionar un registro con Abono de"+ouput1.val());
                                        var array = [ouput1.val(), ouput2.val(),ouput3.val(),ouput4.val(),ouput5.val()];
                                        var i=0;
                                        $.each(document.querySelectorAll("#mdata"+h+" tbody"), function(index, val) {
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
                                        $("#restaenv").val(restay);
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
$('.mdata').on('click', '.button_eliminar_producto', function() {
    var h = $(this).val();
    $(this).parents('tr').eq(0).remove();
    var importe_total = 0
    var validate1 = $("#mfacturar" + h);
    $(".ouput_linea"+h).each(
        function (index, value) {
            importe_total = importe_total + eval($(this).val());
        }
        );
    toastr.warning(importe_total);
    $("#mresta" + h).val(validate1.val() - importe_total);
    $("#restaenv").val(validate1.val() - importe_total);

    $("#mtotal" + h).val(importe_total);
});
/*$("#totalpagar").val(importe_total);*/
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("select[name=tipop]").change(function(e){
            e.preventDefault();
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
<style type="text/css">
.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box padding_box1">
            <div class="row">
                <div class="col-md-10">
                    <div class="x_title">
                        <h2><i class="fa fa-file-text"></i> Consultar cuentas por Cobrar</h2>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 24px;">
                    <a href="{{ route('manageCobro-C-A') }}" class="btn btn-danger"><i class="fa fa-plus" data-toggle="tooltip" data-placement="left" title="Nueva Cuenta por cobrar"></i></a>
                </div>
                <div class="col-md-4"><label>Lista de cuentas por Cobrar</label>

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
                <?php
                if( count($cobros) >0){
                    ?>
                    <table class="table" id="cobros" >
                        <thead style="background-color: #dd4b39; color: white; ">
                            <tr>
                                <th class="col-md-2 text-center">Id</th>
                                <th class="col-md-2">DNI/RUC</th>
                                <th class="col-md-2">Nombre</th>
                                <th class="col-md-2">Dias por pagar</th>
                                <th class="col-md-2">Monto</th>
                                <th class="col-md-2">Estatus</th>
                                <th class="col-md-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cobros as $cobro)
                            <tr>
                                <td class="text-center">{{$cobro->id}}</td>
                                <td>{{$cobro->dni_ruc}}</td>
                                <td>{{$cobro->cliente_id}}</td>
                                <td>{{$cobro->dias}}</td>
                                <td>{{$cobro->monto}}</td>
                                <td>
                                    @if ($cobro->status== "1")
                                    <span class="label label-success">Pagada</span>
                                    @else
                                    <span class="label label-danger">Aun no se paga</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-xs btn abrir" value="{{$cobro->dni_ruc}}Ç{{$cobro->status}}" href="" data-toggle="tooltip" data-placement="left" title="Modificar cuenta por Cobrar">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <?php
                    echo str_replace('/?', '?', $cobros->render());
                }else{
                    ?>
                    <br/><div class='rechazado'><label style='color:#FA206A'>...No se ha encontrado ningun registro...</label>  </div>
                    <?php
                }
                ?>
            </div>
            <div class="row">
                <hr>
                <div class="col-md-2">
                    <span class="h3 text-red">{{$cobrosc}}</span><div></div>
                    <span class="h4"> Cuentas por cobrar</span>
                </div>
                <div class="col-md-2">
                    <span class="h3 text-red">{{$cobrost}}</span><div></div>
                    <span class="h4"> Total de cuentas por cobrar</span>
                </div>
            </div>
        </div>
    </div>
    @foreach ($cobros as $cobro)
    <div class="modal-lg modal modale{{$cobro->dni_ruc}}" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cerrar" value="{{$cobro->dni_ruc}}" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-file-text"></i> Modificar cuenta por cobrar</h4></h4>
            </div>
            <div class="modal-body">

                @section('script')
                <script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>
                <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
                <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
                @endsection
                <form class="form-horizontal row" role="form" method="POST" action="{{ route('manageCobro-storeb-A') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('userid') ? ' has-error' : '' }} has-feedback">
                                <label  class="col-sm-4 control-label">DNI/RUC</label>

                                <div class="col-sm-8">
                                 <input type="text" class="form-control" id="userid" name="userid" value="{{$cobro->dni_ruc}}" placeholder="DNI/RUC" readonly required>
                                 <span class="fa  fa-barcode form-control-feedback right" aria-hidden="true"></span>
                                 @if ($errors->has('userid'))
                                 <span class="help-block">
                                  <strong>{{ $errors->first('userid') }}</strong>
                              </span>
                              @endif

                          </div>
                      </div>
                      <div class="form-group {{ $errors->has('fecha') ? ' has-error' : '' }} has-feedback">
                          <label class="col-sm-4 control-label">Fecha</label>
                          <div class="col-sm-8">
                               <input type="date" class="form-control" name="fecha" id="fecha" value="{{$cobro->fecha}}" placeholder="Fecha" readonly>

                                                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                            @if ($errors->has('fecha'))
                                                                <span class="help-block">
                                      <strong>{{ $errors->first('fecha') }}</strong>
                                  </span>
                                                            @endif
                          </div>
                      </div>
                      
                      
                       <div class="form-group {{ $errors->has('tipop') ? ' has-error' : '' }}">
                          <label class="col-sm-4 control-label">Tipo de Cobro</label>
                          <div class="col-sm-8">
                               <select name="tipop" id="tipop" required class="form-control">
                                                                <option value="0">Selecciona el Tipo de Cobro</option>
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
                       <div class="form-group {{ $errors->has('bancoe') ? ' has-error' : '' }}" id="disable1">
                          <label class="col-sm-4 control-label">Banco Emisor</label>
                          <div class="col-sm-8">
                               <select name="bancoe{{$cobro->dni_ruc}}" id="bancoe{{$cobro->dni_ruc}}"  required class="form-control" disabled>
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
                       <div class="form-group {{ $errors->has('noperacion') ? ' has-error' : '' }} has-feedback" id="disable3">
                          <label class="col-sm-4 control-label">Nro de Operacion</label>
                          <div class="col-sm-8">
                               <input type="text" class="form-control" name="noperacion{{$cobro->dni_ruc}}" id="noperacion{{$cobro->dni_ruc}}" id="Nro peración" value="" placeholder="noperacion" disabled>

                                                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                            @if ($errors->has('noperacion'))
                                                                <span class="help-block">
                                      <strong>{{ $errors->first('noperacion') }}</strong>
                                  </span>
                                                            @endif
                          </div>
                      </div>
                        <div class="form-group  {{ $errors->has('tabono') ? ' has-error' : '' }} has-feedback">
                          <label class="col-sm-4 control-label">Total Abono</label>
                          <div class="col-sm-8">
                               <input type="number" class="form-control" name="mtotal{{$cobro->dni_ruc}}" id="mtotal{{$cobro->dni_ruc}}" value="0" placeholder="tabono" readonly>
                                                            <input type="hidden" class="form-control" name="tabonosum" id="tabonosum" value="0" placeholder="abono" >

                                                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                            @if ($errors->has('tabono'))
                                                                <span class="help-block">
                                      <strong>{{ $errors->first('tabono') }}</strong>
                                  </span>
                                                            @endif
                          </div>
                      </div>

                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                          <label class="col-sm-4 control-label">Cliente</label>
                          <div class="col-sm-8">
                               <input type="text" class="form-control" id="nombre" name="nombre" value="{{$cobro->cliente_id}}" placeholder="Nombre" readonly required>
                                                               
                                                                @if ($errors->has('nombre'))
                                                                    <span class="help-block">
                                                      <strong>{{ $errors->first('nombre') }}</strong>
                                                  </span>
                                                                @endif
                          </div>
                      </div>
                       <div class="form-group  {{ $errors->has('monto') ? ' has-error' : '' }} has-feedback">
                          <label class="col-sm-4 control-label">Monto</label>
                          <div class="col-sm-8">
                              <input type="number" step="any" class="form-control" name="mfacturar{{$cobro->dni_ruc}}" id="mfacturar{{$cobro->dni_ruc}}" value="{{$cobro->monto}}" placeholder="Monto" readonly>

                                                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                            @if ($errors->has('monto'))
                                                                <span class="help-block">
                                      <strong>{{ $errors->first('monto') }}</strong>
                                  </span>
                                                            @endif
                          </div>
                      </div>
                       <div class="form-group {{ $errors->has('dias') ? ' has-error' : '' }} has-feedback">
                          <label class="col-sm-4 control-label">Dias a pagar</label>
                          <div class="col-sm-8">
                               <input type="number" class="form-control" name="dias{{$cobro->dni_ruc}}" id="dias{{$cobro->dni_ruc}}" value="{{$cobro->dias}}" placeholder="Dias para Pagar" readonly>

                                                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                            @if ($errors->has('dias'))
                                                                <span class="help-block">
                                      <strong>{{ $errors->first('dias') }}</strong>
                                  </span>
                                                            @endif
                          </div>
                      </div>
                      
                     
                       <div class="form-group  {{ $errors->has('bancor') ? ' has-error' : '' }}" id="disable2">
                          <label class="col-sm-4 control-label">Banco Receptor</label>
                          <div class="col-sm-8">
                               <select name="bancor{{$cobro->dni_ruc}}" id="bancor{{$cobro->dni_ruc}}"  required class="form-control" disabled>
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
                       <div class="form-group {{ $errors->has('abono') ? ' has-error' : '' }} has-feedback">
                          <label class="col-sm-4 control-label">Abono</label>
                          <div class="col-sm-8">
                               <input type="number" class="form-control" name="montom{{$cobro->dni_ruc}}" id="montom{{$cobro->dni_ruc}}" value="" placeholder="abono" >
                                                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
                                                            @if ($errors->has('abono'))
                                                                <span class="help-block">
                                      <strong>{{ $errors->first('abono') }}</strong>
                                  </span>
                                                            @endif 
                          </div>
                      </div>
                       <div class="form-group {{ $errors->has('resta') ? ' has-error' : '' }} has-feedback">
                          <label class="col-sm-4 control-label">Resta</label>
                          <div class="col-sm-8">
                               <input type="number" step="any" class="form-control" name="mresta{{$cobro->dni_ruc}}" id="mresta{{$cobro->dni_ruc}}" value="0" placeholder="resta" readonly>
                                                            <input type="hidden" name="restaenv" id="restaenv" value="" >
                                                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                            @if ($errors->has('resta'))
                                                                <span class="help-block">
                                      <strong>{{ $errors->first('resta') }}</strong>
                                  </span>
                                                            @endif
                          </div>
                      </div>

                  </div>
                  <div class="text-center">
                      <button id="debitar" value="{{$cobro->dni_ruc}}"  name="debitar"  class="btn label-success ">
                                                            Debitar </button>
                  </div><br>
                   <table class="table table-responsive table-bordered table-condensed mdata" id="mdata{{$cobro->dni_ruc}}" name="mdata{{$cobro->dni_ruc}}">
                                                            <thead>
                                                            <tr>
                                                                <th class="text-center">Abono</th>
                                                                <th >Tipo de cobro</th>
                                                                <th >Banco Emisor</th>
                                                                <th >Banco Receptor</th>
                                                                <th >Nro de Operacion</th>
                                                                <th >*Acciones*</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
              </div>

          </div>

          <div class="modal-footer">
            <div class="form-actions">
                <button type="submit" id="submit" name="submit" class="btn submit btn-success ">
                    Registrar <i class="fa fa-arrow-circle-right"></i>
                </button>

                <button type="button" class="btn cerrar btn-warning" value="{{$cobro->dni_ruc}}" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>
</div>
@endforeach
</div>
@endsection

