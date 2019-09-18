@extends('layouts.master')
@section('titulo', 'Procesar Cotizacion')
@section('content')
<div class="box padding_box1 box-danger" id="div-procesar-cotizacion">
    <div id="wrapper">
        <div class="row">
            <div class="col-md-12">
                {{-- datos de la cotizacion --}}
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-ticket"></i> Datos de La Cotizacion</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <input id="valor_del_igv" type="hidden" value="{{$iva->iva}}">
                            <input type="hidden" id="id_cotizacion_boleto" value="{{ $cotizacion->id }}">
                            <div class="col-sm-3">
                                <label><i class="fa fa-ticket"></i> Numero de cotizacion</label>
                                <input type="number" class="form-control" value="{{ $cotizacion->count }}" disabled>
                            </div>
                            <div class="col-sm-3">
                                <label><i class="fa fa-user"></i> Informacion del agente</label>
                                <input type="text" class="form-control mayus" value="{{$cotizacion->users->nombres . "
                                    " . $cotizacion->users->apellidos}}"
                                    disabled>
                            </div>
                            <div class="col-sm-3">
                                <label><i class="fa fa-user"></i> Agencia de viajes</label>
                                <input type="text" class="form-control mayus" value="{{$agencia_viajes->nombre}}"
                                    disabled>
                            </div>
                            <div class="col-sm-3">
                                <label><i class="fa fa-users"></i> Pasajeros</label>
                                <input type="text" name="dato_cantidad_pasajeros" class="form-control mayus" value="{{$cotizacion->cantidad_pasajeros}}"
                                    disabled>
                            </div>
                            <div class="col-md-12">
                                <br>
                            </div>
                            <div class="col-sm-3">
                                <label><i class="fa fa-map"></i> Lugar de salida</label>
                                <input type="text" class="form-control" value="{{$cotizacion->d_ciudad_id}}" disabled>
                            </div>
                            <div class="col-sm-3">
                                <label><i class="fa fa-map"></i> Lugar de llegada</label>
                                <input type="text" class="form-control" value="{{$cotizacion->h_ciudad_id}}" disabled>
                            </div>
                            <div class="col-sm-3">
                                <label><i class="fa fa-calendar"></i> Fecha de salida</label>
                                <input type="text" class="form-control" value="{{$cotizacion->salida_at}}" disabled>
                            </div>
                            <div class="col-sm-3">
                                <label><i class="fa fa-calendar"></i> Fecha de llegada</label>
                                <input type="text" class="form-control" value="{{$cotizacion->llegada_at}}" disabled>
                            </div>
                            <div class="col-sm-3">
                                <br> @if ($cotizacion->ida_vuelta == 1)
                                <input name="radio_ida_vuelta" type="radio" checked>Ida y vuelta
                                <input name="radio_ida_vuelta" type="radio"> Solo ida @else
                                <input name="radio_ida_vuelta" type="radio">Ida y vuelta
                                <input name="radio_ida_vuelta" type="radio" checked> Solo ida @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Informacion del proveedor --}}
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-handshake-o"></i> Informacion del proveedor</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label><i class="fa fa-user"></i> Consolidador</label>
                                <select @change="buscarComision" v-model="informacion_proveedor.consolidador" name="dato_consolidador"
                                    class="form-control">
                                    @foreach ($consolidadores as $consolidador)
                                    <option value="{{$consolidador->id}}">{{$consolidador->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label><i class="fa fa-plane"></i> Aerolinea</label>
                                <select @change="buscarComision" v-model="informacion_proveedor.aerolinea" name="dato_aerolinea"
                                    class="form-control">
                                    @foreach ($lineas_aereas as $linea_aerea)
                                    <option value="{{$linea_aerea->id}}">{{$linea_aerea->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label><i class="fa fa-barcode"></i> Codigo</label>
                                <input @keyup="validarCodigo" v-model="informacion_proveedor.codigo" name="dato_codigo"
                                    class="form-control mayus" type="text">
                            </div>
                            <div class="col-sm-3">
                                <label><i class="fa fa-percent"></i> Comision (porcentaje)</label>
                                <input v-model="informacion_proveedor.comision" name="dato_comision" type="number" step="0.01"
                                    class="form-control" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                {{-- pasajeros --}}
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-users"></i> Pasajeros</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row" v-for="(persona,index) in lista_pasajeros">
                            {{--
                            <div class="col-sm-2">
                                <label>Empresa</label>
                                <input disabled type="text" value="QANTU TRAVEL" class="form-control">
                            </div> --}}
                            <div class="col-sm-1">
                                <label>T. Doc</label>
                                <select class="form-control" v-model="lista_pasajeros[index].tipo_doc" :disabled="lista_pasajeros[index].validate.dni_blocked">
                                    <option value="dni" selected>DNI</option>
                                    <option value="pasaporte">PASAPORTE</option>
                                    <option value="carnet extranjeria">CDE</option>
                                    <option value="permiso temporal">PTP</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>DNI / RUC / Pasaporte</label>
                                <form @submit.prevent="buscarEmpleado(index)">
                                    <div class="input-group">
                                        <input :disabled="lista_pasajeros[index].validate.dni_blocked" v-model="lista_pasajeros[index].cedula"
                                            type="text" class="form-control mayus" name="data_nombre_persona[]"
                                            placeholder="Buscar DNI/RUC">
                                        <span class="input-group-btn">
                                            <button :disabled="lista_pasajeros[index].validate.dni_blocked" type="submit"
                                                class="btn btn-danger btn-flat" data-toggle="tooltip" title="Buscar Pasajero"><i
                                                    class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-2">
                                <label>Nombres</label>
                                <input style="text-transform:uppercase" :id="'datos_nombre_'+index" v-model="lista_pasajeros[index].nombre"
                                    :disabled="lista_pasajeros[index].validate.dni_blocked" type="text" placeholder="Nombre"
                                    class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <label>Apellidos</label>
                                <input style="text-transform:uppercase" :id="'datos_apellido_'+index" v-model="lista_pasajeros[index].apellido"
                                    :disabled="lista_pasajeros[index].validate.dni_blocked" type="text" placeholder="Apellidos"
                                    class="form-control">
                            </div>
                            <div class="col-sm-1">
                                <label>Pasajero</label>
                                <select class="form-control" v-model="lista_pasajeros[index].tipo_pas" :disabled="lista_pasajeros[index].validate.passenger_type_blocked">
                                    <option value="adulto" selected>ADT</option>
                                    <option value="ninio">CNN</option>
                                    <option value="infante">INF</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>Tipo</label>
                                <select :id="'datos_tipo_'+index" class="form-control" v-model="lista_pasajeros[index].tipo"
                                    disabled>
                                    <option value="Directo">DIRECTO</option>
                                    <option value="Indirecto">INDIRECTO</option>
                                    <option value="Corporativo">CORPORATIVO</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>&nbsp;</label>
                                <br>
                                <button @click="modalProcesarCotizacion(persona,index)" disabled :id="'datos_procesar_'+index"
                                    class="btn btn-danger" data-toggle="tooltip" title="Procesar">
                                    <i class="fa fa-check"></i>
                                </button>
                                <button @click="modalDatosAdicionales(index)" disabled :id="'datos_adicionales_'+index"
                                    class="btn btn-danger" data-toggle="tooltip" title="Agregar datos adicionales">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button @click="clear_data(persona,index)" disabled :id="'clear_data_'+index" class="btn btn-danger"
                                    data-toggle="tooltip" title="Limpiar todos los Datos">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                {{-- boleto --}}
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-users"></i> Pasajeros</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table class="table">
                                    <thead style="background-color: #dd4b39;color:#fff">
                                        <tr>
                                            <th>Nro Ticket</th>
                                            <th>Neto</th>
                                            <th>Tarifa</th>
                                            <th>Comision agencia</th>
                                            <th>IGV</th>
                                            <th>Total</th>
                                            <th>Pago a consolidador</th>
                                            <th>Tarifa + FEE</th>
                                            <th>Utilidad</th>
                                            <th>Incentivo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(boleto,index) in lista_boletos" v-show="boleto.procesado">
                                            <td>@{{boleto.nro_ticket}}</td>
                                            <td>@{{boleto.neto}}</td>
                                            <td>@{{boleto.tarifa}}</td>
                                            <td>@{{boleto.comision}}</td>
                                            <td>@{{boleto.igv}}</td>
                                            <td>@{{boleto.total}}</td>
                                            <td>@{{boleto.pago_consolidador}}</td>
                                            <td>@{{boleto.tarifa_fee}}</td>
                                            <td>@{{boleto.utilidad}}</td>
                                            <td>0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                {{-- finalizar --}}
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-usd"></i> Forma de Pago</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
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
                </div>
                @include('cotizaciones.formulario.datos_adicionales')
                @include('cotizaciones.formulario.procesar_cotizacion')
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    IGV = '{!! $iva->iva !!}'
</script>
<script src="{{ asset('js/cotizaciones/procesar.js') }}"></script>
@endsection