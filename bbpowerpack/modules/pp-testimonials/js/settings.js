(function($){

	FLBuilder.registerModuleHelper('pp-testimonials', {

		rules: {
			'testimonials[]': {
				required: true
			},
			pause: {
				number: true,
				required: true
			},
			speed: {
				number: true,
				required: true
			},
			'border_width': {
				number: true
			},
			'border_radius': {
				number: true
			},
			'heading_font_size': {
                number: true
            },
            'title_font_size': {
                number: true
            },
            'subtitle_font_size': {
                number: true
            },
            'text_font_size': {
                number: true
            },
		},

	});

})(jQuery);
