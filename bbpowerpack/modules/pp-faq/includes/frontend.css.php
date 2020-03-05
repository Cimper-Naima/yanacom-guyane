.fl-node-<?php echo $id; ?> .pp-faq-item:not(:last-child) {
	<?php if ( '0' === $settings->item_spacing ) { ?>
		border-bottom-width: 0;
	<?php } else { ?>
		margin-bottom: <?php echo $settings->item_spacing; ?>px;
	<?php }; ?>
}

<?php
// Label padding.
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'qus_padding',
		'selector'     => ".fl-node-$id .pp-faq-item .pp-faq-button",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'qus_padding_top',
			'padding-right'  => 'qus_padding_right',
			'padding-bottom' => 'qus_padding_bottom',
			'padding-left'   => 'qus_padding_left',
		),
	)
);

// Label border.
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'box_border',
		'selector'     => ".fl-node-$id .pp-faq-item",
	)
);
?>
.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button {
	<?php if ( isset( $settings->qus_bg_color_default ) && ! empty( $settings->qus_bg_color_default ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->qus_bg_color_default ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button .pp-faq-button-label {
	<?php if ( isset( $settings->qus_text_color_default ) && ! empty( $settings->qus_text_color_default ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->qus_text_color_default ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button:hover,
.fl-node-<?php echo $id; ?> .pp-faq-item.pp-faq-item-active .pp-faq-button {
	<?php if ( isset( $settings->qus_bg_color_active ) && ! empty( $settings->qus_bg_color_active ) ) { ?>
	background-color: <?php echo pp_get_color_value( $settings->qus_bg_color_active ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button:hover .pp-faq-button-label,
.fl-node-<?php echo $id; ?> .pp-faq-item.pp-faq-item-active .pp-faq-button .pp-faq-button-label {
	<?php if ( isset( $settings->qus_text_color_active ) && ! empty( $settings->qus_text_color_active ) ) { ?>
	color: <?php echo pp_get_color_value( $settings->qus_text_color_active ); ?>;
	<?php } ?>
}

<?php // if( $settings->answer_bg_color || $settings->answer_border_style != 'none' ) { ?>
	/* .fl-node-<?php echo $id; ?> .pp-faq-item.pp-faq-item-active .pp-faq-button {
		border-bottom-left-radius: 0;
		border-bottom-right-radius: 0;
		transition: none;
	} */
<?php // } ?>

<?php
// Label typography.
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'qus_typography',
		'selector'     => ".fl-node-$id .pp-faq-item .pp-faq-button .pp-faq-button-label",
	)
);
?>

<?php
// Content typography.
FLBuilderCSS::typography_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'answer_typography',
		'selector'     => ".fl-node-$id .pp-faq-item .pp-faq-content",
	)
);
?>
<?php
// Content border.
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'answer_border',
		'selector'     => ".fl-node-$id .pp-faq-item .pp-faq-content",
	)
);

// Content Padding.
FLBuilderCSS::dimension_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'answer_padding',
		'selector'     => ".fl-node-$id .pp-faq-item .pp-faq-content",
		'unit'         => 'px',
		'props'        => array(
			'padding-top'    => 'answer_padding_top',
			'padding-right'  => 'answer_padding_right',
			'padding-bottom' => 'answer_padding_bottom',
			'padding-left'   => 'answer_padding_left',
		),
	)
);
?>
.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-content {
	background-color: <?php echo pp_get_color_value( $settings->answer_bg_color ); ?>;
	color: <?php echo pp_get_color_value( $settings->answer_text_color ); ?>;
	<?php if ( isset( $settings->answer_border['radius'] ) ) { ?>
	border-bottom-left-radius: <?php echo $settings->answer_border['radius']['bottom_left']; ?>px;
	border-bottom-right-radius: <?php echo $settings->answer_border['radius']['bottom_right']; ?>px;
	<?php } ?>
}


.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon {
	font-size: <?php echo $settings->faq_toggle_icon_size; ?>px;
	color: <?php echo pp_get_color_value( $settings->faq_toggle_icon_color ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-faq-item.pp-faq-item-active .pp-faq-button-icon,
.fl-node-<?php echo $id; ?> .pp-faq-item:hover .pp-faq-button-icon {
	<?php if ( isset( $settings->faq_toggle_icon_color_hover ) && ! empty( $settings->faq_toggle_icon_color_hover ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->faq_toggle_icon_color_hover ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon:before {
	font-size: <?php echo $settings->faq_toggle_icon_size; ?>px;
}

.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon.pp-faq-icon-right {
	padding-left: <?php echo $settings->faq_toggle_icon_spacing; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon.pp-faq-icon-left {
	padding-right: <?php echo $settings->faq_toggle_icon_spacing; ?>px;
}

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon.pp-faq-icon-right {
		padding-left: <?php echo $settings->faq_toggle_icon_spacing_medium; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon.pp-faq-icon-left {
		padding-right: <?php echo $settings->faq_toggle_icon_spacing_medium; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon,
	.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon:before {
		font-size: <?php echo $settings->faq_toggle_icon_size_medium; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-faq-item:not(:last-child) {
		<?php if ( '0' === $settings->item_spacing_medium ) { ?>
			border-bottom-width: 0;
			margin-bottom: 0px;
		<?php } else { ?>
			margin-bottom: <?php echo $settings->item_spacing_medium; ?>px;
		<?php }; ?>
	}
}

@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon.pp-faq-icon-right {
		padding-left: <?php echo $settings->faq_toggle_icon_spacing_responsive; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon.pp-faq-icon-left {
		padding-right: <?php echo $settings->faq_toggle_icon_spacing_responsive; ?>px;
	}

	.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon,
	.fl-node-<?php echo $id; ?> .pp-faq-item .pp-faq-button-icon:before {
		font-size: <?php echo $settings->faq_toggle_icon_size_responsive; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-faq-item:not(:last-child) {
		<?php if ( '0' === $settings->item_spacing_responsive ) { ?>
			border-bottom-width: 0;
			margin-bottom: 0px;
		<?php } else { ?>
			margin-bottom: <?php echo $settings->item_spacing_responsive; ?>px;
		<?php }; ?>
	}
}
