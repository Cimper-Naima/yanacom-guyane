<?php
$all_label			= empty( $settings->all_filter_label ) ? __('All', 'bb-powerpack') : $settings->all_filter_label;
$post_type_slug 	= $settings->post_type;
$post_filter_tax 	= ! empty( $settings->post_grid_filters ) ? $settings->post_grid_filters : '';

if ( empty( $post_filter_tax ) ) {
	return;
}

$post_filter_field 	= 'tax_' . $post_type_slug . '_' . $post_filter_tax;
$post_filter_terms	= array();
$taxonomy 			= get_taxonomy( $post_filter_tax );
$taxonmy_name 		= $taxonomy->name;

if ( isset( $settings->{$post_filter_field} ) ) :

	$post_filter_value	= $settings->{$post_filter_field};
	$post_filter_matching = $settings->{$post_filter_field . '_matching'};

	if ( $post_filter_value ) {
		$post_filter_term_ids = explode( ",", $post_filter_value );
		if ( ! $post_filter_matching ) {
			$post_filter_terms = get_terms( $post_filter_tax, array( 'exclude' => $post_filter_term_ids ) );
		} else {
			foreach ( $post_filter_term_ids as $post_filter_term_id ) {
				$post_filter_terms[] = get_term_by('id', $post_filter_term_id, $post_filter_tax);
			}
		}
	}

endif;

$terms = ( count( $post_filter_terms ) > 0 ) ? $post_filter_terms : get_terms( $post_filter_tax );
$count = is_array( $terms ) ? count( $terms ) : 0;
?>
<div class="pp-post-filters-wrapper">
	<div class="pp-post-filters-toggle">
		<span class="toggle-text"><?php echo $all_label; ?></span>
	</div>
	<ul class="pp-post-filters">
		<?php
			echo '<li class="pp-post-filter pp-filter-active" data-filter="*">' . $all_label . '</li>';
			if ( $count > 0 ) {
				foreach ( $terms as $term ) {
					$slug = $term->slug;
					if( $post_type_slug == 'post' && $post_filter_tax == 'post_tag' ) {
						echo '<li class="pp-post-filter" data-filter=".tag-'.$slug.'" data-term="'.$slug.'">'.$term->name.'</li>';
					} else {
						echo '<li class="pp-post-filter" data-filter=".'.$taxonomy->name.'-'.$slug.'" data-term="'.$slug.'">'.$term->name.'</li>';
					}
				}
			}
		?>
	</ul>
</div>

<?php do_action( 'pp_cg_after_post_filters', $settings ); ?>