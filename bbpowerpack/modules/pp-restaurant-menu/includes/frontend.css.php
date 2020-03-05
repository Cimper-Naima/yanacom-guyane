<?php
    $number_show = $settings->large_device_columns;
    $width = '100';
    if( $number_show == 5 ) {
     	$width = '18.4';
    } elseif( $number_show == 4 ) {
     	$width = '23.5';
    } elseif( $number_show == 3 ) {
     	$width = '32';
    } elseif( $number_show == 2 ) {
     	$width = '48';
	}
// Heading Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'heading_border_group',
	'selector' 		=> ".fl-node-$id .pp-restaurant-menu-heading",
) );
// Heading Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'card_border_group',
	'selector' 		=> ".fl-node-$id .pp-menu-item",
) );
// Card Items Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'card_padding_group',
	'selector' 		=> ".fl-node-$id .pp-restaurant-menu-item,
            			.fl-node-$id .pp-restaurant-menu-item-inline",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'card_padding_group_top',
		'padding-right' 	=> 'card_padding_group_right',
		'padding-bottom' 	=> 'card_padding_group_bottom',
		'padding-left' 		=> 'card_padding_group_left',
	),
) );
// Card Items margin
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'card_margin_group',
	'selector' 		=> ".fl-node-$id .pp-restaurant-menu-item,
            			.fl-node-$id .pp-restaurant-menu-item-inline",
	'unit'			=> 'px',
	'props'			=> array(
		'margin-top' 		=> 'card_margin_group_top',
		'margin-right' 		=> 'card_margin_group_right',
		'margin-bottom' 	=> 'card_margin_group_bottom',
		'margin-left' 		=> 'card_margin_group_left',
	),
) );
// Form Menu Heading Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'menu_heading_typography',
	'selector' 		=> ".fl-node-$id .pp-restaurant-menu-heading",
) );
// Form Items Title Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'items_title_typography',
	'selector' 		=> ".fl-node-$id .pp-restaurant-menu-item-title,
						.fl-node-$id .pp-restaurant-menu-item-wrap-in h2",
) );
// Form Items description Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'items_description_typography',
	'selector' 		=> ".fl-node-$id .pp-restaurant-menu-item-description",
) );
// Form Items Price Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'items_price_typography',
	'selector' 		=> ".fl-node-$id .pp-restaurant-menu-item-price",
) );
?>

.fl-node-<?php echo $id; ?> .pp-menu-item {
    margin-left: 2%;
    width: <?php echo $width; ?>%;
	float: left;
    <?php if ( $settings->card_bg_type == 'color' ) { ?>
        background-color: <?php echo pp_get_color_value($settings->card_bg); ?>;
    <?php } ?>
    <?php if ( 'color' == $settings->card_bg_type || 'none' != $settings->card_border_group['style'] ) { ?>
        padding-left: 10px;
        padding-right: 10px;
    <?php } ?>
	overflow: hidden;
}

