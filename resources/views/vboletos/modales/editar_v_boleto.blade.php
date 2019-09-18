{{-- MODAL EDITAR VARIOS  --}}
<div class="modal" id="modalEditarVBoleto" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: auto;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-pencil-square-o"></i> Actualizar Ticket</h4>
                <button type="button" class="close" data-dismiss="modal" @click="hideModal('modalEditarVBoleto')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="col-sm-12"><p class="btn btn-info col-sm-12" v-text="ticket.cliente.dni"></p></div>
                        <div class="col-sm-12"><p class="btn btn-info col-sm-12 mayus" v-text="ticket.cliente.nombre"></p></div>
                    </div>
                    <div class="col-md-2"></div>   
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="col-sm-6">
                            <div class="form-group" id="comi_without_percent">
                                <label>Comisión de Agencia para este ticket (%)</label>
                                <input @keyup="calcularMontos" class="form-control text-red" type="text"  v-model="ticket.percent_comi_agency" placeholder="Porcentaje de comision">
                            </div>
                            <div class="form-group">
                                <label>Nro de Ticket</label>
                                <input class="form-control text-red" type="text"  v-model="ticket.nro" placeholder="Tikets" disabled>
                            </div>
                            <div class="form-group">
                                <label>Neto</label>
                                <input @keyup="calcularMontos" class="form-control text-red" type="text"  v-model="ticket.neto" placeholder="Neto">
                            </div>
                            <div class="form-group">
                                <label>Tarifa</label>
                                <input @keyup="calcularMontos" class="form-control text-red" type="text"  v-model="ticket.tarifa" placeholder="Tarifa">
                            </div>
                            <div class="form-group">
                                <label>Comision de Agencia</label>
                                <input class="form-control text-red" type="text"  v-model="ticket.comision_agencia" step="0.001" placeholder="Comision">
                            </div>
                            <div class="form-group">
                                <label>IGV</label>
                                <input class="form-control text-red" type="number" v-model="ticket.igv" step="any" placeholder="IGV" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" id="comi_without_percent">
                                <label>Comisión General de Agencia (%)</label>
                                <input class="form-control text-red" type="text"  v-model="comision_general_agencia" placeholder="Porcentaje de comision general de agencia" disabled>
                            </div>
                            <div class="form-group">
                                <label>Total</label>
                                <input class="form-control text-red" type="number" v-model="ticket.total" step="any" placeholder="Total" disabled>
                            </div>
                            <div class="form-group">
                                <label>Pagar a Consolidador</label>
                                <input class="form-control text-red" type="text"  v-model="ticket.pago_consolidador" placeholder="Pagar a Cosolidador" disabled>
                            </div>
                            <div class="form-group">
                                <label>Tarifa + FEE</label>
                                <input @keyup="calcularMontos" class="form-control text-red" type="text"  v-model="ticket.tarifa_fee" placeholder="Tarifa + FEE">
                            </div>
                            <div class="form-group">
                                <label>Utilidad</label>
                                <input class="form-control text-red" type="text"  v-model="ticket.utilidad" placeholder="Utilidad" disabled>
                            </div>
                            <div class="form-group">
                                <label>Incentivo</label>
                                <input class="form-control text-red" type="text"  v-model="ticket.incentivo" placeholder="Incentivo" disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tipo de Pago</label>
                                <select id="tipo_pago" class="form-control select2" style="width:100%" onchange="venta_boletos.setChangePayType(this)">
                                    <!-- <option value="0" selected>Seleccione un Tipo de Pago</option> -->
                                    <option class="item"
                                            v-for="tpago in tipo_pagos" 
                                            :value="tpago.id"
                                            :selected="tpago.id == ticket.tipop.id">
                                            @{{tpago.pago}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Agencias de viaje</label>
                                <select id="agencia_viaje" class="form-control select2" style="width:100%">
                                    <!-- <option value="0" selected>Seleccione una Agencia de Viajes</option> -->
                                    <option class="item"
                                            v-for="aviaje in aviajes" 
                                            :value="aviaje.nombre"
                                            :selected="aviaje.nombre == ticket.aviajes">
                                            @{{aviaje.nombre}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" v-show="ver_nro_operacion">
                                <label>Nro de Operación</label>
                                <input class="form-control text-red" type="number"  v-model="ticket.nro_operacion" @keyup="editar_nro_ope" placeholder="Nro de la Operación de pago">
                            </div>
                            <div class="form-group">
                                <label>Lineas Aéreas</label>
                                <select id="linea_aerea" class="form-control select2" style="width:100%">
                                    <!-- <option value="0" selected>Seleccione una linea aérea</option> -->
                                    <option class="item"
                                            v-for="laerea in laereas" 
                                            :value="laerea.id"
                                            :selected="laerea.id == ticket.laerea.id">
                                            @{{laerea.nombre}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Consolidadores</label>
                                <select id="conso" class="form-control select2" style="width:100%">
                                    <!-- <option value="0" selected>Seleccione un Consolidador</option> -->
                                    <option class="item"
                                            v-for="consolidador in consolidadores" 
                                            :value="consolidador.id"
                                            :selected="consolidador.id == ticket.consolidador.id">
                                            @{{consolidador.nombre}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="pull-left btn btn-secondary" @click="hideModal('modalEditarVBoleto')"><i class="fa fa-close"></i> Cancelar</button>
              <button type="submit" class="pull-right btn btn-danger" @click="updateTicket"><i class="fa fa-refresh"></i> Guardar Edición</button>
          </div>
      </div>
  </div>
</div>
{{-- MODAL EDITAR VARIOS FIN --}}