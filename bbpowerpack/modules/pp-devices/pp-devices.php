<?php

/**
 * @class PPDevicesModule
 */
class PPDevicesModule extends FLBuilderModule {

	/**
	 * Constructor function for the module. You must pass the
	 * name, description, dir and url in an array to the parent class.
	 *
	 * @method __construct
	 */
	public static $post_types = array();
	public static $taxonomies = array();

	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'Devices', 'bb-powerpack' ),
				'description'     => __( 'A module for Devices.', 'bb-powerpack' ),
				'group'           => pp_get_modules_group(),
				'category'        => pp_get_modules_cat( 'content' ),
				'dir'             => BB_POWERPACK_DIR . 'modules/pp-devices/',
				'url'             => BB_POWERPACK_URL . 'modules/pp-devices/',
				'editor_export'   => true, // Defaults to true and can be omitted.
				'enabled'         => true, // Defaults to true and can be omitted.
				'partial_refresh' => true,
			)
		);
		$this->add_css( BB_POWERPACK()->fa_css );
	}
	/**
	 * Retrieve the video properties for a given video URL.
	 *
	 * @since 2.7.2
	 *
	 * @param string $video_url Video URL.
	 *
	 * @return null|array The video properties, or null.
	 */
	public function get_video_properties( $video_url ) {
		$provider_regex = array(
			'youtube'     => '/^.*(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|v|vi|user)\/))([^\?&\"\'>]+)/',
			'vimeo'       => '/^.*vimeo\.com\/(?:[a-z]*\/)*([‌​0-9]{6,11})[?]?.*/',
			'dailymotion' => '/^.*dailymotion.com\/(?:video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/',
		);

		foreach ( $provider_regex as $provider => $match_mask ) {
			preg_match( $match_mask, $video_url, $matches );

			if ( $matches ) {
				return array(
					'provider' => $provider,
					'video_id' => $matches[1],
				);
			}
		}

		return null;
	}

	/**
	 * Retrieve video module embed parameters.
	 *
	 * @since 2.7.2
	 *
	 * @return array Video embed parameters.
	 */
	public function get_embed_params() {
		$settings = $this->settings;
		$params   = array();

		if ( 'yes' === $settings->auto_play ) {
			$params['autoplay'] = '1';
		}

		$params_dictionary = array();

		if ( 'youtube' === $settings->video_src ) {
			$params_dictionary = array(
				'loop',
				'controls',
				'mute',
				'rel',
				'modestbranding',
			);

			if ( 'yes' === $settings->loop ) {
				$video_properties = $this->get_video_properties( $settings->youtube_url );

				$params['playlist'] = $video_properties['video_id'];
			}

			$params['start'] = $settings->start_time;

			$params['end'] = $settings->end_time;

			$params['wmode'] = 'opaque';

		} elseif ( 'vimeo' === $settings->video_src ) {
			$params_dictionary = array(
				'loop',
				'mute'           => 'muted',
				'vimeo_title'    => 'title',
				'vimeo_portrait' => 'portrait',
				'vimeo_byline'   => 'byline',
			);

			$params['autopause'] = '0';

		} elseif ( 'dailymotion' === $settings->video_src ) {

			$params_dictionary = array(
				'controls',
				'mute',
				'showinfo' => 'ui-start-screen-info',
				'logo'     => 'ui-logo',
			);

			$params['start'] = $settings->start_time;

			$params['endscreen-enable'] = '0';
		}

		foreach ( $params_dictionary as $key => $param_name ) {
			$setting_name = $param_name;

			if ( is_string( $key ) ) {
				$setting_name = $key;
			}

			$setting_value = 'yes' === $settings->{$setting_name} ? '1' : '0';

			$params[ $param_name ] = $setting_value;
		}

		return $params;
	}

	/**
	 * Get embed options for YouTube and Vimeo based on settings.
	 *
	 * @since 2.7.2
	 *
	 * @return array Embed options.
	 */
	public function get_embed_options() {
		$settings      = $this->settings;
		$embed_options = array();

		if ( 'youtube' === $settings->video_src ) {
			$embed_options['privacy'] = 'yes' === $settings->yt_privacy;
		} elseif ( 'vimeo' === $settings->video_src ) {
			$embed_options['start'] = $settings->start_time;
		}

		return $embed_options;
	}

	/**
	 * Retrieve the embed URL for a given video.
	 *
	 * @since 2.7.2
	 *
	 * @param string $video_url        Video URL.
	 * @param array  $embed_url_params Optional. Embed parameters. Default is an
	 *                                 empty array.
	 * @param array  $options          Optional. Embed options. Default is an
	 *                                 empty array.
	 *
	 * @return null|array The video properties, or null.
	 */
	public function get_embed_url( $video_url, array $embed_url_params = array(), array $options = array() ) {
		$video_properties = $this->get_video_properties( $video_url );

		if ( ! $video_properties ) {
			return null;
		}

		$embed_patterns = array(
			'youtube'     => 'https://www.youtube{NO_COOKIE}.com/embed/{VIDEO_ID}?feature=oembed',
			'vimeo'       => 'https://player.vimeo.com/video/{VIDEO_ID}#t={TIME}',
			'dailymotion' => 'https://dailymotion.com/embed/video/{VIDEO_ID}',
		);

		$embed_pattern = $embed_patterns[ $video_properties['provider'] ];

		$replacements = array(
			'{VIDEO_ID}' => $video_properties['video_id'],
		);

		if ( 'youtube' === $video_properties['provider'] ) {
			$replacements['{NO_COOKIE}'] = ! empty( $options['privacy'] ) ? '-nocookie' : '';
		} elseif ( 'vimeo' === $video_properties['provider'] ) {
			$time_text = '';

			if ( ! empty( $options['start'] ) ) {
				$time_text = date( 'H\hi\ms\s', $options['start'] );
			}

			$replacements['{TIME}'] = $time_text;
		}

		$embed_pattern = str_replace( array_keys( $replacements ), $replacements, $embed_pattern );

		return add_query_arg( $embed_url_params, $embed_pattern );
	}

	/**
	 * Get embed HTML.
	 *
	 * Retrieve the final HTML of the embedded URL.
	 *
	 * @since 2.7.2
	 *
	 * @param string $video_url        Video URL.
	 * @param array  $embed_url_params Optional. Embed parameters. Default is an
	 *                                 empty array.
	 * @param array  $options          Optional. Embed options. Default is an
	 *                                 empty array.
	 * @param array  $frame_attributes Optional. IFrame attributes. Default is an
	 *                                 empty array.
	 *
	 * @return string The embed HTML.
	 */
	public function get_embed_html( $video_url, array $embed_url_params = array(), array $options = array(), array $frame_attributes = array() ) {
		$default_frame_attributes = array(
			'class' => 'pp-video-iframe',
			'allowfullscreen',
			'allow' => 'autoplay',
		);

		$video_embed_url = $this->get_embed_url( $video_url, $embed_url_params, $options );
		if ( ! $video_embed_url ) {
			return null;
		}
		if ( ! isset( $options['lazy_load'] ) || ! $options['lazy_load'] ) {
			$default_frame_attributes['src'] = $video_embed_url;
		} else {
			$default_frame_attributes['data-lazy-load'] = $video_embed_url;
		}

		$frame_attributes = array_merge( $default_frame_attributes, $frame_attributes );

		$attributes_for_print = array();

		foreach ( $frame_attributes as $attribute_key => $attribute_value ) {
			$attribute_value = esc_attr( $attribute_value );

			if ( is_numeric( $attribute_key ) ) {
				$attributes_for_print[] = $attribute_value;
			} else {
				$attributes_for_print[] = sprintf( '%1$s="%2$s"', $attribute_key, $attribute_value );
			}
		}

		$attributes_for_print = implode( ' ', $attributes_for_print );

		$iframe_html = "<iframe $attributes_for_print></iframe>";

		/** This filter is documented in wp-includes/class-oembed.php */
		return apply_filters( 'oembed_result', $iframe_html, $video_url, $frame_attributes );
	}

	/**
	 * Get URL of video.
	 *
	 * @since 2.7.2
	 *
	 * @return string|bool Video URL or false.
	 */
	public function get_video_url() {
		$settings  = $this->settings;
		$video_src = $settings->video_src;

		if ( isset( $settings->{$video_src . '_url'} ) ) {
			return $settings->{$video_src . '_url'};
		}

		return false;
	}

	/**
	 * Get HTML of video to render.
	 *
	 * @since 2.7.2
	 *
	 * @return string Video HTML.
	 */
	public function get_video_html() {
		$settings   = $this->settings;
		$video_url  = $this->get_video_url();
		$video_html = '';

		if ( ! $video_url ) {
			return $video_html;
		}

		if ( 'self_hosted' !== $settings->video_src ) {
			$embed_params  = $this->get_embed_params();
			$embed_options = $this->get_embed_options();
			$video_html    = $this->get_embed_html( $video_url, $embed_params, $embed_options );
		}

		return $video_html;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'PPDevicesModule',
	array(
		'general' => array(
			'title'    => __( 'General', 'bb-powerpack' ),
			'sections' => array(
				'device'      => array(
					'title'  => 'Device',
					'fields' => array(
						'device_type'         => array(
							'type'    => 'select',
							'label'   => __( 'Type', 'bb-powerpack' ),
							'default' => 'phone',
							'options' => array(
								'phone'   => __( 'Phone', 'bb-powerpack' ),
								'tablet'  => __( 'Tablet', 'bb-powerpack' ),
								'laptop'  => __( 'Laptop', 'bb-powerpack' ),
								'desktop' => __( 'Desktop', 'bb-powerpack' ),
								'window'  => __( 'Window', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'phone'   => array(
									'fields' => array( 'orientation', 'orientation_control', 'scrollable', 'vertical_alignment' ),
								),
								'tablet'  => array(
									'fields' => array( 'orientation', 'orientation_control', 'scrollable', 'vertical_alignment' ),
								),
								'laptop'  => array(
									'fields' => array( 'scrollable', 'vertical_alignment' ),
								),
								'desktop' => array(
									'fields' => array( 'scrollable', 'vertical_alignment' ),
								),
								'window'  => array(
									'fields' => array( '' ),
								),
							),
						),
						'media_type'          => array(
							'type'    => 'select',
							'label'   => __( 'Media Type', 'bb-powerpack' ),
							'default' => 'image',
							'options' => array(
								'image' => __( 'Image', 'bb-powerpack' ),
								'video' => __( 'Video', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'image' => array(
									'sections' => array( 'image' ),
								),
								'video' => array(
									'sections' => array( 'behaviour', 'video_buttons' ),
									'fields'   => array( 'video_src' ),
								),
							),
						),
						'video_src'           => array(
							'type'    => 'select',
							'label'   => __( 'Video Source', 'bb-powerpack' ),
							'default' => 'youtube',
							'options' => array(
								'youtube'     => __( 'Youtube', 'bb-powerpack' ),
								'vimeo'       => __( 'Vimeo', 'bb-powerpack' ),
								'dailymotion' => __( 'Daily Motion', 'bb-powerpack' ),
								'self_hosted' => __( 'Self Hosted / URL', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'youtube'     => array(
									'sections' => array( 'embed_video' ),
									'fields'   => array( 'youtube_url', 'loop', 'controls', 'start_time', 'end_time', 'modestbranding', 'yt_privacy', 'rel' ),
								),
								'vimeo'       => array(
									'sections' => array( 'embed_video' ),
									'fields'   => array( 'start_time', 'vimeo_url', 'loop', 'vimeo_title', 'vimeo_portrait', 'vimeo_byline' ),
								),
								'dailymotion' => array(
									'sections' => array( 'embed_video' ),
									'fields'   => array( 'start_time', 'dailymotion_url', 'controls', 'showinfo', 'logo' ),
								),
								'self_hosted' => array(
									'sections' => array( 'video', 'display', 'volume', 'video_interface' ),
									'fields'   => array( 'loop', 'stop_others', 'restart_on_pause', 'end_at_last_frame', 'playback_speed', 'button_spacing' ),
								),
							),
						),
						'orientation'         => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Orientation', 'bb-powerpack' ),
							'default' => 'portrait',
							'options' => array(
								'portrait'  => __( 'Portrait', 'bb-powerpack' ),
								'landscape' => __( 'Landscape', 'bb-powerpack' ),
							),
						),
						'orientation_control' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Orientation Control', 'bb-powerpack' ),
							'default' => 'hide',
							'options' => array(
								'show' => __( 'Show', 'bb-powerpack' ),
								'hide' => __( 'Hide', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'show' => array(
									'fields' => array( 'orientation_control_color' ),
								),
							),

						),
						'alignment'           => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Alignment', 'bb-powerpack' ),
							'default' => 'center',
							'options' => array(
								'left'   => __( 'Left', 'bb-powerpack' ),
								'center' => __( 'Center', 'bb-powerpack' ),
								'right'  => __( 'Right', 'bb-powerpack' ),
							),
							'preview' => array(
								'type'     => 'css',
								'selector' => '.pp-devices-wrapper',
								'property' => 'text-align',
							),
						),
						'max_width'           => array(
							'type'         => 'unit',
							'label'        => __( 'Maximum Width', 'bb-powerpack' ),
							'units'        => array( '%', 'px' ),
							'default_unit' => '%',
							'slider'       => true,
							'preview'      => array(
								'type'     => 'css',
								'property' => 'width',
								'selector' => '.pp-device-wrap',
							),
							'responsive'   => 'true',
						),
					),
				),
				'image'       => array(
					'title'  => 'Image',
					'fields' => array(
						'image'              => array(
							'type'        => 'photo',
							'label'       => __( 'Image', 'bb-powerpack' ),
							'show_remove' => true,
						),
						'image_fit'          => array(
							'type'    => 'select',
							'label'   => __( 'Fit Type', 'bb-powerpack' ),
							'default' => 'contain',
							'options' => array(
								'cover'   => __( 'Cover', 'bb-powerpack' ),
								'contain' => __( 'Default', 'bb-powerpack' ),
								'fill'    => __( 'Fill', 'bb-powerpack' ),
							),
						),
						'scrollable'         => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Scrollable', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'no' => array(
									'fields' => array( 'vertical_alignment' ),
								),
							),
						),
						'vertical_alignment' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Vertical Alignment', 'bb-powerpack' ),
							'default' => 'middle',
							'options' => array(
								'top'    => __( 'Top', 'bb-powerpack' ),
								'middle' => __( 'Middle', 'bb-powerpack' ),
								'bottom' => __( 'Bottom', 'bb-powerpack' ),
								'custom' => __( 'Custom', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'custom' => array(
									'fields' => array( 'top_offset' ),
								),
							),

						),
						'top_offset'         => array(
							'type'         => 'unit',
							'label'        => __( 'Top Offset', 'bb-powerpack' ),
							'default'      => '',
							'units'        => array( '%' ),
							'default_unit' => '%',
							'slider'       => true,
							'preview'      => array(
								'type'     => 'css',
								'selector' => '.pp-device-media-screen',
								'property' => 'top',
							),
						),
					),
				),
				'embed_video' => array(
					'title'  => 'Video',
					'fields' => array(
						'youtube_url'       => array(
							'type'        => 'text',
							'label'       => __( 'Link', 'bb-powerpack' ),
							'placeholder' => __( 'Enter YouTube URL', 'bb-powerpack' ),
							'default'     => 'https://www.youtube.com/watch?v=A7ZkZazfvao',
							'connections' => array( 'url' ),
						),
						'vimeo_url'         => array(
							'type'        => 'text',
							'label'       => __( 'Link', 'bb-powerpack' ),
							'placeholder' => __( 'Enter Viemo URL', 'bb-powerpack' ),
							'default'     => 'https://vimeo.com/103344490',
							'connections' => array( 'url' ),
						),
						'dailymotion_url'   => array(
							'type'        => 'text',
							'label'       => __( 'Link', 'bb-powerpack' ),
							'placeholder' => __( 'Enter Dailymotion URL', 'bb-powerpack' ),
							'default'     => '',
							'connections' => array( 'url' ),
						),
						'embed_cover_image' => array(
							'type'        => 'photo',
							'label'       => __( 'Overlay Image', 'bb-powerpack' ),
							'show_remove' => true,
						),
					),
				),
				'video'       => array(
					'title'  => 'Video',
					'fields' => array(
						'video_type'        => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Video Type', 'bb-powerpack' ),
							'default' => 'mp4',
							'options' => array(
								'mp4'  => __( 'MP4', 'bb-powerpack' ),
								'm4v'  => __( 'M4V', 'bb-powerpack' ),
								'ogg'  => __( 'OGG', 'bb-powerpack' ),
								'webm' => __( 'WEBM', 'bb-powerpack' ),
							),
						),
						'mp4_video_source'  => array(
							'type'    => 'select',
							'label'   => __( 'Video Field', 'bb-powerpack' ),
							'default' => 'url',
							'options' => array(
								'file' => __( 'File', 'bb-powerpack' ),
								'url'  => __( 'URL', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'url'  => array(
									'fields' => array( 'mp4_video_url' ),
								),
								'file' => array(
									'fields' => array( 'mp4_video' ),
								),
							),
						),
						'mp4_video_url'     => array(
							'type'  => 'text',
							'label' => __( 'URL', 'bb-powerpack' ),
						),
						'mp4_video'         => array(
							'type'  => 'video',
							'label' => __( 'Video Field', 'bb-powerpack' ),
						),
						'm4v_video_source'  => array(
							'type'    => 'select',
							'label'   => __( 'Video Field', 'bb-powerpack' ),
							'default' => 'url',
							'options' => array(
								'file' => __( 'File', 'bb-powerpack' ),
								'url'  => __( 'URL', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'url'  => array(
									'fields' => array( 'm4v_video_url' ),
								),
								'file' => array(
									'fields' => array( 'm4v_video' ),
								),
							),
						),
						'm4v_video_url'     => array(
							'type'  => 'text',
							'label' => __( 'URL', 'bb-powerpack' ),
						),
						'm4v_video'         => array(
							'type'  => 'video',
							'label' => __( 'Video Field', 'bb-powerpack' ),
						),
						'ogg_video_source'  => array(
							'type'    => 'select',
							'label'   => __( 'Video Field', 'bb-powerpack' ),
							'default' => 'url',
							'options' => array(
								'file' => __( 'File', 'bb-powerpack' ),
								'url'  => __( 'URL', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'url'  => array(
									'fields' => array( 'ogg_video_url' ),
								),
								'file' => array(
									'fields' => array( 'ogg_video' ),
								),
							),
						),
						'ogg_video_url'     => array(
							'type'  => 'text',
							'label' => __( 'URL', 'bb-powerpack' ),
						),
						'ogg_video'         => array(
							'type'  => 'video',
							'label' => __( 'Video Field', 'bb-powerpack' ),
						),
						'webm_video_source' => array(
							'type'    => 'select',
							'label'   => __( 'Video Field', 'bb-powerpack' ),
							'default' => 'url',
							'options' => array(
								'file' => __( 'File', 'bb-powerpack' ),
								'url'  => __( 'URL', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'url'  => array(
									'fields' => array( 'webm_video_url' ),
								),
								'file' => array(
									'fields' => array( 'webm_video' ),
								),
							),
						),
						'webm_video_url'    => array(
							'type'  => 'text',
							'label' => __( 'URL', 'bb-powerpack' ),
						),
						'webm_video'        => array(
							'type'  => 'video',
							'label' => __( 'Video Field', 'bb-powerpack' ),
						),
						'cover_image'       => array(
							'type'        => 'photo',
							'label'       => __( 'Cover Image', 'bb-powerpack' ),
							'show_remove' => true,
						),
					),
				),
				'behaviour'   => array(
					'title'  => 'Behaviour',
					'fields' => array(
						'auto_play'         => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Auto Play', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'mute'              => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Mute', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'loop'              => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Loop', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'controls'          => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Controls', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Show', 'bb-powerpack' ),
								'no'  => __( 'Hide', 'bb-powerpack' ),
							),
						),
						'showinfo'          => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Video Info', 'bb-powerpack' ),
							'default' => 'show',
							'options' => array(
								'show' => __( 'Show', 'bb-powerpack' ),
								'hide' => __( 'Hide', 'bb-powerpack' ),
							),
						),
						'start_time'        => array(
							'type'    => 'unit',
							'label'   => __( 'Start Time', 'bb-powerpack' ),
							'default' => '',
							'slider'  => true,
							'units'   => array( 'seconds' ),
							'help'    => __( 'Specify a start time (in seconds)', 'bb-powerpack' ),
						),
						'end_time'          => array(
							'type'    => 'unit',
							'label'   => __( 'End Time', 'bb-powerpack' ),
							'default' => '',
							'slider'  => true,
							'units'   => array( 'seconds' ),
							'help'    => __( 'Specify a end time (in seconds)', 'bb-powerpack' ),
						),
						'modestbranding'    => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Modest Branding', 'bb-powerpack' ),
							'help'    => __( 'This option lets you use a YouTube player that does not show a YouTube logo. Note that a small YouTube text label will still display in the upper-right corner of a paused video when the user\'s mouse pointer hovers over the player.', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'logo'              => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Logo', 'bb-powerpack' ),
							'default' => 'show',
							'options' => array(
								'show' => __( 'Show', 'bb-powerpack' ),
								'hide' => __( 'Hide', 'bb-powerpack' ),
							),
						),
						'yt_privacy'        => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Privacy Mode', 'bb-powerpack' ),
							'help'    => __( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'rel'               => array(
							'type'    => 'select',
							'label'   => __( 'Suggested Video', 'bb-powerpack' ),
							'options' => array(
								''    => __( 'Current Video Channel', 'bb-powerpack' ),
								'any' => __( 'Any Video', 'bb-powerpack' ),
							),
						),
						'vimeo_title'       => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Intro Title', 'bb-powerpack' ),
							'default' => 'show',
							'options' => array(
								'yes' => __( 'Show', 'bb-powerpack' ),
								'no'  => __( 'Hide', 'bb-powerpack' ),
							),
						),
						'vimeo_portrait'    => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Intro Portrait', 'bb-powerpack' ),
							'default' => 'show',
							'options' => array(
								'yes' => __( 'Show', 'bb-powerpack' ),
								'no'  => __( 'Hide', 'bb-powerpack' ),
							),
						),
						'vimeo_byline'      => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Intro Byline', 'bb-powerpack' ),
							'default' => 'show',
							'options' => array(
								'yes' => __( 'Show', 'bb-powerpack' ),
								'no'  => __( 'Hide', 'bb-powerpack' ),
							),
						), // till here for embedded url.
						'stop_others'       => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Stop Others', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'help'    => __( 'Stop all other videos on page when this video is played.', 'bb-powerpack' ),
						),
						'restart_on_pause'  => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Restart On Pause', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),

						'end_at_last_frame' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'End at last frame', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'help'    => __( 'End the video at the last frame instead of showing the first one.', 'bb-powerpack' ),
						),
						'playback_speed'    => array(
							'type'    => 'unit',
							'label'   => __( 'Playback Speed', 'bb-powerpack' ),
							'default' => '1',
							'slider'  => array(
								'min'  => 0.1,
								'max'  => 5,
								'step' => 0.01,
							),
						),
					),
				),
				'display'     => array(
					'title'  => 'Display',
					'fields' => array(
						'show_buttons'    => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Buttons', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'show_bar'        => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Bar', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'show_rewind'     => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Rewind', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'show_time'       => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Time', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'show_progress'   => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Progress', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'show_duration'   => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Duration', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'show_fullscreen' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Fullscreen', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
					),
				),
				'volume'      => array(
					'title'  => 'Volume',
					'fields' => array(
						'show_volume'      => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Volume', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'show_volume_icon' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Volume Icon', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'show_volume_bar'  => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Volume Bar', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
						),
						'initial_volume'   => array(
							'type'    => 'unit',
							'label'   => __( 'Initial Volume', 'bb-powerpack' ),
							'default' => '.8',
							'slider'  => array(
								'min'  => 0,
								'max'  => 1,
								'step' => 0.01,
							),
						),
					),
				),
			),
		),
		'style'   => array( // Tab.
			'title'    => __( 'Style', 'bb-powerpack' ), // Tab title.
			'sections' => array( // Tab Sections.
				'device'          => array( // Section.
					'title'  => __( 'Device', 'bb-powerpack' ), // Section Title.
					'fields' => array( // Section Fields.
						'override_style'            => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Override Style', 'bb-powerpack' ),
							'default' => 'no',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields' => array( 'device_color', 'device_bg_color', 'tone', 'opacity' ),
								),
								'no'  => array(
									'fields' => array( 'skin' ),
								),
							),
						),
						'skin'                      => array(
							'type'    => 'select',
							'label'   => __( 'Override Style', 'bb-powerpack' ),
							'default' => 'jet_black',
							'options' => array(
								'jet_black' => __( 'Jet black', 'bb-powerpack' ),
								'black'     => __( 'Black', 'bb-powerpack' ),
								'silver'    => __( 'Silver', 'bb-powerpack' ),
								'gold'      => __( 'Gold', 'bb-powerpack' ),
								'rose_gold' => __( 'Rose Gold', 'bb-powerpack' ),
							),
						),
						'device_color'              => array(
							'type'       => 'color',
							'label'      => __( 'Device Color', 'bb-powerpack' ),
							'default'    => '',
							'show_alpha' => true,
							'show_reset' => true,

						),
						'device_bg_color'           => array(
							'type'       => 'color',
							'label'      => __( 'Device Background Color', 'bb-powerpack' ),
							'default'    => '',
							'show_alpha' => true,
							'show_reset' => true,

						),
						'orientation_control_color' => array(
							'type'       => 'color',
							'label'      => __( 'Orientation Control Color', 'bb-powerpack' ),
							'default'    => '',
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'     => 'css',
								'property' => 'color',
								'selector' => '.pp-device-orientation .fa-mobile',
							),

						),
						'tone'                      => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Tone', 'bb-powerpack' ),
							'default' => 'light',
							'options' => array(
								'dark'  => __( 'Dark', 'bb-powerpack' ),
								'light' => __( 'Light', 'bb-powerpack' ),
							),
						),
						'opacity'                   => array(
							'type'    => 'unit',
							'label'   => __( 'Opacity', 'bb-powerpack' ),
							'slider'  => array(
								'min'  => 0.1,
								'max'  => 0.4,
								'step' => 0.01,
							),
							'preview' => array(
								'type'     => 'css',
								'property' => 'fill-opacity',
								'selector' => '.pp-device-shape svg .overlay-shape',
							),
						),
					),
				),
				'video_overlay'   => array( // Section.
					'title'  => __( 'Video Overlay', 'bb-powerpack' ), // Section Title.
					'fields' => array( // Section Fields.
						'overlay_background' => array(
							'type'       => 'color',
							'label'      => __( 'Overlay Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'     => 'css',
								'property' => 'background-color',
								'selector' => '.pp-video-player-cover.pp-player-cover:after',
							),
						),
						'overlay_opacity'    => array(
							'type'    => 'unit',
							'label'   => __( 'Opacity', 'bb-powerpack' ),
							'slider'  => array(
								'min'  => 0,
								'max'  => 1,
								'step' => 0.01,
							),
							'preview' => array(
								'type'     => 'css',
								'property' => 'opacity',
								'selector' => '.pp-video-player-cover.pp-player-cover',
							),
						),

					),
				),
				'video_interface' => array( // Section.
					'title'  => __( 'Video Interface', 'bb-powerpack' ), // Section Title.
					'fields' => array( // Section Fields.
						'controls_color'          => array(
							'type'       => 'color',
							'label'      => __( 'Controls Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'property' => 'color',
										'selector' => '.pp-video-button, .pp-player-controls-bar',
									),
									array(
										'property' => 'background',
										'selector' => '.pp-player-control-progress-inner, .pp-player-control-progress-outer',
									),
								),
							),
						),
						'controls_bg_color'       => array(
							'type'       => 'color',
							'label'      => __( 'Controls Background Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'property' => 'background',
										'selector' => '.pp-video-button, .pp-player-controls-bar',
									),
								),
							),
						),
						'controls_opacity'        => array(
							'type'    => 'unit',
							'label'   => __( 'Controls Opacity', 'bb-powerpack' ),
							'slider'  => array(
								'min'  => 0,
								'max'  => 1,
								'step' => 0.01,
							),
							'preview' => array(
								'type'     => 'css',
								'property' => 'opacity',
								'selector' => '.pp-player-controls-bar, .pp-video-button',
							),
						),
						'hover_controls_color'    => array(
							'type'       => 'color',
							'label'      => __( 'Hover Controls Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'property' => 'color',
										'selector' => '.pp-video-button:hover, .pp-player-controls-bar:hover',
									),
									array(
										'property' => 'background',
										'selector' => '.pp-player-control-progress-inner:hover, .pp-player-control-progress-outer:hover',
									),
								),
							),
						),
						'hover_controls_bg_color' => array(
							'type'       => 'color',
							'label'      => __( 'Hover Controls Background Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'property' => 'background',
										'selector' => '.pp-video-button:hover, .pp-player-controls-bar:hover',
									),
								),
							),
						),
						'hover_controls_opacity'  => array(
							'type'    => 'unit',
							'label'   => __( 'Hover Controls Opacity', 'bb-powerpack' ),
							'slider'  => array(
								'min'  => 0,
								'max'  => 1,
								'step' => 0.01,
							),
							'preview' => array(
								'type'     => 'css',
								'property' => 'opacity',
								'selector' => '.pp-player-controls-bar:hover, .pp-video-button:hover',
							),
						),
						'bar_border_radius'       => array(
							'type'    => 'unit',
							'label'   => __( 'Progress Bar Border Radius', 'bb-powerpack' ),
							'slider'  => true,
							'preview' => array(
								'type'     => 'css',
								'property' => 'border-radius',
								'selector' => '.pp-player-controls-bar .pp-player-control-progress-outer, .pp-player-controls-bar .pp-player-control-progress-inner',
								'unit'     => 'px',
							),
						),

					),
				),
				'video_buttons'   => array( // Section.
					'title'       => __( 'Video Buttons', 'bb-powerpack' ), // Section Title.
					'description' => __( 'Select Overlay image for Youtube, Vimeo, DailyMotion', 'bb-powerpack' ),
					'fields'      => array( // Section Fields.
						'button_size'                    => array(
							'type'       => 'unit',
							'label'      => __( 'Size', 'bb-powerpack' ),
							'slider'     => array(
								'min'  => 20,
								'max'  => 50,
								'step' => 1,
							),
							'responsive' => true,
						),
						'button_controls_color'          => array(
							'type'       => 'color',
							'label'      => __( 'Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'property' => 'color',
										'selector' => '.pp-video-button',
									),
								),
							),
						),
						'button_controls_bg_color'       => array(
							'type'       => 'color',
							'label'      => __( 'Background Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'property' => 'background',
										'selector' => '.pp-video-button',
									),
								),
							),
						),
						'hover_button_controls_color'    => array(
							'type'       => 'color',
							'label'      => __( 'Hover Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
						),
						'hover_button_controls_bg_color' => array(
							'type'       => 'color',
							'label'      => __( 'Hover Background Color', 'bb-powerpack' ),
							'show_alpha' => true,
							'show_reset' => true,
						),
						'button_border'                  => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-video-button',
							),
						),
						'hover_button_border'            => array(
							'type'       => 'border',
							'label'      => __( 'Hover Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-video-button:hover',
							),
						),
						'button_spacing'                 => array(
							'type'       => 'unit',
							'label'      => __( 'Spacing', 'bb-powerpack' ),
							'default'    => 3,
							'slider'     => array(
								'min'  => 0,
								'max'  => 50,
								'step' => 1,
							),
							'responsive' => true,
							'preview'    => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'property' => 'margin-left',
										'selector' => '.pp-video-button',
										'unit'     => 'px',
									),
									array(
										'property' => 'margin-right',
										'selector' => '.pp-video-button',
										'unit'     => 'px',
									),
								),
							),
						),
						'button_padding'                 => array(
							'type'        => 'dimension',
							'label'       => __( 'Padding', 'bb-powerpack' ),
							'description' => 'em',
							'default'     => 1,
							'unit'        => 'em',
							'slider'      => array(
								'min'  => 0,
								'max'  => 3,
								'step' => .1,
							),
							'preview'     => array(
								'type'  => 'css',
								'rules' => array(
									array(
										'property' => 'padding',
										'selector' => '.pp-video-button',
										'unit'     => 'em',
									),
								),
							),
							'responsive'  => true,
						),
					),
				),
			),
		),

	)
);
