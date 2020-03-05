<?php
$space_desktop = ( $settings->hover_card_columns - 1 ) * $settings->hover_card_spacing;
$space_tablet = ( $settings->hover_card_columns_medium - 1 ) * $settings->hover_card_spacing;
$space_mobile = ( $settings->hover_card_columns_responsive - 1 ) * $settings->hover_card_spacing;
$hover_card_columns_desktop = ( 100 - $space_desktop ) / $settings->hover_card_columns;
$hover_card_columns_tablet = ( 100 - $space_tablet ) / $settings->hover_card_columns_medium;
$hover_card_columns_mobile = ( 100 - $space_mobile ) / $settings->hover_card_columns_responsive; ?>

<?php
FLBuilderCSS::rule( array(
    'selector'  => ".fl-node-$id .pp-hover-card-container",
    'props'     => array(
        'width'     => array(
            'value'     => $hover_card_columns_desktop,
            'unit'      => '%'
        ),
        'margin-right'  => array(
            'value'         => $settings->hover_card_spacing,
            'unit'          => '%'
        ),
        'margin-bottom' => array(
            'value'         => $settings->hover_card_spacing,
            'unit'          => '%'
        ),
        'float'     => array(
            'value'     => 'left'
        )
    )
) );
?>

<?php
// Card - Height
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'hover_card_height',
	'selector'		=> ".fl-node-$id .pp-hover-card-container",
	'prop'			=> 'height',
	'unit'			=> 'px',
) );
?>

.fl-node-<?php echo $id; ?> .pp-hover-card-container:nth-of-type(<?php echo $settings->hover_card_columns; ?>n+1) {
    clear: left;
}

.fl-node-<?php echo $id; ?> .pp-hover-card-container:nth-of-type(<?php echo $settings->hover_card_columns; ?>n) {
    margin-right: 0;
}

