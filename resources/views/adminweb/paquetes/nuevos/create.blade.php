@extends('layouts.master')
@section('titulo', 'Crear Paquete')

@section('content') 
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header">
                <h4><i class="fa fa-cube"></i>  Crear Paquete  </h4>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="tabs">
                        <li id="t1" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Perfil del paquete</a></li>
                        <li id="t2" class="disabled"><a class="disabled"  >Destinos y Hoteles</a></li>
                        <li id="t3" class="disabled"><a class="disabled">Dias</a></li>
                        <li id="t4" class="disabled"><a class="disabled">Actividades</a></li>
                        <li id="t5" class="disabled"><a class="disabled">Precios</a></li>
                        <li id="t6" class="disabled"><a class="disabled">Datos del paquete</a></li>
                    </ul>
                    <div class="tab-content">
                        <!--datos del paquete-->
                        <div class="tab-pane active" id="tab_1">
                            <form action="{{ route('paquete.guardar') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('adminweb.paquetes.nuevos.partials.create')
                                <button class="btn btn-danger pull-right" type="submit">Guardar</button>
                            </form>
                        </div>
                        <!--configuracion del paquete-->
                        <div class="tab-pane" id="tab_2">
                            {{--@include('adminweb.paquetes.nuevo.partials.destinos')--}}
                        </div>
                        <!--itinerario-->
                        <div class="tab-pane" id="tab_3">
                            {{--@include('adminweb.paquetes.nuevo.partials.dia')--}}
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
@section('script')
<script src="{{ asset('js/nuevo/create.js') }}"></script>
@endsection