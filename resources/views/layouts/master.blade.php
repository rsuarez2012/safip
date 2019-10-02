<!DOCTYPE html>
<html>
<head>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYG5g2aJ9TjMlbYk7E_VuFYKSvHC1Ee6Y&libraries=places"
    type="text/javascript"></script>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{asset('imagenes/logo.png')}}" rel="shortcut icon" type="image/x-icon" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('titulo', 'Safip Qantutravel')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

  <link rel="stylesheet" href="{{asset('css/jquery-theme.css')}}">

  <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset("admin-lte/bootstrap/css/bootstrap.min.css")}}">

  <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset("font-awesome/css/font-awesome.min.css") }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset("ionicons/css/ionicons.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/AdminLTE.min.css")}}">

  <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/skins/_all-skins.min.css")}}">

  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset("admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css")}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset("admin-lte/plugins/datepicker/datepicker3.css")}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset("admin-lte/plugins/daterangepicker/daterangepicker.css")}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset("admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}">
  
  <link rel="stylesheet" href="{{ asset("admin-lte/plugins/select2/select2.css") }}">
  <link rel="stylesheet" href="{{asset("css/stilos.css")}}">
  <link rel="stylesheet" href="{{asset("css/chosen.css")}}">
  <link rel="stylesheet" href="{{asset("css/multiSelectCss/multi-select.css")}}">

  @stack('css')
  @yield('css')
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]-->

  {{-- <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> --}}

</head>

<body class="hold-transition skin-red sidebar-mini sidebar-collapse">
  <!---<body class="hold-transition skin-red sidebar-mini">-->

    <section id="container" class="">

      <div class="wrapper">
        @include('layouts.sidebars.sidebar')
        @include('layouts.header.header')

        <div class="content-wrapper">
          @if(session('info'))
            <section class="content-header">
              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Excelente!</strong> {{ session('info') }}
                  </div>
                </div>
              </div>
            </section>
          @elseif(session('inf'))
            <section class="content-header">
              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Vaya!</strong> {{ session('inf') }}
                  </div>
                </div>
              </div>
            </section>
          @elseif(session('error'))
            <section class="content-header">
              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Atencion!.</strong> {{ session('error') }}
                  </div>
                </div>
              </div>
            </section>
          @endif
          
          @yield('content-header')

          <section class="content">
            @yield('content')
          </section>
          
        </div>
         </div>

 @include('layouts.footer.footer')
     
     
    </section>
    <script >
      var APP_URL = {!!json_encode(url('/'))!!};
    </script>


    <script src="{{ asset('admin-lte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/vue.js') }}"></script>
    <script src="{{ asset('js/axios.js') }}"></script>

    {{-- <script src="{{ asset('admin-lte/plugins/select2/select2.js') }}"></script> --}}
    <script src="{{ asset('admin-lte/plugins/select2/select2.full.min.js') }}"></script>
    
    <!-- Bootstrap 3.3.6 -->
    <script src="{{ asset('admin-lte/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>

    <script src="{{ asset('js/toastr.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin-lte/dist/js/app.min.js') }}"></script>
    <script src="{{ asset('admin-lte/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/dataTables.bootstrap.js")!!}></script>
    {{-- <script src={!! asset("js/graficas.js")!!}></script> --}}

    <script src="{{ asset('js/select-busqueda.js') }}"></script>
    
   {{-- EXPORT --}}

    
    <script src="{{ asset('js/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/jquery-datatable/jquery-datatable.js') }}"></script>


{{-- PRUEBA DE CODEPEN EXPORT DATATABLE --}}

{{--  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> --}}

<!-- <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> -->
<script src="{{ asset('js/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.min.js') }}"></script>

<!-- <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script> -->

{{-- <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script> --}}

<script src="{{ asset('js/jquery-datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery-datatable/moment.min.js') }}"></script>
<script src="{{ asset('js/jquery-datatable/datetime-moment.js') }}"></script>
<script src="{{ asset('js/chosen.jquery.js') }}"></script>
<script src="{{ asset('js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('js/jquery.quicksearch.js') }}"></script>
<script src="{{-- asset('js/nuevo/create.js') --}}"></script>
<script src="{{-- asset('js/init.js') --}}"></script>

    @yield('script')
    @stack('scripts')
    <script>
      $(document).ready(function(){
        axios.get(APP_URL+"/get/count/boletos/sin-validar").then(response=>{
          $("#cantidad_boletos_por_validar").text(response.data)
        }).catch(errors =>{
          console.log(errors.response)
        })
        //js create
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

       
      });

    </script>
  </body>
  </html>



