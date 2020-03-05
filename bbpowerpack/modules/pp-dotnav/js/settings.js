(function($){

    /**
     * Use this file to register a module helper that
     * adds additional logic to the settings form. The
     * method 'FLBuilder._registerModuleHelper' accepts
     * two parameters, the module slug (same as the folder name)
     * and an object containing the helper methods and properties.
     */
    FLBuilder._registerModuleHelper('pp-dotnav', {

        /**
         * The 'rules' property is where you setup
         * validation rules that are passed to the jQuery
         * validate plugin (http://jqueryvalidation.org).
         *
         * @property rules
         * @type object
         */
        rules: {
            row_ids: {
                required: true
            },
            top_offset: {
                number: true,
                required: true
            },
            dot_border_width: {
                number: true,
                required: true
            },
            dot_padding: {
                number: true,
                required: true
            },
            dot_margin: {
                number: true,
                required: true
            },
            dot_hide_on: {
                number: true,
                required: true
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

        }
    });

})(jQuery);