<?php $number_cards = count($settings->card_content);
for($i = 0; $i < $number_cards; $i++) {
	$cards = $settings->card_content[$i];
	if ( is_object( $cards->card_box_border ) ) {
		$cards->card_box_border = (array) $cards->card_box_border;
		foreach ( $cards->card_box_border as $key => $card_border_field ) {
			if ( is_object( $card_border_field ) ) {
				$cards->card_box_border[$key] = (array) $card_border_field;
			}
		}
	}
	?>
	<?php if( $cards->hover_card_bg_type == 'image' ) { ?>
		.fl-node-<?php echo $id; ?> .hover-card-<?php echo $i; ?> .pp-hover-card:hover {
			background: <?php echo ($cards->hover_card_overlay) ? pp_hex2rgba('#'.$cards->hover_card_overlay, $cards->hover_card_overlay_opacity) : 'transparent'; ?>;
		}
		.fl-node-<?php echo $id; ?> .pp-hover-card-container.style-2:hover .pp-hover-card-overlay {
			opacity: 0.1;
		}
	<?php } ?>
	.fl-node-<?php echo $id; ?> .hover-card-<?php echo $i; ?> .pp-hover-card-overlay {
		<?php if ( isset( $cards->card_box_border ) && isset( $cards->card_box_border['radius'] ) ) { ?>
			border-top-left-radius: <?php echo $cards->card_box_border['radius']['top_left']; ?>px;
			border-top-right-radius: <?php echo $cards->card_box_border['radius']['top_right']; ?>px;
			border-bottom-left-radius: <?php echo $cards->card_box_border['radius']['bottom_left']; ?>px;
			border-bottom-right-radius: <?php echo $cards->card_box_border['radius']['bottom_right']; ?>px;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-hover-card-container.hover-card-<?php echo $i; ?> {
		<?php if ( isset( $cards->card_box_border ) && isset( $cards->card_box_border['radius'] ) ) { ?>
			border-top-left-radius: <?php echo $cards->card_box_border['radius']['top_left']; ?>px;
			border-top-right-radius: <?php echo $cards->card_box_border['radius']['top_right']; ?>px;
			border-bottom-left-radius: <?php echo $cards->card_box_border['radius']['bottom_left']; ?>px;
			border-bottom-right-radius: <?php echo $cards->card_box_border['radius']['bottom_right']; ?>px;
		<?php } ?>
		background-color: <?php echo ($cards->hover_card_bg_color) ? '#'.$cards->hover_card_bg_color : 'transparent'; ?>;
		<?php if( $cards->hover_card_box_image && $cards->hover_card_bg_type == 'image' ) { ?>
		background-image: url('<?php echo $cards->hover_card_box_image_src; ?>');
		background-repeat: no-repeat;
		background-size: cover;
		<?php } ?>
	}

	<?php

	// Box - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $cards,
		'setting_name' 	=> 'hover_card_box_padding',
		'selector' 		=> ".fl-node-$id .pp-hover-card-container.hover-card-$i .pp-hover-card-inner",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'hover_card_box_padding_top',
			'padding-right' 	=> 'hover_card_box_padding_right',
			'padding-bottom' 	=> 'hover_card_box_padding_bottom',
			'padding-left' 		=> 'hover_card_box_padding_left',
		),
	) );

	// Box - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $cards,
		'setting_name' 	=> 'card_box_border',
		'selector' 		=> ".fl-node-$id .pp-hover-card-container.hover-card-$i .pp-hover-card .pp-hover-card-border",
	) );
	?>	

	.fl-node-<?php echo $id; ?> .hover-card-<?php echo $i; ?>.powerpack-style:hover .pp-hover-card-description {
		opacity: 1;
	}

	.fl-node-<?php echo $id; ?> .hover-card-<?php echo $i; ?>.powerpack-style:hover .pp-more-link {
		opacity: 1;
	}


	.fl-node-<?php echo $id; ?> .pp-hover-card-container.hover-card-<?php echo $i; ?> .pp-hover-card-title h3 {
		<?php if( $cards->hover_card_title_color ) { ?>color: #<?php echo $cards->hover_card_title_color; ?>;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-hover-card-container.hover-card-<?php echo $i; ?>:hover .pp-hover-card-title h3 {
		<?php if( $cards->hover_card_title_color_h ) { ?>color: #<?php echo $cards->hover_card_title_color_h; ?>;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-hover-card-container.hover-card-<?php echo $i; ?> .pp-hover-card-description {
		<?php if( $cards->hover_card_description_color ) { ?>color: #<?php echo $cards->hover_card_description_color; ?>;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-hover-card-container.hover-card-<?php echo $i; ?>:hover .pp-hover-card-description {
		<?php if( $cards->hover_card_description_color_h ) { ?>color: #<?php echo $cards->hover_card_description_color_h; ?>;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-hover-card-container.hover-card-<?php echo $i; ?> .pp-hover-card .icon {
		<?php if( $cards->hover_card_icon_color ) { ?>color: #<?php echo $cards->hover_card_icon_color; ?>;<?php } ?>
	}
	<?php
	// Icon - Size
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $cards,
		'setting_name'	=> 'hover_card_icon_size',
		'selector'		=> ".fl-node-$id .pp-hover-card-container.hover-card-$i .pp-hover-card .icon",
		'prop'			=> 'font-size',
		'unit'			=> 'px',
	) );

	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $cards,
		'setting_name'	=> 'hover_card_icon_size',
		'selector'		=> ".fl-node-$id .pp-hover-card-container.hover-card-$i .pp-hover-card .icon",
		'prop'			=> 'width',
		'unit'			=> 'px',
	) );
	?>
	.fl-node-<?php echo $id; ?> .pp-hover-card-container.hover-card-<?php echo $i; ?>:hover .pp-hover-card .icon {
		<?php if( $cards->hover_card_icon_color_h ) { ?>color: #<?php echo $cards->hover_card_icon_color_h; ?>;<?php } ?>
	}


/* Button */
	.fl-node-<?php echo $id; ?> .pp-hover-card-container.hover-card-<?php echo $i; ?> .pp-hover-card .pp-hover-card-inner .pp-more-link {
		<?php if ( isset( $cards->button_bg_color ) && ! empty( $cards->button_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $cards->button_bg_color ); ?>;
		<?php } ?>
		<?php if ( isset( $cards->button_text_color ) && ! empty( $cards->button_text_color ) ) { ?>
		color: <?php echo pp_get_color_value( $cards->button_text_color ); ?>;
		<?php } ?>
	}
	<?php
	// Button - Width
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $cards,
		'setting_name'	=> 'button_width',
		'selector'		=> ".fl-node-$id .pp-hover-card-container.hover-card-$i .pp-hover-card .pp-hover-card-inner .pp-more-link",
		'prop'			=> 'width',
		'unit'			=> 'px',
	) );

	// Button - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $cards,
		'setting_name' 	=> 'button_padding',
		'selector' 		=> ".fl-node-$id .pp-hover-card-container.hover-card-$i .pp-hover-card .pp-hover-card-inner .pp-more-link",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'button_padding_top',
			'padding-right' 	=> 'button_padding_right',
			'padding-bottom' 	=> 'button_padding_bottom',
			'padding-left' 		=> 'button_padding_left',
		),
	) );

	// Button - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $cards,
		'setting_name' 	=> 'button_border_group',
		'selector' 		=> ".fl-node-$id .pp-hover-card-container.hover-card-$i .pp-hover-card .pp-hover-card-inner .pp-more-link",
	) );
	?>
	.fl-node-<?php echo $id; ?> .pp-hover-card-container.hover-card-<?php echo $i; ?> .pp-hover-card .pp-hover-card-inner .pp-more-link:hover {
		<?php if ( isset( $cards->button_bg_hover ) && ! empty( $cards->button_bg_hover ) ) { ?>
		background-color: <?php echo pp_get_color_value( $cards->button_bg_hover ); ?>;
		<?php } ?>
		<?php if ( isset( $cards->button_text_hover ) && ! empty( $cards->button_text_hover ) ) { ?>
		color: <?php echo pp_get_color_value( $cards->button_text_hover ); ?>;
		<?php } ?>
		<?php if( $cards->button_border_hover_color ) { ?>border-color: #<?php echo $cards->button_border_hover_color; ?>;<?php } ?>
	}

<?php } ?>

