<?php
// Form Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'form_border_group',
	'selector' 		=> ".fl-node-$id .pp-contact-form",
) );
// Form Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'form_padding',
	'selector' 		=> ".fl-node-$id .pp-contact-form",
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
	'selector' 		=> ".fl-node-$id .pp-contact-form textarea,
						.fl-node-$id .pp-contact-form input[type=text],
						.fl-node-$id .pp-contact-form input[type=tel],
						.fl-node-$id .pp-contact-form input[type=email]",
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
	'selector' 		=> ".fl-node-$id .pp-contact-form a.fl-button,
						.fl-node-$id .pp-contact-form a.fl-button:visited",
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
	'selector' 		=> ".fl-node-$id .pp-contact-form .pp-form-title",
) );
// Form description Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'description_typography',
	'selector' 		=> ".fl-node-$id .pp-contact-form .pp-form-description",
) );
// Form Input Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'input_typography',
	'selector' 		=> ".fl-node-$id .pp-contact-form textarea,
						.fl-node-$id .pp-contact-form input[type=text],
						.fl-node-$id .pp-contact-form input[type=tel],
						.fl-node-$id .pp-contact-form input[type=email]",
) );
// Form Checkbox Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'checkbox_typography',
	'selector' 		=> ".fl-node-$id .pp-contact-form .pp-checkbox label",
) );
// Form Button Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'button_typography',
	'selector' 		=> ".fl-node-$id .pp-contact-form a.fl-button,
						.fl-node-$id .pp-contact-form a.fl-button:visited",
) );
// Label Font
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'label_font_size',
	'selector'		=> ".fl-node-$id .pp-contact-form label",
	'prop'			=> 'font-size',
	'unit'			=> 'px',
) );
// Validation Error Font
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'validation_error_font_size',
	'selector'		=> ".fl-node-$id .pp-contact-form .pp-contact-error",
	'prop'			=> 'font-size',
	'unit'			=> 'px',
) );
// Success Message Error Font
FLBuilderCSS::responsive_rule( array(
	'settings'		=> $settings,
	'setting_name'	=> 'success_message_font_size',
	'selector'		=> ".fl-builder-content .fl-node-$id .pp-success-msg",
	'prop'			=> 'font-size',
	'unit'			=> 'px',
) );

// Background Color
if ( ! empty( $settings->btn_bg_color ) && empty( $settings->btn_bg_hover_color ) ) {
	$settings->btn_bg_hover_color = $settings->btn_bg_color;
}

// Background Gradient
if ( ! empty( $settings->btn_bg_color ) ) {
	$bg_grad_start = FLBuilderColor::adjust_brightness( $settings->btn_bg_color, 30, 'lighten' );
}
if ( ! empty( $settings->btn_bg_hover_color ) ) {
	$bg_hover_grad_start = FLBuilderColor::adjust_brightness( $settings->btn_bg_hover_color, 30, 'lighten' );
}

// Border Color
$border_color = '';
if ( ! empty( $settings->btn_bg_color ) ) {
	$border_color = FLBuilderColor::adjust_brightness( $settings->btn_bg_color, 12, 'darken' );
}
$border_hover_color = '';
if ( ! empty( $settings->btn_bg_hover_color ) ) {
	$border_hover_color = FLBuilderColor::adjust_brightness( $settings->btn_bg_hover_color, 12, 'darken' );
}

// Border Size
if ( 'transparent' == $settings->btn_style ) {
	$border_size = $settings->btn_border_size;
}else {
	$border_size 		= ( isset( $settings->btn_border_width ) && ! empty( $settings->btn_border_width ) ) ? $settings->btn_border_width : 1;
	$border_color 		= ( isset( $settings->btn_border_color ) && ! empty( $settings->btn_border_color ) ) ? $settings->btn_border_color : $border_color;
	$border_hover_color = ( isset( $settings->btn_border_hover_color ) && ! empty( $settings->btn_border_hover_color ) ) ? $settings->btn_border_hover_color : $border_hover_color;
}

$border_style = ( isset( $settings->btn_border_style ) ) ? $settings->btn_border_style : 'solid';

?>

