.fl-node-<?php echo $id; ?> .pp-instagram-feed-carousel .pp-feed-item {
	<?php if ( ! empty( $settings->image_custom_size ) ) { ?>
	max-width: <?php echo $settings->image_custom_size; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-instagram-feed-grid .pp-feed-item {
	width: calc( 100% / <?php echo $settings->grid_columns; ?> );
	<?php if ( ( 'grid' == $settings->feed_layout || 'square-grid' == $settings->feed_layout ) && '' != $settings->spacing ) { ?>
		padding-left: <?php echo ( $settings->spacing / 2 ); ?>px;
		/*padding-right: <?php echo ( $settings->spacing / 2 ); ?>px;*/
		/*padding-bottom: <?php echo $settings->spacing; ?>px;*/
		margin-bottom: <?php echo ( $settings->spacing / 2 ); ?>px;
	<?php } ?>
	float: left;
}

.fl-node-<?php echo $id; ?> .pp-feed-item img,
.fl-node-<?php echo $id; ?> .pp-feed-item .pp-feed-item-inner {
	-webkit-transition: filter 0.3s ease-in;
	transition: filter 0.3s ease-in;
}

<?php if ( 'yes' == $settings->image_grayscale ) { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed[data-layout="square-grid"] .pp-feed-item .pp-feed-item-inner,
	.fl-node-<?php echo $id; ?> .pp-feed-item img {
		-webkit-filter: grayscale(100%);
		filter: grayscale(100%);
	}
<?php } ?>

<?php if ( 'yes' == $settings->image_hover_grayscale ) { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed[data-layout="square-grid"] .pp-feed-item:hover .pp-feed-item-inner,
	.fl-node-<?php echo $id; ?> .pp-feed-item:hover img {
		-webkit-filter: grayscale(100%);
		filter: grayscale(100%);
	}
<?php } ?>

<?php if ( 'no' == $settings->image_hover_grayscale ) { ?>
	.fl-node-<?php echo $id; ?> .pp-feed-item:hover .pp-feed-item-inner,
	.fl-node-<?php echo $id; ?> .pp-feed-item:hover img {
		filter: none;
	}
<?php } ?>


<?php if( ( 'square-grid' == $settings->feed_layout || 'carousel' == $settings->feed_layout ) && '' != $settings->image_custom_size ) { ?>
.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item-inner {
	width: <?php echo $settings->image_custom_size; ?>px;
	height: <?php echo $settings->image_custom_size; ?>px;
	background-position: center;
	background-repeat: no-repeat;
	background-size: cover;
	position: relative;
}
<?php } ?>

<?php if ( 'grid' == $settings->feed_layout ) { ?>
.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item:before {
<?php } else { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item .pp-feed-item-inner:before {
<?php } ?>
	content: "";
	position: absolute;
	height: 100%;
	width: 100%;
	z-index: 1;
	opacity: 0;
	-webkit-transition: all 0.25s ease-in-out;
	transition: all 0.25s ease-in-out;
}

<?php if ( 'solid' == $settings->image_overlay_type ) { ?>
	<?php if ( 'grid' == $settings->feed_layout ) { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item:before {
	<?php } else { ?>
		.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item .pp-feed-item-inner:before {
	<?php } ?>
	background-color: <?php echo ( $settings->image_overlay_color ) ? pp_hex2rgba( '#' . $settings->image_overlay_color, $settings->image_overlay_opacity / 100 ) : 'transparent'; ?>;
	opacity: <?php echo ( $settings->image_overlay_opacity / 100 ); ?>;
}
<?php } ?>

<?php if ( 'gradient' == $settings->image_overlay_type ) { ?>
	<?php if ( 'grid' == $settings->feed_layout ) { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item:before {
	<?php } else { ?>
		.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item .pp-feed-item-inner:before {
	<?php } ?>
	background-color: transparent;
	<?php if ( 'linear' == $settings->image_overlay_gradient_type ) { ?>
	background-image: linear-gradient(<?php echo $settings->image_overlay_angle; ?>deg, <?php echo '#' . $settings->image_overlay_color; ?> 0%, <?php echo '#' . $settings->image_overlay_secondary_color; ?> 100%);
	<?php } ?>
	<?php if ( 'radial' == $settings->image_overlay_gradient_type ) { ?>
	background-image: radial-gradient(at <?php echo $settings->image_overlay_gradient_position; ?>, <?php echo '#' . $settings->image_overlay_color; ?> 0%, <?php echo '#' . $settings->image_overlay_secondary_color; ?> 100%);
	<?php } ?>
	opacity: <?php echo ( $settings->image_overlay_opacity / 100 ); ?>;
}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item .pp-overlay-container {
	color: <?php echo '#' . $settings->likes_comments_color; ?>;
}
.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item:hover .pp-overlay-container {
	color: <?php echo '#' . $settings->likes_comments_hover_color; ?>;
}

<?php if ( 'none' == $settings->image_hover_overlay_type ) { ?>
	<?php if ( 'grid' == $settings->feed_layout ) { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item:hover:before {
	<?php } else { ?>
		.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item:hover .pp-feed-item-inner:before {
	<?php } ?>
	opacity: 0;
}
<?php } ?>

<?php if ( 'solid' == $settings->image_hover_overlay_type ) { ?>
	<?php if ( 'grid' == $settings->feed_layout ) { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item:hover:before {
	<?php } else { ?>
		.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item:hover .pp-feed-item-inner:before {
	<?php } ?>
	background-color: <?php echo ( $settings->image_hover_overlay_color ) ? pp_hex2rgba( '#' . $settings->image_hover_overlay_color, $settings->image_hover_overlay_opacity / 100 ) : 'transparent'; ?>;
	opacity: <?php echo ( $settings->image_hover_overlay_opacity / 100 ); ?>;
}
<?php } ?>

<?php if ( 'gradient' == $settings->image_hover_overlay_type ) { ?>
	<?php if ( 'grid' == $settings->feed_layout ) { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item:hover:before {
	<?php } else { ?>
		.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item:hover .pp-feed-item-inner:before {
	<?php } ?>
	background-color: transparent;
	<?php if ( 'linear' == $settings->image_hover_overlay_gradient_type ) { ?>
	background-image: linear-gradient(<?php echo $settings->image_hover_overlay_angle; ?>deg, <?php echo '#' . $settings->image_hover_overlay_color; ?> 0%, <?php echo '#' . $settings->image_hover_overlay_secondary_color; ?> 100%);
	<?php } ?>
	<?php if ( 'radial' == $settings->image_hover_overlay_gradient_type ) { ?>
	background-image: radial-gradient(at <?php echo $settings->image_hover_overlay_gradient_position; ?>, <?php echo '#' . $settings->image_hover_overlay_color; ?> 0%, <?php echo '#' . $settings->image_hover_overlay_secondary_color; ?> 100%);
	<?php } ?>
	opacity: <?php echo ( $settings->image_hover_overlay_opacity / 100 ); ?>;
}
<?php } ?>

<?php if ( 'top' == $settings->feed_title_position ) { ?>
.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-instagram-feed-title-wrap {
	top: 0;
	position: absolute;
	left: 50%;
	-webkit-transform: translateX(-50%);
	-ms-transform: translateX(-50%);
	transform: translate(-50%);
}
<?php } ?>

<?php if ( 'bottom' == $settings->feed_title_position ) { ?>
.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-instagram-feed-title-wrap {
	bottom: 0;
	top: auto;
	position: absolute;
	left: 50%;
	-webkit-transform: translateX(-50%);
	-ms-transform: translateX(-50%);
	transform: translate(-50%);
}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-instagram-feed-title-wrap {
	<?php if ( isset( $settings->feed_title_bg_color ) && ! empty( $settings->feed_title_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->feed_title_bg_color ); ?>;
	<?php } ?>
	<?php if ( 0 <= $settings->feed_title_horizontal_padding ) { ?>
		padding-left: <?php echo $settings->feed_title_horizontal_padding; ?>px;
		padding-right: <?php echo $settings->feed_title_horizontal_padding; ?>px;
	<?php } ?>
	<?php if ( 0 <= $settings->feed_title_vertical_padding ) { ?>
		padding-top: <?php echo $settings->feed_title_vertical_padding; ?>px;
		padding-bottom: <?php echo $settings->feed_title_vertical_padding; ?>px;
	<?php } ?>
	transition: all 0.3s ease-in;
}
<?php
	// Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'title_typography',
		'selector' 		=> ".fl-node-$id .pp-instagram-feed .pp-instagram-feed-title-wrap",
	) );

	// Title - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'feed_title_border_group',
		'selector' 		=> ".fl-node-$id .pp-instagram-feed .pp-instagram-feed-title-wrap",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-instagram-feed-title-wrap .pp-instagram-feed-title {
	color: <?php echo '#' . $settings->feed_title_text_color; ?>;
}

.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-instagram-feed-title-wrap:hover {
	<?php if ( isset( $settings->feed_title_bg_hover ) && ! empty( $settings->feed_title_bg_hover ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->feed_title_bg_hover ); ?>;
	<?php } ?>
	<?php if ( $settings->feed_title_border_hover ) { ?> border-color: #<?php echo $settings->feed_title_border_hover; ?>; <?php } ?>
	transition: all 0.3s ease-in;
}

.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-instagram-feed-title-wrap:hover .pp-instagram-feed-title {
	color: <?php echo '#' . $settings->feed_title_text_hover; ?>;
}

.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-swiper-button {
	font-size: <?php echo $settings->arrow_font_size; ?>px;
	<?php if ( $settings->arrow_color ) { ?>
	color: #<?php echo $settings->arrow_color; ?>;
	<?php } ?>
	background: <?php echo ( $settings->arrow_bg_color ) ? '#' . $settings->arrow_bg_color : 'transparent'; ?>;
	<?php if ( 0 <= $settings->arrow_border_radius ) { ?>
	border-radius: <?php echo $settings->arrow_border_radius; ?>px;
	<?php } ?>
	<?php if ( 0 <= $settings->arrow_vertical_padding ) { ?>
		padding-top: <?php echo $settings->arrow_vertical_padding; ?>px;
	<?php } ?>
	<?php if ( 0 <= $settings->arrow_vertical_padding ) { ?>
		padding-bottom: <?php echo $settings->arrow_vertical_padding; ?>px;
	<?php } ?>
	<?php if ( 0 <= $settings->arrow_horizontal_padding ) { ?>
		padding-left: <?php echo $settings->arrow_horizontal_padding; ?>px;
	<?php } ?>
	<?php if ( 0 <= $settings->arrow_horizontal_padding ) { ?>
		padding-right: <?php echo $settings->arrow_horizontal_padding; ?>px;
	<?php } ?>
	<?php if ( $settings->arrow_border_style ) { ?>
		border-style: <?php echo $settings->arrow_border_style; ?>;
	<?php } ?>
	<?php if ( 0 <= $settings->arrow_border_width ) { ?>
		border-width: <?php echo $settings->arrow_border_width; ?>px;
	<?php } ?>
	<?php if ( $settings->arrow_border_color ) { ?>
		border-color: #<?php echo $settings->arrow_border_color; ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-swiper-button:hover {
	<?php if ( $settings->arrow_color_hover ) { ?>
		color: #<?php echo $settings->arrow_color_hover; ?>;
	<?php } ?>
	<?php if ( $settings->arrow_bg_hover ) { ?>
		background: #<?php echo $settings->arrow_bg_hover; ?>;
	<?php } ?>
	<?php if ( $settings->arrow_border_hover ) { ?>
		border-color: #<?php echo $settings->arrow_border_hover; ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-instagram-feed .swiper-pagination-bullet {
	opacity: 1;
	<?php if ( $settings->dot_bg_color ) { ?>
		background: #<?php echo $settings->dot_bg_color; ?>;
	<?php } ?>
	<?php if ( 0 <= $settings->dot_width ) { ?>
		width: <?php echo $settings->dot_width; ?>px;
	<?php } ?>
	<?php if ( 0 <= $settings->dot_width ) { ?>
		height: <?php echo $settings->dot_width; ?>px;
	<?php } ?>
	<?php if ( 0 <= $settings->dot_border_radius ) { ?>
		border-radius: <?php echo $settings->dot_border_radius; ?>px;
	<?php } ?>
	box-shadow: none;
}

.fl-node-<?php echo $id; ?> .pp-instagram-feed .swiper-pagination-bullet:hover,
.fl-node-<?php echo $id; ?> .pp-instagram-feed .swiper-pagination-bullet-active {
	<?php if ( $settings->dot_bg_hover ) { ?>
		background: #<?php echo $settings->dot_bg_hover; ?>;
	<?php } ?>
	opacity: 1;
	box-shadow: none;
}

<?php if ( 'outside' == $settings->dot_position ) { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed-carousel .swiper-container {
		padding-bottom: 40px;
	}
	.fl-node-<?php echo $id; ?> .pp-instagram-feed-carousel .swiper-pagination {
		bottom: 0;
	}
<?php } ?> 

@media only screen and ( max-width:<?php echo $global_settings->medium_breakpoint; ?>px ) {
	.fl-node-<?php echo $id; ?> .pp-instagram-feed-grid .pp-feed-item {
		width: calc( 100% / <?php echo $settings->grid_columns_medium; ?> );
		<?php if ( ( 'grid' == $settings->feed_layout || 'square-grid' == $settings->feed_layout ) && '' != $settings->spacing_medium ) { ?>
			padding-left: <?php echo ( $settings->spacing_medium / 2 ); ?>px;
			padding-right: <?php echo ( $settings->spacing_medium / 2 ); ?>px;
			padding-bottom: <?php echo $settings->spacing_medium; ?>px;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-instagram-feed-title-wrap {
		<?php if ( 0 <= $settings->feed_title_horizontal_padding_medium ) { ?>
			padding-left: <?php echo $settings->feed_title_horizontal_padding_medium; ?>px;
			padding-right: <?php echo $settings->feed_title_horizontal_padding_medium; ?>px;
		<?php } ?>
		<?php if ( 0 <= $settings->feed_title_vertical_padding_medium ) { ?>
			padding-top: <?php echo $settings->feed_title_vertical_padding_medium; ?>px;
			padding-bottom: <?php echo $settings->feed_title_vertical_padding_medium; ?>px;
		<?php } ?>
	}
	<?php if( ( 'square-grid' == $settings->feed_layout || 'carousel' == $settings->feed_layout ) && '' != $settings->image_custom_size_medium ) { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item-inner {
		width: <?php echo $settings->image_custom_size_medium; ?>px;
		height: <?php echo $settings->image_custom_size_medium; ?>px;
	}
	<?php } ?>
	<?php if ( 'carousel' == $settings->feed_layout && $settings->visible_items_medium == '1' ) { ?>
		.fl-node-<?php echo $id; ?> .pp-instagram-feed-carousel .swiper-container {
			max-width: <?php echo $settings->image_custom_size_medium; ?>px;
		}
	<?php } ?>
}

@media only screen and ( max-width:<?php echo $global_settings->responsive_breakpoint; ?>px ) {
	.fl-node-<?php echo $id; ?> .pp-instagram-feed-grid .pp-feed-item {
		width: calc( 100% / <?php echo $settings->grid_columns_responsive; ?> );
		<?php if ( ( 'grid' == $settings->feed_layout || 'square-grid' == $settings->feed_layout ) && '' != $settings->spacing_responsive ) { ?>
			padding-left: <?php echo ( $settings->spacing_responsive / 2 ); ?>px;
			padding-right: <?php echo ( $settings->spacing_responsive / 2 ); ?>px;
			padding-bottom: <?php echo $settings->spacing_responsive; ?>px;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-instagram-feed-title-wrap {
		<?php if ( 0 <= $settings->feed_title_horizontal_padding_responsive ) { ?>
			padding-left: <?php echo $settings->feed_title_horizontal_padding_responsive; ?>px;
			padding-right: <?php echo $settings->feed_title_horizontal_padding_responsive; ?>px;
		<?php } ?>
		<?php if ( 0 <= $settings->feed_title_vertical_padding_responsive ) { ?>
			padding-top: <?php echo $settings->feed_title_vertical_padding_responsive; ?>px;
			padding-bottom: <?php echo $settings->feed_title_vertical_padding_responsive; ?>px;
		<?php } ?>
	}
	<?php if( ( 'square-grid' == $settings->feed_layout || 'carousel' == $settings->feed_layout ) && '' != $settings->image_custom_size_responsive ) { ?>
	.fl-node-<?php echo $id; ?> .pp-instagram-feed .pp-feed-item-inner {
		width: <?php echo '-1' === $settings->image_custom_size_responsive ? '100%' : $settings->image_custom_size_responsive . 'px'; ?>;
		height: <?php echo $settings->image_custom_size_responsive; ?>px;
	}
	<?php } ?>
	<?php if ( 'carousel' == $settings->feed_layout && $settings->visible_items_responsive == '1' ) { ?>
		.fl-node-<?php echo $id; ?> .pp-instagram-feed-carousel .swiper-container {
			max-width: <?php echo $settings->image_custom_size_responsive; ?>px;
		}
	<?php } ?>
}
