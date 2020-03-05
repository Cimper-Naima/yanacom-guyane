; (function ($) {

	PPImageScroll = function (settings) {
		this.id 				= settings.id;
		this.node 				= $('.fl-node-' + this.id);
		this.scrollElement 		= this.node.find(".pp-image-scroll-container"),
		this.scrollOverlay 		= this.node.find(".pp-image-scroll-overlay"),
		this.scrollVertical 	= this.node.find(".pp-overlay-vertical"),
		this.imageScroll 		= this.node.find('.pp-image-scroll-image .pp-scroll-image'),

		this.imgHeight 			= settings.imgHeight,
		this.trigger 			= settings.imgTriggerOn,
		this.scrollSpeed 		= settings.scrollSpeed,
		this.direction 			= settings.scrollDir,
		this.reverse 			= settings.reverseDir,
		this.isBuilderActive 	= settings.isBuilderActive,

		this.transformOffset 	= null;
		this._init();
	};

	PPImageScroll.prototype = {
		_init: function () {
			this.__initScroll();
		},
		__initScroll() {
			var self = this;

			if ( "scroll" == self.trigger ) {
				self.scrollElement.addClass("pp-container-scroll");
				self.scrollElement.imagesLoaded(function () {
					self.scrollOverlay.css({ "width": self.imageScroll.width(), "height": self.imageScroll.height() });
				});
				if ("vertical" == self.direction) {
					self.scrollVertical.addClass("pp-image-scroll-ver");
				}
			} else {
				if ('yes' == self.reverse) {
					self.scrollElement.imagesLoaded(function () {
						self.scrollElement.addClass("pp-container-scroll-instant");
						self.__setTransform();
						self.__startTransform();
					});
				}
				if ("vertical" == self.direction) {
					self.scrollVertical.removeClass("pp-image-scroll-ver");
				}
				self.scrollElement.mouseenter(function () {
					self.scrollElement.removeClass("pp-container-scroll-instant");
					self.__setTransform();
					self.reverse === 'yes' ? self.__endTransform() : self.__startTransform();
				});

				self.scrollElement.mouseleave(function () {
					self.reverse === 'yes' ? self.__startTransform() : self.__endTransform();
				});
			}

		},
		__setTransform() {
			if ("vertical" == this.direction) {
				this.transformOffset = this.imageScroll.height() - this.scrollElement.height();
			} else {
				this.transformOffset = this.imageScroll.width() - this.scrollElement.width();
			}
		},

		__startTransform() {
			this.imageScroll.css("transform", ( this.direction == "vertical" ? "translateY" : "translateX") + "( -" + this.transformOffset + "px)");
		},

		__endTransform() {
			this.imageScroll.css("transform", (this.direction == 'vertical' ? "translateY" : "translateX") + "(0px)");
		},

	}
})(jQuery);