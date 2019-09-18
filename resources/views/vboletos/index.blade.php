@extends('layouts.master')

@section('titulo', 'Vboletos')
@push('css')
<style>
      .v-center-text
      {
        display: flex;
        align-items: center
      }    
      .w-100
      {
        width: 100%
      }
      ul
      {
        list-style: none
      }
      ul > li  > span
      {
        border: 1px solid #000;
        padding: 0px 20px;
        float: right;
      }
      .table td
      {
        border-top: 0px
      }
      .border-document
      {
        border:2px solid #ddd
      }
      .p-1
      {
        padding: 1em
      }
      .text-center
      {
        text-align:center;
      }
</style>
@endpush
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
                                        @click="search_filter_vboletos">
                                    <i class="fa fas fa-calendar" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="col-md-2" style="padding-top:2%;">
                                <button class="btn btn-info"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Exportar Excel"
                                        data-original-title="Exportar Excel"
                                        @click.prevent="exportarExcel">
                                    <i class="fa fa-file-excel-o"></i>
                                </button>
                                <button class="btn btn-grey"
                                        style="display: none;" 
                                        @click="clear_selected">
                                    <i class="fa fa-file-pdf-o"></i> PDF
                                </button>
                            </div>
                            <div class="col-md-4" style="padding-top:2%;">
                                <button class="btn btn-danger"
                                        id="btn_edit_sm"
                                        @click="showModal('modalEditarVBoletos', [], 'edit_multis', 0)"
                                        v-show="exe_edit_multi == 2">
                                    <i class="fa fa-edit"></i> Editar Seleccionados
                                </button>
                                <button class="btn btn-grey"
                                        id="btn_clear_sm"
                                        @click="clear_selected"
                                        v-show="exe_edit_multi >= 1">
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
                                    data-original-title=""
                                    @click="showModal('modalFiltroGeneral', [], 'filtro_general', 0)">
                                    <i class="fa fas fa-filter" aria-hidden="true"></i> 
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <v_boletos_datatable :v_boletos="v_boletos" v-show="v_boletos.length > 0"></v_boletos_datatable>
                            <div v-show="v_boletos.length == 0" class="alert alert-block alert-info" style="margin-top: 44px;">
                                <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                                <p class="margin-bottom-10">
                                    Actualmente no existen venta de Boletos
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODALES -->
                @include('vboletos.modales.detalle_v_boleto')
                @include('vboletos.modales.editar_fecha_v_boleto')
                @include('vboletos.modales.editar_v_boleto')
                @include('vboletos.modales.editar_v_boletos')
                @include('vboletos.modales.filtro_general')
                @include('vboletos.modales.preview_documento')
            </div>


            <!-- Init Component Template -->
            <template id="v_boletos_datatable">
                <div style="margin-top: 1%;">
                    <span class="titlepageSize">Cant. de Registros en la lista</span>
                    <select v-model="pageSize" @change="changeSelect()" class="pageSize">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                    </select>
                    <div class="pull-right" style="margin-bottom: 10px;margin-top: 5px;">
                        <input type="text" v-model="search" placeholder="Escriba para filtrar" class="form-control">
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead class="table-danger">
                            <tr>
                                <th>SM</th>
                                <th>ID</th>
                                <th>REGISTRO</th>
                                <th>ID COTIZACION</th>
                                <th>CODIGO</th>
                                <th>DNI/RUC</th>
                                <th>PASAJERO</th>
                                <th>AEROLINEA</th>
                                <th>RUTA</th>
                                <th>NRO TICKET</th>
                                <th>AGENCIA DE VIAJE</th>
                                <th>AGENTE</th>
                                <th>NETO</th>
                                <th>COMISION AGENCIA</th>
                                <th>TOTAL</th>
                                <th>TIPO DE PAGO</th>
                                <th>TARIFA FEE</th>
                                <th>STATUS</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(v_boleto, index) in v_boletos_list" :id="'tr_padre_'+v_boleto.id" style="display: ;" class="ticket">
                                <td>
                                    <input type="checkbox"
                                            id=""
                                            class="cl_check_sm"
                                            @change="validate_sm"
                                            v-model="sm_v_boletos"
                                            :value="v_boleto.id">
                                </td>
                                <td v-text="v_boleto.id"></td>
                                <td :id="'td_fecha_registro_'+v_boleto.id">
                                    @{{ setformatDate(v_boleto.created_at) }}
                                </td>
                                <td v-text="v_boleto.venta_boleto_id"></td>
                                <td style="text-transform: uppercase;"><a @click.prevent="previewDocumento(v_boleto.codigo)" href="" v-text="v_boleto.codigo"></a></td>
                                <td v-text="v_boleto.cliente_id"></td>
                                <td v-text="v_boleto.nombre_cliente" style="text-transform: uppercase;"></td>
                                <td v-if="v_boleto.laereas != null" v-text="v_boleto.laereas.nombre" :id="'td_linea_aerea_'+v_boleto.id" style="text-transform: uppercase;"></td>
                                    <td v-else></td>
                                <td v-text="v_boleto.ruta" style="text-transform: uppercase;"></td>
                                <td v-text="v_boleto.nro_ticket"></td>
                                <td v-text="v_boleto.aviajes" :id="'td_agencia_viaje_'+v_boleto.id" style="text-transform: uppercase;"></td>
                                <td v-if="v_boleto.users != null" v-text="v_boleto.users.nombres+' '+v_boleto.users.apellidos" style="text-transform: uppercase;"></td>
                                    <td v-else></td>
                                <td v-text="v_boleto.neto" :id="'td_valor_neto_'+v_boleto.id"></td>
                                <td v-text="v_boleto.comision_agencia" :id="'td_comision_agencia_'+v_boleto.id"></td>
                                <td v-text="v_boleto.total" :id="'td_total_'+v_boleto.id"></td>
                                <td v-text="v_boleto.tipop.pago" :id="'td_tipo_pago_'+v_boleto.id" style="text-transform: uppercase;"></td>
                                <td v-text="v_boleto.tarifa_fee" :id="'td_tarifa_fee_'+v_boleto.id"></td>
                                <td>
                                    <span v-if="v_boleto.pagado == 1" class="label label-success">Pagado</span>
                                    <span v-else class="label label-danger">Sin pagar</span>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-xs"
                                            data-toggle="tooltip"
                                            data-placement="left"
                                            title="Ver detalles del ticket"
                                            @click="showModal('modalDetalleVBoleto', v_boleto, 'detalle', index)">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-warning btn-xs"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar fecha de registro"
                                            @click="showModal('modalFechaVBoletos', v_boleto, 'editar_fecha', index)">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </button>
                                    @if(Auth::user()->role == "Administrador" || Auth::user()->email == "confirmaciones@qantutravel.com")
                                        @if(Auth::user()->role == "Administrador")
                                        <button class="btn btn-danger btn-xs"
                                                :id="'anularTicket_'+v_boleto.id"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Anular Ticket"
                                                @click="anularTicket(v_boleto)">
                                            <i class="fa fa-minus-square"></i>
                                        </button>
                                        @endif
                                        <button class="btn btn-xs bg-olive"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Editar ticket"
                                                @click="showModal('modalEditarVBoleto', v_boleto, 'editar_ticket', index)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <a class="btn btn-info btn-xs"
                                            href=""
                                            @click.prevent="printPDF(v_boleto)"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Imprimir Boleto">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                    @endif
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
        </div>
    </div>

    <div class="row" id="venta_boletos_calculos_finales">
        <hr>
        <div class="col-md-3">
            <span class="h4"> Cantidad de venta de Boletos</span>
            <input  type="text" :value="v_boletos.length" class="h3 text-red form-control edit-input" disabled style="width: 30%"><div></div>
        </div>
        <div class="col-md-4">
            <div style="text-align: right;" class="col-md-6">
                <span class="h4 mod-span">Pago cons. </span><div></div>
                <span class="h4 mod-span">Tarifa FEE </span><div></div>
                <span class="h4 mod-span">Utilidad </span><div></div>
                <span class="h4 mod-span">Incentivo </span><div></div>
            </div>
            <div style="background-color: #fafafa;" class="col-md-6">
                <input disabled="" :value="inf_pago_conso" class="h3 text-red form-control edit-input"><div></div>
                <input disabled="" :value="inf_tarifa_fee" class="h3 text-red form-control edit-input"><div></div>
                <input disabled="" :value="inf_utilidad" class="h3 text-red form-control edit-input"><div></div>
                <input disabled="" :value="inf_incentivo" class="h3 text-red form-control edit-input"><div></div>
            </div>
        </div>
        <div class="col-md-4">
            <div style="text-align: right;" class="col-md-6">
                <span class="h4 mod-span">Sub total </span><div></div>
                <span class="h4 mod-span">IGV </span><div></div>
                <span class="h4 mod-span">TOTAL </span><div></div>
            </div>
            <div style="background-color: #fafafa;" class="col-md-6">
                <input disabled="" :value="inf_sub_total" class="h3 text-red form-control edit-input"><div></div>
                <input disabled="" :value="inf_igv" class="h3 text-red form-control edit-input"><div></div>
                <input disabled="" :value="inf_total" class="h3 text-red form-control edit-input"><div></div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/vboletos/index.js')}}"></script>
@endpush

