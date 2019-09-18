@extends('layouts.master')

@section('titulo', 'import')

@section('css')
        <!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
<link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
@endsection
@section('script')

    <script src={!! asset("js/jquery.min.js")!!}></script>
    <script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src={!! asset("js/toastr.js") !!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
    <script type="text/javascript">
        $(function () {
            $('#opbanc').DataTable({
                "iDisplayLength": 100,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
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
                    toastr.info("Recuerda identificar tu pago, haciendo click sobre el nombre de la Agencia o consolidador que estas identificando");
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
                    toastr.warning("Debe llenar las dos cajas de texto", "Disculpe!");
                }else {
                    if (descripcion == 0) {
                        toastr.warning("Debe llenar las dos cajas de texto", "Disculpe!");
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
@endsection
@section('content')
    <form class="form-horizontal" role="form" method="POST" action="{{ route('manageCoperacionesbancarias-store-A') }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
 <div class="box padding_box1">
<div class="row">
        <div class="col-md-5">

                    <label>Banco emisor:</label>
                        <select name="empresa" id="empresa" required="" class="form-control">
                                    <option value="0">Selecciona El Banco Emisor</option>
                                @foreach($bancos as $banco)
                                    <option value="{{$banco->banco}}">{{$banco->banco}}</option>
                                @endforeach
                        </select>
        </div>
        <div class="col-md-5">
                <label>Moneda:</label>
                    <select name="moneda" id="moneda" required="" class="form-control">
                        <option value="">Selecciona la Moneda</option>
                        <option value="Dolar">Dolar</option>
                        <option value="Soles">Soles</option>
                    </select>
        </div>
        <div class="col-md-2">
                    <button type="submit" class="btn btn-success pull-right">
                        Guardar <i class="fa fa-arrow-circle-right"></i>
                    </button>
            </div>

        <div class="clearfix"></div>
        <hr>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table" id="opbanc">
                    <thead>
                        <tr>
                            <th style="width: 80px !important"></th>
                            <th class="col-md-1">Opciones</th>
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
                        <tr>
                                <td><input class="check check{{$operacion->operacion_numero}}"  type="checkbox" name="check[]" id="check[]" value="checkeado{{$operacion->operacion_numero}}"><input class="checkeado checkeado{{$operacion->operacion_numero}}" type="text" name="checkeado[]" id="checkeado[]" value="0" hidden></td>

                                <td><select style="width: 60px" name="target[]" id="target[]" required="" class="form-control color{{$operacion->operacion_numero}} target targetcolor{{$operacion->operacion_numero}}">
                                        <option value="0">Tipo</option>
                                        <option value="1">Deudas de Agencia de Viajes</option>
                                        <option value="2">Pago a Consolidadores</option>
                                        <option value="3">Gastos</option>
                                    </select>
                                </td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} procedenciacolor{{$operacion->operacion_numero}} procedencia" name="procedencia[]" id="procedencia[]" type="text" value="NO Identificado" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} tipoopcolor{{$operacion->operacion_numero}} tipo_operacion" name="tipo_operacion[]" id="tipo_operacion[]" type="text" value="NO Identificado" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} fecha" name="fecha[]" id="fecha[]" type="text" value="{{$operacion->fecha}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} descripcion" name="descripcion[]" id="descripcion[]" type="text" value="{{$operacion->descripcion_operacion}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} monto" name="monto[]" id="monto[]" type="text" value="{{$operacion->monto}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} saldo" name="saldo[]" id="saldo[]" type="text" value="{{$operacion->saldo}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} sucursal" name="sucursal[]" id="sucursal[]" type="text" value="{{$operacion->sucursal_agencia}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} nro_operacion" name="nro_operacion[]" id="nro_operacion[]" type="text" value="{{$operacion->operacion_numero}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} hora_operacion" name="hora_operacion[]" id="hora_operacion[]" type="text" value="{{$operacion->operacion_hora}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} usuario" name="usuario[]" id="usuario[]" type="text" value="{{$operacion->usuario}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} utc" name="utc[]" id="utc[]" type="text" value="{{$operacion->utc}}" readonly></td>
                                <td><input class="transparenteinput color{{$operacion->operacion_numero}} referencia" name="referencia[]" id="referencia[]" type="text" value="{{$operacion->referencia_2}}" readonly></td>
                                <td><input class="transparenteinput status color{{$operacion->operacion_numero}} statuscolor{{$operacion->operacion_numero}} status" name="status[]" id="status[]" value="NO identificado" type="text" readonly></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            

<!----------------------------------->
            <div class="modal-lg modal modal1" style="overflow-y: scroll;">
                <div class="modal-content modal-content2">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Deuda de agencia deviajes</h4>
                    </div>
                    <div class="modal-body">

                        <div>
                            <section>
                                <div class=" row">
                                    <div class="col-sm-12 ">

                                        <iframe name="myiframe1" id="myiframe1" src="" height="800" width="100%">Your browser does not support frames.</iframe>

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
        </div>
    </div>
</div>
    </form>
@endsection


