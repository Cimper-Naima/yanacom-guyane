(function($){

    /**
     * Use this file to register a module helper that
     * adds additional logic to the settings form. The
     * method 'FLBuilder._registerModuleHelper' accepts
     * two parameters, the module slug (same as the folder name)
     * and an object containing the helper methods and properties.
     */
    FLBuilder._registerModuleHelper('pp-logos-grid', {

        /**
         * The 'rules' property is where you setup
         * validation rules that are passed to the jQuery
         * validate plugin (http://jqueryvalidation.org).
         *
         * @property rules
         * @type object
         */
        rules: {
            'logos_grid[]': {
				required: true
			},
            'logo_carousel_width': {
                number: true,
            },
            'logo_carousel_minimum_grid': {
                number: true
            },
            'logo_carousel_maximum_grid': {
                number: true
            },
            'logos_grid_spacing': {
                number: true
            },
            'logos_carousel_spacing': {
                number: true
            },
            'logos_grid_columns_desktop': {
                number: true
            },
            'logos_grid_columns_tablet': {
                number: true
            },
            'logos_grid_columns_mobile': {
                number: true
            },
            'logo_slider_pause': {
                number: true
            },
            'logo_slider_speed': {
                number: true
            },
            'logo_grid_border_width': {
                number: true
            },
            'logo_grid_border_radius': {
                number: true
            },
            'logo_grid_padding_top': {
                number: true
            },
            'logo_grid_padding_bottom': {
                number: true
            },
            'logo_grid_padding_left': {
                number: true
            },
            'logo_grid_padding_right': {
                number: true
            },
            'logo_grid_logo_border_width': {
                number: true
            },
            'logo_grid_logo_border_radius': {
                number: true
            },
            'logo_grid_title_font_size': {
                number: true
            },
            'logo_grid_title_top_margin': {
                number: true
            },
            'logo_grid_title_bottom_margin': {
                number: true
            },
            'logo_grid_arrow_font_size': {
                number: true
            },
            'logo_grid_arrow_border_width': {
                number: true
            },
            'logo_grid_arrow_border_radius': {
                number: true
            },
            'logo_grid_arrow_padding_top': {
                number: true
            },
            'logo_grid_arrow_padding_bottom': {
                number: true
            },
            'logo_grid_arrow_padding_left': {
                number: true
            },
            'logo_grid_arrow_padding_right': {
                number: true
            },
            'logo_grid_arrow_width': {
                number: true
            },
            'logo_grid_dot_border_width': {
                number: true
            },
            'logo_grid_dot_border_radius': {
                number: true
            },
        },
    });

})(jQuery);
