<div id="modal_hotel" class="modal" style="overflow: auto; ">
	<div role="document" class="modal-dialog modal-lg">
		<div class="modal-content" style="width: auto; margin: auto;">
			<div class="modal-header">
				<h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
					<i class="fa fa-plus"></i> Nuevo Hotel
				</h4>
				<button @click="cerrarModal()" type="button" data-dismiss="modal" class="close">
					<span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			</div> 
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-3">
						<label>Nombre Hotel</label>
						<input placeholder="Nombre" type="text" class="form-control" v-model="hotel.nombre">
					</div>
					<div class="col-sm-3">
						<label>*</label>
						<input placeholder="Hostel" type="text" class="form-control" v-model="hotel.estrella">
					</div>
					<div class="col-sm-3">
						<label>Categoria</label>
						<select class="form-control" name="categorias" v-model="hotel.categoria_id">
							<option value="">Seleccione Una Opcion</option>
						</select>
					</div>	
					<div class="col-sm-3">
						<label>Destino</label>
						<select class="form-control"  name="destinos" v-model="hotel.destino_id">
							<option value="">Seleccione Una Opcion</option>
						</select>
					</div>
					<div class="col-sm-3">
						<label>Check In</label>
						<input type="time" class="form-control" v-model="hotel.check_in">
					</div>
					<div class="col-sm-3">
						<label>Check Out</label>
						<input type="time" class="form-control" v-model="hotel.check_out">
					</div>
					<div class="col-sm-3">
						<label>Enlace</label>
						<input placeholder="https://ejemplo.com" type="text" class="form-control" v-model="hotel.enlace">
					</div>
				</div> 
				<hr>
				<h4 class="text-center">Peruano</h4>
				<div class="row">
					<div class="col-sm-2">
						<label>Simple</label> 
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.p_simple">
					</div>
					<div class="col-sm-2">
						<label>Doble</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.p_doble">
					</div>
					<div class="col-sm-2">
						<label>Triple</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.p_triple">
					</div>
					<div class="col-sm-2">
						<label>Cuadruple</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.p_ninio">
					</div>
					<div class="col-sm-2">
						<label>Suite Junior</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.p_sj">
					</div>
					<div class="col-sm-2">
						<label>Suite</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.p_s">
					</div>
				</div>
				<hr>
				<h4 class="text-center">Extranjero</h4>
				<div class="row">
					<div class="col-sm-2">
						<label>Simple</label> 
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.e_simple">
					</div>
					<div class="col-sm-2">
						<label>Doble</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.e_doble">
					</div>
					<div class="col-sm-2">
						<label>Triple</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.e_triple">
					</div>
					<div class="col-sm-2">
						<label>Niño</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.e_ninio">
					</div>
					<div class="col-sm-2">
						<label>Suite Junior</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.e_sj">
					</div>
					<div class="col-sm-2">
						<label>Suite</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" v-model="hotel.e_s">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button @click="cerrarModal()" type="button" class="pull-left btn btn-secondary">
					<i class="fa fa-close"></i> Cerrar
				</button>
				<button @click="guardarHotel()" type="button" class="pull-right btn btn-danger">
					<div v-if="!editar"><i class="fa fa-plus-circle"></i> Agregar</div>
					<div v-else><i class="fa fa-save"></i> Guardar Cambio</div>
				</button>
			</div>
		</div>
	</div>
</div>