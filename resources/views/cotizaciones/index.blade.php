@extends('layouts.master')

@section('titulo', 'Cotizaciones | Boletos')

@section('css')
  <!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
 <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box" id="cotizaciones">
            <div class="box-header with-border">
                <h2 class="box-title" style="font-size: 24px;"><i class="fa fa-ticket"></i> Administración de Cotizaciones</h2>
            </div>
            <div class="box-body">
                <div class="x_content">
                    @if(Session::has('message'))
                        <div class='alert alert-success'>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <p>{!! Session::get('message') !!}</p>
                        </div>
                    @elseif(Session::has('message2'))
                        <div class='alert alert-danger'>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <p>{!! Session::get('message2') !!}</p>
                        </div>
                    @endif
                </div>
                <div class="nav-tabs-custom  tab-danger">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1" data-toggle="tab">Cotización de Boletos</a>
                        </li>
                        <li>
                            <a id="hoteles_tab" href="#tab_2" data-toggle="tab">Cotización de Paquetes</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="fecha_d">Desde:</label>
                                            <input type="date" v-model="fecha_d" class="form-control" id="fecha_d" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="fecha_h">Hasta:</label>
                                            <input type="date" v-model="fecha_h" class="form-control" id="fecha_h" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-1" style="padding-top:2%;">
                                        <button type="submit"
                                                style="padding: 7px; margin-left: 7%;"
                                                class="btn btn-warning btn-xs btn"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Filtrar por fecha"
                                                data-original-title="Filtrar por fecha"
                                                @click="search_filter_cboletos">
                                                <i class="fa fas fa-calendar" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-7" style="padding-top:2%;">
                                        <button class="btn btn-danger"
                                                @click.prevent="edit_multi"
                                                v-show="btn_editar_multi">
                                            <i class="fa fa-edit"></i> Editar Seleccionados
                                        </button>
                                        <button class="btn btn-grey"
                                                @click.prevent="clean_multi"
                                                v-show="multi_selected.length > 0">
                                            <i class="fa fa-close"></i> Limpiar Seleccionados
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <c_boletos_datatable :c_boletos="c_boletos" v-if="c_boletos.length > 0"></c_boletos_datatable>
                            <div v-else class="alert alert-block alert-info" style="margin-top: 44px;">
                                <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                                <p class="margin-bottom-10">
                                    Actualmente no existen cotizaciones de Boletos
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <c_paquetes_datatable :c_paquetes="c_paquetes" v-if="c_paquetes.length > 0"></c_paquetes_datatable>
                            <div v-else class="alert alert-block alert-info" style="margin-top: 44px;">
                                <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                                <p class="margin-bottom-10">
                                    Actualmente no existen cotizaciones de paquetes
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <!-- MODAL SELECCIONAR PROVEEDOR-->
                @include('cotizaciones.formulario.procesar')

                {{-- MODAL DE COTIZACIONES  --}}
                @include('cotizaciones.formulario.editar_c_boleto')
                @include('cotizaciones.formulario.editar_c_boletos')
                @include('cotizaciones.formulario.editar_c_paquete')
        </div>
        <template id="c_boletos_datatable">
            <div>
                <span class="titlepageSize">Cant. de Registros en la lista</span>
                <select v-model="pageSize" @change="changeSelect()" class="pageSize">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select>
                <div class="pull-right" style="margin-bottom: 10px;margin-top: 5px;">
                    <input type="text" v-model.trim="search" placeholder="Escriba para filtrar" class="form-control">
                </div>
                <table class="table table-bordered table-hover">
                    <thead class="table-danger">
                        <tr>
                            <th>SM</th>
                            <th >NRO COTIZACION</th>
                            <th >AGENCIA DE VIAJE</th>
                            <th  >CIUDAD SALIDA</th>
                            <th class="col-md-1">CIUDAD LLEGADA</th>
                            <th class="col-md-1">FECHA SALIDA</th>
                            <th class="col-md-1">FECHA LLEGADA</th>
                            <th class="col-md-1">TIPO DE BOLETO</th>
                            <th class="col-md-1">CANT. PASAJEROS</th>
                            <th class="col-md-1">ESTADO DE BOLETO</th>
                            <th >OBSERVACION</th>
                            <th class="col-md-1">FECHA CREACION</th>
                            <th >VENDEDOR</th>
                            <th class="col-md-1">FECHA EDICION</th>
                            <th class="col-md-2">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(c_boleto, index) in c_boletos_list">
                            <td>
                                <input   type="checkbox"
                                    class="check_cot"
                                    @change="validate"
                                    v-model="multi_selected"
                                    :value="c_boleto.id">
                                <input type="hidden" :id="c_boleto.id" :value="index">
                            </td>
                            <td v-text="c_boleto.count"></td>
                            <td>
                                <span   v-if="c_boleto.aviajes != null"
                                        v-text="c_boleto.aviajes.nombre"
                                        :id="'aviaje_'+c_boleto.id"></span>
                                <span v-else>Esta Agencia de Viajes ya no existe</span>
                            </td>
                            <td v-text="c_boleto.d_ciudad_id" :id="'c_salida_'+c_boleto.id"></td>
                            <td v-text="c_boleto.h_ciudad_id" :id="'c_llegada_'+c_boleto.id"></td>
                            <td v-text="c_boleto.salida_at" :id="'fecha_salida_'+c_boleto.id"></td>
                            <td v-text="c_boleto.llegada_at" :id="'fecha_retorno_'+c_boleto.id"></td>
                            <td>
                                <span v-if="c_boleto.ida_vuelta == 0" :id="'s_ida_'+c_boleto.id" class="mayus">Solo Ida</span>
                                <span v-else :id="'ida_v_'+c_boleto.id" class="mayus">Ida y Vuelta</span>
                            </td>
                            <td v-text="c_boleto.cantidad_pasajeros" :id="'pasajeros_'+c_boleto.id"></td>
                            <td>
                                <span class="label label-success" v-if="c_boleto.status == 1">Procesado</span>
                                <span class="label label-danger" v-else>Sin Procesar</span>
                            </td>
                            <td v-text="c_boleto.observacion" :id="'observacion_'+c_boleto.id" class="mayus"></td>
                            <td v-text="c_boleto.created_at.split(' ')[0]"></td>
                            <td>
                                <span v-if="c_boleto.users != null && c_boleto.users.nombres != ''" v-text="c_boleto.users.nombres+' '+c_boleto.users.apellidos" class="mayus"></span>
                                <span v-else>Este Usuario ya no existe</span>
                            </td>
                            <td v-text="c_boleto.updated_at.split(' ')[0]"></td>
                            <td>
                                <a  v-if="c_boleto.status != 1"
                                    class="btn btn-success btn-xs"
                                    :href="route+'/tablero/cotizaciones/admin/procesar/'+c_boleto.id"
                                    data-toggle="tooltip"
                                    data-placement="left"
                                    title="Procesar">
                                    <i class="fa fa-check-circle-o"></i>
                                </a>
                                <a  class="btn btn-warning btn-xs"
                                    data-toggle="tooltip"
                                    data-placement="left"
                                    @click="modalShow('modalEditarCBoleto', c_boleto)"
                                    title="Editar">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                                @if(Auth::user()->role == "Administrador")
                                    <a  class="btn btn-danger btn-xs"
                                        :href="route+'/tablero/cotizaciones/admin/anulado/'+c_boleto.count"
                                        data-toggle="tooltip"
                                        data-placement="left"
                                        title="Anular">
                                        <i class="fa fa-minus-square"></i>
                                    </a>
                                @endif
                                <a  class="btn btn-danger btn-xs"
                                    :href="route+'/tablero/cotizaciones/admin/destroy/'+c_boleto.id"
                                    data-toggle="tooltip"
                                    data-placement="left"
                                    title="Eliminar">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
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
        <template id="c_paquetes_datatable">
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
                            <th>N° Cotizacion</th>
                            <th>Agencia de Viajes</th>
                            {{-- <th>Pais</th> --}}
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
                        <tr v-for="c_paquete in c_paquetes_list">
                            <td class="text-center text-bold" v-text="c_paquete.id"></td>
                            <td v-text="c_paquete.agencia.nombre"></td>
                            {{-- <td v-text="c_paquete.pais.paisnombre"></td> --}}
                            <td v-text="c_paquete.destino.nombre"></td>
                            <td v-text="c_paquete.nacionalidad" class="mayus"></td>
                            <td v-text="c_paquete.fecha_salida"></td>
                            <td v-text="c_paquete.fecha_retorno"></td>
                            <td v-text="c_paquete.pasajero" class="text-center"></td>
                            <td class="text-center">
                                <label v-if="c_paquete.estado == 'procesado'" class="label label-success">Procesado</label>
                                <label v-if="c_paquete.estado == 'por_procesar'" class="label label-danger">Por Procesar</label>
                                <label v-if="c_paquete.estado == 'anulado'" class="label label-warning">Anulado</label>
                            </td>
                            <td v-text="c_paquete.observacion" class="mayus"></td>
                            <td v-text="c_paquete.created_at.split(' ')[0]"></td>
                            <td v-text="c_paquete.vendedor.nombres"></td>
                            <td v-text="c_paquete.updated_at.split(' ')[0]"></td>
                            <td>
                                <a  v-if="c_paquete.estado == 'procesado'"
                                    @click.prevent="anular_c_paquete(c_paquete.id)"
                                    class="btn btn-danger btn-xs"
                                    title="Anular Cotizacion"
                                    data-toggle="tooltip">
                                    <i class="fa fa-close"></i>
                                </a>
                                <button v-if="c_paquete.estado == 'por_procesar'"
                                        :value="c_paquete.id"
                                        class="btn btn-success btn-xs "
                                        title="procesar cotizacion"
                                        @click="modalShow('modalProcesar', c_paquete)"
                                        data-toggle="tooltip">
                                        <i class="fa fa-check-square-o "></i>
                                </button>
                                <button v-if="c_paquete.estado == 'por_procesar'"
                                        :value="c_paquete.id"
                                        class="editarCotizacion btn btn-warning btn-xs"
                                        title="editar cotizacion"
                                        @click="modalShow('modalEditarCPaquete', c_paquete)"
                                        data-toggle="tooltip">
                                        <i class="fa fa-pencil "></i>
                                </button>
                                <label v-if="c_paquete.estado == 'anulado'" class="label label-warning">Anulado</label>
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
                            :disabled="totalPage <= 1 || currentPage == totalPage || block">
                            Siguiente
                        <i class="fa fa-angle-right"></i>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection

@push('scripts')
    <script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/dataTables.bootstrap.js")!!}></script>
<script>
    $(function () {
        $(function () {
            $('.cotiza').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "lengthMenu": [ 50,100, 200, 500],
                "autoWidth": true
            });
        });
    });
</script>
<script src="{{asset('js/cotizaciones/index.js')}}"></script>

@endpush

