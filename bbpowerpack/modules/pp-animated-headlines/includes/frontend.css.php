<?php
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'headline_typography',
	'selector'		=> ".fl-node-$id .pp-headline"
) );
?>
.fl-node-<?php echo $id; ?> .pp-headline {
	text-align: <?php echo $settings->alignment; ?>;
	<?php if ( ! empty( $settings->color ) ) { ?>
		color: #<?php echo $settings->color; ?>;
	<?php } ?>
}
<?php
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'animated_typography',
	'selector'		=> ".fl-node-$id .pp-headline-dynamic-wrapper"
) );
?>
.fl-node-<?php echo $id; ?> .pp-headline-dynamic-wrapper {
	<?php if ( $settings->animated_color != '' ) { ?>
		color: #<?php echo $settings->animated_color; ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-headline-dynamic-wrapper.pp-headline-typing-selected {
	<?php if ( ! empty( $settings->animated_selection_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->animated_selection_bg_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-headline-dynamic-wrapper.pp-headline-typing-selected .pp-headline-dynamic-text {
	<?php if ( ! empty( $settings->animated_selection_color ) ) { ?>
	color: #<?php echo $settings->animated_selection_color; ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-headline-dynamic-wrapper path {
	<?php if ( $settings->shape_width != '' ) { ?>
		stroke-width: <?php echo $settings->shape_width; ?>px;
	<?php } ?>
	<?php if ( $settings->shape_color ) { ?>
		stroke: #<?php echo $settings->shape_color; ?>;
	<?php } ?>
}