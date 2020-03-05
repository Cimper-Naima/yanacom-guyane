(function($){

	/**
	 * Helper class for header layout logic.
	 *
	 * @since 1.0
	 * @class FLThemeBuilderHeaderLayout
	 */
	FLThemeBuilderHeaderLayout = {

		/**
		 * A reference to the window object for this page.
		 *
		 * @since 1.0
		 * @property {Object} win
		 */
		win : null,

		/**
		 * A reference to the body object for this page.
		 *
		 * @since 1.0
		 * @property {Object} body
		 */
		body : null,

		/**
		 * A reference to the header object for this page.
		 *
		 * @since 1.0
		 * @property {Object} header
		 */
		header : null,

		/**
		 * Whether this header overlays the content or not.
		 *
		 * @since 1.0
		 * @property {Boolean} overlay
		 */
		overlay : false,

		/**
		 * Whether the page has the WP admin bar or not.
		 *
		 * @since 1.0
		 * @property {Boolean} hasAdminBar
		 */
		hasAdminBar : false,

		/**
		 * Initializes header layout logic.
		 *
		 * @since 1.0
		 * @method init
		 */
		init: function()
		{
			var editing = $( 'html.fl-builder-edit' ).length,
				header  = $( '.fl-builder-content[data-type=header]' );

			if ( ! editing && header.length ) {

				header.imagesLoaded( $.proxy( function() {

					this.win    	 = $( window );
					this.body   	 = $( 'body' );
					this.header 	 = header.eq( 0 );
					this.overlay     = !! Number( header.attr( 'data-overlay' ) );
					this.hasAdminBar = !! $( 'body.admin-bar' ).length;

					if ( Number( header.attr( 'data-sticky' ) ) ) {

						this.header.data( 'original-top', this.header.offset().top );
						this.win.on( 'resize', $.throttle( 500, $.proxy( this._initSticky, this ) ) );
						this._initSticky();

						if ( Number( header.attr( 'data-shrink' ) ) ) {
							this.header.data( 'original-height', this.header.outerHeight() );
							this.win.on( 'resize', $.throttle( 500, $.proxy( this._initShrink, this ) ) );
							this._initShrink();
						}
					}

				}, this ) );
			}
		},

		/**
		 * Initializes sticky logic for a header.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initSticky
		 */
		_initSticky: function()
		{
			if ( this.win.width() >= FLBuilderLayoutConfig.breakpoints.medium ) {
				this.win.on( 'scroll.fl-theme-builder-header-sticky', $.proxy( this._doSticky, this ) );
				this._doSticky();
			} else {
				this.win.off( 'scroll.fl-theme-builder-header-sticky' );
				this.header.removeClass( 'fl-theme-builder-header-sticky' );
				this.body.css( 'padding-top', '0' );
			}
		},

		/**
		 * Sticks the header when the page is scrolled.
		 *
		 * @since 1.0
		 * @access private
		 * @method _doSticky
		 */
		_doSticky: function()
		{
			var winTop    		  = this.win.scrollTop(),
				headerTop 		  = this.header.data( 'original-top' ),
				hasStickyClass    = this.header.hasClass( 'fl-theme-builder-header-sticky' ),
				hasScrolledClass  = this.header.hasClass( 'fl-theme-builder-header-scrolled' );

			if ( this.hasAdminBar ) {
				winTop += 32;
			}

			if ( winTop >= headerTop ) {
				if ( ! hasStickyClass ) {
					this.header.addClass( 'fl-theme-builder-header-sticky' );
					if ( ! this.overlay ) {
						this.body.css( 'padding-top', this.header.outerHeight() + 'px' );
					}
				}
			}
			else if ( hasStickyClass ) {
				this.header.removeClass( 'fl-theme-builder-header-sticky' );
				this.body.css( 'padding-top', '0' );
			}

			if ( winTop > headerTop ) {
				if ( ! hasScrolledClass ) {
					this.header.addClass( 'fl-theme-builder-header-scrolled' );
				}
			} else if ( hasScrolledClass ) {
				this.header.removeClass( 'fl-theme-builder-header-scrolled' );
			}
		},

		/**
		 * Initializes shrink logic for a header.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initShrink
		 */
		_initShrink: function()
		{
			if ( this.win.width() >= FLBuilderLayoutConfig.breakpoints.medium ) {
				this.win.on( 'scroll.fl-theme-builder-header-shrink', $.proxy( this._doShrink, this ) );
				this._setImageMaxHeight();
			} else {
				this.body.css( 'padding-top', '0' );
				this.win.off( 'scroll.fl-theme-builder-header-shrink' );
				this._removeShrink();
				this._removeImageMaxHeight();
			}
		},

		/**
		 * Shrinks the header when the page is scrolled.
		 *
		 * @since 1.0
		 * @access private
		 * @method _doShrink
		 */
		_doShrink: function()
		{
			var winTop 	  	 = this.win.scrollTop(),
				headerTop 	 = this.header.data( 'original-top' ),
				headerHeight = this.header.data( 'original-height' ),
				hasClass     = this.header.hasClass( 'fl-theme-builder-header-shrink' );

			if ( this.hasAdminBar ) {
				winTop += 32;
			}

			if ( winTop > headerTop + headerHeight ) {

				if ( ! hasClass ) {

					this.header.addClass( 'fl-theme-builder-header-shrink' );

					this.header.find( '.fl-row-content-wrap' ).each( function() {

						var row = $( this );

						if ( parseInt( row.css( 'padding-bottom' ) ) > 5 ) {
							row.addClass( 'fl-theme-builder-header-shrink-row-bottom' );
						}

						if ( parseInt( row.css( 'padding-top' ) ) > 5 ) {
							row.addClass( 'fl-theme-builder-header-shrink-row-top' );
						}
					} );

					this.header.find( '.fl-module-content' ).each( function() {

						var module = $( this );

						if ( parseInt( module.css( 'margin-bottom' ) ) > 5 ) {
							module.addClass( 'fl-theme-builder-header-shrink-module-bottom' );
						}

						if ( parseInt( module.css( 'margin-top' ) ) > 5 ) {
							module.addClass( 'fl-theme-builder-header-shrink-module-top' );
						}
					} );
				}
			} else if ( hasClass ) {
				this._removeShrink();
			}
		},

		/**
		 * Removes the header shrink effect.
		 *
		 * @since 1.0
		 * @access private
		 * @method _removeShrink
		 */
		_removeShrink: function()
		{
			var rows    = this.header.find( '.fl-row-content-wrap' ),
				modules = this.header.find( '.fl-module-content' );

			rows.removeClass( 'fl-theme-builder-header-shrink-row-bottom' );
			rows.removeClass( 'fl-theme-builder-header-shrink-row-top' );
			modules.removeClass( 'fl-theme-builder-header-shrink-module-bottom' );
			modules.removeClass( 'fl-theme-builder-header-shrink-module-top' );
			this.header.removeClass( 'fl-theme-builder-header-shrink' );
		},

		/**
		 * Adds max height to images in modules for smooth scrolling.
		 *
		 * @since 1.1.1
		 * @access private
		 * @method _setImageMaxHeight
		 */
		_setImageMaxHeight: function()
		{
			var head = $( 'head' ),
				stylesId = 'fl-header-styles-' + this.header.data( 'post-id' ),
				styles = '',
				images = this.header.find( '.fl-module-content img' );

			if ( $( '#' + stylesId ).length ) {
				return;
			}

			images.each( function( i ) {
				var image = $( this ),
					height = image.height(),
					node = image.closest( '.fl-module' ).data( 'node' ),
					className = 'fl-node-' + node + '-img-' + i;

				image.addClass( className );
				styles += '.' + className + ' { max-height: ' + height + 'px }';
			} );

			if ( '' !== styles ) {
				head.append( '<style id="' + stylesId + '">' + styles + '</style>' );
			}
		},

		/**
		 * Removes max height on images in modules for smooth scrolling.
		 *
		 * @since 1.1.1
		 * @access private
		 * @method _removeImageMaxHeight
		 */
		_removeImageMaxHeight: function()
		{
			$( '#fl-header-styles-' + this.header.data( 'post-id' ) ).remove();
		},
	};

	$( function() { FLThemeBuilderHeaderLayout.init(); } );

})(jQuery);
