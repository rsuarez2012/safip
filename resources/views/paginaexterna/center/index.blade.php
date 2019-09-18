@extends('paginaexterna.index')

@section('titulo', 'Pagina de Bienvenida')

@section('css')

@endsection

@section('script')

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#owl-example-33100").owlCarousel({
            items : 4,
            itemsCustom : false,
            itemsDesktop : false,
            itemsDesktopSmall : false,
            itemsTablet : [768,2],
            itemsTabletSmall : false,
            itemsMobile : [479,1],
            slideSpeed : 200,
            paginationSpeed : 800,
            rewindSpeed :  1000,
            autoPlay : true,
            stopOnHover : false,
            navigation : true,
            navigationText : ["prev","next"],
            rewindNav : true,
            scrollPerPage : false,
            pagination : false,
            paginationNumbers : false,
            responsive : true,
            responsiveRefreshRate : 200,
            responsiveBaseWidth : window,
            baseClass : "owl-carousel",
            theme : "owl-carousel",
            lazyLoad : false,
            lazyFollow : true,
            lazyEffect : "owl-carousel",
            autoHeight : false,
            dragBeforeAnimFinish : true,
            mouseDrag : true,
            touchDrag : true,
            addClassActive : true,
            transitionStyle : false,
            beforeUpdate : false,
            afterUpdate : false,
            beforeInit : false,
            afterInit : false,
            beforeMove : false,
            afterMove : false,
            afterAction : false,
            startDragging : false,
            afterLazyLoad: false

        });
    });
