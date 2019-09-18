{{-- MODAL PAGOS  --}}
<div class="modal" id="modal_pagos_conso" style="overflow-y: scroll;overflow: auto;">
  	<div class="modal-dialog modal-pago-conso" role="document">
    	<div class="modal-content" style="width: auto;margin: auto;">
      		<div class="modal-header">
        		<h4 id="titulo-modal-pagos" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Realizar pagos a consolidador</h4>
        		<button type="button" class="cerrarCrear close" data-dismiss="modal">
        		  <span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body" >
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							  <label for=""><i class="fa fa-sign-in"></i> Fecha</label>
							  <input class="form-control" readonly type="date" v-model="pag_con[general_index_conso].fecha">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							  <label for=""><i class="fa fa-users"></i> Nro de Cotización</label>
							  <input class="form-control" v-model="pag_con[general_index_conso].nro_cot" type="number" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							  <label for=""><i class="fa fa-users"></i> Nro de Operación</label>
							  <input class="form-control" v-model="pag_con[general_index_conso].nro_ope" type="number" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							  <label for=""><i class="fa fa-users"></i> Nro de Ticket</label>
							  <input class="form-control" v-model="pag_con[general_index_conso].ticket" type="number" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for=""><i class="fa fa-users"></i> Monto a pagar</label>
							<input class="form-control text-red" v-model="pag_con[general_index_conso].monto" type="text" readonly >
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for=""><i class="fa fa-users"></i> Días por Cobrar</label>
							<input class="form-control" v-model="pag_con[general_index_conso].diasc" type="text" readonly >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="col-sm-5">
							Usar el monto que resta en la operación bancaria: 
							<input type="checkbox"
                                    id="'plus_deuda_conso_'+general_index"
                                    class="cl_check_full_price"
                                    @change="validate_full_price('conso')"
                                    v-model="pag_con[general_index_conso].full_price">
						</div>
						<div class="col-sm-3">
							<h4 class="text-center">PAGOS</h4>
						</div>
						<div class="col-sm-4">
							<button type="button"
									class="pull-right btn btn-danger" 
									@click="create_pago_conso"
									:disabled="pag_con[general_index_conso].resta <= 0">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" v-for="(dcon_pago, index) in pag_con[general_index_conso].pagos">
						<div class="col-sm-2">
							<div class="form-group">
								<label>Tipo de Pago</label>
								<select class="form-control"
										:id="'conso_ope_no_ident_pay_type_'+ope_no_ident.id+'_gi_'+general_index_conso+'_pg_'+index"
										@change="val_pay_type_conso(index)"
										v-model="dcon_pago.type"
										style="width: 100%;">
									<option value="0">Seleccione un Tipo de pago</option>
									<option v-for="pay in pay_types"
											:value="pay.id"
											v-text="pay.pago">
									</option>
								</select>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
                                <label>Banco Emisor</label>
                                <select :id="'conso_ope_no_ident_emi_bank_'+ope_no_ident.id+'_gi_'+general_index_conso+'_pg_'+index"
                                		:name="'conso_ope_no_ident_emi_bank_'+ope_no_ident.id+'_gi_'+general_index_conso+'_pg_'+index"
                                		class="form-control select2"
                                		style="width:100%"
                                		onchange="opebanks.$children[0].set_type_emi_bank(this, 'conso')" 
                                		:disabled="!dcon_pago.validate.b_emi">
                                    <option value="0" selected>Seleccione un Banco Emisor</option>
                                    <option class="item"
                                            v-for="emi in emisor_banks" 
                                            :value="emi.id"
                                            :selected="emi.id == dcon_pago.banco_emi">
                                            @{{emi.banco}}
                                    </option>
                                </select>
                            </div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
                                <label>Banco Receptor</label>
                                <select :id="'conso_ope_no_ident_recep_bank_'+ope_no_ident.id+'_gi_'+general_index_conso+'_pg_'+index"
                                		:name="'conso_ope_no_ident_recep_bank_'+ope_no_ident.id+'_gi_'+general_index_conso+'_pg_'+index"
                                		class="form-control select2"
                                		style="width:100%"
                                		onchange="opebanks.$children[0].set_type_recep_bank(this, 'conso')" 
                                		:disabled="!dcon_pago.validate.b_recep">
                                    <option value="0" selected>Seleccione un Banco Receptor</option>
                                    <option class="item"
                                            v-for="recep in receptor_banks" 
                                            :value="recep.id"
                                            :selected="recep.id == dcon_pago.banco_recep">
                                            @{{recep.banco}}
                                    </option>
                                </select>
                            </div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for=""><i class="fa fa-users"></i> Nro Operación </label>
								<input class="form-control"
										{{-- :id="'conso_ope_no_ident_nro_ope_pago_'+ope_no_ident.id+'_gi_'+general_index_conso+'_pg_'+index" --}}
										v-model="dcon_pago.nro_ope"
										type="number"
										:disabled="!dcon_pago.validate.n_ope">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for=""><i class="fa fa-users"></i> Abono</label>
								<input class="form-control text-red"
										v-model="dcon_pago.abono"
										type="number"
										@keyup="val_monto_pago_conso(index)"
										:disabled="!dcon_pago.validate.abn">
							</div>
						</div>
						<div class="col-sm-1">
							<button type="button" class="pull-right btn btn-danger" 
									style="margin-top: 24px;" 
									@click="delete_pago_conso(index)"
									:disabled="index == 0">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for=""><i class="fa fa-users"></i> Total abonado</label>
							<input class="form-control text-red" v-model="pag_con[general_index_conso].total_abono" type="text" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for=""><i class="fa fa-users"></i> Monto restante</label>
							<input class="form-control text-red" v-model="pag_con[general_index_conso].resta" type="text" readonly >
						</div>
					</div>
					<div class="col-md-4">
						<button type="button"
								class="pull-right btn btn-warning"
								style="margin-top: 27px;"
								@click="reset_pagos('conso')"
								:disabled="pag_con[general_index_conso].btn_reset_pagos">
							<i class="fa fa-trash"></i>&nbsp;Reset
						</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="pull-left btn btn-secondary" 
						@click="close_modal_set_pago('conso')">
					<i class="fa fa-close"></i> Cerrar
				</button>
				<button type="button" class="pull-right btn btn-info" 
						@click="realizar_pagos('conso')"
						:disabled="pag_con[general_index_conso].monto == pag_con[general_index_conso].resta || pag_con[general_index_conso].resta < 0 || pag_con[general_index].total_abono > ope_no_ident.monto || pag_con[general_index].total_abono > monto_resta_general">
					<i class="fa fa-check"></i>&nbsp;Realizar pagos
				</button>
			</div>
		</div>
	</div>
</div>
{{-- MODAL CREAR FIN --}}