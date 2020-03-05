<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarRelatedModule
 */
class FLTheEventsCalendarRelatedModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Related Events', 'fl-theme-builder' ),
			'description'     => __( 'Displays the related events for the current event.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-related/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-related/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ) && class_exists( 'Tribe__Events__Pro__Main' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarRelatedModule', array() );
