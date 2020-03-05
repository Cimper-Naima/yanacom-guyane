<?php 
// Announcement Text Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'announcement_text_typography',
	'selector' 		=> ".fl-node-$id .pp-announcement-bar-wrap .pp-announcement-bar-content p",
) );
?>
.fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap {
    background: <?php echo ($settings->announcement_bar_background) ? pp_get_color_value($settings->announcement_bar_background) : '#ffffff'; ?>;
    <?php if( $settings->announcement_bar_position == 'top' ) { ?>
        top: 0;
        border-bottom-color: <?php echo ($settings->announcement_bar_border_color) ? pp_get_color_value($settings->announcement_bar_border_color) : '#000'; ?>;
        border-bottom-style: <?php echo $settings->announcement_bar_border_type; ?>;
        border-bottom-width: <?php echo ($settings->announcement_bar_border_width >= 0) ? $settings->announcement_bar_border_width.'px' : '0'; ?>;
    <?php } ?>
    <?php if( $settings->announcement_bar_position == 'bottom' ) { ?>
        bottom: 0;
        border-top-color: <?php echo ($settings->announcement_bar_border_color) ? pp_get_color_value($settings->announcement_bar_border_color) : '#000'; ?>;
        border-top-style: <?php echo $settings->announcement_bar_border_type; ?>;
        border-top-width: <?php echo ($settings->announcement_bar_border_width >= 0) ? $settings->announcement_bar_border_width.'px' : '0'; ?>;
    <?php } ?>
    <?php if($settings->announcement_box_shadow == 'yes') { ?>
		-webkit-box-shadow: <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_h']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_v']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_blur']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_spread']; ?>px <?php echo pp_hex2rgba( '#'.$settings->announcement_box_shadow_color, $settings->announcement_box_shadow_opacity ); ?>;
		-moz-box-shadow: <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_h']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_v']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_blur']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_spread']; ?>px <?php echo pp_hex2rgba( '#'.$settings->announcement_box_shadow_color, $settings->announcement_box_shadow_opacity ); ?>;
	    -o-box-shadow: <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_h']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_v']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_blur']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_spread']; ?>px <?php echo pp_hex2rgba( '#'.$settings->announcement_box_shadow_color, $settings->announcement_box_shadow_opacity ); ?>;
	    box-shadow: <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_h']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_v']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_blur']; ?>px <?php echo $settings->announcement_box_shadow_options['announcement_box_shadow_spread']; ?>px <?php echo pp_hex2rgba( '#'.$settings->announcement_box_shadow_color, $settings->announcement_box_shadow_opacity ); ?>;
	<?php } ?>
}

<?php if( $settings->announcement_bar_position == 'top' && ! FLBuilderModel::is_builder_active() ) { ?>
    .admin-bar .fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap {
        top: 32px;
    }
<?php } ?>

<?php if ( ! FLBuilderModel::is_builder_active() ) { ?>
.fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap.pp-announcement-bar-bottom {
	opacity: 0;
    visibility: hidden;
}
.fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap.pp-announcement-bar-top {
    <?php if ( is_admin_bar_showing() ) { ?>
    margin-top: -<?php echo $settings->announcement_bar_height+146; ?>px;
    <?php } else { ?>
    margin-top: -<?php echo $settings->announcement_bar_height+100; ?>px;
    <?php } ?>
}
<?php } ?>
.pp-top-bar {
    margin-top: <?php echo $settings->announcement_bar_height; ?>px !important;
}
.pp-top-bar-admin {
    margin-top: <?php echo $settings->announcement_bar_height+32; ?>px !important;
}
.pp-top-bar .fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap.pp-announcement-bar-top {
	opacity: 1;
    margin-top: 0;
}
.pp-bottom-bar .fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap.pp-announcement-bar-bottom {
	opacity: 1;
    visibility: visible;
}
.pp-bottom-bar {
    margin-bottom: <?php echo $settings->announcement_bar_height; ?>px;
}

.fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap .pp-announcement-bar-inner {
    height: <?php echo $settings->announcement_bar_height; ?>px;
    text-align: <?php echo $settings->announcement_text_align; ?>;
}
.fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap .pp-announcement-bar-icon {
    vertical-align: middle;
}
.fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap .pp-announcement-bar-icon .pp-icon {
    color: <?php echo ($settings->announcement_icon_color) ? pp_get_color_value($settings->announcement_icon_color) : '#000'; ?>;
    font-size: <?php echo ($settings->announcement_icon_size) ? $settings->announcement_icon_size : '20'; ?>px;
}
.fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap .pp-announcement-bar-content p {
    color: <?php echo ($settings->announcement_text_color) ? pp_get_color_value($settings->announcement_text_color) : '#000'; ?>;
}
<?php
// Announcement Link Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'		=> $settings,
	'setting_name' 	=> 'announcement_link_typography',
	'selector' 		=> ".fl-node-$id .pp-announcement-bar-wrap .pp-announcement-bar-link a",
) );

if ( $settings->announcement_link_type == 'button' ) {
	// Announcement Button Border - Settings
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'announcement_button_border_group',
		'selector' 		=> ".fl-node-$id .pp-announcement-bar-wrap .pp-announcement-bar-link a",
	) );
	// Announcement Button Padding
	FLBuilderCSS::dimension_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'announcement_button_padding',
		'selector' 		=> ".fl-node-$id .pp-announcement-bar-wrap .pp-announcement-bar-link a",
		'unit'			=> 'px',
		'props'			=> array(
			'padding-top' 		=> 'announcement_button_padding_top',
			'padding-right' 	=> 'announcement_button_padding_right',
			'padding-bottom' 	=> 'announcement_button_padding_bottom',
			'padding-left' 		=> 'announcement_button_padding_left',
		),
	) );
}
?>
.fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap .pp-announcement-bar-link a {
    <?php if( $settings->announcement_link_type == 'button' ) { ?>
		<?php if( isset( $settings->announcement_button_bg_default ) && ! empty( $settings->announcement_button_bg_default ) ) { ?>
			background: <?php echo pp_get_color_value( $settings->announcement_button_bg_default ); ?>;
		<?php } ?>
    <?php } ?>
	<?php if( isset( $settings->announcement_link_color_default ) && ! empty( $settings->announcement_link_color_default ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->announcement_link_color_default ); ?>;
	<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap .pp-announcement-bar-link a:hover {
    <?php if( $settings->announcement_link_type == 'button' ) { ?>
		<?php if( isset( $settings->announcement_button_bg_hover ) && ! empty( $settings->announcement_button_bg_hover ) ) { ?>
			background: <?php echo pp_get_color_value( $settings->announcement_button_bg_hover ); ?>;
		<?php } ?>
    <?php } ?>
	<?php if( isset( $settings->announcement_link_color_hover ) && ! empty( $settings->announcement_link_color_hover ) ) { ?>
		color: <?php echo pp_get_color_value( $settings->announcement_link_color_hover ); ?>;
	<?php } ?>
}

.fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap .pp-announcement-bar-close-button .pp-close-button {
    color: <?php echo ($settings->announcement_close_color) ? pp_get_color_value($settings->announcement_close_color) : '#000'; ?>;
    font-size: <?php echo ($settings->close_size >= 0) ? $settings->close_size.'px' : '16px'; ?>;
}

@media only screen and ( max-width: 782px ) {
    .pp-top-bar-admin {
        margin-top: <?php echo $settings->announcement_bar_height+46; ?>px !important;
    }
    .logged-in.admin-bar .fl-node-<?php echo $id; ?> .pp-announcement-bar-wrap.pp-announcement-bar-top {
        top: 46px;
    }
    .pp-announcement-bar-link, .pp-announcement-bar-icon, .pp-announcement-bar-content p {
        display: inline-block;
        padding: 5px;
    }
}
