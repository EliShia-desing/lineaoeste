/* == Universia - Dónde quieres estudiar - JS de navegación cabecera == */

/* jshint devel: true, unused: false */

var menuAnimation = function( layerToMove, time, varheight, varheight2, oncomplete){
    var layer = layerToMove;
    var menuHeight = varheight;
    var menuHeight2 = varheight2;
    
        $('.body-content').css({
            'transform' : 'translateY('+menuHeight2+'px)',
            'margin-bottom': -menuHeight,
            'transition' : 'all '+time+'ms ease-in-out 0ms',
        });
};

//Variables para detener las llamadas resize

var isPhone = false;
var isTablet = false;
var isDesktop = false;

var menuHeight;
var compareLayerHeight;
var searchLayerHeight;
var worldLayerHeight;

window.resetNavigation = function(){
        var featuredButtons;
        var whoNav;
        var menuHeight;
        
        // Clonación del contenido de una capa a otra

        if($('body').hasClass('phoneScreen')){
            whoNav = $('.header-top-right ul.whoNav').clone();

            if($('.header-nav ul').length <= 2){
                $('.header-top-right ul.whoNav').remove();
                $('.header-nav-inner').append(whoNav);
            }
        }
        if($('body').hasClass('tabletScreen') || $('body').hasClass('phoneScreen')){
            featuredButtons = $('.header-middle-featured').clone();

            if(!$('.header-bottom').has('.header-middle-featured').length){
                $('.header-middle .header-middle-featured').remove();
                $('.header-bottom').append(featuredButtons);
            }
        }
        if($('body').hasClass('desktopScreen')){
            featuredButtons = $('.header-middle-featured').clone();

            if(!$('.header-middle').has('.header-middle-featured').length){
                $('.header-bottom .header-middle-featured').remove();
                $('.header-middle-inner').prepend(featuredButtons);
            }
        }
        if($('body').hasClass('tabletScreen') || $('body').hasClass('desktopScreen')){
            whoNav = $('.header-nav-inner ul.whoNav').clone();

            if($('.header-top-right li:first-child ul').length <= 0){
                $('.header-nav-inner ul.whoNav').remove();
                $('.header-top-right li:first-child').prepend(whoNav);
            }
        }

        // Corrección alturas del menú al hacer resize
        var menu = $('.header-nav');
        var compareLayer = $('.header-dropdown-compare');
        var searchLayer = $('.header-dropdown-search');
        var worldLayer = $('.header-world-layer');

        setTimeout(function(){
            if($('body').hasClass('phoneScreen')){
                if(!isPhone){
                    compareLayer.show();
                    searchLayer.show();
                    $('.header').css({
                        'transform' : 'translateY(0px)',
                        'transition' : 'none',
                    });
                    $('.body-content').css({
                        'transform' : 'translateY(0px)',
                        'margin-bottom': 0,
                        'transition' : 'none',
                    });
                    $('.social-icon-button').removeClass('active').addClass('ajaxpopup');
                    $('.profiles-button').removeClass('active');
                    $('.header-world-button').removeClass('active').addClass('ajaxpopup');
                    $('.header-compare-button').removeClass('active');
                    $('.header-search-button').removeClass('active');
                    $('.menu-button').removeClass('active');

                    menuHeight = $('.header-nav').height();
                    compareLayerHeight = $('.header-dropdown-compare').height();
                    searchLayerHeight = $('.header-dropdown-search').height();
                    worldLayerHeight = $('.header-world-layer').height();
                    isPhone = true;
                    isTablet = false;
                    isDesktop = false;
                }
            }
            if($('body').hasClass('tabletScreen')){
                if(!isTablet){
                    compareLayer.show();
                    searchLayer.show();
                    $('.header').css({
                        'transform' : 'translateY(0px)',
                        'transition' : 'none',
                    });
                    $('.body-content').css({
                        'transform' : 'translateY(0px)',
                        'margin-bottom': 0,
                        'transition' : 'none',
                    });
                    $('.header-top').css({'margin-top':0});
                    $('.profiles-button').removeClass('active');
                    $('.social-icon-button').removeClass('active').removeClass('ajaxpopup');
                    $('.header-world-button').removeClass('active').removeClass('ajaxpopup');
                    $('.header-compare-button').removeClass('active');
                    $('.header-search-button').removeClass('active');
                    $('.menu-button').removeClass('active');

                    menuHeight = $('.header-nav').height();
                    compareLayerHeight = $('.header-dropdown-compare').height();
                    searchLayerHeight = $('.header-dropdown-search').height();
                    worldLayerHeight = $('.header-world-layer').height();
                    isTablet = true;
                    isPhone = false;
                    isDesktop = false;
                }
            }
            if($('body').hasClass('desktopScreen')){
                if(!isDesktop){
                    menuHeight = 0;
                    compareLayer.hide();
                    searchLayer.hide();
                    $('.header').css({
                        'transform' : '',
                        'transition' : 'none',
                    });
                    $('.body-content').css({
                        'transform' : '',
                        'margin-bottom': 0,
                        'transition' : 'none',
                    });
                    $('.social-icon-button').removeClass('active');
                    $('.profiles-button').removeClass('active');
                    $('.header-world-button').removeClass('active');
                    $('.header-compare-button').removeClass('active');
                    $('.header-search-button').removeClass('active');
                    $('.menu-button').removeClass('active');

                    menuHeight = $('.header-nav').height();
                    compareLayerHeight = $('.header-dropdown-compare').height();
                    searchLayerHeight = $('.header-dropdown-search').height();
                    worldLayerHeight = $('.header-world-layer').height();
                    isDesktop = true;
                    isPhone = false;
                    isTablet = false;
                    $('.whoNav').css({
                        'opacity': 1,
                    });
                }
            }
        }, 180);

        if(!$('body').hasClass('desktopScreen')){
            if(searchLayer.height() !== searchLayerHeight){
                if($('.header-search-button').hasClass('active')){
                    $('.body-content').css({
                        'transform' : 'translateY('+searchLayer.height()+'px)',
                        'margin-bottom': -searchLayer.height(),
                        'transition' : 'all 0ms ease-in-out',
                    }, 0);
                }
                searchLayerHeight = searchLayer.height();
            }
            if(compareLayer.height() !== compareLayerHeight){
                if($('.header-compare-button').hasClass('active')){
                    $('.body-content').css({
                        'transform' : 'translateY('+compareLayer.height()+'px)',
                        'margin-bottom': -compareLayer.height(),
                        'transition' : 'all 0ms ease-in-out',
                    }, 0);
                }
                compareLayerHeight = compareLayer.height();
            }
        }else{
            if(!isDesktop){
                $('.body-content').removeAttr("style");
                compareLayer.removeAttr("style");
                searchLayer.removeAttr("style");
                worldLayer.removeAttr("style");
            }
        }

    };

    window.startNavigation = function(){
        var menu = $('.header-nav');
        var compareLayer = $('.header-dropdown-compare');
        var searchLayer = $('.header-dropdown-search');
        var touchActive = true;

        //Despliegue menu
        $(document).on("click", '.menu-button', function(e){
            e.preventDefault();

            if(!$('body').hasClass('desktopScreen')){
                var el = $(this);
                if(touchActive){

                    var touchFunction = function (){
                        touchActive = false;
                        setTimeout(function(){touchActive = true;}, 700);
                        if(el.hasClass('active')){

                            el.removeClass('active');
                            
                            menuAnimation(menu, 700, 0, 0);

                        }else{

                            el.addClass('active');
                            
                            menuAnimation(menu, 700, -menu.height(), menu.height());

                        }
                    };

                    if($('.header-compare-button').hasClass('active') || $('.header-search-button').hasClass('active')){
                        if($('.header-compare-button').hasClass('active')){
                            $('.header-compare-button').trigger('click');
                        }
                        if($('.header-search-button').hasClass('active')){
                            $('.header-search-button').trigger('click');
                        }
                        setTimeout(function(){
                            compareLayer.css('z-index', '0');
                            menu.css('z-index', '1');
                            searchLayer.css('z-index', '0');
                            touchFunction();
                        }, 700);
                    }else{
                        if($('.profiles-button').hasClass('active')){
                            $('.profiles-button').trigger('click');
                        }
                        if($('.social-icon-button').hasClass('active')){
                            $('.social-icon-button').trigger('click');
                        }
                        if($('.header-world-button').hasClass('active')){
                            $('.header-world-button').trigger('click');
                        }
                        compareLayer.css('z-index', '0');
                        menu.css('z-index', '1');
                        searchLayer.css('z-index', '0');
                        touchFunction();
                    }
                }
            }
        });

        //Despliegue comparador
        $(document).on('click', '.header-compare-button', function(e){
            e.preventDefault();
            if(!$(this).closest('li').hasClass('current-menu-item')){
                if(!$('body').hasClass('desktopScreen')){
                    var el = $(this);
                    if(touchActive){
                        var touchFunction2 = function (){
                            touchActive = false;
                            setTimeout(function(){touchActive = true;}, 700);
                            if(el.hasClass('active')){

                                el.removeClass('active');
                                
                                menuAnimation(compareLayer, 700, 0, 0);

                            }else{

                                el.addClass('active');
                                
                                menuAnimation(compareLayer, 700, -compareLayer.height(), compareLayer.height());


                            }
                        };

                        if($('.menu-button').hasClass('active') || $('.header-search-button').hasClass('active')){
                            if($('.menu-button').hasClass('active')){
                                $('.menu-button').trigger('click');
                            }
                            if($('.header-search-button').hasClass('active')){
                                $('.header-search-button').trigger('click');
                            }
                            setTimeout(function(){
                                compareLayer.css('z-index', '1');
                                menu.css('z-index', '0');
                                searchLayer.css('z-index', '0');
                                touchFunction2();
                            }, 700);
                        }else{
                            if($('.profiles-button').hasClass('active')){
                                $('.profiles-button').trigger('click');
                            }
                            if($('.social-icon-button').hasClass('active')){
                                $('.social-icon-button').trigger('click');
                            }
                            if($('.header-world-button').hasClass('active')){
                                $('.header-world-button').trigger('click');
                            }
                            compareLayer.css('z-index', '1');
                            menu.css('z-index', '0');
                            searchLayer.css('z-index', '0');
                            touchFunction2();
                        }
                    }
                }else{
                    if($('.header-compare-button').hasClass('active')){
                        $('.header-compare-button').removeClass('active');
                        $('.header-dropdown-compare').slideUp();
                    }else{
                        $('.header-compare-button').addClass('active');
                        $('.header-dropdown-compare').slideDown();
                        $('.header-dropdown-search').slideUp();
                        $('.header-search-button').removeClass('active');
                        if($('.social-icon-button').hasClass('active')){
                            $('.social-icon-button').trigger('click');
                        }
                        if($('.header-world-button').hasClass('active')){
                            $('.header-world-button').trigger('click');
                        }
                    }
                }
            }
        });

        //Despliegue buscador
        $(document).on('click', '.header-search-button', function(e){
            e.preventDefault();

            if(!$(this).closest('li').hasClass('current-menu-item')){
                if(!$('body').hasClass('desktopScreen')){
                    var el = $(this);
                    if(touchActive){
                        var touchFunction3 = function (){
                            touchActive = false;
                            setTimeout(function(){touchActive = true;}, 700);
                            if(el.hasClass('active')){

                                el.removeClass('active');
                                
                                menuAnimation(searchLayer, 700, 0, 0);
                            }else{

                                el.addClass('active');
                                
                                menuAnimation(searchLayer, 700, -searchLayer.height(), searchLayer.height());
                            }
                        };
                        if($('.menu-button').hasClass('active') || $('.header-compare-button').hasClass('active')){
                            if($('.menu-button').hasClass('active')){
                                $('.menu-button').trigger('click');
                            }
                            if($('.header-compare-button').hasClass('active')){
                                $('.header-compare-button').trigger('click');
                            }
                            setTimeout(function(){
                                compareLayer.css('z-index', '0');
                                menu.css('z-index', '0');
                                searchLayer.css('z-index', '1');
                                touchFunction3();
                            }, 700);
                        }else{
                            if($('.profiles-button').hasClass('active')){
                                $('.profiles-button').trigger('click');
                            }
                            if($('.social-icon-button').hasClass('active')){
                                $('.social-icon-button').trigger('click');
                            }
                            if($('.header-world-button').hasClass('active')){
                                $('.header-world-button').trigger('click');
                            }
                            compareLayer.css('z-index', '0');
                            menu.css('z-index', '0');
                            searchLayer.css('z-index', '1');
                            touchFunction3();
                        }
                    }
                }else{
                    if($('.header-search-button').hasClass('active')){
                        $('.header-search-button').removeClass('active');
                        $('.header-dropdown-search').slideUp();
                    }else{
                        $('.header-search-button').addClass('active');
                        $('.header-dropdown-search').slideDown();
                        $('.header-dropdown-compare').slideUp();
                        $('.header-compare-button').removeClass('active');
                        if($('.social-icon-button').hasClass('active')){
                            $('.social-icon-button').trigger('click');
                        }
                        if($('.header-world-button').hasClass('active')){
                            $('.header-world-button').trigger('click');
                        }
                    }
                }
            }
        });

        //Despliegue capa redes sociales

        $('.social-icon-button').click(function(e) {
            e.preventDefault();

            var el = $(this);

            var socialLayerHeight = $('.header-social-layer').outerHeight();
            
            if(!$('body').hasClass('desktopScreen')){
                if(!$('body').hasClass('phoneScreen')){
                    if(!el.hasClass('active')){
                        if($('.header-search-button').hasClass('active')){
                            $('.header-search-button').trigger('click');
                        }
                        if($('.header-compare-button').hasClass('active')){
                            $('.header-compare-button').trigger('click');
                        }
                        if($('.menu-button').hasClass('active')){
                            $('.menu-button').trigger('click');
                        }
                        if($('.profiles-button').hasClass('active')){
                            $('.profiles-button').trigger('click');
                        }
                        if($('.header-world-button').hasClass('active')){
                            $('.header-world-button').trigger('click');
                        }
                        $('.whoNav').css({
                            'z-index':'2',
                        }).animate({
                            'opacity': 0,
                        });
                        $('.header-social-layer').css({
                            'z-index':'3',
                        }).animate({
                            'opacity': 1,
                        });
                        $('.header-world-layer').css({
                            'z-index':'2',
                        }).animate({
                            'opacity': 0,
                        });
                        $('.header').css({
                            'transform' : 'translateY('+socialLayerHeight+'px)',
                            'transition' : 'all 700ms ease-in-out',
                        });
                        $('.body-content').css({
                            'transform' : 'translateY('+socialLayerHeight+'px)',
                            'margin-bottom': -socialLayerHeight,
                            'transition' : 'all 700ms ease-in-out',
                        });
                        el.addClass('active');

                    }else{
                        $('.header').css({
                            'transform' : 'translateY(0px)',
                            'transition' : 'all 700ms ease-in-out',
                        });

                        $('.body-content').css({
                            'transform' : 'translateY(0px)',
                            'margin-bottom': 0,
                            'transition' : 'all 700ms ease-in-out',
                        });
                        el.removeClass('active');
                    }
                }else{

                    //LANZAR LIGHTBOX REDES SOCIALES SMARTPHONE

                }
            }else{
                if(!el.hasClass('active')){
                    $('.header-top').animate({
                        'margin-top': socialLayerHeight,
                    }, 700);
                    $('.header-social-layer').css({
                        'z-index':'3',
                    }).animate({
                        'opacity': 1,
                    });
                    $('.header-world-layer').css({
                        'z-index':'2',
                    }).animate({
                        'opacity': 0,
                    });
                    $('.header-world-button').removeClass('active');
                    el.addClass('active');
                    if($('.header-search-button').hasClass('active')){
                        $('.header-search-button').trigger('click');
                    }
                    if($('.header-compare-button').hasClass('active')){
                        $('.header-compare-button').trigger('click');
                    }
                }else{
                    $('.header-top').animate({
                        'margin-top': 0,
                    }, 700);
                    el.removeClass('active');
                }
            }
        });

        //Despliegue perfiles

        $('.profiles-button').click(function(e) {
            e.preventDefault();

            var el = $(this);

            var whoNavHeight = $('.whoNav').outerHeight();
            
            if(!$('body').hasClass('desktopScreen')){
                if(!$('body').hasClass('phoneScreen')){
                    if(!el.hasClass('active')){
                        if($('.header-search-button').hasClass('active')){
                            $('.header-search-button').trigger('click');
                        }
                        if($('.header-compare-button').hasClass('active')){
                            $('.header-compare-button').trigger('click');
                        }
                        if($('.menu-button').hasClass('active')){
                            $('.menu-button').trigger('click');
                        }
                        if($('.social-icon-button').hasClass('active')){
                            $('.social-icon-button').trigger('click');
                        }
                        if($('.header-world-button').hasClass('active')){
                            $('.header-world-button').trigger('click');
                        }
                        $('.whoNav').css({
                            'z-index':'3',
                        }).animate({
                            'opacity': 1,
                        });
                        $('.header-social-layer').css({
                            'z-index':'2',
                        }).animate({
                            'opacity': 0,
                        });
                        $('.header-world-layer').css({
                            'z-index':'2',
                        }).animate({
                            'opacity': 0,
                        });
                        $('.header').css({
                            'transform' : 'translateY('+whoNavHeight+'px)',
                            'transition' : 'all 700ms ease-in-out',
                        });
                        $('.body-content').css({
                            'transform' : 'translateY('+whoNavHeight+'px)',
                            'margin-bottom': -whoNavHeight,
                            'transition' : 'all 700ms ease-in-out',
                        });
                        el.addClass('active');

                    }else{
                        $('.header').css({
                            'transform' : 'translateY(0px)',
                            'transition' : 'all 700ms ease-in-out',
                        });

                        $('.body-content').css({
                            'transform' : 'translateY(0px)',
                            'margin-bottom': 0,
                            'transition' : 'all 700ms ease-in-out',
                        });
                        el.removeClass('active');
                    }
                }
            }
        });

        //Despliegue capa "en el mundo"

        $('.header-world-button').click(function(e) {
            e.preventDefault();

            var el = $(this);

            var worldLayerHeight = $('.header-world-layer').outerHeight();
            
            if(!$('body').hasClass('desktopScreen')){
                if(!$('body').hasClass('phoneScreen')){
                    if(!el.hasClass('active')){
                        if($('.header-search-button').hasClass('active')){
                            $('.header-search-button').trigger('click');
                        }
                        if($('.header-compare-button').hasClass('active')){
                            $('.header-compare-button').trigger('click');
                        }
                        if($('.menu-button').hasClass('active')){
                            $('.menu-button').trigger('click');
                        }
                        if($('.profiles-button').hasClass('active')){
                            $('.profiles-button').trigger('click');
                        }
                        if($('.social-icon-button').hasClass('active')){
                            $('.social-icon-button').trigger('click');
                        }
                        $('.whoNav').css({
                            'z-index':'2',
                        }).animate({
                            'opacity': 0,
                        });
                        $('.header-social-layer').css({
                            'z-index':'2',
                        }).animate({
                            'opacity': 0,
                        });
                        $('.header-world-layer').css({
                            'z-index':'3',
                        }).animate({
                            'opacity': 1,
                        });
                        $('.header').css({
                            'transform' : 'translateY('+worldLayerHeight+'px)',
                            'transition' : 'all 700ms ease-in-out',
                        });
                        $('.body-content').css({
                            'transform' : 'translateY('+worldLayerHeight+'px)',
                            'margin-bottom': -worldLayerHeight,
                            'transition' : 'all 700ms ease-in-out',
                        });
                        el.addClass('active');

                    }else{
                        $('.header').css({
                            'transform' : 'translateY(0px)',
                            'transition' : 'all 700ms ease-in-out',
                        });

                        $('.body-content').css({
                            'transform' : 'translateY(0px)',
                            'margin-bottom': 0,
                            'transition' : 'all 700ms ease-in-out',
                        });
                        el.removeClass('active');
                    }
                }else{

                    //LANZAR LIGHTBOX EN EL MUNDO SMARTPHONE

                }
            }else{
                if(!el.hasClass('active')){
                    $('.header-top').animate({
                        'margin-top': worldLayerHeight,
                    }, 700);
                    $('.header-social-layer').css({
                        'z-index':'2',
                    }).animate({
                        'opacity': 0,
                    });
                    $('.header-world-layer').css({
                        'z-index':'3',
                    }).animate({
                        'opacity': 1,
                    });
                    $('.social-icon-button').removeClass('active');
                    el.addClass('active');
                    if($('.header-search-button').hasClass('active')){
                        $('.header-search-button').trigger('click');
                    }
                    if($('.header-compare-button').hasClass('active')){
                        $('.header-compare-button').trigger('click');
                    }
                }else{
                    $('.header-top').animate({
                        'margin-top': 0,
                    }, 700);
                    el.removeClass('active');
                }
            }
        });

    // Inyección cabecera actualidad
    if($('.headerToday').length > 0){
        var auxiliarLayer = $('<div class="headerToday_wrapper"></div>');
        $('.breadcrumb').addClass('breadcrumb_today');
        $('.page-title:first')
            .addClass('page-title_today')
            .append('<i class="icons-menu"><span></span></i>')
            .after(auxiliarLayer.append($('.headerToday').clone()))
            .next('.headerToday_wrapper').find('.headerToday-inner').addClass('headerToday-content');
        $('.headerToday_wrapper .headerToday').css({'display' : 'none'});
    }

    };