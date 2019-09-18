@extends('layouts.master') 
@section('titulo', 'Operadores') 
@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset(" admin-lte/dist/css/style_child.css ")}}">
<link rel="stylesheet" href="{{ asset('/css/bootstrap-tagsinput.css') }}">
<style type="text/css">
    .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }
      .bootstrap-tagsinput{
        width: 100%;
        border-radius: 0px;
        border-color: #d2d6de;
      }

</style>
@endsection
 
@section('script')
<script src="{{ asset('/js/bootstrap-tagsinput.js') }}"></script>

<script src={!! asset( "admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset( "admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset( "admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<script src="{!! asset('js/sistemalaravel4.js') !!}"></script>
<script src="//cdn.ckeditor.com/4.9.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor' );

</script>

<script type="text/javascript">
    $(function () {
            var APP_URL = {!!json_encode(url('/'))!!};
            cargarlistado(1,APP_URL);
            $('#empresas').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "lengthMenu": [ 50,100, 200, 500],
                "autoWidth": true
            });
            $(".btncorreo").click(function(e){
                e.preventDefault();
                $(".modalCorreo").fadeIn();
            });
            $(".btncerrar").click(function(e){
                e.preventDefault();
                $(".modalCorreo").fadeOut(300);
            });
            $(".abrirCategoria").click(function(){
                $(".modalCategoria").fadeIn();
            });
            $(".cerrarModal").click(function(){
                $(".modalCategoria").fadeOut(300);
            });
            $("select#tipoenv").change(function(e){
                e.preventDefault();
                var valor = $(this).val();

                // alert($('select[name=tipop]').val());

                if (valor = 1){
                    $('#1').find('input, textarea, button, select').removeAttr("disabled");

                }else{
                    $('#2').find('input, textarea, button, select').prop("disabled",true);

                }
                if (valor = 2) {
                    $('#2').find('input, textarea, button, select').removeAttr("disabled");

                }else{
                    $('#1').find('input, textarea, button, select').prop("disabled",true);

                }
            });
        });

</script>
<script type="text/javascript">
$(document).ready(function() {
    $('#agregarO').on('click', function(){

    });
    $('button[id=ad]').on('click', function(){
        $('#addCategory').fadeIn(300);
    });
    $("#cc").click(function(){
        $("#addCategory").fadeOut(300);
        
    });
    $("select").select2({
        width:'100%'
    });
    $('input[id=tag]').tagsinput({
          tagClass: 'big'
        });
    $('body').on("click", "button[id=editO]", function(e) {
    //$('button[id=editO]').on('click', function(){
        var id = $(this).attr('data-id');
        //console.log(id);
        $.ajax({
            url: '/tablero/operadores/admin/edit/'+id,
            //url : url + id,
            type: 'GET',
            dataType: 'json',
            data: {id:id},
            success:function(data){
                //$('input[id=t]').tagsinput();
                console.log(data);
                //console.log(data.emails[0].nombre);
                var emails = data.emails;

                //$(".modal-body input[id=tags]").tagsinput('emails')

                console.log(emails);
                var empresas = data.empresas;
                var empre = data.operador.empresas_id;
                var tipos = data.tipos;
                var cate  = data.operador.categoria_id;

                var destinos = data.destinos;
                var des = data.operador.destino_id;       
                $('#addEditO').fadeIn(300);
                var listEmp = '<option selected="selected" value="">Seleccione...</option>';
                $.each(empresas, function(elemento, indice){
                    if(empre == indice.id)
                        listEmp += "<option selected value='" + indice.id + "'>" + indice.nombre + "</option>";
                    else
                        listEmp += "<option value='" + indice.id + "'>" + indice.nombre + "</option>";
                });

                var listCat = '<option selected="selected" value="">Seleccione...</option>';
                $.each(tipos, function(elemento, indice){
                    listCat += "<option selected value='" + indice.id + "'>" + indice.nombre + "</option>";
                    
                    if(cate == indice.id)
                        listCat += "<option selected value='" + indice.id + "'>" + indice.nombre + "</option>";
                    else
                        listCat += "<option value='" + indice.id + "'>" + indice.nombre + "</option>";
                });
                var listDes = '<option selected="selected" value="">Seleccione...</option>';
                $.each(destinos, function(elemento, indice){
                    listDes += "<option selected value='" + indice.id + "'>" + indice.nombre + "</option>";
                    
                    if(des == indice.id)
                        listDes += "<option selected value='" + indice.id + "'>" + indice.nombre + "</option>";
                    else
                        listDes += "<option value='" + indice.id + "'>" + indice.nombre + "</option>";
                });
                /*var listEmail = "<input type='text' value='' data-role='tagsinput' class='form-control'>";
                $.each(emails,function(i, v) {
                    console.log(v.emails);
                });*/
                $(".modal-body #empresa").html(listEmp);
                $(".modal-body #categoria").html(listCat);
                $(".modal-body #destino").html(listDes);
                $(".modal-body #nombre").val(data.operador.nombre);
                $(".modal-body #ruc").val(data.operador.rif);
                $(".modal-body #direccion").val(data.operador.direccion);
                $(".modal-body #telefono").val(data.operador.telefono);
                $(".modal-body #web").val(data.operador.web);
                //$(".modal-body #t").val(data.operador.email);
                $(".modal-body #t").val(emails);
                
                
            }
        })
    });
    $("#eO").click(function(){
        $("#addEditO").fadeOut(300);
    });
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
                        <h2><i class="fa fa-building"></i>Operadores</h2>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 24px;">
                    {{--<a href="{{ route('manageOperador-create-A') }}" type="submit" class="btn btn-success" style=" position: relative; z-index: 1;"
                        data-toggle="tooltip" data-placement="top" title="Nuevo Operador">
                            <i class="fa fa-plus"></i> operador
                    </a>--}}
                    <button class="btn btn-success" style=" position: relative; z-index: 1;" data-toggle="tooltip" data-placement="top" title="Nuevo Operador" id="ad"><i class="fa fa-plus"></i></button>

                    <button class="btn btn-danger btncorreo" data-toggle="tooltip" data-placement="top" title="Envio de Correos"><i class="fa fa-envelope-o"></i></button>

                    <a class="btn btn-success abrirCategoria" style="position: relative; z-index: 1;" data-toggle="tooltip" data-placement="top"
                        title="Categorias">
                            <i class="fa fa-btn fa-map-marker"></i>
                        </a>

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

            @if (count($operadores) > 0)
            <div class="table-responsive">
                <table class="table" id="empresas">
                    <thead style="background-color: #dd4b39; color: white; ">
                        <tr>
                            <th class="col-md-2">Nombre</th>
                            <th class="col-md-1">Destinos</th>
                            <th class="col-md-1">RUC</th>
                            <th class="col-md-2">Direccion</th>
                            <th class="col-md-1">Telfono</th>
                            <th class="col-md-2">Email</th>
                            <th class="col-md-2">Web</th>
                            <th>Categoria</th>
                            <th class="col-md-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($operadores as $operador)
                        <tr>
                            <input type="hidden" name="operador_id" value="{{ $operador->id }}"></input>
                            <td>{{$operador->nombre}}</td>
                            <td>{{$operador->destino->nombre}}</td>
                            <td>{{$operador->rif}}</td>
                            <td>{{$operador->direccion}}</td>
                            <td>{{$operador->telefono}}</td>
                            <td>
                                @if ($operador->emails->count()>0) @foreach ($operador->emails as $email) {{$email->nombre }}<br>                                @endforeach @else Sin Emails Registrados @endif
                            </td>
                            <td>{{$operador->web}}</td>
                            <td>
                                @if($operador->categoria != null) {{$operador->categoria->nombre}} @endif
                            </td>
                            <td style="display: inline-flex; margin-left: 27%;">
                                {{--<a href="{{ route('manageOperador-edit-A', $operador->id) }}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="left"
                                    title="Editar"><i class="fa fa-edit"></i></a>--}}


                                <button data-id="{{$operador->id}}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="left"
                                    title="Editar" id="editO"><i class="fa fa-edit"></i></button>

                                     @if(count($operador->Servicios)
                                >= 0)
                                <form action="{{ action('OperadorController@deleteOperador', $operador->id) }}" method="get">
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger btn-xs abrirModalConfirm" data-toggle="tooltip" data-placement="left" title="Eliminar"><i class="fa fa-trash"></i></button>
                                </form>
                                @endif
                                <a href="{{ route('manageOperador-servicios-A', $operador->id) }}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="left"
                                    title="Servicios"><i class="fa fa-list"></i></a>
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
        </div>
    @include('operadores.partials.modalOperadorCategorias')
    </div>
</div>
<!--agregar operador-->
<div id="addCategory" class="modal" style="overflow: auto; ">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 900px; margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-building"></i>Nuevo Operador
                </h4>
                <!--onclick="main_de_hoteles.cerrarModal()"-->
                <button  type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div> 

            <div class="modal-body">
                <form method="POST" action="{{ route('manageOperador-store-A') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-sm-4 {{ $errors->has('empresa') ? ' has-error' : '' }}">
                            <label class="control-label">Empresa</label>
                                <select name="empresa" required class="form-control select2">
                                     <option value="">Selecciona La Empresa</option>
                                     @foreach($empresas as $empresa)
                                     <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                                     @endforeach
                               </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="" placeholder="Nombre" >
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label">Ruc</label>
                                <input type="text" class="form-control" name="rif" value="" placeholder="RUC">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="control-label">Direccion</label>
                            <input type="text" class="form-control" name="direccion" value="" placeholder="Direccion"  maxlength="255">
                        </div>
                        <div class="form-group col-sm-4">
                           <label class="control-label">Telefono</label>
                           <input type="text" class="form-control" name="telefono" value="" placeholder="Telefono">
                        </div>
                            
                        <div class="form-group col-sm-4">
                            <label class="control-label">Email</label><br>
                            <input type="text" value="" data-role="tagsinput" id="tags" class="form-control">
                            {{--<input type="text" data-role="tagsinput" name="email" value="" placeholder="Email" class="form-control">--}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                           <label class="control-label">Web Empresarial</label>
                           <input type="text" class="form-control" name="web" value="" placeholder="Web Empresarial">
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label">Tipo de Categoria</label>
                            <select name="tipo" id="" class="form-control select2" style="width: 100%;">
                                <option value="" selected="selected">Tipo de Categoria</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                           <label class="control-label">Seleccione un Destino</label>
                           <select name="destino" id="" class="form-control select2" style="width: 100%;">
                                <option value="" selected="selected">Seleccione un Destino</option>
                                @foreach($destinos as $destino)
                                    <option value="{{$destino->id}}">{{$destino->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
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
</div>
<!---Fin de agregar operador-->
<!--editar operador-->
<div id="addEditO" class="modal" style="overflow: auto; ">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 900px; margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-building"></i>Editar Operador
                </h4>
                <!--onclick="main_de_hoteles.cerrarModal()"-->
                <button  type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div> 

            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action=" {{route('manageOperador-update-A',$operador->id)}}">
                    {!! csrf_field() !!}                        
                    <div class="row">
                        <div class="form-group col-sm-4 {{ $errors->has('empresa') ? ' has-error' : '' }}" style="margin-left: 5px;">
                            <label class="control-label">Empresa</label>
                                <select name="empresa" required class="form-control select2" id="empresa">
                                     {{--<option value="">Selecciona La Empresa</option>
                                     @foreach($empresas as $empresa)
                                     <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                                     @endforeach--}}
                               </select>
                        </div>
                        <div class="form-group col-sm-4" style="margin-left: 5px;">
                            <label class="control-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="" placeholder="Nombre" id="nombre">
                        </div>

                        <div class="form-group col-sm-4" style="margin-left: 5px;">
                            <label class="control-label">Ruc</label>
                                <input type="text" class="form-control" name="rif" value="" placeholder="RUC" id="ruc">
                        </div>
                    </div>
                        
                    <div class="row">
                        <div class="form-group col-sm-4" style="margin-left: 5px;">
                            <label class="control-label">Direccion</label>
                            <input type="text" class="form-control" name="direccion" value="" placeholder="Direccion"  maxlength="255" id="direccion">
                        </div>
                        <div class="form-group col-sm-4" style="margin-left: 5px;">
                           <label class="control-label">Telefono</label>
                           <input type="text" class="form-control" name="telefono" value="" placeholder="Telefono" id="telefono">
                        </div>
                        <div class="form-group col-sm-4" style="margin-left: 5px;">
                            <label class="control-label">Email</label><br>
                            
                            <input type="text" value="" class="form-control" id="t" name="email">
                            
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-4" style="margin-left: 5px;">
                           <label class="control-label">Web Empresarial</label>
                           <input type="text" class="form-control" name="web" value="" placeholder="Web Empresarial" id="web">
                        </div>
                        <div class="form-group col-sm-4" style="margin-left: 5px;">
                            <label class="control-label">Tipo de Categoria</label>
                            <select name="tipo" class="form-control select2" style="width: 100%;" id="categoria">
                                {{--<option value="" selected="selected">Tipo de Categoria</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach--}}
                            </select>
                        </div>
                        <div class="form-group col-sm-4" style="margin-left: 5px;">
                           <label class="control-label">Seleccione un Destino</label>
                           <select name="destino" id="destino" class="form-control select2" style="width: 100%;">
                                {{--<option value="" selected="selected">Seleccione un Destino</option>
                                @foreach($destinos as $destino)
                                    <option value="{{$destino->id}}">{{$destino->nombre}}</option>
                                @endforeach--}}
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                        <!--onclick="main_de_hoteles.cerrarModal()"-->
                        <button  type="button" class="btn btn-secondary pull-left" id="eO">
                            <i class="fa fa-close"></i> Cerrar
                        </button>

                        <button type="submit" id="ac" class="btn btn-danger pull-right">
                            <i class="fa fa-save"></i> Guardar
                        </button>   
            </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--fin de editar operador-->
<!--enviar correo-->
<div class="modal-lg modal modalCorreo">
    <div class="modal-content2 modal-content">
        <div class="modal-header">
            <button type="button" class="close btncerrar" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h5 class="modal-title" id="myModalLabel">
                <h4><i class="fa fa-filter"></i> Envio de Correos </h4>
            </h5>
        </div>
        <div class="modal-body">

            <div class=" row">
                <div class="col-sm-12 ">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('manageCorreo-envioAv-A')}}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="hidden" value="clientes">
                        <div class="col-sm-4">
                            <H4>Asunto</H4>
                        </div>
                        <div class="col-sm-12">
                            <input class="form-control" name="asunto" type="text">

                            <div class="clearfix"></div>
                        </div>
                        <div class="col-sm-4">
                            <H4>Mensaje</H4>
                        </div>
                        <div class="col-sm-12">
                            <textarea name="editor" class="form-control" type="text"></textarea>
                            <div class="clearfix"></div>
                        </div>
                        <!-- contenido principal -->
                        <div class="col-sm-4">
                            <H4></H4>
                        </div>
                        <div class="col-sm-12">
                            <section class="content" id="contenido_principal">

                            </section>
                            <!-- cargador empresa -->
                            <div style="display: none;" id="cargador_empresa" align="center">
                                <br>
                                <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;Espere... &nbsp;&nbsp;&nbsp;</label>
                                <img src="{!! asset('imagenes/cargando.gif')!!}" align="middle" alt="cargador"> &nbsp;
                                <label style="color:#ABB6BA">Realizando tarea solicitada ...</label>
                                <br>
                                <hr style="color:#003" width="50%">
                                <br>
                            </div>
                        </div>
                        <!-------------------------------------------->
                        <div>
                            <hr>
                            <div class="col-sm-4">
                                <H4>Destinatarios</H4>
                            </div>
                            <table class="table table-responsive table-bordered table-condensed" id="data">
                                <thead>
                                    <tr>
                                        <th class="col-md-2">Rif</th>
                                        <th class="col-md-2">Nombre</th>
                                        <th class="col-md-1">Correo</th>
                                        <th class="col-md-1">*Acciones*</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4">
                            <H4>Tipo de Envio</H4>
                        </div>
                        <div class="col-sm-12">
                            <select class="form-control" name="tipoenv" id="tipoenv" required>
                                    <option value="">Seleccionar</option>
                                    <option value="1">Enviar a todos</option>
                                    <option value="2">Envios Selectos</option>
                                </select>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-sm-12">
                            <H4>________________________________________________________________________________________________________________</H4>
                        </div>
                        <div class="col-sm-12">
                            <div name="1" id="1">
                                <button type="submit" class="btn btn-warning" data-dismiss="modal" disabled>Enviar</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection