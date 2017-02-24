(function($) {
	'use strict';

	app.viewModels.home = {};

	/**
	 * Inniate slider.
	 *
	 * @type Object
	 */
	ko.bindingHandlers.slider = {

		init: function() {
			$(document).ready(function(){
	          $('.home-slider').slick({
	            dots: true,
	            autoplay: vars.settings.sliderAutoplay ? true : false,
	            fade: true
	          });
	        });
		}
	};


})(jQuery);