.fl-node-<?php echo $id; ?> .pp-hover-card-container .pp-hover-card-title h3 {
	<?php if( $settings->hover_card_title_margin['hover_card_title_margin_top'] ) { ?>margin-top: <?php echo $settings->hover_card_title_margin['hover_card_title_margin_top']; ?>px;<?php } ?>
	<?php if( $settings->hover_card_title_margin['hover_card_title_margin_bottom'] ) { ?>margin-bottom: <?php echo $settings->hover_card_title_margin['hover_card_title_margin_bottom']; ?>px;<?php } ?>
}
<?php
// Title Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'card_title_typography',
	'selector' 		=> ".fl-node-$id .pp-hover-card-container .pp-hover-card-title h3",
) );
?>

.fl-node-<?php echo $id; ?> .pp-hover-card-container .pp-hover-card-description {
	<?php if( $settings->hover_card_description_margin['hover_card_description_margin_top'] ) { ?>margin-top: <?php echo $settings->hover_card_description_margin['hover_card_description_margin_top']; ?>px;<?php } ?>
	<?php if( $settings->hover_card_description_margin['hover_card_description_margin_bottom'] ) { ?>margin-bottom: <?php echo $settings->hover_card_description_margin['hover_card_description_margin_bottom']; ?>px;<?php } ?>
}
<?php
// Description Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'card_description_typography',
	'selector' 		=> ".fl-node-$id .pp-hover-card-container .pp-hover-card-description",
) );

// Button Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'button_typography',
	'selector' 		=> ".fl-node-$id .pp-hover-card .pp-hover-card-inner .pp-more-link",
) );
?>

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
    div.fl-node-<?php echo $id; ?> .pp-hover-card-container {
        <?php if( $settings->hover_card_columns_medium >= 0 ) { ?>
        width: <?php echo $hover_card_columns_tablet; ?>%;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card-container:nth-of-type(<?php echo $settings->hover_card_columns; ?>n+1) {
        clear: none;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card-container:nth-of-type(<?php echo $settings->hover_card_columns_medium; ?>n+1) {
        clear: left;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card-container:nth-of-type(<?php echo $settings->hover_card_columns; ?>n) {
        margin-right: <?php echo $settings->hover_card_spacing; ?>%;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card-container:nth-of-type(<?php echo $settings->hover_card_columns_medium; ?>n) {
        margin-right: 0;
    }
}

@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
    div.fl-node-<?php echo $id; ?> .pp-hover-card-container {
        <?php if( $settings->hover_card_columns_responsive >= 0 ) { ?>
        width: <?php echo $hover_card_columns_mobile; ?>%;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card-container:nth-of-type(<?php echo $settings->hover_card_columns_medium; ?>n+1) {
        clear: none;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card-container:nth-of-type(<?php echo $settings->hover_card_columns_responsive; ?>n+1) {
        clear: left;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card-container:nth-of-type(<?php echo $settings->hover_card_columns_medium; ?>n) {
        margin-right: <?php echo $settings->hover_card_spacing; ?>%;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card-container:nth-of-type(<?php echo $settings->hover_card_columns_responsive; ?>n) {
        margin-right: 0;
    }
}
