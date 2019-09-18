<div class="modal" id="actividades" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog" role="document">
        <div class="modal-content"   style="width: 800px;left: -210px">
            <div class="modal-header">
              <h3 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;"><i class="fa fa-list"></i> Servicios</h3>
              <button @click="hide_modal_services()"  type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" >
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-xs-4">Nombre</th>
                            <th class="col-xs-3">Tipo</th>
                            <th class="col-xs-4">
                                <div class="form-group" id="div_multiple1" v-show="filterServices && dataActivity.type === 'servicio'">
                                    <label>Seleccione otros destinos</label>
                                    <select class="form-control select2"
                                        multiple="multiple"
                                        data-placeholder="Seleccione los Destinos"
                                        style="width: 80%;"
                                        id="select_filter_services">
                                            <option v-for="destiny in destinies" :value="destiny.id">@{{destiny.nombre}}</option>
                                    </select>
                                    <button class="btn btn-primary btn-xs" @click="searchFilterServices()"><i class="fa fa-filter"></i></button>
                                </div>
                                <div class="form-group" id="div_multiple2" v-show="filterRestaurants && dataActivity.type === 'restaurante'">
                                    <label>Seleccione otros destinos</label>
                                    <select class="form-control select2"
                                        multiple="multiple"
                                        data-placeholder="Seleccione los Destinos"
                                        style="width: 80%;"
                                        id="select_filter_restaurants">
                                        <template v-for="destiny in destinies">
                                            <option :value="destiny.id">@{{destiny.nombre}}</option>
                                        </template>
                                    </select>
                                    <button class="btn btn-primary btn-xs" @click="searchFilterRestaurants()"><i class="fa fa-filter"></i></button>
                                </div>
                            </th>
                            <th class="col-xs-1">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input v-model="dataActivity.name" type="text" class="form-control" placeholder="Nombre De La Actividad">
                            </td>
                            <td>
                                <select v-model="dataActivity.type" class="form-control"  @change="searchType()">
                                    <option value="">Tipo</option>
                                    <option value="servicio">Servicio</option>
                                    <option value="restaurante">Restaurante</option>
                                </select>
                            </td>
                            <td>
                                <div v-show="dataActivity.type === 'servicio'">
                                    <input  type="radio" @change="changeFilterServices()" checked value="false" name="f_services">Mismos
                                    <input type="radio" @change="changeFilterServices()" value="true" name="f_services">Otros
                                    <select v-model="dataActivity.item_id"  class="form-control" id="search-activity" style="width: 100%;">
                                        <option value="">Seleccione un servicio</option>
                                        <option v-for="service in services" :value="service.id" class="item">@{{service.nombre + ' / ' + service.operador.nombre}}</option>
                                    </select>
                                </div>
                                <div v-show="dataActivity.type === 'restaurante'">
                                    <input  type="radio" @change="changeFilterRestaurants()" checked value="false" name="f_restaurants">Mismos
                                    <input type="radio" @change="changeFilterRestaurants()" value="true" name="f_restaurants">Otros
                                    <select v-model="dataActivity.item_id" class="form-control" id="search-restaurants" style="width: 100%;">
                                        <option value="">Seleccione un restaurante</option>
                                        <option v-for="restaurant in restaurants" :value="restaurant.id" class="item">@{{restaurant.nombre}}</option>
                                    </select>
                                </div>
                                <input v-show="dataActivity.type === ''" value="Seleccione un tipo" class="form-control" disabled>    
                            </td>
                            <td><button class="btn btn-danger" title="Agregar" data-toggle="tooltip" @click="saveActivity()"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead class="bg-head-tabla">
                        <tr>
                            {{-- <th class="text-center">Codigo</th> --}}
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody v-if="mi_dia.actividades != null">
                        <template v-if="mi_dia.actividades.length > 0">
                            <tr v-for="(activities, index) in mi_dia.actividades">
                                {{-- <td class="text-center">@{{activities.codigo}}</td> --}}
                                <td class="text-center">@{{activities.nombre}}</td>
                                <td class="text-center">@{{activities.tipo}}</td>
                                <td class="text-center"><button @click="deleteActivity(activities,index)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr>
                                <td colspan="3" class="text-center">Este dia no tiene ninguna actividad</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button @click="hide_modal_services()"  type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cerrar</button>
                <button type="submit" class="hidden btn btn-danger" ><i class="fa fa-refresh"></i> Actualizar Cotizacion</button>
            </div>
        </div>
    </div>
</div>
