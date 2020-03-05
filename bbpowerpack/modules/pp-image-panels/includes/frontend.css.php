<?php
// Panel - Height
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'panel_height',
	'selector'		=> ".fl-node-$id .pp-image-panels-wrap .pp-panel-item",
	'prop'			=> 'height',
	'unit'			=> 'px',
) );
?>
.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-item .pp-panel-title h3 {
	<?php if ( 'no' == $settings->show_title ) { ?>
	display: none;
	<?php } ?>
}
<?php
// Title Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'title_typography',
	'selector' 		=> ".fl-node-$id .pp-image-panels-wrap .pp-panel-item .pp-panel-title h3",
) );

// Title - Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'title_padding',
	'selector' 		=> ".fl-node-$id .pp-image-panels-wrap .pp-panel-item .pp-panel-title h3",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'title_padding_top',
		'padding-right' 	=> 'title_padding_right',
		'padding-bottom' 	=> 'title_padding_bottom',
		'padding-left' 		=> 'title_padding_left',
	),
) );

$number_panels = count($settings->image_panels);
for( $i = 0; $i < $number_panels; $i++ ) {
	$panel = $settings->image_panels[$i];
	if ( !is_object($panel) ) {
		continue;
	}
?>
	.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-link-<?php echo $i; ?> {
		<?php if( $panel->link_type == 'panel' || $panel->link_type == 'lightbox' ) { ?>
			width: <?php echo 100/$number_panels; ?>%;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-item-<?php echo $i; ?> {
		<?php if( $panel->link_type == 'none' ) { ?>
			width: <?php echo 100/$number_panels; ?>%;
		<?php } else { ?>
			width: 100%;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-item-<?php echo $i; ?> {
		background-image: url(<?php echo $panel->photo_src; ?>);
		<?php if ( $settings->image_panels[$i]->position == 'custom' ) { ?>
		background-position: <?php echo $settings->image_panels[$i]->custom_position; ?>%;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-item-<?php echo $i; ?> .pp-panel-title h3 {
		<?php if ( isset( $panel->title_bg_color ) && ! empty( $panel->title_bg_color ) ) { ?>
			background-color: <?php echo pp_get_color_value( $panel->title_bg_color ); ?>;
		<?php } ?>
		<?php if ( isset( $panel->title_text_color ) && ! empty( $panel->title_text_color ) ) { ?>
			color: <?php echo pp_get_color_value( $panel->title_text_color ); ?>;
		<?php } ?>
	}
<?php } ?>

@media only screen and ( max-width: 768px ) {
	<?php for( $i = 0; $i < $number_panels; $i++ ) {
		$panel = $settings->image_panels[$i];
	?>
		.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-link-<?php echo $i; ?>,
		.fl-node-<?php echo $id; ?> .pp-image-panels-wrap .pp-panel-item-<?php echo $i; ?> {
			width: 100% !important;
		}
	<?php } ?>
}