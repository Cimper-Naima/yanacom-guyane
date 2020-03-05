<?php

/**
 * Rich text module alias for the event cost.
 *
 * @since TBD
 */
FLBuilder::register_module_alias( 'fl-the-events-calendar-cost', array(
	'module'      => 'rich-text',
	'name'        => __( 'Event Cost', 'fl-theme-builder' ),
	'description' => __( 'Displays the cost for an event.', 'fl-theme-builder' ),
	'group'       => __( 'Themer Modules', 'fl-theme-builder' ),
	'category'    => __( 'The Events Calendar', 'fl-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
	'settings'    => array(
		'text' => '[wpbb post:the_events_calendar_cost]',
	),
) );
