<div class="modal" id="modalProcesar" style="overflow-y: scroll;overflow: auto;">
  <div class="modal-dialog" role="document">
    <div class="modal-content"   style="width: 300px;margin: auto;">
      <div class="modal-header">
        <h3  class="modal-title" style="display: inline;"><i class="fa fa-truck"></i> Seleccione un Proveedor</h3>
        <button type="button" class="cerrarProcesar close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center" >
        <form style="display: inline;" action="{{ route('manageCotizacionPaquete-qantu-A') }}" method="get">
          <input type="hidden" name="cotizacion">
          <button type="submit" class="btn btn-danger">Qantu Travel</button>  
        </form>

        <form style="display: inline;" action="{{ route('manageCotizacionPaquete-proveedor-A') }}" method="get">
          <input type="hidden" name="proveedor">
          <button type="submit" class="btn btn-danger">Otro Proveedor</button>  
        </form>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="pull-right btn btn-secondary cerrarProcesar"><i class="fa fa-close"></i> Cancelar</button>
      </div>
    </div>
  </div>
</div>