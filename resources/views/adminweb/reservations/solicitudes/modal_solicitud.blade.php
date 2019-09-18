<div class="modal" id="solicitud_reservacion" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: auto;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Solicitud de Reservación.
                </h4>
                <button @click="closeModal('solicitud_reservacion')"  type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <h4>Resumen de Solicitud</h4>
                        <p><b>Codigo del Paquete:</b> @{{ paquete.codigo }}</p>
                        <p><b>Nombre del Paquete:</b> @{{ paquete.nombre }}</p>
                        <p><b>Destinos:</b> @{{ destinos }}</p>
                        <p><b>Codigo de la Reservación:</b> @{{ sol.code }}</p>
                        <p><b>Status de la Reservación:</b> <span v-if="sol.status == 'pending'">Pendiente</span><span v-if="sol.status == 'approved'">Aprobada</span><span v-if="sol.status == 'rejected'">Rechazada</span></p>
                        <p><b>Fecha y hora de Reservación:</b> @{{ sol.created_at }}</p>
                    </div>
                    <div class="col-sm-4">
                        <h4>Resumen de Pago</h4>
                        <p><b>Código de Referencia:</b> @{{ sol.codigo_referencia }}</p>
                        <p><b>Status de Pago:</b> @{{ sol.status_pago }}</p>
                        <p><b>Tipo de pago elegido:</b> @{{ sol.tipo_pago }}</p>
                        <template v-if="contact.length != 'undefined'">
                            <h4>Datos del Contacto:</h4>
                            <p><b>Nombre:</b @{{ people.name }}> @{{ people.lastname }}</p>
                            <p><b>Email:</b> @{{ contact.email }}</p>
                            <p><b>Telefono:</b> @{{ contact.phone }}</p>
                        </template>
                    </div>
                    <div class="col-sm-4">
                        <h4>Reservado por:</h4>
                        <p><b>RUC/RIF:</b> @{{ user.dni }}</p>
                        <p><b>Nombre:</b> @{{ user.name }} @{{ user.lastname }}</p>
                        <p><b>Email:</b> @{{ user.email }}</p>
                        <h4>Observaciónes:</h4>
                        <textarea v-model="sol.observacion" cols="35" rows="3" disabled></textarea>
                    </div>
                </div>
                <div class="row">
                    <h4 class="text-center" v-if="tickets.length > 0">Boletos</h4>
                    <div class="col-sm-12">
                        <table class="table table-sm" v-if="tickets.length > 0">
                            <thead style="background: red; color:white;">
                                <tr>
                                    <td>Tipo Doc.</td>
                                    <td>Documento</td>
                                    <td>Nombres</td>
                                    <td>Apellidos</td>
                                    <td>Nacionalidad</td>
                                    <td>Tipo</td>
                                    <td>Neto</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="ticket in tickets">
                                    <td v-text="ticket.people.type_document"></td>
                                    <td v-text="ticket.people.document"></td>
                                    <td v-text="ticket.people.name"></td>
                                    <td v-text="ticket.people.lastname"></td>
                                    <td v-text="ticket.people.nacionality"></td>
                                    <td v-text="ticket.type"></td>
                                    <td v-text="ticket.neto"></td>
                                </tr>
                            </tbody>
                            <tfoot style="background:red; color:white;">
                                <tr>
                                    <td colspan="6" style="text-align:center;">Total a Pagar</td>
                                    <td v-text="sol.total"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button @click="closeModal('solicitud_reservacion')"  type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cerrar</button>
                <button @click.prevent="action('rechazar', 'warning', 'btn-warning', sol.id)"
                        type="button"
                        class="pull-right btn btn-warning"
                        title="Cancelar Solicitud"
                        data-toggle="tooltip"
                        v-show="sol.status != 'rejected'">
                    <i class="fa fa-ban"></i> Rechazar
                </button>
                <button @click.prevent="aprobar"
                        type="button"
                        class="pull-right btn btn-info"
                        title="Aprobar Solicitud"
                        data-toggle="tooltip"
                        v-show="sol.status == 'pending'">
                    <i class="fa fa-check"></i> Aprobar
                </button>
            </div>
        </div>
    </div>
</div>