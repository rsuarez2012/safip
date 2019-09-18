{{-- MODAL EDITAR VARIOS  --}}
<div class="modal" id="modalFiltroGeneral" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: auto;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-pencil-square-o"></i> Filtros Generales</h4>
                <button type="button" class="close" data-dismiss="modal" @click="hideModal('modalFiltroGeneral')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Consolidadores</label>
                                <select id="select_filter_conso"
                                        class="form-control select2"
                                        multiple="multiple"
                                        data-placeholder="Seleccione los Consolidadores"
                                        style="width:100%">
                                    <option class="item"
                                            v-for="consolidador in consolidadores" 
                                            :value="consolidador.id">
                                            @{{consolidador.nombre}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Lineas Áereas</label>
                                <select id="select_filter_linea_aerea"
                                        class="form-control select2"
                                        multiple="multiple"
                                        data-placeholder="Seleccione las Aerolineas"
                                        style="width:100%">
                                    <option class="item"
                                            v-for="laerea in laereas" 
                                            :value="laerea.id">
                                            @{{laerea.nombre}}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pasajero</label>
                                <input class="form-control" type="text"  v-model.trim="filter_pasajero" placeholder="Nombre del pasajero">
                            </div>
                            
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Agencias de Viajes</label>
                                <select id="select_filter_agencia_viaje"
                                        class="form-control select2"
                                        multiple="multiple"
                                        data-placeholder="Seleccione las Agencias de Viajes"
                                        style="width:100%">
                                    <option class="item"
                                            v-for="aviaje in aviajes" 
                                            :value="aviaje.nombre">
                                            @{{aviaje.nombre}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Vendedores</label>
                                <select id="select_filter_vendedor"
                                        class="form-control select2"
                                        multiple="multiple"
                                        data-placeholder="Seleccione los Vendedores"
                                        style="width:100%">
                                    <option class="item"
                                            v-for="vendedor in vendedores"
                                            :value="vendedor.id"
                                            {{-- :value="vendedor.nombres+' '+vendedor.apellidos" --}}>
                                            @{{vendedor.nombres}} @{{vendedor.apellidos}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Pago</label>
                                <select id="filter_tipo_pago" class="form-control select2" style="width:100%">
                                    <option value="0" selected>Seleccione un Tipo de Pago</option>
                                    <option class="item"
                                            v-for="tpago in tipo_pagos" 
                                            :value="tpago.id">
                                            @{{tpago.pago}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fecha_d">Desde:</label>
                                <input type="date" v-model="fecha_d" class="form-control" id="fecha_d" value="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fecha_h">Hasta:</label>
                                <input type="date" v-model="fecha_h" class="form-control" id="fecha_h" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="pull-left btn btn-secondary" @click="hideModal('modalFiltroGeneral')"><i class="fa fa-close"></i> Cancelar</button>
              <button type="submit" class="pull-right btn btn-danger" @click="setGeneralFilter"><i class="fa fa-search"></i> Buscar</button>
          </div>
      </div>
  </div>
</div>
{{-- MODAL EDITAR VARIOS FIN --}}