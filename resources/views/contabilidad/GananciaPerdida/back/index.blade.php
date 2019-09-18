@extends('layouts.master')

@section('titulo', 'operaciones bancarias')

@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
<link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{  asset('css/buttom.css') }} ">
@endsection
@section('script')

<script src="{{  asset('js/buttom.js') }} "></script>
<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src={!! asset("js/toastr.js") !!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<script src={!! asset("js/xlsx.core.min.js")!!}></script>

<script type="text/javascript">
    $(function () {
        $('#opbanc').DataTable({
            "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "lengthMenu": [ 50,100, 200, 500],
                
                "autoWidth": true
        });
    });
    function enviar_form(){
        $("#fecha_filtrar_desde").val($("#fecha_desde").val());
        $("#fecha_filtrar_hasta").val($("#fecha_hasta").val());
        $('#form_operaciones').submit();
    }
    $(document).ready(function(){
        $("input[name=contabilidad]").change(function ver(){
            if($(this).val()=="si"){
             $("#cont_suc").removeClass("hidden");
            }else{
             $("#cont_suc").addClass("hidden");   
            }
        });


        $( ".target" ).change(function() {
            var att = $(this).attr('class').split(' ');
            //console.log(att);
            var valor = $(this).val();
            //console.log(valor);
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
                $('#cont_suc').val("");
                $('.modal3').fadeIn();
                $('.guardar2').val(clase);
            }
        });
        $(".cerrar").click(function(e){
            e.preventDefault();
            $('#cont_suc').val("");
            $('#si').removeClass("active");
            $('#option1').attr("checked");
            $('#no').addClass("active");
            $('#cont_suc').addClass("hidden");
            $(".modal").fadeOut(600);
        });
        $('#capturar').click(function(e){
            e.preventDefault();

            var capturar = $(this).val();
            $('#capturado').val(capturar);
        });

        $('.capturar').click(function(e){
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
            //console.log($(this).val());
            var clase = $(this).val();
            e.preventDefault();
            var referencia = $('#capturado').val();
            if (referencia == 0){
                alert ("Recuerda identificar tu pago," +
                    "haciendo click sobre el nombre de la Agencia" +
                    " o consolidador que estas identificando");
            }else{
                swal({
                    title: "Disculpe!.",
                    text: "¿Identificó el pago!?",
                    icon: "warning",
                    buttons: {
                        cancel: "No",
                        confirm: {
                            text: "Si",
                            value: true,
                        },
                    },
                    dangerMode: true,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    timer: 5000,
                }).then(acepted => {
                    if(acepted){
                        var tipoop = $('.target'+clase).val();
                        var valor = $('.target'+clase).val();
                        if (valor == 1){
                            $('.targetcolor'+clase).addClass("color1");
                        }
                        if (valor == 2){
                            $('.targetcolor'+clase).addClass("color2");
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
                    } else {
                        $('.status'+clase).val("NO Identificado");
                        $(".modal").fadeOut(600);
                    }
                });
            }
        });
        $("#guardar2").click(function(e){
            e.preventDefault();
            var clase = $(this).val();
            var tipog = $('#tipog').val();
            var descripcion = $('#descripciong').val();
            if (referencia == 0){
                toastr.warning("debe llenar las dos cajas de texto");
            }else {
                if (descripcion == 0) {
                    toastr.warning("debe llenar las dos cajas de texto");
                } else {
                    swal({
                        title: "Disculpe!.",
                        text: "¿Identificó el pago!?",
                        icon: "warning",
                        buttons: {
                            cancel: "No",
                            confirm: {
                                text: "Si",
                                value: true,
                            },
                        },
                        dangerMode: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        timer: 5000,
                    }).then(acepted => {
                        if(acepted){
                            var tipoop = $('.target'+clase).val();
                            $('.status'+clase).val("Identificado");
                            $('.procedencia' + clase).val(tipog+"*"+descripcion);
                            var valor = $('.target'+clase).val();
                            if (valor == 3){
                                $('.'+clase).addClass("color3");
                            }
                            var o = $('#cont_suc').val();
                            $('.gastos'+clase).val(o);
                            $('.tipoop'+clase).val("Gastos");
                            $(".modal").fadeOut(600);
                        } else {
                            $('.status'+clase).val("NO Identificado");
                            $(".modal").fadeOut(600);
                        }
                    });
                }
            }
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
    function abrirFiltro(){
        $(".modalFiltroC").fadeIn();
    }
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
            </div>
            <div class="row">
                <div class="col-md-9">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageCoperacionesbancarias-A-fecha')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="col-sm-4">
                            <label>Desde:</label>
                            <div class="form-group {{ $errors->has('fechai') ? ' has-error' : '' }} has-feedback" style="padding-left: 15px;">
                                <input id="fecha_desde" type="date" class="form-control" name="fechai" value="{{$fechai}}" placeholder="Fecha" >
                                <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                                @if ($errors->has('fechai'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fechai') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4"><label>Hasta:</label>
                            <div class="form-group {{ $errors->has('fechaf') ? ' has-error' : '' }} has-feedback">
                                <input id="fecha_hasta" type="date" class="form-control" name="fechaf" value="{{$fechaf}}" placeholder="Fecha" >
                                <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                                @if ($errors->has('fechaf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fechaf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" style="margin-top: 24px;padding: 7px;" class="btn btn-warning btn-xs btn"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Filtrar por fecha">
                                <i class="fa fas fa-calendar" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="col-sm-6" style="margin-top:24px;">
                        <form  class="form-horizontal"
                                role="form"
                                method="POST"
                                action="{{ route('manageCoperacionesbancarias-import-A') }}"
                                enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div style="width:27px;float:left;margin-right:4px;">
                                <input  class="input-file"
                                        id="file"
                                        type="file"
                                        name="file"
                                        data-toggle="tooltip"
                                        data-placement="left"
                                        title="Cargar Documento"
                                        data-original-title="Cargar Documento"
                                        style="padding:7px;margin-left:15px;">
                                <label tabindex="0"
                                        for="my-file"
                                        class="input-file-trigger btn btn-warning btn-xs"
                                        style="padding: 7px;border-radius:3px !important;height:34px;">
                                    <i class="fa fa-folder" style="cursor:pointer;"></i>
                                </label>
                            </div>
                            {{-- <p class="file-return"></p> --}}
                            <button style="padding: 7px;"
                                    type="submit"
                                    class="btn btn-xs btn-warning"
                                    value="Subir"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Guardar Documento"
                                    data-original-title="Guardar Documento">
                                <i class="fa fa-upload"></i>
                            </button>
                        </form>
                        <p class="file-return"></p>
                    </div>
                    <div class="col-sm-6">
                        <button style="margin-top: 24px;padding: 7px;"
                                class="btn btn-warning btn-xs"
                                data-toggle="tooltip"
                                data-placement="left"
                                onclick="abrirFiltro()"
                                title=" Filtros Generales">
                            <i class="fa fas fa-filter" aria-hidden="true"></i>
                        </button>
                        <button style="margin-top: 24px;padding: 7px;"
                                class="btn btn-warning btn-xs btn abrirFiltroB"
                                name="abrirFiltroB"
                                id="abrirFiltroB"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Balance Bancario"
                                data-original-title="">
                            <i class="fa fa-line-chart" aria-hidden="true"></i>
                        </button>
                        @if (count($operaciones) > 0)
                        <button style="margin-top: 24px;padding: 6px;"
                                class="btn btn-warning pull-right"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Guardar"
                                onclick="enviar_form()"
                                data-original-title="Guardar">
                            <i class="fa fa-arrow-circle-right"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
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
                    <form class="form-horizontal" id="form_operaciones" role="form" method="POST" action="{{ route('manageCoperacionesbancarias-storeindex-A') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="hidden" id="fecha_filtrar_desde" name="fechai">
                        <input type="hidden" id="fecha_filtrar_hasta" name="fechaf">
                        @if (count($operaciones) > 0)
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table" id="opbanc">
                                    <thead>
                                        <tr>
                                            <th style="width: 80px !important"></th>
                                            <th class="col-md-1">Opciones</th>
                                            <th class="col-md-1">Empresa</th>
                                            <th class="col-md-1">Moneda</th>
                                            <th class="col-md-1">Procedencia</th>
                                            <th class="col-md-1">Tipo de operación</th>
                                            <th class="col-md-1">Fecha</th>
                                            <th class="col-md-1">Descripción</th>
                                            <th class="col-md-1">Monto</th>
                                            <th class="col-md-1">Saldo</th>
                                            <th class="col-md-1">Sucursal</th>
                                            <th class="col-md-1">NRO Operación</th>
                                            <th class="col-md-1">Hora Operación</th>
                                            <th class="col-md-1">Usuario</th>
                                            <th class="col-md-1">UTC</th>
                                            <th class="col-md-1">Referencia</th>
                                            <th class="col-md-1">Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($operaciones as $operacion)
                                        @if($operacion->tipo_operacion == "Deudas de Agencia de Viajes")

                                        <tr>

                                            <td><input disabled class="check check{{$operacion->nro_operacion}} color1"  type="checkbox" name="check[]" id="check[]" value="checkeado{{$operacion->nro_operacion}}"><input class="checkeado checkeado{{$operacion->nro_operacion}}" type="text" name="checkeado[]" id="checkeado[]" value="0" hidden></td>

                                            <td><select disabled  style="width: 60px" name="target[]" id="target[]" required="" class="form-control color{{$operacion->nro_operacion}}{{$operacion->utc}} target targetcolor{{$operacion->nro_operacion}}{{$operacion->utc}} color1">
                                                <option value="0">Tipo</option>
                                                <option value="1">Deudas de Agencia de Viajes</option>
                                                <option value="2">Pago a Consolidadores</option>
                                                <option value="3">Gastos</option>
                                            </select>
                                        </td>
                                        <td><input title="{{$operacion->empresa}}" class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} empresacolor{{$operacion->nro_operacion}}{{$operacion->utc}} empresa color1" name="empresa[]" id="empresa[]" type="text" value="{{$operacion->empresa}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} monedacolor{{$operacion->nro_operacion}}{{$operacion->utc}} moneda color1" name="moneda[]" id="moneda[]" type="text" value="{{$operacion->moneda}}" readonly></td>
                                        <td><input title="{{$operacion->procedencia}}" class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} procedenciacolor{{$operacion->nro_operacion}}{{$operacion->utc}} procedencia color1" name="procedencia[]" id="procedencia[]" type="text" value="{{$operacion->procedencia}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} tipoopcolor{{$operacion->nro_operacion}}{{$operacion->utc}} tipo_operacion color1" name="tipo_operacion[]" id="tipo_operacion[]" type="text" value="{{$operacion->tipo_operacion}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} fecha color1" name="fecha[]" id="fecha[]" type="text" value="{{$operacion->fecha}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} descripcion color1" name="descripcion[]" id="descripcion[]" type="text" value="{{$operacion->descripcion}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} monto color1" name="monto[]" id="monto[]" type="text" value="{{$operacion->monto}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} saldo color1" name="saldo[]" id="saldo[]" type="text" value="{{$operacion->saldo}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} sucursal color1" name="sucursal[]" id="sucursal[]" type="text" value="{{$operacion->sucursal}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} nro_operacion color1" name="nro_operacion[]" id="nro_operacion[]" type="text" value="{{$operacion->nro_operacion}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} hora_operacion color1" name="hora_operacion[]" id="hora_operacion[]" type="text" value="{{$operacion->hora_operacion}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} usuario color1" name="usuario[]" id="usuario[]" type="text" value="{{$operacion->usuario}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} utc color1" name="utc[]" id="utc[]" type="text" value="{{$operacion->utc}}" readonly></td>
                                        <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} referencia color1" name="referencia[]" id="referencia[]" type="text" value="{{$operacion->referencia}}" readonly></td>
                                        <td><input class="transparenteinput status color{{$operacion->nro_operacion}}{{$operacion->utc}} statuscolor{{$operacion->nro_operacion}}{{$operacion->utc}} status color1" name="status[]" id="status[]" value="{{$operacion->status}}" type="text" readonly>
                                            <input class="gastoscolor{{$operacion->nro_operacion}}" name="gastos[]" id="gastos" value="" type="hidden" readonly>
                                        </td>

                                    </tr>
                                    @endif
                                    @if($operacion->tipo_operacion == "Pago a Consolidadores")

                                    <tr>
                                        <td><input disabled class="check check{{$operacion->nro_operacion}} color2"  type="checkbox" name="check[]" id="check[]" value="checkeado{{$operacion->nro_operacion}}"><input class="checkeado checkeado{{$operacion->nro_operacion}}" type="text" name="checkeado[]" id="checkeado[]" value="0" hidden></td>

                                        <td><select disabled style="width: 60px" name="target[]" id="target[]" required="" class="form-control color{{$operacion->nro_operacion}}{{$operacion->utc}} target targetcolor{{$operacion->nro_operacion}}{{$operacion->utc}} color2">
                                            <option value="0">Tipo</option>
                                            <option value="1">Deudas de Agencia de Viajes</option>
                                            <option value="2">Pago a Consolidadores</option>
                                            <option value="3">Gastos</option>
                                        </select>
                                    </td>
                                    <td><input title="{{$operacion->empresa}}" class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} empresacolor{{$operacion->nro_operacion}}{{$operacion->utc}} empresa color2" name="empresa[]" id="empresa[]" type="text" value="{{$operacion->empresa}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} monedacolor{{$operacion->nro_operacion}}{{$operacion->utc}} moneda color2" name="moneda[]" id="moneda[]" type="text" value="{{$operacion->moneda}}" readonly></td>
                                    <td><input title="{{$operacion->procedencia}}" class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} procedenciacolor{{$operacion->nro_operacion}}{{$operacion->utc}} procedencia color2" name="procedencia[]" id="procedencia[]" type="text" value="{{$operacion->procedencia}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} tipoopcolor{{$operacion->nro_operacion}}{{$operacion->utc}} tipo_operacion color2" name="tipo_operacion[]" id="tipo_operacion[]" type="text" value="{{$operacion->tipo_operacion}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} fecha color2" name="fecha[]" id="fecha[]" type="text" value="{{$operacion->fecha}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} descripcion color2" name="descripcion[]" id="descripcion[]" type="text" value="{{$operacion->descripcion}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} monto color2" name="monto[]" id="monto[]" type="text" value="{{$operacion->monto}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} saldo color2" name="saldo[]" id="saldo[]" type="text" value="{{$operacion->saldo}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} sucursal color2" name="sucursal[]" id="sucursal[]" type="text" value="{{$operacion->sucursal}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} nro_operacion color2" name="nro_operacion[]" id="nro_operacion[]" type="text" value="{{$operacion->nro_operacion}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} hora_operacion color2" name="hora_operacion[]" id="hora_operacion[]" type="text" value="{{$operacion->hora_operacion}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} usuario color2" name="usuario[]" id="usuario[]" type="text" value="{{$operacion->usuario}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} utc color2" name="utc[]" id="utc[]" type="text" value="{{$operacion->utc}}" readonly></td>
                                    <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} referencia color2" name="referencia[]" id="referencia[]" type="text" value="{{$operacion->referencia}}" readonly></td>
                                    <td><input class="transparenteinput status color{{$operacion->nro_operacion}}{{$operacion->utc}} statuscolor{{$operacion->nro_operacion}}{{$operacion->utc}} status color2" name="status[]" id="status[]" value="{{$operacion->status}}" type="text" readonly>
                                        <input class="gastoscolor{{$operacion->nro_operacion}}" name="gastos[]" id="gastos" value="" type="hidden" readonly>
                                    </td>
                                </tr>
                                @endif
                                @if($operacion->tipo_operacion == "Gastos")
                                <tr>
                                    <td><input disabled class="check check{{$operacion->nro_operacion}} color3"  type="checkbox" name="check[]" id="check[]" value="checkeado{{$operacion->nro_operacion}}"><input class="checkeado checkeado{{$operacion->nro_operacion}}" type="text" name="checkeado[]" id="checkeado[]" value="0" hidden></td>

                                    <td><select disabled style="width: 60px" name="target[]" id="target[]" required="" class="form-control color{{$operacion->nro_operacion}}{{$operacion->utc}} target targetcolor{{$operacion->nro_operacion}}{{$operacion->utc}} color3">
                                        <option value="0">Tipo</option>
                                        <option value="1">Deudas de Agencia de Viajes</option>
                                        <option value="2">Pago a Consolidadores</option>
                                        <option value="3">Gastos</option>
                                    </select>
                                </td>
                                <td><input title="{{$operacion->empresa}}" class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} empresacolor{{$operacion->nro_operacion}}{{$operacion->utc}} empresa color3" name="empresa[]" id="empresa[]" type="text" value="{{$operacion->empresa}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} monedacolor{{$operacion->nro_operacion}}{{$operacion->utc}} moneda color3" name="moneda[]" id="moneda[]" type="text" value="{{$operacion->moneda}}" readonly></td>
                                <td><input title="{{$operacion->procedencia}}" class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} procedenciacolor{{$operacion->nro_operacion}}{{$operacion->utc}} procedencia color3" name="procedencia[]" id="procedencia[]" type="text" value="{{$operacion->procedencia}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} tipoopcolor{{$operacion->nro_operacion}}{{$operacion->utc}} tipo_operacion color3" name="tipo_operacion[]" id="tipo_operacion[]" type="text" value="{{$operacion->tipo_operacion}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} fecha color3" name="fecha[]" id="fecha[]" type="text" value="{{$operacion->fecha}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} descripcion color3" name="descripcion[]" id="descripcion[]" type="text" value="{{$operacion->descripcion}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} monto color3" name="monto[]" id="monto[]" type="text" value="{{$operacion->monto}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} saldo color3" name="saldo[]" id="saldo[]" type="text" value="{{$operacion->saldo}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} sucursal color3" name="sucursal[]" id="sucursal[]" type="text" value="{{$operacion->sucursal}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} nro_operacion color3" name="nro_operacion[]" id="nro_operacion[]" type="text" value="{{$operacion->nro_operacion}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} hora_operacion color3" name="hora_operacion[]" id="hora_operacion[]" type="text" value="{{$operacion->hora_operacion}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} usuario color3" name="usuario[]" id="usuario[]" type="text" value="{{$operacion->usuario}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}}{{$operacion->monto}} utc color3" name="utc[]" id="utc[]" type="text" value="{{$operacion->utc}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}}{{$operacion->monto}} referencia color3" name="referencia[]" id="referencia[]" type="text" value="{{$operacion->referencia}}" readonly></td>
                                <td><input class="transparenteinput status color{{$operacion->nro_operacion}}{{$operacion->utc}}{{$operacion->monto}} statuscolor{{$operacion->nro_operacion}}{{$operacion->utc}} status color3" name="status[]" id="status[]" value="{{$operacion->status}}" type="text" readonly>
                                    <input class="gastoscolor{{$operacion->nro_operacion}}" name="gastos[]" id="gastos" value="" type="hidden" readonly>
                                </td>
                            </tr>
                            @endif
                            @if($operacion->tipo_operacion == "NO Identificado")
                            <tr>
                                <td><input class="check check{{$operacion->nro_operacion}}{{$operacion->monto}} "  type="checkbox" name="check[]" id="check[]" value="checkeado{{$operacion->nro_operacion}}"><input class="checkeado checkeado{{$operacion->nro_operacion}}" type="text" name="checkeado[]" id="checkeado[]" value="0" hidden></td>
                                <td><select style="width: 60px" name="target[]" id="target[]" required="" class="form-control color{{$operacion->nro_operacion}}{{$operacion->utc}} target targetcolor{{$operacion->nro_operacion}}{{$operacion->utc}} ">
                                    <option value="0">Tipo</option>
                                    <option value="1">Deudas de Agencia de Viajes</option>
                                    <option value="2">Pago a Consolidadores</option>
                                    <option value="3">Gastos</option>
                                </select>
                            </td>
                            <td><input title="{{$operacion->empresa}}" class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} empresacolor{{$operacion->nro_operacion}}{{$operacion->utc}} empresa" name="empresa[]" id="empresa[]" type="text" value="{{$operacion->empresa}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} monedacolor{{$operacion->nro_operacion}}{{$operacion->utc}} moneda" name="moneda[]" id="moneda[]" type="text" value="{{$operacion->moneda}}" readonly></td>
                            <td><input title="{{$operacion->procedencia}}" class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} procedenciacolor{{$operacion->nro_operacion}}{{$operacion->utc}} procedencia" name="procedencia[]" id="procedencia[]" type="text" value="{{$operacion->procedencia}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} tipoopcolor{{$operacion->nro_operacion}}{{$operacion->utc}} tipo_operacion" name="tipo_operacion[]" id="tipo_operacion[]" type="text" value="{{$operacion->tipo_operacion}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} fecha" name="fecha[]" id="fecha[]" type="text" value="{{$operacion->fecha}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} descripcion" name="descripcion[]" id="descripcion[]" type="text" value="{{$operacion->descripcion}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} monto" name="monto[]" id="monto[]" type="text" value="{{$operacion->monto}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} saldo" name="saldo[]" id="saldo[]" type="text" value="{{$operacion->saldo}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} sucursal" name="sucursal[]" id="sucursal[]" type="text" value="{{$operacion->sucursal}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} nro_operacion" name="nro_operacion[]" id="nro_operacion[]" type="text" value="{{$operacion->nro_operacion}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} hora_operacion" name="hora_operacion[]" id="hora_operacion[]" type="text" value="{{$operacion->hora_operacion}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} usuario" name="usuario[]" id="usuario[]" type="text" value="{{$operacion->usuario}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} utc" name="utc[]" id="utc[]" type="text" value="{{$operacion->utc}}" readonly></td>
                            <td><input class="transparenteinput color{{$operacion->nro_operacion}}{{$operacion->utc}} referencia" name="referencia[]" id="referencia[]" type="text" value="{{$operacion->referencia}}" readonly></td>
                            <td><input class="transparenteinput status color{{$operacion->nro_operacion}}{{$operacion->utc}} statuscolor{{$operacion->nro_operacion}}{{$operacion->utc}} status" name="status[]" id="status[]" value="{{$operacion->status}}" type="text" readonly>
                                <input class="gastoscolor{{$operacion->nro_operacion}}" name="gastos[]" id="gastos" value="" type="hidden" readonly>
                            </td>
                        </tr>
                        @endif
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
         @else

                        <div class="alert alert-block alert-info" style="margin-top: 44px;">
                            <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                            <p class="margin-bottom-10">
                            No existen items registrados en el sistema.
                            </p>
                        </div>

                    @endif
       
    </form>
    <div class="clearfix"></div>
