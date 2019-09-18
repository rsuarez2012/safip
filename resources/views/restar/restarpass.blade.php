<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{asset('imagenes/logo.png')}}" rel="shortcut icon" type="image/x-icon" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Libra Logistic | Reinicia Clave</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset("/admin-lte/bootstrap/css/bootstrap.min.css") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("/font-awesome/css/font-awesome.min.css") }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset("/ionicons/css/ionicons.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("/admin-lte/dist/css/AdminLTE.min.css") }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset("/admin-lte/dist/css/skins/skin-blue.min.css") }}">
    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">


<div class="login-box">
    <div class="login-logo">
        <a href="">
            <img src="{!! asset('imagenes/logo.png') !!}" class="logo col-md-12"></a>
        <div class="clearfix"></div>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <h3 class="text-center">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    Cambio de Clave
        </h3>
        <div class="form-line"></div>
        <div class="x_content">
            @if(Session::has('message'))
                <div class='alert alert-success'>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{!! Session::get('message') !!}</p>
                </div>
            @endif
        </div>
        <div class="x_content">
            @if(Session::has('message2'))
                <div class='alert alert-danger'>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{!! Session::get('message2') !!}</p>
                </div>
            @endif
        </div>

        <form class="login-fomr" action="{{ route('generador-store') }}" method="POST">
            {!! csrf_field() !!}
<h4>Correo para Reiniciar clave</h4>
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <h4>Nueva Clave</h4>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <h4>Codigo generado por el Administrador </h4>
            <div class="form-group has-feedback">
                <input type="code" name="code" class="form-control" placeholder="Codigo de Reinicio">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            
            <div class="row">
                <div class="form-actions">
                    <!--  /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Ejecutar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </form>

        <!--<div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                Google+</a>
        </div>
        <!-- /.social-auth-links -->

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="../../public/admin-lte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../public/admin-lte/bootstrap/js/bootstrap.js"></script>
<!-- iCheck -->
<script src="../../public/admin-lte/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>

</body>
</html>
