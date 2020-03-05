<?php

/**
 * Post module alias for post lists on archive layouts.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-post-list', array(
	'module'      => 'post-grid',
	'name'        => __( 'Post List', 'fl-theme-builder' ),
	'description' => __( 'Displays a list of posts for the current archive.', 'fl-theme-builder' ),
	'group'       => __( 'Themer Modules', 'fl-theme-builder' ),
	'category'    => __( 'Archives', 'fl-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
	'settings'    => array(
		'layout'         => 'feed',
		'image_position' => 'beside',
		'data_source'    => 'main_query',
	),
) );
