.fl-node-<?php echo $id; ?> .clearfix:before,
.fl-node-<?php echo $id; ?> .clearfix:after {
    content: "";
    display: table;
}

.fl-node-<?php echo $id; ?> .clearfix: after {
    clear: both;
}

<?php
	$logo_grid_border_style = 'none';
	$logo_grid_border_width = 0;
	$logo_grid_border_right_width = 0;
	$logo_grid_border_bottom_width = 0;
	if ( isset( $settings->logo_grid_border ) ) {
		$logo_grid_border_style = isset( $settings->logo_grid_border['style'] ) ? $settings->logo_grid_border['style'] : 'none';
		$logo_grid_border_right_width = ! empty( $settings->logo_grid_border['width']['right'] ) ? $settings->logo_grid_border['width']['right'] : 0;
		$logo_grid_border_bottom_width = ! empty( $settings->logo_grid_border['width']['bottom'] ) ? $settings->logo_grid_border['width']['bottom'] : 0;
	}
?>

<?php
	if ( isset( $settings->logos_grid_columns ) && ! empty( $settings->logos_grid_columns ) ) {
		$space_desktop = $space_tablet = $space_mobile = ( $settings->logos_grid_columns - 1 ) * $settings->logos_grid_spacing;
		$logos_grid_columns_desktop = ( 100 - $space_desktop ) / $settings->logos_grid_columns;
	}

	if ( isset( $settings->logos_grid_columns ) && ! empty( $settings->logos_grid_columns_medium ) ) {
		$space_tablet = $space_mobile = ( $settings->logos_grid_columns_medium - 1 ) * $settings->logos_grid_spacing;
		$logos_grid_columns_tablet = ( 100 - $space_tablet ) / $settings->logos_grid_columns_medium;
	}

	if ( isset( $settings->logos_grid_columns ) && ! empty( $settings->logos_grid_columns_responsive ) ) {
		$space_mobile = ( $settings->logos_grid_columns_responsive - 1 ) * $settings->logos_grid_spacing;
		$logos_grid_columns_mobile = ( 100 - $space_mobile ) / $settings->logos_grid_columns_responsive;
	}
 ?>

.fl-node-<?php echo $id; ?> .pp-logos-content {
    position: relative;
}

.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo {
    position: relative;
    <?php if( $settings->logos_layout == 'grid' ) { ?>
        width: calc((100% - <?php echo $space_desktop + 1; ?>px) / <?php echo $settings->logos_grid_columns; ?>);
        <?php if ( $settings->logos_grid_spacing == 0 ) { ?>
        margin-right: <?php echo $settings->logos_grid_spacing - ( $logo_grid_border_style != 'none' ? $logo_grid_border_right_width : 0 ); ?>px;
        margin-bottom: <?php echo $settings->logos_grid_spacing - ( $logo_grid_border_style != 'none' ? $logo_grid_border_bottom_width : 0 ); ?>px;
        <?php } else { ?>
        margin-right: <?php echo $settings->logos_grid_spacing; ?>px;
        margin-bottom: <?php echo $settings->logos_grid_spacing; ?>px;
        <?php } ?>
    <?php } ?>
    <?php if( $settings->logos_layout == 'carousel' ) { ?>
        <?php if ( $settings->logo_slider_transition == 'fade' ) { ?>
            width: calc((100% - <?php echo ($settings->logo_carousel_minimum_grid - 1) * $settings->logos_carousel_spacing; ?>px) / <?php echo $settings->logo_carousel_minimum_grid; ?>);
        <?php } ?>
    margin-right: <?php echo $settings->logos_carousel_spacing; ?>px;
    <?php } ?>
    float: left;
	<?php if( $settings->logo_grid_bg_color ) { ?>
    background-color: #<?php echo $settings->logo_grid_bg_color; ?>;
    <?php } ?>
}

