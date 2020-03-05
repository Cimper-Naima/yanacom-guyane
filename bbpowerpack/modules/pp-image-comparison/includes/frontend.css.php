.fl-node-<?php echo $id; ?> .twentytwenty-container * {
	-webkit-box-sizing: content-box;
	-moz-box-sizing: content-box;
	box-sizing: content-box;
}
.fl-node-<?php echo $id; ?> .twentytwenty-overlay {
	background-color: <?php echo ! empty( $settings->overlay_bg_color ) ? pp_get_color_value( $settings->overlay_bg_color ) : 'transparent'; ?>;
	transition: all 0.4s ease-in-out;
}
.fl-node-<?php echo $id; ?> .pp-image-comp-inner:hover .twentytwenty-overlay {
	background-color: <?php echo ! empty( $settings->overlay_bg_color_hover ) ? pp_get_color_value( $settings->overlay_bg_color_hover ) : 'transparent'; ?>;
}
.fl-node-<?php echo $id; ?> .twentytwenty-container img {
	max-height: <?php echo $settings->img_max_height; ?>px;
	width: 100%;
	object-fit: cover;
}
<?php if ( 'mouse_click' === $settings->move_slider ) { ?>
	.fl-node-<?php echo $id; ?> .twentytwenty-container img {
		transition: all 0.4s ease-in-out;
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-handle {
		background-color: <?php echo pp_get_color_value( $settings->icon_bg_color ); ?>;
		transition: all 0.4s ease-in-out;
	}
<?php } else { ?>
	.fl-node-<?php echo $id; ?> .twentytwenty-handle {
		background-color: <?php echo pp_get_color_value( $settings->icon_bg_color ); ?>;
		transition: border-color 0.4s ease-in-out, background-color 0.4s ease-in-out;
	}
<?php } ?>
.fl-node-<?php echo $id; ?> .pp-image-comp-inner:hover .twentytwenty-handle {
	background-color: <?php echo pp_get_color_value( $settings->icon_bg_color_hover ); ?>;
}
.fl-node-<?php echo $id; ?> .twentytwenty-handle .twentytwenty-left-arrow {
	border-right-color: <?php echo pp_get_color_value( $settings->icon_color ); ?>;
	transition: border-right-color 0.4s ease-in-out;
}
.fl-node-<?php echo $id; ?> .twentytwenty-handle .twentytwenty-right-arrow {
	border-left-color: <?php echo pp_get_color_value( $settings->icon_color ); ?>;
	transition: border-left-color 0.4s ease-in-out;
}
.fl-node-<?php echo $id; ?> .pp-image-comp-inner:hover .twentytwenty-handle .twentytwenty-left-arrow {
	border-right-color: <?php echo pp_get_color_value( $settings->icon_color_hover ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-image-comp-inner:hover .twentytwenty-handle .twentytwenty-right-arrow {
	border-left-color: <?php echo pp_get_color_value( $settings->icon_color_hover ); ?>;
}
.fl-node-<?php echo $id; ?> .twentytwenty-handle .twentytwenty-down-arrow {
	border-top-color: <?php echo pp_get_color_value( $settings->icon_color ); ?>;
	transition: border-top-color 0.4s ease-in-out;
}
.fl-node-<?php echo $id; ?> .twentytwenty-handle .twentytwenty-up-arrow {
	border-bottom-color: <?php echo pp_get_color_value( $settings->icon_color ); ?>;
	transition: border-bottom-color 0.4s ease-in-out;
}
.fl-node-<?php echo $id; ?> .pp-image-comp-inner:hover .twentytwenty-handle .twentytwenty-down-arrow {
	border-top-color: <?php echo pp_get_color_value( $settings->icon_color_hover ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-image-comp-inner:hover .twentytwenty-handle .twentytwenty-up-arrow {
	border-bottom-color: <?php echo pp_get_color_value( $settings->icon_color_hover ); ?>;
}
<?php
// Icon Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'icon_border',
		'selector'     => '.fl-node-$id .twentytwenty-handle',
	)
);
?>

.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:before,
.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:after {
	width: <?php echo $settings->divider_width; ?>px;
	margin-left: calc(-<?php echo $settings->divider_width; ?>px/2);
	background-color: <?php echo pp_get_color_value( $settings->divider_color ); ?>;
	transition: all 0.4s ease-in-out;
}
.fl-node-<?php echo $id; ?> .pp-image-comp-inner:hover .twentytwenty-handle:before,
.fl-node-<?php echo $id; ?> .pp-image-comp-inner:hover .twentytwenty-handle:after {
	background-color: <?php echo pp_get_color_value( $settings->divider_color_hover ); ?>;
}
.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:before {
	margin-bottom: <?php echo 22 + ( ! empty( $settings->icon_border['width']['top'] ) ? $settings->icon_border['width']['top'] : 0 ); ?>px;
}
.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:after {
	margin-top: <?php echo 22 + ( ! empty( $settings->icon_border['width']['bottom'] ) ? $settings->icon_border['width']['bottom'] : 0 ); ?>px;
}
.fl-node-<?php echo $id; ?> .pp-image-comp-inner:hover .twentytwenty-handle {
	border-color: <?php echo pp_get_color_value( $settings->icon_border_color_h ); ?>;
}

.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:before,
.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:after {
	height: <?php echo $settings->divider_width; ?>px;
	margin-top: calc(-<?php echo $settings->divider_width; ?>px/2);
	background-color: <?php echo pp_get_color_value( $settings->divider_color ); ?>;
	transition: all 0.4s ease-in-out;
}

.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:before {
	margin-left: <?php echo 22 + ( ! empty( $settings->icon_border['width']['right'] ) ? $settings->icon_border['width']['right'] : 0 ); ?>px;
}
.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:after {
	margin-right: <?php echo 22 + ( ! empty( $settings->icon_border['width']['left'] ) ? $settings->icon_border['width']['left'] : 0 ); ?>px;
}
<?php
$before_position_h = '';
$after_position_h  = '';
$before_position_v = '';
$after_position_v  = '';

if ( 'horizontal' === $settings->img_orientation ) {
	if ( 'top' === $settings->before_positon_h ) {
		$before_position_h = 'top:' . $settings->before_align . 'px;transform: translateY(0%);';
	} elseif ( 'bottom' === $settings->before_positon_h ) {
		$before_position_h = 'top:calc(100% - ' . $settings->before_align . 'px);transform: translateY(-100%);';
	} else {
		$before_position_h = 'top:50%;transform: translateY(-50%);';
	}
	if ( 'top' === $settings->after_positon_h ) {
		$after_position_h = 'top:' . $settings->after_align . 'px;transform: translateY(0%);';
	} elseif ( 'bottom' === $settings->after_positon_h ) {
		$after_position_h = 'top:calc(100% - ' . $settings->after_align . 'px);transform: translateY(-100%);';
	} else {
		$after_position_h = 'top:50%;transform: translateY(-50%);';
	}
} elseif ( 'vertical' === $settings->img_orientation ) {
	if ( 'left' === $settings->before_positon_v ) {
		$before_position_v = 'left:' . $settings->before_align . 'px;transform: translateX(0%);';
	} elseif ( 'right' === $settings->before_positon_v ) {
		$before_position_v = 'left:calc(100% - ' . $settings->before_align . 'px);transform: translateX(-100%);';
	} else {
		$before_position_v = 'left:50%;transform: translate(-50%);';
	}
	if ( 'left' === $settings->after_positon_v ) {
		$after_position_v = 'left:' . $settings->after_align . 'px;transform: translateX(0%);';
	} elseif ( 'right' === $settings->after_positon_v ) {
		$after_position_v = 'left:calc(100% - ' . $settings->after_align . 'px);transform: translateX(-100%);';
	} else {
		$after_position_v = 'left:50%;transform: translate(-50%);';
	}
}
// Before Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'before_border',
		'selector'     => '.fl-node-$id .twentytwenty-before-label:before',
	)
);
// Before - Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'before_padding',
		'selector'     => '.fl-node-$id .twentytwenty-before-label:before',
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'before_padding_top',
			'padding-right'  => 'before_padding_right',
			'padding-bottom' => 'before_padding_bottom',
			'padding-left'   => 'before_padding_left',
		),
	)
);
// After Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'after_border',
		'selector'     => '.fl-node-$id .twentytwenty-after-label:before',
	)
);
// After - Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'after_padding',
		'selector'     => '.fl-node-$id .twentytwenty-after-label:before',
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'after_padding_top',
			'padding-right'  => 'after_padding_right',
			'padding-bottom' => 'after_padding_bottom',
			'padding-left'   => 'after_padding_left',
		),
	)
);
// Title Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'label_typography',
		'selector'     => '.fl-node-$id .twentytwenty-before-label:before,
							.fl-node-$id .twentytwenty-after-label:before',
	)
);
?>
.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-before-label:before {
	top: <?php echo $settings->before_align; ?>px;
	<?php echo $before_position_v; ?>
}
.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-after-label:before {
	bottom: <?php echo $settings->after_align; ?>px;
	<?php echo $after_position_v; ?>
}
.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-before-label:before {
	left: <?php echo $settings->before_align; ?>px;
	<?php echo $before_position_h; ?>
}
.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-after-label:before {
	right: <?php echo $settings->after_align; ?>px;
	<?php echo $after_position_h; ?>
}
<?php if ( 'always' === $settings->display_label ) { ?>
	.fl-node-<?php echo $id; ?> .twentytwenty-after-label,
	.fl-node-<?php echo $id; ?> .twentytwenty-before-label {
		opacity: 1;
	}
<?php } ?>
.fl-node-<?php echo $id; ?> .twentytwenty-before-label:before {
	color: <?php echo pp_get_color_value( $settings->before_color ); ?>;
	background-color: <?php echo pp_get_color_value( $settings->before_bg_color ); ?>;	
}
.fl-node-<?php echo $id; ?> .twentytwenty-after-label:before {
	color: <?php echo pp_get_color_value( $settings->after_color ); ?>;
	background-color: <?php echo pp_get_color_value( $settings->after_bg_color ); ?>;
}

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:before,
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:after {
		width: <?php echo $settings->divider_width_medium; ?>px;
		margin-left: calc(-<?php echo $settings->divider_width_medium; ?>px/2);
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:before {
		margin-bottom: <?php echo 22 + ( ! empty( $settings->icon_border_medium['width']['top'] ) ? $settings->icon_border_medium['width']['top'] : 0 ); ?>px;
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:after {
		margin-top: <?php echo 22 + ( ! empty( $settings->icon_border_medium['width']['bottom'] ) ? $settings->icon_border_medium['width']['bottom'] : 0 ); ?>px;
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:before,
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:after {
		height: <?php echo $settings->divider_width_medium; ?>px;
		margin-top: calc(-<?php echo $settings->divider_width_medium; ?>px/2);
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:before {
		margin-left: <?php echo 22 + ( ! empty( $settings->icon_border_medium['width']['right'] ) ? $settings->icon_border_medium['width']['right'] : 0 ); ?>px;
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:after {
		margin-right: <?php echo 22 + ( ! empty( $settings->icon_border_medium['width']['left'] ) ? $settings->icon_border_medium['width']['left'] : 0 ); ?>px;
	}
	<?php
	$before_position_h_medium = '';
	$after_position_h_medium  = '';
	$before_position_v_medium = '';
	$after_position_v_medium  = '';

	if ( 'horizontal' === $settings->img_orientation ) {
		if ( 'top' === $settings->before_positon_h_medium ) {
			$before_position_h_medium = 'top:' . $settings->before_align_medium . 'px;transform: translateY(0%);';
		} elseif ( 'bottom' === $settings->before_positon_h_medium ) {
			$before_position_h_medium = 'top:calc(100% - ' . $settings->before_align_medium . 'px);transform: translateY(-100%);';
		} else {
			$before_position_h_medium = 'top:50%;transform: translateY(-50%);';
		}
		if ( 'top' === $settings->after_positon_h_medium ) {
			$after_position_h_medium = 'top:' . $settings->after_align_medium . 'px;transform: translateY(0%);';
		} elseif ( 'bottom' === $settings->after_positon_h_medium ) {
			$after_position_h_medium = 'top:calc(100% - ' . $settings->after_align_medium . 'px);transform: translateY(-100%);';
		} else {
			$after_position_h_medium = 'top:50%;transform: translateY(-50%);';
		}
	} elseif ( 'vertical' === $settings->img_orientation ) {
		if ( 'left' === $settings->before_positon_v_medium ) {
			$before_position_v_medium = 'left:' . $settings->before_align_medium . 'px;transform: translateX(0%);';
		} elseif ( 'right' === $settings->before_positon_v_medium ) {
			$before_position_v_medium = 'left:calc(100% - ' . $settings->before_align_medium . 'px);transform: translateX(-100%);';
		} else {
			$before_position_v_medium = 'left:50%;transform: translate(-50%);';
		}
		if ( 'left' === $settings->after_positon_v_medium ) {
			$after_position_v_medium = 'left:' . $settings->after_align_medium . 'px;transform: translateX(0%);';
		} elseif ( 'right' === $settings->after_positon_v_medium ) {
			$after_position_v_medium = 'left:calc(100% - ' . $settings->after_align_medium . 'px);transform: translateX(-100%);';
		} else {
			$after_position_v_medium = 'left:50%;transform: translate(-50%);';
		}
	}
	?>
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-before-label:before {
		top: <?php echo $settings->before_align_medium; ?>px;
		<?php echo $before_position_v_medium; ?>
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-after-label:before {
		bottom: <?php echo $settings->after_align_medium; ?>px;
		<?php echo $after_position_v_medium; ?>
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-before-label:before {
		left: <?php echo $settings->before_align_medium; ?>px;
		<?php echo $before_position_h_medium; ?>
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-after-label:before {
		right: <?php echo $settings->after_align_medium; ?>px;
		<?php echo $after_position_h_medium; ?>
	}

}

@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:before,
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:after {
		width: <?php echo $settings->divider_width_responsive; ?>px;
		margin-left: calc(-<?php echo $settings->divider_width_responsive; ?>px/2);
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:before {
		margin-bottom: <?php echo 22 + ( ! empty( $settings->icon_border_responsive['width']['top'] ) ? $settings->icon_border_responsive['width']['top'] : 0 ); ?>px;
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-handle:after {
		margin-top: <?php echo 22 + ( ! empty( $settings->icon_border_responsive['width']['bottom'] ) ? $settings->icon_border_responsive['width']['bottom'] : 0 ); ?>px;
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:before,
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:after {
		height: <?php echo $settings->divider_width_responsive; ?>px;
		margin-top: calc(-<?php echo $settings->divider_width_responsive; ?>px/2);
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:before {
		margin-left: <?php echo 22 + ( ! empty( $settings->icon_border_responsive['width']['right'] ) ? $settings->icon_border_responsive['width']['right'] : 0 ); ?>px;
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-handle:after {
		margin-right: <?php echo 22 + ( ! empty( $settings->icon_border_responsive['width']['left'] ) ? $settings->icon_border_responsive['width']['left'] : 0 ); ?>px;
	}
	<?php
	$before_position_h_responsive = '';
	$after_position_h_responsive  = '';
	$before_position_v_responsive = '';
	$after_position_v_responsive  = '';

	if ( 'horizontal' === $settings->img_orientation ) {
		if ( 'top' === $settings->before_positon_h_responsive ) {
			$before_position_h_responsive = 'top:' . $settings->before_align_responsive . 'px;transform: translateY(0%);';
		} elseif ( 'bottom' === $settings->before_positon_h_responsive ) {
			$before_position_h_responsive = 'top:calc(100% - ' . $settings->before_align_responsive . 'px);transform: translateY(-100%);';
		} else {
			$before_position_h_responsive = 'top:50%;transform: translateY(-50%);';
		}
		if ( 'top' === $settings->after_positon_h_responsive ) {
			$after_position_h_responsive = 'top:' . $settings->after_align_responsive . 'px;transform: translateY(0%);';
		} elseif ( 'bottom' === $settings->after_positon_h_responsive ) {
			$after_position_h_responsive = 'top:calc(100% - ' . $settings->after_align_responsive . 'px);transform: translateY(-100%);';
		} else {
			$after_position_h_responsive = 'top:50%;transform: translateY(-50%);';
		}
	} elseif ( 'vertical' === $settings->img_orientation ) {
		if ( 'left' === $settings->before_positon_v_responsive ) {
			$before_position_v_responsive = 'left:' . $settings->before_align_responsive . 'px;transform: translateX(0%);';
		} elseif ( 'right' === $settings->before_positon_v_responsive ) {
			$before_position_v_responsive = 'left:calc(100% - ' . $settings->before_align_responsive . 'px);transform: translateX(-100%);';
		} else {
			$before_position_v_responsive = 'left:50%;transform: translate(-50%);';
		}
		if ( 'left' === $settings->after_positon_v_responsive ) {
			$after_position_v_responsive = 'left:' . $settings->after_align_responsive . 'px;transform: translateX(0%);';
		} elseif ( 'right' === $settings->after_positon_v_responsive ) {
			$after_position_v_responsive = 'left:calc(100% - ' . $settings->after_align_responsive . 'px);transform: translateX(-100%);';
		} else {
			$after_position_v_responsive = 'left:50%;transform: translate(-50%);';
		}
	}
	?>
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-before-label:before {
		top: <?php echo $settings->before_align_responsive; ?>px;
		<?php echo $before_position_v_responsive; ?>
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-vertical .twentytwenty-after-label:before {
		bottom: <?php echo $settings->after_align_responsive; ?>px;
		<?php echo $after_position_v_responsive; ?>
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-before-label:before {
		left: <?php echo $settings->before_align_responsive; ?>px;
		<?php echo $before_position_h_responsive; ?>
	}
	.fl-node-<?php echo $id; ?> .twentytwenty-horizontal .twentytwenty-after-label:before {
		right: <?php echo $settings->after_align_responsive; ?>px;
		<?php echo $after_position_h_responsive; ?>
	}
}
