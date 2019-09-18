@extends('layouts.master')
@section('titulo', 'Crear Itinerario')
@section('css')
<link rel="stylesheet" href="{{ asset('css/pasos_paquetes.css') }}">
@endsection
@section('content')
<div class="row" id="main-paso3">
  <input type="hidden" name="id_oculto" value="{{$paquete_id}}">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="box padding_box1">

      <div class="box-header">
        <h3><i class="fa fa-calendar"></i> Itinerario De @{{package.nombre}}</h3>
      </div>
      <div class="box-body"> 
        <div class="box-footer">
          <a v-if="package.statusCreado == 'terminado'" href="{{route('manageProduct-A')}}" class="btn btn-danger pull-right"><i class="fa fa-arrow-circle-left"></i> Volver</a>
          <a v-else @click.prevent="completeDays()"  href="{{route('managePaquete-paso-4-A',$paquete_id)}}" class="btn btn-danger pull-right "  id="parte1-fin">Siguiente <i class="fa fa-arrow-circle-right"></i></a>
        </div> 
        <div class="row">
          <div class="col-xs-12">
            <div class="nav-tabs-custom  tab-danger">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-sun-o"></i> Dias</a></li>
                 <li><a href="#tab_2" @click="getItineraryTotal()" data-toggle="tab"><i class="fa fa-calendar"></i> Itinerario</a></li>
                <li><a href="#tab_3" @click="getItinerarioFinal('neto')" data-toggle="tab"><i class="fa fa-money"></i> Monto Neto</a></li>
                <li><a href="#tab_4" @click="getItinerarioFinal('doce')" data-toggle="tab"><i class="fa fa-percent"></i> Monto con 12%</a></li>
                <li><a href="#tab_5" @click="getItinerarioFinal('diez')" data-toggle="tab"><i class="fa fa-percent"></i> Monto con 10% y 12$</a></li>
                <li><a href="#tab_6" @click="getItinerarioFinal('promocion')" data-toggle="tab"><i class="fa fa-star"></i> Promociones</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <div  class="row">
                    <div class="col-xs-12">
                      <button :disabled="view_button_new" @click="newDay(package.id)" class="btn btn-danger pull-right"><i class="fa fa-plus-circle"></i> Agregar Dia</button>    
                    </div>
                  </div>
                  <br>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead style="background-color: #dd4b39;">
                        <tr style="color: #fff">
                          <th class="col-xs-2">Imagen</th>
                          <th class="col-xs-1">N° del Dia</th>
                          <th class="col-xs-1">Nombre</th>
                          <th class="col-xs-4">Descripción</th>
                          <th class="col-xs-1 text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(day, index) in package.dias">
                          <td class="text-center" style=" vertical-align: middle;"><img  :src="route+'/storage/miniature/dia'+day.imagen" alt="Este dia no tiene una imagen"></td>
                          <td class="text-center">@{{(index+1)}}</td>
                          <td class="text-center">@{{day.nombre}}</td>
                          <td style="text-align: justify;">@{{day.descripcion}}</td>
                          <td class="text-center">
                              <button @click="showActivities(index)" class="btn btn-primary btn-xs" title="Ver Actividades" data-toggle="tooltip"><i class="fa fa-calendar"></i></button>
                              <button @click="editDay(day)" class="btn btn-warning btn-xs" title="Editar Dia" data-toggle="tooltip"><i class="fa fa-pencil"></i></button>
                              <button @click="deleteDay(day,index)" class="btn btn-danger btn-xs" title="Eliminar Dia" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="tab_2">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="bg-head-tabla">
                        <tr>
                          <th>Dias</th>
                          <th>Actividad</th>
                          <th>Peruano Adulto</th>
                          <th>Extranjero Adulto</th>
                          <th>Comunidad Adulto</th>
                          <th>Niño Peruano</th>
                          <th>Niño Extranjero</th>
                        </tr>
                      </thead>
                      <tbody>
                        <template v-for="dia in package.dias">    
                          <tr>
                            <td :rowspan="dia.actividades.length+1">@{{dia.nombre}}</td> 
                          </tr>
                          <tr  v-for="actividad in dia.actividades">
                            <td>@{{actividad.nombre}}</td>
                            <template v-if="actividad.tipo == 'servicio'">
                              <td>@{{actividad.servicio[0].servicio.peruano.adulto}}</td>
                              <td>@{{actividad.servicio[0].servicio.extranjero.adulto}}</td>
                              <td>@{{actividad.servicio[0].servicio.comunidad.adulto}}</td>
                              <td>@{{actividad.servicio[0].servicio.peruano.ninio}}</td>
                              <td>@{{actividad.servicio[0].servicio.extranjero.ninio}}</td>
                            </template>    
                            <template v-if="actividad.tipo == 'restaurante'">
                              <td>@{{actividad.restaurante[0].restaurante.peruano.adulto}}</td>
                              <td>@{{actividad.restaurante[0].restaurante.extranjero.adulto}}</td>
                              <td>@{{actividad.restaurante[0].restaurante.comunidad.adulto}}</td>
                              <td>@{{actividad.restaurante[0].restaurante.peruano.ninio}}</td>
                              <td>@{{actividad.restaurante[0].restaurante.extranjero.ninio}}</td>
                            </template>   
                          </tr>
                        </template>    
                      </tbody>
                      <tfoot  class="bg-head-tabla">
                        <tr>
                          <td colspan="2">TOTAL </td>
                          <td v-for="col in total_itinerary">
                              @{{Math.round(col * 100) / 100}}
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="tab_3">
                  <button @click="changetypeTarifa('neto')" class="btn btn-danger margin-inferior">Publicar estos costos en web</button>
                  <div class="table-responsive">
                  {{-- TABLA DE NETO CON HOTELES ENZALADOS --}}
                  <table class="table table-bordered" v-if="table_mounts.length > 0">
                    <thead class="bg-head-tabla">
                      <tr>
                        <th v-if="type_tarifa == 'neto'">Mostrar</th>
                        <th>Hoteles</th>
                        <th>*</th>
                        <th>p_swb</th>
                        <th>p_dwb</th>
                        <th>p_tpl</th>
                        <th>p_chd</th>
                        <th>e_swb</th>
                        <th>e_dwb</th>
                        <th>e_tpl</th>
                        <th>e_chd</th>
                        <th>c_swb</th>
                        <th>c_dwb</th>
                        <th>c_tpl</th>
                        <th>p_chd</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="row in table_mounts">
                        <template v-if="type_tarifa == 'neto'">
                          <td class="text-center">
                            <input type="checkbox" v-if="row.estado == 'visible'" checked @click="changeStateHotels(row.codigo,row.estado)">
                            <input type="checkbox" v-else @click="changeStateHotels(row.codigo,row.estado)">
                          </td>
                        </template>
                        <td>
                            @{{row.hotels}}
                        </td>
                        <td>
                            @{{row.star}}
                        </td>
                        <td>@{{Math.round(row.p_swb * 100) / 100 }}</td>
                        <td>@{{Math.round(row.p_dwb * 100) / 100 }}</td>
                        <td>@{{Math.round(row.p_tpl * 100) / 100 }}</td>
                        <td>@{{Math.round(row.p_chd * 100) / 100 }}</td>
                        <td>@{{Math.round(row.e_swb * 100) / 100 }}</td>
                        <td>@{{Math.round(row.e_dwb * 100) / 100 }}</td>
                        <td>@{{Math.round(row.e_tpl * 100) / 100 }}</td>
                        <td>@{{Math.round(row.e_chd * 100) / 100 }}</td>
                        <td>@{{Math.round(row.c_swb * 100) / 100 }}</td>
                        <td>@{{Math.round(row.c_dwb * 100) / 100 }}</td>
                        <td>@{{Math.round(row.c_tpl * 100) / 100 }}</td>
                        <td>@{{Math.round(row.p_chd * 100) / 100 }}</td>
                      </tr>
                    </tbody>
                  </table>

                  {{-- TABLA DE NETO SOLO DE ACTIVIDADES - NO TIENE HOTELES ENLAZADOS --}}
                  <table class="table table-bordered" v-else>
                    <thead class="bg-head-tabla">
                      <tr>
                        <th></th>
                        <th>Peruano Adulto</th>
                        <th>Extranjero Adulto</th>
                        <th>Comunidad Adulto</th>
                        <th>Niño Peruano</th>
                        <th>Niño Extranjero</th>
                      </tr>
                    </thead>
                    <tfoot  class="bg-head-tabla">
                      <tr>
                        <td colspan="1">TOTAL </td>
                        <td v-for="col in total_itinerary">
                            @{{Math.round(col * 100) / 100}}
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="tab_4">
                <button @click="changetypeTarifa('doce')" class="btn btn-danger margin-inferior">Publicar estos costos en web</button>
                <div class="table-responsive">
                {{-- TABLA DE NETO CON HOTELES ENZALADOS --}}
                  <table class="table table-bordered" v-if="table_mounts.length > 0">
                    <thead class="bg-head-tabla">
                      <tr>
                        <th v-if="type_tarifa == 'doce'">Mostrar</th>
                        <th>Hoteles</th>
                        <th>*</th>
                        <th>p_swb</th>
                        <th>p_dwb</th>
                        <th>p_tpl</th>
                        <th>p_chd</th>
                        <th>e_swb</th>
                        <th>e_dwb</th>
                        <th>e_tpl</th>
                        <th>e_chd</th>
                        <th>c_swb</th>
                        <th>c_dwb</th>
                        <th>c_tpl</th>
                        <th>c_chd</th>
                      </tr>
                    </thead>
                      <tbody>
                          <tr v-for="row in table_mounts">
                              <template v-if="type_tarifa == 'doce'">
                                  <td class="text-center">
                                      <input type="checkbox" v-if="row.estado == 'visible'" checked @click="changeStateHotels(row.codigo,row.estado)">
                                      <input type="checkbox" v-else @click="changeStateHotels(row.codigo,row.estado)">
                                  </td>
                              </template>
                              <td>
                                  @{{row.hotels}}
                              </td>
                              <td>
                                  @{{row.star}}
                              </td>
                              <td>@{{Math.round(row.p_swb * 100) / 100 }}</td>
                              <td>@{{Math.round(row.p_dwb * 100) / 100 }}</td>
                              <td>@{{Math.round(row.p_tpl * 100) / 100 }}</td>
                              <td>@{{Math.round(row.p_chd * 100) / 100 }}</td>
                              <td>@{{Math.round(row.e_swb * 100) / 100 }}</td>
                              <td>@{{Math.round(row.e_dwb * 100) / 100 }}</td>
                              <td>@{{Math.round(row.e_tpl * 100) / 100 }}</td>
                              <td>@{{Math.round(row.e_chd * 100) / 100 }}</td>
                              <td>@{{Math.round(row.c_swb * 100) / 100 }}</td>
                              <td>@{{Math.round(row.c_dwb * 100) / 100 }}</td>
                              <td>@{{Math.round(row.c_tpl * 100) / 100 }}</td>
                              <td>@{{Math.round(row.p_chd * 100) / 100 }}</td>
                          </tr>
                      </tbody>
                  </table>

                  {{-- TABLA DE NETO SOLO DE ACTIVIDADES - NO TIENE HOTELES ENLAZADOS --}}
                  <table class="table table-bordered" v-else>
                    <thead class="bg-head-tabla">
                      <tr>
                        <th></th>
                        <th>Peruano Adulto</th>
                        <th>Extranjero Adulto</th>
                        <th>Comunidad Adulto</th>
                        <th>Niño Peruano</th>
                        <th>Niño Extranjero</th>
                      </tr>
                    </thead>
                    <tfoot  class="bg-head-tabla">
                      <tr>
                        <td colspan="1">TOTAL </td>
                        <td v-for="col in total_itinerary">
                            @{{Math.round(sum_doce(col) * 100) / 100}}
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="tab_5">
                <button @click="changetypeTarifa('diez')" class="btn btn-danger margin-inferior">Publicar estos costos en web</button>    
                <div class="table-responsive">
                  {{-- TABLA DE NETO CON HOTELES ENZALADOS --}}
                  <table class="table table-bordered" v-if="table_mounts.length > 0">
                    <thead class="bg-head-tabla">
                      <tr>
                        <th v-if="type_tarifa == 'diez'">Mostrar</th>
                        <th>Hoteles</th>
                        <th>*</th>
                        <th>p_swb</th>
                        <th>p_dwb</th>
                        <th>p_tpl</th>
                        <th>p_chd</th>
                        <th>e_swb</th>
                        <th>e_dwb</th>
                        <th>e_tpl</th>
                        <th>e_chd</th>
                        <th>c_swb</th>
                        <th>c_dwb</th>
                        <th>c_tpl</th>
                        <th>c_chd</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="row in table_mounts">
                          <template v-if="type_tarifa == 'diez'">
                              <td class="text-center">
                                  <input type="checkbox" v-if="row.estado == 'visible'" checked @click="changeStateHotels(row.codigo,row.estado)">
                                  <input type="checkbox" v-else @click="changeStateHotels(row.codigo,row.estado)">
                              </td>
                          </template>
                          <td>
                              @{{row.hotels}}
                          </td>
                          <td>
                              @{{row.star}}
                          </td>
                          <td>@{{Math.round(row.p_swb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.p_dwb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.p_tpl * 100) / 100 }}</td>
                          <td>@{{Math.round(row.p_chd * 100) / 100 }}</td>
                          <td>@{{Math.round(row.e_swb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.e_dwb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.e_tpl * 100) / 100 }}</td>
                          <td>@{{Math.round(row.e_chd * 100) / 100 }}</td>
                          <td>@{{Math.round(row.c_swb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.c_dwb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.c_tpl * 100) / 100 }}</td>
                          <td>@{{Math.round(row.p_chd * 100) / 100 }}</td>
                      </tr>
                    </tbody>
                  </table>

                  {{-- TABLA DE NETO SOLO DE ACTIVIDADES - NO TIENE HOTELES ENLAZADOS --}}
                  <table class="table table-bordered" v-else>
                    <thead class="bg-head-tabla">
                      <tr>
                        <th></th>
                        <th>Peruano Adulto</th>
                        <th>Extranjero Adulto</th>
                        <th>Comunidad Adulto</th>
                        <th>Niño Peruano</th>
                        <th>Niño Extranjero</th>
                      </tr>
                    </thead>
                    <tfoot  class="bg-head-tabla">
                      <tr>
                        <td colspan="1">TOTAL </td>
                        <td v-for="col in total_itinerary">
                              @{{Math.round(sum_final(col) * 100) / 100}}
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="tab_6">
                <div class="form-group  margin-inferior">
                  <label>Precio Promocion </label>
                  <br>
                  <input style="width: 120px;float: left;" class="form-control" type="number" step="0.01" v-model="mount_utility">
                  <button @click="calculate_new_promotion"
                    data-toggle="tooltip"
                    title="Calcular"
                    class="btn btn-danger"
                    style="margin-right: 20px;"
                    v-if="mount_utility > 0">
                  <i class="fa fa-calculator"></i>
                  </button> 
                  <button @click="changetypeTarifa('promocion')" class="btn btn-danger"  v-if="package.utilidad_promocion > 0">
                      Publicar estos costos en web
                  </button>    
                </div>
                <div class="table-responsive" style="clear: both;">
                    {{-- TABLA DE NETO CON HOTELES ENZALADOS --}}
                    <table class="table table-bordered" v-if="table_mounts.length > 0">
                      <thead class="bg-head-tabla">
                        <tr>
                          <th v-if="type_tarifa == 'promocion'">Mostrar</th>
                          <th>Hoteles</th>
                          <th>*</th>
                          <th>p_swb</th>
                          <th>p_dwb</th>
                          <th>p_tpl</th>
                          <th>p_chd</th>
                          <th>e_swb</th>
                          <th>e_dwb</th>
                          <th>e_tpl</th>
                          <th>e_chd</th>
                          <th>c_swb</th>
                          <th>c_dwb</th>
                          <th>c_tpl</th>
                          <th>c_chd</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="row in table_mounts">
                          <template v-if="type_tarifa == 'promocion'">
                            <td class="text-center">
                              <input type="checkbox" v-if="row.estado == 'visible'" checked @click="changeStateHotels(row.codigo,row.estado)">
                              <input type="checkbox" v-else @click="changeStateHotels(row.codigo,row.estado)">
                            </td>
                          </template>
                          <td>
                            @{{row.hotels}}
                          </td>
                          <td>
                            @{{row.star}}
                          </td>
                          <td>@{{Math.round(row.p_swb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.p_dwb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.p_tpl * 100) / 100 }}</td>
                          <td>@{{Math.round(row.p_chd * 100) / 100 }}</td>
                          <td>@{{Math.round(row.e_swb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.e_dwb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.e_tpl * 100) / 100 }}</td>
                          <td>@{{Math.round(row.e_chd * 100) / 100 }}</td>
                          <td>@{{Math.round(row.c_swb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.c_dwb * 100) / 100 }}</td>
                          <td>@{{Math.round(row.c_tpl * 100) / 100 }}</td>
                          <td>@{{Math.round(row.p_chd * 100) / 100 }}</td>
                        </tr>
                      </tbody>
                    </table>

                      {{-- TABLA DE NETO SOLO DE ACTIVIDADES - NO TIENE HOTELES ENLAZADOS --}}
                      <table class="table table-bordered" v-else>
                        <thead class="bg-head-tabla">
                          <tr>
                            <th></th>
                            <th>Peruano Adulto</th>
                            <th>Extranjero Adulto</th>
                            <th>Comunidad Adulto</th>
                            <th>Niño Peruano</th>
                            <th>Niño Extranjero</th>
                          </tr>
                        </thead>
                        <tfoot  class="bg-head-tabla">
                          <tr>
                            <td colspan="1">TOTAL </td>
                            <td v-for="col in total_itinerary">
                                @{{Math.round(sum_promotion(col) * 100) / 100}}
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
               </div>
            </div>
          </div>            
        </div>
      </div>
    </div>
  </div>
