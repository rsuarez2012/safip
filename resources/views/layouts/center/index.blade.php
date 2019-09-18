@extends('layouts.master')

@section('titulo', 'Pagina de Bienvenida')

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('js/fullcalendar/fullcalendar.css')}}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('js/fullcalendar/fullcalendar.print.css')}}" media="print"> --}}
    {{-- <link rel="stylesheet" href="{{asset('js/fullcalendar/lib/cupertino/jquery-ui.min.css')}}"> --}}
@endsection

@section('script')

    <script src={!! asset("js/jquery.min.js")!!}></script>
    <script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
    <script src={!! asset("js/highcharts.js")!!}></script>
    <script src={!! asset("js/graficas.js")!!}></script>

@section ('content')

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
    <!-- contenido principal -->
    <?php  $nombremes=array("","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"); ?>

    <div  class="row" >
        <div class="col-md-3">
            <label>Año</label>
            <select class="form-control" id="anio_sel"  onchange="cambiar_fecha_grafica();">
                <option value={{$anio}}>{{$anio}}</option>
                @foreach($anios as $ani)
                    <option value={{$ani->anio}}>{{$ani->anio}}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-3">
            <label>Mes</label>
            <select class="form-control" id="mes_sel" onchange="cambiar_fecha_grafica();" >
                <?php  echo '<option value="'.$mes.'" >'.$nombremes[intval($mes)].'</option>';   ?>
                <option value="1">ENERO</option>
                <option value="2">FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>
        </div>
    </div>

    <div  class="row" >
        <br/>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header">
                </div>

                <div class="box-body" id="div_grafica_barras">
                </div>

                <div class="box-footer">
                </div>
            </div>
        </div>


        <!-- <div class="box box-primary">
             <div class="box-header">
             </div>

             <div class="box-body" id="div_grafica_lineas">
             </div>

             <div class="box-footer">
             </div>
         </div>-->
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header">
                    <center>
                        <b>Tasa de cambio</b>
                        
                    </center>
                </div>
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Dolar $</th>
                                <th style="text-align: center;">Sol</th>
                                <th style="text-align: center;">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;">1</td>
                                <td style="text-align: center;">3,10</td>
                                <td style="text-align: center;">
                                    <button class="btn btn-success btn-sm" id="tasa">actualizar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" placeholder="Cantidad en dolares" name="cantidad" id="monto" value=" ">
                                </td>
                                <td>
                                    <input type="text" name="tasa" class="form-control" placeholder="Tasa del Dia" disabled="" id="tasaD" value="3,10">
                                </td>
                                <td>
                                    <input type="text" name="resultado" placeholder="Resultado" class="form-control" id="resultado">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header">
                </div>

                <div class="box-body" id="div_grafica_pie">
                </div>

                <div class="box-footer">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <div class="box-body" id="div_grafica_ganancias_perdidas">
                </div>
                <div class="box-footer">
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div id="calendar"></div>
        </div>
    </div>

<div id="add-tasa" class="modal" style="overflow: auto; ">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 500px; margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-list"></i> Actualizar Tasa
                </h4>
                <!--onclick="main_de_hoteles.cerrarModal()"-->
                <button  type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div> 

            <div class="modal-body">
                <form action="{{-- url('/tablero/Hoteles/Admin/Categorias/Store') --}}" method="POST">
                    {!! csrf_field() !!}
                    <label>Tasa del Día</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                    
            </div>
            <div class="modal-footer">
                <!--onclick="main_de_hoteles.cerrarModal()"-->
                <button  type="button" class="btn btn-secondary pull-left" id="cc">
                    <i class="fa fa-close"></i> Cerrar
                </button>

                <button type="submit" id="ac" class="btn btn-danger pull-right">
                    <i class="fa fa-save"></i> Agregar
                </button>   
            </div>
                </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#tasa').on('click', function(){
            $("#add-tasa").fadeIn(300);
        }) 
        $('#resultado').on('click', function(){
            var can = $("#monto").val();
            var tasa = 3.10;
            resul = can * tasa;
            $("#resultado").val(resul);

            //alert("el resultado es: " + resultado);
        })   
        $('button[id=cc]').on('click', function() {
            $("#add-tasa").fadeOut(300);
            
        
        });
    });
</script>




    <script>
        var APP_URL = {!!json_encode(url('/'))!!};
        cargar_grafica_barras({{$anio}},{{intval($mes)}});
        cargar_grafica_lineas({{$anio}},{{intval($mes)}});
        cargar_grafica_pie();
        preload_data_grafica_ganancias();
    </script>





@endsection
