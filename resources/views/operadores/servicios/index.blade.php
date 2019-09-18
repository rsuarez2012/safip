@extends('layouts.master')
@section('titulo', 'servicio')
@section('script')
<script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

<script>
  $(document).ready(function(){
    $(function () {
      $('#servicios').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true
      });
    });
  });
</script>
@endsection


@section('content')

<div class="row box">
  <div class="col-md-12">
    <h1 style="margin-left: 1%;"><i class="fa fa-user"></i> Operador {{$operador->nombre}}</h1>
    <div class="table-responsive">
      <table class="table table-bordered" id="servicios">
        <thead class="text-center text-bold">
          <tr>
            <th>&nbsp;</th>
            <th class="bg-green" colspan="2">Peruano</th>
            <th class="bg-primary" colspan="2">Extranjero</th>
            <th class="bg-danger" colspan="2">Comunidad</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
          </tr>
          <tr>
            <th class="bg-orange">Nombre Servicio</th>
            <th class="bg-green">Adulto</th>
            <th class="bg-green">Estudiante</th>
            <th class="bg-primary">Adulto</th>
            <th class="bg-primary">Estudiante</th>
            <th class="bg-danger">Adulto</th>
            <th class="bg-danger">Estudiante</th>
            <th class="bg-success">Niño Peruano</th>
            <th class="bg-success">Niño Extranjero</th>
            <th class="bg-navy">Acciones</th>
          </tr>
        </thead>
        <tbody>
         <tr>
          <form action="{{route('manageServicios-store-A')}}" method="POST">
           {!! csrf_field() !!}
           <input type="hidden" name="operador" value="{{$operador->id}}" required="">
           <td class="bg-orange "><input class="form-control" type="text" step="0.01" name="nombre" required="" min="0"></td>
           <td class="bg-green"><input class="form-control" type="number" step="0.01" name="p_adulto" required="" min="0"></td>
           <td class="bg-green"><input class="form-control" type="number" step="0.01" name="p_estudiante" required="" min="0"></td>
           <td class="bg-primary "><input class="form-control" type="number" step="0.01" name="e_adulto" required="" min="0"></td>
           <td class="bg-primary "><input class="form-control" type="number" step="0.01" name="e_estudiante" required="" min="0"></td>
           <td class="bg-danger"><input class=" form-control" type="number" step="0.01" name="c_adulto" required="" min="0"></td>
           <td class="bg-danger"><input class=" form-control" type="number" step="0.01" name="c_estudiante" required="" min="0"></td>
           <td class="bg-success"><input class="form-control" type="number" step="0.01" name="p_ninio" required="" min="0"></td>
           <td class="bg-success"><input class="form-control" type="number" step="0.01" name="e_ninio" required="" min="0"></td>
           <td class="bg-navy">
            <button type="submit" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="left" title="Agregar"><i class="fa fa-plus-circle"></i> Agregar</button>
          </td>
        </form> 
      </tr>
      @if(count($operador->servicios) > 0)
      @foreach($operador->servicios as $fila)
        @php
          $peruano = ['adulto' => 0, 'estudiante' => 0, 'ninio' => 0];
          $extranjero = ['adulto' => 0, 'estudiante' => 0, 'ninio' => 0];
          $comunidad = ['adulto' => 0, 'estudiante' => 0];
          if ($fila->peruano!= null) {
                $peruano['adulto'] = $fila->peruano->adulto;
                $peruano['estudiante'] = $fila->peruano->estudiante;
                $peruano['ninio'] = $fila->peruano->ninio;
            }
            if ($fila->extranjero!= null) {
                $extranjero['adulto'] = $fila->extranjero->adulto;
                $extranjero['estudiante'] = $fila->extranjero->estudiante;
                $extranjero['ninio'] = $fila->extranjero->ninio;
            }
            if ($fila->comunidad!= null) {
                $comunidad['adulto'] = $fila->comunidad->adulto;
                $comunidad['estudiante'] = $fila->comunidad->estudiante;
            }
        @endphp
      <tr>
        <form action="{{route('manageServicios-updated-A')}}" method="POST">
          {!! csrf_field() !!}
          <input type="hidden" name="operador" value="{{$operador->id}}" required="">
          <input type="hidden" name="servicio" value="{{$fila->id}}" required="">
          <td class="bg-orange ">
            <input class="form-control" type="text" step="0.01" name="nombre" required="" min="0" value="{{$fila->nombre}}">
          </td>
          <td class="bg-green">
            <input class="form-control" type="number" step="0.01" name="p_adulto" required="" min="0" value="{{$peruano['adulto']}}">
          </td>
          <td class="bg-green">
            <input class="form-control" type="number" step="0.01" name="p_estudiante" required="" min="0" value="{{$peruano['estudiante']}}">
          </td>
          <td class="bg-primary ">
            <input class="form-control" type="number" step="0.01" name="e_adulto" required="" min="0" value="{{$extranjero['adulto']}}">
          </td>
          <td class="bg-primary ">
            <input class="form-control" type="number" step="0.01" name="e_estudiante" required="" min="0" value="{{$extranjero['estudiante']}}">
          </td>
          <td class="bg-danger">
            <input class=" form-control" type="number" step="0.01" name="c_adulto" required="" min="0" value="{{$comunidad['adulto']}}">
          </td>
          <td class="bg-danger">
            <input class=" form-control" type="number" step="0.01" name="c_estudiante" required="" min="0" value="{{$comunidad['estudiante']}}">
          </td>
          <td class="bg-success">
            <input class="form-control" type="number" step="0.01" name="p_ninio" required="" min="0" value="{{$peruano['ninio']}}">
          </td>
          <td class="bg-success">
            <input class="form-control" type="number" step="0.01" name="e_ninio" required="" min="0" value="{{$extranjero['ninio']}}">
          </td>
          <td class="bg-navy">
            <button type="submit" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-pencil"></i></button>
            <a href="{{route('manageServicios-destroy-A',['id'=>$fila->id,'operador'=>$operador->id])}}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="left" title="Eliminar"><i class="fa fa-trash"></i></a>
          </td>
        </form>
      </tr>
      @endforeach
      @endif
    </tbody>
  </table>
</div>
</div>
</div>


@endsection()





