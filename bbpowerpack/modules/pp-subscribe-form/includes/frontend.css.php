
<?php
// Box Padding
if ( 'standard' != $settings->box_type && 'fixed_bottom' != $settings->box_type ) {

	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'box_padding',
		'selector' 		=> ".fl-node-$id .pp-subscribe-content",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'box_padding_top',
			'padding-right' 	=> 'box_padding_right',
			'padding-bottom' 	=> 'box_padding_bottom',
			'padding-left' 		=> 'box_padding_left',
		),
	) );
} 
// Form Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'form_padding',
	'selector' 		=> ".fl-node-$id .pp-subscribe-form",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'form_padding_top',
		'padding-right' 	=> 'form_padding_right',
		'padding-bottom' 	=> 'form_padding_bottom',
		'padding-left' 		=> 'form_padding_left',
	),
) );
// Input Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'input_field_padding',
	'selector' 		=> ".fl-node-$id .pp-subscribe-form input[type=text],
						.fl-node-$id .pp-subscribe-form input[type=email],
						.fl-node-$id .pp-subscribe-form textarea,
						.fl-node-$id .pp-subscribe-form input[type=tel]",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'input_field_padding_top',
		'padding-right' 	=> 'input_field_padding_right',
		'padding-bottom' 	=> 'input_field_padding_bottom',
		'padding-left' 		=> 'input_field_padding_left',
	),
) );
// Button Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'button_padding',
	'selector' 		=> ".fl-node-$id .pp-subscribe-form a.fl-button,
						.fl-node-$id .pp-subscribe-form a.fl-button:visited",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'button_padding_top',
		'padding-right' 	=> 'button_padding_right',
		'padding-bottom' 	=> 'button_padding_bottom',
		'padding-left' 		=> 'button_padding_left',
	),
) );

// Form Border - Settings
if ( 'standard' == $settings->box_type || 'fixed_bottom' == $settings->box_type ) {
	$classAdded = ".fl-node-" . $id . " .pp-subscribe-form";
} else {
	$classAdded = ".fl-node-" . $id . ".pp-subscribe-box";
}
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'form_border_group',
	'selector' 		=> $classAdded,
) );

// Form Content Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'content_typography',
	'selector' 		=> ".fl-node-$id .pp-subscribe-content",
) );

// Form Input Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'input_typography',
	'selector' 		=> ".fl-node-$id .pp-subscribe-form input[type=text],
						.fl-node-$id .pp-subscribe-form input[type=email],
						.fl-node-$id .pp-subscribe-form textarea,
						.fl-node-$id .pp-subscribe-form input[type=tel]",
) );

// Form Button Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'button_typography',
	'selector' 		=> ".fl-node-$id .pp-subscribe-form a.fl-button,
						.fl-node-$id .pp-subscribe-form a.fl-button:visited",
) );

// Checkbox Font
if ( isset( $settings->checkbox_font_size ) && 'custom' == $settings->checkbox_font_size ) {
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'checkbox_font_size_custom',
		'selector'		=> ".fl-node-$id .pp-subscribe-form .pp-checkbox-input label",
		'prop'			=> 'font-size',
		'unit'			=> 'px',
	) );	
}
// Placeholder Font
if ( isset( $settings->placeholder_size ) && 'custom' == $settings->placeholder_size ) {
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'placeholder_font_size',
		'selector'		=> ".fl-node-$id .pp-subscribe-form input[type=text]::-webkit-input-placeholder,
							.fl-node-$id .pp-subscribe-form input[type=email]::-webkit-input-placeholder",
		'prop'			=> 'font-size',
		'unit'			=> 'px',
	) );	
}
// Validation Error Font
if ( isset( $settings->validation_error_size ) && 'custom' == $settings->validation_error_size ) {
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'validation_error_font_size',
		'selector'		=> ".fl-node-$id .pp-subscribe-form .pp-form-error-message",
		'prop'			=> 'font-size',
		'unit'			=> 'px',
	) );	
}
// Success Message Error Font
if ( isset( $settings->success_message_size ) && 'custom' == $settings->success_message_size ) {
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'success_message_font_size',
		'selector'		=> ".fl-node-$id .pp-subscribe-form .pp-form-success-message",
		'prop'			=> 'font-size',
		'unit'			=> 'px',
	) );	
}
?>

