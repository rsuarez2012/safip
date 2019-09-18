  {{-- MODAL VENTA AGENCIA --}}
  <div class="modal" id="modalBoleto" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog" role="document" style="margin: 10px auto;width: 100%;">
      <div class="modal-content">
        <div class="modal-header">
          <h3  class="modal-title" style="display: inline;"><i class="fa fa-ticket"></i> Ticket N° <span id="titulo-boleto"></span> </h3>
          <button type="button" class="cerrarModal close" data-dismiss="modal">
            <span aria-hidden="true"><i class="fa fa-close"></i></span>
          </button> 
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2 ">
              <form action="" method="">
                <div id="formulario">
                  <input name="cliente_dni" class="btn btn-sm btn-info btn-flat pull-left form-control required" type="button" class="form-control" >
                  <input name="cliente_nombre" class="btn btn-sm btn-info btn-flat pull-left form-control required" type="button" class="form-control" >
                  <div  class="col-md-6">
                    <label>File</label>
                    <input class="form-control input-sm text-red" type="text" readonly=""   name="tiket">
                    <label>Hotel</label>
                    <input class="form-control input-sm text-red" type="text" readonly="" name="cliente_hoteles">
                    <label>Tipo</label><br>
                    <input disabled type="text"
                    name="cliente_tipo" class="form-control input-sm text-red">
                    <label>Neto</label>
                    <input class="form-control required input-sm text-red" type="number" name="cliente_neto" readonly>
                    <label>Comision </label>
                    <input class="form-control required input-sm text-red" type="number" step="0.01" name="cliente_comision" readonly>
                  </div>
                  <div  class="col-md-6">
                    <label>10%</label>
                    <input class="form-control required input-sm text-red" type="number" step="0.01" name="cliente_diez" readonly>
                    <label>Incentivo</label>
                    <input class="form-control required input-sm text-red" type="number" name ="cliente_incentivo" readonly="">
                    <label>Total</label>
                    <input class="form-control required input-sm text-red" type="number" step="0.01" name="cliente_total" placeholder="Total" readonly>
                    <label>A Pagar </label>
                    <input class="form-control required input-sm text-red " readonly="" type="number" name="cliente_pagar">
                  </div>
                  <div align="center" class="col-md-10 col-sm-offset-1">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
         <a id="enlace-boleto" target="_blank" href="#" class="btn btn-success cerrarModal">Imprimir Ticket <i class="fa fa-print"></i></a>
         <button type="button" class="pull-left btn cerrarModal btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
       </div>
     </div>
   </div>
 </div>