<?php
	// Logo Grid - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'logo_grid_border',
		'selector' 		=> ".fl-node-$id .pp-logos-content .pp-logo",
	) );

	// Logo Grid - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'logo_grid_padding',
		'selector' 		=> ".fl-node-$id .pp-logos-content .pp-logo",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'logo_grid_padding_top',
			'padding-right' 	=> 'logo_grid_padding_right',
			'padding-bottom' 	=> 'logo_grid_padding_bottom',
			'padding-left' 		=> 'logo_grid_padding_left',
		),
	) );
?>

<?php if( $settings->logos_layout == 'grid' ) { ?>
.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:nth-of-type(<?php echo $settings->logos_grid_columns; ?>n+1) {
    clear: left;
}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:nth-of-type(<?php echo $settings->logos_layout == 'grid' ? $settings->logos_grid_columns : $settings->logo_carousel_minimum_grid; ?>n) {
    margin-right: 0;
}

.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:hover {
	<?php if( $settings->logo_grid_bg_hover ) { ?>
    background-color: #<?php echo $settings->logo_grid_bg_hover; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-logos-wrapper {
	display: flex;
    flex-wrap: wrap;
}
.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
}

<?php
// Height
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'custom_height',
	'selector'		=> ".fl-node-$id .pp-logos-content .pp-logo",
	'prop'			=> 'height',
	'unit'			=> 'px',
) );
?>

.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo > a,
.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo .pp-logo-inner {
    flex: 1 1 auto;
}

.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo .pp-logo-inner .pp-logo-inner-wrap {
    text-align: center;
}


.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo a {
    display: block;
    text-decoration: none;
    box-shadow: none;
    border: none;
}

.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo div.title-wrapper {
    display: <?php echo $settings->upload_logo_show_title; ?>
}


.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo div.title-wrapper p.logo-title {
    text-align: center;
    <?php if( $settings->logo_grid_title_color ) { ?>
    color: #<?php echo $settings->logo_grid_title_color; ?>;
    <?php } ?>
    <?php if( $settings->logo_grid_title_top_margin >= 0 ) { ?>
    margin-top: <?php echo $settings->logo_grid_title_top_margin; ?>px;
    <?php } ?>
    <?php if( $settings->logo_grid_title_bottom_margin >= 0 ) { ?>
    margin-bottom: <?php echo $settings->logo_grid_title_bottom_margin; ?>px;
    <?php } ?>
}

