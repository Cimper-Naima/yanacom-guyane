( function( $ ) {

	/**
	 * Handles frontend editing UI logic for the builder.
	 *
	 * @class FLThemeBuilderFrontendEdit
	 * @since 1.0
	 */
	var FLThemeBuilderFrontendEdit = {

		/**
		 * Initialize.
		 *
		 * @since 1.0
		 * @access private
		 * @method _init
		 */
		_init: function()
		{
			this._bind();
			this._maybeShowOverrideWarning();
		},

		/**
		 * Bind events.
		 *
		 * @since 1.0
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			$( '.fl-builder-content:not(.fl-builder-content-primary)' ).on( 'mouseenter', this._partMouseenter );
			$( '.fl-builder-content:not(.fl-builder-content-primary)' ).on( 'mouseleave', this._partMouseleave );
		},

		/**
		 * Shows a confirmation dialog warning the user if they are about
		 * to override a theme layout with a standard builder layout.
		 *
		 * @since 1.0
		 * @access private
		 * @method _maybeShowOverrideWarning
		 */
		_maybeShowOverrideWarning: function()
		{
			var enabled  = FLBuilderConfig.builderEnabled,
				postType = FLBuilderConfig.postType,
				layouts  = FLThemeBuilderConfig.layouts,
				strings  = FLThemeBuilderConfig.strings;

			if ( ! enabled && 'fl-theme-layout' != postType && 'undefined' != typeof layouts.singular ) {
				FLBuilder.confirm( {
					message : strings.overrideWarning,
					strings : {
						ok     : strings.overrideWarningOk,
						cancel : strings.overrideWarningCancel
					},
					cancel : function() {
						FLBuilder.showAjaxLoader();
						window.location.href = FLThemeBuilderConfig.adminEditURL;
					}
				} );
			}
		},

		/**
		 * Shows the edit overlay when the mouse enters a
		 * header, footer or part.
		 *
		 * @since 1.0
		 * @access private
		 * @method _partMouseenter
		 */
		_partMouseenter: function()
		{
			// TODO
		},

		/**
		 * Removes the edit overlay when the mouse leaves a
		 * header, footer or part.
		 *
		 * @since 1.0
		 * @access private
		 * @method _partMouseleave
		 */
		_partMouseleave: function()
		{
			// TODO
		}
	};

	// Initialize
	$( function() { FLThemeBuilderFrontendEdit._init(); } );

} )( jQuery );
