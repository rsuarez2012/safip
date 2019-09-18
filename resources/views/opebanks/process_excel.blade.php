@extends('layouts.master')

@section('titulo', 'Excel Import')

@section('content')
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box" id="process_data_excel">
                <div class="box-header with-border">
                    <h2 class="box-title" style="font-size: 24px;">
                    	<i class="fa fa-ticket"></i> Procesar Documento Excel
                    </h2>
                    <h4 class="text-right">
                        Operaciones cargadas: @{{ data_excel.length }}
                    </h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                        	<div class="col-md-4">
                        		<div class="form-group">
                        		    <label for=""><i class="fa fa-bank"></i> Bancos</label>
                        		    <select id="banco" class="form-control select2" style="width:100%">
                        		        <option value="0" selected>Seleccione un Banco</option>
                        		        @foreach($bancos as $banco)
                        		        	<option value="{{ $banco->banco }}">{{ $banco->banco }}</option>
                        		        @endforeach
                        		    </select>
                        		</div>
                    		</div>
                    		<div class="col-md-4">
                    			<div class="form-group">
                        		    <label for=""><i class="fa fa-map"></i> Monedas</label>
                        		    <select id="moneda" class="form-control select2" style="width:100%">
                        		        <option value="0">Selecciona la Moneda</option>
                        				<option value="Dolar">Dolar</option>
                        				<option value="Soles">Soles</option>
                        		    </select>
                        		</div>
                    		</div>
                    		<div class="col-md-2" style="margin-top: 2.2%;">
                                <button class="btn btn-danger pull-right" @click="save_process">Guardar</button>
                    		</div>
                            <div class="col-md-2" style="margin-top: 2.2%;">
                                <button class="btn btn-danger pull-right" @click="salir">Salir</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <t_process_excel :data_excel="data_excel" v-show="data_excel.length > 0"></t_process_excel>
                            <div v-show="data_excel.length == 0" class="alert alert-block alert-info" style="margin-top: 44px;">
                                <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                                <p class="margin-bottom-10">
                                    Actualmente no existen datos para procesar
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Init Component Template -->
            <template id="t_process_excel">
                <div style="margin-top: 1%;">
                    <span class="titlepageSize">Cant. de Registros en la lista</span>
                    <select v-model="pageSize" @change="changeSelect()" class="pageSize">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                    </select>
                    <div class="pull-right" style="margin-bottom: 10px;margin-top: 5px;">
                        <input type="text" v-model="search" placeholder="Escriba para filtrar" class="form-control">
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead class="table-danger">
                            <tr>
                                <th>GUARDAR TODOS
                                    <input type="checkbox"
                                            class="pull-right cl_check_father"
                                            @change="set_sm_all"
                                            value="all">
                                </th>
                                <th>NRO OPERACION</th>
                                <th>FECHA</th>
                                <th>MONTO</th>
                                <th>SALDO</th>
                                <th>DESCRIPCION</th>
                                {{-- <th>REFERENCIA</th> --}}
                                <th>SUCURSAL</th>
                                <th>USUARIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ope, index) in data_list">
                            	<td width="75px">
                            		<input type="checkbox"
                                            class="cl_check_sm"
                                            @change="set_sm"
                                            v-model="sm_data"
                                            :value="data_list[index]">
                            	</td>
                            	<td v-text="ope.operacion_numero"></td>
                            	<td v-text="ope.fecha.split(' ')[0]"></td>
                            	<td v-text="ope.monto"></td>
                            	<td v-text="ope.saldo"></td>
                            	<td v-text="ope.descripcion_operacion"></td>
                            	{{-- <td v-text="ope.referencia_2"></td> --}}
                            	<td v-text="ope.sucursal_agencia"></td>
                            	<td v-text="ope.usuario"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pager">
                        <button type="button"
                                class="btn btn-danger btn-xs"
                                @click="previousPage"
                                :disabled="currentPage <= 1">
                            <i class="fa fa-angle-left"></i>
                            Anterior
                        </button>
                        Página @{{currentPage}} de @{{totalPage}}
                        <button type="button"
                                class="btn btn-danger btn-xs"
                                @click="nextPage"
                                :disabled="totalPage <= 1 || currentPage == totalPage">
                                Siguiente
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
@endsection

@push('scripts')
	<script>
		let data = {!! json_encode($data) !!}
	</script>
	<script src="{{ asset('js/opebanks/process_excel.js') }}"></script>
@endpush