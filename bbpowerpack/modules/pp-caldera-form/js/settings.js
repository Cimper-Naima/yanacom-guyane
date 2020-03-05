(function($){

    /**
     * Use this file to register a module helper that
     * adds additional logic to the settings form. The
     * method 'FLBuilder._registerModuleHelper' accepts
     * two parameters, the module slug (same as the folder name)
     * and an object containing the helper methods and properties.
     */
    FLBuilder._registerModuleHelper('pp-caldera-form', {

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
            'form_border_radius': {
                number: true,
            },
            'form_shadow': {
                number: true
            },
            'form_shadow_opacity': {
                number: true
            },
            'form_padding': {
                number: true
            },
            'title_margin': {
                number: true
            },
            'description_margin': {
                number: true
            },
            'input_field_height': {
                number: true
            },
            'input_textarea_height': {
                number: true
            },
            'input_field_background_opacity': {
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
            'button_background_opacity': {
                number: true
            },
            'button_border_width': {
                number: true
            },
            'button_border_radius': {
                number: true
            },
            'button_padding': {
                number: true
            },
            'title_font_size': {
                number: true
            },
            'title_line_height': {
                number: true
            },
            'description_font_size': {
                number: true
            },
            'description_line_height': {
                number: true
            },
            'label_font_size': {
                number: true
            },
            'input_font_size': {
                number: true
            },
            'input_desc_font_size': {
                number: true
            },
            'input_desc_line_height': {
                number: true
            },
            'button_font_size': {
                number: true
            },
            'validation_error_font_size': {
                number: true
            },
            'success_message_font_size': {
                number: true
            }
        }
    });

})(jQuery);
