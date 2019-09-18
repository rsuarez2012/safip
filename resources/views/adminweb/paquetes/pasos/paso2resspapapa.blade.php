@extends('layouts.master')
@section('titulo', 'Hoteles Paquete - Paso 2')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pasos_paquetes.css') }}">
    <style type="text/css">
        .chosen-container-multi .chosen-choices li.search-field input[type="text"] {
            height: 31px;
        }
        .chosen-container .chosen-results li.group-result {
                display: list-item;
                font-weight: bold;
                cursor: default;
        }
    </style>
@endsection
@section('content')
<div class="row" id="paso2">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="x_title">
                {{-- AGREGAR DESTINOS     --}}
                    <div class="col-xs-12 table-responsive">
                        <div class="box">
                            <div class="box-header">
                                <div class="col-xs-4">
                                    <h3><i class="fa fa-map-signs"></i> Configuración del Paquete</h3>
                                </div>
                                <a href="{{route('manageProduct-A')}}"
                                    class="btn btn-danger pull-right">
                                    <i class="fa fa-arrow-circle-left"></i> Volver
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="col-xs-4">
                                    <label>Desea agregar Hotel.?</label>
                                    <select class="form-control" @change="view_hotels"
                                            :disabled="!click_ver_hoteles && (new_destiny_without_hotels && new_destiny_with_hotels)">
                                        <option value="">Seleccione su opción</option>

                                        <option value="" v-show="!ver_hoteles">SI</option>
                                        <option value="" v-show="ver_hoteles">NO</option>
                                    </select>
                                    {{--<button class="btn btn-danger btn-sm form-control"
                                            @click.prevent="view_hotels"
                                            :disabled="!click_ver_hoteles && (new_destiny_without_hotels && new_destiny_with_hotels)">
                                        <i class="fa fa-plus-circle" v-show="!ver_hoteles"></i>
                                        <i class="fa fa-minus-circle" v-show="ver_hoteles"></i>
                                        <span v-show="ver_hoteles">No</span>
                                        <span v-show="!ver_hoteles">Si</span>
                                    </button>--}}
                                </div>
                                <div class="col-xs-3">
                                    <label class="">Dias de hospedaje: </label>
                                    <input v-model="noches"
                                            type="number"
                                            class="form-control"
                                            placeholder="Cantidad de Noches"
                                            :disabled="!ver_hoteles" id="no">
                                        {{--$paquete--}}
                                        {{--$destinos[0]->hoteles--}}

                                        
                                </div>
                                <div class="col-xs-3">
                                    <label class="">Destino del paquete</label>
                                    
                                    <input type="hidden" value="{{$paquete->id}}" name="id" id="paquete_id">
                                    <select id="destino" class="form-control">
                                        <option value="">Seleccione un Destino</option>
                                        <option class="item"
                                                v-for="destino in destinos" 
                                                :value="destino.id">
                                                @{{destino.nombre}}
                                        </option>
                                    </select>
                                    <div class="side-by-side clearfix">
                                        <div>
                                    <select name="destinos[]" data-placeholder="Seleccione el Destino y hotel" class="form-control chosen-select" multiple id="destino" tabindex="5">
                                        @foreach($destinos as $destino)
                                            <option value=""></option>
                                            <optgroup label="{{$destino->nombre.''.$destino->id}}">
                                                @foreach($destino->hoteles as $hotel)
                                                    {{--<option value="{{$destino->id.'_'.$hotel->id}}">{{$hotel->nombre.' '.$hotel->id}}</option>--}}
        <option value="{{$hotel->destino_id}}_{{$hotel->id}}">{{$hotel->nombre.' '.$hotel->id}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    {{----}}
                                </div>
                                <div class="col-xs-2">
                                    <div class="clearfix"></div>
                                    <br>
                                    <button class="btn btn-danger pull-right" @click.prevent="agregar_destino" id="add">
                                        <i class="fa fa-plus-circle"></i> Agregar
                                    </button>
                                    <button class="btn btn-danger pull-right" id="addD">
                                        <i class="fa fa-plus-circle"></i>1 Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{--<table class="table box" style="box-shadow: 5px 5px 5px #ddd">
                            <tr>
                                <td class="col-xs-2" style="text-align: center;">
                                    
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    
                                    <div class="clearfix"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="pull-right">Desea agregar Hotel.?</label>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm"
                                            @click.prevent="view_hotels"
                                            :disabled="!click_ver_hoteles && (new_destiny_without_hotels && new_destiny_with_hotels)">
                                        <i class="fa fa-plus-circle" v-show="!ver_hoteles"></i>
                                        <i class="fa fa-minus-circle" v-show="ver_hoteles"></i>
                                        <span v-show="ver_hoteles">No</span>
                                        <span v-show="!ver_hoteles">Si</span>
                                    </button>
                                </td>
                                <td class="col-xs-3" style="text-align: center;">
                                    <label class="pull-right">Dias de hospedaje: </label>
                                </td>
                                <td class="col-xs-3">
                                    <input v-model="noches"
                                            type="number"
                                            class="form-control"
                                            placeholder="Cantidad de Noches"
                                            :disabled="!ver_hoteles">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: center;">
                                    <label class="">Destino del paquete</label>
                                </td>
                                <td>
                                    <input type="hidden" value="{{$paquete->id}}" name="id" id="paquete_id">
                                    <select id="destino" class="form-control select2">
                                        <option value="">Seleccione un Destino</option>
                                        <option class="item"
                                                v-for="destino in destinos" 
                                                :value="destino.id">
                                                @{{destino.nombre}}
                                        </option>
                                    </select>
                                </td>
                                <td class="col-xs-3">
                                    <button class="btn btn-danger pull-right" @click.prevent="agregar_destino">
                                        <i class="fa fa-plus-circle"></i> Agregar
                                    </button>
                                    
                                </td>
                            </tr>--}}
                            {{--<tr>
                                <td  class="col-xs-2">
                                    <button class="btn btn-danger"
                                            @click.prevent="view_hotels"
                                            :disabled="!click_ver_hoteles && (new_destiny_without_hotels && new_destiny_with_hotels)">
                                        <i class="fa fa-plus-circle" v-show="!ver_hoteles"></i>
                                        <i class="fa fa-minus-circle" v-show="ver_hoteles"></i>
                                        <span v-show="ver_hoteles">Sin Hoteles</span>
                                        <span v-show="!ver_hoteles">Con Hoteles</span>
                                    </button>
                                </td>

                                <td class="col-xs-2">
                                    <input v-model="noches"
                                            type="number"
                                            class="form-control"
                                            placeholder="Cantidad de Noches"
                                            :disabled="!ver_hoteles">
                                </td>
                                <td class="col-xs-3">
                                    <input type="hidden" value="{{$paquete->id}}" name="id" id="paquete_id">
                                    <select id="destino" class="form-control select2">
                                        <option value="">Seleccione un Destino</option>
                                        <option class="item"
                                                v-for="destino in destinos" 
                                                :value="destino.id">
                                                @{{destino.nombre}}
                                        </option>
                                    </select>
                                </td>
                                <td class="col-xs-3">
                                    <button class="btn btn-danger" @click.prevent="agregar_destino">
                                        <i class="fa fa-plus-circle"></i> Agregar
                                    </button>
                                    
                                </td>
                            </tr>--}}
                        {{--</table>--}}
                    </div>
                {{-- FIN AGREGAR DESTINOS   --}}
                </div>
            </div>

            {{--<div class="box-body" v-show="!ver_hoteles && new_destiny_without_hotels">
                <div class="box" style="overflow-x: auto;white-space: nowrap;box-shadow: 5px 5px 5px #ddd;" >
                    <div class="col-md-4">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Destinos</th>
                                    <th>
                                        Acción
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="destinoPaquete of listados">
                                    <td v-text="destinoPaquete.destino.nombre.toUpperCase()"></td>
                                    <td>
                                        <a @click.prevent="eliminar_destino(destinoPaquete.id)" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-8">
                        <a v-if="!edit"
                            @click="next_step"
                            class="btn btn-danger pull-right"
                            style="margin-top: 1%;">Siguiente 
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>--}}
            {{-- LISTA DE HOTELES POR DESTINO --}}
            <div class="box-body" v-show="listados.length > 0 && ver_hoteles && new_destiny_with_hotels">
                {{-- @if(count($paquete->listados)>0) --}}
                <div class="box" v-show="btn_enlazar || !edit">
                    <div class="box-header">
                        <button class="btn btn-danger" @click.prevent="enlazar" v-show="btn_enlazar">
                            <i class="fa fa-exchange"></i> Enlazar
                        </button>
                        <a v-if="!edit"
                            @click="next_step"
                            class="btn btn-danger pull-right">Siguiente 
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="box" style="overflow-x: auto;white-space: nowrap;box-shadow: 5px 5px 5px #ddd;" v-show="listados.length > 0">
                    <div class="box-body box-lista-hoteles">
                        <div class="nav-tabs-custom  tab-danger">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab">Hoteles Para Enlazar</a></li>
                                <li>
                                    <a id="hoteles_tab" href="#tab_2" data-toggle="tab" onclick="paso2.calculos_enlazados" @click="act_inp_dft_check">Hoteles Enlazados</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row" style="overflow-x: scroll;overflow: auto;">
                                        <div class="col-md-6" v-for="destinoPaquete of listados">
                                            <table class="table table-bordered table-hover tabla_destinos">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                            <button class="btn btn-danger btn-xs"
                                                                    @click="active_multi(destinoPaquete, 'todos')">Todos
                                                            </button>
                                                        </th>
                                                        <th class="text-center">
                                                            Hoteles en @{{ destinoPaquete.destino.nombre.toUpperCase() }}
                                                        </th>
                                                        <th>
                                                            Noches: @{{ destinoPaquete.noches.cantidad }}
                                                        </th>
                                                        <th>
                                                            <a @click.prevent="eliminar_destino(destinoPaquete.id)" class="btn btn-danger btn-xs">
                                                                <i class="fa fa-trash"></i> Eliminar @{{ destinoPaquete.destino.nombre.toUpperCase() }}
                                                            </a>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input  type="checkbox"
                                                                    :id="'s_multi_padre_'+destinoPaquete.id"
                                                                    @change="active_multi(destinoPaquete, 'ind')"
                                                                    value=""> SM
                                                        </td>
                                                        <th>Nombre</th>
                                                        <th>*</th>
                                                        <th>Categoria</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <tr v-for="hotel in destinoPaquete.destino.hoteles" class="tr_hotel">
                                                        <td>
                                                           <input   type="checkbox"
                                                                    :class="'check_hijo_'+destinoPaquete.id"
                                                                    @change="validate"
                                                                    v-model="multi_selected"
                                                                    :value="hotel.id"
                                                                    style="display:none;">

                                                           <input   type="radio"
                                                                    :class="'radio_hijo_'+destinoPaquete.id"
                                                                    @change="set_destinos_selected(destinoPaquete.id,hotel.id, destinoPaquete.noche_id)"
                                                                    :name="'hotel_'+destinoPaquete.destino.nombre"
                                                                    style="display:''">
                                                        </td>
                                                        <td v-text="hotel.nombre"></td>
                                                        <td v-text="hotel.estrella"></td>
                                                        <td v-text="hotel.categoria.nombre"></td>
                                                   </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_2">
                                    {{-- AQUI VA LA TABLA DE LOS HOTELES ENLAZADOS --}}
                                    <datatable :enlazados="enlazados"></datatable>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @endif --}}
            </div>
            {{--FIN LISTA DE HOTELES POR DESTINO --}}
        </div>
    </div>
