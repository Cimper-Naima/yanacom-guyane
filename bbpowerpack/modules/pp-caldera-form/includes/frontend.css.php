/**
 * $module An instance of your module class.
 * $id The module's ID.
 * $settings The module's settings.
*/
<?php
// Form Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'form_border_group',
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content",
) );
// File Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'file_border_group',
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid input[type=file]",
) );
// Button Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'button_border_group',
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid input[type=submit]",
) );
// Form Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'form_padding',
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'form_padding_top',
		'padding-right' 	=> 'form_padding_right',
		'padding-bottom' 	=> 'form_padding_bottom',
		'padding-left' 		=> 'form_padding_left',
	),
) );
// Form Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'input_field_padding',
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid .form-control",
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
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid input[type=submit]",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'button_padding_top',
		'padding-right' 	=> 'button_padding_right',
		'padding-bottom' 	=> 'button_padding_bottom',
		'padding-left' 		=> 'button_padding_left',
	),
) );
// Form Title Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'title_typography',
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content .pp-form-title",
) );
// Form Description Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'description_typography',
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content .pp-form-description",
) );
// Form Label Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'label_typography',
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid .form-group > label,
						.fl-node-$id .pp-caldera-form-content .caldera-grid .form-group label",
) );
// Form Input Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'input_typography',
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid .form-control",
) );
// Form Button Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'button_typography',
	'selector' 		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid input[type=submit]",
) );
// Custom Description Font Size
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'input_desc_font_size',
	'selector'		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid .form-group .help-block",
	'prop'			=> 'font-size',
	'unit'			=> 'px',
) );
// Custom Description Line Height Font Size
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'input_desc_line_height',
	'selector'		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid .form-group .help-block",
	'prop'			=> 'line-height',
) );
// Validation Message Font Size
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'validation_message_font_size',
	'selector'		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid .form-group .has-error .help-block,
						.fl-node-$id .pp-caldera-form-content .caldera-grid .form-group .caldera_ajax_error_block",
	'prop'			=> 'font-size',
) );
// Success Message Font Size
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'success_message_font_size',
	'selector'		=> ".fl-node-$id .pp-caldera-form-content .caldera-grid .alert-success",
	'prop'			=> 'font-size',
) );
?>

.fl-node-<?php echo $id; ?> .pp-caldera-form-content {
	background-color: <?php echo $settings->form_bg_color ? pp_get_color_value( $settings->form_bg_color ) : 'transparent'; ?>;
    <?php if( $settings->form_bg_image ) { ?>
	background-image: url('<?php echo $settings->form_bg_image_src; ?>');
    <?php } ?>
    <?php if( $settings->form_bg_size ) { ?>
    background-size: <?php echo $settings->form_bg_size; ?>;
    <?php } ?>
    <?php if( $settings->form_bg_repeat ) { ?>
    background-repeat: <?php echo $settings->form_bg_repeat; ?>;
    <?php } ?>
}

