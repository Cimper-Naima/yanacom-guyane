; (function ($) {

	FLBuilder.registerModuleHelper('pp-album', {
		init: function () {
			var form 		= $('.fl-builder-settings');
			var self 		= this;

			self._toggleCoverContent();

			form.find('#fl-field-cover_content').on('DOMSubtreeModified', function () {
				self._toggleCoverContent();
			});
		},

		_toggleCoverContent: function () {
			var form = $('.fl-builder-settings');
			var field = form.find('input[name="cover_content"]');
			if ( 'hide' === field.val() ) {
				form.find('#fl-builder-settings-section-album_cover_content').hide();
				form.find('#fl-builder-settings-section-album_cover_content_h').hide();

				var fieldButton = form.find('input[name="content_button"]');
				if ('no' === fieldButton.val()) {
					form.find('#fl-builder-settings-section-album_cover_button').hide();
				} else {
					form.find('#fl-builder-settings-section-album_cover_button').hide();
				}

			} else {
				form.find('#fl-builder-settings-section-album_cover_content').show();
				form.find('#fl-builder-settings-section-album_cover_content_h').show();

				var fieldButton = form.find('input[name="content_button"]');
				if ('no' === fieldButton.val()) {
					form.find('#fl-builder-settings-section-album_cover_button').hide();
				} else {
					form.find('#fl-builder-settings-section-album_cover_button').show();
				}
			}
		},

	});
})(jQuery);