<!-- MODAL PROCESAR PAQUETE -->

<div class="modal-md modal" id="modal-ventadirecta" style="overflow-y: auto;">
 <div class="modal-dialog" role="document" style="margin: 10px auto;width: 100%;">
      <div class="modal-content">
        <div class="modal-header">
          <h3  class="modal-title" style="display: inline;"><i class="fa fa-usd"></i> Paquetes y Costos Venta Directa</h3>
          <button type="button" class="cerrarventad close" data-dismiss="modal">
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
                    <input class="form-control required input-sm text-red" type="text"  value="" name="neto" id="neto" placeholder="Neto" >
                    <label>Comision </label>
                    <input class="form-control monto required input-sm text-red" type="text"  value="" name="comi"  id="comi"  placeholder="Comision" >
                    <label>Incentivo</label>
                    <input class="form-control required input-sm text-red" type="text"  value="" name ="incentivo" id="incentivo" placeholder="Incentivo" >
                    <label>Total</label>
                    <input class="form-control required input-sm text-red" type="number" step="any" value="" id="total" name="total" placeholder="Total" >
                  </div>
                  <div  class="col-md-6">
                    
                    <label>Tarifa+FEE</label>
                    <input class="form-control required input-sm text-red" type="text"  value="" name ="tarifaf" id="tarifaf" placeholder="Incentivo" >
                    <label>Utilidad</label>
                    <input class="form-control required input-sm text-red" type="number" step="any" value="" id="utilidad" name="utilidad" placeholder="Total" >
                    <label>Total Utilidad</label>
                    <input class="form-control required input-sm text-red" type="number" step="any" value="" id="totalu" name="totalu" placeholder="Total" >
                    <input type="hidden" name="cliente_nacionalidad">
                  </div>
                  <div align="center" class="col-md-10 col-sm-offset-1">
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn  btn-warning" data-dismiss="modal">Adicionar Cliente</button>
         <button type="button" class="btn cerrarventad btn-warning" data-dismiss="modal">Cerrar</button>
       </div>
     </div>
   </div>
</div>
<!-- //MODAL PROCESAR PAQUETE -->

