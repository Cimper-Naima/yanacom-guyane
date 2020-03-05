<?php


if ( 'top' === $settings->vertical_alignment ) {
	if ( 'landscape' === $settings->orientation || 'laptop' === $settings->device_type || 'desktop' === $settings->device_type ) {
		$valign = 'flex-end';// as landscape flex works opposite.
	} else {
		$valign = 'flex-start';
	}
} elseif ( 'middle' === $settings->vertical_alignment ) {
	$valign = 'center';
} elseif ( 'bottom' === $settings->vertical_alignment ) {
	if ( 'landscape' === $settings->orientation ) {
		$valign = 'flex-start';
	} else {
		$valign = 'flex-end';
	}
} elseif ( 'custom' === $settings->vertical_alignment ) {
	$valign = 'flex-start';
}
if ( 'yes' === $settings->scrollable ) {
	$valign = 'flex-start';
}

FLBuilderCSS::responsive_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'max_width',
		'selector'     => ".fl-node-$id .pp-device-wrap",
		'prop'         => 'width',
		'unit'         => $settings->max_width_unit,
	)
);

FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_border',
		'selector'     => ".fl-node-$id .pp-video-button",
	)
);

FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'hover_button_border',
		'selector'     => ".fl-node-$id .pp-video-button:hover",
	)
);

FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_padding',
		'selector'     => ".fl-node-$id .pp-video-button",
		'unit'         => 'em',
		'props'        => array(
			'padding-top'    => 'button_padding_top',
			'padding-right'  => 'button_padding_right',
			'padding-bottom' => 'button_padding_bottom',
			'padding-left'   => 'button_padding_left',
		),
	)
);
?>

.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-devices-wrapper {
	text-align: <?php echo $settings->alignment; ?>;
}

.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device-wrap {
	<?php if ( '' !== ( $settings->max_width ) ) { ?>
		width: <?php echo $settings->max_width . $settings->max_width_unit; ?>;
	<?php } ?>

}

.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device-media-screen {
	align-items: <?php echo $valign; ?>;

	<?php if ( '' !== ( $settings->top_offset ) && 'custom' === $settings->vertical_alignment && 'yes' === $settings->scrollable ) { ?>
		top : <?php echo $settings->top_offset . '%'; ?>;
	<?php } ?>
}


<?php
if ( 'yes' === $settings->scrollable ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-scrollable {
		overflow-y: auto;
	}

	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-scrollable .pp-device-media-screen-inner figure {
		height: auto;
	}
	<?php
}
?>


<?php
if ( '' !== $settings->orientation_control_color ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device-orientation .fa-mobile {
		color: <?php echo pp_get_color_value( $settings->orientation_control_color ); ?>;
	}
	<?php
}
?>
.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device-shape .overlay-shape {
	fill: #fff;
	fill-opacity:0.4;
}
<?php
if ( 'yes' === $settings->override_style ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device-shape svg .back-shape,
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device-shape svg .side-shape {
		fill:<?php echo pp_get_color_value( $settings->device_color ); ?>;
	}

	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .dark-tone .overlay-shape {
		fill: #000;
		fill-opacity:0.4;
	}

	<?php
	if ( '' !== ( $settings->device_bg_color ) ) {
		?>
		.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device .pp-device-media {
			background-color: <?php echo pp_get_color_value( $settings->device_bg_color ); ?>;
		}
		<?php
	}

	if ( '' !== ( $settings->opacity ) ) {
		?>
		.fl-module-pp-devices.fl-node-<?php echo $id; ?>  .pp-device-shape svg .overlay-shape {
			fill-opacity: <?php echo $settings->opacity; ?>;
		}
		<?php
	}
} else {
	// override style is no.
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device-shape svg .back-shape,
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device-shape svg .side-shape {
		<?php
		if ( 'gold' === $settings->skin ) {
			?>
			fill:#fbe6cf;
			<?php
		} elseif ( 'rose_gold' === $settings->skin ) {
			?>
			fill:#fde4dc;
			<?php
		} elseif ( 'silver' === $settings->skin ) {
			?>
			fill:#e4e6e7;
			<?php
		} elseif ( 'black' === $settings->skin ) {
			?>
			fill:#343639;
			<?php
		}
		?>
	}

	<?php
}



if ( 'no' === $settings->show_bar ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar-wrapper{
		display:none;
	}
	<?php
}

if ( 'no' === $settings->show_buttons ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-buttons{
		display:none;
	}
	<?php
}

if ( 'no' === $settings->show_rewind ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar .pp-player-controls-rewind {
		display:none;
	}
	<?php
}

if ( 'no' === $settings->show_time ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar .pp-player-controls-time{
		display:none;
	}
	<?php
}
if ( 'no' === $settings->show_progress ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar .pp-player-control-progress{
		display:none;
	}
	<?php
}
if ( 'no' === $settings->show_duration ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar .pp-player-controls-duration{
		display:none;
	}
	<?php
}
if ( 'no' === $settings->show_fullscreen ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar .pp-player-controls-fs {
		display:none;
	}
	<?php
}

if ( 'no' === $settings->show_volume ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar .pp-player-controls-volume {
		display:none;
	}
	<?php
}

if ( 'no' === $settings->show_volume_icon ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar .pp-player-controls-volume-icon {
		display:none;
	}
	<?php
}

if ( 'no' === $settings->show_volume_bar ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar .pp-player-controls-volume-bar {
		display:none;
	}
	<?php
}

if ( '' !== ( $settings->overlay_opacity ) ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-player-cover.pp-player-cover {
		opacity: <?php echo $settings->overlay_opacity; ?>;
	}
	<?php
}

