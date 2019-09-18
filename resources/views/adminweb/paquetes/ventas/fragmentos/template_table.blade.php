<template id="datatable-vue">
    <div>
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Desde</label>
                    <input v-model="fecha_inicial" type="date" class="form-control" name="fecha_inicial">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Hasta</label>
                    <input v-model="fecha_final" type="date" class="form-control" name="fecha_final">
                </div>
            </div>
            <div class="col-sm-1" style="padding-top: 2%;">
                <div class="form-group">
                    <button @click="datesFilterData" class="btn btn-warning ">
                        <i class="fa fa-filter"></i>
                    </button>
                </div>
            </div>
            <div class="col-sm-1 col-sm-offset-5">
                <button @click="showModalFilter()" class="btn btn-danger btn-sm">
                    <i class="fa fa-filter"></i> Filtro General
                </button>
            </div>
        </div>
        <div class="table-responsive" style="text-transform: uppercase;">
            <div class="col-md-1">
                <select v-model="sort" @change="getData">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select>
            </div>
            <div class="col-md-2 pull-right" style="margin-bottom:10px;">
                <input v-model="search" @keyup="getData" type="search" class="form-control" placeholder="Buscar">
            </div>

            <table class="table table-bordered table-hover">
                <thead style="background-color: #dd4b39;color: #fff">
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Registro</th>
                        <th>N° Cotizacion</th>
                        <th>DNI / RUC</th>
                        <th>Pasajero</th>
                        <th>Agencia</th>
                        <th>Agente</th>
                        <th>Neto</th>
                        <th>comision</th>
                        <th>Consolidador</th>
                        <th>Tipo Venta</th>
                        <th>Estado</th>
                        <th>A Pagar</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for='dato in datos'>
                        <td>@{{dato.id}}</td>
                        <td>@{{dato.fecha}}</td>
                        <td>@{{dato.cotizacion_id}}</td>
                        <td>@{{dato.cliente.cedula_rif}}</td>
                        <td>@{{dato.cliente.nombre +' '+dato.cliente.apellido}}</td>
                        <td>@{{dato.cotizacion.agencia.nombre}}</td>
                        <td>@{{dato.vendedor.apellidos + ' ' + dato.vendedor.nombres}}</td>
                        <td>@{{dato.costo_neto}}</td>
                        <td>@{{dato.comision}}</td>
                        <template v-if="tipo == 'otro'">
                            <td>@{{dato.otro.consolidador.nombre}}</td>
                            <td>@{{dato.otro.tipo}}</td>
                        </template>
                        <template v-else-if="tipo == 'qantu'">
                            <td>@{{dato.otro.consolidador.nombre}}</td>
                            <td>@{{dato.qantu.tipo}}</td>
                        </template>
                        <td>Estado</td>
                        <!-- <template v-if="tipo == 'otro'">
                            <td>@{{dato.otro.consolidador.nombre}}</td>
                            <td>@{{dato.otro.tipo}}</td>
                        </template>
                        <template v-else-if="tipo == 'qantu'">
                            <td>@{{dato.qantu.consolidador.nombre}}</td>
                            <td>@{{dato.qantu.tipo}}</td>
                        </template> -->
                        <td class='text-center'>
                            <label v-if="dato.estado == 'Cancelado'" class='label label-success'>@{{dato.estado}}</label>
                            <label v-else class='label label-danger'>@{{dato.estado}}</label>
                        </td>
                        <td>
                            <button v-if="rol_usuario == 'Administrador'" @click="showModalEdit(dato)" data-toggle="tooltip"
                                data-placement="left" title='Editar' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i></button>
                            <a target="_blank" :href="route + '/tablero/print/boletos/paquetes/' + dato.id" data-toggle="tooltip"
                                data-placement="left" title='Imprmir Boleto' class='btn btn-info btn-xs'><i class='fa fa-print'></i></a>
                            <button v-if="rol_usuario == 'Administrador'" @click="anularBoleto(dato.id)" data-toggle="tooltip"
                                data-placement="left" title='Anular Boleto' class='btn btn-danger btn-xs'><i class='fa fa-close'></i></button>
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
            </nav>
        </div>
        @include('adminweb.paquetes.ventas.fragmentos.boleto')
        @include('adminweb.paquetes.ventas.fragmentos.filtro')
    </div>
</template>