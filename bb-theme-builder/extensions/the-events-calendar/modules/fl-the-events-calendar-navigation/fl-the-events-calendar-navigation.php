<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarRelatedModule
 */
class FLTheEventsCalendarNavigationModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Navigation', 'fl-theme-builder' ),
			'description'     => __( 'Displays prev/next events for the current event.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-navigation/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-navigation/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarNavigationModule', array(
	'general' => array(
		'title'    => __( 'Style', 'fl-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'previous' => array(
						'type'        => 'text',
						'label'       => __( 'Previous Link', 'fl-theme-builder' ),
						'default'     => '<span>&laquo;</span> %title%',
						'placeholder' => '<span>&laquo;</span> %title%',
					),
					'next'     => array(
						'type'        => 'text',
						'label'       => __( 'Next Link', 'fl-theme-builder' ),
						'default'     => '%title% <span>&raquo;</span>',
						'placeholder' => '%title% <span>&raquo;</span>',
					),
				),
			),
		),
	),
) );
