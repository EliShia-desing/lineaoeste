/* == Universia - Dónde quieres estudiar - JS para el slider destacado == */

/* jshint devel: true, unused: false */


window.startSlider = function() {

    var items;
    var item;
    var autoPlayInterval;
    var autoPlay;

    //Llamada al iniciarse
    $(".slider-carousel").on('initialized.owl.carousel', function(event){
        var el = $(this);
        var currentSlide;

        items = event.item.count;
        item = event.item.index;

        if(items <= 1){
            $('.module-slider').addClass('single-slider');
        }

        setTimeout(function(){

            $('.owl-item.active').attr('class', 'owl-item active');
            $('.owl-item').not('.active').attr('class', 'owl-item').css('left', '0');

            //Definimos el activo en la navegación
            $('.customPagination a').each(function(index){
                var el = $(this);

                if(index === item){
                    el.addClass('active');
                }else{
                    el.removeClass('active');
                }
            });

            //Comprobamos el tamaño de la imágen para adaptarla al contenedor
            if(el.find('img').width() < el.width()){
                el.addClass('full-width');
            }

        }, 50);


        //AutoPlay
        autoPlay = function () {
            if(items > 1 && !$('body').hasClass('phoneScreen')){
                autoPlayInterval = setInterval(function(){
                    $(".slider-carousel").trigger('to.owl.carousel',item+1);
                }, 7000);
            }
        };

        autoPlay();

        //Pausa autoplay al hacer rollover
        $('.module-slider').on({
            mouseover: function(){
                clearInterval(autoPlayInterval);
            },
            mouseout: function(){
                autoPlay();
            }
        });

        //Asignamos el enlace de cada botón a su slide correspondiente
        $('.customPagination a').each(function(index){
            var el = $(this);

            el.on('click', $(this), function(e){
                e.preventDefault();

                $(".slider-carousel").trigger('to.owl.carousel', index);
            });
        });
    });

    //Declaramos el slider
    if($('body').hasClass('desktopScreen')){
        $(".slider-carousel").owlCarousel({
            animateOut: 'fadeOut',
            animateIn: 'fadeInLeft',
            items: 1,
            itemElement: 'li',
            stageElement: 'ul',
            mouseDrag: false,
            touchDrag: true,
            loop: false,
            responsiveRefreshRate: 0,
        });
    }else{
        $(".slider-carousel").owlCarousel({
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            items: 1,
            itemElement: 'li',
            stageElement: 'ul',
            mouseDrag: false,
            touchDrag: false,
            loop: false,
            dots: true,
        });
        if(items > 1){
            $(".slider-carousel").swipe( {
                swipeLeft: function(event, direction, distance, duration, fingerCount) {

                    if(item < items-1){
                        $(".slider-carousel").trigger('next.owl.carousel');
                    }else{
                        $(".slider-carousel").trigger('to.owl.carousel',[0]);
                    }
                    
                },
                swipeRight: function(event, direction, distance, duration, fingerCount) {

                    var lastItem = items-1;

                    if(item > 0){
                        $(".slider-carousel").trigger('prev.owl.carousel');
                    }else{
                        $(".slider-carousel").trigger('to.owl.carousel',lastItem);
                    }
                },
            });
        }
    }

    //Llamada al detectar cambios en el slider
    $(".slider-carousel").on('changed.owl.carousel', function(event){
        var el = $(this);

        items = event.item.count;
        item = event.item.index;

        if(items > 1){
            $(".slider-carousel").swipe("disable");
        }

        $('.customPagination a').each(function(index){
            var el = $(this);

            //Eliminamos el evento click mientras se ejecuta la animación
            el.unbind('click').on('click', function(e){
                e.preventDefault();
            });

            if(index === item){
                el.addClass('active');
            }else{
                el.removeClass('active');
            }
        });

    });

    //Llamada al redimensionar la pantalla
    $(".slider-carousel").on('resized.owl.carousel', function(){
        var el = $(this);

        $('.owl-item.active').attr('class', 'owl-item active');
        $('.owl-item').not('.active').attr('class', 'owl-item');

        if(el.find('img').width() < el.width()){
            el.addClass('full-width');
        }
        autoPlay();
    });
    $(".slider-carousel").on('resize.owl.carousel', function(){
        var el = $(this);

        if(el.find('img').width() < el.width()){
            el.addClass('full-width');
        }else{
            el.removeClass('full-width');
        }
        clearInterval(autoPlayInterval);
    });

    //Llamada al terminar la animación
    $(".slider-carousel").on('translated.owl.carousel', function(){
        var el = $(this);
        var currentSlide;

        $('.owl-item').not('.active').attr('class', 'owl-item').css('left', '');
        
        if(items > 1){
            $(".slider-carousel").swipe("enable");
        }

        $('.customPagination a').each(function(index){
            var el = $(this);

            if(index !== item){
                el.unbind('click').on('click', $(this), function(e){
                    e.preventDefault();

                    $(".slider-carousel").trigger('to.owl.carousel', index);
                });
            }
        });
    });

    //Llamada al arrastrar
    $(".slider-carousel").on('drag.owl.carousel', function(){
        $('.owl-stage').addClass('owl-drag');
    });

    //Llamada al soltar
    $(".slider-carousel").on('dragged.owl.carousel', function(){
        setTimeout(function(){
            $('.owl-stage').removeClass('owl-drag');
        }, 200);
    });
};