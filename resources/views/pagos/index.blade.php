@extends('layouts.master')
@section('titulo', 'Pagos')
@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('script')

<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/dataTables.bootstrap.js")!!}></script>
<script type="text/javascript">
    $(function () {
        $('#pagos').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "lengthMenu": [ 50,100, 200, 500],

            "autoWidth": true

        });
    });
    function BuscarPagos(h){
        /*consulta a base de datos para traer el detalle de los pagos*/
        var codigo = h;
        var cont=0;
        var suma=0;
        var APP_URL = {!!json_encode(url('/'))!!};
        $.get(APP_URL+'/tablero/pagos/getdpagos/' + codigo, function (pagos) {
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
                    
                     $("#mdata"+h).append(tr);
                 });
            $.each(pagos, function(i, item) {

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
            BuscarPagos(h);

            if(e > 0){
                $(".registrar").attr('disabled',true);
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
                    <h2><i class="fa fa-file-text"></i> Consultar cuentas por pagar</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-2" style="margin-top: 24px;">
                <a href="{{ route('managePago-C-A') }}" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Nueva Cuenta por pagar"><i class="fa fa-plus" ></i> </a>
            </div>
            <div class="col-md-4"><label>Lista de cuentas por pagar</label>

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
        if( count($pagos) >0){
            ?>
            <table class="table" id="pagos" >
                <thead style="background-color: #dd4b39; color: white; ">
                    <tr>
                        <th class="col-md-2 text-center">Id</th>
                        <th class="col-md-2">Concepto</th>
                        <th class="col-md-2">Codigo</th>
                        <th class="col-md-1">Consolidador</th>
                        <th class="col-md-2">Dias por pagar</th>
                        <th class="col-md-2">Monto</th>
                        <th class="col-md-2">Estatus</th>
                        <th class="col-md-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                    <tr>
                        <td class="text-center">{{$pago->id}}</td>
                        <td>{{$pago->concepto}}</td>
                        <td>{{$pago->codigo}}</td>
                        <td>{{$pago->proveedor_id}}</td>
                        <td>{{$pago->dias}}</td>
                        <td>{{$pago->monto}}</td>
                        <td>
                            @if ($pago->status== "1")
                            <span class="label label-success">Pagada</span>
                            @else
                            <span class="label label-danger">Por Pagar</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-xs btn abrir" value="{{$pago->codigo}}Ç{{$pago->status}}" href="" data-toggle="tooltip" data-placement="left" title="Modificar cuenta por pagar">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <?php
            echo str_replace('/?', '?', $pagos->render());
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
            <span class="h3 text-red">{{$pagosc}}</span><div></div>
            <span class="h4"> Cuentas por pagar</span>
        </div>
        <div class="col-md-2">
            <span class="h3 text-red">{{$pagost}}</span><div></div>
            <span class="h4"> Total de cuentas por pagar</span>
        </div>
    </div>
</div>
</div>
@foreach ($pagos as $pago)
<div class="modal-lg modal modale{{$pago->codigo}}" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close cerrar" value="{{$pago->codigo}}" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-pencil-square-o"></i> Modificar cuenta por pagar</h4></h4>
        </div>
        <div class="modal-body">

            @section('script')
            <script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>
            <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
            <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
            @endsection

            <form class="form-horizontal row" role="form" method="POST" action="{{ route('managePago-storeb-A') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="col-sm-12">
                    <div class="col-sm-6">

                       <div class="form-group  {{ $errors->has('concepto') ? ' has-error' : '' }} has-feedback">
                          <label  class="col-sm-4 control-label">Tipo</label>

                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="concepto" id="concepto" value="{{$pago->concepto}}" placeholder="Concepto" readonly>

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('concepto'))
                            <span class="help-block">
                              <strong>{{ $errors->first('concepto') }}</strong>
                          </span>
                          @endif

                      </div>
                  </div>
                  
                  <div class="form-group {{ $errors->has('fecha') ? ' has-error' : '' }} has-feedback">
                    <label class="col-sm-4 control-label">Fecha</label>
                    <div class="col-sm-8">
                     <input type="date" class="form-control" name="fecha" id="fecha" value="{{$pago->fecha}}" placeholder="Fecha" readonly>

                     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                     @if ($errors->has('fecha'))
                     <span class="help-block">
                      <strong>{{ $errors->first('fecha') }}</strong>
                  </span>
                  @endif

              </div>
          </div>
          <div class="form-group {{ $errors->has('monto') ? ' has-error' : '' }} has-feedback">
            <label class="col-sm-4 control-label">Monto</label>
            <div class="col-sm-8">
                <input type="number" step="any" class="form-control" name="mfacturar{{$pago->codigo}}" id="mfacturar{{$pago->codigo}}" value="{{$pago->monto}}" placeholder="Monto" readonly>

                <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                @if ($errors->has('monto'))
                <span class="help-block">
                  <strong>{{ $errors->first('monto') }}</strong>
              </span>
              @endif

          </div>
      </div>
      
  </div>
  <div class="col-sm-6">
     <div class="form-group {{ $errors->has('proveedor') ? ' has-error' : '' }}">
        <label class="col-sm-4 control-label">Proveedor</label>
        <div class="col-sm-8">
            <input type="text" name="proveedor" value="{{$pago->proveedor_id}}" required class="form-control" readonly>
        </input>
        @if ($errors->has('proveedor'))
        <span class="help-block">
          <strong>{{ $errors->first('proveedor') }}</strong>
      </span>
      @endif
  </div>
</div>
<div class="form-group  {{ $errors->has('codigo') ? ' has-error' : '' }} has-feedback">
    <label class="col-sm-4 control-label">Codigo</label>
    <div class="col-sm-8">
       <input type="text" class="form-control" name="codigo" id="codigo" value="{{$pago->codigo}}" placeholder="Codigo" readonly>

       <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

       @if ($errors->has('codigo'))
       <span class="help-block">
          <strong>{{ $errors->first('codigo') }}</strong>
      </span>
      @endif

  </div>
</div>

<div class="form-group {{ $errors->has('dias') ? ' has-error' : '' }} has-feedback">
    <label class="col-sm-4 control-label">Dias a Pagar</label>
    <div class="col-sm-8">
        <input type="number" class="form-control" name="dias{{$pago->codigo}}" id="dias{{$pago->codigo}}" value="{{$pago->dias}}" placeholder="Dias para Pagar" readonly>

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
    <div class="form-group {{ $errors->has('tipop') ? ' has-error' : '' }}">
        <label class="col-sm-4 control-label">Tipo de Pago</label>
        <div class="col-sm-6">
           <select name="tipop" id="tipop" class="form-control {{$pago->codigo}}" required >
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
</div><hr>
</div>
<div class="col-sm-6">
    <div class="form-group {{ $errors->has('bancoe') ? ' has-error' : '' }}" id="disable1{{$pago->codigo}}">
        <label class="col-sm-4 control-label">Banco Emisor</label>
        <div class="col-sm-8">
           <select name="bancoe{{$pago->codigo}}" id="bancoe{{$pago->codigo}}"  required class="form-control" disabled>
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

<div class="form-group {{ $errors->has('noperacion') ? ' has-error' : '' }} has-feedback" id="disable3{{$pago->codigo}}">
    <label class="col-sm-4 control-label">Nro de Operacion</label>
    <div class="col-sm-8">
     <input type="text" class="form-control" name="noperacion{{$pago->codigo}}" id="noperacion{{$pago->codigo}}" id="Nro peración" value="" placeholder="noperacion" disabled>

     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

     @if ($errors->has('noperacion'))
     <span class="help-block">
      <strong>{{ $errors->first('noperacion') }}</strong>
  </span>
  @endif

</div>
</div>
<div class="form-group {{ $errors->has('abono') ? ' has-error' : '' }} has-feedback">
    <label class="col-sm-4 control-label">Abono</label>
    <div class="col-sm-8">
      <input type="number" class="form-control" name="montom{{$pago->codigo}}" id="montom{{$pago->codigo}}" value="" placeholder="abono" >
      <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>
      @if ($errors->has('abono'))
      <span class="help-block">
          <strong>{{ $errors->first('abono') }}</strong>
      </span>
      @endif
  </div>
</div>
</div>
<div class="col-sm-6">
    <div class="form-group {{ $errors->has('bancor') ? ' has-error' : '' }}" id="disable2{{$pago->codigo}}">
        <label class="col-sm-4 control-label">Banco Receptor</label>
        <div class="col-sm-8">
          <select name="bancor{{$pago->codigo}}" id="bancor{{$pago->codigo}}"  required class="form-control" disabled>
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
<div class="form-group {{ $errors->has('tabono') ? ' has-error' : '' }} has-feedback">
    <label class="col-sm-4 control-label">Total Abono</label>
    <div class="col-sm-8">
      <input type="number" class="form-control" name="mtotal{{$pago->codigo}}" id="mtotal{{$pago->codigo}}" value="0" placeholder="tabono" readonly>
      <input type="hidden" class="form-control" name="tabonosum" id="tabonosum" value="0" placeholder="abono" >

      <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

      @if ($errors->has('tabono'))
      <span class="help-block">
          <strong>{{ $errors->first('tabono') }}</strong>
      </span>
      @endif
  </div>
</div>
<div class="form-group {{ $errors->has('resta') ? ' has-error' : '' }} has-feedback">
    <label class="col-sm-4 control-label">Resta</label>
    <div class="col-sm-8">
        <input type="number" step="any" class="form-control" name="mresta{{$pago->codigo}}" id="mresta{{$pago->codigo}}" value="0" placeholder="resta" readonly>
        <input type="hidden" name="restaenv" id="restaenv" value="" >
        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

        @if ($errors->has('resta'))
        <span class="help-block">
          <strong>{{ $errors->first('resta') }}</strong>
      </span>
      @endif
  </div>
</div>
</div><hr>
<div class="text-center" >

    <button id="debitar" value="{{$pago->codigo}}"  name="debitar"  class="btn label-success ">
    Debitar </button>

</div><br>



</div>
<table class="table table-responsive table-bordered table-condensed mdata" id="mdata{{$pago->codigo}}" name="mdata{{$pago->codigo}}">
    <thead>
        <tr>
            <th class="text-center">Abono</th>
            <th >Tipo de pago</th>
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
<div class="modal-footer">
    <div class="form-actions">

        <button type="button" class="btn cerrar btn-warning" value="{{$pago->codigo}}" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="registrar" name="registrar" class="btn btn-success pull-right registrar">

            Registrar <i class="fa fa-arrow-circle-right"></i>
        </button>


    </div>
</div>
</form>
</div>
</div>
@endforeach
</div>
@endsection

