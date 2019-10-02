<div class="row">                        			
	<div class="col-sm-6">
		<div class="form-group">
			<label>Destinos</label>
			<input type="hidden" name="id" value="{{$paquete->id}}" id="paquete_id">
			<select class="form-control" name="destino" id="dest" style="width: 100%">
				<option value=''>Seleccione el destino</option>
				@foreach($destinos as $destino)
					<option value='{{ $destino->id }}_{{$destino->nombre}}'>{{ $destino->nombre }}</option>
				@endforeach
			</select>
		  <input type="hidden" name="nombre-destino" id="nombre-destino" value="">
      <input type="hidden" name="destino_id" id="destino_id">
		</div>

		
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label>Dias</label>
			<input type="number" name="noches" id="noches" class="form-control" value="0">
		</div>
		
		<button class="btn btn-danger pull-right" type="submit">Agregar</button>

	</div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-sm-12">
		<br />
			
		<table class="table table-bordered" id="destinos-select" >
			<thead>
				<tr>
					<th style="text-align: center;">Destinos</th>
					<th style="text-align: center;">Dias</th>
					<th style="text-align: center;">Acción</th>
				</tr>
			</thead>
			{{--$destinosP--}}
			<tbody>
				@foreach($destinosP as $destino)
				<tr class="destino_id{{ $destino->id }}">
					<td style="text-align: center;">
						<input type="hidden" name="destino-id"  id="destino-id">
						{{$destino->destino->nombre}}
					</td>
					<td style="text-align: center;">
						<input id="signup-token" name="_token" type="hidden" value="{{csrf_token()}}">
						<input type="number" name="cantidad" id="count-days" value="{{$destino->noches->cantidad}}">
					</td>
					<td style="text-align: center;">
						<!--<button class="btn btn-danger btn-sm"><i class="fa fa-trash" id="delete-dest" data-id="{{--$destino->id--}}"></i></button>-->
						<a type="button" class="btn btn-warning btn-xs" id="edit-dest" data-id="{{ $destino->noches->id }}"  data-dest="{{$destino->destino->id}}" data-edit="{{ $destino->id }}" data-toggle="tooltip" data-original-title="Editar Dias">
							<i class="fa fa-pencil"></i>
						</a>
						<a type="button" class="btn btn-danger btn-xs" id="delete-dest" data-dele="{{ $destino->id }}" data-toggle="tooltip" data-original-title="Eliminar Destino">
							<i class="fa fa-trash"></i>
						</a>						
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<label for="">Desea agregar hotel.?</label>
			<select class="form-control" id="opcion">
				<option value="no">NO</option>
				<option value="si">SI</option>
			</select>
		</div>
		
	</div>
	<div class="col-sm-6" style="display: block;" id="dest-hot">
		<div class="form-group" id="pru">
			<label for="">Destinos seleccionados</label>
			<select class="form-control desti" name="destino" id="hot-dest" style="width: 100%">
				<option value=''>Seleccione el destino</option>
				@foreach($destinosP as $destino)
					<option value='{{ $destino->destino_id }}' data-id="{{ $destino->destino_id }}" id="d-name">{{ $destino->destino->nombre }}</option>
				
				@endforeach
			</select>
		</div>
		
	</div>
	<div class="row">
		<div class="col-sm-12">
		
		<div class="form-group selector-hoteles" style="display: none;">
			<label>Hoteles</label>
			<select class="form-control" multiple="multiple" id="destinos-hoteles" name="hoteles[]">

				{{--@foreach($destinos as $destino)
					<optgroup label='{{$destino->nombre}}'>
					@foreach($destino->hoteles as $hotel)
						<option value='{{ $destino->id }}_{{ $hotel->id }}'>{{ $hotel->nombre.' '.$destino->id }}</option>
					@endforeach	
					</optgroup>
				@endforeach--}}
			</select>
			<br>
		</div>
		
	    </div>
	</div>
</div>


<div class="row">
	<div class="col-sm-12">
		<button id="btn-step2-hoteles" class="btn btn-danger pull-left" style="display: none" type="submit">Enlazar</button>
			{{--<a href="{{route('paquete.edit.paso3',$paquete)}}" class="btn btn-danger pull-right" id="next" data-id="{{$paquete->id}}">Siguiente</a>--}}
			<button class="btn btn-danger pull-right" id="next" data-id="{{$paquete->id}}">Siguiente</button>
			
	</div>
</div>