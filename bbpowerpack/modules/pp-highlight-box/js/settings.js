(function($){

    /**
     * Use this file to register a module helper that
     * adds additional logic to the settings form. The
     * method 'FLBuilder._registerModuleHelper' accepts
     * two parameters, the module slug (same as the folder name)
     * and an object containing the helper methods and properties.
     */
    FLBuilder._registerModuleHelper('pp-highlight-box', {

        /**
         * The 'rules' property is where you setup
         * validation rules that are passed to the jQuery
         * validate plugin (http://jqueryvalidation.org).
         *
         * @property rules
         * @type object
         */
        rules: {
            'box_custom_icon_width': {
                number: true,
            },
            'box_font_icon_size': {
                number: true
            },
            'box_font_size': {
                number: true
            },
            'box_right_padding': {
                number: true
            },
            'box_left_padding': {
                number: true
            },
            'box_bottom_padding': {
                number: true
            },
            'box_top_padding': {
                number: true
            },
            'box_icon_transition_duration': {
                number: true
            }
        },
    });

})(jQuery);