</script>
<script type="text/javascript">
    new WOW().init();
    jQuery(window).scroll(function(){
        var barra = jQuery(window).scrollTop();
        var posicion =  (barra * 0.10); /*Para cambiar la velocidad en que se movera el fondo lo haces cambiando el 0.10*/

        jQuery('.fimagen').css({
            'background-position': '0 -' + posicion + 'px'
        });

    });
    jQuery(document).ready(function(e){
            //alert('demo');
            jQuery('.owl-item').addClass('ih-item square effect10 bottom_to_top');
        })

    </script>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#owl-example-33100").owlCarousel({
                items : 4,
                itemsCustom : false,
                itemsDesktop : false,
                itemsDesktopSmall : false,
                itemsTablet : [768,2],
                itemsTabletSmall : false,
                itemsMobile : [479,1],

                slideSpeed : 200,
                paginationSpeed : 800,
                rewindSpeed :  1000,

                autoPlay : true,
                stopOnHover : false,

                navigation : true,
                navigationText : ["prev","next"],
                rewindNav : true,
                scrollPerPage : false,

                pagination : false,
                paginationNumbers : false,

                responsive : true,
                responsiveRefreshRate : 200,
                responsiveBaseWidth : window,


                baseClass : "owl-carousel",
                theme : "owl-carousel",

                lazyLoad : false,
                lazyFollow : true,
                lazyEffect : "owl-carousel",

                autoHeight : false,


                dragBeforeAnimFinish : true,
                mouseDrag : true,
                touchDrag : true,

                addClassActive : true,
                transitionStyle : false,

                beforeUpdate : false,
                afterUpdate : false,
                beforeInit : false,
                afterInit : false,
                beforeMove : false,
                afterMove : false,
                afterAction : false,
                startDragging : false,
                afterLazyLoad: false

            });


        });
    </script>

    @endsection
    @section ('content')
    @include('paginaexterna.bannerfinder.bannerfinder')
    <div class="contenido">
        <div id="system-message-container">
        </div>
        <article class="item-page">
        </article>
    </div>
    <section class="servicios">
        <div class="custom">
            <ul>
                <li class="fadeInDown animated wow animated" data-wow-delay="0s"><div class="imagen"><img src="web/templates/kreatico/images/avion.jpg" alt="Fly"/></div>
                    <div class="titulo"><i class="fa fa-plane" aria-hidden="true"></i><br />AVION<p><a href="#">VER MAS<i class="fa fa-angle-right"></i></a></p></div>

                </li>
                <li class="fadeInDown animated wow animated" data-wow-delay="0.25s"><div class="imagen"><img src="web/templates/kreatico/images/buses.jpg" alt="Bus"/></div>
                    <div class="titulo"><i class="fa fa-bus" aria-hidden="true"></i><br />TRASLADOS<p><a href="#">VER MAS<i class="fa fa-angle-right"></i></a></p></div>

                </li>
                <li class="fadeInDown animated wow animated" data-wow-delay="0.5s"><div class="imagen"><img src="web/templates/kreatico/images/trenes.jpg" alt="Trains"/></div>
                    <div class="titulo"><i class="fa fa-train" aria-hidden="true"></i><br />TRENES<p><a href="#">VER MAS<i class="fa fa-angle-right"></i></a></p></div>

                </li>
                <li class="fadeInDown animated wow animated" data-wow-delay="0.75s"><div class="imagen"><img src="web/templates/kreatico/images/hoteles.jpg" alt="Hotels"/></div>
                    <div class="titulo"><i class="fa fa-bed" aria-hidden="true"></i><br />HOTELES<p><a href="#">VER MAS<i class="fa fa-angle-right"></i></a></p></div>

                </li>
            </ul>
        </div>

    </section>
    <section class="paquetes slideInDown animated">
        <div class="icon_home"><i class="fa fa-plane" aria-hidden="true"></i></div>
        <h3 class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">SALIDAS CONFIRMADAS</h3>
        <div class="desc">Encuentra las mejores ofertas en paquetes disponibles</div>
        <div class="listado">
            <div class="custom">
                <div class="moduletable_paquetes">
                    <div class="mod_ext_owl_carousel_k2_content _paquetes">
                        <div id="owl-example-33100" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
                            <div class="owl-wrapper-outer"><div class="owl-wrapper" style="width: 3470px; left: 0px; display: block; transition: all 1000ms ease; transform: translate3d(0px, 0px, 0px);">
                                @foreach($products as $product)
                                <!-----------bloque-------->
                                <div class="owl-item ih-item square effect10 bottom_to_top active" style="width: 347px;"><div class="ext-item-wrap img">
                                    
                                    <div class="info">

                                        <i class="fa fa-suitcase"></i>
                                        <div class="ext-itemtitle">
                                            <a class="moduleItemTitle" href="vacaciones/nacionales/paracas/item/paracas.html">{{$product->name}}</a>
                                        </div>
                                        <div class="ext-itemintrotext">&nbsp;{{$product->extracto}}</div>
                                        <a class="moduleItemReadMore" href="{{url('detalle/paquete').'/'.$product->id}}">
                                            Ver mas<i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                    <span class="cupos_restantes">
                                                {{$product->cupos}} Cupos
                                            </span>
                                    <div class="ext-itemimage">
                                        <a class="ext-moduleitemimage" href="vacaciones/nacionales/paracas/item/paracas.html" title="Continue reading &quot;Tacna Histórico&quot;">
                                            <img style="width: 272.59px; height: 187.41px;" src="{{asset('uploads/images/products').'/'.$product->imagen}}" alt="PARACAS-ICA">         </a>        

                                        </div>
                                        <div class="content">
                                            <div class="ext-itemtitle">
                                                <a class="moduleItemTitle" href="vacaciones/nacionales/paracas/item/paracas.htmll">{{$product->destino}} /<span class="color_noches">{{($product->duracion)-(1)}} Noches</span></a>
                                            </div>
                                            <div class="ext-moduleitemextrafields">
                                                <ul>
                                                    <li class="typeTextfield group1">
                                                        <div class="moduleItemExtraFieldsValue-precio">
                                                            <small> Adulto </small>
                                                            S/.{{$product->precio_sol}}
                                                            $/.{{$product->precio_dolar}}
                                                            <small>Por Persona</small>
                                                        </div>
                                                    </li>
                                                    <li class="typeTextfield group1">
                                                        <div class="moduleItemExtraFieldsValue-antes">
                                                            <small>
                                                            Niño:                    </small>
                                                        0000                                   </div>
                                                    </li>
                                                    <li class="typeTextfield group1">
                                                        <div class="moduleItemExtraFieldsValue-dias">
                                                            <small>
                                                            </small>
                                                            Fecha de Salida {{$product->fecha_sale}}                                      </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-----------bloque-------->
                                    @endforeach
                                <!--<div class="owl-item ih-item square effect10 bottom_to_top active" style="width: 347px;"><div class="ext-item-wrap img">
                                            <div class="info">
                                                <i class="fa fa-suitcase"></i>
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="vacaciones/nacionales/paracas/item/paracas.html">PARACAS-ICA /<span class="color_noches"> 5 Nochea</span></a>
                                                </div>
                                                <div class="ext-itemintrotext">&nbsp;Traslado, Alojamiento, Desayunos,&nbsp;Almuerzo Buffet, Tickets</div>
                                                <a class="moduleItemReadMore" href="ruta">
                                                    Ver mas<i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>

                                            <div class="ext-itemimage">
                                                <a class="ext-moduleitemimage" href="vacaciones/nacionales/paracas/item/paracas.html" title="Continue reading &quot;Tacna Histórico&quot;">
                                                    <img src="web/media/k2/items/cache/e44a6f32e15cb53ee479b2697e759e2e_M.jpg" alt="PARACAS-ICA">         </a>        </div>

                                            <div class="content">
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="vacaciones/nacionales/paracas/item/paracas.htmll">PACARAS-ICA /<span class="color_noches"> 5 Nochea</span></a>
                                                </div>

                                                <div class="ext-moduleitemextrafields">

                                                    <ul>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-precio">
                                                                <small>
                                                                    Adulto                  </small>
                                                                S/.159.00                                         <small>Por Persona</small>                                        </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-antes">
                                                                <small>
                                                                    Niño:                    </small>
                                                                0000                                   </div>
                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-dias">
                                                                <small>
                                                                </small>
                                                                FULL DAY
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                    <!--<div class="owl-item ih-item square effect10 bottom_to_top active" style="width: 347px;"><div class="ext-item-wrap img">
                                            <div class="info">
                                                <i class="fa fa-suitcase"></i>
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="vacaciones/nacionales/lunahuana/item/lunahuana.html">LUNAHUANA /<span class="color_noches"> 5 Nochea</span></a>
                                                </div>
                                                <div class="ext-itemintrotext">&nbsp;Traslado, Alojamiento, Desayunos,&nbsp;Almuerzo Buffet, Tickets</div>
                                                <a class="moduleItemReadMore" href="vacaciones/nacionales/lunahuana/item/lunahuana.html">
                                                    Ver mas<i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                            <div class="ext-itemimage">
                                                <a class="ext-moduleitemimage" href="vacaciones/nacionales/lunahuana/item/lunahuana.html" title="Continue reading &quot;Iquitos Natural&quot;">
                                                    <img src="web/media/k2/items/cache/ea457adccaa9e569cff05de9b4f3b04d_M.jpg" alt="Lunahuana">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="vacaciones/nacionales/lunahuana/item/lunahuana.html">LUNAHUANA /<span class="color_noches"> 5 Nochea</span></a>
                                                </div>
                                                <div class="ext-moduleitemextrafields">
                                                    <ul>
                                                        <li class="typeTextfield group1">
                                                            <div class="moduleItemExtraFieldsValue-precio">
                                                                <small>
                                                                    Adulto                   </small>
                                                                S/.99.00                                        <small>Por Persona</small>                                        </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-antes">
                                                                <small>
                                                                    Niños:                    </small>
                                                                0000                                   </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-dias">
                                                                <small>
                                                                </small>
                                                                FULL DAY
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>

                                        </div>
                                    </div>-->
                                    <!--<div class="owl-item ih-item square effect10 bottom_to_top active" ><div class="ext-item-wrap img">

                                            <div class="info">
                                                <i class="fa fa-suitcase"></i>
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="vacaciones/nacionales/rupac/item/rupac.html">RUPAC /<span class="color_noches"> 5 Nochea</span></a>
                                                </div>

                                                <div class="ext-itemintrotext">&nbsp;Traslado, Alojamiento, Desayunos,&nbsp;Almuerzo Buffet, Tickets</div>

                                                <a class="moduleItemReadMore" href="vacaciones/nacionales/rupac/item/rupac.html">
                                                    Ver mas<i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>

                                            <div class="ext-itemimage">
                                                <a class="ext-moduleitemimage" href="vacaciones/nacionales/rupac/item/rupac.html" title="Continue reading &quot;RupacAncestral&quot;">
                                                    <img src="web/media/k2/items/cache/88f135a483ef01fac8d7b920488085e4_M.jpg" alt="Rupac">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="vacaciones/nacionales/rupac/item/rupac.html">RUPAC /<span class="color_noches"> 5 Nochea</span></a>
                                                </div>

                                                <div class="ext-moduleitemextrafields">
                                                    <ul>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-precio">
                                                                <small>
                                                                    Desde                    </small>
                                                                S/.155.00                                         <small>Por Persona</small>                                        </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-antes">
                                                                <small>
                                                                    Niños:                    </small>
                                                                0000                                        </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-dias">
                                                                <small>
                                                                </small>
                                                                2D/1N                                        </div>

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                    <!--<div class="owl-item ih-item square effect10 bottom_to_top active" style="width: 347px;"><div class="ext-item-wrap img">

                                            <div class="info">
                                                <i class="fa fa-suitcase"></i>
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="#">LIMA </a>
                                                </div>
                                                <div class="ext-itemintrotext">&nbsp;Traslado, Alojamiento, Desayunos,&nbsp;Almuerzo Buffet, Tickets</div>
                                                <a class="moduleItemReadMore" href="#">
                                                    Ver mas<i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                            <div class="ext-itemimage">
                                                <a class="ext-moduleitemimage" href="#" title="Continue reading &quot;Lima Ciudad de Reyes&quot;">
                                                    <img src="web/media/k2/items/cache/358873fad4914931314b94f2036b503a_M.jpg" alt="Lima Ciudad de Reyes">          </a>        </div>

                                            <div class="content">
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="#">LIMA /<span class="color_noches"> 5 Nochea</span></a>
                                                </div>

                                                <div class="ext-moduleitemextrafields">

                                                    <ul>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-precio">
                                                                <small>
                                                                    Desde                    </small>
                                                                S/.250.00                                       <small>Por Persona</small>                                        </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-antes">
                                                                <small>
                                                                    Niños:                    </small>
                                                                000                                       </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-dias">
                                                                <small>
                                                                </small>
                                                                3D/2N                                        </div>

                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>-->
                                    <!--<div class="owl-item ih-item square effect10 bottom_to_top" style="width: 347px;"><div class="ext-item-wrap img">

                                            <div class="info">
                                                <i class="fa fa-suitcase"></i>
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="#">CUSCO</a>
                                                </div>

                                                <div class="ext-itemintrotext">&nbsp;Traslado, Alojamiento, Desayunos,&nbsp;Almuerzo Buffet, Tickets</div>

                                                <a class="moduleItemReadMore" href="#">
                                                    Ver mas<i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                            <div class="ext-itemimage">
                                                <a class="ext-moduleitemimage" href="#" title="Continue reading &quot;Amanecer en Valle Sagrado&quot;">
                                                    <img src="web/media/k2/items/cache/ba1b7eb9b8ad142948e3b9dce300b4c6_M.jpg" alt="Amanecer en Valle Sagrado">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="#">CUSCO</a>
                                                </div>
                                                <div class="ext-moduleitemextrafields">
                                                    <ul>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-precio">
                                                                <small>
                                                                    Desde                    </small>
                                                                S/.369                                        <small>Por Persona</small>                                        </div>

                                                        </li>
                                                        <li class="typeTextfield group1">
                                                            <div class="moduleItemExtraFieldsValue-antes">
                                                                <small>
                                                                    Niños:                    </small>
                                                                0000                                      </div>

                                                        </li>
                                                        <li class="typeTextfield group1">
                                                            <div class="moduleItemExtraFieldsValue-dias">
                                                                <small>
                                                                </small>
                                                                4D/3N                                        </div>

                                                        </li>
                                                    </ul>
                                                </div>


                                            </div>

                                        </div>
                                    </div>-->
                                </div>
                            </div>


                            <div class="owl-controls"><div class="owl-buttons"><div class="owl-prev">prev</div>
                            <div class="owl-next">next</div>
                        </div>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
