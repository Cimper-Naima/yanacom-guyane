<?php

$photo_border_width = ( isset( $settings->photo_border_group ) && ! empty( $settings->photo_border_group['width'] ) ) ? $settings->photo_border_group['width'] : 0;
$photo_border_radius = ( isset( $settings->photo_border_group ) && ! empty( $settings->photo_border_group['radius'] ) ) ? $settings->photo_border_group['radius'] : 0;
$photo_border = ( isset( $settings->photo_border_group ) && ! empty( $settings->photo_border_group['style'] ) ) ? $settings->photo_border_group['style'] : 'none';

if ( 'justified' != $settings->gallery_layout ) {

	$desktop_col = ( $settings->photo_grid_count ) ? $settings->photo_grid_count : 4;
	$medium_col = ( $settings->photo_grid_count_medium ) ? $settings->photo_grid_count_medium : 2;
	$mobile_col = ( $settings->photo_grid_count_responsive ) ? $settings->photo_grid_count_responsive : 1;

	$space_desktop = ( $desktop_col - 1 ) * $settings->photo_spacing;
	$photo_columns_desktop = ( 100 - $space_desktop ) / $desktop_col;

	$space_tablet = ( $medium_col - 1 ) * $settings->photo_spacing;
	$photo_columns_tablet = ( 100 - $space_tablet ) / $medium_col;

	$space_mobile = ( $mobile_col - 1 ) * $settings->photo_spacing;
	$photo_columns_mobile = ( 100 - $space_mobile ) / $mobile_col;
?>

.fancybox-<?php echo $id; ?> button.fancybox-button {
	padding: 10px;
	border-radius: 0;
    box-shadow: none;
}

<?php if ( 'grid' === $settings->gallery_layout ) { ?>
.fl-node-<?php echo $id; ?> .pp-photo-gallery {
	<?php if ( isset( $settings->align_items ) && 'yes' === $settings->align_items ) { ?>
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	<?php } ?>
}
<?php } ?>


.fl-node-<?php echo $id; ?> .pp-photo-gallery-item {
	width: <?php echo $photo_columns_desktop;?>%;
	<?php if ( 'grid' == $settings->gallery_layout ) { ?>
		margin-right: <?php echo $settings->photo_spacing; ?>%;
	<?php } ?>
	margin-bottom: <?php echo $settings->photo_spacing; ?>%;
	<?php if ( 0 == $settings->photo_spacing && 'grid' == $settings->gallery_layout ) { ?>
		margin-right: <?php echo $settings->photo_spacing - ( 'none' != $photo_border ? $photo_border_width['left'] : 0 ); ?>px;
		margin-bottom: <?php echo $settings->photo_spacing - ( 'none' != $photo_border ? $photo_border_width['top'] : 0 ); ?>px;
	<?php } ?>
	
	<?php if ( 'yes' == $settings->show_image_shadow_hover ) { ?>
		-webkit-transition: all <?php echo ($settings->image_shadow_hover_speed / 1000); ?>s ease-in;
			-moz-transition: all <?php echo ($settings->image_shadow_hover_speed / 1000); ?>s ease-in;
				-ms-transition: all <?php echo ($settings->image_shadow_hover_speed / 1000); ?>s ease-in;
					-o-transition: all <?php echo ($settings->image_shadow_hover_speed / 1000); ?>s ease-in;
						transition: all <?php echo ($settings->image_shadow_hover_speed / 1000); ?>s ease-in;
	<?php } ?>
}

<?php
	// Photo - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'photo_border_group',
		'selector' 		=> ".fl-node-$id .pp-photo-gallery-item",
	) );

	// gallery Items - Padding
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'photo_padding',
		'selector'		=> ".fl-node-$id .pp-photo-gallery-item",
		'prop'			=> 'padding',
		'unit'			=> 'px',
	) );
?>

.fl-node-<?php echo $id; ?> .pp-gallery-masonry-item {
	width: calc( <?php echo $photo_columns_desktop;?>% - 1px );
}

