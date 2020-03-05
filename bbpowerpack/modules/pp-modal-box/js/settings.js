(function($){

    FLBuilder._registerModuleHelper('pp-modal-box', {

		_templates: '',

        /**
         * The 'rules' property is where you setup
         * validation rules that are passed to the jQuery
         * validate plugin (http://jqueryvalidation.org).
         *
         * @property rules
         * @type object
         */
        rules: {
            'button_text': {
                required: true
            },
            'button_font_size': {
                number: true,
                required: true
            },
            'button_opacity': {
                number: true
            },
            'button_opacity_hover': {
                number: true
            },
            'button_border_width': {
                number: true
            },
            'button_border_radius': {
                number: true
            },
            'button_padding_left_right': {
                number: true
            },
            'button_padding_top_bottom': {
                number: true
            },
            'modal_delay': {
                number: true
            },
            'display_after': {
                number: true
            },
            'display_after_auto': {
                number: true
            },
            'title_font_size': {
                number: true
            },
            'title_border': {
                number: true
            },
            'title_padding': {
                number: true
            },
            'modal_border_radius': {
                number: true
            },
            'modal_padding': {
                number: true
            },
            'modal_width': {
                number: true
            },
            'modal_height': {
                number: true
            },
            'content_border_width': {
                number: true
            },
            'content_border_radius': {
                number: true
            },
            'content_padding': {
                number: true
            },
            'overlay_opacity': {
                number: true
            },
            'close_btn_border_radius': {
                number: true
            },
            'close_btn_weight': {
                number: true
            },
            'close_btn_top': {
                number: true
            },
            'close_btn_right': {
                number: true
            },
            'media_breakpoint': {
                number: true
            },
		},
		
        init: function() {
			$('body').delegate( '.fl-builder-settings select[name="modal_type"]', 'change', $.proxy(this._modalTypeChange, this) );

            $('select[name="button_type"]').trigger('change');
			$('select[name="modal_load"]').trigger('change');

			this._setTemplates();
			
			var nodeId = $('#fl-field-modal_css_class').parents('.fl-builder-settings').data('node');
			$('#fl-field-modal_css_class input').val( 'modal-' + nodeId );
			$('.pp-modal-node-id').text( nodeId );
			$('.pp-modal-hide-js').val( 'pp_modal_' + nodeId + '.hide()' );
		},

		_modalTypeChange: function(e)
		{
			var type = $(e.target).val();

			if ( 'templates' === type ) {
				this._setTemplates();
			}
		},

		_getTemplates: function(callback)
		{
			if ( 'undefined' === typeof callback ) {
				return;
			}

			$.post(
				ajaxurl,
				{
					action: 'pp_get_saved_templates',
				},
				function( response ) {
					callback(response);
				}
			);
		},

		_setTemplates: function()
		{
			var form = $('.fl-builder-settings'),
				select = form.find( 'select[name="modal_type_templates"]' ),
				value = '', self = this;

			if ( 'templates' !== form.find( 'select[name="modal_type"]' ).val()) {
				return;
			}
	
			if ( 'undefined' !== typeof FLBuilderSettingsForms && 'undefined' !== typeof FLBuilderSettingsForms.config ) {
				if ( "pp-modal-box" === FLBuilderSettingsForms.config.id ) {
					value = FLBuilderSettingsForms.config.settings['modal_type_templates'];
				}
			}

			if ( this._templates !== '' ) {
				select.html( this._templates );
				select.find( 'option[value="' + value + '"]').attr('selected', 'selected');

				return;
			}

			this._getTemplates(function(data) {
				var response = JSON.parse( data );

				if ( response.success ) {
					self._templates = response.data;
					select.html( response.data );
					if ( '' !== value ) {
						select.find( 'option[value="' + value + '"]').attr('selected', 'selected');
					}
				}
			});
		}
    });

})(jQuery);
