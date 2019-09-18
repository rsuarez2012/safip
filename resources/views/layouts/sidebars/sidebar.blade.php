  <aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
       <img src="{{asset('uploads/usuarios/'. Auth::user()->imagen)}}" class="img-circle" alt="User Image">
     </div>
     <div class="pull-left info">
      <!-- nombre usando la variable se sesion-->
      <p>{{ Auth::user()->nombres." ".Auth::user()->apellidos }}</p>
      @if (Auth::user()->role == "Admin")
      <a href="#"><i class="fa fa-circle text-success"></i> Administrador</a>
      @endif
      @if (Auth::user()->role == "Vendedor")
      <a href="#"><i class="fa fa-circle text-success"></i>Vendedor</a>
      @endif
      @if (Auth::user()->role == "Supervisor")
      <a href="#"><i class="fa fa-circle text-success"></i>Supervisor</a>
      @endif

    </div>
  </div>

  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
    <li class="header">MENU</li>
    <li class="treeview">
      <a href="{{ route('tablero') }}">
        <i class="fa fa-sliders"></i> <span>Panel</span>

      </a>

    </li>
    @if (Auth::user()->boletos == "1")
    {{-- Cotizaciones --}}
    <li class="treeview">
      <a href="#">
        <i class="fa fa-money"></i>
        <span>Cotizaciones</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
      	 <li class=""><a href="{{ route('manageCotizacion-create-A') }}"><i class="fa fa-ticket"></i> Nueva Cotizacion de Boletos</a></li>
      	  <li class=""><a href="{{ url('/tablero/Paquetes/Cotizaciones/Crear') }}"><i class="fa fa-cubes"></i> Nueva Cotizacion de Paquetes</a></li>
       <li class=""><a href="{{ route('manageCotizacion-A') }}"><i class="fa fa-ticket"></i> Administrar Cotizaciones</a></li>

     </ul>
   </li>

   @endif
  {{-- PAQUETES --}}

<li class="treeview">
  <a href="#">
    <i class="fa fa-suitcase"></i>
    <span>Paquetes</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
   @if (Auth::user()->ppaquetes == "1")
   <li class=""><a href="{{ route('manageProduct-A') }}"><i class="fa fa-cubes"></i>Paquetes Turisticos</a></li>
   {{--<li class=""><a href="{{ route('full_day.index') }}"><i class="fa fa-cubes"></i>Paquetes Full Day</a></li>--}}
   @endif
   @if (Auth::user()->reservaciones == "1")
   <li class=""><a href="{{ route('reservations.solicitudes') }}"><i class="fa fa-file-text"></i> Reservación Web</a></li>    
   @endif
   @if (Auth::user()->poperadores == "1")
   <li class=""><a href="{{ route('manageOperador-A') }}"><i class="fa fa-users"></i> Operadores</a></li>
   @endif
   @if (Auth::user()->pdestinos == "1")
   <li><a href="{{route('manageDestino-A')}}"><i class="fa fa-globe"></i> Destinos</a></li>
   @endif
   @if (Auth::user()->photeles == "1")
   <li><a href="{{route('manageHoteles-A')}}"><i class="fa fa-hotel"></i> Hoteles</a></li>
   @endif
   @if (Auth::user()->prestaurantes == "1")
   <li><a href="{{route('manageRestaurante-A')}}"><i class="fa fa-cutlery"></i> Restaurantes</a></li>
   @endif

 </ul>
</li>

 @if(Auth::user()->vboletos == "" and Auth::user()->pconso == "" and Auth::user()->deuaviajes == "" and Auth::user()->pasajeros == "" and Auth::user()->contabilidad == "")
     @else
{{-- REPORTES --}}
<li class="treeview">
  <a href="#">
    <i class="glyphicon glyphicon-folder-open"></i>
    <span>Reportes</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
  @if (Auth::user()->validar_boletos == "1")
     <li><a href="{{url("/tablero/validar/ventas-boletos")}}">
      <i class="fa fa-clock-o"></i> Boletos Por Validar 
      <small class="label bg-blue" id="cantidad_boletos_por_validar">0</small></a>
    </li>
  @endif 
   @if (Auth::user()->vboletos == "1")
   <li class=""><a href="{{ route('manageVboleto-A') }}"><i class="fa fa-ticket"></i> Venta de Boletos</a></li>
   <li class=""><a href="{{ route('boletos.paquete.index') }}"><i class="fa fa-ticket"></i> Venta de Paquetes</a></li>
   @endif


   @if (Auth::user()->pasajeros == "1")
   <li class=""><a href="{{ route('manageCliente-A') }}"><i class="fa fa-users"></i> Pasajeros</a></li>
   @endif
   @if (Auth::user()->pconso == "1")
   <li class=""><a href="{{ route('managePconsolidador-A') }}"><i class="fa fa-handshake-o"></i> Pago a Consolidadores</a></li>
   @endif
   @if (Auth::user()->deuaviajes == "1")
   <li class=""><a href="{{ route('manageDagenciaviajes-A') }}"><i class="fa fa-usd"></i> Deuda de Agencias</a></li>
   @endif
    {{-- @if (Auth::user()->contabilidad == "1")  --}}
      <li class=""><a href="{{ route('manageContabilidad-A') }}"><i class="fa fa-money"></i> Contabilidad</a></li>
    {{--   @endif   --}}

   <li class="" hidden=""><a href=""><i class="glyphicon glyphicon-list-alt"></i> Reporte Gerencial</a></li>
     
 </ul>
</li>
@endif
 @if(Auth::user()->solicitudes == "" and Auth::user()->ancppagar == "" and Auth::user()->ancpcobrar == "" and Auth::user()->opb == "" and Auth::user()->nomina == "" and Auth::user()->caja_chica == "" )
     @else