<?php
	// Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'title_typography',
		'selector' 		=> ".fl-node-$id .pp-logos-content .pp-logo div.title-wrapper p.logo-title",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:hover div.title-wrapper p.logo-title {
    <?php if( $settings->logo_grid_title_hover ) { ?>
    color: #<?php echo $settings->logo_grid_title_hover; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo img {
    <?php if( $settings->logo_grid_grayscale == 'grayscale' ) { ?>
        -webkit-filter: grayscale(100%);
        filter: grayscale(100%);
    <?php } else { ?>
        -webkit-filter: inherit;
        filter: inherit;
    <?php } ?>
    <?php if( $settings->logo_grid_logo_border_style ) { ?>
    border-style: <?php echo $settings->logo_grid_logo_border_style; ?>;
    <?php } ?>
    <?php if( $settings->logo_grid_logo_border_width >= 0 ) { ?>
    border-width: <?php echo $settings->logo_grid_logo_border_width; ?>px;
    <?php } ?>
    <?php if( $settings->logo_grid_logo_border_color ) { ?>
    border-color: #<?php echo $settings->logo_grid_logo_border_color; ?>;
    <?php } ?>
    <?php if( $settings->logo_grid_logo_border_radius >= 0 ) { ?>
    border-radius: <?php echo $settings->logo_grid_logo_border_radius; ?>px;
    <?php } ?>
    <?php if ( $settings->logo_grid_size >= 0 ) { ?>
    height: <?php echo $settings->logo_grid_size; ?>px;
    <?php } ?>
    margin: 0 auto;
    <?php if( $settings->logo_grid_opacity >= 0 ) { ?>
    opacity: <?php echo $settings->logo_grid_opacity / 100; ?>;
    -webkit-transition: opacity 0.3s ease-in-out;
    -moz-transition: opacity 0.3s ease-in-out;
    -ms-transition: opacity 0.3s ease-in-out;
    transition: opacity 0.3s ease-in-out;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:hover img {
    <?php if( $settings->logo_grid_grayscale_hover == 'grayscale' ) { ?>
        -webkit-filter: grayscale(100%);
        filter: grayscale(100%);
    <?php } else { ?>
        -webkit-filter: inherit;
        filter: inherit;
    <?php } ?>
    <?php if ( $settings->logo_grid_logo_border_hover != '' ) { ?>
    border-color: #<?php echo $settings->logo_grid_logo_border_hover; ?>;
    <?php } ?>
    <?php if( $settings->logo_grid_opacity_hover >= 0 ) { ?>
    opacity: <?php echo $settings->logo_grid_opacity_hover / 100; ?>;
    -webkit-transition: opacity 0.3s ease-in-out;
    -moz-transition: opacity 0.3s ease-in-out;
    -ms-transition: opacity 0.3s ease-in-out;
    transition: opacity 0.3s ease-in-out;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-logos-content .bx-pager a {
	opacity: 1;
	<?php if ( isset( $settings->logo_grid_dot_bg_color ) && ! empty( $settings->logo_grid_dot_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->logo_grid_dot_bg_color ); ?>;
	<?php } ?>
    <?php if( $settings->logo_grid_dot_width >= 0 ) { ?>
    width: <?php echo $settings->logo_grid_dot_width; ?>px;
    <?php } ?>
    <?php if( $settings->logo_grid_dot_width >= 0 ) { ?>
    height: <?php echo $settings->logo_grid_dot_width; ?>px;
    <?php } ?>
    <?php if( $settings->logo_grid_dot_border_radius >= 0 ) { ?>
    border-radius: <?php echo $settings->logo_grid_dot_border_radius; ?>px;
    <?php } ?>
    box-shadow: none;
}

.fl-node-<?php echo $id; ?> .pp-logos-content .bx-pager a.active,
.fl-node-<?php echo $id; ?> .pp-logos-content .bx-pager a:hover {
	<?php if ( isset( $settings->logo_grid_dot_bg_hover ) && ! empty( $settings->logo_grid_dot_bg_hover ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->logo_grid_dot_bg_hover ); ?>;
	<?php } ?>
	opacity: 1;
    box-shadow: none;
}

.fl-node-<?php echo $id; ?> .pp-logos-content .bx-prev .fa:before {
    content: "\f053";
}
.fl-node-<?php echo $id; ?> .pp-logos-content .bx-next .fa:before {
    content: "\f054";
}

<?php
	// Carousel Arrow - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'logo_grid_arrow',
		'selector' 		=> ".fl-node-$id .pp-logos-content .fa, .fl-node-$id .pp-logos-content .fa:hover",
	) );

	// Carousel Arrow - Font Size
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'logo_grid_arrow_font_size',
		'selector'		=> ".fl-node-$id .pp-logos-content .fa, .fl-node-$id .pp-logos-content .fa:hover",
		'prop'			=> 'font-size',
		'unit'			=> 'px',
	) );

	// Carousel Arrow - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'logo_grid_arrow_padding',
		'selector' 		=> ".fl-node-$id .pp-logos-content .fa, .fl-node-$id .pp-logos-content .fa:hover",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'logo_grid_arrow_padding_top',
			'padding-right' 	=> 'logo_grid_arrow_padding_right',
			'padding-bottom' 	=> 'logo_grid_arrow_padding_bottom',
			'padding-left' 		=> 'logo_grid_arrow_padding_left',
		),
	) );
?>

