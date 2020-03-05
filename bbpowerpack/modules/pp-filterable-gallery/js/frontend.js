(function($) {
	PPFilterableGallery = function(settings)
	{
		this.settings       = settings;
		this.nodeClass      = '.fl-node-' + settings.id;
		this.wrapperClass   = this.nodeClass + ' .pp-photo-gallery';
		this.itemClass      = this.wrapperClass + ' .pp-gallery-item';
		this.masonry		= this.settings.layout === 'masonry' ? true : false;

		if(this._hasItems()) {
			this._initLayout();
		}
	};

	PPFilterableGallery.prototype = {

		settings        : {},
		nodeClass       : '',
		wrapperClass    : '',
		itemClass       : '',
		filterData		: {},
		postClass       : '',
		gallery         : null,
		matchHeight		: false,
		masonry			: false,

		_hasItems: function()
		{
			return $(this.itemClass).length > 0;
		},

		_initLayout: function()
		{
			this._initFilterData();
			this._gridLayout();

			this._hashChange();

			$(window).on('hashchange', $.proxy( this._hashChange, this ));
		},

		_hashChange: function()
		{
			setTimeout(function() {
				if( location.hash && $(location.hash).length > 0 ) {
					if ( $(location.hash).parent().hasClass('pp-gallery-filters') ) {
						$(location.hash).trigger('click');
					}
				}
			}, 200);
		},

		_initFilterData: function()
		{
			var filterData = {
				itemSelector: '.pp-gallery-item',
				percentPosition: true,
				transitionDuration: '0.6s',
			};

			if ( ! this.masonry ) {
				filterData = $.extend( {}, filterData, {
					layoutMode: 'fitRows',
					fitRows: {
						gutter: '.pp-photo-space'
					  },
				} );
			} else {
				filterData = $.extend( {}, filterData, {
					masonry: {
						columnWidth: '.pp-gallery-item',
						gutter: '.pp-photo-space'
					},
				} );
			}

			this.filterData = filterData;
		},

		_gridLayout: function()
		{
			var node 			= $(this.nodeClass);
			var wrap 			= $(this.wrapperClass);
			var items 			= $(this.itemClass);
			var filterData 		= this.filterData;
			var filters 		= wrap.isotope(filterData);
			var filtersWrap 	= node.find('.pp-gallery-filters');
			var filterToggle 	= node.find('.pp-gallery-filters-toggle');
			var isMasonry		= this.masonry;
			
			wrap.imagesLoaded( $.proxy( function() {

				if ( wrap.find( '.pp-gallery-overlay' ).length > 0 ) {
					var imgW = wrap.find( '.pp-gallery-img' ).outerWidth();
					wrap.find( '.pp-gallery-overlay' ).css('max-width', imgW + 'px');
				}

				filterToggle.on('click', function () {
					filtersWrap.slideToggle(function () {
						if ($(this).is(':visible')) {
							$(this).addClass('pp-gallery-filters-open');
						}
						if (!$(this).is(':visible')) {
							$(this).removeClass('pp-gallery-filters-open');
						}
					});
				});

				filtersWrap.on('click', '.pp-gallery-filter-label', function() {
                    var filterVal = $(this).attr('data-filter');
                    filters.isotope({ filter: filterVal });

					filtersWrap.find('.pp-gallery-filter-label').removeClass('pp-filter-active');
					$(this).addClass('pp-filter-active');
					
					filterToggle.find('span.toggle-text').html($(this).text());
					if (filtersWrap.hasClass('pp-gallery-filters-open')) {
						filtersWrap.slideUp();
					}
                });

                setTimeout( function() {
					node.find('.pp-filter-active').trigger('click');
					if ( isMasonry ) {
						wrap.isotope('layout');
					}

					items.css('visibility', 'visible');
                }, 1000 );

			}, this ) );
		},
	};

})(jQuery);
