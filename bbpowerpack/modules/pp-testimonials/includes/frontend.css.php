.fl-node-<?php echo $id; ?> .pp-testimonials-wrap .bx-wrapper .bx-pager a {
	<?php if( $settings->dot_color ) { ?>background: <?php echo pp_get_color_value($settings->dot_color); ?>;<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-testimonials-wrap .bx-wrapper .bx-pager a {
	opacity: 0.5;
}
.fl-node-<?php echo $id; ?> .pp-testimonials-wrap .bx-wrapper .bx-pager a.active {
	<?php if( $settings->active_dot_color ) { ?>background: <?php echo pp_get_color_value($settings->active_dot_color); ?>;<?php } ?>
	opacity: 1;
}
.fl-node-<?php echo $id; ?> .pp-testimonials-wrap .fa:hover,
.fl-node-<?php echo $id; ?> .pp-testimonials-wrap .fa {
	<?php if( $settings->arrow_color ) { ?>color: <?php echo pp_get_color_value($settings->arrow_color); ?>;<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-testimonials-wrap .pp-arrow-wrapper {
	<?php if( $settings->arrow_alignment ) { ?>text-align: <?php echo $settings->arrow_alignment; ?>;<?php } ?>
}

<?php if( $settings->layout_4_content_bg || $settings->box_border['width']['top'] != 0 ) { ?>
	.fl-node-<?php echo $id; ?> .pp-testimonials .pp-content-wrapper {
		padding: 20px;
	}
<?php } ?>

<?php if( $settings->testimonial_layout == '1' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-testimonial.layout-1 .pp-content-wrapper {
		<?php if( $settings->layout_4_content_bg ) { ?>background: <?php echo pp_get_color_value($settings->layout_4_content_bg); ?>;<?php } ?>
	}
	<?php if( $settings->show_arrow == 'yes' ) { ?>
		.fl-node-<?php echo $id; ?> .pp-testimonial.layout-1 .pp-arrow-top {
			<?php if( $settings->layout_4_content_bg ) { ?>border-bottom-color: <?php echo pp_get_color_value($settings->layout_4_content_bg); ?>;<?php } ?>
		}
	<?php } ?>
<?php } ?>
<?php if( $settings->testimonial_layout == '2' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-testimonial.layout-2 .pp-content-wrapper {
		<?php if( $settings->layout_4_content_bg ) { ?>background: <?php echo pp_get_color_value($settings->layout_4_content_bg); ?>;<?php } ?>
	}
	<?php if( $settings->show_arrow == 'yes' ) { ?>
		.fl-node-<?php echo $id; ?> .pp-testimonial.layout-2 .pp-arrow-bottom {
			<?php if( $settings->layout_4_content_bg ) { ?>border-top-color: <?php echo pp_get_color_value($settings->layout_4_content_bg); ?>;<?php } ?>
		}
	<?php } ?>
<?php } ?>
<?php if( $settings->testimonial_layout == '3' ) {
	$wd = $settings->image_size + 30; ?>
	.fl-node-<?php echo $id; ?> .pp-testimonial.layout-3 .pp-content-wrapper {
		width: calc(100% - <?php echo $wd; ?>px);
		<?php if( $settings->layout_4_content_bg ) { ?>background: <?php echo pp_get_color_value($settings->layout_4_content_bg); ?>;<?php } ?>
	}
	<?php if( $settings->show_arrow == 'yes' ) { ?>
		.fl-node-<?php echo $id; ?> .pp-testimonial.layout-3 .pp-arrow-left {
			<?php if( $settings->layout_4_content_bg ) { ?>border-right-color: <?php echo pp_get_color_value($settings->layout_4_content_bg); ?>;<?php } ?>
		}
	<?php } ?>
	.fl-node-<?php echo $id; ?> .pp-testimonials .layout-3 .pp-testimonials-image {
		max-height: <?php echo $settings->image_size; ?>px;
		max-width: <?php echo $settings->image_size; ?>px;
	}

<?php } ?>
<?php if( $settings->testimonial_layout == '4' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-testimonial.layout-4 .layout-4-content {
		<?php if( $settings->layout_4_content_bg ) { ?>background: <?php echo pp_get_color_value($settings->layout_4_content_bg); ?>;<?php } ?>
	}
<?php } ?>
<?php if( $settings->testimonial_layout == '5' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-testimonial.layout-5 .pp-content-wrapper {
		<?php if( $settings->layout_4_content_bg ) { ?>background: <?php echo pp_get_color_value($settings->layout_4_content_bg); ?>;<?php } ?>
	}
	<?php if( $settings->show_arrow == 'yes' ) { ?>
		.fl-node-<?php echo $id; ?> .pp-testimonial.layout-5 .pp-arrow-top {
			<?php if( $settings->layout_4_content_bg ) { ?>border-bottom-color: <?php echo pp_get_color_value($settings->layout_4_content_bg); ?>;<?php } ?>
		}
	<?php } ?>
<?php } ?>

<?php
	// Box - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'box_border',
		'selector' 		=> ".fl-node-$id .pp-testimonial.layout-1 .pp-content-wrapper, .fl-node-$id .pp-testimonial.layout-2 .pp-content-wrapper, .fl-node-$id .pp-testimonial.layout-3 .pp-content-wrapper, .fl-node-$id .pp-testimonial.layout-4 .layout-4-content, .fl-node-$id .pp-testimonial.layout-5 .pp-content-wrapper",
	) );
?>

.fl-node-<?php echo $id; ?> .pp-testimonials-wrap .pp-testimonials-heading {
	<?php if( $settings->heading_color ) { ?>color: #<?php echo $settings->heading_color; ?>;<?php } ?>
}
<?php
	// Heading Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'heading_typography',
		'selector' 		=> ".fl-node-$id .pp-testimonials-wrap .pp-testimonials-heading",
	) );
?>
.fl-node-<?php echo $id; ?> .pp-testimonial .pp-title-wrapper h3.pp-testimonials-title {
	<?php if( $settings->title_color ) { ?>color: #<?php echo $settings->title_color; ?>;<?php } ?>
	margin-top: <?php echo $settings->title_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->title_margin['bottom']; ?>px;
}
<?php
	// Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'title_typography',
		'selector' 		=> ".fl-node-$id .pp-testimonial .pp-title-wrapper h3.pp-testimonials-title",
	) );