</div>
</section>
<section class="paquetes slideInDown animated">
    <div class="icon_home2"><i class="fa fa-suitcase" aria-hidden="true"></i></div>

    <h3 style="color: #c90e14;" class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">ÚLTIMOS PAQUETES</h3>
    <div class="desc">Encuentra las mejores ofertas en paquetes disponibles</div>
    <div class="listado">
        <div class="custom">
            <div class="moduletable_paquetes">

                <div class="mod_ext_owl_carousel_k2_content _paquetes">
                    <div id="owl-example-33100" class="owl-carousel owl-theme" style="opacity: 1; display: block;">

                        <div class="owl-wrapper-outer"><div class="owl-wrapper" style="width: 3470px; left: 0px; display: block; transition: all 1000ms ease; transform: translate3d(0px, 0px, 0px);">
                            @foreach($products_featured as $product_f)
                            <!-----------bloque-------->
                            <div class="owl-item ih-item square effect10 bottom_to_top active" style="width: 347px;"><div class="ext-item-wrap img">
                                <div class="info">
                                    <i class="fa fa-suitcase"></i>
                                    <div class="ext-itemtitle">
                                        <a class="moduleItemTitle" href="vacaciones/nacionales/paracas/item/paracas.html">{{$product_f->name}}</a>
                                    </div>
                                    <div class="ext-itemintrotext">&nbsp;{{$product_f->extracto}}</div>
                                    <a class="moduleItemReadMore" href="{{url('detalle/paquete').'/'.$product_f->id}}">
                                        Ver mas<i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                                <div class="ext-itemimage">
                                    <a class="ext-moduleitemimage" href="vacaciones/nacionales/paracas/item/paracas.html" title="Continue reading &quot;Tacna Histórico&quot;">
                                        <img style="width: 272.59px; height: 187.41px;" src="{{asset('uploads/images/products').'/'.$product_f->imagen}}" alt="PARACAS-ICA">         </a>        </div>
                                        <div class="content">
                                            <div class="ext-itemtitle">
                                                <a class="moduleItemTitle" href="vacaciones/nacionales/paracas/item/paracas.htmll">{{$product_f->destino}} /<span class="color_noches">{{($product_f->duration)-(1)}} Noches</span></a>
                                            </div>
                                            <div class="ext-moduleitemextrafields">
                                                <ul>
                                                    <li class="typeTextfield group1">
                                                        <div class="moduleItemExtraFieldsValue-precio">
                                                            <small> Adulto </small>
                                                            S/.{{$product_f->precio_sol}}
                                                            $/.{{$product_f->precio_dolar}}
                                                            <small>Por Persona</small>
                                                        </div>
                                                    </li>
                                                    <li class="typeTextfield group1">
                                                        <div class="moduleItemExtraFieldsValue-antes">
                                                            <small>
                                                            Niño:                    </small>
                                                        0000                                   </div>
                                                    </li>
                                                    <li class="typeTextfield group1">
                                                        <div class="moduleItemExtraFieldsValue-dias">
                                                            <small>
                                                            </small>
                                                            {{$product_f->categoria}}                                      </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-----------bloque-------->
                                    @endforeach
                                <!--<div class="owl-item ih-item square effect10 bottom_to_top active" style="width: 347px;"><div class="ext-item-wrap img">

                                            <div class="info">
                                                <i class="fa fa-suitcase"></i>
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="vacaciones/nacionales/lunahuana/item/lunahuana.html">LUNAHUANA /<span class="color_noches"> 5 Noches</span></a>
                                                </div>

                                                <div class="ext-itemintrotext">&nbsp;Traslado, Alojamiento, Desayunos,&nbsp;Almuerzo Buffet, Tickets</div>

                                                <a class="moduleItemReadMore" href="vacaciones/nacionales/lunahuana/item/lunahuana.html">
                                                    Ver mas<i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                            <div class="ext-itemimage">
                                                <a class="ext-moduleitemimage" href="vacaciones/nacionales/lunahuana/item/lunahuana.html" title="Continue reading &quot;Iquitos Natural&quot;">
                                                    <img src="web/media/k2/items/cache/ea457adccaa9e569cff05de9b4f3b04d_M.jpg" alt="Lunahuana">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="vacaciones/nacionales/lunahuana/item/lunahuana.html">LUNAHUANA /<span class="color_noches"> 5 Nochea</span></a>
                                                </div>
                                                <div class="ext-moduleitemextrafields">
                                                    <ul>
                                                        <li class="typeTextfield group1">
                                                            <div class="moduleItemExtraFieldsValue-precio">
                                                                <small>
                                                                    Adulto                   </small>
                                                                S/.99.00                                        <small>Por Persona</small>                                        </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-antes">
                                                                <small>
                                                                    Niños:                    </small>
                                                                0000                                   </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-dias">
                                                                <small>
                                                                </small>
                                                                FULL DAY                                     </div>

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                    <!--<div class="owl-item ih-item square effect10 bottom_to_top active" ><div class="ext-item-wrap img">

                                            <div class="info">
                                                <i class="fa fa-suitcase"></i>
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="vacaciones/nacionales/rupac/item/rupac.html">RUPAC</a>
                                                </div>
                                                <div class="ext-itemintrotext">&nbsp;Traslado, Alojamiento, Desayunos,&nbsp;Almuerzo Buffet, Tickets</div>
                                                <a class="moduleItemReadMore" href="vacaciones/nacionales/rupac/item/rupac.html">
                                                    Ver mas<i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                            <div class="ext-itemimage">
                                                <a class="ext-moduleitemimage" href="vacaciones/nacionales/rupac/item/rupac.html" title="Continue reading &quot;RupacAncestral&quot;">
                                                    <img src="web/media/k2/items/cache/88f135a483ef01fac8d7b920488085e4_M.jpg" alt="Rupac">         </a>        </div>
                                            <div class="content">
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="vacaciones/nacionales/rupac/item/rupac.html">RUPAC /<span class="color_noches"> 5 Nochea</span></a>
                                                </div>
                                                <div class="ext-moduleitemextrafields">
                                                    <ul>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-precio">
                                                                <small>
                                                                    Desde                    </small>
                                                                S/.155.00                                         <small>Por Persona</small>                                        </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-antes">
                                                                <small>
                                                                    Niños:                    </small>
                                                                0000                                        </div>
                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-dias">
                                                                <small>
                                                                </small>
                                                                2D/1N                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>-->
                                    <!--<div class="owl-item ih-item square effect10 bottom_to_top active" style="width: 347px;"><div class="ext-item-wrap img">

                                            <div class="info">
                                                <i class="fa fa-suitcase"></i>
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="#">LIMA</a>
                                                </div>

                                                <div class="ext-itemintrotext">&nbsp;Traslado, Alojamiento, Desayunos,&nbsp;Almuerzo Buffet, Tickets</div>

                                                <a class="moduleItemReadMore" href="#">
                                                    Ver mas<i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                            <div class="ext-itemimage">
                                                <a class="ext-moduleitemimage" href="#" title="Continue reading &quot;Lima Ciudad de Reyes&quot;">
                                                    <img src="web/media/k2/items/cache/358873fad4914931314b94f2036b503a_M.jpg" alt="Lima Ciudad de Reyes">          </a>        </div>

                                            <div class="content">
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="#">LIMA /<span class="color_noches"> 5 Nochea</span></a>
                                                </div>

                                                <div class="ext-moduleitemextrafields">

                                                    <ul>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-precio">
                                                                <small>
                                                                    Desde                    </small>
                                                                S/.250.00                                       <small>Por Persona</small>                                        </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-antes">
                                                                <small>
                                                                    Niños:                    </small>
                                                                000                                       </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-dias">
                                                                <small>
                                                                </small>
                                                                3D/2N                                        </div>

                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>



                                        </div>
                                    </div>-->
                                    <!--<div class="owl-item ih-item square effect10 bottom_to_top" style="width: 347px;"><div class="ext-item-wrap img">

                                            <div class="info">
                                                <i class="fa fa-suitcase"></i>
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="#">CUSCO</a>
                                                </div>

                                                <div class="ext-itemintrotext">&nbsp;Traslado, Alojamiento, Desayunos,&nbsp;Almuerzo Buffet, Tickets</div>

                                                <a class="moduleItemReadMore" href="#">
                                                    Ver mas<i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>



                                            <div class="ext-itemimage">
                                                <a class="ext-moduleitemimage" href="#" title="Continue reading &quot;Amanecer en Valle Sagrado&quot;">
                                                    <img src="web/media/k2/items/cache/ba1b7eb9b8ad142948e3b9dce300b4c6_M.jpg" alt="Amanecer en Valle Sagrado">         </a>        </div>

                                            <div class="content">
                                                <div class="ext-itemtitle">
                                                    <a class="moduleItemTitle" href="#">CUSCO</a>
                                                </div>

                                                <div class="ext-moduleitemextrafields">

                                                    <ul>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-precio">
                                                                <small>
                                                                    Desde                    </small>
                                                                S/.369                                        <small>Por Persona</small>                                        </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-antes">
                                                                <small>
                                                                    Niños:                    </small>
                                                                0000                                      </div>

                                                        </li>
                                                        <li class="typeTextfield group1">

                                                            <div class="moduleItemExtraFieldsValue-dias">
                                                                <small>
                                                                </small>
                                                                4D/3N                                        </div>

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                            <div class="owl-controls"><div class="owl-buttons"><div class="owl-prev">prev</div>
                            <div class="owl-next">next</div>
                        </div>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
