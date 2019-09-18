@extends('layouts.master')
@section('titulo', 'Solicitudes De Agencias')

@section('css')
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12  box">
      <div class="box-header">
        <h2><i class="fa fa-users"></i> Solicitudes de Agencias <img style="display: none" src="{{asset('imagenes/cargando.gif')}}"  id="cargando"></h2>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="solicitudes">
            <thead  style="background-color: #dd4b39;color: #fff">
              <tr>
                <th>Nombre De La Agencia</th>
                <th>DNI</th>
                <th>Correo Electronico</th>
                <th>Nombre Corporativo</th>
                <th>Representante Legal</th>
                <th>Sitio Web</th>
                <th>Fecha De Creacion</th>
                <th>Telefono Corporativo</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($solicitudes as $solicitud)
                  <tr id="{{$solicitud->id}}">
                      <td>{{$solicitud->user->name}}</td>
                      <td>{{$solicitud->user->dni}}</td>
                      <td>{{$solicitud->user->email}}</td>
                      <td>{{$solicitud->business_name}}</td>
                      <td>{{$solicitud->legal_representative}}</td>
                      <td>{{$solicitud->website}}</td>
                      <td>{{$solicitud->date}}</td>
                      <td>{{$solicitud->corporate_phone}}</td>
                      <td class="text-center status-actual">
                        @if ($solicitud->status == "processing")
                            <label class="label bg-primary">En Espera</label>
                        @elseif($solicitud->status == "approved")
                            <label class="label bg-green">Aprobado</label>
                        @else 
                            <label style="background-color: #dd4b39;color: #fff" class="label">Rechazado</label>    
                        @endif
                      </td>
                      <td class="status-botones" style="min-width: 70px;">
                        @if ($solicitud->status == "processing")
                          <button onclick="abrirModal({{$solicitud->id}},'approved')" class="btn btn-primary btn-xs"  title="Aprobar"><i class="fa fa-check"></i></button>
                          <button onclick="abrirModal({{$solicitud->id}},'rejected')" class="btn btn-danger btn-xs"  title="Rechazar"><i class="glyphicon glyphicon-ban-circle"></i></button>
                        @elseif($solicitud->status == "approved")
                          {{-- <button onclick="eliminar({{$solicitud->id}})" data-toggle='tooltip' title='Eliminar' class='btn-xs btn btn-danger'><i class='fa fa-close'></i></button>
                           --}}<button onclick="abrirModal({{$solicitud->id}},'rejected')" class="btn btn-danger btn-xs"  title="Rechazar"><i class="glyphicon glyphicon-ban-circle"></i></button>
                        @else 
                          {{-- <button onclick="abrirModal({{$solicitud->id}},'delete')" data-toggle='tooltip' title='Eliminar' class='btn-xs btn btn-danger'><i class='fa fa-close'></i></button>
                          <button data-toggle='tooltip' title='Editar' class='btn-xs btn btn-warning'><i class='fa fa-pencil'></i></button>   --}}  
                        @endif
                      </td>
                    </tr>  
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@include('adminweb.solicitudes.alerta')
@endsection

@section('script')
    <script>
        $(document).ready(function(){
          $(function () {
            $('#solicitudes').DataTable({
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": false,
              "info": true,
              "autoWidth": true
          });
        });
      });
      var APP_URL = {!!json_encode(url('/'))!!};
    </script>
    <script src="{{ asset('js/paquetes/solicitudes_agencias/index.js') }}"></script>
@endsection

