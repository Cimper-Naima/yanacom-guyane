<?php

/**
 * The Events Calendar archive support for the theme builder.
 *
 * @since TBD
 */
final class FLThemeBuilderTheEventsCalendarArchive {

	/**
	 * @since TBD
	 * @return void
	 */
	static public function init() {
		/* Actions */
		add_action( 'wp', __CLASS__ . '::init_query_hooks' );
		add_action( 'fl_builder_posts_module_before_posts', __CLASS__ . '::posts_module_before_posts', 10, 2 );
		add_action( 'fl_builder_posts_module_after_posts', __CLASS__ . '::posts_module_after_posts', 10, 2 );
		add_action( 'fl_builder_post_grid_before_content', __CLASS__ . '::post_grid_before_content' );
		add_action( 'fl_builder_post_gallery_after_meta', __CLASS__ . '::post_grid_before_content' );
		add_action( 'fl_builder_post_feed_after_meta', __CLASS__ . '::post_grid_before_content' );

		/* Filters */
		add_filter( 'fl_builder_register_settings_form', __CLASS__ . '::post_grid_settings', 10, 2 );
		add_filter( 'fl_builder_render_css', __CLASS__ . '::post_grid_css', 10, 2 );
		add_action( 'fl_builder_loop_query_args', __CLASS__ . '::builder_loop_query_args' );
	}

	/**
	 * Setup hooks that must be run after the query.
	 *
	 * @since TBD
	 * @return void
	 */
	static public function init_query_hooks() {
		global $post;

		$location          = FLThemeBuilderRulesLocation::get_preview_location( get_the_ID() );
		$is_event_preview  = stristr( $location, 'tribe_events' );
		$is_theme_layout   = 'fl-theme-layout' === get_post_type();
		$theme_layout_type = is_object( $post ) ? get_post_meta( $post->ID, '_fl_theme_layout_type', true ) : '';

		if ( $is_event_preview && $is_theme_layout && 'archive' === $theme_layout_type ) {
			add_filter( 'body_class', __CLASS__ . '::body_class' );
		} elseif ( is_post_type_archive( 'tribe_events' ) ) {
			add_filter( 'fl_builder_loop_query', __CLASS__ . '::builder_loop_query', 10, 2 );
			add_action( 'fl_theme_builder_before_render_content', __CLASS__ . '::before_render_content' );
		}
	}

	/**
	 * Adds the events body classes to theme layouts that are
	 * set to event locations.
	 *
	 * @since TBD
	 * @param array $classes
	 * @return array
	 */
	static public function body_class( $classes ) {
		$classes[] = 'events-archive';
		$classes[] = 'events-gridview';
		$classes[] = 'tribe-events-uses-geolocation';
		return $classes;
	}

	/**
	 * Event archives don't always show all of the posts for builder post
	 * module queries. This queries all posts and orders them by start date.
	 *
	 * @since TBD
	 * @param object $query
	 * @param object $settings
	 * @return object
	 */
	static public function builder_loop_query( $query, $settings ) {

		if ( isset( $settings->data_source ) && 'main_query' == $settings->data_source ) {
			$orderby = 'EventStartDate';
			$order   = 'ASC';

			if ( isset( $settings->event_orderby ) && ! empty( $settings->event_orderby ) ) {
				$orderby = $settings->event_orderby;
				$order   = $settings->event_order;
			}

			$query = new WP_Query( array_merge( $query->query, array(
				'orderby' => $orderby,
				'order'   => $order,
				'paged'   => FLBuilderLoop::get_paged(),
			) ) );
		}

		return $query;
	}

	/**
	 * Adds sorting to events list in the posts module for source custom query.
	 *
	 * @since TBD
	 * @param object $args
	 * @return array
	 */
	static public function builder_loop_query_args( $args ) {
		$settings = $args['settings'];

		if ( ! isset( $settings->data_source ) || 'custom_query' != $settings->data_source ) {
			return $args;
		}

		if ( 'tribe_events' != $args['post_type'] ) {
			return $args;
		}

		if ( ! isset( $settings->event_orderby ) || empty( $settings->event_orderby ) ) {
			return $args;
		}

		$args['orderby']   = 'meta_value_num';
		$args['meta_key']  = '_' . $settings->event_orderby;
		$args['meta_type'] = 'DATE';
		$args['order']     = $settings->event_order;

		return $args;
	}

	/**
	 * Fixes query issues with event archive layouts before
	 * the layout is rendered.
	 *
	 * @since TBD
	 * @return void
	 */
	static public function before_render_content() {
		Tribe__Events__Templates::restoreQuery();
		remove_action( 'loop_start', array( 'Tribe__Events__Templates', 'setup_ecp_template' ) );
	}

