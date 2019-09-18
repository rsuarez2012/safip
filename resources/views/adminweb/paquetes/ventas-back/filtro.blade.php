  {{-- MODAL VENTA AGENCIA --}}
  <div class="modal" id="modalFiltro" style="overflow-y: scroll;overflow: auto;">
        <div class="modal-dialog" role="document" style="margin: 10px auto;width: 100%;">
          <div class="modal-content">
            <div class="modal-header">
              <h3  class="modal-title" style="display: inline;"><i class="fa fa-filter"></i> Filtros </h3>
              <button type="button" class="cerrarModal close" data-dismiss="modal">
                <span aria-hidden="true"><i class="fa fa-close"></i></span>
              </button> 
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-8 col-sm-offset-2 ">
                  <form action="{{route('manageVentaPaquete-filtro')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                      <label style="width: 50%;"><i class="fa fa-user"></i> Nombre</label>
                        <label><i class="fa fa-user-o"></i> Apellido</label>
                      <input placeholder="Nombre" type="text" name="nombre_filtro" class="form-control" style="width: 49%;float: left;margin-right: 2%;">
                      <input placeholder="Apellido"  type="text" name="apellido_filtro" class="form-control" style="width: 49%;">
                    </div>
                    <div class="form-group">
                      <label><i class="fa fa-plane"></i> Agencia de Viajes</label>
                      <select style="width: 100%;" class="form-control select2" name="agencia_filtro">
                        <option value="">Seleccione Una Agencia</option>
                       @foreach ($agencias as $agencia)
                      <option value="{{$agencia->id}}">{{$agencia->nombre}}</option>
                       @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                        <label style="width: 50%;"><i class="fa fa-calendar"></i> Desde</label>
                        <label><i class="fa fa-calendar"></i> Hasta</label>
                        <br>
                        <input value="{{date('Y-m-d')}}"  type="date" name="desde_filtro" class="form-control" style="width: 49%;float: left;margin-right: 2%;">
                        <input value="{{date('Y-m-d')}}"  type="date" name="hasta_filtro" class="form-control" style="width: 49%;">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
               <button class="btn btn-success" type="submit">Filtrar <i class="fa fa-search"></i></button>
             </form>
             <button type="button" class="pull-left btn cerrarModal btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
           </div>
         </div>
       </div>
     </div>
    