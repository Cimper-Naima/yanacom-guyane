.fl-node-<?php echo $id; ?> .pp-hotspot-container {
	position: relative;
	display: inline-block;
	left: 50%;
	transform: translate(-50%);
}
.fl-node-<?php echo $id; ?> .pp-hotspot-image-container .pp-hotspot-image {
	width: <?php echo $settings->photo_size; ?>px;
	opacity: <?php echo $settings->img_opacity; ?>;
}
<?php
// Image Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'img_border',
		'selector'     => ".fl-node-$id .pp-hotspot-image-container .pp-hotspot-image",
	)
);
?>
.fl-node-<?php echo $id; ?> span.pp-marker-title {
	<?php echo ( 'no' === $settings->admin_title_preview ) ? 'display: none' : 'display: block'; ?>
}
.fl-node-<?php echo $id; ?> .pp-hotspot-marker {
	position: absolute;
	background: <?php echo pp_get_color_value( $settings->common_marker_bg_color ); ?>;
	min-width: <?php echo $settings->marker_bg_size; ?>px;
	min-height: <?php echo $settings->marker_bg_size; ?>px;
	text-align: center;
	border-radius: 100px;
	border-style: solid;
	border-width: 2px;
	border-color: #000;
	cursor: pointer;
}
.fl-node-<?php echo $id; ?> .pp-hotspot-marker.pp-non-active-marker {
	visibility: hidden;
}
.fl-node-<?php echo $id; ?> .pp-hotspot-marker.pp-non-active-marker.open {
	visibility: visible;
}

.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-icon,
.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-text {
	font-size: <?php echo $settings->common_marker_size; ?>px;
	color: <?php echo pp_get_color_value( $settings->common_marker_color ); ?>;
	margin-bottom: 0;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translateX(-50%) translateY(-50%);
}
.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-icon.dashicons, 
.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-icon.dashicons-before:before {
	font-size: <?php echo $settings->common_marker_size; ?>px;
	width: <?php echo $settings->common_marker_size; ?>px;
	height: <?php echo $settings->common_marker_size; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-image {
	min-width: <?php echo $settings->marker_img_size; ?>px;
	min-height: <?php echo $settings->marker_img_size; ?>px;
	width: <?php echo $settings->marker_img_size; ?>px;
	height: <?php echo $settings->marker_img_size; ?>px;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translateX(-50%) translateY(-50%);
	<?php if ( ! empty( $settings->marker_border['radius']['top_left'] ) || '0' === $settings->marker_border['radius']['top_left'] ) { ?>
		border-top-left-radius: <?php echo $settings->marker_border['radius']['top_left']; ?>px;
		border-top-right-radius:  <?php echo $settings->marker_border['radius']['top_right']; ?>px;
		border-bottom-left-radius:  <?php echo $settings->marker_border['radius']['bottom_left']; ?>px;
		border-bottom-right-radius:  <?php echo $settings->marker_border['radius']['bottom_right']; ?>px;
	<?php } else { ?>
		border-radius: 100px;
	<?php } ?>
}
<?php
// Marker Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'marker_border',
		'selector'     => ".fl-node-$id .pp-hotspot-marker",
	)
);
?>
<?php if ( 'yes' === $settings->marker_ripple_effect ) { ?>
	.fl-node-<?php echo $id; ?> .pp-hotspot-marker:before {
		content: "";
		display: block;
		pointer-events: none;
		-webkit-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1);
		-webkit-animation: shadow-pulse 2s infinite;
		animation: shadow-pulse 2s infinite;
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		<?php if ( ! empty( $settings->marker_border['radius']['top_left'] ) || '0' === $settings->marker_border['radius']['top_left'] ) { ?>
			border-top-left-radius: <?php echo $settings->marker_border['radius']['top_left']; ?>px;
			border-top-right-radius:  <?php echo $settings->marker_border['radius']['top_right']; ?>px;
			border-bottom-left-radius:  <?php echo $settings->marker_border['radius']['bottom_left']; ?>px;
			border-bottom-right-radius:  <?php echo $settings->marker_border['radius']['bottom_right']; ?>px;
		<?php } else { ?>
			border-radius: 100px;
		<?php } ?>
		background: <?php echo pp_get_color_value( $settings->common_marker_bg_color ); ?>;
		z-index: 0;
	}
