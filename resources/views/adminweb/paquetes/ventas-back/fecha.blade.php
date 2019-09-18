  {{-- MODAL VENTA AGENCIA --}}
  <div class="modal" id="modalFecha" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog" role="document" style="margin: 10px auto;width: 100%;">
      <div class="modal-content">
        <div class="modal-header">
          <h3  class="modal-title" style="display: inline;"><i class="fa fa-ticket"></i> Cambiar Fecha Boleto Nº <span id="f_title"></span> </h3>
          <button type="button" class="cerrarModal close" data-dismiss="modal">
            <span aria-hidden="true"><i class="fa fa-close"></i></span>
          </button> 
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2 ">
              <form action="{{route('manageVentaPaquete-fecha')}}" method="POST">
                {{csrf_field()}}
                <input class="form-control" required="" name="f_cotizacion" type="hidden">
                <label class="bg-warning text-justify">Se le notifica que se le cambiara la fecha a todos los boletos que pertenezcan a la misma cotizacion que este boleto</label>
                <label>Nueva Fecha</label>
                <input class="form-control" required="" type="date" name="f_fecha">
              </div>
            </div>
          </div>
          <div class="modal-footer">
           <button class="btn btn-success" type="submit">Actualizar <i class="fa fa-save"></i></button>
         </form>
         <button type="button" class="pull-left btn cerrarModal btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
       </div>
     </div>
   </div>
 </div>
