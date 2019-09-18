@extends('layouts.master')
@section('titulo', 'Agencia de Viaje')
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
    <script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
    <script src="{!! asset('js/sistemalaravel3.js') !!}"></script>
    <script src="//cdn.ckeditor.com/4.9.0/standard/ckeditor.js"></script>
    <script>CKEDITOR.replace( 'editor' );</script>

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
        });
        $(".btncorreo").click(function(e){
            e.preventDefault();
            $(".modalCorreo").fadeIn();
        });
        $(".btncerrar").click(function(e){
            e.preventDefault();
            $(".modalCorreo").fadeOut(300);
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
    </script>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box padding_box1">
                <div class="row">
                    <div class="col-md-10">
                        <div class="x_title">
                            <h2><i class="fa fa-plane"></i> Agencia de Viajes</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 24px;">
                        <a href="{{ route('manageAviaje-create-A') }}" type="submit" class="btn btn-success" style=" position: relative; z-index: 1;" data-toggle="tooltip" data-placement="left" title="Nueva Agencia de Viajes">
                            <i class="fa fa-plus"></i> 
                        </a>
                        
                    
                         <button class="btn btn-warning btncorreo" data-toggle="tooltip" data-placement="top" title="Envio de Correos"><i class="fa fa-envelope-o"></i></button>
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
                @if (count($viajes) > 0)
                    <div class="table-responsive">
                        <table class="table" id="empresas" >
                            <thead style="background-color: #dd4b39; color: white; ">
                            <tr >

                                <th class="col-md-1">Empresa</th>
                                <th class="col-md-1">Nombre</th>
                                <th class="col-md-1">RUC</th>
                                <th>Direccion</th>
                                <th  >Email</th>
                                <th class="col-md-1">Telefono</th>
                                <th class="col-md-1" ">Web</th>
                                <th class="col-md-1">Descripcion</th>
                                <th class="col-md-1">Counter</th>
                                <th >Creado por:</th>
                                <th class="col-md-1">Fecha de Creacion:</th>
                                <th class="col-md-1">Editado por:</th>
                                <th class="col-md-1">Fecha de Edicion:</th>
                                <th class="col-md-2">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($viajes as $viaje)
                                <tr>
                                    <td>@if(!empty($viaje->empresas->nombre))
                                            {{$viaje->empresas->nombre}}
                                        @else
                                            Esta Linea Aerea Ya no Existe
                                        @endif
                                        </td>
                                    <td>{{$viaje->nombre}}</td>
                                    <td>{{$viaje->rif}}</td>
                                    <td>{{$viaje->direccion}}</td>
                                    <td style="font-size: 12px !important ;">{{$viaje->email}}</td>
                                    <td>{{$viaje->telefono}}</td>
                                    <td style="font-size: x-small !important ;">{{$viaje->web}}</td>
                                    <td>{{$viaje->descripcion}}</td>
                                    <td>{{$viaje->counter}}</td>
                                    <td>{{$viaje->created_by}}</td>
                                    <td>{{$viaje->created_at}}</td>
                                    <td>{{$viaje->updated_by}}</td>
                                    <td>{{$viaje->updated_at}}</td>
                                    <td>
                                        <a class="btn btn-warning btn-xs" href="{{ route('manageAviaje-edit-A', $viaje->id) }}" data-toggle="tooltip" data-placement="left" title="Editar">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{ route('manageAviaje-destroy-A', $viaje->id) }}" onclick="return confirm('Seguro que desea Eliminar el Registro {{$viaje->id}}?')" data-toggle="tooltip" data-placement="left" title="Eliminar">
                                            <i class="fa fa-trash fa-lg"></i>
                                        </a>
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
        </div>
    </div>
    <div class="modal-lg modal modalCorreo">
        <div class="modal-content2 modal-content">
            <div class="modal-header">
                <button type="button" class="close btncerrar" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h5 class="modal-title" id="myModalLabel"> <h4><i class="fa fa-filter"></i> Envio de Correos </h4></h5>
            </div>
            <div class="modal-body">

                <div class=" row">
                    <div class="col-sm-12 ">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('manageCorreo-envioAv-A')}}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" value="clientes">
                            <div class="col-sm-4"><H4>Asunto</H4></div>
                            <div class="col-sm-12">
                                <input class="form-control" name="asunto" type="text">

                                <div class="clearfix"></div>
                            </div>
                            <div class="col-sm-4"><H4>Mensaje</H4></div>
                            <div class="col-sm-12">
                                <textarea name="editor" class="form-control" type="text"></textarea>
                                <div class="clearfix"></div>
                            </div>
                            <!-- contenido principal -->
                            <div class="col-sm-4"><H4>Mensaje</H4></div>
                            <div class="col-sm-12">
                                <section class="content"  id="contenido_principal">

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
                                <div class="col-sm-4"><H4>Destinatarios</H4></div>
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
                            <div class="col-sm-4"><H4>Tipo de Envio</H4></div>
                            <div class="col-sm-12">
                                <select  class="form-control" name="tipoenv" id="tipoenv" required>
                                    <option value="">Seleccionar</option>
                                    <option value="1">Enviar a todos</option>
                                    <option value="2">Envios Selectos</option>
                                </select>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-sm-12"><H4>________________________________________________________________________________________________________________</H4></div>
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

