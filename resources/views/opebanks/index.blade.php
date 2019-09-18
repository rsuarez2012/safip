@extends('layouts.master')

@section('titulo', 'Operaciones Bancarias')

@push('css')
    <style>
        @media (min-width: 768px) {
            .modal-pago-deudas, .modal-pago-conso, .modal-sm-pago-deudas{
                width: 992px;
            }
        }
        @media (min-width: 992px){
            .modal-lg {
                width: 975px;
            }
        }
        @media (min-width: 1200px){
            .modal-lg {
                width: 1100px;
            }
        }
        .items{
           width: 40px;
           border: none;
        }
    </style>
@endpush

@section('content')
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box" id="app_opebanks">
                <div class="box-header with-border">
                    <h2 class="box-title" style="font-size: 24px;">
                    	<i class="fa fa-ticket"></i> Consultar operaciones bancarias
                    </h2>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_d">Desde:</label>
                                    <input type="date" v-model="fecha_d" class="form-control" id="fecha_d" value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_h">Hasta:</label>
                                    <input type="date" v-model="fecha_h" class="form-control" id="fecha_h" value="">
                                </div>
                            </div>
                            <div class="col-md-1" style="padding-top:25px;">
                                <button type="submit"
                                        style="padding: 7px; margin-left: 7%;"
                                        class="btn btn-warning btn-xs btn"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Filtrar por fecha"
                                        data-original-title="Filtrar por fecha"
                                        @click="pre_load_opebanks">
                                    <i class="fa fas fa-calendar" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="col-md-2" style="padding-top:7px;">
                                <form  class="form-horizontal"
                                        role="form"
                                        method="POST"
                                        action="{{ route('process.excel') }}"
                                        enctype="multipart/form-data"
                                        style="margin-top: 15%;">
                                    {{ csrf_field() }}
                                    <div style="width:27px;float:left;margin-right:4px;">
                                        <input  id="file"
                                                type="file"
                                                name="file"
                                                data-toggle="tooltip"
                                                data-placement="left"
                                                title="Cargar Documento"
                                                data-original-title="Cargar Documento"
                                                @change="load_document($event)"
                                                style="padding:7px;margin-left:15px;position: absolute;top: 36%; left: 0;width: 25px;opacity: 0;padding: 7px 0;cursor: pointer;"
                                                required>
                                        <label tabindex="0"
                                                for="my-file"
                                                class="input-file-trigger btn btn-warning btn-xs"
                                                style="padding: 7px;border-radius:3px !important;height:34px;">
                                            <i class="fa fa-folder" style="cursor:pointer;"></i>
                                        </label>
                                    </div>
                                    <button style="padding: 7px;"
                                            type="submit"
                                            class="btn btn-xs btn-warning"
                                            value="Subir"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Guardar Documento"
                                            data-original-title="Guardar Documento">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                    {{-- <button type="button"
                                            style="padding: 7px;"
                                            class="btn btn-warning btn-sm"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Filtro General">
                                            <i class="fa fas fa-filter" aria-hidden="true"></i> 
                                    </button> --}}
                                </form>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control bg-blue" value="Deudas de Agencia" readonly>
                                    <input type="text" class="form-control bg-green" value="Pago a Consolidadores" readonly>
                                    <input type="text" class="form-control bg-red" value="Gastos" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="nav-tabs-custom tab-danger" style="box-shadow: none;">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1" data-toggle="tab">No Identificados</a>
                                    </li>
                                    <li>
                                        <a href="#tab_2" data-toggle="tab">Ya Identificados</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <div class="col-lg-12">
                                            <templ_opebanks_no_ident :opebanks_no_ident="opebanks_no_ident" v-show="opebanks_no_ident.length > 0"></templ_opebanks_no_ident>
                                            <div v-show="opebanks_no_ident.length == 0" class="alert alert-block alert-info" style="margin-top: 44px;">
                                                <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                                                <p class="margin-bottom-10">
                                                    Actualmente no existen Operaciones Bancarias no Identificadas
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_2">
                                        <div class="col-lg-12">
                                            <templ_opebanks_ident :opebanks_ident="opebanks_ident" v-show="opebanks_ident.length > 0"></templ_opebanks_ident>
                                            <div v-show="opebanks_ident.length == 0" class="alert alert-block alert-info" style="margin-top: 44px;">
                                                <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                                                <p class="margin-bottom-10">
                                                    Actualmente no existen Operaciones Bancarias Identificadas
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('opebanks.templates.opebanks_ident')
            @include('opebanks.templates.opebanks_no_ident')
        </div>
	</div>
@endsection

@push('scripts')
    <script src="{{asset('js/opebanks/index.js')}}"></script>
@endpush