;(function( $ ) {

	PPVideoGallery = function( settings ) {
		this.id				= settings.id;
		this.layout 		= settings.layout;
		this.aspectRatio 	= settings.aspectRatio;
		this.filters		= settings.filters;
		this.carousel		= settings.carousel;
		this.isBuilderActive = settings.isBuilderActive;
		this.nodeClass 		= '.fl-node-' + this.id;
		this.itemClass		= this.nodeClass + ' .pp-video-gallery-item';
		this.elements		= {};
		this.swiper			= {};
		this.lightboxWrap	= '<div class="pp-aspect-ratio-'+this.aspectRatio+'"></div>';
		this.lightboxData	= [];
		this.activeIndex	= false;

		this._init();
	};

	PPVideoGallery.prototype = {
		_init: function() {
			this.elements = {
				node: $(this.nodeClass),
				wrap: $(this.nodeClass).find('.pp-video-gallery-items'),
				items: '',
			};

			this._initVideo();

			if ( 'gallery' === this.layout ) {
				// Initialize the gallery.
				this._initGallery();
			} else {
				// Initialize the carousel.
				if ( typeof Swiper === 'undefined' ) {
					$(window).on('load', $.proxy(function() {
						if ( typeof Swiper === 'undefined' ) {
							return;
						} else {
							this._initCarousel();
						}
					}, this) );
				} else {
					this._initCarousel();
				}
			}
		},

		_initVideo: function() {
			var self = this;
			
			this.lightboxData = [];

			this._getItems();

			this.elements.items.each( function() {
				var $item = $(this);

				if ( $(this).find( '.pp-video-image-overlay' ).length > 0 ) {
					$(this).find( '.pp-video-image-overlay' ).off('click');
					self._stopIframeAutoplay($item);
					
					if ( $item.find('.pp-video-lightbox-content').length > 0 ) {
						var data = {
							src: $(self.lightboxWrap).html( $item.find('.pp-video-lightbox-content').html() ),
							type: 'html',
							opts: {
								slideClass: 'pp-video-slide-' + $item.index()
							}
						};
		
						self.lightboxData.push( data );
					}
				}
			} );

			this._bindEvents();
		},

		_initGallery: function() {
			if ( this.filters ) {
				this._initFilters();
			}
		},

		_initCarousel: function() {
			this.elements.swiper = this.nodeClass + ' .swiper-container';

			this.elements.swiperSlide = $(this.elements.swiper).find('.swiper-slide');
			
			if (1 >= this._getSlidesCount()) {
                return;
			}
			
			this.swiper = new Swiper(this.elements.swiper, this._getSwiperOptions());
		},

		_bindEvents: function() {
			this.elements.items.find('.pp-video-image-overlay').off('click');
			this.elements.items.find('.pp-video-image-overlay').on('click', $.proxy(function(e) {
				e.stopPropagation();

				var $item = $(e.target).parents('.pp-video-gallery-item');
				
				this.activeIndex = $item.index();

				if ( $item.find('.pp-video-lightbox-content').length > 0 ) {
					this._initLightbox($item);
				} else {
					this._inlinePlay($item);
				}
			}, this));
		},

		_initLightbox: function($item) {

			//$.fancybox.open($('<div class="'+wrapperClasses+'"></div>').html( $item.find('.pp-video-lightbox-content').html() ), options);
			$.fancybox.open( this.lightboxData, this._getLightboxOptions(), this.activeIndex );
		},

		_getLightboxOptions: function() {
			var self = this;
			var id = this.id;
			var options = {
				modal			: false,
				baseClass		: 'pp-video-gallery-fancybox fancybox-' + id,
				buttons			: [
					'close'
				],
				wheel			: false,
				defaultType		: 'html',
				animationEffect	: 'fade',
				touch			: false,
				afterLoad		: function(current, previous) {
					$('.fancybox-' + id).find('.fancybox-bg').addClass('fancybox-' + id + '-overlay');
				}
			};

			return options;
		},

		_inlinePlay: function($item) {
			// Stop autoplay from all iframes.
			$item.parents('.pp-video-gallery-items').find( '.pp-video-has-overlay' ).each(function() {
				if ( $(this).find('.pp-video-iframe').length > 0 ) {
					$(this).find('.pp-video-iframe')[0].src = $(this).find('.pp-video-iframe')[0].src.replace('&autoplay=1', '');
					$(this).find('.pp-video-iframe')[0].src = $(this).find('.pp-video-iframe')[0].src.replace('autoplay=1', '');
				}
			});

			$item.find( '.pp-video-image-overlay' ).fadeOut(800, function() {
				this.remove();
			});

			if ( $item.find( '.pp-video' ).length > 0 ) {
				$item.find( '.pp-video' )[0].play();

				return;
			}

			if ( $item.find( '.pp-video-iframe' ).length > 0 ) {
				var iframeSrc = $item.find( '.pp-video-iframe' )[0].src.replace('&autoplay=0', '');
				iframeSrc = iframeSrc.replace('autoplay=0', '');
				
				var src = iframeSrc.split('#');
				iframeSrc = src[0] + '&autoplay=1';
				
				if ( 'undefined' !== typeof src[1] ) {
					iframeSrc += '#' + src[1];
				}
				$item.find( '.pp-video-iframe' )[0].src = iframeSrc;
			}
		},

		_initFilters: function() {
			var filterData = {
				itemSelector: '.pp-video-gallery-item',
				percentPosition: true,
				transitionDuration: '0.6s',
			};
			filterData = $.extend( {}, filterData, {
				layoutMode: 'fitRows',
				fitRows: {
					gutter: '.pp-video-gallery--spacer'
				},
			} );

			var filters = this.elements.wrap.isotope( filterData );
			var filtersWrap = this.elements.node.find( '.pp-video-gallery-filters' );

			this.elements.wrap.imagesLoaded( $.proxy( function() {
				filtersWrap.on('click', '.pp-video-gallery-filter', function() {
					var filterVal = $(this).attr('data-filter');
                    filters.isotope({ filter: filterVal });

					filtersWrap.find('.pp-video-gallery-filter').removeClass('pp-filter--active');
					$(this).addClass('pp-filter--active');
				});
			}, this ) );
		},

		_stopIframeAutoplay: function($item) {
			if ( $item.find( '.pp-video-iframe' ).length > 0 ) {
				$item.find( '.pp-video-iframe' )[0].src = $item.find( '.pp-video-iframe' )[0].src.replace('&autoplay=1', '');
				$item.find( '.pp-video-iframe' )[0].src = $item.find( '.pp-video-iframe' )[0].src.replace('autoplay=1', '');
			}
		},

		_getItems: function() {
			this.elements.items = $(this.itemClass);
			return this.elements.items;
		},

		_isSlideshow: function() {
			return false;
		},

		_getEffect: function() {
			return this.carousel.effect;
		},

        _getSlidesCount: function () {
            return this.elements.swiperSlide.length;
        },

        _getInitialSlide: function () {
            return this.carousel.initialSlide;
        },

        _getSpaceBetween: function () {
            var space = this.carousel.spaceBetween.desktop,
                space = parseInt(space);

            if ( isNaN( space ) ) {
                space = 20;
            }

            return space;
        },

        _getSpaceBetweenTablet: function () {
            var space = this.carousel.spaceBetween.tablet,
                space = parseInt(space);

            if ( isNaN(space) ) {
                space = this._getSpaceBetween();
            }

            return space;
        },

        _getSpaceBetweenMobile: function () {
            var space = this.carousel.spaceBetween.mobile,
                space = parseInt(space);

            if ( isNaN(space) ) {
                space = this._getSpaceBetweenTablet();
            }

            return space;
        },

        _getSlidesPerView: function () {
			if ( this._isSlideshow() ) {
				return 1;
			}

			var slidesPerView = this.carousel.slidesPerView.desktop;

            return Math.min(this._getSlidesCount(), +slidesPerView);
        },

        _getSlidesPerViewTablet: function () {
			if ( this._isSlideshow() ) {
				return 1;
			}

			var slidesPerView = this.carousel.slidesPerView.tablet;

			if (slidesPerView === '' || slidesPerView === 0) {
				slidesPerView = this._getSlidesPerView();
			}

			return Math.min(this._getSlidesCount(), +slidesPerView);
        },

        _getSlidesPerViewMobile: function () {
			if ( this._isSlideshow() ) {
				return 1;
			}

			var slidesPerView = this.carousel.slidesPerView.mobile;

			if (slidesPerView === '' || slidesPerView === 0) {
				slidesPerView = this._getSlidesPerViewTablet();
			}

			return Math.min(this._getSlidesCount(), +slidesPerView);
		},
		
		_getSlidesToScroll: function(device) {
			if ( ! this._isSlideshow() && 'slide' === this._getEffect() ) {
				var slides = this.carousel.slidesToScroll[device];

				return Math.min( this._getSlidesCount(), +slides || 1 );
			}

			return 1;
		},

		_getSlidesToScrollDesktop: function() {
			return this._getSlidesToScroll( 'desktop' );
		},

		_getSlidesToScrollTablet: function() {
			return this._getSlidesToScroll( 'tablet' );
		},

		_getSlidesToScrollMobile: function() {
			return this._getSlidesToScroll( 'mobile' );
		},

        _getSwiperOptions: function () {
            var medium_breakpoint = this.carousel.breakpoint.medium,
				responsive_breakpoint = this.carousel.breakpoint.responsive;

            var options = {
				navigation: {
					prevEl: this.nodeClass + ' .pp-video-carousel-nav-prev',
					nextEl: this.nodeClass + ' .pp-video-carousel-nav-next'
				},
				pagination: {
					el: this.nodeClass + ' .swiper-pagination',
					type: this.carousel.pagination,
					clickable: true
				},
				grabCursor: true,
                effect: this._getEffect(),
                initialSlide: this._getInitialSlide(),
                slidesPerView: this._getSlidesPerView(),
                slidesPerGroup: this._getSlidesToScrollDesktop(),
                spaceBetween: this._getSpaceBetween(),
                loop: this.carousel.loop,
                loopedSlides: this._getSlidesCount(),
				speed: this.carousel.speed,
                breakpoints: {}
			};
			
			if ( ! this.isBuilderActive && this.carousel.autoplay ) {
				options.autoplay = this.carousel.autoplay;
			}
			
			options.breakpoints[medium_breakpoint] = {
				slidesPerView: this._getSlidesPerViewTablet(),
				slidesPerGroup: this._getSlidesToScrollTablet(),
				spaceBetween: this._getSpaceBetweenTablet()
			};
			options.breakpoints[responsive_breakpoint] = {
				slidesPerView: this._getSlidesPerViewMobile(),
				slidesPerGroup: this._getSlidesToScrollMobile(),
				spaceBetween: this._getSpaceBetweenMobile()
			};

			options.on = {
				init: this._initVideo.bind(this),
				//imagesReady: this._onResize.bind(this),
				//resize: this._onResize.bind(this)
			};

            return options;
		},
		
		_onResize: function() {
			var element = $(this.elements.swiper);
			element.css( 'height', 'auto' );

			var height = element.height() + element.find('.swiper-pagination').height();
			element.height( (height + 22) );
		}
	};

})(jQuery);