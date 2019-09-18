@extends('layouts.master')
 
@section('titulo', 'Empleados')

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
        <h1>&nbsp;<i class="fa fa-money"></i>&nbsp;Modificar Registros</h1>
                                    <form method="POST" action="{{ route('managefacturaCompra-update-save-A') }}">
                                    	<input type="hidden" name="id" value="{{$registro->id}}">
                                        <div class="form-group">
                                            <label>Fecha de emision</label>
                                            <input type="date" name="emision" required="" class="form-control" value="{{$registro->emision}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo Documento</label>
                                            <input type="text" name="tipo" required="" class="form-control" value="{{$registro->documento}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Numero serie del comprobante</label>
                                            <input type="text" name="serie" required="" class="form-control" value="{{$registro->comp_pago_serie}}">
                                        </div>
                                        <div class="form-group has-feedback">
                                        <div class="form-group">
                                            <label>Numero del comprobante</label>
                                            <input type="text" name="numero" required="" class="form-control" value="{{$registro->comp_pago_numero}}">
                                        </div>
                                        <div class="form-group">
                                            <label>RUC</label>
                                            <input type="text" name="ruc" required="" class="form-control" value="{{$registro->ruc}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre o razon social</label>
                                            <input type="text" name="nombre" required="" class="form-control" value="{{$registro->nombre}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Adquis grabada</label>
                                            <input type="number" step="0.01" name="grabada" required="" class="form-control" value="{{$registro->adquis_grabada}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Adquis No grabada</label>
                                            <input type="number" step="0.01" name="nograbada" required="" class="form-control" value="{{$registro->adquis_no_grabada}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Monto del Impuesto</label>
                                            <input type="number" step="0.01" name="impuesto" required="" class="form-control" value="{{$registro->impuesto}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Taza de cambio</label>
                                            <input type="text" name="taza" required="" class="form-control" value="{{$registro->taza_cambio}}">
                                        </div>    
                                      </div>
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

