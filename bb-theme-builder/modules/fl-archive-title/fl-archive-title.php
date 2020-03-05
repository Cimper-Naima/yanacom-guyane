<?php

/**
 * Heading module alias for the archive title.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-archive-title', array(
	'module'      => 'heading',
	'name'        => __( 'Archive Title', 'fl-theme-builder' ),
	'description' => __( 'Displays the title for the current archive.', 'fl-theme-builder' ),
	'group'       => __( 'Themer Modules', 'fl-theme-builder' ),
	'category'    => __( 'Archives', 'fl-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
	'settings'    => array(
		'tag'         => 'h1',
		'connections' => array(
			'heading' => (object) array(
				'object'   => 'archive',
				'property' => 'title',
				'field'    => 'text',
			),
		),
	),
) );
