var carousel_<?php echo $id; ?> = '';
;(function($) {
	<?php
	$columns            = empty( $settings->columns ) ? 3 : $settings->columns;
	$columns_medium     = empty( $settings->columns_medium ) ? $columns : $settings->columns_medium;
	$columns_responsive = empty( $settings->columns_responsive ) ? $columns_medium : $settings->columns_responsive;
	?>

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

	var settings = {
		id: '<?php echo $id; ?>',
		type: '<?php echo $settings->carousel_type; ?>',
		initialSlide: 0,
		slidesPerView: {
			desktop: <?php echo absint( $columns ); ?>,
			tablet: <?php echo absint( $columns_medium ); ?>,
			mobile: <?php echo absint( $columns_responsive ); ?>,
		},
		slidesToScroll: {
			desktop: <?php echo $slides_to_scroll; ?>,
			tablet: <?php echo $slides_to_scroll_tablet; ?>,
			mobile: <?php echo $slides_to_scroll_mobile; ?>,
		},
		slideshow_slidesPerView: {
			desktop: ''<?php //echo absint($settings->thumb_columns); ?>,
			tablet: ''<?php //echo absint($settings->thumb_columns_medium); ?>,
			mobile: ''<?php //echo absint($settings->thumb_columns_responsive); ?>,
		},
		spaceBetween: {
			desktop: '<?php echo $settings->spacing; ?>',
			tablet: '<?php echo $settings->spacing_medium; ?>',
			mobile: '<?php echo $settings->spacing_responsive; ?>',
		},
		isBuilderActive: <?php echo FLBuilderModel::is_builder_active() ? 'true' : 'false'; ?>,
		pagination: '<?php echo $settings->pagination_type; ?>',
		autoplay_speed: <?php echo 'yes' === $settings->autoplay ? $settings->autoplay_speed : 'false'; ?>,
		pause_on_interaction: <?php echo ( 'yes' === $settings->pause_on_interaction ) ? 'true' : 'false'; ?>,
		effect: 'slide',
		speed: <?php echo ! empty( $settings->transition_speed ) ? $settings->transition_speed : 1000; ?>,
		breakpoint: {
			medium: <?php echo $global_settings->medium_breakpoint; ?>,
			responsive: <?php echo $global_settings->responsive_breakpoint; ?>
		},
	};

	<?php if ( 'yes' === $settings->category_grid_slider ) { ?>
			carousel_<?php echo $id; ?> = new PPCategoryGridSlider(settings);
	<?php } ?>


})(jQuery);
