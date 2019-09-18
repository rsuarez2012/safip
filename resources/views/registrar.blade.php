<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="{{asset('imagenes/logo.png')}}" rel="shortcut icon" type="image/x-icon" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Libra Logistic | Registrar</title>
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
                    Registrar
        </h3>

        <form class="login-fomr" action="{{ route('registrar-store') }}" method="POST">
            {!! csrf_field() !!}

            <div class="form-group has-feedback">
                <input type="text" name="nombres" class="form-control" placeholder="Nombres">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type=text" name="apellidos" class="form-control" placeholder="Apellidos">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <p class="login-box-msg">Selecciona tu Rol dentro del Sistema</p>
            <div class="form-group {{ $errors->has('usuario') ? ' has-error' : '' }}">
                <select name="usuario" required class="form-control">
                    <option value="">Tipo de Usuario</option>
                    <option value="3">Cliente</option>
                    <option value="4">Chofer</option>
                </select>

                @if ($errors->has('usuario'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('usuario') }}</strong>
                                </span>
                @endif
            </div>

            <div class="row">
                <!-- /.col --> 
                <div class="form-actions">
                    <div class="col-xs-5">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Registrarme</button>
                    </div>
                </div>
                <!-- /.col -->
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
