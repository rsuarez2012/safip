@push('css')
    <style type="text/css">
        @media (max-width: 1024px) {
            .non_deudas{
                margin-top: 90px !important;
            }
        }
    </style>
@endpush
<div class="modal" id="modal_deudas" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: auto;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-deudas" class="modal-title" style="display: inline;">
                    <i class="fa fa-bank"></i> Deuda de Agencias de Viajes
                </h4>
                <button @click="closeModal"  type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-md-2">
                            <div class="form-group" v-show="set_arrow_filter_date">
                                <label for="fecha_d">Desde:</label>
                                <input type="date" v-model="fecha_d" class="form-control" id="" value="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" v-show="set_arrow_filter_date">
                                <label for="fecha_h">Hasta:</label>
                                <input type="date" v-model="fecha_h" class="form-control" id="" value="">
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-top:2%;">
                            <button type="button" v-show="set_arrow_filter_date"
                                    style="padding: 7px; margin-left: 7%;"
                                    class="btn btn-warning btn-xs btn"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Filtrar por fecha"
                                    data-original-title="Filtrar por fecha"
                                    @click="load_deudas_agencia_fechas"
                                    >
                                <i class="fa fas fa-calendar" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="monto_ope">Monto Disponible</label>
                                <input type="text" v-model="ope_no_ident.monto" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="monto_ope">Usado en pagos</label>
                                <input type="text" v-model="monto_pagos_general" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="monto_resta_general">Resta por usar</label>
                                <input type="text" v-model="monto_resta_general.toFixed(2)" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-md-6">
                            <button class="btn btn-danger"
                                    id="btn_edit_sm"
                                    @click="showModal('modal_sm_pagos')"
                                    v-show="exe_edit_multi_pagos == 2">
                                <i class="fa fa-edit"></i> Editar Seleccionados
                            </button>
                            <button class="btn btn-grey"
                                    id="btn_clear_sm"
                                    @click="clear_selected"
                                    v-show="exe_edit_multi_pagos >= 1">
                                <i class="fa fa-close"></i> Limpiar Seleccionados
                            </button>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="procedencia">Indique la procedencia de la operación</label>
                                <input type="text" v-model="procedencia" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div style="margin-top: 1%;" v-show="deudas_agencia.length > 0">
                            <div class="row">
                                <div class="col-md-4">
                                    <span class="titlepageSize">Cant. de Registros en la lista</span>
                                    <select class="pageSize" v-model="pageSize_deudas" @change="changeSelect('deudas')">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="500">500</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <p>Cantidad de Registros encontrados: @{{ deudas_agencia.length }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="pull-right" style="margin-bottom: 10px;margin-top: 5px;">
                                        <input type="text" placeholder="Escriba para filtrar" v-model="search_deudas_no_ident" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead class="table-danger">
                                    <tr>
                                        <th>SM</th>
                                        <th>NRO DE OPERACIÓN</th>
                                        <th>FECHA DE REGISTRO</th>
                                        <th>NRO DE COTIZACIÓN</th>
                                        <th>PASAJERO</th>
                                        <th>LINEA AEREA</th>
                                        <th>RUTA</th>
                                        <th>AGENCIA DE VIAJES</th>
                                        <th>POR COBRAR</th>
                                        <th>DIAS POR COBRAR</th>
                                        <th>STATUS</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(deuda_ag, index) in deudas_opebank_no_ident_list">
                                        <td>
                                            <input type="checkbox"
                                                    id=""
                                                    class="cl_check_sm"
                                                    @change="validate_sm"
                                                    v-model="sm_pagos"
                                                    :value="deuda_ag">
                                        </td>
                                        <td v-text="deuda_ag.nro_operacion"></td>
                                        <td v-text="deuda_ag.fecha"></td>
                                        <td v-text="deuda_ag.venta_boleto_id"></td>
                                        <td v-text="deuda_ag.nombre_cliente"></td>
                                        <td v-if="deuda_ag.laereas != null" v-text="deuda_ag.laereas.nombre"></td>
                                            <td v-else>No posee</td>
                                        <td v-text="deuda_ag.ruta"></td>
                                        <td v-text="deuda_ag.aviajes_id"></td>
                                        <td v-text="deuda_ag.porpagar"></td>
                                        <td v-text="deuda_ag.diasc"></td>
                                        <td>
                                            <span v-if="deuda_ag.status == 0" class="label label-danger">Por Cobrar</span>
                                            <span v-else class="label label-success">Pagada</span>
                                            <span v-show="deu_ag[index].pagado" class="label label-info">Editado</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-xs btn abrir"
                                                    {{-- data-toggle="tooltip"
                                                    data-placement="top" --}}
                                                    title="Editar registro de deuda"
                                                    @click="open_modal_set_pago(deuda_ag, 'deuda')">
                                                <i class="fa fa-pencil fa-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pager">
                                <button type="button"
                                        class="btn btn-danger btn-xs"
                                        @click="previousPage('deudas')"
                                        :disabled="currentPage_deudas <= 1">
                                    <i class="fa fa-angle-left"></i>
                                    Anterior
                                </button>
                                Página @{{currentPage_deudas}} de @{{totalPage_deudas}}
                                <button type="button"
                                        class="btn btn-danger btn-xs"
                                        @click="nextPage('deudas')"
                                        :disabled="totalPage_deudas <= 1 || currentPage_deudas == totalPage">
                                        Siguiente
                                    <i class="fa fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                        <div v-show="deudas_agencia.length == 0" class="alert alert-block alert-info non_deudas" style="{{-- margin-top: 80px; --}}">
                            <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                            <p class="margin-bottom-10">
                                Actualmente no existen Deudas de Agencias relacionadas al nro de operación #@{{ope_no_ident.nro_operacion}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button @click="closeModal('deuda')"
                        type="button"
                        class="pull-left btn btn-secondary">
                    <i class="fa fa-close"></i> Cerrar
                </button>
                <button type="button" class="pull-right btn bg-green" 
                        @click="register_payments('deuda')"
                        :disabled="!save_payments">
                    <i class="fa fa-check"></i>&nbsp;Enviar y Guardar pagos
                </button>
            </div>
        </div>
    </div>
</div>
@include('opebanks.modals.modal_pagos')
@include('opebanks.modals.modal_sm_pagos')
