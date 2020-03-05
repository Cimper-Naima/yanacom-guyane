(function($){

    /**
     * Use this file to register a module helper that
     * adds additional logic to the settings form. The
     * method 'FLBuilder._registerModuleHelper' accepts
     * two parameters, the module slug (same as the folder name)
     * and an object containing the helper methods and properties.
     */
    FLBuilder._registerModuleHelper('pp-info-banner', {

        /**
         * The 'rules' property is where you setup
         * validation rules that are passed to the jQuery
         * validate plugin (http://jqueryvalidation.org).
         *
         * @property rules
         * @type object
         */
        rules: {
            banner_min_height: {
                number: true,
            },
            banner_info_padding: {
                number: true
            },
            banner_border_width: {
                number: true
            },
            banner_title_font_size: {
                number: true
            },
            banner_title_margin: {
                number: true
            },
            banner_desc_font_size: {
                number: true
            },
            banner_desc_margin: {
                number: true
            },
            banner_image_height: {
                number: true
            },
            banner_button_border_width: {
                number: true
            },
            banner_button_border_radius: {
                number: true
            },
            banner_button_font_size: {
                number: true
            },
            banner_button_padding_left: {
                number: true
            },
            banner_button_padding_right: {
                number: true
            },
            banner_button_padding_top: {
                number: true
            },
            banner_button_padding_bottom: {
                number: true
            }
        },

        /**
         * The 'init' method is called by the builder when
         * the settings form is opened.
         *
         * @method init
         */
        init: function()
        {

        },

    });

})(jQuery);
