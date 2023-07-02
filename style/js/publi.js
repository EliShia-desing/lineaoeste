/* == Universia - Dónde quieres estudiar - JS de estilos e interacción == */

/* jshint devel: true, unused: false */

var publicidad = (function(){

	var init = function(){

		$(document).ready(function(){

			var bannerTop = $('#Top');
				childsbannerTop = $('#Top').children();

			// Si hay publicidad añadimos la clase '.visible' que se encarga de dar estilo a la capa
			if(childsbannerTop.length > 2){
				bannerTop.addClass('visible');
			}

		});

	};

	return {
		init: init
	};

})($);

publicidad.init();
