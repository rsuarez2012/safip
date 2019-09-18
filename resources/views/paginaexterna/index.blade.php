<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr" >
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <!--Start of Tawk.to Script-->
    <script src="{{ asset("admin-lte/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>

    <script src="{{ asset("admin-lte/plugins/select2/select2.js") }}"></script>

    <!-- Bootstrap 3.3.6 -->
    <script src="{{ asset("admin-lte/bootstrap/js/bootstrap.min.js") }}"></script>
    <!-- AdminLTE App -->

    @yield('script')
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes"/>
    <meta name="HandheldFriendly" content="true" />
    <meta name="apple-mobile-web-app-capable" content="YES" />
    <base  />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="Qantu Travel" />
    <meta name="generator" content="Agencia de Viajes y Turismo" />
    <title>Qantu Travel Agencia de Viajes | Paquetes Turísticos, Promociones, Ofertas y Venta de destinos Nacionales e Internacionales</title>
    <link href="index.html" rel="alternate" hreflang="es-ES" />
    <link href="index.html" rel="alternate" hreflang="en-GB" />
    <link href="{{asset('web/media/k2/assets/css/k2.fonts91f5.css?v2.7.1')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('web/components2/com_k2/css/k2.css?v2.7.1')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('web/templates/system/css/system.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('web/templates/kreatico/css/estilo.css')}}" rel="stylesheet" type="text/css" media="screen,projection" />
    <link href="{{asset('web/templates/kreatico/css/animate.css')}}" rel="stylesheet" type="text/css" media="screen,projection" />
    <link href="{{asset('web/templates/kreatico/css/ihover.css')}}" rel="stylesheet" type="text/css" media="screen,projection" />
    <link href="{{asset('web/modules2/mod_ext_owl_carousel_k2_content/assets/css/owl.carousel.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('web/modules2/mod_ext_owl_carousel_k2_content/assets/css/owl.theme.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('web/modules2/mod_unite_nivoslider/tmpl/css/nivo-slider.css')}}" rel="stylesheet" type="text/css" />
    <link href="http://viajeslafayette.com/modules/mod_unite_nivoslider/tmpl/themes/default/default.css" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Raleway" rel="stylesheet" type="text/css" />
    <link href="{{asset('web/modules2/mod_gruemenu/css/styles.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('web/media/mod_languages/css/template1c7b.css?c962a9addbbb43be44030f335e571aeb')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('web/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('web/lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/style.css')}}" rel="stylesheet">

   
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5b1fb3f8a832f328d934c65b/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</style>
<!--End of Tawk.to Script-->
<link rel="icon" type="image/png" href="ico.png" />
<script type="text/javascript">
    var big        = '72%';
    var small      = '53%';
    var bildauf    = 'templates/kreatico/images/plus.html';
    var bildzu     = 'templates/kreatico/images/minus.html';
    var rightopen  = 'Open info';
    var rightclose = 'Close info';
    var altopen    = 'is open';
    var altclose   = 'is closed';
</script>
<link href="index.html" rel="alternate" hreflang="x-default" />
<script type = "text/javascript" src = "{{asset('web/modules/mod_ext_owl_carousel_k2_content/assets/js/owl.carousel.min.js')}}"></script>
<link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGvjn4HYffLM7DzhTZs9I3eAxztcEmHts" type="text/javascript"></script>
<link rel="stylesheet" href="../../maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

    @include('paginaexterna.header.header')

    @yield('content')

    @include('paginaexterna.footer.footer')

</body>

</html>
