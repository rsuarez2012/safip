<div class="modal fade in modal-filter" id="filtro_boleto" style="padding-right: 17px;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button @click="cerrarModal()" type="button" class="close" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Filtro General </h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Desde</label>
              <input v-model="fecha_inicial" type="date" class="form-control" name="fecha_inicial">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Hasta</label>
              <input v-model="fecha_final" type="date" class="form-control" name="fecha_final">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Consolidador</label>
              <select id="select_filter_conso" class="form-control select2" multiple="multiple" data-placeholder="Seleccione los Consolidadores"
                style="width:100%">
                <option class="item" v-for="consolidador in consolidadores" :value="consolidador.id">
                  @{{consolidador.nombre}}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>Vendedor</label>
              <select id="select_filter_vendedor" class="form-control select2" multiple="multiple" data-placeholder="Seleccione Vendedores"
                style="width:100%">
                <option class="item" v-for="vendedor in vendedores" :value="vendedor.id">
                  @{{vendedor.nombres+" "+vendedor.apellidos}}
                </option>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Agencia</label>
              <select id="select_filter_agency" class="form-control select2" multiple="multiple" data-placeholder="Seleccione Agencia"
                style="width:100%">
                <option class="item" v-for="agencia in agencias" :value="agencia.id">
                  @{{agencia.nombre}}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>Cliente</label>
              <input style="text-transform: uppercase" v-model="cliente_nombre" type="text" class="form-control">
            </div>
          </div>
          <div class="col-sm-6">
            <label>Tipo Venta</label>
            <select v-model="tipo_venta" id="select_filter_sell" class="form-control" data-placeholder="Seleccione Tipo Pago"
              style="width:100%">
              <option value="" selected>Seleccione Un Tipo</option>
              <option value="agencia">Agencia</option>
              <option value="directa">Directa</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" @click="cerrarModal()" class="btn btn-default pull-left"><i class="fa fa-close"></i>Cerrar
        </button>
        <button type="button" class="btn btn-danger" @click="filtroGeneral()"><i class="fa fa-refresh"></i> Actualizar</button>
      </div>
    </div>
  </div>
</div>