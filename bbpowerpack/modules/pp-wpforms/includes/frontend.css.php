/**
 * $module An instance of your module class.
 * $id The module's ID.
 * $settings The module's settings.
*/


.fl-node-<?php echo $id; ?> .pp-wpforms-content {
	<?php if ( isset( $settings->form_bg_color ) && ! empty( $settings->form_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->form_bg_color ); ?>;
	<?php } ?>
	<?php if( $settings->form_bg_image ) { ?>
	background-image: url('<?php echo wp_get_attachment_url( absint($settings->form_bg_image) ); ?>');
    <?php } ?>
    <?php if( $settings->form_bg_size ) { ?>
    background-size: <?php echo $settings->form_bg_size; ?>;
    <?php } ?>
    <?php if( $settings->form_bg_repeat ) { ?>
    background-repeat: <?php echo $settings->form_bg_repeat; ?>;
    <?php } ?>
}

<?php
	// Form - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'form_border',
		'selector' 		=> ".fl-node-$id .pp-wpforms-content",
	) );

	// Form - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'form_padding',
		'selector' 		=> ".fl-node-$id .pp-wpforms-content",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'form_padding_top',
			'padding-right' 	=> 'form_padding_right',
			'padding-bottom' 	=> 'form_padding_bottom',
			'padding-left' 		=> 'form_padding_left',
		),
	) );
?>

<?php if( $settings->form_bg_image && $settings->form_bg_type == 'image' ) { ?>
.fl-node-<?php echo $id; ?> .pp-wpforms-content:before {
	<?php if ( isset( $settings->form_bg_overlay ) && ! empty( $settings->form_bg_overlay ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->form_bg_overlay ); ?>;
	<?php } ?>
}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form  .wpforms-field {
    <?php if( $settings->input_field_margin >= 0 ) { ?>
	margin-bottom: <?php echo $settings->input_field_margin; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-title,
.fl-node-<?php echo $id; ?> .pp-wpforms-content .pp-form-title {
    <?php if( $settings->title_color ) { ?>
    color: #<?php echo $settings->title_color; ?>;
    <?php } ?>
	display: <?php echo ($settings->title_field == 'false') ? 'none' : 'block'; ?>;
    <?php if( $settings->title_margin['top'] >= 0 ) { ?>
	margin-top: <?php echo $settings->title_margin['top']; ?>px;
	<?php } ?>
	<?php if( $settings->title_margin['bottom'] >= 0 ) { ?>
	margin-bottom: <?php echo $settings->title_margin['bottom']; ?>px;
	<?php } ?>
}

<?php
	// Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'title_typography',
		'selector' 		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-title, .fl-node-$id .pp-wpforms-content .pp-form-title",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-wpforms-content .pp-form-title {
	display: <?php echo ($settings->form_custom_title_desc == 'yes') ? 'block' : 'none'; ?>;
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-title {
	<?php if( $settings->form_custom_title_desc == 'yes' ) { ?>
	display: none;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-description,
.fl-node-<?php echo $id; ?> .pp-wpforms-content .pp-form-description {
    <?php if( $settings->description_color ) { ?>
    color: #<?php echo $settings->description_color; ?>;
    <?php } ?>
	display: <?php echo ($settings->description_field == 'false') ? 'none' : 'block'; ?>;
    <?php if( $settings->description_margin['top'] >= 0 ) { ?>
	margin-top: <?php echo $settings->description_margin['top']; ?>px;
	<?php } ?>
	<?php if( $settings->description_margin['bottom'] >= 0 ) { ?>
	margin-bottom: <?php echo $settings->description_margin['bottom']; ?>px;
	<?php } ?>
}

<?php
	// Description Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'description_typography',
		'selector' 		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-description, .fl-node-$id .pp-wpforms-content .pp-form-description",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-wpforms-content .pp-form-description {
    display: <?php echo ($settings->form_custom_title_desc == 'yes') ? 'block' : 'none'; ?>;
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-description {
	<?php if( $settings->form_custom_title_desc == 'yes' ) { ?>
	display: none;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-field-label {
    <?php if( $settings->form_label_color ) { ?>
	color: #<?php echo $settings->form_label_color; ?>;
    <?php } ?>
    <?php if( $settings->display_labels ) { ?>
    display: <?php echo $settings->display_labels; ?>;
    <?php } ?>
}

<?php
	// Label Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'label_typography',
		'selector' 		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-field-label",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-field-sublabel,
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-field-label-inline {
    <?php if( $settings->form_label_color ) { ?>
    color: #<?php echo $settings->form_label_color; ?>;
    <?php } ?>
    <?php if( $settings->label_typography['font_family'] != 'Default' ) { ?>
    font-family: <?php echo $settings->label_typography['font_family']; ?>;
	font-weight: <?php echo $settings->label_typography['font_weight']; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-field-description {
    <?php if( $settings->input_desc_color ) { ?>
    color: #<?php echo $settings->input_desc_color; ?>;
    <?php } ?>
    <?php if( $settings->label_typography['font_family'] != 'Default' ) { ?>
    font-family: <?php echo $settings->label_typography['font_family']; ?>;
	font-weight: <?php echo $settings->label_typography['font_weight']; ?>;
    <?php } ?>
}

<?php
	// Input Description - Font Size
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'input_desc_font_size',
		'selector'		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-field-description",
		'prop'			=> 'font-size',
		'unit'			=> 'px',
	) );

	// Input Description - Line Height
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'input_desc_line_height',
		'selector'		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-field-description",
		'prop'			=> 'line-height',
	) );
?>


.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form select,
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form textarea {
    <?php if( $settings->input_field_text_color ) { ?>
    color: #<?php echo $settings->input_field_text_color; ?>;
    <?php } ?>
	<?php if ( isset( $settings->input_field_bg_color ) && ! empty( $settings->input_field_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->input_field_bg_color ); ?>;
	<?php } ?>
	border-width: 0;
	border-color: <?php echo $settings->input_field_border_color ? '#' . $settings->input_field_border_color : 'transparent'; ?>;
    <?php if( $settings->input_field_border_radius >= 0 ) { ?>
	border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -moz-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -webkit-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -ms-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -o-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    <?php } ?>
    <?php if( $settings->input_field_border_width >= 0 ) { ?>
    <?php echo $settings->input_field_border_position; ?>-width: <?php echo $settings->input_field_border_width; ?>px;
    <?php } ?>
	<?php echo ($settings->input_field_width == 'true') ? 'width: 100% !important;' : ''; ?>
    <?php if( $settings->input_field_box_shadow == 'yes' ) { ?>
        box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px #<?php echo $settings->input_shadow_color; ?>;
        -moz-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px #<?php echo $settings->input_shadow_color; ?>;
        -webkit-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px #<?php echo $settings->input_shadow_color; ?>;
        -ms-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px #<?php echo $settings->input_shadow_color; ?>;
        -o-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px #<?php echo $settings->input_shadow_color; ?>;
    <?php } else { ?>
		box-shadow: none;
	<?php } ?>
}

<?php
	// Input Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'input_typography',
		'selector' 		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']), .fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form select, .fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form textarea",
	) );

	// Input - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'input_field_padding',
		'selector' 		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']), .fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form select, .fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form textarea",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'input_field_padding_top',
			'padding-right' 	=> 'input_field_padding_right',
			'padding-bottom' 	=> 'input_field_padding_bottom',
			'padding-left' 		=> 'input_field_padding_left',
		),
	) );