if ( '' !== ( $settings->overlay_background ) ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-player-cover.pp-player-cover:after {
		background-color: <?php echo pp_get_color_value( $settings->overlay_background ); ?>;
	}
	<?php
}

if ( '' !== ( $settings->controls_color ) ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button, .fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar {
		color: <?php echo pp_get_color_value( $settings->controls_color ); ?>;
	}
	<?php
}

?>

.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-control-progress-outer,.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-control-progress-inner{
<?php
if ( '' !== ( $settings->controls_color ) ) {
	?>
		background: <?php echo pp_get_color_value( $settings->controls_color ); ?>;
	<?php
}

if ( '' !== ( $settings->bar_border_radius ) ) {
	?>
		border-radius: <?php echo $settings->bar_border_radius; ?>px;
	<?php
}
?>
}


.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button, .fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar {

	<?php
	if ( '' !== ( $settings->controls_opacity ) ) {
		?>
	opacity: <?php echo $settings->controls_opacity; ?>;
		<?php
	}
	?>

	<?php
	if ( '' !== ( $settings->controls_bg_color ) ) {
		?>
	background: <?php echo pp_get_color_value( $settings->controls_bg_color ); ?>;
		<?php
	}
	?>

}


.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button:hover, .fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-player-controls-bar:hover {
<?php

if ( '' !== ( $settings->hover_controls_color ) ) {
	?>
		color: <?php echo pp_get_color_value( $settings->hover_controls_color ); ?>;
	<?php
}

if ( '' !== ( $settings->hover_controls_opacity ) ) {
	?>
	opacity: <?php echo $settings->hover_controls_opacity; ?>;
	<?php
}

if ( '' !== ( $settings->hover_controls_bg_color ) ) {
	?>
	background: <?php echo pp_get_color_value( $settings->hover_controls_bg_color ); ?>;
	<?php
}
?>


?>
}

<?php


if ( '' !== ( $settings->button_controls_color ) ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button {
		color: <?php echo pp_get_color_value( $settings->button_controls_color ); ?>;
	}
	<?php
}

if ( '' !== ( $settings->button_controls_bg_color ) ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button {
		background: <?php echo pp_get_color_value( $settings->button_controls_bg_color ); ?>;
	}
	<?php
}

if ( '' !== ( $settings->hover_button_controls_color ) ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button:hover {
		color: <?php echo pp_get_color_value( $settings->hover_button_controls_color ); ?>;
	}
	<?php
}

if ( '' !== ( $settings->hover_button_controls_bg_color ) ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button:hover {
		background: <?php echo pp_get_color_value( $settings->hover_button_controls_bg_color ); ?>;
	}
	<?php
}

if ( '' !== ( $settings->button_size ) ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button:before {
		font-size: <?php echo $settings->button_size; ?>px;
	}

	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button {
		width: <?php echo $settings->button_size + ( $settings->button_size / 2.5 ); ?>px;
	}
	<?php
}


if ( '' !== ( $settings->button_spacing ) ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button {
		margin: 0px <?php echo $settings->button_spacing; ?>px;
	}
	<?php
}


if ( 'contain' !== $settings->image_fit || 'landscape' === $settings->orientation ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-image-fit .pp-device-media-screen figure img {
		object-fit: <?php echo $settings->image_fit; ?>;
	}

	<?php
}

?>

.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-buttons{
	<?php if ( 'self_hosted' !== $settings->video_src && '' === $settings->embed_cover_image_src ) { ?>
		display: none !important;
	<?php } elseif ( 'self_hosted' !== $settings->video_src && '' !== $settings->embed_cover_image_src ) { ?>
		display: inline-table !important;
	<?php } ?>
}

<?php

if ( 'self_hosted' !== $settings->video_src && '' !== $settings->embed_cover_image_src ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-player-cover {
		background-image: url(<?php echo $settings->embed_cover_image_src; ?>);
	}
	<?php

} elseif ( 'self_hosted' !== $settings->video_src && '' === $settings->embed_cover_image_src ) {
	?>
	.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-player-cover {
		display: none;
	}
	<?php
}

?>

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	<?php
	if ( '' !== ( $settings->button_size_medium ) ) {
		?>
			.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button:before {
				font-size: <?php echo $settings->button_size_medium; ?>px;
			}

			.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button {
				width: <?php echo $settings->button_size_medium + ( $settings->button_size_medium / 2.5 ); ?>px;
			}
			<?php
	}

	if ( '' !== ( $settings->button_spacing_medium ) ) {
		?>
			.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button {
				margin: 0px <?php echo $settings->button_spacing_medium; ?>px;
			}
			<?php
	}

	if ( '' !== ( $settings->max_width_medium ) ) {
		?>
			.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device-wrap {
				width:  <?php echo $settings->max_width_medium . $settings->max_width_unit; ?>;
			}
			<?php
	}

	?>
}

@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	<?php
	if ( '' !== ( $settings->button_size_responsive ) ) {
		?>
			.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button:before {
				font-size: <?php echo $settings->button_size_responsive; ?>px;
			}

			.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button {
				width: <?php echo $settings->button_size_responsive + ( $settings->button_size_responsive / 2.5 ); ?>px;
			}
			<?php
	}

	if ( '' !== ( $settings->button_spacing_responsive ) ) {
		?>
			.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-video-button {
				margin: 0px <?php echo $settings->button_spacing_responsive; ?>px;
			}
			<?php
	}

	if ( '' !== ( $settings->max_width_responsive ) ) {
		?>
			.fl-module-pp-devices.fl-node-<?php echo $id; ?> .pp-device-wrap {
				width:  <?php echo $settings->max_width_responsive . $settings->max_width_unit; ?>;
			}
			<?php
	}
	?>
}
