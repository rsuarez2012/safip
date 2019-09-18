{{-- MODAL PAGOS  --}}
<div class="modal" id="modal_sm_pagos" style="overflow-y: scroll;overflow: auto;">
  	<div class="modal-dialog modal-sm-pago-deudas" role="document">
    	<div class="modal-content" style="width: auto;margin: auto;">
      		<div class="modal-header">
        		<h4 id="titulo-modal-sm-pagos" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Realizar pagos a @{{ sm_pagos.length }} @{{ (ope_no_ident_type == 1) ? 'deudas de agencia' : 'deudas a consolidadores' }} seleccionadas</h4>
        		<button type="button" class="cerrarCrear close" data-dismiss="modal">
        		  <span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body" >
      			<div class="row">
      				<div class="col-md-3">
						<div class="form-group">
							<label for=""> Monto a pagar</label>
							<input class="form-control text-red" v-model="sm.monto" type="text" readonly >
						</div>
					</div>
					<div class="col-md-3">
                        <div class="form-group">
                            <label for="monto_ope">Monto Disponible</label>
                            <input type="text" v-model="ope_no_ident.monto" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="monto_ope">Usado en pagos</label>
                            <input type="text" v-model="monto_pagos_general" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="monto_resta_general">Resta por usar</label>
                            <input type="text" v-model="monto_resta_general.toFixed(2)" class="form-control" disabled>
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
                                    @change="validate_full_price('sm_deuda')"
                                    v-model="sm.full_price">
						</div>
						<div class="col-sm-3">
							<h4 class="text-center">PAGOS</h4>
						</div>
						<div class="col-sm-4">
							<button type="button"
									id="plus_sm_deuda"
									class="pull-right btn btn-danger" 
									@click="create_pago_sm"
									:disabled="sm.resta <= 0">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" v-for="(dag_pago, index) in sm.pagos">
						<div class="col-sm-2">
							<div class="form-group">
								<label>Tipo de Pago</label>
								<select class="form-control"
										:id="'sm_ope_no_ident_pay_type_'+ope_no_ident.id+'_pg_'+index"
										@change="val_pay_type_sm(index)"
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
                                <select :id="'sm_ope_no_ident_emi_bank_'+ope_no_ident.id+'_pg_'+index"
                                		:name="'sm_ope_no_ident_emi_bank_'+ope_no_ident.id+'_pg_'+index"
                                		class="form-control select2"
                                		style="width:100%"
                                		onchange="opebanks.$children[0].set_type_emi_bank_sm(this)" 
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
                                <select :id="'ope_no_ident_recep_bank_'+ope_no_ident.id+'_pg_'+index"
                                		:name="'ope_no_ident_recep_bank_'+ope_no_ident.id+'_pg_'+index"
                                		class="form-control select2"
                                		style="width:100%"
                                		onchange="opebanks.$children[0].set_type_recep_bank_sm(this)" 
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
										{{-- :id="'ope_no_ident_nro_ope_pago_'+ope_no_ident.id+'_pg_'+index" --}}
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
										@keyup="val_monto_sm(index)"
										:disabled="!dag_pago.validate.abn">
							</div>
						</div>
						<div class="col-sm-1">
							<button type="button" class="pull-right btn btn-danger" 
									style="margin-top: 24px;" 
									@click="delete_pago_sm(index)"
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
							<input class="form-control text-red" v-model="sm.total_abono" type="text" readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for=""><i class="fa fa-users"></i> Monto restante</label>
							<input class="form-control text-red" v-model="sm.resta" type="text" readonly >
						</div>
					</div>
					<div class="col-md-4">
						<button type="button"
								class="pull-right btn btn-warning"
								style="margin-top: 27px;"
								@click="reset_pagos('sm_deuda')"
								:disabled="sm.btn_reset_pagos">
							<i class="fa fa-trash"></i>&nbsp;Reset
						</button>
					</div>
				</div>
				<div class="row" v-show="ha_excedido_multi">
					<div class="col-md-12">
						<h5 class="text-center">Usted ha excedido el monto disponible, Ahora debe seleccionar las deudas y restarles el excedente de @{{ excedente_multi }}</h5>
					</div>
					<div class="col-lg-12">
                        <div style="margin-top: 1%;">
                            <table class="table table-bordered table-hover">
                                <thead class="table-danger">
                                    <tr>
                                        <th>FECHA DE REGISTRO</th>
                                        <th>PASAJERO</th>
                                        <th>AGENCIA DE VIAJES</th>
                                        <th>POR COBRAR</th>
                                        <th>CANT CANCELADA</th>
                                        <th>NVA CANT X PAGAR / EXCEDENTE RESTADO</th>
                                        <th>EXCEDENTE RESTANTE</th>
                                        <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(deuda_ag, index) in sm_pagos">
                                        <td v-text="deuda_ag.fecha"></td>
                                        <td v-text="deuda_ag.nombre_cliente"></td>
                                        <td v-text="deuda_ag.aviajes_id"></td>
                                        <td v-text="deuda_ag.porpagar"></td>
                                        <td v-text="deuda_ag.tarifa_fee"></td>
                                        <td v-text="">
                                        	<div class="form-group">
												<input class="form-control text-red" 
														type="number"
														v-model="deuda_ag.excedente"
														:id="'input_exced_'+index">
											</div>
                                        </td>
                                        <td v-text="excedente_multi_modif"></td>
                                        <td>
                                        	<button type="button" class="pull-right btn btn-green" 
													@click="val_monto_resta_sm(index)">
												<i class="fa fa-check"></i>
											</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="pull-left btn btn-secondary" 
						@click="close_modal_set_pago('sm_deuda')">
					<i class="fa fa-close"></i> Cerrar
				</button>
				<button type="button" class="pull-right btn btn-info" 
						@click="realizar_pagos('sm_deuda')"
						:disabled="sm.monto == sm.resta || sm.resta < 0 || excedente_multi_modif > 0">
					<i class="fa fa-check"></i>&nbsp;Realizar pagos
				</button>
			</div>
		</div>
	</div>
</div>
{{-- MODAL CREAR FIN --}}