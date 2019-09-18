{{-- MODAL LISTA DE PASAJEROS --}}
<div class="modal" id="modalPasajeros" style="overflow-y: scroll;overflow: auto;">
  <div class="modal-dialog" style="margin: 10px auto;width: 100%;" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h3  class="modal-title" style="display: inline;"><i class="fa fa-users"></i> Lista de Pasajeros <img src="{{asset('imagenes/cargando.gif')}}" hidden="" id="cargandoPasajero" alt=""></h3>
        <button type="button" class="cerrarPasajeros close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div class="row">
          <div class="col-xs-12">
            <div class="pull-right">
              <button class="btn btn-danger abrirNuevoPasajero"><i class="fa fa-plus-circle"></i> Nuevo Pasajero</button>
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <table id="pasajeros" class="table table-responsive table-bordered table-hover">
            <thead>
              <tr class="btn-danger">
                <th><i class="fa fa-check"></i> Seleccionar</th>
                <th><i class="fa fa-building"></i> Empresa</th>
                <th><i class="fa fa-list-alt"></i> DNI/RUC</th>
                <th><i class="fa fa-user"></i> Nombre</th>
                <th><i class="fa fa-user"></i> Apellido</th>
                <th><i class="fa fa-list"></i> Tipo</th>    
              </tr>
            </thead>
            <tbody>
              @foreach($pasajeros as $pasajero)
              <tr>
                <td><input type="radio" name="pasajero" value="{{$pasajero->id}}"></td>
                <td>Qantu Travel</td>
                <td>{{$pasajero->cedula_rif}}</td>
                <td>{{$pasajero->nombre}}</td>
                <td>{{$pasajero->apellido}}</td>
                <td>{{$pasajero->tipo_pasajero}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="pull-left btn btn-secondary cerrarPasajeros"><i class="fa fa-close"></i> Cancelar</button>
        <button type="button" id="asginar-pasajero" class="pull-right btn btn-danger"><i class="fa fa-user-plus"></i> Agregar</button>
      </div>
    </div>
  </div>
</div>
{{-- /MODAL LISTA DE PASAJEROS --}}



{{-- MODAL LISTA DE PASAJEROS --}}
<div class="modal" id="modalNuevoPasajero" style="overflow-y: scroll;overflow: auto;">
  <div class="modal-dialog" role="document" style="margin: 10px auto;width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <h3  class="modal-title" style="display: inline;"><i class="fa fa-user-plus"></i> Nuevo Usuario</h3>
        <button type="button" class="cerrarNuevoPasajero close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 ">
            <form id="form-nuevo-cliente"><br>
              {{csrf_field()}}
              <div class="form-group row">
                <div class="col-sm-12">
                  <label><i class="fa fa-building"></i> Empresa</label>
                  <select class="form-control select2 input_nuevo" name="empresa" style="width: 100%;">
                    <option value="1">Qantu Travel</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <label><i class="fa fa-list"></i> Tipo</label>
                  <select class="form-control input_nuevo" name="tipo">
                    <option value="Corporativo">Corporativo</option>
                    <option value="Directo">Directo</option>
                    <option value="Indirecto">Indirecto</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <label><i class="fa fa-user"></i> Nombre</label>
                  <input type="text" name="nombre" class="form-control input_nuevo" placeholder="Nombre">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <label><i class="fa fa-user"></i> Apellido</label>
                  <input type="text" name="apellido" class="form-control input_nuevo" placeholder="Apellido">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <label><i class="fa fa-list-alt"></i> DNI - RUC</label>
                  <input type="text" name="dni" class="form-control input_nuevo" placeholder="DNI">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <label><i class="fa fa-map"></i> Direccion (Opcional)</label>
                  <input type="text" name="direccion" class="form-control input_nuevo_opcional" placeholder="Direccion">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <label><i class="fa fa-phone"></i> Telefono (Opcional)</label>
                  <input type="text" name="telefono" class="form-control input_nuevo_opcional" placeholder="Telefono">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12">
                  <label><i class="fa fa-envelope"></i> Email</label>
                  <input type="email" name="email" class="form-control input_nuevo" placeholder="Email">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="pull-left btn btn-secondary cerrarNuevoPasajero"><i class="fa fa-close"></i> Cancelar</button>
        <button type="button" class="pull-right btn btn-danger" id="guardar-pasajero"><i class="fa fa-user-plus"></i> Agregar</button>
      </div>
    </div>
  </div>
</div>