{{-- ADMINISTRACION --}}
<li class="treeview">
  <a href="#">
    <i class="fa fa-line-chart  fa-fw"></i>
    <span>Administracion</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    @if (Auth::user()->solicitudes == "1")
    <li class=""><a href="{{ url('solicitudes/agencias') }}"><i class="fa fa-envelope"></i> Solicitudes De Agencias Web</a></li>
    @endif
    @if (Auth::user()->ancppagar == "1")
    <li class=""><a href="{{route('managePago-principal-A')}}"><i class="fa fa-file-text"></i> Cuentas por Pagar</a></li>
    @endif
    @if (Auth::user()->ancpcobrar == "1")
    <li class=""><a href="{{ route('manageCobro-principal-A') }}"><i class="fa fa-file-text"></i>  Cuentas por Cobrar</a></li>
    @endif
    @if (Auth::user()->opb == "1")
    {{-- <li class=""><a href="{{ route('manageCoperacionesbancarias-A') }}"><i class="fa fa-eraser"></i> Operaciones Bancarias</a></li> --}}
    <li class="">
      <a href="{{ route('opebanks.index') }}">
        <i class="fa fa-eraser"></i> Operaciones Bancarias
        {{-- <span class="pull-right-container">
          <small class="label pull-right bg-green">Nuevo</small>
        </span> --}}
      </a>
    </li>
    @endif
    @if (Auth::user()->nomina == "1") 
    <li class=""><a href="{{ route('manageNomina-A') }}"><i class="fa fa-users"></i> Nomina</a></li>
    @endif
    @if (Auth::user()->caja_chica == "1")
    <li class=""><a href="{{ route('manageCaja-A') }}"><i class="fa fa-usd"></i> Caja Chica</a></li>
    @endif
    {{-- @if (Auth::user()->contabilidad == "1")  --}}
      <li class=""><a href="{{ route('manageContabilidad-A') }}"><i class="fa fa-money"></i> Contabilidad</a></li>
    {{--   @endif   --}}


  </ul>
</li>
@endif
{{-- USUARIOS --}}
<li class="treeview">
  <a href="#">
    <i class="fa  fa-group"></i>
    <span>Usuarios</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
   @if (Auth::user()->cclave == "1")
   {{-- GENERADOR DE CLAVE --}}
   <li><a href="{{route('manageGenerador-A')}}"><i class="fa fa-file-code-o"></i> <span>Generador de claves</span></a></li>
   @endif
   @if (Auth::user()->usuarios == "1")
   <li class=""><a href="{{ route('manageUsuario-A') }}"><i class="fa fa-user"></i> Usuarios Admin</a></li>
   @endif
   @if (Auth::user()->usuarios_web == "1")
   <li class=""><a href="{{ route('usuarios_web.index') }}"><i class="fa fa-users"></i> Usuarios  Web</a></li>    
   @endif

 </ul>
</li>
@if (Auth::user()->empresa == "" and Auth::user()->consolidadores == "" and Auth::user()->agencias_viajes == "" and Auth::user()->lineas_aereas == "" and Auth::user()->banco == "" and Auth::user()->igv == "" and Auth::user()->incentivos == "" and Auth::user()->paises == "" and Auth::user()->ciudades == "" and Auth::user()->comision == "")
@else
{{-- ADMINISTRACION ADMIN --}}
<li class="treeview">
  <a href="#">
    <i class="fa fa-wrench"></i>
    <span>Admin </span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
   @if (Auth::user()->empresa == "1")
   <li class=""><a href="{{ route('manageEmpresa-A') }}"><i class="fa fa-building"></i> Empresa</a></li>
   @endif
   @if (Auth::user()->consolidadores == "1")
   <li class=""><a href="{{ route('manageConsolidador-A') }}"><i class="fa fa-handshake-o"></i>Consolidadores</a></li>
   @endif
   @if (Auth::user()->agencias_viajes == "1")
   <li class=""><a href="{{ route('manageAviaje-A') }}"><i class="fa fa-ticket"></i> Agencias de Viaje</a></li>
   @endif
   @if (Auth::user()->lineas_aereas == "1")
   <li class=""><a href="{{ route('manageLaerea-A') }}"><i class="fa fa-plane"></i> Líneas Aereas</a></li>
   @endif
   @if (Auth::user()->banco == "1")
   <li class=""><a href="{{ route('manageBanco-A') }}"><i class="fa fa-university"></i> Banco</a></li>
   @endif
   @if (Auth::user()->igv == "1")
   <li class=""><a href="{{ route('manageIva-A') }}"><i class="fa fa-percent"></i>IGV</a></li>
   @endif
   @if (Auth::user()->incentivos == "1")
   <li class=""><a href="{{ route('manageIncentivo-A') }}"><i class="fa fa-check-circle"></i> Incentivo</a></li>
   @endif
   @if (Auth::user()->paises == "1")
   <li class=""><a href="{{ route('managePais-A') }}"><i class="fa fa-map"></i> País</a></li>
   @endif
   @if (Auth::user()->ciudades == "1")
   <li class=""><a href="{{ route('manageCiudad-A') }}"><i class="fa fa-industry"></i> Ciudad</a></li>
   @endif
   @if (Auth::user()->comision == "1")
   <li class=""><a href="{{ route('manageComision-A') }}"><i class="fa fa-location-arrow"></i> Comisión</a></li>
   @endif

 </ul>
</li>
@endif
{{-- CERRAR SESSION --}}
<li><a href="{{route('logout')}}"><i class="fa fa-sign-out"></i> <span>Cerrar Sesión</span></a></li>
 
</ul>
</section>
<!-- /.sidebar -->
</aside>
