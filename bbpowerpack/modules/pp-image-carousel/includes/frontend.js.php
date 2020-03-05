var carousel_<?php echo $id; ?> = '';

(function($) {
	<?php if($settings->click_action == 'lightbox') : ?>

		var gallery_selector = $( '.fl-node-<?php echo $id; ?> .pp-image-carousel' );
		if( gallery_selector.length && typeof $.fn.magnificPopup !== 'undefined') {
			gallery_selector.magnificPopup({
				delegate: '.pp-image-carousel-item a',
				closeBtnInside: true,
				type: 'image',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					tCounter: ''
				},
				<?php if ( isset( $settings->lightbox_caption ) && 'yes' == $settings->lightbox_caption ) { ?>
				'image': {
					titleSrc: function(item) {
						var caption = item.el.data('caption') || '';
						return caption;
					}
				}
				<?php } ?>
			});
		}
	<?php endif; ?>

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
			desktop: <?php echo absint($settings->columns); ?>,
			tablet: <?php echo absint($settings->columns_medium); ?>,
			mobile: <?php echo absint($settings->columns_responsive); ?>,
		},
		slidesToScroll: {
			desktop: <?php echo $slides_to_scroll; ?>,
			tablet: <?php echo $slides_to_scroll_tablet; ?>,
			mobile: <?php echo $slides_to_scroll_mobile; ?>,
		},
		slideshow_slidesPerView: {
			desktop: <?php echo absint($settings->thumb_columns); ?>,
			tablet: <?php echo absint($settings->thumb_columns_medium); ?>,
			mobile: <?php echo absint($settings->thumb_columns_responsive); ?>,
		},
		spaceBetween: {
			desktop: '<?php echo $settings->spacing; ?>',
			tablet: '<?php echo $settings->spacing_medium; ?>',
			mobile: '<?php echo $settings->spacing_responsive; ?>',
		},
		isBuilderActive: <?php echo FLBuilderModel::is_builder_active() ? 'true' : 'false'; ?>,
		pagination: '<?php echo $settings->pagination_type; ?>',
		autoplay: <?php echo $settings->autoplay == 'yes' ? 'true' : 'false'; ?>,
		autoplay_speed: <?php echo $settings->autoplay == 'yes' ? $settings->autoplay_speed : 'false'; ?>,
		pause_on_interaction: <?php echo $settings->pause_on_interaction == 'yes' ? 'true' : 'false'; ?>,
		effect: '<?php echo $settings->effect; ?>',
		speed: <?php echo $settings->transition_speed; ?>,
		breakpoint: {
			medium: <?php echo $global_settings->medium_breakpoint; ?>,
			responsive: <?php echo $global_settings->responsive_breakpoint; ?>
		},
	};

	carousel_<?php echo $id; ?> = new PPImageCarousel(settings);

	function updateCarousel() {
		setTimeout(function() {
			if ( 'number' !== typeof carousel_<?php echo $id; ?>.swipers.main.length ) {
				carousel_<?php echo $id; ?>.swipers.main.update();
			} else {
				carousel_<?php echo $id; ?>.swipers.main.forEach(function(item) {
					if ( 'undefined' !== typeof item ) {
						item.update();
					}
				});
			}
		}, 10);
	}

	// Modal Box fix
	$(document).on('pp_modal_box_rendered', function(e, selector) {
		if ( selector.find('.fl-node-<?php echo $id; ?>').length > 0 ) {
			updateCarousel();
		}
	});
	
	$(document).on('fl-builder.pp-accordion-toggle-complete', function(e) {
		if ( $(e.target).find('.fl-node-<?php echo $id; ?>').length > 0 ) {
			updateCarousel();
		}
	});

	$(document).on('pp-tabs-switched', function(e, selector) {
		if ( selector.find('.fl-node-<?php echo $id; ?>').length > 0 ) {
			updateCarousel();
		}
	});

	// Beaver Builder Tabs module.
	$('.fl-tabs').find('.fl-tabs-label').on('click', function() {
		var index = $(this).data('index');
		var panel = $(this).parents('.fl-tabs').find('.fl-tabs-panel-content[data-index="' + index + '"]');
		if ( panel.find('.fl-node-<?php echo $id; ?>').length > 0 ) {
			updateCarousel();
		}
	});

	// expandable row fix.
	var state = 0;
	$(document).on('pp_expandable_row_toggle', function(e, selector) {
		if ( selector.is('.pp-er-open') && state === 0 ) {
			new PPImageCarousel(settings);
			state = 1;
		}
	});
	
})(jQuery);