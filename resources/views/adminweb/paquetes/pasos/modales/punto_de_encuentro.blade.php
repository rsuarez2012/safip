<div class="modal" id="punto_encuentro" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog" role="document">
        <div class="modal-content"   style="width: 600px;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-map-marker"></i> Seleccione Punto de Encuentro</h4>
                <button onclick="closeModal()" type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label form="">Nombre Del Punto de Encuentro</label>
                            <input type="text" id="nombre_punto" class="form-control">
                        </div>
                        <div class="form-group">
                            <label form="">Ubicacion del Punto de Encuentro</label>
                            <input type="text" id="searchmap" class="form-control" placeholder="Coloque la direccion">
                            <div id="map-canvas"></div>
                        </div>
                        <input type="hidden" name="lat" id="lat">
                        <input type="hidden" name="lng" id="lng">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal()" type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cerrar</button>
                <button onclick="setDataPoint()" class="btn pull-right btn-danger" type="submit"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>