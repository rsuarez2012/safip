@extends('layouts.master')
@section('titulo', 'Cotizaciones de Paquetes')

@section('css')

<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div hidden="true" id="div-alerta" class="callout callout-danger" style="position: fixed;z-index: 999999;">
  </div>
    <div class="box">
      <div class="box-header">
        <div class="x_title">
          <h2><i class="fa fa-cubes"></i> Cotizaciones de Paquetes <img src="{{asset('imagenes/cargando.gif')}}" hidden="" id="cargando" alt=""></h2><hr>
          
        </div>
        
        <div class="pull-right">
          <button type="button" id="abrirCrear" class="btn btn-danger" >
            <i class="fa fa-plus-circle"></i> Crear Cotizacion
          </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table id="cpaquetes" class="table-bordered table table-hover">
            <thead>
              <tr>
                <th>N° Cotizacion</th>
                <th>Agencia de Viajes</th>
                <th>Pais</th>
                <th>Ciudad Destino</th>
                <th>Nacionalidad</th>
                <th>Fecha de Salida</th>
                <th>Fecha de Retorno</th>
                <th>Cantidad de pasajeros</th>
                <th>Estado del Paquete</th>
                <th>observacion</th>
                <th>Fecha de Creacion</th>
                <th>Vendedor</th>
                <th>Fecha de Edicion</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($cotizaciones as $cotizacion)
              <tr id="fila-{{$cotizacion->id}}">
                <td class="text-center text-bold">{{$cotizacion->id}}</td>
                <td>{{$cotizacion->agencia->nombre}}</td>
                <td>{{$cotizacion->pais->Paisnombre}}</td>
                <td>{{$cotizacion->destino->nombre}}</td>
                <td>{{$cotizacion->nacionalidad}}</td>
                <td>{{$cotizacion->fecha_salida}}</td>
                <td>{{$cotizacion->fecha_retorno}}</td>
                <td class="text-center">{{$cotizacion->pasajero}}</td>
                <td class="text-center">
                  @if($cotizacion->estado == "procesado")
                    <label class="label label-success">Procesado</label>
                  @elseif($cotizacion->estado == "por_procesar")
                    <label class="label label-danger">Por Procesar</label>
                  @elseif($cotizacion->estado == "anulado")
                  <label class="label label-warning">Anulado</label>
                  @endif
                </td>
                <td>{{$cotizacion->observacion}}</td>
                <td>{{$cotizacion->created_at}}</td>
                <td>{{$cotizacion->vendedor->nombres}}</td>
                <td>{{$cotizacion->updated_at}}</td>
                <td>
                  @if($cotizacion->estado == "procesado")
                  <a href="{{route('manageCotizacionAdmin-destroy',$cotizacion->id)}}" class="btn btn-danger btn-xs" title="Anular Cotizacion" data-toggle="tooltip"><i class="fa fa-close"></i></a>
                  @elseif($cotizacion->estado == "por_procesar")
                  <button value="{{$cotizacion->id}}" class="abrirProcesar btn btn-success btn-xs " title="procesar cotizacion" data-toggle="tooltip"><i class="fa fa-check-square-o "></i></button>
                  <button value="{{$cotizacion->id}}" class="editarCotizacion btn btn-warning btn-xs" title="editar cotizacion" data-toggle="tooltip"><i class="fa fa-pencil "></i></button>
                  @elseif($cotizacion->estado == "anulado")
                  <label class="label label-warning">Anulado</label>
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

  <!-- MODAL SELECCIONAR PROVEEDOR-->
@include('adminweb.paquetes.cotizacion.formulario.procesar')

{{-- MODAL DE COTIZACIONES  --}}
@include('adminweb.paquetes.cotizacion.formulario.create')

@endsection

@section('script')
<script src="{!! asset('js/paquetes/cotizacion/index.js') !!}"></script>

<script>
  $(document).ready(function(){
    $(function () {
      $('#cpaquetes').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true
      });
    });

    //modal seleccionar proveedor
    $(".abrirseleccion").click(function(){
     $(".modalseleccion").fadeIn();
   });
    $(".cerrarseleccion").click(function(){
      $(".modalseleccion").fadeOut(300);
    });
  });
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
</script>
<script >
 $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });

 var APP_URL = {!!json_encode(url('/'))!!};
</script>
@endsection