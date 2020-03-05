(function($) {

	PPInfoBanner = function( settings ) {
		this.id		 	= settings.id;
		this.settings 	= settings;
		this.nodeClass	= '.fl-node-' + settings.id;
		this.wrapClass	= this.nodeClass + ' .info-banner-wrap',
		this.imgClass	= this.nodeClass + ' .pp-info-banner-img',
		this.nodeOffset = $(this.nodeClass).offset(),
		this.nodeHeight = $(this.nodeClass).height(),
		this.bannerHeight = $(this.nodeClass).find('.pp-info-banner-content').height(),
		this.animateClass = $(this.wrapClass).data('animation-class'),
		this.imgAnimClass = $(this.nodeClass).find('.pp-info-banner-img').data('animation-class'),
		this.winHeight	= $(window).height();

		if ( $(this.nodeClass).length === 0 ) {
			return;
		}

		this._init();
	};

	PPInfoBanner.prototype = {
		_init: function()
		{
			var nodeOffset 		= this.nodeOffset,
				nodeHeight		= this.nodeHeight,
				bannerHeight 	= this.bannerHeight,
				animateClass	= this.animateClass,
				imgAnimClass	= this.imgAnimClass,
				winHeight		= this.winHeight;

			$(this.nodeClass).find('.banner-link').css('height', bannerHeight + 'px');

			$(window).on('scroll', $.proxy( function() {
				var scrollPos = $(window).scrollTop();

				if ( scrollPos >= nodeOffset.top - ( winHeight - nodeHeight ) ) {
					$(this.wrapClass).addClass(animateClass).css('opacity', 1);
					
					if ( $(this.imgClass).length > 0 && 'undefined' !== typeof this.imgAnimClass ) {
						$(this.imgClass).addClass(imgAnimClass);
					}
				}
			}, this ) );

			if ( 0 >= nodeOffset.top - ( winHeight - nodeHeight ) ) {
				$(this.wrapClass).css('opacity', 1);
			}
		}
	};

})(jQuery);