@keyframes shadow-pulse
{
	0% {
		-webkit-transform: scale(1);
		transform: scale(1);
		opacity: 1;
	}
	100% {
		-webkit-transform: scale(2);
		transform: scale(2);
		opacity: 0;
	}
}

<?php } ?>

<?php foreach ( $settings->markers_content as $i => $marker ) { ?>
	.fl-node-<?php echo $id; ?> .pp-hotspot-marker.pp-marker-<?php echo ( $i + 1 ); ?> {
		top: <?php echo $marker->marker_position_vertical; ?>%;
		left: <?php echo $marker->marker_position_horizontal; ?>%;
		transform: translate(0, -<?php echo $marker->marker_position_vertical; ?>%);
		<?php if ( ! empty( $marker->marker_bg_color ) ) { ?>
			background: <?php echo pp_get_color_value( $marker->marker_bg_color ); ?>;
		<?php } ?>
		<?php if ( ! empty( $marker->marker_border_single_color ) ) { ?>
			border-color: <?php echo pp_get_color_value( $marker->marker_border_single_color ); ?>;
		<?php } ?>
	}
	<?php if ( ! empty( $marker->marker_color ) ) { ?>
		<?php if ( 'icon' === $marker->marker_type ) { ?>
			.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-hotspot-marker.pp-marker-<?php echo ( $i + 1 ); ?> .pp-marker-icon {
				color: <?php echo pp_get_color_value( $marker->marker_color ); ?>;
			}
		<?php } elseif ( 'text' === $marker->marker_type ) { ?>
			.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-hotspot-marker.pp-marker-<?php echo ( $i + 1 ); ?> .pp-marker-text {
				color: <?php echo pp_get_color_value( $marker->marker_color ); ?>;
			}
		<?php } ?>
	<?php } ?>

	<?php if ( ! empty( $marker->marker_bg_color && 'yes' === $settings->marker_ripple_effect ) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-marker-<?php echo ( $i + 1 ); ?>:before {
			content: "";
			background: <?php echo pp_get_color_value( $marker->marker_bg_color ); ?>;
		}
	<?php } ?>
	<?php
	// Marker Text typography
	FLBuilderCSS::typography_field_rule(
		array(
			'settings'     => $marker,
			'setting_name' => 'marker_text_typography',
			'selector'     => ".fl-node-$id .pp-hotspot-content .pp-marker-text",
		)
	);
	?>
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-hotspot-overlay {
	position: absolute;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	background: rgba(0, 0, 0, 0.5);
	border-top-left-radius: <?php echo $settings->img_border['radius']['top_left']; ?>px;
	border-top-right-radius:  <?php echo $settings->img_border['radius']['top_right']; ?>px;
	border-bottom-left-radius:  <?php echo $settings->img_border['radius']['bottom_left']; ?>px;
	border-bottom-right-radius:  <?php echo $settings->img_border['radius']['bottom_right']; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-hotspot-overlay-button {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%);
	color: <?php echo pp_get_color_value( $settings->button_color ); ?>;
	background: <?php echo pp_get_color_value( $settings->button_bg_color ); ?>;
	transition: all 0.4s ease-in-out;
}
.fl-node-<?php echo $id; ?> .pp-hotspot-overlay-button:hover {
	color: <?php echo pp_get_color_value( $settings->button_color_hover ); ?>;
	background: <?php echo pp_get_color_value( $settings->button_bg_color_hover ); ?>;
	border-color: <?php echo pp_get_color_value( $settings->button_border_color_hover ); ?>;
}
<?php
// Button Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_border',
		'selector'     => ".fl-node-$id .pp-hotspot-overlay-button",
	)
);
// Button Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_padding',
		'selector'     => ".fl-node-$id .pp-hotspot-overlay-button",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'button_padding_top',
			'padding-right'  => 'button_padding_right',
			'padding-bottom' => 'button_padding_bottom',
			'padding-left'   => 'button_padding_left',
		),
	)
);
// Button typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_typography',
		'selector'     => ".fl-node-$id .pp-hotspot-overlay-button",
	)
);

