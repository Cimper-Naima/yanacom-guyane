.fl-node-<?php echo $id; ?> .pp-photo-container .pp-photo-content {
	<?php if ( isset( $settings->box_background ) && ! empty( $settings->box_background ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->box_background ); ?>;
	<?php } ?>
}

<?php
	// Box - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'box_border_group',
		'selector' 		=> ".fl-node-$id .pp-photo-container .pp-photo-content .pp-photo-content-inner",
	) );

	// Box - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'box_padding',
		'selector' 		=> ".fl-node-$id .pp-photo-container .pp-photo-content .pp-photo-content-inner",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'box_padding_top',
			'padding-right' 	=> 'box_padding_right',
			'padding-bottom' 	=> 'box_padding_bottom',
			'padding-left' 		=> 'box_padding_left',
		),
	) );
?>

.fl-node-<?php echo $id; ?> .pp-photo-container .pp-photo-content .pp-photo-content-inner {
	background-clip: border-box;
    <?php if ( isset( $settings->box_border_group ) && isset( $settings->box_border_group['radius'] ) ) { ?>
		border-top-left-radius: <?php echo $settings->box_border_group['radius']['top_left']; ?>px;
		border-top-right-radius: <?php echo $settings->box_border_group['radius']['top_right']; ?>px;
		border-bottom-left-radius: <?php echo $settings->box_border_group['radius']['bottom_left']; ?>px;
		border-bottom-right-radius: <?php echo $settings->box_border_group['radius']['bottom_right']; ?>px;
	<?php } ?>
	transition: all 0.3s ease-in-out;
}

.fl-node-<?php echo $id; ?> .pp-photo-container .pp-photo-content:hover .pp-photo-content-inner {
	<?php if ( isset( $settings->box_border_hover_color ) && ! empty( $settings->box_border_hover_color ) ) { ?>
		border-color: #<?php echo $settings->box_border_hover_color; ?>;
	<?php } ?>
}

<?php
// Image - Size
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'photo_size',
	'selector'		=> ".fl-node-$id .pp-photo-container .pp-photo-content .pp-photo-content-inner img",
	'prop'			=> 'width',
	'unit'			=> 'px',
) );

