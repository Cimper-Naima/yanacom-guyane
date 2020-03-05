<?php
// Album Cover Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'cover_border',
	'selector' 		=> ".fl-node-$id .pp-album-cover",
) );
// Overlay Margin
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'overlay_margin',
	'selector' 		=> ".fl-node-$id .pp-album-cover-overlay",
	'unit'			=> 'px',
	'props'			=> array(
		'margin-top' 		=> 'overlay_margin_top',
		'margin-right' 		=> 'overlay_margin_right',
		'margin-bottom'		=> 'overlay_margin_bottom',
		'margin-left' 		=> 'overlay_margin_left',
	),
) );
// Album Cover Hover Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'cover_hover_border',
	'selector' 		=> ".fl-node-$id .pp-album-container-wrap:hover .pp-album-cover",
) );
// Overlay Hover Margin
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'overlay_hover_margin',
	'selector' 		=> ".fl-node-$id .pp-album-container-wrap:hover .pp-album-cover-overlay",
	'unit'			=> 'px',
	'props'			=> array(
		'margin-top' 		=> 'overlay_hover_margin_top',
		'margin-right' 		=> 'overlay_hover_margin_right',
		'margin-bottom'		=> 'overlay_hover_margin_bottom',
		'margin-left' 		=> 'overlay_hover_margin_left',
	),
) );
?>

.fl-node-<?php echo $id; ?> .pp-album-cover img {
	transform: scale(<?php echo $settings->cover_img_scale;?>);
}
.fl-node-<?php echo $id; ?> .pp-album-container-wrap:hover img {
	transform: scale(<?php echo $settings->cover_img_hover_scale;?>);
}
.fl-node-<?php echo $id; ?> .pp-album-cover-overlay {
	background-color: <?php echo $settings->cover_overlay_bg ? pp_get_color_value( $settings->cover_overlay_bg ) : 'transparent'; ?>;
}
.fl-node-<?php echo $id; ?> .pp-album-container-wrap:hover .pp-album-cover-overlay {
	background-color: <?php echo $settings->cover_overlay_hover_bg; ?>;
}
.fl-node-<?php echo $id; ?> .pp-album-container-wrap {
	width: <?php echo $settings->cover_width;?>px;
	margin: 0 auto;
	cursor: pointer;
}
.fl-node-<?php echo $id; ?> .pp-album-cover-wrap {
	height: <?php echo $settings->cover_height;?>px;
}
.fl-node-<?php echo $id; ?> .pp-album-content-wrap {
	align-items: <?php echo $settings->horizontal_align; ?>;
	justify-content: <?php echo $settings->vertical_align; ?>;
}
.fl-node-<?php echo $id; ?> .pp-album-container-wrap.pp-trigger-button {
    width: 100%;
    display: flex;
    justify-content: <?php echo $settings->btn_align; ?>;
}
<?php
// Content Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'content_padding',
	'selector' 		=> ".fl-node-$id .pp-album-content",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'content_padding_top',
		'padding-right' 	=> 'content_padding_right',
		'padding-bottom' 	=> 'content_padding_bottom',
		'padding-left' 		=> 'content_padding_left',
	),
) );
// Content Margin
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'content_margin',
	'selector' 		=> ".fl-node-$id .pp-album-content",
	'unit'			=> 'px',
	'props'			=> array(
		'margin-top' 		=> 'content_margin_top',
		'margin-right' 		=> 'content_margin_right',
		'margin-bottom'		=> 'content_margin_bottom',
		'margin-left' 		=> 'content_margin_left',
	),
) );
// Content Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'content_border',
	'selector' 		=> ".fl-node-$id .pp-album-content",
) );
// Content Hover Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'content_hover_border',
	'selector' 		=> ".fl-node-$id .pp-album-container-wrap:hover .pp-album-content",
) );
?>
.fl-node-<?php echo $id; ?> .pp-album-content-wrap .pp-album-content {
	background-color: <?php echo $settings->content_bg ? pp_get_color_value( $settings->content_bg ) : 'transparent'; ?>;
	text-align: <?php echo $settings->content_text_align;?>;
	transition: all 0.4s ease-in-out;
}
<?php if( isset($settings->content_bg) ) {?>
.fl-node-<?php echo $id; ?> .pp-album-container-wrap:hover .pp-album-content {
	background-color: <?php echo pp_get_color_value( $settings->content_hover_bg ); ?>;
}
<?php } ?>
.fl-node-<?php echo $id; ?> .pp-album-content.pp-album-cover-button-position-inline {
	align-items: <?php echo $settings->inline_button_pos; ?>;
}

