@extends('layouts.master')

@section('titulo', 'Cuentas por Cobrar')



@section('script')
<script src="{!! asset('js/jquery-3.2.1.min.js') !!}"></script>

<script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

<script type="text/javascript">
    $(document).ready(function () {
        $('#Modalagenciadev').DataTable({
            "iDisplayLength": 10,
            "bProcessing": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }
        });



        $("#abrir").click(function (e) {
            e.preventDefault();
            $(".modal").fadeIn();
        });
        $(".cerrar").click(function (e) {
            e.preventDefault();
            $(".modal").fadeOut(300);
        });
    });
</script>


<script type="text/javascript">
    $(".boton-dato").click(function (e) {
        e.preventDefault();
        var valor = $(this).val().split('Ç');
        $("#userid").val(valor[0]);
        $("#nombre").val(valor[1]);
        toastr.warning("Usted selecciono el cliente Nº " + valor[1]);
        $(".modal").fadeOut(300);
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#monto").keyup(function () {
            var x = $("#monto").val();
            $("#resta").val(x);
        });
    });


    $("#debitar").click(function (e) {
        e.preventDefault();
        var input1 = $('select#bancoe');
        var input2 = $('select#bancor');
        var input3 = $('#noperacion');
        var input4 = $('#abono');
        var input5 = $('select#tipop');
        var input6 = $('#concepto');
        var input7 = $('#tabono');
        var input8 = $('#monto');
        var input9 = $('#resta');
        var input10 = $('#codigo');
        var input11 = $('#dias');
        var input12 = $('#proveedor');

        if (input6.val() != '' && input10.val() != '' && input11.val() != '' && input12.val() != 0) {
            if (input5.val() <= 0) {
                toastr.warning('Debe seleccionar el tipo de pago');
            } else {
                if (input8.val() == input7.val()) {
                    toastr.warning('Ya se ha pagado el total de la deuda');
                } else {
                    if (parseFloat(input4.val()) <= 0) {
                        toastr.warning('El abono no puede ser menor que 1');
                    } else {
                        var resta = parseFloat(input8.val()) - parseFloat(input4.val());
                        if (resta < 0) {
                            toastr.warning('El el abono no puede ser mayor que el monto');
                        } else {
                            var importe_total = 0
                            $(".importe_linea").each(
                                function (index, value) {
                                    importe_total = importe_total + eval($(this).val());
                                }
                            );
                            /*alternativa*/
                            if (importe_total > 0) {
                                var restay = (input9.val() - input4.val());
                                if (restay < 0) {
                                    toastr.warning("El monto supera el total que resta");
                                } else {

                                    toastr.warning("Se va a adicionar un registro con concepto de Nº " + input4
                                        .val());
                                    var array = [input4.val(), input5.val(), input1.val(), input2.val(), input3
                                        .val()
                                    ];
                                    e.preventDefault();
                                    var i = 0;
                                    $.each(document.querySelectorAll("#data tbody"), function (index, val) {
                                        if (i < array.length)
                                            $(val).append("<tr>" +
                                                "<td><input class='importe_linea form-control' type='text' name='abono[]' value=" +
                                                "'" + array[i++] + "'" + "readonly></td>" +
                                                "<td><input class='form-control' type='text' name='tipo_pago[]' value=" +
                                                "'" + array[i++] + "'" + "readonly></td>" +
                                                "<td><input class='form-control' type='text' name='banco_emisor[]' value=" +
                                                "'" + array[i++] + "'" + "readonly></td>" +
                                                "<td><input class='form-control' type='text' name='banco_receptor[]' value=" +
                                                "'" + array[i++] + "'" + "readonly></td>" +
                                                "<td><input class='form-control' type='text' name='nro_operacion[]' value=" +
                                                "'" + array[i++] + "'" + "readonly></td>" +
                                                "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>"
                                            );
                                    });
                                    var importe_total = 0
                                    $(".importe_linea").each(
                                        function (index, value) {
                                            importe_total = importe_total + eval($(this).val());
                                        }
                                    );

                                    $("#tabono").val(importe_total);
                                    var x = parseFloat(input8.val()) - parseFloat(input7.val());
                                    $("#resta").val(x);
                                }
                            } else {
                                var restay = (input9.val() - input4.val());
                                if (restay < 0) {
                                    toastr.warning("El monto supera el total que resta1");
                                } else {

                                    toastr.warning("Se va a adicionar un registro con concepto de Nº " + input6
                                        .val());
                                    var array = [input4.val(), input5.val(), input1.val(), input2.val(), input3
                                        .val()
                                    ];
                                    e.preventDefault();
                                    var i = 0;
                                    $.each(document.querySelectorAll("#data tbody"), function (index, val) {
                                        if (i < array.length)
                                            $(val).append("<tr>" +
                                                "<td><input class='importe_linea form-control' type='text' name='abono[]' value=" +
                                                "'" + array[i++] + "'" + "readonly></td>" +
                                                "<td><input class='form-control' type='text' name='tipo_pago[]' value=" +
                                                "'" + array[i++] + "'" + "readonly></td>" +
                                                "<td><input class='form-control' type='text' name='banco_emisor[]' value=" +
                                                "'" + array[i++] + "'" + "readonly></td>" +
                                                "<td><input class='form-control' type='text' name='banco_receptor[]' value=" +
                                                "'" + array[i++] + "'" + "readonly></td>" +
                                                "<td><input class='form-control' type='text' name='nro_operacion[]' value=" +
                                                "'" + array[i++] + "'" + "readonly></td>" +
                                                "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>"
                                            );
                                    });
                                    var importe_total = 0
                                    $(".importe_linea").each(
                                        function (index, value) {
                                            importe_total = importe_total + eval($(this).val());
                                        }
                                    );

                                    $("#tabono").val(importe_total);
                                    var x = parseFloat(input8.val()) - parseFloat(input7.val());
                                    $("#resta").val(x);
                                }


                            }


                        }
                    }
                }
            }
        } else {
            toastr.warning("debe llenar todos los campos para procesar");
        }

    });

    $('#data').on('click', '.button_eliminar_producto', function () {
        $(this).parents('tr').eq(0).remove();

        var importe_total = 0
        $(".importe_linea").each(
            function (index, value) {
                importe_total = importe_total + eval($(this).val());
            }
        );
        $("#tabono").val(importe_total);
        var input7 = $('#tabono');
        var input8 = $('#monto');
        var x = parseFloat(input8.val()) - parseFloat(input7.val());
        $("#resta").val(x);
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("select[name=tipop]").change(function () {
            // alert($('select[name=tipop]').val());
            var a = $(this).val();

            if (a > 1) {
                $('#disable1').find('input, textarea, button, select').removeAttr("disabled");
                $('#disable2').find('input, textarea, button, select').removeAttr("disabled");
                $('#disable3').find('input, textarea, button, select').removeAttr("disabled");
            }
            if (a <= 1) {
                $('#disable1').find('input, textarea, button, select').prop("disabled", true);
                $('#disable2').find('input, textarea, button, select').prop("disabled", true);
                $('#disable3').find('input, textarea, button, select').prop("disabled", true);
            }


            //$('input[name=tipop]').val($(this).val());
        });
    });

    //$( "#neto" ).change(function() {
    //  var comision =(parseFloat($(valoreninput).val()) * parseFloat($(neto).val())) / 100;
    // $('#comi').val(comision);

    //});
