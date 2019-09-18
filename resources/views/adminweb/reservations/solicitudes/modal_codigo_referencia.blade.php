<div class="modal fade" id="codigo_referencia" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="width:112%;margin-left:0%">
            <div class="modal-header">
                <h4 class="modal-title">Aprobar Reservación</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="paquete_id" name="paquete_id" value="">
                <input type="hidden" id="codigo_paquete" name="codigo_paquete" value="">
                <div class="row">
                    <div class="col-md-12">
                        <b>Código de referencia del pago</b>
                        <div class="form-line">
                            <input  type="text"
                                    v-model="codigo_referencia"
                                    value=""
                                    class="form-control"
                                    placeholder="Ex: 0123456789"
                                    autofocus>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="pull-left btn btn-white" @click="closeModal('codigo_referencia')">Cerrar</button>
                <button @click.prevent="action('aprobar', 'info', 'btn-primary', sol.id)"
                        type="button"
                        class="pull-right btn btn-info"
                        title="Aprobar Solicitud"
                        data-toggle="tooltip"
                        :disabled="codigo_referencia.length < 5">
                    <i class="fa fa-check"></i> Aceptar
                </button>
            </div>
        </div>
    </div>
</div>