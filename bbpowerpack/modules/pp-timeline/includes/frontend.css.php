.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper:before {
	border-right-color: <?php echo ($settings->timeline_line_color) ? '#'.$settings->timeline_line_color : '#000' ?>;
	border-right-style: <?php echo $settings->timeline_line_style ?>;
	border-right-width: <?php echo ($settings->timeline_line_width >= 0) ? $settings->timeline_line_width : '1' ?>px;
}
.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper:after {
	border-color: <?php echo ($settings->timeline_line_color) ? '#'.$settings->timeline_line_color : '#000' ?>;
}

<?php
	// Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'title_typography',
		'selector' 		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content .pp-timeline-title",
	) );

	// Title - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'title_padding',
		'selector' 		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content .pp-timeline-title",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'title_padding_top',
			'padding-right' 	=> 'title_padding_right',
			'padding-bottom' 	=> 'title_padding_bottom',
			'padding-left' 		=> 'title_padding_left',
		),
	) );

	// Text Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'text_typography',
		'selector' 		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content .pp-timeline-text-wrapper p",
	) );
	// Text - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'content_padding',
		'selector' 		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content .pp-timeline-text-wrapper",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'content_padding_top',
			'padding-right' 	=> 'content_padding_right',
			'padding-bottom' 	=> 'content_padding_bottom',
			'padding-left' 		=> 'content_padding_left',
		),
	) );

	// Button Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'button_typography',
		'selector' 		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content a",
	) );
	
	// Icon - Size
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'icon_size',
		'selector'		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-icon .pp-icon",
		'prop'			=> 'font-size',
		'unit'			=> 'px',
	) );

	// Icon - Padding
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'icon_padding',
		'selector'		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-icon",
		'prop'			=> 'padding',
		'unit'			=> 'px',
	) );
?>