</div>
<template id="datatable">
    <div>
        <span class="titlepageSize">Cant. de Registros en la lista</span>
        <select v-model="pageSize" @change="changeSelect()" class="pageSize">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="500">500</option>
        </select>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th colspan="2"></th>
                    <th colspan="4" class="text-center">PERUANO</th>
                    <th colspan="4" class="text-center">EXTRANJERO</th>
                    <th class="text-center">ACCIONES</th>
                </tr>
                <tr>
                    <th>Hoteles{{--  en <span> / </span> --}}</th>
                    <th>*</th>
                    <th>Simple</th>
                    <th>Doble</th>
                    <th>Triple</th>
                    <th>Cuadruple</th>
                    <th>Simple</th>
                    <th>Doble</th>
                    <th>Triple</th>
                    <th>Cuadruple</th>
                    <th>
                        <button type="button"
                                data-toggle="tooltip"
                                data-placement="left"
                                title="Eliminar Todos"
                                class="btn btn-danger btn-xs"
                                @click.prevent="quitar_enlace('todos')">
                            <i class="fa fa-close"></i>
                            Todos
                        </button>
                        <button type="button"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Quitar Todos Destacados"
                                class="btn btn-warning btn-xs pull-right"
                                @click.prevent="clear_all"
                                :disabled="destacados.length == 0">
                            <i class="fa fa-ban"></i>
                        </button>
                        <button type="button"
                                id="cinco_destacados"
                                style="margin-right: 12px;"
                                class="btn btn-warning btn-xs pull-right"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="Destacados 5 primeros hoteles"
                                @click.prevent="set_cinco_primeros"
                                :disabled="destacados.length >= 5">
                            <i class="fa fa-star"></i>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="enlazado in orderedList">
                    <td>
                        <span v-for="hotel in enlazado.hoteles">@{{hotel}} / </span>
                    </td>
                    <td v-text="enlazado.star"></td>
                    <td>@{{Math.round(enlazado.p_swb * 100) / 100 }}</td>
                    <td>@{{Math.round(enlazado.p_dwb * 100) / 100 }}</td>
                    <td>@{{Math.round(enlazado.p_tpl * 100) / 100 }}</td>
                    <td>@{{Math.round(enlazado.p_chd * 100) / 100 }}</td>
                    <td>@{{Math.round(enlazado.e_swb * 100) / 100 }}</td>
                    <td>@{{Math.round(enlazado.e_dwb * 100) / 100 }}</td>
                    <td>@{{Math.round(enlazado.e_tpl * 100) / 100 }}</td>
                    <td>@{{Math.round(enlazado.e_chd * 100) / 100 }}</td>
                    <td>
                        <button type="button"
                                class="btn btn-danger btn-xs"
                                @click.prevent="quitar_enlace(enlazado.codigo)">
                            <i class="fa fa-close"></i>
                        </button>
                        <input  type="checkbox"
                                class="pull-right ckeck_hijos"
                                :id="'check_hijo_dest_'+enlazado.codigo"
                                v-model="destacados"
                                :value="enlazado.codigo"
                                @change="set_destacados(enlazado.codigo)"
                                {{-- :disabled="destacados.length >= 5" --}}>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pager">
            <button type="button"
                    class="btn btn-danger btn-xs"
                    @click="previousPage"
                    :disabled="currentPage <= 1">
                <i class="fa fa-angle-left"></i>
                Anterior
            </button>
            Página @{{currentPage}} de @{{totalPage}}
            <button type="button"
                    class="btn btn-danger btn-xs"
                    @click="nextPage"
                    :disabled="totalPage <= 1 || currentPage == totalPage">
                    Siguiente
                <i class="fa fa-angle-right"></i>
            </button>
        </div>
    </div>
