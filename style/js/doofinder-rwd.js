/* == Universia - Dónde quieres estudiar - JS de estilos e interacción == */

/* jshint devel: true, unused: false */

var Style = (function(){

	var resetPosition = function(){
		if($('.content-search #claveDooFinder').length > 0){
			var inputWidth = $('.content-search #claveDooFinder').outerWidth() -1;
			var inputXPos = $('.content-search #claveDooFinder').offset().left +1;
			var inputYPos = $('.content-search .search-inner').offset().top - 85;

			$('.doofinder').css({
				'width' : inputWidth,
				'top' : inputYPos,
				'left' : inputXPos
			});
		}
	};

	/*------------------ Eventos principales ------------------*/

	var onResizeInstant = function(){
		resetPosition();
	};

	var init = function(){

		$(window).load(function() {
			onResizeInstant();
		});

		$(window).resize(function() {
			onResizeInstant();
		});

	};

	return {
		init: init
	};

})($);

Style.init();