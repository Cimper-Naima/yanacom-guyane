<?php
// Image Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'image_border',
		'selector'     => ".fl-node-$id .pp-image-scroll-wrap",
	)
);
?>
.fl-node-<?php echo $id; ?> .pp-image-scroll-wrap .pp-image-scroll-container {
	height: <?php echo $settings->photo_height; ?>px;
	position: relative;
}

.fl-node-<?php echo $id; ?> .pp-image-scroll-container .pp-image-scroll-image img {
	-webkit-transition: all <?php echo $settings->scroll_speed; ?>s ease-in-out !important;
	transition: all <?php echo $settings->scroll_speed; ?>s ease-in-out !important;
}
<?php if ( 'horizontal' === $settings->scroll_dir ) { ?>
	<?php if ( 'scroll' === $settings->img_trigger ) { ?>
		.fl-node-<?php echo $id; ?> .pp-image-scroll-container .pp-image-scroll-image img {
			height: calc(<?php echo $settings->photo_height; ?>px - 15px);
		}
	<?php } else { ?>
		.fl-node-<?php echo $id; ?> .pp-image-scroll-container .pp-image-scroll-image img {
			height: <?php echo $settings->photo_height; ?>px;
		}
	<?php } ?>
<?php } ?>
<?php

// Icon Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'icon_border',
		'selector'     => ".fl-node-$id .pp-overlay-content",
	)
);
// Icon Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'icon_padding',
		'selector'     => ".fl-node-$id .pp-overlay-content",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'icon_padding_top',
			'padding-right'  => 'icon_padding_right',
			'padding-bottom' => 'icon_padding_bottom',
			'padding-left'   => 'icon_padding_left',
		),
	)
);
// Icon Text Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'icon_typography',
		'selector'     => ".fl-node-$id .pp-overlay-content .pp-overlay-text",
	)
);
?>
.fl-node-<?php echo $id; ?> .pp-image-scroll-overlay {
	background-color: <?php echo $settings->overlay_color ? pp_get_color_value( $settings->overlay_color ) : 'transparent'; ?>;
}
.fl-node-<?php echo $id; ?> .pp-overlay-content {
	color: <?php echo $settings->icon_color ? pp_get_color_value( $settings->icon_color ) : '000'; ?>;
	background-color: <?php echo $settings->icon_bg_color ? pp_get_color_value( $settings->icon_bg_color ) : 'transparent'; ?>;
}
<?php if ( 'icon_text' === $settings->overlay_type ) { ?>
	<?php if ( 'after' === $settings->icon_position ) { ?>
		.fl-node-<?php echo $id; ?> .pp-overlay-content {
			display: flex;
			flex-direction: row;
			align-items: center;
		}
		.fl-node-<?php echo $id; ?> .pp-overlay-content .pp-overlay-text {
			padding-right: <?php echo $settings->space_icon_text; ?>px;
		}
	<?php } elseif ( 'before' === $settings->icon_position ) { ?>
		.fl-node-<?php echo $id; ?> .pp-overlay-content {
			display: flex;
			flex-direction: row-reverse;
			align-items: center;
		}
		.fl-node-<?php echo $id; ?> .pp-overlay-content .pp-overlay-text {
			padding-left: <?php echo $settings->space_icon_text; ?>px;
		}
	<?php } elseif ( 'above' === $settings->icon_position ) { ?>
		.fl-node-<?php echo $id; ?> .pp-overlay-content {
			display: flex;
			flex-direction: column-reverse;
			align-items: center;
		}
		.fl-node-<?php echo $id; ?> .pp-overlay-content .pp-overlay-text {
			padding-top: <?php echo $settings->space_icon_text; ?>px;
		}
	<?php } elseif ( 'below' === $settings->icon_position ) { ?>
		.fl-node-<?php echo $id; ?> .pp-overlay-content {
			display: flex;
			flex-direction: column;
			align-items: center;
		}
		.fl-node-<?php echo $id; ?> .pp-overlay-content .pp-overlay-text {
			padding-bottom: <?php echo $settings->space_icon_text; ?>px;
		}
	<?php } ?>
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-overlay-content .pp-overlay-icon {
	font-size: <?php echo $settings->icon_size; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-overlay-content .pp-overlay-image {
	width: <?php echo $settings->icon_size; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-overlay-content .pp-overlay-text {
	margin-bottom: 0;
}

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-image-scroll-wrap .pp-image-scroll-container {
		height: <?php echo $settings->photo_height_medium; ?>px;
	}
	<?php if ( 'horizontal' === $settings->scroll_dir ) { ?>
		<?php if ( 'scroll' === $settings->img_trigger ) { ?>
			.fl-node-<?php echo $id; ?> .pp-image-scroll-container .pp-image-scroll-image img {
				height: calc(<?php echo $settings->photo_height_medium; ?>px - 15px);
			}
		<?php } else { ?>
			.fl-node-<?php echo $id; ?> .pp-image-scroll-container .pp-image-scroll-image img {
				height: <?php echo $settings->photo_height_medium; ?>px;
			}
		<?php } ?>
	<?php } ?>
}

@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-image-scroll-wrap .pp-image-scroll-container {
		height: <?php echo $settings->photo_height_responsive; ?>px;
	}
	<?php if ( 'horizontal' === $settings->scroll_dir ) { ?>
		<?php if ( 'scroll' === $settings->img_trigger ) { ?>
			.fl-node-<?php echo $id; ?> .pp-image-scroll-container .pp-image-scroll-image img {
				height: calc(<?php echo $settings->photo_height_responsive; ?>px - 15px);
			}
		<?php } else { ?>
			.fl-node-<?php echo $id; ?> .pp-image-scroll-container .pp-image-scroll-image img {
				height: <?php echo $settings->photo_height_responsive; ?>px;
			}
		<?php } ?>
	<?php } ?>
}
