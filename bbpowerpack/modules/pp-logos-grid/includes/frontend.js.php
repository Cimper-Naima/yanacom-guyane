<?php $padding = $settings->logo_grid_padding_top + $settings->logo_grid_padding_bottom + $settings->logo_grid_padding_left + $settings->logo_grid_padding_right; ?>

(function($) {

	function equalheight() {

		if( window.navigator.userAgent.indexOf( 'MSIE ' ) > 0 ) {
			return;
		}

		var maxHeight = 0;
		$('.fl-node-<?php echo $id; ?> .pp-logos-wrapper .pp-logo').each(function(index) {
			if(($(this).find('.logo-image').outerHeight() + <?php echo $padding; ?>) > maxHeight) {
				maxHeight = $(this).find('.logo-image').outerHeight() + <?php echo $padding; ?>;
			}
		});
		$('.fl-node-<?php echo $id; ?> .pp-logos-wrapper .pp-logo').css('height', maxHeight + 'px');

		<?php if ( $settings->logos_layout == 'carousel' && $settings->logo_slider_transition == 'fade' ) { ?>
		if($(window).width() <= 768 ){
			$('.fl-node-<?php echo $id; ?> .pp-logos-wrapper .pp-logo').each(function(index) {
				//$(this).css('height', $('.fl-node-<?php echo $id; ?> .pp-logos-content').outerHeight() + 'px');
			});
		}
		<?php } ?>
		return maxHeight;
	}

	$('.fl-node-<?php echo $id; ?> .pp-logos-wrapper').imagesLoaded(function() {
	<?php if( $settings->logos_layout == 'carousel' ) { ?>
		// Clear the controls in case they were already created.
		$('.fl-node-<?php echo $id; ?> .logo-slider-next').empty();
		$('.fl-node-<?php echo $id; ?> .logo-slider-prev').empty();

		var minSlides = ($(window).width() <= 768) ? parseInt($('.fl-node-<?php echo $id; ?>').width() / <?php echo $settings->logo_carousel_width + ($settings->logos_carousel_spacing * ($settings->logo_carousel_minimum_grid - 1)); ?>) : <?php echo $settings->logo_carousel_minimum_grid; ?>;

		<?php if ( isset( $settings->logo_carousel_minimum_grid_medium ) && ! empty( $settings->logo_carousel_minimum_grid_medium ) ) { ?>
		if ( window.innerWidth <= <?php echo $global_settings->medium_breakpoint; ?> ) {
			minSlides = <?php echo $settings->logo_carousel_minimum_grid_medium; ?>;
		}
		<?php } ?>
		<?php if ( isset( $settings->logo_carousel_minimum_grid_responsive ) && ! empty( $settings->logo_carousel_minimum_grid_responsive ) ) { ?>
		if ( window.innerWidth <= <?php echo $global_settings->responsive_breakpoint; ?> ) {
			minSlides = <?php echo $settings->logo_carousel_minimum_grid_responsive; ?>;
		}
		<?php } ?>

		minSlides = (minSlides === 0) ? 1 : minSlides;

		var maxSlides = minSlides;
		var moveSlides = maxSlides;

		<?php if ( isset( $settings->logo_carousel_move_slide ) && ! empty( $settings->logo_carousel_move_slide ) ) { ?>
			moveSlides = <?php echo $settings->logo_carousel_move_slide; ?>;
		<?php } ?>

		var totalSlides = minSlides - 1;

		<?php if ( $settings->logo_slider_transition == 'fade' ) { ?>
		var min_<?php echo $id; ?> = minSlides;
		$('.fl-node-<?php echo $id; ?> .pp-logos-wrapper .pp-logo').each(function(index) {
			//$(this).css('width', 'calc((100% - '+totalSlides * <?php echo $settings->logos_carousel_spacing; ?>+'px) /'+ minSlides + ')');
			$(this).css('width', 'calc((100% - '+totalSlides * <?php echo $settings->logos_carousel_spacing; ?>+'px) /'+ minSlides + ')');
			//$(this).css('width', '<?php echo $settings->logo_carousel_width; ?>px');
			if(index % min_<?php echo $id; ?> == 0) {
	    		$(this).before('<div class="slide-group clearfix"></div>');
			}
			$(this).appendTo($(this).prev());
		});
		$('.fl-node-<?php echo $id; ?> .pp-logos-wrapper .slide-group .pp-logo:nth-of-type('+minSlides+'n)').css('margin-right', 0);
		<?php } ?>

		<?php if ( $settings->equal_height == 'yes' ) { ?>
		//equalheight();
		<?php } ?>

		// Create the slider.
		$('.fl-node-<?php echo $id; ?> .pp-logos-wrapper').bxSlider({
			<?php if ( $settings->logo_slider_transition != 'fade' ) { ?>
	        slideWidth: <?php echo $settings->logo_carousel_width; ?>,
			<?php } ?>
			moveSlides: moveSlides,
			slideMargin: <?php echo $settings->logos_carousel_spacing; ?>,
	        minSlides: minSlides,
	        maxSlides: maxSlides,
			autoStart : <?php echo $settings->logo_slider_auto_play ?>,
			auto : true,
			autoHover: <?php echo $settings->logo_slider_pause_hover; ?>,
			adaptiveHeight: false,
			pause : <?php echo $settings->logo_slider_pause * 1000; ?>,
			mode : '<?php echo $settings->logo_slider_transition; ?>',
			speed : <?php echo $settings->logo_slider_speed * 1000;  ?>,
			pager : <?php echo $settings->logo_slider_dots; ?>,
			nextSelector : '.fl-node-<?php echo $id; ?> .logo-slider-next',
			prevSelector : '.fl-node-<?php echo $id; ?> .logo-slider-prev',
			nextText: '<i class="fa fa-chevron-circle-right"></i>',
			prevText: '<i class="fa fa-chevron-circle-left"></i>',
			controls : <?php echo $settings->logo_slider_arrows; ?>,
			onSliderLoad: function() {
				$('.fl-node-<?php echo $id; ?> .pp-logos-wrapper').addClass('pp-logos-wrapper-loaded');
			}
		});

	<?php } ?>

	<?php if( $settings->logos_layout == 'carousel' ) { ?>

		<?php if ( $settings->logo_slider_transition != 'fade' ) { ?>
		if($(window).width() <= 768 ){
			$('.fl-node-<?php echo $id; ?> .pp-logos-wrapper .pp-logo').each(function(index) {
				//$(this).css('height', $(this).css('width'));
			});
			//$('.fl-node-<?php echo $id; ?> .bx-viewport').css('height', $('.fl-node-<?php echo $id; ?> .pp-logos-wrapper').outerHeight() + 'px');
		}
		<?php } ?>
		<?php if ( $settings->logo_slider_transition == 'fade' ) { ?>
		if($(window).width() <= 768 ){
			var viewport_h = $('.fl-node-<?php echo $id; ?> .bx-viewport').outerHeight();
			$('.fl-node-<?php echo $id; ?> .pp-logos-wrapper .pp-logo').css('height', viewport_h + 'px');
			//$('.fl-node-<?php echo $id; ?> .bx-viewport, .fl-node-<?php echo $id; ?> .pp-logos-wrapper .pp-logo').css('height', $('.fl-node-<?php echo $id; ?> .pp-logos-content').outerHeight() + 20 + 'px');
		}
		<?php } ?>

	<?php } ?>

	<?php if ( $settings->logos_layout !== 'carousel' && $settings->equal_height == 'yes' ) { ?>
	//equalheight();
	<?php } ?>

	});

})(jQuery);
