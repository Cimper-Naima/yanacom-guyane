.fl-node-<?php echo $id; ?> {
	width: 100%;
}

.fl-node-<?php echo $id; ?> .pp-google-map-wrapper .pp-google-map {
	width: <?php echo ( '' !== $settings->map_width ) ? $settings->map_width . $settings->map_width_unit : '100%'; ?>;
	height: <?php echo ( '' !== $settings->map_height ) ? $settings->map_height : '300'; ?>px;
	background-color: #ccc;
}
.fl-node-<?php echo $id; ?> .gm-style .pp-infowindow-content {
	max-width: <?php echo ( '' !== $settings->info_width ) ? $settings->info_width : '200'; ?>px;
}
<?php
// Form Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'info_padding',
		'selector'     => ".fl-node-$id .gm-style .pp-infowindow-content",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'info_padding_top',
			'padding-right'  => 'info_padding_right',
			'padding-bottom' => 'info_padding_bottom',
			'padding-left'   => 'info_padding_left',
		),
	)
);
?>
@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	<?php if ( '' !== $settings->map_width_medium ) { ?>
		.fl-node-<?php echo $id; ?> .pp-google-map-wrapper .pp-google-map {
			width: <?php echo $settings->map_width_medium . $settings->map_width_medium_unit; ?>;
		}
	<?php } ?>
	<?php if ( '' !== $settings->map_height_medium ) { ?>
		.fl-node-<?php echo $id; ?> .pp-google-map-wrapper .pp-google-map {
			height: <?php echo $settings->map_height_medium; ?>px;
		}
	<?php } ?>
	<?php if ( '' !== $settings->info_width_medium ) { ?>
		.fl-node-<?php echo $id; ?> .gm-style .pp-infowindow-content {
			max-width: <?php echo $settings->info_width_medium; ?>px;
		}
	<?php } ?>
}
@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	<?php if ( '' !== $settings->map_width_responsive ) { ?>
		.fl-node-<?php echo $id; ?> .pp-google-map-wrapper .pp-google-map {
			width: <?php echo $settings->map_width_responsive . $settings->map_width_responsive_unit; ?>;
		}
	<?php } ?>
	<?php if ( '' !== $settings->map_height_responsive ) { ?>
		.fl-node-<?php echo $id; ?> .pp-google-map-wrapper .pp-google-map {
			height: <?php echo $settings->map_height_responsive; ?>px;
		}
	<?php } ?>
	<?php if ( '' !== $settings->info_width_responsive ) { ?>
		.fl-node-<?php echo $id; ?> .gm-style .pp-infowindow-content {
			max-width: <?php echo $settings->info_width_responsive; ?>px;
		}
	<?php } ?>
}