</script>



@endsection

@section('content')


<div>

    <div id="wrapper">
        <div id="login" class=" form" style="background-color: #FFF; padding: 0 20px; border-radius: 10px;">
            <section class="login_content">
                <div class="clearfix"></div>

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
                <div class="row">
                    <div class="col-md-10">
                        <div class="x_title">
                            <h2><i class="fa fa-plus-circle"></i> Nueva cuenta por cobrar</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('manageCobro-store-A') }}"
                            enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <!------------------------------------------------>
                            <div>
                                <div class="box-header with-border">
                                    <h3 class="box-title">Información del Cliente </h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">

                                    <!------------------------------------------------>
                                    <div class="col-sm-2">
                                        <label class="pull-right">DNI/RUC</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group {{ $errors->has('userid') ? ' has-error' : '' }} has-feedback">
                                            <div class="col-md-11">
                                                <input type="text" class="form-control" id="userid" name="userid" value=""
                                                    placeholder="DNI/RUC" readonly required>
                                                <span class="fa  fa-barcode form-control-feedback right" aria-hidden="true"></span>
                                                @if ($errors->has('userid'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('userid') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn label-success btn-xs btn" id="abrir" href="#"
                                                    data-toggle="tooltip" data-placement="left" title="Añadir agencias de viajes">
                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="pull-right">Cliente</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="nombre" name="nombre" value=""
                                                placeholder="Nombre" readonly required>
                                            <span class="fa  fa-barcode form-control-feedback right" aria-hidden="true"></span>
                                            @if ($errors->has('nombre'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('nombre') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <!-------------------------------------------------------------------------------------->
                                    <div class="col-sm-2">
                                        <label class="pull-right">Fecha</label>
                                    </div>
                                    <div class="col-sm-10">

                                        <div class="form-group {{ $errors->has('fecha') ? ' has-error' : '' }} has-feedback">
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="{{date('Y-m-d')}}"
                                                placeholder="Fecha">

                                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                            @if ($errors->has('fecha'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('fecha') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <label class="pull-right">Monto</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('monto') ? ' has-error' : '' }} has-feedback">
                                            <input type="number" step="any" class="form-control" name="monto" id="monto"
                                                value="0" placeholder="Monto">

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
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('dias') ? ' has-error' : '' }} has-feedback">
                                            <input type="number" class="form-control" name="dias" id="dias" value=""
                                                placeholder="Dias para Pagar">

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
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('tipop') ? ' has-error' : '' }}">
                                            <select name="tipop" id="tipop" required class="form-control select2">
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
                                        <label class="pull-right">Banco Emisor</label>
                                    </div>
                                    <div class="col-sm-10">

                                        <div class="form-group {{ $errors->has('bancor') ? ' has-error' : '' }}" id="disable2">
                                            <select name="bancoe" id="bancoe" onchange="mostrarValor(this.value);"
                                                required class="form-control select2" disabled>
                                                <option value="">Selecciona el Banco Receptor</option>
                                                @foreach($bancosg as $banco)
                                                <option value="{{$banco->banco}}">{{$banco->banco}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('bancor'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('bancoe') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="pull-right">Banco Receptor</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('bancor') ? ' has-error' : '' }}" id="disable1">
                                            <select name="bancoe" id="bancor" onchange="mostrarValor(this.value);"
                                                required class="form-control select2" disabled>
                                                <option value="">Selecciona el Banco Emisor</option>
                                                @foreach($bancos as $bancog)
                                                <option value="{{$bancog->banco}}">{{$bancog->banco}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('bancoe'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('bancor') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="pull-right">Nro operación</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('noperacion') ? ' has-error' : '' }} has-feedback"
                                            id="disable3">
                                            <input type="text" class="form-control" name="noperacion" id="noperacion"
                                                id="Nro peración" value="" placeholder="noperacion" disabled>

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
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('abono') ? ' has-error' : '' }} has-feedback">
                                            <input type="number" class="form-control" name="abono" id="abono" value=""
                                                placeholder="abono">


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
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('tabono') ? ' has-error' : '' }} has-feedback">
                                            <input type="number" class="form-control" name="tabono" id="tabono" value="0"
                                                placeholder="tabono" readonly>
                                            <input type="hidden" class="form-control" name="tabonosum" id="tabonosum"
                                                value="0" placeholder="abono">

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
                                    <div class="col-sm-10">
                                        <div class="form-group {{ $errors->has('resta') ? ' has-error' : '' }} has-feedback">
                                            <input type="number" step="any" class="form-control" name="resta" id="resta"
                                                value="0" placeholder="resta" readonly>

                                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                            @if ($errors->has('resta'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('resta') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div align="center">
                                        <br>
                                        <button id="debitar" name="debitar" class="btn label-success pull-center">
                                            Debitar </button>
                                        <br>
                                    </div>


                                    <div>
                                        <br>
                                        <table class="table table-responsive table-bordered table-condensed" id="data"
                                            name="data">
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
                                        <button type="submit" class="btn btn-success pull-right">
                                            Registrar <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </section>
        </div>

        <!----------------------------------------------------------------------------------->
        <div class="modal-lg modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close cerrar" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        <h2><i class="fa fa-building"></i> Agencias de viaje</h2>
                    </h4>
                </div>
                <div class="modal-body">

                    @section('script')
                    <script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>
                    <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
                    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
                    @endsection

                    <div class="box padding_box1">
                        <div id="wrapper">


                            <table class="table table-responsive" id="Modalagenciadev">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">RUC</th>
                                        <th class="col-md-2">Nombre</th>
                                        <th class="col-md-2">Telefono</th>
                                        <th class="col-md-2">Dirección</th>
                                        <th class="col-md-2">Acciones</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($aviajes as $aviaje)
                                    <tr>
                                        <td>{{$aviaje->rif}}</td>
                                        <td>{{$aviaje->nombre}}</td>
                                        <td>{{$aviaje->telefono}}</td>
                                        <td>{{$aviaje->direccion}}</td>
                                        <td><button class="btn boton-dato btn-warning btn-xs btn abrir" id="dato" value="{{$aviaje->rif}}Ç{{$aviaje->nombre}}"
                                                href="#" data-toggle="tooltip" data-placement="left" title="Añadir">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cerrar btn-warning" data-dismiss="modal">Cerrar</button>
                </div>

            </div>

        </div>
        <!----------------------------------------------------------------------------------->

    </div>
</div>

@endsection