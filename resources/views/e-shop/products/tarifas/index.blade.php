@extends('layouts.master')
@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('script')


<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<script type="text/javascript">

	$(document).ready(function(){

	});

</script>

@endsection
@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="box padding_box1">
			<div class="row">
				<h1> <i class="fa fa-map" style="margin-left: 1%;"></i> Destino {{strtoupper($destino->nombre)}}</h1>
			</div>
			<div class="row table-responsive">
				<table class="table text-center table-bordered">
					<caption><h2 style="margin-left: 1%;"> <i class="fa fa-hotel"></i>Hoteles</h2></caption>
					<thead>
						<tr>
							<th class="bg-black" rowspan="2" style="min-width: 200px;">NOMBRE HOTEL</th>
							<th class="bg-black" rowspan="2" style="min-width: 100px;">*</th>
							<th colspan="5" class="text-center bg-danger">EXTRANJERO</th>
							<th colspan="5" class="text-center bg-green">PERUANO</th>
							<th colspan="4" class="text-center bg-info">COMUNIDAD</th>
							<th rospan="2" class="bg-primary" rowspan="2">Check In</th>
							<th rospan="2" class="bg-primary" rowspan="2">Check Out</th>
							<th class="text-center bg-black" rowspan="2">AGREGAR</th>
									
						</tr>
						<tr>
							<th style="min-width: 100px;" class="bg-danger">SWD</th>
							<th style="min-width: 100px;" class="bg-danger">DWB</th>
							<th style="min-width: 100px;" class="bg-danger">TPL</th>
							<th style="min-width: 100px;" class="bg-danger">CHD</th>
							<th style="min-width: 100px;" class="bg-danger">Niño</th>
							<th style="min-width: 100px;" class="bg-green">SWD</th>
							<th style="min-width: 100px;" class="bg-green">DWB</th>
							<th style="min-width: 100px;" class="bg-green">TPL</th>
							<th style="min-width: 100px;" class="bg-green">CHD</th>
							<th style="min-width: 100px;" class="bg-green">Niño</th>
							<th style="min-width: 100px;" class="bg-info">SWD</th>
							<th style="min-width: 100px;" class="bg-info">DWB</th>
							<th style="min-width: 100px;" class="bg-info">TPL</th>
							<th style="min-width: 100px;" class="bg-info">CHD</th> 
						</tr>
						<tr>
							<form action="" method="POST">
								{{ csrf_field() }}
								<input type="hidden" name="destino" value="{{$destino->id}}">
								<th class="bg-black"><input required="" placeholder="Nombre del Hotel" name="nombre" type="text" class="form-control"></th>
								<th class="bg-black"><input required="" placeholder="*" name="estrella" type="text" class="form-control"></th>
								<th class="bg-danger"><input required="" placeholder="min 0" name="e_swd" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-danger"><input required="" placeholder="min 0" name="e_dwb" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-danger"><input required="" placeholder="min 0" name="e_chd" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-danger"><input required="" placeholder="min 0" name="e_tpl" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-danger"><input required="" placeholder="min 0" name="e_ninio" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-green"><input required="" placeholder="min 0" name="p_swd" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-green"><input required="" placeholder="min 0" name="p_dwb" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-green"><input required="" placeholder="min 0" name="p_chd" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-green"><input required="" placeholder="min 0" name="p_tpl" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-green"><input required="" placeholder="min 0" name="p_ninio" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-info"><input required="" placeholder="min 0" name="c_swd" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-info"><input required="" placeholder="min 0" name="c_dwb" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-info"><input required="" placeholder="min 0" name="c_chd" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-info"><input required="" placeholder="min 0" name="c_tpl" step="0.01" min="0" type="number" class="form-control"></th>
								<th class="bg-primary"><input type="date" class="form-control" required=""></th>
								<th class="bg-primary"><input type="date" class="form-control" required=""></th>
								<th>
									<button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="left" title="Agregar Hotel">Agregar <i class="fa fa-plus"></i></button>
								</th>
							</form>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@stop