.fl-node-<?php echo $id; ?>.pp-subscribe-box {
	display: block;
	<?php if ( !empty($settings->box_bg) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->box_bg ); ?>;
	<?php } ?>
	max-width: <?php echo $settings->box_width; ?>px;
	height: <?php echo $settings->box_height; ?>px;
	<?php if ( ! FLBuilderModel::is_builder_active() ) { ?>
	position: fixed;
	<?php } ?>
	<?php if ( 'welcome_gate' == $settings->box_type ) { ?>
		<?php if ( ! FLBuilderModel::is_builder_active() ) { ?>
			background-color: transparent;
			background: none;
		<?php } ?>
		top: 0;
		left: 0;
		right: auto;
		bottom: auto;
		-webkit-transition: top 0.5s ease-in-out;
		-moz-transition: top 0.5s ease-in-out;
		transition: top 0.5s ease-in-out;
	<?php } else { ?>
		<?php echo $settings->slidein_position; ?>: -<?php echo $settings->box_width + 50; ?>px;
		bottom: 0;
	<?php } ?>
	z-index: 100002;
	<?php if ( 'slidein' == $settings->box_type ) { ?>
	-webkit-transition: <?php echo $settings->slidein_position; ?> 0.3s ease-in-out;
	-moz-transition: <?php echo $settings->slidein_position; ?> 0.3s ease-in-out;
	transition: <?php echo $settings->slidein_position; ?> 0.3s ease-in-out;
	<?php } ?>
}
.fl-node-<?php echo $id; ?>.pp-subscribe-popup_scroll,
.fl-node-<?php echo $id; ?>.pp-subscribe-popup_exit,
.fl-node-<?php echo $id; ?>.pp-subscribe-popup_auto,
.fl-node-<?php echo $id; ?>.pp-subscribe-welcome_gate {
	<?php if ( ! FLBuilderModel::is_builder_active() ) { ?>
	display: none;
	<?php } ?>
}
<?php if ( 'yes' == $settings->show_overlay || 'welcome_gate' == $settings->box_type ) { ?>
.pp-subscribe-<?php echo $id; ?>-overlay {
	display: none;
	<?php if ( 'welcome_gate' != $settings->box_type ) { ?>
		background-color: <?php echo pp_hex2rgba( '#'.$settings->overlay_color, $settings->overlay_opacity/100 ); ?>;
	<?php } else { ?>
		background-color: <?php echo pp_get_color_value( $settings->box_bg ); ?>;
	<?php } ?>
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 100001;
}
<?php } ?>
.fl-node-<?php echo $id; ?>.pp-subscribe-slidein.pp-box-active {
	<?php echo $settings->slidein_position; ?>: 0;
}
.fl-node-<?php echo $id; ?>.pp-subscribe-box .pp-subscribe-inner {
	position: relative;
    float: left;
	height: 100%;
    width: 100%;
}
.fl-node-<?php echo $id; ?>.pp-subscribe-box .pp-subscribe-body {
	display: block;
    height: 100%;
    width: 100%;
    overflow: hidden;
}
.fl-node-<?php echo $id; ?> .pp-subscribe-content {
	margin-top: <?php echo $settings->content_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->content_margin['bottom']; ?>px;
}
.fl-node-<?php echo $id; ?>.pp-subscribe-box .pp-subscribe-content,
.fl-node-<?php echo $id; ?>.pp-subscribe-box .pp-subscribe-form {
	float: left;
	width: 100%;
}
.fl-node-<?php echo $id; ?>.pp-subscribe-box .pp-box-close {
	border-radius: 100%;
	position: <?php echo 'welcome_gate' == $settings->box_type ? 'fixed' : 'absolute'; ?>;
	<?php if ( 'slidein' == $settings->box_type ) { ?>
    	<?php echo 'left' == $settings->slidein_position ? 'right' : 'left'; ?>: -10px;
	<?php } else { ?>
		right: -10px;
	<?php } ?>
    top: -10px;
	<?php if ( 'welcome_gate' == $settings->box_type ) { ?>
		<?php if ( FLBuilderModel::is_builder_active() ) { ?>
			display: none;
		<?php } ?>
		right: 20px;
		top: 20px;
		background: #dadada;
		border: 2px solid #fff;
		width: 40px;
		padding: 2px;
	<?php } else { ?>
    	background: #000;
		border: 2px solid #000;
		width: 20px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?>.pp-subscribe-box .pp-box-close .pp-box-close-svg {
	display: block;
}
.fl-node-<?php echo $id; ?>.pp-subscribe-box .pp-box-close .pp-box-close-svg path {
	stroke: <?php if ( 'welcome_gate' == $settings->box_type ){ echo pp_get_color_value( $settings->box_bg ); }else{ echo '#fff'; }?>;
    fill: transparent;
    stroke-linecap: round;
    stroke-width: 5;
}
.fl-node-<?php echo $id; ?>.pp-subscribe-box .pp-subscribe-content p:last-of-type {
	margin-bottom: 0;
}
.fl-node-<?php echo $id; ?>.pp-subscribe-box .pp-form-field {
	position: relative;
}
.fl-node-<?php echo $id; ?>.pp-subscribe-box .pp-form-error-message {
	position: <?php echo 'welcome_gate' == $settings->box_type ? 'static' : 'absolute'; ?>;
    top: -30px;
}

.fl-node-<?php echo $id; ?> .pp-subscribe-form {
	<?php if ( $settings->box_type != 'welcome_gate' ) { ?>
		background-color: 
		<?php echo ($settings->form_bg_color && $settings->form_bg_type == 'color') ? pp_get_color_value( $settings->form_bg_color ) : 'transparent'; ?>;
	    <?php if( $settings->form_bg_image && $settings->form_bg_type == 'image' ) { ?>
		background-image: url('<?php echo $settings->form_bg_image_src; ?>');
	    <?php } ?>
	    <?php if( $settings->form_bg_size ) { ?>
	    background-size: <?php echo $settings->form_bg_size; ?>;
	    <?php } ?>
	    <?php if( $settings->form_bg_repeat ) { ?>
	    background-repeat: <?php echo $settings->form_bg_repeat; ?>;
	    <?php } ?>
	<?php } ?>

	<?php if ( 'fixed_bottom' == $settings->box_type && ! FLBuilderModel::is_builder_active() ) { ?>
		position: fixed;
	    bottom: -999px;
	    left: 0;
	    width: 100%;
	    z-index: 100001;
		-webkit-transition: 0.3s bottom ease-in-out;
		-moz-transition: 0.3s bottom ease-in-out;
		transition: 0.3s bottom ease-in-out;
	<?php } ?>
}
<?php if ( 'fixed_bottom' == $settings->box_type && ! FLBuilderModel::is_builder_active() ) { ?>
.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-box-close {
	position: absolute;
    height: 30px;
    width: 30px;
    display: inline-block;
    margin: 0 auto;
    text-align: center;
    left: 50%;
    top: -15px;
	background: #fff;
    border: 1px solid <?php echo ( '' != $settings->form_bg_color ) ? pp_get_color_value( $settings->form_bg_color ) : '#666'; ?>;
    border-radius: 100%;
	cursor: pointer;
}
.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-box-close:before {
	content: "x";
    color: <?php echo ('' != $settings->form_bg_color && 'ffffff' != $settings->form_bg_color ) ? pp_get_color_value( $settings->form_bg_color ) : '#666'; ?>;
    font-family: sans-serif;
    font-size: 18px;
}
.fl-node-<?php echo $id; ?> .pp-subscribe-form.pp-box-active {
	bottom: 0;
	right: auto;
	-webkit-transition: 0.3s bottom ease-in-out;
	-moz-transition: 0.3s bottom ease-in-out;
	transition: 0.3s bottom ease-in-out;
}
.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-subscribe-form-inner {
	margin: 0 auto;
	margin-top: 8px;
	max-width: <?php echo $settings->box_width; ?>px;
}
<?php } ?>

<?php if( $settings->input_custom_width == 'custom' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-form-field.pp-name-field {
		width: <?php echo $settings->input_name_width; ?>%;
	}
	.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-form-field.pp-email-field {
		width: <?php echo $settings->input_email_width; ?>%;
	}
	.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-form-button {
		width: <?php echo $settings->input_button_width; ?>%;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-form-button {
	<?php if($settings->btn_align == 'right') { ?>
		float: right;
	<?php } ?>
	<?php if($settings->btn_align == 'center') { ?>
		margin: 0 auto;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-form-field {
	<?php if( $settings->layout == 'inline' ) { ?>
	padding-right: <?php echo $settings->inputs_space; ?>%;
	<?php } ?>
	<?php if( $settings->layout == 'stacked' ) { ?>
	margin-bottom: <?php echo $settings->inputs_space; ?>%;
	<?php } ?>
}

<?php if( $settings->layout == 'compact' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-subscribe-form-compact .pp-form-field.pp-name-field {
		padding-right: <?php echo $settings->inputs_space; ?>%;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-checkbox-input {
	width: 100% !important;
}
.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-checkbox-input label {
	<?php if ( isset( $settings->checkbox_text_color ) && ! empty( $settings->checkbox_text_color ) ) { ?>
	color: <?php echo pp_get_color_value($settings->checkbox_text_color); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=text],
.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=email] {
	<?php if( $settings->input_field_text_color ) { ?>
    color: <?php echo pp_get_color_value($settings->input_field_text_color); ?>;
    <?php } ?>
	background-color: <?php if ( '' != $settings->input_field_bg_color ) { echo pp_get_color_value( $settings->input_field_bg_color ); }else{ echo 'transparent'; }?>;
	border-width: 0;
	border-style: solid;
	border-color: <?php echo $settings->input_field_border_color ? pp_get_color_value($settings->input_field_border_color) : 'transparent'; ?>;
    <?php if( $settings->input_field_border_radius >= 0 ) { ?>
	border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -moz-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -webkit-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -ms-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -o-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    <?php } ?>
    <?php if( $settings->input_border_width['top'] >= 0 ) { ?>
    border-top-width: <?php echo $settings->input_border_width['top']; ?>px;
    <?php } ?>
	<?php if( $settings->input_border_width['bottom'] >= 0 ) { ?>
    border-bottom-width: <?php echo $settings->input_border_width['bottom']; ?>px;
    <?php } ?>
	<?php if( $settings->input_border_width['left'] >= 0 ) { ?>
    border-left-width: <?php echo $settings->input_border_width['left']; ?>px;
    <?php } ?>
	<?php if( $settings->input_border_width['right'] >= 0 ) { ?>
    border-right-width: <?php echo $settings->input_border_width['right']; ?>px;
    <?php } ?>

    <?php if( $settings->input_field_box_shadow == 'yes' && ! empty( $settings->input_shadow_color ) ) { ?>
        box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px <?php echo pp_get_color_value($settings->input_shadow_color); ?>;
        -moz-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px <?php echo pp_get_color_value($settings->input_shadow_color); ?>;
        -webkit-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px <?php echo pp_get_color_value($settings->input_shadow_color); ?>;
        -ms-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px <?php echo pp_get_color_value($settings->input_shadow_color); ?>;
        -o-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px <?php echo pp_get_color_value($settings->input_shadow_color); ?>;
    <?php } ?>
	height: <?php echo $settings->input_height; ?>px;
}

.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=text]:focus,
.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=email]:focus {
	border-color: <?php echo $settings->input_field_focus_color ? pp_get_color_value($settings->input_field_focus_color) : 'transparent'; ?>;
}

.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=text]::-webkit-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: <?php echo pp_get_color_value($settings->input_placeholder_color); ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
	text-transform: <?php echo $settings->placeholder_text_transform; ?>;
}

.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=text]:-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=text]::-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: <?php echo pp_get_color_value($settings->input_placeholder_color); ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=text]:-ms-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: <?php echo pp_get_color_value($settings->input_placeholder_color); ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=email]::-webkit-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
	text-transform: <?php echo $settings->placeholder_text_transform; ?>;
}
.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=email]:-moz-placeholder {
    <?php if( $settings->input_placeholder_color ) { ?>
    color: <?php echo pp_get_color_value($settings->input_placeholder_color); ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=email]::-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: <?php echo pp_get_color_value($settings->input_placeholder_color); ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-subscribe-form input[type=email]:-ms-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: <?php echo pp_get_color_value($settings->input_placeholder_color); ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}

