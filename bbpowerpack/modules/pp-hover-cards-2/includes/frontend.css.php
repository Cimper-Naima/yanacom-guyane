<?php
$cards_desktop			= $settings->hover_card_column_width['desktop'] == '' ? 3 : $settings->hover_card_column_width['desktop'];
$cards_tablet			= $settings->hover_card_column_width['tablet'] === '' ? $cards_desktop : $settings->hover_card_column_width['tablet'];
$cards_mobile			= $settings->hover_card_column_width['mobile'] === '' ? $cards_desktop : $settings->hover_card_column_width['mobile'];
$space_desktop 			= ( $settings->hover_card_column_width['desktop'] - 1 ) * $settings->hover_card_spacing;
$space_tablet 			= ( $settings->hover_card_column_width['tablet'] - 1 ) * $settings->hover_card_spacing;
$space_mobile 			= ( $settings->hover_card_column_width['mobile'] - 1 ) * $settings->hover_card_spacing;
$desktop 				= ( 100 - $space_desktop ) / $cards_desktop;
$tablet 				= ( 100 - $space_tablet ) / $cards_tablet;
$mobile 				= ( 100 - $space_mobile ) / $cards_mobile;
$hover_card_column_w 	= $settings->hover_card_column_width;
$hover_card_column_w 	= (array) $hover_card_column_w;
$max_height_desktop		= (isset( $settings->hover_card_max_height ) && $settings->hover_card_max_height['desktop'] > 0) ? $settings->hover_card_max_height['desktop'] : $settings->hover_card_height['desktop'];
$max_height_tablet		= (isset( $settings->hover_card_max_height ) && $settings->hover_card_max_height['tablet'] > 0) ? $settings->hover_card_max_height['tablet'] : $settings->hover_card_height['tablet'];
$max_height_mobile		= (isset( $settings->hover_card_max_height ) && $settings->hover_card_max_height['mobile'] > 0) ? $settings->hover_card_max_height['mobile'] : $settings->hover_card_height['mobile'];

// Hover Card Title Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'hover_card_title_typography',
	'selector' 		=> ".fl-node-$id .pp-hover-card .pp-hover-card-title-wrap .pp-hover-card-title",
) );
// Hover Card Description Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'hover_card_description_typography',
	'selector' 		=> ".fl-node-$id .pp-hover-card .pp-hover-card-description .pp-hover-card-description-inner",
) );
?>