</template>
@endsection


@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.chosen-select').chosen(
            {
                allow_single_deselect: true,
                //max_selected_options: 3,
            }
        );    
        /*$("#chosen-select").bind("chosen:maxselected", function () {
            alert("Máximo número de elementos seleccionado")
        });          QUEDE EN CAMBIAR LOS DESTINOS CUAN NO TENGAN HOTELES*/
        //$('#addD').on('click', function () {
        $('.chosen-select').on('change', function () {
            // body...
            //alert("Máximo");
            //var destino = $(".chosen-select").chosen().val();
            var destino = $(this).chosen().val();
            var noche = $('#no').val();
            //console.log("Cantidad de dia: "+noche);
            //console.log(destino.length);
            console.log(destino);
            let desti = [
                {
                    id:"0"
                },
            ];
            let dests = [];
            let hots  = [{"destino_id":"","hotel":""}];
            const elementExist = (desti, value) => {
                let i = 0;
                while (i < desti.length){
                    if(desti[i].id == value) return i;
                    i++;
                }
                return false;
            }
            destino.forEach(function(destino, index){

                console.log(destino);
                var separador = "_";
                valores = destino.split(separador);
                console.log("Destinos " + valores[0] + " Hotel "+ valores[1]);
                //let i = elementExist(dests);
                var i = false;
                hots.push({"destino_id":valores[0],"hotel":valores[1]});
                if($.inArray(valores[0],dests)==-1){
                    dests.push(valores[0]);
                }else{
                    console.log("existe");
                }
                /*if(i === false){
                    dests.push({
                        'id':valores[0]
                    });
                }else{
                    dests[i].id.push(valores[0]);
                }*/
                console.log(dests.includes(valores[0]));
            });
            console.log("destinos " + dests.toString());
            console.log("hoteles " + hots);
            $('#hoteles').html(hots);

            //var ob = valores.splice(separador)[0];
            //var o = ob.slice(separador)

            //valores1 = destino.split(separador);

    //var myarray = SplitArray(cadena,4);
    //      
            
           /* $.ajax({
                url:'/Paso/2/load/destinos',
                type:'post',
                success: function(data){
                    response(data);
                    console.log(data);
                }
            }); */     

        })
    /*function SplitArray(cadena. tope){
        var myarray = new Array(tope);
        myarray[0] = "";
        var j=0;
        $.each(cadena, function(i, valor){
            if(valor==","){
                j++;myarray[j]="";
            }else{
                myarray[j]=myarray[j]+valor;
            }
        });
        return myarray;
    }*/
    });
</script>
<script>
    /* $(function () {
        $(".select2").select2();
    }); */
    $(function () {
        $(".tabla_destinos").DataTable({
            "ordering": true,
            "autoWidth": false
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false
        });
    });
    let paquete_act = {!! $paquete !!};
</script>
@if ($edit)
    <script>
        let edit = true;
    </script>
@else
    <script>
        let edit = false;
    </script>
@endif
<script src="{{asset('js/paquetes/paso2.js')}}"></script>

@endpush

