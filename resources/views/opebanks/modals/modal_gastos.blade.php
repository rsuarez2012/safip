{{-- MODAL PAGOS  --}}
<div class="modal" id="modal_gastos" style="overflow-y: scroll;overflow: auto;">
  	<div class="modal-dialog modal-gastos" role="document">
    	<div class="modal-content" style="width: auto;margin: auto;">
      		<div class="modal-header">
        		<h4 id="titulo-modal-gastos" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Detalles del Gasto</h4>
        		<button type="button" class="cerrarCrear close" data-dismiss="modal">
        		  <span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body" >
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							  <label for=""><i class="fa fa-sign-in"></i> Tipo de Gasto</label>
							  <input class="form-control" type="text" v-model="tipo_gasto" placeholder="Tipo de Gasto">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for=""><i class="fa fa-users"></i> Descripción</label>
							<textarea class="form-control" rows="3" cols="3" v-model="descripcion_gasto" placeholder="Descripción del gasto"></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for=""><i class="fa fa-balance-scale"></i> Agregar Gastos a Contabilidad?</label>
							<button type="button" :class="[!add_contability ? 'btn-danger' : 'btn-secondary', 'btn']" 
									@click="add_gasto_contab(false)">
								<i class="fa fa-ban"></i> NO
							</button>
							<button type="button" :class="[add_contability ? 'btn-danger' : 'btn-secondary', 'btn']" 
									@click="add_gasto_contab(true)">
								<i class="fa fa-check"></i> SI
							</button>
						</div>
					</div>
				</div>
				<div class="row" v-show="add_contability">
					<div class="col-md-12">
						<div class="form-group">
							<select class="form-control"
									:id="'sucursal_'+ope_no_ident.id"
									v-model="sucursal"
									@change="sel_yes_suc"
									style="width: 100%;">
								<option value="0">Seleccione Sucursal</option>
								<option v-for="suc in sucursales"
										:value="suc.name"
										v-text="suc.name">
								</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="pull-left btn btn-secondary" 
						@click="closeModalGasto">
					<i class="fa fa-close"></i> Cerrar
				</button>
				<button type="button" class="pull-right btn bg-green" 
						@click="register_gasto"
						:disabled="tipo_gasto.length == 0 || descripcion_gasto.length == 0 || yes_suc">
					<i class="fa fa-check"></i>&nbsp;Guardar Gasto
				</button>
			</div>
		</div>
	</div>
</div>
{{-- MODAL CREAR FIN --}}