.fl-node-<?php echo $id; ?> .pp-hover-card {
	min-height: <?php echo $settings->hover_card_height['desktop']; ?>px;
	<?php if ( $max_height_desktop ) { ?>
	max-height: <?php echo $max_height_desktop; ?>px;
	<?php } ?>
	width: <?php echo $desktop; ?>%;
	<?php if ( isset( $settings->hover_card_max_width ) && $settings->hover_card_max_width['desktop'] > 0 ) { ?>
	max-width: <?php echo $settings->hover_card_max_width['desktop']; ?>px;
	<?php } ?>
    margin-right: <?php echo $settings->hover_card_spacing; ?>%;
	margin-bottom: <?php echo $settings->hover_card_spacing; ?>%;
	float: left;
}
.fl-node-<?php echo $id; ?> .pp-hover-card .pp-hover-card-inner {
	min-height: <?php echo $settings->hover_card_height['desktop']; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-hover-card .pp-hover-card-image {
	<?php if ( $settings->hover_card_img_width == '100' ) { ?>
	max-width: 100% !important;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-hover-card.powerpack-style .pp-hover-card-inner {
	display: table;
	width: 100%;
	height: 100%;
}
.fl-node-<?php echo $id; ?> .pp-hover-card.powerpack-style .pp-hover-card-inner-wrap {
	display: table-cell;
    vertical-align: middle;
    text-align: center;
}
.fl-node-<?php echo $id; ?> .pp-hover-card.powerpack-style .pp-hover-card-title-wrap,
.fl-node-<?php echo $id; ?> .pp-hover-card.powerpack-style .pp-hover-card-icon-wrap {
	-webkit-transform: translateY(10px);
	-moz-transform: translateY(10px);
	-ms-transform: translateY(10px);
	transform: translateY(10px);
	-webkit-transition: transform 0.5s ease;
	-moz-transition: transform 0.5s ease;
	-ms-transition: transform 0.5s ease;
	transition: transform 0.5s ease;
}
.fl-node-<?php echo $id; ?> .pp-hover-card.powerpack-style:hover .pp-hover-card-title-wrap,
.fl-node-<?php echo $id; ?> .pp-hover-card.powerpack-style:hover .pp-hover-card-icon-wrap {
	-webkit-transform: translateY(0px);
	-moz-transform: translateY(0px);
	-ms-transform: translateY(0px);
	transform: translateY(0px);
	-webkit-transition: transform 0.5s ease;
	-moz-transition: transform 0.5s ease;
	-ms-transition: transform 0.5s ease;
	transition: transform 0.5s ease;
}
.fl-node-<?php echo $id; ?> .pp-hover-card.powerpack-style .pp-hover-card-description {
	opacity: 0;
    visibility: hidden;
	-webkit-transform: translateY(10px);
	-moz-transform: translateY(10px);
	-ms-transform: translateY(10px);
	transform: translateY(10px);
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-ms-transition: all 0.5s ease;
	transition: all 0.5s ease;
}
.fl-node-<?php echo $id; ?> .pp-hover-card.powerpack-style:hover .pp-hover-card-description {
	opacity: 1;
	visibility: visible;
	-webkit-transform: translateY(0px);
	-moz-transform: translateY(0px);
	-ms-transform: translateY(0px);
	transform: translateY(0px);
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-ms-transition: all 0.5s ease;
	transition: all 0.5s ease;
}

.fl-node-<?php echo $id; ?> .pp-hover-card:nth-of-type(<?php echo $hover_card_column_w['desktop']; ?>n+1) {
    clear: left;
}

.fl-node-<?php echo $id; ?> .pp-hover-card:nth-of-type(<?php echo $hover_card_column_w['desktop']; ?>n) {
    margin-right: 0;
}

<?php
for( $i = 0; $i < count( $settings->card_content ); $i++ ) {
	$card = $settings->card_content[$i];
	if ( is_object( $card->hover_card_box_border_group ) ) {
		$card->hover_card_box_border_group = (array) $card->hover_card_box_border_group;
		foreach ( $card->hover_card_box_border_group as $key => $card_border_field ) {
			if ( is_object( $card_border_field ) ) {
				$card->hover_card_box_border_group[$key] = (array) $card_border_field;
			}
		}
	}
	// Button - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $card,
		'setting_name' 	=> 'hover_card_box_padding',
		'selector' 		=> ".fl-node-$id .pp-hover-card-$i .pp-hover-card-inner",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'hover_card_box_padding_top',
			'padding-right' 	=> 'hover_card_box_padding_right',
			'padding-bottom' 	=> 'hover_card_box_padding_bottom',
			'padding-left' 		=> 'hover_card_box_padding_left',
		),
	) );

	// Form Border - Settings
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $card,
		'setting_name' 	=> 'hover_card_box_border_group',
		'selector' 		=> ".fl-node-$id .pp-hover-card-$i .pp-hover-card-inner",
	) );
