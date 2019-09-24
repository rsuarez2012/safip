<div class="row">                        			
	<div class="col-sm-6">
		<div class="form-group">
			<label>Destinos</label>
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
		<a class="btn btn-danger pull-right" type="" id="destino-seleccionado">Agregar</a>
	</div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-sm-12">
		<br />
			
		<table class="table table-bordered" id="destinos-select">
			<thead>
				<tr>
					<th style="text-align: center;">Destinos</th>
					<th style="text-align: center;">Dias</th>
					<th style="text-align: center;">Acción</th>
				</tr>
			</thead>
			<tbody>
				
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
	<div class="col-sm-6">
		<div class="form-group">
			<label for="">Destinos seleccionados</label>
			<select class="form-control" name="destino">
				@foreach($destinos as $destino)
					<option value='{{ $destino->id }}'>{{ $destino->nombre }}</option>
				@endforeach
			</select>
		</div>
		
	</div>
</div>


<div class="row">
	<div class="col-sm-12">
		<div class="form-group selector">
			<label>Destinos</label>
			<select class="form-control" multiple="multiple" id="destino" name="destino">
				@foreach($destinos as $destino)
					<option value='{{ $destino->id }}'>{{ $destino->nombre }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group selector-hoteles" style="display: none;">
			<label>Destinos</label>
			<select class="form-control" multiple="multiple" id="destinos-hoteles">
				@foreach($destinos as $destino)
					<optgroup label='{{$destino->nombre}}'>
					@foreach($destino->hoteles as $hotel)
						<option value='{{ $destino->id }}_{{ $hotel->id }}'>{{ $hotel->nombre.' '.$destino->id }}</option>
					@endforeach	
					</optgroup>
				@endforeach
			</select>
			<br>
		<a class="btn btn-danger pull-right" type="submit" id="">Enlazar</a>
		</div>
	</div>
</div>
{{--@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    alert("agregar");
  });
</script>
@endsection--}}