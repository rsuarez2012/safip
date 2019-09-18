@section('css')

@endsection

@section('script')

<script type="text/javascript">
    jQuery(function(){
        $(".modregister").fadeIn(600);
    });
    jQuery(document).ready(function() {
        jQuery('#nivo_slider_91').show().nivoSlider({
            effect: 'sliceUpRight,sliceUpDown',
            slices: 15,
            boxCols: 8,
            boxRows: 4,
            animSpeed: 500,
            pauseTime: 3000,
            startSlide: 0,
            directionNav: true,
            controlNav: false,
            controlNavThumbs: false,
            pauseOnHover: true,
            manualAdvance: false,
            prevText: 'Prev',
            nextText: 'Next',
            randomStart: false,
            beforeChange: function(){},
            afterChange: function(){},
            slideshowEnd: function(){},
            lastSlide: function(){},
            afterLoad: function(){}   });
        jQuery('#register').click(function(e) {
            e.preventDefault();
            $(".modregister").fadeIn(600);
        });
        jQuery(".cerrarregister").click(function(e){
            e.preventDefault();
            $(".modregister").fadeOut(600);
        });


        }); //ready
    </script>
    <!--  End "Unite Nivo Slider" -->

    <script type="text/javascript">
        var el = document.getElementById('TheGrue90');
        if(el) {el.style.display += el.style.display = 'none';}
    </script>

    @endsection
    <header class="header">
        <div class="toplin">
            <div class="row">
                <div  style="width: 600px; margin: 0 auto; float: left;">
                    <div class="row">
                        <div style="    max-width: 150px;" class="col-lg-6 col-xs-12">
                            <div style="    margin-top: 1px;" class="idioma">
                                <i class="fa fa-globe"></i><div class="moduletable_idioma">
                                    <div class="mod-languages_idioma">
                                        <ul class="lang-inline">
                                            <li class="lang-active" dir="ltr">
                                                <a href="index.html">
                                                ESPAÑOL           </a>
                                            </li>
                                            <li dir="ltr">
                                                <a href="index.html">
                                                ENGLISH           </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="max-width: 207px !important;" class="col-lg-6 col-xs-12">
                            <div class="telefono">
                                <div class="moduletable_telefono">
                                    <div class="custom_telefono"  >
                                        <div><i class="fa fa-phone"></i> (1)299 8833 / +51 961 755 744</div></div>
                                    </div>
                                </div>
                            </div>
                            <div style="max-width: 150px !important;" class="col-lg-6 col-xs-12">
                                <div class="telefono">
                                    <div class="moduletable_telefono">
                                        <div class="custom_telefono"  >
                                            <div><i class="fa fa-facebook"></i><i class="fa fa-youtube"></i><i class="fa fa-twitter"></i></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom">
            <div class="row">
                <div style="text-align: right;" class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <a href="{{route('indexweb')}}"><img class="logo-qtu" src="{{asset('web/templates/kreatico/images/logotipo.png')}}" alt="QantuTravel"/></a>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                    <div class="buscador-general col-sm-12">
                        <div class="inner-addon left-addon">
                            <i class="glyphicon  fa fa-search"></i>
                            <input placeholder="Buscar Paquetes" type="text" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-43 col-md-4 col-sm-4 col-xs-12">
                    <div class="row">
                        <div class="registdd">
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
                            @if (Auth::guest())
                            <a data-toggle="modal" data-target="#myModal3" href="" ><i class="fa fa-list "></i><span style="float: left;margin-right: 7px;" class="image-title">Mis reservas</span></a>

                            <a data-toggle="modal" data-target="#myModal" href="" ><i class="fa fa-user "></i><span style="float: left;margin-right: 7px;" class="image-title">Inscribete</span></a>

                            <a data-toggle="modal" data-target="#myModal2" href="" ><i class="fa fa-sign-in"></i><span style="float: left;" class="image-title">Iniciar sesión</span></a>
                            @else
                            <a data-toggle="modal" data-target="" href="" ><i class="fa fa-user "></i><span style="float: left;margin-right: 7px;" class="image-title">{{Auth::User()->nombres}} {{Auth::User()->apellidos}} {{Auth::User()->role_id}}</span></a>
                            <a href="{{route('myacount')}}" ><i class="fa fa-list "></i><span style="float: left;margin-right: 7px;" class="image-title">Mi Cuenta</span></a>
                            <a href="{{route('logout2')}}" ><i cl   ass="fa fa-list "></i><span style="float: left;margin-right: 7px;" class="image-title">Cerrar Sesión</span></a>
                            @endif



                        </div>
                    </div>
                    <div class="row">

                    </div>
                </div>

            </div>
        </div>

        <div class="menup">
            <div class="custom">
                <div class="moduletable_menup">

                    <a href="#sidr-main" id="navigation-toggle" class="navigation-toggle-90"><span class="nav-line"></span><span class="nav-line"></span><span class="nav-line"></span></a>
                    <div id="sidr-close"><a href="#sidr-close" class="toggle-sidr-close"></a></div>
                    <div id="gruemenu" class="grue_90 ">
                        <ul >
                            <li class="item-104 has-sub parent">
                                <a href="{{route('general_packages')}}">
                                    <span class="separator">
                                      <img src="{{asset('web/images/iconos/vacaciones.png')}}" alt="Vacaciones" />
                                      <span class="image-title">Paquetes</span>
                                  </span>
                              </a>
                              <ul class="sub-menu"><li class="item-225 has-sub parent">
                                <a href="{{route('paquetes_nacionales')}}">
                                    <span class="separator">
                                    Nacionales</span>
                                </a>
                                <ul class="sub-menu"><li class="item-207"><a href="{{route('paquetes_nacionales_norte')}}">NORTE</a></li><li class="item-210"><a href="{{route('paquetes_nacionales_centro')}}" >CENTRO</a></li><li class="item-228"><a href="{{route('paquetes_nacionales_sur')}}" >SUR</a></li></ul></li><li class="item-226"><a href="{{route('paquetes_internacionales')}}"><span class="separator">
                                Internacionales</span></a>
                            </li><li class="item-227"><a href="{{route('paquetes_luna_miel')}}" >Luna de Miel</a></li></ul></li>
                            <li class="item-211"><a href="{{route('fullday')}}" ><img src="{{asset('web/images/iconos/cruceros.png')}}" alt="Cruceros" /><span class="image-title">Full Day</span> </a></li>
                            <li class="item-211"><a href="{{route('salidasconfirmadas')}}" ><img src="{{asset('web/images/iconos/vuelos.png')}}" alt="Cruceros" /><span class="image-title">Salidas Confirmadas</span> </a></li>
                            <li class="item-220"><a href="{{route('alojamiento')}}" ><img src="{{asset('web/images/iconos/hotel.png')}}" alt="Hoteles" /><span class="image-title">Alojamiento</span> </a></li>
                            <li class="item-222 has-sub parent"><a><span class="separator">
                              <img src="{{asset('web/images/iconos/traslados.png')}}" alt="Servicios" /><span class="image-title">Traslados</span> </span></a>
                              <ul class="sub-menu"><li class="item-219"><a href="{{route('vehiculos')}}" ><img src="{{asset('web/images/iconos/traslados.png')}}" alt="Traslados" /><span class="image-title">Traslados</span> </a></li><li class="item-223"><a href="{{route('trenes')}}" ><img src="{{asset('web/images/iconos/trains.png')}}" alt="Trenes" /><span class="image-title">Trenes</span> </a></li><li class="item-224"><a href="{{route('buses')}}" ><img src="{{asset('web/images/iconos/buses.png')}}" alt="Buses" /><span class="image-title">Buses</span> </a><a href="{{route('cruceros')}}" ><img src="{{asset('web/images/iconos/cruceros2.png')}}" alt="Buses" /><span class="image-title">Cruceros</span> </a></li></ul></li>
                              <li class="item-218"><a href="{{route('vuelos')}}" ><img src="{{asset('web/images/iconos/vuelos.png')}}" alt="Vuelos" /><span class="image-title">Vuelos</span> </a></li>
                              <li class="item-156"><a href="{{route('promociones')}}" ><img src="{{asset('web/images/iconos/oferta.png')}}" alt="Ofertas" /><span class="image-title">Promociones</span> </a></li>
                              <li class="item-156"><a href="{{route('seguros')}}" ><img src="{{asset('web/images/iconos/cruceros.png')}}" alt="Ofertas" /><span class="image-title">Seguros</span> </a></li>
                              <li class="item-156"><a href="{{route('autos')}}" ><img src="{{asset('web/images/iconos/traslados.png')}}" alt="Ofertas" /><span class="image-title">Autos</span> </a></li>
                              <li class="item-107"><a href="{{route('promocionesescolares')}}" ><img src="{{asset('web/images/iconos/oferta.png')}}" alt="Contacto" /><span class="image-title">Promociones Escolares</span> </a></li>
                          </ul>
                      </div>

                  </div>
              </div>
          </div>
      </header>
<!--
    <div class="textosobre">
  <div class="custom">
      <img src="/images/booking.png')}}"/>
  </div></div>-->
  @include('paginaexterna.register.modal_register')
