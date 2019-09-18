<div class="x_content">

  <!-- modals -->
  <!-- Large modal -->
  <div class="modal services" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">Registrar Nuevo Servicio de Hotel</h4>
        </div>
        <div class="modal-body">
            <form action="{{route('servicios_hotel')}}" class="row" method="POST">
            	{!! csrf_field() !!}
                
                <div class="form-group col-md-12">
                  <input type="text" name="nombre" class="form-control" id="nombre" value="" required>
                    <small id="nameHelp" class="form-text text-muted">Nombre del Servicio</small>
                </div>
                <div class="form-group col-md-12">
                  <button type="submit" class="btn btn-sm btn-danger pull-right">Registrar</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>