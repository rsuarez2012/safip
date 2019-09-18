@extends('layouts.master')

@section('titulo', 'Pagina de Bienvenida')

@section ('content')
      <section class="content-header">
        <img src="{{asset('imagenes/mapa-dig-xs.png')}}" class="img-responsive visible-xs">
            <img src="{{asset('imagenes/mapa-dig-sm.png')}}" class="img-responsive visible-sm">
            <img src="{{asset('imagenes/mapa-dig-md.png')}}" class="img-responsive visible-md">
            <img src="{{asset('imagenes/mapa-dig-lg.png')}}" class="img-responsive visible-lg">
      </section>



@endsection
