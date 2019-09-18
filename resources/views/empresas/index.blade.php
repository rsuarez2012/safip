@extends('layouts.master')

@section('titulo', 'Empresas')

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
                   <div class="col-md-8">
                        <div class="x_title">
                            <h2><i class="fa fa-building"></i> Empresas</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 pull-right" style="top: 24px;">
                        <button class="btn btn-success abrir"><i class="fa fa-building" data-toggle="tooltip" data-placement="left" title=" Crear Sucursal"></i> </button>
                        
                    
                        <a href="{{ route('manageEmpresa-create-A') }}" type="submit" class="btn btn-success" style=" position: relative; z-index: 1;" data-toggle="tooltip" data-placement="top" title="Nueva Empresa">
                            <i class="fa fa-plus "></i> 
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


                    @if (count($empresas) > 0)
                    <div class="table-responsive">
                    <table class="table" id="empresas" >
                                <thead style="background-color: #dd4b39; color: white; ">
                                <tr>
                                    <th >ID</th>
                                    <th class="col-md-2">Nombre</th>
                                    <th class="col-md-2">RUC</th>
                                    <th class="col-md-2">Direccion</th>
                                    <th class="col-md-1">Email</th>
                                    <th class="col-md-1">Telefono 1</th>
                                    <th class="col-md-1">Telefono 2</th>
                                    <th class="col-md-1">Web</th>
                                    <th class="col-md-1">Slogan</th>
                                    <th class="col-md-2">Acciones</th>

                                </tr>
                            </thead>

                        <tbody>
                        @foreach ($empresas as $empresa)
                            <tr>
                                <td>{{$empresa->id}}</td>
                                <td>{{$empresa->nombre}}</td>
                                <td>{{$empresa->rif}}</td>
                                <td>{{$empresa->direccion}}</td>
                                <td>{{$empresa->email}}</td>
                                <td>{{$empresa->telefono_1}}</td>
                                <td>{{$empresa->telefono_2}}</td>
                                <td>{{$empresa->web}}</td>
                                <td>{{$empresa->slogan}}</td>

                                <td>

                                    <a class="btn btn-info btn-xs" href="{{ route('manageEmpresa-show-A', $empresa->id) }}" data-toggle="tooltip" data-placement="left" title="Ver Ficha">
                                        <i class="fa fa-file-text fa-lg"></i>
                                    </a>
                                    <a class="btn btn-warning btn-xs" href="{{ route('manageEmpresa-edit-A', $empresa->id) }}" data-toggle="tooltip" data-placement="left" title="Editar">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>

                                        <a class="btn btn-danger btn-xs" href="{{ route('manageEmpresa-destroy-A', $empresa->id) }}" onclick="return confirm('Seguro que desea Eliminar el Registro {{$empresa->id}}?')" data-toggle="tooltip" data-placement="left" title="Eliminar">
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
        
        <div class="modal-lg modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close cerrar" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel"> <h2><i class="fa fa-building"></i> Crear Sucursal</h2></h4>
                </div>
                <div class="modal-body">

                    @section('script')
                        <script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>
                        <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
                        <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
                    @endsection

                        <div class="box padding_box1">
                            <div id="wrapper">
                                <div id="login" class=" form" style="background-color: #FFF; padding: 0 20px; border-radius: 10px;">
                                    <section class="login_content">
                                        <div class="clearfix"></div>


                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="x_title">
                                                   
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">

                                                <div class="clearfix"></div>


                                                <form class="form-horizontal" role="form" method="POST" action="{{ route('manageSucursal-store-A') }}" enctype="multipart/form-data">
                                                    {!! csrf_field() !!}

                                                    <div class="form-group {{ $errors->has('empresa') ? ' has-error' : '' }}">
                                                        <label class="control-label col-sm-2">Empresa</label>
                                                        <div class="col-sm-10">
                                                        <select name="empresa" required class="form-control ">
                                                            <option value="">Selecciona La Empresa</option>
                                                            @foreach($empresas as $empresa)
                                                                <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                                                            @endforeach

                                                        </select>

                                                        @if ($errors->has('empresa'))
                                                            <span class="help-block">
                                          <strong>{{ $errors->first('empresa') }}</strong>
                                      </span>
                                                        @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }} has-feedback">
                                                        <label class="col-sm-2 control-label">Nombre</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="nombre" value="" placeholder="Nombre" required>

                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('nombre'))
                                                            <span class="help-block">
                                      <strong>{{ $errors->first('nombre') }}</strong>
                                  </span>
                                                        @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group {{ $errors->has('rif') ? ' has-error' : '' }} has-feedback">
                                                        <label class="col-sm-2 control-label">RUC</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="rif" value="" placeholder="RUC" required>

                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('rif'))
                                                            <span class="help-block">
                                                          <strong>{{ $errors->first('rif') }}</strong>
                                                      </span>
                                                        @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">
                                                        <label class="col-sm-2 control-label">Direccion</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="direccion" value="" placeholder="Direccion"  maxlength="255" required>

                                                        <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                                                        @if ($errors->has('direccion'))
                                                            <span class="help-block">
                                                              <strong>{{ $errors->first('direccion') }}</strong>
                                                         </span>
                                                        @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-actions">
                                                        <button type="submit" class="btn btn-success pull-right">
                                                            Registrar <i class="fa fa-arrow-circle-right"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </section>
                                </div>

                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cerrar btn-warning" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
        
</div>
@endsection