?>

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form select {
    <?php if( $settings->input_field_height ) { ?>
    height: <?php echo $settings->input_field_height; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-field-row input,
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-field-row select,
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-field-row textarea {
    margin-bottom: <?php echo ( $settings->input_field_margin * 40 ) / 100 ?>px;
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form textarea {
    <?php if( $settings->input_textarea_height ) { ?>
    height: <?php echo $settings->input_textarea_height; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file'])::-webkit-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']):-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file'])::-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']):-ms-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form select::-webkit-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form select:-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form select::-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form select:-ms-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form textarea::-webkit-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form textarea:-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form textarea::-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form textarea:-ms-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']):focus,
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form select:focus,
.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form textarea:focus {
    border-color: <?php echo $settings->input_field_focus_color ? '#' . $settings->input_field_focus_color : 'transparent'; ?>;
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form .wpforms-submit-container {
    text-align: <?php echo $settings->button_alignment; ?>;
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form button {
    <?php if( $settings->button_text_color_default ) { ?>
	color: #<?php echo $settings->button_text_color_default; ?>;
    <?php } ?>
	<?php if ( isset( $settings->button_bg_color_default ) && ! empty( $settings->button_bg_color_default ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->button_bg_color_default ); ?>;
	<?php } ?>
    <?php if( $settings->button_width == 'true' ) { ?> width: 100%; <?php } ?>
}

<?php
	// Button - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'button_border',
		'selector' 		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form button, .fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form button:hover",
	) );

	// Button Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'button_typography',
		'selector' 		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form button",
	) );

	// Button - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'button_padding',
		'selector' 		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form button",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'button_padding_top',
			'padding-right' 	=> 'button_padding_right',
			'padding-bottom' 	=> 'button_padding_bottom',
			'padding-left' 		=> 'button_padding_left',
		),
	) );
?>

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form button:hover {
    <?php if( $settings->button_text_color_hover ) { ?>
	color: #<?php echo $settings->button_text_color_hover; ?>;
    <?php } ?>
	<?php if ( isset( $settings->button_background_color_hover ) && ! empty( $settings->button_background_color_hover ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->button_background_color_hover ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-wpforms-content div.wpforms-container-full .wpforms-form label.wpforms-error {
    <?php if( $settings->validation_message ) { ?>
	display: <?php echo $settings->validation_message; ?>;
    <?php } ?>
    <?php if( $settings->validation_message_color ) { ?>
	color: #<?php echo $settings->validation_message_color; ?>;
    <?php } ?>
}

<?php
	// Validation Message - Font Size
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'validation_message_font_size',
		'selector'		=> ".fl-node-$id .pp-wpforms-content div.wpforms-container-full .wpforms-form label.wpforms-error",
		'prop'			=> 'font-size',
		'unit'			=> 'px',
	) );
?>

.fl-node-<?php echo $id; ?> .pp-wpforms-content .wpforms-confirmation-container-full {
    <?php if( $settings->success_message_color ) { ?>
	color: #<?php echo $settings->success_message_color; ?>;
    <?php } ?>
	border-color: <?php echo $settings->success_message_border_color ? '#' . $settings->success_message_border_color : 'transparent'; ?>;
	<?php if ( isset( $settings->success_message_bg_color ) && ! empty( $settings->success_message_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->success_message_bg_color ); ?>;
	<?php } ?>
}

<?php
	// Success Message - Font Size
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'success_message_font_size',
		'selector'		=> ".fl-node-$id .pp-wpforms-content .wpforms-confirmation-container-full",
		'prop'			=> 'font-size',
		'unit'			=> 'px',
	) );
?>