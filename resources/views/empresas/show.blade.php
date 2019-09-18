@extends('layouts.master')


@section('titulo', 'Ficha Empresas')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
     <div class="page-header">
        <h1 aling="center" class="text-center"> <i class="fa fa-cubes"></i> Detalles de Empresa</h1>
    </div>
    <div class="col-md-9 col-md-offset-1">
       <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Empresa</h3>
        </div>

         <div class="panel-body">

                <table class="table table-striped table-bordered table-hover">


                    <tr>
                        <th>Nombres</th>
                        <td>{{$empresas->nombre}}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{$empresas->email}}</td>
                    </tr>

                    <tr>
                        <th>RUC</th>
                        <td>{{$empresas->rif}}</td>
                    </tr>

                    <tr>
                        <th>Direccion</th>
                        <td>{{$empresas->direccion}}</td>
                    </tr>

                    <tr>
                        <th>Telefono 1</th>
                        <td>{{$empresas->telefono_1}}</td>
                    </tr>

                    <tr>
                        <th>Telefono 2</th>
                        <td>{{$empresas->telefono_2}}</td>
                    </tr>

                    <tr>
                        <th>Web</th>
                        <td>{{$empresas->web}}</td>
                    </tr>

                    <tr>
                        <th>Eslogan</th>
                        <td>{{$empresas->slogan}}</td>
                    </tr>

                </table>
            </div>

    </div>



     <div class="page-header">
            <h1 aling="center" class="text-center"> <i class="fa fa-cubes"></i> Sucursales de {{$empresas->nombre}} </h1>
        </div>
        
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

         @if (count($sucursales) > 0)
         <div class="col-md-8 col-md-offset-2">
        <div class="table-responsive">
            <table class="table" id="sucursal1">
                <thead>
                    <tr>
                        <th class="col-md-1">ID</th>
                        <th class="col-md-2">Rif</th>
                        <th class="col-md-2">Nombre</th>
                        <th class="col-md-2">Direccion</th>
                        <th class="col-md-2">Acciones</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($sucursales as $sucursal)
                    <tr>
                        <td>{{$sucursal->id}}</td>
                        <td>{{$sucursal->rif}}</td>
                        <td>{{$sucursal->nombre}}</td>
                        <td>{{$sucursal->direccion}}</td>
                        <td>

                            <!----------->
                            <a class="btn btn-warning btn-xs" href="{{ route('manageSucursal-edit-A', $sucursal->id) }}" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="fa fa-pencil fa-lg"></i>
                            </a>
                            <!---------------------->
                            <a class="btn btn-danger btn-xs" href="{{ route('manageSucursal-destroy-A', $sucursal->id) }}" onclick="return confirm('Seguro que desea Eliminar el Registro {{$sucursal->id}}?')" data-toggle="tooltip" data-placement="left" title="Eliminar">
                                <i class="fa fa-trash fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>

            </table>


        </div>
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

