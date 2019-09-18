<div class="modal" id="modal-agencia" style="overflow-y: scroll;overflow: auto;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="width:auto;margin: auto;">
      <div class="modal-header">
        <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
          <i class="fa fa-plus"></i> Configurar agencia de viajes</h4>
          <button onclick="cerrarModal()" type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="form_crear_agencia_counter" onsubmit="crearAgencia(event)" role="form" method="POST" action="{{ route('manageAviaje-store-A') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="row">


              <div class="col-sm-6">
               <label >Empresa <i class="fa fa-building"></i></label>
               <select name="empresa" style="width: 100%;" required class="form-control select2">
                <option value="">Selecciona La Empresa</option>
                @foreach($empresas as $empresa)
                <option value="{{$empresa->id}}" selected="">{{$empresa->nombre}}</option>
                @endforeach
              </select>
            </div>



            <div class="col-sm-6">
             <label >Nombre <i class="fa fa-user"></i></label>
             <input required type="text" class="form-control mayus" name="nombre" value="" placeholder="Nombre" >
           </div>



           <div class="col-sm-6">
            <label >RUC <i class="fa fa-list"></i></label>
            <input required type="text" class="form-control mayus" name="rif" value="" placeholder="RUC" >
          </div>


          <div class="col-sm-6">
            <label >Direccion <i class="fa fa-map"></i></label>
            <input type="text" class="form-control mayus" name="direccion" value="" placeholder="Direccion"  maxlength="255">
          </div>

          <div class="col-sm-6">
            <label >Telefono <i class="fa fa-phone"></i></label>
            <input type="text" class="form-control mayus" name="telefono" value="" placeholder="Telefono">
          </div>


          <div class="col-sm-6">
            <label >Email <i class="fa fa-envelope"></i></label>
            <input required type="email" class="form-control mayus" name="email" value="" placeholder="Email">
          </div>

          <div class="col-sm-6">
            <label > Web Empresarial <i class="fa fa-chrome"></i></label>
            <input type="text" class="form-control mayus" name="web" value="" placeholder="Web Empresarial">
          </div>
          <div class="col-sm-6"> 
            <label >Descripcion</label>
            <input type="text" class="form-control mayus" name="descripcion" value="" placeholder="Descripcion">
          </div>
        </div>
        <div class="form-actions">
          <button onclick="cerrarModal()" type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cerrar</button>
          <button  type="submit" class="btn btn-success pull-right">
            Registrar <i class="fa fa-arrow-circle-right"></i>
          </button>
          <br>
        </div>
      </form>
    </div>
  </div>
</div>
</div>