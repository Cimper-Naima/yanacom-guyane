<?php
FLBuilderModel::default_settings($settings, array(
	'data_source'		=> is_post_type_archive() ? 'main_query' : 'custom_query',
	'post_type' 		=> 'post',
	'order_by'  		=> 'date',
	'order'     		=> 'DESC',
	'offset'    		=> 0,
	'users'     		=> '',
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
	'post_grid_filters_type'	=> 'static',
	'all_filter_label'	=> __('All', 'bb-powerpack'),
	'post_taxonomies'	=> 'none',
	'product_rating'	=> 'yes',
	'product_price'		=> 'yes',
	'product_button'	=> 'yes',
	'product_button_text'	=> __('Add to Cart', 'bb-powerpack'),
	'fallback_image'	=> 'default',
	'image_thumb_size'	=> 'large'
));

$module_dir = pp_get_module_dir('pp-content-grid');
$module_url = pp_get_module_url('pp-content-grid');

$css_class = '';

if ( $settings->match_height == 'no' ) {
	$css_class .= ' pp-masonry-active';
} else {
	$css_class .= ' pp-equal-height';
}
if ( $settings->layout == 'grid' && $settings->post_grid_filters_display == 'yes' && ! empty( $settings->post_grid_filters ) ) {
	$css_class .= ' pp-filters-active';
}

// Set custom parameteres in module settings to verify
// our module when using filter hooks.
if ( ! isset( $settings->pp_content_grid ) ) {
	$settings->pp_content_grid = true;
}
if ( ! isset( $settings->pp_content_grid_id ) ) {
	$settings->pp_content_grid_id = $id;
}
if ( ! isset( $settings->pp_post_id ) ) {
	$settings->pp_post_id = get_the_ID();
}

if ( 'acf_relationship' == $settings->data_source ) {
	$settings->post_type = 'any';
}

/**
 * Added fl_builder_loop_query_args filter to get the filtered posts
 * only for the current module when using dyanmic (AJAX) filters
 * and infinite scroll.
 * 
 * We have passed the taxonomy term and node id as parameters in
 * pagination URLs.
 * 
 * This is the only way to get the posts of a taxonomy from the next
 * page.
 */
add_filter( 'fl_builder_loop_query_args', function( $args ) {
	if ( ! isset( $_GET['filter_term'] ) ) {
		return $args;
	}
	if ( ! isset( $_GET['node_id'] ) ) {
		return $args;
	}

	if ( ! empty( $_GET['filter_term'] ) && isset( $args['settings']->pp_content_grid_id ) ) {
		if ( ! empty( $_GET['node_id'] ) && $_GET['node_id'] == $args['settings']->pp_content_grid_id ) {
			$args['tax_query'][] = array(
				'taxonomy' => $args['settings']->post_grid_filters,
				'field'    => 'slug',
				'terms'    => $_GET['filter_term']
			);
		}
	}

	return $args;
} );

if ( ! isset( $settings->offset ) || empty( $settings->offset ) ) {
	$settings->offset = 0;
}

// Save the current post, so that it can be restored later (see the end of this file).
global $post;
$initial_current_post = $post;

// Get the query data.
$query = FLBuilderLoop::query( $settings );

