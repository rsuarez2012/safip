
<div class="modal modalCategoria" style="overflow-y: auto;">
    <div class="modal-content">
        <div class="modal-body">
            <h3>LISTA DE CATEGORIAS</h3>
            <table class="table">
                <form method="POST" 
                      action="{{Route('manageOperadorCategoria-store-A')}}">
                    {!! csrf_field() !!}
                    <td>
                        <input class="form-control" required="" class="form-control"" name="nombre" type="text" placeholder="Categoria">
                    </td>
                    <td>
                        <button class="btn btn-danger" type="submit">Guardar<i class="fa fa-save"></i></button>
                    </td>
                </form>
            </table>
            <table class="table table-bordered" id="destinosTable">
                <thead>
                    <tr>
                        <th>CATEGORIAS</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($tipos as $categoria)
                    <tr>
                        <form method="POST" 
                              action="{{Route('manageOperadorCategoria-update-A')}}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="{{$categoria->id}}">
                            <td>
                                <input class="form-control" required class="form-control" name="nombre" type="text" value="{{$categoria->nombre}}">
                            </td>
                            <td>
                                <button class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="left" title="Editar"><i class="fa fa-edit"></i></button>
                                <a 
                                    href="{{ route('delete.categoria.operador', $categoria->id) }}"
                                    class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="left" title="Eliminar"><i class="fa fa-trash"></i></a>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="modal-footer">
                <button type="button" class="btn cerrarModal btn-warning" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>