?>
.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-tooltip-container {
	display: none;
}
<?php
// Tooltip Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'tooltip_padding',
		'selector'     => ".pp-tooltip-wrap-$id.tooltipster-sidetip .tooltipster-box .tooltipster-content",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'tooltip_padding_top',
			'padding-right'  => 'tooltip_padding_right',
			'padding-bottom' => 'tooltip_padding_bottom',
			'padding-left'   => 'tooltip_padding_left',
		),
	)
);
// Tooltip typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'tooltip_typography',
		'selector'     => ".pp-tooltip-wrap-$id.tooltipster-sidetip .tooltipster-box .tooltipster-content",
	)
);
?>
.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip .tooltipster-box {
	background: <?php echo pp_get_color_value( $settings->tooltip_bg_color ); ?>;
	border-radius: <?php echo $settings->tooltip_corners; ?>px;
	border: none;
}
.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip .tooltipster-box .tooltipster-content {
	color: <?php echo pp_get_color_value( $settings->tooltip_text_color ); ?>;
}
.pp-tooltip-wrap-<?php echo $id; ?> .pp-tooltip-content-<?php echo $id; ?> .pp-tour ul {
	list-style: none;
	display: flex;
	justify-content: space-between;
	margin-bottom: 0;
	padding: 0;
}
.pp-tooltip-wrap-<?php echo $id; ?> .pp-tooltip-content-<?php echo $id; ?> .pp-tour ul a.pp-prev.inactive,
.pp-tooltip-wrap-<?php echo $id; ?> .pp-tooltip-content-<?php echo $id; ?> .pp-tour ul a.pp-next.inactive {
	pointer-events: none;
	cursor: default;
	text-decoration: none;
	opacity: 0.5;
}
.pp-tooltip-wrap-<?php echo $id; ?> .pp-tooltip-content-<?php echo $id; ?> .pp-tour ul a.pp-prev {
	color: <?php echo pp_get_color_value( $settings->tooltip_pre_color ); ?>;
	cursor: pointer;
}
.pp-tooltip-wrap-<?php echo $id; ?> .pp-tooltip-content-<?php echo $id; ?> .pp-tour ul a.pp-next {
	color: <?php echo pp_get_color_value( $settings->tooltip_nxt_color ); ?>;
	cursor: pointer;
}
.pp-tooltip-wrap-<?php echo $id; ?> .pp-tooltip-content-<?php echo $id; ?> .pp-hotspot-end .pp-tour-end {
	color: <?php echo pp_get_color_value( $settings->tooltip_end_color ); ?>;
	cursor: pointer;
}