.fl-node-<?php echo $id; ?> .pp-album-icon {
	color: <?php echo pp_get_color_value( $settings->content_icon_color ); ?>;
	margin-bottom: <?php echo $settings->content_icon_spacing; ?>px;
	font-size: <?php echo $settings->content_icon_size; ?>px;
	transition: all 0.4s ease-in-out;
}
<?php if( isset($settings->content_icon_color_h) ) {?>
.fl-node-<?php echo $id; ?> .pp-album-container-wrap:hover .pp-album-content .pp-album-icon {
	color: <?php echo pp_get_color_value( $settings->content_icon_color_h ); ?>;
}
<?php } ?>
<?php
// Title Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'content_title_typo',
	'selector' 		=> ".fl-node-$id .pp-album-title",
) );
// Subtitle Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'content_subtitle_typo',
	'selector' 		=> ".fl-node-$id .pp-album-subtitle",
) );
// Button Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'content_button_typo',
	'selector' 		=> ".fl-node-$id .pp-album-cover-button-wrap",
) );
?>
.fl-node-<?php echo $id; ?> .pp-album-title {
	color: <?php echo pp_get_color_value( $settings->content_title_color ); ?>;
	margin-bottom: <?php echo $settings->content_title_spacing; ?>px;
	transition: all 0.4s ease-in-out;
}
<?php if( isset($settings->content_title_color_h) ) {?>
.fl-node-<?php echo $id; ?> .pp-album-container-wrap:hover .pp-album-content .pp-album-title {
	color: <?php echo pp_get_color_value( $settings->content_title_color_h ); ?>;
}
<?php } ?>
.fl-node-<?php echo $id; ?> .pp-album-subtitle {
	color: <?php echo pp_get_color_value( $settings->content_subtitle_color ); ?>;
	transition: all 0.4s ease-in-out;
}
<?php if( isset($settings->content_subtitle_color_h) ) {?>
.fl-node-<?php echo $id; ?> .pp-album-container-wrap:hover .pp-album-content .pp-album-subtitle {
	color: <?php echo pp_get_color_value( $settings->content_subtitle_color_h ); ?>;
}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-album-cover-button-wrap {
	color: <?php echo pp_get_color_value( $settings->content_button_color ); ?>;
	background-color: <?php echo pp_get_color_value( $settings->content_button_bg ); ?>;
	transition: all 0.4s ease-in-out;
}
.fl-node-<?php echo $id; ?> .pp-album-content .pp-album-cover-button-wrap:hover {
	color: <?php echo pp_get_color_value( $settings->content_button_hover_color ); ?>;
	background-color: <?php echo pp_get_color_value( $settings->content_button_hover_bg ); ?>;
	border-color: <?php echo pp_get_color_value( $settings->content_button_hover_border ); ?>;
}
<?php
// Content Button Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'content_button_padding',
	'selector' 		=> ".fl-node-$id .pp-album-cover-button-wrap",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'content_button_padding_top',
		'padding-right' 	=> 'content_button_padding_right',
		'padding-bottom' 	=> 'content_button_padding_bottom',
		'padding-left' 		=> 'content_button_padding_left',
	),
) );
// Content Button Margin
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'content_button_margin',
	'selector' 		=> ".fl-node-$id .pp-album-cover-button-wrap",
	'unit'			=> 'px',
	'props'			=> array(
		'margin-top' 		=> 'content_button_margin_top',
		'margin-right' 		=> 'content_button_margin_right',
		'margin-bottom'		=> 'content_button_margin_bottom',
		'margin-left' 		=> 'content_button_margin_left',
	),
) );
// Content Button Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'content_button_border',
	'selector' 		=> ".fl-node-$id .pp-album-cover-button-wrap",
) );
?>


<?php // Trigger Button 
$iconCss 	= 'display: flex;';
$iconSpace 	= $settings->icon_spacing . 'px';

