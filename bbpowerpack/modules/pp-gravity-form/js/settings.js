(function($){

    /**
     * Use this file to register a module helper that
     * adds additional logic to the settings form. The
     * method 'FLBuilder._registerModuleHelper' accepts
     * two parameters, the module slug (same as the folder name)
     * and an object containing the helper methods and properties.
     */
    FLBuilder._registerModuleHelper('pp-gravity-form', {

        /**
         * The 'rules' property is where you setup
         * validation rules that are passed to the jQuery
         * validate plugin (http://jqueryvalidation.org).
         *
         * @property rules
         * @type object
         */
        rules: {
            'form_border_width': {
                number: true
            },
            'form_padding': {
                number: true
            },
            'title_font_size': {
                number: true
            },
            'description_font_size': {
                number: true
            },
            'label_font_size': {
                number: true
            },
            'input_font_size': {
                number: true
            },
            'input_field_border_width': {
                number: true
            },
            'input_field_border_radius': {
                number: true
            },
            'input_field_padding': {
                number: true
            },
            'input_field_margin': {
                number: true
            },
            'button_width_size': {
                number: true
            },
            'button_font_size': {
                number: true
            },
            'button_padding_top_bottom': {
                number: true
            },
            'button_padding_top_bottom': {
                number: true
            },
            'button_padding_left_right': {
                number: true
            },
            'button_border_radius': {
                number: true
            },
            'button_border_width': {
                number: true
            },
            'form_error_input_border_width': {
                number: true
            },
            'validation_error_font_size': {
                number: true
            }
        }
    });

})(jQuery);
