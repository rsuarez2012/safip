<div class="modal" id="modal-dato-adicionales" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="margin: auto;width: 500px;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Datos adicionales
                </h4>
                <button @click="cerrarModal()" type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Telefono</label>
                            <input v-model="lista_pasajeros[indice_adicionales].telefono" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Direccion</label>
                            <input v-model="lista_pasajeros[indice_adicionales].email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="lista_pasajeros[indice_adicionales].direccion" class="form-control">
                        </div>    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button @click="cerrarModal()" type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cerrar</button>
                <button  @click="cerrarModal()" class="btn btn-success pull-right">
                    Registrar <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </div>
    </div>  
</div>