if( 'left' == $settings->cover_btn_align ){
	if( 'top' == $settings->icon_position ){
		$iconCss .= 'flex-direction: column-reverse;';
		$iconCss .= 'align-items: flex-start;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-bottom:'. $iconSpace . ';}';

	}elseif( 'bottom' == $settings->icon_position ){
		$iconCss .= 'flex-direction: column;';
		$iconCss .= 'align-items: flex-start;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-top:'. $iconSpace . ';}';

	}elseif( 'left' == $settings->icon_position ){
		$iconCss .= 'flex-direction: row-reverse;';
		$iconCss .= 'align-items: center;';
		$iconCss .= 'justify-content: flex-end;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-right:'. $iconSpace . ';}';
		
	}elseif( 'right' == $settings->icon_position ){
		$iconCss .= 'flex-direction: row;';
		$iconCss .= 'align-items: center;';
		$iconCss .= 'justify-content: flex-start;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-left:'. $iconSpace . ';}';

	}
}elseif( 'center' == $settings->cover_btn_align ){
	if( 'top' == $settings->icon_position ){
		$iconCss .= 'flex-direction: column-reverse;';
		$iconCss .= 'align-items: center;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-bottom:'. $iconSpace . ';}';

	}elseif( 'bottom' == $settings->icon_position ){
		$iconCss .= 'flex-direction: column;';
		$iconCss .= 'align-items: center;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-top:'. $iconSpace . ';}';

	}elseif( 'left' == $settings->icon_position ){
		$iconCss .= 'flex-direction: row-reverse;';
		$iconCss .= 'align-items: center;';
		$iconCss .= 'justify-content: center;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-right:'. $iconSpace . ';}';

	}elseif( 'right' == $settings->icon_position ){
		$iconCss .= 'flex-direction: row;';
		$iconCss .= 'align-items: center;';
		$iconCss .= 'justify-content: center;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-left:'. $iconSpace . ';}';

	}
}elseif( 'right' == $settings->cover_btn_align ){
	if( 'top' == $settings->icon_position ){
		$iconCss .= 'flex-direction: column-reverse;';
		$iconCss .= 'align-items: flex-end;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-bottom:'. $iconSpace . ';}';

	}elseif( 'bottom' == $settings->icon_position ){
		$iconCss .= 'flex-direction: column;';
		$iconCss .= 'align-items: flex-end;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-top:'. $iconSpace . ';}';

	}elseif( 'left' == $settings->icon_position ){
		$iconCss .= 'flex-direction: row-reverse;';
		$iconCss .= 'align-items: center;';
		$iconCss .= 'justify-content: flex-start;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-right:'. $iconSpace . ';}';

	}elseif( 'right' == $settings->icon_position ){
		$iconCss .= 'flex-direction: row;';
		$iconCss .= 'align-items: center;';
		$iconCss .= 'justify-content: flex-end;';
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-left:'. $iconSpace . ';}';

	}
}
?>
.fl-node-<?php echo $id; ?> .pp-album-button-content {
	width: <?php echo $settings->btn_max_width;?>px;
	margin: 0 auto;
}
.fl-node-<?php echo $id; ?> .pp-album-button-inner {
	<?php echo $iconCss;?>;
	color: <?php echo pp_get_color_value( $settings->trigger_button_color ); ?> !important;
	background-color: <?php echo pp_get_color_value( $settings->trigger_button_bg ); ?>;
	transition: all 0.4s ease-in-out;
}

