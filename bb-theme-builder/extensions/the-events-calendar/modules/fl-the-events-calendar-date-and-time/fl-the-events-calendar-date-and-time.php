<?php

/**
 * Heading module alias for the event date and time.
 *
 * @since TBD
 */
FLBuilder::register_module_alias( 'fl-the-events-calendar-date-and-time', array(
	'module'      => 'rich-text',
	'name'        => __( 'Event Date and Time', 'fl-theme-builder' ),
	'description' => __( 'Displays the date and time for an event.', 'fl-theme-builder' ),
	'group'       => __( 'Themer Modules', 'fl-theme-builder' ),
	'category'    => __( 'The Events Calendar', 'fl-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
	'settings'    => array(
		'text' => '[wpbb post:the_events_calendar_date_and_time]',
	),
) );
