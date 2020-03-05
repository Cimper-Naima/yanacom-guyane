<?php
$slides_to_scroll = $slides_to_scroll_tablet = $slides_to_scroll_mobile = 1;
if ( isset( $settings->slides_to_scroll ) && ! empty( $settings->slides_to_scroll ) ) {
	$slides_to_scroll = absint( $settings->slides_to_scroll );
}
if ( isset( $settings->slides_to_scroll_medium ) && ! empty( $settings->slides_to_scroll_medium ) ) {
	$slides_to_scroll_tablet = absint( $settings->slides_to_scroll_medium );
} else {
	$slides_to_scroll_tablet = $slides_to_scroll;
}
if ( isset( $settings->slides_to_scroll_responsive ) && ! empty( $settings->slides_to_scroll_responsive ) ) {
	$slides_to_scroll_mobile = absint( $settings->slides_to_scroll_responsive );
} else {
	$slides_to_scroll_mobile = $slides_to_scroll_tablet;
}
?>

var gallery_<?php echo $id; ?> = '';

;(function($) {

	var options = {
		id: '<?php echo $id; ?>',
		layout: '<?php echo $module->get_layout(); ?>',
		aspectRatio: '<?php echo $settings->aspect_ratio; ?>',
		filters: <?php echo $module->filters_enabled() ? 'true' : 'false'; ?>,
		carousel: false,
		isBuilderActive: <?php echo FLBuilderModel::is_builder_active() ? 'true' : 'false'; ?>,
	};

	<?php if ( 'carousel' === $module->get_layout() ) { ?>
		options.carousel = {
			initialSlide: 0,
			slidesPerView: {
				desktop: <?php echo absint( $settings->columns ); ?>,
				tablet: <?php echo absint( $settings->columns_medium ); ?>,
				mobile: <?php echo absint( $settings->columns_responsive ); ?>,
			},
			slidesToScroll: {
				desktop: <?php echo $slides_to_scroll; ?>,
				tablet: <?php echo $slides_to_scroll_tablet; ?>,
				mobile: <?php echo $slides_to_scroll_mobile; ?>,
			},
			spaceBetween: {
				desktop: '<?php echo $settings->spacing; ?>',
				tablet: '<?php echo $settings->spacing_medium; ?>',
				mobile: '<?php echo $settings->spacing_responsive; ?>',
			},
			autoplay: false,
			pagination: '<?php echo $settings->pagination_type; ?>',
			effect: '<?php echo $settings->effect; ?>',
			speed: <?php echo empty( $settings->transition_speed ) ? 1000 : $settings->transition_speed; ?>,
			loop: <?php echo 'yes' === $settings->carousel_loop ? 'true' : 'false'; ?>,
			breakpoint: {
				medium: <?php echo $global_settings->medium_breakpoint; ?>,
				responsive: <?php echo $global_settings->responsive_breakpoint; ?>
			}
		};
		<?php if ( 'yes' === $settings->carousel_autoplay ) { ?>
			options.carousel.autoplay = {
				delay: <?php echo $settings->autoplay_delay; ?>,
				disableOnInteraction: <?php echo 'yes' === $settings->pause_on_interaction ? 'true' : 'false'; ?>,
			};
		<?php } ?>
	<?php } ?>
	
	gallery_<?php echo $id; ?> = new PPVideoGallery( options );

})(jQuery);
