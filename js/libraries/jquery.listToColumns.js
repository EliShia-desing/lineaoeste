/*  listToColumns v0.5 - Develop by Redbility - based on
 *	easyListSplitter plugin
 *
 *	To init the plugin add the following code to your own js file:
 *
 *	$('#selector').listToColumns({ 
 *			container: $('#parent-container'),
            maxColumns : 3,
            responsiveColumns : [
                {1280 : 3},
                {900 : 2},
                {640 : 1}
            ],
            direction: 'horizontal'
 *	});
 */

/* jshint devel: true, unused: false */

var j = 1;

(function ($) {
	$.fn.listToColumns = function (options) {

		var defaults = {
			container: $(this),
			maxColumns: 1,
			responsiveColumns: [ /*{800:1}*/ ], // Insert here the window breakpoint and the number of columns what you want.
			direction: 'horizontal'
		};

		var settings = $.extend(defaults, options);

		$('.'+settings.container).each(function () {

			var elParent = $(this);
			var obj = elParent.find('ul');
			var objDiv = elParent.find('> div');
			var totalListElements = $(this).children('li').size();
			var baseColItems = Math.ceil(totalListElements / settings.colNumber);
			var divClass = objDiv.attr('class');
			var listClass = obj.attr('class');
			var initialList = obj.clone();
			var initialDiv = objDiv.clone();
			var newColumnCount = settings.maxColumns;

			function init(){
				var windowWidth = window.innerWidth;

				// Create the columns

				if($(this).parent('div').find('ul').length !== settings.responsiveColumns.length || $(this).parent('div').find('> div').length !== settings.responsiveColumns.length){
					obj.remove();
					objDiv.remove();

					for (var i=0, numResponsiveColumns=settings.responsiveColumns.length; i<numResponsiveColumns; i++) {

						var currentSize = settings.responsiveColumns[i];
			
						for (var h in currentSize)
						{
							if (h >= windowWidth)
							{
								newColumnCount = currentSize[h];
							}
						}
					}

					if(elParent.closest('div').find('.listContainer').length !== 0){
						elParent.closest('div').find('.listContainer').empty();
					}

					for (var n = 1; n <= newColumnCount; n++){
						if(elParent.find('.listContainer').length === 0){
							elParent.prepend('<div class="listContainer"></div>');
						}
					
						if(obj.length > 0){
							elParent.closest('div').find('.listContainer').append('<ul class="listCol' + n + '"></ul>');
						}else{
							elParent.closest('div').find('.listContainer').append('<div class="listCol' + n + '"></div>');
						}
						
						elParent.find('.listContainer > ul').addClass(listClass);
						elParent.find('.listContainer > div').addClass(divClass);
					}
				}

				var listItem = 0;
				var k = 1;
				var l = 0;
				var d = 0;

				if (settings.direction === 'vertical') {
					// Vertical sort (coming Soon)
					
					/*$(this).children('li').each(function () {
						listItem = listItem + 1;
						if (listItem > baseColItems * (settings.colNumber - 1)) {
							$(this).parents('.listContainer').find('.listCol' + settings.colNumber).append(this);
						} else {
							if (listItem <= (baseColItems * k)) {
								$(this).parent('.listContainer').find('.listCol' + k).append(this);
							} else {
								$(this).parent('.listContainer').find('.listCol' + (k + 1)).append(this);
								k = k + 1;
							}
						}
					});

					$('.listContainer' + j).find('ol,ul').each(function () {
						if ($(this).children().size() === 0) {
							$(this).remove();
						}
					});*/

				} else {
					// Horizontal sort
					if(obj.length > 0){
						initialList.children('li').each(function (i) {
							var el = $(this);
							l = l + 1;

							if (l <= newColumnCount && l < initialList.children('li').length) {
								elParent.closest('div').find('.listContainer').find('.listCol' + l).append(el.clone());
							} else {
								l = 1;
								elParent.closest('div').find('.listContainer').find('.listCol' + l).append(el.clone());
							}
						});
					}else{
						initialDiv.children('div').each(function (i) {
							var el = $(this);
							d = d + 1;

							if (d <= newColumnCount && d <= initialDiv.children('div').length) {
								elParent.closest('div').find('.listContainer').find('.listCol' + d).append(el.clone());
							} else {
								d = 1;
								elParent.closest('div').find('.listContainer').find('.listCol' + d).append(el.clone());
							}
						});
					}
				}

				if(obj.length > 0){
					elParent.closest('div').find('.listContainer').find('ol:last,ul:last').addClass('last-col'); // Set class last on the last UL or OL	
				}else{
					elParent.closest('div').find('.listContainer').find('> div:last').addClass('last-col'); // Set class last on the last UL or OL	
				}

				j = j + 1;

			}

			init();

			var timeout;

			$(window).resize(function() {
				clearTimeout(timeout);
				timeout = setTimeout(function(){
					init();
				}, 200);
			});

		});
	};
})($);