@extends('layouts.master')


@section('titulo', 'Error')


@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            404 Pagina de Error
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i>Tablero</a></li>
            <!--<li><a href="#">Examples</a></li>
            <li class="active">404 error</li>-->
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Hola {{ Auth::user()->nombres." ".Auth::user()->apellidos }}
                    Ups! al parecer no tienes permisos para utilizar esta
                    función...</h3>

                <p>
                    No se ha conseguido esta pagina para tí, consulta tus derechos dentro del sistema directamente con el administrador.
                    Tal vez deberías <a href="/">Regresar al tablero</a> he intenta con otra opción.
                </p>


            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
    <!-- /.content -->

@endsection