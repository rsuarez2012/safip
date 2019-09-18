{{-- MODAL CREAR  --}} 
<!-- Modal -->
<div class="modal" id="modalCrear" style="overflow-y: scroll;overflow: auto;">
  <div class="modal-dialog" role="document">
    <div class="modal-content"   style="width: 600px;margin: auto;">
      <div class="modal-header">
        <h3 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;"></h3>
        <button type="button" class="cerrarCrear close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <form id="form-cotizacion" method="post">
          {!! csrf_field() !!}
          <div hidden id="input-editar-cotizacion" class="form-group">
           <input readonly=""  class="form-control input-cotizacion" type="hidden" name="id_cotizacion">
          </div>
          <div class="form-group">
            <label for=""><i class="fa fa-plane"></i> Agencia de Viaje</label>
            <select required="true" class="form-control select2" name="agencia_id" style="width: 100%;">
              @foreach($agencias as $agencia)
              <option value="{{$agencia->id}}">{{$agencia->nombre}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
           <label for=""><i class="fa fa-globe"></i> Seleccione el Pais</label>
           <select required="true" class="form-control select2" name="pais_id" style="width: 100%;">
            @foreach($paises as $pais)
            <option value="{{$pais->id}}">{{$pais->paisnombre}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for=""><i class="fa fa-map"></i> Seleccione la Ciudad</label>
          <select required="true" class="form-control select2" name="destino_id" style="width: 100%;">
           @foreach($destinos as $destino)
           <option value="{{$destino->id}}" >{{$destino->nombre}}</option>
           @endforeach
         </select>
       </div>
       <div class="form-group">
        <label for=""><i class="fa fa-user"></i> Nacionalidad</label>
        <select required="true" class="form-control select2" name="nacionalidad" style="width: 100%;">
          <option value="peruano">peruano</option>
          <option value="comunidad">comunidad</option>
          <option value="extranjero">extranjero</option>
        </select>
      </div>
      <div class="form-group">
        <label for=""><i class="fa fa-sign-in"></i> Fecha Salida</label>
        <input class="form-control input-cotizacion" required="true" type="date" name="fecha_salida">
      </div>
      <div class="form-group">
        <label for=""><i class="fa fa-sign-out"></i> Fecha Retorno</label>
        <input class="form-control input-cotizacion" required="true" type="date" name="fecha_retorno">
      </div>
      <div class="form-group">
        <label for=""><i class="fa fa-users"></i> Cantidad de Pasajeros</label>
        <input class="form-control input-cotizacion" type="number" required="true" placeholder="Minimo 1" name="cantidad" min="1" minlength="0">
      </div>
      <div class="form-group">
        <label for=""><i class="fa fa-eye"></i> Observaciones (Opcional)</label>
        <textarea name="observacion" placeholder="Maximo 20 Caracteres..." maxlength="200" id="textarea-cotizacion" cols="30" rows="3" class="form-control"></textarea>
      </div>

    </div>
    <div class="modal-footer">
      <button type="button" class="pull-left btn btn-secondary cerrarCrear"><i class="fa fa-close"></i> Cancelar</button>
      <button type="submit" class="hidden btn btn-danger" id="crearCotizacion"><i class="fa fa-check"></i> Guardar Cotizacion</button>
      <button type="submit" class="hidden btn btn-danger" id="actualizarCotizacion"><i class="fa fa-refresh"></i> Actualizar Cotizacion</button>
    </form>
  </div>
</div>
</div>
</div>
{{-- MODAL CREAR FIN --}}
