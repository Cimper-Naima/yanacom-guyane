<?php
	// Size
	FLBuilderCSS::responsive_rule( array(
		'settings'     => $settings,
		'setting_name' => 'size',
		'selector'     => ".fl-node-$id .pp-search-form__container",
		'prop'         => 'min-height',
		'unit'			=> 'px'
	) );

	// Button Icon Size
	FLBuilderCSS::responsive_rule( array(
		'settings'     	=> $settings,
		'setting_name' 	=> 'icon_size',
		'selector'     	=> ".fl-node-$id .pp-search-form--button-type-icon .pp-search-form__submit",
		'prop'         	=> 'font-size',
		'unit'			=> 'px'
	) );

	// Searc Icon Size - minimal
	FLBuilderCSS::responsive_rule( array(
		'settings'     	=> $settings,
		'setting_name' 	=> 'input_icon_size',
		'selector'     	=> ".fl-node-$id .pp-search-form__icon i",
		'prop'         	=> 'font-size',
		'unit'			=> 'px'
	) );

	// Padding for input and buttons
	FLBuilderCSS::rule( array(
		'selector'     	=> ".fl-node-$id input[type='search'].pp-search-form__input, .fl-node-$id .pp-search-form--button-type-text .pp-search-form__submit",
		'props'         => array(
			'padding-left'	=> array(
				'value'		=> 'calc( ' . $settings->size . 'px / 3 )',
				'unit'		=> ''
			),
			'padding-right'	=> array(
				'value'		=> 'calc( ' . $settings->size . 'px / 3 )',
				'unit'		=> ''
			),
		),
	) );

	// Full screen - input height
	FLBuilderCSS::responsive_rule( array(
		'settings'     	=> $settings,
		'setting_name' 	=> 'input_height',
		'selector'     	=> ".fl-node-$id input[type='search'].pp-search-form__input",
		'prop'         	=> 'min-height',
		'unit'			=> 'px'
	) );

	// Border
	FLBuilderCSS::border_field_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'input_border',
		'selector'		=> ".fl-node-$id .pp-search-form__container:not(.pp-search-form--lightbox), .fl-node-$id .pp-search-form-wrap.pp-search-form--style-full_screen input[type='search'].pp-search-form__input"
	) );

	// Input Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'input_typography',
		'selector' 		=> ".fl-node-$id input[type='search'].pp-search-form__input, .fl-node-$id .pp-search-form-wrap.pp-search-form--style-full_screen .pp-search-form input[type='search'].pp-search-form__input",
	) );

	// Button Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'button_typography',
		'selector' 		=> ".fl-node-$id .pp-search-form--button-type-text .pp-search-form__submit",
	) );
