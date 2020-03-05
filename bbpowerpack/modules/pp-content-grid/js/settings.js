;(function($){

	FLBuilder.registerModuleHelper('pp-content-grid', {
		/**
		 * Cached settings used to replace the current settings
		 * if the post layout changes are canceled.
		 *
		 * @since 1.0
		 * @access private
		 * @property {String} _previousSettings
		 */
		_previousSettings: null,

		_currentStyle: 'default',

		/**
         * The 'init' method is called by the builder when
         * the settings form is opened.
         *
         * @method init
         */
        init: function()
        {
			var form 			= $('.fl-builder-settings'),
				button_sections = ['button_colors', 'button_typography'],
				self 			= this;

			this._currentStyle = form.find('select[name="post_grid_style_select"]').val();

			this._tirggerStyleChange();
			form.find('select[name="post_grid_style_select"]').on('change', $.proxy( this._tirggerStyleChange, this ));

			if ( $( '#fl-field-custom_layout:visible' ).length > 0 ) {
				$( '#fl-field-custom_layout:visible' ).on('click', function() {
					setTimeout(function() {
						self._bindCustomLayoutSettings();
					}, 1000);
				});
			}

			if( $('#fl-builder-settings-section-general select[name="post_type"]').val() == 'product' || $('#fl-builder-settings-section-general select[name="post_type"]').val() == 'download' ) {
                $('#fl-builder-settings-section-product-settings').show();
                $('#fl-field-more_link_text').hide();
                if ( $('#fl-builder-settings-section-general select[name="post_type"]').val() == 'download' ) {
                    $('#fl-field-product_rating, #fl-field-product_rating_color').hide();
                }
		   	}

			$('#fl-builder-settings-section-general select[name="post_type"]').on('change', function() {
				if( $('#fl-builder-settings-section-general select[name="post_type"]').val() == 'product' || $('#fl-builder-settings-section-general select[name="post_type"]').val() == 'download' ) {
                    $('#fl-builder-settings-section-product-settings').show();
                    $('#fl-field-more_link_text').hide();
                    if ( $('#fl-builder-settings-section-general select[name="post_type"]').val() == 'download' ) {
                        $('#fl-field-product_rating, #fl-field-product_rating_color').hide();
                    }
			   	} else {
				   $('#fl-builder-settings-section-product-settings').hide();
                   self._showField( 'more_link_text', form.find( 'select[name="more_link_type"]' ).val() === 'button' );
			   	}
			});

			$('#fl-builder-settings-section-general select[name="post_type"]').trigger('change');

			// Show more link text field if more_link_type is button.
			self._showField( 'more_link_text', form.find( 'select[name="more_link_type"]' ).val() === 'button' );
			// Hide more link text field if more_link_type is not button.
			self._hideField( 'more_link_text', form.find( 'select[name="more_link_type"]' ).val() !== 'button' );

			if ( form.find( 'input[name="event_enable"]' ).val() === 'yes' || form.find( 'select[name="more_link_type"]' ).val() === 'button' || form.find( 'select[name="product_button"]' ).val() === 'yes' ) {
				self._showSection( button_sections );
			} else {
				self._hideSection( button_sections );
			}

			form.find( 'input[name="event_enable"]' ).on('change', function() {
				self._showSection( button_sections, $(this).val() === 'yes' );
				self._hideSection( button_sections, ( $(this).val() === 'no' && form.find( 'select[name="more_link_type"]' ).val() !== 'button' ) );
			});

			form.find( 'select[name="more_link_type"]' ).on('change', function() {
				self._showSection( button_sections, ( $(this).val() !== 'button' && form.find( 'input[name="event_enable"]' ).val() === 'yes' ) );
				self._showField( 'more_link_text', $(this).val() === 'button' );
			});
		},

		_tirggerStyleChange: function()
		{
			var form = $('.fl-builder-settings'),
				style = form.find('select[name="post_grid_style_select"]').val();

			form.removeClass( 'pp-cg-module-' + this._currentStyle );
			form.addClass( 'pp-cg-module-' + style );

			this._currentStyle = style;

			if ( 'custom' === form.find('select[name="post_grid_style_select"]').val() ) {
				form.addClass( 'pp-style-custom' );
			} else {
				form.removeClass( 'pp-style-custom' );
			}
		},

		/**
		 * Bind events to the custom post layout lightbox.
		 *
		 * @since 1.0
		 * @access _bindCustomPostLayoutSettings
		 * @method _bind
		 */
		_bindCustomLayoutSettings: function()
		{
			var form   = $( 'form[data-type="pp_post_custom_layout"]:visible' ),
				html   = form.find( 'textarea[name="html"]' ),
				css    = form.find( 'textarea[name="css"]' ),
				cancel = form.find( '.fl-builder-settings-cancel' );

			html.on( 'change', $.proxy( this._doCustomLayoutPreview, this ) );
			css.on( 'change', $.proxy( this._doCustomLayoutPreview, this ) );
			cancel.on( 'click', $.proxy( this._cancelClicked, this ) );
		},

		/**
		 * Callback for previewing custom post layouts.
		 *
		 * @since 2.6.2
		 * @access private
		 * @method _doCustomPostLayoutPreview
		 */
		_doCustomLayoutPreview: function()
		{
			var moduleForm     = $( '.fl-builder-module-settings' ),
				moduleSettings = FLBuilder._getSettings( moduleForm ),
				postForm       = $( '.fl-builder-settings[data-type="pp_post_custom_layout"]' ),
				postSettings   = FLBuilder._getSettings( postForm ),
				postField      = moduleForm.find( '[name="custom_layout"]' ),
				preview        = FLBuilder.preview;

			if ( ! this._previousSettings ) {
				this._previousSettings = moduleSettings.custom_layout
			}

			postField.val( JSON.stringify( postSettings ) );
			preview.delay( 2000, $.proxy( preview.preview, preview ) );
		},

		/**
		 * Callback for when the custom post layout settings
		 * lightbox cancel button is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _cancelClicked
		 */
		_cancelClicked: function()
		{
			var postField = $( '.fl-builder-module-settings' ).find( '[name="custom_layout"]' );

			if ( this._previousSettings ) {
				postField.val( this._previousSettings ).trigger( 'change' );
				this._previousSettings = null;
			}
		},

		_showSection: function(section_ids, condition)
		{
			if ( 'boolean' !== typeof condition || ! condition ) {
				return;
			}

			var form = $('.fl-builder-settings');

			if ( typeof section_ids === 'object' ) {
				section_ids.forEach( function( section_id ) {
					form.find('#fl-builder-settings-section-' + section_id).show();
				} );
			}

			if ( typeof section_ids === 'string' ) {
				form.find('#fl-builder-settings-section-' + section_ids).show();
			}
		},

		_hideSection: function(section_ids, condition = true)
		{
			if ( ! condition ) {
				return;
			}

			var form = $('.fl-builder-settings');
			
			if ( typeof section_ids === 'object' ) {
				section_ids.forEach( function( section_id ) {
					form.find('#fl-builder-settings-section-' + section_id).hide();
				} );
			}

			if ( typeof section_ids === 'string' ) {
				form.find('#fl-builder-settings-section-' + section_ids).hide();
			}
		},

		_showField: function(field_ids, condition = true)
		{
			if ( ! condition ) {
				return;
			}

			var form = $('.fl-builder-settings');

			if ( typeof field_ids === 'object' ) {
				field_ids.forEach( function( field_id ) {
					form.find('#fl-field-' + field_id).show();
				} );
			}

			if ( typeof field_ids === 'string' ) {
				form.find('#fl-field-' + field_ids).show();
			}
		},

		_hideField: function(field_ids, condition = true)
		{
			if ( ! condition ) {
				return;
			}

			var form = $('.fl-builder-settings');
			
			if ( typeof field_ids === 'object' ) {
				field_ids.forEach( function( field_id ) {
					form.find('#fl-field-' + field_id).hide();
				} );
			}

			if ( typeof field_ids === 'string' ) {
				form.find('#fl-field-' + field_ids).hide();
			}
		}

	});

})(jQuery);