?>
<div class="pp-posts-wrapper">
	<?php

	// Render the posts.
	if ( $query->have_posts() ) :

		do_action( 'pp_cg_before_posts', $settings, $query );

		$css_class .= ( FLBuilderLoop::get_paged() > 0 ) ? ' pp-paged-scroll-to' : '';

		if ( 'acf_relationship' != $settings->data_source ) {
			// Post filters.
			if ( $settings->layout == 'grid' && $settings->post_grid_filters_display == 'yes' && 'none' != $settings->post_grid_filters ) {
				include $module->dir . 'includes/post-filters.php';
			}
		}

	?>

	<div class="pp-content-post-<?php echo $settings->layout; ?><?php echo $css_class; ?> clearfix" itemscope="itemscope" itemtype="http://schema.org/Blog">
		<?php if( $settings->layout == 'carousel' ) { ?>
			<div class="pp-content-posts-inner owl-carousel owl-theme">
		<?php } ?>

			<?php

			$render = true;

			while( $query->have_posts() ) {

				$query->the_post();

				$post_id 	= get_the_ID();
				$permalink 	= get_permalink();

				$terms_list = wp_get_post_terms( $post_id, $settings->post_taxonomies );
				
				if ( $settings->post_type == 'product' && function_exists( 'wc_get_product' ) ) {
					$product = wc_get_product( $post_id );
					if ( ! is_object( $product ) ) {
						$render = false;
					}
				}

				if ( $render ) {
					ob_start();

					include apply_filters( 'pp_cg_module_layout_path', $module->dir . 'includes/post-' . $settings->layout . '.php', $settings->layout, $settings );

					// Do shortcodes here so they are parsed in context of the current post.
					echo do_shortcode( ob_get_clean() );
				}
			}

			?>

			<?php if ( $settings->layout == 'grid' ) { ?>
			<div class="pp-grid-space"></div>
			<?php } ?>

		<?php if ( $settings->layout == 'carousel' ) { ?>
			</div>
		<?php } ?>
	</div>

	<div class="fl-clear"></div>

	<?php endif; ?>

	<?php

	do_action( 'pp_cg_after_posts', $settings, $query );

	// Render the pagination.
	if( $settings->layout != 'carousel' && $settings->pagination != 'none' && $query->have_posts() && $query->max_num_pages > 1 ) :

	?>

	<div class="pp-content-grid-pagination fl-builder-pagination"<?php if($settings->pagination == 'scroll' || 'load_more' == $settings->pagination) echo ' style="display:none;"'; ?>>
		<?php
		if ( 'yes' == $settings->post_grid_filters_display && 'dynamic' == $settings->post_grid_filters_type ) {
			BB_PowerPack_Post_Helper::ajax_pagination( $query, $settings );
		} else {
			BB_PowerPack_Post_Helper::pagination( $query, $settings );
		}
		?>
	</div>

	<?php if ( 'load_more' == $settings->pagination ) { ?>
		<div class="pp-content-grid-load-more">
			<a href="#" class="pp-grid-load-more-button">
			<span class="pp-grid-loader-text"><?php echo $settings->load_more_text; ?></span>
			<span class="pp-grid-loader-icon"><img src="<?php echo BB_POWERPACK_URL . 'images/spinner.gif'; ?>" /></span></a>
		</div>
	<?php } ?>
	<?php if ( 'scroll' == $settings->pagination ) { ?>
		<div class="pp-content-grid-loader" style="display: none;">
			<span class="pp-grid-loader-text"><?php _e('Loading...', 'bb-powerpack'); ?></span>
			<span class="pp-grid-loader-icon"><img src="<?php echo BB_POWERPACK_URL . 'images/spinner.gif'; ?>" /></span>
		</div>
	<?php } ?>

	<?php endif; ?>

	<?php

	do_action( 'pp_cg_after_pagination', $settings, $query );

	// Render the empty message.
	if( ! $query->have_posts() ) :

	?>
	<div class="pp-content-grid-empty">
		<p><?php echo $settings->no_results_message; ?></p>
		<?php if ( $settings->show_search == 'yes' ) : ?>
		<?php get_search_form(); ?>
		<?php endif; ?>
	</div>

	<?php

	endif;

	wp_reset_postdata();

	// Restore the original current post.
	//
	// Note that wp_reset_postdata() isn't enough because it resets the current post by using the main
	// query, but it doesn't take into account the possibility that it might have been overridden by a
	// third-party plugin in the meantime.
	//
	// Specifically, this used to cause problems with Toolset Views, when its Content Templates were used.
	$post = $initial_current_post;
	setup_postdata( $initial_current_post );

	?>
</div>
