@extends('layouts.master')

@section('titulo', 'Vboletos')

@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

@endsection
@section('script')


<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>

<script type="text/javascript">

$(document).ready(function(){
  $.fn.dataTable.moment('h:mm A');
  var table = $('#vboletos').DataTable({
    "language": {
      "decimal": "",
      "emptyTable": "No hay datos disponibles",
      "info": "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
      "infoEmpty": "Mostrando 0 hasta 0 de 0 entries",
      "infoFiltered": "(filtrando de _MAX_ registros totales)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ registros",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "No se encontraron coincidencias",
      "paginate": {
        "first": "Primera",
        "last": "Ultima",
        "next": "Siguiente",
        "previous": "Anterior"
      },
      "aria": {
        "sortAscending": ": activar para ordenar de forma ascendente",
        "sortDescending": ": activar para ordenar de forma descendente"
      }
    },
    dom: 'Blfrtip',
    buttons: [  'excel',  'print' ],
    lengthMenu: [
      [ 10, 100, 150, 200,500, -1 ],
      [ '10', '100', '150', '200','500', 'Todo' ]
    ],
    "order": [
      [0, 'desc']
    ],
    "scrollX": true
  });
  table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)');
});


    $(document).ready(function() {

        $(".select2").select2();

        function calculos (event)
        {
            /*tarifa*/
            var unot = $("#dtarifa");
            var dost = $("#dtotal");
            if (parseFloat($(unot).val()) > 0) {
                var xt = (parseFloat($(unot).val()) - parseFloat($(dost).val()));
                var trest = xt.toFixed(2);
                $('#dconso').val(trest);
            }else{
                $('#dconso').val(0);
            }
            /*neto*/
            var unott =  $('#dcomi');
            var dostt =  $('#digv');
            var dobleoperacion = 2;
            for ($i = 0; $i < dobleoperacion; $i++) {
                if (parseFloat($(unott).val()) > 0) {
                    var ytt = parseFloat($(unott).val()) + parseFloat($(dostt).val());
                    var trestt = ytt.toFixed(2);
                    $('#dtotal').val(trestt);
                } else {
                    $('#dtotal').val(0);
                }
            }

            /*neto2*/
            if(parseFloat($("#dneto").val()) > 0) {
                var xttt = (parseFloat($("#dvaloreninput").val()) * parseFloat($("#dneto").val())) / 100;
                var comisionttt = xttt.toFixed(2);
                $('#dcomi').val(comisionttt);

            }else{
                $('#dcomi').val(0);
            }
            /*neto3*/


            /*neto4*/
            var xn = (parseFloat($("#dcomi").val()) * parseFloat($("#diva").val())) / 100;
            var netoc= xn.toFixed(2);
            $('#digv').val(netoc);
            /*tarifaf*/
            var unon = $("#dtarifaf");
            var dosn = $("#dconso");
            var tresn = $("#dvaloreninput");
            if(parseFloat($(unon).val()) > 0) {
                var xn = (parseFloat($(unon).val()) - parseFloat($(dosn).val()));
                var cuatron= xn.toFixed(2);
                if (tresn.val() == 0) {
                    $('#dutilidad').val(cuatron);
                        // $('#utilidad').val(cuatro);
                    } else {
                        $('#dutilidad').val(cuatron);
                    }
                    /// var cinco= (isNaN(tres.value)) ? $('#utilidad').val(0) : $('#utilidad').val(tres);
                }else{
                    $('#dutilidad').val(0);
                }

            };
            setInterval(calculos, 3);
        });

        $(function () {
            // $('#vboletos').DataTable({
                // "paging": true,
                // "lengthChange": true,
                // "searching": true,
                // "ordering": false,
                // "info": true,
                // "lengthMenu": [ 50,100, 200, 500],
                
                // "autoWidth": true
            // });
           
            var pagoc = 0;

            $(".pagoc").each(
                function (index, value) {
                    pagoc = pagoc + eval($(this).val());
                }
                );
            var tarifaff = 0;
            $(".tarifaff").each(
                function (index, value) {
                    tarifaff = tarifaff + eval($(this).val());
                }
                );
            var util = 0;
            $(".util").each(
                function (index, value) {
                    util = util + eval($(this).val());
                }
                );

            /*$(".incen").each(
                    function (index, value) {
                        incen = incen + eval($(this).val());
                    }
                    );*/

                    var igvt = 0;
                    $(".igvt").each(
                        function (index, value) {
                            igvt = igvt + eval($(this).val());
                        }
                        );
                    $("#igvt").val(igvt.toFixed(2));

                    $("#pagoc").val(pagoc.toFixed(2));
                    $("#tarifaff").val(tarifaff.toFixed(2));
                    if(util){
                        $("#util").val(util.toFixed(2));
                    }else{
                        $("#util").val(0);
                    }


                    var subt = 0;
                    var a = 0;
                    $(".subt").each(
                        function (index, value) {
                            subt = subt + eval($(this).val());
                        }
                        );
                    subt = subt.toFixed(2);

                    $("#subt").val(subt);

                    var b = parseFloat(subt) + parseFloat(igvt);
                    var tt = b.toFixed(2);
                    $("#tt").val(tt);

                    var tat = 0;
                    $(".tarifat").each(
                        function (index, value) {
                            tat = tat + eval($(this).val());
                        }
                        );
                    tat = tat.toFixed(2);
            //todas las (tarifa fee)  - todas las (tarifas total)
            var incen =  tarifaff - tat;

            /*
            calculo de incentivo
            */
            //evalue que tarifa se ajusta a cada meta y se imprime en campo incentivo
            if(incen <= $("#primera_meta").val()){
                var resultado = (incen * $("#primer_incentivo").val()) / 100;
                $("#incen").val(resultado.toFixed(2));
            }else {
                if (incen <= $("#segunda_meta").val()) {
                    var resultado = (incen * $("#segundo_incentivo").val()) / 100;
                    $("#incen").val(resultado.toFixed(2));
                }else{
                    if(incen <= $("#tercera_meta").val()){
                        var resultado = (incen * $("#tercer_incentivo").val()) / 100;
                        $("#incen").val(resultado.toFixed(2));
                    }else {
                        if(incen <= $("#cuartameta_meta").val()){
                            var resultado = (incen * $("#cuarto_incentivo").val()) / 100;
                            $("#incen").val(resultado.toFixed(2));
                        }else{
                            if(incen <= $("#quinta_meta").val()){
                                var resultado = (incen * $("#quinto_incentivo").val()) / 100;
                                $("#incen").val(resultado.toFixed(2) + " + PLUS");
                            }
                        }
                    }
                }
            }

            var nFilas = $("#vboletos tr").length;
            var msg = nFilas - 1;
            $("#").val(msg);
        });

    $(".dtiketss").click(function(){
        var h = $(this).val();
        $(".modale"+ h).fadeIn(300);

    });

    $(".dtiketsedit").click(function(){
        var h = $(this).val();
        var APP_URL = {!!json_encode(url('/'))!!};
        $.get(APP_URL+'/tablero/ventaboletos/admin/consulta/' + h, function (ticket) {
            console.log(ticket);
            $('#dtikets').val(ticket.nro_ticket);
            $('#dneto').val(ticket.neto);
            $('#dtarifa').val(ticket.tarifa);
            $('#dcomi').val(ticket.comision_agencia);
            $('#digv').val(ticket.igv);
            $('#dtotal').val(ticket.total);
            $('#dconso').val(ticket.pago_consolidador);
            $('#dtarifaf').val(ticket.tarifa_fee);
            $('#dutilidad').val(ticket.utilidad);
            $('#dincentivo').val(ticket.incentivo);

                // alert(ticket.comision_agencia);
                $.get(APP_URL+'/tablero/cotizaciones/admin/comision/'+ticket.consolidadores_id+'/'+ticket.laereas_id, function (comision) {
                    console.log(comision);
                    if(comision != 0){
                        $("#porcentaje").val(comision);
                        $('#dvaloreninput').val(comision);
                        $('#vporcentaje').removeClass('hidden');
                    }else{
                        if(ticket.comision > 0){
                            $("#porcentaje").val(ticket.comision);
                            $('#dvaloreninput').val(ticket.comision);
                            $("#dcomi").val(ticket.comision_agencia);
                            $("#digv").val(ticket.igv);
                            $("#dtotal").val(ticket.total);
                        } else {
                            $('#dvaloreninput').val(0);
                        }
                        $('#dutilidad').val(0);
                        $('#vporcentaje').removeClass('hidden');
                    }
                });
            });

        $(".modalee").fadeIn(300);

    });
    $("#porcentaje").keyup(function(){
        var h = $(this).val();
        $('#dvaloreninput').val(h);

    });

    $(".cerrarre").click(function(){
        var h = $(this).val();
        $(".modalee").fadeOut(300);
        $('#vporcentaje').addClass('hidden');
        $('#porcentaje').val('');

    });
    $(".cerrarr").click(function(){
        var h = $(this).val();
        $(".modale"+ h).fadeOut(300);

    });

    $(".dfecha").click(function(){
        var g = $(this).val();
        $(".modala"+ g).fadeIn();
        $('#fechas').find('input, textarea, button, select, label').attr('hidden','true');

        $('#fechap').find('input, textarea, button, select, label').removeAttr("hidden");

    });

    $(".cerrarrr").click(function(){
        var g = $(this).val();
        $(".modala"+ g).fadeOut(300);

    });

    $( "#fecha" ).change(function() {
        $('#fechap').find('input, textarea, button, select, label').attr('hidden','true');
    
        $('#fechas').find('input, textarea, button, select, label').removeAttr("hidden");
    });
    $(document).ready(function(){
        
        $(".abrirFiltro").click(function(){

            $(".modalFiltro").fadeIn();
        });
        $(".cerrarFiltro").click(function(){
            $(".modalFiltro").fadeOut(300);
        });

        $(".ndoc").click(function(e){
            e.preventDefault();
            var ticket = $(this).val();
            var fechai= $('#fechai').val();
            var fechaf= $('#fechaf').val();
            $("#tk").val(ticket);

            $(".modalDoc").fadeIn();
        });
        $(".cerrarDoc").click(function(e){
            e.preventDefault();
            $(".modalDoc").fadeOut(300);
        });

        $('.check').click(function() {
            var clase= $(this).attr('class').split('Ç');
            if ($(this).is(':checked')) {
                $('.'+clase[0]).val(clase[1]);

            }
        });
        $(".vdoc").click(function(e){
            e.preventDefault();
            var documento = $(this).val();
            var APP_URL = {!!json_encode(url('/'))!!};
            url = APP_URL +'/uploads/documentos_cobranza/'+documento;
            window.open(url, '_blank');
            return false;
        });
    });

    
    var sm_v_boletos = [];
    function set_val_sm(v_boleto_id){
        if(sm_v_boletos.length > 0){
            let exist = false;
            sm_v_boletos.forEach(vb => {
                if(vb == v_boleto_id){
                    exist = true;
                }
            })
            if(exist){
                sm_v_boletos.splice(sm_v_boletos.indexOf(v_boleto_id), 1);
            } else {
                sm_v_boletos.push(v_boleto_id);
            }
        } else {
            sm_v_boletos.push(v_boleto_id);
        }

        val_btn_edit_sm();
    }
    function val_btn_edit_sm(){
        if(sm_v_boletos.length >= 2){
            $("#btn_edit_sm").css("display", "");
            $("#btn_clear_sm").css("display", "");
        } else if( sm_v_boletos.length == 1){
            $("#btn_edit_sm").css("display", "none");
            $("#btn_clear_sm").css("display", "");
        }else {
            $("#btn_edit_sm").css("display", "none");
            $("#btn_clear_sm").css("display", "none");
        }
    }
    function modal_edith_sm(){
        $("#modalEditarVBoletos").modal('show');
    }
    function modal_edith_hide(){
        $("#modalEditarVBoletos").modal('hide');
    }
    function clear_selected(){
        sm_v_boletos = [];
        $("input[class='cl_check_sm']:checked").removeAttr("checked");
        val_btn_edit_sm();
    }
    function procesar_edith_sm(){
        let tipo_pago = $("select[name='tipo_pago']").val();
        let aviajes = $("select[name='aviaje']").val();
        let f_regist = $("input[name='fecha_registro']").val();
        //console.log(aviajes);
        //return;
        if(f_regist != ""){
            let f = f_regist.split("-");
            let d = new Date();
            let proces = false;
            if(f[0] <= d.getFullYear()){
                if(f[1] <= d.getMonth()+1){
                    if(parseInt(f[2]) <= d.getDate()){
                        proces = true;
                    }
                }
            }
            if(!proces){
                toastr.warning("La fecha de registro no puede ser mayor a la fecha actual!.", "Disculpe!.");
                return;
            }
        }
        swal({
            title: "Espere un momento!",
            text: "Los datos esta siendo enviados.",
            icon: APP_URL + "/imagenes/loader.gif",
            button: {
                text: "Entiendo",
                value: false,
                closeModal: false,
            },
            closeOnClickOutside: false,
            closeOnEsc: false,
			dangerMode: true,
        });
        let url = APP_URL+"/tablero/ventaboletos/admin/update/varios";
        axios.post(url,{tpago: tipo_pago, aviaje: aviajes, freg: f_regist, boletos:sm_v_boletos}).then(response => {
            swal.close();
            toastr.success("Boletos actualizados con exito!. Esta página se actualizará en 5 seg.", "Excelente!.");
            setTimeout(() => {
                window.location.reload();
            }, 5000);
        }).catch(error => {
            console.log(error);
            console.log(error.response);
        });
    }
