(function($){

	FLBuilder.registerModuleHelper('pp-image', {

		rules: {
			border_width: {
				number: true
			},
			image_border_width: {
				number: true
			},
			border_radius: {
				number: true
			},
			h: {
				number: true
			},
			v: {
				number: true
			},
			blur: {
				number: true
			},
			spread: {
				number: true
			},
			box_shadow_opacity: {
				number: true
			},
			caption_opacity: {
				number: true
			},
			top: {
				number: true
			},
			bottom: {
				number: true
			},
			left: {
				number: true
			},
			right: {
				number: true
			},
			desktop: {
				number: true
			},
			tablet: {
				number: true
			},
			mobile: {
				number: true
			},
		},

		init: function()
		{
			var form            = $('.fl-builder-settings'),
				photoSource     = form.find('select[name=photo_source]'),
				librarySource   = form.find('select[name=photo_src]'),
				urlSource       = form.find('input[name=photo_url]'),
				align           = form.find('select[name=align]');

			// Init validation events.
			this._photoSourceChanged();

			// Validation events.
			photoSource.on('change', this._photoSourceChanged);
		},

		_photoSourceChanged: function()
		{
			var form            = $('.fl-builder-settings'),
				photoSource     = form.find('select[name=photo_source]').val(),
				photo           = form.find('input[name=photo]'),
				photoUrl        = form.find('input[name=photo_url]'),
				linkType        = form.find('select[name=link_type]');

			photo.rules('remove');
			photoUrl.rules('remove');
			linkType.find('option[value=page]').remove();

			if(photoSource == 'library') {
				linkType.append('<option value="page">' + FLBuilderStrings.photoPage + '</option>');
			}
		}
	});

})(jQuery);
