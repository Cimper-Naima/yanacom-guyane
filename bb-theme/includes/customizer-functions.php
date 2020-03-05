<?php

/**
 * Output list of all image sizes.
 *
 * @since 1.6
 * @return void
 */
function archive_post_image_sizes() {
	$options     = array();
	$image_sizes = get_intermediate_image_sizes();
	if ( count( $image_sizes ) ) {
		foreach ( $image_sizes as $image_size ) {
			$options[ $image_size ] = $image_size;
		}
	}

	return $options;
}

/**
 * Output list of all image sizes.
 *
 * @since 1.6
 * @return void
 */
function single_post_image_sizes() {
	$options     = array();
	$image_sizes = get_intermediate_image_sizes();
	if ( count( $image_sizes ) ) {
		foreach ( $image_sizes as $image_size ) {
			$options[ $image_size ] = $image_size;
		}
	}

	return $options;
}

/**
 * Setup filesystem singleton.
 * @since 1.6.5
 */
function fl_theme_filesystem() {
	if ( class_exists( 'FL_Filesystem' ) ) {
		return FL_Filesystem::instance();
	} else {
		return FL_Theme_Filesystem::instance();
	}
}
