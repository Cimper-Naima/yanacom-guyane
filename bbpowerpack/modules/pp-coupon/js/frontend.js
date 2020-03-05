; (function ($) {

	PPCoupon = function (settings) {
		this.id 			= settings.id;
		this.couponStyle 	= settings.coupon_style;
		this.couponCode 	= settings.coupon_code;
		this.node 			= $('.fl-node-' + this.id);

		this._init();
	};

	PPCoupon.prototype = {
		_init: function () {
			var self = this;
			self.node.find('.pp-coupon-code').not('.pp-copied').on('click', function(){
				var clicked = $(this);
				var tempInput = '<input type="text" value="' + self.couponCode + '" id="ppCouponInput">';

				clicked.append(tempInput);

				var copyText = document.getElementById("ppCouponInput");
				copyText.select();
				document.execCommand("copy");
				$('#ppCouponInput').remove();
				
				if ('copy' === self.couponStyle) {
					clicked.addClass('pp-copied');
					clicked.find('.pp-coupon-copy-text').fadeOut().text('Copied').fadeIn();
				} else {
					
					clicked.find('.pp-coupon-reveal-wrap').css({
						'transform': 'translate(200px, 0px)',
					});

					setTimeout(function () {
						clicked.find('.pp-coupon-code-text-wrap').removeClass('pp-unreavel');
						clicked.find('.pp-coupon-code-text').text(self.couponCode);
						clicked.find('.pp-coupon-reveal-wrap').remove();
					}, 150);

					setTimeout(function () {
						clicked.addClass('pp-copied');
						clicked.find('.pp-coupon-copy-text').fadeOut().text('Copied').fadeIn();
					}, 500);
				}
			});

		},
	};

}) (jQuery);