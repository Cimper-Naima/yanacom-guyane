<?php

$layout = $settings->layout;
$layout_posts_count = $module->get_layout_posts_count( $layout );
$show_other_posts = ( isset( $settings->show_other_posts ) && 'yes' == $settings->show_other_posts ) ? true : false;
$default_posts_count = 4;

switch ( $layout ) :

	case 1:
	case 5:
		$default_posts_count = 4;
		break;

	case 2:
		$default_posts_count = 5;
		break;

	case 3:
	case 4:
		$default_posts_count = 3;
		break;

	default:
		$default_posts_count = 4;
		break;

endswitch;

$settings->posts_per_page = $default_posts_count;

if ( $show_other_posts ) {
	if ( ! empty( $settings->number_of_posts ) && is_numeric( $settings->number_of_posts ) && $settings->number_of_posts > 0 ) {
		$number_of_posts = absint( $settings->number_of_posts );
		$settings->posts_per_page += $number_of_posts;
	} else {
		$settings->posts_per_page = '-1';
	}
}
$other_posts_displayed = false;

$query = FLBuilderLoop::query( $settings );

// Render the posts.
if ( $query->have_posts() ) :

	do_action( 'pp_tiles_before_posts', $settings, $query );

?>
<div class="pp-post-tiles pp-tile-layout-<?php echo $settings->layout; ?>" itemscope="itemscope" itemtype="http://schema.org/Blog">
	<?php

	$count = 1;

	while ( $query->have_posts() ) :

		$query->the_post();

		$image_size = 'large';

		// Large size for all layout's first post.
		if ( $count == 1 ) {
			$image_size = isset( $settings->image_size_large_tile ) ? $settings->image_size_large_tile : $image_size;
		}

		// Medium size for Layout 1 - Post 2, Layout 3 - Post 2 and Post 3.
		if ( ( $count == 2 && ( $layout == 1 || $layout == 3 ) ) || ( $count == 3 && $layout == 3 ) ) {
			$image_size = isset( $settings->image_size_medium_tile ) ? $settings->image_size_medium_tile : $image_size;
		}

		// Small size for Layout 2 - Post 3 and Post 4.
		if ( ( $count == 2 || $count == 4 ) && $layout == 2 ) {
			$image_size = isset( $settings->image_size_small_tile ) ? $settings->image_size_small_tile : $image_size;
		}

		// Small size for Layout 1 - Post 3 and Post 4, Layout 2 - Post 1-4, Layout 4 - Post 2 and Post 3.
		if ( ( $count == 3 || $count == 4 ) && ( $layout == 1 || $layout == 2 || $layout == 4 ) ) {
			$image_size = isset( $settings->image_size_small_tile ) ? $settings->image_size_small_tile : $image_size;
		}

		if ( in_array( $layout, array(1,2,3,4) ) ) :

			if ( $count == 1 ) {
				echo '<div class="pp-post-tile-left">';
			}
			if ( $count == 2 ) {
				echo '<div class="pp-post-tile-right">';
			}

			if ( $count <= $layout_posts_count ) {
				include apply_filters( 'pp_tiles_layout_path', $module->dir . 'includes/post-grid.php', $settings->layout, $settings );
			}

			if ( $count == 1 ) {
				echo '</div>';
			}
			if ( ($count == 3 && $settings->layout == 3) || ($count == 3 && $settings->layout == 4) || ($count == 4 && $settings->layout == 1) || ($count == 5 && $settings->layout == 2) ) {
				echo '</div>';
			}

			// Other posts.
			if ( $show_other_posts && $count > $layout_posts_count && $query->post_count > $layout_posts_count && ! $other_posts_displayed ) {
				$other_posts_displayed = true;
				echo '<div class="pp-post-tile-group pp-post-col-' . $settings->column_width . '">';
			}

			if ( $show_other_posts && $count > $layout_posts_count && $count <= $query->post_count ) {
				include apply_filters( 'pp_tiles_layout_path', $module->dir . 'includes/post-grid.php', $layout, $settings );
			}

			if ( $show_other_posts && $count >= $query->post_count && $query->post_count > $layout_posts_count ) {
				echo '</div>';
			}

		endif;

		$count++;

	endwhile;

	?>
</div>
<div class="fl-clear"></div>
<?php endif; ?>

<?php

do_action( 'pp_tiles_after_posts', $settings, $query );

// Render the empty message.
if(!$query->have_posts() && (defined('DOING_AJAX') || isset($_REQUEST['fl_builder']))) :

?>
<div class="fl-post-grid-empty">
	<?php
	if (isset($settings->no_results_message)) :
		echo $settings->no_results_message;
	else :
		_e( 'No posts found.', 'bb-powerpack' );
	endif;
	?>
</div>

<?php

endif;

wp_reset_postdata();

?>
