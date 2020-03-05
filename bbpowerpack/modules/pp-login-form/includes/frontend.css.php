.fl-node-<?php echo $id; ?> .pp-login-form {
	<?php if ( ! empty( $settings->form_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->form_bg_color ); ?>;
	<?php } ?>
}
<?php
// Form padding.
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'form_padding',
	'selector'		=> ".fl-node-$id .pp-login-form",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'form_padding_top',
		'padding-right' 	=> 'form_padding_right',
		'padding-bottom' 	=> 'form_padding_bottom',
		'padding-left' 		=> 'form_padding_left',
	),	
) );

// Form border.
FLBuilderCSS::border_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'form_border',
	'selector'		=> ".fl-node-$id .pp-login-form"
) );
?>

.fl-node-<?php echo $id; ?> .pp-field-group {
	<?php if ( ! empty( $settings->fields_spacing ) ) { ?>
	margin-bottom: <?php echo $settings->fields_spacing; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-field-group:last-of-type {
	margin-bottom: 0;
}

.fl-node-<?php echo $id; ?> .pp-field-group > a {
	<?php if ( ! empty( $settings->links_color ) ) { ?>
	color: #<?php echo $settings->links_color; ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-field-group > a:hover,
.fl-node-<?php echo $id; ?> .pp-field-group > a:focus {
	<?php if ( ! empty( $settings->links_hover_color ) ) { ?>
	color: #<?php echo $settings->links_hover_color; ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-field-group > label {
	<?php if ( ! empty( $settings->label_spacing ) ) { ?>
	margin-bottom: <?php echo $settings->label_spacing; ?>px;
	<?php } ?>
	<?php if ( ! empty( $settings->label_color ) ) { ?>
	color: #<?php echo $settings->label_color; ?>;
	<?php } ?>
}
<?php
// Label Typography.
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'label_typography',
	'selector'		=> ".fl-node-$id .pp-field-group > label",
) );
?>

.fl-node-<?php echo $id; ?> .pp-field-group .pp-login-form--input {
	<?php if ( ! empty( $settings->field_text_color ) ) { ?>
	color: #<?php echo $settings->field_text_color; ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->field_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->field_bg_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-field-group .pp-login-form--input:focus,
.fl-node-<?php echo $id; ?> .pp-field-group input[type="checkbox"]:focus {
	<?php if ( ! empty( $settings->field_border_focus_color ) ) { ?>
	border-color: #<?php echo $settings->field_border_focus_color; ?>;
	<?php } ?>
}
<?php
// Input border.
FLBuilderCSS::border_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'field_border',
	'selector'		=> ".fl-node-$id .pp-field-group .pp-login-form--input"
) );

// Input height.
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'field_height',
	'selector'		=> ".fl-node-$id .pp-field-group .pp-login-form--input",
	'prop'			=> 'height',
	'unit'			=> 'px'
) );

// Input padding.
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'field_padding',
	'selector'		=> ".fl-node-$id .pp-field-group .pp-login-form--input",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'field_padding_top',
		'padding-right' 	=> 'field_padding_right',
		'padding-bottom' 	=> 'field_padding_bottom',
		'padding-left' 		=> 'field_padding_left',
	),
) );

// Input Typography.
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'fields_typography',
	'selector'		=> ".fl-node-$id .pp-field-group .pp-login-form--input",
) );
?>

.fl-node-<?php echo $id; ?> .pp-field-group .pp-login-form--button {
	<?php if ( ! empty( $settings->button_text_color ) ) { ?>
	color: #<?php echo $settings->button_text_color; ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->button_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->button_bg_color ); ?>;
	<?php } ?>
}
<?php
// Button align.
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'button_align',
	'selector'		=> ".fl-node-$id .pp-field-group.pp-field-type-submit, .fl-node-$id .pp-field-group.pp-field-type-link",
	'prop'			=> 'text-align'
) );

// Button border.
FLBuilderCSS::border_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'button_border',
	'selector'		=> ".fl-node-$id .pp-field-group .pp-login-form--button"
) );

// Button padding.
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'button_padding',
	'selector'		=> ".fl-node-$id .pp-field-group .pp-login-form--button",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'button_padding_top',
		'padding-right' 	=> 'button_padding_right',
		'padding-bottom' 	=> 'button_padding_bottom',
		'padding-left' 		=> 'button_padding_left',
	),
) );

// Button width.
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'button_width',
	'selector'		=> ".fl-node-$id .pp-field-group .pp-login-form--button",
	'prop'			=> 'width',
	'unit'			=> $settings->button_width_unit
) );

// Button Typography.
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'button_typography',
	'selector'		=> ".fl-node-$id .pp-field-group .pp-login-form--button .pp-login-form--button-text",
) );
?>

.fl-node-<?php echo $id; ?> .pp-field-group .pp-login-form--button:hover,
.fl-node-<?php echo $id; ?> .pp-field-group .pp-login-form--button:focus {
	<?php if ( ! empty( $settings->button_text_hover_color ) ) { ?>
	color: #<?php echo $settings->button_text_hover_color; ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->button_bg_hover_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->button_bg_hover_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->button_border_hover_color ) ) { ?>
	border-color: #<?php echo $settings->button_border_hover_color; ?>;
	<?php } ?>
}