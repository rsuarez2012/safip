{{-- MODAL EDITAR VARIOS  --}}
<div class="modal" id="modalDetalleVBoleto" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: auto;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-ticket"></i> Ticket y Costos
                </h4>
                <button type="button" class="close" data-dismiss="modal" @click="hideModal('modalDetalleVBoleto')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nro de Ticket</label>
                                <input class="form-control text-red" type="text"  id="nro_ticket" placeholder="Tikets" disabled>
                            </div>
                            <div class="form-group">
                                <label>Neto</label>
                                <input class="form-control text-red" type="text"  id="neto" placeholder="Neto" disabled>
                            </div>
                            <div class="form-group">
                                <label>Tarifa</label>
                                <input class="form-control text-red" type="text"  id="tarifa" placeholder="Tarifa" disabled>
                            </div>
                            <div class="form-group">
                                <label>Comision de Agencia</label>
                                <input class="form-control text-red" type="text"  id="comision_agencia" placeholder="Comision" disabled>
                            </div>
                            <div class="form-group">
                                <label>IGV</label>
                                <input class="form-control text-red" type="number" id="igv" step="any" placeholder="IGV" disabled>
                            </div>
                            <div class="form-group">
                                <label>Consolidadores</label>
                                <input class="form-control text-red" type="text" id="consolidador" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Total</label>
                                <input class="form-control text-red" type="number" id="total" step="any" placeholder="Total" disabled>
                            </div>
                            <div class="form-group">
                                <label>Pagar a Consolidador</label>
                                <input class="form-control text-red" type="text"  id="pago_consolidador" placeholder="Pagar a Cosolidador" disabled>
                            </div>
                            <div class="form-group">
                                <label>Tarifa + FEE</label>
                                <input class="form-control text-red" type="text"  id="tarifa_fee" placeholder="Tarifa + FEE" disabled>
                            </div>
                            <div class="form-group">
                                <label>Utilidad</label>
                                <input class="form-control text-red" type="text"  id="utilidad" placeholder="Utilidad" disabled>
                            </div>
                            <div class="form-group">
                                <label>Incentivo</label>
                                <input class="form-control text-red" type="text"  id="incentivo" placeholder="Incentivo" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="pull-left btn btn-secondary" @click="hideModal('modalDetalleVBoleto')"><i class="fa fa-close"></i> Cancelar</button>
          </div>
      </div>
  </div>
</div>
{{-- MODAL EDITAR VARIOS FIN --}}