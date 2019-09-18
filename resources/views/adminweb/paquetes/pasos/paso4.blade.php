    @extends('layouts.master')
    @section('titulo', 'Paso 4 - Datos Adicionales ')

    @section('content')

    <div hidden="true" id="div-alerta" class="callout callout-danger" style="position: fixed;z-index: 999999;">
    </div>
    <div class="row" id="main-paso4">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box padding_box1">
               <input type="hidden" id="paquete_id" value="{{$paquete->id}}">
                <div class="box-header">
                    <h3>
                        <i class="fa fa-list"></i> Datos Adicionales Del Paquete
                        <img id="img-alerta" hidden="true" width="30" height="30" src="{{asset('imagenes/cargando.gif')}}">
                        <a href="{{route('managePaquete-Finalizar-A',$paquete->id)}}" class="pull-right btn btn-danger"><i class="fa fa-check"></i> Finalizar</a>
                    </h3>
                    <div class="box-footer"></div>
                    
                </div>
                <hr>
                {{--<div class="box-header">
                    <div class="col-xs-4 text-center">
                        <select name="tipo_dato" class="form-control select2">
                            <option value="" class="default">Tipo de Dato</option>
                            <option value="incluido">Incluido</option>
                            <option value="noincluido">No Incluido</option>
                            <option value="llevar">Recomendaciones a Llevar</option>
                            <option value="importante">Notas Importantes</option>
                            <option value="politcareserva">Politicas De Reserva</option>
                            <option value="politicatarifa">Politicas De Nuestras Tarifas</option>
                            <option value="fechas">Fechas Especiales</option>
                            <option value="responsabilidades">Responsabilidades</option>
                        </select>
                    </div>
                    <div class="col-xs-4 text-center">
                        <textarea {{-- maxlength="230" --}} {{--v-model="new_dato" name="texto_dato" type="textarea" class="form-control" placeholder="Texto del Dato..."></textarea>
                    </div>
                    <div class="col-xs-4 text-center">
                        <button @click="crear_dato" class="btn btn-danger" data-toggle="tooltip" title="Agregar"><i class="fa fa-plus-circle"></i></button>
                        <button class="btn btn-danger" @click="openModal({{$paquete}})"  data-toggle="tooltip" title="Datos de otro paquete"><i class="fa fa-cube"></i></button>
                        <a target="_blank" href="{{-- url('/tablero/paso/4/print/enlazados/paquete/'.$paquete->id) --}}{{--" class="btn btn-danger" data-toggle="tooltip" title="Impirmir Paquete">
                            <i class="fa fa-print"></i></a>
                    </div>
                </div>
            </div>
            <hr>--}}

                {{-- INCLUIDOS --}}
            {{--<div class="col-xs-12 col-sm-6">
                <div class="box" style="box-shadow: 5px 5px 5px #666;">
                    <div class="bg-gray box-header with-border">Incluidos</div>
                    <table class="table">
                        <tr v-for="base_incluido in data_base_incluidos">
                            <td style="border-top:0;">
                                <input type="text" :id="base_incluido.id" class="form-control" :value="base_incluido.texto">
                            </td>
                            <td class="pull-right" style="margin-top:6px;border-top:0;">
                                <button class="btn btn-warning btn-xs" @click="editar_dato(base_incluido.id)">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-danger btn-xs" @click="eliminar_dato(base_incluido.id)">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>--}}

            {{-- NO INCLUIDOS --}}
            {{--<div class="col-xs-12 col-sm-6">
                <div class="box" style="box-shadow: 5px 5px 5px #666;">
                    <div class="bg-gray box-header with-border">No Incluidos</div>
                    <table class="table">
                        <tr v-for="base_noincluido in data_base_noincluidos">
                            <td style="border-top:0;">
                                <input type="text" :id="base_noincluido.id" class="form-control" :value="base_noincluido.texto">
                            </td>
                            <td class="pull-right" style="margin-top:6px;border-top:0;">
                                <button class="btn btn-warning btn-xs" @click="editar_dato(base_noincluido.id)">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-danger btn-xs" @click="eliminar_dato(base_noincluido.id)">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>--}}

            {{-- RECOMENDACIONES A LLEVAR --}}
            {{--<div class="col-xs-12 col-sm-6">
                <div class="box" style="box-shadow: 5px 5px 5px #666;">
                    <div class="bg-gray box-header with-border">Recomendaciones a Llevar</div>
                    <table class="table">
                        <tr v-for="base_llevar in data_base_llevars">
                            <td style="border-top:0;">
                                <input type="text" :id="base_llevar.id" class="form-control" :value="base_llevar.texto">
                            </td>
                            <td class="pull-right" style="margin-top:6px;border-top:0;">
                                <button class="btn btn-warning btn-xs" @click="editar_dato(base_llevar.id)">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-danger btn-xs" @click="eliminar_dato(base_llevar.id)">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>--}}

            {{-- NOTAS IMPORTANTES --}}
            {{--<div class="col-xs-12 col-sm-6">
                <div class="box" style="box-shadow: 5px 5px 5px #666;">
                    <div class="bg-gray box-header with-border">Notas Importantes</div>
                    <table  class="table">
                        <tr v-for="base_importante in data_base_importantes">
                            <td style="border-top:0;">
                                <input type="text" :id="base_importante.id" class="form-control" :value="base_importante.texto">
                            </td>
                            <td class="pull-right" style="margin-top:6px;border-top:0;">
                                <button class="btn btn-warning btn-xs" @click="editar_dato(base_importante.id)">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-danger btn-xs" @click="eliminar_dato(base_importante.id)">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>--}}

            {{-- POLITICAS DE RESERVA --}}
            {{--<div class="col-xs-12 col-sm-6">
                <div class="box" style="box-shadow: 5px 5px 5px #666;">
                    <div class="bg-gray box-header with-border">Politicas De Reserva</div>
                    <table class="table">
                        <tr v-for="base_politcareserva in data_base_politcareservas">
                            <td style="border-top:0;">
                                <input type="text" :id="base_politcareserva.id" class="form-control" :value="base_politcareserva.texto">
                            </td>
                            <td class="pull-right" style="margin-top:6px;border-top:0;">
                                <button class="btn btn-warning btn-xs" @click="editar_dato(base_politcareserva.id)">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-danger btn-xs" @click="eliminar_dato(base_politcareserva.id)">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>--}}

            {{-- POLITICAS DE NUETSRAS TARIFAS --}}
            {{--<div class="col-xs-12 col-sm-6">
                <div class="box" style="box-shadow: 5px 5px 5px #666;">
                    <div class="bg-gray box-header with-border">Politicas De Nuestras Tarifas</div>
                    <table class="table">
                        <tr v-for="base_politicatarifa in data_base_politicatarifas">
                            <td style="border-top:0;">
                                <input type="text" :id="base_politicatarifa.id" class="form-control" :value="base_politicatarifa.texto">
                            </td>
                            <td class="pull-right" style="margin-top:6px;border-top:0;">
                                <button class="btn btn-warning btn-xs" @click="editar_dato(base_politicatarifa.id)">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-danger btn-xs" @click="eliminar_dato(base_politicatarifa.id)">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>--}}

            {{-- FECHAS ESPECIALES --}}
            {{--<div class="col-xs-12 col-sm-6">
                <div class="box" style="box-shadow: 5px 5px 5px #666;">
                    <div class="bg-gray box-header with-border">Fechas Especiales</div>
                    <table class="table">
                        <tr v-for="base_fecha in data_base_fechas">
                            <td style="border-top:0;">
                                <input type="text" :id="base_fecha.id" class="form-control" :value="base_fecha.texto">
                            </td>
                            <td class="pull-right" style="margin-top:6px;border-top:0;">
                                <button class="btn btn-warning btn-xs" @click="editar_dato(base_fecha.id)">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-danger btn-xs" @click="eliminar_dato(base_fecha.id)">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>--}}

            {{-- RECOMENDACIONES A LLEVAR --}}
            {{--<div class="col-xs-12 col-sm-6">
                <div class="box" style="box-shadow: 5px 5px 5px #666;">
                    <div class="bg-gray box-header with-border">Responsabilidades</div>
                    <table class="table">
                        <tr v-for="base_responsabilidad in data_base_responsabilidades">
                            <td style="border-top:0;">
                                <input type="text" :id="base_responsabilidad.id" class="form-control" :value="base_responsabilidad.texto">
                            </td>
                            <td class="pull-right" style="margin-top:6px;border-top:0;">
                                <button class="btn btn-warning btn-xs" @click="editar_dato(base_responsabilidad.id)">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-danger btn-xs" @click="eliminar_dato(base_responsabilidad.id)">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        @include('adminweb.paquetes.pasos.modales.add_datos_a_paquete')--}}

        <!--raul-->
        <div class="row" id="main-paso4">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="box padding_box1">

                                           <input type="hidden" id="paquete_id" value="{{--$paquete->id--}}{{$dat}}">
                                            {{--<div class="box-header">
                                                <h3>
                                                    <i class="fa fa-list"></i> Datos Adicionales Del Paquete
                                                    <img id="img-alerta" hidden="true" width="30" height="30" src="{{asset('imagenes/cargando.gif')}}">
                                                    <a href="      {{route('managePaquete-Finalizar-A',$paquete_id)}}{{--$paquete->id--}}{{--" class="pull-right btn btn-danger"><i class="fa fa-check"></i> Finalizar</a>
                                                </h3>
                                                <div class="box-footer"></div>
                                            </div>
                                          </div>--}}

                        {{--<button class="btn btn-danger" @click="openModal({{$paquete}})"  data-toggle="tooltip" title="Datos de otro paquete"><i class="fa fa-cube"></i></button>--}}
                        <a target="_blank" href="{{ url('/tablero/paso/4/print/enlazados/paquete/'.$paquete->id) }}" class="btn btn-danger pull-right" data-toggle="tooltip" title="Impirmir Paquete">
                            <i class="fa fa-print"></i></a>
                            <br>
                                        <hr>
                                       <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                          <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                              <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                  Incluidos
                                                </a>
                                                <button class="btn btn-danger pull-right add" id="add" data-toggle="tooltip" data-toggle="modal" data-target="#editDepartament"data-id="incluido" title="Agregar"><i class="fa fa-plus-circle"></i></button>
                                                <div class="clearfix"></div>
                                              </h4>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                              <div class="panel-body">
                                                <table class="table">
                                                @foreach($datos as $dato)
                                                    <tr class="inclu{{ $dato->id }}">
                                                        <td style="border-top:0;">
      <input type="text" class="form-control" value="{{$dato->texto}}" id="{{ $dato->id }}">
                                                        </td>
                                                        <td class="pull-right" style="margin-top:6px;border-top:0;">
                                                            <button class="btn btn-warning btn-xs ed"  data-id="{{ $dato->id }}">
                                                                <i class="fa fa-edit"></i> Editar
                                                            </button>
                                                            <button class="btn btn-danger btn-xs dele-in" data-id={{ $dato->id }}>
                                                                <i class="fa fa-trash"></i> Eliminar
                                                            </button>
                                                            <input id="signup-token" name="_token" type="hidden" value="{{csrf_token()}}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTwo">
                                              <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                  Recomendaciones a llevar
                                                </a>
                                                <button class="btn btn-danger pull-right add" id="add" data-toggle="tooltip" data-toggle="modal" data-target="#editDepartament" data-id="llevar" title="Agregar"><i class="fa fa-plus-circle"></i></button>
                                                <div class="clearfix"></div>
                                              </h4>
                                            </div>
                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                              <div class="panel-body">
                                                <table class="table">
                                                @foreach($llevar as $lleva)
                                                    <tr class="inclu{{ $lleva->id }}">
                                                        <td style="border-top:0;">
                     <input type="text" class="form-control textO" value="{{$lleva->texto}}" id="{{ $lleva->id }}">
                                                        </td>
                                                        <td class="pull-right" style="margin-top:6px;border-top:0;">
                                                            <button class="btn btn-warning btn-xs ed"  data-id="{{ $lleva->id }}">
                                                                <i class="fa fa-edit"></i> Editar
                                                            </button>
                                                            <button class="btn btn-danger btn-xs dele-in" data-id={{ $lleva->id }}>
                                                                <i class="fa fa-trash"></i> Eliminar
                                                            </button>
                                                            <input id="signup-token" name="_token" type="hidden" value="{{csrf_token()}}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingThree">
                                              <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                  Politicas de reserva
                                                </a>
                                                <button class="btn btn-danger pull-right add" id="add-poli" data-toggle="tooltip" data-toggle="modal" data-target="#editDepartament"data-id="politcareserva" title="Agregar"><i class="fa fa-plus-circle"></i></button>
                                                <div class="clearfix"></div>
                                              </h4>
                                            </div>
                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                                <div class="panel-body">
                                                    <table class="table">
                                                    @foreach($politicas as $politica)
                                                        <tr class="inclu{{ $politica->id }}">
                                                            <td style="border-top:0;">
                  <input type="text" class="form-control" value="{{$politica->texto}}" id="{{ $politica->id }}">
                                                            </td>
                                                            <td class="pull-right" style="margin-top:6px;border-top:0;">
                                                               <button class="btn btn-warning btn-xs ed"  data-id="{{ $politica->id }}">
                                                                   <i class="fa fa-edit"></i> Editar
                                                               </button>
                                                               <button class="btn btn-danger btn-xs dele-in" data-id={{ $politica->id }}>
                                                                <i class="fa fa-trash"></i> Eliminar
                                                               </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="panel panel-default">
                                             <div class="panel-heading" role="tab" id="headingFour">
                                              <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                                  Fechas especiales
                                                </a>
                                                <button class="btn btn-danger pull-right add" id="add" data-toggle="tooltip" data-toggle="modal" data-target="#editDepartament"data-id="fechas" title="Agregar"><i class="fa fa-plus-circle"></i></button>
                                                <div class="clearfix"></div>
                                              </h4>
                                            </div>
                                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                              <div class="panel-body">
                                                <table class="table">
                                                @foreach($fechas as $fecha)
                                                    <tr class="inclu{{$fecha->id}}">
                                                        <td style="border-top:0;">
            <input type="text" class="form-control" value="{{$fecha->texto}}" id="{{$fecha->id}}">
                                                        </td>
                                                        <td class="pull-right" style="margin-top:6px;border-top:0;">
                                                            <button class="btn btn-warning btn-xs ed"  data-id="{{ $fecha->id }}">
                                                                   <i class="fa fa-edit"></i> Editar
                                                               </button>
                                                            <button class="btn btn-danger btn-xs dele-in" data-id={{ $fecha->id }}>
                                                                <i class="fa fa-trash"></i> Eliminar
                                                               </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="panel panel-danger">
                                            <div class="panel-heading" role="tab" id="headingFive">
                                              <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                  No incluidos
                                                </a>
                                                <button class="btn btn-danger pull-right add" id="add-noin" data-toggle="tooltip" data-toggle="modal" data-target="#editDepartament"data-id="noincluido" title="Agregar"><i class="fa fa-plus-circle"></i></button>
                                                <div class="clearfix"></div>
                                              </h4>
                                            </div>
                                            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                              <div class="panel-body">
                                                <table class="table">
                                                @foreach($noincluidos as $noincluido)
                                                    <tr class="inclu{{$noincluido->id}}">
                                                        <td style="border-top:0;">
      <input type="text" class="form-control" value="{{$noincluido->texto}}" id="{{$noincluido->id}}">
                                                        </td>
                                                        <td class="pull-right" style="margin-top:6px;border-top:0;">
                                                            <button class="btn btn-warning btn-xs ed" data-id="{{$noincluido->id}}">
                                                                <i class="fa fa-edit"></i> Editar
                                                            </button>
                                                            <button class="btn btn-danger btn-xs dele-in" data-id={{ $noincluido->id }}>
                                                                <i class="fa fa-trash"></i> Eliminar
                                                               </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="panel panel-danger">
                                            <div class="panel-heading" role="tab" id="headingSix">
                                              <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                  Notas importantes
                                                </a>
                                                <button class="btn btn-danger pull-right add" id="add-imp" data-toggle="tooltip" data-toggle="modal" data-target="#editDepartament"data-id="importante" title="Agregar"><i class="fa fa-plus-circle"></i></button>
                                                <div class="clearfix"></div>
                                              </h4>
                                            </div>
                                            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                              <div class="panel-body">
                                                <table class="table">
                                                @foreach($importantes as $importante)
                                                    <tr class="inclu{{$importante->id}}">
                                                        <td style="border-top:0;">
   <input type="text" class="form-control" value="{{$importante->texto}}" id="{{$importante->id}}">
                                                        </td>
                                                        <td class="pull-right" style="margin-top:6px;border-top:0;">
                                                            <button class="btn btn-warning btn-xs ed" data-id={{$importante->id}}>
                                                                <i class="fa fa-edit"></i> Editar
                                                            </button>
                                                            <button class="btn btn-danger btn-xs dele-in" data-id="{{$importante->id}}">
                                                                <i class="fa fa-trash"></i> Eliminar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="panel panel-danger">
                                            <div class="panel-heading" role="tab" id="headingSeven">
                                              <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseThree">
                                                  Politicas de nuestras tarifas
                                                </a>
                                                <button class="btn btn-danger pull-right add" id="add" data-toggle="tooltip" data-toggle="modal" data-target="#editDepartament"data-id="politicatarifa" title="Agregar"><i class="fa fa-plus-circle"></i></button>
                                                <div class="clearfix"></div>
                                              </h4>
                                            </div>
                                            <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                                              <div class="panel-body">
                                                <table class="table">
                                                @foreach($tarifas as $tarifa)
                                                    <tr class="inclu{{$tarifa->id}}">
                                                        <td style="border-top:0;">
         <input type="text" class="form-control" value="{{$tarifa->texto}}" id="{{$tarifa->id}}">
                                                        </td>
                                                        <td class="pull-right" style="margin-top:6px;border-top:0;">
                                                            <button class="btn btn-warning btn-xs ed" data-id="{{$tarifa->id}}">
                                                                <i class="fa fa-edit"></i> Editar
                                                            </button>
                                                            <button class="btn btn-danger btn-xs dele-in" data-id="{{$tarifa->id}}">
                                                                <i class="fa fa-trash"></i> Eliminar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="panel panel-danger">
                                            <div class="panel-heading" role="tab" id="headingEight">
                                              <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                                  Responsabilidades
                                                </a>
                                                <button class="btn btn-danger pull-right add" id="add" data-toggle="tooltip" data-toggle="modal" data-target="#editDepartament"data-id="responsabilidades" title="Agregar"><i class="fa fa-plus-circle"></i></button>
                                                <div class="clearfix"></div>
                                              </h4>
                                            </div>
                                            <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight">
                                              <div class="panel-body">
                                                <table class="table">
                                                @foreach($responsabilidades as $responsabilidad)
                                                    <tr class="inclu{{$responsabilidad->id}}">
                                                        <td style="border-top:0;">
<input type="text" class="form-control" value="{{$responsabilidad->texto}}" id="{{$responsabilidad->id}}">
                                                        </td>
                                                        <td class="pull-right" style="margin-top:6px;border-top:0;">
                                                            <button class="btn btn-warning btn-xs ed" data-id="{{$responsabilidad->id}}">
                                                                <i class="fa fa-edit"></i> Editar
                                                            </button>
                                                            <button class="btn btn-danger btn-xs dele-in" data-id="{{$responsabilidad->id}}">
                                                                <i class="fa fa-trash"></i> Eliminar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                              </div>
                                            </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="clearfix"></div>
                           </div>
    </div>


<!--raul-->
<div class="modal" id="editDepartament" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: auto;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Agregar datos</h4>
                <button @click="closeModal"  type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
         <form class="row" action="{{Route('r-data-add', 'paquete_id')}}" method="POST" id="addF" name="addF">
            {{--Quito el action del form --}}
                <div class="row">
                    <div class="col-sm-11">
                        {{-- csrf_field() --}}
                        <div class="form-group">
                            <input id="signup-token" name="_token" type="hidden" value="{{csrf_token()}}">
                           <input type="hidden" name="paquete_id" id="package_id">
                           <input type="hidden" name="tipo" id="tipo">


                           
                            <label class="text-dark" style="margin-left: 11px;">Descripción del dato</label>
                            <input type="text" class="form-control" placeholder="" onfocus name="texto" id="texto" style="margin-left: 11px">
                         
                        </div>
                    </div>
                    <!--<div class="col-sm-3" style="margin-top:24px;">
                        
                    </div>-->
                </div>
            <div class="modal-footer">
                <button @click="closeModal"  type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cerrar</button>
                <button class="btn btn-info pull-right" id="enviar">
                  <i class="fa fa-plus"></i> Agregar
               </button>
            </div>
         </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
     $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
      $('.add').on('click', function(){
         var paquete = $('#paquete_id').val();
         var tipo = $(this).attr('data-id');
         //alert(tipo);
         if(tipo == 'incluido'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);
            $('#enviar').click(function(event){
               var formID = '#addF';
               var table = $('.table').val({ajax: "/tablero/Admin/Paso/4/Agregar/Dato/"+paquete});
               $.ajax({
                  //url: $(formID).attr('action'),
                  method: $(formID).attr('method'),
                  data: $(formID).serialize(),
                  dataType: 'html',
                  success:function(data){
                     /*$('#table tbody').append('<tr class="inclu{{--$dato->id}}"><td style="border-top:0;"><input type="text" class="form-control" value="{{$dato->texto}}" id="{{$dato->id}}"></td><td class="pull-right" style="margin-top:6px;border-top:0;"><button class="btn btn-warning btn-xs ed" data-id="{{$dato->id}}"><i class="fa fa-edit"></i> Editar</button><button class="btn btn-danger btn-xs dele-in" data-id="{{$dato->id--}}"><i class="fa fa-trash"></i> Eliminar</button></td></tr>');*/
                     //$('#table tbody').append(data);
                     $('#table tbody').load(data);
                     toastr.success('Dato registrado con exito!.');
                  },
                  error:function(data){
                     console.log('Error:',data);
                  }
                  /*success: function(result){
                     if ($(formID).find("input:first-child").attr('value') == 'PUT') {
                        var $jsonObject = jQuery.parseJSON(result);
                        $(location).attr('href',$jsonObject.re);
                     }
                     else{
                        $(formID)[0].reset();
                        console.log('Ok');
                     }
                  },
                  error: function(){
                     console.log('Error');
                  }*/
               });

            })

         } else if(tipo == 'noincluido'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'llevar'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'politcareserva'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'importante'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'politicatarifa'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'fechas'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else if(tipo == 'responsabilidades'){
            $('#editDepartament').modal('show');
            $('.modal-body #package_id').val(paquete);
            $('.modal-body #tipo').val(tipo);

         } else {
         }
      });
      $('.dele-in').on('click', function () {
         var id = $(this).attr('data-id');
         confirm("Seguro de eliminar?");
         $.ajax({
            type:'DELETE',
            data: {
               //id: id,
               _token: $('#signup-token').val()
            },
            url:'/tablero/Admin/Paso/4/Eliminar/Dato/'+id,
            success: function(data){
               toastr.success('Dato Eliminado con exito!.');
               $('.inclu'+id).remove();
            },
            error:function(data){
               console.log('Error:',data);
            }
         });
      });
      $('.ed').on('click', function () {
         //textO
         var id = $(this).attr('data-id');
         var texto = $('#'+id).val();
         //alert(texto);
         if(texto ===""){
            toastr.success('Por favor ingrese el dato!.');
         }else{
            $.ajax({
               type:'POST',
               data: {
                  id: id,
                  _token: $('#signup-token').val(),
                  texto: texto,
               },
               url: '/tablero/Admin/Paso/4/Editar/Dato/'+id,
               success:function(data){
                  
                  toastr.success('Dato actualizado con exito!.');
               },
               error:function(data){
                  console.log('Error:',data);
               }
            });

         }


        
      })
   })
</script>
<script >
   $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
});
   var APP_URL = {!!json_encode(url('/'))!!};

</script>
<script src="{{asset('js/paquetes/paso4.js')}}"></script>

@endsection
@section('script')
<script type="text/javascript">
  
</script>
@endsection