<?php

FLBuilder::render_module_css('fl-button', $id, array(
	'align'             => '',
	'bg_color'          => $settings->btn_bg_color,
	'bg_hover_color'    => $settings->btn_bg_hover_color,
	'bg_opacity'        => $settings->btn_bg_opacity,
	'bg_hover_opacity'  => $settings->btn_bg_hover_opacity,
	'icon'              => $settings->btn_icon,
	'icon_position'     => $settings->btn_icon_position,
	'icon_animation'    => $settings->btn_icon_animation,
	'link'              => '#',
	'link_target'       => '_self',
	'style'             => $settings->btn_style,
	'text'              => $settings->btn_text,
	'text_color'        => $settings->btn_text_color,
	'text_hover_color'  => $settings->btn_text_hover_color,
	'width'             => 'full'
));
?>

<?php
// Button Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'button_border_group',
	'selector' 		=> ".fl-builder-content .fl-node-$id .pp-subscribe-form a.fl-button, .fl-builder-content .fl-node-$id .pp-subscribe-form a.fl-button:visited",
) );
?>
.fl-node-<?php echo $id; ?> .pp-subscribe-form a.fl-button,
.fl-node-<?php echo $id; ?> .pp-subscribe-form a.fl-button:visited {
	text-decoration: none;
	background-color: <?php echo $settings->btn_bg_color ? pp_get_color_value( $settings->btn_bg_color ) : 'transparent'; ?>;
	display: block;
	clear: both;
	height: <?php echo $settings->btn_height; ?>px;
	<?php if( $settings->layout == 'stacked' ) { ?>
		margin-top: <?php echo $settings->btn_margin; ?>%;
	<?php } ?>
}

