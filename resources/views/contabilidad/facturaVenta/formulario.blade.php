@extends('layouts.master')
 
@section('titulo', 'Factura Venta')

@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->

@endsection
@section('script')

<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

@endsection

@section('content')
    <!-- contenido principal -->
<div class="container">
    <div  class="row  box" >
        <br/>
        <div class="col-sm-12">
        <h1>&nbsp;<i class="fa fa-money"></i>&nbsp;Modificar Registro</h1>
                                    <form method="POST" action="{{ route('managefacturaVenta-update-save-A') }}">
                                    	<input type="hidden" name="id" value="{{$registro->id}}">
                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <input type="date" name="fecha" required="" class="form-control" value="{{$registro->fecha}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Factura</label>
                                            <input type="text" name="factura" required="" class="form-control" value="{{$registro->factura}}">
                                        </div>
                                        <div class="form-group">
                                            <label>RUC</label>
                                            <input type="text" name="ruc" required="" class="form-control" value="{{$registro->ruc}}">
                                        </div>
                                        <div class="form-group has-feedback">
                                        <div class="form-group">
                                            <label>Usuario</label>
                                            <input type="text" name="usuario" required="" class="form-control" value="{{$registro->usuario}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Monto</label>
                                            <input type="number" step="0.01" name="monto" required="" class="form-control" value="{{$registro->monto}}">
                                        </div>
                                        <div class="form-group">
                                            <label>IGV</label>
                                            <input type="number" step="0.01" name="igv" required="" class="form-control" value="{{$registro->igv}}">
                                        </div>
                                        @if($registro->taza_cambio==1)
                                            <div class="hidden form-group">
                                                <label>Taza de Cambio</label>
                                                <input type="number" step="0.01" name="taza_cambio" required="" class="form-control" value="{{$registro->taza_cambio}}">
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label>Taza de Cambio</label>
                                                <input type="number" step="0.01" name="taza_cambio" required="" class="form-control" value="{{$registro->taza_cambio}}">
                                            </div>
                                        @endif
                                      <div class="form-actions">
                                        <button type="submit" class="btn btn-success pull-right">
                                            Guardar Cambios <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                        {!! csrf_field() !!}
                                       </div> 
                                    </form>                                                        
                                

                            </div>

</div>
</div>
@endsection