.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:hover {
	<?php if ( 'yes' == $settings->show_image_shadow_hover ) { ?>
		-webkit-box-shadow: <?php echo $settings->image_shadow_hover['horizontal']; ?>px <?php echo $settings->image_shadow_hover['vertical']; ?>px <?php echo $settings->image_shadow_hover['blur']; ?>px <?php echo $settings->image_shadow_hover['spread']; ?>px <?php echo pp_get_color_value( $settings->image_shadow_color_hover ); ?>;
			-moz-box-shadow: <?php echo $settings->image_shadow_hover['horizontal']; ?>px <?php echo $settings->image_shadow_hover['vertical']; ?>px <?php echo $settings->image_shadow_hover['blur']; ?>px <?php echo $settings->image_shadow_hover['spread']; ?>px <?php echo pp_get_color_value( $settings->image_shadow_color_hover ); ?>;
				-o-box-shadow: <?php echo $settings->image_shadow_hover['horizontal']; ?>px <?php echo $settings->image_shadow_hover['vertical']; ?>px <?php echo $settings->image_shadow_hover['blur']; ?>px <?php echo $settings->image_shadow_hover['spread']; ?>px <?php echo pp_get_color_value( $settings->image_shadow_color_hover ); ?>;
					box-shadow: <?php echo $settings->image_shadow_hover['horizontal']; ?>px <?php echo $settings->image_shadow_hover['vertical']; ?>px <?php echo $settings->image_shadow_hover['blur']; ?>px <?php echo $settings->image_shadow_hover['spread']; ?>px <?php echo pp_get_color_value( $settings->image_shadow_color_hover ); ?>;
		-webkit-transition: all <?php echo ($settings->image_shadow_hover_speed / 1000); ?>s ease-in;
			-moz-transition: all <?php echo ($settings->image_shadow_hover_speed / 1000); ?>s ease-in;
				-ms-transition: all <?php echo ($settings->image_shadow_hover_speed / 1000); ?>s ease-in;
					-o-transition: all <?php echo ($settings->image_shadow_hover_speed / 1000); ?>s ease-in;
						transition: all <?php echo ($settings->image_shadow_hover_speed / 1000); ?>s ease-in;
	<?php } ?>
}
<?php if ( $desktop_col > 1 ) { ?>
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $desktop_col; ?>n+1){
		clear: left;
	}
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $desktop_col; ?>n+0){
		clear: right;
	}
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $desktop_col; ?>n){
		margin-right: 0;
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-photo-gallery-item img,
.fl-node-<?php echo $id; ?> .pp-gallery-overlay,
.fl-node-<?php echo $id; ?> .pp-photo-gallery-content {
	<?php if ( $photo_border_radius['top_left'] >= 0 ) { ?> border-top-left-radius: <?php echo $photo_border_radius['top_left']; ?>px; <?php } ?>
	<?php if ( $photo_border_radius['bottom_left'] >= 0 ) { ?> border-bottom-left-radius: <?php echo $photo_border_radius['bottom_left']; ?>px; <?php } ?>
	<?php if ( $photo_border_radius['top_right'] >= 0 ) { ?> border-top-right-radius: <?php echo $photo_border_radius['top_right']; ?>px; <?php } ?>
	<?php if ( $photo_border_radius['bottom_right'] >= 0 ) { ?> border-bottom-right-radius: <?php echo $photo_border_radius['bottom_right']; ?>px; <?php } ?>
}

<?php if ( 'below' == $settings->show_captions && $settings->caption_bg_color ) { ?>
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-item.has-caption img,
	.fl-node-<?php echo $id; ?> .has-caption .pp-gallery-overlay,
	.fl-node-<?php echo $id; ?> .has-caption .pp-photo-gallery-content {
		border-bottom-left-radius: 0;
		border-bottom-right-radius: 0;
	}

	.fl-node-<?php echo $id; ?> .pp-photo-gallery-item.has-caption .pp-photo-gallery-caption {
		<?php if ( $photo_border_radius['bottom_left'] >= 0 ) { ?> border-bottom-left-radius: <?php echo $photo_border_radius['bottom_left']; ?>px; <?php } ?>
		<?php if ( $photo_border_radius['bottom_right'] >= 0 ) { ?> border-bottom-right-radius: <?php echo $photo_border_radius['bottom_right']; ?>px; <?php } ?>
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-photo-space {
	width: <?php echo $settings->photo_spacing; ?>%;
}

<?php } ?>

<?php if ( 'below' == $settings->show_captions ) { ?>
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-caption {
		<?php if ( isset( $settings->caption_bg_color ) && ! empty( $settings->caption_bg_color ) ) { ?>
			background-color: <?php echo pp_get_color_value( $settings->caption_bg_color ); ?>;
		<?php } ?>
		text-align: <?php echo $settings->caption_alignment; ?>;
	}
<?php } ?>

<?php
	// Caption - Padding
	FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'caption_padding',
	'selector' 		=> ".fl-node-$id .pp-photo-gallery-caption",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'caption_padding_top',
		'padding-right' 	=> 'caption_padding_right',
		'padding-bottom' 	=> 'caption_padding_bottom',
		'padding-left' 		=> 'caption_padding_left',
	),
) );
?>


