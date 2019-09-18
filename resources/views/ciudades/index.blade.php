@extends('layouts.master')

@section('titulo', 'Ciudades')

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
            $('#ciudades').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
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
                            <h2><i class="fa fa-map-o"></i> Ciudades</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 24px;">
                        <a href="{{ route('manageCiudad-create-A') }}" type="submit" class="btn btn-success" style=" position: relative; z-index: 1;" data-toggle="tooltip" data-placement="left" title="Nueva Ciudad">
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


                    @if (count($ciudades) > 0)
                    <div class="table-responsive">
                    <table class="table" id="ciudades" >
                                <thead style="background-color: #dd4b39; color: white; ">
                                <tr>
                                    <th class="col-md-1 text-center">ID</th>
                                    <th class="col-md-2">Ciudad</th>
                                    <th class="col-md-2">Cod. Pais</th>
                                    <th class="col-md-2 text-center">Acciones</th>

                                </tr>
                            </thead>

                        <tbody>
                        @foreach ($ciudades as $ciudad)
                            <tr>
                                <td class="text-center">{{$ciudad->id}}</td>
                                <td>{{$ciudad->ciudadnombre}}</td>
                                <td>{{$ciudad->paiscodigo}}</td>

                                <td class="text-center">
                                    <a class="btn btn-warning btn-xs" href="{{ route('manageCiudad-edit-A', $ciudad->id) }}" data-toggle="tooltip" data-placement="left" title="Editar">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>

                                        <a class="btn btn-danger btn-xs" href="{{ route('manageCiudad-destroy-A', $ciudad->id) }}" onclick="return confirm('Seguro que desea Eliminar el Registro {{$ciudad->id}}?')" data-toggle="tooltip" data-placement="left" title="Eliminar">
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

