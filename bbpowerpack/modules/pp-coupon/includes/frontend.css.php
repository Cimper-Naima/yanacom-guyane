<?php
// Box Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'box_border',
		'selector'     => ".fl-node-$id .pp-coupon",
	)
);
// Box Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'box_padding',
		'selector'     => ".fl-node-$id .pp-coupon",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'box_padding_top',
			'padding-right'  => 'box_padding_right',
			'padding-bottom' => 'box_padding_bottom',
			'padding-left'   => 'box_padding_left',
		),
	)
);
?>

.fl-node-<?php echo $id; ?> .pp-coupon-wrap {
	<?php if ( ! empty( $settings->content_bg ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->content_bg ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-coupon-discount {
	<?php echo $settings->discount_position; ?>: 0;
	<?php if ( ! empty( $settings->discount_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->discount_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->discount_bg ) ) { ?>
		background: <?php echo pp_get_color_value( $settings->discount_bg ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-discount:hover {
	<?php if ( ! empty( $settings->discount_color_hover ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->discount_color_hover ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->discount_bg_hover ) ) { ?>
		background: <?php echo pp_get_color_value( $settings->discount_bg_hover ); ?>;
	<?php } ?>
}

<?php
// Discount Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'discount_border',
		'selector'     => ".fl-node-$id .pp-coupon-discount",
	)
);
// Discount Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'discount_border_hover',
		'selector'     => ".fl-node-$id .pp-coupon-discount:hover",
	)
);
// Discount Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'discount_padding',
		'selector'     => ".fl-node-$id .pp-coupon-discount",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'discount_padding_top',
			'padding-right'  => 'discount_padding_right',
			'padding-bottom' => 'discount_padding_bottom',
			'padding-left'   => 'discount_padding_left',
		),
	)
);
// Discount Margin
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'discount_margin',
		'selector'     => ".fl-node-$id .pp-coupon-discount",
		'unit'         => 'px',
		'props'        => array(
			'margin-top'    => 'discount_margin_top',
			'margin-right'  => 'discount_margin_right',
			'margin-bottom' => 'discount_margin_bottom',
			'margin-left'   => 'discount_margin_left',
		),
	)
);
// Discount Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'discount_typography',
		'selector'     => ".fl-node-$id .pp-coupon-discount",
	)
);
?>

