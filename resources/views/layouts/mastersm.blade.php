<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{asset('imagenes/logo.png')}}" rel="shortcut icon" type="image/x-icon" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>@yield('titulo')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/jquery-theme.css')}}">

    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset("admin-lte/bootstrap/css/bootstrap.min.css")}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("font-awesome/css/font-awesome.min.css") }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset("ionicons/css/ionicons.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/AdminLTE.min.css")}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/skins/_all-skins.min.css")}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset("admin-lte/plugins/iCheck/flat/blue.css")}}">
    <!-- Morris chart -->
    <link rel="stylesheet"href="{{ asset("admin-lte/plugins/morris/morris.css")}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset("admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css")}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset("admin-lte/plugins/datepicker/datepicker3.css")}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset("admin-lte/plugins/daterangepicker/daterangepicker.css")}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset("admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}">

      <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@yield('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]-->

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

</head>


<body class="skin-red sidebar-mini sidebar-collapse">
<!---<body class="hold-transition skin-red sidebar-mini">-->

<section id="container" class="">
    <section id="main-content">




         
         

        <div class="content-header">
    @yield('content')
    </div>

    </section>

</section>



<script src="{{ asset("admin-lte/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
<script src="{{ asset("admin-lte/plugins/select2/select2.js") }}"></script>

<!-- Bootstrap 3.3.6 -->
<script src="{{ asset("admin-lte/bootstrap/js/bootstrap.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("admin-lte/dist/js/app.min.js") }}"></script>
<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/dataTables.bootstrap.js")!!}></script>
@yield('script')
</body>
</html>



