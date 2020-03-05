.fl-node-<?php echo $id; ?> .pp-accordion-item {

	<?php if($settings->item_spacing == 0) : ?>

	border-bottom: none;

	<?php else : ?>

	margin-bottom: <?php echo $settings->item_spacing; ?>px;

	<?php endif; ?>

}

<?php
// Label padding.
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'label_padding',
	'selector'		=> ".fl-node-$id .pp-accordion-item .pp-accordion-button",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top'		=> 'label_padding_top',
		'padding-right'		=> 'label_padding_right',
		'padding-bottom'	=> 'label_padding_bottom',
		'padding-left'		=> 'label_padding_left',
	)
) );

// Label border.
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'label_border',
	'selector' 		=> ".fl-node-$id .pp-accordion-item .pp-accordion-button",
) );
?> 
.fl-node-<?php echo $id; ?> .pp-accordion-item .pp-accordion-button {
	<?php if ( isset( $settings->label_bg_color_default ) && ! empty( $settings->label_bg_color_default ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->label_bg_color_default ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->label_text_color_default ) && ! empty( $settings->label_text_color_default ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->label_text_color_default ); ?>;
	<?php } ?>

	<?php if($settings->item_spacing == 0) : ?>
		border-bottom-width: 0;
	<?php endif; ?>
}

.fl-node-<?php echo $id; ?> .pp-accordion-item .pp-accordion-button:hover,
.fl-node-<?php echo $id; ?> .pp-accordion-item.pp-accordion-item-active .pp-accordion-button {
	<?php if ( isset( $settings->label_bg_color_active ) && ! empty( $settings->label_bg_color_active ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->label_bg_color_active ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->label_text_color_active ) && ! empty( $settings->label_text_color_active ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->label_text_color_active ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-accordion-item.pp-accordion-item-active .pp-accordion-button-icon,
.fl-node-<?php echo $id; ?> .pp-accordion-item:hover .pp-accordion-button-icon {
	<?php if ( isset( $settings->label_text_color_active ) && ! empty( $settings->label_text_color_active ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->label_text_color_active ); ?>;
	<?php } ?>
}


<?php if( $settings->item_spacing == 0 && isset( $settings->label_border['width'] ) ) : ?>
.fl-node-<?php echo $id; ?> .pp-accordion-item .pp-accordion-button:last-child {
	border-bottom-width: <?php echo $settings->label_border['width']['bottom']; ?>px;
}
<?php endif; ?>

<?php // if( $settings->content_bg_color || $settings->content_border_style != 'none' ) { ?>
	/* .fl-node-<?php echo $id; ?> .pp-accordion-item.pp-accordion-item-active .pp-accordion-button {
		border-bottom-left-radius: 0;
		border-bottom-right-radius: 0;
		transition: none;
	} */
<?php // } ?>

<?php
// Label typography.
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'label_typography',
	'selector' 		=> ".fl-node-$id .pp-accordion-item .pp-accordion-button .pp-accordion-button-label",
) );
?>

<?php
// Content typography.
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'content_typography',
	'selector' 		=> ".fl-node-$id .pp-accordion-item .pp-accordion-content",
) );
?>
<?php
// Content border.
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'content_border',
	'selector' 		=> ".fl-node-$id .pp-accordion-item .pp-accordion-content",
) );

// Content Padding.
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'content_padding',
	'selector'		=> ".fl-node-$id .pp-accordion-item .pp-accordion-content",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top'		=> 'content_padding_top',
		'padding-right'		=> 'content_padding_right',
		'padding-bottom'	=> 'content_padding_bottom',
		'padding-left'		=> 'content_padding_left',
	)
) );
?>
.fl-node-<?php echo $id; ?> .pp-accordion-item .pp-accordion-content {
	background-color: <?php echo pp_get_color_value( $settings->content_bg_color ); ?>;
	color: <?php echo pp_get_color_value( $settings->content_text_color ); ?>;
	<?php if ( isset( $settings->content_border['radius'] ) ) { ?>
	border-bottom-left-radius: <?php echo $settings->content_border['radius']['bottom_left']; ?>px;
	border-bottom-right-radius: <?php echo $settings->content_border['radius']['bottom_right']; ?>px;
	<?php } ?>
}


.fl-node-<?php echo $id; ?> .pp-accordion-item .pp-accordion-button-icon {
	font-size: <?php echo $settings->accordion_toggle_icon_size; ?>px;
	color: #<?php echo $settings->accordion_toggle_icon_color; ?>;
}

.fl-node-<?php echo $id; ?> .pp-accordion-item .pp-accordion-button-icon:before {
	font-size: <?php echo $settings->accordion_toggle_icon_size; ?>px;
}

.fl-node-<?php echo $id; ?> .pp-accordion-item .pp-accordion-icon {
	font-size: <?php echo $settings->accordion_icon_size; ?>px;
	width: <?php echo ($settings->accordion_icon_size * 1.25); ?>px;
	<?php if ( isset( $settings->label_text_color_default ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->label_text_color_default ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-accordion-item .pp-accordion-button:hover .pp-accordion-icon,
.fl-node-<?php echo $id; ?> .pp-accordion-item.pp-accordion-item-active .pp-accordion-icon {
	<?php if ( isset( $settings->label_text_color_active ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->label_text_color_active ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-accordion-item .pp-accordion-icon:before {
	font-size: <?php echo $settings->accordion_icon_size; ?>px;
}