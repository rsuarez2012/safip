@extends('layouts.master')
@section('titulo','Paquetes')
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
        $('#products').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
    });
    $(function () {
        $('#destinosTable').DataTable({
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
                <div class="col-md-7">
                    <div class="x_title">
                        <h2><i class="fa fa-building"></i> Paquetes</h2>
                        <div class="clearfix"></div>
                    </div>
                </div>
                
                <div class="container text-center">

                <div class="col-md-2">
                    <a href="{{ route('manageProduct-create-A') }}" class="btn btn-success" style="margin-bottom: 10px; position: relative; z-index: 1;">
                        <i class="fa fa-btn fa-plus-circle"></i> Nuevo Paquete
                    </a>
                </div>
            </div>
            
        <div class="container text-center">

            <div class="page">
                <div class="x_content">
                   @if(Session::has('message'))
                   <div class='alert alert-success'>
                       <button type="button" class="close" data-dismiss="alert">&times;</button>
                       <p>{!! Session::get('message') !!}</p>
                   </div>
                   @endif
               </div>
               <div class="table-responsive">
                <table id="products" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Imagen</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Precio Sol</th>
                            <th class="text-center">Precio Dolar</th>
                            <th class="text-center">Categoría</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@stop