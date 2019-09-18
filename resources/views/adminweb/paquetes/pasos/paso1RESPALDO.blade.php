   
@extends('layouts.master')
@section('titulo', 'Datos Paquete - Paso 1')

@section('css')
<style>
    #map-canvas {
        width: 100%;
        height: 370px;
    }
    body > div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr > td.disabled{
        color: #aaa;
    }
    body > div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr > td.active{
        color:#fff;
        background-color: #d9534f;
    }
    th{
      text-align: center;
    }
</style>
@endsection
@section('content')  
{{-- id paquete --}}
@isset($paquete_id)
<input type="hidden" value="{{$paquete_id}}" id="pac">    
@endisset
<div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12" id="main-paso1">
      <div class="box box-danger">
        <div class="box-header">
            <h4><i class="fa fa-cube"></i>  @{{package.action}} Paquete  </h4>
            <a class="btn btn-danger pull-right" v-if="package.edit" href="{{route('manageProduct-A')}}">Volver</a> 
        </div>    
         <div class="box-body">

            <div class="col-sm-6 form-group">
                <label>Codigo Paquete</label>
                {{--<input :disabled="package.validated" class="form-control" v-model="package.code" type="text" placeholder="Codigo">--}}
                <input class="form-control" v-model="package.code" type="text" placeholder="Codigo" id="codigo">

                <label>Nombre Paquete</label>
                {{--<input class="form-control" v-model="package.name" type="text" placeholder="Nombre">--}}
                <input class="form-control" v-model="package.name" type="text" placeholder="Nombre" name="nombre" id="nombre">
            
                <label>Categoria Paquete</label>
                <select class="form-control" name="category" id="categoria">
                  @foreach($categorias as $category)
                    <option value="{{$category->id}}">{{$category->nombre}}</option>
                  @endforeach
                </select>
                {{--<select @change="changeCategory()" class="form-control" v-model="package.category" id="categoria" selected>
                    <template v-for="option in categories">
                        <option :value="option.id" selected>@{{option.nombre}}</option>    
                    </template>    
                    {{--<option v-for="option in categories" :value="option.id" :selected>@{{option.nombre}}</option>  
                </select>--}}
            
                <label>Zona</label>
                <select class="form-control" v-model="package.zone" id="zona">
                   <option value="costa" :selected="package.zone == 'costa'">Costa</option>
                   <option value="sierra" :selected="package.zone == 'sierra'">Sierra</option>
                   <option value="selva" :selected="package.zone == 'selva'">Selva</option>    
                </select>
            
                <label>Imagen Paquete</label>
                <input class="form-control" @change="processFile($event)" type="file" accept="image/*">
            </div>
            <div class="col-sm-6 form-group">
                <label>Imagen del paquete</label>
                <center>
                    
                    <img :src="'/web/images/paquetes/'+package.image" class="img-responsive" width="720px" height="80px">
                </center>
            </div>
            <div class="col-sm-6 form-group hidden">
                <label>Descripcion Corta</label>
                <input class="form-control " v-model="package.extrac" type="text" placeholder="extracto">
            </div>
            <div class="col-sm-6 form-group  hidden">
                <label>Descripcion Larga</label>
                <textarea class="form-control" v-model="package.description" placeholder="description"></textarea>
            </div>
            <div class="clearfix"></div>
            <button class="btn btn-danger pull-right" v-if="!package.edit && !package.validated" @click="validateCode()">Validar Codigo</button>
            <button class="btn btn-danger pull-right" v-else-if="!package.edit" @click="savePackage()">Guardar</button>
            <button class="btn btn-danger pull-right" v-else @click="savePackage()">Actualizar</button>
            <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="nav-tabs-custom tab-danger">
                        <ul class="nav nav-tabs">
                            <li class="active" v-if="package.category =='7'" >
                                <a href="#tab_1" data-toggle="tab"><i class="fa fa-calendar"></i> Fecha salida</a>
                            </li>
                            <li v-else="package.category !='7'">
                                <a href="#tab_1" data-toggle="tab"  disabled></a>
                            </li>
                            <li v-if="!package.edit">
                              <a href="#tab_1" data-toggle="tab"  disabled></a>
                            </li>
                            <li v-else>
                                <a href="#tab_2" data-toggle="tab"><i class="fa fa-list"></i> Datos adicionales</a>
                            </li>
                            
                        </ul>
                     </div>
                     <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                           <div class="panel panel-default" v-if="package.category !='7'">
                           </div>
                              <div class="panel panel-default" v-else="package.category =='7'">
                                 <div class="panel-heading" role="tab" id="headingOne">
                                    <div class="table-responsive">
                                       <div v-show="package.category == '7'">
                                          <div class="form-group col-sm-12 text-center">
                                             <label>Agregar Fecha de Salidas</label>
                                             <form action="#" @submit.prevent="addDate()">
                                                <div class="form-group col-xs-6 pull-right">
                                                   <label>Fechas</label>
                                                   <a class="btn btn-danger btn-block" onclick="showCalendar()"><i class="fa  fa-calendar-plus-o" ></i> Agregar fechas</a>
                                                   <input style="opacity: 0;width: 0px;height: 0px;" disabled type="text" name="dates_datepicker" class="date">
                                                </div>
                                                <div class="form-group col-xs-6 pull-right">
                                                   <label>Cupos</label>
                                                   <input type="number" v-model="quotas" class="form-control" placeholder="cupos">                           
                                                </div>
                                                <div class="form-group col-xs-6">
                                                   &nbsp;
                                                   <a class="btn btn-block btn-danger" id="button-modal-point" onclick="pointIn()">Punto de Encuentro</a>
                                                   <input id="actual_nombre" class="form-control" style="display: none" type="text" disabled>
                                                   
                                                </div>
                                                <div class="form-group col-xs-6 pull-right">
                                                   <button data-toggle="tooltip" style="float: left"  class="btn btn-danger col-xs-12" title="Agregar"><i class="fa fa-plus"></i>Guardar Salida</button>
                                                   
                                                </div>     
                                             </form>    
                                          </div> 
                                       </div> 
                                    </div>
                                 </div>
                                 <div class="panel-body">
                                    <table class="table" >
                                       <thead>
                                          <th>Fecha</th>
                                          <th>Lugar salida</th>
                                          <th>Cupos</th>
                                          <th style="text-align: center;">Accion</th>
                                       </thead>
                                       <tbody>
                                          <tr v-for="(item,index) in departures">
                                             <td :value="item.departure">
                                                <input style="width: 100%; text-align: center;" type="text" :value="item.departure" class="form-control" disabled >
                                             </td>
                                             <td>
                                                <input type="text" style="width: 100%;text-align: center;" disabled :value="item.point_name" class="form-control text-center">
                                             </td>
                                             <td><input style="width: 100%;text-align: center;" type="text" :value="item.quotas" class="form-control" disabled ></td>
                                             <td>
                                                   <button class="btn btn-round btn-danger" @click="deleteDate(index,item)" style="width: 100%;text-align: center;"><i class="fa fa-trash"></i> Eliminar Fecha</button> 
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                           <div class="table-responsive">
                                <div class="row" id="main-paso4">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="box padding_box1">
                                           <input type="hidden" id="paquete_id" value="{{--$paquete->id--}}{{$dat}}">
                                            <div class="box-header">
                                                <h3>
                                                    <i class="fa fa-list"></i> Datos Adicionales Del Paquete
                                                    <img id="img-alerta" hidden="true" width="30" height="30" src="{{asset('imagenes/cargando.gif')}}">
                                                    <a href="      {{route('managePaquete-Finalizar-A',$paquete_id)}}{{--$paquete->id--}}" class="pull-right btn btn-danger"><i class="fa fa-check"></i> Finalizar</a>
                                                </h3>
                                                <div class="box-footer"></div>
                                            </div>
                                          </div>
                                        <hr>
                                       <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                          <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                              <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                  Incluidos
                                                </a>
                                                <button class="btn btn-danger pull-right add" id="add" data-toggle="tooltip" data-toggle="modal" data-target="#editDepartament"data-id="incluido" title="Agregar"><i class="fa fa-plus-circle"></i>
                                                Agregar Datos Incluidos</button>
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
                                                               {{--@include('adminweb.paquetes.pasos.modales.add_datos_a_paquete')--}}
                        </div>
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </div>
</div>
                                  {{-- estas son las salidas del paquete<div class="form-group col-sm-6" v-for="(item,index) in departures">
                                        <div style="clear: both">
                                            <label>Salida Nº @{{index+1}}</label> <button class="btn btn-danger btn-xs pull-right" @click="deleteDate(index,item)"><i class="fa fa-trash"></i> Eliminar Fecha</button> 
                                        </div>
                                        <input style="width: 50%;float: left;" type="text" :value="item.departure" class="form-control" disabled >
                                        <input style="width: 50%;float: left;" type="text" :value="item.quotas" class="form-control" disabled >
                                        <input type="text" disabled :value="item.point_name" class="form-control text-center">
                                    </div>--}}
                                







                                    
                                
<div class="x_content">
  <!-- modals -->
  <!-- Large modal -->
  <div class="modal fade" id="editDepartament2"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">prueba</h4>
        </div>
        <div class="modal-body">

            {{--{!! Form::open(['route' => ['beneficiarios.store'], 'files' => true]) !!}--}}
            <form action="{{--Route('productos.update', 'test')--}}" class="row" method="POST">
               {{ csrf_field() }}
               {{ method_field('patch') }}
                <input type="hidden" id='id' name="id" value="">
                <input type="text" id='id' name="id" value="">
                {{--@include('products.partials.form')--}}
         </form>
        </div>
      </div>
    </div>
  </div>
</div>
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
@include('adminweb.paquetes.pasos.modales.punto_de_encuentro') 
@endsection


@section('script')
<script type="text/javascript">
   $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    //evaluar la categoria
      $('#categoria').change(function(){
        var id = $(this).val();
        //alert(id);
        if(id === '6'){
          $('#zona').prop('disabled', true);
        
        }else{
          $('#zona').prop('disabled', false);
        }

      })
      $('#nombre').on('click',function() {
        var codigo = $('#codigo').val();
        if(codigo == ""){
          toastr.warning("Debe colocar un codigo");
        }else{
          $.ajax({
            url: '/validate/code/'+codigo,
            type: 'GET',
            success: function(data){
              console.log(data);
              if(data > 0){
                toastr.info("El codigo esta repetido.");
              }else{
                toastr.success("Codigo " + codigo + " Valido");
              }
            }
          });
        }
      })
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
<script>
        function pointIn() {
            $("#punto_encuentro").fadeIn(300);
        }
        function closeModal(){
            $(".modal").fadeOut(300);
        }   
        function setDataPoint(){
            if ($("#nombre_punto").val() == "") {
                toastr.info("Debe Seleccionar Un Nombre para el Punto de Encuentro");
            } else {
                if ($("#lat").val() == "" || $("#lng").val() == "") {
                    toastr.info("Debe Seleccionar Un Punto de Encuentro");
                } else {
                    $("#actual_nombre").val($("#nombre_punto").val());    
                    $("#button-modal-point").hide();
                    $("#actual_nombre").show();
                    $(".modal").fadeOut(300);
                }  
                
            }
            
        }
        function showCalendar(){
            $('.date').datepicker('show');
        }
</script>
<script src='{{ asset('js/multi-select-date.js') }}'></script>
<script src="{{--asset('js/paquetes/paso1.js')--}}"></script>
<script src="{{asset('js/paquetes/paso4.js')}}"></script>

@endsection

