.fl-node-<?php echo $id; ?> .pp-member-wrapper {
	<?php if ( isset( $settings->box_bg_color ) && ! empty( $settings->box_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->box_bg_color ); ?>;
	<?php } ?>
    opacity: 1;
	text-align: <?php echo $settings->box_content_alignment; ?>;
}

.fl-node-<?php echo $id; ?> .pp-member-wrapper:hover {
    <?php if ( isset( $settings->box_bg_hover_color ) && ! empty( $settings->box_bg_hover_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->box_bg_hover_color ); ?>;
	<?php } ?>
}

<?php
// Box - Border
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'box_border_group',
	'selector' 		=> ".fl-node-$id .pp-member-wrapper",
) );

FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'box_padding_group',
	'selector' 		=> ".fl-node-$id .pp-member-wrapper",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'box_padding_group_top',
		'padding-right' 	=> 'box_padding_group_right',
		'padding-bottom' 	=> 'box_padding_group_bottom',
		'padding-left' 		=> 'box_padding_group_left',
	),
) );
?>

.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-image img {
    <?php if( $settings->image_greyscale == 'greyscale' ) { ?>
        -webkit-filter: grayscale(100%);
        -moz-filter: grayscale(100%);
        -ms-filter: grayscale(100%);
        -o-filter: grayscale(100%);
        filter: grayscale(100%);
    <?php } ?>
    overflow: hidden;
}

<?php
// Image - Border
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'image_border_group',
	'selector' 		=> ".fl-node-$id .pp-member-wrapper .pp-member-image img",
) );
?>

.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-content {
	background-color: <?php echo ( false === strpos( $settings->content_bg_color, 'rgb' ) ) ? '#' . $settings->content_bg_color : $settings->content_bg_color; ?>;
}

<?php
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'content_padding',
	'selector' 		=> ".fl-node-$id .pp-member-wrapper .pp-member-content",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'content_padding_top',
		'padding-right' 	=> 'content_padding_right',
		'padding-bottom' 	=> 'content_padding_bottom',
		'padding-left' 		=> 'content_padding_left',
	),
) );
?>

.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-name {
	<?php if( $settings->title_font_color ) { ?>
		color: #<?php echo $settings->title_font_color; ?>;
	<?php } ?>
	margin-top: <?php echo $settings->title_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->title_margin['bottom']; ?>px;
}

<?php
// Title Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'title_typography',
	'selector' 		=> ".fl-node-$id .pp-member-wrapper .pp-member-name",
) );
?>

.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-designation {
	<?php if( $settings->designation_font_color ) { ?>
		color: #<?php echo $settings->designation_font_color; ?>;
	<?php } ?>
	margin-top: <?php echo $settings->designation_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->designation_margin['bottom']; ?>px;
}

<?php
// Designation Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'designation_typography',
	'selector' 		=> ".fl-node-$id .pp-member-wrapper .pp-member-designation",
) );
?>

.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-description {
	<?php if( $settings->description_font_color ) { ?>
		color: #<?php echo $settings->description_font_color; ?>;
	<?php } ?>
	margin-top: <?php echo $settings->description_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->description_margin['bottom']; ?>px;
}

<?php
// Description Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'description_typography',
	'selector' 		=> ".fl-node-$id .pp-member-wrapper .pp-member-description",
) );
?>

.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-separator {
    width: <?php echo $settings->separator_width; ?>px;
    height: <?php echo $settings->separator_height; ?>px;
    background-color: <?php echo ( $settings->separator_color ) ? '#' . $settings->separator_color : 'transparent' ?>;
    display: inline-block;
}

.fl-node-<?php echo $id; ?> .pp-member-social-icons li {
    margin-right: <?php echo $settings->social_links_space; ?>px;
}

<?php
// Social Icons - Space Between Icons
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'social_links_space',
	'selector'		=> ".fl-node-$id .pp-member-social-icons li",
	'prop'			=> 'margin-right',
	'unit'			=> 'px',
) );
?>

.fl-node-<?php echo $id; ?> .pp-member-social-icons li a {
    <?php if ( isset( $settings->social_links_bg_color ) && ! empty( $settings->social_links_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->social_links_bg_color ); ?>;
	<?php } ?>
    <?php if ( isset( $settings->social_links_text_color ) && ! empty( $settings->social_links_text_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->social_links_text_color ); ?>;
	<?php } ?>
    font-size: <?php echo $settings->social_links_font_size; ?>px;
    width: <?php echo ($settings->social_links_font_size * 2.2); ?>px;
    height: <?php echo ($settings->social_links_font_size * 2.2); ?>px;
}

