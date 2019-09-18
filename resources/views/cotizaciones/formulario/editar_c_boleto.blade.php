{{-- MODAL CREAR  --}}
<div class="modal" id="modalEditarCBoleto" style="overflow-y: scroll;overflow: auto;">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content" style="width: auto;margin: auto;">
      		<div class="modal-header">
        		<h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Actualizar Cotización de Boleto Nro: @{{c_boleto.count}}</h4>
        		<button type="button" class="cerrarCrear close" data-dismiss="modal">
        		  <span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body" >
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for=""><i class="fa fa-plane"></i> Agencia de Viaje</label>
							<select required="true" class="form-control select2" name="sl_aviaje" style="width: 100%;">
								<option value="">Seleccione una agencia de viaje</option>
								<option v-for="agencia in agencias"
										:value="agencia.id"
										v-text="agencia.nombre"
										:selected="agencia.id == c_boleto.aviajes_id">
								</option>
							</select>
						</div>
						{{-- <div class="form-group">
							 <label for=""><i class="fa fa-globe"></i> Seleccione el Pais</label>
							 <select required="true" class="form-control select2" name="sl_pais_boleto" style="width: 100%;">
								<option value="">Seleccione un pais</option>
								<option v-for="pais in paises"
										:value="pais.id"
										v-text="pais.paisnombre"
										:selected="pais.id == c_boleto.paises_id">
								</option>
							</select>
					  	</div> --}}
					  	<div class="form-group">
							<label for=""><i class="fa fa-map"></i> Seleccione la Ciudad de Salida</label>
							  <select required="true" class="form-control select2" name="sl_c_salida" style="width: 100%;">
								<option value="">Ciudad Salida</option>
								<option v-for="ciudad in ciudades"
										:value="ciudad.ciudadnombre"
										v-text="ciudad.ciudadnombre"
										:selected="ciudad.ciudadnombre == c_boleto.d_ciudad_id">
								</option>
							</select>
						</div>
						<div class="form-group">
							<label for=""><i class="fa fa-map"></i> Seleccione la Ciudad de Llegada</label>
							  <select required="true" class="form-control select2" name="sl_c_llegada" style="width: 100%;">
								<option value="">Ciudad Llegada</option>
								<option v-for="ciudad in ciudades"
										:value="ciudad.ciudadnombre"
										v-text="ciudad.ciudadnombre"
										:selected="ciudad.ciudadnombre == c_boleto.h_ciudad_id">
								</option>
							</select>
						</div>
						<div class="form-group">
							<label>
								<span class="fa fa-exchange"></span>
								<input type="radio" name="vuelo" value="1" v-model="ida_v">
								Ida y Vuelta |
							</label>
							<label>
								<span class="fa fa-angle-double-right"></span>
								<input type="radio" name="vuelo" value="0" v-model="ida_v">
								Solo Ida |
							</label>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							  <label for=""><i class="fa fa-sign-in"></i> Fecha Salida</label>
							  <input class="form-control" required="true" type="date" v-model="fecha_salida">
						</div>
						<div class="form-group">
							  <label for=""><i class="fa fa-sign-out"></i> Fecha Retorno</label>
							  <input class="form-control" required="true" type="date" v-model="fecha_retorno">
						</div>
						<div class="form-group">
							  <label for=""><i class="fa fa-users"></i> Cantidad de Pasajeros</label>
							  <input class="form-control" v-model="pasajeros" type="number" required="true" placeholder="Minimo 1" min="1" minlength="0">
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
				<button type="button" class="pull-left btn btn-secondary" @click="modalHide('modalEditarCBoleto')"><i class="fa fa-close"></i> Cancelar</button>
				<button type="submit" class="pull-right btn btn-danger" @click.prevent="update_c_boleto"><i class="fa fa-refresh"></i> Actualizar Cotizacion</button>
			</div>
		</div>
	</div>
</div>
{{-- MODAL CREAR FIN --}}