<div class="modal" id="modalCrear" style="overflow-y: scroll;overflow: auto;" style="display: block" >
    <div class="modal-dialog" role="document">
        <div class="modal-content"   style="width: 600px;margin: auto;">
          <form action="{{ url('/solicitudes/agencias/estodo') }}" method="get">
            <div class="modal-body" >
              <h3>¿ Esta Seguro que quiere <span id="accion-modal"></span> esta solicitud ?</h3>
                <input type="hidden" id="input_agencia" name="input_agencia">
                <input type="hidden" id="input_status" name="input_status">
              <div style="display: none" id="text-message">
                <label class="text-bold">Ingrese Motivo Del Rechazo</label>
                <input class="form-control" name="message" placeholder="Ejemplo ... Dni Invalido">
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-danger pull-right">Continuar <i class="fa fa-arrow-circle-right"></i></button>
              <a class="btn btn-danger pull-left" onclick="cerrarModal()"><i class="fa fa-close"></i> Cancelar</a>   
            </div>
          </form>
      </div>
    </div>
  </div>