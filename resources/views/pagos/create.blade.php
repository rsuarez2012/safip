@extends('layouts.master')

@section('titulo', 'Cuentas por Pagar')



@section('script')


<script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">



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
                            toastr.warning('El abono no puede ser mayor que el monto');
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
                            } else {
                                var restay = (input9.val() - input4.val());
                                if (restay < 0) {
                                    toastr.warning("El monto supera el total que resta1");
                                } else {

                                    toastr.info("Se va a adicionar un registro con concepto de Nº " +
                                        input6.val());
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


<div class="box padding_box1">

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
                            <h2><i class="fa fa-plus-circle"></i> Nueva cuenta por pagar</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">

                        <form class="form-horizontal row" role="form" method="POST" action="{{ route('managePago-store-A') }}"
                            enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="col-sm-2">
                                <label class="pull-right">Tipo</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group {{ $errors->has('concepto') ? ' has-error' : '' }} has-feedback">
                                    <input type="text" class="form-control" name="concepto" id="concepto" value=""
                                        placeholder="Concepto">

                                    <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                    @if ($errors->has('concepto'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('concepto') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right">Proveedor</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group {{ $errors->has('proveedor') ? ' has-error' : '' }}">
                                    <select name="proveedor" required class="form-control select2">
                                        <option value="">Selecciona el proveedor</option>
                                        @foreach($consolidadores as $consolidador)
                                        <option value="{{$consolidador->id}}">{{$consolidador->nombre}}</option>
                                        @endforeach

                                    </select>

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
                                <label class="pull-right">Codigo</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group {{ $errors->has('codigo') ? ' has-error' : '' }} has-feedback">
                                    <input type="text" class="form-control" name="codigo" id="codigo" value=""
                                        placeholder="Codigo">

                                    <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                    @if ($errors->has('codigo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('codigo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right">Monto</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group {{ $errors->has('monto') ? ' has-error' : '' }} has-feedback">
                                    <input type="number" step="any" class="form-control" name="monto" id="monto" value="0"
                                        placeholder="Monto">

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
                                <div class="form-group {{ $errors->has('bancoe') ? ' has-error' : '' }}" id="disable1">
                                    <select name="bancoe" id="bancoe" onchange="mostrarValor(this.value);" required
                                        class="form-control select2" disabled>
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
                                <label class="pull-right">Banco Receptor</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group {{ $errors->has('bancor') ? ' has-error' : '' }}" id="disable2">
                                    <select name="bancor" id="bancor" onchange="mostrarValor(this.value);" required
                                        class="form-control select2" disabled>
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
                            <div class="col-sm-10">
                                <div class="form-group {{ $errors->has('noperacion') ? ' has-error' : '' }} has-feedback"
                                    id="disable3">
                                    <input type="text" class="form-control" name="noperacion" id="noperacion" id="Nro peración"
                                        value="" placeholder="noperacion" disabled>

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
                                    <input type="hidden" class="form-control" name="tabonosum" id="tabonosum" value="0"
                                        placeholder="abono">

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
                                    <input type="number" step="any" class="form-control" name="resta" id="resta" value="0"
                                        placeholder="resta" readonly>

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
                                <table class="table table-responsive table-bordered table-condensed" id="data" name="data">
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
                        </form>
                    </div>
                </div>

            </section>
        </div>


    </div>
</div>

@endsection