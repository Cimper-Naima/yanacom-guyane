(function($) {

	PPFAQModule = function( settings )
	{
		this.settings  = settings;
		this.nodeClass = '.fl-node-' + settings.id;
		this._init();
	};

	PPFAQModule.prototype = {

		settings  : {},
		nodeClass : '',
		clicked   : false,

		_init: function()
		{
			$( this.nodeClass + ' .pp-faq-button' ).css( 'height', $( this.nodeClass + ' .pp-faq-button' ).outerHeight() + 'px' );
			$( this.nodeClass + ' .pp-faq-button' ).on( 'click', $.proxy( this._buttonClick, this ) );

			this._openDefaultItem();

			this._hashChange();

			$( window ).on( 'hashchange', $.proxy( this._hashChange, this ));
		},

		_hashChange: function()
		{
			if ( location.hash && $(location.hash).length > 0 ) {
				var element = $( location.hash + '.pp-faq-item' );
				if ( element && element.length > 0 ) {
					location.href = '#';
					$( 'html, body' ).animate({
						scrollTop: element.offset().top - 120
					}, 0, function() {
						if ( ! element.hasClass( 'pp-faq-item-active' ) ) {
							element.find( '.pp-faq-button' ).trigger( 'click' );
						}
					});
				}
			}
		},

		_buttonClick: function( e )
		{
			var button     = $( e.target ).closest( '.pp-faq-button' ),
				faq        = button.closest( '.pp-faq' ),
				item	   = button.closest( '.pp-faq-item' ),
				allContent = faq.find( '.pp-faq-content' ),
				allIcons   = faq.find( '.pp-faq-button i.pp-faq-button-icon' ),
				content    = button.siblings( '.pp-faq-content' ),
				icon       = button.find( 'i.pp-faq-button-icon' ),
				self       = this;

			if ( faq.hasClass( 'pp-faq-collapse' ) ) {
				faq.find( '.pp-faq-item-active' ).removeClass( 'pp-faq-item-active' );
				allContent.slideUp( 'normal' );
			}

			// if ( this.settings.responsiveCollapse && window.innerWidth <= 768 && ! this.clicked ) {
			// 	this.clicked = true;
			// 	return;
			// }

			if ( content.is( ':hidden' ) ) {
				item.addClass( 'pp-faq-item-active' );
				content.slideDown( 'normal', function() {
					self._slideDownComplete( this );
				});
			}
			else {
				item.removeClass( 'pp-faq-item-active' );
				content.slideUp( 'normal', function() {
					self._slideUpComplete( this );
				});
			}
		},

		_slideUpComplete: function(target)
		{
			var content = $( target ),
				faq     = content.closest( '.pp-faq' );

			faq.trigger( 'fl-builder.pp-faq-toggle-complete' );
		},

		_slideDownComplete: function(target)
		{
			var content = $( target ),
				faq     = content.closest( '.pp-faq' ),
				item    = content.parent(),
				win     = $( window );

			// Gallery module support.
			FLBuilderLayout.refreshGalleries( content );

			// Content Grid module support.
			if ( 'undefined' !== typeof $.fn.isotope ) {
				content.find( '.pp-content-post-grid.pp-masonry-active' ).isotope( 'layout' );

				var highestBox    = 0;
				var contentHeight = 0;

	            content.find( '.pp-equal-height .pp-content-post' ).css( 'height', '' ).each(function(){
	                if ( $(this).height() > highestBox ) {
	                	highestBox    = $( this ).height();
	                	contentHeight = $( this ).find( '.pp-content-post-data' ).outerHeight();
	                }
	            });

	            $( this.nodeClass ).find( '.pp-equal-height .pp-content-post' ).height(highestBox);
			}

			if ( item.offset().top < win.scrollTop() + 100 ) {
				if ( ! this.clicked ) {
					$( 'html, body' ).animate({
						scrollTop: item.offset().top - 100
					}, 500, 'swing' );
				}
			}

			this.clicked = false;

			faq.trigger( 'fl-builder.pp-faq-toggle-complete' );
			$( document ).trigger( 'pp-faq-toggle-complete', [ faq ] );
		},

		_openDefaultItem: function()
		{
			if ( this.settings.responsiveCollapse && window.innerWidth <= 768 ) {
				return;
			}

			if ( typeof this.settings.defaultItem !== 'undefined' ) {
				if ( 'all' == this.settings.defaultItem ) {
					$( this.nodeClass + ' .pp-faq-button' ).trigger( 'click' );
				} else {
					var item = $.isNumeric( this.settings.defaultItem ) ? ( this.settings.defaultItem - 1 ) : null;
					
					if ( item !== null ) {
						this.clicked = true;
						$( this.nodeClass + ' .pp-faq-button' ).eq( item ).trigger( 'click' );
					}
				}
			}
		}
	};

})(jQuery);
