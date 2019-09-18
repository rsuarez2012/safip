@extends('layouts.master')
@section('titulo', 'Cotizaciones de Paquetes')

@section('css')
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div hidden="true" id="div-alerta" class="callout callout-danger" style="position: fixed;z-index: 999999;">
    </div>
    <div class="box  box-danger">
      <div class="box-header">
          <h2><i class="fa fa-cubes"></i> Cotizaciones de Paquetes</h2><hr>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <form id="form-cotizacion" method="post" action="{{ url('/tablero/Paquetes/Cotizaciones/store') }}">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for=""><i class="fa fa-plane"></i> Agencia de Viaje</label> 
                            <br>
                            <select required="true" class="form-control select2 select-agencia-id mayus" name="agencia_id" style="width: 95%;">
                                @foreach($agencias as $agencia)
                                <option value="{{$agencia->id}}">{{$agencia->nombre}}</option>
                                @endforeach
                            </select>
                            <a id="btn-nueva-agencia" class="btn-success btn text-center" data-toggle="tooltip" title="Configurar Nueva Agencia" style="width: 5%;float: right;" onclick="abrirModal()">+</a>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for=""><i class="fa fa-globe"></i> Seleccione el Pais</label>
                            <select required="true" class="form-control select2 mayus" name="pais_id" style="width: 100%;">
                                @foreach($paises as $pais)
                                <option value="{{$pais->id}}">{{$pais->paisnombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for=""><i class="fa fa-map"></i> Seleccione la Ciudad</label>
                            <select required="true" class="form-control select2 mayus" name="destino_id" style="width: 100%;">
                                @foreach($destinos as $destino)
                                <option value="{{$destino->id}}" >{{$destino->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for=""><i class="fa fa-user"></i> Nacionalidad</label>
                            <select required="true" class="form-control select2 mayus" name="nacionalidad" style="width: 100%;">
                                <option value="peruano">PERUANO</option>
                                <option value="comunidad">COMUNIDAD</option>
                                <option value="extranjero">EXTRANJERO</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                     <div class="form-group col-sm-6">
                        <label for=""><i class="fa fa-sign-in"></i> Fecha Salida</label>
                        <input class="form-control input-cotizacion mayus" required="true" type="date" name="fecha_salida">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for=""><i class="fa fa-sign-out"></i> Fecha Retorno</label>
                        <input class="form-control input-cotizacion mayus" required="true" type="date" name="fecha_retorno">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for=""><i class="fa fa-users"></i> Cantidad de Pasajeros</label>
                        <input class="form-control input-cotizacion mayus" type="number" required="true" placeholder="Minimo 1" name="cantidad" min="1" minlength="0">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for=""><i class="fa fa-eye"></i> Observaciones (Opcional)</label>
                        <textarea name="observacion" placeholder="Maximo 20 Caracteres..." maxlength="200" id="textarea-cotizacion" cols="30" rows="3" class="form-control mayus"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" id="crearCotizacion"><i class="fa fa-check"></i> Guardar Cotizacion</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>
@include("aviajes.modal_crear_counter");
@endsection

@section('script')
<script src="{{ asset("js/cotizaciones/crear_agencia_por_counter.js") }}"></script>
@endsection