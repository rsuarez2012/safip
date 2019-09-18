<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{!! asset('admin-lte/dist/img/user2-160x160.jpg')!!}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <!--trea el nombre usando la variable se sesion-->
                <p>{{ Auth::user()->nombres." ".Auth::user()->apellidos }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
       <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">NAVEGACIÓN PRINCIPAL</li>
            <!--titulo del panel-->
            <li><a><i class="fa fa-book"></i> <span>Panel de control</span></a></li>
            <!--/.titulo del panel-->

            <!--titulo clientes-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Clientes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('manageCliente') }}"><i class="fa fa-circle-o"></i> Listado</a></li>
                </ul>
            </li>
            <!--/.titulo del clientes-->

            <!--titulo del Vehiculos-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i><span>Vehiculos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="{{ route('manageVehiculo') }}"><i class="fa fa-circle-o"></i> Listado</a></li>
                    <li><a href="{{ route('manageVehiculo-create') }}"><i class="fa fa-circle-o"></i> Agregar</a></li>
                </ul>
            </li>
            <!--/.titulo del Vehiculos-->

            <!--titulo del choferes-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Choferes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="{{route('manageChofer')}}"><i class="fa fa-circle-o"></i> Listado</a></li>
                    <li><a href="{{route('manageChofer-create')}}"><i class="fa fa-circle-o"></i> Agregar</a></li>
                </ul>
            </li>
            <!--/.titulo del choferes-->

            <!--titulo del Rutas-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Rutas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="index.html"><i class="fa fa-circle-o"></i> Listado</a></li>
                    <li><a href="index2.html"><i class="fa fa-circle-o"></i> Agregar</a></li>
                </ul>
            </li>
            <!--/.titulo del Rutas-->

            <!--titulo del Reservaciones-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Reservaciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="index.html"><i class="fa fa-circle-o"></i> Listado</a></li>
                    <li><a href="index2.html"><i class="fa fa-circle-o"></i> Agregar</a></li>
                </ul>
            </li>
            <!--/.titulo del Reservaciones-->

            <!--titulo del Facturacion-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Facturacion</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="index.html"><i class="fa fa-circle-o"></i> Listado</a></li>
                    <li><a href="index2.html"><i class="fa fa-circle-o"></i> Agregar Factura</a></li>
                </ul>
            </li>
            <!--/.titulo del Facturacion-->

            <!--titulo del Estadisticas-->
            <li><a href="#"><i class="fa fa-book"></i> <span>Estadisticas</span></a></li>
            <!--/.titulo del estadisticas-->

            <!--titulo del administracion-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Administracion</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="index.html"><i class="fa fa-circle-o"></i> Datos de Empresa</a></li>
                    <li><a href="index2.html"><i class="fa fa-circle-o"></i> Agregar Factura</a></li>
                </ul>
            </li>
            <!--/.titulo del administracion-->

            <!--titulo del usuarios-->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="index.html"><i class="fa fa-circle-o"></i> Roles</a></li>
                    <li><a href="index2.html"><i class="fa fa-circle-o"></i> Permisos</a></li>
                </ul>
            </li>
            <!--/.titulo del Facturacion-->


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>