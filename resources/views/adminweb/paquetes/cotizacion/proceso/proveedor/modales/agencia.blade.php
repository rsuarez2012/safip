<!-- MODAL PROCESAR PAQUETE -->

<div class="modal-md modal" id="modal-procesar" style="overflow-y: auto;">
 <div class="modal-dialog" role="document" style="margin: 10px auto;width: 100%;">
      <div class="modal-content">
        <div class="modal-header">
          <h3  class="modal-title" style="display: inline;" id="modal-title"><i class="fa fa-usd"></i></h3>
          <button type="button" class="cerraragencia close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2 ">
              <form action="" method="">
                <div id="formulario">
                  
                  <input name="cliente_name" class="btn btn-sm btn-danger btn-flat pull-left form-control required mayus" type="button" class="form-control" >
                  <div  class="col-md-6">
                 
                    <label>Neto</label>
                    <input class="form-control required input-sm text-red otros_prov_inputs_pago" type="text"  value="" name="otros_prov_neto" id="otros_prov_neto" placeholder="Neto" >

                    <label>Comision </label>
                    <input class="form-control monto required input-sm text-red otros_prov_inputs_pago" type="text"  value="" name="otros_prov_comi"  id="otros_prov_comi"  placeholder="Comision" disabled="true">

                      <div class="hidden">

                        <label>10%</label>
                        <input class="form-control required input-sm text-red otros_prov_inputs_pago" type="text"  value="" name="otros_prov_diez"  id="otros_prov_diez"  placeholder="10%" disabled="true">
                      </div>
                    
                    <label>Incentivo</label>
                    <input class="form-control required input-sm text-red otros_prov_inputs_pago" type="text"  value="12" name ="incentivo" id="incentivo" placeholder="Incentivo" disabled="true">

                  </div>
                  <div  class="col-md-6">

                    <label class="oculto" style="display: none;">Tarifa + FEE</label>
                    <input class="form-control input-sm text-red oculto otros_prov_inputs_pago" type="number" placeholder="0" step="0.01"  name="cliente_tarifa" style="display: none;" id="otros_prov_tarifa_fee">

                    <label class="oculto" style="display: none;">Utilidad</label>
                    <input class="form-control input-sm text-red oculto otros_prov_inputs_pago" id="tarifaUtilidad" type="number" placeholder="0"  step="0.01" name="cliente_utilidad" style="display: none;">

                    <label class="oculto" style="display: none;">Total Utilidad</label>
                    <input class="form-control input-sm text-red oculto otros_prov_inputs_pago" type="number" placeholder="0" step="0.01" name="cliente_total_utilidad" readonly="" style="display: none;" id="otros_prov_total_util">
                    
                    <label>Total</label>
                    <input class="form-control required input-sm text-red otros_prov_inputs_pago" type="number" step="any" value="" id="otros_prov_total" name="otros_prov_total" placeholder="Total" disabled="true">

                    <label>A Pagar</label>
                    <input class="form-control required input-sm text-red otros_prov_inputs_pago" type="number" step="any" value="" id="otros_prov_a_pagar" name="otros_prov_a_pagar" placeholder="A Pagar" >
                    
                  </div>
                  <div align="center" class="col-md-10 col-sm-offset-1">
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-primary" id="crear-pago-pasajero" data-dismiss="modal">Adicionar Costo</button>
         <button type="button" class="btn cerraragencia btn-warning" data-dismiss="modal">Cerrar</button>
       </div>
     </div>
   </div>
</div>
<!-- //MODAL PROCESAR PAQUETE -->

