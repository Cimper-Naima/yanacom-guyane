<?php
// Item Border.
FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'box_border',
		'selector'     => ".fl-node-$id .pp-video-wrapper",
	)
);

FLBuilderCSS::border_field_rule(
	array(
		'settings'     => $settings,
		'setting_name' => 'play_icon_border',
		'selector'     => ".fl-node-$id .pp-video-play-icon",
	)
);
?>
.fl-node-<?php echo $id; ?> .pp-video-play-icon {
	<?php if ( ! empty( $settings->play_icon_bg_color ) ) { ?>
		background: <?php echo pp_get_color_value( $settings->play_icon_bg_color ); ?>;
	<?php } ?>
	<?php if ( ! empty( $settings->play_icon_size ) ) { ?>
		padding: calc( <?php echo $settings->play_icon_size; ?>px / 1.2 );
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-play-icon:hover {
	<?php if ( ! empty( $settings->play_icon_bg_hover_color ) ) { ?>
		background: <?php echo pp_get_color_value( $settings->play_icon_bg_hover_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->play_icon_border_hover_color ) && ! empty( $settings->play_icon_border_hover_color ) ) { ?>
		border-color: #<?php echo $settings->play_icon_border_hover_color; ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-image-overlay {
	cursor: pointer;
}
<?php
FLBuilderCSS::responsive_rule( array(
	'settings'	=> $settings,
	'setting_name'	=> 'play_icon_size',
	'selector'	=> ".fl-node-$id .pp-video-play-icon svg",
	'prop'		=> 'width',
	'unit'		=> 'px',
) );
FLBuilderCSS::responsive_rule( array(
	'settings'	=> $settings,
	'setting_name'	=> 'play_icon_size',
	'selector'	=> ".fl-node-$id .pp-video-play-icon svg",
	'prop'		=> 'height',
	'unit'		=> 'px',
) );
?>
.fl-node-<?php echo $id; ?> .pp-video-play-icon svg {
	<?php if ( ! empty( $settings->play_icon_color ) ) { ?>
		fill: <?php echo pp_get_color_value( $settings->play_icon_color ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-video-play-icon:hover svg {
	<?php if ( ! empty( $settings->play_icon_hover_color ) ) { ?>
		fill: <?php echo pp_get_color_value( $settings->play_icon_hover_color ); ?>;
	<?php } ?>
}

.fancybox-<?php echo $id; ?> .pp-aspect-ratio-<?php echo $settings->aspect_ratio; ?> {
	background: none;
	width: 100%;
	height: 100%;
}
.fancybox-<?php echo $id; ?> .pp-video-container {
	<?php if ( 'top' === $settings->lightbox_video_position ) { ?>
		top: 60px;
		transform: translateX(-50%);
	<?php } ?>
}
.fancybox-<?php echo $id; ?> .fancybox-close-small {
	color: #<?php echo ! empty( $settings->lightbox_color ) ? $settings->lightbox_color : 'fff'; ?>;
	height: 60px;
	width: 60px;
	background: none !important;
	border: none !important;
	box-shadow: none !important;
	padding: 5px !important;
}
.fancybox-<?php echo $id; ?> .fancybox-close-small:hover,
.fancybox-<?php echo $id; ?> .fancybox-close-small:focus {
	color: #<?php echo ! empty( $settings->lightbox_hover_color ) ? $settings->lightbox_hover_color : 'fff'; ?>;
}
.fancybox-<?php echo $id; ?> .fancybox-close-small,
.fancybox-<?php echo $id; ?> .fancybox-close-small:focus {
	position: absolute;
	top: 0;
	right: 0;
}
.admin-bar .fancybox-<?php echo $id; ?> .fancybox-close-small {
	top: 32px;
}
.fancybox-<?php echo $id; ?>-overlay {
	<?php if ( ! empty( $settings->lightbox_bg_color ) ) { ?>
	opacity: 1 !important;
	background: <?php echo pp_get_color_value( $settings->lightbox_bg_color ); ?>;
	<?php } ?>
}

@media only screen and (min-width: 1025px) {
	.fancybox-<?php echo $id; ?> .pp-video-container {
		<?php if ( ! empty( $settings->lightbox_video_width ) ) { ?>
			width: <?php echo $settings->lightbox_video_width; ?>%;
		<?php } ?>
	}
}

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-video-play-icon {
		<?php if ( isset( $settings->play_icon_size_medium ) && ! empty( $settings->play_icon_size_medium ) ) { ?>
			padding: calc( <?php echo $settings->play_icon_size_medium; ?>px / 1.2 );
		<?php } ?>
	}
}
@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-video-play-icon {
		<?php if ( isset( $settings->play_icon_size_responsive ) && ! empty( $settings->play_icon_size_responsive ) ) { ?>
			padding: calc( <?php echo $settings->play_icon_size_responsive; ?>px / 1.2 );
		<?php } ?>
	}
}