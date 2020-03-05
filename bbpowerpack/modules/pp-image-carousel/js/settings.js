;(function($) {
	FLBuilder.registerModuleHelper('pp-image-carousel', {

		init: function()
		{
			var self = this;
			var $form = $('.fl-builder-settings'),
				$type = $form.find('select[name="carousel_type"]'),
				$effect = $form.find('select[name="effect"]');

			this._toggleFields( $form, $type, $effect );

			$type.on('change', function() {
				self._toggleFields( $form, $type, $effect );
			});

			$effect.on('change', function() {
				self._toggleFields( $form, $type, $effect );
			});
		},

		_toggleFields: function( $form, $type, $effect )
		{
			if ( 'carousel' === $type.val() ) {
				$form.find('#fl-field-effect').show();

				if ( 'slide' === $effect.val() ) {
					$form.find('#fl-field-columns').show();
					$form.find('#fl-field-slides_to_scroll').show();
				}
				if ( 'fade' === $effect.val() || 'cube' === $effect.val() ) {
					$form.find('#fl-field-columns').hide();
					$form.find('#fl-field-slides_to_scroll').hide();
				}
			}
			if ( 'slideshow' === $type.val() ) {
				$form.find('#fl-field-effect').show();
				$form.find('#fl-field-columns').hide();
				$form.find('#fl-field-slides_to_scroll').hide();
			}
			if ( 'coverflow' === $type.val() ) {
				$form.find('#fl-field-effect').hide();
				$form.find('#fl-field-columns').show();
				$form.find('#fl-field-slides_to_scroll').show();
			}
		}

	} );
})(jQuery);