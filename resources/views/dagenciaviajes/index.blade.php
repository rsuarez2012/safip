@extends('layouts.master')

@section('titulo', 'Deuda de agencia de viajes')

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

<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/dataTables.bootstrap.js")!!}></script>
<script type="text/javascript">
    $(function () {
        $('#pconsolidadores').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "lengthMenu": [ 50,100, 200, 500],
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

    $('#exportar').click(function(e){
        var htmltable= document.getElementById('pconsolidadores');
        var html = htmltable.outerHTML; window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
        /* window.open('data:application/vnd.ms-excel,' +  encodeURIComponent ($('#cotiza').html()));*/
        e.preventDefault();

    });

    function BuscarPagos(h,i,j){
        /*consulta a base de datos para traer el detalle de los pagos*/
        var codigo = i;
        var ticket = j;
        var suma=0;
        var APP_URL = {!!json_encode(url('/'))!!};
        $.get(APP_URL+'/tablero/dagenciaviajes/getdcobros/' + codigo+ '/'+ ticket, function (pagos) {
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
            $(".micheckbox").on( 'change', function() {
                if( $(this).is(':checked') ) {
                    var a = $(this).val();
                    var b = $('#sl').val();
                    var c = parseFloat(a) + parseFloat(b);
                    $('#sl').val(c.toFixed(2));
                } else {
                    var a = $(this).val();
                    var b = $('#sl').val();
                    var c = parseFloat(b) - parseFloat(a);
                    $('#sl').val(c.toFixed(2));
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
    <div class="col-md-12">
        <div class="box padding_box1">
            <div class="row">
               <div class="col-md-10">
                <div class="x_title">
                    <h2><i class="fa fa-ticket"></i> Consultar deuda de agencia de viajes</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-2">

            </div>
            <form class="form-horizontal" role="form" method="POST" action="{{route('manageDagenciaviajes-A-fecha')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="col-sm-2" style="margin-left: 2%;"><label>Desde:</label>
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
              <div class="col-sm-2"><label>Hasta:</label>
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
          <div class="col-md-6">

            <button type="submit" style="margin-top: 24px;padding: 7px;" class="btn btn-warning btn-xs btn"  data-toggle="tooltip" data-placement="left" title=" Filtrar por Fechas" data-original-title="Filtrar por fecha">
                <i class="fa fas fa-calendar" aria-hidden="true"></i>
            </button>
        </form>
        <div class="col-md-2 pull-right" ;>
           <a  type="" style="margin-top: 24px;padding: 7px;" class="btn btn-warning btn-xs btn abrirFiltro "  data-toggle="tooltip" data-placement="left" title="Filtros Generales" data-original-title="">
            <i class="fa fas fa-filter" aria-hidden="true"></i>
        </a > 
   
        <button name="exportar" style="margin-top: 24px;padding: 7px;" id="exportar" class="btn btn-warning btn-sm  exportar" data-toggle="tooltip" data-placement="top" title="exportar excel"><i class="fa fa-file-excel-o"></i></button>
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
        <thead style="background-color: #dd4b39; color: white; ">
            <tr>
                <th class="col-md-1">Seleccionar</th>
                <th class="col-md-2">Registro</th>
                <th class="col-md-2">Venta Boleto ID</th>
                <th class="col-md-2">Nro de Ticket</th>
                <th class="col-md-1">DNI</th>
                <th class="col-md-2">Pasajero</th>
                <th class="col-md-1">Linea Aerea</th>
                <th class="col-md-1">Ruta</th>
                <th class="col-md-1">Consolidador</th>
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

                <td><input type="checkbox" class="micheckbox" name="" value="{{$deuagencias->tarifa_fee}}"></td>
                <td>{{$deuagencias->fecha}}</td>
                <td>{{$deuagencias->venta_boleto_id}}</td>
                <td>{{$deuagencias->nro_ticket}}</td>
                <td>{{$deuagencias->dni_ruc}}</td>
                <td>{{$deuagencias->nombre_cliente}}</td>
                <td>@if(!empty($deuagencias->laereas->nombre))
                    {{$deuagencias->laereas->nombre}}
                    @else
                    Esta Linea Aerea Ya no Existe
                @endif</td>
                <td>{{$deuagencias->ruta}}</td>
                <td>@if(!empty($deuagencias->consolidadores->nombre))
                    {{$deuagencias->consolidadores->nombre}}
                    @else
                    Este consolidador Ya no Existe
                @endif</td>
                <td>{{$deuagencias->aviajes_id}}</td>
                <td>{{$deuagencias->tarifa_fee}}<input type="hidden" class="tf" value="{{$deuagencias->tarifa_fee}}"></td>
                <td>{{$deuagencias->porpagar}}<input type="hidden" class="pc" value="{{$deuagencias->porpagar}}"></td>
                <td>{{$deuagencias->agentes_id}}</td>
                <td>{{$deuagencias->diasc}}</td>
                <td>
                    @if ($deuagencias->status== "1")
                    <span class="label label-success">Pagada</span>
                    @else
                    <span class="label label-danger">Por Cobrar</span>
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
      <span class="h4 text-red"><input class="h3 text-red transparenteinput" value="" name="tf" id="tf" readonly></span><div></div>
      <span class="h4 text-red"><input class="h3 text-red transparenteinput" value="" name="pc" id="pc" readonly></span><div></div>
      <span class="h4 text-red"><input class="h3 text-red transparenteinput" value="0" name="sl" id="sl" readonly></span><div></div>
  </div>
</div>

</div>
</div>
</div>

<!----------------------------MODAL modificar cuentas por agar-------------------------------->
@foreach ($deuagenciasv as $deuagencias)
<div class="modal-lg modal modale{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close cerrar" value="{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-pencil"></i> Modificar cuenta por Cobrar</h4></h4>
        </div>
        <div class="modal-body">
           <form class="form-horizontal row" role="form" method="POST" action="{{ route('manageDagenciaviajes-storeb-A') }}" enctype="multipart/form-data">

             {!! csrf_field() !!}
             <div class="col-sm-12">
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('proveedor') ? ' has-error' : '' }}">
                      <label  class="col-sm-4 control-label">Proveedor</label>

                      <div class="col-sm-8">
                       <input type="text" name="proveedor" value="{{$deuagencias->consolidadores_id}}" required class="form-control" readonly>
                   </input>
                   @if ($errors->has('proveedor'))
                   <span class="help-block">
                      <strong>{{ $errors->first('proveedor') }}</strong>
                  </span>
                  @endif

              </div>
          </div>
          <div class="form-group {{ $errors->has('fecha') ? ' has-error' : '' }} has-feedback">
              <label  class="col-sm-4 control-label">Fecha</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" name="fecha" id="fecha" value="{{$deuagencias->created_at }}" placeholder="Fecha" readonly>

                <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                @if ($errors->has('fecha'))
                <span class="help-block">
                  <strong>{{ $errors->first('fecha') }}</strong>
              </span>
              @endif

          </div>
      </div>
      <div class="form-group {{ $errors->has('codigo') ? ' has-error' : '' }} has-feedback">
        <label  class="col-sm-4 control-label">Nro de Cotizacion</label>

        <div class="col-sm-8">
           <input type="text" class="form-control" name="codigo" id="codigo" value="{{$deuagencias->venta_boleto_id}}" placeholder="Codigo" readonly>

           <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

           @if ($errors->has('codigo'))
           <span class="help-block">
              <strong>{{ $errors->first('codigo') }}</strong>
          </span>
          @endif

      </div>
  </div>
</div>
<div class="col-sm-6">
  <div class="form-group {{ $errors->has('ticket') ? ' has-error' : '' }} has-feedback">
      <label  class="col-sm-4 control-label">Ticket</label>

      <div class="col-sm-8">
       <input type="text" class="form-control" name="ticket" id="ticket" value="{{$deuagencias->nro_ticket}}" placeholder="ticket" readonly>

       <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

       @if ($errors->has('ticket'))
       <span class="help-block">
          <strong>{{ $errors->first('ticket') }}</strong>
      </span>
      @endif

  </div>
</div>
<div class="form-group {{ $errors->has('monto') ? ' has-error' : '' }} has-feedback">
  <label  class="col-sm-4 control-label">Monto</label>

  <div class="col-sm-8">

   <input type="number" step="any" class="form-control" name="mfacturar{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" id="mfacturar{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" value="{{$deuagencias->tarifa_fee}}" placeholder="Monto" readonly>

   <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

   @if ($errors->has('monto'))
   <span class="help-block">
      <strong>{{ $errors->first('monto') }}</strong>
  </span>
  @endif
</div>
</div>
<div class="form-group {{ $errors->has('dias') ? ' has-error' : '' }} has-feedback">
  <label  class="col-sm-4 control-label">Dias a Cobrar</label>

  <div class="col-sm-8">
   <input type="number" class="form-control" name="dias{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" id="dias{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" value="{{$deuagencias->diasc}}" placeholder="Dias para Cobrar" readonly>

   <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

   @if ($errors->has('dias'))
   <span class="help-block">
      <strong>{{ $errors->first('dias') }}</strong>
  </span>
  @endif

</div>
</div>
</div>
<div class="col-sm-12 "><hr>
    <div class="form-group {{ $errors->has('tipop') ? ' has-error' : '' }} ">
        <label class="col-sm-4 control-label">Tipo de Pago</label>
        <div class="col-sm-6">
          <select name="tipop" id="tipop" class="form-control {{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}} tipop{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" required >
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

  </select>


</div>
</div><hr>
</div>
<div class="col-sm-6">
 <div class="form-group {{ $errors->has('bancoe') ? ' has-error' : '' }}" id="disable1{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}} ">
  <label  class="col-sm-4 control-label">Banco Emisor</label>

  <div class="col-sm-8">
     <select name="bancoe{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" id="bancoe{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}"  required class="form-control" disabled>
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
<div class="form-group {{ $errors->has('noperacion') ? ' has-error' : '' }} has-feedback" id="disable3{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}">
  <label  class="col-sm-4 control-label">Nro de Operacion</label>

  <div class="col-sm-8">
     <input type="text" class="form-control" name="noperacion{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" id="noperacion{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" id="Nro peración" value="" placeholder="noperacion" disabled>
     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

     @if ($errors->has('noperacion'))
     <span class="help-block">
      <strong>{{ $errors->first('noperacion') }}</strong>
  </span>
  @endif

</div>
</div>
<div class="form-group {{ $errors->has('tabono') ? ' has-error' : '' }} has-feedback">
  <label  class="col-sm-4 control-label">Total Abono</label>

  <div class="col-sm-8">
     <input type="number" class="form-control" name="mtotal{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" id="mtotal{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" value="0" placeholder="tabono" readonly>
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
    <div class="form-group {{ $errors->has('bancor') ? ' has-error' : '' }}" id="disable2{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}">
      <label  class="col-sm-4 control-label">Banco Receptor</label>

      <div class="col-sm-8">
        <select name="bancor{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" id="bancor{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}"  required class="form-control" disabled>
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
  <label  class="col-sm-4 control-label">Abono</label>

  <div class="col-sm-8">
     <input type="number" class="form-control" name="montom{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" id="montom{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" value="" placeholder="abono" >
     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
     @if ($errors->has('abono'))
     <span class="help-block">
      <strong>{{ $errors->first('abono') }}</strong>
  </span>
  @endif

</div>
</div>
<div class="form-group {{ $errors->has('resta') ? ' has-error' : '' }} has-feedback">
    <label  class="col-sm-4 control-label">Resta</label>

    <div class="col-sm-8">
       <input type="number" step="any" class="form-control" name="mresta{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" id="mresta{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" value="0" placeholder="resta" readonly>
       <input type="hidden" class="restaenv{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" name="restaenv" id="restaenv" value="" >
       <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

       @if ($errors->has('resta'))
       <span class="help-block">
          <strong>{{ $errors->first('resta') }}</strong>
      </span>
      @endif

  </div>
</div>
</div>


</div>
<div class="text-center" >

    <button id="debitar" value=""  name="debitar"  class="btn label-success ">
    Debitar </button>

</div><br>
 <table class="table table-responsive table-bordered table-condensed cdata" id="cdata{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" name="cdata{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}">
                                                        <thead>
                                                        <tr>
                                                            <th class="col-md-2 text-center">Abono</th>
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
<div class="modal-footer">
    <div class="form-actions">
     <button type="button" class="btn cerrar btn-warning" value="{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}" data-dismiss="modal">Cerrar</button>
     <button type="submit" id="registrar" name="registrar" class="btn btn-success pull-right registrar{{$deuagencias->venta_boleto_id}}{{$deuagencias->nro_ticket}}">
        Registrar <i class="fa fa-arrow-circle-right"></i>
    </button>

</div>

</div>
</form>
</div>
</div>
@endforeach

<!-------fin modal modificar cuenta por pagar--------->
<div class="modal-lg modal modalFiltro">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close cerrarFiltro" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h5 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-filter"></i> Filtros Generales </h4></h5>
        </div>
        <div class="modal-body">

            <form class="form-horizontal" role="form" method="POST" action="{{ route('manageDagenciaviajes-A-busquedag')}}" enctype="multipart/form-data">
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
                                        <div class="col-sm-4"><H4 style="
    margin-left: 77%;
">Estatus</H4></div>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="status" id="status">
                                                <option value="0">Por Pagar</option>
                                                <option value="1">Pagado</option>
                                            </select>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3" style="margin-left: 43%;"><label>Desde:</label>
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
                                      <div class="col-md-3"><label>Hasta:</label>
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

