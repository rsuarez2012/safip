<script type="text/javascript">

    $("#buscar").click(function(e) {
        e.preventDefault();
        var APP_URL = {!!json_encode(url('/'))!!};
        buscarusuario(APP_URL);
    });

    $(".boton-dato").click(function(e){
        e.preventDefault();
        var valor = $(this).val().split('Ç');
        var rif = valor[0];
        var nombre = valor[1];
        var correo = valor[2];

        alert ("Se va a adicionar un usuario para envio de correo "+correo);
        var array = [rif,nombre,correo];
        e.preventDefault();
        var i=0;
        $.each(document.querySelectorAll("#data tbody"), function(index, val) {
            if(i< array.length)
                $(val).append("<tr>" +
                    "<td><input class='form-control' type='text' name='rif[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                    "<td><input class='form-control' type='text' name='nombre[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                    "<td><input class='form-control' type='text' name='correo[]' value="+"'"+ array[i++]+"'"+"readonly></td>"+
                    "<td><button type='button' class='btn btn-danger button_eliminar_producto'> Eliminar </button></td></tr>");
        });
    });
    $('#data').on('click', '.button_eliminar_producto', function(){
        $(this).parents('tr').eq(0).remove();
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
    <h4 class="box-title">Buscar Agencia de Viajes</h4>
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

                              </div>
                            </span>
    </div>
</div>
<div class="box-body">
    <?php
    if( count($aviajes) >0){
    ?>
    <table class="display table table-hover table-responsive" id="tabla_pacientes">
        <thead>
        <tr>
            <th class="col-md-2">Empresa</th>
            <th class="col-md-2">Email</th>
            <th class="col-md-2">RIF</th>
            <th class="col-md-2">Nombre</th>
            <th class="col-md-2">Acciones</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($aviajes as $aviaje)
            <tr role="row" class="odd">
                <td>@if(!empty($aviaje->empresas->nombre))
                        {{$aviaje->empresas->nombre}}
                    @else
                        Esta Empresa Ya no Existe
                    @endif</td>
                <td>{{$aviaje->email}}</td>
                <td>{{$aviaje->rif}}</td>
                <td>{{$aviaje->nombre}}</td>
                <td>
                    <button class="label boton-dato label-primary" id="boton-dato" name="boton-dato"
                            value="{{$aviaje->rif}}Ç{{$aviaje->nombre}}Ç{{$aviaje->email}}">Capturar Email
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
    <?php
    echo str_replace('/?', '?', $aviajes->render());
    }else{
    ?>
    <br/><div class='rechazado'><label style='color:#FA206A'>...No se ha encontrado ningun usuario...</label>  </div>

    <?php
    }

    ?>
</div>
