<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarMapModule
 */
class FLTheEventsCalendarMapModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Map', 'fl-theme-builder' ),
			'description'     => __( 'Displays the map for the current event.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-map/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-map/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarMapModule', array(
	'general' => array(
		'title'    => __( 'Style', 'fl-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'height' => array(
						'type'        => 'text',
						'label'       => __( 'Height', 'fl-theme-builder' ),
						'default'     => '350',
						'size'        => '5',
						'description' => 'px',
						'placeholder' => '350',
					),
				),
			),
		),
	),
) );
