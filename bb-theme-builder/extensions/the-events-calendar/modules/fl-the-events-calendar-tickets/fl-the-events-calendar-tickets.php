<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarTicketsModule
 */
class FLTheEventsCalendarTicketsModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Tickets', 'fl-theme-builder' ),
			'description'     => __( 'Displays the ticket form and info for the current event.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-tickets/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-tickets/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ) && class_exists( 'Tribe__Tickets__RSVP' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarTicketsModule', array(
	'style' => array(
		'title'    => __( 'Style', 'fl-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'fl-theme-builder' ),
						'show_reset' => true,
					),
					'text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'fl-theme-builder' ),
						'show_reset' => true,
					),
					'sep_color'  => array(
						'type'       => 'color',
						'label'      => __( 'Separator Color', 'fl-theme-builder' ),
						'show_reset' => true,
					),
				),
			),
			'button'  => array(
				'title'  => __( 'Button', 'fl-theme-builder' ),
				'fields' => array(
					'btn_bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'fl-theme-builder' ),
						'show_reset' => true,
					),
					'btn_text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'fl-theme-builder' ),
						'show_reset' => true,
					),
				),
			),
		),
	),
) );