<?php if ( 'lightbox' == $settings->click_action && ! empty( $settings->show_captions ) ) : ?>
	.mfp-gallery img.mfp-img {
		padding: 0;
	}

	.mfp-counter {
		display: block !important;
	}
<?php endif; ?>

<?php if ( 'none' != $settings->overlay_effects ) : ?>
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay {
		<?php if ( 'solid' == $settings->overlay_type ) { ?>
			background: <?php echo ( '' != $settings->overlay_color ) ? pp_hex2rgba( '#' . $settings->overlay_color, ( $settings->overlay_color_opacity / 100 ) ) : 'rgba(0,0,0,.5)'; ?>;
		<?php } ?>

		<?php if ( 'gradient' == $settings->overlay_type ) : ?>
			background: -moz-linear-gradient(top,  <?php echo pp_hex2rgba( '#' . $settings->overlay_primary_color, ( $settings->overlay_color_opacity / 100 ) ); ?> 0%, <?php echo pp_hex2rgba( '#' . $settings->overlay_secondary_color, ( $settings->overlay_color_opacity / 100 ) ); ?> 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo pp_hex2rgba( '#' . $settings->overlay_primary_color, ( $settings->overlay_color_opacity / 100 ) ); ?>), color-stop(100%,<?php echo pp_hex2rgba( '#' . $settings->overlay_secondary_color, ( $settings->overlay_color_opacity / 100 ) ); ?>)); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top,  <?php echo pp_hex2rgba( '#' . $settings->overlay_primary_color, ( $settings->overlay_color_opacity / 100 ) ); ?> 0%,<?php echo pp_hex2rgba( '#' . $settings->overlay_secondary_color, ( $settings->overlay_color_opacity / 100 ) ); ?> 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top,  <?php echo pp_hex2rgba( '#' . $settings->overlay_primary_color, ( $settings->overlay_color_opacity / 100 ) ); ?> 0%,<?php echo pp_hex2rgba( '#' . $settings->overlay_secondary_color, ( $settings->overlay_color_opacity / 100 ) ); ?> 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top,  <?php echo pp_hex2rgba( '#' . $settings->overlay_primary_color, ( $settings->overlay_color_opacity / 100 ) ); ?> 0%,<?php echo pp_hex2rgba( '#' . $settings->overlay_secondary_color, ( $settings->overlay_color_opacity / 100 ) ); ?> 100%); /* IE10+ */
			background: linear-gradient(to bottom,  <?php echo pp_hex2rgba( '#' . $settings->overlay_primary_color, ( $settings->overlay_color_opacity / 100 ) ); ?> 0%,<?php echo pp_hex2rgba( '#' . $settings->overlay_secondary_color, ($settings->overlay_color_opacity / 100 ) ); ?> 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo pp_hex2rgba( '#' . $settings->overlay_primary_color, ( $settings->overlay_color_opacity / 100 ) ); ?>', endColorstr='<?php echo pp_hex2rgba( '#' . $settings->overlay_secondary_color, ( $settings->overlay_color_opacity / 100 ) ); ?>',GradientType=0 ); /* IE6-9 */
		<?php endif; ?>

		-webkit-transition: <?php echo ($settings->overlay_animation_speed / 1000); ?>s ease;
			-moz-transition: <?php echo ($settings->overlay_animation_speed / 1000); ?>s ease;
				-ms-transition: <?php echo ($settings->overlay_animation_speed / 1000); ?>s ease;
					-o-transition: <?php echo ($settings->overlay_animation_speed / 1000); ?>s ease;
						transition: <?php echo ($settings->overlay_animation_speed / 1000); ?>s ease;
	}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-icon span {
	width: auto;
	height: auto;
	color: #<?php echo $settings->overlay_icon_color; ?>;
	font-size: <?php echo $settings->overlay_icon_size; ?>px;
	background-color: #<?php echo $settings->overlay_icon_bg_color; ?>;
	<?php if ( $settings->overlay_icon_radius ) { ?>border-radius: <?php echo $settings->overlay_icon_radius; ?>px;<?php } ?>
	<?php if ( $settings->overlay_icon_vertical_padding ) { ?>padding-top: <?php echo $settings->overlay_icon_vertical_padding; ?>px;<?php } ?>
	<?php if ( $settings->overlay_icon_vertical_padding ) { ?>padding-bottom: <?php echo $settings->overlay_icon_vertical_padding; ?>px;<?php } ?>
	<?php if ( $settings->overlay_icon_horizotal_padding ) { ?>padding-left: <?php echo $settings->overlay_icon_horizotal_padding; ?>px;<?php } ?>
	<?php if ( $settings->overlay_icon_horizotal_padding ) { ?>padding-right: <?php echo $settings->overlay_icon_horizotal_padding; ?>px;<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-icon span:before {
	font-size: <?php echo $settings->overlay_icon_size; ?>px;
	width: auto;
	height: auto;
}

.fl-node-<?php echo $id; ?> .pp-photo-gallery-caption,
.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-caption {
	<?php if ( $settings->caption_color ) { ?>
	color: #<?php echo $settings->caption_color; ?>;
	<?php } ?>
}

<?php
	// Caption Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'caption_typography',
		'selector' 		=> ".fl-node-$id .pp-photo-gallery-caption, .fl-node-$id .pp-gallery-overlay .pp-caption",
	) );
