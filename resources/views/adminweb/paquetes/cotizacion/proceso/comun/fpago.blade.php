
{{-- MODAL VENTA AGENCIA --}}
<div class="modal" id="modal-tipo-pago" style="overflow-y: scroll;overflow: auto;">
  <div class="modal-dialog" role="document" style="margin: 10px auto;width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <h3  class="modal-title" style="display: inline;"><i class="fa fa-usd"></i> Paquetes y Costos Venta Directa</h3>
        <button type="button" class="cerrar-boton-modal-pago close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
         <div class="col-sm-12">
          <label>
            <i class="fa fa-money"></i> Seleccione Tipo De Pago
          </label>
          <select name="fp_tipo" class="input-forma-pago form-control select2" style="width: 100%;">
            <option value="Efectivo">Efectivo</option>
            <option value="TDO">TDO</option>
            <option value="TDC">TDC</option>
            <option value="Cheque">Cheque</option>
            <option value="Transferencia">Transferencia</option>
            <option value="Deposito">Deposito</option>
            <option value="Credito">Credito</option>
          </select>
        </div>
      </div>
      <div class="row"> 
       <hr>
       <div class="col-sm-5">
        <label style="display: block;"><i class="fa fa-usd"></i> Monto</label>
        <input class="input-forma-pago form-control" type="number" step="any" name="fp_abono">
      </div>
      <div class="col-sm-5">
        <label style="display: block;"><i class="fa fa-usd"></i> Por Pagar</label>
        <input class="input-forma-pago form-control" type="number" step="any" name="fp_por_pagar" readonly>
      </div>
      <div class="col-sm-2  text-center">
        <label style="display: block;">Monto Completo</label>
        <input type="checkbox" name="fp_monto_completo">
      </div>
    </div>
    <div hidden class="row" id="fp_datos_banco">
      <hr>
      {{-- BANCO QUE ENVIA --}}
      <div class="col-sm-4">
        <label  style="display: block;"><i class="fa fa-send"></i> Banco Emisor</label>
        <select name="fp_banco_emisor" style="width: 100%;" class="input-forma-pago select2 form-control">
          @foreach($bancosg as $banco)
          <option value="{{$banco->id}}">{{$banco->banco}}</option>
          @endforeach
        </select>
      </div>
      {{-- BANCO QUE RECIBE --}}
      <div class="col-sm-4">
        <label style="display: block;"><i class="fa fa-bank"></i> Banco Receptor</label>
        <select name="fp_banco_receptor" style="width: 100%;" class="input-forma-pago select2 form-control">
          @foreach($bancos as $banco)
          <option value="{{$banco->id}}">{{$banco->banco}}</option>
          @endforeach
        </select>
      </div>
      {{-- NRO OPERACION --}}
      <div class="col-sm-4">
        <label style="display: block;">N° De Operacion</label>
        <input name="fp_operacion" type="number" step="any" class="input-forma-pago form-control">
      </div>
    </div>
  </div>

  <div class="modal-footer">
   <button type="button" class="pull-right btn  btn-danger" id="guardar-forma-pago" data-dismiss="modal"><i class="fa fa-arrow-circle-right "></i> Guardar</button>
   <button type="button" class="pull-left btn cerrar-boton-modal-pago btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
 </div>
</div>
</div>
</div>