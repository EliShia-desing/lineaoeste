/* == Universia - Dónde quieres estudiar - JS de estilos e interacción == */

/* jshint devel: true, unused: false */

var Style = (function(){

    /*------------------ RWD Breakpoints ------------------*/

    var mobile_max_width = 640;
    var tablet_max_width = 900;


    /*------------------ Window width ------------------*/


    var ww = window.innerWidth;
    var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;


    /*------------------ Detección de tamaño de ventana ------------------*/


    var mediaQuery = function() {
        if(!$('html').is("#ie8")){
            $('body').removeClass('desktopScreen tabletScreen phoneScreen standardPhoneScreen');
        }

        ww = window.innerWidth;

        if( ww<=mobile_max_width ) {
            $('body').addClass('phoneScreen');
        } else if( ww>mobile_max_width && ww<=tablet_max_width ) {
            $('body').addClass('tabletScreen');
        } else if( ww>tablet_max_width ) {
            $('body').addClass('desktopScreen');
        }
    };


    /*------------------ Detección de dispositivos táctiles ------------------*/


    var touchDevice = function() {
        var is_touch_device = 'ontouchstart' in document.documentElement;
        if(is_touch_device){
            $('body').addClass('touchDevice');
        } else {
            $('body').addClass('noTouchDevice');
        }
    };


    /*------------------ Detección de navegadores no estandar ------------------*/


    var browserDetect = function() {
        if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
            $('body').addClass('firefoxBrowser');
        }
        if(navigator.userAgent.toLowerCase().indexOf('msie') > -1) {
            $('body').addClass('isIE');
        }
    };


    var forceRedraw = function(element){

        // alert(element);
        if (!element) { return; }

        var n = document.createTextNode(' ');
        var disp = element.style.display;  // don't worry about previous display style

        element.appendChild(n);
        element.style.display = 'none';

        setTimeout(function(){
            element.style.display = disp;
            n.parentNode.removeChild(n);
        },20); // you can play with this timeout to make it as short as possible
    }

    /*------------------ Transición entre páginas ------------------*/


    var fadePageOnLoad = function() {

        /*$('body').css({
         "transition":"opacity 500ms ease-out",
         "-ms-transition":"opacity 500ms ease-out",
         "-o-transition":"opacity 500ms ease-out",
         "-moz-transition":"opacity 500ms ease-out",
         }).removeClass('hide');*/
        $('body').removeClass('hide');
        var element;

        for(element in $._data($(document)[0], "events").click){
            $($._data($(document)[0], "events").click[element].selector).addClass('clickHandler');
        }

        $('a').each(function(){
            var el = $(this);

            if(el.attr('href') !== undefined){

                if($._data(el[0], "events") === undefined && !el.hasClass('clickHandler') && el.attr('href').length > 1 && !el.hasClass('ajaxpopup')){
                    el.on('click', function(e){
                        e.preventDefault();
                        var linkLocation = el.attr('href');
                        if(el.attr('target') === '_blank'){
                            window.open(linkLocation,'_blank');
                        }else{
                            //$('body').css('opacity', 0);
                            //setTimeout(function(){
                                window.location = linkLocation;
                            //}, 500);
                        }
                    });
                }

            }

        });

    };


    /*------------------ Desplegables ------------------*/


    var initDropDown = function() {

        // Desplegables
        $('.dropdown-layer_dynamic').each(function(){
            var el = $(this);

            setTimeout(function(){
                el.data('initialHeight', (el.height()));

                el.css({
                    'height' : 0,
                    'min-height': el.find('.more').position().top,
                });
            }, 100);

        });

        $('.viewall').on('click', function(e){
            var el = $(this);
            if(el.find('span').hasClass('icons-arrowdown-small') || el.find('span').hasClass('icons-arrowup-small')){
                e.preventDefault();
            }

            var elDynamic = el.closest('.module').find('.dropdown-layer_dynamic');

            if(elDynamic.find('.more').length > 0){

                if(!el.hasClass('active')){
                    if($('body').hasClass('desktopScreen')){
                        elDynamic.css({
                            'height' : elDynamic.data('initialHeight'),
                        });
                    }else{
                        elDynamic.css({
                            'height' : 'auto',
                        });
                    }
                    setTimeout(function(){
                        elDynamic.css({
                            'height': 'auto',
                        });
                        elDynamic.data('initialHeight', (elDynamic.height()));
                    }, 600);
                }else{
                    if($('body').hasClass('desktopScreen')){
                        elDynamic.css({
                            'height' : elDynamic.data('initialHeight'),
                        });
                    }else{
                        elDynamic.css({
                            'height' : 'auto',
                        });
                        $('body, html').animate({
                            scrollTop: elDynamic.closest('.module').offset().top -20
                        }, 0);
                    }
                    setTimeout(function(){
                        elDynamic.css({
                            'height' : 0,
                            'min-height': elDynamic.find('.more').position().top,
                        });
                    }, 10);
                }
            }

            if(!el.hasClass('active')){
                el.closest('.container-inner').find('.dropdown-layer').stop().slideDown();
                el.addClass('active');
            }else{
                el.closest('.container-inner').find('.dropdown-layer').stop().slideUp();
                el.removeClass('active');
            }
        });

    };

    var resetDropDown = function() {

        // Desplegables

        $('.dropdown-layer_dynamic').each(function(){
            var el = $(this);
            if(el.closest('.module').find('.viewall').hasClass('active')){
                el.data('initialHeight', (el.height()));
            }
        });


    };


    /*------------------ Inicializar Pie en el DOM Ready------------------*/

    var isPhone = false;
    var isTablet = false;
    var isDesktop = false;

    var startFooter = function(){

        // Desplegables secciones

        $('.footer-cross-links h3 a').on('click', function(e){
            e.preventDefault();
            var el = $(this);

            if($('body').hasClass('phoneScreen')){
                if(!el.hasClass('active')){
                    el.closest('li').find('ul').slideDown();
                    el.addClass('active');
                }else{
                    el.closest('li').find('ul').slideUp();
                    el.removeClass('active');
                }
            }
        });

        // Select "En el mundo"

        $(document).on('change', '.select01 select', function(){

            var el = $(this);

            if(el.val() !== "0"){
                el
                    .parent()
                    .next().slideDown().addClass('open')
                    .find('.select-button')
                    .attr("href",el.val())
                    .attr('target', '_blank')
                    .html('Ir a Universia '+ $("#countrySelect option:selected").text() +' <i class="icons-external-link"></i>');
            }else{
                el
                    .parent()
                    .next().slideUp().removeClass('open');
            }

        });

    };

    var resetFooter = function (){

        //Variables para detener las llamadas resize

        if($('body').hasClass('phoneScreen')){
            if(!isPhone){

                // Movemos de posición el bloque "en el mundo"
                var selectBlock = $('.footer-select-block').clone(true);
                $('.footer-select-block').remove();
                $('.footer-cross-links:first').find('.column:first').after(selectBlock);

            }
        }
        if($('body').hasClass('tabletScreen')){
            if(!isTablet){
                //limpiamos los estilos en línea de los desplegables pequeños
                $('.footer-cross-links li ul').removeAttr('style');

                // Reposicionamos de nuevo el bloque "en el mundo" a su sitio original
                var selectBlock2 = $('.footer-select-block').clone(true);
                $('.footer-select-block').remove();
                $('.footer-cross-links.last-col').prepend(selectBlock2);
            }
        }
        if($('body').hasClass('desktopScreen')){
            if(!isDesktop){
                //limpiamos los estilos en línea de los desplegables pequeños
                $('.footer-cross-links li ul').removeAttr('style');

                // Reposicionamos de nuevo el bloque "en el mundo" a su sitio original
                var selectBlock3 = $('.footer-select-block').clone(true);
                $('.footer-select-block').remove();
                $('.footer-cross-links.last-col').prepend(selectBlock3);
            }
        }

    };


    /*------------------ Capa de cookies------------------*/


    var cookiesClose = function(){  // Cerrar la capa de cookies

        $('.header-cookies-close').click(function(){

            var el = $(this).closest('.header-cookies');
            var elHeight = el.height();
            var cookiesAnimation = function(){
                $('#general').css({
                    'transition': 'all 400ms ease-in-out',
                    'transform': 'translateY(-'+elHeight+'px)',
                    'margin-bottom': parseInt($('.footer').css('margin-bottom'))-elHeight,
                });
            };
            var cookiesRemove = function(){
                $('#general').css({
                    'transition': 'none',
                    'transform': 'translateY(-'+0+'px)',
                    'margin-bottom': 0,
                });
                el.css({
                    'transition': 'none',
                    'height' : 0,
                    'padding' : 0,
                    'overflow' : 'hidden',
                    'margin-top': 0,
                });
            };

            var removeOnComplete;

            if(!$('body').hasClass('desktopScreen')){
                cookiesAnimation();
                removeOnComplete = setTimeout(cookiesRemove, 450);
            }else{
                el.animate({
                    'margin-top': -elHeight,
                }, 400);
                removeOnComplete = setTimeout(cookiesRemove, 450);
            }

        });

    };


    /*------------------ Ajuste tamaño de textos ------------------*/


    var initTextResize = function(){
        $('.cypher-sm').fitText(0.47);
        $('.cypher-md').fitText(0.317);
        $('.cypher-big').fitText(0.169);
        $('.type02 .cypher-sm').fitText(0.317);
        $('.type02 .cypher-md').fitText(0.317);
        $('.type02 .cypher-big').fitText(0.317);
    };


    /* ----------------- Generador de columnas ----------------- */


    var initGroupGen = function(){
        $('.knowledge-areas-content').wrecker({
            // options
            itemSelector : '.knowledge-area',
            maxColumns : 2,
            responsiveColumns : [
                // windowMaxWidth : columns
                // windowMaxWidth order and values should match those in your responsive CSS
                {1280 : 2},
                {640 : 1}
            ]
        });
        $('.disciplines-area-content').wrecker({
            // options
            itemSelector : '.discipline-area',
            maxColumns : 3,
            responsiveColumns : [
                // windowMaxWidth : columns
                // windowMaxWidth order and values should match those in your responsive CSS
                {1280 : 3},
                {900 : 2},
                {640 : 1}
            ]
        });
        $('.universityInfo-content').wrecker({
            // options
            itemSelector : '.universityInfo-content-area',
            maxColumns : 2,
            responsiveColumns : [
                // windowMaxWidth : columns
                // windowMaxWidth order and values should match those in your responsive CSS
                {1280 : 2},
                {900 : 2},
                {640 : 1}
            ]
        });
        $('.twoColumnsBasic-content').wrecker({
            // options
            itemSelector : '.twoColumnsBasic-content-area',
            maxColumns : 2,
            responsiveColumns : [
                // windowMaxWidth : columns
                // windowMaxWidth order and values should match those in your responsive CSS
                {1280 : 2},
                {900 : 2},
                {640 : 1}
            ]
        });
    };
    var initColumnGen = function(){
        $('.more-disciplines-area ul').listToColumns({
            container: 'more-disciplines-area',
            maxColumns : 3,
            responsiveColumns : [
                {1280 : 3},
                {900 : 2},
                {640 : 1}
            ],
            direction: 'horizontal'
        });
        $('.citiesList > div').listToColumns({
            container: 'citiesList',
            maxColumns : 3,
            responsiveColumns : [
                {1280 : 3},
                {900 : 3},
                {640 : 2},
                {480 : 1}
            ],
            direction: 'horizontal'
        });
        $('.citiesList2 > div').listToColumns({
            container: 'citiesList2',
            maxColumns : 2,
            responsiveColumns : [
                {1280 : 2},
                {900 : 2},
                {640 : 2},
                {480 : 1}
            ],
            direction: 'horizontal'
        });
        $('.fullModuleList-inner ul').listToColumns({
            container: 'fullModuleList-inner',
            maxColumns : 4,
            responsiveColumns : [
                {1280 : 4},
                {900 : 4},
                {640 : 2}
            ],
            direction: 'horizontal'
        });
        $('.simpleThreeColumnsList ul').listToColumns({
            container: 'simpleThreeColumnsList',
            maxColumns : 3,
            responsiveColumns : [
                {1280 : 3},
                {640 : 2}
            ],
            direction: 'horizontal'
        });
        $('.simpleTwoColumnsList ul').listToColumns({
            container: 'simpleTwoColumnsList',
            maxColumns : 2,
            responsiveColumns : [
                {1280 : 2},
                {640 : 1}
            ],
            direction: 'horizontal'
        });
        $('.headerToday-content ul').listToColumns({
            container: 'headerToday-content',
            maxColumns : 3,
            responsiveColumns : [
                {99999 : 1},
                {900 : 3},
                {640 : 1}
            ],
            direction: 'horizontal'
        });
    };


    /* ------------------ Slider Genéricos -------------------*/


    var initSliders = function(){
        window.initSlider($(".generic-slider"));
        window.initFullSlider($(".BasicImageSlider"));
    };


    /* ----------------- Eventos de los módulos ----------------- */


    var eventsModules = function(){
        $('.ranks-inner .viewall.dropdown-button').on('click', function(){
            var el = $(this);

            if(!el.hasClass('active')){
                el.prev('.rank-container').find('li+li+li').slideDown();
            }else{
                el.prev('.rank-container').find('li+li+li').slideUp();
            }
        });
    };
    var resetEventsModules = function(){
        if($('body').hasClass('tabletScreen')){
            $('.rank-container').find('li+li+li').removeAttr('style');
        }
    };


    /* ------------------ Interacciones formularios ------------------ */

    if($('.contactForm').length > 0){
        var contactFormParent = $('.contactForm').closest('.fixcol');
        var contactFormObject = $('.fixcol .contactForm').detach();
    }

    var formEvents = function() {
        if(contactFormObject !== undefined){
            //Inyección del módulo del sidebar al contenido

            if(!$('body').hasClass('desktopScreen')){
                contactFormObject.insertAfter(contactFormParent.closest('.container').find('.module:first'));
            }else{
                contactFormObject.prependTo(contactFormParent);
            }

            //Ocultamos el sidebar el dispositivos si está vacío

            if($('.fixcol').children().not('.sidebarMenu').length <= 0){
                $('.fixcol').hide();
            }else{
                $('.fixcol').show();
            }


            //Módulo centinela

            var SidebarContactFormHeight = contactFormObject.height();
            var floatContactModule = $('<div class="module module_darkGrey basicBlock basicBlock_small content-search floatContactForm"><h3 class="title03">Contacta con la universidad</h3><a href="#" class="button01">Solicitar información</a></div>');

            if($('body').hasClass('desktopScreen')){
                if($('.floatContactForm').length < 1){
                    floatContactModule.insertAfter(contactFormObject);
                }

                floatContactModule.find('a').unbind('click').bind('click', function(e){
                    e.preventDefault();

                    $('html, body').animate({
                        scrollTop: contactFormObject.offset().top-25,
                    });
                });

                $(document).on('scroll', function(){
                    floatContactModule.css({
                        'top' : 25,
                    });

                    if($(window).scrollTop() > contactFormObject.offset().top + SidebarContactFormHeight){
                        floatContactModule.css({
                            'opacity' : 1,
                            'margin-top' : 0,
                        });
                    }else{
                        floatContactModule.css({
                            'opacity' : 0,
                            'margin-top' : -200,
                        });
                    }
                    if($(window).scrollTop() > $('.footer').offset().top-260){
                        floatContactModule.css({
                            'opacity' : 0,
                            'margin-top' : -200,
                        });
                    }
                });
            }else{
                $('.floatContactForm').remove();
            }

            //GOTO Form en tablet

            $('.contactFormSmall').unbind('click').bind('click', function(){
                $('body, html').animate({
                    scrollTop: $(".contactForm").offset().top - 10
                }, 600);
            });
            $('.contactFormSmall a').unbind('click').bind('click', function(e){
                e.preventDefault();
                $('body, html').animate({
                    scrollTop: $(".contactForm").offset().top - 10
                }, 600);
            });

            //Acción de desplegar el formulario en dispositivos

            var formHeight = 0;
            var floatContactButton = $('<a href="#" class="button01">Solicitar información</a>');

            if(!$('body').hasClass('desktopScreen')){
                if($('.contactForm').find('a.button01').length < 1){
                    floatContactButton.insertAfter($('.contactForm h3'));
                }

                floatContactButton.unbind('click').bind('click', function(e){
                    e.preventDefault();
                });

                if(!$('.contactForm').hasClass('open')){
                    $('.contactForm .form').css({
                        'height' : 0,
                        'opacity' : 0,
                        'margin-top' : -46,
                    });
                }

                $('.contactForm').unbind('click').bind('click', function(e){

                    var elem = $(this);

                    if($(e.target).closest('.form').length < 1){

                        if(!elem.hasClass('open')){
                            elem.find('.form')
                                .css({
                                    'visibility' : 'hidden',
                                    'height' : 'auto',
                                    'position' : 'absolute'
                                });

                            formHeight = elem.find('.form').height();

                            elem.find('.form')
                                .css({
                                    'visibility' : 'visible',
                                    'height' : '0',
                                    'position' : 'relative'
                                })
                                .stop()
                                .animate({
                                    'margin-top' : 0,
                                    'height' : formHeight,
                                    'opacity' : 1,
                                }, function(){
                                    elem.find('.form').css({
                                        'height' : 'auto',
                                    });
                                });

                            elem.addClass('open');
                        }else{
                            $('.form').stop().animate({
                                'opacity' : 0,
                                'margin-top' : -46,
                                'height' : 0
                            });

                            elem.removeClass('open');
                        }

                    }

                });
            }else{
                $('.contactForm .form').css({
                    'height' : 'auto',
                    'opacity' : 1,
                    'margin-top' : 0
                });
            }
        }
    };


    /* ------------------ Navegación secundaria ------------------- */

    function secondNavTrigger(){
        $('.page-title_today').unbind('click').bind('click', function(){
            var el = $(this);
            if(el.hasClass('active')){
                el.removeClass('active');
                $('.content .headerToday_wrapper .headerToday').slideUp('400');
            }else{
                el.addClass('active');
                $('.content .headerToday_wrapper .headerToday').slideDown('400');
            }
        });
    }

    var startSecondNav = function(){
        secondNavTrigger();

        if($('body').hasClass('desktopScreen')){
            $('.page-title_today').unbind('click');
        }
    };
    var resetSecondNav = function(){
        if($('body').hasClass('desktopScreen')){
            $('.page-title_today').unbind('click');
            $('.content .headerToday_wrapper .headerToday').css({
                'display' : 'none'
            });
        }else{
            secondNavTrigger();
            if($('.page-title_today').hasClass('active')){
                $('.content .headerToday_wrapper .headerToday').css({
                    'display' : 'block'
                });
            }else{
                $('.content .headerToday_wrapper .headerToday').css({
                    'display' : 'none'
                });
            }
        }
    };


    /* ----------------------- Buscador ------------------------ */


    var sidevar;
    var filters;
    var filterButtonPos;

    var startSearchEvents = function(){
        //Tooltips

        $('.tooltip').tooltip({
            content: function(){
                var elem = $(this);
                return $(this).html().toString();
            },
            position: {
                using: function(position, feedback) {
                    $(this).css({
                        'top' : feedback.target.top-38,
                        'left' : feedback.target.left+40,
                    });
                }
            },
        });

        //Dropdown

        $('.filterBlock-firstTrigger').on('click', function(){
            var elem = $(this);

            if($('body').hasClass('desktopScreen')){

                if(!elem.hasClass('open')){
                    elem.addClass('open');
                    elem.addClass('active');

                    elem.next().stop().slideDown();

                    if(elem.next().next().length > 0 && elem.next().next().hasClass('open')){
                        elem.next().next().slideDown();
                    }

                }else{
                    elem.removeClass('open');
                    elem.addClass('active');

                    elem.next().stop().slideUp();

                    if(elem.next().next().length > 0){
                        elem.next().next().slideUp();
                    }
                }

            }
        });

        //Slider

        /*	$('.sliderRangeUI').slider({
         range: true,
         min: 0,
         max: 15000,
         values: [ 3000, 12000 ],
         slide: function( event, ui ) {
         $( ".sliderRangeUI-minVal" ).text( "€ " + ui.values[ 0 ]);
         $( ".sliderRangeUI-maxVal" ).text( "€ " + ui.values[ 1 ]);
         }
         });
         $( ".sliderRangeUI-minVal" ).text( "€ " + $( ".sliderRangeUI" ).slider( "values", 0 ));
         $( ".sliderRangeUI-maxVal" ).text( "€ " + $( ".sliderRangeUI" ).slider( "values", 1 ));*/

        //Filtro
        var currentScroll;

        if($('.filterLauncher').length > 0){
            filterButtonPos = $('.filterLauncher').offset().top+1;
        }

        //Evento click en el botón filtros
        $('.filterLauncher').on('click', function(e){
            e.preventDefault();

            var elem = $(this);

            currentScroll = $(window).scrollTop();

            $('.filterBlock').css({
                'transition' : 'width 0.4s 0.1s, height 0.4s, min-height 0.4s, top 0.4s 0.1s, left 0.4s 0.1s, right 0.4s 0.1s, background-color 0.3s 0.2s',
                '-webkit-transition' : 'width 0.4s 0.1s, height 0.4s, min-height 0.4s, top 0.4s 0.1s, left 0.4s 0.1s, right 0.4s 0.1s, background-color 0.3s 0.2s',
                '-ms-transition' : 'width 0.4s 0.1s, height 0.4s, min-height 0.4s, top 0.4s 0.1s, left 0.4s 0.1s, right 0.4s 0.1s, background-color 0.3s 0.2s',
                'top' : filterButtonPos,
                'height' : $('.filterBlock').find('.form').height()+150,
                'min-height' : '100%'
            });


            if(!$('.filterBlock').hasClass('open')){
                setTimeout(function(){
                    $('.filterBlock').addClass('open');
                }, 10);
                setTimeout(function(){
                    $('#general').css({
                        'height' : '100%',
                        'overflow' : 'hidden'
                    });
                    $('body, html').animate({
                        scrollTop : 0
                    }, 0);
                    $('.filterBlock').css({
                        'height' : 'auto',
                    });
                }, 500);
            }

        });

        //Evento click boton cerrar y filtrar
        $('.filterBlock').find('.icons-filter, .filterBlock-apply').on('click', function(e){
            e.preventDefault();

            var elem = $(this);

            elem.closest('.filterBlock').removeClass('open');

            var attrStyle = $('.filterBlock').attr('style');
            if(typeof attrStyle !== typeof undefined && attrStyle !== false){
                $('.filterBlock').removeAttr('style');
            }else{
                $('.filterBlock').css({
                    'transition' : 'opacity 0.3s 0.5s, width 0.4s 0.1s, height 0.4s, min-height 0.4s, top 0.4s, left 0.4s 0.1s, right 0.4s 0.1s, background-color 0.4s 0.2s, z-index 0s 0.5s',
                    '-webkit-transition' : 'opacity 0.3s 0.5s, width 0.4s 0.1s, height 0.4s, min-height 0.4s, top 0.4s, left 0.4s 0.1s, right 0.4s 0.1s, background-color 0.4s 0.2s, z-index 0s 0.5s',
                    '-ms-transition' : 'opacity 0.3s 0.5s, width 0.4s 0.1s, height 0.4s, min-height 0.4s, top 0.4s, left 0.4s 0.1s, right 0.4s 0.1s, background-color 0.4s 0.2s, z-index 0s 0.5s',
                    'top' : filterButtonPos,
                    'height' : 79,
                    'min-height' : 79
                });
            }

            $('#general').removeAttr('style');

            $('body, html').animate({
                scrollTop : currentScroll
            }, 0);
        });
    };

    var resetColumnStructure = function (){

        $('.filterBlock-firstTrigger').removeClass('active');

        filters = $('.filterBlock').detach();
        sidevar = $('.fixcol_invert').detach();

        if($('.filterLauncher').length > 0){
            filterButtonPos = $('.filterLauncher').offset().top+1;
        }

        if(!$('body').hasClass('desktopScreen')){
            if($('.fixcol_invert').length <= 0){
                $('.floatcol_invert').after(sidevar);
            }
            if($('.filterBlock').length <= 0){
                if($('.filterLauncher').length > 0){
                    $('#general').after(filters.css('top', $('.filterLauncher').offset().top+1));
                }
            }
            $('.filterBlock-firstTrigger').removeClass('open');
            $('.filterBlock-item').find('> *').removeAttr('style');
        }else{

            if($('.fixcol_invert').length <= 0){
                $('.floatcol_invert').before(sidevar);
            }
            if($('.filterBlock').length <= 0){
                $('.fixcol_invert').prepend(filters);
                $('#general').removeAttr('style');
                $('.filterBlock').removeAttr('style');
                $('.filterBlock').removeClass('open');
            }
        }

    };

    /* ----------------------- Radio button manager ------------------------ */


    var radioManager = function(){

        var totalRadios = $('.fullContactForm label.optRegistered');

        totalRadios.each(function(){
            var target = $(this).data('open');

            if($(this).prev('input').is(":checked")){
                $(this).parent().siblings('#' + target).addClass('active').show();
            }
        });

        totalRadios.on("click", function(){
            var target = $(this).data('open');

            $('.fullContactForm label.optRegistered').parent().siblings('.container-forms-register').removeClass('active').hide();
            $(this).parent().siblings('#' + target).addClass('active').show();
        });
    };

    /* ----------------------- Added pseudoselectors classes (web map) ------------------------ */

    var mapWebClasses = function(){
        $('.webMap .item:first-child').addClass('first');
        $('.webMap .item:last-child').addClass('last');
    };

    /* ----------------------- Mapa web ------------------------ */

    var initAnimationWebMap = function (){
        $('.webMap .item .title02 a.has-sublevel').on("click", function(e){
            e.preventDefault();
            var targetDiv = $(this).parent().next('.sub-level');

            if(targetDiv.hasClass('open')){
                $('.webMap .item .title02 a.has-sublevel').removeClass('active');
                targetDiv.removeClass('open').slideUp();
            }else{
                $('.webMap .item .title02 a.has-sublevel').removeClass('active');
                $(this).addClass('active');
                $('.webMap .item .title02 a.has-sublevel').parent().next('.sub-level').removeClass('open').slideUp();
                targetDiv.addClass('open').slideDown('slow');
            }

            //$(this).addClass('active').parent().next('.sub-level').addClass('open').slideDown();
        });
    };

    /* ----------------------- Buscador ------------------------ */

    var maxCols;
    var totalCols = $('.comparator-carousel .row:first .cell').length;
    var currentItem = 0;
    var lastItem = 0;
    var removeTransition;
    var pagination = $('.comparator-pagination');
    var paginationPos = pagination.offset();
    var disableSwipe = false;
    var resetCarousel;

    var initComparator = function(){

        //Definimos el número de columnas y márgenes laterales para cada breakpoint

        if($('body').hasClass('desktopScreen')){

            maxCols = 3;

        }else if($('body').hasClass('tabletScreen')){

            maxCols = 2;

        }else if($('body').hasClass('phoneScreen')){

            maxCols = 1;

        }

        //Definimos el ancho que debe tener cada columna

        var maxColsWidth = $('.comparator-carousel').width()/maxCols;
        var deleting = $('.deleting');
        var deletingPos = deleting.position();

        $('.comparator-carousel .table .cell').css({
            'width' :	maxColsWidth,
        });
        $('.comparator-carousel .table + *').css({
            'width' :	maxColsWidth-28,
        });

        //Si no hay espacio para la columna adicional la eliminamos

        if($('.comparator-carousel .table').width()+5 >= $('.comparator-carousel').width()){
            $('.comparator-carousel .table + *').hide();
        }else{
            $('.comparator-carousel .table + *').show();
        }

        //Definimos el punto de anclaje de la tabla respecto al ítem actual

        if(disableSwipe === false){
            $('.comparator-carousel .table').css({
                'margin-left' : -((maxColsWidth) * currentItem)
            });
        }

        //Calculamos el número de páginas total

        var totalPages = 0;

        $('.comparator-carousel .table .row:first .cell').each(function(index){
            if(index === 0){
                totalPages = 0;
            }
            if(index % maxCols === 0){
                totalPages += 1;
            }

            //Si no hay elementos suficientes para hacer slide eliminamos la navegación

            if(index < maxCols){
                disableSwipe = true;
                $('.comparator-pagination').hide();
            }else{
                $('.comparator-pagination').show();
                disableSwipe = false;
            }

            //Reseteamos la posición del carrusel si no hay elementos suficientes para el slide.

            clearTimeout(resetCarousel);

            resetCarousel = setTimeout(function(){
                if(index < maxCols){
                    $('.comparator-carousel .table').css({
                        'margin-left' : 0
                    });
                    currentItem = 0;
                }
            },0);

        });

        //Comprobamos si los botones deben estar o no activos

        if($('body').hasClass('phoneScreen')){
            if(currentItem >= totalPages-1){
                $('.comparator-pagination-next').addClass('disabled');
            }else{
                $('.comparator-pagination-next').removeClass('disabled');
            }
        }else{
            if(currentItem >= totalPages){
                $('.comparator-pagination-next').addClass('disabled');
            }else{
                $('.comparator-pagination-next').removeClass('disabled');
            }
        }

        if(currentItem <= 0){
            $('.comparator-pagination-prev').addClass('disabled');
        }else{
            $('.comparator-pagination-prev').removeClass('disabled');
        }

        //Eventos para la paginación

        $('.comparator-pagination-next').unbind('click').bind('click', function(e){
            e.preventDefault();



            if($('body').hasClass('phoneScreen')){
                if(currentItem < totalPages-1){
                    currentItem += 1;
                }
                //Añadimos la clase desactivado cuando no se puede avanzar más
                if(currentItem >= totalPages-1){
                    $(this).addClass('disabled');
                }
            }else{
                if(lastItem < totalCols && currentItem < totalPages){
                    currentItem += 1;
                    lastItem = currentItem+maxCols;
                }
                //Añadimos la clase desactivado cuando no se puede avanzar más
                if(lastItem >= totalCols){
                    $(this).addClass('disabled');
                }
            }

            $('.comparator-pagination-prev').removeClass('disabled');

            if($('html').hasClass('ie8')){
                $('.comparator-carousel .table').animate({
                    'margin-left' : -((maxColsWidth) * currentItem)
                }, 600);
            }else{
                $('.comparator-carousel .table').css({
                    'transition' : 'margin-left 600ms ease-in-out',
                    '-webkit-transition' : 'margin-left 600ms ease-in-out',
                    '-ms-transition' : 'margin-left 600ms ease-in-out',
                    'margin-left' : -((maxColsWidth) * currentItem)
                });
            }

            //Eliminamos el transition para que no haga movimientos raros al hacer resize

            clearTimeout(removeTransition);

            removeTransition = setTimeout(function(){
                $('.comparator-carousel .table').css({
                    'transition' : 'none',
                    '-webkit-transition' : 'none',
                    '-ms-transition' : 'none',
                });
            }, 600);

        });
        $('.comparator-pagination-prev').unbind('click').bind('click', function(e){
            e.preventDefault();

            if(currentItem > 0){
                currentItem -= 1;
                lastItem = currentItem-maxCols;
            }

            //Añadimos la clase desactivado cuando no se puede retroceder más
            if(currentItem <= 0){
                $(this).addClass('disabled');
            }

            if($('body').hasClass('phoneScreen')){
                //Añadimos la clase desactivado cuando no se puede avanzar más
                if(currentItem >= totalPages-1){
                    $('.comparator-pagination-next').addClass('disabled');
                }else{
                    $('.comparator-pagination-next').removeClass('disabled');
                }
            }else{
                //Añadimos la clase desactivado cuando no se puede avanzar más
                if(currentItem >= totalPages){
                    $('.comparator-pagination-next').addClass('disabled');
                }else{
                    $('.comparator-pagination-next').removeClass('disabled');
                }
            }

            if($('html').hasClass('ie8')){
                $('.comparator-carousel .table').animate({
                    'margin-left' : -((maxColsWidth) * currentItem)
                }, 600);
            }else{
                $('.comparator-carousel .table').css({
                    'transition' : 'margin-left 600ms ease-in-out',
                    '-webkit-transition' : 'margin-left 600ms ease-in-out',
                    '-ms-transition' : 'margin-left 600ms ease-in-out',
                    'margin-left' : -((maxColsWidth) * currentItem)
                });
            }

            //Eliminamos el transition para que no haga movimientos raros al hacer resize

            clearTimeout(removeTransition);

            removeTransition = setTimeout(function(){
                $('.comparator-carousel .table').css({
                    'transition' : 'none',
                    '-webkit-transition' : 'none',
                    '-ms-transition' : 'none',
                });
            }, 600);

        });

        //Eventos Swipe

        if(disableSwipe === false){
            $(".comparator-carousel-wrapper").swipe("enable");
            $(".comparator-carousel-wrapper").swipe( {
                swipeLeft: function(event, direction, distance, duration, fingerCount) {

                    $(".comparator-pagination-next").trigger('click');

                },
                swipeRight: function(event, direction, distance, duration, fingerCount) {

                    $(".comparator-pagination-prev").trigger('click');

                },
            });
        }else{
            $(".comparator-carousel-wrapper").swipe("disable");
        }

        //Botón eliminar

        $('.comparator-remove').unbind('click').bind('click', function(e){
            e.preventDefault();

            var elem = $(this);
            var parentElem = elem.closest('.cell');
            var parentElemPos = parentElem.position();
            var parentRow = elem.closest('.row');
            var currentDeleting;

            $('.cell').removeClass('deleting');
            $('.comparator-carousel-deleteLayer').addClass('hidden');

            parentRow.find('.cell').each(function(i){
                var el = $(this);

                if(el.is(parentElem)){
                    currentDeleting = i;
                }


            });

            parentElem.find('.comparator-carousel-deleteLayer').removeClass('hidden');

            $('.row').each(function(){

                $(this).find('.cell').each(function(n){
                    var el = $(this);

                    if(n === currentDeleting){
                        el.addClass('deleting');
                    }
                });

            });

        });

        //Botón cancelar eliminar

        $('.cancel-delete').unbind('click').bind('click', function(e){
            e.preventDefault();

            var elem = $(this);
            var parentElem = elem.closest('.cell');

            $('.cell').removeClass('deleting');
            parentElem.find('.comparator-carousel-deleteLayer').addClass('hidden');

        });

        //Paginación flotante

        var isFixed = false;
        var margin = 0;
        var paginationClone;
        var isHide = false;


        $(window).unbind('scroll').bind('scroll', function(){

            if($('body').hasClass('phoneScreen')){
                margin = 10;
            }else{
                margin = 10;
            }
            if(pagination.length > 0){
                if($(window).scrollTop() >= paginationPos.top-margin){

                    if(isFixed === false){
                        paginationClone = pagination.detach();

                        $('.body-content').before(paginationClone.addClass('fixed').css({
                            'right' : $('.container-inner').offset().left+10
                        }));

                        isFixed = true;
                    }

                }else{

                    if(isFixed === true){
                        paginationClone = pagination.detach();

                        $('.comparator .submodule-title').after(paginationClone.removeClass('fixed')
                        );

                        isFixed = false;
                    }
                }
            }

            if($(window).scrollTop() >= $('.footer').offset().top-150){
                $('.comparator-pagination').removeClass('fixed');
                isHide = true;
            }else if($(window).scrollTop() < $('.footer').offset().top+margin && isHide === true){
                $('.comparator-pagination').addClass('fixed');
                isHide = false;
            }

        });

        if(pagination.length > 0 && pagination.hasClass('fixed')){
            pagination.css({
                'right' : $('.container-inner').offset().left+10
            });
        }

    };


    /*----------------- Eventos estudiar en el extranjero -----------------*/

    var sidebarMenu = $('.abroadMenu .has-submenu ul').detach();
    var dynamicPubli = $('.publi.dynamicPosition').detach();

    var initAbroad = function(){

    };

    var resetAbroad = function(){

        //Roposicionamos los elementos del sidebar
        if(!$('body').hasClass('desktopScreen')){
            sidebarMenu.appendTo('.abroadMenu li.has-submenu');
            dynamicPubli.insertAfter('.floatcol .module:first');
        }else{
            sidebarMenu.appendTo('.module.sidebarMenu');
            dynamicPubli.insertAfter('.module.sidebarMenu');
        }

        //Ocultamos el sidebar el dispositivos si está vacío

        if($('.sidebarMenu').length > 0){
            if($('.fixcol').children().not('.sidebarMenu').length <= 0){
                $('.fixcol').hide();
            }else{
                $('.fixcol').show();
            }
        }

        //Slide Up/Down menú principal en dispositivos

        $('.page-title_abroad').unbind('click').bind('click', function(){
            var el = $(this);
            if(el.hasClass('active')){
                el.removeClass('active');
                $('.content .abroadMenu_wrapper').stop().slideUp(400);
            }else{
                el.addClass('active');
                $('.content .abroadMenu_wrapper').slideDown(400);
            }
        });

        //Forzamos el menú pricipal para que se muestre siempre en escritorio

        if($('body').hasClass('desktopScreen')){
            $('.content .abroadMenu_wrapper').show();
        }else{
            if($('.page-title_abroad').hasClass('active')){
                $('.content .abroadMenu_wrapper').show();
            }else{
                $('.content .abroadMenu_wrapper').hide();
            }
        }

        //Slide Up/Down Submenu en dispositivos

        if(!$('body').hasClass('desktopScreen')){
            $('.has-submenu').unbind('click').bind('click', function(e){
                e.preventDefault();

                var elem = $(this);

                if(!$(this).hasClass('open')){
                    $(this).addClass('open');

                    $(this).find('ul').slideDown(400);
                }else{
                    $(this).removeClass('open');

                    $(this).find('ul').stop().slideUp(400);
                }

            });

        }else{
            $('.has-submenu').unbind('click');
        }

    };

    /*----------------- Navegación módulo tabs -----------------*/

    var initTabsModule = function(){
        $('[class^="groupModuleTabs"]').each(function(){
            var groupName = $(this).attr('class');

            $('.' + groupName + ' .moduleTabs .customTabs .cell').each(function(index){
            var tab = $(this);
            var tabContent = tab.find('span').text();


            tab.find('a').bind('click', function(e){
                e.preventDefault();

                var elem = $(this);

                $('.' + groupName + ' .moduleTabs .tabs-carousel .tab-content').each(function(index2){
                    var tabContent = $(this);

                    if(index === index2){
                        if(!tabContent.hasClass('active')){
                            $('.' + groupName + ' .moduleTabs .customTabs a').removeClass('active');
                            $('.' + groupName + ' .moduleTabs .tabs-carousel .tab-content').removeClass('active');

                            elem.addClass('active');
                            tabContent.addClass('active');
                        }
                    }
                });
            });
        });
        });
    };

    var resetTabsModule = function(){

        if($('body').hasClass('phoneScreen')){

            $('[class^="groupModuleTabs"]').each(function(){
                var groupName = $(this).attr('class');

                $('.' + groupName + ' .moduleTabs .tabs-carousel .tab-content').each(function(){
                    var elem = $(this);
                    elem.addClass('active');

                    if(!elem.prev('.tabTitle').hasClass('open')){
                        setTimeout(function(){
                            elem.hide();
                        }, 200);
                    }
                });
                $('.' + groupName + ' .moduleTabs .customTabs .cell').each(function(index){

                    var tab = $(this);
                    var tabContent = tab.find('span').text();

                    $('.' + groupName +' .moduleTabs .tabs-carousel .tabTitle').each(function(index2){
                        var tabTitle = $(this);

                        if(index === index2){
                            tabTitle.text(tabContent);
                        }
                    });
                });
                $('.' + groupName + ' .moduleTabs .tabTitle').unbind('click').bind('click', function(){
                    var elem = $(this);

                    $(".BasicImageSlider")
                        .find('.owl-item').css({
                            'width' : elem.closest('.moduleTabs').width(),
                        })
                        .end()
                        .find('.owl-stage').css({
                            'width' : elem.closest('.moduleTabs').width()*$(".BasicImageSlider")
                                .find('.owl-item').length,
                        });

                    if(!elem.hasClass('open')){
                        elem.addClass('open');

                        elem.next('.tab-content').find('.module').css({
                            'opacity' : 0
                        });

                        elem.next('.tab-content').stop().slideDown(400);

                        setTimeout(function(){
                            elem.next('.tab-content').find('.module').animate({
                                'opacity' : 1
                            });
                        }, 100);

                    }else{
                        elem.removeClass('open');

                        elem.next('.tab-content').slideUp(400);

                        elem.next('.tab-content').find('.module').animate({
                            'opacity' : 0
                        });
                    }
                });
            });
        }else{
            $('.moduleTabs .tabs-carousel .tab-content').removeAttr('style');
            $('.moduleTabs .tabs-carousel .tab-content .module').removeAttr('style');
        }
    };


    /*----------------- Navegación sidebar genérica -----------------*/


    var singleSidebarMenu = $('.singleMenu-inner > ul').detach();

    var initSingleMenu = function(){

        setTimeout(function(){
            $('.singleSidebarMenu ul li').each(function(){
                var elem = $(this);

                if(elem.hasClass('open')){
                    elem.find('ul').slideDown(400);
                }
            });
            $('.singleMenu ul li').each(function(){
                var elem = $(this);

                if(elem.hasClass('open')){
                    elem.removeClass('open');
                }
            });
        }, 50);

    };

    var resetSingleMenu = function(){

        //Roposicionamos los elementos del sidebar
        if(!$('body').hasClass('desktopScreen')){
            singleSidebarMenu.appendTo('.singleMenu-inner');
        }else{
            singleSidebarMenu.appendTo('.module.singleSidebarMenu');
        }

        //Ocultamos el sidebar el dispositivos si está vacío


        if(!$('body').hasClass('desktopScreen')){
            if($('.singleSidebarMenu').length > 0){
                if($('.fixcol').children().not('.singleSidebarMenu').length <= 0){
                    $('.fixcol').hide();
                }
            }
        }else{
            $('.fixcol').show();
        }

        //Slide Up/Down menú principal en dispositivos

        $('.page-title_menu').unbind('click').bind('click', function(){
            var el = $(this);
            if(el.hasClass('active')){
                el.removeClass('active');
                $('.singleMenu_wrapper .singleMenu').stop().slideUp(400);
            }else{
                el.addClass('active');
                $('.singleMenu_wrapper .singleMenu').slideDown(400);
            }
        });

        //Forzamos el menú pricipal para que se muestre siempre en escritorio

        if($('body').hasClass('desktopScreen')){
            $('.singleMenu_wrapper .singleMenu').show();
        }else{
            if($('.page-title_menu').hasClass('active')){
                $('.singleMenu_wrapper .singleMenu').show();
            }else{
                $('.singleMenu_wrapper .singleMenu').hide();
            }
        }

        //Slide Up/Down Submenu en dispositivos

        $('.has-submenu').unbind('click').bind('click', function(e){
            e.preventDefault();

            var elem = $(this);

            if(!$(this).hasClass('open')){
                $(this).addClass('open');

                $(this).find('ul').slideDown(400);
            }else{
                $(this).removeClass('open');

                $(this).find('ul').stop().slideUp(400);
            }

        });

    };


    /*----------------- Calendario jQuery -----------------*/


    var initCalendar = function(){
        //Días deshabilitados
        var string;

        $.datepicker.regional.es = {
            closeText: 'Cerrar',
            prevText: '',
            nextText: '',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['D','L','M','M','J','V','S'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: '',
            showOtherMonths: false
        };

        $.datepicker.regional['pt'] = {
            closeText: 'Fechar',
            prevText: '',
            nextText: '',
            currentText: 'Hoje',
            monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','S&aacute;bado'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b'],
            dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b'],
            weekHeader: 'Sem',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};

        var userLang = navigator.language || navigator.userLanguage;
        $.datepicker.setDefaults($.datepicker.regional.es);

        if(userLang!=null && userLang.split('-')[0]=='pt') {
            $.datepicker.setDefaults($.datepicker.regional.pt);
        }
        else
            $.datepicker.setDefaults($.datepicker.regional.es);


        //Abrir calendario
        if($('body').hasClass('noTouchDevice')){


            $( '.filterBlock-field .icons-calendar' ).on('click', function(e){
                e.preventDefault();

                $( 'input[type="date"]' ).each(function(i){
                    var el = $( this );

                    el.datepicker({
                        dateFormat: 'yy-mm-dd',
                        beforeShow: function(input, inst) {
                            if($('body').hasClass('desktopScreen')){
                                $('#ui-datepicker-div').removeClass('smallCalendar');
                                setTimeout(function () {
                                    inst.dpDiv.css({
                                        top: el.offset().top -28,
                                        marginLeft: (input.offsetWidth+60) + 'px'
                                    });
                                }, 0);
                            }else{
                                $('#ui-datepicker-div').addClass('smallCalendar');
                                inst.dpDiv.css({marginTop: 0, marginLeft: 0});
                            }
                        }
                    });
                });

                $(this).parent().find( 'input[type="date"]' ).trigger('focus');
            });
        }else{
            $( '.filterBlock-field .icons-calendar' ).on('click', function(e){
                e.preventDefault();
                $(this).parent().find( 'input[type="date"]' ).trigger('click');
                $(this).parent().find( 'input[type="date"]' ).trigger('focus');
            });
        }

        sidevar = $('.fixcol_invert').clone(true);
    };

    /* BUSCADOR */

    var eventsSearch = function(){

        $('#resetForm').click(function(){
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ deleteFilters: "true", section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        $('#contentTypeFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ addContentType: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });
        $('.contentTypeFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            if($( this ).prop( "checked" )){
                $.post( "/busqueda-ajax",{ addContentType: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }else{
                $.post( "/busqueda-ajax",{ delContentType: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }
        });

        $('#sectionFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ addSection: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });
        $('.sectionFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            if($( this ).prop( "checked" )){
                $.post( "/busqueda-ajax",{ addSection: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }else{
                $.post( "/busqueda-ajax",{ delSection: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }
        });

        $('#communityFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ addCommunity: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });
        $('.communityFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            if($( this ).prop( "checked" )){
                $.post( "/busqueda-ajax",{ addCommunity: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }else{
                $.post( "/busqueda-ajax",{ delCommunity: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }
        });

        $('#organismFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ addOrganism: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });
        $('.organismFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            if($( this ).prop( "checked" )){
                $.post( "/busqueda-ajax",{ addOrganism: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }else{
                $.post( "/busqueda-ajax",{ delOrganism: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }
        });

        $('#knowledgeAreaFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ addKnowledgeArea: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });
        $('.knowledgeAreaFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            if($( this ).prop( "checked" )){
                $.post( "/busqueda-ajax",{ addKnowledgeArea: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }else{
                $.post( "/busqueda-ajax",{ delKnowledgeArea: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }
        });

        $('#categoryFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ addCategory: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });
        $('.categoryFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            if($( this ).prop( "checked" )){
                $.post( "/busqueda-ajax",{ addCategory: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }else{
                $.post( "/busqueda-ajax",{ delCategory: name, section:$("#section").val()} ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            }
        });

        $('#publicationDateIniFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ addPublicationDateIni: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });
        $('#publicationDateFinFilter').change(function(){
            var name = $(this).val();
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ addPublicationDateFin: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });


        $('.contentTypeDel').click(function(){
            var name = $(this).attr('id');
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ delContentType: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        $('.sectionDel').click(function(){
            var name = $(this).attr('id');
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ delSection: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        $('.communityDel').click(function(){
            var name = $(this).attr('id');
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ delCommunity: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        $('.organismDel').click(function(){
            var name = $(this).attr('id');
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ delOrganism: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        $('.knowledgeAreaDel').click(function(){
            var name = $(this).attr('id');
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ delKnowledgeArea: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        $('.categoryDel').click(function(){
            var name = $(this).attr('id');
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ delCategory: name, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        $('.publicationDateIniDel').click(function(){
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ delPublicationDateIni: "true", section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });
        $('.publicationDateFinDel').click(function(){
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ delPublicationDateFin: "true", section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        $('.pageSearch').click(function(){
            var page = $(this).attr('pg');
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{ page: page, section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        $('#selectOrder').change(function(){
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{orderSearch:$(this).val(),section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        $('.filterBlock-apply').click(function(){
            if(!$('.filterBlock').hasClass('open')){searchEffects();}
            $.post( "/busqueda-ajax",{a:"a",section:$("#section").val()} ,function( data ) {
                if(!$('.filterBlock').hasClass('open')){
                    $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                }
            } );
        });

        fadePageOnLoad();
        window.initLightBox();
        initCalendar();
        //restartCompareButtons();


    };

    function searchEffects(){
        $(".loadingLayer").show(); $("#resultSearch").addClass("relativePos");
        var aTag = $("h1[id='anchorTitle']");
        $('html,body').animate({scrollTop: aTag.offset().top});
    }

    /* ------------------ Paginacion TAGS ---------------------- */

    var eventsTagPag = function(){
        $('.tagPageSearch').click(function(){
            var page = $(this).attr('pg');
            searchEffects();
            $.post( "/tagContentPagination",{ page: page, tag:$("#tag").val()} ,function( data ) {
                $("#contentTagPagination").html(data); eventsTagPag();
            } );
        });

        fadePageOnLoad();
        window.initLightBox();
        //restartCompareButtons();


    };

    /* ------------------ Paginacion SECTIONS ---------------------- */

    var eventsSectionPag = function(){
        $('.sectionPageSearch').click(function(){
            var page = $(this).attr('pg');
            searchEffects();
            $.post( "/sectionContentPagination",{ page: page, sectionName:$("#section").val(), noticiaDestacada1Id:$("#noticiaDestacada1Id").val(), noticiaDestacada2Id:$("#noticiaDestacada2Id").val()} ,function( data ) {
                $("#contentSectionPagination").html(data); eventsSectionPag();
            } );
        });

        fadePageOnLoad();
        window.initLightBox();
        //restartCompareButtons();


    };

    /* ------------------ Eventos principales ------------------ */

    var onReady = function(){
        mediaQuery();
        window.startNavigation();
        window.startSlider();
        touchDevice();
        startFooter();
        browserDetect();
        cookiesClose();
        initTextResize();
        initGroupGen();
        initColumnGen();
        initSliders();
        eventsModules();
        startSecondNav();
        radioManager();
        mapWebClasses();
        initAnimationWebMap();
        initAbroad();
        initTabsModule();
        initSingleMenu();
    };

    var onLoad = function(){
        startSearchEvents();
        initCalendar();
        fadePageOnLoad();
        initDropDown();
        //forceRedraw($('#general'));
        var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
        if(is_chrome) {
            $('#general').hide().show(0);
            $('body,html').hide().show(0);
        }

    };

    var onResize = function(){
        resetFooter();
        resetEventsModules();
        resetDropDown();
        resetSecondNav();
        resetTabsModule();
        formEvents();
    };

    var onResizeInstant = function(){
        mediaQuery();
        resetColumnStructure();
        initComparator();
        window.resetNavigation();
        resetAbroad();
        resetSingleMenu();
    };

    var init = function(){

        $(window).load(function() {
            onResize();
            onResizeInstant();
            onLoad();
            eventsSearch();
            $('#btnFormSearch').click(function(){
                if(!$('.filterBlock').hasClass('open')){searchEffects();}
                $.post( "/busqueda-ajax",$("#buscadorForm").serialize() ,function( data ) {
                    if(!$('.filterBlock').hasClass('open')){
                        $("#contentSearch").html(data); startSearchEvents(); eventsSearch();
                    }
                } );
            });
            /* TAG PAGINATION */
            $('.tagPageSearch').click(function(){
                var page = $(this).attr('pg');
                searchEffects();
                $.post( "/tagContentPagination",{ page: page, tag:$("#tag").val()} ,function( data ) {
                    $("#contentTagPagination").html(data); eventsTagPag();
                } );
            });
            /* SECTION PAGINATION */
            $('.sectionPageSearch').click(function(){
                var page = $(this).attr('pg');
                searchEffects();
                $.post( "/sectionContentPagination",{ page: page, sectionName:$("#section").val(), noticiaDestacada1Id:$("#noticiaDestacada1Id").val(), noticiaDestacada2Id:$("#noticiaDestacada2Id").val()} ,function( data ) {
                    $("#contentSectionPagination").html(data); eventsSectionPag();
                } );
            });

        });

        $(document).ready(function(){
            onReady();
            onResizeInstant();
            setTimeout(window.initLightBox,200);
            // Rellamada al evento resize para una correcta carga de los eventos
            setTimeout(onResize,180);
        });

        $(window).resize(function(){
            // Comprobamos que ha habido resize en x, para evitar lanzarlo cuando las barras del navegador desaparecen (Chrome mobile).
            var nww = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            if( nww !== width ) {
                onResizeInstant();
                clearTimeout(this.id);
                this.id = setTimeout(function(){
                    onResize();
                }, 50);
                width = nww;
                height = window.innerHeight;
            }
        });

    };

    return {
        init: init
    };

})($);

Style.init();