@extends('layouts.master')
  @section('titulo', 'Procesar Cotizacion')
  
  @section('content')
  <div id="main_otro">  
    {{-- informacion --}}
    <div class="row">
      <div class="col-sm-12">
        {{-- box --}}
        <div class="box box-danger">
          {{-- box header --}}
          <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-piggy-bank"></i> Informacion De Cotizacion</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Desplegar">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          {{-- box body --}}
          <div class="box-body">
            <input type="hidden" id="cotizacion_id" value="{{$cotizacion->id}}">
            <div class="col-sm-4">
              <label><i class="fa fa-plane"></i> Agencia de Viaje</label>
              <input value="{{$cotizacion->agencia->nombre}}" type="text" readonly class="form-control mayus">
            </div>
            <div class="col-sm-4">
              <label><i class="fa fa-map"></i> Ciudad Destino</label>
              <input value="{{$cotizacion->pais->paisnombre}}" type="text" readonly class="form-control mayus">
            </div>
            <div class="col-sm-4">
              <label><i class="fa fa-user"></i> Nacionalidad</label>
              <input value="{{$cotizacion->nacionalidad}}" type="text" readonly class="form-control mayus">
            </div>
            <div class="col-sm-4">
              <label><i class="fa fa-sign-out"></i> Fecha Salida</label>
              <input value="{{$cotizacion->fecha_salida}}" type="text" readonly class="form-control mayus">
            </div>
            <div class="col-sm-4">
              <label><i class="fa fa-sign-in"></i> Fecha Llegada</label>
              <input value="{{$cotizacion->fecha_retorno}}" type="text" readonly class="form-control mayus">
            </div>
            <div class="col-sm-4">
              <label><i class="fa fa-users"></i> Cantidad Pasajeros</label>
              <input id="cantidad_pasajeros" value="{{$cotizacion->pasajero}}" type="text" readonly class="form-control mayus">
            </div>
            <div class="col-sm-4">
              <label><i class="fa fa-eye"></i> Observacion</label>
              <textarea  class="form-control mayus" type="text" readonly="">
                {{$cotizacion->observacion}}
              </textarea>
            </div>
          </div>
          {{-- fin box-body --}}
        </div>
        {{-- fin box --}}
      </div>
    </div>
    {{-- informacion del proveedor --}}
    <div class="row">
      <div class="col-sm-12">
        {{-- box --}}
        <div class="box box-danger">
          {{-- box header --}}
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-handshake-o"></i> Informacion Del Proveedor</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Desplegar">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          {{-- box body --}}
          <div class="box-body">
            <div class="col-sm-4">
              <label><i class="fa fa-building"></i> Agencia de Viaje</label>
              <select id="select-proveedores" class="form-control mayus select2" onchange="main_otro.setProveedor()">
                <option value="" selected>Seleccione un Proveedor</option>  
                @foreach($proveedores as $proveedor)
                <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-4">
              <label><i class="fa fa-usd"></i> Comision</label>
              <input  type="text" v-model="datos_venta.comision" class="form-control mayus">
            </div>
            <div class="col-sm-4">
              <label><i class="fa fa-money"></i> Tipo De Venta</label>
              <br>
              <input @click="verPasajeros('directa')" v-model="datos_venta.tipo_venta" value="directa" type="radio"> Venta directa
              <input @click="verPasajeros('agencia')" v-model="datos_venta.tipo_venta" value="agencia" type="radio"> Agencia
            </div>
          </div>
          {{-- fin box-body --}}
        </div>
        {{-- fin box --}}
      </div>
    </div>
    {{-- Pasajeros --}}
    <template v-if="ver_pasajeros">
    <div class="row">
      <div class="col-sm-12">
        {{-- box --}}
        <div class="box box-danger">
          {{-- box header --}}
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-handshake-o"></i> Pasajeros</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Desplegar">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          {{-- box body --}}
          <div class="box-body">
            <div class="row" v-for="(pasajero,index) in pasajeros">
              <div class="col-sm-1">
                <label>T. Doc</label>
                <select class="form-control" v-model="pasajero.tipo_documento">
                  <option value="dni">DNI</option>
                  <option value="pasaporte">PASAPORTE</option>
                  <option value="carnet extranjeria">CDE</option>
                  <option value="permiso temporal">PTP</option>
                </select>
              </div>
              <div class="col-sm-2">
                <label>DNI / RUC / Pasaporte</label>
                <form @submit.prevent="buscarPasajero(index)">
                  <div class="input-group">
                    <input :disabled="pasajero.block_dni" v-model="pasajero.dni"
                    type="text" class="form-control mayus" 
                    placeholder="Buscar DNI/RUC">
                    <span class="input-group-btn">
                      <button  type="submit" :disabled="pasajero.block_dni"
                      class="btn btn-danger btn-flat" data-toggle="tooltip" title="Buscar Pasajero"><i
                      class="fa fa-search"></i></button>
                    </span>
                  </div>
                </form>
              </div>
              <div class="col-sm-2">
                <label>Nombres</label>
                <input v-model="pasajero.nombres" style="text-transform:uppercase" type="text" placeholder="Nombre"
                class="form-control" :disabled="pasajero.block_input">
              </div>
              <div class="col-sm-2">
                <label>Apellidos</label>
                <input v-model="pasajero.apellidos" style="text-transform:uppercase"
                type="text" placeholder="Apellidos"
                class="form-control" :disabled="pasajero.block_input">
              </div>
              <div class="col-sm-1">
                <label>Pasajero</label>
                <select v-model="pasajero.pasajero" class="form-control" {{-- :disabled="pasajero.block_input" --}}>
                  <option value="adulto" selected>ADT</option>
                  <option value="ninio">CNN</option>
                  <option value="infante">INF</option>
                </select>
              </div>
              <div class="col-sm-2">
                <label>Tipo</label>
                <select v-model="pasajero.tipo"  class="form-control" {{-- :disabled="pasajero.block_input" --}}>
                <option value="Directo">DIRECTO</option>
                <option value="Indirecto">INDIRECTO</option>
                <option value="Corporativo">CORPORATIVO</option>
              </select>
            </div>
            <div class="col-sm-2 text-center">
              <label>&nbsp;</label>
              <br>
              <button @click="modalProcesar(index)"  :disabled="pasajero.block_procesar" 
              class="btn btn-danger" data-toggle="tooltip" title="Procesar">
              <i class="fa fa-check"></i>
            </button>
          <button @click="limpiarDatos(index)" :disabled="pasajero.block_button" class="btn btn-danger"
          data-toggle="tooltip" title="Limpiar todos los Datos">
          <i class="fa fa-trash"></i>
        </button>
      </div>
    </div>
    </template>
    {{-- Boletos --}}
    <template v-if="ver_boletos">
      <div class="row">
        <div class="col-sm-12">
          {{-- box --}}
          <div class="box box-danger">
            {{-- box header --}}
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-ticket"></i> Paquetes</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Desplegar">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            {{-- box body --}}
            <div class="box-body">
             <div class="table-responsive">
                <table class="table text-center table-hovered table-bordered">
                  <thead>
                    <tr>
                      <th>Boleto N°</th>
                      <th>Neto </th>
                      <th>Incentivo</th>
                      <th>Comision del proveedor</th>
                      <th>Tarifa+FEE</th>
                      <th>Utilidad</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(boleto,index) in boletos" v-if="boleto.procesado">
                      <td>@{{index+1}}</td>
                      <td>@{{boleto.neto}}</td>
                      <td>@{{boleto.incentivo}}</td>
                      <td>@{{boleto.comision}}</td>
                      <td>@{{boleto.tarifa_fee}}</td>
                      <td>@{{boleto.utilidad}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>  
    </template>
    {{-- Forma de Pago --}}
    <template v-if="ver_boletos">
      <div class="row">
        <div class="col-sm-12">
          {{-- box --}}
          <div class="box box-danger">
            {{-- box header --}}
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-bank"></i> Forma de Pago</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Desplegar">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            {{-- box body --}}
            <div class="box-body">
             <div class="row">
                            <div class="col-md-3">
                                <label>Total a pagar</label>
                                <input v-model="datos_pago.total_pagar" type="number" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Tipo de pago</label>
                                <select @change="cambiarTipoPago" class="form-control" v-model="datos_pago.tipo">
                                    @foreach ($tipo_pagos as $index => $pago)
                                    <option value="{{$pago->id}}">{{$pago->pago}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Monto a cancelar</label>
                                <div class="input-group">
                                    <input @keyup="calcularTotal" :disabled="datos_pago.disable_monto" v-model="datos_pago.monto_cancelar"
                                        type="text" class="form-control" name="" placeholder="Monto a pagar">
                                    <span class="input-group-btn">
                                        <button @click="pagarTodo" :disabled="datos_pago.disable_monto" type="submit"
                                            class="btn btn-danger btn-flat" data-toggle="tooltip" title="Cancelar Todo"><i
                                                class="fa fa-bank"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Restante</label>
                                <input type="number" class="form-control" disabled v-model="datos_pago.restante">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Banco emisor</label>
                                <select :disabled="datos_pago.disable_datos_banco" class="form-control" v-model="datos_pago.banco_emisor">
                                    @foreach ($bancosg as $index => $banco)
                                    <option value="{{$banco->id}}">{{$banco->banco}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Banco receptor</label>
                                <select :disabled="datos_pago.disable_datos_banco" class="form-control" v-model="datos_pago.banco_receptor">
                                    @foreach ($bancos as $index => $banco)
                                    <option selected value="{{$banco->id}}">{{$banco->banco}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Numero Operacion</label>
                                <input :disabled="datos_pago.disable_datos_banco" type="text" class="form-control"
                                    v-model="datos_pago.nro_operacion">
                            </div>
                            <div class="col-md-3">
                                <label>Dias para pagar</label>
                                <input type="number" class="form-control" :disabled="datos_pago.disable_dias_para_pagar"
                                    v-model="datos_pago.dias_para_pagar">
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-danger pull-right" @click="finalizarProcesar">Finalizar <i class="fa fa-arrow-circle-right"></i></button>
            </div>  
    </template>
    @include("adminweb.paquetes.cotizacion.proceso.otro.directa")
  </div>
  @endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>
<script src="{{asset("js/venta-paquete/otro.js")}}"></script>
@endpush
</div>