</div>


@include('adminweb.paquetes.pasos.modales.actividades')
@include('adminweb.paquetes.pasos.modales.dia')
</div>
@push('scripts')
<script src="{{ asset('js/paquetes/paso3.js') }}"></script>
<script>
    $(document).ready(function(){
        $(".select2").select2();
    });
    (function($, window) {
    'use strict';

    var MultiModal = function(element) {
        this.$element = $(element);
        this.modalCount = 0;
    };

    MultiModal.BASE_ZINDEX = 1040;

    MultiModal.prototype.show = function(target) {
        var that = this;
        var $target = $(target);
        var modalIndex = that.modalCount++;

        $target.css('z-index', MultiModal.BASE_ZINDEX + (modalIndex * 20) + 10);

        // Bootstrap triggers the show event at the beginning of the show function and before
        // the modal backdrop element has been created. The timeout here allows the modal
        // show function to complete, after which the modal backdrop will have been created
        // and appended to the DOM.
        window.setTimeout(function() {
            // we only want one backdrop; hide any extras
            if(modalIndex > 0)
                $('.modal-backdrop').not(':first').addClass('hidden');

            that.adjustBackdrop();
        });
    };

    MultiModal.prototype.hidden = function(target) {
        this.modalCount--;

        if(this.modalCount) {
           this.adjustBackdrop();
            // bootstrap removes the modal-open class when a modal is closed; add it back
            $('body').addClass('modal-open');
        }
    };

    MultiModal.prototype.adjustBackdrop = function() {
        var modalIndex = this.modalCount - 1;
        $('.modal-backdrop:first').css('z-index', MultiModal.BASE_ZINDEX + (modalIndex * 20));
    };

    function Plugin(method, target) {
        return this.each(function() {
            var $this = $(this);
            var data = $this.data('multi-modal-plugin');

            if(!data)
                $this.data('multi-modal-plugin', (data = new MultiModal(this)));

            if(method)
                data[method](target);
        });
    }

    $.fn.multiModal = Plugin;
    $.fn.multiModal.Constructor = MultiModal;

    $(document).on('show.bs.modal', function(e) {
        $(document).multiModal('show', e.target);
    });

    $(document).on('hidden.bs.modal', function(e) {
        $(document).multiModal('hidden', e.target);
    });
}(jQuery, window));
</script>
@endpush
@endsection