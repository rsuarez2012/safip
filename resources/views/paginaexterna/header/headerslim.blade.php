@section('css')

@endsection

@section('script')
    <script type="text/javascript">
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
        }); //ready
    </script>
    <!--  End "Unite Nivo Slider" -->

    <script type="text/javascript">
        var el = document.getElementById('TheGrue90');
        if(el) {el.style.display += el.style.display = 'none';}
    </script>

@endsection
<nav class="social">
    <ul>
        <li><a href="#">Twitter <i class="fa fa-twitter"></i></a></li>
        <li><a href="https://www.facebook.com/qantutravel" target="_blank">Facebook <i class="fa fa-facebook"></i></a></li>
        <li><a href="#">Google+ <i class="fa fa-google-plus"></i></a></li>
    </ul>
</nav>
<header class="header">
    <div class="toplin">
        <div class="row">
            <div  style="width: 600px; margin: 0 auto; float: left;">
                <div class="row">
                    <div style="    max-width: 230px;" class="col-lg-6 col-xs-12">
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
                    <div style="max-width: 228px !important;" class="col-lg-6 col-xs-12">
                        <div class="telefono">
                            <div class="moduletable_telefono">
                                <div class="custom_telefono"  >
                                    <div><i class="fa fa-phone"></i> (1)299 8833 / +51 961 755 744</div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="custom">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <a href="indexweb"><img class="logo-qtu" src="{{asset('web/templates/kreatico/images/logotipo.png')}}" alt="QantuTravel"/></a>
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
                        <a href="{{route('managePaginaExterna-register')}}" ><i class="fa fa-list "></i><span style="float: left;margin-right: 7px;" class="image-title">MIS RESERVAS</span></a>

                        <a href="{{route('managePaginaExterna-register')}}" ><i class="fa fa-user "></i><span style="float: left;margin-right: 7px;" class="image-title">INSCRIBETE</span></a>

                        <a href="http://qantutravel.com:2095/" ><i class="fa fa-sign-in"></i><span style="float: left;" class="image-title">INICIAR SESION</span></a>
                    </div>
                </div>
                <div class="row">

                </div>
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
                        <li class="item-104 has-sub parent"><a><span class="separator">
  <img src="{{asset('web/images/iconos/vacaciones.png')}}" alt="Vacaciones" /><span class="image-title">Paquetes</span> </span></a>
                            <ul class="sub-menu"><li class="item-225 has-sub parent"><a><span class="separator">
  Nacionales</span></a>
                                    <ul class="sub-menu"><li class="item-207"><a href="#" >NORTE</a></li><li class="item-210"><a href="#" >CENTRO</a></li><li class="item-228"><a href="#" >SUR</a></li></ul></li><li class="item-226"><a><span class="separator">
  Internacionales</span></a>
                                </li><li class="item-227"><a href="#" >Luna de Miel</a></li></ul></li>
                        <li class="item-211"><a href="#" ><img src="{{asset('web/images/iconos/cruceros.png')}}" alt="Cruceros" /><span class="image-title">FullDays</span> </a></li>
                        <li class="item-220"><a href="#" ><img src="{{asset('web/images/iconos/hotel.png')}}" alt="Hoteles" /><span class="image-title">Alojamiento</span> </a></li>
                        <li class="item-222 has-sub parent"><a><span class="separator">
  <img src="{{asset('web/images/iconos/traslados.png')}}" alt="Servicios" /><span class="image-title">Traslados</span> </span></a>
                            <ul class="sub-menu"><li class="item-219"><a href="#" ><img src="{{asset('web/images/iconos/traslados.png')}}" alt="Traslados" /><span class="image-title">Traslados</span> </a></li><li class="item-223"><a href="#" ><img src="{{asset('web/images/iconos/trains.png')}}" alt="Trenes" /><span class="image-title">Trenes</span> </a></li><li class="item-224"><a href="#" ><img src="{{asset('web/images/iconos/buses.png')}}" alt="Buses" /><span class="image-title">Buses</span> </a><a href="#" ><img src="{{asset('web/images/iconos/cruceros2.png')}}" alt="Buses" /><span class="image-title">Cruceros</span> </a></li></ul></li>
                        <li class="item-218"><a href="#" ><img src="{{asset('web/images/iconos/vuelos.png')}}" alt="Vuelos" /><span class="image-title">Vuelos</span> </a></li>
                        <li class="item-156"><a href="ofertas.html" ><img src="{{asset('web/images/iconos/oferta.png')}}" alt="Ofertas" /><span class="image-title">Promociones</span> </a></li>
                        <li class="item-156"><a href="ofertas.html" ><img src="{{asset('web/images/iconos/cruceros.png')}}" alt="Ofertas" /><span class="image-title">Seguros</span> </a></li>
                        <li class="item-156"><a href="ofertas.html" ><img src="{{asset('web/images/iconos/traslados.png')}}" alt="Ofertas" /><span class="image-title">Autos</span> </a></li>
                        <li class="item-107"><a href="ofertas.html" ><img src="{{asset('web/images/iconos/oferta.png')}}" alt="Contacto" /><span class="image-title">Promociones escolares</span> </a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</header>
