
@extends('layouts.master')
@section('titulo', 'Procesar Cotizacion')
@section('css')

<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection


@section('content')

<div class="row">
  <div class="col-xs-12">
    <div hidden="true" id="div-alerta" class="callout callout-danger" style="position: fixed;z-index: 999999;">
    </div>
    <div class="box">
      <div class="box-header">
        <div class="x_title">
          <h2 ><i class="fa fa-check-square-o"></i> Procesar Cotizacion N° {{$cotizacion->id}} <img src="{{asset('imagenes/cargando.gif')}}" hidden="" id="cargando" alt=""></h2><hr>
        </div>
      </div>
      <div class="box-body">
        {{-- INFORMACION DE COTIZACION --}}
        <div class="col-sm-10 col-sm-offset-1">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="glyphicon glyphicon-piggy-bank"></i> Informacion De Cotizacion</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Desplegar">
                  <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="col-sm-4">
                  <label><i class="fa fa-plane"></i> Agencia de Viaje</label>
                  <input class="form-control" type="text" readonly="" value="{{$cotizacion->agencia->nombre}}">
                </div>
                <div class="col-sm-4">
                  <label><i class="fa fa-globe"></i> Pais</label>
                  <input class="form-control" type="text" readonly="" value="{{$cotizacion->pais->Paisnombre}}">
                </div>
                <div class="col-sm-4">
                  <label><i class="fa fa-map"></i> Ciudad Destino</label>
                  <input class="form-control" type="text" readonly="" value="{{$cotizacion->destino->nombre}}">
                </div>
                <div class="col-sm-4">
                  <label><i class="fa fa-user"></i> Nacionalidad</label>
                  <input class="form-control" type="text" readonly="" value="{{$cotizacion->nacionalidad}}">
                </div>
                <div class="col-sm-4">
                  <label><i class="fa fa-sign-out"></i> Fecha Salida</label>
                  <input class="form-control" type="text" readonly="" value="{{$cotizacion->fecha_salida}}">
                </div>
                <div class="col-sm-4">
                  <label><i class="fa fa-sign-in"></i> Fecha Retorno</label>
                  <input class="form-control" type="text" readonly="" value="{{$cotizacion->fecha_retorno}}">
                </div>
                <div class="col-sm-4">
                  <label><i class="fa fa-users"></i> Cantidad de Pasajeros</label>
                  <input name="input_cantidad_pasajeros" class="form-control" type="text" readonly="" value="{{$cotizacion->pasajero}}">
                </div>
                <div class="col-sm-4">
                  <label><i class="fa fa-eye"></i> Observaciones</label>
                  <textarea class="form-control" type="text" readonly="">{{$cotizacion->observacion}}</textarea>
                </div> 

                <div class="col-sm-4">
                  <label><br>
                    <input id="agencia" type="radio"
                    name="tventa" value="agencia">
                    <label for="agencia">Agencia</label>
                    <input id="ventad" type="radio"
                    name="tventa" value="venta">
                    <label for="venta directa">  Venta directa</label>
                  </label>
                </div>   
              </div>

            </div>
          </div>
          {{-- FIN INFORMACION DE COTIZACION --}}

          {{-- INFORMACION DEL PROVEEDOR --}}
          <div class="col-sm-10 col-sm-offset-1" style="display: none;" id="divInfoProv">
            <div class="box collapsed-box box-danger" id="divInfoProv">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-handshake-o"></i> Informacion De Proveedor</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                <div class="col-sm-3">
                  <label><i class="fa fa-trucks"></i> Proveedor</label>
                  <input class="form-control" readonly="" value="Qantu Travel"  type="text" name="proveedor_nombre">
                </div>
                <div class="col-sm-3">
                  <label><i class="fa fa-barcode"></i> Codigo Paquete</label>
                  <input class="form-control" type="text" name="codigo_paquete">
                </div>
                <div class="col-sm-3 text-center">
                  <button id="buscar-paquete" style="margin-top: 25px;" class="btn btn-danger"><i class="fa fa-search"></i> Buscar</button>
                </div>
                <div class="col-sm-3">
                  <label><i class="fa fa-list-alt"></i> Nombre Paquete</label>
                  <input class="form-control" readonly=""  type="text" name="nombre_paquete">
                </div>
              </div>
            </div>
          </div>
          {{-- FIN INFORMACION DEL PROVEEDOR --}} 

          {{-- HOTELES --}}
          <div class="col-sm-10 col-sm-offset-1" style="display: none;" id="divHoteles">
            <div class="box collapsed-box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-building"></i> Hoteles</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                <div class="table-responsive" style="max-height: 300px;overflow: auto;overflow-y: scroll;">
                  <table class="table table-bordered tabe-hover" id="tabla-enlazados" ></table>
                </div>
              </div>
            </div>
          </div>
          {{-- FIN HOTELES --}}


          {{-- PASAJEROS --}}
          <div class="col-sm-10 col-sm-offset-1" style="display: none;" id="divPasajeros">
            <div class="box collapsed-box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-hotel"></i> Habitaciones Y Pasajeros</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
               <div class="row  text-center">
                <div class="col-xs-4">
                  <label for=""><i class="fa fa-th-large"></i> Habitaciones Disponibles</label>
                  <input class="form-control" readonly="" type="number" name="cantidad_habitaciones" min="1" max="5" value="{{$cotizacion->pasajero}}">
                </div>
                <div class="col-xs-4">
                  <label for=""><i class="fa fa-list"></i> Tipo De Habitacion</label>
                  <select class="form-control" name="tipo_habitacion">
                    <option value="1">Simple</option>
                    <option value="2">Doble</option>
                    @if($cotizacion->pasajero > 2)
                    <option value="3">Triple</option>
                    @endif
                  </select>
                </div>
                <div class="col-xs-4">
                  <label for="" style="display: block;">Agregar</label>
                  <button class="btn btn-danger" id="agregar-habitaciones"><i class="fa fa-plus-circle"></i></button>
                </div>
              </div>
              <hr>
              <div id="zona_habitaciones">
              </div>
              
            </div>
          </div>
        </div>
        {{-- FIN PASAJEROS --}}

        {{-- BOLETOS PAQUETES --}}
        <div class="col-sm-10 col-sm-offset-1" style="display: none;" id="divInfoPaquete">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-cube"></i> Informacion Del Paquete</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              {{-- TABLA DE BOLETOS --}}
             <div class="row  text-center">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tabla-venta-paquete">
                  <thead class="btn-danger">
                    <tr>
                      <th>N°</th>
                      <th>Cliente</th>
                      <th>Cotizacion</th>
                      <th>Hotel</th>
                      <th>Tipo</th>
                      <th>Neto</th>
                      <th>Comision</th>
                      <th>10%</th>
                      <th>Incentivo</th>
                      <th>total</th>
                      <th class="varian">Tarifa + FEE</th>
                      <th class="varian">Utilidad</th>               
                      <th class="varian">Total de Utilidad</th>
                      <th>A Pagar</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody></tbody>     
                </table>
              </div>
              {{-- FIN TABLA BOLETOS --}}
            </div>
            <hr>
            <div class="row">
               {!! csrf_field() !!}
              <div class="col-xs-12 text-center col-sm-4">
                <label>Total A Pagar</label>
                <input type="number" step="0.01" class="form-control" readonly value="0" name="total_a_pagar">
              </div>
              <div class="col-xs-12 text-center col-sm-4">
                <label style="display: block;">Metodo de Pago</label>
                <button disabled id="boton-modal-pago" class="btn btn-danger"><i class="fa fa-money"></i> Seleccionar</button>
              </div>
              <div class="col-xs-12 text-center col-sm-4">
                <label style="display: block;">Procesar</label>
                <button id="boton-finalizar-procesar-cotizacion" disabled class="btn btn-danger"><i class="fa fa-arrow-circle-right"></i> Finalizar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- FIN BOLETOS PASAJEROS --}}
    </div>



  </div>


</div>
<!-- /.box -->
<!-- /.collapse1 -->
</div>
</div>

</div>
</div>
</div>

{{-- MODAL FORMA DE PAGO --}}
@include('adminweb.paquetes.cotizacion.proceso.comun.fpago')
@include('adminweb.paquetes.cotizacion.proceso.qantu.modales.agencia')
{{-- MODAL DE PASAJEROS  --}}
@include('adminweb.paquetes.cotizacion.proceso.comun.pasajeros')
{{-- MODAL DE VENTA DIRECTA --}}
@include('adminweb.paquetes.cotizacion.proceso.qantu.modales.vdirecta')
{{-- MODAL VENTA A UNA AGNECIA --}}

@endsection

@push('scripts')
<script src="{!! asset('js/paquetes/proceso/qantu.js') !!}"></script>
<script>
 $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
 $(function () {
  $('#pasajeros').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true
  });
});
 var APP_URL = {!!json_encode(url('/'))!!};
</script>
@endpush