?>
.fl-node-<?php echo $id; ?> .pp-search-form-wrap:not(.pp-search-form--style-full_screen) .pp-search-form__container:not(.pp-search-form--lightbox) {
	<?php if ( ! empty( $settings->input_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->input_bg_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-search-form-wrap:not(.pp-search-form--style-full_screen) .pp-search-form--focus .pp-search-form__container:not(.pp-search-form--lightbox) {
	<?php if ( ! empty( $settings->input_focus_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->input_focus_bg_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->input_focus_border_color ) ) { ?>
		border-color: <?php echo pp_get_color_value( $settings->input_focus_border_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-search-form-wrap.pp-search-form--style-full_screen .pp-search-form--focus input[type="search"].pp-search-form__input {
	<?php if ( ! empty( $settings->input_focus_border_color ) ) { ?>
		border-color: <?php echo pp_get_color_value( $settings->input_focus_border_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-search-form__icon {
	padding-left: calc( <?php echo $settings->size; ?>px / 3 );
}

.fl-node-<?php echo $id; ?> .pp-search-form__input,
.fl-node-<?php echo $id; ?> .pp-search-form-wrap.pp-search-form--style-full_screen input[type="search"].pp-search-form__input {
	<?php if ( ! empty( $settings->input_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->input_color ); ?>;
	<?php } ?>
}
<?php
// Input min and max height
FLBuilderCSS::rule( array(
	'selector'     => ".fl-node-$id .pp-search-form-wrap:not(.pp-search-form--style-full_screen) .pp-search-form__input",
	'props'        => array(
		'min-height'	=> array(
			'value'			=> $settings->size,
			'unit'			=> 'px'
		),
		'max-height'	=> array(
			'value'			=> $settings->size,
			'unit'			=> 'px'
		)
	),
) );
?>

.fl-node-<?php echo $id; ?> .pp-search-form--focus input[type="search"].pp-search-form__input,
.fl-node-<?php echo $id; ?> .pp-search-form-wrap.pp-search-form--style-full_screen .pp-search-form--focus input[type="search"].pp-search-form__input {
	<?php if ( ! empty( $settings->input_focus_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->input_focus_color ); ?>;
	<?php } ?>
}

<?php if ( isset( $settings->input_placeholder_color ) && ! empty( $settings->input_placeholder_color ) ) { ?>
.fl-node-<?php echo $id; ?> .pp-search-form__input::-webkit-input-placeholder {
	color: <?php echo pp_get_color_value( $settings->input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-search-form__input:-ms-input-placeholder {
	color: <?php echo pp_get_color_value( $settings->input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-search-form__input::-moz-placeholder {
	color: <?php echo pp_get_color_value( $settings->input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-search-form__input:-moz-placeholder {
	color: <?php echo pp_get_color_value( $settings->input_placeholder_color ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-search-form__input::placeholder {
	color: <?php echo pp_get_color_value( $settings->input_placeholder_color ); ?>;
}
<?php } ?>

<?php if ( ! empty( $settings->input_color ) ) { // lightbox close icon ?>
.fl-node-<?php echo $id; ?> .pp-search-form--lightbox-close {
	color: <?php echo pp_get_color_value( $settings->input_color ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-search-form--lightbox-close svg {
	stroke: <?php echo pp_get_color_value( $settings->input_color ); ?>;
}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-search-form__submit {
	<?php if ( ! empty( $settings->button_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->button_bg_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->button_color ) ) { ?>
		color: #<?php echo $settings->button_color; ?>;
	<?php } ?>
}
<?php 
// Button width - if empty then render size value.
FLBuilderCSS::responsive_rule( array(
	'settings'     	=> $settings,
	'setting_name' 	=> 'size',
	'enabled'		=> ( empty( $settings->button_width ) && ! empty( $settings->size ) ),
	'selector'     	=> ".fl-node-$id .pp-search-form__submit",
	'prop'         	=> 'min-width',
) );

// Button width - otherwise render calculated value
FLBuilderCSS::rule( array(
	'enabled'		=> ( ! empty( $settings->button_width ) && ! empty( $settings->size ) ),
	'selector'     	=> ".fl-node-$id .pp-search-form__submit",
	'props'         => array(
		'min-width'	=> array(
			'value'		=> 'calc( ' . $settings->button_width . ' * ' . $settings->size . 'px )',
			'unit'		=> ''
		)
	),
) );

// -- Button width - render calculated value for medium devices
FLBuilderCSS::rule( array(
	'media'			=> 'medium',
	'enabled'		=> ( isset( $settings->button_width_medium ) && ! empty( $settings->button_width_medium ) ),
	'selector'     	=> ".fl-node-$id .pp-search-form__submit",
	'props'         => array(
		'min-width'	=> array(
			'value'		=> 'calc( ' . $settings->button_width_medium . ' * ' . $settings->size . 'px )',
			'unit'		=> ''
		)
	),
) );

// -- Button width - render calculated value for responsive devices
FLBuilderCSS::rule( array(
	'media'			=> 'responsive',
	'enabled'		=> ( isset( $settings->button_width_responsive ) && ! empty( $settings->button_width_responsive ) ),
	'selector'     	=> ".fl-node-$id .pp-search-form__submit",
	'props'         => array(
		'min-width'	=> array(
			'value'		=> 'calc( ' . $settings->button_width_responsive . ' * ' . $settings->size . 'px )',
			'unit'		=> ''
		)
	),
) );
?>

.fl-node-<?php echo $id; ?> .pp-search-form__submit:hover {
	<?php if ( ! empty( $settings->button_bg_hover_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->button_bg_hover_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->button_hover_color ) ) { ?>
		color: #<?php echo $settings->button_hover_color; ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-search-form--style-full_screen .pp-search-form {
	text-align: <?php echo $settings->toggle_align; ?>;	
}

.fl-node-<?php echo $id; ?> .pp-search-form__toggle i {
	<?php if ( $settings->toggle_icon_size >= 0 ) { ?>
		--toggle-icon-size: calc( <?php echo $settings->toggle_icon_size; ?>em / 100 );
	<?php } ?>
	<?php if ( isset( $settings->toggle_size ) && $settings->toggle_size >= 0 ) { ?>
		font-size:  <?php echo $settings->toggle_size; ?>px;
		width:  <?php echo $settings->toggle_size; ?>px;
		height:  <?php echo $settings->toggle_size; ?>px;
	<?php } ?>
	<?php if ( ! empty( $settings->toggle_icon_color ) ) { ?>
		color: #<?php echo $settings->toggle_icon_color; ?>;
		<?php if ( $settings->toggle_icon_border_width >= 0 ) { ?>
			border-color: #<?php echo $settings->toggle_icon_color; ?>;
		<?php } ?>
	<?php } ?>
	<?php if ( ! empty( $settings->toggle_icon_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->toggle_icon_bg_color ); ?>;
	<?php } ?>
	<?php if ( $settings->toggle_icon_border_width >= 0 ) { ?>
		border-width: <?php echo $settings->toggle_icon_border_width; ?>px;
	<?php } ?>
	<?php if ( $settings->toggle_icon_radius >= 0 ) { ?>
		border-radius: <?php echo $settings->toggle_icon_radius; ?>px;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-search-form__toggle:hover i {
	<?php if ( ! empty( $settings->toggle_icon_hover_color ) ) { ?>
		color: #<?php echo $settings->toggle_icon_hover_color; ?>;
		<?php if ( $settings->toggle_icon_border_width >= 0 ) { ?>
			border-color: #<?php echo $settings->toggle_icon_hover_color; ?>;
		<?php } ?>
	<?php } ?>
	<?php if ( ! empty( $settings->toggle_icon_bg_hover_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->toggle_icon_bg_hover_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-search-form__toggle i:before {
	<?php if ( $settings->toggle_icon_size >= 0 ) { ?>
	font-size: var(--toggle-icon-size);
	<?php } ?>
}