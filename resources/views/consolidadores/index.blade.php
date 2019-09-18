@extends('layouts.master')

@section('titulo', 'consolidadoreses')

@section('css')
  <!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
 <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('script')


    <script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>



    <script type="text/javascript">
        $(function () {
            $('#empresas').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true
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
                            <h2><i class="fa fa-building"></i> Consolidadores</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('manageConsolidador-create-A') }}" type="submit" class="btn btn-success" style="margin-bottom: 10px; position: relative; z-index: 1;">
                            <i class="fa fa-btn fa-sign-in"></i> Nuevo Consolidador
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


                    @if (count($consolidadores) > 0)
                    <div class="table-responsive">
                    <table class="table" id="empresas" >
                                <thead>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-2">Empresa</th>
                                    <th class="col-md-2">Nombre</th>
                                    <th class="col-md-2">RUC</th>
                                    <th class="col-md-2">Direccion</th>
                                    <th class="col-md-1">Email</th>
                                    <th class="col-md-1">Telefono</th>
                                    <th class="col-md-1">Web</th>
                                    <th class="col-md-1">Descripcion</th>
                                    <th class="col-md-2">Acciones</th>

                                </tr>
                            </thead>

                        <tbody>
                        @foreach ($consolidadores as $consolidador)
                            <tr>
                                <td>{{$consolidador->id}}</td>
                                <td>{{$consolidador->empresas->nombre}}</td>
                                <td>{{$consolidador->nombre}}</td>
                                <td>{{$consolidador->rif}}</td>
                                <td>{{$consolidador->direccion}}</td>
                                <td>{{$consolidador->email}}</td>
                                <td>{{$consolidador->telefono}}</td>
                                <td>{{$consolidador->web}}</td>
                                <td>{{$consolidador->descripcion}}</td>

                                <td>
                                    <a class="btn btn-warning btn-xs" href="{{ route('manageConsolidador-edit-A', $consolidador->id) }}" data-toggle="tooltip" data-placement="left" title="Editar">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>

                                        <a class="btn btn-danger btn-xs" href="{{ route('manageConsolidador-destroy-A', $consolidador->id) }}" onclick="return confirm('Seguro que desea Eliminar el Registro {{$consolidador->id}}?')" data-toggle="tooltip" data-placement="left" title="Eliminar">
                                            <i class="fa fa-trash fa-lg"></i>
                                        </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        {{$consolidadores->render()}}
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
@endsection
