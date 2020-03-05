.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content {
	<?php if ( ! empty( $settings->post_timeline_background ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
	<?php } ?>
}

<?php
	// Box - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'post_timeline_border',
		'selector' 		=> ".fl-node-$id .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper:before {
	border-right-color: <?php echo ($settings->post_timeline_line_color) ? '#'.$settings->post_timeline_line_color : '#000'; ?>;
	border-right-style: <?php echo $settings->post_timeline_line_style ?>;
	border-right-width: <?php echo ($settings->post_timeline_line_width >= 0) ? $settings->post_timeline_line_width : '1'; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-post-timeline .pp-post-timeline-content-wrapper:after {
	border-color: <?php echo ($settings->post_timeline_line_color) ? '#'.$settings->post_timeline_line_color : '#000'; ?>;
}
.fl-node-<?php echo $id; ?> .pp-post-timeline.horizontal .pp-post-timeline-content-wrapper:before {
	border-right: 0;
	border-top-style: <?php echo $settings->post_timeline_line_style ?>;
	border-top-width: <?php echo ($settings->post_timeline_line_width >= 0) ? $settings->post_timeline_line_width : '1'; ?>px;
	border-top-color: <?php echo ($settings->post_timeline_line_color) ? '#'.$settings->post_timeline_line_color : '#000'; ?>;
}
.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title-wrapper {
	<?php if ( isset( $settings->title_bg_color ) && ! empty( $settings->title_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
	<?php } ?>
	<?php if( $settings->title_border != '' ) { ?>
		border-bottom-width: <?php echo $settings->title_border; ?>px;
		border-bottom-color: #<?php echo $settings->title_border_color; ?>;
		border-bottom-style: solid;
	<?php } ?>
	padding-top: <?php echo ( $settings->title_vertical_padding != '') ? $settings->title_vertical_padding.'px' : '20px'; ?>;
	padding-bottom: <?php echo ( $settings->title_vertical_padding != '') ? $settings->title_vertical_padding.'px' : '20px'; ?>;
	padding-left: <?php echo ( $settings->title_horizontal_padding != '') ? $settings->title_horizontal_padding.'px' : '20px'; ?>;
	padding-right: <?php echo ( $settings->title_horizontal_padding != '') ? $settings->title_horizontal_padding.'px' : '20px'; ?>;
}
.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title {
	<?php if($settings->title_text_color) { ?>color: #<?php echo $settings->title_text_color; ?>;<?php } ?>
}

<?php
	// Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'title_typography',
		'selector' 		=> ".fl-node-$id .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title a {
	<?php if($settings->title_text_color) { ?>color: #<?php echo $settings->title_text_color; ?>;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-meta {
	<?php if($settings->meta_text_color) { ?>color: #<?php echo $settings->meta_text_color; ?>;<?php } ?>
}
<?php
	// Meta Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'meta_typography',
		'selector' 		=> ".fl-node-$id .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-meta",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-meta a {
	<?php if($settings->meta_link_color) { ?>color: #<?php echo $settings->meta_link_color; ?>;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-meta a:hover {
	<?php if($settings->meta_link_hover) { ?>color: #<?php echo $settings->meta_link_hover; ?>;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-text-wrapper {
	<?php if( $settings->content_color ) { ?>color: #<?php echo $settings->content_color; ?>;<?php } ?>
	padding-top: <?php echo ( $settings->content_vertical_padding != '') ? $settings->content_vertical_padding.'px' : '20px'; ?>;
	padding-bottom: <?php echo ( $settings->content_vertical_padding != '') ? $settings->content_vertical_padding.'px' : '20px'; ?>;
	padding-left: <?php echo ( $settings->content_horizontal_padding != '') ? $settings->content_horizontal_padding.'px' : '20px'; ?>;
	padding-right: <?php echo ( $settings->content_horizontal_padding != '') ? $settings->content_horizontal_padding.'px' : '20px'; ?>;
}

<?php
	// Text Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'text_typography',
		'selector' 		=> ".fl-node-$id .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-text-wrapper",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-icon .pp-timeline-icon,
.fl-node-<?php echo $id; ?> .pp-post-timeline.horizontal .pp-post-timeline-slide-navigation .pp-timeline-icon {
	<?php if( $settings->icon_size >= 0 ) { ?>font-size: <?php echo $settings->icon_size; ?>px;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon,
.fl-node-<?php echo $id; ?> .pp-post-timeline.horizontal .pp-post-timeline-slide-navigation .pp-post-timeline-icon {
	<?php if ( isset( $settings->icon_bg_color ) && ! empty( $settings->icon_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->icon_bg_color ); ?>;
	<?php } ?>
	border-color: <?php echo ($settings->icon_border_color) ? '#'.$settings->icon_border_color : 'transparent'; ?>;
	border-style: <?php echo $settings->icon_border_style ?>;
	border-radius: <?php echo ($settings->icon_border_radius >= 0) ? $settings->icon_border_radius : '0'; ?>px;
	border-width: <?php echo ($settings->icon_border_width >= 0) ? $settings->icon_border_width : '0'; ?>px;
	color: <?php echo ($settings->icon_text_color) ? '#'. $settings->icon_text_color : '#000'; ?>;
	<?php if( $settings->icon_padding >= 0 ) { ?>padding: <?php echo $settings->icon_padding; ?>px;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon-wrapper .pp-separator-arrow,
.fl-node-<?php echo $id; ?> .pp-post-timeline.left .pp-post-timeline-content-wrapper .pp-post-timeline-item:nth-of-type(2n) .pp-separator-arrow {
	border: 0;	
	border-top: <?php echo ($settings->post_timeline_border['width']['top']) ? $settings->post_timeline_border['width']['top'] : 1; ?>px solid transparent;
	border-left: <?php echo ($settings->post_timeline_border['width']['top']) ? $settings->post_timeline_border['width']['top'] : 1; ?>px solid transparent;
	
	<?php if( isset( $settings->post_timeline_background ) && ! empty( $settings->post_timeline_background ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
		border-top-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
		border-left-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
	<?php } elseif( isset( $settings->title_bg_color ) && ! empty( $settings->title_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
		border-top-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
		border-left-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
	<?php } ?>
	
	<?php if( $settings->post_timeline_border['style'] != 'none' && $settings->post_timeline_border['color'] != '' ) { ?>
		border-top-color: #<?php echo $settings->post_timeline_border['color']; ?>;
		border-left-color: #<?php echo $settings->post_timeline_border['color']; ?>;
	<?php } elseif ( isset( $settings->post_timeline_border['shadow'] ) && $settings->post_timeline_border['shadow']['color'] != '' ) { ?>
		border-top-color: <?php echo pp_get_color_value( $settings->post_timeline_border['shadow']['color'] ); ?>;
		border-left-color: <?php echo pp_get_color_value( $settings->post_timeline_border['shadow']['color'] ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline.right .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-separator-arrow,
.fl-node-<?php echo $id; ?> .pp-post-timeline.alternate .pp-post-timeline-content-wrapper .pp-post-timeline-item:nth-of-type(2n) .pp-separator-arrow {
	border: 0;	
	border-bottom: <?php echo ($settings->post_timeline_border['width']) ? $settings->post_timeline_border['width']['top'] : 1; ?>px solid transparent;
	border-right: <?php echo ($settings->post_timeline_border['width']) ? $settings->post_timeline_border['width']['top'] : 1; ?>px solid transparent;

	<?php if( isset( $settings->post_timeline_background ) && ! empty( $settings->post_timeline_background ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
		border-bottom-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
		border-right-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
	<?php } elseif( isset( $settings->title_bg_color ) && ! empty( $settings->title_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
		border-bottom-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
		border-right-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
	<?php } ?>
	
	<?php if( $settings->post_timeline_border['style'] != 'none' && $settings->post_timeline_border['color'] != '' ) { ?>
		border-bottom-color: #<?php echo $settings->post_timeline_border['color']; ?>;
		border-right-color: #<?php echo $settings->post_timeline_border['color']; ?>;
	<?php } elseif ( isset( $settings->post_timeline_border['shadow'] ) && $settings->post_timeline_border['shadow']['color'] != '' ) { ?>
		border-bottom-color: <?php echo pp_get_color_value( $settings->post_timeline_border['shadow']['color'] ); ?>;
		border-right-color: <?php echo pp_get_color_value( $settings->post_timeline_border['shadow']['color'] ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline.horizontal .pp-post-timeline-content-wrapper .pp-post-timeline-item.slick-current .pp-separator-arrow {
	border: 0;	
	border-bottom: <?php echo ($settings->post_timeline_border['width']) ? $settings->post_timeline_border['width']['top'] : 1; ?>px solid transparent;
	border-left: <?php echo ($settings->post_timeline_border['width']) ? $settings->post_timeline_border['width']['top'] : 1; ?>px solid transparent;

	<?php if( isset( $settings->post_timeline_background ) && ! empty( $settings->post_timeline_background ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
		border-bottom-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
		border-left-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
	<?php } ?>
	<?php if( isset( $settings->title_bg_color ) && ! empty( $settings->title_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
		border-bottom-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
		border-left-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
	<?php } ?>

	<?php if( $settings->post_timeline_border['style'] != 'none' && $settings->post_timeline_border['color'] != '' ) { ?>
		border-bottom-color: #<?php echo $settings->post_timeline_border['color']; ?>;
		border-left-color: #<?php echo $settings->post_timeline_border['color']; ?>;
	<?php } elseif ( isset( $settings->post_timeline_border['shadow'] ) && $settings->post_timeline_border['shadow']['color'] != '' ) { ?>
		border-bottom-color: <?php echo pp_get_color_value( $settings->post_timeline_border['shadow']['color'] ); ?>;
		border-left-color: <?php echo pp_get_color_value( $settings->post_timeline_border['shadow']['color'] ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-read-more {
	<?php if( $settings->button_top_margin ) { ?>margin-top: <?php echo $settings->button_top_margin; ?>px;<?php } ?>
	<?php if( $settings->button_bottom_margin ) { ?>margin-bottom: <?php echo $settings->button_bottom_margin; ?>px;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button {
	<?php if( isset( $settings->post_timeline_button_bg_color ) && ! empty( $settings->post_timeline_button_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->post_timeline_button_bg_color ); ?>;
	<?php } ?>
	<?php if($settings->post_timeline_button_text_color) { ?>color: #<?php echo $settings->post_timeline_button_text_color; ?><?php } ?>;
	padding-top: <?php echo ( $settings->button_vertical_padding != '') ? $settings->button_vertical_padding.'px' : '10px'; ?>;
	padding-bottom: <?php echo ( $settings->button_vertical_padding != '') ? $settings->button_vertical_padding.'px' : '10px'; ?>;
	padding-left: <?php echo ( $settings->button_horizontal_padding != '') ? $settings->button_horizontal_padding.'px' : '10px'; ?>;
	padding-right: <?php echo ( $settings->button_horizontal_padding != '') ? $settings->button_horizontal_padding.'px' : '10px'; ?>;
}

<?php
	// Button Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'button_typography',
		'selector' 		=> ".fl-node-$id .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button",
	) );

	// Button - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'post_timeline_button_border',
		'selector' 		=> ".fl-node-$id .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button:hover {
	<?php if( isset( $settings->post_timeline_button_bg_hover ) && ! empty( $settings->post_timeline_button_bg_hover ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->post_timeline_button_bg_hover ); ?>;
	<?php } ?>
	<?php if($settings->post_timeline_button_text_hover) { ?>color: #<?php echo $settings->post_timeline_button_text_hover; ?><?php } ?>;
}

.fl-node-<?php echo $id; ?> .pp-post-timeline-slide-navigation span.slick-arrow {
	<?php if( isset( $settings->arrow_bg_color ) && ! empty( $settings->arrow_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->arrow_bg_color ); ?>;
	<?php } ?>
	padding-top: <?php echo ( $settings->arrow_vertical_padding != '') ? $settings->arrow_vertical_padding.'px' : '5px'; ?>;
	padding-bottom: <?php echo ( $settings->arrow_vertical_padding != '') ? $settings->arrow_vertical_padding.'px' : '5px'; ?>;
	padding-left: <?php echo ( $settings->arrow_horizontal_padding != '') ? $settings->arrow_horizontal_padding.'px' : '10px'; ?>;
	padding-right: <?php echo ( $settings->arrow_horizontal_padding != '') ? $settings->arrow_horizontal_padding.'px' : '10px'; ?>;
	width: <?php echo ($settings->arrow_font_size >= 0) ? ( $settings->arrow_font_size * 1.5 ) : '15'; ?>px;
	height: <?php echo ($settings->arrow_font_size >= 0) ? ( $settings->arrow_font_size * 1.5 ) : '15'; ?>px;
}

<?php
	// Arrow - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'arrow_border',
		'selector' 		=> ".fl-node-$id .pp-post-timeline-slide-navigation span.slick-arrow",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-post-timeline-slide-navigation span.slick-arrow,
.fl-node-<?php echo $id; ?> .pp-post-timeline-slide-navigation span.slick-arrow:before {
	<?php if( $settings->arrow_font_size != '' ) { ?>font-size: <?php echo $settings->arrow_font_size; ?>px;<?php } ?>
	<?php if( $settings->arrow_color ) { ?>color: #<?php echo $settings->arrow_color; ?>;<?php } ?>
	line-height: 0.8;
}

.fl-node-<?php echo $id; ?> .pp-post-timeline-slide-navigation span.slick-arrow:hover {
	<?php if( $settings->arrow_hover ) { ?>color: #<?php echo $settings->arrow_hover; ?>;<?php } ?>
	<?php if( isset( $settings->arrow_bg_hover ) && ! empty( $settings->arrow_bg_hover ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->arrow_bg_hover ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline-slide-navigation span.slick-arrow:hover:before {
	<?php if( $settings->arrow_hover ) { ?>color: #<?php echo $settings->arrow_hover; ?>;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-post-timeline .slick-dots li,
.fl-node-<?php echo $id; ?> .pp-post-timeline .slick-dots li button,
.fl-node-<?php echo $id; ?> .pp-post-timeline .slick-dots li button:before {
	width: <?php echo ($settings->dot_width) ? $settings->dot_width : '10'; ?>px;
	height: <?php echo ($settings->dot_width) ? $settings->dot_width : '10'; ?>px;
}

.fl-node-<?php echo $id; ?> .pp-post-timeline .slick-dots li button:before {
	<?php if( $settings->dot_bg_color ) { ?>color: #<?php echo $settings->dot_bg_color; ?>;<?php } ?>
	font-size: <?php echo ($settings->dot_width) ? $settings->dot_width : '10'; ?>px;
}

.fl-node-<?php echo $id; ?> .pp-post-timeline .slick-dots li button:hover:before,
.fl-node-<?php echo $id; ?> .pp-post-timeline .slick-dots li.slick-active button:before {
	<?php if( $settings->dot_bg_hover ) { ?>color: #<?php echo $settings->dot_bg_hover; ?>;<?php } ?>
}


@media only screen and ( max-width: <?php echo $global_settings->medium_breakpoint; ?>px ) {
	.pp-post-timeline .pp-post-timeline-content-wrapper:before {
	    left: 3%;
	    -webkit-transform: translateX(-3%);
	    -moz-transform: translateX(-3%);
	    -o-transform: translateX(-3%);
	    -ms-transform: translateX(-3%);
	    transform: translateX(-3%);
	}
	.pp-post-timeline .pp-post-timeline-content-wrapper:after {
		left: 3%;
		-webkit-transform: translateX(-40%);
		-moz-transform: translateX(-40%);
		-o-transform: translateX(-40%);
		-ms-transform: translateX(-40%);
		transform: translateX(-40%);
	}
	.pp-post-timeline .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content {
	    float: right;
	    width: 90%;
	}
	.pp-post-timeline.left .pp-post-timeline-content-wrapper .pp-post-timeline-item:nth-of-type(2n) .pp-post-timeline-content {
		float: right;
	}
	.pp-post-timeline.left .pp-post-timeline-content-wrapper .pp-post-timeline-item:nth-of-type(2n) .pp-separator-arrow {
		left: auto;
	}
	.pp-post-timeline .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon-wrapper {
	    left: 3.31% !important;
		width: 14%;
	}
	.pp-post-timeline .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon-wrapper .pp-separator-arrow {
	    left: auto;
	    right: -10px;
	}
	.pp-post-timeline .pp-post-timeline-content-wrapper .pp-post-timeline-item:nth-of-type(2n) .pp-post-timeline-icon-wrapper .pp-separator-arrow {
	    right: -10px;
	}
	.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title-wrapper {
		<?php if( $settings->title_vertical_padding_medium != '') { ?>padding-top: <?php echo $settings->title_vertical_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->title_vertical_padding_medium != '') { ?>padding-bottom: <?php echo $settings->title_vertical_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->title_horizontal_padding_medium != '') { ?>padding-left: <?php echo $settings->title_horizontal_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->title_horizontal_padding_medium != '') { ?>padding-right: <?php echo $settings->title_horizontal_padding_medium; ?>px; <?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-text-wrapper {
		<?php if( $settings->content_vertical_padding_medium != '') { ?>padding-top: <?php echo $settings->content_vertical_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->content_vertical_padding_medium != '') { ?>padding-bottom: <?php echo $settings->content_vertical_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->content_horizontal_padding_medium != '') { ?>padding-left: <?php echo $settings->content_horizontal_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->content_horizontal_padding_medium != '') { ?>padding-right: <?php echo $settings->content_horizontal_padding_medium; ?>px; <?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-read-more {
		<?php if( $settings->button_top_margin_medium ) { ?>margin-top: <?php echo $settings->button_top_margin_medium; ?>px;<?php } ?>
		<?php if( $settings->button_bottom_margin_medium ) { ?>margin-bottom: <?php echo $settings->button_bottom_margin_medium; ?>px;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button {
		<?php if( $settings->button_vertical_padding_medium != '') { ?>padding-top: <?php echo $settings->button_vertical_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->button_vertical_padding_medium != '') { ?>padding-bottom: <?php echo $settings->button_vertical_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->button_horizontal_padding_medium != '') { ?>padding-left: <?php echo $settings->button_horizontal_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->button_horizontal_padding_medium != '') { ?>padding-right: <?php echo $settings->button_horizontal_padding_medium; ?>px; <?php } ?>
	}

	.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon-wrapper .pp-separator-arrow,
	.fl-node-<?php echo $id; ?> .pp-post-timeline.left .pp-post-timeline-content-wrapper .pp-post-timeline-item:nth-of-type(2n) .pp-separator-arrow {
		border: 0;	
		border-bottom: <?php echo ($settings->post_timeline_border['width']) ? $settings->post_timeline_border['width']['top'] : 1; ?>px solid transparent;
		border-right: <?php echo ($settings->post_timeline_border['width']) ? $settings->post_timeline_border['width']['top'] : 1; ?>px solid transparent;

		<?php if( isset( $settings->post_timeline_background ) && ! empty( $settings->post_timeline_background ) ) { ?>
			background-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
			border-bottom-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
			border-right-color: <?php echo pp_get_color_value( $settings->post_timeline_background ); ?>;
		<?php } elseif( isset( $settings->title_bg_color ) && ! empty( $settings->title_bg_color ) ) { ?>
			background-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
			border-bottom-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
			border-right-color: <?php echo pp_get_color_value( $settings->title_bg_color ); ?>;
		<?php } ?>
		
		<?php if( $settings->post_timeline_border['style'] != 'none' && $settings->post_timeline_border['color'] != '' ) { ?>
			border-bottom-color: #<?php echo $settings->post_timeline_border['color']; ?>;
			border-right-color: #<?php echo $settings->post_timeline_border['color']; ?>;
		<?php } elseif ( isset( $settings->post_timeline_border['shadow'] ) && $settings->post_timeline_border['shadow']['color'] != '' ) { ?>
			border-bottom-color: <?php echo pp_get_color_value( $settings->post_timeline_border['shadow']['color'] ); ?>;
			border-right-color: <?php echo pp_get_color_value( $settings->post_timeline_border['shadow']['color'] ); ?>;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-post-timeline-slide-navigation span.slick-arrow {
		<?php if( $settings->arrow_vertical_padding_medium != '') { ?>padding-top: <?php echo $settings->arrow_vertical_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->arrow_vertical_padding_medium != '') { ?>padding-bottom: <?php echo $settings->arrow_vertical_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->arrow_horizontal_padding_medium != '') { ?>padding-left: <?php echo $settings->arrow_horizontal_padding_medium; ?>px; <?php } ?>
		<?php if( $settings->arrow_horizontal_padding_medium != '') { ?>padding-right: <?php echo $settings->arrow_horizontal_padding_medium; ?>px; <?php } ?>
	}
}

@media only screen and ( max-width: <?php echo $global_settings->responsive_breakpoint; ?>px ) {
	.pp-post-timeline .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content {
	    width: 85%;
	}
	.pp-post-timeline .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-icon-wrapper {
		width: 24%;
	}
	.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-title-wrapper {
		<?php if( $settings->title_vertical_padding_responsive != '') { ?>padding-top: <?php echo $settings->title_vertical_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->title_vertical_padding_responsive != '') { ?>padding-bottom: <?php echo $settings->title_vertical_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->title_horizontal_padding_responsive != '') { ?>padding-left: <?php echo $settings->title_horizontal_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->title_horizontal_padding_responsive != '') { ?>padding-right: <?php echo $settings->title_horizontal_padding_responsive; ?>px; <?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-text-wrapper {
		<?php if( $settings->content_vertical_padding_responsive != '') { ?>padding-top: <?php echo $settings->content_vertical_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->content_vertical_padding_responsive != '') { ?>padding-bottom: <?php echo $settings->content_vertical_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->content_horizontal_padding_responsive != '') { ?>padding-left: <?php echo $settings->content_horizontal_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->content_horizontal_padding_responsive != '') { ?>padding-right: <?php echo $settings->content_horizontal_padding_responsive; ?>px; <?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-read-more {
		<?php if( $settings->button_top_margin_responsive ) { ?>margin-top: <?php echo $settings->button_top_margin_responsive; ?>px;<?php } ?>
		<?php if( $settings->button_bottom_margin_responsive ) { ?>margin-bottom: <?php echo $settings->button_bottom_margin_responsive; ?>px;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-post-timeline-content-wrapper .pp-post-timeline-item .pp-post-timeline-content .pp-post-timeline-button {
		<?php if( $settings->button_vertical_padding_responsive != '') { ?>padding-top: <?php echo $settings->button_vertical_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->button_vertical_padding_responsive != '') { ?>padding-bottom: <?php echo $settings->button_vertical_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->button_horizontal_padding_responsive != '') { ?>padding-left: <?php echo $settings->button_horizontal_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->button_horizontal_padding_responsive != '') { ?>padding-right: <?php echo $settings->button_horizontal_padding_responsive; ?>px; <?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-post-timeline-slide-navigation span.slick-arrow {
		<?php if( $settings->arrow_vertical_padding_responsive != '') { ?>padding-top: <?php echo $settings->arrow_vertical_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->arrow_vertical_padding_responsive != '') { ?>padding-bottom: <?php echo $settings->arrow_vertical_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->arrow_horizontal_padding_responsive != '') { ?>padding-left: <?php echo $settings->arrow_horizontal_padding_responsive; ?>px; <?php } ?>
		<?php if( $settings->arrow_horizontal_padding_responsive != '') { ?>padding-right: <?php echo $settings->arrow_horizontal_padding_responsive; ?>px; <?php } ?>
	}
}
