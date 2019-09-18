@extends('layouts.master')
@section('titulo', 'Crear Cotizacion')
@section('script')


    <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
    <script type="text/javascript">
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

        $(document).ready(function() {
            $(".addday").click(function(e){
                e.preventDefault();
                var dias= $("#duration").val();
                var unidad =1;
                var suma = (parseInt(dias)+parseInt(unidad));
                $.each(document.querySelectorAll("#data tbody"), function (index, val) {
                    $(val).append("<tr>" +
                        "<td><input class='form-control' type='text' name='dia[]' value='Dia:"+suma+"' ></td>" +
                        "<td><textarea class='form-control' type='text' name='description[]' value=''></textarea></td>"+
                        "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
                });
                $("#duration").val(suma);

            });

            $('#data').on('click', '.button_eliminar_producto', function(){
                var dias = $("#duration").val();
                var resta = eval(dias - 1);
                if (resta < 0){
                    $("#duration").val(0);
                }else{
                    $("#duration").val(resta);
                }
                $(this).parents('tr').eq(0).remove();
            });
            /*------------------------------------*/

            $(".addincludes").click(function(e){
                e.preventDefault();
                $.each(document.querySelectorAll("#tincludes tbody"), function (index, val) {
                    $(val).append("<tr>" +
                        "<td><textarea class='form-control' type='text' name='dincludes[]' value=''></textarea></td>"+
                        "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
                });

            });
            $('#tincludes').on('click', '.button_eliminar_producto', function(){
                $(this).parents('tr').eq(0).remove();
            });
            /*------------------------------------*/
            $(".addnot_includes").click(function(e){
                e.preventDefault();

                $.each(document.querySelectorAll("#tnot_includes tbody"), function (index, val) {
                    $(val).append("<tr>" +
                        "<td><textarea class='form-control' type='text' name='dnot_includes[]' value=''></textarea></td>"+
                        "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
                });


            });

            $('#tnot_includes').on('click', '.button_eliminar_producto', function(){
                $(this).parents('tr').eq(0).remove();
            });
            /*------------------------------------*/
            $(".addrecommendations_to_carry").click(function(e){
                e.preventDefault();

                $.each(document.querySelectorAll("#trecommendations_to_carry tbody"), function (index, val) {
                    $(val).append("<tr>" +

                        "<td><textarea class='form-control' type='text' name='drecommendations_to_carry[]' value=''></textarea></td>"+
                        "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
                });

            });

            $('#trecommendations_to_carry').on('click', '.button_eliminar_producto', function(){

                $(this).parents('tr').eq(0).remove();
            });
            /*------------------------------------*/
            $(".addimportant_note").click(function(e){
                e.preventDefault();

                $.each(document.querySelectorAll("#timportant_note tbody"), function (index, val) {
                    $(val).append("<tr>" +
                        "<td><textarea class='form-control' type='text' name='dimportant_note[]' value=''></textarea></td>"+
                        "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
                });


            });

            $('#timportant_note').on('click', '.button_eliminar_producto', function(){

                $(this).parents('tr').eq(0).remove();
            });
            /*------------------------------------*/
            $(".addreservation_polices").click(function(e){
                e.preventDefault();

                $.each(document.querySelectorAll("#treservation_polices tbody"), function (index, val) {
                    $(val).append("<tr>" +

                        "<td><textarea class='form-control' type='text' name='dreservation_polices[]' value=''></textarea></td>"+
                        "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
                });


            });

            $('#treservation_polices').on('click', '.button_eliminar_producto', function(){

                $(this).parents('tr').eq(0).remove();
            });
            /*------------------------------------*/
            $(".addpolices_of_our_rates").click(function(e){
                e.preventDefault();
                var dias= $("#duration").val();
                var unidad =1;
                var suma = (parseInt(dias)+parseInt(unidad));
                $.each(document.querySelectorAll("#tpolices_of_our_rates tbody"), function (index, val) {
                    $(val).append("<tr>" +
                        "<td><textarea class='form-control' type='text' name='dpolices_of_our_rates[]' value=''></textarea></td>"+
                        "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
                });

            });

            $('#tpolices_of_our_rates').on('click', '.button_eliminar_producto', function(){

                $(this).parents('tr').eq(0).remove();

            });
            /*------------------------------------*/
            $(".addspecial_dates").click(function(e){
                e.preventDefault();

                $.each(document.querySelectorAll("#tspecial_dates tbody"), function (index, val) {
                    $(val).append("<tr>" +

                        "<td><textarea class='form-control' type='text' name='dspecial_dates[]' value=''></textarea></td>"+
                        "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
                });


            });

            $('#tspecial_dates').on('click', '.button_eliminar_producto', function(){

                $(this).parents('tr').eq(0).remove();
            });
            /*------------------------------------*/
            $(".addresponsabilities").click(function(e){
                e.preventDefault();

                $.each(document.querySelectorAll("#tresponsabilities tbody"), function (index, val) {
                    $(val).append("<tr>" +

                        "<td><textarea class='form-control' type='text' name='dresponsabilities[]' value=''></textarea></td>"+
                        "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
                });


            });

            $('#tresponsabilities').on('click', '.button_eliminar_producto', function(){

                $(this).parents('tr').eq(0).remove();
            });
            /*------------------------------------*/

            /*------------------------------------*/
            $(".addtarifa").click(function(e){
                e.preventDefault();

                $.each(document.querySelectorAll("#trtarifas tbody"), function (index, val) {
                    $(val).append("<tr>" +

                        "<td><input class='form-control' type='radio' name='radius[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='hotel[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='stars[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='category[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='swbe[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='dwbe[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='tple[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='chde[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='swbp[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='dwbp[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='tplp[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='chdp[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='in[]' value=''></td>"+
                        "<td><input class='form-control' type='text' name='out[]' value=''></td>"+

                        "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
                });


            });

            $('#trtarifas').on('click', '.button_eliminar_producto', function(){

                $(this).parents('tr').eq(0).remove();
            });
            /*------------------------------------*/
        });
    </script>


@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box padding_box1">
                <div class="row">
                    <div class="col-md-10">
                        <div class="x_title">
                            <h2><i class="fa fa-building"></i>Editar Paquetes de Viaje</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="container text-center">
                    <div class="page-header">

                    </div>
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <div class="page">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('manageProduct-update-A' ,$product->id) }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label for="name">Nombre:</label>
                                        <input type="text" name="name" value="{{$product->name}}" class="form-control" placeholder="Ingresa el nombre...">
                                    </div>
                                    <div class="form-group">
                                        <label for="price_sol">Precio en Soles:</label>
                                        <input type="number" step="any" name="price_sol" value="{{$product->price_sol}}" class="form-control" placeholder="Ingresa el precio...">
                                    </div>
                                    <div class="form-group">
                                        <label for="price_dolar">Precio en Dolares:</label>
                                        <input type="number" step="any" name="price_dolar" value="{{$product->price_dolar}}" class="form-control" placeholder="Ingresa el precio...">
                                    </div>

                                    <div class="form-group">
                                        <label for="destination_id">Destino</label>
                                        <select name="destination_id" class="form-control" >
                                            <option value="{{$product->destination_id}}">{{$product->destination_id}}</option>
                                            <option value="">Selecciona el Destino</option>
                                            @foreach($destination as $destiny)
                                                <option value="{{$destiny->id}}">{{$destiny->destination_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Descripcion:</label>
                                        <textarea type="text" name="descriptionv2"  class="form-control" placeholder="Descripcion...">{{$product->description}}</textarea>
                                    </div>
                                    <div class="col-md-5"></div>
                                    <div class="col-md-2">
                                        <!-------dias de duracion----->
                                        <label for="description">Días de Duración:</label>
                                        <input type="number" name="duration" id="duration" value="{{$product->duration}}" class="form-control" placeholder="Catidad de dias..." readonly required >
                                        <a class="btn btn-success btn-danger addday" href="">Agregar dia</a>
                                    </div>
                                    <div class="col-md-5"></div>
                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->

                                    <div>
                                        <hr>
                                        <h4 class="box-title">Información de Atividades</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="data" name="data">
                                            <thead>
                                            <tr>
                                                <th class="col-md-2">Dia</th>
                                                <th class="col-md-2">Description</th>
                                                <th class="col-md-2">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($itinerary as $iti)
                                            <tr>
                                                <td><input class='form-control' type="text" value="{{$iti->day}}" name="dia[]"></td>
                                                <td><textarea class='form-control' name="description[]" id="">{{$iti->description}}</textarea></td>
                                                <td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td>
                                            </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--------------------------------------------->
                                    <!-------incluido----->
                                    <div class="form-group">

                                        <a class="btn btn-success btn-danger addincludes" href="">Agregar Item</a>
                                    </div>

                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->

                                    <div>
                                        <hr>
                                        <h4 class="box-title h4paq">Información de Incluidos</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="tincludes" name="includes">
                                            <thead>
                                            <tr>
                                                <th class="col-md-2">Incluye</th>
                                                <th class="col-md-2">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Recommendations_to_carry as $Recommendations)
                                                <tr>
                                                    <td><textarea class='form-control' type='text' name='drecommendations_to_carry[]' value=''>{{$Recommendations->description}}</textarea></td>
                                                    <td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------inlcuido----->
                                    <hr>
                                    <!-------no incluido----->
                                    <div class="form-group">

                                        <a class="btn btn-success btn-danger addnot_includes" href="">Agregar Item</a>
                                    </div>

                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->

                                    <div>
                                        <hr>
                                        <h4 class="box-title h4paq">Información NO Incluidos</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="tnot_includes" name="tnot_includes">
                                            <thead>
                                            <tr>
                                                <th class="col-md-2">No Incluye</th>
                                                <th class="col-md-2">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Recommendations_to_carry as $Recommendations)
                                                <tr>
                                                    <td><textarea class='form-control' type='text' name='drecommendations_to_carry[]' value=''>{{$Recommendations->description}}</textarea></td>
                                                    <td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------no inlcuido----->
                                    <hr>
                                    <!-------Recomendaciones a llevar----->
                                    <div class="form-group">


                                        <a class="btn btn-success btn-danger addrecommendations_to_carry" href="">Agregar Item</a>
                                    </div>

                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->

                                    <div>
                                        <hr>
                                        <h4 class="box-title h4paq">Recomendaciones a Llevar</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="trecommendations_to_carry" name="trecommendations_to_carry">
                                            <thead>
                                            <tr>
                                                <th class="col-md-2">Recomendacion</th>
                                                <th class="col-md-2">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Recommendations_to_carry as $Recommendations)
                                            <tr>
                                                <td><textarea class='form-control' type='text' name='drecommendations_to_carry[]' value=''>{{$Recommendations->description}}</textarea></td>
                                                <td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td>
                                            </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!------Recomendaciones a llevar----->
                                    <hr>
                                    <!-------nota importante----->
                                    <div class="form-group">


                                        <a class="btn btn-success btn-danger addimportant_note" href="">Agregar Item</a>
                                    </div>

                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->
                                    <div>
                                        <hr>
                                        <h4 class="box-title h4paq">Nota Importante</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="timportant_note" name="timportant_note">
                                            <thead>
                                            <tr>
                                                <th class="col-md-2">Incluye</th>
                                                <th class="col-md-2">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Important_note as $Important)
                                                <tr>
                                                    <td><textarea class='form-control' type='text' name='dimportant_note[]' value=''>{{$Important->description}}</textarea></td>
                                                    <td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------nota importante----->
                                    <hr>
                                    <!-------reservation_polices----->
                                    <div class="form-group">

                                        <a class="btn btn-success btn-danger addreservation_polices" href="">Agregar Item</a>
                                    </div>

                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->

                                    <div>
                                        <hr>
                                        <h4 class="box-title h4paq">Politicas de Reserva</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="treservation_polices" name="treservation_polices">
                                            <thead>
                                            <tr>
                                                <th class="col-md-2">Incluye</th>
                                                <th class="col-md-2">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Reservation_polices as $Reservation)
                                                <tr>
                                                    <td><textarea class='form-control' type='text' name='dreservation_polices[]' value=''>{{$Reservation->description}}</textarea></td>
                                                    <td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------reservation_polices----->
                                    <hr>
                                    <!-------nuestras tarifas----->
                                    <div class="form-group">


                                        <a class="btn btn-success btn-danger addpolices_of_our_rates" href="">Agregar Item</a>
                                    </div>

                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->

                                    <div>
                                        <hr>
                                        <h4 class="box-title h4paq">Politicas de Nuestras Tafirfas</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="tpolices_of_our_rates" name="tpolices_of_our_rates">
                                            <thead>
                                            <tr>
                                                <th class="col-md-2">Politica</th>
                                                <th class="col-md-2">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Polices_of_our_rates as $Police)
                                                <tr>
                                                    <td><textarea class='form-control' type='text' name='dpolices_of_our_rates[]' value=''>{{$Polices->description}}</textarea></td>
                                                    <td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------nuestras tarifas----->
                                    <hr>
                                    <!-------fechas especiales----->
                                    <div class="form-group">


                                        <a class="btn btn-success btn-danger addspecial_dates" href="">Agregar Item</a>
                                    </div>

                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->

                                    <div>
                                        <hr>
                                        <h4 class="box-title h4paq">Fechas Especiales</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="tspecial_dates" name="tspecial_dates">
                                            <thead>
                                            <tr>
                                                <th class="col-md-2">F- Especiales</th>
                                                <th class="col-md-2">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Special_dates as $Special)
                                                <tr>
                                                    <td><textarea class='form-control' type='text' name='dspecial_dates[]' value=''>{{$Special->description}}</textarea></td>
                                                    <td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------fechas especiales----->
                                    <hr>
                                    <!-------responsabilidades----->
                                    <div class="form-group">


                                        <a class="btn btn-success btn-danger addresponsabilities" href="">Agregar Item</a>
                                    </div>

                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->
                                    <div>
                                        <hr>
                                        <h4 class="box-title h4paq">Responsabilidades</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="tresponsabilities" name="tresponsabilities">
                                            <thead>
                                            <tr>
                                                <th class="col-md-2">Responsabilidades</th>
                                                <th class="col-md-2">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Resposanbilities as $Respo)
                                                <tr>
                                                    <td><textarea class='form-control' type='text' name='dresponsabilities[]' value=''>{{$Respo->description}}</textarea></td>
                                                    <td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------responsabilidades----->
                                    <div class="form-group">


                                        <a class="btn btn-success btn-danger addtarifa" href="">Agregar Tarifa</a>
                                    </div>

                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->
                                    <div>
                                        <hr>
                                        <h4 class="box-title h4paq">TARIFAS POR PERSONA EN US$</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="trtarifas" name="trtarifas">
                                            <thead>
                                            <tr>
                                                <th colspan="4"></th>
                                                <th colspan="4" class="text-center prod-col-nacional">EXTRANJERO</th>
                                                <th colspan="4" class="text-center prod-col-extranjero">PERUANO</th>
                                                <th colspan="1" class="text-center prod-col-extranjero td-prod-nacional">CHECK</th>
                                                <th colspan="1" class="text-center prod-col-extranjero td-prod-nacional">CHECK</th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #c90e14"></th>
                                                <th style="background-color: #c90e14; color: #fff">HOTEL EN CUSCO</th>
                                                <th style="background-color: #c90e14; color: #fff;text-align: center;">*</th>
                                                <th style="background-color: #c90e14; color: #fff">CATEGORIA</th>
                                                <th style="background-color: #c90e14; color: #fff" abbr="" scope="col">SWB</th>
                                                <th style="background-color: #c90e14; color: #fff" abbr="" scope="col">DWB</th>
                                                <th style="background-color: #c90e14; color: #fff" abbr="" scope="col">TPL</th>
                                                <th style="background-color: #c90e14; color: #fff" abbr="" scope="col">CHD</th>
                                                <th style="background-color: #c90e14; color: #fff" abbr="" scope="col">SWB</th>
                                                <th style="background-color: #c90e14; color: #fff"  abbr="" scope="col">DWB</th>
                                                <th style="background-color: #c90e14; color: #fff"  abbr="" scope="col">TPL</th>
                                                <th style="background-color: #c90e14; color: #fff"  abbr="" scope="col">CHD</th>
                                                <th style="background-color: #0a620e; color: #fff;text-align: center;" abbr="" scope="col">IN</th>
                                                <th style="background-color: #0a620e; color: #fff;text-align: center;" abbr="" scope="col">OUT</th>
                                                <th   scope="col">Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($RatesPerson as $Rates)
                                                <tr>
                                                    <td><input class='form-control' type='radio' name='radius[]' value='{{$Rates->radius}}'></td>
                                                    <td><input class='form-control' type='text' name='hotel[]' value='{{$Rates->hotel}}'></td>
                                                    <td><input class='form-control' type='text' name='stars[]' value='{{$Rates->stars}}'></td>
                                                    <td><input class='form-control' type='text' name='category[]' value='{{$Rates->category}}'></td>
                                                    <td><input class='form-control' type='text' name='swbe[]' value='{{$Rates->swbe}}'></td>
                                                    <td><input class='form-control' type='text' name='dwbe[]' value='{{$Rates->dwbe}}'></td>
                                                    <td><input class='form-control' type='text' name='tple[]' value='{{$Rates->tple}}'></td>
                                                    <td><input class='form-control' type='text' name='chde[]' value='{{$Rates->chde}}'></td>
                                                    <td><input class='form-control' type='text' name='swbp[]' value='{{$Rates->swbp}}'></td>
                                                    <td><input class='form-control' type='text' name='dwbp[]' value='{{$Rates->dwbp}}'></td>
                                                    <td><input class='form-control' type='text' name='tplp[]' value='{{$Rates->tplp}}'></td>
                                                    <td><input class='form-control' type='text' name='chdp[]' value='{{$Rates->chdp}}'></td>
                                                    <td><input class='form-control' type='text' name='in[]' value='{{$Rates->in}}'></td>
                                                    <td><input class='form-control' type='text' name='out[]' value='{{$Rates->out}}'></td>

                                                    <td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------inlcuido----->



                                    <div class="form-group">
                                        <label for="extract">Pequeña Desc:</label>
                                        <input type="text" name="extract" value="{{$product->extract}}" class="form-control" placeholder="Pequeña Descripcion...">
                                    </div>
                                    <div class="form-group">
                                        <label for="type_service_id">Tipo de Servicio</label>
                                        <select name="type_service_id" value="" class="form-control" >
                                            <option value="{{$product->type_service_id}}">{{$product->type_service_id}}</option>
                                            <option value="">Selecciona el tipo de servicio</option>
                                            @foreach($type_service as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Categoría: </label>
                                        <select name="category_id" id="category_id"  class="form-control" required>
                                            <option value="{{$product->category_id}}">{{$product->category_id}}</option>
                                            <option value="">Selecciona una Categoria</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            @if($product->visible == 1)
                                                <label for="visible"> <input title="Visible" type="checkbox" checked name="visible" value="1" >Visible</label>
                                            @else
                                                <label for="visible"> <input title="Visible" type="checkbox" name="visible" value="1" >Visible</label>
                                            @endif
                                        </div>
                                        <div class="checkbox">
                                            @if($product->visible == 1)
                                                <label for="outstanding"><input title="Destacado" type="checkbox" checked  name="outstanding" value="1">Destacado</label>
                                            @else
                                                <label for="outstanding"><input title="Destacado" type="checkbox" name="outstanding" value="1">Destacado</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Imagen:</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a href="{{ route('manageProduct-A') }}" class="btn btn-warning">Regresar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop