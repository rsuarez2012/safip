            <template id="template_opebanks_no_ident">
                <div style="margin-top: 1%;">
                    <span class="titlepageSize">Cant. de Registros en la lista</span>
                    <select v-model="pageSize" @change="changeSelect('general')" class="pageSize">
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
                                <th>OPCIONES</th>
                                <th>EMPRESA</th>
                                <th>MONEDA</th>
                                <th>FECHA</th>
                                <th>DESCRIPCIÓN</th>
                                <th>MONTO</th>
                                <th>SALDO</th>
                                <th>SUCURSAL</th>
                                <th>NRO OPERACIÓN</th>
                                <th>USUARIO</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ope_no_ident, index) in opebanks_no_ident_list"
                                {{-- v-if="ope_no_ident.nro_operacion > 0" --}}
                                :id="'tr_padre_'+ope_no_ident.id"
                                style="display:;"
                                class="ticket">
                                <td>
                                    <select class="form-control" :id="'ope_no_ident_type_'+ope_no_ident.id" @change="action_generate(ope_no_ident)" style="width: 100%;">
                                        <option value="0">Seleccione un Tipo</option>
                                        <option v-for="option in options"
                                            :value="option.value"
                                            v-text="option.type">
                                        </option>
                                    </select>
                                </td>
                                <td v-text="ope_no_ident.empresa"></td>
                                <td v-text="ope_no_ident.moneda"></td>
                                <td v-text="ope_no_ident.fecha.split(' ')[0]"></td>
                                <td v-text="ope_no_ident.descripcion"></td>
                                <td v-text="ope_no_ident.monto"></td>
                                <td v-text="ope_no_ident.saldo"></td>
                                <td v-text="ope_no_ident.sucursal"></td>
                                <td v-text="ope_no_ident.nro_operacion"></td>
                                <td v-text="ope_no_ident.usuario"></td>
                                <td>
                                    <button type="button" class="btn btn-danger" 
                                            @click="delete_ope_bank(ope_no_ident.id)">
                                        <i class="fa fa-trash"></i> 
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pager">
                        <button type="button"
                                class="btn btn-danger btn-xs"
                                @click="previousPage('general')"
                                :disabled="currentPage <= 1">
                            <i class="fa fa-angle-left"></i>
                            Anterior
                        </button>
                        Página @{{currentPage}} de @{{totalPage}}
                        <button type="button"
                                class="btn btn-danger btn-xs"
                                @click="nextPage('general')"
                                :disabled="totalPage <= 1 || currentPage == totalPage">
                                Siguiente
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                    @include('opebanks.modals.modal_deudas')
                    @include('opebanks.modals.modal_deudas_pagos_conso')
                    @include('opebanks.modals.modal_gastos')
                </div>
            </template>