	/**
	 * dds event calendar settings to the Posts module.
	 *
	 * @since TBD
	 * @param array  $form
	 * @param string $slug
	 * @return array
	 */
	static public function post_grid_settings( $form, $slug ) {
		if ( 'post-grid' != $slug ) {
			return $form;
		}

		$form['layout']['sections']['events'] = array(
			'title'  => __( 'The Events Calendar', 'fl-theme-builder' ),
			'fields' => array(
				'event_date'    => array(
					'type'    => 'select',
					'label'   => __( 'Event Date', 'fl-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show' => __( 'Show', 'fl-theme-builder' ),
						'hide' => __( 'Hide', 'fl-theme-builder' ),
					),
				),
				'event_address' => array(
					'type'    => 'select',
					'label'   => __( 'Event Address', 'fl-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show' => __( 'Show', 'fl-theme-builder' ),
						'hide' => __( 'Hide', 'fl-theme-builder' ),
					),
				),
				'event_cost'    => array(
					'type'    => 'select',
					'label'   => __( 'Event Cost', 'fl-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show' => __( 'Show', 'fl-theme-builder' ),
						'hide' => __( 'Hide', 'fl-theme-builder' ),
					),
				),
				'event_orderby' => array(
					'type'    => 'select',
					'label'   => __( 'Events Order By', 'fl-theme-builder' ),
					'default' => '',
					'options' => array(
						''               => __( 'Default', 'fl-theme-builder' ),
						'EventStartDate' => __( 'Start Date', 'fl-theme-builder' ),
						'EventEndDate'   => __( 'End Date', 'fl-theme-builder' ),
					),
				),
				'event_order'   => array(
					'type'    => 'select',
					'label'   => __( 'Events Order', 'fl-theme-builder' ),
					'default' => 'Ascending',
					'options' => array(
						'ASC'  => __( 'Ascending', 'fl-theme-builder' ),
						'DESC' => __( 'Descending', 'fl-theme-builder' ),
					),
				),
			),
		);

		$form['style']['sections']['events_button'] = array(
			'title'  => __( 'The Events Calendar Cart Button', 'fl-theme-builder' ),
			'fields' => array(
				'events_button_bg_color'   => array(
					'type'       => 'color',
					'label'      => __( 'Background Color', 'fl-theme-builder' ),
					'default'    => '',
					'show_reset' => true,
				),
				'events_button_text_color' => array(
					'type'       => 'color',
					'label'      => __( 'Text Color', 'fl-theme-builder' ),
					'default'    => '',
					'show_reset' => true,
				),
			),
		);

		return $form;
	}

	/**
	 * Event calendar logic for before posts are rendered in the post module
	 *
	 * @since TBD
	 * @param object $settings
	 * @param object $query
	 * @return void
	 */
	static public function posts_module_before_posts( $settings, $query ) {
		if ( isset( $query->query_vars->post_type ) && 'tribe_events' === $query->query_vars->post_type ) {
			do_action( 'tribe_events_before_the_grid' );
		}
	}

	/**
	 * Event calendar logic for after posts are rendered in the post module
	 *
	 * @since TBD
	 * @param object $settings
	 * @param object $query
	 * @return void
	 */
	static public function posts_module_after_posts( $settings, $query ) {
		if ( isset( $query->query_vars->post_type ) && 'tribe_events' === $query->query_vars->post_type ) {
			do_action( 'tribe_events_after_the_grid' );
		}
	}

	/**
	 * Adds event calendar info before the grid layout content.
	 *
	 * @since TBD
	 * @param object $settings
	 * @return void
	 */
	static public function post_grid_before_content( $settings ) {

		// if custom layout then dont do these.
		if ( 'custom' == $settings->post_layout ) {
			return false;
		}

		do_action( 'tribe_events_before_the_grid' );

		// Opening wrapper
		if ( 'show' === $settings->event_date || 'show' === $settings->event_address ) {
			echo '<div class="fl-post-module-event-calendar-meta fl-post-grid-event-calendar-meta">';
		}

		// Event date
		if ( 'show' === $settings->event_date ) {
			echo '<div class="fl-post-grid-event-calendar-date">';
			echo FLPageData::get_value( 'post', 'the_events_calendar_date_and_time' );
			echo '</div>';
		}

		// Event location
		if ( 'show' === $settings->event_address ) {
			$address = FLPageData::get_value( 'post', 'the_events_calendar_address' );
			if ( $address ) {
				echo '<div class="fl-post-grid-event-calendar-address">';
				echo $address;
				echo '</div>';
			}
		}

		// Closing wrapper
		if ( 'show' === $settings->event_date || 'show' === $settings->event_address ) {
			echo '</div>';
		}

		// Event Tickets
		if ( 'gallery' !== $settings->layout && 'show' === $settings->event_cost && tribe_get_cost() ) {
			echo '<div class="fl-post-module-event-calendar-cost tribe-events-event-cost">';
			echo '<span class="ticket-cost">';
			echo tribe_get_cost( null, true );
			echo '</span>';
			do_action( 'tribe_events_inside_cost' );
			echo '</div>';
		}
	}

	/**
	 * Renders custom CSS for the post grid module.
	 *
	 * @since TBD
	 * @param string $css
	 * @param array  $nodes
	 * @return string
	 */
	static public function post_grid_css( $css, $nodes ) {
		$global_included = false;

		foreach ( $nodes['modules'] as $module ) {

			if ( ! is_object( $module ) ) {
				continue;
			} elseif ( 'post-grid' != $module->settings->type ) {
				continue;
			} elseif ( ! $global_included ) {
				$global_included = true;
				$css            .= file_get_contents( FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'css/post-grid.css' );
			}

			ob_start();
			$id       = $module->node;
			$settings = $module->settings;
			include FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'includes/post-grid-the-events-calendar.css.php';
			$css .= ob_get_clean();
		}

		return $css;
	}
}

FLThemeBuilderTheEventsCalendarArchive::init();
