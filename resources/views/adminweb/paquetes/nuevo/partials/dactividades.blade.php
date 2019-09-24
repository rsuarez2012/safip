<form @submit.prevent="saveDay()">
              <div class="modal-body row" v-for="(day, index) in list_days">
                  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                  <div class="form-group col-sm-1">
                    <label class="text-dark">Día @{{index+1}}</label>
                  </div>
                  <div class="form-group col-sm-2">
                    <label class="text-dark">Día Libre</label><br>
                    <input v-model="list_days[index].libre" @change='changeFreeDay(index)' type="checkbox">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="text-dark">Nombre del Día</label>
                    <!--<div class="pull-right">
                      
                    </div>   -->
                      <input :disabled="list_days[index].libre" type="text" class="form-control" placeholder="Ejemplo" v-model="list_days[index].name">
                  </div>
                  <div class="form-group col-sm-3">
                      <label class="text-dark">Descripción del Día</label>
                      <textarea :disabled="list_days[index].libre" rows="2" class="form-control"  placeholder="Texto..." v-model="list_days[index].description"></textarea>
                  </div> 
                  <div class="form-group col-sm-3">
                      <label>&nbsp;</label>                      
                      <div class="btn btn-danger btn-block" style="position: relative;width: 100%;height: 34px" :disabled="list_days[index].libre">
                          <p v-if="list_days[index].image == null" style="position: absolute;width: 100%" class="text-center">
                              <span v-if="!list_days[index].libre && !edit">Cargar Imagen <i class="fa fa-upload"></i></span>
                              <span v-else>Dia Libre</span>
                          </p>
                          <p v-else-if="list_days[index].image.name" style="position: absolute;width: 100%" class="text-center">@{{list_days[index].image.name}} <i class="fa fa-check"></i></p>
                          <p v-else style="position: absolute;width: 100%" class="text-center">Cambiar Imagen</p>
                          <input :disabled="list_days[index].libre" type="file" style="opacity: 0;position: absolute" class="form-control" @change="processFile($event,index)"> 
                      </div>
                      
                      {{-- <img style="margin: auto" width="100%" height="200px" :src="route + '/storage/medium/' + list_days[index].image" alt=""> --}}
                  </div>
                 {{--  <div v-if="edit" class="form-group col-sm-1 text-center">
                      <label>&nbsp;</label>   
                      <div class="form-inline">
                          <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Guardar Cambios"><i class="fa fa-pencil"></i></button>
                          <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Limpiar campos del dia"><i class="fa fa-eraser"></i></button>
                      </div>
                  </div> --}}
                  
                  
              </div>
              <div class="modal-footer">
                  <button @click="closeModal()"  type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cancelar</button>
                  <button v-if="!edit" type="" class="btn btn-danger" ><i class="fa fa-plus-circle"></i> Agregar</button>
                  <button v-else type="" class="btn btn-danger" ><i class="fa fa-save"></i> Editar</button>
              </div>
          </form>

