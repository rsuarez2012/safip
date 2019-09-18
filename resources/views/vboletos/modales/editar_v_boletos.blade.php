{{-- MODAL EDITAR VARIOS  --}}
<div class="modal" id="modalEditarVBoletos" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: auto;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Actualizar Ventas de Boletos</h4>
                <button type="button" class="close" data-dismiss="modal" @click="hideModal('modalEditarVBoletos')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for=""><i class="fa fa-plane"></i> Tipo de Pago</label>
                            <select id="multi_tipo_pago" class="form-control select2" style="width:100%">
                                <option value="0" selected>Seleccione un Tipo de Pago</option>
                                <option class="item"
                                        v-for="tpago in tipo_pagos" 
                                        :value="tpago.id">
                                        @{{tpago.pago}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""><i class="fa fa-map"></i> Agencia de viajes</label>
                            <select id="multi_agencia_viaje" class="form-control select2" style="width:100%">
                                <option value="0" selected>Seleccione una Agencia de Viajes</option>
                                <option class="item"
                                        v-for="aviaje in aviajes" 
                                        :value="aviaje.nombre">
                                        @{{aviaje.nombre}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for=""><i class="fa fa-sign-in"></i> Fecha de Registro</label>
                            <input class="form-control" type="date" id="new_fecha_registro" v-model="new_fecha_registro" @change="validate_fecha_proceso('new_fecha_registro')">
                        </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="pull-left btn btn-secondary" @click="hideModal('modalEditarVBoletos')"><i class="fa fa-close"></i> Cancelar</button>
              <button type="submit" class="pull-right btn btn-danger" @click="procesar_edith_sm"><i class="fa fa-refresh"></i> Actualizar Boletos</button>
          </div>
      </div>
  </div>
</div>
{{-- MODAL EDITAR VARIOS FIN --}}