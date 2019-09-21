@extends('layouts.master')
@section('titulo', 'Datos Paquetes')

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
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header">
            
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos del paquete</a></li>
                        <li class><a href="#tab_2" data-toggle="tab" aria-expanded="false">Configuración del paquete</a></li>
                        <li class><a href="#tab_3" data-toggle="tab" aria-expanded="false">Itinerario</a></li>
                        <li class><a href="#tab_4" data-toggle="tab" aria-expanded="false">Adicionales Del Paquete
</a></li>
                    </ul>
                    <div class="tab-content">
                        <!--datos del paquete-->
                        <div class="tab-pane active" id="tab_1">
                            <form action="{{ route('paquete.actualizar', $paquete->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $paquete->id }}" name="id">
                                @include('adminweb.paquetes.nuevo.partials.datos')
                                <button class="btn btn-danger pull-right" type="submit">Guardar</button>
                            </form>
                        </div>
                        <!--configuracion del paquete-->
                        <div class="tab-pane" id="tab_2">
                        </div>
                        <!--itinerario-->
                        <div class="tab-pane" id="tab_3">
                        </div>
                        <!--adicionales--> 
                        <div class="tab-pane" id="tab_4">
                        </div>

                    </div>
                </div>
            </div>  
        </div>
    </div>
</div> 
@endsection