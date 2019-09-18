<header class="main-header">
    <!-- Logo -->
    <!--<a href="index2.html" class="logo">-->
    <a class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img width="50 px" src="{!! asset('imagenes/logo2.png') !!}"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img width="100 px" src="{!! asset('imagenes/logo2.png') !!}"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top ">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

      
        <!--en caso de emergencia quita el input y deja el value suelto en la misma linea-->
        <input class="hidden" value="{{Auth::user()->nombres." ".Auth::user()->apellidos }}">
                       
        <span>
            <a href="" class="pull-right">Calculadora</a>
        </span>
    </nav>
</header>