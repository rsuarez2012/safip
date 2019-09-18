@extends('layouts.master')

@section('titulo', 'Agentes')

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
            $('#agentes').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
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
                            <h2><i class="fa fa-building"></i> Agentes</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('manageAgente-create-A') }}" type="submit" class="btn btn-success" style="margin-bottom: 10px; position: relative; z-index: 1;">
                            <i class="fa fa-btn fa-sign-in"></i> Nuevo Agente
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


                    @if (count($agentes) > 0)
                    <div class="table-responsive">
                    <table class="table" id="agentes" >
                                <thead>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-2">Empresa</th>
                                    <th class="col-md-2">Sucursal</th>
                                    <th class="col-md-2">Nombre</th>
                                    <th class="col-md-2">Apellido</th>
                                    <th class="col-md-2">DNI</th>
                                    <th class="col-md-2">Direccion</th>
                                    <th class="col-md-1">Email</th>
                                    <th class="col-md-1">Telefono</th>
                                    <th class="col-md-1">Cargo</th>
                                    <th class="col-md-1">Creado por:</th>
                                    <th class="col-md-1">Fecha de Creacion:</th>
                                    <th class="col-md-1">Fecha de Edicion:</th>
                                    <th class="col-md-2">Acciones</th>

                                </tr>
                            </thead>

                        <tbody>
                        @foreach ($agentes as $agente)

                            <tr>
                                <td>{{$agente->id}}</td>
                                <td>@if(!empty($agente->empresas->nombre))
                                        {{$agente->empresas->nombre}}
                                    @else
                                        Esta Empresa Ya no Existe
                                    @endif
                                    </td>
                                <td>@if(!empty($agente->sucursales->nombre))
                                        {{$agente->sucursales->nombre}}
                                    @else
                                        Esta Sucursal Ya no Existe
                                    @endif
                                    </td>
                                <td>{{$agente->nombre}}</td>
                                <td>{{$agente->apellido}}</td>
                                <td>{{$agente->cedula_rif}}</td>
                                <td>{{$agente->direccion}}</td>
                                <td>{{$agente->email}}</td>
                                <td>{{$agente->telefono}}</td>
                                <td>{{$agente->cargo}}</td>
                                <td>{{$agente->created_by}}</td>
                                <td>{{$agente->created_at}}</td>
                                <td>{{$agente->updated_at}}</td>

                                <td>
                                    <a class="btn btn-warning btn-xs" href="{{ route('manageAgente-edit-A', $agente->id) }}" data-toggle="tooltip" data-placement="left" title="Editar">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{ route('manageAgente-destroy-A', $agente->id) }}" onclick="return confirm('Seguro que desea Eliminar el Registro {{$agente->id}}?')" data-toggle="tooltip" data-placement="left" title="Eliminar">
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
@endsection

