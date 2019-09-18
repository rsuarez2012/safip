<!-- MODAL PROCESAR PAQUETE -->
<div class="modal-md modal" id="modal-ventadirecta" style="overflow-y: auto">
 <div class="modal-dialog" role="document" style="margin: 10px auto;width: 100%;">
  <div class="modal-content">
    <div class="modal-header">
      <h3  class="modal-title" style="display: inline;"><i class="fa fa-usd"></i> Venta Directa</h3>
      <button type="button" class="close" data-dismiss="modal" @click="cerrarModal()">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2 ">
          <div class="row bg-danger text-center" style="background-color: #dd4b39;color: #fff;text-transform: uppercase;"><h4 id="nombre-pasajero">Jose Angel</h4></div>
          <br>
        </div>
        <div class="col-sm-8 col-sm-offset-2 ">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Neto</label>
                <input @keyup="calcularVentaDirecta"  v-model="boletos[indice_venta_directa].neto" type="number" step=".01" class="form-control">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Pago a Mayorista</label>
                <input {{-- @keyup="calcularVentaDirecta" --}} disabled  v-model="boletos[indice_venta_directa].pago_mayorista" type="number" step=".01" class="form-control">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Comisión</label>
                <input disabled  v-model="boletos[indice_venta_directa].comision" type="number" step=".01" class="form-control">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Tarifa+FEE</label>
                <input @keyup="calcularVentaDirecta"  v-model="boletos[indice_venta_directa].tarifa_fee" type="number" step=".01" class="form-control">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Incentivo</label>
                <input @keyup="calcularVentaDirecta"  v-model="boletos[indice_venta_directa].incentivo" type="number" step=".01" class="form-control">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Utilidad</label>
                <input disabled  v-model="boletos[indice_venta_directa].utilidad" type="number" step=".01" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
     <a type="button" @click="procesarBoletoDirecto()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-right"></i> Procesar</a>
     <button type="button" @click="cerrarModal()" class="btn btn-secondary pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
   </div>
 </div>
</div>
</div>
<!-- //MODAL PROCESAR PAQUETE -->