div.fl-node-<?php echo $id; ?> .pp-subscribe-form a.fl-button:hover {
	background-color: <?php echo $settings->btn_bg_hover_color ? pp_get_color_value( $settings->btn_bg_hover_color ) : 'transparent'; ?>;
	<?php if( $settings->btn_border_hover_color ) { ?>
		border-color: <?php echo pp_get_color_value($settings->btn_border_hover_color); ?>;
    <?php } ?>
}

<?php if ('enable' == $settings->btn_button_transition): ?>
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-button,
.fl-builder-content .fl-node-<?php echo $id; ?> .fl-button * {
	-webkit-transition: all 0.2s ease-in-out;
    -moz-transition: all 0.2s ease-in-out;
    -o-transition: all 0.2s ease-in-out;
	transition: all 0.2s ease-in-out;
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .pp-subscribe-form a.fl-button:focus {
	border: 0;
}

.fl-node-<?php echo $id; ?> .pp-subscribe-form .fl-button-wrap {
	<?php if( $settings->layout == 'stacked' ) { ?>
		text-align: <?php echo $settings->btn_align; ?>;
	<?php } ?>
}

<?php if( $settings->layout == 'stacked' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-subscribe-form-compact .pp-form-field:last-child {
		margin-bottom: <?php echo $settings->btn_margin; ?>%;
	}
<?php } ?>

<?php if( $settings->layout == 'compact' ) { ?>
.fl-node-<?php echo $id; ?> .pp-subscribe-form-compact .pp-form-field {
	margin-bottom: <?php echo $settings->btn_margin; ?>%;
}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-subscribe-form a.fl-button .fl-button-icon,
.fl-node-<?php echo $id; ?> .pp-subscribe-form a.fl-button .fl-button-icon:before {
	font-size: <?php echo $settings->btn_icon_size; ?>px;
}

.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-form-error-message {
    <?php if( $settings->validation_message_color ) { ?>
		color: <?php echo pp_get_color_value($settings->validation_message_color); ?>;
    <?php } ?>
	text-transform: <?php echo $settings->error_text_transform; ?>;
}

.fl-node-<?php echo $id; ?> .pp-subscribe-form .pp-form-success-message {
	<?php if( $settings->success_message_color ) { ?>
	color: <?php echo pp_get_color_value($settings->success_message_color); ?>;
    <?php } ?>
	text-transform: <?php echo $settings->success_message_text_transform; ?>;
}