</div>
</div>
<!--Modal iframe-->

<div class="modal-lg modal modal1" style="overflow-y: scroll;">
    <div class="modal-content modal-content3">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Deudas y Pagos</h4>
        </div>
        <div class="modal-body">

            <div>
                <section>
                    <div class=" row">
                        <div class="col-sm-12 ">

                            <iframe name="myiframe1" id="myiframe1" src="" height="500px" width="100%">Your browser does not support frames.</iframe>

                            <div class="clearfix"></div>

                        </div>
                    </div>

                </section>
            </div>
        </div>
        <div class="modal-footer">
            <div class="alert alert-success" hidden>
                <button class="close" data-dismiss="alert"> <span>&times;</span></button>
                Se Identifico correctamente! ahora puede guardar...
            </div>
            <input type="text" hidden name="capturado" id="capturado" value="0">
            <button type="hidden" value="" class="btn btn-success referencia" name="referencia" id="referencia">Guardar</button>
            <button type="button" class="btn cerrar btn-warning" data-dismiss="modal">Cerrar</button>
        </div>

    </div>
</div>

<div class="modal-lg modal modal3" style="overflow-y: scroll;">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Detalles del gasto</h4>
        </div>
        <div class="modal-body">


            <div>
                <section>
                    <div class=" row">
                        <div class="col-sm-10 col-sm-offset-1">

                            <div class="clearfix"></div>
                            <div id="formulario">
                                <div class="form-group  has-feedback">
                                    <label>Tipo de gasto</label>
                                    <input type="text" class="form-control" name="tipog" id="tipog" value="" placeholder="Tipo de Gasto" maxlength="255">
                                    <label>Descripción</label>
                                    <textarea type="text" class="form-control" name="descripciong" id="descripciong" value="" placeholder="Descripcion" maxlength="255"></textarea>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-12">
                            <label for="">Agregar Gastos a Contabilidad</label><br>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                              <label id="no" class="btn btn-danger active rounded-circle">
                                <input value="no" type="radio" name="contabilidad" id="option1" checked>NO
                            </label>
                            <label id="si" class="btn btn-danger">
                                <input value="si" type="radio" name="contabilidad" id="option2">SI
                            </label>
                        </div>
                            <select class="form-control hidden" id="cont_suc" style="margin-top: 5px;">
                                <option value="">Seleccione Sucursal</option>
                                <option value="0001">0001</option>
                                <option value="0002">0002</option>
                                <option value="0003">0003</option>
                                <option value="0004">0004</option>
                            </select>
                    </div>
                </div>

        </section>
    </div>
</div>
<div class="modal-footer">

    <button type="button" class="btn cerrar btn-warning" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success guardar2" name="guardar2" id="guardar2" data-dismiss="modal">Guardar</button>
</div>

</div>
</div>
        <!-------------------------------------------Modal iframe--------------------------------------------->




        <!-------------------------------------------------Modal Iframe Bancos------------------------------------>
        <div class="modal-lg modal modalFiltroB">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close cerrarFiltroB" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-filter"></i> Consultar Balance Bancario </h4></h5>
                </div>
                <div class="modal-body">
                    <div>
                        <section>
                            <div class=" row">
                                <div class="col-sm-12 ">

                                    <iframe name="myiframe2" id="myiframe2" src="" height="400" width="100%">Your browser does not support frames.</iframe>

                                    <div class="clearfix"></div>

                                </div>
                            </div>

                        </section>
                    </div>
                    <div class="modal-footer">

                    </div>

                </div>
            </div>
        </div>
        <!-------------------------------------------------Modal Iframe Bancos------------------------------------>


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
                                    <div class="row " style="margin-left: 35%;">
                                        <div class="col-md-5"><label>Desde:</label>
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
                                        <div class="col-md-5"><label>Hasta:</label>
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
                                    </div><br>
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

