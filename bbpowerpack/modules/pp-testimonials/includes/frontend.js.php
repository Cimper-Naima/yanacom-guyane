(function($) {
<?php if ( count($settings->testimonials) > 1 ) : ?>
	// Clear the controls in case they were already created.
	$('.fl-node-<?php echo $id; ?> .pp-arrow-wrapper .pp-slider-next').empty();
	$('.fl-node-<?php echo $id; ?> .pp-arrow-wrapper .pp-slider-prev').empty();

	if( $(window).width() > 767 ) {
		<?php $responsive = 0; ?>
	}
	else {
		<?php $responsive = 1; ?>
	}

	// Create the slider.
	var sliderOptions = {
		auto : true,
		autoStart : <?php echo $settings->autoplay; ?>,
		autoHover : <?php echo $settings->hover_pause; ?>,
		<?php echo $settings->adaptive_height == 'no' ? 'adaptiveHeight: true' : 'adaptiveHeight: false'; ?>,
		pause : <?php echo $settings->pause * 1000; ?>,
		mode : '<?php echo $settings->transition; ?>',
		speed : <?php echo $settings->speed * 1000;  ?>,
		infiniteLoop : <?php echo $settings->loop;  ?>,
		pager : <?php echo $settings->dots; ?>,
		nextSelector : '.fl-node-<?php echo $id; ?> .pp-arrow-wrapper .pp-slider-next',
		prevSelector : '.fl-node-<?php echo $id; ?> .pp-arrow-wrapper .pp-slider-prev',
		nextText: '<i class="fa fa-chevron-circle-right"></i>',
		prevText: '<i class="fa fa-chevron-circle-left"></i>',
		controls : <?php echo $settings->arrows; ?>,
		onSliderLoad: function() {
			$('.fl-node-<?php echo $id; ?> .pp-testimonials').addClass('pp-testimonials-loaded');
		}
	};
	var carouselOptions = {
		minSlides : <?php echo ($settings->carousel == 1) ? $settings->min_slides : 1; ?>,
		maxSlides : <?php echo ($settings->carousel == 1) ? $settings->max_slides : 1; ?>,
		moveSlides : <?php echo ($settings->carousel == 1) ? $settings->move_slides : 1; ?>,
		<?php if ( $settings->carousel == 1 ) { ?>
			<?php if ( ! empty( $settings->slide_width ) ) { ?>
				slideWidth : <?php echo $settings->slide_width; ?>,
			<?php } else { ?>
				slideWidth : 0,
			<?php } ?>
		<?php } else { ?>
			slideWidth : 0,
		<?php } ?>
		slideMargin : <?php echo ($settings->carousel == 1) ? $settings->slide_margin : 0; ?>,
	};
	if($(window).width() <= 768) {
		var carouselOptions = {
			minSlides : 1,
			maxSlides : 1,
			moveSlides : 1,
			slideWidth : 0,
			slideMargin : 0,
		};
	}

	$(window).on('load', function() {
		$('.fl-node-<?php echo $id; ?> .pp-testimonials').bxSlider($.extend({}, sliderOptions, carouselOptions));
	});
<?php endif; ?>
})(jQuery);