.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip.tooltipster-top .tooltipster-arrow-border,
.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip.tooltipster-top .tooltipster-arrow-background {
	border-top-color: <?php echo pp_get_color_value( $settings->tooltip_bg_color ); ?>;
}
.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip.tooltipster-bottom .tooltipster-arrow-border,
.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip.tooltipster-bottom .tooltipster-arrow-background {
	border-bottom-color: <?php echo pp_get_color_value( $settings->tooltip_bg_color ); ?>;
}
.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip.tooltipster-left .tooltipster-arrow-border,
.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip.tooltipster-left .tooltipster-arrow-background {
	border-left-color: <?php echo pp_get_color_value( $settings->tooltip_bg_color ); ?>;
}
.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip.tooltipster-right .tooltipster-arrow-border,
.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip.tooltipster-right .tooltipster-arrow-background {
	border-right-color: <?php echo pp_get_color_value( $settings->tooltip_bg_color ); ?>;
}
.pp-tooltip-wrap-<?php echo $id; ?>.tooltipster-sidetip .tooltipster-box .tooltipster-content .pp-hotspot-tour .pp-hotspot-end {
	text-align: center;
}

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-hotspot-image-container .pp-hotspot-image {
		width: <?php echo $settings->photo_size_medium; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-icon,
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-text {
		font-size: <?php echo $settings->common_marker_size_medium; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-icon.dashicons, 
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-icon.dashicons-before:before {
		font-size: <?php echo $settings->common_marker_size_medium; ?>px;
		width: <?php echo $settings->common_marker_size_medium; ?>px;
		height: <?php echo $settings->common_marker_size_medium; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-marker {
		min-width: <?php echo $settings->marker_bg_size_medium; ?>px;
		min-height: <?php echo $settings->marker_bg_size_medium; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-image {
		min-width: <?php echo $settings->marker_img_size_medium; ?>px;
		min-height: <?php echo $settings->marker_img_size_medium; ?>px;
		width: <?php echo $settings->marker_img_size_medium; ?>px;
		height: <?php echo $settings->marker_img_size_medium; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-hotspot-marker:before,
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-image {
		border-top-left-radius: <?php echo $settings->marker_border_medium['radius']['top_left']; ?>px;
		border-top-right-radius:  <?php echo $settings->marker_border_medium['radius']['top_right']; ?>px;
		border-bottom-left-radius:  <?php echo $settings->marker_border_medium['radius']['bottom_left']; ?>px;
		border-bottom-right-radius:  <?php echo $settings->marker_border_medium['radius']['bottom_right']; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-overlay {
		border-top-left-radius: <?php echo $settings->img_border_medium['radius']['top_left']; ?>px;
		border-top-right-radius:  <?php echo $settings->img_border_medium['radius']['top_right']; ?>px;
		border-bottom-left-radius:  <?php echo $settings->img_border_medium['radius']['bottom_left']; ?>px;
		border-bottom-right-radius:  <?php echo $settings->img_border_medium['radius']['bottom_right']; ?>px;
	}
}
@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-hotspot-image-container .pp-hotspot-image {
		width: <?php echo $settings->photo_size_responsive; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-icon,
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-text {
		font-size: <?php echo $settings->common_marker_size_responsive; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-icon.dashicons, 
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-icon.dashicons-before:before {
		font-size: <?php echo $settings->common_marker_size_responsive; ?>px;
		width: <?php echo $settings->common_marker_size_responsive; ?>px;
		height: <?php echo $settings->common_marker_size_responsive; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-marker {
		min-width: <?php echo $settings->marker_bg_size_responsive; ?>px;
		min-height: <?php echo $settings->marker_bg_size_responsive; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-image {
		min-width: <?php echo $settings->marker_img_size_responsive; ?>px;
		min-height: <?php echo $settings->marker_img_size_responsive; ?>px;
		width: <?php echo $settings->marker_img_size_responsive; ?>px;
		height: <?php echo $settings->marker_img_size_responsive; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-hotspot-marker:before,
	.fl-node-<?php echo $id; ?> .pp-hotspot-content .pp-marker-image {
		border-top-left-radius: <?php echo $settings->marker_border_responsive['radius']['top_left']; ?>px;
		border-top-right-radius:  <?php echo $settings->marker_border_responsive['radius']['top_right']; ?>px;
		border-bottom-left-radius:  <?php echo $settings->marker_border_responsive['radius']['bottom_left']; ?>px;
		border-bottom-right-radius:  <?php echo $settings->marker_border_responsive['radius']['bottom_right']; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hotspot-overlay {
		border-top-left-radius: <?php echo $settings->img_border_responsive['radius']['top_left']; ?>px;
		border-top-right-radius:  <?php echo $settings->img_border_responsive['radius']['top_right']; ?>px;
		border-bottom-left-radius:  <?php echo $settings->img_border_responsive['radius']['bottom_left']; ?>px;
		border-bottom-right-radius:  <?php echo $settings->img_border_responsive['radius']['bottom_right']; ?>px;
	}
}
