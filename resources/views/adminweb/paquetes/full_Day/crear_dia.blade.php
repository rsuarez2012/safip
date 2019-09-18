<div class="modal" id="data_dia" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: auto;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-calendar-plus-o"></i> @{{ action_type }} @{{ tipo }}</h4>
                <button @click="closeModal"  type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label class="text-dark">Nombre</label>  
                        <input  v-model="new_dia.nombre"
                                type="text"
                                class="form-control"
                                placeholder="Ejemplo">
                    </div>
                    <div class="col-sm-5">
                        <label class="text-dark">Descripción</label>
                        <textarea v-model="new_dia.descripcion"
                                rows="2"
                                class="form-control"
                                placeholder="Texto...">
                        </textarea>
                    </div> 
                    <div class="form-group col-sm-4">
                        <label>&nbsp;</label>
                        
                        <div class="btn btn-danger btn-block"
                            style="position: relative;width: 100%;height: 34px">
                            <p style="position: absolute;width: 100%"
                                v-if="new_dia.img == ''"
                                class="text-center">
                                <span>Cargar Imagen <i class="fa fa-upload"></i></span>
                            </p>
                            <p v-else-if="new_dia.id == 0 && new_dia.img != '' || mi_dia.imagen != new_dia.img"
                                style="position: absolute;width: 100%"
                                class="text-center"
                                v-text="new_dia.img">
                                <i class="fa fa-check"></i>
                            </p>
                            <p  v-else-if="new_dia.id > 0"
                                style="position: absolute;width: 100%"
                                class="text-center">Cambiar Imagen
                            </p>
                            <input type="file"
                                    style="opacity: 0;position: absolute"
                                    class="form-control"
                                    @change="load_image_dia($event)"> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button @click="closeModal" type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cancelar</button>
                <button v-if="new_dia.id == 0" @click="save_dia" class="btn btn-danger" ><i class="fa fa-plus-circle"></i> Agregar</button>
                <button v-else class="btn btn-danger" @click="save_dia"><i class="fa fa-save"></i> Editar</button>
            </div>
        </div>
    </div>
</div>