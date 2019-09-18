<div id="modal-categorias" class="modal" style="overflow: auto; ">
	<div role="document" class="modal-dialog modal-lg">
		<div class="modal-content" style="width: 500px; margin: auto;">
			<div class="modal-header">
				<h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
					<i class="fa fa-list"></i> Categorias de Hoteles
				</h4>
				<button onclick="main_de_hoteles.cerrarModal()" type="button" data-dismiss="modal" class="close">
					<span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			</div> 

			<div class="modal-body">
				<table class="table">
					<button @click="crearCategoria()" class="btn btn-danger pull-right" style="margin-bottom: 5px;"><i class="fa fa-plus-circle"></i> Agregar Categoria</button>
				</table>
				<table class="table table-bordered table-hover" id="tabla-categorias">
					<thead style="background-color: #dd4b39; color: #ffffff;">
						<tr>
							<th>Nombre</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody> 
						<tr v-for="categoria in categorias">
							<td>@{{ categoria.nombre }}</td>
							<td>
								<button class="btn btn-xs btn-warning" @click="editarCategoria(categoria)"><i class="fa fa-pencil"></i></button>
								<button class="btn btn-xs btn-danger" @click="eliminarCategoria(categoria.id)"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button onclick="main_de_hoteles.cerrarModal()" type="button" class="btn btn-secondary pull-left">
					<i class="fa fa-close"></i> Cerrar
				</button>	
			</div>
		</div>
	</div>
</div>