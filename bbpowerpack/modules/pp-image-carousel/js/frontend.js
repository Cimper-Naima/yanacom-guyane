;(function ($) {

    PPImageCarousel = function (settings) {
        this.id = settings.id;
        this.nodeClass = '.fl-node-' + settings.id;
		this.wrapperClass = this.nodeClass + ' .pp-image-carousel';
		this.elements = '';
        this.slidesPerView = settings.slidesPerView;
        this.slidesToScroll = settings.slidesToScroll;
		this.settings = settings;
		this.swipers = {};

        if (this._isSlideshow()) {
            this.slidesPerView = settings.slideshow_slidesPerView;
		}
		
		if ( typeof Swiper === 'undefined' ) {
			$(window).on('load', $.proxy(function() {
				if ( typeof Swiper === 'undefined' ) {
					return;
				} else {
					this._init();
				}
			}, this) );
		} else {
			this._init();
		}
    };

    PPImageCarousel.prototype = {
        id: '',
        nodeClass: '',
        wrapperClass: '',
        elements: '',
        slidesPerView: {},
        slidesToScroll: {},
        settings: {},
        swipers: {},

        _init: function () {
            this.elements = {
                mainSwiper: this.nodeClass + ' .pp-image-carousel'
            };

            this.elements.swiperSlide = $(this.elements.mainSwiper).find('.swiper-slide');
            this.elements.thumbSwiper = this.nodeClass + ' .pp-thumbnails-swiper';

            if (1 >= this._getSlidesCount()) {
                return;
            }

            var swiperOptions = this._getSwiperOptions();

            this.swipers.main = new Swiper(this.elements.mainSwiper, swiperOptions.main);

            if (this._isSlideshow()) {
                this.swipers.main.controller.control = this.swipers.thumbs = new Swiper(this.elements.thumbSwiper, swiperOptions.thumbs);
                this.swipers.thumbs.controller.control = this.swipers.main;
            }
		},
		
		_getEffect: function() {
			return this.settings.effect;
		},

        _getSlidesCount: function () {
            return this.elements.swiperSlide.length;
        },

        _getInitialSlide: function () {
            return this.settings.initialSlide;
        },

        _getSpaceBetween: function () {
            var space = this.settings.spaceBetween.desktop,
                space = parseInt(space);

            if ( isNaN( space ) ) {
                space = 20;
            }

            return space;
        },

        _getSpaceBetweenTablet: function () {
            var space = this.settings.spaceBetween.tablet,
                space = parseInt(space);

            if ( isNaN(space) ) {
                space = this._getSpaceBetween();
            }

            return space;
        },

        _getSpaceBetweenMobile: function () {
            var space = this.settings.spaceBetween.mobile,
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

			var slidesPerView = this.slidesPerView.desktop;

            return Math.min(this._getSlidesCount(), +slidesPerView);
        },

        _getSlidesPerViewTablet: function () {
			if ( this._isSlideshow() ) {
				return 1;
			}

			var slidesPerView = this.slidesPerView.tablet;

			if (slidesPerView === '' || slidesPerView === 0) {
				slidesPerView = this.slidesPerView.desktop
			}

			if (!slidesPerView && 'coverflow' === this.settings.type) {
				return Math.min(this._getSlidesCount(), 3);
			}

			return Math.min(this._getSlidesCount(), +slidesPerView);
        },

        _getSlidesPerViewMobile: function () {
			if ( this._isSlideshow() ) {
				return 1;
			}

			var slidesPerView = this.slidesPerView.mobile;

			if (slidesPerView === '' || slidesPerView === 0) {
				slidesPerView = this._getSlidesPerViewTablet();
			}

			if (!slidesPerView && 'coverflow' === this.settings.type) {
				return Math.min(this._getSlidesCount(), 3);
			}

			return Math.min(this._getSlidesCount(), +slidesPerView);
		},

		_getThumbsSlidesPerView: function () {
			var slidesPerView = this.slidesPerView.desktop;

            return Math.min(this._getSlidesCount(), +slidesPerView);
        },

        _getThumbsSlidesPerViewTablet: function () {
			var slidesPerView = this.slidesPerView.tablet;

			if (slidesPerView === '' || slidesPerView === 0) {
				slidesPerView = this.slidesPerView.desktop
			}

			if (!slidesPerView && 'coverflow' === this.settings.type) {
				return Math.min(this._getSlidesCount(), 3);
			}

			return Math.min(this._getSlidesCount(), +slidesPerView);
        },

        _getThumbsSlidesPerViewMobile: function () {
			var slidesPerView = this.slidesPerView.mobile;

			if (slidesPerView === '' || slidesPerView === 0) {
				slidesPerView = this._getSlidesPerViewTablet();
			}

			if (!slidesPerView && 'coverflow' === this.settings.type) {
				return Math.min(this._getSlidesCount(), 3);
			}

			return Math.min(this._getSlidesCount(), +slidesPerView);
		},
		
		_getSlidesToScroll: function(device) {
			if ( ! this._isSlideshow() && 'slide' === this._getEffect() ) {
				var slides = this.slidesToScroll[device];

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
            var medium_breakpoint = this.settings.breakpoint.medium,
				responsive_breakpoint = this.settings.breakpoint.responsive;
				nodeClass = this.nodeClass;

            var options = {
				navigation: {
					prevEl: nodeClass + ' .pp-swiper-button-prev',
					nextEl: nodeClass + ' .pp-swiper-button-next'
				},
				pagination: {
					el: nodeClass + ' .swiper-pagination',
					type: this.settings.pagination,
					clickable: true
				},
				grabCursor: true,
                effect: this._getEffect(),
                initialSlide: this._getInitialSlide(),
                slidesPerView: this._getSlidesPerView(),
                slidesPerGroup: this._getSlidesToScrollDesktop(),
                spaceBetween: this._getSpaceBetween(),
                loop: true,
                loopedSlides: this._getSlidesCount(),
                speed: this.settings.speed,
                breakpoints: {}
			};
			
			if ( ! this.settings.isBuilderActive && this.settings.autoplay_speed !== false ) {
				options.autoplay = {
					delay: this.settings.autoplay_speed,
					disableOnInteraction: !!this.settings.pause_on_interaction
				};
			}
			
			if ('cube' !== this._getEffect() && 'fade' !== this._getEffect()) {
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
			}

            var thumbsSliderOptions = {
                slidesPerView: this._getThumbsSlidesPerView(),
                initialSlide: this._getInitialSlide(),
                centeredSlides: true,
                slideToClickedSlide: true,
                spaceBetween: this._getSpaceBetween(),
                loop: true,
                loopedSlides: this._getSlidesCount(),
                speed: this.settings.speed,
                onSlideChangeEnd: function (swiper) {
                    swiper.fixLoop();
                },
                breakpoints: {}
            };

            thumbsSliderOptions.breakpoints[medium_breakpoint] = {
                slidesPerView: this._getThumbsSlidesPerViewTablet(),
                spaceBetween: this._getSpaceBetweenTablet()
            };
            thumbsSliderOptions.breakpoints[responsive_breakpoint] = {
                slidesPerView: this._getThumbsSlidesPerViewMobile(),
                spaceBetween: this._getSpaceBetweenMobile()
            };

            if ('coverflow' === this.settings.type) {
                options.effect = 'coverflow';
            }

            if (this._isSlideshow()) {
                options.slidesPerView = 1;

                delete options.pagination;
                delete options.breakpoints;
            }

            return {
                main: options,
                thumbs: thumbsSliderOptions
            };
        },

        _isSlideshow: function () {
            return 'slideshow' === this.settings.type;
        },

        _onElementChange: function (property) {
            if (0 === property.indexOf('width')) {
                this.swipers.main.onResize();
            }

            if (0 === property.indexOf('spaceBetween')) {
                this._updateSpaceBetween(this.swipers.main, property);
            }
        },

        _updateSpaceBetween: function (swiper, property) {
            var newSpaceBw = this._getSpaceBetween(),
                deviceMatch = property.match('space_between_(.*)');

            if (deviceMatch) {
                var breakpoints = {
                    tablet: this.settings.breakpoint.medium,
                    mobile: this.settings.breakpoint.responsive
                };

                swiper.params.breakpoints[breakpoints[deviceMatch[1]]].spaceBetween = newSpaceBw;
            } else {
                swiper.originalParams.spaceBetween = newSpaceBw;
            }

            swiper.params.spaceBetween = newSpaceBw;

            swiper.onResize();
        },
    };

})(jQuery);