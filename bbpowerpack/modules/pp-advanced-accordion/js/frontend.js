(function($) {

	PPAccordion = function( settings )
	{
		this.settings 	= settings;
		this.nodeClass  = '.fl-node-' + settings.id;
		this._init();
	};

	PPAccordion.prototype = {

		settings	: {},
		nodeClass   : '',
		clicked		: false,

		_init: function()
		{
			if ( $( this.nodeClass ).find( '.pp-accordion-initialized' ).length > 0 ) {
				return;
			}

			$( this.nodeClass + ' .pp-accordion-button' ).css('height', $( this.nodeClass + ' .pp-accordion-button' ).outerHeight() + 'px');
			$( this.nodeClass + ' .pp-accordion-button' ).on('click', $.proxy( this._buttonClick, this ) );

			this._openDefaultItem();

			this._hashChange();

			$(window).on('hashchange', $.proxy( this._hashChange, this ));
			$( this.nodeClass ).find( '.pp-accordion' ).addClass('pp-accordion-initialized');
		},

		_hashChange: function()
		{
			if( location.hash && $(location.hash).length > 0 ) {
				var element = $(location.hash + '.pp-accordion-item');
				if ( element && element.length > 0 ) {
					location.href = '#';
					$('html, body').animate({
						scrollTop: element.offset().top - 120
					}, 0, function() {
						if ( ! element.hasClass('pp-accordion-item-active') ) {
							element.find('.pp-accordion-button').trigger('click');
						}
					});
				}
			}
		},

		_buttonClick: function( e )
		{
			var button      = $( e.target ).closest('.pp-accordion-button'),
				accordion   = button.closest('.pp-accordion'),
				item	    = button.closest('.pp-accordion-item'),
				allContent  = accordion.find('.pp-accordion-content'),
				allIcons    = accordion.find('.pp-accordion-button i.pp-accordion-button-icon'),
				content     = button.siblings('.pp-accordion-content'),
				icon        = button.find('i.pp-accordion-button-icon'),
				self		= this;

			if(accordion.hasClass('pp-accordion-collapse')) {
				accordion.find( '.pp-accordion-item-active' ).removeClass( 'pp-accordion-item-active' );
				allContent.slideUp('normal');
			}

			// if ( this.settings.responsiveCollapse && window.innerWidth <= 768 && ! this.clicked ) {
			// 	this.clicked = true;
			// 	return;
			// }

			if(content.is(':hidden')) {
				item.addClass( 'pp-accordion-item-active' );
				content.slideDown('normal', function() {
					self._slideDownComplete(this);
				});
			}
			else {
				item.removeClass( 'pp-accordion-item-active' );
				content.slideUp('normal', function() {
					self._slideUpComplete(this);
				});
			}
		},

		_slideUpComplete: function(target)
		{
			var content 	= $( target ),
				accordion 	= content.closest( '.pp-accordion' );

			accordion.trigger( 'fl-builder.pp-accordion-toggle-complete' );
		},

		_slideDownComplete: function(target)
		{
			var content 	= $( target ),
				accordion 	= content.closest( '.pp-accordion' ),
				item 		= content.parent(),
				win  		= $( window );

			// Gallery module support.
			FLBuilderLayout.refreshGalleries( content );

			// Content Grid module support.
			if ( 'undefined' !== typeof $.fn.isotope ) {
				content.find('.pp-content-post-grid.pp-masonry-active').isotope('layout');

				var highestBox = 0;
				var contentHeight = 0;

	            content.find('.pp-equal-height .pp-content-post').css('height', '').each(function(){
	                if($(this).height() > highestBox) {
	                	highestBox = $(this).height();
	                	contentHeight = $(this).find('.pp-content-post-data').outerHeight();
	                }
	            });

	            $(this.nodeClass).find('.pp-equal-height .pp-content-post').height(highestBox);
			}

			if ( item.offset().top < win.scrollTop() + 100 ) {
				if ( ! this.clicked ) {
					$( 'html, body' ).animate({
						scrollTop: item.offset().top - 100
					}, 500, 'swing');
				}
			}

			this.clicked = false;

			accordion.trigger( 'fl-builder.pp-accordion-toggle-complete' );
			$(document).trigger( 'pp-accordion-toggle-complete', [ accordion ] );
		},

		_openDefaultItem: function()
		{
			if ( this.settings.responsiveCollapse && window.innerWidth <= 768 ) {
				return;
			}

			if(typeof this.settings.defaultItem !== 'undefined') {
				var item = $.isNumeric(this.settings.defaultItem) ? (this.settings.defaultItem - 1) : null;

				if(item !== null) {
					this.clicked = true;
					$( this.nodeClass + ' .pp-accordion-button' ).eq(item).trigger('click');
				}
			}
		}
	};

})(jQuery);
