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
                <div class="col-md-4" style="margin-top: 24px;">
                    <button type="button" class="btn btn-success pull-right"  id="modal-crear"><i class="fa fa-plus"></i>Nuevo Hotel</button>
                    <!--onclick="main_de_categorias"-->
                    <button type="button" id="cat" class="btn btn-warning pull-right" style="margin-right: 1px;" data-toggle="tooltip" data-placement="top" title="Categorias de Hotel"><i class="fa fa-list"></i> Categorias</button>
                {{--<button class="btn btn-success pull-right" @click="abrirModalCrear()" data-toggle="tooltip" data-placement="top" title=" Agregar Hotel"><i class="fa fa-plus"></i></button>
                <button class="btn btn-warning pull-right" style="margin-right: 1px;" onclick="main_de_categorias.abrirModalCategorias()" data-toggle="tooltip" data-placement="top" title="Categorias de Hotel"><i class="fa fa-list"></i> </button>--}}
                </div>
            </div>
            <div class="box-body">
                <table class="table" id="table">
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
                        @foreach($hotels as $hotel)
                        <tr class="hote_id{{$hotel->id}}">
                            <td>{{$hotel->nombre}}</td>
                            <td>{{$hotel->estrella}}</td>
                            <td>{{$hotel->categoria->nombre}}</td>
                            <td>{{$hotel->destino->nombre}}</td>
                            <td>
                                <button data-toggle="tooltip" title="Ver y editar"  class="btn btn-warning btn-xs" id="edit" data-id="{{$hotel->id}}"><i class="fa fa-edit" ></i></button>


                                <a href="{{route('detalles_edit', $hotel->id)}}" data-toggle="tooltip" title="Servicios del Hotel" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>

                                <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" data-id="{{$hotel->id}}" id="dh"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('adminweb.hoteles.modals.create')
    @include('adminweb.hoteles.modals.detailHotel')
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
                        <input placeholder="Nombre" type="text" class="form-control" id="nombre" name="nombre" required="">
                    </div>
                    <div class="col-sm-3">
                        <label>*</label>
                        <input placeholder="Hostel" type="text" class="form-control" id="estrella" name="estrella" required="">
                    </div>
                    <div class="col-sm-3">
                        <label>Categoria</label><br>
                        <select class="form-control" name="categoria_id" id="categoria_id" required>
                            <!--<option value="">Seleccione Una Opcion</option>-->
                        </select>
                    </div>  
                    <div class="col-sm-3">
                        <label>Destino</label><br>
                        <select class="form-control"  name="destino_id" id="destino_id" required>
                            <!--<option value="">Seleccione Una Opcion</option>-->
                        </select>
                    
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-sm-3">
                                <label>Check In</label>
                                <input type="time" class="form-control" id="check_in" name="check_in" required>
                            </div>
                            <div class="col-sm-3">
                                <label>Check Out</label>
                                <input type="time" class="form-control" id="check_out" name="check_out" required>
                            </div>
                            <div class="col-sm-3">
                                <label>Enlace</label>
                                <input placeholder="https://ejemplo.com" type="text" class="form-control" id="enlace" name="enlace" required>
                            </div>
                            
                        </div>
                    </div>
                </div> 
                <hr>
                <h4 class="text-center">Peruano</h4>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Simple</label> 
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_swb" name="p_swb" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Doble</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_dwb" name="p_dwb" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Triple</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_tpl" name="p_tpl" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Cuadruple</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_chd" name="p_chd" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Suite Junior</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_sj" name="p_sj" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Suite</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="p_s" name="p_s" required>
                    </div>
                </div>
                <hr>
                <h4 class="text-center">Extranjero</h4>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Simple</label> 
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_swb" name="e_swb" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Doble</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_dwb" name="e_dwb" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Triple</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_tpl" name="e_tpl" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Niño</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_chd" name="e_chd" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Suite Junior</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_sj" name="e_sj" required>
                    </div>
                    <div class="col-sm-2">
                        <label>Suite</label>
                        <input type="number" placeholder="min 0" step="0.01" class="form-control" id="e_s" name="e_s" required>
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
{{--<script src={!! asset( "admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>--}}
<script type="text/javascript">
/*function closeModal(){
            $(".modal").fadeOut(300);
        }*/
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "lengthMenu": [ 50,100, 200, 500],
        "autoWidth": true
    });
    $('#table2').DataTable();
    /*$('button[id=cerrar]').on('click', function(){
        $(".modal").fadeOut(300);
        //$("#detail_hotel").fadeOut(300);


    });*/
    $('button[id=modal-crear]').on('click', function(){
        //alert("hello");
        $("#modal_hotel").fadeIn(300);
    });
    $("#categoria_id").select2();
    $("#destino_id").select2();
    $('body').on("click", "button[id=edit]", function(e) {
    //$('button[id=edit]').on('click', function(){
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
        $("#detail_hotel").fadeIn(300);
    
    });
    $("input[name=view]").click(function(){
        alert("hola");
    })
    $('button[id=cat]').on('click', function() {
        $.ajax({
            url: '/get/categorias/hoteles',
            type: 'GET',
            dataType: 'json',
            //data: {id:id},
            /*success:function(data){
                   
            }*/
        })
        .done(function(data){
            console.log(data);
            $("#modal-categorias").fadeIn(300);
            $('#tabla-categorias').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": true
            });
        //}, 6000);
        });
    });
    //addCategory
    $('button[id=ad]').on('click', function(){
        $('#addCategory').fadeIn(300);
    });
    $('button[id=delete-category]').on('click',function(event){
        var id = $(this).attr('data-id');
        confirm("Seguro desea eliminar esta categoria.?");
        $.ajax({
                type:'POST',
                url:'/tablero/Hoteles/Admin/Categoria/Delete/' + id,
                success: function(data, msg){
                    //$('#exito').delay(500).fadeIn('slow');
                    alert("Eliminado con exito.!");
                    $('.category_id'+id).remove();

                },
                error:function(data){
                    console.log('Error:', data);
                }
            })
        /*$.ajax({
                        url: '/tablero/Hoteles/Admin/Categoria/Delete/' + id,
                        type: 'POST',
                        //method:'DELETE',
                        dataType: 'json',
                        data: {
                            id:id,
                            //_method:method
                        },
                        success:function(data){
                            if(data.success){
                                event.preventDefault();
                                $('#modal-categorias').modal('hide');
                                alert("Exito!", "Categoria Eliminada", "success");
                            }
                            else{
                                console.log(error);
                            }
                               
                        }
                    });*/
        /*swal({
                title: "Seguro Que Quiere Elimar Esta categoria?",
                text: "Si elimina la categoria , se eliminaran todos los hoteles que tengan esta categoria.",
                icon: "warning",
                buttons: {
                    cancel: "No",
                    aceptar: {
                        text: "Si",
                        value: true,
                        className: "btn-danger"
                    },
                },
                dangerMode: true,
            }).then((acepted) => {
                if (acepted) {
                    $.ajax({
                        url: '/tablero/Hoteles/Admin/Categoria/Delete/' + id,
                        type: 'POST',
                        
                        dataType: 'json',
                        data: {
                            id:id,
                            
                        },
                        success:function(data){
                            if(data.success){
                                event.preventDefault();
                                $('#modal-categorias').modal('hide');
                                alert("Exito!", "Categoria Eliminada", "success");
                            }
                            else{
                                console.log(error);
                            }
                               
                        }
                    });*/
                    /*.done(function(data) {
                    });
                };
            });
        //alert(id);*/
    });
    $('#dh').on('click',function(){
        var id = $(this).attr('data-id');
        confirm("Seguro desea eliminar este  hotel.?");
        $.ajax({
                type:'POST',
                url:'/tablero/Hoteles/Admin/delete/' + id,
                success: function(data, msg){
                    //$('#exito').delay(500).fadeIn('slow');
                    alert("Eliminado con exito.!");
                    $('.hotel_id'+id).remove();

                },
                error:function(data){
                    console.log('Error:', data);
                }
            })
    })
    //modal-categorias
    $('button[id=cerrar]').on('click', function(){

        $(".modal").fadeOut(300);
        //$("#detail_hotel").fadeOut(300);
    });
    $('#cc').on('click',function(){
        $(".modal").fadeOut(300);
    })

   });
</script>
@endsection
@endsection




