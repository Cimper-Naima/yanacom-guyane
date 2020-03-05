<?php

/**
 * Post module alias for events on archive layouts.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-the-events-calendar-posts', array(
	'module'      => 'post-grid',
	'name'        => __( 'Event Posts', 'fl-theme-builder' ),
	'description' => __( 'Displays a grid of events for the current archive.', 'fl-theme-builder' ),
	'group'       => __( 'Themer Modules', 'fl-theme-builder' ),
	'category'    => __( 'The Events Calendar', 'fl-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
	'settings'    => array(
		'layout'        => 'columns',
		'data_source'   => 'main_query',
		'show_author'   => '0',
		'show_date'     => '0',
		'show_content'  => '0',
		'event_date'    => '0',
		'event_address' => '0',
	),
) );
