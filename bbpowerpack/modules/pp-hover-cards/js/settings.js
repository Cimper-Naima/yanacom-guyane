(function($){

	FLBuilder.registerModuleHelper('pp-hover-cards', {

		rules: {
			'card_content[]': {
				required: true
			},
			'hover_card_font_icon': {
				required: true
			},
			'hover_card_height': {
				number: true
			},
			'hover_card_height_tablet': {
				number: true
			},
			'hover_card_height_mobile': {
				number: true
			},
			'hover_card_spacing': {
				number: true
			},
			'hover_card_columns_desktop': {
				number: true
			},
			'hover_card_columns_tablet': {
				number: true
			},
			'hover_card_columns_mobile': {
				number: true
			},
			'hover_card_box_border_radius': {
				number: true
			},
			'hover_card_box_border_width': {
				number: true
			},
			'hover_card_box_border_opacity': {
				number: true
			},
			'hover_card_title_font_size': {
				number: true
			},
			'hover_card_description_font_size': {
				number: true
			},
			'hover_card_icon_size': {
				number: true
			},
			'hover_card_title_margin_top': {
				number: true
			},
			'hover_card_title_margin_bottom': {
				number: true
			},
			'hover_card_description_margin_top': {
				number: true
			},
			'hover_card_description_margin_bottom': {
				number: true
			},
			'hover_card_title_font_size_tablet': {
				number: true
			},
			'hover_card_title_font_size_mobile': {
				number: true
			},
			'hover_card_title_line_height': {
				number: true
			},
			'hover_card_title_line_height_tablet': {
				number: true
			},
			'hover_card_title_line_height_mobile': {
				number: true
			},
			'hover_card_description_font_size_tablet': {
				number: true
			},
			'hover_card_description_line_height': {
				number: true
			},
			'hover_card_description_line_height_tablet': {
				number: true
			},
			'hover_card_description_line_height_mobile': {
				number: true
			},
			'button_font_size': {
				number: true
			},
			'hover_card_button_font_size_tablet': {
				number: true
			},
			'hover_card_button_font_size_mobile': {
				number: true
			},
		},

		/**
         * The 'init' method is called by the builder when
         * the settings form is opened.
         *
         * @method init
         */
        init: function()
        {
			if( $('#fl-builder-settings-section-style_type select').val() == 'powerpack-style' ) {
			   $('head').append('<style id="pp-hover-card-settings"> #fl-builder-settings-section-hover_card_image_section, #fl-builder-settings-section-hover_card_icon_style { display: block; } </style>');
		   	} else {
				$('#pp-hover-card-settings').remove();
			}
			$('#fl-builder-settings-section-style_type select').on('change', function() {
				if( $('#fl-builder-settings-section-style_type select').val() == 'powerpack-style' ) {
				   $('head').append('<style id="pp-hover-card-settings"> #fl-builder-settings-section-hover_card_image_section, #fl-builder-settings-section-hover_card_icon_style { display: block; } </style>');
			   } else {
				   $('#pp-hover-card-settings').remove();
			   }
			});

        },

	});

})(jQuery);
