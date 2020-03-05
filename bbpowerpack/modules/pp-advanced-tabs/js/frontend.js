(function($) {

	PPAdvancedTabs = function( settings )
	{
		this.settings 	= settings;
		this.nodeClass  = '.fl-node-' + settings.id;
		this._init();
	};

	PPAdvancedTabs.prototype = {

		settings	: {},
		nodeClass   : '',

		_init: function()
		{
			var win = $(window);

			$(this.nodeClass + ' .pp-tabs-labels .pp-tabs-label').click($.proxy(this._labelClick, this));
			$(this.nodeClass + ' .pp-tabs-panels .pp-tabs-label').click($.proxy(this._responsiveLabelClick, this));

			this._responsiveCollapsed();

			if($(this.nodeClass + ' .pp-tabs-vertical').length > 0) {
				this._resize();
				win.off('resize' + this.nodeClass);
				win.on('resize' + this.nodeClass, $.proxy(this._resize, this));
			}

			this._hashChange();

			$(window).on('hashchange', $.proxy( this._hashChange, this ));
			//$(window).on('resize', $.proxy( this._responsiveCollapsed, this ));
		},

		_hashChange: function()
		{
			if( location.hash && $(location.hash).length > 0 ) {
				var element = $(location.hash + '.pp-tabs-label');
				if ( element && element.length > 0 ) {
					var header = $('.fl-theme-builder-header-sticky');
					var offset = header.length > 0 ? header.height() + 32 : 120;
					location.href = '#';
					$('html, body').animate({
						scrollTop: element.parents('.pp-tabs').offset().top - offset
					}, 50, function() {
						if ( ! element.hasClass('pp-tab-active') ) {
							element.trigger('click');
						}
					});
				}
			}
		},

		_labelClick: function(e)
		{
			var label       = $(e.target).closest('.pp-tabs-label'),
				index       = label.data('index'),
				wrap        = label.closest('.pp-tabs'),
				allIcons    = wrap.find('.pp-tabs-label .fa'),
				icon        = wrap.find('.pp-tabs-label[data-index="' + index + '"] .fa');

			// Toggle the responsive icons.
			//allIcons.addClass('fa-plus');
			//icon.removeClass('fa-plus');

			if ( wrap.hasClass('pp-tabs-vertical') ) {
				var header = $('.fl-theme-builder-header-sticky');
				var offset = header.length > 0 ? header.height() + 32 : 120;
				$('html, body').animate({
					scrollTop: wrap.offset().top - offset
				}, 500 );
			}

			// Toggle the tabs.
			wrap.find('.pp-tabs-labels:first > .pp-tab-active').removeClass('pp-tab-active');
			wrap.find('.pp-tabs-panels:first > .pp-tabs-panel > .pp-tab-active').removeClass('pp-tab-active');
			wrap.find('.pp-tabs-panels:first > .pp-tabs-panel > .pp-tabs-label').removeClass('pp-tab-active');

			wrap.find('.pp-tabs-labels:first > .pp-tabs-label[data-index="' + index + '"]').addClass('pp-tab-active');
			wrap.find('.pp-tabs-panels:first > .pp-tabs-panel > .pp-tabs-panel-content[data-index="' + index + '"]').addClass('pp-tab-active');
			wrap.find('.pp-tabs-panels:first > .pp-tabs-panel > .pp-tabs-label[data-index="' + index + '"]').addClass('pp-tab-active');

			// Gallery module support.
			FLBuilderLayout.refreshGalleries( wrap.find('.pp-tabs-panel-content[data-index="' + index + '"]') );

			// Content Grid module support.
			if ( 'undefined' !== typeof $.fn.isotope ) {
				wrap.find('.pp-tabs-panel-content[data-index="' + index + '"] .pp-content-post-grid').isotope('layout');
				this._gridLayoutMatchHeight();
			}

			$(document).trigger('pp-tabs-switched', [ wrap.find( '.pp-tabs-panel-content[data-index="' + index + '"]' ) ]);
		},

		_responsiveLabelClick: function(e)
		{
			var label           = $(e.target).closest('.pp-tabs-label'),
				wrap            = label.closest('.pp-tabs'),
				index           = label.data('index'),
				content         = label.siblings('.pp-tabs-panel-content'),
				activeContent   = wrap.find('.pp-tabs-panel-content.pp-tab-active'),
				activeIndex     = activeContent.data('index'),
				allIcons        = wrap.find('.pp-tabs-label .fa'),
				icon            = label.find('.fa');

			// Should we proceed?
			if(index == activeIndex) {
				activeContent.slideUp('normal');
				activeContent.removeClass('pp-tab-active');
				$(this.nodeClass + ' .pp-tabs-panels .pp-tabs-label').removeClass('pp-tab-active');
				wrap.removeClass('pp-tabs-animation');
				return;
			}
			if(wrap.hasClass('pp-tabs-animation')) {
				return;
			}

			// Toggle the icons.
			//allIcons.addClass('fa-plus');
			//icon.removeClass('fa-plus');

			// Run the animations.
			wrap.addClass('pp-tabs-animation');
			activeContent.slideUp('normal');


			content.slideDown('normal', function(){

				wrap.find('.pp-tab-active').removeClass('pp-tab-active');
				wrap.find('.pp-tabs-label[data-index="' + index + '"]').addClass('pp-tab-active');
				content.addClass('pp-tab-active');
				wrap.removeClass('pp-tabs-animation');

				// Gallery module support.
				FLBuilderLayout.refreshGalleries( content );

				// Content Grid module support.
				if ( 'undefined' !== typeof $.fn.isotope ) {
					content.find('.pp-content-post-grid').isotope('layout');
				}

				if(label.offset().top < $(window).scrollTop() + 100) {
					$('html, body').animate({ scrollTop: label.offset().top - 100 }, 500, 'swing');
				}

				$(document).trigger('pp-tabs-switched', [ content ]);
			});
		},

		_resize: function()
		{
			$(this.nodeClass + ' .pp-tabs-vertical').each($.proxy(this._resizeVertical, this));
		},

		_resizeVertical: function(e)
		{
			var wrap    = $(this.nodeClass + ' .pp-tabs-vertical'),
				labels  = wrap.find('.pp-tabs-labels'),
				panels  = wrap.find('.pp-tabs-panels');

			panels.css('min-height', labels.height() + 'px');
		},

		_gridLayoutMatchHeight: function()
		{
			var highestBox = 0;
			var contentHeight = 0;

            $(this.nodeClass).find('.pp-equal-height .pp-content-post').css('height', '').each(function(){

                if($(this).height() > highestBox) {
                	highestBox = $(this).height();
                	contentHeight = $(this).find('.pp-content-post-data').outerHeight();
                }
            });

            $(this.nodeClass).find('.pp-equal-height .pp-content-post').height(highestBox);
            //$(this.postClass).find('.pp-content-post-data').css('min-height', contentHeight + 'px').addClass('pp-content-relative');
		},

		_responsiveCollapsed: function()
		{
			if ( $(window).innerWidth() < 769 ) {
				if ( this.settings.responsiveClosed ) {
					$(this.nodeClass + ' .pp-tabs-panels .pp-tabs-label.pp-tab-active').trigger('click');
				}
				$(this.nodeClass + ' .pp-tabs-panels').css('visibility', 'visible');
			}
		}
	};

})(jQuery);