<?php if ('right' == $settings->btn_align): ?>
.fl-builder-content .fl-node-<?php echo $id; ?> .pp-contact-form .pp-send-error,
.fl-builder-content .fl-node-<?php echo $id; ?> .pp-contact-form .pp-success,
.fl-builder-content .fl-node-<?php echo $id; ?> .pp-contact-form .pp-success-none,
.fl-builder-content .fl-node-<?php echo $id; ?> .pp-contact-form .pp-success-msg {
	float: right;
}
<?php endif; ?>

<?php if ('center' == $settings->btn_align): ?>
.fl-builder-content .fl-node-<?php echo $id; ?> .pp-contact-form .pp-send-error,
.fl-builder-content .fl-node-<?php echo $id; ?> .pp-contact-form .pp-success,
.fl-builder-content .fl-node-<?php echo $id; ?> .pp-contact-form .pp-success-none,
.fl-builder-content .fl-node-<?php echo $id; ?> .pp-contact-form .pp-success-msg {
	display: block;
	text-align: center;
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .pp-contact-form .fl-button-wrap,
.fl-node-<?php echo $id; ?> .pp-contact-form .pp-button-wrap {
	margin-top: <?php echo $settings->button_margin; ?>px;
	<?php if ('left' == $settings->btn_align): ?>
		text-align: left;
	<?php endif; ?>
	<?php if ('center' == $settings->btn_align): ?>
		text-align: center;
	<?php endif; ?>
	<?php if ('right' == $settings->btn_align): ?>
		text-align: right;
	<?php endif; ?>
	<?php if ( 'full' == $settings->btn_width ) : ?>
		text-align: center;
	<?php endif; ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form a.fl-button,
.fl-node-<?php echo $id; ?> .pp-contact-form a.fl-button:visited {

	-webkit-border-radius: <?php echo $settings->btn_border_radius; ?>px;
	-moz-border-radius: <?php echo $settings->btn_border_radius; ?>px;
	border-radius: <?php echo $settings->btn_border_radius; ?>px;

	border: <?php echo $border_size; ?>px <?php echo $border_style; ?> #<?php echo $border_color; ?>;

	<?php if ( ! empty( $settings->btn_bg_color ) ) : ?>
		background: #<?php echo $settings->btn_bg_color; ?>;

		<?php if ( 'transparent' == $settings->btn_style ) : // Transparent ?>
		background-color: <?php echo pp_hex2rgba( '#' . $settings->btn_bg_color, $settings->btn_bg_opacity ); ?>;
		<?php endif; ?>

		<?php if( 'gradient' == $settings->btn_style ) : // Gradient ?>
		background: -moz-linear-gradient(top,  #<?php echo $bg_grad_start; ?> 0%, #<?php echo $settings->btn_bg_color; ?> 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#<?php echo $bg_grad_start; ?>), color-stop(100%,#<?php echo $settings->btn_bg_color; ?>)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #<?php echo $bg_grad_start; ?> 0%,#<?php echo $settings->btn_bg_color; ?> 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #<?php echo $bg_grad_start; ?> 0%,#<?php echo $settings->btn_bg_color; ?> 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #<?php echo $bg_grad_start; ?> 0%,#<?php echo $settings->btn_bg_color; ?> 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #<?php echo $bg_grad_start; ?> 0%,#<?php echo $settings->btn_bg_color; ?> 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $bg_grad_start; ?>', endColorstr='#<?php echo $settings->btn_bg_color; ?>',GradientType=0 ); /* IE6-9 */
		<?php endif; ?>

	<?php endif; ?>

	<?php if ( 'full' == $settings->btn_width ) : ?>
		width: 100%;
	<?php endif; ?>
}

<?php if ( ! empty( $settings->btn_text_color ) ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:visited,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button *,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:visited * {
	color: #<?php echo $settings->btn_text_color; ?>;
}
<?php endif; ?>

.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover {
	-webkit-border-radius: <?php echo $settings->btn_border_radius; ?>px;
	-moz-border-radius: <?php echo $settings->btn_border_radius; ?>px;
	border-radius: <?php echo $settings->btn_border_radius; ?>px;
}

<?php if ( 'transparent' != $settings->btn_style ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:focus {
	<?php $border_hover_color = empty( $border_hover_color ) ? $border_color : $border_hover_color; ?>
	border: <?php echo $border_size; ?>px <?php echo $border_style; ?> #<?php echo $border_hover_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->btn_bg_hover_color ) ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:focus {

	background: #<?php echo $settings->btn_bg_hover_color; ?>;

	<?php if ( 'transparent' == $settings->btn_style ) : // Transparent ?>
	background-color: <?php echo pp_hex2rgba( '#' . $settings->btn_bg_hover_color, $settings->btn_bg_hover_opacity ); ?>;
	border: <?php echo $border_size; ?>px <?php echo $border_style; ?> #<?php echo $settings->btn_bg_hover_color; ?>;
	<?php endif; ?>

	<?php if ( 'gradient' == $settings->btn_style ) : // Gradient ?>
	background: -moz-linear-gradient(top,  #<?php echo $bg_hover_grad_start; ?> 0%, #<?php echo $settings->btn_bg_hover_color; ?> 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#<?php echo $bg_hover_grad_start; ?>), color-stop(100%,#<?php echo $settings->btn_bg_hover_color; ?>)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #<?php echo $bg_hover_grad_start; ?> 0%,#<?php echo $settings->btn_bg_hover_color; ?> 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #<?php echo $bg_hover_grad_start; ?> 0%,#<?php echo $settings->btn_bg_hover_color; ?> 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #<?php echo $bg_hover_grad_start; ?> 0%,#<?php echo $settings->btn_bg_hover_color; ?> 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #<?php echo $bg_hover_grad_start; ?> 0%,#<?php echo $settings->btn_bg_hover_color; ?> 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $bg_hover_grad_start; ?>', endColorstr='#<?php echo $settings->btn_bg_hover_color; ?>',GradientType=0 ); /* IE6-9 */
	<?php endif; ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->btn_text_hover_color ) ) : ?>
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:focus,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:hover *,
.fl-builder-content .fl-node-<?php echo $id; ?> a.fl-button:focus * {
	color: #<?php echo $settings->btn_text_hover_color; ?>;
}
<?php endif; ?>


<?php if ('enable' == $settings->btn_button_transition): ?>
	.fl-builder-content .fl-node-<?php echo $id; ?> .fl-button,
	.fl-builder-content .fl-node-<?php echo $id; ?> .fl-button * {
		-webkit-transition: all 0.2s ease-in-out;
	  	-moz-transition: all 0.2s ease-in-out;
	  	-o-transition: all 0.2s ease-in-out;
		transition: all 0.2s ease-in-out;
	}
<?php endif; ?>

<?php if ( empty( $settings->btn_text ) ) : ?>
	<?php if ('after' == $settings->btn_icon_position): ?>
	.fl-builder-content .fl-node-<?php echo $id; ?> .fl-button i.fl-button-icon-after {
		margin-left: 0;
	}
	<?php endif; ?>
	<?php if ('before' == $settings->btn_icon_position): ?>
	.fl-builder-content .fl-node-<?php echo $id; ?> .fl-button i.fl-button-icon-before {
		margin-right: 0;
	}
	<?php endif; ?>
<?php endif; ?>


.fl-node-<?php echo $id; ?> .pp-contact-form {
	background-color: <?php echo $settings->form_bg_color && $settings->form_bg_type == 'color' ? pp_get_color_value( $settings->form_bg_color ) : 'transparent'; ?>;
    <?php if( $settings->form_bg_image && $settings->form_bg_type == 'image' ) { ?>
	background-image: url('<?php echo $settings->form_bg_image_src; ?>');
    <?php } ?>
    <?php if( $settings->form_bg_size ) { ?>
    background-size: <?php echo $settings->form_bg_size; ?>;
    <?php } ?>
    <?php if( $settings->form_bg_repeat ) { ?>
    background-repeat: <?php echo $settings->form_bg_repeat; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form .pp-form-title,
.fl-node-<?php echo $id; ?> .pp-contact-form .pp-form-description {
	<?php if( $settings->form_custom_title_desc == 'no' ) { ?>
		display: none;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form .pp-form-title {
	<?php if( $settings->title_color ) { ?>
   color: #<?php echo $settings->title_color; ?>;
   <?php } ?>
   <?php if( $settings->title_margin['top'] >= 0 ) { ?>
   margin-top: <?php echo $settings->title_margin['top']; ?>px;
   <?php } ?>
   <?php if( $settings->title_margin['bottom'] >= 0 ) { ?>
   margin-bottom: <?php echo $settings->title_margin['bottom']; ?>px;
   <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form .pp-form-description {
    <?php if( $settings->description_color ) { ?>
    color: #<?php echo $settings->description_color; ?>;
    <?php } ?>
    <?php if( $settings->description_margin['top'] >= 0 ) { ?>
	margin-top: <?php echo $settings->description_margin['top']; ?>px;
	<?php } ?>
	<?php if( $settings->description_margin['bottom'] >= 0 ) { ?>
	margin-bottom: <?php echo $settings->description_margin['bottom']; ?>px;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form .pp-input-group {
    <?php if( $settings->input_field_margin >= 0 ) { ?>
	margin-bottom: <?php echo $settings->input_field_margin; ?>px;
    <?php } ?>
}

<?php if( $settings->name_toggle == 'show' || $settings->email_toggle == 'show' || $settings->phone_toggle == 'show' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-contact-form.pp-form-inline .pp-input-group {
		width: 100%;
		padding-left: 0;
	}
<?php } ?>
<?php if( ($settings->name_toggle == 'show' && $settings->email_toggle == 'show') ||
			($settings->name_toggle == 'show' && $settings->phone_toggle == 'show') ||
			($settings->email_toggle == 'show' && $settings->phone_toggle == 'show') ) { ?>
	.fl-node-<?php echo $id; ?> .pp-contact-form.pp-form-inline .pp-input-group {
		width: 50%;
		padding-left: 10px;
	}

	.fl-node-<?php echo $id; ?> .pp-contact-form.pp-form-inline .pp-input-group:first-child {
		padding-left: 0;
	}
<?php } ?>

<?php if( $settings->name_toggle == 'show' && $settings->email_toggle == 'show' && $settings->phone_toggle == 'show' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-contact-form.pp-form-inline .pp-input-group {
		width: 33.33%;
		padding-left: 10px;
	}
	.fl-node-<?php echo $id; ?> .pp-contact-form.pp-form-inline .pp-input-group.pp-checkbox {
		width: 100%;
		padding-left: 0;
	}

	.fl-node-<?php echo $id; ?> .pp-contact-form.pp-form-inline .pp-input-group:first-child {
		padding-left: 0;
	}
<?php } ?>



.fl-node-<?php echo $id; ?> .pp-contact-form.pp-form-inline .pp-input-group.pp-message,
.fl-node-<?php echo $id; ?> .pp-contact-form.pp-form-inline .pp-input-group.pp-subject {
	width: 100%;
	padding-left: 0;
}

.fl-node-<?php echo $id; ?> .pp-contact-form label {
	<?php if( $settings->form_label_color ) { ?>
	color: #<?php echo $settings->form_label_color; ?>;
    <?php } ?>
    <?php if( $settings->display_labels ) { ?>
    display: <?php echo $settings->display_labels; ?>;
    <?php } ?>
    <?php if( $settings->label_font_family['family'] != 'Default' ) { ?>
    <?php FLBuilderFonts::font_css( $settings->label_font_family ); ?>
    <?php } ?>
	<?php if ( ! empty( $settings->label_text_transform ) ) { ?>
    text-transform: <?php echo $settings->label_text_transform; ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form .pp-checkbox label {
	<?php if ( isset( $settings->checkbox_color ) && ! empty( $settings->checkbox_color ) ) { ?>
		color: #<?php echo $settings->checkbox_color; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form textarea,
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=text],
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=tel],
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=email] {
	<?php if( $settings->input_field_text_color ) { ?>
    color: #<?php echo $settings->input_field_text_color; ?>;
    <?php } ?>
	background-color: <?php echo $settings->input_field_bg_color ? pp_get_color_value( $settings->input_field_bg_color ) : 'transparent'; ?>;
	border-width: 0;
	border-color: <?php echo $settings->input_field_border_color ? '#' . $settings->input_field_border_color : 'transparent'; ?>;
    <?php if( $settings->input_field_border_width >= 0 ) { ?>
		border-style: solid;
    	<?php echo $settings->input_field_border_position; ?>-width: <?php echo $settings->input_field_border_width; ?>px;
    <?php } ?>
	<?php if( $settings->input_field_border_radius >= 0 ) { ?>
	border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -moz-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -webkit-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -ms-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    -o-border-radius: <?php echo $settings->input_field_border_radius; ?>px;
    <?php } ?>
    <?php if( $settings->input_field_box_shadow == 'yes' ) { ?>
        box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px #<?php echo $settings->input_shadow_color; ?>;
        -moz-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px #<?php echo $settings->input_shadow_color; ?>;
        -webkit-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px #<?php echo $settings->input_shadow_color; ?>;
        -ms-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px #<?php echo $settings->input_shadow_color; ?>;
        -o-box-shadow: <?php echo ($settings->input_shadow_direction == 'inset') ? $settings->input_shadow_direction : ''; ?> 0 0 10px #<?php echo $settings->input_shadow_color; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form input[type=text],
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=tel],
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=email] {
	<?php if( $settings->input_field_height ) { ?>
    height: <?php echo $settings->input_field_height; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form textarea {
	<?php if( $settings->input_textarea_height ) { ?>
    height: <?php echo $settings->input_textarea_height; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form textarea:focus,
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=text]:focus,
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=tel]:focus,
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=email]:focus {
	border-color: <?php echo $settings->input_field_focus_color ? '#' . $settings->input_field_focus_color : 'transparent'; ?>;
	outline: none;
}

.fl-node-<?php echo $id; ?> .pp-contact-form input[type=text]::-webkit-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form input[type=text]:-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=text]::-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=text]:-ms-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=tel]::-webkit-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=tel]:-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=tel]::-moz-placeholder {
    <?php if( $settings->input_placeholder_color ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
	color: transparent;
	opacity: 0;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=tel]:-ms-input-placeholder {
    <?php if( $settings->input_placeholder_color ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
	<?php } else { ?>
	color: transparent;
	opacity: 0;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=email]::-webkit-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=email]:-moz-placeholder {
    <?php if( $settings->input_placeholder_color ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=email]::-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form input[type=email]:-ms-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form textarea::-webkit-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
    <?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form textarea:-moz-placeholder {
    <?php if( $settings->input_placeholder_color ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form textarea::-moz-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-contact-form textarea:-ms-input-placeholder {
    <?php if( $settings->input_placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    color: #<?php echo $settings->input_placeholder_color; ?>;
	<?php } else { ?>
    color: transparent;
	opacity: 0;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form .pp-contact-error {
    <?php if( $settings->validation_message_color ) { ?>
		color: #<?php echo $settings->validation_message_color; ?>;
    <?php } ?>
	<?php if( $settings->label_font_family['family'] != 'Default' ) { ?>
		<?php FLBuilderFonts::font_css( $settings->label_font_family ); ?>
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-contact-form .pp-error textarea,
.fl-node-<?php echo $id; ?> .pp-contact-form .pp-error input[type=text],
.fl-node-<?php echo $id; ?> .pp-contact-form .pp-error input[type=tel],
.fl-node-<?php echo $id; ?> .pp-contact-form .pp-error input[type=email] {
	<?php if( $settings->validation_field_border_color ) { ?>
		border-color: #<?php echo $settings->validation_field_border_color; ?>;
    <?php } ?>
}

.fl-builder-content .fl-node-<?php echo $id; ?> .pp-success-msg {
	<?php if( $settings->success_message_color ) { ?>
		color: #<?php echo $settings->success_message_color; ?>;
    <?php } ?>
}


@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-builder-content .fl-node-<?php echo $id; ?> .pp-contact-form a.fl-button,
	.fl-builder-content .fl-node-<?php echo $id; ?> .pp-contact-form a.fl-button:visited {
		display: block;
		text-align: center;
	}
	.fl-node-<?php echo $id; ?> .pp-contact-form.pp-form-inline .pp-input-group {
		width: 100% !important;
		padding-left: 0;
	}
}

