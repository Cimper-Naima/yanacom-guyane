.fl-node-<?php echo $id; ?> .pp-notification-wrapper {
	<?php if ( isset( $settings->box_background ) && ! empty( $settings->box_background ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->box_background ); ?>;
	<?php } ?>
}
<?php
	// Box - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'box_border',
		'selector' 		=> ".fl-node-$id .pp-notification-wrapper",
	) );

	// Box - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'box_padding',
		'selector' 		=> ".fl-node-$id .pp-notification-wrapper",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'box_padding_top',
			'padding-right' 	=> 'box_padding_right',
			'padding-bottom' 	=> 'box_padding_bottom',
			'padding-left' 		=> 'box_padding_left',
		),
	) );

?>

.fl-node-<?php echo $id; ?> .pp-notification-wrapper .pp-notification-inner .pp-notification-icon {
	margin-right: <?php echo ($settings->box_padding_left > 0) ? $settings->box_padding_left.'px' : '10px'; ?>;
}
.fl-node-<?php echo $id; ?> .pp-notification-wrapper .pp-notification-inner .pp-notification-icon span.pp-icon {
	<?php if($settings->icon_color) { ?>color: #<?php echo $settings->icon_color; ?>;<?php } ?>
	<?php if($settings->icon_size) { ?>font-size: <?php echo $settings->icon_size; ?>px;<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-notification-wrapper .pp-notification-inner .pp-notification-content p {
	<?php if($settings->text_color) { ?>color: #<?php echo $settings->text_color; ?>;<?php } ?>
}

<?php
	// Text Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'text_typography',
		'selector' 		=> ".fl-node-$id .pp-notification-wrapper .pp-notification-inner .pp-notification-content p",
	) );
?>
