/*--------------------- LightBox ---------------------*/


var currentScroll;

window.initLightBox = function(){

    //eventos de cierre de ventana
    var closeEventsClick = function(){
        $('.mfp-bg').addClass('fadeOut');
        $('.mfp-content').removeClass('zoomIn').addClass('zoomOut');
        $('#general').removeClass('locked');
        $('.mfp-bg').removeClass('limitHeight');
        $(window).scrollTop(currentScroll);
        $.magnificPopup.close();
    };

    $('.ajaxpopup').on('click', function(e){
        e.preventDefault();
    });

    // BOF - HTML LightBoxes

        $(document).on('click','.ajaxpopup', function(){
            $.magnificPopup.open({
                items: {
                    src: $(this).attr('href'),
                    type:'ajax',
                },
                tLoading: 'Cargando...',
                removalDelay: 350,
                callbacks: {
                    beforeOpen: function() {
                        //Calculamos la altura del scroll para que al cerrar el popup podamos poner l apágina a la misma altura a la que estaba
                        currentScroll = $(window).scrollTop();
                    },
                    parseAjax: function(){
                        //animación de apertura
                        $('.mfp-content').addClass('zoomIn');
                        $('#general').addClass('locked');
                        $('.mfp-bg').addClass('limitHeight');
                        
                        setTimeout(function(){
                            $('.mfp-wrap').addClass('forceTop');
                            if($('body').hasClass('touchDevice')){
                                $(window).scrollTop(0);
                            }
                        }, 800);
                    },
                    ajaxContentAdded: function() {
                        //Añadimos un botón ded cerrar personalizado y eliminamos el que trae por defecto para que nos permita añadir efectos personalizados
                        $('.mfp-content .mfp-close').removeClass('mfp-close').addClass('lightbox-close');
                        $(".lightbox-close").click(function(){
                            $('.mfp-container').addClass('fixed');
                            closeEventsClick();
                        });
                    },
                    beforeClose: function() {
                        //Animación cerrar
                        $('.mfp-bg').addClass('fadeOut');
                        $('#general').removeClass('locked');
                        $('.mfp-bg').removeClass('limitHeight');
                        $(window).scrollTop(currentScroll);
                        $('.mfp-content').removeClass('zoomIn');
                        $('.mfp-content').addClass('zoomOut');
                    },
                    afterClose: function() {
                        //Eliminamos cualquier rastro del popup una vez cerrado y volvemos a poner la ventana a la altura que estaba antes de abrirlo.
                        $('#general').removeClass('locked');
                        $('.mfp-container').removeClass('fixed');
                        $(window).scrollTop(currentScroll);
                    },
                    disableOn: function() {
                      if( !$('body').hasClass('phoneScreen') ) {
                        return false;
                      }
                      return true;
                    }
                },
            });
        });


    // EOF
};