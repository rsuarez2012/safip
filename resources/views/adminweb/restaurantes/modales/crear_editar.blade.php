<div id="modal_restaurante" class="modal" style="overflow: auto; ">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content" style="width: auto; margin: auto;">
                <div class="modal-header">
                    <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                        <i class="fa fa-plus"></i> Nuevo Restaurante
                    </h4>
                    <button @click="cerrarModal()" type="button" data-dismiss="modal" class="close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div> 
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Nombre Restaurante</label>
                            <input placeholder="Nombre" type="text" class="form-control" v-model="restaurante.nombre">
                        </div>
                        <div class="col-sm-6">
                            <label>Destino</label>
                            <select  v-model="restaurante.destino_id" class="form-control">
                                @foreach ($destinos as $destino)
                                    <option value="{{$destino->id}}">{{$destino->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> 
                    <hr>
                    <h4 class="text-center">Peruano</h4>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Adulto</label> 
                            <input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="restaurante.peruano_adulto">
                        </div>
                        <div class="col-sm-4">
                            <label>Estudiante</label>
                            <input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="restaurante.peruano_estudiante">
                        </div>
                        <div class="col-sm-4">
                            <label>Niño</label>
                            <input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="restaurante.peruano_ninio">
                        </div>
                    </div>
                    <hr>
                    <h4 class="text-center">Extranjero</h4>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Adulto</label> 
                            <input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="restaurante.extranjero_adulto">
                        </div>
                        <div class="col-sm-4">
                            <label>Estudiante</label>
                            <input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="restaurante.extranjero_estudiante">
                        </div>
                        <div class="col-sm-4">
                            <label>Niño</label>
                            <input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="restaurante.extranjero_ninio">
                        </div>
                    </div>
                    <hr>
                    <h4 class="text-center">Comunidad</h4>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Adulto</label> 
                            <input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="restaurante.comunidad_adulto">
                        </div>
                        <div class="col-sm-4">
                            <label>Estudiante</label>
                            <input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="restaurante.comunidad_estudiante">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="cerrarModal()" type="button" class="pull-left btn btn-secondary">
                        <i class="fa fa-close"></i> Cerrar
                    </button>
                    <button type="button" class="pull-right btn btn-danger">
                        <div v-if="restaurante.accion == 'crear'" @click="guardarRestaurante"><i class="fa fa-plus-circle"></i> Agregar</div>
                        <div v-else @click="updateRestaurantes"><i class="fa fa-save"></i> Guardar Cambio</div>
                    </button>
                </div>
            </div>
        </div>
    </div>