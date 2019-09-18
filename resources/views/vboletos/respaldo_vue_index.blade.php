@extends('layouts.master')

@section('titulo', 'Vboletos')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box" id="venta_boletos">
                <div class="box-header with-border">
                    <h2 class="box-title" style="font-size: 24px;"><i class="fa fa-ticket"></i> Consultar Venta de boletos</h2>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_d">Desde:</label>
                                    <input type="date" v-model="fecha_d" class="form-control" id="fecha_d" value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_h">Hasta:</label>
                                    <input type="date" v-model="fecha_h" class="form-control" id="fecha_h" value="">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="submit"
                                        style="margin-top: 24px;padding: 7px; margin-left: 7%;"
                                        class="btn btn-warning btn-xs btn"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Filtrar por fecha"
                                        data-original-title="Filtrar por fecha"
                                        @click="load_vboletos">
                                    <i class="fa fas fa-calendar" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="col-md-4" style="padding-top:2%;">
                                <button class="btn btn-danger" id="btn_edit_sm" onclick="modal_edith_sm()" style="display:">
                                    <i class="fa fa-edit"></i> Editar Seleccionados
                                </button>
                                <button class="btn btn-grey" id="btn_clear_sm" onclick="clear_selected()" style="display:">
                                    <i class="fa fa-close"></i> Limpiar Seleccionados
                                </button>
                            </div>
                            <div class="col-md-1" style="padding-top: 5px;">
                                <button type=""
                                    style="margin-top: 24px;"
                                    class="btn btn-warning btn-sm btn abrirFiltro"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Filtros Generales"
                                    data-original-title="">
                                    <i class="fa fas fa-filter" aria-hidden="true"></i> 
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- <v_boletos_datatable :v_boletos="v_boletos" v-if="v_boletos.length > 0"></v_boletos_datatable>
                            <div v-else class="alert alert-block alert-info" style="margin-top: 44px;">
                                <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                                <p class="margin-bottom-10">
                                    Actualmente no existen venta de Boletos
                                </p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Init Component Template -->
            <!-- <template id="v_boletos_datatable">
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
                                <th>SM</th>
                                <th >Numero de Cotizacion</th>
                                <th >Agencia de Viajes</th>
                                <th  >Ciudad Salida</th>
                                <th class="col-md-1">Ciudad Llegada</th>
                                <th class="col-md-1">Fecha de Salida</th>
                                <th class="col-md-1">Fecha de llegada</th>
                                <th class="col-md-1">Tipo de Boleto</th>
                                <th class="col-md-1">Cantidad de pasajeros</th>
                                <th class="col-md-1">Estado de Boleto</th>
                                <th >observacion</th>
                                <th class="col-md-1">Fecha de Creacion:</th>
                                <th >Vendedor</th>
                                <th class="col-md-1">Fecha de Edicion:</th>
                                <th class="col-md-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SM</td>
                                <td>Numero de Cotizacion</td>
                                <td>Agencia de Viajes</td>
                                <td>Ciudad Salida</td>
                                <td>Ciudad Llegada</td>
                                <td>Fecha de Salida</td>
                                <td>Fecha de llegada</td>
                                <td>Tipo de Boleto</td>
                                <td>Cantidad de pasajeros</td>
                                <td>Estado de Boleto</td>
                                <td>observacion</td>
                                <td>Fecha de Creacion:</td>
                                <td>Vendedor</td>
                                <td>Fecha de Edicion:</td>
                                <td>Acciones</td>
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
            </template> -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('js/vboletos/index.js')}}"></script>
@endpush


