/* ----------------------------------------------

Para inicializar un slider utilizar:

window.initSlider( $(identificador_slider) );

---------------------------------------------- */

var lastVisibleItem;

window.initFullSlider = function(obj) {
	obj.owlCarousel({
		nav: true,
		navText: ['', '', '', ''],
		dots: true,
		dotsEach: false,
		loop: true,
		mouseDrag: true,
		itemElement: 'li',
		stageElement: 'ul',
		items: 1,
		autoplay:true,
		autoplayTimeout:3000,
		autoplaySpeed:3000,
		autoplayHoverPause:true
	});
};

window.initSlider = function(obj) {

	//Llamada al iniciarse
	obj.on('initialized.owl.carousel', function(event){
		var el = $(this);
		var size = event.page.size;
		var currentPage = 1;
		var itemCount = 0;

		//Guardamos a que página pertenece cada uno de los elementos en sí mismos.
		el.find('.owl-item').each(function(){
			var el = $(this);
			itemCount += 1;

			el.data('page', currentPage);

			if(itemCount === size){
				currentPage += 1;
				itemCount = 0;
			}

			//Comprobamos a qué página corresponde el último elemento visible
			if(el.hasClass('active')){
                //callGA(el.children().first().attr('id'),el.children().first().attr('section'));
				lastVisibleItem = el.data('page');
			}
		});

		el.find('.owl-controls .owl-dot').each(function(index){
			var elChild = $(this);

			elChild.bind('click', function(){
				elChild.addClass('active');
				el.find('.owl-controls .owl-dot').not(elChild).removeClass('active');
			});
			if(index+1 === lastVisibleItem){
				elChild.addClass('active');
			}else{
				elChild.removeClass('active');
			}
		});
	});
	obj.owlCarousel({
		dots: true,
		dotsEach: false,
		loop: false,
		mouseDrag: true,
		margin: 28,
		itemElement: 'div',
		stageElement: 'div',
		responsive:{
			0:{
				items:1
			},
			640:{
				items:2
			},
			900:{
				items:3
			}
		}
	});
	//Llamada al detectar cambios en el slider
	obj.on('resized.owl.carousel', function(event){
		var el = $(this);
		var size = event.page.size;
		var currentPage = 1;
		var itemCount = 0;

		//Guardamos a que página pertenece cada uno de los elementos en sí mismos.
		el.find('.owl-item').each(function(){
			var el = $(this);
			itemCount += 1;

			el.data('page', currentPage);

			if(itemCount === size){
				currentPage += 1;
				itemCount = 0;
			}

			//Comprobamos a qué página corresponde el último elemento visible
			if(el.hasClass('active')){
				lastVisibleItem = el.data('page');
			}
		});

		//Volvemos a plicar el evento click a los nuevos bullets que hayan podido aparecer
		el.find('.owl-controls .owl-dot').each(function(index){
			var elChild = $(this);
			elChild.unbind('click').bind('click', function(){
				elChild.addClass('active');
				el.find('.owl-controls .owl-dot').not(elChild).removeClass('active');
			});
			if(index+1 === lastVisibleItem){
				elChild.addClass('active');
			}else{
				elChild.removeClass('active');
			}
		});
	});
	//Llamada al terminar la animación
	obj.on('translated.owl.carousel', function(){
		var el = $(this);

		el.find('.owl-item').each(function(){
			var el = $(this);

			//Comprobamos a qué página corresponde el último elemento visible
			if(el.hasClass('active')){
                callGA(el.children().first().attr('id'),el.children().first().attr('section'));
				lastVisibleItem = el.data('page');
			}
		});

		el.find('.owl-controls .owl-dot').each(function(index){

			var el = $(this);
			if(index+1 === lastVisibleItem){
				el.addClass('active');
			}else{
				el.removeClass('active');
			}
		});

		var CssTranformMatrix = el.find('.owl-stage').css('transform');

		el.find('.owl-stage').css({
			'-webkit-transform': 'translate3d('+ Math.round(CssTranformMatrix.m41).toString() +'px, 0, 0)',
			'-moz-transform': 'translate3d('+ Math.round(CssTranformMatrix.m41).toString() +'px, 0, 0)',
			'-o-transform': 'translate3d('+ Math.round(CssTranformMatrix.m41).toString() +'px, 0, 0)',
			'-ms-transform': 'translate3d('+ Math.round(CssTranformMatrix.m41).toString() +'px, 0, 0)',
			'transform': 'translate3d('+ Math.round(CssTranformMatrix.m41).toString() +'px, 0, 0)'
		});

	});
};

window.initTabSlider = function(obj) {

    var items;
    var item;

    //Llamada al iniciarse
    obj.on('initialized.owl.carousel', function(event){

        items = event.item.count;
        item = event.item.index;

        setTimeout(function(){

            //Definimos el activo en la navegación
            $('.customTabs a').each(function(index){
                var el = $(this);

                if(index === item){
                    el.addClass('active');
                }else{
                    el.removeClass('active');
                }
            });

        }, 50);

        //Asignamos el enlace de cada botón a su slide correspondiente
        $('.customTabs a').each(function(index){
            var el = $(this);

            $('.owl-tabItem').each(function(i){
				var elChild = $(this);

				if(i !== 0){
					elChild.css('height', 0);
				}else{
					elChild.css('height', 'auto');
				}
			});

            el.on('click', $(this), function(e){
                e.preventDefault();

                obj.trigger('to.owl.carousel', index);

				el.addClass('active');
				$('.customTabs a').not(el).removeClass('active');

                $('.owl-tabItem').each(function(i){
					var elChild = $(this);

					if(index !== i){
						elChild.css('height', 0);
					}else{
						elChild.css('height', 'auto');
					}
				});
            });
        });
        
    });

    //Declaramos el slider
    obj.owlCarousel({
        animateOut: 'fadeOutShort',
        animateIn: 'fadeInShort',
        items: 1,
        itemElement: 'li',
        stageElement: 'ul',
        mouseDrag: false,
        touchDrag: false,
        loop: false,
        dots: true,
        responsiveRefreshRate: 0,
        itemClass: 'owl-tabItem',
    });
    
    //Llamada al detectar cambios en el slider
    obj.on('changed.owl.carousel', function(event){

        items = event.item.count;
        item = event.item.index;

        $('.customTabs a').each(function(){
            var el = $(this);

            //Eliminamos el evento click mientras se ejecuta la animación
            el.unbind('click').on('click', function(e){
                e.preventDefault();
            });
        });

    });

    //Llamada al terminar la animación
    obj.on('translated.owl.carousel', function(){

        $('.customTabs a').each(function(index){
            var el = $(this);

            el.unbind('click').on('click', $(this), function(e){
                e.preventDefault();

                obj.trigger('to.owl.carousel', index);

                el.addClass('active');
				$('.customTabs a').not(el).removeClass('active');

				$('.owl-tabItem').each(function(i){
					var elChild = $(this);

					if(index !== i){
						elChild.css('height', 0);
					}else{
						elChild.css('height', 'auto');
					}
				});
            });
            
        });
        
    });

};