?>
	<?php if ( isset($card->hover_card_box_border_group['radius']) ) { ?>
		.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?> {
			border-top-left-radius: <?php echo $card->hover_card_box_border_group['radius']['top_left']; ?>px;
			border-top-right-radius: <?php echo $card->hover_card_box_border_group['radius']['top_right']; ?>px;
			border-bottom-left-radius: <?php echo $card->hover_card_box_border_group['radius']['bottom_left']; ?>px;
			border-bottom-right-radius: <?php echo $card->hover_card_box_border_group['radius']['bottom_right']; ?>px;
		}
	<?php } ?>
	.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?> .pp-hover-card-inner {
		<?php if ( $card->hover_card_bg_type == 'color' ) { ?>
			background: <?php echo $card->hover_card_bg_color == '' ? 'none' : pp_get_color_value($card->hover_card_bg_color); ?>;
		<?php } ?>
		transition: all 0.3s ease-in;
	}

	.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?>:hover .pp-hover-card-inner {
		<?php if ( $card->hover_card_bg_type == 'color' && ! empty( $card->hover_card_bg_hover ) ) { ?>
		background: <?php echo pp_get_color_value($card->hover_card_bg_hover); ?>;
		<?php } ?>
		transition: all 0.3s ease-in;
	}

	.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?>:hover .pp-hover-card-overlay {
		<?php if ( $card->hover_card_bg_type != 'color' ) { ?>
		background: #<?php echo $card->hover_card_overlay; ?>;
		opacity: <?php echo $card->hover_card_overlay_opacity; ?>
		<?php } ?>
	}

	<?php if ( $card->hover_card_bg_type == 'color' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?>:before {
		background: <?php echo $card->hover_card_overlay != '' ? pp_hex2rgba('#'.$card->hover_card_overlay, $card->hover_card_overlay_opacity) : 'none'; ?>;
	}
	<?php } else { ?>
	.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?> {
		background: <?php echo $card->hover_card_overlay != '' ? '#'.$card->hover_card_overlay : 'none'; ?>;
	}
	<?php } ?>

	<?php if ( $settings->style_type == 'powerpack-style' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?> .pp-hover-card-icon {
		font-size: <?php echo $card->hover_card_icon_size; ?>px;
		color: #<?php echo $card->hover_card_icon_color; ?>;
	}
	<?php } ?>

	.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?> .pp-hover-card-content .pp-hover-card-title {
		color: #<?php echo $card->hover_card_title_color; ?>;
	}
	.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?> .pp-hover-card-content .pp-hover-card-description {
		color: #<?php echo $card->hover_card_description_color; ?>;
	}
	.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?>:hover .pp-hover-card-content .pp-hover-card-title {
		color: #<?php echo $card->hover_card_title_color_h; ?>;
	}
	.fl-node-<?php echo $id; ?> .pp-hover-card-<?php echo $i; ?>:hover .pp-hover-card-content .pp-hover-card-description {
		color: #<?php echo $card->hover_card_description_color_h; ?>;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-hover-card .pp-hover-card-title-wrap .pp-hover-card-title {
	margin-top: 0;
	margin-bottom: 10px;
	transition: all 0.3s ease;
}

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> {
		text-align: center;
	}
	.fl-node-<?php echo $id; ?> .pp-hover-card-wrap {
		/*display: inline-block;*/
	}
    .fl-node-<?php echo $id; ?> .pp-hover-card {
		<?php if( $settings->hover_card_height['tablet'] >= 0 ) { ?>
		min-height: <?php echo $settings->hover_card_height['tablet']; ?>px;
		<?php } ?>
		<?php if( $max_height_tablet ) { ?>
		max-height: <?php echo $max_height_tablet; ?>px;
		<?php } ?>
        <?php if( $settings->hover_card_column_width['tablet'] >= 0 ) { ?>
        width: <?php echo $tablet; ?>%;
		<?php } ?>
		<?php if ( isset( $settings->hover_card_max_width ) && $settings->hover_card_max_width['tablet'] > 0 ) { ?>
		max-width: <?php echo $settings->hover_card_max_width['tablet']; ?>px;
		<?php } ?>
		<?php if( $cards_tablet < 2 ) { ?>
		float: none;
		<?php } ?>
		display: inline-block;
    }
	.fl-node-<?php echo $id; ?> .pp-hover-card .pp-hover-card-inner {
		min-height: <?php echo $settings->hover_card_height['tablet']; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-hover-card .pp-hover-card-image {
		width: 100%;
		height: auto;
	}
    .fl-node-<?php echo $id; ?> .pp-hover-card:nth-of-type(<?php echo $settings->hover_card_column_width['desktop']; ?>n+1) {
        clear: none;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card:nth-of-type(<?php echo $settings->hover_card_column_width['tablet']; ?>n+1) {
        clear: left;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card:nth-of-type(<?php echo $settings->hover_card_column_width['desktop']; ?>n) {
        margin-right: <?php echo $settings->hover_card_spacing; ?>%;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card:nth-of-type(<?php echo $settings->hover_card_column_width['tablet']; ?>n) {
        margin-right: 0;
    }
}

@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
    .fl-node-<?php echo $id; ?> .pp-hover-card {
        <?php if( $settings->hover_card_height['mobile'] >= 0 ) { ?>
		min-height: <?php echo $settings->hover_card_height['mobile']; ?>px;
		<?php } ?>
		<?php if( $max_height_mobile ) { ?>
		max-height: <?php echo $max_height_mobile; ?>px;
		<?php } ?>
        <?php if( $settings->hover_card_column_width['mobile'] >= 0 ) { ?>
        width: <?php echo $mobile; ?>%;
		<?php } ?>
		<?php if ( isset( $settings->hover_card_max_width ) && $settings->hover_card_max_width['mobile'] > 0 ) { ?>
		max-width: <?php echo $settings->hover_card_max_width['mobile']; ?>px;
		<?php } ?>
    }
	.fl-node-<?php echo $id; ?> .pp-hover-card .pp-hover-card-inner {
		min-height: <?php echo $settings->hover_card_height['mobile']; ?>px;
	}
    .fl-node-<?php echo $id; ?> .pp-hover-card:nth-of-type(<?php echo $settings->hover_card_column_width['tablet']; ?>n+1) {
            clear: none;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card:nth-of-type(<?php echo $settings->hover_card_column_width['mobile']; ?>n+1) {
            clear: left;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card:nth-of-type(<?php echo $settings->hover_card_column_width['tablet']; ?>n) {
            margin-right: <?php echo $settings->hover_card_spacing; ?>%;
    }
    .fl-node-<?php echo $id; ?> .pp-hover-card:nth-of-type(<?php echo $settings->hover_card_column_width['mobile']; ?>n) {
            margin-right: 0;
    }
}
