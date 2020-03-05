(function($){

	FLBuilder.registerModuleHelper('pp-advanced-menu', {

		rules: {

		},

		init: function()
		{
			var form = $('.fl-builder-settings'),
				input = form.find('select[name="offcanvas_direction"]');

			input.on('change', function() {
				$('html').removeClass('pp-off-canvas-menu-open');
			});
		},

	});

})(jQuery);
