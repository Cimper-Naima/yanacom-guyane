(function($){

	FLBuilder.registerModuleHelper('pp-smart-button', {

		rules: {
			text: {
				required: true
			},
			border_size: {
				required: true,
				number: true
			},
			bg_opacity: {
				required: true,
				number: true
			},
			font_size: {
				required: true,
				number: true
			},
			padding: {
				required: true,
				number: true
			},
			icon_size: {
				number: true
			},
			button_effect_duration: {
				number: true
			},
			custom_width: {
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
			border_radius: {
				required: true,
				number: true
			},
			letter_spacing: {
				number: true
			}
		},

		init: function()
		{
			$( 'input[name=bg_color]' ).on( 'change', this._bgColorChange );

			this._bgColorChange();
		},

		_bgColorChange: function()
		{
			var bgColor = $( 'input[name=bg_color]' ),
				style   = $( '#pp-builder-settings-section-style' );

			if ( '' == bgColor.val() ) {
				style.hide();
			}
			else {
				style.show();
			}
		}
	});

})(jQuery);