?>
.fl-node-<?php echo $id; ?> .pp-testimonial .pp-title-wrapper h4.pp-testimonials-subtitle {
	<?php if( $settings->subtitle_color ) { ?>color: #<?php echo $settings->subtitle_color; ?>;<?php } ?>
	margin-top: <?php echo $settings->subtitle_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->subtitle_margin['bottom']; ?>px;
}
<?php
	// Sub Title Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'subtitle_typography',
		'selector' 		=> ".fl-node-$id .pp-testimonial .pp-title-wrapper h4.pp-testimonials-subtitle",
	) );
?>
.fl-node-<?php echo $id; ?> .pp-testimonial .pp-testimonials-content {
	<?php if( $settings->text_color ) { ?>color: #<?php echo $settings->text_color; ?><?php } ?>;
	margin-top: <?php echo $settings->content_margin['top']; ?>px;
	margin-bottom: <?php echo $settings->content_margin['bottom']; ?>px;
}
<?php
	// text Typography
	FLBuilderCSS::typography_field_rule( array(
		'settings'		=> $settings,
		'setting_name' 	=> 'text_typography',
		'selector' 		=> ".fl-node-$id .pp-testimonial .pp-testimonials-content",
	) );
?>
.fl-node-<?php echo $id; ?> .pp-testimonial .pp-testimonials-image img {
	max-height: <?php echo $settings->image_size; ?>px;
	max-width: <?php echo $settings->image_size; ?>px;
}

<?php
	// Image - Border
	FLBuilderCSS::border_field_rule( array(
		'settings' 		=> $settings,
		'setting_name' 	=> 'image_border',
		'selector' 		=> ".fl-node-$id .pp-testimonial .pp-testimonials-image img",
	) );
?>