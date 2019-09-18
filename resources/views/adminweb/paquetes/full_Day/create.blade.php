@extends('layouts.master')
@section('titulo', 'Paquetes Full Day')

@push('css')
    <style>
        .botonera_paso1 > button{
            margin-top: 9%;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/pasos_paquetes.css') }}">  
@endpush

@section('content')
    <div class="row" id="fullday">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="box">
                        <div class="box-header with-border">
                            <h1 id="new_paquete" class="box-title" style="font-size: 24px;">Nuevo Paquete Full Day</h1>
                            <h1 id="old_paquete" style="display:none;font-size: 24px;margin-top: 0;margin-bottom: 0;"></h1>
                            <div class="box-tools pull-right">
                                {{--<a href="{{ route('full_day.index') }}"
                                    class="btn btn-danger">
                                    <i class="fa fa-reply"></i> Volver
                                </a>--}}
                                <a href="{{ route('manageProduct-A') }}"
                                    class="btn btn-danger">
                                    <i class="fa fa-reply"></i> Volver
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Datos Basicos</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" id="paquete_id" value="{{$paquete_id}}">
                                <input type="hidden" id="categoria_id" value="{{$categoria_id}}">
                                <div class="col-sm-3 form-group">
                                    <label>Codigo Paquete</label>
                                    <input :disabled="paso != 1 || basic_data.validated"
                                            v-model.trim="basic_data.codigo"
                                            class="form-control" 
                                            type="text"
                                            placeholder="Codigo">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label>Nombre Paquete</label>
                                    <input class="form-control"
                                            v-model.trim="basic_data.nombre"
                                            type="text"
                                            placeholder="Nombre">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label>Imagen Paquete</label>
                                    <input class="form-control"
                                            @change="load_image($event)"
                                            type="file" accept="image/*">
                                </div>
                                <div class="col-sm-3 botonera_paso1">
                                    <button class="btn btn-danger pull-right" 
                                            v-if="!basic_data.validated"
                                            @click="code_validate">Validar Codigo
                                    </button>
                                    <button class="btn btn-danger pull-right"
                                            v-else-if="basic_data.validated && paso == 1"
                                            @click="save_paquete">Guardar
                                    </button>
                                    <button class="btn btn-danger pull-right"
                                            v-else
                                            @click="save_paquete">Actualizar
                                    </button>    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box" v-show="paso != 1">
                        <div class="box-header with-border">
                            <h3 class="box-title">Selección de Destinos</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                
                                <div class="col-md-5">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Destinos</th>
                                                <th style="text-align: center;">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="destinoPaquete of destinos_p">
                                                <td v-text="destinoPaquete.destino.nombre.toUpperCase()" style="text-align: center;"></td>
                                                <td>
                                                    <center>
                                                    <a @click.prevent="eliminar_destino(destinoPaquete.id)" class="btn btn-danger btn-xs">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </a>
                                                </center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-5">
                                    <select id="destino" class="form-control select2" style="width:100%">
                                        <option value="0" selected>Seleccione un Destino</option>
                                        <option class="item"
                                                v-for="destino in otros_destinos" 
                                                :value="destino.id">
                                                @{{destino.nombre}}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-danger"
                                            @click="agregar_destino">
                                        <i class="fa fa-plus-circle"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box" v-show="paso != 1  && paso != 2">
                        <div class="box-header with-border">
                            <h3 class="box-title">Selección de Servicios y Configuración de tarifas</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="nav-tabs-custom  tab-danger">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-sun-o"></i> Dia</a></li>
                                            <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-calendar"></i> Itinerario</a></li>
                                            <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-money"></i> Monto Neto</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">
                                                <div  class="row">
                                                    <div class="col-xs-12">
                                                        <button v-if="mi_dia.length != undefined"
                                                                @click="openModal('Crear', 'día')"
                                                                class="btn btn-danger pull-right">
                                                            <i class="fa fa-plus-circle"></i> Agregar Dia
                                                        </button>    
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="table-responsive" v-show="mi_dia.length == undefined">
                                                    <table class="table table-bordered">
                                                        <thead style="background-color: #dd4b39;">
                                                            <tr style="color: #fff">
                                                                <th class="col-xs-2">Imagen</th>
                                                                <th class="col-xs-1">Nombre</th>
                                                                <th class="col-xs-4">Descripción</th>
                                                                <th class="col-xs-1 text-center">Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <img width="120px" height="100" :src="route+'/storage/miniature/'+mi_dia.imagen" alt="La ruta de esta imagen no es valida">
                                                                </td>
                                                                <td class="text-center" v-text="mi_dia.nombre"></td>
                                                                <td v-text="mi_dia.descripcion"></td>
                                                                <td class="text-center">
                                                                    <button @click="show_modal_services"
                                                                            class="btn btn-primary btn-xs"
                                                                            title="Ver Actividades"
                                                                            data-toggle="tooltip">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </button>
                                                                    <button @click="openModal('Editar', 'día')"
                                                                            class="btn btn-warning btn-xs"
                                                                            title="Editar Dia"
                                                                            data-toggle="tooltip">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </button>
                                                                    <button @click="destroy_dia"
                                                                            class="btn btn-danger btn-xs"
                                                                            title="Eliminar Dia"
                                                                            data-toggle="tooltip">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_2">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="bg-head-tabla">
                                                            <tr>
                                                                <th>Actividad</th>
                                                                <th>Peruano Adulto</th>
                                                                <th>Extranjero Adulto</th>
                                                                <th>Comunidad Adulto</th>
                                                                <th>Niño Peruano</th>
                                                                <th>Niño Extranjero</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <tr  v-for="actividad in mi_dia.actividades">
                                                                    <td>@{{actividad.nombre}}</td>
                                                                    <template v-if="actividad.tipo == 'servicio'">
                                                                        <td>@{{actividad.servicio[0].servicio.peruano.adulto}}</td>
                                                                        <td>@{{actividad.servicio[0].servicio.extranjero.adulto}}</td>
                                                                        <td>@{{actividad.servicio[0].servicio.comunidad.adulto}}</td>
                                                                        <td>@{{actividad.servicio[0].servicio.peruano.ninio}}</td>
                                                                        <td>@{{actividad.servicio[0].servicio.extranjero.ninio}}</td>
                                                                    </template>    
                                                                    <template v-if="actividad.tipo == 'restaurante'">
                                                                        <td>@{{actividad.restaurante[0].restaurante.peruano.adulto}}</td>
                                                                        <td>@{{actividad.restaurante[0].restaurante.extranjero.adulto}}</td>
                                                                        <td>@{{actividad.restaurante[0].restaurante.comunidad.adulto}}</td>
                                                                        <td>@{{actividad.restaurante[0].restaurante.peruano.ninio}}</td>
                                                                        <td>@{{actividad.restaurante[0].restaurante.extranjero.ninio}}</td>
                                                                    </template>   
                                                                </tr>
                                                        </tbody>
                                                        <tfoot  class="bg-head-tabla">
                                                            <tr>
                                                                <td>TOTAL </td>
                                                                <td v-for="col in total_itinerary">
                                                                    @{{Math.round(col * 100) / 100}}
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_3">
                                                <div class="form-group  margin-inferior" v-show="mi_dia.length == undefined">
                                                    <label>Monto a Calcular </label>
                                                    <br>
                                                    <input style="width: 120px;float: left;margin-right: 1%"
                                                            class="form-control"
                                                            type="number"
                                                            step="0.01"
                                                            v-model="new_percent">
                                                    <button @click="calculate_new_promotion"
                                                            data-toggle="tooltip"
                                                            title="Calcular"
                                                            class="btn btn-danger"
                                                            style="margin-right: 20px;"
                                                            v-if="new_percent > 0">
                                                        <i class="fa fa-calculator"></i>
                                                    </button> 
                                                    <button class="btn btn-danger" @click="save_new_percent">
                                                        Publicar estos costos en web
                                                    </button>    
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="bg-head-tabla">
                                                            <tr>
                                                                <th></th>
                                                                <th>Peruano Adulto</th>
                                                                <th>Extranjero Adulto</th>
                                                                <th>Comunidad Adulto</th>
                                                                <th>Niño Peruano</th>
                                                                <th>Niño Extranjero</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot  class="bg-head-tabla">
                                                            <tr>
                                                                <td colspan="1">TOTAL </td>
                                                                <td v-for="col in total_itinerary">
                                                                    @{{Math.round(sum_new_percent(col) * 100) / 100}}
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-danger pull-right"
                                            v-if="mi_dia.length == undefined && mi_dia.actividades.length > 0"
                                            @click="seguir_finalizar">Seguir a Datos Adicionales
                                    </button>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        @include('adminweb.paquetes.full_Day.crear_dia')
        @include('adminweb.paquetes.full_Day.actividades')
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/paquetes/full_day.js') }}"></script>
@endpush