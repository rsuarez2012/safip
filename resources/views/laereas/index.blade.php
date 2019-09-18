@extends('layouts.master')

@section('titulo', 'Lineas Aereas')

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
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                 "lengthMenu": [ 50,100, 200, 500],
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
                            <h2><i class="fa fa-building"></i> Linea Aerea</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-2 pull-right" style="margin-top: 24px;">
                        <a href="{{ route('manageLaerea-create-A') }}" type="submit" class="btn btn-success" style=" position: relative; z-index: 1;" data-toggle="tooltip" data-placement="left" title=" Nueva Linea Aerea">
                            <i class="fa fa-plus"></i> 
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


                    @if (count($aereas) > 0)
                    <div class="table-responsive">
                    <table class="table" id="empresas" >
                                <thead style="background-color: #dd4b39; color: white; ">
                                <tr>
                                    <th >ID</th>
                                    <th class="col-md-2">Empresa</th>
                                    <th class="col-md-2">Nombre</th>
                                    <th >RUC</th>
                                    <th class="col-md-2">Direccion</th>
                                    <th class="col-md-1">Email</th>
                                    <th class="col-md-1">Telefono</th>
                                    <th class="col-md-1">Web</th>
                                    <th class="col-md-1">Descripcion</th>
                                    <th class="col-md-1">Creado por:</th>
                                    <th class="col-md-1">Fecha de Creacion:</th>
                                    <th class="col-md-1">Editado por:</th>
                                    <th class="col-md-1">Fecha de Edicion:</th>
                                    <th class="col-md-2">Acciones</th>

                                </tr>
                            </thead>

                        <tbody>
                        @foreach ($aereas as $aerea)
                            <tr style="padding: 1px !important;">
                                <td>{{$aerea->id}}</td>
                                <td>@if(!empty($aerea->empresas->nombre))
                                        {{$aerea->empresas->nombre}}
                                    @else
                                        Esta empresa Ya no Existe
                                    @endif
                                    </td>
                                <td>{{$aerea->nombre}}</td>
                                <td>{{$aerea->rif}}</td>
                                <td>{{$aerea->direccion}}</td>
                                <td style="font-size: x-small !important ;">{{$aerea->email}}</td>
                                <td>{{$aerea->telefono}}</td>
                                <td style="font-size: x-small !important ;">{{$aerea->web}}</td>
                                <td>{{$aerea->descripcion}}</td>
                                <td>{{$aerea->created_by}}</td>
                                <td>{{$aerea->created_at}}</td>
                                <td>{{$aerea->updated_by}}</td>
                                <td>{{$aerea->updated_at}}</td>

                                <td>
                                    <a class="btn btn-warning btn-xs" href="{{ route('manageLaerea-edit-A', $aerea->id) }}" data-toggle="tooltip" data-placement="left" title="Editar">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>

                                        <a class="btn btn-danger btn-xs" href="{{ route('manageLaerea-destroy-A', $aerea->id) }}" onclick="return confirm('Seguro que desea Eliminar el Registro {{$aerea->id}}?')" data-toggle="tooltip" data-placement="left" title="Eliminar">
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

