;(function($) {
<?php if( $settings->post_timeline_layout == 'horizontal' ) { ?>
$('.fl-node-<?php echo $id; ?>').imagesLoaded(function() {
	$( '.pp-post-timeline-slide-navigation' ).each(function( index ) {

		var sconf       	= {};
		var slider_id   	= $(this).attr('id');
		var slider_nav_id 	= $(this).attr('post-timeline-slider-nav-for');
		var nav_id			= '';

		// For Navigation
		if( typeof(slider_nav_id) != 'undefined' && slider_nav_id != '' ) {
			nav_id = '.'+slider_nav_id;
		}

		if( typeof(slider_id) != 'undefined' && slider_id != '' ) {

			jQuery('.'+slider_nav_id).slick({
				<?php echo ( $settings->slider_pagination == 'yes' ) ? 'dots: true' : 'dots: false'; ?>,
				arrows			: false,
				asNavFor 		: '#'+slider_id,
				slidesToShow 	: <?php echo ( $settings->slide_columns >= 0 && $settings->slide_columns != '' ) ? $settings->slide_columns : '3'; ?>,
				slidesToScroll 	: 1,
				<?php echo ( $settings->auto_play == 'yes' ) ? 'autoplay: true' : 'autoplay: false'; ?>,
				<?php echo ( $settings->stop_on_hover == 'yes' ) ? 'pauseOnHover: true' : 'pauseOnHover: false'; ?>,
				speed			: <?php echo $settings->transition_speed; ?>,
				responsive 		: [
					{
						breakpoint: <?php echo $global_settings->medium_breakpoint; ?>,
						settings: {
							<?php if ( $settings->slide_columns_medium != '' ) { ?>slidesToShow: <?php echo $settings->slide_columns_medium; ?>,<?php } ?>
						}
					},
					{
						breakpoint: <?php echo $global_settings->responsive_breakpoint; ?>,
						settings: {
							<?php if ( $settings->slide_columns_responsive != '' ) { ?>slidesToShow: <?php echo $settings->slide_columns_responsive; ?>,<?php } ?>
						}
					}
				]
			});
		}

		// For Navigation
		if( typeof(slider_nav_id) != 'undefined' ) {

			jQuery('#'+slider_id).slick({
				dots			: false,
				<?php echo ( $settings->slider_navigation == 'yes' ) ? 'arrows: true' : 'arrows: false'; ?>,
				prevArrow		: '<span class="slick-prev fa fa-angle-left"></span>',
				nextArrow		: '<span class="slick-next fa fa-angle-right"></span>',
				speed			: <?php echo $settings->transition_speed; ?>,
				asNavFor 		: nav_id,
				slidesToShow 	: <?php echo ( $settings->slide_columns >= 0 && $settings->slide_columns != '' ) ? $settings->slide_columns : '3'; ?>,
				slidesToScroll 	: 1,
				<?php echo ( $settings->auto_play == 'yes' ) ? 'autoplay: true' : 'autoplay: false'; ?>,
				<?php echo ( $settings->stop_on_hover == 'yes' ) ? 'pauseOnHover: true' : 'pauseOnHover: false'; ?>,
				focusOnSelect 	: true,
				centerPadding 	: '10px',
				responsive 		: [
					{
						breakpoint: <?php echo $global_settings->medium_breakpoint; ?>,
						settings: {
							<?php if ( $settings->slide_columns_medium != '' ) { ?>slidesToShow: <?php echo $settings->slide_columns_medium; ?>,<?php } ?>
						}
					},
					{
						breakpoint: <?php echo $global_settings->responsive_breakpoint; ?>,
						settings: {
							<?php if ( $settings->slide_columns_responsive != '' ) { ?>slidesToShow: <?php echo $settings->slide_columns_responsive; ?>,<?php } ?>
						}
					}
				]
			});
		}
	});

	$('.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper').each(function(){

		// Cache the highest box height
		var highestBox = 0;

		$('.pp-post-timeline-item', this).each(function(){

			if ( $(this).height() > highestBox ) {
				highestBox = $(this).height();
			}

		});

		// Set the height of all those children to whichever was highest
		$('.pp-post-timeline-item',this).height(highestBox);

	});
});
<?php } ?>
})(jQuery);