<?php
// Social Links - Border
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'social_links_border_group',
	'selector' 		=> ".fl-node-$id .pp-member-social-icons li a",
) );

FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'social_links_padding',
	'selector' 		=> ".fl-node-$id .pp-member-social-icons li a",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'social_links_padding_top',
		'padding-right' 	=> 'social_links_padding_right',
		'padding-bottom' 	=> 'social_links_padding_bottom',
		'padding-left' 		=> 'social_links_padding_left',
	),
) );
?>

.fl-node-<?php echo $id; ?> .pp-member-social-icons li a:hover {
    <?php if ( isset( $settings->social_links_bg_hover_color ) && ! empty( $settings->social_links_bg_hover_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->social_links_bg_hover_color ); ?>;
	<?php } ?>
    <?php if ( isset( $settings->social_links_text_hover_color ) && ! empty( $settings->social_links_text_hover_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->social_links_text_hover_color ); ?>;
	<?php } ?>
    <?php if( $settings->social_links_border_hover_color ) { ?> border-color: #<?php echo $settings->social_links_border_hover_color; ?>; <?php } ?>
}

<?php if( $settings->content_position == 'hover' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-member-wrapper {
		position: relative;
	}
	.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-content {
		position: absolute;
	    top: 0;
	    left: 0;
	    right: 0;
	    bottom: 0;
	    opacity: 0;
	    overflow: hidden;
	    -webkit-transition: all 0.2s ease-in;
	    -moz-transition: all 0.2s ease-in;
	    -o-transition: all 0.2s ease-in;
	    -ms-transition: all 0.2s ease-in;
	    transition: all 0.2s ease-in;
	}
	.fl-node-<?php echo $id; ?> .pp-member-wrapper:hover .pp-member-content {
		opacity: 1;
	}
	.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-content-inner-wrapper {
		display: table;
		width: 100%;
		height: 100%;
	}
	.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-content-inner {
		display: table-cell;
		vertical-align: middle;
	}
<?php } ?>

<?php if( $settings->content_position == 'over' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-member-wrapper {
		position: relative;
	}
	.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-content {
		position: absolute;
		height: 20%;
		bottom: 0;
	    left: 0;
	    right: 0;
	    overflow: hidden;
		-webkit-transition: height 0.4s ease, top 0.4s ease;
		-moz-transition: height 0.4s ease, top 0.4s ease;
		-o-transition: height 0.4s ease, top 0.4s ease;
		-ms-transition: height 0.4s ease, top 0.4s ease;
		transition: height 0.4s ease, top 0.4s ease;
		padding: 20px;
	}

	.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-description,
	.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-designation {
		opacity: 0;
		-webkit-transition: opacity 0.5s ease-in;
	    -moz-transition: opacity 0.5s ease-in;
	    -o-transition: opacity 0.5s ease-in;
	    -ms-transition: opacity 0.5s ease-in;
	    transition: opacity 0.5s ease-in;
	}
	.fl-node-<?php echo $id; ?> .pp-member-wrapper:hover .pp-member-description,
	.fl-node-<?php echo $id; ?> .pp-member-wrapper:hover .pp-member-designation {
		opacity: 1;
		-webkit-transition: opacity 0.5s ease-in;
	    -moz-transition: opacity 0.5s ease-in;
	    -o-transition: opacity 0.5s ease-in;
	    -ms-transition: opacity 0.5s ease-in;
	    transition: opacity 0.5s ease-in;
	}
	.fl-node-<?php echo $id; ?> .pp-member-wrapper:hover .pp-member-content {
		height: 100%;
		-webkit-transition: height 0.4s ease, top 0.4s ease;
	    -moz-transition: height 0.4s ease, top 0.4s ease;
	    -o-transition: height 0.4s ease, top 0.4s ease;
	    -ms-transition: height 0.4s ease, top 0.4s ease;
	    transition: height 0.4s ease, top 0.4s ease;
	}
	.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-content-inner-wrapper {
		display: table;
		width: 100%;
		height: 100%;
	}
	.fl-node-<?php echo $id; ?> .pp-member-wrapper .pp-member-content-inner {
		display: table-cell;
		vertical-align: middle;
	}
<?php } ?>