<div class="modal fade in" id="editar_boleto" style="padding-right: 17px;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button @click="cerrarModal()" type="button" class="close" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Editar Boleto <span>@{{boleto.id}}</span></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 form-group">
              <label>Consolidador</label>
              <template v-if="tipo == 'otro'">
                <select v-model="boleto.otro.proveedor_id" style="width: 100%;" class="form-control select2 select_consolidador">
                  <option value="">Cambiar Consolidador</option>
                  <option :value="consolidador.id" v-for="consolidador in consolidadores" v-text="consolidador.nombre"></option>
                </select>
              </template>
              <template v-else-if="tipo == 'qantu'">
                <select v-model="boleto.qantu.proveedor_id" style="width: 100%;" class="form-control select2">
                  <option value="">Cambiar Consolidador</option>
                  <option :value="consolidador.id" v-for="consolidador in consolidadores" v-text="consolidador.nombre"></option>
                </select>
              </template>
            </div>
            <div class="col-md-6 form-group">
              <label>Fecha</label>
              <input type="date" v-model="boleto.fecha" class="form-control">
            </div>
            <div class="col-md-6 form-group">
              <label>Neto</label>
              <input @keyup="calculoBoletoEditar" v-model="boleto.costo_neto" type="number" step="0.01" class="form-control">
            </div>
            <div class="col-md-6 form-group">
              <label>Pago Mayorista</label>
              <input v-model="boleto.pago_mayorista" disabled type="number" step="0.01" class="form-control">
            </div>
            <div class="col-md-6 form-group">
              <label>Comision</label>
              <input @keyup="calculoBoletoEditar" v-model="boleto.comision" disabled type="number" step="0.01" class="form-control">
            </div>
            <div class="col-md-6 form-group">
              <label>Tarifa+FEE</label>
              <input @keyup="calculoBoletoEditar" v-model="boleto.total_venta" type="number" step="0.01" class="form-control">
            </div>
            <div class="col-md-6 form-group">
              <label>Incentivo</label>
              <input @keyup="calculoBoletoEditar" v-model="boleto.incentivo" type="number" step="0.01" class="form-control">
            </div>
            <div class="col-md-6 form-group">
              <label>Utilidad</label>
              <input @keyup="calculoBoletoEditar" v-model="boleto.a_pagar" disabled type="number" step="0.01" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" @click="cerrarModal()" class="btn btn-default pull-left"><i class="fa fa-close"></i>Cerrar </button>
          <button type="button" class="btn btn-danger" @click="actualizarDatos()"><i class="fa fa-refresh" ></i> Actualizar</button>
        </div>
      </div>
    </div>
  </div>