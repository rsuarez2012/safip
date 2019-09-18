@extends('layouts.master')
@section('titulo', 'Destinos')
@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
{{-- @section('script')
<script>
 $(document).ready(function(){
  $(function () {
    $('#destino').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });

  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
});
</script>

@endsection --}}
@section('content')
<div class="row" id="main-destinos">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <div class="x_title">
          <h2><i class="fa fa-globe"> </i> Destinos</h2>
        </div>
      </div>
      <div class="box-body">
        <table class="table">
          <tr>
            <td>
              <button class="btn btn-danger pull-right"  data-toggle="tooltip" data-placement="left" title=" Nuevo Destino"  @click="nuevoDestino()"><i class="fa fa-plus"></i></button>
            </td>
          </tr>
        </table>
       <div class="table-responsive">
         <table id="destino" class="table table-bordered table-hover">
           <thead style="background-color: #dd4b39;color: #fff;">
             <tr>
               <th class="text-center">NOMBRE DEL DESTINO</th>
               <th class="text-center">ACCIONES</th>
             </tr>
           </thead>
           <tbody>
             <tr v-for="destino in destinos">
              <td class="text-center">@{{ destino.nombre }}</td>
              <td class="text-center">
                <button class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar" @click="editarDestino(destino)"><i class="fa fa-edit"></i></button>
                <button class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar" @click="eliminarDestino(destino)"><i class="fa fa-trash"></i></button>
              </td>
            </tr>
          </tbody>
        </table>

      </div>

    </div>
  </div>
</div>
</div>


@endsection
@push('scripts')
  <script src="{{ asset('js/destinos/index.js') }}"></script>
@endpush