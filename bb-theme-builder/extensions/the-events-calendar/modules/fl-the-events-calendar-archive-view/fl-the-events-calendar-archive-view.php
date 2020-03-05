<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarArchiveViewModule
 */
class FLTheEventsCalendarArchiveViewModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Calendar', 'fl-theme-builder' ),
			'description'     => __( 'Displays the event calendar view for event archives.', 'fl-theme-builder' ),
			'group'           => __( 'Themer Modules', 'fl-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'fl-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-archive-view/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-archive-view/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarArchiveViewModule', array(
	'general' => array(
		'title'    => __( 'Style', 'fl-theme-builder' ),
		'sections' => array(
			'filter'  => array(
				'title'  => '',
				'fields' => array(
					'fg_color' => array(
						'type'       => 'color',
						'label'      => __( 'Foreground Color', 'fl-theme-builder' ),
						'show_reset' => true,
						'help'       => __( 'Sets the color of text and borders for elements with an accent background color.', 'fl-theme-builder' ),
					),
					'bg_color' => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'fl-theme-builder' ),
						'show_reset' => true,
						'help'       => __( 'Sets the background color for elements that have a default accent background color such as the calendar heading.', 'fl-theme-builder' ),
					),
				),
			),
			'notices' => array(
				'title'  => __( 'Error Notices', 'fl-theme-builder' ),
				'fields' => array(
					'notice_text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'fl-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type' => 'none',
						),
					),
					'notice_bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'fl-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .tribe-events-notices',
							'property' => 'background-color',
						),
					),
				),
			),
		),
	),
) );
