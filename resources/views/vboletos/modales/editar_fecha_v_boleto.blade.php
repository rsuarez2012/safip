{{-- MODAL EDITAR VARIOS  --}}
<div class="modal" id="modalFechaVBoletos" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: auto;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-pencil-square-o"></i> Editar fecha de registro</h4>
                <button type="button" class="close" data-dismiss="modal" onclick="modal_edith_hide()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Fecha de Registro</label>
                                <input class="form-control" type="date" id="fecha_registro" disabled>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Nueva Fecha de Registro</label>
                                <input class="form-control" type="date" v-model="new_fecha_registro" @change="valFalseFechaRegistro">
                            </div>
                        </div>
                        <div class="col-sm-2" style="margin-top: 24px;">
                            <button class="pull-right btn btn-warning" @click="validate_fecha_proceso('new_fecha_registro')">
                                <!-- <i class="fa fa-refresh"></i>  -->Validar Fecha</button>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="pull-left btn btn-secondary" @click="hideModal('modalFechaVBoletos')"><i class="fa fa-close"></i> Cancelar</button>
              <button type="submit" class="pull-right btn btn-danger" @click="updateFechaRegistro" :disabled="!exe_new_fecha_reg"><i class="fa fa-refresh"></i> Actualizar Fecha</button>
          </div>
      </div>
  </div>
</div>
{{-- MODAL EDITAR VARIOS FIN --}}