// Image Effects
if ( isset( $settings->show_image_effect ) && 'yes' === $settings->show_image_effect ){
	echo pp_image_effect_render_style( $settings, ".fl-node-$id .pp-photo-container .pp-photo-content .pp-photo-content-inner img" );
	echo pp_image_effect_render_style( $settings, ".fl-node-$id .pp-photo-container .pp-photo-content .pp-photo-content-inner:hover img", true );
}
?>
.fl-node-<?php echo $id; ?> .pp-photo-container .pp-photo-content .pp-photo-content-inner a {
    display: block;
    text-decoration: none !important;
}
<?php if( $settings->image_border_type == 'inside' ) { ?>
    <?php if(!empty($settings->link_type)) { ?>
        .fl-node-<?php echo $id; ?> .pp-photo-container .pp-photo-content .pp-photo-content-inner a:before {
            bottom: 0;
            content: '';
            display: block;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            <?php if($settings->image_border_color) { ?>border-color: #<?php echo $settings->image_border_color; ?>;<?php } ?>
            border-style: <?php echo $settings->image_border_style; ?>;
            <?php if($settings->image_border_width) { ?>border-width: <?php echo $settings->image_border_width; ?>px;<?php } ?>
            <?php if($settings->image_spacing) { ?>margin: <?php echo $settings->image_spacing; ?>px;<?php } ?>
			<?php if ( isset( $settings->box_border_group ) && isset( $settings->box_border_group['radius'] ) ) { ?>
				border-top-left-radius: <?php echo $settings->box_border_group['radius']['top_left']; ?>px;
				border-top-right-radius: <?php echo $settings->box_border_group['radius']['top_right']; ?>px;
				border-bottom-left-radius: <?php echo $settings->box_border_group['radius']['bottom_left']; ?>px;
				border-bottom-right-radius: <?php echo $settings->box_border_group['radius']['bottom_right']; ?>px;
			<?php } ?>
			z-index: 99;
			transition: all 0.3s ease;
        }
    <?php } else if( '' ==  $settings->link_type ) { ?>
        .fl-node-<?php echo $id; ?> .pp-photo-container .pp-photo-content .pp-photo-content-inner:before {
            bottom: 0;
            content: '';
            display: block;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            <?php if($settings->image_border_color) { ?>border-color: #<?php echo $settings->image_border_color; ?>;<?php } ?>
            border-style: <?php echo $settings->image_border_style; ?>;
            <?php if($settings->image_border_width) { ?>border-width: <?php echo $settings->image_border_width; ?>px;<?php } ?>
            <?php if($settings->image_spacing) { ?>margin: <?php echo $settings->image_spacing; ?>px;<?php } ?>
			<?php if ( isset( $settings->box_border_group ) && isset( $settings->box_border_group['radius'] ) ) { ?>
				border-top-left-radius: <?php echo $settings->box_border_group['radius']['top_left']; ?>px;
				border-top-right-radius: <?php echo $settings->box_border_group['radius']['top_right']; ?>px;
				border-bottom-left-radius: <?php echo $settings->box_border_group['radius']['bottom_left']; ?>px;
				border-bottom-right-radius: <?php echo $settings->box_border_group['radius']['bottom_right']; ?>px;
			<?php } ?>
			z-index: 99;
			transition: all 0.3s ease;
        }
    <?php } ?>
<?php } ?>
<?php if( $settings->image_border_type == 'outside' ) { ?>
    .fl-node-<?php echo $id; ?> .pp-photo-container .pp-photo-content .pp-photo-content-inner img {
        <?php if($settings->image_border_color) { ?>border-color: #<?php echo $settings->image_border_color; ?>;<?php } ?>
        border-style: <?php echo $settings->image_border_style; ?>;
        <?php if($settings->image_border_width) { ?>border-width: <?php echo $settings->image_border_width; ?>px;<?php } ?>
		<?php if ( isset( $settings->box_border_group ) && isset( $settings->box_border_group['radius'] ) ) { ?>
			border-top-left-radius: <?php echo $settings->box_border_group['radius']['top_left']; ?>px;
			border-top-right-radius: <?php echo $settings->box_border_group['radius']['top_right']; ?>px;
			border-bottom-left-radius: <?php echo $settings->box_border_group['radius']['bottom_left']; ?>px;
			border-bottom-right-radius: <?php echo $settings->box_border_group['radius']['bottom_right']; ?>px;
		<?php } ?>
    }
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-photo-caption {
	<?php if ( $settings->show_caption != 'hover' && isset( $settings->caption_bg_color ) && ! empty( $settings->caption_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->caption_bg_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->caption_text_color ) && ! empty( $settings->caption_text_color ) ) { ?>
    	color: <?php echo pp_get_color_value( $settings->caption_text_color ); ?>;
	<?php } ?>
}

<?php
	// Caption Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'caption_typography',
		'selector' 		=> ".fl-node-$id .pp-photo-caption",
	) );

	// Caption - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'caption_padding',
		'selector' 		=> ".fl-node-$id .pp-photo-caption",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'caption_padding_top',
			'padding-right' 	=> 'caption_padding_right',
			'padding-bottom' 	=> 'caption_padding_bottom',
			'padding-left' 		=> 'caption_padding_left',
		),
	) );
?>

.fl-node-<?php echo $id; ?> .pp-overlay-wrap .pp-overlay-bg {
    <?php if ( isset( $settings->hover_margin ) && !empty( $settings->hover_margin ) ) { ?>
        margin: <?php echo $settings->hover_margin; ?>px;
    <?php } ?>
	<?php if ( isset( $settings->caption_bg_color ) && ! empty( $settings->caption_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->caption_bg_color ); ?>;
	<?php } ?>
    <?php if ( isset( $settings->box_border_group ) && isset( $settings->box_border_group['radius'] ) ) { ?>
		border-top-left-radius: <?php echo $settings->box_border_group['radius']['top_left']; ?>px;
		border-top-right-radius: <?php echo $settings->box_border_group['radius']['top_right']; ?>px;
		border-bottom-left-radius: <?php echo $settings->box_border_group['radius']['bottom_left']; ?>px;
		border-bottom-right-radius: <?php echo $settings->box_border_group['radius']['bottom_right']; ?>px;
	<?php } ?>
}

@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.pp-photo-container .pp-photo-align-responsive-left {
		text-align: left !important;
	}
	.pp-photo-container .pp-photo-align-responsive-center {
		text-align: center !important;
	}
	.pp-photo-container .pp-photo-align-responsive-right {
		text-align: right !important;
	}
}