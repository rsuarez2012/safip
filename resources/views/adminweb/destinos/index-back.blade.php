@extends('layouts.master')
@section('titulo', 'Destinos')
@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('script')
<script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
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

@endsection
@section('content')


<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <div class="x_title">
          <h2><i class="fa fa-globe"> </i> Destinos</h2><hr> 
      </div>
  </div>
  <div class="box-body">
   <div class="table-responsive">
       <table id="destino" class="table table-bordered table-hover">
       <thead>
           <tr>
               <th class="bg-orange text-center">NOMBRE DESTINO</th>
               <th class=" bg-navy text-center">ACCIONES</th>
           </tr>
       </thead>
      <tbody>
           <tr >
                <form action="{{route('manageDestino-store-A')}}"  method="POST">
                    {!! csrf_field() !!}
                    
                    <td class="bg-orange text-center">
                    <input  type="text" required placeholder="Nombre" name="nombre" class="form-control " style="width: 70%;">
                    </td> 
                    
                    <td class="bg-navy text-center"><button type="submit" class="btn btn-danger" title="Agregar" data-toggle="tooltip"><i class="fa fa-plus-circle"></i> Agregar</button></td>
                </form>
            </tr>
            @foreach($destino as $destinos)
            <tr>
                <form action="{{route('manageDestino-update-A')}}" method="POST">
                    {!! csrf_field() !!}

                    <input  type="hidden" name="id" value="{{$destinos->id}}"  >
                    <td class="bg-orange text-center">
                      <input  value="{{$destinos->nombre}}" type="text" required placeholder="Nombre" name="nombre" class="form-control" style="width: 70%;">
                    </td>
                    <td class="bg-navy text-center">
                        <button type="submit" class="btn-xs btn btn-danger"><i class="fa fa-pencil"></i></button>
                        <a href="{{route('manageDestino-destroy-A', $destinos->id)}}" class="btn-xs btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </form>
            </tr>
            @endforeach
      </tbody>
       </table>

   </div>

</div>
</div>
</div>
</div>


@endsection