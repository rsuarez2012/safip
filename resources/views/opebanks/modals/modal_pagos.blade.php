{{-- MODAL PAGOS  --}}
<div class="modal" id="modal_pagos_deuda" style="overflow-y: scroll;overflow: auto;">
  	<div class="modal-dialog modal-pago-deudas" role="document">
    	<div class="modal-content" style="width: auto;margin: auto;">
      		<div class="modal-header">
        		<h4 id="titulo-modal-pagos" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Realizar pagos a deuda</h4>
        		<button type="button" class="cerrarCrear close" data-dismiss="modal">
        		  <span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body" >
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							  <label for=""><i class="fa fa-sign-in"></i> Fecha</label>
							  <input class="form-control" readonly type="date" v-model="deu_ag[general_index].fecha">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							  <label for=""><i class="fa fa-users"></i> Nro de Cotización</label>
							  <input class="form-control" v-model="deu_ag[general_index].nro_cot" type="number" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							  <label for=""><i class="fa fa-users"></i> Nro de Operación</label>
							  <input class="form-control" v-model="deu_ag[general_index].nro_ope" type="number" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							  <label for=""><i class="fa fa-users"></i> Nro de Ticket</label>
							  <input class="form-control" v-model="deu_ag[general_index].ticket" type="number" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for=""><i class="fa fa-users"></i> Monto a pagar</label>
							<input class="form-control text-red" v-model="deu_ag[general_index].monto" type="text" readonly >
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for=""><i class="fa fa-users"></i> Días por Cobrar</label>
							<input class="form-control" v-model="deu_ag[general_index].diasc" type="text" readonly >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="col-sm-5">
							Usar el monto que resta en la operación bancaria: 
							<input type="checkbox"
                                    id=""
                                    class="cl_check_full_price"
                                    @change="validate_full_price('deuda')"
                                    v-model="deu_ag[general_index].full_price"
                                    {{-- :value="monto_resta_general" --}}>
						</div>
						<div class="col-sm-3">
							<h4 class="text-center">PAGOS</h4>
						</div>
						<div class="col-sm-4">
							<button type="button"
									:id="'plus_deuda_'+general_index"
									class="pull-right btn btn-danger" 
									@click="create_pago_deuda"
									:disabled="deu_ag[general_index].resta <= 0">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" v-for="(dag_pago, index) in deu_ag[general_index].pagos">
						<div class="col-sm-2">
							<div class="form-group">
								<label>Tipo de Pago</label>
								<select class="form-control"
										:id="'ope_no_ident_pay_type_'+ope_no_ident.id+'_gi_'+general_index+'_pg_'+index"
										@change="val_pay_type(index)"
										v-model="dag_pago.type"
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
                                <select :id="'ope_no_ident_emi_bank_'+ope_no_ident.id+'_gi_'+general_index+'_pg_'+index"
                                		:name="'ope_no_ident_emi_bank_'+ope_no_ident.id+'_gi_'+general_index+'_pg_'+index"
                                		class="form-control select2"
                                		style="width:100%"
                                		onchange="opebanks.$children[0].set_type_emi_bank(this)" 
                                		:disabled="!dag_pago.validate.b_emi">
                                    <option value="0" selected>Seleccione un Banco Emisor</option>
                                    <option class="item"
                                            v-for="emi in emisor_banks" 
                                            :value="emi.id"
                                            :selected="emi.id == dag_pago.banco_emi">
                                            @{{emi.banco}}
                                    </option>
                                </select>
                            </div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
                                <label>Banco Receptor</label>
                                <select :id="'ope_no_ident_recep_bank_'+ope_no_ident.id+'_gi_'+general_index+'_pg_'+index"
                                		:name="'ope_no_ident_recep_bank_'+ope_no_ident.id+'_gi_'+general_index+'_pg_'+index"
                                		class="form-control select2"
                                		style="width:100%"
                                		onchange="opebanks.$children[0].set_type_recep_bank(this)" 
                                		:disabled="!dag_pago.validate.b_recep">
                                    <option value="0" selected>Seleccione un Banco Receptor</option>
                                    <option class="item"
                                            v-for="recep in receptor_banks" 
                                            :value="recep.id"
                                            :selected="recep.id == dag_pago.banco_recep">
                                            @{{recep.banco}}
                                    </option>
                                </select>
                            </div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for=""><i class="fa fa-users"></i> Nro Operación </label>
								<input class="form-control"
										{{-- :id="'ope_no_ident_nro_ope_pago_'+ope_no_ident.id+'_gi_'+general_index+'_pg_'+index" --}}
										v-model="dag_pago.nro_ope"
										type="number"
										:disabled="!dag_pago.validate.n_ope">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for=""><i class="fa fa-users"></i> Abono</label>
								<input class="form-control text-red"
										v-model="dag_pago.abono"
										type="number"
										@keyup="val_monto(index)"
										:disabled="!dag_pago.validate.abn">
							</div>
						</div>
						<div class="col-sm-1">
							<button type="button" class="pull-right btn btn-danger" 
									style="margin-top: 24px;" 
									@click="delete_pago_deuda(index)"
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
							<input class="form-control text-red" v-model="deu_ag[general_index].total_abono" type="text" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for=""><i class="fa fa-users"></i> Monto restante</label>
							<input class="form-control text-red" v-model="deu_ag[general_index].resta" type="text" readonly >
						</div>
					</div>
					<div class="col-md-4">
						<button type="button"
								class="pull-right btn btn-warning"
								style="margin-top: 27px;"
								@click="reset_pagos('deuda')"
								:disabled="deu_ag[general_index].btn_reset_pagos">
							<i class="fa fa-trash"></i>&nbsp;Reset
						</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="pull-left btn btn-secondary" 
						@click="close_modal_set_pago('deuda')">
					<i class="fa fa-close"></i> Cerrar
				</button>
				<button type="button" class="pull-right btn btn-info" 
						@click="realizar_pagos('deuda')"
						:disabled="deu_ag[general_index].monto == deu_ag[general_index].resta || deu_ag[general_index].resta < 0 || deu_ag[general_index].total_abono > ope_no_ident.monto || deu_ag[general_index].total_abono > monto_resta_general">
					<i class="fa fa-check"></i>&nbsp;Realizar pagos
				</button>
			</div>
		</div>
	</div>
</div>
{{-- MODAL CREAR FIN --}}