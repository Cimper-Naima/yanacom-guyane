(function($) {

	PPCustomGrid = function(settings)
	{
		this.settings     = settings;
		this.nodeClass    = '.fl-node-' + settings.id;
		this.matchHeight  = settings.matchHeight;
        this.wrapperClass = this.nodeClass + ' .pp-custom-grid';

		if ( 'columns' === this.settings.layout ) {
			this.postClass    = this.nodeClass + ' .pp-custom-grid-column';
		}
		else {
			this.postClass    = this.wrapperClass + '-post';
		}

		if(this._hasPosts()) {
			this._initLayout();
			this._initInfiniteScroll();

			var self = this;

			// Set FacetWP Trigger
			$(document).on('facetwp-loaded', function() {
				if ( 'undefined' !== typeof FWP ) {
					if (FWP.loaded || FWP.is_bfcache) {
						self._initInfiniteScroll();
					}
				}
			});
		}
	};

	PPCustomGrid.prototype = {

		settings        : {},
		nodeClass       : '',
		wrapperClass    : '',
		postClass       : '',
		gallery         : null,

		_hasPosts: function()
		{
			return $(this.postClass).length > 0;
		},

		_initLayout: function()
		{
			switch(this.settings.layout) {

				case 'columns':
				this._columnsLayout();
				break;

				case 'grid':
				this._gridLayout();
				break;
			}

			$(this.postClass).css('visibility', 'visible');

			FLBuilderLayout._scrollToElement( $( this.nodeClass + ' .pp-paged-scroll-to' ) );
		},

		_columnsLayout: function()
		{
			$(this.wrapperClass).imagesLoaded( $.proxy( function() {
				this._gridLayoutMatchHeight();
			}, this ) );

			$( window ).on( 'resize', $.proxy( this._gridLayoutMatchHeight, this ) );
		},

		_gridLayout: function()
		{
			var wrap = $(this.wrapperClass);

			wrap.masonry({
				columnWidth         : this.nodeClass + ' .pp-custom-grid-sizer',
				gutter              : parseInt(this.settings.postSpacing),
				isFitWidth          : true,
				itemSelector        : this.postClass,
				transitionDuration  : 0
			});

			wrap.imagesLoaded( $.proxy( function() {
				this._gridLayoutRemoveHeight();
				wrap.masonry();
			}, this ) );
		},

		_gridLayoutRemoveHeight: function()
		{
			$(this.nodeClass + ' .pp-custom-grid-post').css('height', 'auto');
		},

		_gridLayoutMatchHeight: function()
		{
			var highestBox = 0;

			if ( 0 === this.matchHeight ) {
				this._gridLayoutRemoveHeight();
				return;
			}

            $(this.nodeClass + ' .pp-custom-grid-post').css('height', '').each(function(){

                if($(this).height() > highestBox) {
                	highestBox = $(this).height();
                }
            });

            $(this.nodeClass + ' .pp-custom-grid-post').height(highestBox);
		},

		_initInfiniteScroll: function()
		{
			if(this.settings.pagination == 'scroll' && typeof FLBuilder === 'undefined') {
				this._infiniteScroll();
			}
		},

		_infiniteScroll: function(settings)
		{
			$(this.wrapperClass).infinitescroll({
				navSelector     : this.nodeClass + ' .pp-custom-grid-pagination',
				nextSelector    : this.nodeClass + ' .pp-custom-grid-pagination a.next',
				itemSelector    : this.postClass,
				prefill         : true,
				bufferPx        : 200,
				loading         : {
					msgText         : 'Loading',
					finishedMsg     : '',
					img             : FLBuilderLayoutConfig.paths.pluginUrl + 'img/ajax-loader-grey.gif',
					speed           : 1
				}
			}, $.proxy(this._infiniteScrollComplete, this));

			setTimeout(function(){
				$(window).trigger('resize');
			}, 100);
		},

		_infiniteScrollComplete: function(elements)
		{
			var wrap = $(this.wrapperClass);

			elements = $(elements);

			if(this.settings.layout == 'columns') {
				wrap.imagesLoaded( $.proxy( function() {
					this._gridLayoutMatchHeight();
					elements.css('visibility', 'visible');
				}, this ) );
			}
			else if(this.settings.layout == 'grid') {
				wrap.imagesLoaded( $.proxy( function() {
					wrap.masonry('appended', elements);
					elements.css('visibility', 'visible');
				}, this ) );
			}
		}
	};

})(jQuery);
