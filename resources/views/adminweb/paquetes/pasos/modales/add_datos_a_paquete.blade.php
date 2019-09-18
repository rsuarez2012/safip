<div class="modal" id="datos_paquete" style="overflow-y: scroll;overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: auto;margin: auto;">
            <div class="modal-header">
                <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
                    <i class="fa fa-plus"></i> Agregar datos de otro paquete al actual</h4>
                <button @click="closeModal"  type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="text-dark">Nombre o Código del Paquete</label>
                            <input type="text" class="form-control" placeholder="CUSCO EXPRESS ó ABCDE123" onfocus v-model="name_paquete" @keyup.enter.prevent="buscar_paquete">
                        </div>
                    </div>
                    <div class="col-sm-4" style="margin-top:24px;">
                        <button class="btn btn-info" @click="buscar_paquete">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                    </div>
                </div>

                <h4 v-show="paquetes.length > 0 && paquete.length == 0">Paquetes</h4>
                <div class="row" v-show="paquetes.length > 0 && paquete.length == 0" v-for="paq in paquetes">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <p v-text="'Nombre: '+paq.nombre+' / Código: '+paq.codigo"></p>
                        </div>
                    </div>
                    <div class="col-sm-4" style="">
                        <button class="btn btn-success" @click="select_paquete(paq)">
                            <i class="fa fa-plus"></i> Seleccionar
                        </button>
                    </div>
                </div>

                {{-- LISTA DE DATOS DENTRO DEL PAQUETE SELECCIONADO --}}
                <h4 v-show="paquete.id > 0">Paquete: @{{paquete.nombre}}</h4>
                <div class="row">
                    <div class="col-sm-6" style="border-right: solid 1px #dd4b39">
                        <div class="row" v-show="incluidos.length > 0">
                            <div class="col-sm-8">
                                <p class="text-dark" style="font-size:16px;">Incluidos</p>
                                <ul>
                                    <li v-for="incluido in incluidos" v-text="incluido.texto"></li>
                                </ul>
                            </div>
                            <div class="col-sm-4" style="">
                                <button class="btn btn-success btn-xs pull-right" @click="add_datos_to_paquete('incluido')">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
        
                        <div class="row" v-show="noincluidos.length > 0">
                            <div class="col-sm-8">
                                <p class="text-dark" style="font-size:16px;">No Incluidos</p>
                                <ul>
                                    <li v-for="noincluido in noincluidos" v-text="noincluido.texto"></li>
                                </ul>
                            </div>
                            <div class="col-sm-4" style="">
                                <button class="btn btn-success btn-xs pull-right" @click="add_datos_to_paquete('noincluido')">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
        
                        <div class="row" v-show="llevars.length > 0">
                            <div class="col-sm-8">
                                <p class="text-dark" style="font-size:16px;">Recomendaciones a llevar</p>
                                <ul>
                                    <li v-for="llevar in llevars" v-text="llevar.texto"></li>
                                </ul>
                            </div>
                            <div class="col-sm-4" style="">
                                <button class="btn btn-success btn-xs pull-right" @click="add_datos_to_paquete('llevar')">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
        
                        <div class="row" v-show="importantes.length > 0">
                            <div class="col-sm-8">
                                <p class="text-dark" style="font-size:16px;">Notas Importantes</p>
                                <ul>
                                    <li v-for="importante in importantes" v-text="importante.texto"></li>
                                </ul>
                            </div>
                            <div class="col-sm-4" style="">
                                <button class="btn btn-success btn-xs pull-right" @click="add_datos_to_paquete('importante')">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row" v-show="politcareservas.length > 0">
                            <div class="col-sm-8">
                                <p class="text-dark" style="font-size:16px;">Politicas de Reserva</p>
                                <ul>
                                    <li v-for="politcareserva in politcareservas" v-text="politcareserva.texto"></li>
                                </ul>
                            </div>
                            <div class="col-sm-4" style="">
                                <button class="btn btn-success btn-xs pull-right" @click="add_datos_to_paquete('politcareserva')">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
        
                        <div class="row" v-show="politicatarifas.length > 0">
                            <div class="col-sm-8">
                                <p class="text-dark" style="font-size:16px;">Politicas de Nuestras Tarifas</p>
                                <ul>
                                    <li v-for="politicatarifa in politicatarifas" v-text="politicatarifa.texto"></li>
                                </ul>
                            </div>
                            <div class="col-sm-4" style="">
                                <button class="btn btn-success btn-xs pull-right" @click="add_datos_to_paquete('politicatarifa')">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
        
                        <div class="row" v-show="fechas.length > 0">
                            <div class="col-sm-8">
                                <p class="text-dark" style="font-size:16px;">Fechas Especiales</p>
                                <ul>
                                    <li v-for="fecha in fechas" v-text="fecha.texto"></li>
                                </ul>
                            </div>
                            <div class="col-sm-4" style="">
                                <button class="btn btn-success btn-xs pull-right" @click="add_datos_to_paquete('fechas')">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
        
                        <div class="row" v-show="responsabilidades.length > 0">
                            <div class="col-sm-8">
                                <p class="text-dark" style="font-size:16px;">Responsabilidades</p>
                                <ul>
                                    <li v-for="responsabilidad in responsabilidades" v-text="responsabilidad.texto"></li>
                                </ul>
                            </div>
                            <div class="col-sm-4" style="">
                                <button class="btn btn-success btn-xs pull-right" @click="add_datos_to_paquete('responsabilidades')">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button @click="closeModal"  type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>