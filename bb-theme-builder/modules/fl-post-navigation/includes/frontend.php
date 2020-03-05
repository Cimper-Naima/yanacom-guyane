<?php
global $wp_query, $post;

// Get the post and query.
$original_post = $post;

if ( is_object( $original_post ) && 0 === $original_post->ID && isset( $wp_query->post ) ) {
	$post = $wp_query->post;
}

$args = apply_filters( 'fl_theme_builder_post_nav', array(
	'prev_text'    => $settings->prev_text,
	'next_text'    => $settings->next_text,
	'in_same_term' => $settings->in_same_term,
	'taxonomy'     => $settings->tax_select,
) );
the_post_navigation( $args );

// Reset the global post variable.
$post = $original_post;
