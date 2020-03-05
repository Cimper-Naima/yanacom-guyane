;(function($) {
	FLBuilder.registerModuleHelper('pp-video-gallery', {

		init: function()
		{
			var $form = $('.fl-builder-settings');

			this._toggleClass();

			$form.find('[name="layout"]').on('change', this._toggleClass);
		},

		_toggleClass: function() {
			var $form = $('.fl-builder-settings');

			$form.removeClass( 'pp-video-gallery-layout-gallery' );
			$form.removeClass( 'pp-video-gallery-layout-carousel' );
			$form.addClass( 'pp-video-gallery-layout-' + $form.find('[name="layout"]').val() );
		}

	} );
})(jQuery);