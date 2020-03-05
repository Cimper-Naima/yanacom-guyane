<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarDescriptionModule
 */
class FLTheEventsCalendarDescriptionModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Description', 'fl-theme-builder' ),
			'description'     => __( 'Displays the description for the current event.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-description/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-description/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarDescriptionModule', array() );
