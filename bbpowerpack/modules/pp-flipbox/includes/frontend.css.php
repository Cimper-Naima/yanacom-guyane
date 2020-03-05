.fl-node-<?php echo $id; ?> .pp-flipbox {
	<?php if( $settings->box_border_style != 'none' ) { ?>
	border-style: <?php echo $settings->box_border_style; ?>;
	border-width: <?php echo $settings->box_border_width; ?>px;
	<?php } ?>
	<?php if( $settings->top_padding ) { ?>padding: <?php echo $settings->top_padding; ?>px <?php echo $settings->side_padding; ?>px;<?php } ?>
	<?php if ( $settings->box_height == 'custom' ) { ?>
		height: <?php echo $settings->box_height_custom; ?>px;
	<?php } ?>
}

/* Front */
.fl-node-<?php echo $id; ?> .pp-flipbox-front {
	<?php if( $settings->front_background ) { ?>background: <?php echo pp_get_color_value($settings->front_background); ?>;<?php } ?>
	<?php if( $settings->front_border_color ) { ?>border-color: #<?php echo $settings->front_border_color; ?>;<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-flipbox-front .pp-flipbox-title .pp-flipbox-front-title {
	<?php if( $settings->front_title_color ) { ?>color: #<?php echo $settings->front_title_color; ?>;<?php } ?>
	margin-top: <?php echo $settings->front_title_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->front_title_margin['bottom']; ?>px;
}

<?php
	// Front Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'front_title_typography',
		'selector' 		=> ".fl-node-$id .pp-flipbox-front .pp-flipbox-title .pp-flipbox-front-title",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-flipbox-front .pp-flipbox-description {
	<?php if( $settings->front_text_color ) { ?>color: #<?php echo $settings->front_text_color; ?>;<?php } ?>
	margin-top: <?php echo $settings->front_text_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->front_text_margin['bottom']; ?>px;
}

<?php
	// Front Text Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'front_text_typography',
		'selector' 		=> ".fl-node-$id .pp-flipbox-front .pp-flipbox-description",
	) );
?>

/* Back */
.fl-node-<?php echo $id; ?> .pp-flipbox-back {
	<?php if( $settings->back_background ) { ?>background: <?php echo pp_get_color_value($settings->back_background); ?>;<?php } ?>
	<?php if( $settings->back_border_color ) { ?>border-color: #<?php echo $settings->back_border_color; ?>;<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-flipbox-back .pp-flipbox-title .pp-flipbox-back-title {
	<?php if( $settings->back_title_color ) { ?>color: #<?php echo $settings->back_title_color; ?>;<?php } ?>
	margin-top: <?php echo $settings->back_title_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->back_title_margin['bottom']; ?>px;
}

<?php
	// Back Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'back_title_typography',
		'selector' 		=> ".fl-node-$id .pp-flipbox-back .pp-flipbox-title .pp-flipbox-back-title",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-flipbox-back .pp-flipbox-description {
	<?php if( $settings->back_text_color ) { ?>color: #<?php echo $settings->back_text_color; ?>;<?php } ?>
	margin-top: <?php echo $settings->back_text_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->back_text_margin['bottom']; ?>px;
}

<?php
	// Back Text Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'back_text_typography',
		'selector' 		=> ".fl-node-$id .pp-flipbox-back .pp-flipbox-description",
	) );
?>

<?php if( $settings->icon_type == 'icon' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-flipbox-icon {
		<?php if( $settings->show_border == 'yes' ) { ?>
			<?php if( $settings->icon_border_color ) { ?>border-color: #<?php echo $settings->icon_border_color; ?>;<?php } ?>
			<?php if( $settings->icon_border_radius ) { ?>border-radius: <?php echo $settings->icon_border_radius; ?>px;<?php } ?>
			<?php if( $settings->icon_border_width ) { ?>border-width: <?php echo $settings->icon_border_width; ?>px;<?php } ?>
		<?php } ?>
		<?php if( $settings->icon_box_size ) { ?>padding: <?php echo $settings->icon_box_size; ?>px;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-flipbox-icon-inner {
		<?php if( $settings->icon_background ) { ?>background: #<?php echo $settings->icon_background; ?>;<?php } ?>
		<?php if( ( $settings->show_border == 'yes' && $settings->icon_border_radius ) || ( $settings->icon_background && $settings->icon_border_radius ) ) { ?>
			<?php if( $settings->icon_border_radius ) { ?>border-radius: <?php echo $settings->icon_border_radius; ?>px;<?php } ?>
		<?php } ?>
		<?php if( $settings->icon_color ) { ?>color: #<?php echo $settings->icon_color; ?>;<?php } ?>
	}
	<?php
		// Icon - Font Size
		FLBuilderCSS::responsive_rule( array(
			'settings'		=> $settings,
			'setting_name'	=> 'icon_font_size',
			'selector'		=> ".fl-node-$id .pp-flipbox-icon-inner, .fl-node-$id .pp-flipbox-icon-inner span.pp-icon, .fl-node-$id .pp-flipbox-icon-inner span.pp-icon:before",
			'prop'			=> 'font-size',
			'unit'			=> 'px',
		) );

		// Icon - Width
		FLBuilderCSS::responsive_rule( array(
			'settings'		=> $settings,
			'setting_name'	=> 'icon_width',
			'selector'		=> ".fl-node-$id .pp-flipbox-icon-inner",
			'prop'			=> 'width',
			'unit'			=> 'px',
		) );

		FLBuilderCSS::responsive_rule( array(
			'settings'		=> $settings,
			'setting_name'	=> 'icon_width',
			'selector'		=> ".fl-node-$id .pp-flipbox-icon-inner",
			'prop'			=> 'height',
			'unit'			=> 'px',
		) );
	?>
	.fl-node-<?php echo $id; ?> .pp-flipbox-icon:hover {
		<?php if( $settings->show_border == 'yes' ) { ?>
		<?php if( $settings->icon_border_color_hover ) { ?>	border-color: #<?php echo $settings->icon_border_color_hover; ?>;<?php } ?>
		<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-flipbox-icon-inner:hover {
		<?php if( $settings->icon_background_hover ) { ?>background: #<?php echo $settings->icon_background_hover; ?>;<?php } ?>
		<?php if( $settings->icon_color_hover ) { ?>color: #<?php echo $settings->icon_color_hover; ?>;<?php } ?>
	}
<?php } ?>
<?php if( $settings->icon_type == 'image' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-flipbox-image img {
		<?php if( $settings->show_border == 'yes' ) { ?>
			<?php if( $settings->icon_border_color ) { ?>border-color: #<?php echo $settings->icon_border_color; ?>;<?php } ?>
			<?php if( $settings->icon_border_width ) { ?>border-width: <?php echo $settings->icon_border_width; ?>px;<?php } ?>
		<?php } ?>
		<?php if( $settings->icon_border_radius ) { ?>border-radius: <?php echo $settings->icon_border_radius; ?>px;<?php } ?>
		<?php if( $settings->icon_box_size ) { ?>padding: <?php echo $settings->icon_box_size; ?>px;<?php } ?>
	}
	<?php
		// Icon - Width
		FLBuilderCSS::responsive_rule( array(
			'settings'		=> $settings,
			'setting_name'	=> 'image_width',
			'selector'		=> ".fl-node-$id .pp-flipbox-image img",
			'prop'			=> 'width',
			'unit'			=> 'px',
		) );

		FLBuilderCSS::responsive_rule( array(
			'settings'		=> $settings,
			'setting_name'	=> 'image_width',
			'selector'		=> ".fl-node-$id .pp-flipbox-image img",
			'prop'			=> 'height',
			'unit'			=> 'px',
		) );
	?>
	.fl-node-<?php echo $id; ?> .pp-flipbox-image img:hover {
		<?php if( $settings->show_border == 'yes' ) { ?>
			<?php if( $settings->icon_border_color_hover ) { ?>border-color: #<?php echo $settings->icon_border_color_hover; ?>;<?php } ?>
		<?php } ?>
	}
<?php } ?>

<?php if( $settings->link_type == 'custom' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-flipbox .pp-more-link {
		<?php if( $settings->link_background ) { ?>background: <?php echo pp_get_color_value($settings->link_background); ?>;<?php } ?>
		<?php if( $settings->link_color ) { ?>color: #<?php echo $settings->link_color; ?>;<?php } ?>
	}
	<?php
		// More Link - Padding
		FLBuilderCSS::dimension_field_rule( array(
			'settings'		=> $settings,
			'setting_name' 	=> 'link_padding',
			'selector' 		=> ".fl-node-$id .pp-flipbox .pp-more-link",
			'unit'			=> 'px',
			'props'			=> array(
				'padding-top' 		=> 'link_padding_top',
				'padding-right' 	=> 'link_padding_right',
				'padding-bottom' 	=> 'link_padding_bottom',
				'padding-left' 		=> 'link_padding_left',
			),
		) );
		
		// More Link Typography
		FLBuilderCSS::typography_field_rule( array(
			'settings'		=> $settings,
			'setting_name' 	=> 'link_typography',
			'selector' 		=> ".fl-node-$id .pp-flipbox-back .pp-more-link",
		) );
	?>
	
	.fl-node-<?php echo $id; ?> .pp-flipbox .pp-more-link:hover {
		<?php if( $settings->link_background_hover ) { ?>background: <?php echo pp_get_color_value($settings->link_background_hover); ?>;<?php } ?>
		<?php if( $settings->link_color_hover ) { ?>color: #<?php echo $settings->link_color_hover; ?>;<?php } ?>
	}
<?php } ?>

/* Flips */
.fl-node-<?php echo $id; ?> .pp-flipbox {
	<?php if( $settings->flip_duration ) { ?>transition-duration: <?php echo $settings->flip_duration; ?>ms;<?php } ?>
}

