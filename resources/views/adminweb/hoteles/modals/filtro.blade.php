  {{-- MODAL VENTA AGENCIA --}}
  <div class="modal" id="modalF" style="overflow-y: scroll;overflow: auto;">
        <div class="modal-dialog" role="document" style="margin: 10px auto;width: 100%;">
          <div class="modal-content">
            <div class="modal-header">
              <h3  class="modal-title" style="display: inline;"><i class="fa fa-filter"></i> Filtrar Hoteles </h3>
              <button type="button" onclick="cerrarModal()" class="close" data-dismiss="modal">
                <span aria-hidden="true"><i class="fa fa-close"></i></span>
              </button> 
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-8 col-sm-offset-2 ">
                  <form action="{{ route('manageHoteles-filtro-A') }}"  method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                      <label>Filtrar Por :</label>
                      <select onchange="verTipo()" class="form-control" name="tipo">
                          <option value="nombre" selected>Nombre Del Hotel</option>
                          <option value="destino">Destino</option>
                          <option value="categoria">Categoria</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <input placeholder="Nombre de Hotel" type="text" name="f_nombre" class="form-control"> 
                    </div>  
                    <div class="form-group" >
                        <select name="f_destino" class="form-control" style="display: none;">
                            @foreach ($destinos as $destino)
                            <option value="{{$destino->id}}">{{$destino->nombre}}</option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="f_categoria" class="form-control" style="display: none;">
                            @foreach ($categorias as $categoria)
                                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                            @endforeach
                        </select>
                    </div>      
                  </div>
                </div>
              </div>
              <div class="modal-footer">
               <button class="btn btn-success" type="submit">Buscar <i class="fa fa-search"></i></button>
             </form>
             <button onclick="cerrarModal()" type="button" class="pull-left btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
           </div>
         </div>
       </div>
     </div>
    