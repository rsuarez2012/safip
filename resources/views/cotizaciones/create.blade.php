@extends('layouts.master')
@section('titulo', 'Crear Cotizacion')


@section('content')
<div class="row">
  <div class="col-xs-12">
    <div hidden="true" id="div-alerta" class="callout callout-danger" style="position: fixed;z-index: 999999;">
    </div>
    <div class="box  box-danger">
      <div class="box-header">
        <h2><i class="fa fa-ticket"></i> Cotizaciones de Boleto</h2><hr>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
            <form role="form" method="POST" action="{{ route('manageCotizacion-store-A') }}">
              {!! csrf_field() !!}
        <div class="row">
          <div class="col-md-4">
            <label>Agencia de Viajes</label>
                  <select name="aviaje" required class="select-agencia-id form-control select2" style="width: 95%;">
                   @foreach($aviajes as $aviaje)
                   <option value="{{$aviaje->id}}">{{$aviaje->nombre}}</option>
                   @endforeach
                 </select>
                 <a id="btn-nueva-agencia" class="btn-success btn text-center" data-toggle="tooltip" title="Configurar Nueva Agencia" style="width: 5%;margin-right: -8px;float: right;" onclick="abrirModal()">+</a>
          </div>
          <div class="col-md-4">
            <label>Desde</label>
              <select name="salida" required class="form-control select2">
               @foreach($salidas as $salida)
               <option value="{{$salida->ciudadnombre}}">{{$salida->ciudadnombre}}</option>
               @endforeach
             </select>
          </div>
          <div class="col-md-4">
            <label>Hasta</label>
            <select name="llegada" required class="form-control select2">
              @foreach($llegadas as $llegada)
              <option value="{{$llegada->ciudadnombre}}">{{$llegada->ciudadnombre}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-md-4">
            <label>Fecha de Salida</label>
            <input required type="date" class="form-control" name="csalida" value="" placeholder="salida" >
          </div>
          <div class="col-md-4">
            <label>Fecha de llegada</label>
            <input type="date" class="form-control" name="cllegada" value="" placeholder="llegada" >
          </div>
          <div class="col-md-4">
            <label>Cantidad de pasajeros</label>
            <input required type="number" class="form-control mayus" name="cpasajero" value="" placeholder="Cantidad de Pasajeros">
          </div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-md-4">
            <label>Obervacion</label>
            <input type="text" class="form-control mayus" name="observacion" value="" placeholder="Observacion" >
          </div>
          <div class="col-md-4" style="margin-top: 2%;">
            <label>
              <span class="fa fa-exchange"></span>
              <input checked value="1" type="radio" name="tipo_recorrido" class="input_change_check" onclick="change_input()">Ida y Vuelta |
            </label>
            <label>
             <span class="fa fa-angle-double-right"></span>
             <input type="radio" value="0" name="tipo_recorrido" class="input_change_check" onclick="change_input()">Solo Ida |
           </label>
          </div>
        </div>
            <button type="submit" class="btn btn-success pull-right">
              Registrar <i class="fa fa-arrow-circle-right"></i>
            </button>
          </form>
  </div>
</div>
</div>
</div>

@include("aviajes.modal_crear_counter");
@endsection

@section('script')
<script src="{{ asset("js/cotizaciones/crear_agencia_por_counter.js") }}"></script>
@endsection