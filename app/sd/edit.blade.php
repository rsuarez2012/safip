@extends('layouts.master')
@section('titulo', 'Datos Paquetes')

@section('css')
<link rel="stylesheet" href="{{ asset('css/multiSelectCss/multi-select.css') }}">
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
    .ms-container{
    	width: 100%;
    }
</style>
@endsection
@section('content') 
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header">
            	 <h4><i class="fa fa-cube"></i>  Datos del Paquete  </h4>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="tabs">
                        <li id="t1" class><a href="#tab_1" data-toggle="tab" aria-expanded="true">Perfil del paquete</a></li>
                        <li id="t2" class="active"><a href="#tab_2" data-toggle="tab" aria-expanded="false" id="a_tab2">Destinos y Hoteles</a></li>
                        <li id="t3" class><a href="#tab_3" data-toggle="tab" aria-expanded="false" id="a_tab3">Dias y Actividades</a></li>
                        <li id="t4" class><a href="#tab_4" data-toggle="tab" aria-expanded="false" id="a_tab4">Precios</a></li>
                    </ul>
                    <div class="tab-content">
                        <!--datos del paquete-->
                        <div class="tab-pane" id="tab_1">
                            <form action="{{ route('paquete.actualizar', $paquete->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{--$paquete_id--}}
                                <input type="hidden" value="{{ $paquete->id }}" name="id">
                                @include('adminweb.paquetes.nuevo.partials.datos')
                                <button class="btn btn-danger pull-right" type="submit">Guardar</button>
                            </form>
                        </div>
                        <!--configuracion del paquete-->
                        <div class="tab-pane active" id="tab_2">
                        	<form action="{{ route('agregar.desr', $paquete->id) }}" method="POST" id="destino-form">
                        		 {{ csrf_field() }}
                        		<input type="hidden" name="id" value="{{$paquete->id}}" id="paquete_id">
                        		<div class="row">                        			
	                        		<div class="col-sm-6">
	                        			<div class="form-group">
	                        				<label for="">Desea agregar hotel.?</label>
	                        				<select class="form-control" id="opcion">
	                        					<option value="no">NO</option>
	                        					<option value="si">SI</option>
	                        				</select>
	                        			</div>
	                        		</div>
	                        		<div class="col-sm-6">
	                        			<div class="form-group">
	                        				<label>Dias de Hospedaje</label>
	                        				<input type="number" name="noches" id="noches" class="form-control" value="0">
	                        			</div>
	                        		</div>
                        		</div>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="form-group selector">
	                        				<label>Destinos</label>
	                        				<select class="form-control" multiple="multiple" id="destino" name="destino">
	                        					@foreach($destinos as $destino)
											  <option value='{{ $destino->id }}'>{{ $destino->nombre }}</option>
											  @endforeach
											</select>
	                        			</div>
	                        			<div class="form-group selector-hoteles" style="display: none;">
	                        				<label>Destinos</label>
	                        				
	                        				<select class="form-control" multiple="multiple" id="destinos-hoteles">
	                        					@foreach($destinos as $destino)
	                        					<optgroup label='{{$destino->nombre}}'>
	                        						@foreach($destino->hoteles as $hotel)
												  	<option value='{{ $destino->id }}_{{ $hotel->id }}'>{{ $hotel->nombre.' '.$destino->id }}</option>
												  @endforeach	
												</optgroup>
											  @endforeach
											</select>
	                        			</div>
                        			</div>
                        		</div>
                                <div class="form-group">
                            		<a id="btn-step2" class="btn btn-danger pull-right">Guardar</a>
                                    <a id="btn-step2-hoteles" class="btn btn-danger pull-right" style="display: none">Enlazar</a>
                                </div>
                                <br/>
                                <label>Hoteles enlazados</label>
                                <hr/>
                        	</form>
                           <div class="row">
                               <div class="col-sm-12">
                                   <div class="table-responsive">
                                     <table id="destinos-table" class="table table-bordered table-hover enlazados">
                                       <thead>
                                        <tr>
                                           <th colspan="2">&nbsp;</th>
                                           <th colspan="4">Peruano</th>
                                           <th colspan="4">Extranjero</th>
                                           <th>&nbsp;</th>
                                        </tr>
                                         <tr>
                                           <th class="text-center">Hoteles</th>
                                           <th class="text-center">*</th>
                                           <th class="text-center">Simple</th>
                                           <th class="text-center">Doble</th>
                                           <th class="text-center">Triple</th>
                                           <th class="text-center">Cuadruple</th>
                                           <th class="text-center">Simple</th>
                                           <th class="text-center">Doble</th>
                                           <th class="text-center">Triple</th>
                                           <th class="text-center">Cuadruple</th>
                                           <th class="text-center">ACCIONES</th>
                                         </tr>
                                       </thead>
                                       <tbody>
                                        @foreach($paquete->enlazados as $enlazado)   
                                        <tr>                                      
                                          <td class="text-center">{{ $enlazado->hotel->nombre }}</td>
                                          <td class="text-center">{{ $enlazado->hotel->estrella }}</td>
                                          <td class="text-center">{{ $enlazado->hotel->p_swb }}</td>
                                          <td class="text-center">{{ $enlazado->hotel->p_dwb }}</td>
                                          <td class="text-center">{{ $enlazado->hotel->p_tpl }}</td>
                                          <td class="text-center">{{ $enlazado->hotel->p_chd }}</td>
                                          <td class="text-center">{{ $enlazado->hotel->e_swb }}</td>
                                          <td class="text-center">{{ $enlazado->hotel->e_dwb }}</td>
                                          <td class="text-center">{{ $enlazado->hotel->e_tpl }}</td>
                                          <td class="text-center">{{ $enlazado->hotel->e_chd }}</td>
                                          <td class="text-center">
                                            <a class="btn btn-xs btn-danger eliminarDestino" data-toggle="tooltip" title="Eliminar" data-enlazado="{{ $enlazado->id }}"><i class="fa fa-trash"></i></a>
                                          </td>
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>

                                  </div>
                               </div>
                           </div>
                        </div>
                        <!--itinerario-->
                        <div class="tab-pane" id="tab_3">

                            <a id="btn-step3" class="btn btn-danger pull-right">Guardar</a>
                        </div>
                        <!--adicionales--> 
                        <div class="tab-pane" id="tab_4">

                            <a id="btn-step4" class="btn btn-danger pull-right">Guardar</a>
                        </div>

                    </div>
                </div>
            </div>  
        </div>
    </div>
</div> 
@endsection