.fl-node-<?php echo $id; ?> .pp-coupon-code {
	<?php echo $settings->coupon_code_position; ?>: 0;
	<?php if ( ! empty( $settings->coupon_code_bg ) ) { ?>
	background: <?php echo pp_get_color_value( $settings->coupon_code_bg ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-code .pp-coupon-code-text {
	<?php if ( ! empty( $settings->coupon_code_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->coupon_code_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-code .pp-coupon-code-no-code {
	<?php if ( ! empty( $settings->coupon_code_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->coupon_code_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-code .pp-coupon-copy-text {
	<?php if ( ! empty( $settings->copy_text_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->copy_text_color ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-coupon-code:hover {
	<?php if ( ! empty( $settings->coupon_code_bg_hover ) ) { ?>
	background: <?php echo pp_get_color_value( $settings->coupon_code_bg_hover ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-code:hover .pp-coupon-code-text {
	<?php if ( ! empty( $settings->coupon_code_color_hover ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->coupon_code_color_hover ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-code:hover .pp-coupon-code-no-code {
	<?php if ( ! empty( $settings->coupon_code_color_hover ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->coupon_code_color_hover ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-code:hover .pp-coupon-copy-text {
	<?php if ( ! empty( $settings->copy_text_color_hover ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->copy_text_color_hover ); ?>;
	<?php } ?>
}
<?php
if ( 'reveal' === $settings->coupon_style ) {
	$coupon_class = ".fl-node-$id .pp-coupon-reveal-wrap, .fl-node-$id .pp-coupon-code-text-wrap";
} else {
	$coupon_class = ".fl-node-$id .pp-coupon-code";
}
// Couon Code Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'coupon_code_border',
		'selector'     => ".fl-node-$id .pp-coupon-code",
	)
);
// Couon Code Hover Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'coupon_code_border_hover',
		'selector'     => ".fl-node-$id .pp-coupon-code:hover",
	)
);
// coupon_code Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'coupon_code_padding',
		'selector'     => $coupon_class,
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'coupon_code_padding_top',
			'padding-right'  => 'coupon_code_padding_right',
			'padding-bottom' => 'coupon_code_padding_bottom',
			'padding-left'   => 'coupon_code_padding_left',
		),
	)
);
// coupon_code Margin
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'coupon_code_margin',
		'selector'     => ".fl-node-$id .pp-coupon-code",
		'unit'         => 'px',
		'props'        => array(
			'margin-top'    => 'coupon_code_margin_top',
			'margin-right'  => 'coupon_code_margin_right',
			'margin-bottom' => 'coupon_code_margin_bottom',
			'margin-left'   => 'coupon_code_margin_left',
		),
	)
);
// Coupon Code Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'coupon_typography',
		'selector'     => ".fl-node-$id .pp-coupon-code",
	)
);
// Reveal Text Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'reveal_typography',
		'selector'     => ".fl-node-$id .pp-coupon-reveal",
	)
);
// Copy Text Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'copy_typography',
		'selector'     => ".fl-node-$id .pp-coupon-copy-text",
	)
);
?>
.fl-node-<?php echo $id; ?> .pp-coupon-reveal-wrap {
	<?php if ( ! empty( $settings->coupon_reveal_bg ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->coupon_reveal_bg ); ?>;
	box-shadow: 0px 0px 0px 20px <?php echo pp_get_color_value( $settings->coupon_reveal_bg ); ?>;
	<?php } ?>
	transition: all 0.3s ease-in-out;
}

.fl-node-<?php echo $id; ?> .pp-coupon-reveal-wrap {
	<?php if ( ! empty( $settings->coupon_reveal_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->coupon_reveal_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-code:hover .pp-coupon-reveal-wrap {
	<?php if ( ! empty( $settings->coupon_reveal_color_hover ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->coupon_reveal_color_hover ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-code:hover .pp-coupon-reveal-wrap {
	<?php if ( ! empty( $settings->coupon_reveal_bg_hover ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->coupon_reveal_bg_hover ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-code.pp-coupon-style-reveal:hover .pp-coupon-reveal-wrap {
	<?php if ( ! empty( $settings->coupon_reveal_bg_hover ) ) { ?>
		box-shadow: 0px 0px 0px 3px <?php echo pp_get_color_value( $settings->coupon_reveal_bg_hover ); ?>;
	<?php } elseif ( ! empty( $settings->coupon_reveal_bg ) ) { ?>
		box-shadow: 0px 0px 0px 3px <?php echo pp_get_color_value( $settings->coupon_reveal_bg ); ?>;
	<?php } ?>
}
<?php if ( 'yes' === $settings->show_icon ) { ?>
	.fl-node-<?php echo $id; ?> .pp-coupon-code-icon {
		font-size: <?php echo $settings->icon_size; ?>px;
		<?php if ( ! empty( $settings->icon_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->icon_color ); ?>;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-code:hover .pp-coupon-code-icon {
		<?php if ( ! empty( $settings->icon_color_hover ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->icon_color_hover ); ?>;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-code-icon.dashicons {
		height: auto;
		width: auto;
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-code-icon.dashicons:before {
		font-size: <?php echo $settings->icon_size; ?>px;
		width: <?php echo $settings->icon_size; ?>px;
		height: <?php echo $settings->icon_size; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-icon-right .pp-coupon-code-icon {
		padding-left: <?php echo $settings->icon_spacing; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-icon-left .pp-coupon-code-icon {
		padding-right: <?php echo $settings->icon_spacing; ?>px;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-coupon-code.pp-copied.pp-coupon-style-reveal .pp-coupon-code-text {
	<?php if ( ! empty( $settings->coupon_sep_color ) ) { ?>
	border-right: 2px dotted <?php echo pp_get_color_value( $settings->coupon_sep_color ); ?>;
	<?php } ?>
	padding-right: <?php echo $settings->separator_padding; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-coupon-code.pp-coupon-style-copy .pp-coupon-code-text {
	<?php if ( ! empty( $settings->coupon_sep_color ) ) { ?>
	border-right: 2px dotted <?php echo pp_get_color_value( $settings->coupon_sep_color ); ?>;
	<?php } ?>
	padding-right: <?php echo $settings->separator_padding; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-coupon-copy-text {
	padding-left: <?php echo $settings->separator_padding; ?>px;
}

.fl-node-<?php echo $id; ?> .pp-coupon-code.pp-copied.pp-coupon-style-reveal:hover .pp-coupon-code-text {
	<?php if ( ! empty( $settings->coupon_sep_color_hover ) ) { ?>
	border-right: 2px dotted <?php echo pp_get_color_value( $settings->coupon_sep_color_hover ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-code.pp-coupon-style-copy:hover .pp-coupon-code-text {
	<?php if ( ! empty( $settings->coupon_sep_color_hover ) ) { ?>
	border-right: 2px dotted <?php echo pp_get_color_value( $settings->coupon_sep_color_hover ); ?>;
	<?php } ?>
}
<?php
// coupon_code Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'content_padding',
		'selector'     => ".fl-node-$id .pp-coupon-content-wrapper",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'content_padding_top',
			'padding-right'  => 'content_padding_right',
			'padding-bottom' => 'content_padding_bottom',
			'padding-left'   => 'content_padding_left',
		),
	)
);
// Title Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'title_typography',
		'selector'     => ".fl-node-$id .pp-coupon-title",
	)
);
// Description Typography
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'description_typography',
		'selector'     => ".fl-node-$id .pp-coupon-description",
	)
);
?>
.fl-node-<?php echo $id; ?> .pp-coupon-title {
	<?php if ( ! empty( $settings->title_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->title_color ); ?>;
	<?php } ?>
	margin-bottom: <?php echo $settings->title_margin; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-coupon-description {
	<?php if ( ! empty( $settings->description_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->description_color ); ?>;
	<?php } ?>
	margin-bottom: <?php echo $settings->description_margin; ?>px;
}
<?php if ( 'auto' === $settings->button_width ) { ?>
	.fl-node-<?php echo $id; ?> .pp-coupon-button {
		display: flex;
		justify-content: <?php echo $settings->link_align; ?>;
	}
<?php } elseif ( 'custom' === $settings->button_width ) { ?>
	<?php if ( 'flex-start' === $settings->link_align ) { ?>
		.fl-node-<?php echo $id; ?> .pp-coupon-button {
			text-align: left;
		}
	<?php } elseif ( 'flex-end' === $settings->link_align ) { ?>
		.fl-node-<?php echo $id; ?> .pp-coupon-button {
			text-align: right;
		}
	<?php } else { ?>
		.fl-node-<?php echo $id; ?> .pp-coupon-button {
			text-align: center;
		}
	<?php } ?>
<?php } ?>
.fl-node-<?php echo $id; ?> .pp-coupon-link-button {
	<?php if ( 'auto' === $settings->button_width ) { ?>
		width: auto;
	<?php } elseif ( 'full' === $settings->button_width ) { ?>
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: space-between;
	<?php } else { ?>
		width: <?php echo $settings->button_custom_width . $settings->button_custom_width_unit; ?>;
	<?php } ?>

	<?php if ( ! empty( $settings->link_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->link_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->button_bg_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->button_bg_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-link-button:hover {
	<?php if ( ! empty( $settings->link_hover_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->link_hover_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->button_bg_hover_color ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->button_bg_hover_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->button_border_hover ) ) { ?>
	border-color: <?php echo pp_get_color_value( $settings->button_border_hover ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-coupon-link-text {
	<?php if ( ! empty( $settings->link_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->link_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-link-text:hover {
	<?php if ( ! empty( $settings->link_hover_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->link_hover_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-link-icon {
	font-size: <?php echo $settings->link_icon_size; ?>px;
	<?php if ( ! empty( $settings->link_icon_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->link_icon_color ); ?>;
	<?php } ?>
	<?php if ( 'full' != $settings->button_width ) { ?>
		<?php if ( isset( $settings->link_icon_pos ) && 'left' == $settings->link_icon_pos ) { ?>
			padding-right: <?php echo $settings->link_icon_spacing; ?>px;
		<?php } else { ?>
			padding-left: <?php echo $settings->link_icon_spacing; ?>px;
		<?php } ?>
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-coupon-link-text:hover .pp-coupon-link-icon,
.fl-node-<?php echo $id; ?> .pp-coupon-link-button:hover .pp-coupon-link-icon {
	<?php if ( ! empty( $settings->link_icon_hover_color ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->link_icon_hover_color ); ?>;
	<?php } ?>
}

<?php
// Box Border - Settings
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'button_border',
		'selector'     => ".fl-node-$id .pp-coupon-link-button",
	)
);

// Description Typography
$link_class = '';
if ( 'text' === $settings->link_type ) {
	$link_class = ".fl-node-$id .pp-coupon-link-text";
} elseif ( 'button' === $settings->link_type ) {
	$link_class = ".fl-node-$id .pp-coupon-link-button";
}

FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'link_typography',
		'selector'     => $link_class,
	)
);
// Link Button Padding
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'link_button_padding',
		'selector'     => ".fl-node-$id .pp-coupon-link-button",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'link_button_padding_top',
			'padding-right'  => 'link_button_padding_right',
			'padding-bottom' => 'link_button_padding_bottom',
			'padding-left'   => 'link_button_padding_left',
		),
	)
);
// Link Margin
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'link_margin',
		'selector'     => ".fl-node-$id .pp-coupon-button",
		'unit'         => 'px',
		'props'        => array(
			'margin-top'    => 'link_margin_top',
			'margin-right'  => 'link_margin_right',
			'margin-bottom' => 'link_margin_bottom',
			'margin-left'   => 'link_margin_left',
		),
	)
);
?>
.fl-node-<?php echo $id; ?> .pp-coupon-separator {
	<?php if ( ! empty( $settings->separator_color ) ) { ?>
	border-top-color: <?php echo pp_get_color_value( $settings->separator_color ); ?>;
	<?php } ?>
	border-top-width: <?php echo $settings->separator_width; ?>px;
	margin-bottom: <?php echo $settings->separator_margin; ?>px;
}

@media screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	<?php if ( 'yes' === $settings->show_icon ) { ?>
		.fl-node-<?php echo $id; ?> .pp-coupon-code-icon,
		.fl-node-<?php echo $id; ?> .pp-coupon-icon-left .pp-coupon-code-icon.dashicons:before {
			font-size: <?php echo $settings->icon_size; ?>px;
		}
		.fl-node-<?php echo $id; ?> .pp-coupon-icon-right .pp-coupon-code-icon {
			padding-left: <?php echo $settings->icon_spacing; ?>px;
		}
		.fl-node-<?php echo $id; ?> .pp-coupon-icon-left .pp-coupon-code-icon {
			padding-right: <?php echo $settings->icon_spacing; ?>px;
		}
	<?php } ?>

	.fl-node-<?php echo $id; ?> .pp-coupon-code.pp-copied.pp-coupon-style-reveal .pp-coupon-code-text {
		padding-right: <?php echo $settings->separator_padding; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-code.pp-coupon-style-copy .pp-coupon-code-text {
		padding-right: <?php echo $settings->separator_padding; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-copy-text {
		padding-left: <?php echo $settings->separator_padding; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-title {
		margin-bottom: <?php echo $settings->title_margin; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-description {
		margin-bottom: <?php echo $settings->description_margin; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-link-button {
		<?php if ( 'auto' === $settings->button_width ) { ?>
			width: auto;
		<?php } elseif ( 'full' === $settings->button_width ) { ?>
			width: 100%;
		<?php } else { ?>
			width: <?php echo $settings->button_custom_width . $settings->button_custom_width_unit; ?>;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-link-icon {
		font-size: <?php echo $settings->link_icon_size; ?>px;
		padding-left: <?php echo $settings->link_icon_spacing; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-coupon-separator {
		border-top-width: <?php echo $settings->separator_width; ?>px;
		margin-bottom: <?php echo $settings->separator_margin; ?>px;
	}
}
