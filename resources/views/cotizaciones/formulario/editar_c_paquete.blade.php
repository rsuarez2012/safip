{{-- MODAL CREAR  --}}
<div class="modal" id="modalEditarCPaquete" style="overflow-y: scroll;overflow: auto;">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content" style="width: auto;margin: auto;">
      		<div class="modal-header">
        		<h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Actualizar Cotización de Paquete Nro: @{{c_paquete.id}}</h4>
        		<button type="button" class="cerrarCrear close" data-dismiss="modal">
        		  <span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body" >
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for=""><i class="fa fa-plane"></i> Agencia de Viaje</label>
							<select required="true" class="form-control select2" name="sl_agencia" style="width: 100%;">
								<option value="">Seleccione una agencia de viaje</option>
								<option v-for="agencia in agencias" :value="agencia.id" v-text="agencia.nombre" :selected="agencia.id == c_paquete.agencia_id"></option>
							</select>
						</div>
						<div class="form-group">
							 <label for=""><i class="fa fa-globe"></i> Seleccione el Pais</label>
							 <select required="true" class="form-control select2" name="sl_pais" style="width: 100%;">
								<option value="">Seleccione un pais</option>
								<option v-for="pais in paises" :value="pais.id" v-text="pais.paisnombre" :selected="pais.id == c_paquete.pais_id"></option>
							</select>
					  	</div>
					  	<div class="form-group">
							<label for=""><i class="fa fa-map"></i> Seleccione la Ciudad</label>
							  <select required="true" class="form-control select2" name="sl_destino" style="width: 100%;">
								<option value="">Seleccione una ciudad</option>
								<option v-for="destino in destinos" :value="destino.id" v-text="destino.nombre" :selected="destino.id == c_paquete.destino_id"></option>
							</select>
						</div>
						 <div class="form-group">
						  <label for=""><i class="fa fa-user"></i> Nacionalidad</label>
						  <select required="true" class="form-control select2" name="nacionalidad" style="width: 100%;">
								<option value="peruano" :selected="c_paquete.nacionalidad == 'peruano'">peruano</option>
								<option value="comunidad" :selected="c_paquete.nacionalidad == 'comunidad'">comunidad</option>
								<option value="extranjero" :selected="c_paquete.nacionalidad == 'extranjero'">extranjero</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							  <label for=""><i class="fa fa-sign-in"></i> Fecha Salida</label>
							  <input class="form-control input-cotizacion" required="true" type="date" v-model="fecha_salida">
						</div>
						<div class="form-group">
							  <label for=""><i class="fa fa-sign-out"></i> Fecha Retorno</label>
							  <input class="form-control input-cotizacion" required="true" type="date" v-model="fecha_retorno">
						</div>
						<div class="form-group">
							  <label for=""><i class="fa fa-users"></i> Cantidad de Pasajeros</label>
							  <input class="form-control input-cotizacion" v-model="pasajeros" type="number" required="true" placeholder="Minimo 1" name="cantidad" min="1" minlength="0">
						</div>
						<div class="form-group">
							<label for=""><i class="fa fa-eye"></i> Observaciones (Opcional)</label>
							<textarea v-model="observacion"
										placeholder="Maximo 20 Caracteres..."
										{{-- maxlength="200" --}}
										cols="30"
										rows="3"
										class="form-control">
								@{{ observacion }}
							</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="pull-left btn btn-secondary" @click="modalHide('modalEditarCPaquete')"><i class="fa fa-close"></i> Cancelar</button>
				<button type="submit" class="pull-right btn btn-danger" @click.prevent="update_c_paquete"><i class="fa fa-refresh"></i> Actualizar Cotizacion</button>
			</div>
		</div>
	</div>
</div>
{{-- MODAL CREAR FIN --}}
