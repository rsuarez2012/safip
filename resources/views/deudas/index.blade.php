@extends('layouts.master')

@section('titulo', 'TDeudas')

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
            $('#deudas').DataTable({
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
                            <h2><i class="fa fa-building"></i> Tipos de Deudas</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('manageDeuda-create-A') }}" type="submit" class="btn btn-success" style="margin-bottom: 10px; position: relative; z-index: 1;">
                            <i class="fa fa-btn fa-sign-in"></i> Nuevo Tipo de Deuda
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


                    @if (count($deudas) > 0)
                    <div class="table-responsive">
                    <table class="table" id="deudas" >
                                <thead>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-2">Tipo de Deuda</th>
                                    <th class="col-md-2">Descripcion</th>
                                    <th class="col-md-2">Fecha de Registro</th>
                                    <th class="col-md-2">Registrado por:</th>
                                    <th class="col-md-2">Acciones</th>

                                </tr>
                            </thead>

                        <tbody>
                        @foreach ($deudas as $deuda)
                            <tr>
                                <td>{{$deuda->id}}</td>
                                <td>{{$deuda->tipo_deuda}}</td>
                                <td>{{$deuda->descripcion}}</td>
                                <td>{{$deuda->created_at}}</td>
                                <td>{{$deuda->usuario}}</td>
                                <td>
                                    <a class="btn btn-warning btn-xs" href="{{ route('manageDeuda-edit-A', $deuda->id) }}" data-toggle="tooltip" data-placement="left" title="Editar">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>

                                        <a class="btn btn-danger btn-xs" href="{{ route('manageDeuda-destroy-A', $deuda->id) }}" onclick="return confirm('Seguro que desea Eliminar el Registro {{$deuda->id}}?')" data-toggle="tooltip" data-placement="left" title="Eliminar">
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
    </div>
        
</div>
@endsection