<?php $number_items = count($settings->timeline);
for( $i = 0; $i < $number_items; $i++ ) {
	$timeline = $settings->timeline[$i];
	?>
	.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper .pp-timeline-item-<?php echo $i; ?> .pp-timeline-icon {
		<?php if ( isset( $timeline->icon_background_color ) && ! empty( $timeline->icon_background_color ) ) { ?>
			background-color: <?php echo pp_get_color_value( $timeline->icon_background_color ); ?>;
		<?php } ?>
		<?php if ( isset( $timeline->icon_text_color ) && ! empty( $timeline->icon_text_color ) ) { ?>
			color: #<?php echo $timeline->icon_text_color; ?>;
		<?php } ?>
	}

	<?php
	if ( is_object( $timeline->icon_border ) ) {
		$timeline->icon_border = (array) $timeline->icon_border;
		foreach ( $timeline->icon_border as $key => $icon_border_field ) {
			if ( is_object( $icon_border_field ) ) {
				$timeline->icon_border[$key] = (array) $icon_border_field;
			}
		}
	}
	// Icon - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $timeline,
		'setting_name' 	=> 'icon_border',
		'selector' 		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-item-$i .pp-timeline-icon",
	) );
	?>

	.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper .pp-timeline-item-<?php echo $i; ?> .pp-timeline-content .pp-timeline-title-wrapper {
		<?php if ( isset( $timeline->title_background_color ) && ! empty( $timeline->title_background_color ) ) { ?>
			background-color: <?php echo pp_get_color_value( $timeline->title_background_color ); ?>;
		<?php } ?>
		<?php if ( isset( $timeline->title_text_color ) && ! empty( $timeline->title_text_color ) ) { ?>color: #<?php echo $timeline->title_text_color; ?>; <?php } ?>
		<?php if( $timeline->title_border != '' ) { ?>
			border-bottom-width: <?php echo $timeline->title_border; ?>px;
			border-bottom-color: #<?php echo $timeline->title_border_color; ?>;
			border-bottom-style: solid;
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper .pp-timeline-item-<?php echo $i; ?> .pp-timeline-content .pp-timeline-text-wrapper p {
		color: <?php echo ($timeline->text_color) ? '#'.$timeline->text_color : '#000' ?>;
	}

	.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper .pp-timeline-item-<?php echo $i; ?> .pp-timeline-content {
		<?php if ( isset( $timeline->timeline_box_background ) && ! empty( $timeline->timeline_box_background ) ) { ?>
			background-color: <?php echo pp_get_color_value( $timeline->timeline_box_background ); ?>;
		<?php } ?>
	}

	<?php
	if ( is_object( $timeline->timeline_box_border ) ) {
		$timeline->timeline_box_border = (array) $timeline->timeline_box_border;
		foreach ( $timeline->timeline_box_border as $key => $box_border_field ) {
			if ( is_object( $box_border_field ) ) {
				$timeline->timeline_box_border[$key] = (array) $box_border_field;
			}
		}
	}
	// Box - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $timeline,
		'setting_name' 	=> 'timeline_box_border',
		'selector' 		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-item-$i .pp-timeline-content",
	) );
	?>

	.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper .pp-timeline-item-<?php echo $i; ?> .pp-timeline-icon-wrapper .pp-separator-arrow {
		<?php if( $timeline->title != '' ) { ?>
			border-left-color: <?php echo (isset( $timeline->title_background_color ) && ! empty( $timeline->title_background_color )) ? pp_get_color_value( $timeline->title_background_color ) : 'transparent' ?>;
		<?php } else { ?>
			border-left-color: <?php echo (isset( $timeline->timeline_box_background ) && ! empty( $timeline->timeline_box_background )) ? pp_get_color_value( $timeline->timeline_box_background ) : 'transparent' ?>;
		<?php } ?>
	}
	<?php if( $i % 2 == 1 ) { ?>
		.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper .pp-timeline-item-<?php echo $i; ?> .pp-timeline-icon-wrapper .pp-separator-arrow {
			border-left-color: transparent;
			<?php if( $timeline->title != '' ) { ?>
				border-right: 10px solid <?php echo (isset( $timeline->title_background_color ) && ! empty( $timeline->title_background_color )) ? pp_get_color_value( $timeline->title_background_color ) : 'transparent' ?>;
			<?php } else { ?>
				border-right: 10px solid <?php echo (isset( $timeline->timeline_box_background ) && ! empty( $timeline->timeline_box_background )) ? pp_get_color_value( $timeline->timeline_box_background ) : 'transparent' ?>;
			<?php } ?>
		}
	<?php } ?>

	.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper .pp-timeline-item-<?php echo $i; ?> .pp-timeline-content .pp-timeline-button {
		<?php if ( isset( $timeline->timeline_button_background_color ) && ! empty( $timeline->timeline_button_background_color ) ) { ?>
			background-color: <?php echo pp_get_color_value( $timeline->timeline_button_background_color ); ?>;
		<?php } ?>
		<?php if ( isset( $timeline->timeline_button_text_color ) && ! empty( $timeline->timeline_button_text_color ) ) { ?>color: #<?php echo $timeline->timeline_button_text_color; ?>; <?php } ?>
	}
	<?php
		if ( is_object( $timeline->timeline_button_border ) ) {
			$timeline->timeline_button_border = (array) $timeline->timeline_button_border;
			foreach ( $timeline->timeline_button_border as $key => $button_border_field ) {
				if ( is_object( $button_border_field ) ) {
					$timeline->timeline_button_border[$key] = (array) $button_border_field;
				}
			}
		}
		// Button - Border
		FLBuilderCSS::border_field_rule( array(
			'settings' 		=> $timeline,
			'setting_name' 	=> 'timeline_button_border',
			'selector' 		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-item-$i .pp-timeline-content .pp-timeline-button",
		) );

		// Button - Padding
		FLBuilderCSS::dimension_field_rule( array(
			'settings'		=> $timeline,
			'setting_name' 	=> 'button_padding',
			'selector' 		=> ".fl-node-$id .pp-timeline-content-wrapper .pp-timeline-item-$i .pp-timeline-content .pp-timeline-button",
			'unit'			=> 'px',
			'props'			=> array(
				'padding-top' 		=> 'button_padding_top',
				'padding-right' 	=> 'button_padding_right',
				'padding-bottom' 	=> 'button_padding_bottom',
				'padding-left' 		=> 'button_padding_left',
			),
		) );
	?>
	.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper .pp-timeline-item-<?php echo $i; ?> .pp-timeline-content .pp-timeline-button:hover {
		<?php if ( isset( $timeline->timeline_button_background_hover ) && ! empty( $timeline->timeline_button_background_hover ) ) { ?>
			background-color: <?php echo pp_get_color_value( $timeline->timeline_button_background_hover ); ?>;
		<?php } ?>
		<?php if ( isset( $timeline->timeline_button_text_hover ) && ! empty( $timeline->timeline_button_text_hover ) ) { ?>color: #<?php echo $timeline->timeline_button_text_hover; ?>; <?php } ?>
	}
<?php } ?>

@media only screen and ( max-width: 768px ) {
	.pp-timeline .pp-timeline-content-wrapper:before {
	    left: 3%;
	    -webkit-transform: translateX(-3%);
	    -moz-transform: translateX(-3%);
	    -o-transform: translateX(-3%);
	    -ms-transform: translateX(-3%);
	    transform: translateX(-3%);
	}
	.pp-timeline .pp-timeline-content-wrapper:after {
		left: 3%;
		-webkit-transform: translateX(-40%);
		-moz-transform: translateX(-40%);
		-o-transform: translateX(-40%);
		-ms-transform: translateX(-40%);
		transform: translateX(-40%);
	}
	.pp-timeline .pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content {
	    float: right;
	    width: 90%;
	}
	.pp-timeline .pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-icon-wrapper {
	    left: 3%;
		width: 15%;
	}
	.pp-timeline .pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-icon-wrapper .pp-separator-arrow {
	    left: auto;
	    right: 0;
	}
	.pp-timeline .pp-timeline-content-wrapper .pp-timeline-item:nth-of-type(2n) .pp-timeline-icon-wrapper .pp-separator-arrow {
	    right: 0;
	}

	<?php $number_items = count($settings->timeline);
	for( $i = 0; $i < $number_items; $i++ ) {
		$timeline = $settings->timeline[$i];
		?>
		.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper .pp-timeline-item-<?php echo $i; ?> .pp-timeline-icon-wrapper .pp-separator-arrow {
			<?php if( $timeline->title != '' ) { ?>
				border-right: 10px solid <?php echo (isset( $timeline->title_background_color ) && ! empty( $timeline->title_background_color )) ? pp_get_color_value( $timeline->title_background_color ) : 'transparent' ?>;
			<?php } else { ?>
				border-right: 10px solid <?php echo (isset( $timeline->timeline_box_background ) && ! empty( $timeline->timeline_box_background )) ? pp_get_color_value( $timeline->timeline_box_background ) : 'transparent' ?>;
			<?php } ?>
			border-left: none;
		}
		<?php if( $i % 2 == 1 ) { ?>
			.fl-node-<?php echo $id; ?> .pp-timeline-content-wrapper .pp-timeline-item-<?php echo $i; ?> .pp-timeline-icon-wrapper .pp-separator-arrow {
				border-left-color: transparent;
				<?php if( $timeline->title != '' ) { ?>
					border-right: 10px solid <?php echo (isset( $timeline->title_background_color ) && ! empty( $timeline->title_background_color )) ? pp_get_color_value( $timeline->title_background_color ) : 'transparent' ?>;
				<?php } else { ?>
					border-right: 10px solid <?php echo (isset( $timeline->timeline_box_background ) && ! empty( $timeline->timeline_box_background )) ? pp_get_color_value( $timeline->timeline_box_background ) : 'transparent' ?>;
				<?php } ?>
			}
		<?php } ?>
	<?php } ?>
}
@media only screen and ( max-width: 480px ) {
	.pp-timeline .pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-content {
	    width: 85%;
	}
	.pp-timeline .pp-timeline-content-wrapper .pp-timeline-item .pp-timeline-icon-wrapper {
		width: 24%;
	}
}
