{{-- MODAL VENTA AGENCIA --}}
<div class="modal modalProcesar" id="vDirectaModal" style="overflow-y: scroll;overflow: auto;">
  <div class="modal-dialog" role="document" style="margin: 10px auto;width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <h3  class="modal-title" style="display: inline;"><i class="fa fa-usd"></i> Paquetes y Costos Venta Directa</h3>
        <button type="button" class="cerrar-procesar-modal close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 ">
            <form action="" method="">
              <div id="formulario">
                <input name="cliente_id" class="btn btn-sm btn-info btn-flat pull-left form-control input_vdirecta" type="button" class="form-control" >
                <input name="cliente_nombre" class="btn btn-sm btn-info btn-flat pull-left form-control input_vdirecta" type="button" class="form-control" >
                <div  class="col-md-6">
                  <label>File</label>
                  <input class="form-control input-sm text-red input_vdirecta" type="text" readonly=""  value="{{$cotizacion->id}}" name="tikets">
                  <label>Hotel</label>
                  <input class="form-control input-sm text-red input_vdirecta" type="text" readonly="" name="cliente_hoteles">
                  <label>Tipo</label><br>
                  <input disabled type="text"
                  name="cliente_tipo" class="form-control input-sm text-red input_vdirecta">
                  <label>Neto</label>
                  <input class="form-control input_vdirecta input-sm text-red" type="number" name="cliente_neto" readonly>
                  <label>Comision </label>
                  <input class="form-control input_vdirecta input-sm text-red" type="number" step="0.01" name="cliente_comision" readonly>
                   <label>10%</label>
                  <input class="form-control input_vdirecta input-sm text-red" type="number" step="0.01" name="cliente_diez" readonly>
                </div>
                <div  class="col-md-6">
                  <label>Incentivo</label>
                  <input class="form-control input_vdirecta input-sm text-red" type="number" name ="cliente_incentivo" readonly="">
                  <label>Total</label>
                  <input class="form-control input_vdirecta input-sm text-red" type="number" step="0.01" name="cliente_total" placeholder="Total"  readonly>
                  <label>Tarifa + FEE</label>
                  <input class="form-control input_vdirecta input-sm text-red" type="number" placeholder="0" step="0.01"  name="cliente_tarifa">
                  <label>Utilidad</label>
                  <input class="form-control input_vdirecta input-sm text-red" id="tarifaUtilidad" type="number" placeholder="0"  step="0.01" name="cliente_utilidad">
                  <label>Total Utilidad</label>
                  <input class="form-control input_vdirecta input-sm text-red" type="number" placeholder="0" step="0.01" name="cliente_total_utilidad" readonly="">
                  <label>A Pagar </label>
                  <input class="form-control input_vdirecta input-sm text-red " type="number" name="cliente_pagar">
                  <input type="hidden" name="cliente_nacionalidad" class=" input_vdirecta">
                </div>
                <div align="center" class="col-md-10 col-sm-offset-1">
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       <button type="button" class="pull-right btn  btn-danger" id="crear-boleto-vdirecta" data-dismiss="modal"><i class="fa fa-user-plus"></i> Adicionar Cliente</button>
       <button type="button" class="pull-left btn cerrar-procesar-modal btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
     </div>
   </div>
 </div>
</div>
