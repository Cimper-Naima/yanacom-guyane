;(function($){

	$(document).ready(function() {
		<?php
			$hide_tablet = isset( $settings->hide_tour_tablet ) && ! empty( $settings->hide_tour_tablet ) ? $settings->hide_tour_tablet : '';
			$hide_mobile = isset( $settings->hide_tour_mobile ) && ! empty( $settings->hide_tour_mobile ) ? $settings->hide_tour_mobile : '';
			$bp_tablet   = ! empty( $global_settings->medium_breakpoint ) ? $global_settings->medium_breakpoint : 1025;
			$bp_mobile   = ! empty( $global_settings->responsive_breakpoint ) ? $global_settings->responsive_breakpoint : 768;
			$max_width   = 'none';
			$min_width   = 'none';

		if ( 'yes' === $hide_tablet && 'yes' !== $hide_mobile ) {
			$max_width = $bp_tablet;
			$min_width = $bp_mobile;
		} elseif ( 'yes' !== $hide_tablet && 'yes' === $hide_mobile ) {
			$max_width = $bp_mobile - 1;
			$min_width = 0;
		} elseif ( 'yes' === $hide_tablet && 'yes' === $hide_mobile ) {
			$max_width = $bp_tablet;
			$min_width = 0;
		}
		?>
		new PPHotspot({
			id: 				'<?php echo $id; ?>',
			markerLength:		'<?php echo sizeof( $settings->markers_content ); ?>',
			tooltipEnable:		'<?php echo $settings->tooltip; ?>',
			tooltipPosition:	'<?php echo $settings->tooltip_position; ?>',
			tooltipTrigger:		'<?php echo $settings->tooltip_trigger; ?>',
			tooltipDistance:	'<?php echo $settings->tooltip_distance; ?>',
			tooltipAnimation:	'<?php echo $settings->tooltip_animation; ?>',
			tooltipWidth:		'<?php echo $settings->tooltip_max_width; ?>',
			animationDur:		'<?php echo $settings->animation_duration; ?>',
			tourEnable:			'<?php echo $settings->enable_tour; ?>',
			tourRepeat:			'<?php echo $settings->repeat_tour; ?>',
			tourAutoplay:		'<?php echo $settings->autoplay_tour; ?>',
			tooltipInterval:	'<?php echo $settings->tooltip_interval; ?>',
			launchTourOn:		'<?php echo $settings->launch_tour; ?>',
			nonActiveMarker:	'<?php echo $settings->non_active_marker; ?>',
			tooltipZindex:		'<?php echo $settings->tooltip_zindex; ?>',
			adminTitlePreview:	'<?php echo $settings->admin_title_preview; ?>',
			tooltipPreview:		'<?php echo $settings->tooltip_preview; ?>',
			viewport:			90,
			tooltipArrow:		<?php echo 'show' === $settings->tooltip_arrow ? 'true' : 'false'; ?>,
			isBuilderActive:	<?php echo FLBuilderModel::is_builder_active() ? 'true' : 'false'; ?>,
			maxWidth:           '<?php echo $max_width; ?>',
			minWidth:           '<?php echo $min_width; ?>',
		});
	});

})(jQuery);