.fl-node-<?php echo $id; ?> .pp-menu-item .pp-restaurant-menu-item-left,
.fl-node-<?php echo $id; ?> .pp-menu-item .pp-restaurant-menu-item-right {
    <?php if ( $settings->restaurant_menu_layout == 'stacked' && ( 'color' == $settings->card_bg_type || 'none' != $settings->card_border_group['style'] ) ) { ?>
        padding-left: 0;
        padding-right: 0;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-menu-item:nth-child(<?php echo (int) $number_show; ?>n+1) {
	margin-left: 0% !important;
	clear: left;
}

.fl-node-<?php echo $id; ?> .pp-restaurant-menu-heading {
    <?php if ( $settings->heading_bg_type == 'color' ) { ?>
        background-color: <?php echo pp_get_color_value($settings->heading_bg); ?>;
    <?php } ?>
    margin-top: <?php echo is_numeric($settings->heading_margin['top']) ? $settings->heading_margin['top'] : '0'; ?>px;
    margin-right: 0;
    margin-bottom: <?php echo is_numeric($settings->heading_margin['bottom']) ? $settings->heading_margin['bottom'] : '0'; ?>px;
    margin-left: 0;
    padding-top: <?php echo is_numeric($settings->heading_padding['top']) ? $settings->heading_padding['top'] : '0'; ?>px;
    padding-right: <?php echo $settings->heading_bg_type == 'color' ? 10 : 0; ?>px;
    padding-bottom: <?php echo is_numeric($settings->heading_padding['bottom']) ? $settings->heading_padding['bottom'] : '0'; ?>px;
    padding-left: <?php echo $settings->heading_bg_type == 'color' ? 10 : 0; ?>px;
}

 <?php
	 if ( 'none' == $settings->card_border_group['style'] ) {
	 	?>
		 	.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-wrap-in .pp-restaurant-menu-item-inline h2{
				padding-top: 0px !important;
			}
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline .pp-restaurant-menu-item-price{
				padding: 0px;
			}
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item .pp-restaurant-menu-item-left{
				padding-left: 0px;
			}
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item .pp-restaurant-menu-item-right{
				padding-right: 0px;
			}
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline-right-content{
 				padding-left: 0px;
 			}

		<?php
	 }
?>

<?php
    if ( $settings->card_bg_type == 'color' ) {
       ?>
            .fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline .pp-restaurant-menu-item-price {
               padding-right: 0;
            }
       <?php
    }
?>

<?php
    if ( $settings->card_border_group['width']['right'] > 0 ) {
	 	?>
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline {
				padding-bottom: 0px;
			}
		}
		<?php
	}
 ?>

.fl-node-<?php echo $id; ?> .pp-restaurant-menu-heading {
	color: <?php echo pp_get_color_value( $settings->menu_heading_color ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-title {
	color: <?php echo pp_get_color_value( $settings->menu_title_color ); ?>;
    <?php if ( $settings->restaurant_menu_layout == 'stacked' ) { ?>
		padding-top: 10px;
		display: inline-block;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-wrap-in h2 {
    <?php if ( $settings->show_description == 'no' ) { ?>
        margin-bottom: 0 !important;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-description {
    color: <?php echo pp_get_color_value( $settings->menu_description_color ); ?>;
}

.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-price {
	color: <?php echo pp_get_color_value( $settings->menu_price_color); ?>;
    <?php if ( $settings->show_price == 'no' ) { ?>
	    display: none !important;
    <?php } ?>
    <?php if ( $settings->restaurant_menu_layout == 'stacked' ) { ?>
        padding-top: 10px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline .pp-restaurant-menu-item-images {
	<?php if ( $settings->inline_image_width >= 0 ) { ?>
	width: <?php echo $settings->inline_image_width; ?>%;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline .pp-restaurant-menu-item-inline-right-content {
	<?php if ( $settings->inline_image_width >= 0 ) { ?>
		<?php if ( $settings->show_price == 'no' || empty( $menu_item->menu_items_price ) ) { ?>
			width: <?php echo 100 - floatval($settings->inline_image_width); ?>%;
		<?php } else { ?>
			width: <?php echo 80 - floatval($settings->inline_image_width); ?>%;
		<?php } ?>
	<?php } ?>
}

 <?php
	 if ( $settings->large_device_columns == '2' ) {
	 	?>
			.fl-node-<?php echo $id; ?> .pp-menu-item {
					margin-left: 4% !important;
			}
		<?php
	 }
 ?>

 <?php
	 if ( ( $settings->card_border_group['width']['bottom'] > '0') && ( $settings->card_border_group['width']['top'] == 0) && ( $settings->card_border_group['width']['right'] == 0) && ( $settings->card_border_group['width']['left'] == 0) ) {
	 	?>
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item .pp-restaurant-menu-item-left {
				padding-left: 0px !important;
			}
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item .pp-restaurant-menu-item-right {
				padding-right: 0px !important;
			}
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline-right-content {
				padding-left: 0px !important;
			}
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline .pp-restaurant-menu-item-images {
				margin-bottom : 10px;
			}
		<?php
	}
?>

<?php
foreach ( $settings->menu_items as $key => $menu_item ) {
	if ( $menu_item->restaurant_select_images == 'none' ){
	 	?>
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline-<?php echo $key; ?> .pp-restaurant-menu-item-inline-right-content {
				<?php if ( $settings->show_price == 'no' || empty( $menu_item->menu_items_price ) ) { ?>
					width: 100% !important;
				<?php } else { ?>
 					width: 80% !important;
				<?php } ?>
 				padding-bottom: 20px;
 			}
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline-<?php echo $key; ?> .pp-restaurant-menu-item-wrap-in pp-restaurant-menu-item-inline h2 {
				padding-top: 0px !important;
			}
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline-<?php echo $key; ?> .pp-restaurant-menu-item-inline .pp-restaurant-menu-item-images {
				display : none;
			}
			.fl-node-<?php echo $id; ?> .pp-restaurant-menu-item-inline-<?php echo $key; ?> .pp-restaurant-menu-item .pp-restaurant-menu-item-images {
				display : none;
			}
		<?php
    } elseif ( $settings->text_alignment == 'center' ) { ?>
        .fl-node-<?php echo $id; ?> .pp-menu-item-<?php echo $key; ?> .pp-restaurant-menu-item-title {
            display: inline-block;
        }
    <?php }
	?>
<?php } ?>

<?php if ( $settings->text_alignment == 'center' && $settings->restaurant_menu_layout != 'inline' ) { ?>
    .fl-node-<?php echo $id; ?> .pp-menu-item {
        <?php if ( $settings->card_bg_type == 'color' ) { ?>
            padding-bottom: 10px;
            padding-top: 10px;
        <?php } else { ?>
            margin-bottom: 0;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-menu-item .pp-restaurant-menu-item-images {
        width: 100% !important;
        padding: 0 !important;
    }
    .fl-node-<?php echo $id; ?> .pp-menu-item .pp-menu-item-content,
    .fl-node-<?php echo $id; ?> .pp-menu-item .pp-restaurant-menu-item-left {
        width: 100% !important;
        padding-bottom: 0;
        text-align: center !important;
    }
    .fl-node-<?php echo $id; ?> .pp-menu-item .pp-restaurant-menu-item-price,
    .fl-node-<?php echo $id; ?> .pp-menu-item .pp-restaurant-menu-item-right {
        width: 100% !important;
        padding-top: 5px;
        text-align: center !important;
    }
    .fl-node-<?php echo $id; ?> .pp-menu-item .pp-restaurant-menu-item-price {
        padding-top: 0;
        padding-bottom: 0;
    }
    .fl-node-<?php echo $id; ?> .pp-menu-item .pp-menu-item-unit {
        display: inline;
    }
<?php } ?>

@media (max-width: <?php echo $global_settings->medium_breakpoint; ?>px){
	<?php
		$number_column_medium_device = $settings->medium_device_columns;
		$width_medium = '100';
		if( $number_column_medium_device == 5 ) {
			$width_medium = '18.4';
		}elseif( $number_column_medium_device == 4 ) {
			$width_medium = '23.5';
		}elseif( $number_column_medium_device == 3 ) {
			$width_medium = '32';
		}elseif( $number_column_medium_device == 2 ) {
			$width_medium = '48';
		}

	?>
	.fl-node-<?php echo $id; ?> .pp-menu-item:nth-child(n+1) {
		width: <?php echo $width_medium; ?>%;
		margin-left: 2% !important;
		clear: none !important;
	}
	.fl-node-<?php echo $id; ?> .pp-menu-item:nth-child(<?php echo (int) $number_column_medium_device; ?>n+1) {
		margin-left: 0% !important;
		clear: left !important;
	}
}
@media (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px){
	<?php
		$number_column_small_device = $settings->small_device_columns;
		$width_small = '100';
		if( $number_column_small_device == 3 ) {
			$width_small = '32';
		}elseif( $number_column_small_device == 2 ) {
			$width_small = '48';
		}

	?>
	.fl-node-<?php echo $id; ?> .pp-menu-item:nth-child(n+1) {
		width: <?php echo $width_small; ?>%;
		margin-left: 2% !important;
		clear: none !important;
	}
	.fl-node-<?php echo $id; ?> .pp-menu-item:nth-child(<?php echo (int) $number_column_small_device; ?>n+1) {
		margin-left: 0% !important;
		clear: left !important;
	}
	.fl-node-<?php echo $id; ?> .pp-menu-item{
		margin-bottom: 20px;
	}
}