.fl-node-<?php echo $id; ?> .pp-album-button-inner:hover {
	color: <?php echo pp_get_color_value( $settings->trigger_button_hover_color ); ?> !important;
	background-color: <?php echo pp_get_color_value( $settings->trigger_button_hover_bg ); ?>;
	border-color: <?php echo pp_get_color_value( $settings->trigger_button_hover_border ); ?>;
}
.fl-node-<?php echo $id; ?> .pp-album-button-content i {
	font-size: <?php echo $settings->trigger_icon_size;?>px;
	color: <?php echo pp_get_color_value( $settings->trigger_icon_color ); ?>;
	transition: all 0.4s ease-in-out;
}
.fl-node-<?php echo $id; ?> .pp-album-button-inner:hover i {
	color: <?php echo pp_get_color_value( $settings->trigger_icon_hover_color ); ?>;
}
<?php
// Trigger Button Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'trigger_button_padding',
	'selector' 		=> ".fl-node-$id .pp-album-button-inner",
	'unit'			=> 'px',
	'props'			=> array(
		'padding-top' 		=> 'trigger_button_padding_top',
		'padding-right' 	=> 'trigger_button_padding_right',
		'padding-bottom' 	=> 'trigger_button_padding_bottom',
		'padding-left' 		=> 'trigger_button_padding_left',
	),
) );
// Trigger Button Border - Settings
FLBuilderCSS::border_field_rule( array(
	'settings' 		=> $settings,
	'setting_name' 	=> 'trigger_button_border',
	'selector' 		=> ".fl-node-$id .pp-album-button-inner",
) );
// Trigger Button Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'trigger_button_typo',
	'selector' 		=> ".fl-node-$id .pp-album-button-inner",
) );
?>

@media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-album-container-wrap {
		width: <?php echo $settings->cover_width_medium;?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-album-cover-wrap {
		height: <?php echo $settings->cover_height_medium;?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-album-icon {
		margin-bottom: <?php echo $settings->content_icon_spacing_medium; ?>px;
		font-size: <?php echo $settings->content_icon_size_medium; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-album-title {
		margin-bottom: <?php echo $settings->content_title_spacing_medium; ?>px;
	}
	<?php // Trigger Button
	$iconSpace_medium 	= $settings->icon_spacing_medium . 'px';
	if( 'top' == $settings->icon_position ){
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-bottom:'. $iconSpace_medium . ';}';
	}elseif( 'bottom' == $settings->icon_position ){
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-top:'. $iconSpace_medium . ';}';
	}elseif( 'left' == $settings->icon_position ){
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-right:'. $iconSpace_medium . ';}';
	}elseif( 'right' == $settings->icon_position ){
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-left:'. $iconSpace_medium . ';}';
	}
	?>
	.fl-node-<?php echo $id; ?> .pp-album-button-content {
		max-width: <?php echo $settings->btn_max_width_medium;?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-album-button-content i {
		font-size: <?php echo $settings->trigger_icon_size_medium;?>px;
	}
}
@media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
	.fl-node-<?php echo $id; ?> .pp-album-container-wrap {
		width: <?php echo $settings->cover_width_responsive;?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-album-cover-wrap {
		height: <?php echo $settings->cover_height_responsive;?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-album-icon {
		margin-bottom: <?php echo $settings->content_icon_spacing_responsive; ?>px;
		font-size: <?php echo $settings->content_icon_size_responsive; ?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-album-title {
		margin-bottom: <?php echo $settings->content_title_spacing_responsive; ?>px;
	}
	<?php // Trigger Button
	$iconSpace_responsive 	= $settings->icon_spacing_responsive . 'px';
	if( 'top' == $settings->icon_position ){
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-bottom:'. $iconSpace_responsive . ';}';
	}elseif( 'bottom' == $settings->icon_position ){
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-top:'. $iconSpace_responsive . ';}';
	}elseif( 'left' == $settings->icon_position ){
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-right:'. $iconSpace_responsive . ';}';
	}elseif( 'right' == $settings->icon_position ){
		echo '.fl-node-' . $id . ' .pp-album-button-content i { margin-left:'. $iconSpace_responsive . ';}';
	}
	?>
	.fl-node-<?php echo $id; ?> .pp-album-button-content {
		max-width: <?php echo $settings->btn_max_width_responsive;?>px;
	}
	.fl-node-<?php echo $id; ?> .pp-album-button-content i {
		font-size: <?php echo $settings->trigger_icon_size_responsive;?>px;
	}
}
.fancybox-is-open.pp-fancybox-<?php echo $id; ?> .fancybox-bg {
	background-color: <?php echo pp_get_color_value( $settings->lightbox_bg_color ); ?>;
	opacity: <?php echo $settings->lightboxbg_opacity; ?>;
}
.fancybox-is-open.pp-fancybox-<?php echo $id; ?> .fancybox-thumbs {
	background-color: <?php echo pp_get_color_value( $settings->thumbs_bg_color ); ?>;
}