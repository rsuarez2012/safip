<div id="modal-categorias" class="modal" style="overflow: auto; ">
	<div role="document" class="modal-dialog modal-lg">
		<div class="modal-content" style="width: 500px; margin: auto;">
			<div class="modal-header">
				<h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
					<i class="fa fa-list"></i> Categorias de Hoteles
				</h4>
				<!--onclick="main_de_hoteles.cerrarModal()"-->
				<button  type="button" data-dismiss="modal" class="close">
					<span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			</div> 

			<div class="modal-body">
				<table class="table">
					<!--@ click="crearCategoria()" -->
					<button class="btn btn-danger pull-right" id="ad" style="margin-bottom: 5px;"><i class="fa fa-plus-circle"></i> Agregar Categoria</button>
				</table>
				<table class="table table-bordered table-hover" id="table2">
					<thead style="background-color: #dd4b39; color: #ffffff;">
						<tr>
							<th>Nombre</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody> 
						<!--v - for="categoria in categorias"-->
						@foreach($categorias as $categoria)
						<tr class="category_id{{$categoria->id}}">
							<!--@ {{-- categoria.nombre --}}-->
							<td>{{ $categoria->nombre }}</td>
							<td>
								<!---@ click="editarCategoria(categoria)"-->
								<button class="btn btn-xs btn-warning" data-id="{{$categoria->id}}"><i class="fa fa-pencil"></i></button>
								<!--@ click="eliminarCategoria(categoria.id)"-->
								<button class="btn btn-xs btn-danger" id="delete-category" data-id="{{$categoria->id}}" value=""><i class="fa fa-trash"></i></button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<!--onclick="main_de_hoteles.cerrarModal()" -->
				<button type="button" class="btn btn-secondary pull-left" id="cerrar">
					<i class="fa fa-close"></i> Cerrar
				</button>	
			</div>
		</div>
	</div>
</div>



<div id="addCategory" class="modal" style="overflow: auto; ">
	<div role="document" class="modal-dialog modal-lg">
		<div class="modal-content" style="width: 500px; margin: auto;">
			<div class="modal-header">
				<h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
					<i class="fa fa-list"></i> Categorias de Hoteles
				</h4>
				<!--onclick="main_de_hoteles.cerrarModal()"-->
				<button  type="button" data-dismiss="modal" class="close">
					<span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			</div> 

			<div class="modal-body">
				<form action="{{ url('/tablero/Hoteles/Admin/Categorias/Store') }}" method="POST">
					{!! csrf_field() !!}
					<label>Nombre de la Categoria</label>
					<input type="text" name="nombre" id="nombre" class="form-control">
					
			</div>
			<div class="modal-footer">
				<!--onclick="main_de_hoteles.cerrarModal()"-->
				<button  type="button" class="btn btn-secondary pull-left" id="cc">
					<i class="fa fa-close"></i> Cerrar
				</button>

				<button type="submit" id="ac" class="btn btn-danger pull-right">
					<i class="fa fa-save"></i> Agregar
				</button>	
			</div>
				</form>
		</div>
	</div>
</div>
