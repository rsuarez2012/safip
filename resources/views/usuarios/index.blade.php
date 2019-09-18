@extends('layouts.master')

@section('titulo', 'Usuarios')

@section('css')
  <!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->

@endsection
@section('script')

    <script src={!! asset("js/jquery.min.js")!!}></script>
    <script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

    <script type="text/javascript">
        $(function () {
            $('#usuarios').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthMenu": [ 50,100, 200, 500],
                "autoWidth": true
            });
        });
        $(document).ready(function(){
  
           $(".abrir").click(function(){
              
                $(".modal").fadeIn();
              
            });
           
          
            $(".cerrar").click(function(){
              
                $(".modal").fadeOut(300);
              
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
                        <h2><i class="fa fa-user"></i> Usuarios</h2>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 24px;">
                    <a href="{{ route('manageUsuario-create-A') }}" type="submit" class="btn btn-success" style=" position: relative; z-index: 1;" data-toggle="tooltip" data-placement="left" title="Nuevo Usuario">
                          <i class="fa fa-btn fa-user-plus"></i> 
                    </a>
                 
                </div>
            </div>
            <hr>
        <div class="x_panel">


            

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


                @if (count($usuarios) > 0)
                <div class="table-responsive">
                <table class="table" id="usuarios" >
                            <thead style="background-color: #dd4b39; color: white; ">
                            <tr>
                                <th class="col-md-1 text-center">ID</th>
                                <th class="col-md-2">Nombres</th>
                                <th class="col-md-2">Apellidos</th>
                                <th class="col-md-2">Correo</th>
                                <th class="col-md-1">Rol</th>
                                <th class="col-md-1">Estatus</th>
                                <th class="col-md-2 text-center">Acciones</th>

                            </tr>
                        </thead>

                    <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td class="text-center">{{$usuario->id}}</td>
                            <td>{{$usuario->nombres}}</td>
                            <td>{{$usuario->apellidos}}</td>
                            <td>{{$usuario->email}}</td>
                            <td>
                                    <span class="label label-success">{{$usuario->role}}</span>
                            </td>
                            <td>
                                @if ($usuario->active== "1")
                                    <span class="label label-success">Activo</span>
                                @else
                                    <span class="label label-danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                    @if( $usuario->active == "1" )
                                        <a class="btn btn-danger btn-xs" href="{{ route('manageUsuario-status-A', $usuario->id) }}" onclick="return confirm('Seguro que desea Deshabilitar al usuario {{$usuario->apellidos." ".$usuario->nombres}}?')" data-toggle="tooltip" data-placement="left" title="Deshabilitar" >
                                            <i class="fa fa-ban"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-success btn-xs" href="{{ route('manageUsuario-status-A', $usuario->id) }}" onclick="return confirm('Seguro que desea Habilitar al usuario {{$usuario->apellidos." ".$usuario->nombres}}?')" data-toggle="tooltip" data-placement="left" title="Habilitar" >
                                            <i class="fa fa-check-circle-o"></i>
                                        </a>
                                    @endif

                                    <a class="btn btn-warning btn-xs" href="{{ route('manageUsuario-edit-A', $usuario->id) }}" data-toggle="tooltip" data-placement="left" title="Editar">
                                        <i class="fa fa-pencil fa-lg"></i>
                                    </a>

                                    <a class="btn btn-danger btn-xs" href="{{ route('manageUsuario-destroy-A', $usuario->id) }}" onclick="return confirm('Seguro que desea Eliminar al usuario {{$usuario->id}}?')" data-toggle="tooltip" data-placement="left" title="Eliminar">
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
                        <h3 style="margin-top: 0px;"><b>INFORMACIÓN!!!</b></h3>
                        <i class="fa fa-exclamation-triangle" style="font-size: 40px; float:left; margin-right: 16px; margin-top: -6px;"></i>
                        <p class="margin-bottom-10">
                        No existen items registrados en el sistema.
                        </p>
                    </div>

                @endif

            </div>
        </div></div>
    </div>
        
</div>

@endsection