<?php if( $settings->form_bg_image && $settings->form_bg_type == 'image' ) { ?>
.fl-node-<?php echo $id; ?> .pp-caldera-form-content:before {
	background-color: <?php echo ( $settings->form_bg_overlay ) ? pp_get_color_value( $settings->form_bg_overlay ) : 'transparent'; ?>;
}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .single > div {
	list-style-type: none !important;
    <?php if( $settings->input_field_margin >= 0 ) { ?>
	margin-bottom: <?php echo $settings->input_field_margin; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .pp-form-title {
    <?php if( $settings->title_color ) { ?>
	    color: #<?php echo $settings->title_color; ?>;
    <?php } ?>
	display: <?php echo ($settings->form_custom_title_desc == 'no') ? 'none' : 'block'; ?>;
    <?php if( $settings->title_margin['top'] >= 0 ) { ?>
		margin-top: <?php echo $settings->title_margin['top']; ?>px;
	<?php } ?>
	<?php if( $settings->title_margin['bottom'] >= 0 ) { ?>
		margin-bottom: <?php echo $settings->title_margin['bottom']; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .pp-form-title {
	display: <?php echo ($settings->form_custom_title_desc == 'yes') ? 'block' : 'none'; ?>;
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .pp-form-description {
    <?php if( $settings->description_color ) { ?>
	    color: #<?php echo $settings->description_color; ?>;
    <?php } ?>
	display: <?php echo ($settings->form_custom_title_desc == 'no') ? 'none' : 'block'; ?>;
    <?php if( $settings->description_margin['top'] >= 0 ) { ?>
		margin-top: <?php echo $settings->description_margin['top']; ?>px;
	<?php } ?>
	<?php if( $settings->description_margin['bottom'] >= 0 ) { ?>
		margin-bottom: <?php echo $settings->description_margin['bottom']; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .pp-form-description {
    display: <?php echo ($settings->form_custom_title_desc == 'yes') ? 'block' : 'none'; ?>;
}

.fl-node-<?php echo $id; ?> .pp-ff-content .frm_style_formidable-style.with_frm_style .frm_form_title + div.frm_description {
	<?php if( $settings->form_custom_title_desc == 'yes' ) { ?>
	display: none;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-group > label {
    <?php if( $settings->form_label_color ) { ?>
	color: #<?php echo $settings->form_label_color; ?>;
    <?php } ?>
    <?php if( $settings->display_labels ) { ?>
    display: <?php echo $settings->display_labels; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-group label,
.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid > div {
    <?php if( $settings->form_label_color ) { ?>
    color: #<?php echo $settings->form_label_color; ?>;
    <?php } ?>
	<?php if( isset( $settings->label_typography['font_family'] ) && 'Default' != $settings->label_typography['font_family'] ) { ?>		
		font-family: <?php echo $settings->label_typography['font_family']; ?>;
    	font-weight: <?php echo $settings->label_typography['font_weight']; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-group .help-block {
    <?php if( $settings->input_desc_color ) { ?>
    color: #<?php echo $settings->input_desc_color; ?>;
    <?php } ?>
	<?php if( isset( $settings->label_typography['font_family'] ) && 'Default' != $settings->label_typography['font_family'] ) { ?>		
		font-family: <?php echo $settings->label_typography['font_family']; ?>;
    	font-weight: <?php echo $settings->label_typography['font_weight']; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-control {
    <?php if( $settings->input_field_text_color ) { ?>
    color: #<?php echo $settings->input_field_text_color; ?>;
    <?php } ?>
	background-color: <?php echo $settings->input_field_bg_color ? pp_get_color_value( $settings->input_field_bg_color ) : 'transparent'; ?>;
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
    margin-bottom: <?php echo ( $settings->input_field_margin * 40 ) / 100 ?>px;
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid input.form-control,
.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid select.form-control {
    <?php if( $settings->input_field_height ) { ?>
    height: <?php echo $settings->input_field_height; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .cf-color-picker .input-group-addon {
    <?php if( $settings->input_field_height ) { ?>
    height: <?php echo $settings->input_field_height; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid textarea.form-control {
    <?php if( $settings->input_textarea_height ) { ?>
    height: <?php echo $settings->input_textarea_height; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-ff-content .frm_style_formidable-style.with_frm_style .form-field input,
.fl-node-<?php echo $id; ?> .pp-ff-content .frm_style_formidable-style.with_frm_style .form-field select {

}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-control::-webkit-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-control:-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-control::-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-control:-ms-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-control:focus {
    border-color: <?php echo $settings->input_field_focus_color ? '#' . $settings->input_field_focus_color : 'transparent'; ?>;
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid input[type=file] {
    background-color: <?php echo $settings->file_bg_color ? pp_get_color_value($settings->file_bg_color) : 'transparent'; ?>;
    <?php if( $settings->file_text_color ) { ?>color: #<?php echo $settings->file_text_color; ?>;<?php } ?>
    <?php if( $settings->file_vertical_padding ) { ?>
    padding-top: <?php echo $settings->file_vertical_padding; ?>px;
    <?php } ?>
    <?php if( $settings->file_vertical_padding ) { ?>
    padding-bottom: <?php echo $settings->file_vertical_padding; ?>px;
    <?php } ?>
    <?php if( $settings->file_horizontal_padding ) { ?>
    padding-left: <?php echo $settings->file_horizontal_padding; ?>px;
    <?php } ?>
    <?php if( $settings->file_horizontal_padding ) { ?>
    padding-right: <?php echo $settings->file_horizontal_padding; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid input[type=submit] {
    <?php if( isset( $settings->button_text_color_default ) && ! empty( $settings->button_text_color_default ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->button_text_color_default ); ?>;
    <?php } ?>
	<?php if( isset( $settings->button_bg_color_default ) && ! empty( $settings->button_bg_color_default ) ) { ?>
		background: <?php echo pp_get_color_value( $settings->button_bg_color_default ); ?>;
    <?php } ?>
    <?php if( $settings->button_alignment == 'center' || $settings->button_alignment == 'none' ) { ?>
		display: block;
		margin: 0 auto;
    <?php } else { ?>
   		float: <?php echo $settings->button_alignment; ?>;
    <?php } ?>
    <?php if( $settings->button_width == 'true' ) { ?>width: 100%; <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid input[type=submit]:hover {
	<?php if( isset( $settings->button_text_color_hover ) && ! empty( $settings->button_text_color_hover ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->button_text_color_hover ); ?>;
    <?php } ?>
	<?php if( isset( $settings->button_bg_color_hover ) && ! empty( $settings->button_bg_color_hover ) ) { ?>
		background: <?php echo pp_get_color_value( $settings->button_bg_color_hover ); ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-group .has-error .help-block,
.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .form-group .caldera_ajax_error_block {
    <?php if( $settings->validation_message ) { ?>
	display: <?php echo $settings->validation_message; ?>;
    <?php } ?>
    <?php if( $settings->validation_message_color ) { ?>
	color: #<?php echo $settings->validation_message_color; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-caldera-form-content .caldera-grid .alert-success {
    <?php if( $settings->success_message_color ) { ?>
	color: #<?php echo $settings->success_message_color; ?>;
    <?php } ?>
	border-color: <?php echo $settings->success_message_border_color ? '#' . $settings->success_message_border_color : 'transparent'; ?>;
    background-color: <?php echo $settings->success_message_bg_color ? pp_get_color_value( $settings->success_message_bg_color ) : 'transparent'; ?>
}
