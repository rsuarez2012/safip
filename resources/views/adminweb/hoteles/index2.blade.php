@extends('layouts.master')
@section('titulo', 'Hoteles')

@section('content')
<div class="row" id="main-hoteles">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
              
                 <div class="col-md-8">
                        <div class="x_title">
                             <h3><i class="fa fa-hotel"></i> Hoteles</h3>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <div class="col-md-2" style="margin-top: 24px;">
                <button class="btn btn-success pull-right" @click="abrirModalCrear()" data-toggle="tooltip" data-placement="top" title=" Agregar Hotel"><i class="fa fa-plus"></i></button>
                <button class="btn btn-warning pull-right" style="margin-right: 1px;" onclick="main_de_categorias.abrirModalCategorias()" data-toggle="tooltip" data-placement="top" title="Categorias de Hotel"><i class="fa fa-list"></i> </button>
                </div>
            </div>
            <div class="box-body">
                {{-- <div class="container"> --}}
                    {{--<div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-2">
                            <select v-model="sort" class="form-control"  @change="getHoteles()">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-offset-8">
                            <input type="text"  class="form-control" v-model="search" @keyup="getHoteles()">
                        </div>
                    </div>--}}
                <!-- </div> -->
                               
                {{--<table class="table table-hover" id="tabla-hoteles">
                    <thead style="background-color: #dd4b39; color: #ffffff;">
                        <tr>
                            <th>Nombre</th>
                            <th>*</th>
                            <th>Categoria</th>
                            <th>Destino</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="hotel in hoteles">
                            <td>
                                
                                <a href="#" class="btn btn-default" id="raulid" v-bind:value="hotel.id">ver</a>
                            </td>
                            <td>@{{hotel.nombre}}</td>
                            <td>@{{hotel.estrella}}</td>
                            <td>@{{hotel.categoria.nombre}}</td>
                            <td>@{{hotel.destino.nombre}}</td>
                            <td>                                
                                <button data-toggle="tooltip" title="Ver y editar" @click="verHotel(hotel)" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></button>
                                <button data-toggle="tooltip" title="Servicios del Hotel" class="btn btn-info btn-xs raulid" id="raulid" v-bind:data-id="hotel.id"><i class="fa fa-eye"></i></button>
                                <button data-toggle="tooltip" title="Eliminar" @click="eliminarHotel(hotel.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li v-if="pagination.current_page > 1">
                            <a href="#" @click.prevent="changePage(pagination.current_page - 1)">
                                <span>Atras</span>
                            </a>
                        </li>
        
                        <li v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '']">
                            <a href="#" @click.prevent="changePage(page)">
                                @{{ page }}
                            </a>
                        </li>
        
                        <li v-if="pagination.current_page < pagination.last_page">
                            <a href="#" @click.prevent="changePage(pagination.current_page + 1)">
                                <span>Siguiente</span>
                            </a>
                        </li>
                    </ul>
                </nav>--}}
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>*</th>
                            <th>Categoria</th>
                            <th>Destino</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hotels as $hotel)
                        <tr>
                            <td>{{$hotel->nombre}}</td>
                            <td>{{$hotel->estrella}}</td>
                            <td>{{$hotel->categoria->nombre}}</td>
                            <td>{{$hotel->destino->nombre}}</td>
                            <td>
                                <button data-toggle="tooltip" title="Ver y editar"  class="btn btn-warning btn-xs" id="edit" data-id="{{$hotel->id}}"><i class="fa fa-edit" ></i></button>


                                <button data-toggle="tooltip" title="Servicios del Hotel" class="btn btn-info btn-xs" id="serve" data-id="{{$hotel->id}}"><i class="fa fa-eye"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('adminweb.hoteles.modals.create')
</div>
 @include('adminweb.hoteles.modals.categorias')
 <div id="modal_hot" class="modal" style="overflow: auto; ">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content" style="width: auto; margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Editar Hotel
                </h4>
                <button type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div> 
            <div class="modal-body">
                <form action="{{ url('/tablero/Hoteles/Admin/Update') }}" method="POST" id="">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" id="id" value="">
                <div class="row">
                    <div class="col-sm-3">
                        <label>Nombre Hotel</label>
                        <input placeholder="Nombre" type="text" class="form-control" id="nombre" name="nombre">
                    </div>
                    <div class="col-sm-3">
                        <label>*</label>
                        <input placeholder="Hostel" type="text" class="form-control" id="estrella" name="estrella">
                    </div>
                    <div class="col-sm-3">
                        <label>Categoria</label><br>
                        <select class="form-control" name="categoria_id" id="categoria_id">
                            <!--<option value="">Seleccione Una Opcion</option>-->
                        </select>
                    </div>  
                    <div class="col-sm-3">
                        <label>Destino</label><br>
                        <select class="form-control"  name="destino_id" id="destino_id">
                            <!--<option value="">Seleccione Una Opcion</option>-->
                        </select>
                    
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-sm-3">
                                <label>Check In</label>
                                <input type="time" class="form-control" id="check_in" name="check_in">
                            </div>
                            <div class="col-sm-3">
                                <label>Check Out</label>
                                <input type="time" class="form-control" id="check_out" name="check_out">
                            </div>
                            <div class="col-sm-3">
                                <label>Enlace</label>
                                <input placeholder="https://ejemplo.com" type="text" class="form-control" id="enlace" name="enlace">
                            </div>
                            
                        </div>
                    </div>
                </div> 
                <hr>
                <h4 class="text-center">Peruano</h4>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Simple</label> 
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_swb" name="p_swb">
                    </div>
                    <div class="col-sm-2">
                        <label>Doble</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_dwb" name="p_dwb">
                    </div>
                    <div class="col-sm-2">
                        <label>Triple</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_tpl" name="p_tpl">
                    </div>
                    <div class="col-sm-2">
                        <label>Cuadruple</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_chd" name="p_chd">
                    </div>
                    <div class="col-sm-2">
                        <label>Suite Junior</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_sj" name="p_sj">
                    </div>
                    <div class="col-sm-2">
                        <label>Suite</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_s" name="p_s">
                    </div>
                </div>
                <hr>
                <h4 class="text-center">Extranjero</h4>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Simple</label> 
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_swb" name="e_swb">
                    </div>
                    <div class="col-sm-2">
                        <label>Doble</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_dwb" name="e_dwb">
                    </div>
                    <div class="col-sm-2">
                        <label>Triple</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_tpl" name="e_tpl">
                    </div>
                    <div class="col-sm-2">
                        <label>Niño</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_chd" name="e_chd">
                    </div>
                    <div class="col-sm-2">
                        <label>Suite Junior</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_sj" name="e_sj">
                    </div>
                    <div class="col-sm-2">
                        <label>Suite</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_s" name="e_s">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-secondary pull-left" id="cerrar" data-dismiss="modal"><i class="fa fa-close"></i>Cerrar</button>
                <button type="submit" class="pull-right btn btn-danger"><i class="fa fa-save"></i> Guardar Cambios</div>
                </button>
            </div>
                </form>
        </div>
    </div>
</div>

@section('script')
<script src={!! asset( "admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset( "admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset( "admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<script type="text/javascript">
    
$(document).ready(function(){
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
<script src="{{asset('js\hoteles\index.js') }}"></script>

@endpush




