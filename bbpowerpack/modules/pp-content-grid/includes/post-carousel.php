<?php FLBuilderModel::default_settings($settings, array(
	'show_image' 		=> 'yes',
	'show_author'		=> 'yes',
	'show_date'			=> 'yes',
	'show_categories'	=> 'no',
	'meta_separator'	=> ' | ',
	'show_content'		=> 'yes',
	'content_type'		=> 'excerpt',
	'content_length'	=> 300,
	'more_link_type'	=> 'box',
	'more_link_text'	=> __('Read More', 'bb-powerpack'),
	'post_grid_filters_display' => 'no',
	'post_grid_filters'	=> 'none',
	'post_taxonomies'	=> 'none',
	'image_thumb_crop'	=> '',
	'product_rating'	=> 'yes',
	'product_price'		=> 'yes',
	'product_button'	=> 'yes',

));

?>
<div class="pp-content-post pp-content-carousel-post pp-grid-<?php echo $settings->post_grid_style_select; ?> <?php echo join( ' ', get_post_class() ); ?>" itemscope="itemscope" itemtype="<?php PPContentGridModule::schema_itemtype(); ?>">

	<?php PPContentGridModule::schema_meta(); ?>
	
	<?php if ( 'style-9' == $settings->post_grid_style_select ) {
		include $module_dir . 'includes/post-tile.php';
	} else { ?>

	<?php if( $settings->more_link_type == 'box' && ('product' != $settings->post_type || 'download' != $settings->post_type )) { ?>
		<a class="pp-post-link" href="<?php echo $permalink; ?>"></a>
	<?php } ?>

	<?php if( 'style-1' == $settings->post_grid_style_select ) { ?>

	<<?php echo $settings->title_tag; ?> class="pp-content-grid-title pp-post-title" itemprop="headline">
		<?php if( $settings->more_link_type == 'button' || $settings->more_link_type == 'title' || $settings->more_link_type == 'title_thumb' ) { ?>
			<a href="<?php echo $permalink; ?>">
		<?php } ?>
			<?php the_title(); ?>
		<?php if( $settings->more_link_type == 'button' || $settings->more_link_type == 'title' || $settings->more_link_type == 'title_thumb' ) { ?>
			</a>
		<?php } ?>
	</<?php echo $settings->title_tag; ?>>

	<div class="pp-content-post-meta pp-post-meta">
		<?php if($settings->show_author == 'yes' ) : ?>
			<span class="pp-content-post-author">
			<?php

			printf(
				_x( 'By %s', '%s stands for author name.', 'bb-powerpack' ),
				'<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '"><span>' . get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ) . '</span></a>'
			);

			?>
			</span>
		<?php endif; ?>
		<?php if($settings->show_date == 'yes' && 'style-5' != $settings->post_grid_style_select ) : ?>
			<?php if($settings->show_author == 'yes' ) : ?>
				<span> <?php echo $settings->meta_separator; ?> </span>
			<?php endif; ?>
			<span class="pp-content-grid-date">
				<?php echo get_the_date(); ?>
			</span>
		<?php endif; ?>

	</div>

	<?php } ?>

	<?php if($settings->show_image == 'yes') : ?>
		<?php include $module->dir . 'includes/templates/post-image.php'; ?>
	<?php endif; ?>

	<div class="pp-content-carousel-inner pp-content-body">

		<?php if('style-5' == $settings->post_grid_style_select && 'yes' == $settings->show_date) { ?>
		<div class="pp-content-post-date pp-post-meta">
			<span class="pp-post-day"><?php echo get_the_date('d'); ?></span>
			<span class="pp-post-month"><?php echo get_the_date('M'); ?></span>
		</div>
		<?php } ?>

		<div class="pp-content-post-data">

			<?php if( 'style-1' != $settings->post_grid_style_select && 'style-4' != $settings->post_grid_style_select ) { ?>
				<<?php echo $settings->title_tag; ?> class="pp-content-carousel-title pp-post-title" itemprop="headline">
					<?php if( $settings->more_link_type == 'button' || $settings->more_link_type == 'title' || $settings->more_link_type == 'title_thumb' ) { ?>
						<a href="<?php echo $permalink; ?>">
					<?php } ?>
						<?php the_title(); ?>
					<?php if( $settings->more_link_type == 'button' || $settings->more_link_type == 'title' || $settings->more_link_type == 'title_thumb' ) { ?>
						</a>
					<?php } ?>
				</<?php echo $settings->title_tag; ?>>
				<?php if( 'style-2' == $settings->post_grid_style_select ) { ?>
					<span class="pp-post-title-divider"></span>
				<?php } ?>
			<?php } ?>

		<?php if(($settings->show_author == 'yes' || $settings->show_date == 'yes' || $settings->show_categories == 'yes')
				&& ('style-1' != $settings->post_grid_style_select) ) : ?>

		<div class="pp-content-post-meta pp-post-meta">
			<?php if($settings->show_author == 'yes' ) : ?>
				<span class="pp-content-post-author">
				<?php

				printf(
					_x( 'By %s', '%s stands for author name.', 'bb-powerpack' ),
					'<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '"><span>' . get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ) . '</span></a>'
				);

				?>
				</span>
			<?php endif; ?>

				<?php if($settings->show_date == 'yes' && 'style-5' != $settings->post_grid_style_select && 'style-6' != $settings->post_grid_style_select ) : ?>
					<?php if($settings->show_author == 'yes'  ) : ?>
						<span> <?php echo $settings->meta_separator; ?> </span>
					<?php endif; ?>
					<span class="pp-content-carousel-date">
						<?php echo get_the_date(); ?>
					</span>
				<?php endif; ?>

				<?php if( 'style-6' == $settings->post_grid_style_select || 'style-5' == $settings->post_grid_style_select ) : ?>
					<?php if($settings->show_author == 'yes' && $settings->show_categories == 'yes' && taxonomy_exists($settings->post_taxonomies) && !empty($terms_list) ) : ?>
						<span> <?php echo $settings->meta_separator; ?> </span>
					<?php endif; ?>
					<?php if($settings->show_categories == 'yes') { ?>
					<span class="pp-content-post-category">
						<?php if(taxonomy_exists($settings->post_taxonomies)) { ?>
							<?php $i = 1;
							foreach ($terms_list as $term):
								?>
							<?php if( $i == count($terms_list) ) { ?>
								<a href="<?php echo get_term_link($term); ?>" class="pp-post-meta-term"><?php echo $term->name; ?></a>
							<?php } else { ?>
								<a href="<?php echo get_term_link($term); ?>" class="pp-post-meta-term"><?php echo $term->name; ?></a> <?php echo ! empty( $settings->meta_separator ) ? $settings->meta_separator : '/'; ?>
							<?php } ?>
							<?php $i++; endforeach; ?>
						<?php } ?>
					</span>
					<?php } ?>
				<?php endif; ?>

			</div>
			<?php endif; ?>

			<?php if( $settings->post_type == 'product' && $settings->product_rating == 'yes' && class_exists( 'WooCommerce' ) ) { ?>
				<?php include $module->dir . 'includes/templates/product-rating.php'; ?>
			<?php } ?>

			<?php if ( 'tribe_events' == $settings->post_type && ( class_exists( 'Tribe__Events__Main' ) && class_exists( 'FLThemeBuilderLoader' ) ) ) { ?>
				<?php include $module_dir . 'includes/templates/event-content.php'; ?>
			<?php } ?>

			<?php do_action( 'pp_cg_before_post_content', $post_id, $settings ); ?>

			<?php if($settings->show_content == 'yes' || $settings->show_content == 'custom') : ?>
				<?php include $module->dir . 'includes/templates/post-content.php'; ?>
			<?php endif; ?>

			<?php do_action( 'pp_cg_after_post_content', $post_id, $settings ); ?>

			<?php if( $settings->more_link_text != '' && $settings->more_link_type == 'button' && 'product' != $settings->post_type && 'download' != $settings->post_type ) :
				include $module->dir . 'includes/templates/custom-button.php';
			endif; ?>

			<?php if( ( $settings->post_type == 'product' || $settings->post_type == 'download' ) && ( $settings->product_price == 'yes' || $settings->product_button == 'yes' ) ) { ?>
				<?php if( $settings->product_price == 'yes' ) { ?>
					<?php include $module->dir . 'includes/templates/product-price.php'; ?>
				<?php } ?>

				<?php if( $settings->more_link_text != '' && $settings->more_link_type == 'button' && ( 'product' == $settings->post_type || 'download' == $settings->post_type ) ) : ?>
					<?php if ( 'no' == $settings->product_button ) :
						include $module->dir . 'includes/templates/custom-button.php';
					endif; ?>
				<?php endif; ?>

				<?php if( $settings->product_button == 'yes' ) { ?>
					<?php include $module->dir . 'includes/templates/cart-button.php'; ?>
				<?php } ?>
			<?php } ?>

			<?php if(($settings->show_categories == 'yes' && taxonomy_exists($settings->post_taxonomies) && !empty($terms_list)) && ('style-3' != $settings->post_grid_style_select && 'style-5' != $settings->post_grid_style_select && 'style-6' != $settings->post_grid_style_select) ) : ?>
				<?php include $module->dir . 'includes/templates/post-meta.php'; ?>
			<?php endif; ?>
		</div>
	</div>
	<?php } ?>
</div>
