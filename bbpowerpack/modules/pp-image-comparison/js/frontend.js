; (function ($) {

	PPImageComparison = function (settings) {
		this.id 				= settings.id;
		this.node 				= $('.fl-node-' + this.id);
		this.container 			= this.node.find('.pp-image-comp-inner'),
		this.beforeLabel		= settings.beforeLabel,
		this.afterLabel			= settings.afterLabel,
		this.visibleRatio		= settings.visibleRatio,
		this.imgOrientation		= settings.imgOrientation,
		this.sliderHandle		= settings.sliderHandle,
		this.sliderHover		= settings.sliderHover,
		this.sliderClick		= settings.sliderClick,
		this.isBuilderActive	= settings.isBuilderActive;

		this._init();
	};

	PPImageComparison.prototype = {
		_init: function () {
			var self = this;
			self.container.imagesLoaded(function() {
				self.container.twentytwenty({
					default_offset_pct: 	self.visibleRatio,
					orientation: 			self.imgOrientation,
					before_label: 			self.beforeLabel,
					after_label: 			self.afterLabel,
					move_with_handle_only: 	self.sliderHandle,
					move_slider_on_hover: 	self.sliderHover,
					click_to_move: 			self.sliderClick,
				});
			});
		},

	}
})(jQuery);