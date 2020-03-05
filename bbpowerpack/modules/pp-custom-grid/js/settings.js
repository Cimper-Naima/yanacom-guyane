;(function($){

	FLBuilder.registerModuleHelper('pp-custom-grid', {

		_presetName: null,

		/**
		 * Cached settings used to replace the current settings
		 * if the post layout changes are canceled.
		 *
		 * @since 1.2.7
		 * @access private
		 * @property {String} _previousSettings
		 */
		_previousSettings: null,

		/**
         * The 'init' method is called by the builder when
         * the settings form is opened.
         *
         * @method init
         */
        init: function()
        {
			//$('select[name="preset"]').trigger('change');\
			FLBuilder.preview.preview();
			this._loaded();
        },

		/**
		 * Fires when the settings form has loaded.
		 *
		 * @since 1.2.7
		 * @access private
		 * @method _loaded
		 */
		_loaded: function()
		{
			this._presetName = $('select[name="preset"]').val() + '_preset';

			if ( $( '[data-type="'+this._presetName+'"]:visible' ).length > 0 ) {
				this._bindCustomPostLayoutSettings();
			}
		},

		/**
		 * Bind events to the custom post layout lightbox.
		 *
		 * @since 1.2.7
		 * @access private
		 * @method _bindCustomPostLayoutSettings
		 */
		_bindCustomPostLayoutSettings: function()
		{
			var form   = $( '[data-type="'+this._presetName+'"]:visible' ),
				html   = form.find( 'textarea[name="html"]' ),
				css    = form.find( 'textarea[name="css"]' ),
				cancel = form.find( '.fl-builder-settings-cancel' );

			html.on( 'change', $.proxy( this._doCustomPostLayoutPreview, this ) );
			css.on( 'change', $.proxy( this._doCustomPostLayoutPreview, this ) );
			cancel.on( 'click', $.proxy( this._cancelClicked, this ) );
		},

		/**
		 * Callback for previewing custom post layouts.
		 *
		 * @since 1.2.7
		 * @access private
		 * @method _doCustomPostLayoutPreview
		 */
		_doCustomPostLayoutPreview: function()
		{
			var moduleForm     = $( '.fl-builder-module-settings' ),
				moduleSettings = FLBuilder._getSettings( moduleForm ),
				postForm       = $( '.fl-builder-settings[data-type="'+this._presetName+'"]' ),
				postSettings   = FLBuilder._getSettings( postForm ),
				postField      = moduleForm.find( '[name="'+this._presetName+'"]' ),
				preview        = FLBuilder.preview;

			if ( ! this._previousSettings ) {
				this._previousSettings = moduleSettings[this._presetName];
			}

			postField.val( JSON.stringify( postSettings ) );
			preview.delay( 2000, $.proxy( preview.preview, preview ) );
		},

		/**
		 * Callback for when the custom post layout settings
		 * lightbox cancel button is clicked.
		 *
		 * @since 1.2.7
		 * @access private
		 * @method _cancelClicked
		 */
		_cancelClicked: function()
		{
			var postField = $( '.fl-builder-module-settings' ).find( '[name="'+this._presetName+'"]' );

			if ( this._previousSettings ) {
				postField.val( this._previousSettings ).trigger( 'change' );
				this._previousSettings = null;
			}
		}

	});

})(jQuery);
