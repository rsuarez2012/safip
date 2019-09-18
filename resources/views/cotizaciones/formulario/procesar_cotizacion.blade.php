<div class="modal" id="modal-procesar-cotizaciones" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="margin: auto;width: 650px;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Procesar Boleto
                </h4>
                <button @click="cerrarModal()" type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12"><p class="btn btn-info col-sm-12" id="dni_azul"></p></div>
                    <div class="col-sm-12"><p class="btn btn-info col-sm-12 mayus"  id="persona_azul"></p></div>
                    <hr>    
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nro Ticket</label>
                            <input v-model="lista_boletos[indice_adicionales].nro_ticket" type="text" class="form-control">
                        </div>
                    </div>    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Total</label>
                            <input  v-model="lista_boletos[indice_adicionales].total" type="number" disabled step="0.001" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Neto</label>
                            <input @keyup="calcularMontos" v-model="lista_boletos[indice_adicionales].neto" type="number" step="0.001" class="form-control">
                        </div>
                    </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label>Pago a consolidador</label>
                            <input v-model="lista_boletos[indice_adicionales].pago_consolidador" type="number" disabled step="0.001" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tarifa</label>
                            <input @keyup="calcularMontos" v-model="lista_boletos[indice_adicionales].tarifa" type="number" step="0.001" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tarifa + FEE</label>
                            <input @keyup="calcularMontos" v-model="lista_boletos[indice_adicionales].tarifa_fee" type="number" step="0.001" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Comision Agencia</label>
                            <input v-model="lista_boletos[indice_adicionales].comision" type="number" disabled  step="0.001" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Utilidad</label>
                            <input v-model="lista_boletos[indice_adicionales].utilidad" type="number" disabled step="0.001" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>IGV</label>
                            <input v-model="lista_boletos[indice_adicionales].igv" type="number" disabled step="0.001" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Incentivo</label>
                            <input value="0" type="number" disabled step="0.001" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button @click="cerrarModal()" type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cerrar</button>
                <button  @click="procesarBoleto()" class="btn btn-success pull-right">
                    Registrar <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </div>
    </div>  
</div>
