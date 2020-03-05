<?php

/**
 * Handles logic for The Events Calendar page data properties.
 *
 * @since TBD
 */
final class FLPageDataTheEventsCalendar {

	/**
	 * @since TBD
	 * @return string
	 */
	static public function init() {
		FLPageData::add_group( 'the-events-calendar', array(
			'label' => __( 'The Events Calendar', 'fl-theme-builder' ),
		) );
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function start_date( $settings, $property ) {

		$format = isset( $settings->format ) ? $settings->format : false;
		if ( $format ) {
			return tribe_get_start_date( null, false, $format );
		} else {
			return tribe_get_start_date( null, false );
		}

	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function start_time() {
		$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
		$event_time  = tribe_get_start_date( null, false, $time_format );

		if ( tribe_get_option( 'tribe_events_timezones_show_zone' ) ) {
			$event_id   = Tribe__Events__Main::postIdHelper();
			$event_time = Tribe__Events__Timezones::append_timezone( $event_time, $event_id );
		}
		return $event_time;
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function end_date( $settings, $property ) {

		$format = isset( $settings->format ) ? $settings->format : false;
		if ( $format ) {
			return tribe_get_display_end_date( null, false, $format );
		} else {
			return tribe_get_display_end_date( null, false );
		}
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function end_time() {
		$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
		$event_time  = tribe_get_end_date( null, false, $time_format );

		if ( tribe_get_option( 'tribe_events_timezones_show_zone' ) ) {
			$event_id   = Tribe__Events__Main::postIdHelper();
			$event_time = Tribe__Events__Timezones::append_timezone( $event_time, $event_id );
		}

		return $event_time;
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function organizer_url() {
		return get_permalink( tribe_get_organizer_id() );
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function venue_url() {
		return get_permalink( tribe_get_venue_id() );
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function field( $settings ) {
		$value = '';

		if ( ! empty( $settings->name ) ) {
			$fields = tribe_get_option( 'custom-fields', false );
			if ( is_array( $fields ) ) {
				foreach ( $fields as $field ) {
					if ( $settings->name === $field['label'] ) {
						$post_id = Tribe__Events__Main::postIdHelper();
						$value   = str_replace( '|', ', ', get_post_meta( $post_id, $field['name'], true ) );
					}
				}
			}
		}

		return $value;
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function back_link() {
		return '<a href="' . tribe_get_events_link() . '">' . __( '&laquo; All Events', 'fl-theme-builder' ) . '</a>';
	}
}

FLPageDataTheEventsCalendar::init();
