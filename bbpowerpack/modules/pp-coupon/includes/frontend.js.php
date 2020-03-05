;(function($) {
	new PPCoupon({
		id: '<?php echo $id; ?>',
		coupon_style: '<?php echo $settings->coupon_style; ?>',
		coupon_code: '<?php echo $settings->coupon_code; ?>',
	});

})(jQuery);
