<script type="text/javascript">

    $("#buscar").click(function(e) {
        e.preventDefault();
        var APP_URL = {!!json_encode(url('/'))!!};
        buscarusuario(APP_URL);
    });


    $(".boton-dato").click(function(e){
        e.preventDefault();
        $("#col").addClass("collapsed-box");
        $("#col2").removeClass("fa-minus");
        $("#col2").addClass("fa-plus");
        var valor = $(this).val().split('Ç');
        $("#userid").val(valor[0]);
        $("#nombre").val(valor[1]);
        var comision = $("#valoreninput").val();
        var v = "";
        alert("Usted selecciono el cliente Nº "+valor);
        $("#userid").val(valor[0]);
        $("#username").val(valor[1]);
        $("#tikets").val(v);
        $("#neto").val(v);
        $("#tarifa").val(v);
        $("#comi").val(0);
        $("#igv").val(0);
        $("#total").val(v);
        $("#conso").val(v);
        $("#tarifaf").val(v);
        $("#utilidad").val(v);
        $("#incentivo").val(0);
    });
    $(document).ready(function(){
        $(".boton-dato").click(function(){
            $(".mod").fadeIn(600);
        });
        $(".cerrar").click(function(e){
            e.preventDefault();
            $(".mod").fadeOut(600);
        });
    });
         $(document).ready(function(){
            $(".abrirpasajero").click(function(e){
                e.preventDefault();
                 $("select#empresa1").val(0);
                 $("#nombre1").val();
                 $("#apellido1").val();
                 $("#cedula_rif1").val();
                 $("#direccion1").val();
                 $("#telefono1").val();
                 $("#email1").val();

                $(".modapasajero").fadeIn();
            });
            $(".cerrarpasajero").click(function(){

                $(".modapasajero").fadeOut(300);
            });
        });
    </script>
<div class="clearfix"></div>
    <div class="box-header">
        <h4 class="box-title">Buscar Pasajeros</h4>
        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                              <div style="padding-right: 0" class="col-md-8">
                                  <input type="hidden" class="form-control" value='{!!json_encode(url('/'))!!}' id="ruta" name="ruta">
                                <input type="text" class="form-control" id="dato_buscado">         
                              </div>
                              <div style="padding-left: 0" class="col-md-2">
                                <button class="btn btn-info btn-flat" type="button" id="buscar" name="buscar"  >Buscar!</button>
                              </div>
                              <div class="col-md-2">
                            <button id=""  name=""  class="btn btn-warning pull-right abrirpasajero">
                                                                                Nuevo pasajero </button>
                              </div>
                            </span>
        </div>

    </div>
    <div class="box-body">
        <?php
        if( count($clientes) >0){
        ?>
        <table class="display table table-hover table-responsive" id="tabla_pacientes">
            <thead>
            <tr>
                <th class="col-md-2">Empresa</th>
                <th class="col-md-2">DNI/RUC</th>
                <th class="col-md-2">Nombre</th>
                <th class="col-md-2">Apellido</th>
                <th class="col-md-2">Tipo</th>
                <th class="col-md-2">Acciones</th>
            </tr>
            </thead>

            <tbody>

            @foreach ($clientes as $cliente)
            <tr role="row" class="odd">
                <td>@if(!empty($cliente->empresas->nombre))
                        {{$cliente->empresas->nombre}}
                    @else
                        Esta Empresa Ya no Existe
                    @endif</td>
                <td>{{$cliente->cedula_rif}}</td>
                <td>{{$cliente->nombre}}</td>
                <td>{{$cliente->apellido}}</td>
                <td>{{$cliente->tipo_pasajero}}</td>
                <td>
                    <button class="label boton-dato label-primary" id="boton-dato" name="boton-dato"
                            value="{{$cliente->cedula_rif}}Ç{{$cliente->nombre}} {{$cliente->apellido}}">Procesar ticket
                    </button>
                </td>
            </tr>
            @endforeach
            </tbody>

        </table>
<?php
echo str_replace('/?', '?', $clientes->render());
}else{
?>
            <br/><div class='rechazado'><label style='color:#FA206A'>...No se ha encontrado ningun usuario...</label>  </div>

            <?php
        }

        ?>
        </div>