?>

<?php if ( 'none' == $settings->overlay_effects && 'none' == $settings->hover_effects && 'hover' == $settings->show_captions ) { ?>
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay {
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		opacity: 0;
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner {
		position: absolute;
		top: 50%;
		left: 50%;
		-webkit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
	}
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content:hover .pp-gallery-overlay {
		opacity: 1;
	}
<?php } ?>

<?php if ( 'fade' == $settings->overlay_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay {
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		height: 100%;
		width: 100%;
		opacity: 0;
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner {
		position: absolute;
		top: 50%;
		left: 50%;
		-webkit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
	}
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content:hover .pp-gallery-overlay {
		opacity: 1;
	}
<?php } ?>

<?php if ( 'from-left' == $settings->overlay_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay {
		bottom: 0;
		left: 0;
		right: 0;
		width: 0;
		height: 100%;
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner {
		white-space: nowrap;
		color: white;
		font-size: 20px;
		position: absolute;
		overflow: hidden;
		top: 50%;
		left: 50%;
		-webkit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
	}
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content:hover .pp-gallery-overlay {
		width: 100%;
	}
<?php } ?>

<?php if ( 'from-right' == $settings->overlay_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay {
		bottom: 0;
		left: 100%;
		right: 0;
		width: 0;
		height: 100%;
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner {
		white-space: nowrap;
		color: white;
		font-size: 20px;
		position: absolute;
		overflow: hidden;
		top: 50%;
		left: 50%;
		-webkit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
	}
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content:hover .pp-gallery-overlay {
		width: 100%;
		left: 0;
	}
<?php } ?>

<?php if ( 'from-top' == $settings->overlay_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay {
		bottom: 100%;
		left: 0;
		right: 0;
		width: 100%;
		height: 0;
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner {
		white-space: nowrap;
		color: white;
		font-size: 20px;
		position: absolute;
		overflow: hidden;
		top: 50%;
		left: 50%;
		-webkit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
	}
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content:hover .pp-gallery-overlay {
		height: 100%;
		bottom: 0;
	}
<?php } ?>

<?php if ( 'from-bottom' == $settings->overlay_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay {
		bottom: 0;
		left: 0;
		right: 0;
		width: 100%;
		height: 0;
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner {
		white-space: nowrap;
		color: white;
		font-size: 20px;
		position: absolute;
		overflow: hidden;
		top: 50%;
		left: 50%;
		-webkit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
	}
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content:hover .pp-gallery-overlay {
		height: 100%;
	}
<?php } ?>

<?php if ( 'framed' == $settings->overlay_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay {
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		height: 100%;
		width: 100%;
		opacity: 0;
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner {
		position: absolute;
		top: 50%;
		left: 50%;
		width: 100%;
		height: 100%;
		-webkit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner:before,
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner:after {
		content: '';
		display: block;
		position: absolute;
		top: <?php echo ( $settings->overlay_spacing ) ? $settings->overlay_spacing . 'px' : '30px'; ?>;
		left: <?php echo ( $settings->overlay_spacing ) ? $settings->overlay_spacing . 'px' : '30px'; ?>;
		bottom: <?php echo ( $settings->overlay_spacing ) ? $settings->overlay_spacing . 'px' : '30px'; ?>;
		right: <?php echo ( $settings->overlay_spacing ) ? $settings->overlay_spacing . 'px' : '30px'; ?>;
		-webkit-transition: -webkit-transform .35s ease 0s;
			-ms-transition: -ms-transform .35s ease 0s;
				transition: transform .35s ease 0s;
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner:before {
		border-style: solid;
		border-width: 0;
		border-color: <?php echo ( $settings->overlay_border_color ) ? '#' . $settings->overlay_border_color : '#ffffff'; ?>;
		border-top-width: <?php echo ( $settings->overlay_border_width ) ? $settings->overlay_border_width . 'px' : '1px'; ?>;
		border-bottom-width: <?php echo ( $settings->overlay_border_width ) ? $settings->overlay_border_width . 'px' : '1px'; ?>;
		-webkit-transform: scale(0,1);
			-ms-transform: scale(0,1);
				transform: scale(0,1);
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner:after {
		border-style: solid;
		border-width: 0;
		border-color: <?php echo ( $settings->overlay_border_color ) ? '#' . $settings->overlay_border_color : '#ffffff'; ?>;
		border-left-width: <?php echo ( $settings->overlay_border_width ) ? $settings->overlay_border_width . 'px' : '1px'; ?>;
		border-right-width: <?php echo ( $settings->overlay_border_width ) ? $settings->overlay_border_width . 'px' : '1px'; ?>;
		-webkit-transform: scale(1,0);
			-ms-transform: scale(1,0);
				transform: scale(1,0);
	}

	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content:hover .pp-gallery-overlay .pp-overlay-inner:before,
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content:hover .pp-gallery-overlay .pp-overlay-inner:after {
		-webkit-transform: scale(1);
			-ms-transform: scale(1);
				transform: scale(1);
	}

	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content:hover .pp-gallery-overlay {
		opacity: 1;
	}

	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content .pp-caption {
		position: absolute;
		left: <?php echo ( $settings->overlay_spacing ) ? $settings->overlay_spacing . 'px' : '30px'; ?>;
		right: <?php echo ( $settings->overlay_spacing ) ? $settings->overlay_spacing . 'px' : '30px'; ?>;
		top: 50%;
		transform: translateY( -50% );
		-webkit-transition: -webkit-transform .35s ease 0s;
			-ms-transition: -ms-transform .35s ease 0s;
				transition: transform .35s ease 0s;
	}
<?php } ?>

<?php if ( 'zoom-in' == $settings->hover_effects || 'zoom-out' == $settings->hover_effects || 'greyscale' == $settings->hover_effects || 'blur' == $settings->hover_effects || 'rotate' == $settings->hover_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay {
		top: 0;
		opacity: 0;
		overflow: hidden;
		<?php if ( 'none' == $settings->overlay_effects ) { ?>
			left: 0;
			width: 100%;
			height: 100%;
		<?php } ?>
		<?php if ( 'from-bottom' == $settings->overlay_effects ) { ?>
			top: auto;
		<?php } ?>
		
	}
	.fl-node-<?php echo $id; ?> .pp-gallery-overlay .pp-overlay-inner {
		-webkit-box-orient: vertical;
		-webkit-box-direction: normal;
		-webkit-flex-direction: column;
			-ms-flex-direction: column;
				flex-direction: column;
		-webkit-box-pack: center;
		-webkit-justify-content: center;
		-ms-flex-pack: center;
		justify-content: center;
		display: -webkit-box;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
		height: 100%;
		width: 100%;
	}
	.fl-node-<?php echo $id; ?> .pp-photo-gallery-content:hover .pp-gallery-overlay {
		opacity: 1;
		-webkit-transform: translate(0);
			-moz-transform: translate(0);
				-ms-transform: translate(0);
					-o-transform: translate(0);
						transform: translate(0);
	}
<?php } ?>

<?php if ( 'none' != $settings->hover_effects ) { ?>
.fl-node-<?php echo $id; ?> .pp-photo-gallery .pp-photo-gallery-content .pp-gallery-img {
	-webkit-transition: all <?php echo ($settings->image_animation_speed / 1000); ?>s ease;
		-moz-transition: all <?php echo ($settings->image_animation_speed / 1000); ?>s ease;
			-ms-transition: all <?php echo ($settings->image_animation_speed / 1000); ?>s ease;
				-o-transition: all <?php echo ($settings->image_animation_speed / 1000); ?>s ease;
					transition: all <?php echo ($settings->image_animation_speed / 1000); ?>s ease;
}
<?php } ?>

<?php if ( 'zoom-in' == $settings->hover_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-photo-gallery .pp-photo-gallery-content .pp-gallery-img {
		-webkit-transform: scale(1);
			-moz-transform: scale(1);
				-ms-transform: scale(1);
					-o-transform: scale(1);
						transform: scale(1);
	}

	.fl-node-<?php echo $id; ?> .pp-photo-gallery .pp-photo-gallery-content:hover .pp-gallery-img {
		-webkit-transform: scale(1.3);
			-moz-transform: scale(1.3);
				-ms-transform: scale(1.3);
					-o-transform: scale(1.3);
						transform: scale(1.3);
	}
<?php } ?>

<?php if ( 'zoom-out' == $settings->hover_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-photo-gallery .pp-photo-gallery-content .pp-gallery-img {
		-webkit-transform: scale(1.5);
			-moz-transform: scale(1.5);
				-ms-transform: scale(1.5);
					-o-transform: scale(1.5);
						transform: scale(1.5);
	}

	.fl-node-<?php echo $id; ?> .pp-photo-gallery .pp-photo-gallery-content:hover .pp-gallery-img {
		-webkit-transform: scale(1);
			-moz-transform: scale(1);
				-ms-transform: scale(1);
					-o-transform: scale(1);
						transform: scale(1);
	}
<?php } ?>

<?php if ( 'greyscale' == $settings->hover_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-photo-gallery .pp-photo-gallery-content:hover .pp-gallery-img {
		-webkit-filter: grayscale(100%);
			-moz-filter: grayscale(100%);
				-ms-filter: grayscale(100%);
					filter: grayscale(100%);
	}
<?php } ?>

<?php if ( 'blur' == $settings->hover_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-photo-gallery .pp-photo-gallery-content .pp-gallery-img {
		-webkit-filter: blur(0);
		filter: blur(0);
	}

	.fl-node-<?php echo $id; ?> .pp-photo-gallery .pp-photo-gallery-content:hover .pp-gallery-img {
		-webkit-filter: blur(3px);
		filter: blur(3px);
	}
<?php } ?>

<?php if ( 'rotate' == $settings->hover_effects ) { ?>
	.fl-node-<?php echo $id; ?> .pp-photo-gallery .pp-photo-gallery-content .pp-gallery-img {
		-webkit-transform: rotate(0) scale(1);
		transform: rotate(0) scale(1);
	}

	.fl-node-<?php echo $id; ?> .pp-photo-gallery .pp-photo-gallery-content:hover .pp-gallery-img {
		-webkit-transform: rotate(15deg) scale(1.6);
		transform: rotate(15deg) scale(1.6);
	}
<?php } ?>
.fl-node-<?php echo $id; ?> .pp-gallery-pagination {
	<?php if ( isset( $settings->load_more_alignment ) ) { ?>
		text-align: <?php echo $settings->load_more_alignment; ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-gallery-pagination.pagination-scroll {
	display: none;
}
.fl-node-<?php echo $id; ?> .pp-gallery-pagination .pp-gallery-load-more {
	<?php if ( isset( $settings->load_more_bg_color ) && ! empty( $settings->load_more_bg_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->load_more_bg_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->load_more_text_color ) && ! empty( $settings->load_more_text_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->load_more_text_color ); ?>;
	<?php } ?>
}
<?php
	// Load More - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'load_more_border',
		'selector' 		=> ".fl-node-$id .pp-gallery-pagination .pp-gallery-load-more",
	) );

	// Load More - Margin Top
	FLBuilderCSS::responsive_rule( array(
		'settings'		=> $settings,
		'setting_name'	=> 'load_more_margin_top',
		'selector'		=> ".fl-node-$id .pp-gallery-pagination .pp-gallery-load-more",
		'prop'			=> 'margin-top',
		'unit'			=> 'px',
	) );

	// Load More - Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'load_more_padding',
		'selector' 		=> ".fl-node-$id .pp-gallery-pagination .pp-gallery-load-more",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'load_more_padding_top',
			'padding-right' 	=> 'load_more_padding_right',
			'padding-bottom' 	=> 'load_more_padding_bottom',
			'padding-left' 		=> 'load_more_padding_left',
		),
	) );
?>
.fl-node-<?php echo $id; ?> .pp-gallery-pagination .pp-gallery-load-more:hover {
	<?php if ( isset( $settings->load_more_bg_hover_color ) && ! empty( $settings->load_more_bg_hover_color ) ) { ?>
		background-color: <?php echo pp_get_color_value( $settings->load_more_bg_hover_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->load_more_text_hover_color ) && ! empty( $settings->load_more_text_hover_color ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->load_more_text_hover_color ); ?>;
	<?php } ?>
	<?php if ( isset( $settings->load_more_border_hover_color ) && ! empty( $settings->load_more_border_hover_color ) ) { ?>
		border-color: <?php echo pp_get_color_value( $settings->load_more_border_hover_color ); ?>;
	<?php } ?>
}

.fancybox-<?php echo $id; ?>-overlay {
	background-image: none;
	<?php if ( isset( $settings->lightbox_overlay_color ) && ! empty( $settings->lightbox_overlay_color ) ) : ?>
		background-color: <?php echo pp_get_color_value( $settings->lightbox_overlay_color ); ?>;
	<?php endif; ?>
}

@media only screen and ( max-width: <?php echo $global_settings->medium_breakpoint; ?>px ) {
	
	<?php if ( 'justified' != $settings->gallery_layout ) { ?>
		.fl-node-<?php echo $id; ?> .pp-photo-gallery-item {
			width: <?php echo $photo_columns_tablet;?>%;
		}

		<?php if ( 'grid' == $settings->gallery_layout ) { ?>
			.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $desktop_col; ?>n+1){
				clear: none;
			}
			.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $desktop_col; ?>n+0){
				clear: none;
			}
			.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $desktop_col; ?>n){
				margin-right: <?php echo $settings->photo_spacing; ?>%;
			}
			<?php if ( $medium_col > 1 ) { ?>
				.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $medium_col; ?>n+1){
					clear: left;
				}
				.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $medium_col; ?>n+0){
					clear: right;
				}
			<?php } ?>
			.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $medium_col; ?>n){
				margin-right: 0;
			}
		<?php } ?>
	<?php } ?>
}

@media only screen and ( max-width: <?php echo $global_settings->responsive_breakpoint; ?>px ) {
	<?php if ( 'justified' != $settings->gallery_layout ) { ?>
		.fl-node-<?php echo $id; ?> .pp-photo-gallery-item {
			width: <?php echo $photo_columns_mobile;?>%;
		}
		<?php if ( 'grid' == $settings->gallery_layout ) { ?>
			.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $medium_col; ?>n+1){
				clear: none;
			}
			.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $medium_col; ?>n+0){
				clear: none;
			}
			.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $medium_col; ?>n){
				margin-right: <?php echo $settings->photo_spacing; ?>%;
			}
			<?php if ( $mobile_col > 1 ) { ?>
				.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $mobile_col; ?>n+1){
					clear: left;
				}
				.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $mobile_col; ?>n+0){
					clear: right;
				}
			<?php } ?>
			.fl-node-<?php echo $id; ?> .pp-photo-gallery-item:nth-child(<?php echo $mobile_col; ?>n){
				margin-right: 0;
			}
		<?php } ?>
	<?php } ?>
}
