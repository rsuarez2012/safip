
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
                <input type="hidden" name="cotizacion_id" value="{{$cotizacion->id}}">
                <input class="form-control mayus" type="text" readonly="" value="{{$cotizacion->agencia->nombre}}">
              </div>
              <div class="col-sm-4">
                <label><i class="fa fa-globe"></i> Pais</label>
                <input class="form-control mayus" type="text" readonly="" value="{{$cotizacion->pais->Paisnombre}}">
              </div>
              <div class="col-sm-4">
                <label><i class="fa fa-map"></i> Ciudad Destino</label>
                <input class="form-control mayus" type="text" readonly="" value="{{$cotizacion->destino->nombre}}">
              </div>
              <div class="col-sm-4">
                <label><i class="fa fa-user"></i> Nacionalidad</label>
                <input class="form-control mayus" type="text" readonly="" value="{{$cotizacion->nacionalidad}}">
              </div>
              <div class="col-sm-4">
                <label><i class="fa fa-sign-out"></i> Fecha Salida</label>
                <input class="form-control mayus" type="text" readonly="" value="{{$cotizacion->fecha_salida}}">
              </div>
              <div class="col-sm-4">
                <label><i class="fa fa-sign-in"></i> Fecha Retorno</label>
                <input class="form-control mayus" type="text" readonly="" value="{{$cotizacion->fecha_retorno}}">
              </div>
              <div class="col-sm-4">
                <label><i class="fa fa-users"></i> Cantidad de Pasajeros</label>
                <input class="form-control mayus" type="text" readonly="" name="input_cantidad_pasajeros" value="{{$cotizacion->pasajero}}">
              </div>
              <div class="col-sm-4">
                <label><i class="fa fa-eye"></i> Observaciones</label>
                <textarea class="form-control mayus" type="text" readonly="">{{$cotizacion->observacion}}</textarea>
              </div> 


            </div>

          </div>
        </div>
        {{-- FIN INFORMACION DE COTIZACION --}} 

        {{-- INFORMACION DEL PROVEEDOR --}}
        <div class="col-sm-10 col-sm-offset-1" >
          <div class="box collapsed-box box-danger" id="div_prov_CInfoProv">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-handshake-o"></i> Informacion De Proveedor</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <div class="box-body ">
              <div class="row">
                <div class= "col-xs-12 " style="margin-left: 25%;">
                  <div class="col-xs-4">
                    <label ><i class="fa fa-building"></i> Proveedor</label>
                    <select name="proveedores_nombre" id="proveedor" class=" form-control mayus">
                     <option value="">seleccione el proveedor</option>
                     @foreach($consolidadores as $consolidador)
                     <option value="{{$consolidador->id}}">{{$consolidador->nombre}}</option>
                     @endforeach
                   </select>
                 </div>
                 <div class="col-xs-3">
                  <label>
                    <label >Tipo de Venta:</label><br>
                    <input type="radio"  id="prov_ventad"
                           name="tventa" value="venta directa">
                    <label for="prov_ventad">  Venta directa</label>

                    <input type="radio" id="prov_agencia"
                           name="tventa" value="agencia">
                    <label for="prov_agencia">Agencia</label>
                  </label>
                </div> 
              </div>  
            </div>
          </div>
        </div>
      </div>
      {{-- FIN INFORMACION DEL PROVEEDOR --}}



      {{-- PASAJEROS --}}
      <div class="col-sm-10 col-sm-offset-1" style="display: none;" id="div_prov_PPasajeros">
        <div class="box collapsed-box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-users"></i>  Pasajeros</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            @for($i=0 ; $i < $cotizacion->pasajero ; $i++)
            <p class="hidden" id="cantidad_pasajeros" value="{{ $cotizacion->pasajero }}"></p>
            <div class="row renoval" style="margin-left: 18%;" id="{{$i+1}}">
              <div class="col-sm-4">
                <label ><i  class="fa fa-user"></i> Pasajero</label><br>
                <button class='btn btn-danger abrirPasajeros' >Seleccionar Pasajero</button>
              </div>
              <div class="col-sm-3">
                <label ><i class="fa fa-list-alt"></i> Nacionalidad</label>
                <select name="" id="" class="form-control mayus">
                  <option value="Peruano" >PERUANO</option>
                  <option value="Comunidad">COMUNIDAD</option>
                  <option value="Extranjero">EXTRAJERO</option>
                </select>
              </div>
              <div class="col-sm-2">
                <label  style="display: block;"><i class="fa  fa-wrench"></i>Acciones</label>
                  <button name="procesarp" disabled="true" title="Procesar" data-toggle="tooltip" class="abriragencia btn btn-danger btn-xs"><i class="fa fa-cog"></i></button>
                  <button name="eliminar" title="Eliminar" data-toggle="tooltip" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></button>
              </div>
            </div>
            <hr>
            @endfor
          </div>
        </div>
      </div>
      {{-- FIN PASAJEROS --}} 

      {{-- INFORMACION DEL PAQUETE --}}
      <div class="col-sm-10 col-sm-offset-1" id="div_prov_PInfoPaquete" style="display: none;">
        <div class="box collapsed-box box-danger">
          <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-cubes"></i> Informacion del Paquete</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
          <div class="row">
           <div class="col-sm-2 pull-right">
                <label style="display: block;">Metodo de Pago</label>
                <button disabled id="boton-modal-pago" class="btn btn-danger"><i class="fa fa-money"></i> Seleccionar</button>
              </div> 
              </div><br> 

              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tabla_op-venta-paquete">
                <thead class="btn-danger">
                  <tr>
                    <th>Nro</th>
                    <th>Neto</th>
                    <th>Comision de Agencia</th>
                    <th>10%</th>
                    <th>Incentivo</th>
                    <th class="mostrar">Tarifa + FEE</th>
                    <th class="mostrar">Utilidad</th>            
                    <th class="mostrar">Total de Utilidad</th>
                    <th>SubTotal</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                 </table>
              </div>
              <div class="form-group row  ">
              <div>
                <label class="col-sm-1 control-label">Total: </label>
                <div class="col-sm-2">
                  <input type="text" name="total_post_proces" class="form-control" readonly="" value="0">
                </div>
              </div>
              <div>
                <label class="col-sm-2 control-label"> Total a pagar: </label>
                <div class="col-sm-2">
                  <input type="text" id="total_a_pagar" name="total_a_pagar" class="form-control" disabled="true" value="0">
                </div>
              </div>
             
              <div class=" col-sm-2">
                <button disabled id="boton-finalizar-procesar-cotizacion_otros_prov" class="btn btn-danger "><i class="fa fa-arrow-circle-right"></i> Guardar</button>
              </div>
            </div>

          </div>
        </div>
      </div>
      {{-- FIN INFORMACION DEL PAQUETE --}} 




    </div>

  </div>
  <!-- /.box -->
</div>

<!-- /.col xs 12 -->
</div>
<!-- /.row -->


{{-- MODAL DE PASAJEROS  --}}
@include('adminweb.paquetes.cotizacion.proceso.comun.pasajeros')
{{-- MODAL FORMA DE PAGO --}}
@include('adminweb.paquetes.cotizacion.proceso.comun.fpago')

{{-- MODAL VENTA AGENCIA --}}
@include('adminweb.paquetes.cotizacion.proceso.proveedor.modales.agencia')



@endsection

@push('scripts')
<script src="{!! asset('js/paquetes/proceso/qantu.js') !!}"></script>
<script src="{{ asset('js/paquetes/proceso/provedor.js') }}"></script>

<script>
 $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
 $(function(){
  $('[data-toggle="tooltip"]').tooltip();
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