</script>






@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title" style="font-size: 24px;"><i class="fa fa-ticket"></i> Consultar Venta de boletos</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <form class="form-horizontal" role="form" method="POST" action="{{route('manageVboleto-A-fecha')}}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="col-sm-5" style="margin-left: 2%;"><label>Desde:</label>
                                <div class="form-group {{ $errors->has('fechai') ? ' has-error' : '' }} has-feedback">
                                    <input type="date" class="form-control" name="fechai" id="fechai" value="{{$fechai}}" placeholder="Fecha" >
                                    <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                                    @if ($errors->has('fechai'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('fechai') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-5"><label>Hasta:</label>
                                <div class="form-group {{ $errors->has('fechaf') ? ' has-error' : '' }} has-feedback">
                                    <input type="date" class="form-control" name="fechaf" id="fechaf" value="{{$fechaf}}" placeholder="Fecha" >
                                    <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
                                    @if ($errors->has('fechaf'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('fechaf') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <button type="submit"
                                        style="margin-top: 24px;padding: 7px; margin-left: 7%;"
                                        class="btn btn-warning btn-xs btn"
                                        data-toggle="tooltip"
                                        data-placement="left"
                                        title="Filtrar por fecha"
                                        data-original-title="Filtrar por fecha">
                                    <i class="fa fas fa-calendar" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4" style="padding-top:2%;">
                        <button class="btn btn-danger" id="btn_edit_sm" onclick="modal_edith_sm()" style="display:none">
                            <i class="fa fa-edit"></i> Editar Seleccionados
                        </button>
                        <button class="btn btn-grey" id="btn_clear_sm" onclick="clear_selected()" style="display:none">
                            <i class="fa fa-close"></i> Limpiar Seleccionados
                        </button>
                    </div>
                    <div class="col-md-2" style="padding-top: 5px;">
                        <button type=""
                                style="margin-top: 24px;"
                                class="btn btn-warning btn-sm btn abrirFiltro"
                                data-toggle="tooltip"
                                data-placement="left"
                                title="Filtros Generales"
                                data-original-title="">
                            <i class="fa fas fa-filter" aria-hidden="true"></i> 
                        </button>   
                      
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding-right: 2%;padding-left: 2%;">
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
                    @if (count($vboletos) > 0)
                        <div class="table-responsive">
                           <table border="1" bordercolor="#ccc" class="table{{--  js-exportable  --}}" id="vboletos" >
                               <thead class="table-danger">
                                    <tr>
                                       <th>SM</th>
                                       <th class="col-md-1">ID</th>
                                       <th class="col-md-1">DC</th>
                                       <th class="col-md-1">Registro</th>
                                       <th class="col-md-1">ID cotización</th>
                                       <th class="col-md-1">Codigo</th>
                                       <th class="col-md-1">DNI/RUC</th>
                                       <th class="col-md-2">Pasajero</th>
                                       <th class="col-md-2">Aereo linea</th>
                                       <th class="col-md-2">Ruta</th>
                                       <th class="col-md-2">Nro Tiket</th>
                                       <th class="col-md-2" style="display:none;">Consolidador</th>
                                       <th class="col-md-2">Agencia de Viajes</th>
                                       <th class="col-md-2">Agente</th>
                                       <th class="col-md-1" >Neto</th>
                                       <th class="col-md-2" style="display:none;">Tarifa</th>
                                       <th class="col-md-2">Comisón Agencia</th>
                                       <th class="col-md-1" style="display:none;">IGV</th>
                                       <th class="col-md-1" >Total</th>
                                         <th class="col-md-1" style="">Tipo de Pago</th>
                                       <th class="col-md-1" style="display:none;">Pago Consolidador</th>
                                       <th class="col-md-1" >Tarifa Fee</th>
                                     
                                       
                                       <th class="col-md-2" style="display:none;">Utilidad</th>
                                       <th class="col-md-2" style="display:none;">Incentivo</th>
                                       <th style="width: 2035px;" class="col-md-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vboletos as $vboleto)
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="" class="cl_check_sm" value="{{ $vboleto->id }}" onclick="set_val_sm({{ $vboleto->id }})">
                                        </td>
                                        <td>
                                            <input class="" type="hidden" value="{{$vboleto->id}}">{{$vboleto->id}}
                                        </td>
                                        @if($vboleto->doc_cobranza)
                                        <td>
                                            <button name="vdoc" id="vdoc" class="btn btn-warning btn-xs vdoc" value="{{$vboleto->doc_cobranza}}" data-toggle="tooltip" data-placement="left" title="Ver Documento de Cobranza">
                                                <i class="fa fa-paperclip" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                        @else
                                        <td>
                                            <button name="ndoc" id="ndoc" class="btn btn-danger btn-xs ndoc" value="{{$vboleto->nro_ticket}}" data-toggle="tooltip" data-placement="left" title="Agregar Documento de Cobranza">
                                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                        @endif
                                        <td>
                                            <input class="" type="hidden" value="{{$vboleto->created_at}}">{{$vboleto->created($vboleto->created_at)}}
                                        </td>
                                        <td>
                                            <input class="" type="hidden" value="{{$vboleto->venta_boleto_id}}">{{$vboleto->venta_boleto_id}}
                                        </td>
                                        <td>
                                            <input class="" type="hidden" value="{{$vboleto->codigo}}">{{$vboleto->codigo}}
                                        </td>
                                        <td>
                                            <input class="" type="hidden" value="{{$vboleto->cliente_id}}">{{$vboleto->cliente_id}}
                                        </td>
                                        <td class="mayus">
                                            <input class="" type="hidden" value="{{$vboleto->nombre_cliente}}">{{$vboleto->nombre_cliente}}
                                        </td>
                                        <td class="mayus"> 
                                            @if(!empty($vboleto->laereas->nombre))
                                                <input class="" type="hidden" value="{{$vboleto->laereas->nombre}}">{{$vboleto->laereas->nombre}}
                                            @else
                                                Esta Linea Aerea Ya no Existe
                                            @endif
                                        </td>
                                        <td class="mayus">
                                            <input class="" type="hidden" value="{{$vboleto->ruta}}">{{$vboleto->ruta}}
                                        </td>
                                        <td>
                                            <input class=""  type="hidden" value="{{$vboleto->nro_ticket}}">{{$vboleto->nro_ticket}}
                                        </td >
                                        <td style="display:none; " class="mayus">
                                            @if(!empty($vboleto->consolidadores->nombre))
                                                <input class="" type="hidden" value="{{$vboleto->consolidadores->nombre}}">{{$vboleto->consolidadores->nombre}}
                                            @else
                                                Este consolidador Ya no Existe
                                            @endif
                                        </td>
                                        <td class="mayus">
                                            <input class="" type="hidden" value="{{$vboleto->aviajes}}">{{$vboleto->aviajes}}
                                        </td>
                                        <td class="mayus">
                                            @if(!empty($vboleto->users->nombres))
                                                <input class="" type="hidden" value="{{$vboleto->users->nombres}} {{$vboleto->users->apellidos}}">{{$vboleto->users->nombres}} {{$vboleto->users->apellidos}}
                                            @else
                                                Este Usuario Ya no Existe
                                            @endif
                                        </td>
                                        <td >
                                            <input class="" type="hidden" value="{{$vboleto->neto}}">{{$vboleto->neto}}
                                        </td>
                                        <td hidden><input class="tarifat" type="hidden" value="{{$vboleto->tarifa}}">{{$vboleto->tarifa}}</td>
                                        <td><input class="subt" type="hidden" value="{{$vboleto->comision_agencia}}">{{$vboleto->comision_agencia}}</td>
                                        <td hidden><input class="igvt" type="hidden" value="{{$vboleto->igv}}">{{$vboleto->igv}}</td>
                                        <td ><input class="tt"  type="hidden" value="{{$vboleto->total}}">{{$vboleto->total}}</td>
                                        <td ><input class="tt" type="hidden" value="{{$vboleto->tipo_pago}}">{{$vboleto->tipop->pago}}</td>
                                         <td hidden><input class="pagoc" type="hidden" value="{{$vboleto->pago_consolidador}}">{{$vboleto->pago_consolidador}}</td>
                                         <td ><input class="tarifaff" type="hidden" value="{{$vboleto->tarifa_fee}}">{{$vboleto->tarifa_fee}}</td>
                                        
                                       
                                       
                                        <td hidden><input class="util" type="hidden" value="{{$vboleto->utilidad}}">{{$vboleto->utilidad}}</td>
                                        <td hidden><input class="incen" type="hidden" value="{{$vboleto->incentivo}}">{{$vboleto->incentivo}}</td>
                                        <td  style="width: 235px;">
                                            <button name="dtiketss" id="dtiketss" class="btn btn-warning btn-xs dtiketss" value="{{$vboleto->nro_ticket}}" data-toggle="tooltip" data-placement="left" title="Ver detalles del ticket">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>
                                            <button name="dfecha" id="dfecha" class="btn btn-warning btn-xs dfecha" value="{{$vboleto->nro_ticket}}"  data-toggle="tooltip" data-placement="left" title="Editar fecha de registro">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </button>
                                            @if(Auth::user()->role == "Administrador")
                                                <a class="btn btn-danger btn-xs" href="{{ route('manageVboleto-anulate-A', $vboleto->nro_ticket) }}" onclick="return confirm('Seguro que desea anular el Registro {{$vboleto->nro_ticket}}?')" data-toggle="tooltip" data-placement="left" title="Anular">
                                                    <i class="fa fa-minus-square"></i>
                                                </a>
                                                <button name="dtiketsedit" id="dtiketsedit" class="btn btn-danger btn-xs dtiketsedit" value="{{$vboleto->nro_ticket}}" data-toggle="tooltip" data-placement="left" title="Editar ticket">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </button>
                                                <a class="btn btn-info btn-xs" href="{{ route('manageVboleto-pdf-A', $vboleto->nro_ticket) }}" onclick="return confirm('Desea Generar PDF del Boleto Nº {{$vboleto->nro_ticket}}?')" data-toggle="tooltip" data-placement="left" title="Imprimir Boleto">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </a>
                                            @endif
                                            @if ($vboleto->pagado== "1")
                                                <span class="label label-success">Pagado</span>
                                            @else
                                                <span class="label label-danger">Sin pagar</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-block alert-info" style="margin-top: 44px; margin-left: 1%;">
                            <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                            <p class="margin-bottom-10">
                                No existen items registrados en el sistema.
                            </p>
                        </div>
                    @endif
                    @include('vboletos.modales.editar_v_boletos')
                </div>
            </div>
        </div>
        <hr>
    
   
<div class="row">
    <hr>
    <div class="col-md-2">
        <input disabled="" type="text" name="cc" id="cc" value="{{count($vboletos)}}" class="h3 text-red form-control edit-input"><div></div>
        <span class="h4"> Cantidad de venta de Boletos</span>
    </div>
    <div class="col-md-5">
        <div style="text-align: right;" class="col-md-6">
            <span class="h4 mod-span">Pago cons. </span><div></div>
            <span class="h4 mod-span">Tarifa FEE </span><div></div>
            <span class="h4 mod-span">Utilidad </span><div></div>
            <span class="h4 mod-span">Incentivo </span><div></div>
        </div>
        <div style="background-color: #fafafa;" class="col-md-6">
            <input disabled="" name="pagoc" id="pagoc" value="0" class="h3 text-red form-control edit-input"><div></div>
            <input disabled="" name="tarifaff" id="tarifaff" value="0" class="h3 text-red form-control edit-input"><div></div>
            <input disabled="" name="util" id="util" value="0" class="h3 text-red form-control edit-input"><div></div>
            @foreach($incentivos as $incentivo)
            <input type="hidden" name="primera_meta" id="primera_meta" value="{{$incentivo->primera_meta}}">
            <input type="hidden" name="primer_incentivo" id="primer_incentivo" value="{{$incentivo->primer_incentivo}}">
            <input type="hidden" name="segunda_meta"value="{{$incentivo->segunda_meta}}">
            <input type="hidden" name="segundo_incentivo" value="{{$incentivo->segundo_incentivo}}">
            <input type="hidden" name="tercera_meta" value="{{$incentivo->tercera_meta}}">
            <input type="hidden" name="tercer_incentivo" value="{{$incentivo->tercer_incentivo}}">
            <input type="hidden" name="cuarta_meta" value="{{$incentivo->cuarta_meta}}">
            <input type="hidden" name="cuarto_incentivo" value="{{$incentivo->cuarto_incentivo}}">
            <input type="hidden" name="quinta_meta" value="{{$incentivo->quinta_meta}}">
            <input type="hidden" name="quinto_incentivo" value="{{$incentivo->quinto_incentivo}}">
            @endforeach
            <input disabled="" name="incen" id="incen" value="0" class="h3 text-red form-control edit-input"><div></div>
        </div>
    </div>
    <div class="col-md-5">
        <div style="text-align: right;" class="col-md-6">
            <span class="h4 mod-span">Sub total </span><div></div>
            <span class="h4 mod-span">IGV </span><div></div>
            <span class="h4 mod-span">TOTAL </span><div></div>
        </div>
        <div style="background-color: #fafafa;" class="col-md-6">
            <input disabled="" name="subt" id="subt" value="0" class="h3 text-red form-control edit-input"><div></div>
            <input disabled="" name="igvt" id="igvt" value="0" class="h3 text-red form-control edit-input"><div></div>
            <input disabled="" name="tt" id="tt" value="0" class="h3 text-red form-control edit-input"><div></div>
        </div>
    </div>
</div>
</div>
</div>
@foreach ($vboletos as $vboleto)
<div class="modal-lg modal modala{{$vboleto->nro_ticket}}" style="overflow-y: scroll;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close cerrarrr" value="{{$vboleto->nro_ticket}}" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h5 class="modal-title" id="myModalLabel"> <h3><i class="fa fa-pencil-square-o"></i> Editar fecha de registro</h3></h5>
        </div>
        <div class="modal-body">
            <div>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('manageVboleto-A-cfecha',$vboleto->id) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="col-sm-12">
                        <div class="row">
                            <h4 class="text-center"  name="fechap" id="fechap">Fecha actual del registro</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label class=" control-label col-sm-5">Fecha de Registro</label>

                                <div class="col-sm-7">
                                   <input type="date" class="form-control"  name="fechai" id="fechai" value="{{$fechai}}" placeholder="Fecha" >
                               </div>
                           </div>
                       </div>
                       <div class="col-sm-6">
                        <div class="form-group ">
                           <label class=" control-label col-sm-5"> Fecha de Proceso</label>                               

                           <div class="col-sm-7">
                               <input type="date" class="form-control"  name="fechaf" id="fechaf" value="{{$fechaf}}" placeholder="Fecha" >


                           </div>
                       </div>
                   </div>
                   <div class="row">
                    <h4 class="text-center" name="fechas" id="fechas"  >Nueva fecha  de registro</h4>
                </div>
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="form-group {{ $errors->has('fecha') ? ' has-error' : '' }} has-feedback">
                        <input type="date" class="form-control" name="fecha" id="fecha" value={{$vboleto->created_at}} placeholder="Fecha" >
                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
                        @if ($errors->has('fecha'))
                        <span class="help-block">
                          <strong>{{ $errors->first('fecha') }}</strong>
                      </span>
                      @endif
                  </div>
              </div>
              <input type="text" class="hidden" name="nro_ticket" value="{{$vboleto->nro_ticket}}">

          </div>




          <div class=" row">


          </div>


      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-warning" data-dismiss="modal">Cambiar</button>
    </div>
</form>
</div>
</div>
</div>
</div>
@endforeach
@foreach ($vboletos as $vboleto)
<div class="modal-lg modal modale{{$vboleto->nro_ticket}}" style="overflow-y: scroll;">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-ticket"></i> Tikets y Costo</h4>
        </div>
        <div class="modal-body">
            @section('script')
            <script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>
            <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
            <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
            @endsection
            <div>
                <section>
                    <div class=" row">
                        <div class="col-sm-10 col-sm-offset-1">

                            <div class="clearfix"></div>
                            <div id="formulario">
                                <input name="userid" class="btn btn-sm btn-info btn-flat pull-left form-control required" type="button" class="form-control" value="" id="userid" placeholder="" required>
                                <input name="iva" class="btn btn-sm btn-info btn-flat pull-left form-control required" type="hidden" class="form-control" value="" id="iva" placeholder="" required>
                                <div  class="col-md-6">
                                    <label>Nro de Tikets</label>
                                    <input class="form-control required input-sm text-red" type="text"  value="{{$vboleto->nro_ticket}}" id="tikets"  name="tikets" placeholder="Tikets" >
                                    <label>Neto</label>
                                    <input class="form-control required input-sm text-red" type="text"  value="{{$vboleto->neto}}" name="neto" id="neto" placeholder="Neto" >
                                    <label>Tarifa</label>
                                    <input class="form-control required input-sm text-red" type="text"  value="{{$vboleto->tarifa}}" name="tarifa" id="tarifa"  placeholder="Tarifa" >
                                    <label>Comision de Agencia</label>
                                    <input class="form-control monto required input-sm text-red" type="text"  value="{{$vboleto->comision_agencia}}" name="comi"  id="comi"  placeholder="Comision" >
                                    <label>IGV</label>
                                    <input class="form-control monto required input-sm text-red" type="number" step="any"  value="{{$vboleto->igv}}" name="igv" id="igv"  placeholder="IGV" >
                                    <label>Consolidadores</label>
                                    @foreach ($consolidadores as $item)
                                        @if ($vboleto->consolidadores_id == $item->id)
                                            <input disabled type="text" class="form-control input-sm text-red" value="{{$item->nombre}}">
                                        @endif
                                    @endforeach
                                </div>
                                <div  class="col-md-6">
                                    <label>Total</label>
                                    <input class="form-control required input-sm text-red" type="number" step="any" value="{{$vboleto->total}}" id="total" name="total" placeholder="Total" >
                                    <label>Pagar a Consolidador</label>
                                    <input class="form-control required input-sm text-red " type="text"  value="{{$vboleto->pago_consolidador}}" name="conso" id="conso" placeholder="Pagar a Cosolidador"  readonly>
                                    <label>Tarifa + FEE</label>
                                    <input class="form-control required input-sm text-red" type="text"  value="{{$vboleto->tarifa_fee}}"  name="tarifaf" id="tarifaf" placeholder="Tarifa + FEE" >
                                    <label>Utilidad</label>
                                    <input class="form-control required input-sm text-red" type="text"  value="{{$vboleto->utilidad}}" name="utilidad" id="utilidad" placeholder="Utilidad" >
                                    <label>Incentivo</label>
                                    <input class="form-control required input-sm text-red" type="text"  value="{{$vboleto->incentivo}}" name ="incentivo" id="incentivo" placeholder="Incentivo" >
                                </div>
                                <div align="center" class="col-md-10 col-sm-offset-1">
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn cerrarr btn-warning" value="{{$vboleto->nro_ticket}}" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
@endforeach
</button>
<!------------------------------------Modal editar Ticket------------------------------>

<div class="modal-lg modal modalee" style="overflow-y: scroll;">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pencil-square-o"></i>Editar Tikets y Costo</h4>
        </div>
        <div class="modal-body">
            <div>
                <section>
                    <div class=" row">
                        <div class="col-sm-10 col-sm-offset-1">

                            <div class="clearfix"></div>
                            <div id="formulario">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('manageVboleto-update-A') }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    
                                    <div class="row">
                                        <h4 class="text-center"  name="fechap" id="fechap"><i class="fa fa-calendar"></i> Fecha actual del registro</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label class=" control-label col-sm-4">Fecha de Registro</label>

                                            <div class="col-sm-8">
                                               <input type="date" class="form-control"  name="fechai" id="fechai" value="{{$fechai}}" placeholder="Fecha" >


                                           </div>
                                       </div>
                                   </div>
                                   <div class="col-sm-6">
                                    <div class="form-group ">
                                       <label class=" control-label col-sm-4"> Fecha de Proceso</label>                               

                                       <div class="col-sm-8">
                                           <input type="date" class="form-control"  name="fechaf" id="fechaf" value="{{$fechaf}}" placeholder="Fecha" >


                                       </div>
                                   </div>
                               </div>



                               <input name="userid" class="btn btn-sm btn-info btn-flat pull-left form-control required" type="button" class="form-control" value="" id="userid" placeholder="" required>
                               <input name="iva" class="btn btn-sm btn-info btn-flat pull-left form-control required" type="hidden" class="form-control" value="" id="iva" placeholder="" required>
                               <div class="row mods-h4">
                                <input type="hidden" name="dvaloreninput" id="dvaloreninput" value="">
                                <input type="hidden" name="diva" id="diva" value="{{$iva->iva}}">

                                <div class="col-sm-8" id="vporcentaje" style="margin-top: 10px;padding-left: 4%;">
                                    <label for="porcentaje">Comision de Agencia para este Ticket %</label>
                                    <input type="number" value="0" step="any" name="porcentaje" id="porcentaje">
                                </div>
                            </div>
                            <div  class="col-md-6">
                                <label>Nro de Tikets</label>
                                <input class="form-control required input-sm text-red" type="text"  value="" id="dtikets"  name="dtikets" placeholder="Tikets" readonly>
                                <label>Neto</label>
                                <input class="form-control required input-sm text-red" type="number" step="any"  value="" name="dneto" id="dneto" placeholder="Neto" >
                                <label>Tarifa</label>
                                <input class="form-control required input-sm text-red" type="number" step="any"  value="" name="dtarifa" id="dtarifa"  placeholder="Tarifa" >
                                <label>Comision de Agencia</label>
                                {{-- <input class="form-control monto required input-sm text-red"
                                        type="number"
                                        value=""
                                        name="comision"> --}}
                                <input class="form-control monto required input-sm text-red"
                                        type="number"
                                        value=""
                                        name="dcomi"
                                        id="dcomi"
                                        step="0.01"
                                        placeholder="Comision">
                                <label>IGV</label>
                                <input class="form-control monto required input-sm text-red"
                                        type="number"
                                        step="any"
                                        value=""
                                        name="digv"
                                        id="digv"
                                        placeholder="IGV"
                                        readonly>
                            </div>
                            <div  class="col-md-6">
                                <label>Total</label>
                                <input class="form-control required input-sm text-red"
                                        type="number"
                                        step="any"
                                        value=""
                                        id="dtotal"
                                        name="dtotal"
                                        placeholder="Total"
                                        readonly>
                                <label>Pagar a Consolidador</label>
                                <input class="form-control required input-sm text-red " type="number" step="any"  value="" name="dconso" id="dconso" placeholder="Pagar a Cosolidador"  readonly>
                                <label>Tarifa + FEE</label>
                                <input class="form-control required input-sm text-red" type="number" step="any"  value=""  name="dtarifaf" id="dtarifaf" placeholder="Tarifa + FEE" >
                                <label>Utilidad</label>
                                <input class="form-control required input-sm text-red" type="number" step="any" value="" name="dutilidad" id="dutilidad" placeholder="Utilidad" readonly>
                                <label>Incentivo</label>
                                <input class="form-control required input-sm text-red" type="number" step="any"  value="" name ="dincentivo" id="dincentivo" placeholder="Incentivo" readonly><br>
                            </div>
                            <div class="row">

                                <div class="row">
                                    <div style="text-align: right;" class="col-sm-2"><H4>Tipo de Pago</H4></div>
                                    <div  class="col-sm-4">
                                        <select name="tpago" class="select2" id="tpago" style="width: 180px; margin-top: 7px;">
                                            <option value="">Tipo de Pago</option>
                                            @foreach($tipop as $tipo)
                                            <option value="{{$tipo->id}}">{{$tipo->pago}}</option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div  class="col-sm-2"><H4>Linea Aerea</H4></div>
                                    <div  class="col-sm-4" style="margin-left: -4%;">
                                        <select name="laerea" class="select2" id="laerea" style="width: 180px; margin-top: 7px; ">
                                            <option value="">Linea Aerea</option>
                                            @foreach($laereas as $laerea)
                                            <option value="{{$laerea->id}}">{{$laerea->nombre}}</option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div style="text-align: right;" class="col-sm-2"><H4>Agencia de viajes</H4></div>
                                    <div class="col-sm-4">
                                        <select name="aviajes" class="select2" style="width: 180px; margin-top: 7px;">
                                            <option value="">Agencia de Viaje</option>
                                            @foreach($aviajes as $aviaje)
                                            <option value="{{$aviaje->nombre}}">{{$aviaje->nombre}}</option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-sm-2" style="margin-left: -4%;"><H4>Consolidador</H4></div>
                                    <div  class="col-sm-4">
                                        <select name="consolidadors" class="select2" id="consolidadors" style="width: 180px; margin-top: 7px;">
                                            <option value="">Consolidador</option>
                                            @foreach($consolidadores as $consolidador)
                                            <option value="{{$consolidador->id}}">{{$consolidador->nombre}}</option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div align="center" class="col-md-10 col-sm-offset-1">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning" data-dismiss="modal">Guardar edicion</button>
                                     <button type="button" class="btn cerrarre btn-warning" value="" data-dismiss="modal">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
   
</div>
</div>

</button>
<!------------------------------------Modal editar ticket------------------------------>

<div class="modal-lg modal modalFiltro">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close cerrarFiltro" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h5 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-filter"></i> Filtros Generales </h4></h5>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('manageVboleto-A-busquedag')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="box col-sm-10">
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
                    <div class="row">
                        <div style="text-align: right;" class="col-sm-4"><H4>Pasajero</H4></div>
                        <div class="col-sm-8">
                            <input type="text" name="pasajero" id="pasajero" class="form-control" style="margin-top: 7px"/>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div style="text-align: right;" class="col-sm-4"><H4>Tipo de Pago</H4></div>
                        <div  class="col-sm-8">
                            <select class="form-control" name="tpago" id="tpago" style="margin-top: 7px">
                                <option value="">Tipo de Pago</option>
                                @foreach($tipop as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->pago}}</option>
                                @endforeach
                            </select>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="row col-sm-10" style="margin-left: 32%;">
                     <div class="col-sm-5"><label>Desde:</label>
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
                  <div class="col-sm-5"><label>Hasta:</label>
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
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning" data-dismiss="modal">Buscar</button>
    </div>
</form>
</div>
</div>
<!------------------------------------Modal editar documento de cobranza------------------------------>

<div class="modal-lg modal modalDoc">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close cerrarDoc" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h5 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-filter"></i> Incluir Documento de Cobranza </h4></h5>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('manageVboleto-Doc_C-A')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <h4 class="title" id="myModalLabel">Documento de Cobranza</h4>

                <h4 align="center"><i class="fa fa-file-image-o"></i>Cargar Documento</h4>

                <div class="form-group {{ $errors->has('doc_cobranza') ? ' has-error' : '' }} has-feedback">
                    <input type="file" class="form-control" name="doc_cobranza" placeholder="Documento de Cobranza">
                    <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>
                    @if ($errors->has('doc_cobranza'))
                    <span class="help-block">
                        <strong>{{ $errors->first('doc_cobranza') }}</strong>
                    </span>
                    @endif
                </div>

                <input type="hidden" name="tk" id="tk">
                <div class="row hidden">
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
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning" data-dismiss="modal">Cargar</button>

    </form>
</div>
</div>
</div>

@endsection


