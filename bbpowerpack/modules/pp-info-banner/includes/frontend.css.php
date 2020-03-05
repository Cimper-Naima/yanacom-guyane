<?php
// Form Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'banner_border_group',
	'selector' 		=> ".fl-node-$id .pp-info-banner-content",
) );
// Button Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'banner_button_border_group',
	'selector' 		=> ".fl-node-$id .pp-info-banner-content .banner-button",
) );
// Banner Info Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'banner_info_padding_group',
	'selector' 		=> ".fl-node-$id .pp-info-banner-content .info-banner-wrap",
	'unit'			=> isset( $settings->banner_info_padding_group_unit ) ? $settings->banner_info_padding_group_unit : 'px',
	'props'			=> array(
		'padding-top' 		=> 'banner_info_padding_group_top',
		'padding-right' 	=> 'banner_info_padding_group_right',
		'padding-bottom' 	=> 'banner_info_padding_group_bottom',
		'padding-left' 		=> 'banner_info_padding_group_left',
	),
) );
// Banner Title Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'banner_title_padding',
	'selector' 		=> ".fl-node-$id .pp-info-banner-content .banner-title",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'banner_title_padding_top',
		'padding-right' 	=> 'banner_title_padding_right',
		'padding-bottom' 	=> 'banner_title_padding_bottom',
		'padding-left' 		=> 'banner_title_padding_left',
	),
) );
// Banner Desc Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'banner_desc_padding',
	'selector' 		=> ".fl-node-$id .pp-info-banner-content .banner-description",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'banner_desc_padding_top',
		'padding-right' 	=> 'banner_desc_padding_right',
		'padding-bottom' 	=> 'banner_desc_padding_bottom',
		'padding-left' 		=> 'banner_desc_padding_left',
	),
) );
// Banner Button Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'banner_button_padding',
	'selector' 		=> ".fl-node-$id .pp-info-banner-content .banner-button",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'banner_button_padding_top',
		'padding-right' 	=> 'banner_button_padding_right',
		'padding-bottom' 	=> 'banner_button_padding_bottom',
		'padding-left' 		=> 'banner_button_padding_left',
	),
) );
// Banner Title Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'banner_title_typography',
	'selector' 		=> ".fl-node-$id .pp-info-banner-content .banner-title",
) );
?>
.fl-node-<?php echo $id; ?> .pp-info-banner-content {
    width: 100%;
    position: relative;
    overflow: hidden;
    background: <?php echo $settings->banner_bg_color ? pp_get_color_value( $settings->banner_bg_color ) : 'transparent' ?>;
    <?php if( $settings->banner_min_height ) { ?>
	height: <?php echo $settings->banner_min_height; ?>px;
    <?php } ?>
}
<?php if( $settings->banner_image_arrangement == 'background' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-info-banner-content .pp-info-banner-bg {
		<?php if( $settings->banner_image_arrangement == 'background' && $settings->banner_image ) { ?>
	    background-image: url('<?php echo $settings->banner_image_src; ?>');
	    <?php } ?>
	    <?php if( $settings->banner_bg_size ) { ?>
	    background-size: <?php echo $settings->banner_bg_size; ?>;
	    <?php } ?>
	    <?php if( $settings->banner_bg_repeat ) { ?>
	    background-repeat: <?php echo $settings->banner_bg_repeat; ?>;
	    <?php } ?>
	    background-position: <?php echo $settings->banner_bg_position; ?>;
		position: absolute;
		width: 100%;
		height: 100%;
		-webkit-transition: all 0.5s ease;
	    -moz-transition: all 0.5s ease;
	    -ms-transition: all 0.5s ease;
	    -o-transition: all 0.5s ease;
	    transition: all 0.5s ease;
	    will-change: transform;
	}
	.fl-node-<?php echo $id; ?> .pp-info-banner-content:hover .pp-info-banner-bg {
        <?php if ( isset( $settings->banner_bg_hover_zoom ) && $settings->banner_bg_hover_zoom == 'enable' ) { ?>
		-webkit-transform: scale(1.1);
	    -moz-transform: scale(1.1);
	    -o-transform: scale(1.1);
	    -ms-transform: scale(1.1);
	    -ms-filter: "progid:DXImageTransform.Microsoft.Matrix(M11=1.1, M12=0, M21=0, M22=1.1, SizingMethod='auto expand')";
	    filter: progid:DXImageTransform.Microsoft.Matrix(M11=1.1, M12=0, M21=0, M22=1.1, SizingMethod='auto expand');
	    transform: scale(1.1);
        <?php } ?>
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-info-banner-content .pp-info-banner-bg:before {
    content: "";
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 2;
    background-color: <?php echo $settings->banner_bg_overlay ? pp_get_color_value( $settings->banner_bg_overlay ) : 'transparent'; ?>;
    opacity: <?php echo $settings->banner_bg_opacity; ?>;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content .pp-info-banner-inner {
    display: table;
    width: 100%;
    height: 100%;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content .info-banner-wrap {
    display: table-cell;
    vertical-align: middle;
	position: relative;
	z-index: 5;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content .info-banner-wrap.animated {
    -webkit-animation-duration: <?php echo $settings->banner_info_transition_duration; ?>ms;
    -moz-animation-duration: <?php echo $settings->banner_info_transition_duration; ?>ms;
    -ms-animation-duration: <?php echo $settings->banner_info_transition_duration; ?>ms;
    -o-animation-duration: <?php echo $settings->banner_info_transition_duration; ?>ms;
    animation-duration: <?php echo $settings->banner_info_transition_duration; ?>ms;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content .info-banner-wrap.info-right {
	text-align: right;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content .info-banner-wrap.info-center {
	text-align: center;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content .banner-title {
    <?php if( $settings->banner_title_color ) { ?>
	color: <?php echo pp_get_color_value( $settings->banner_title_color ); ?>;
    <?php } ?>
    <?php if( $settings->banner_title_margin >= 0 ) { ?>
	margin-bottom: <?php echo $settings->banner_title_margin; ?>px;
    <?php } ?>
    <?php if( $settings->banner_title_border_type) { ?>
    border-style: <?php echo $settings->banner_title_border_type; ?>;
    <?php } ?>
    border-color: <?php echo $settings->banner_title_border_color ? pp_get_color_value( $settings->banner_title_border_color ) : 'transparent'; ?>;
    border-width: 0;
    <?php echo $settings->banner_title_border_position; ?>-width: <?php echo $settings->banner_title_border_width; ?>px;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content .banner-description {
    <?php if( $settings->banner_desc_font['family'] != 'Default' ) { ?>
	<?php FLBuilderFonts::font_css( $settings->banner_desc_font ); ?>
    <?php } ?>
    <?php if( $settings->banner_desc_font_size ) { ?>
	font-size: <?php echo $settings->banner_desc_font_size; ?>px;
    <?php } ?>
    <?php if( $settings->banner_desc_color ) { ?>
	color: <?php echo pp_get_color_value( $settings->banner_desc_color ); ?>;
    <?php } ?>
    <?php if( $settings->banner_desc_margin >= 0 ) { ?>
	margin-bottom: <?php echo $settings->banner_desc_margin; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.pp-info-banner-img {
	position: absolute;
	display: block;
	float: none;
	width: auto;
	margin: 0 auto;
	max-width: none;
	z-index: 1;
	<?php if( $settings->banner_image_height >= 0 ) { ?>
	height: <?php echo $settings->banner_image_height; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.pp-info-banner-img {
    <?php if ( $settings->banner_image_effect != 'none' ) { ?>
        opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-info-banner-content img.pp-info-banner-img.<?php echo $settings->banner_image_effect; ?> {
    opacity: 1;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.animated {
    -webkit-animation-duration: <?php echo $settings->banner_image_transition_duration; ?>ms;
    -moz-animation-duration: <?php echo $settings->banner_image_transition_duration; ?>ms;
    -ms-animation-duration: <?php echo $settings->banner_image_transition_duration; ?>ms;
    -o-animation-duration: <?php echo $settings->banner_image_transition_duration; ?>ms;
    animation-duration: <?php echo $settings->banner_image_transition_duration; ?>ms;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.img-top-right {
	left: auto;
    right: 0;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.img-top-center {
    left: 30%;
    -webkit-transform: translateX(-30%);
    -moz-transform: translateX(-30%);
    -ms-transform: translateX(-30%);
    -o-transform: translateX(-30%);
    transform: translateX(-30%);
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.img-center-left {
    top: 30%;
    -webkit-transform: translateY(-30%);
    -moz-transform: translateY(-30%);
    -ms-transform: translateY(-30%);
    -o-transform: translateY(-30%);
    transform: translateY(-30%);
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.img-center {
    top: 30%;
    left: 30%;
    -webkit-transform: translate(-30%,-30%);
    -moz-transform: translate(-30%,-30%);
    -ms-transform: translate(-30%,-30%);
    -o-transform: translate(-30%,-30%);
    transform: translate(-30%,-30%);
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.img-center-right {
    top: 30%;
    -webkit-transform: translateY(-30%);
    -moz-transform: translateY(-30%);
    -ms-transform: translateY(-30%);
    -o-transform: translateY(-30%);
    transform: translateY(-30%);
    left: auto;
    right: 0;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.img-bottom-center,
.fl-node-<?php echo $id; ?> .pp-info-banner-content img.img-bottom-left,
.fl-node-<?php echo $id; ?> .pp-info-banner-content img.img-bottom-right {
    top: auto;
    bottom: 0;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.img-bottom-center {
    left: 30%;
    transform: translateX(-30%);
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content img.img-bottom-right {
    right: 0;
    left: auto;
}


.fl-node-<?php echo $id; ?> .pp-info-banner-content .banner-button {
    background-color: <?php echo $settings->banner_button_bg_color ? pp_get_color_value( $settings->banner_button_bg_color ) : 'transparent'; ?>;
	color: <?php echo pp_get_color_value( $settings->banner_button_text_color ); ?>;
    <?php if( $settings->banner_button_font['family'] != 'Default' ) { ?>
	<?php FLBuilderFonts::font_css( $settings->banner_button_font ); ?>
    <?php } ?>
    <?php if( $settings->banner_button_font_size ) { ?>
	font-size: <?php echo $settings->banner_button_font_size; ?>px;
    <?php } ?>
	display: inline-block;
    box-shadow: none;
    text-decoration: none;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content .banner-link {
    text-decoration: none !important;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
}

.fl-node-<?php echo $id; ?> .pp-info-banner-content .banner-button:hover {
    background-color: <?php echo $settings->banner_button_bg_hover_color ? pp_get_color_value( $settings->banner_button_bg_hover_color ) : 'transparent'; ?>;
    <?php if( $settings->banner_button_text_hover ) { ?>
		color: <?php echo pp_get_color_value( $settings->banner_button_text_hover ); ?>;
    <?php } ?>
    border-color: <?php echo $settings->banner_button_border_hover ? pp_get_color_value( $settings->banner_button_border_hover ) : 'transparent'; ?>;
    text-decoration: none;
}

@media only screen and (max-width: <?php echo $settings->banner_bp1; ?>px) {
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content {
        <?php if( $settings->banner_bp1_min_height ) { ?>
    	height: <?php echo $settings->banner_bp1_min_height; ?>px;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content .banner-title {
        <?php if( $settings->banner_bp1_title_font_size ) { ?>
    	font-size: <?php echo $settings->banner_bp1_title_font_size; ?>px;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content .banner-description {
        <?php if( $settings->banner_bp1_desc_font_size ) { ?>
    	font-size: <?php echo $settings->banner_bp1_desc_font_size; ?>px;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content .banner-button {
        <?php if( $settings->banner_bp1_button_font_size ) { ?>
    	font-size: <?php echo $settings->banner_bp1_button_font_size; ?>px;
        <?php } ?>
    }
}

@media only screen and (max-width: <?php echo $settings->banner_bp2; ?>px) {
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content {
        <?php if( $settings->banner_bp2_min_height ) { ?>
    	height: <?php echo $settings->banner_bp2_min_height; ?>px;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content .banner-title {
        <?php if( $settings->banner_bp2_title_font_size ) { ?>
    	font-size: <?php echo $settings->banner_bp2_title_font_size; ?>px;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content .banner-description {
        <?php if( $settings->banner_bp2_desc_font_size ) { ?>
    	font-size: <?php echo $settings->banner_bp2_desc_font_size; ?>px;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content .banner-button {
        <?php if( $settings->banner_bp2_button_font_size ) { ?>
    	font-size: <?php echo $settings->banner_bp2_button_font_size; ?>px;
        <?php } ?>
    }
}

@media only screen and (max-width: <?php echo $settings->banner_bp3; ?>px) {
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content {
        <?php if( $settings->banner_bp3_min_height ) { ?>
    	height: <?php echo $settings->banner_bp3_min_height; ?>px;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content .banner-title {
        <?php if( $settings->banner_bp3_title_font_size ) { ?>
    	font-size: <?php echo $settings->banner_bp3_title_font_size; ?>px;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content .banner-description {
        <?php if( $settings->banner_bp3_desc_font_size ) { ?>
    	font-size: <?php echo $settings->banner_bp3_desc_font_size; ?>px;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> div.pp-info-banner-content .banner-button {
        <?php if( $settings->banner_bp3_button_font_size ) { ?>
    	font-size: <?php echo $settings->banner_bp3_button_font_size; ?>px;
        <?php } ?>
    }
}
