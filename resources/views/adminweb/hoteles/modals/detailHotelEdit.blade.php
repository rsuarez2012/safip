<div id="detail_hotel" class="modal" style="overflow: auto; ">
	<div role="document" class="modal-dialog modal-lg">
		<div class="modal-content" style="width: auto; margin: auto;">
			<div class="modal-header">
				<h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
					<i class="fa fa-plus"></i> Servicios del Hotel
				</h4>
				<button type="button" data-dismiss="modal" class="close">
					<span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			</div> 
			<div class="modal-body">
			<form action="{{ url('/tablero/Hoteles/Admin/Store')}}" method="POST">
					{!! csrf_field() !!}
				<div class="row">
					<div class="col-sm-3">
						<label>Nombre Hotel</label>
						<input placeholder="Nombre" type="text" class="form-control" name="nombre">
					</div>
					<div class="col-sm-3">
						<label>*</label>
						<input placeholder="Hostel" type="text" class="form-control" name="estrella">
					</div>
					<div class="col-sm-3">
						<label>Categoria</label><br>
						<select class="form-control" name="categoria_id" id="categoria_id">
							<option value="">Seleccione Una Opcion</option>
							@foreach($categorias as $categoria)
								<option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
							@endforeach
						</select>
					</div>	
					<div class="col-sm-3">
						<label>Destino</label><br>
						<select class="form-control"  name="destino_id" id="destino_id">
							<option value="">Seleccione Una Opcion</option>
							@foreach($destinos as $destino)
								<option value="{{ $destino->id }}">{{ $destino->nombre }}</option>
							@endforeach
						</select>
					</div>


					<div class="row">
                        <div class="col-md-12">
                            <div class="col-sm-3">
                                <label>Check In</label>
                                <input type="time" class="form-control" id="check_in" name="check_in">
                            </div>
                            <div class="col-sm-3">
                                <label>Check Out</label>
                                <input type="time" class="form-control" id="check_out" name="check_out">
                            </div>
                            <div class="col-sm-3">
                                <label>Enlace</label>
                                <input placeholder="https://ejemplo.com" type="text" class="form-control" id="enlace" name="enlace">
                            </div>
                            
                        </div>
                    </div>
				</div> 
				<hr>
				<h4 class="text-center">Peruano</h4>
				<div class="row">
					<div class="col-sm-2">
						<label>Simple</label> 
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="p_simple">
					</div>
					<div class="col-sm-2">
						<label>Doble</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="p_doble">
					</div>
					<div class="col-sm-2">
						<label>Triple</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="p_triple">
					</div>
					<div class="col-sm-2">
						<label>Cuadruple</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="p_ninio">
					</div>
					<div class="col-sm-2">
						<label>Suite Junior</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="p_sj">
					</div>
					<div class="col-sm-2">
						<label>Suite</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="p_s">
					</div>
				</div>
				<hr>
				<h4 class="text-center">Extranjero</h4>
				<div class="row">
					<div class="col-sm-2">
						<label>Simple</label> 
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="e_simple">
					</div>
					<div class="col-sm-2">
						<label>Doble</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="e_doble">
					</div>
					<div class="col-sm-2">
						<label>Triple</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="e_triple">
					</div>
					<div class="col-sm-2">
						<label>Niño</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="e_ninio">
					</div>
					<div class="col-sm-2">
						<label>Suite Junior</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="e_sj">
					</div>
					<div class="col-sm-2">
						<label>Suite</label>
						<input type="number" placeholder="min 0" step="0.01" class="form-control" name="e_s">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="pull-left btn btn-secondary" id="cerrar">
					<i class="fa fa-close"></i> Cerrar
				</button>
				<button  type="submit" class="pull-right btn btn-danger">
					<i class="fa fa-plus-circle"></i> Agregar</div>
				</button>
			</div>
			</form>
		</div>
	</div>
</div>