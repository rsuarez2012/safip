@extends('layouts.master')
@section('titulo', 'Restaurantes')

@section('css')
    <style>
      .clase_td{
         background-color: #dd4b39;
         color:#ffffff; 
         border: solid #fff 1px !important;
      }
    </style>
@endsection

@section('content')

<div class="row box" id="main-restaurantes">
  <div class="col-md-12">
    <h1><i class="fa fa-cutlery"> </i> Restaurantes</h1>
    <div class="row">
      <div class="col-md-12">
        <button @click="modalNuevoRestaurante" class="btn btn-danger pull-right" data-toggle="tooltip" title="Nuevo Restaurante"><i class="fa fa-plus-circle"></i></button>
      </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <br>
        </div>
      </div>
    <div class="row">
      <div class="col-sm-12">
          <div class="table-responsive">
              <table class="table table-hover" id="tabla-restaurantes">
                <thead>
                  <tr>
                    <th colspan="2">&nbsp;</th>
                    <th colspan="3" class="text-center clase_td">Peruano</th>
                    <th colspan="3" class="text-center clase_td">Extranjero</th>
                    <th colspan="2" class="text-center clase_td">Comunidad</th>
                  </tr>
                  <tr>
                    <th class="text-center clase_td">Nombre</th>
                    <th class="text-center clase_td">Destino</th>
                    <th class="text-center clase_td">Adulto</th>
                    <th class="text-center clase_td">Estudiante</th>
                    <th class="text-center clase_td">Niño</th>
                    <th class="text-center clase_td">Adulto</th>
                    <th class="text-center clase_td">Estudiante</th>
                    <th class="text-center clase_td">Niño</th>
                    <th class="text-center clase_td">Adulto</th>
                    <th class="text-center clase_td">Estudiante</th>
                    <th class="text-center clase_td">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-for="restaurante in restaurantes">
                      <td>@{{restaurante.nombre}}</td>
                      <td>@{{restaurante.destino.nombre}}</td>
                      <td>@{{restaurante.peruano.adulto}}</td>
                      <td>@{{restaurante.peruano.estudiante}}</td>
                      <td>@{{restaurante.peruano.ninio}}</td>
                      <td>@{{restaurante.extranjero.adulto}}</td>
                      <td>@{{restaurante.extranjero.estudiante}}</td>
                      <td>@{{restaurante.extranjero.ninio}}</td>
                      <td>@{{restaurante.comunidad.adulto}}</td>
                      <td>@{{restaurante.comunidad.estudiante}}</td>
                      <td>
                        <button @click="setRestaurantes(restaurante)" data-toggle="tooltip" title="Editar" class="btn btn-danger btn-xs"><i class="fa fa-pencil"></i></button>
                        <button @click="eliminarRestaurantes(restaurante)" data-toggle="tooltip" title="Eliminar" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
    @include('adminweb/restaurantes/modales/crear_editar')
</div>
</div>


@endsection

@section('script')
 <script src="{{ asset('js/restaurantes/index.js') }}"></script>
@endsection

