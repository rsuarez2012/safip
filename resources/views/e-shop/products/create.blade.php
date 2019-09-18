@extends('layouts.master')
@section('titulo','Nuevo Paquetes')
@section('script')


<script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
<!-- javascript del sistema laravel -->
<script src="{!! asset('js/sistemalaravel.js') !!}"></script>
<link href="{{asset('web/templates/kreatico/css/estilo.css')}}" rel="stylesheet" type="text/css" media="screen,projection" />
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
<script type="text/javascript">
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

$(document).ready(function(){
    $("select[name=category_id]").change(function(){
        if($(this).val()=="salidas_confirmadas"){
            $(".fechas_confirmadas").removeClass("hidden");
        }else{
            $(".fechas_confirmadas").addClass("hidden");
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
                <div class="col-md-12">
                    <div class="x_title">
                        <h2><i class="fa fa-briefcase"></i> Paquetes</h2>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <hr style="border-top: 1px solid #d1d1d1;">
            <div class="container text-center">
                    <!--<div class="page-header">
                        <h1>
                            <i class="fa fa-shopping-cart"></i>
                            <h2>PAQUETES DE VIAJE</h2> <small>[Agregar Paquete]</small>
                        </h1>
                    </div>-->
                    <div class="row">
                        <!--col-md-offset-3-->
                        <div class=" col-md-12">
                            <div class="page">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('manageProduct-store-A') }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <h4 class="box-title h4paq">Información de del paquete</h4>
                                    <div class="col-md-6">
                                        <label for="name">Nombre:</label>
                                        <input type="text" name="name" value="" class="form-control" placeholder="Ingresa el nombre..." required >
                                        <br>
                                        <div style="padding-left: 0;" class="col-md-6">
                                            <label for="price_sol">Precio en Soles:</label>
                                            <input type="number" step="any" name="price_sol" value="" class="form-control" placeholder="Ingresa el precio..." required >
                                        </div>
                                        <div style="padding-right: 0;" class="col-md-6">
                                            <label for="price_dolar">Precio en Dolares:</label>
                                            <input type="number" step="any" name="price_dolar" value="" class="form-control" placeholder="Ingresa el precio..." required >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="destination_id">Destino</label>
                                        <select name="destination_id" class="form-control"  required >
                                            <option value="">Selecciona el Destino</option>
                                            @foreach($destination as $destiny)
                                            <option value="{{$destiny->destination_name}}">{{$destiny->destination_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="description">Descripcion:</label>
                                        <textarea style="min-height: 61px;" type="text" name="descriptionv2" value="" class="form-control" placeholder="Descripcion..." required ></textarea>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <h4 class="box-title h4paq">Datos de la miniatura publicada</h4>
                                    <div class="col-md-6">
                                        <label for="extract">Pequeña Descipción:</label>
                                        <input type="text" name="extract" value="" class="form-control" placeholder="Pequeña Descripcion..." required >
                                        <label for="type_service_id">Tipo de Servicio</label>
                                        <select name="type_service_id" value="" class="form-control"  required >
                                            <option value="">Selecciona el tipo de servicio</option>
                                            @foreach($type_service as $type)
                                            <option value="{{$type->name}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="fechas_confirmadas hidden">
                                            <label for="fecha_sale">Fecha Salida</label>
                                            <input type="date" name="fecha_sale" class="form-control" >
                                        </div>
                                        <div class="fechas_confirmadas hidden">
                                         <label for="cupos">Cupos</label>
                                         <input type="number" min="1" name="cupos" class="form-control">
                                     </div>
                                    </div>
                                    <div class="col-md-6">
                                     <label for="name">Categoría: </label>
                                     <select name="category_id" id="category_id"  class="form-control" required>
                                         <option value="">Selecciona una Categoria</option>
                                         <option value="norte">Paquete / nacional / NORTE</option>
                                         <option value="sur">paquete / nacional / SUR</option>
                                         <option value="centro">Paquete / nacional / CENTRO</option>
                                         <option value="internacional">Paquete Internacional</option>
                                         <option value="luna_miel">Luna de Miel</option>
                                         <option value="full_day">Full Day</option>
                                         <option value="salidas_confirmadas">Salidas Confirmadas</option>
                                         <option value="alojamiento">Alojamiento</option>
                                         <option value="traslados">Traslados</option>
                                         <option value="vuelos">Vuelos</option>
                                         <option value="promociones">Promociones</option>
                                         <option value="seguros">Seguros</option>
                                         <option value="autos">Autos</option>
                                         <option value="promociones">Promociones</option>
                                     </select>

                                     <label for="image">Imagen:</label>
                                     <input type="file" name="image" class="form-control" required >
                                     <div class="fechas_confirmadas hidden">
                                         <label for="fecha_llega">Fecha Llegada</label>
                                         <input type="date" name="fecha_llega" class="form-control">
                                     </div>
                                 </div>
                                 <div class="clearfix"></div>

                                 <br>
                                 <div class="col-md-5"></div>
                                 <div class="col-md-2">
                                    <!-------dias de duracion----->
                                        <label for="description">Días de Duración:</label>
                                        <input type="number" name="duration" id="duration" value="0" class="form-control" placeholder="Catidad de dias..." readonly required >
                                        <a class="btn btn-success btn-danger addday" href="">Agregar dia</a>
                                    </div>
                                    <div class="col-md-5"></div>
                                    <div class="clearfix"></div>
                                    <!--------------------------------------------->

                                    <div>
                                        <hr>
                                        <h4 class="box-title h4paq">Información de Atividades</h4>
                                        <table class="table table-responsive table-bordered table-condensed" id="data" name="data">
                                            <thead>
                                            <tr>
                                                <th class="col-md-2">Dia</th>
                                                <th class="col-md-2">Description</th>
                                                <th class="col-md-2">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------dias de duracion----->
                                    <hr>
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
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------inlcuido----->
                                     <div class="checkbox">
                                            <label for="visible"> <input title="Visible" type="checkbox" name="visible" value="1" >Visible</label>
                                        </div>
                                        <div class="checkbox">
                                            <label for="outstanding"><input title="Destacado" type="checkbox" name="outstanding" value="1">Destacado</label>
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
@endsection