/**
 * $module An instance of your module class.
 * $id The module's ID.
 * $settings The module's settings.
*/
<?php
// Banner Info Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'box_padding',
	'selector' 		=> ".fl-node-$id .pp-highlight-box-content",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'box_padding_top',
		'padding-right' 	=> 'box_padding_right',
		'padding-bottom' 	=> 'box_padding_bottom',
		'padding-left' 		=> 'box_padding_left',
	),
) );
?>
.fl-node-<?php echo $id; ?> .pp-highlight-box-content {
    position: relative;
    <?php if( $settings->box_bg_color ) { ?>
	    background-color: <?php echo pp_get_color_value($settings->box_bg_color); ?>;
    <?php } ?>
    <?php if( $settings->box_text_color ) { ?>
    	color: <?php echo pp_get_color_value($settings->box_text_color); ?>;
    <?php } ?>
	border-radius: <?php echo $settings->box_border_radius; ?>px;
    <?php if( $settings->box_font['family'] != 'Default' ) { ?>
    	<?php FLBuilderFonts::font_css( $settings->box_font ); ?>
    <?php } ?>
    <?php if( $settings->box_font_size ) { ?>
    	font-size: <?php echo $settings->box_font_size; ?>px;
    <?php } ?>
    overflow: hidden;
    -webkit-transition: <?php echo $settings->box_icon_transition_duration; ?>ms background-color ease;
    -moz-transition: <?php echo $settings->box_icon_transition_duration; ?>ms background-color ease;
    -ms-transition: <?php echo $settings->box_icon_transition_duration; ?>ms background-color ease;
    transition: <?php echo $settings->box_icon_transition_duration; ?>ms background-color ease;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content:hover {
    <?php if( $settings->box_bg_hover_color ) { ?>
   		background-color: <?php echo pp_get_color_value($settings->box_bg_hover_color); ?>;
    <?php } ?>
    <?php if( $settings->box_text_hover_color ) { ?>
    color: <?php echo pp_get_color_value($settings->box_text_hover_color); ?>;
    <?php } ?>
    -webkit-transition: <?php echo $settings->box_icon_transition_duration; ?>ms background-color ease;
    -moz-transition: <?php echo $settings->box_icon_transition_duration; ?>ms background-color ease;
    -ms-transition: <?php echo $settings->box_icon_transition_duration; ?>ms background-color ease;
    transition: <?php echo $settings->box_icon_transition_duration; ?>ms background-color ease;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content .box-link {
    <?php if( $settings->box_text_color ) { ?>
    color: <?php echo pp_get_color_value($settings->box_text_color); ?>;
    <?php } ?>
    display: block;
    text-decoration: none;
    box-shadow: none;
    border: none;
    cursor: pointer;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content .font_icon {
    <?php if( $settings->box_font_icon_size ) { ?>
    font-size: <?php echo $settings->box_font_icon_size; ?>px;
    <?php } ?>
    <?php if( $settings->box_font_icon_color ) { ?>
    	color: <?php echo pp_get_color_value($settings->box_font_icon_color); ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content .custom_icon {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    text-align: center;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content .font_icon .font_icon_inner,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content .custom_icon .custom_icon_inner {
    height: 100%;
    width: 100%;
    display: table;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content .font_icon i,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content .custom_icon .custom_icon_inner_wrap {
    display: table-cell;
    vertical-align: middle;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content .custom_icon .custom_icon_inner_wrap {
    height: 100%;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content .custom_icon .custom_icon_inner {
    width: <?php echo $settings->box_custom_icon_width; ?>px;
    margin: 0 auto;
}

fl-node-<?php echo $id; ?> .pp-highlight-box-content .custom_icon img {
    width: margin: 0 auto;
}

/* Box Hover Effect */

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.box-hover .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content.box-hover .custom_icon {
    background-color: <?php echo pp_get_color_value($settings->box_bg_hover_color); ?>;
    opacity: 0.5;
    -webkit-transition: visibility <?php echo $settings->box_icon_transition_duration; ?>ms all, opacity <?php echo $settings->box_icon_transition_duration; ?>ms ease-in;
     -moz-transition: visibility <?php echo $settings->box_icon_transition_duration; ?>ms all, opacity <?php echo $settings->box_icon_transition_duration; ?>ms ease-in;
      -ms-transition: visibility <?php echo $settings->box_icon_transition_duration; ?>ms all, opacity <?php echo $settings->box_icon_transition_duration; ?>ms ease-in;
          transition: visibility <?php echo $settings->box_icon_transition_duration; ?>ms all, opacity <?php echo $settings->box_icon_transition_duration; ?>ms ease-in;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.box-hover:hover .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content.box-hover:hover .custom_icon {
    opacity: 1;
    visibility: visible;
    -webkit-transition: visibility <?php echo $settings->box_icon_transition_duration; ?>ms all, opacity <?php echo $settings->box_icon_transition_duration; ?>ms ease-in;
     -moz-transition: visibility <?php echo $settings->box_icon_transition_duration; ?>ms all, opacity <?php echo $settings->box_icon_transition_duration; ?>ms ease-in;
      -ms-transition: visibility <?php echo $settings->box_icon_transition_duration; ?>ms all, opacity <?php echo $settings->box_icon_transition_duration; ?>ms ease-in;
          transition: visibility <?php echo $settings->box_icon_transition_duration; ?>ms all, opacity <?php echo $settings->box_icon_transition_duration; ?>ms ease-in;
}

/* Box Slide Left Effect */

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-left .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-left .custom_icon {
    left: -200%;
    top: 50%;
    -webkit-transform: translate(0,50%);
    -moz-transform: translate(0,50%);
    -o-transform: translate(0,50%);
    -ms-transform: translate(0,50%);
    transform: translate(0,-50%);
    -webkit-transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    -moz-transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    text-align: center;
}


.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-left:hover .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-left:hover .custom_icon {
    visibility: visible;
    opacity: 1;
    left: 50%;
    transform: translate(-50%, -50%);
}


.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-left .box-text {
    -webkit-transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    -moz-transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-left:hover .box-text {
    -webkit-transform: translateX(1000%);
    -moz-transform: translateX(1000%);
    -o-transform: translateX(1000%);
    -ms-transform: translateX(1000%);
    transform: translateX(1000%);
}

/* Box Slide Right Effect */

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-right .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-right .custom_icon {
    left: 200%;
    top: 50%;
    -webkit-transform: translate(0,-50%);
    -moz-transform: translate(0,-50%);
    -o-transform: translate(0,-50%);
    -ms-transform: translate(0,-50%);
    transform: translate(0,-50%);
    -webkit-transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    -moz-transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    text-align: center;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-right:hover .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-right:hover .custom_icon  {
    visibility: visible;
    opacity: 1;
    left: 50%;
    transform: translate(-50%, -50%);
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-right .box-text {
    -webkit-transition: all .45s;
    -moz-transition: all .45s;
    transition: all .45s;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-right:hover .box-text {
    -webkit-transform: translateX(-1000%);
    -moz-transform: translateX(-1000%);
    -o-transform: translateX(-1000%);
    -ms-transform: translateX(-1000%);
    transform: translateX(-1000%);
}

/* Box Slide Top Effect */

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-top .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-top .custom_icon {
    top: -500px;
    left: 50%;
    -webkit-transform: translate(-50%,0);
    -moz-transform: translate(-50%,0);
    -o-transform: translate(-50%,0);
    -ms-transform: translate(-50%,0);
    transform: translate(-50%,0);
    -webkit-transition: all .3s;
    -moz-transition: all .3s;
    transition: all .3s;
    text-align: center;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-top:hover .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-top:hover .custom_icon  {
    visibility: visible;
    opacity: 1;
    top: 50%;
    transform: translate(-50%, -50%);
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-top .box-text {
    -webkit-transition: all .45s;
    -moz-transition: all .45s;
    transition: all .45s;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-top:hover .box-text {
    -webkit-transform: translateY(1000%);
    -moz-transform: translateY(1000%);
    -o-transform: translateY(1000%);
    -ms-transform: translateY(1000%);
    transform: translateY(1000%);
}

/* Box Slide Bottom Effect */

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-bottom .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-bottom .custom_icon {
    top: 500px;
    left: 50%;
    -webkit-transform: translate(-50%,-50%);
    -moz-transform: translate(-50%,-50%);
    -o-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
    -webkit-transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    -moz-transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    text-align: center;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-bottom:hover .font_icon,
.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-bottom:hover .custom_icon {
    visibility: visible;
    opacity: 1;
    top: 50%;
    transform: translate(-50%, -50%);
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-bottom .box-text {
    -webkit-transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    -moz-transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
    transition: all <?php echo $settings->box_icon_transition_duration; ?>ms;
}

.fl-node-<?php echo $id; ?> .pp-highlight-box-content.slide-bottom:hover .box-text {
    -webkit-transform: translateY(-1000%);
    -moz-transform: translateY(-1000%);
    -o-transform: translateY(-1000%);
    -ms-transform: translateY(-1000%);
    transform: translateY(-1000%);
}
