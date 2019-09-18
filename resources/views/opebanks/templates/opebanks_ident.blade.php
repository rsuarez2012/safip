            <template id="template_opebanks_ident">
                <div style="margin-top: 1%;">
                    <span class="titlepageSize">Cant. de Registros en la lista</span>
                    <select v-model="pageSize" class="pageSize">
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
                                <th>NRO OPERACIÓN</th>
                                <th>EMPRESA</th>
                                <th>MONEDA</th>
                                <th>FECHA</th>
                                <th>DESCRIPCIÓN</th>
                                <th>MONTO</th>
                                <th>SALDO</th>
                                <th>SUCURSAL</th>
                                <th>USUARIO</th>
                                <th>DEUDAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ope_ident, index) in opebanks_ident_list"
                                :class="{'bg-blue' : ope_ident.tipo_operacion == 'deuda', 'bg-green' : ope_ident.tipo_operacion == 'pago_conso', 'bg-red' : ope_ident.tipo_operacion == 'gastos'}">
                                <td v-text="ope_ident.nro_operacion"></td>
                                <td v-text="ope_ident.empresa"></td>
                                <td v-text="ope_ident.moneda"></td>
                                <td v-text="ope_ident.fecha.split(' ')[0]"></td>
                                <td v-text="ope_ident.descripcion"></td>
                                <td v-text="ope_ident.monto"></td>
                                <td v-text="ope_ident.saldo"></td>
                                <td v-text="ope_ident.sucursal"></td>
                                <td v-text="ope_ident.usuario"></td>
                                <td>
                                    <button class="btn btn-info btn-xs"
                                            title="Ver">
                                        - <i class="fa fa-usd"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pager">
                        {{-- <button type="button"
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
                        </button> --}}
                    </div>
                </div>
            </template>