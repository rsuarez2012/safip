@extends('layouts.master')
@section('titulo', 'Hoteles')

@section('content')
<div class="row" id="main-hoteles">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
              
                <div class="col-md-8">
                    <div class="x_title">
                         <h3>
                            <i class="fa fa-hotel"></i> 
                            Detalles del Hotel: {{ $hotel[0]->nombre }}
                        </h3>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="box-body">
            {{--<form method="POST" action="{{route('detalles_store')}}">--}}
                @php
                    $id = $hotel[0]->id;
                @endphp
            <form method="POST" action="{{route('detalles_store', $id)}}">
                {{ csrf_field() }}
                <div class="col-xs-8">
                    <div class="box box-danger">
                        <div class="box-body">
                            <input type="hidden" value="{{ $hotel[0]->id }}" name="hotel_id" id="hotel_id">
                            <div class="form-group">
                                <label>Reseña del Hotel</label>
                                <textarea rows="4" name="resumen_hotel" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Descripcion de las habitaciones</label>
                                <textarea rows="4" name="descripcion_habitaciones" class="form-control"></textarea>
                            </div>
                        </div>
                        {{--dd($detalle)--}}
                    </div> 
                </div>
                <div class="col-xs-4">
                    <div class="box box-danger">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-xs-8">
                                    <h4><b>servicios</b></h4>
                                </div>
                                <div class="col-xs-4">
                                    <button type="button" class="btn btn-danger btn-sm pull-right" id="addServices" data-toggle="modal" data-target=".services">Agregar</button>
                                </div>
                                
                            </div>
                        </div>
                        <biv class="box-body">
                            <div class="form-group">
                                <select class="form-control select2" multiple="multiple" data-placeholder="Selecciona uno o mas servicios" style="width: 100%;" name="servicios[]">
                                    @foreach($services as $service)
                                        {{--$hotel->servicios->pluck('id')--}}
                                    <option {{collect(old('services', $servicio->pluck('servicio_id')))->contains($service->id) ? 'selected' : '' }} value="{{$service->id}}">{{$service->nombre}}</option>
                                @endforeach                                    
                                </select>
                            </div>
                        </biv>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-block">
                            Guardar Detalles
                        </button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    @include('adminweb.hoteles.modals.servicios')
</div>
 {{--@include('adminweb.hoteles.modals.categorias')--}}

@section('script')
<script src={!! asset( "admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset( "admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset( "admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<script type="text/javascript">
    
$(document).ready(function(){
    $('#addServices').on('click', function(){
        //alert("servicio");
        //$('.services').modal('show');
    })
    $('#table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "lengthMenu": [ 50,100, 200, 500],
                "autoWidth": true
            });
    $('button[id=edit]').on('click', function(){
    $('#cerrar').on('click', function(){
        $(".modal").fadeOut(300);

    });
        var id = $(this).attr('data-id');
        //var listItems = '';
        //console.log(id);
        $.ajax({
            url: '/tablero/Hoteles/Admin/edit/' + id,
            type: 'GET',
            dataType: 'json',
            data: {id:id},
            /*success:function(data){
                   
            }*/
        })
        .done(function(data) {
            //console.log("success");
            
            var categorias = data.categorias;
            var destinos = data.destinos;
            var cate = data.hotel[0].categoria_id;
            var dest = data.hotel[0].destino_id;
                    console.log(data);
                    console.log(data.hotel);
                    console.log(data.hotel[0].categoria_id);

                $("#modal_hot").fadeIn(300);
                $(".modal-body #id").val(id);
                var listItems = '<option selected="selected" value="">Seleccione...</option>';
                $.each(categorias, function(elemento, indice){
                     //console.log(elemento, indice);
                     //$('.modal-body #categoria_id').append('<option value="' + indice.id + '">' + indice.nombre + '</option>');
                    if(cate == indice.id)
                        listItems += "<option selected value='" + indice.id + "'>" + indice.nombre + "</option>";
                    else
                        listItems += "<option value='" + indice.id + "'>" + indice.nombre + "</option>";
                })
                $('.modal-body #categoria_id').html(listItems);
                $('.modal-body #categoria_id').select2();
                $(".modal-body #nombre").val(data.hotel[0].nombre);
                $(".modal-body #estrella").val(data.hotel[0].estrella);
                //DESTINO
                $.each(destinos, function(elemento, indice){
                    //$(".modal-body #destino_id").append('<option value="' +indice.id+ '">' + indice.nombre +'</option>');
                    if(dest == indice.id)
                        listItems += "<option selected value='" + indice.id + "'>" + indice.nombre + "</option>";
                    else
                        listItems += "<option value='" + indice.id + "'>" + indice.nombre + "</option>";
                })
                $(".modal-body #destino_id").html(listItems);
                $(".modal-body #destino_id").select2();
                $(".modal-body #check_in").val(data.hotel[0].check_in);
                $(".modal-body #check_out").val(data.hotel[0].check_out);
                $(".modal-body #enlace").val(data.hotel[0].enlace);
                $(".modal-body #p_swb").val(data.hotel[0].p_swb);
                $(".modal-body #p_dwb").val(data.hotel[0].p_dwb);
                $(".modal-body #p_tpl").val(data.hotel[0].p_tpl);
                $(".modal-body #p_chd").val(data.hotel[0].p_chd);
                $(".modal-body #p_sj").val(data.hotel[0].p_sj);
                $(".modal-body #p_s").val(data.hotel[0].p_s);
                $(".modal-body #e_swb").val(data.hotel[0].e_swb);
                $(".modal-body #e_dwb").val(data.hotel[0].e_dwb);
                $(".modal-body #e_tpl").val(data.hotel[0].e_tpl);
                $(".modal-body #e_chd").val(data.hotel[0].e_chd);
                $(".modal-body #e_sj").val(data.hotel[0].e_sj);
                $(".modal-body #e_s").val(data.hotel[0].e_s);
             
           
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    });
    $('button[id=serve]').on('click', function() {
        var id = $(this).attr('data-id');
        //alert(id);
        $("#modal_hotel").fadeIn(300);
    
    });
    $("input[name=view]").click(function(){
        alert("hola");
    })
    $('input[name=prueba]').on('click', function() {
        var id = $(this).val();
        alert(id);
    //$('.dele-in').on('click', function () {
        //var id = $(this).attr('data-id');
    });
   });
</script>
@endsection
@endsection

@push('scripts')
<script src="{{--asset('js\hoteles\index.js') --}}"></script>

@endpush