<figure class="slide">
    <div class="moduletable_slide">
        <!--  Begin "Unite Nivo Slider" -->
        <div class="nivo-slider-wrapper theme-default" style="max-width:100%;max-height:100%;margin:0px auto;margin-top:0px;margin-bottom:0px;">
            <div id="nivo_slider_91" class="nivoSlider">

                <div class="carousel-caption d-none d-md-block">
                    <h3>  Arequipa & Colca Vía Lc Perú </h3>
                    <p>Del 07 Al 10 Diciembre</p>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-2"><i class="fa fa fa-globe "><span> Perú</span></i></div>
                        <div class="col-sm-2"><i class="fa fa fa-globe "><span> 5 Noches</span></i></div>
                        <div class="col-sm-2"><i class="fa fa fa-globe "><span> Aerolinea Peru</span></i></div>
                        <div class="col-sm-2"><i class="fa fa fa-globe "><span> 6 Cupos</span></i></div>
                    </div>
                    <div class="row">
                        <button style="margin: 0 auto;margin-top: 27px;" class="btn">Ver Paquete</button>
                    </div>
                    <div class="capa_hero"></div>
                </div>
                <img src="{{asset('web/images/slide/1.jpg')}}" alt="PARACAS-ICA" />

            </div>
            <div class="content_filt">

                <div class="content-selects">
                    <div style="display: block;" id="Tab1" class="tabcontent">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Destino" aria-label="Search for...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Fecha" aria-label="Search for...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Aereolinea" aria-label="Search for...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <button class="btn">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="Tab2" class="tabcontent">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Buscar por" aria-label="Destino">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Buscar por" aria-label="Fecha">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="Tab3" class="tabcontent">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Buscar por" aria-label="Aereolinea">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <a class="tablinks" onclick="openTab(event, 'Tab1')"><img src="{{asset('web/images/iconos/cruceros.png')}}" alt="Vuelos"><span class="image-title">Paquetes</span>
                        </a>
                        <a class="tablinks" onclick="openTab(event, 'Tab2')"><img src="{{asset('web/images/iconos/vuelos.png')}}" alt="Vuelos"><span class="image-title">Salidas Confirmadas</span>
                        </a>
                        <a class="tablinks" onclick="openTab(event, 'Tab3')"><img src="{{asset('web/images/iconos/oferta.png')}}" alt="Vuelos"><span class="image-title">Exclusiones y Entradas</span>
                        </a>
                    </div>

                </div>

            </div>
        </div>

    </div>
</figure><!--
    <div class="textosobre">
  <div class="custom">
      <img src="/images/booking.png')}}"/>
    </div></div>-->



