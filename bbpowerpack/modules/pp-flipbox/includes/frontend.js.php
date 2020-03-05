(function($) {

	function is_touch_device() {
		return (('ontouchstart' in window)
			|| (navigator.MaxTouchPoints > 0)
			|| (navigator.msMaxTouchPoints > 0));
	}

	$(window).on('load', function() {
		if ( ! is_touch_device() ) {
			$('.fl-node-<?php echo $id; ?> .pp-flipbox-container').on('mouseenter', function(e) {
				e.preventDefault();
				$(this).addClass('pp-hover');
			});
			$('.fl-node-<?php echo $id; ?> .pp-flipbox-container').on('mouseleave', function(e) {
				e.preventDefault();
				$(this).removeClass('pp-hover');
			});
		}

		$('.fl-node-<?php echo $id; ?> .pp-flipbox-container').on('click', function(e) {
			$(this).toggleClass('pp-hover');
		});

		<?php if ( $settings->box_height != 'custom' ) : ?>

		if( $('.fl-node-<?php echo $id; ?> .pp-flipbox-front').outerHeight() > $('.fl-node-<?php echo $id; ?> .pp-flipbox-back').outerHeight() ) {
			$('.fl-node-<?php echo $id; ?> .pp-flipbox-back').css( 'height', $('.fl-node-<?php echo $id; ?> .pp-flipbox-front').outerHeight() + 'px' );
		}
		else {
			$('.fl-node-<?php echo $id; ?> .pp-flipbox-front').css( 'height', $('.fl-node-<?php echo $id; ?> .pp-flipbox-back').outerHeight() + 'px' );
		}

		<?php endif; ?>
	});

})(jQuery);
