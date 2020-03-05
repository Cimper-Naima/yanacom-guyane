<div class="pp-content-grid-image pp-post-image">
	<?php $featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>
    <?php if ( $featured_image_url && '' != $featured_image_url ) { ?>
		<?php if ( 'style-9' == $settings->post_grid_style_select ) { ?>
			<div class="pp-post-featured-img" style="background-image: url('<?php echo $featured_image_url; ?>');">
				<a href="<?php echo $permalink; ?>" title="<?php the_title_attribute(); ?>"></a>
			</div>
		<?php } else { ?>
			<div class="pp-post-featured-img">
				<?php FLBuilder::render_module_html( 'photo', BB_PowerPack_Post_Helper::post_image_get_settings( get_the_ID(), $settings->image_thumb_crop, $settings ) ); ?>
			</div>
		<?php } ?>
    <?php } else {
		$img_src = '';

		if ( isset( $settings->fallback_image ) && 'default' == $settings->fallback_image ) {
			$first_img = BB_PowerPack_Post_Helper::post_catch_image( get_the_content(), $settings->image_thumb_size );
        	$img_src = ( '' != $first_img ) ? $first_img : apply_filters( 'pp_cg_placeholder_img', $module_url .'/images/placeholder.jpg' );
		}
		if ( isset( $settings->fallback_image ) && 'custom' == $settings->fallback_image ) {
			$img_src = $settings->fallback_image_custom_src;
		}
        ?>
		<?php if ( ! empty( $img_src ) ) { ?>
			<?php if ( 'style-9' == $settings->post_grid_style_select ) { ?>
				<div class="pp-post-featured-img" style="background-image: url('<?php echo $img_src ?>');">
					<a href="<?php echo $permalink; ?>" title="<?php the_title_attribute(); ?>"></a>
				</div>
			<?php } else { ?>
				<div class="pp-post-featured-img">
					<?php if( $settings->more_link_type == 'button' || $settings->more_link_type == 'thumb' || $settings->more_link_type == 'title_thumb' ) { ?>
					<a href="<?php echo $permalink; ?>" title="<?php the_title_attribute(); ?>" itemprop="url">
					<?php } ?>
					<img src="<?php echo $img_src; ?>" alt="<?php echo get_the_title(); ?>" />
					<?php if( $settings->more_link_type == 'button' || $settings->more_link_type == 'thumb' || $settings->more_link_type == 'title_thumb' ) { ?>
					</a>
					<?php } ?>
				</div>
			<?php } ?>
		<?php } ?>
    <?php } ?>

	<?php if ( 'style-9' != $settings->post_grid_style_select ) { ?>
		<?php if(($settings->show_categories == 'yes' && taxonomy_exists($settings->post_taxonomies) && !empty($terms_list)) && ('style-3' == $settings->post_grid_style_select) ) : ?>
			<?php include $module_dir . 'includes/templates/post-meta.php'; ?>
		<?php endif; ?>

		<?php if( 'style-4' == $settings->post_grid_style_select ) { ?>
			<<?php echo $settings->title_tag; ?> class="pp-content-grid-title pp-post-title" itemprop="headline">
				<?php if( $settings->more_link_type == 'button' || $settings->more_link_type == 'title' || $settings->more_link_type == 'title_thumb' ) { ?>
					<a href="<?php echo $permalink; ?>">
				<?php } ?>
						<?php the_title(); ?>
				<?php if( $settings->more_link_type == 'button' || $settings->more_link_type == 'title' || $settings->more_link_type == 'title_thumb' ) { ?>
					</a>
				<?php } ?>
			</<?php echo $settings->title_tag; ?>>
		<?php } ?>

		<?php if('style-6' == $settings->post_grid_style_select && 'yes' == $settings->show_date) { ?>
		<div class="pp-content-post-date pp-post-meta">
			<span class="pp-post-month"><?php echo get_the_date('M'); ?></span>
			<span class="pp-post-day"><?php echo get_the_date('d'); ?></span>
		</div>
		<?php } ?>
	<?php } ?>
</div>
