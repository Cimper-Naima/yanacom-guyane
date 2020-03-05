<?php

/**
 * Post module alias for post galleries on archive layouts.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-post-gallery', array(
	'module'      => 'post-grid',
	'name'        => __( 'Post Gallery', 'fl-theme-builder' ),
	'description' => __( 'Displays a gallery grid of posts for the current archive.', 'fl-theme-builder' ),
	'group'       => __( 'Themer Modules', 'fl-theme-builder' ),
	'category'    => __( 'Archives', 'fl-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
	'settings'    => array(
		'layout'      => 'gallery',
		'data_source' => 'main_query',
	),
) );
