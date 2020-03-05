<?php
FLBuilderModel::default_settings($settings, array(
	'post_type' 		=> 'post',
	'show_image' 		=> 'yes',
	'image_thumb_size'	=> 'large',
	'show_author'		=> 'yes',
	'show_date'			=> 'yes',
	'show_categories'	=> 'no',
	'meta_separator'	=> ' | ',
	'show_content'		=> 'yes',
	'content_type'		=> 'excerpt',
	'content_length'	=> 300,
	'link_type'			=> 'title',
	'show_button'		=> 'no',
	'button_text'	=> __('Read More', 'bb-powerpack'),
	'post_taxonomies'	=> 'none',
	'image_position'	=> 'above_header'
));

$terms_list = wp_get_post_terms( get_the_ID(), $settings->post_taxonomies );

$query = FLBuilderLoop::query($settings);

// Render the posts.
if($query->have_posts()) :
?>
<div class="pp-post-timeline <?php echo $settings->post_timeline_layout; ?> <?php if( $settings->post_timeline_layout == 'vertical' ) { ?><?php echo $settings->post_timeline_ver_direction; ?><?php } ?>">

	<?php if( $settings->post_timeline_layout == 'horizontal' ) { ?>
		<div id="post-timeline-slider-for-<?php echo $id; ?>" class="pp-post-timeline-slider-target pp-post-timeline-slide-navigation" post-timeline-slider-nav-for="post-timeline-slider-for-<?php echo $id; ?>">
			<?php
			while($query->have_posts()) :
			$query->the_post(); ?>

				<div class="pp-post-timeline-icon-wrapper slick-arrow">
					<div class="pp-post-timeline-icon">
						<span class="pp-timeline-icon <?php echo $settings->post_timeline_icon; ?>"></span>
					</div>
				</div>

			<?php endwhile; ?>
		</div>
	<?php } ?>

	<div class="pp-post-timeline-slider-target pp-post-timeline-content-wrapper post-timeline-slider-for-<?php echo $id; ?>">

		<?php
		while($query->have_posts()) :

		$query->the_post();

		include $module->dir . 'includes/' . $settings->post_timeline_layout . '-timeline.php';

		endwhile; ?>
	</div>
</div>
<?php

endif;

wp_reset_postdata();

?>