.fl-node-<?php echo $id; ?> .pp-logos-content .fa {
    <?php if( $settings->logo_slider_arrow_color ) { ?>
	color: #<?php echo $settings->logo_slider_arrow_color; ?>;
    <?php } ?>
	<?php if ( isset( $settings->logo_slider_arrow_bg_color ) && ! empty( $settings->logo_slider_arrow_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->logo_slider_arrow_bg_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-logos-content .fa:hover {
    <?php if( $settings->logo_slider_arrow_color_hover ) { ?>
    color: #<?php echo $settings->logo_slider_arrow_color_hover; ?>;
    <?php } ?>
	<?php if ( isset( $settings->logo_slider_arrow_bg_hover ) && ! empty( $settings->logo_slider_arrow_bg_hover ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->logo_slider_arrow_bg_hover ); ?>;
	<?php } ?>
    <?php if( $settings->logo_grid_arrow_border_hover ) { ?>
    border-color: #<?php echo $settings->logo_grid_arrow_border_hover; ?>;
    <?php } ?>
}

@media only screen and (max-width: 1024px) {
    .fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo {
        <?php if( $settings->logos_layout == 'grid' && $settings->logos_grid_columns_medium >= 0 ) { ?>
        width: calc((100% - <?php echo $space_tablet + 1; ?>px) / <?php echo $settings->logos_grid_columns_medium; ?>);
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:nth-of-type(<?php echo $settings->logos_grid_columns_medium; ?>n+1) {
        <?php if( $settings->logos_layout == 'grid' ) { ?>
            clear: left;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:nth-of-type(<?php echo $settings->logos_grid_columns; ?>n) {
        <?php if( $settings->logos_layout == 'grid' ) { ?>
            <?php if ( $settings->logos_grid_spacing == 0 ) { ?>
            margin-right: <?php echo $settings->logos_grid_spacing - ( $logo_grid_border_style != 'none' ? $logo_grid_border_right_width : 0 ); ?>px;
            margin-bottom: <?php echo $settings->logos_grid_spacing - ( $logo_grid_border_style != 'none' ? $logo_grid_border_bottom_width : 0 ); ?>px;
            <?php } else { ?>
            margin-right: <?php echo $settings->logos_grid_spacing; ?>px;
            margin-bottom: <?php echo $settings->logos_grid_spacing; ?>px;
            <?php } ?>
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:nth-of-type(<?php echo $settings->logos_grid_columns_medium; ?>n) {
        <?php if( $settings->logos_layout == 'grid' ) { ?>
            margin-right: 0;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:nth-of-type(<?php echo $settings->logos_grid_columns; ?>n+1) {
        <?php if( $settings->logos_layout == 'grid' ) { ?>
            clear: none;
        <?php } ?>
    }
}

@media only screen and (max-width: 480px) {
    .fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo {
        <?php if( $settings->logos_layout == 'grid' && $settings->logos_grid_columns_responsive >= 0 ) { ?>
        width: calc((100% - <?php echo $space_mobile + 1; ?>px) / <?php echo $settings->logos_grid_columns_responsive; ?>);
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:nth-of-type(<?php echo $settings->logos_grid_columns_medium; ?>n+1) {
        <?php if( $settings->logos_layout == 'grid' ) { ?>
            clear: none;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:nth-of-type(<?php echo $settings->logos_grid_columns_responsive; ?>n+1) {
        <?php if( $settings->logos_layout == 'grid' ) { ?>
            clear: left;
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:nth-of-type(<?php echo $settings->logos_grid_columns_medium; ?>n) {
        <?php if( $settings->logos_layout == 'grid' ) { ?>
            <?php if ( $settings->logos_grid_spacing == 0 ) { ?>
            margin-right: <?php echo $settings->logos_grid_spacing - ( $logo_grid_border_style != 'none' ? $logo_grid_border_right_width : 0 ); ?>px;
            margin-bottom: <?php echo $settings->logos_grid_spacing - ( $logo_grid_border_style != 'none' ? $logo_grid_border_bottom_width : 0 ); ?>px;
            <?php } else { ?>
            margin-right: <?php echo $settings->logos_grid_spacing; ?>px;
            margin-bottom: <?php echo $settings->logos_grid_spacing; ?>px;
            <?php } ?>
        <?php } ?>
    }
    .fl-node-<?php echo $id; ?> .pp-logos-content .pp-logo:nth-of-type(<?php echo $settings->logos_grid_columns_responsive; ?>n) {
        <?php if( $settings->logos_layout == 'grid' ) { ?>
            margin-right: 0;
        <?php } ?>
    }
}