</div>
</section>
<div class="ultimos wow fadeInDown animated">
    <div class="custom">
        <div class="listado_u one">
            <h3>ULTIMOS PAQUETES INTERNACIONALES</h3>
            <div class="moduletable circuitos">
                <div id="k2ModuleBox153" class="k2ItemsBlock  circuitos">
                    <ul>
                        <li class="first">
                            <!-- Plugins: AfterDisplayTitle -->
                            <!-- K2 Plugins: K2AfterDisplayTitle -->
                            <div class="moduleItemTitle">
                                <a  href="#">CARTAGENA</a>
                            </div>
                            <!-- Plugins: BeforeDisplayContent -->
                            <!-- K2 Plugins: K2BeforeDisplayContent -->
                            <div class="moduleItemExtraFields">
                                <div class="moduleItemExtraFieldsValue1">$599</div>
                                <div class="moduleItemExtraFieldsValue2">$550</div>
                                <div class="moduleItemExtraFieldsValue4">5D/4N</div>
                                <div class="moduleItemReadMore">
                                    <a  href="#">
                                    Ver mas     </a>
                                </div>
                            </div>
                            <div class="clr"></div>


                            <!-- Plugins: AfterDisplayContent -->

                            <!-- K2 Plugins: K2AfterDisplayContent -->

                            <!-- Plugins: AfterDisplay -->

                            <!-- K2 Plugins: K2AfterDisplay -->

                            <div class="clr"></div>

                        </li>
                        <li class="first">

                            <!-- Plugins: BeforeDisplay -->

                            <!-- K2 Plugins: K2BeforeDisplay -->


                            <div class="moduleItemTitle">
                                <a  href="#">FOZ DE IGUAZU</a>
                            </div>



                            <!-- Plugins: AfterDisplayTitle -->

                            <!-- K2 Plugins: K2AfterDisplayTitle -->

                            <!-- Plugins: BeforeDisplayContent -->

                            <!-- K2 Plugins: K2BeforeDisplayContent -->


                            <div class="moduleItemExtraFields">
                                <div class="moduleItemExtraFieldsValue1">$595</div>

                                <div class="moduleItemExtraFieldsValue2">$595</div>

                                <div class="moduleItemExtraFieldsValue4">5D/4N</div>


                                <div class="moduleItemReadMore">
                                    <a  href="#">
                                    Ver mas     </a>
                                </div>

                            </div>


                            <div class="clr"></div>


                            <!-- Plugins: AfterDisplayContent -->

                            <!-- K2 Plugins: K2AfterDisplayContent -->



                            <!-- Plugins: AfterDisplay -->

                            <!-- K2 Plugins: K2AfterDisplay -->

                            <div class="clr"></div>

                        </li>
                        <li class="first">

                            <!-- Plugins: BeforeDisplay -->

                            <!-- K2 Plugins: K2BeforeDisplay -->


                            <div class="moduleItemTitle">
                                <a  href="#">PUNTA CANA</a>
                            </div>



                            <!-- Plugins: AfterDisplayTitle -->

                            <!-- K2 Plugins: K2AfterDisplayTitle -->

                            <!-- Plugins: BeforeDisplayContent -->

                            <!-- K2 Plugins: K2BeforeDisplayContent -->


                            <div class="moduleItemExtraFields">
                                <div class="moduleItemExtraFieldsValue1">$850</div>

                                <div class="moduleItemExtraFieldsValue2">$852</div>

                                <div class="moduleItemExtraFieldsValue4">4D/3N</div>
                                <div class="moduleItemReadMore">
                                    <a  href="#">
                                    Ver mas     </a>
                                </div>

                            </div>


                            <div class="clr"></div>


                            <!-- Plugins: AfterDisplayContent -->

                            <!-- K2 Plugins: K2AfterDisplayContent -->



                            <!-- Plugins: AfterDisplay -->

                            <!-- K2 Plugins: K2AfterDisplay -->

                            <div class="clr"></div>

                        </li>
                        <li class="first">

                            <!-- Plugins: BeforeDisplay -->

                            <!-- K2 Plugins: K2BeforeDisplay -->


                            <div class="moduleItemTitle">
                                <a  href="#">EUROPA EN BREVE</a>
                            </div>



                            <!-- Plugins: AfterDisplayTitle -->

                            <!-- K2 Plugins: K2AfterDisplayTitle -->

                            <!-- Plugins: BeforeDisplayContent -->

                            <!-- K2 Plugins: K2BeforeDisplayContent -->


                            <div class="moduleItemExtraFields">
                                <div class="moduleItemExtraFieldsValue1">$2.859</div>

                                <div class="moduleItemExtraFieldsValue2">$2.859</div>

                                <div class="moduleItemExtraFieldsValue4">17D/16N</div>


                                <div class="moduleItemReadMore">
                                    <a  href="#">
                                    Ver mas     </a>
                                </div>

                            </div>


                            <div class="clr"></div>


                            <!-- Plugins: AfterDisplayContent -->

                            <!-- K2 Plugins: K2AfterDisplayContent -->


                            <!-- Plugins: AfterDisplay -->

                            <!-- K2 Plugins: K2AfterDisplay -->

                            <div class="clr"></div>

                        </li>
                        <li class="first">

                            <!-- Plugins: BeforeDisplay -->

                            <!-- K2 Plugins: K2BeforeDisplay -->


                            <div class="moduleItemTitle">
                                <a  href="#">EUROPA QUERIDA</a>
                            </div>



                            <!-- Plugins: AfterDisplayTitle -->

                            <!-- K2 Plugins: K2AfterDisplayTitle -->

                            <!-- Plugins: BeforeDisplayContent -->

                            <!-- K2 Plugins: K2BeforeDisplayContent -->


                            <div class="moduleItemExtraFields">
                                <div class="moduleItemExtraFieldsValue1">$3.199</div>

                                <div class="moduleItemExtraFieldsValue2">$3.199</div>

                                <div class="moduleItemExtraFieldsValue4">21D/20N</div>


                                <div class="moduleItemReadMore">
                                    <a  href="#">
                                    Ver mas     </a>
                                </div>

                            </div>

                            <div class="clr"></div>


                            <!-- Plugins: AfterDisplayContent -->

                            <!-- K2 Plugins: K2AfterDisplayContent -->



                            <!-- Plugins: AfterDisplay -->

                            <!-- K2 Plugins: K2AfterDisplay -->

                            <div class="clr"></div>

                        </li>
                        <li class="clearList"></li>
                    </ul>

                </div>

            </div>


        </div>


        <div class="listado_u two">
            <h3>ULTIMAS PROMOCIONES FULL DAYS</h3>
            <div class="moduletable circuitos">

                <div id="k2ModuleBox153" class="k2ItemsBlock  circuitos">


                    <ul>
                        <li class="first">

                            <!-- Plugins: BeforeDisplay -->

                            <!-- K2 Plugins: K2BeforeDisplay -->


                            <div class="moduleItemTitle">
                                <a  href="#">PARACAS - ICA</a>
                            </div>


                            <!-- Plugins: AfterDisplayTitle -->

                            <!-- K2 Plugins: K2AfterDisplayTitle -->

                            <!-- Plugins: BeforeDisplayContent -->

                            <!-- K2 Plugins: K2BeforeDisplayContent -->


                            <div class="moduleItemExtraFields">
                                <div class="moduleItemExtraFieldsValue1">S/.159.00</div>

                                <div class="moduleItemExtraFieldsValue2">$550</div>

                                <div class="moduleItemExtraFieldsValue4">0D/0N</div>


                                <div class="moduleItemReadMore">
                                    <a  href="vacaciones/nacionales/paracas/item/paracas.html">
                                    Ver mas     </a>            </div>

                                </div>


                                <div class="clr"></div>


                                <!-- Plugins: AfterDisplayContent -->

                                <!-- K2 Plugins: K2AfterDisplayContent -->

                                <!-- Plugins: AfterDisplay -->

                                <!-- K2 Plugins: K2AfterDisplay -->

                                <div class="clr"></div>

                            </li>
                            <li class="first">

                                <!-- Plugins: BeforeDisplay -->

                                <!-- K2 Plugins: K2BeforeDisplay -->


                                <div class="moduleItemTitle">
                                    <a  href="#">LUNAHUANA</a>
                                </div>



                                <!-- Plugins: AfterDisplayTitle -->

                                <!-- K2 Plugins: K2AfterDisplayTitle -->

                                <!-- Plugins: BeforeDisplayContent -->

                                <!-- K2 Plugins: K2BeforeDisplayContent -->


                                <div class="moduleItemExtraFields">
                                    <div class="moduleItemExtraFieldsValue1">S/.99</div>

                                    <div class="moduleItemExtraFieldsValue2">$550</div>

                                    <div class="moduleItemExtraFieldsValue4">0D/0N</div>


                                    <div class="moduleItemReadMore">
                                        <a  href="vacaciones/nacionales/lunahuana/item/lunahuana.html">
                                        Ver mas     </a>            </div>

                                    </div>


                                    <div class="clr"></div>


                                    <!-- Plugins: AfterDisplayContent -->

                                    <!-- K2 Plugins: K2AfterDisplayContent -->

                                    <!-- Plugins: AfterDisplay -->

                                    <!-- K2 Plugins: K2AfterDisplay -->

                                    <div class="clr"></div>

                                </li>
                                <li class="first">

                                    <!-- Plugins: BeforeDisplay -->

                                    <!-- K2 Plugins: K2BeforeDisplay -->


                                    <div class="moduleItemTitle">
                                        <a  href="#">RUPAC</a>
                                    </div>



                                    <!-- Plugins: AfterDisplayTitle -->

                                    <!-- K2 Plugins: K2AfterDisplayTitle -->

                                    <!-- Plugins: BeforeDisplayContent -->

                                    <!-- K2 Plugins: K2BeforeDisplayContent -->


                                    <div class="moduleItemExtraFields">
                                        <div class="moduleItemExtraFieldsValue1">S/.155.00</div>

                                        <div class="moduleItemExtraFieldsValue2">$550</div>

                                        <div class="moduleItemExtraFieldsValue4">0D/0N</div>


                                        <div class="moduleItemReadMore">
                                            <a  href="vacaciones/nacionales/rupac/item/rupac.html">
                                            Ver mas     </a>            </div>

                                        </div>


                                        <div class="clr"></div>


                                        <!-- Plugins: AfterDisplayContent -->

                                        <!-- K2 Plugins: K2AfterDisplayContent -->


                                        <!-- Plugins: AfterDisplay -->

                                        <!-- K2 Plugins: K2AfterDisplay -->

                                        <div class="clr"></div>

                                    </li>
                                    <li class="first">

                                        <!-- Plugins: BeforeDisplay -->

                                        <!-- K2 Plugins: K2BeforeDisplay -->


                                        <div class="moduleItemTitle">
                                            <a  href="#">CANTA OBRAJILLO </a>
                                        </div>



                                        <!-- Plugins: AfterDisplayTitle -->

                                        <!-- K2 Plugins: K2AfterDisplayTitle -->

                                        <!-- Plugins: BeforeDisplayContent -->

                                        <!-- K2 Plugins: K2BeforeDisplayContent -->


                                        <div class="moduleItemExtraFields">
                                            <div class="moduleItemExtraFieldsValue1">S/.85.00</div>

                                            <div class="moduleItemExtraFieldsValue2">$550</div>

                                            <div class="moduleItemExtraFieldsValue4">0D/0N</div>


                                            <div class="moduleItemReadMore">
                                                <a  href="#">
                                                Ver mas     </a>
                                            </div>

                                        </div>


                                        <div class="clr"></div>


                                        <!-- Plugins: AfterDisplayContent -->

                                        <!-- K2 Plugins: K2AfterDisplayContent -->

                                        <!-- Plugins: AfterDisplay -->

                                        <!-- K2 Plugins: K2AfterDisplay -->

                                        <div class="clr"></div>

                                    </li>
                                    <li class="first">

                                        <!-- Plugins: BeforeDisplay -->

                                        <!-- K2 Plugins: K2BeforeDisplay -->


                                        <div class="moduleItemTitle">
                                            <a  href="#">HUANCAYA</a>
                                        </div>



                                        <!-- Plugins: AfterDisplayTitle -->

                                        <!-- K2 Plugins: K2AfterDisplayTitle -->

                                        <!-- Plugins: BeforeDisplayContent -->

                                        <!-- K2 Plugins: K2BeforeDisplayContent -->


                                        <div class="moduleItemExtraFields">
                                            <div class="moduleItemExtraFieldsValue1">S/.290</div>

                                            <div class="moduleItemExtraFieldsValue2">S/.290</div>

                                            <div class="moduleItemExtraFieldsValue4">0D/0N</div>


                                            <div class="moduleItemReadMore">
                                                <a  href="#">
                                                Ver mas     </a>
                                            </div>

                                        </div>





                                        <div class="clr"></div>


                                        <!-- Plugins: AfterDisplayContent -->

                                        <!-- K2 Plugins: K2AfterDisplayContent -->


                                        <!-- Plugins: AfterDisplay -->

                                        <!-- K2 Plugins: K2AfterDisplay -->

                                        <div class="clr"></div>

                                    </li>
                                    <li class="clearList"></li>
                                </ul>
                            </div>

                        </div>


                    </div>

                    <div class="listado_u one">
                        <h3>ULTIMOS PAQUETES NACIONALES</h3>
                        <div class="moduletable circuitos">

                            <div id="k2ModuleBox153" class="k2ItemsBlock  circuitos">


                                <ul>
                                    <li class="first">

                                        <!-- Plugins: BeforeDisplay -->

                                        <!-- K2 Plugins: K2BeforeDisplay -->


                                        <div class="moduleItemTitle">
                                            <a  href="#">TARAPOTO</a>
                                        </div>



                                        <!-- Plugins: AfterDisplayTitle -->

                                        <!-- K2 Plugins: K2AfterDisplayTitle -->

                                        <!-- Plugins: BeforeDisplayContent -->

                                        <!-- K2 Plugins: K2BeforeDisplayContent -->


                                        <div class="moduleItemExtraFields">
                                            <div class="moduleItemExtraFieldsValue1">$350</div>

                                            <div class="moduleItemExtraFieldsValue2">$550</div>

                                            <div class="moduleItemExtraFieldsValue4">4D/3N</div>


                                            <div class="moduleItemReadMore">
                                                <a  href="#">
                                                Ver mas     </a>
                                            </div>

                                        </div>


                                        <div class="clr"></div>


                                        <!-- Plugins: AfterDisplayContent -->

                                        <!-- K2 Plugins: K2AfterDisplayContent -->


                                        <!-- Plugins: AfterDisplay -->

                                        <!-- K2 Plugins: K2AfterDisplay -->

                                        <div class="clr"></div>

                                    </li>
                                    <li class="first">

                                        <!-- Plugins: BeforeDisplay -->

                                        <!-- K2 Plugins: K2BeforeDisplay -->


                                        <div class="moduleItemTitle">
                                            <a  href="#">SELVA CENTRAL</a>
                                        </div>



                                        <!-- Plugins: AfterDisplayTitle -->

                                        <!-- K2 Plugins: K2AfterDisplayTitle -->

                                        <!-- Plugins: BeforeDisplayContent -->

                                        <!-- K2 Plugins: K2BeforeDisplayContent -->


                                        <div class="moduleItemExtraFields">
                                            <div class="moduleItemExtraFieldsValue1">$290</div>

                                            <div class="moduleItemExtraFieldsValue2">$550</div>

                                            <div class="moduleItemExtraFieldsValue4">4D/3N</div>


                                            <div class="moduleItemReadMore">
                                                <a  href="#">
                                                Ver mas     </a>
                                            </div>

                                        </div>


                                        <div class="clr"></div>


                                        <!-- Plugins: AfterDisplayContent -->

                                        <!-- K2 Plugins: K2AfterDisplayContent -->


                                        <!-- Plugins: AfterDisplay -->

                                        <!-- K2 Plugins: K2AfterDisplay -->

                                        <div class="clr"></div>

                                    </li>
                                    <li class="first">

                                        <!-- Plugins: BeforeDisplay -->

                                        <!-- K2 Plugins: K2BeforeDisplay -->


                                        <div class="moduleItemTitle">
                                            <a  href="#">CUSCO</a>
                                        </div>



                                        <!-- Plugins: AfterDisplayTitle -->

                                        <!-- K2 Plugins: K2AfterDisplayTitle -->

                                        <!-- Plugins: BeforeDisplayContent -->

                                        <!-- K2 Plugins: K2BeforeDisplayContent -->


                                        <div class="moduleItemExtraFields">
                                            <div class="moduleItemExtraFieldsValue1">$369</div>

                                            <div class="moduleItemExtraFieldsValue2">$550</div>

                                            <div class="moduleItemExtraFieldsValue4">4D/3N</div>


                                            <div class="moduleItemReadMore">
                                                <a  href="#">
                                                Ver mas     </a>
                                            </div>

                                        </div>



                                        <div class="clr"></div>


                                        <!-- Plugins: AfterDisplayContent -->

                                        <!-- K2 Plugins: K2AfterDisplayContent -->


                                        <!-- Plugins: AfterDisplay -->

                                        <!-- K2 Plugins: K2AfterDisplay -->

                                        <div class="clr"></div>

                                    </li>
                                    <li class="first">

                                        <!-- Plugins: BeforeDisplay -->

                                        <!-- K2 Plugins: K2BeforeDisplay -->


                                        <div class="moduleItemTitle">
                                            <a  href="#">HUANCAYA</a>
                                        </div>



                                        <!-- Plugins: AfterDisplayTitle -->

                                        <!-- K2 Plugins: K2AfterDisplayTitle -->

                                        <!-- Plugins: BeforeDisplayContent -->

                                        <!-- K2 Plugins: K2BeforeDisplayContent -->


                                        <div class="moduleItemExtraFields">
                                            <div class="moduleItemExtraFieldsValue1">S/.290</div>

                                            <div class="moduleItemExtraFieldsValue2">$550</div>

                                            <div class="moduleItemExtraFieldsValue4">2D/1N</div>


                                            <div class="moduleItemReadMore">
                                                <a  href="#">
                                                Ver mas     </a>
                                            </div>

                                        </div>





                                        <div class="clr"></div>


                                        <!-- Plugins: AfterDisplayContent -->

                                        <!-- K2 Plugins: K2AfterDisplayContent -->


                                        <!-- Plugins: AfterDisplay -->

                                        <!-- K2 Plugins: K2AfterDisplay -->

                                        <div class="clr"></div>

                                    </li>
                                    <li class="first">

                                        <!-- Plugins: BeforeDisplay -->

                                        <!-- K2 Plugins: K2BeforeDisplay -->


                                        <div class="moduleItemTitle">
                                            <a  href="#">LIMA</a>
                                        </div>



                                        <!-- Plugins: AfterDisplayTitle -->

                                        <!-- K2 Plugins: K2AfterDisplayTitle -->

                                        <!-- Plugins: BeforeDisplayContent -->

                                        <!-- K2 Plugins: K2BeforeDisplayContent -->


                                        <div class="moduleItemExtraFields">
                                            <div class="moduleItemExtraFieldsValue1">S/.250</div>

                                            <div class="moduleItemExtraFieldsValue2">$550</div>

                                            <div class="moduleItemExtraFieldsValue4">3D/2N</div>


                                            <div class="moduleItemReadMore">
                                                <a  href="#">
                                                Ver mas     </a>
                                            </div>

                                        </div>


                                        <div class="clr"></div>


                                        <!-- Plugins: AfterDisplayContent -->

                                        <!-- K2 Plugins: K2AfterDisplayContent -->

                                        <!-- Plugins: AfterDisplay -->

                                        <!-- K2 Plugins: K2AfterDisplay -->

                                        <div class="clr"></div>

                                    </li>
                                    <li class="clearList"></li>
                                </ul>



                            </div>

                        </div>


                    </div>

                </div>

            </div>


            <div class="recursos">
                <div class="custom">

                    <div class="banner wow fadeInLeft animated">
                        <div class="bannergroup_banners">

                            <div class="banneritem">
                                <img
                                src="web/images/banners/banner.jpg"
                                alt="Banner 1"
                                />
                                <div class="clr"></div>

                            </div>


                        </div>


                    </div>

                    <div class="newsletter wow fadeInRight animated">
                        <div class="titulo">
                            <div class="imagen"><img src="web/templates/kreatico/images/news-icon.png" alt="Newsletter"/></div>

                            <h2>RECIBE LAS MEJORES OFERTAS</h2>
                        </div>

                        <div class="form"><div class="moduletable_newsletter">
                            <iframe  id="blockrandom"
                            name=""
                            src="http://www.avcreativos.com/form/news.php"
                            width="100%"
                            height="100"
                            scrolling="no"
                            frameborder="0"
                            class="wrapper_newsletter" >
                        Sin marcos</iframe>
                    </div>

                </div>

            </div>

        </div>

    </div>


    @endsection